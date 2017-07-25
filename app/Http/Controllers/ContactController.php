<?php

namespace App\Http\Controllers;

use App\Mail\ContactReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct() {}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('contact.index');
    }

    /**
     * Return a redirect to the success page
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function send(Request $request) {
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|email',
            'subject'   => 'required',
            'body'      => 'required',
        ]);

        Mail::to('info@barfbento.com')
            ->cc('benm@barfbento.com')
            ->send(new ContactReceived($request->only(['name', 'email', 'subject', 'body'])));

        flash('Your message has been sent.');

        return redirect('/contact/success');
    }

    /**
     * Return the success view for contact page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function success() {
        return view('contact.success');
    }

}
