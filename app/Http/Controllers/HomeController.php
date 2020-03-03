<?php

namespace App\Http\Controllers;

use http\Client\Curl\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Javascript;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //return Carbon::now();
         $trans_dates = DB::table('transactions')
            ->select('trans_date')
            ->distinct()
             ->limit(15)
             ->orderByDesc('trans_date')
            ->get();

         //dd($trans_dates);

         $trans_last7=[]; //get last 7 days
         for ($i=0;$i<count($trans_dates);$i++)
         {
             $trans_last7[$i]=$trans_dates[$i]->trans_date;
         }

        $trans_form_date=[]; // date formatting like: 30 Mar

        for ($i=0;$i<count($trans_dates);$i++)
        {
            $yrdata= strtotime($trans_last7[$i]);
            $trans_form_date[$i]=date("d M",  $yrdata);
        }

        $trans_amount=[]; //last 7 days total amount

        for ($i=0;$i<count($trans_dates);$i++)
        {
            $trans_amount[$i] = DB::table('transactions')
                ->select('amount')
                ->where('trans_date',$trans_dates[$i]->trans_date)
                ->sum('amount');
        }


        $trans_successful=[]; //last 7 days successfull transaction

        for ($i=0;$i<count($trans_dates);$i++)
        {
            $trans_successful[$i] = DB::table('transactions')
                ->select('amount')
                ->where('trans_date',$trans_dates[$i]->trans_date)
                ->where('is_order_completed',1)
                ->sum('amount');
        }

        $trans_total_count=[]; //last 7 days number of total transaction

        for ($i=0;$i<count($trans_dates);$i++)
        {
            $trans_total_count[$i] = DB::table('transactions')
                ->where('trans_date',$trans_dates[$i]->trans_date)
                ->count();
        }
        //dd($trans_total_count);

        $trans_successful_count=[]; //last 7 days number of successfull transaction

        for ($i=0;$i<count($trans_dates);$i++)
        {
            $trans_successful_count[$i] = DB::table('transactions')
                ->select('amount')
                ->where('trans_date',$trans_dates[$i]->trans_date)
                ->where('is_order_completed',1)
                ->count('amount');
        }
        //dd($trans_successful_count);

        $userType = Auth::user()->user_type;

        $av_districts = DB::table('onboard_mms')
            ->select('districts.district_name', 'districts.id')
            ->join('districts', 'onboard_mms.district_id', '=', 'districts.id')
            ->distinct()
            ->get();

        $totalMm = DB::table('onboard_mms')
            ->count();

        $activeMm = DB::table('onboard_mms')
            ->where('is_active', '1')
            ->count();
        if ($totalMm != 0) {
            $active_percentage = round(($activeMm * 100) / $totalMm);
            $inactive_percentage = round(100 - $active_percentage);
        } else {
            $active_percentage = 'None';
            $inactive_percentage = 'None';
        }

        /*graph data retrive for Tangail District Starts*/

        $tangailTotal = DB::table('onboard_mms')
            ->where('district_id', 34)
            ->count();

        $tangailActive = DB::table('onboard_mms')
            ->where('district_id', 34)
            ->where('is_active', '1')
            ->count();
        if ($tangailTotal != 0) {
            $tangail_active_percentage = round(($tangailActive * 100) / $tangailTotal);
            $tangail_inactive_percentage = round(100 - $tangail_active_percentage);
        } else {
            $tangail_active_percentage = 'None';
            $tangail_inactive_percentage = 'None';
        }

        /*graph data retrive for Tangail District Ends*/

        /*graph data retrive for Sirajgonj District Starts*/

        $sirajgonjTotal = DB::table('onboard_mms')
            ->where('district_id', 52)
            ->count();

        $sirajgonjActive = DB::table('onboard_mms')
            ->where('district_id', 52)
            ->where('is_active', '1')
            ->count();
        if ($sirajgonjTotal != 0) {
            $sirajgonj_active_percentage = round(($sirajgonjActive * 100) / $sirajgonjTotal);
            $sirajgonj_inactive_percentage = round(100 - $sirajgonj_active_percentage);
        } else {
            $sirajgonj_active_percentage = 'None';
            $sirajgonj_inactive_percentage = 'None';
        }

        /*graph data retrive for Sirajgonj District Ends*/


        //dd(session()->all());
        return view('home', compact(
            'av_districts',
            'inactive_percentage',
            'totalMm',
            'active_percentage',
            'activeMm',
            'userType',
            'totalMm',
            'activeMm',
            'tangailTotal',
            'tangailActive',
            'tangail_inactive_percentage',
            'tangail_active_percentage',
            'sirajgonjTotal',
            'sirajgonjActive',
            'sirajgonj_inactive_percentage',
            'sirajgonj_active_percentage',
            'trans_form_date',
            'trans_amount',
            'trans_successful',
            'trans_total_count',
            'trans_successful_count'
        ));
    }
}
