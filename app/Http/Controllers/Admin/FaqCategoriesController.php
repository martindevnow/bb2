<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Martin\Core\Faq;
use Martin\Core\FaqCategory;

class FaqCategoriesController extends Controller
{
    /**
     * Display all FaqCategories
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $faq_categories = FaqCategory::with('faqs')->get();


        return view('admin.faq_categories.index')
            ->with(compact('faq_categories'));
    }

    /**
     * Show one Faq
     *
     * @param FaqCategory $faq_category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(FaqCategory $faq_category) {
        return view('admin.faq_categories.show')
            ->with(compact('faq_category'));
    }

    /**
     * Show form to create a new FaqCategory
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        return view('admin.faq_categories.create');
    }

    /**
     * Store the details submitted for creating a new FaqCategory
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request) {
        $this->validate($request, [
            'code'          => 'required|unique:faq_categories',
            'label'         => 'required',
        ]);

        $faq_category = FaqCategory::create($request->only(['label', 'code']));

        flash('The faq category ' . $faq_category->label . ' was saved.')->success();

        return redirect('/admin/faq_categories');
    }

    /**
     * Show the form to edit a specific FaqCategory
     *
     * @param FaqCategory $faq_category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(FaqCategory $faq_category) {
        return view('admin.faq_categories.edit')
            ->with(compact('faq_category'));

    }

    /**
     * Update the parameters of a specific FaqCategory
     *
     * @param FaqCategory $faq_category
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(FaqCategory $faq_category, Request $request) {
        $this->validate($request, [
            'code'          => 'required',
            'label'         => 'required',
        ]);

        $faq_category->fill($request->only(['code', 'label']));
        $faq_category->save();

        flash('The faq category ' . $faq_category->label . ' was updated.')->success();

        return redirect('/admin/faq_categories');
    }

    /**
     * Delete an existing FaqCategory
     *
     * @param FaqCategory $faq_category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(FaqCategory $faq_category) {
        $faq_category->delete();

        flash('The faq category: ' . $faq_category->label . ' has been deleted.')->success();

        return redirect()->back();
    }
}

