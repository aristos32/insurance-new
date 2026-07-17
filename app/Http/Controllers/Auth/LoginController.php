<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SystemUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function show(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        /** @var SystemUser|null $user */
        $user = SystemUser::query()->where('username', $credentials['username'])->first();

        if ($user && ! $user->isActive()) {
            return back()->withErrors(['username' => 'This account is suspended.'])->onlyInput('username');
        }

        if (! Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            if ($user) {
                $user->consecutiveFailLoginAttempts = (int) $user->consecutiveFailLoginAttempts + 1;
                if ($user->consecutiveFailLoginAttempts >= 3) {
                    $user->status = 'SUSPENDED';
                }
                $user->save();
            }

            return back()->withErrors(['username' => 'Invalid credentials.'])->onlyInput('username');
        }

        $request->session()->regenerate();

        /** @var SystemUser $authUser */
        $authUser = Auth::user();
        $authUser->consecutiveFailLoginAttempts = 0;
        $authUser->save();

        if (! $authUser->isOfficeUser()) {
            Auth::logout();

            return back()->withErrors(['username' => 'Office access requires an employee role or higher.']);
        }

        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
