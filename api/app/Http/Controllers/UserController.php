<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\GetUserByEventRequest;
use App\Http\Requests\GetUserStatisticRequest;
use App\Http\Requests\UpdateUserFormRequest;
use App\Models\Event;
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

    public function showUserStatistic(GetUserStatisticRequest $request) {
        $userEmail = $request->only(['email']);
        $user = User::where('email', $userEmail)->where('role', 'user')->first();
        $data['user'] = $user;

        $eventList = Event::all();
        $events = [];
        foreach($eventList as $event) {
            $events[$event->name] = RegisterForm::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->get();
        }

        $data['events'] = $events;

        return response()->json([
            'data' => $data
        ]);
    }

    public function updateUserForm(UpdateUserFormRequest $request) {
        $formID = $request->only(['form_id']);
        $putData = $request->only(['event_id', 'first_name', 'last_name', 'hobbies']);
        RegisterForm::where('id', $formID)
        ->update($putData);

        return response()->json([
            'messages' => 'Update register form successful.'
        ]);
    }
}
