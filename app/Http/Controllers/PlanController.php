<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use Auth;
use Carbon\Carbon;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();

        return view('plans.index', compact('plans'));
    }

    public function show(Plan $plan, Request $request)
    {
        if($request->user()->subscribed($plan->name)) {
            return redirect()->route('home')->with('success', 'You have already subscribed the plan');
        }

        $user = Auth::user();

        $intent = $user->createSetupIntent();

        return view('plans.show', compact('plan','intent'));
    }
}
