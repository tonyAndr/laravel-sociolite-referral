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
    public function index(Request $request, $page = 'index')
    {
        return view('admin.index', ['page' => $page]);
    }
    public function users(Request $request)
    {
        return $this->index($request, 'users');
    }
    public function withdrawals(Request $request)
    {
        return $this->index($request, 'withdrawals');
    }

    public function delete_user(Request $request) {
        
    }
}
