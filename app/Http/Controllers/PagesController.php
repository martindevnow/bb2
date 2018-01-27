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
        $instagram = new Instagram('4221042410.1677ed0.dd2ba4b789f94bedbc1579de08ecab29');
        $pics = $instagram->get();

        return view('pages.about')->with(compact('pics'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function shipping() {
        return view('pages.shipping');
    }
}
