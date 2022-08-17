<?php

namespace Laravin\Referral\Listeners;

use Laravin\Referral\Events\UserReferred;
use Laravin\Referral\Models\ReferralLink;
use Laravin\Referral\Models\ReferralRelationship;

class RewardUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserReferred $event)
    {
        dd($event);
        $referral = ReferralLink::find($event->referralId);
        if (!is_null($referral)) {
            ReferralRelationship::create(['referral_link_id' => $referral->id, 'user_id' => $event->user->id]);
            if ($referral->program->name === 'Sự kiện giới thiệu') {
                // Người chia sẻ link
                $provider = $referral->user;
                $provider->addCredits(15);
                // Người sử dụng link
                $user = $event->user;
                $user->addCredits(20);
            }
        }
    }
}
