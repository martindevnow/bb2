<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Martin\Core\Faq;
use Martin\Core\FaqCategory;

class FaqsController extends Controller
{
    /**
     * Display all Faqs
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $faq_categories = FaqCategory::with('faqs')->get();
        $uncategorized_faqs = Faq::with('category')
            ->where('faq_category_id', null)->get();

        return view('admin.faqs.index')
            ->with(compact('uncategorized_faqs', 'faq_categories'));
    }

    /**
     * Show one Faq
     *
     * @param Faq $faq
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Faq $faq) {
        return view('admin.faqs.show')
            ->with(compact('faq'));
    }

    /**
     * Show form to create a new Faq
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        $categories = FaqCategory::all();
        return view('admin.faqs.create')->with(compact('categories'));
    }

    /**
     * Store the details submitted for creating a new Faq
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request) {
        $this->validate($request, [
            'code'          => 'required|unique:faqs',
            'question'      => 'required',
            'answer'        => 'required',
            'faq_category_id'   => 'required|exists:faq_categories,id',
        ]);

        $faq = Faq::create($request->only(['code', 'question', 'answer', 'faq_category_id']));

        flash('The faq ' . $faq->label . ' was saved.')->success();

        return redirect('/admin/faqs');
    }

    /**
     * Show the form to edit a specific Faq
     *
     * @param Faq $faq
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Faq $faq) {
        $categories = FaqCategory::all();
        return view('admin.faqs.edit')
            ->with(compact('faq', 'categories'));

    }

    /**
     * Update the parameters of a specific Faq
     *
     * @param Faq $faq
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Faq $faq, Request $request) {
        $this->validate($request, [
            'code'          => 'required',
            'question'      => 'required',
            'answer'        => 'required',
            'faq_category_id'   => 'required|exists:faq_categories,id',
        ]);

        $faq->fill($request->only(['code', 'question', 'answer', 'faq_category_id']));
        $faq->save();

        flash('The faq ' . $faq->label . ' was updated.')->success();

        return redirect('/admin/faqs');
    }

    /**
     * Delete an existing Faq
     *
     * @param Faq $faq
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Faq $faq) {
        $faq->delete();

        flash('The faq: ' . $faq->label . ' has been deleted.')->success();

        return redirect()->back();
    }
}

