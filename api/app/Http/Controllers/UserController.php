<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\GetUserByEventRequest;
use App\Models\RegisterForm;
use App\Models\User;

class UserController extends Controller
{
    public function showUserByEvent(GetUserByEventRequest $request) {
        $eventID = $request->route("event_id");

        $data = User::join("register_forms", "users.id", "=", "register_forms.user_id")
                ->where("register_forms.event_id", $eventID)
                ->paginate(10);

        return response()->json([
            'data' => $data
        ]);
    }

    public function deleteUser(DeleteUserRequest $request) {
        $userID = $request->only(['id']);
        // only delete Users with role 'user'
        $user = User::where('id', $userID)->where('role', 'user')->first();
        if (!$user) {
            return response()->json([
                'errors' => 'Cannot delete user.'
            ], 422);
        }
        RegisterForm::where('user_id', $userID)->delete();
        $user->delete();

        return response()->json([
            'messages' => 'Delete user record successful.'
        ]);
    }
}
