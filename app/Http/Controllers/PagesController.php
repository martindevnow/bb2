<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vinkla\Instagram\Instagram;

class PagesController extends Controller
{
    public function __construct() {}

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('pages.landing');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about() {
        $instagram = new Instagram();
        $pics = $instagram->get('b.a.r.f.bento');

        return view('pages.about')->with(compact('pics'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function shipping() {
        return view('pages.shipping');
    }
}
