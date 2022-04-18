<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\RegisterForm;
use App\Models\User;

class RegisterController extends Controller
{
    public function storeRegister(RegisterRequest $request) {
        $postData = $request->only(['event_id', 'email', 'first_name', 'last_name', 'hobbies']);

        // check if email is exist in Users
        $user = User::where('email',$postData['email'])->first();
        if (!$user) {
            // if not create new User with email
            $user = User::create([
                'email' => $postData['email'],
                'role' => 'user'
            ]);
        }

        // register new form with EventID
        RegisterForm::create([
            'event_id' => $postData['event_id'],
            'user_id' => $user->id,
            'first_name' => $postData['first_name'],
            'last_name' => $postData['last_name'],
            'hobbies' => $postData['hobbies']
        ]);

        return response()->json([
            'messages' => 'Register event successful.'
        ]);
    }
}
