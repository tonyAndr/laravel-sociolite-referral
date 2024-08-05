<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReferralAcceptedMail;
use App\Http\Requests\ReferralStoreRequest;
use App\Models\User;
use App\Notifications\NotifyParentsRewardedReferrals;

class ReferralController extends Controller
{
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display referrals listing.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $referrals = $request->user()->referrals()->orderBy('created_at', 'asc')->get();

        return view('referrals.index', compact('referrals'));
    }

    public static function rewardParents(User $user, $robux) {
        $parent = $user->getParent();
        // lvl 1: 10%
        $lvl1_rbx = round($robux*0.1,2);
        if ($parent) {
            $parent->addRobuxNoRef($lvl1_rbx);
            $parent->notify(new NotifyParentsRewardedReferrals($lvl1_rbx));
            // lvl 2: 1%
            $grandpa = $parent->getParent();
            $lvl2_rbx = round($robux*0.01, 2);
            if ($grandpa && $lvl2_rbx >= 0.01) {
                $grandpa->addRobuxNoRef(); 
                $grandpa->notify(new NotifyParentsRewardedReferrals($lvl2_rbx));
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     return view('referrals.create');
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ReferralStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(ReferralStoreRequest $request)
    // {
    //     $referral = $request->user()->referrals()->create($request->only('email'));
    //     Mail::to($referral->email)->send(new ReferralAcceptedMail($request->user(), $referral));

    //     return back();
    // }
}
