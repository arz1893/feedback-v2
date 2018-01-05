<?php

namespace App\Http\Controllers\User;

use App\User;
use App\UserGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index() {
        $users = User::where('tenantId', Auth::user()->tenantId)->get();
        return view('user.user_index', compact('users'));
    }

    public function create() {
        $userGroups = UserGroup::where('recOwner', Auth::user()->tenantId)->orderBy('name', 'asc')->pluck('name', 'systemId');
        return view('user.user_add', compact('userGroups'));
    }

    public function store(Request $request) {
        dd($request->all());
    }
}
