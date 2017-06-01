<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function __construct() {
    }

    public function index() {
        return view('pages.landing');
    }

    public function about() {
        return view('pages.about');
    }
}
