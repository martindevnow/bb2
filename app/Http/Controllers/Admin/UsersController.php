<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Martin\ACL\User;

class UsersController extends Controller
{
    /**
     * Display all Users
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $users = User::with('pets')->get();

        return view('admin.users.index')
            ->with(compact('users'));
    }

    /**
     * Show one User
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user) {
        return view('admin.users.show')
            ->with(compact('user'));
    }

    /**
     * Show form to create a new User
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        return view('admin.users.create');
    }

    /**
     * Store the details submitted for creating a new User
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request) {
        $this->validate($request, [
            'name'          => 'required',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required',
        ]);

        $user = User::create($request->only(['name', 'email', 'password']));

        flash('The user ' . $user->name . ' was saved.')->success();

        return redirect('/admin/users');
    }

    /**
     * Show the form to edit a specific User
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user) {
        return view('admin.users.edit')
            ->with(compact('user'));

    }

    /**
     * Update the parameters of a specific User
     *
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(User $user, Request $request) {
        $this->validate($request, [
            'name'          => 'required',
            'email'         => 'required|email',
            'password'      => '',
        ]);

        $userData = $request->only(['name', 'email', 'password']);

        if ($request->get('password') == '')
            unset($userData['password']);

        $user->fill($userData);
        $user->save();

        flash('The user ' . $user->name . ' was updated.')->success();

        return redirect('/admin/users');
    }

    /**
     * Delete an existing User
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user) {
        $user->delete();

        flash('The user: ' . $user->name . ' has been deleted.')->success();

        return redirect()->back();
    }
}

