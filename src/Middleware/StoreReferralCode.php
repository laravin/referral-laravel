<?php

namespace Laravin\Referral\Middleware;

use Closure;
use Laravin\Referral\Models\ReferralLink;

class StoreReferralCode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($request->has('ref')) {
            $referral = ReferralLink::whereCode($request->get('ref'))->first();
            $response->cookie('ref', $referral->id, $referral->lifetime_minutes);
        }

        return $response;
    }
}
