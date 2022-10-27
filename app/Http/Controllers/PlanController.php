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
        $user = Auth::user();

        $plans = Plan::all()->sortByDesc('created_at')->unique('name')->reverse();
        
        if($user->trial_ends_at || $user->is_sub_cancel)
        {
            // foreach($plans as $key => $plan)
            // {
            //     if($plan->slug == 'trial')
            //     {
            //         $plans->forget($key);
            //     }
            // }
            $plans = Plan::where('name','Basic')->latest()->limit(1)->get();
        }       

        return view('plans.index', compact('plans'));
    }

    public function show(Plan $plan, Request $request)
    {
        if($request->user()->subscribed($plan->name)) {
            // return redirect()->route('home')->with('success', 'You have already subscribed the plan');
            return redirect()->route('student-time-log')->with('success', 'You have already subscribed the plan');
        }

        $user = Auth::user();

        if($plan->slug == 'trial')
        {
            $user->trial_ends_at = now()->addDays(14);
            $user->save();

            // return redirect()->route('home')->with('success', 'You are now on 14 days trial period');
            return redirect()->route('student-time-log')->with('success', 'You are now on 14 days trial period');
        }        

        $intent = $user->createSetupIntent();

        return view('plans.show', compact('plan','intent'));
    }
}
