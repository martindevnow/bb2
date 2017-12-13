<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanBuilderForm;
use Exception;
use Stripe\{Charge, Customer};

class PlansController extends Controller
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
        return view('plans.index');
    }


    public function subscribe(PlanBuilderForm $form) {

        try {
            $form->save();

        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }
}
