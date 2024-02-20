<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Withdrawal;

class AdminController extends Controller
{
    //
    //
    /**
     * Display referrals listing.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // $users = User::paginate(20, pageName: 'users');
        // $withdrawals = Withdrawal::paginate(20, pageName: 'withdrawals');

        return view('admin.index');
    }

    public function delete_user(Request $request) {
        
    }
}
