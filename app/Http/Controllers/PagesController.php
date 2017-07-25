<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vinkla\Instagram\Instagram;

class PagesController extends Controller
{
    public function __construct() {
    }

    public function index() {
        return view('pages.landing');
    }

    public function about() {

        $instagram = new Instagram();
        $pics = $instagram->get('b.a.r.f.bento');

        return view('pages.about')->with(compact('pics'));
    }
}
