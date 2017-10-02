<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Martin\ACL\User;

class UsersController extends Controller {

    public function index() {
        return User::with(['pets'])->get();
    }

    /**
     * Add a new User. Their owner must exist
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request) {
        $post = $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email',
            'first_name'    => '',
            'last_name'     => '',
            'phone_number'  => '',
            'password'      => 'required',
        ]);

        $post['password'] = bcrypt($post['password']);

        $user = User::create($post);

        return $user;
    }
}