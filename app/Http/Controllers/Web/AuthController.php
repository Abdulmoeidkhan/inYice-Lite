<?php

namespace App\Http\Controllers\Web;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\{
    Auth,
    Hash,
    Password
};

class AuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $socialUser = Socialite::driver('google')->user();
            // $socialUser = Socialite::driver('google')->user();

            // Check if user already exists
            $user = User::where('google_id', $socialUser->id)->first();

            if ($user) {
                Auth::login($user);
                $request->session()->regenerate();
                return redirect()->intended('/dashboard')->with('success', 'Logged in successfully using Google.');
            }

            // If new user
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail() ?? 'noemail_' . $socialUser->id . '@example.com',
                'google_id' => $socialUser->getId(),
                'image'      => $socialUser->getAvatar(),
                'status'   => 1,
                'password' => Hash::make(rand(100000, 999999)),
            ]);

            $user->assignRole('user');

            Auth::login($user);
            $request->session()->regenerate();
            if ($user->hasRole('developer')) {
                return redirect()->route('pages.dashboard')->with('success', 'Account created and logged in using Google.');
            }
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('pages.login')->with('error', 'Google login failed. Please try again.');
        }
    }

    // Show Registration Form
    public function showRegister()
    {
        return view('pages.register');
    }

    // Handle Registration
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors());
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            // Assign default role
            $user->assignRole('user');

            Auth::login($user);

            return redirect()->route('pages.dashboard')->with('success', 'User register successfully.!');
        } catch (\Exception $e) {
            return back()->with('error',  $e->getMessage());
        }
    }


    // Show Login Form
    public function showLogin()
    {
        return view('pages.login');
    }


    // Handle Login
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            // return $validator->fails();
            // return $validator->errors();
            return back()->withErrors($validator->errors());
        }

        // return $request->all();
        try {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return back()->withErrors(['email'=> 'Email not found in record.']);
            }

            if (!Hash::check($request->password, $user->password)) {
                return back()->withErrors(['password'=> 'Incorrect Password.']);
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $request->session()->regenerate();
                return redirect()->intended(route('pages.dashboard'))->with('success', 'User login successfully.');
            }
        } catch (\Exception $e) {
            return back()->with('error',  $e->getMessage());
        }
    }

    // Logout User
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('pages.login')->with('success', 'You have been logged out.');
    }

    // Show Forgot Password Form
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    // Send Reset Link Email
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->with(['email' => __($status)]);
    }

    // Show Reset Password Form
    public function showResetForm(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // Handle Password Reset
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill(['password' => Hash::make($password)])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Password has been reset.')
            : back()->with(['email' => [__($status)]]);
    }
}
