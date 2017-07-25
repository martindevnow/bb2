<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Martin\Core\FaqCategory;

class FaqController extends Controller
{
    public function __construct() {}

    /**
     * Show all the FAQs by categories
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $categories = FaqCategory::with('faqs')->get();
        return view('faq.index')
            ->with(compact('categories'));
    }

}
