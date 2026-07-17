<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\SystemUser;
use App\Services\HistoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(private HistoryService $history) {}

    public function index(Request $request): View
    {
        $users = SystemUser::query()
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = '%'.$request->string('q').'%';
                $q->where(function ($inner) use ($term) {
                    $inner->where('username', 'like', $term)
                        ->orWhere('firstName', 'like', $term)
                        ->orWhere('lastName', 'like', $term)
                        ->orWhere('email', 'like', $term);
                });
            })
            ->orderBy('username')
            ->paginate(25)
            ->withQueryString();

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        return view('users.form', [
            'user' => new SystemUser(['role' => UserRole::Employee->value, 'status' => 'ACTIVE', 'productType' => 'OFFICE']),
            'roles' => UserRole::cases(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        SystemUser::create($data);
        $this->history->log('USER', 'CREATE', 'username', $data['username'], 'Created user');

        return redirect()->route('users.index')->with('success', 'User created.');
    }

    public function edit(SystemUser $user): View
    {
        return view('users.form', [
            'user' => $user,
            'roles' => UserRole::cases(),
        ]);
    }

    public function update(Request $request, SystemUser $user): RedirectResponse
    {
        $data = $this->validated($request, $user);
        if (empty($data['password'])) {
            unset($data['password']);
        }
        $user->update($data);
        $this->history->log('USER', 'UPDATE', 'username', $user->username, 'Updated user');

        return redirect()->route('users.index')->with('success', 'User updated.');
    }

    public function destroy(SystemUser $user): RedirectResponse
    {
        if ($user->username === auth()->user()->username) {
            return back()->withErrors(['username' => 'You cannot delete your own account.']);
        }

        $username = $user->username;
        $user->delete();
        $this->history->log('USER', 'DELETE', 'username', $username, 'Deleted user');

        return redirect()->route('users.index')->with('success', 'User deleted.');
    }

    private function validated(Request $request, ?SystemUser $user = null): array
    {
        return $request->validate([
            'username' => [
                $user ? 'sometimes' : 'required',
                'string',
                'max:40',
                Rule::unique('systemuser', 'username')->ignore($user?->username, 'username'),
            ],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:6'],
            'role' => ['required', Rule::enum(UserRole::class)],
            'status' => ['required', Rule::in(['ACTIVE', 'SUSPENDED'])],
            'productType' => ['nullable', 'string', 'max:20'],
            'subProductType' => ['nullable', 'string', 'max:20'],
            'clientName' => ['nullable', 'string', 'max:40'],
            'stateId' => ['nullable', 'string', 'max:20'],
            'title' => ['nullable', 'string', 'max:10'],
            'producer' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', 'string', 'max:10'],
            'firstName' => ['nullable', 'string', 'max:70'],
            'lastName' => ['nullable', 'string', 'max:70'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'cellphone' => ['nullable', 'string', 'max:20'],
            'profession' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:50'],
        ]);
    }
}
