<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use App\Helpers\EmailHelper;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle the user registration process.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        } else {
            $profilePicturePath = null;
        }

        // Generate a unique confirmation token
        $confirmationToken = Str::uuid();

        // Create a new user using the UserRepository
        $user = $this->userRepository->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->password),
            'profile_picture' => $profilePicturePath,
            'confirmation_token' => $confirmationToken,
        ]);

        // Send confirmation email
        EmailHelper::sendConfirmationEmail($user);

        // Redirect after registration
        return redirect()->route('register')->with('success', 'Registration successful!');
    }

    /**
     * Confirm the user's email.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function confirmEmail($token)
    {
        // Find the user with the given confirmation token
        $user = User::where('confirmation_token', $token)->first();

        // Check if the user exists
        if (!$user) {
            return view('confirmation-messages', ['message' => 'Invalid token.']);
        }

        // update the confirmation_token to null
        $user->update(['confirmation_token' => null]);

        // Perform any additional actions (e.g., login the user, show a success message)

        return view('confirmation-messages', ['message' => 'Email confirmed successfully.']);
    }
}
