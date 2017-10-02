<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Martin\ACL\User;

class UsersController extends Controller {

    /**
     * Fetch a list of Users
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[] |Illuminate\Database\Eloquent\Collection
     */
    public function index() {
        return User::with(['pets'])->get();
    }

    /**
     * Add a new User
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