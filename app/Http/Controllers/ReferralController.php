<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReferralAcceptedMail;
use App\Http\Requests\ReferralStoreRequest;

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
        $referrals = $request->user()->referrals()->orderBy('completed', 'asc')->get();

        return view('referrals.index', compact('referrals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('referrals.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ReferralStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReferralStoreRequest $request)
    {
        $referral = $request->user()->referrals()->create($request->only('email'));
        Mail::to($referral->email)->send(new ReferralAcceptedMail($request->user(), $referral));

        return back();
    }
}