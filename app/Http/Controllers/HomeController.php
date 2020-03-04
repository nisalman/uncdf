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
use PHPUnit\Framework\Constraint\Count;

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

        $trans_dates = DB::table('transactions')
            ->select('trans_date')
            ->distinct()
            ->limit(15)
            ->orderByDesc('trans_date')
            ->get();

        /*Last 7 days Tangail Transaction*/

        $trans_last7 = []; //get last 7 days
        for ($i = 0; $i < count($trans_dates); $i++) {
            $trans_last7[$i] = $trans_dates[$i]->trans_date;
        }

        $tan_total_last7 = [];

        for ($i = 0; $i < count($trans_dates); $i++) {
            $tan_total_last7[$i] = DB::table('transactions')
                ->select('transactions.amount')
                ->join('onboard_mms', 'transactions.id_onboard_mm', '=', 'onboard_mms.id_onboard_mm')
                ->where('onboard_mms.district_id', '=', 34)
                ->where('trans_date', $trans_dates[$i]->trans_date)
                ->where('transactions.is_order_completed', '=', 1)
                ->orderByDesc('transactions.trans_date')
                ->sum('transactions.amount');
        }

        $tan_total_last7_avg = [];

        for ($i = 0; $i < count($trans_dates); $i++) {
            $tan_total_last7_average[$i] = DB::table('transactions')
                ->select('transactions.amount')
                ->join('onboard_mms', 'transactions.id_onboard_mm', '=', 'onboard_mms.id_onboard_mm')
                ->where('onboard_mms.district_id', '=', 34)
                ->where('trans_date', $trans_dates[$i]->trans_date)
                ->where('transactions.is_order_completed', '=', 1)
                ->orderByDesc('transactions.trans_date')
                ->avg('transactions.amount');

            $tan_total_last7_avg[$i]=round($tan_total_last7_average[$i]);
        }


        $tan_total_last7_count = [];
        for ($i = 0; $i < count($trans_dates); $i++) {
            $tan_total_last7_count[$i] = DB::table('transactions')
                ->select('transactions.amount')
                ->join('onboard_mms', 'transactions.id_onboard_mm', '=', 'onboard_mms.id_onboard_mm')
                ->where('onboard_mms.district_id', '=', 34)
                ->where('trans_date', $trans_dates[$i]->trans_date)
                ->where('transactions.is_order_completed', '=', 1)
                ->orderByDesc('transactions.trans_date')
                ->count();
        }
        //dd($tan_total_last7_count);

        $sir_total_last7_count = [];
        for ($i = 0; $i < count($trans_dates); $i++) {
            $sir_total_last7_count[$i] = DB::table('transactions')
                ->select('transactions.amount')
                ->join('onboard_mms', 'transactions.id_onboard_mm', '=', 'onboard_mms.id_onboard_mm')
                ->where('onboard_mms.district_id', '=', 52)
                ->where('trans_date', $trans_dates[$i]->trans_date)
                ->where('transactions.is_order_completed', '=', 1)
                ->orderByDesc('transactions.trans_date')
                ->count();
        }
        //dd($sir_total_last7_count);


        /*Last 7 days Tangail Transaction end*/


        /*Last 7 days Sirajgonj Transaction starts*/

        $sir_total_last7 = [];

        for ($i = 0; $i < count($trans_dates); $i++) {
            $sir_total_last7[$i] = DB::table('transactions')
                ->select('transactions.amount')
                ->join('onboard_mms', 'transactions.id_onboard_mm', '=', 'onboard_mms.id_onboard_mm')
                ->where('onboard_mms.district_id', '=', 52)
                ->where('trans_date', $trans_dates[$i]->trans_date)
                ->where('transactions.is_order_completed', '=', 1)
                ->orderByDesc('transactions.trans_date')
                ->sum('transactions.amount');
        }

        $sir_total_last7_avg = [];

        for ($i = 0; $i < count($trans_dates); $i++) {
            $sir_total_last7_average[$i] = DB::table('transactions')
                ->select('transactions.amount')
                ->join('onboard_mms', 'transactions.id_onboard_mm', '=', 'onboard_mms.id_onboard_mm')
                ->where('onboard_mms.district_id', '=', 52)
                ->where('trans_date', $trans_dates[$i]->trans_date)
                ->where('transactions.is_order_completed', '=', 1)
                ->orderByDesc('transactions.trans_date')
                ->avg('transactions.amount');
            $sir_total_last7_avg[$i]=round($sir_total_last7_average[$i]);
        }


        //dd($sir_total_last7_avg); // Sirajgong Last 15 days

        /*Last 7 days Sirajgonj Transaction ends*/


        $trans_last7 = []; //get last 7 days
        for ($i = 0; $i < count($trans_dates); $i++) {
            $trans_last7[$i] = $trans_dates[$i]->trans_date;
        }

        $trans_form_date = []; // date formatting like: 30 Mar

        for ($i = 0; $i < count($trans_dates); $i++) {
            $yrdata = strtotime($trans_last7[$i]);
            $trans_form_date[$i] = date("d M", $yrdata);
        }

        $trans_amount = []; //last 7 days total amount

        for ($i = 0; $i < count($trans_dates); $i++) {
            $trans_amount[$i] = DB::table('transactions')
                ->select('amount')
                ->where('trans_date', $trans_dates[$i]->trans_date)
                ->sum('amount');
        }


        $trans_successful = []; //last 7 days successfull transaction

        for ($i = 0; $i < count($trans_dates); $i++) {
            $trans_successful[$i] = DB::table('transactions')
                ->select('amount')
                ->where('trans_date', $trans_dates[$i]->trans_date)
                ->where('is_order_completed', 1)
                ->sum('amount');
        }

        $trans_total_count = []; //last 7 days number of total transaction

        for ($i = 0; $i < count($trans_dates); $i++) {
            $trans_total_count[$i] = DB::table('transactions')
                ->where('trans_date', $trans_dates[$i]->trans_date)
                ->count();
        }
        //dd($trans_total_count);

        $trans_successful_count = []; //last 7 days number of successfull transaction

        for ($i = 0; $i < count($trans_dates); $i++) {
            $trans_successful_count[$i] = DB::table('transactions')
                ->select('amount')
                ->where('trans_date', $trans_dates[$i]->trans_date)
                ->where('is_order_completed', 1)
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
            'trans_successful_count',
            'tan_total_last7',
            'sir_total_last7',
            'tan_total_last7_count',
            'sir_total_last7_count',
            'tan_total_last7_avg',
            'sir_total_last7_avg'
        ));
    }
}
