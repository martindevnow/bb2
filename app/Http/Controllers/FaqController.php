<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function __construct() {}

    public function index() {
        return view('faq.index');
    }

}
