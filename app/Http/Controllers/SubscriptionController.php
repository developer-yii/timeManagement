<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use Auth;

class SubscriptionController extends Controller
{
    public function create(Request $request, Plan $plan)
    {
        $plan = Plan::findOrFail($request->get('plan'));        

        if($request->user()->subscribed($plan->name)) {
            return redirect()->route('home')->with('success', 'You have already subscribed the plan');
        }

        $request->user()
            ->newSubscription($plan->name, $plan->stripe_plan)
            ->create($request->paymentMethod);

        $user = Auth::user();
        $user->is_sub_cancel = 0;
        $user->save();
        
        return redirect()->route('home')->with('success', 'Your plan subscribed successfully');
    }

    public function cancel()
    {
        $user = Auth::user();
        $subscriptions = $user->subscriptions()->active()->get();

        $r = $subscriptions->map(function($subscription) {
            $subscription->cancel(); // cancelling each of the active subscription
        });

        if($r)
            $user->is_sub_cancel = 1;
            $user->save();

            $result = ['status' => true, 'message' => 'Subscription cancel successfully'];
        else
            $result = ['status' => false, 'message' => 'Subscription cancel failed'];

        return response()->json($result);
    }
}
