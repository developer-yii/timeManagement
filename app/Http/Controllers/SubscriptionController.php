<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use Validator;
use Auth;
use Carbon\Carbon;
use App\Mail\StripeLink;
use App\Models\Promocode;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.user')->only(['addPriceShow']);;
    }

    public function create(Request $request, Plan $plan)
    {
        $plan = Plan::findOrFail($request->get('plan'));        

        if($request->user()->subscribed($plan->name)) {
            // return redirect()->route('home')->with('success', 'You have already subscribed the plan');
            return redirect()->route('student-time-log')->with('success', 'You have already subscribed the plan');
        }

        $request->user()
            ->newSubscription($plan->name, $plan->stripe_plan)
            ->create($request->paymentMethod);

        $user = Auth::user();
        $user->is_sub_cancel = 0;
        if($user->onTrial())
        {
            $user->trial_ends_at = now();
        }
        $user->promocode_id = null;
        $user->save();

        // Email user a stripe link
        $to_email = $user->email;
        $data = [
            'username' => $user->name,
            'loginRoute' => route('login'),
        ];
        Mail::to($to_email)->send(new StripeLink($data));
        
        // return redirect()->route('home')->with('success', 'Your plan subscribed successfully');
        return redirect()->route('student-time-log')->with('success', 'Your plan subscribed successfully');
    }

    public function cancel()
    {
        $user = Auth::user();
        $subscriptions = $user->subscriptions()->active()->get();

        $r = $subscriptions->map(function($subscription) {
            $subscription->cancel(); // cancelling each of the active subscription
        });

        if($r)
        {
            $user->is_sub_cancel = 1;
            $user->save();
            $result = ['status' => true, 'message' => 'Subscription cancel successfully'];
        }
        else
        {
            $result = ['status' => false, 'message' => 'Subscription cancel failed'];
        }

        return response()->json($result);
    }

    public function addPriceShow()
    {
        $plan = Plan::where('name','Basic')->latest()->first();

        return view('plans.price',compact('plan'));
    }

    public function addPrice(Request $request)
    {
        if($request->ajax()) {

            $rules = array(
                'price'=>'required|numeric',                
            );

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()){
                $result = ['status' => false, 'message' => $validator->errors(), 'data' => []];
                return response()->json($result);
            }
            else
            {
                $price = $request->price*100;

                $stpSecret = env('STRIPE_SECRET');

                try{

                    $stripe = new \Stripe\StripeClient($stpSecret);

                    $product = $stripe->products->all(['limit' => 1]);
                    
                    $product_key = $product->data['0']->id;
                    

                } catch (\Exception $e){
                    $result = ['status' => false, 'Error' => true, 'message' => $e->getMessage(), 'data' => []];
                    return response()->json($result);
                }

                try{
                    $stripe = new \Stripe\StripeClient($stpSecret);

                    $response = $stripe->prices->create([
                        'product' => $product_key,
                        'unit_amount' => $price,
                        'currency' => 'usd',
                        'recurring' => ['interval' => 'month'],
                    ]);                    

                    $prevPlan = Plan::where('cost','>',0)->latest()->first();

                    if($prevPlan)
                    {                        
                        $plan = new Plan;
                        $plan->name = $prevPlan->name;
                        $plan->slug = $prevPlan->name.time();
                        $plan->stripe_plan = $response->id;
                        $plan->cost = $request->price;
                        $plan->description = $prevPlan->description;
                        $plan->save();

                        $result = ['status' => true, 'message' => 'Price updated successfully', 'data' => []];
                        return response()->json($result);
                    }
                    else
                    {
                        $result = ['status' => false, 'Error' => true, 'message' => 'Error in creating New Price', 'data' => []];
                        return response()->json($result);    
                    }
                }
                catch (\Exception $e){                                  
                    $result = ['status' => false, 'Error' => true, 'message' => $e->getMessage(), 'data' => []];
                    return response()->json($result);
                }
            }            
        }
    }

    public function freeCodePlan(Request $request)
    {
        if($request->ajax()) {
            $rules = array(                             
                'freecode'=>'required|exists:promocodes,promocode|size:21|regex:/^[a-zA-Z0-9-]{5}[a-zA-Z0-9{5}-]{6}[a-zA-Z0-9{4}-]{5}[a-zA-Z0-9-]{5}$/', 
            );

            $messages = [
                'freecode.required' => 'Please Enter Promo Code!',
                'freecode.exists' => 'Invalid Promo Code!',
                'freecode.size' => 'Invalid Promo Code!',
                'freecode.regex' => 'Invalid Promo Code!',                
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if($validator->fails()){
                $result = ['status' => false, 'message' => $validator->errors(), 'data' => []];
                return response()->json($result);
            }
            else
            {
                $promo = Promocode::where('promocode',$request->freecode)->first();
                if($promo)
                {
                    $user = User::where('promocode_id',$promo->id)->first();
                    if($user)
                    {
                        $validator->getMessageBag()->add('freecode', 'Promo Code already used');
                        $result = ['status' => false, 'message' => $validator->errors(), 'data' => []];
                        return response()->json($result);
                    }

                    $loginUser = Auth::user();
                    $loginUser->promocode_id = $promo->id;
                    $loginUser->save();

                    session(['success' => 'Your Promo Code Applied successfully, You can now use application free of cost']);

                    $result = ['status' => true, 'message' => 'Promo Code applied successfully', 'data' => []];
                    return response()->json($result);                    
                }
            }
        }        
    }
}
