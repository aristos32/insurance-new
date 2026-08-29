<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SystemUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        if (! $user || ! Hash::check($credentials['password'], (string) $user->getAuthPassword())) {
            if ($user) {
                $user->consecutiveFailLoginAttempts = (int) $user->consecutiveFailLoginAttempts + 1;
                if ($user->consecutiveFailLoginAttempts >= 3) {
                    $user->status = 'SUSPENDED';
                }
                $user->save();
            }

            return back()->withErrors(['username' => 'Invalid credentials.'])->onlyInput('username');
        }

        // Upgrade MD5 hashes to bcrypt on the next successful login
        if (Hash::needsRehash((string) $user->getAuthPassword())) {
            $user->password = Hash::make($credentials['password']);
        }

        if (! $user->isOfficeUser()) {
            $user->save();

            return back()->withErrors(['username' => 'Office access requires an employee role or higher.']);
        }

        Auth::login($user);
        $request->session()->regenerate();

        $user->consecutiveFailLoginAttempts = 0;
        $user->save();

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
