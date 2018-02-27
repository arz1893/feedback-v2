<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\UserRequest;
use App\Invite;
use App\User;
use App\UserGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Webpatser\Uuid\Uuid;

class UserController extends Controller
{
    public function index() {
        $users = User::where('tenantId', Auth::user()->tenantId)->orderBy('created_at', 'asc')->get();
        return view('user.user_index', compact('users'));
    }

    public function create() {
        $userGroups = UserGroup::orderBy('name', 'asc')->pluck('name', 'systemId');
        return view('user.user_add', compact('userGroups'));
    }

    public function store(UserRequest $request) {
        dd($request->all());

        User::create([
            'systemId' => Uuid::generate(4),
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt(str_random(6)),
            'phone' => $request->phone,
            'usergroupId' => $request->usergroupId,
            'tenantId' => Auth::user()->tenantId
        ]);


//        return redirect()->back()->with('status', 'Your invitation has been sent');
    }

    public function sendInvitation(Request $request)
    {

        $token = str_random(16);

        Invite::create([
            'systemId' => Uuid::generate(4),
            'name' => $request->name,
            'email' => $request->email,
            'token' => $token,
            'tenantId' => Auth::user()->tenantId,
            'userId' => Auth::user()->systemId,
            'usergroupId' => $request->usergroupId
        ]);

        Mail::send('user.invitation.email_template', ['adminName' => Auth::user()->name, 'token' => $token, 'recipient' => $request->email], function ($message) {
            $message->from(Auth::user()->email, Auth::user()->name);

            $message->to('anyone@sample.com');

            $message->subject('Company Invitation');

        });

        return redirect()->back()->with(['status' => 'Your invitation has been sent']);
    }
}
