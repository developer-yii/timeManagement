<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Models\Promocode;

class SubscriptionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if($user->user_type != 1)
        {
            if($user->promocode_id)
            {
                $promo = Promocode::find($user->promocode_id);
                
                if($promo)
                {
                    return $next($request);   
                }
                else
                {
                    return redirect()->route('plans.index')->with('subMessage','Subscribe plan to access site');
                }
            }
            else if($user->onTrial())
            {
                return $next($request);
            }
            else if(isSubscriptionActive())
            {
                return $next($request);
            }
            else{
                return redirect()->route('plans.index')->with('subMessage','Subscribe plan to access site');
            }
        }
        else
        {
            return $next($request);
        }
    }
}
