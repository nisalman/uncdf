<?php

namespace App\Http\Controllers;

use http\Client\Curl\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
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

    public function checkupdate()
    {
        if (Cache::has('ekshopUsers', 'ekShopUsersOrders')) {
            if (count(Cache('ekshopUsers')) != self::getEkshopLiveUserCount() || count(cache('ekShopUsersOrders')) != self::getEkshopLiveOrderCount()) {
                self::setUserCache();
                self::setOrderCache();
                self::getAllTangailUsers();
                self::getAllTangailActiveUsers();
                self::getAllSirajganjActiveUsers();
                self::getAllSirajganjUsers();

                Self::getDate();

                $trans_latest_dates = cache('allDates');
                $trans_date_count = count($trans_latest_dates);
                Self::getDateCount($trans_date_count, $trans_latest_dates);
                $trans_latest_last7 = cache('getDateCount');
                Self::getNumberOfTrans($trans_latest_last7);
                Self::getTotalAmountByDate($trans_latest_last7);
                Self::getNumOfTransTangail($trans_latest_last7);
                Self::getNumOfTransSirajgonj($trans_latest_last7);
                Self::getTotalAmountInTangail($trans_latest_last7);
                Self::getTotalAmountInSirajgong($trans_latest_last7);
                Self::getAverageAmountInTangail($trans_latest_last7);
                Self::getAverageAmountInSirajgonj($trans_latest_last7);
                Self::getAllSirajgonjUserData();
                Self::getAllSirajgonjUniqueUserData();
                Self::getAlldistrictTarget();
                echo "cache updated";
                DB::table('last_update')
                    ->where('id',1)
                    ->update(
                        [
                            'updated_at' => now()
                        ]
                    );
            } else {
                DB::table('last_update')
                    ->where('id',1)
                    ->update(
                        [
                            'updated_at' => now()
                        ]
                    );
            }

        } else {
            self::setUserCache();
            self::setOrderCache();
            self::getAllTangailUsers();
            self::getAllTangailActiveUsers();
            self::getAllSirajganjActiveUsers();
            self::getAllSirajganjUsers();

            Self::getDate();
            $trans_latest_dates = cache('allDates');
            $trans_date_count = count($trans_latest_dates);
            Self::getDateCount($trans_date_count, $trans_latest_dates);
            $trans_latest_last7 = cache('getDateCount');
            Self::getNumberOfTrans($trans_latest_last7);
            Self::getTotalAmountByDate($trans_latest_last7);
            Self::getNumOfTransTangail($trans_latest_last7);
            Self::getNumOfTransSirajgonj($trans_latest_last7);
            Self::getTotalAmountInTangail($trans_latest_last7);
            Self::getTotalAmountInSirajgong($trans_latest_last7);
            Self::getAverageAmountInTangail($trans_latest_last7);
            Self::getAverageAmountInSirajgonj($trans_latest_last7);
            Self::getAllSirajgonjUserData();
            Self::getAllSirajgonjUniqueUserData();
            Self::getAlldistrictTarget();
            DB::table('last_update')
                ->where('id',1)
                ->update(
                    [
                        'updated_at' => now()
                    ]
                );

        }
        Session::flash('status', 'Data Updated Successfully');
        return redirect()->back();

    }

    public function index()
    {
        $userType = Auth::user()->user_type;

        $trans_latest_dates = cache('allDates');
        $districtTarget = cache('getDistrictTarget');
        //dd($districtTarget);
        $trans_latest_last7 = cache('getDateCount');
        //Get All users from ekshop live
        $getAllEkshopUsers = cache('ekShopUsers');

        //getCount ekshop users Count from cache
        $getAllEkshopUsersCount = count(Cache('ekshopUsers'));

        //Get all ekshop Orders
        $getAllEkshopUserOrders = cache('ekShopUsersOrders');
        $getAllEkshopUserOrdersCount = count(cache('ekShopUsersOrders'));

        //Get Active distinct users count from the order table | ekShopLive
        $getEkshopActiveUsersCount = Cache::get('ekShopUsersOrders')->unique('id')->count('id');

        //Calculate Active user percentage
        $activeUserInPercentage = round((100 * $getEkshopActiveUsersCount) / $getAllEkshopUsersCount);
        $getAllTangailUsers = Cache('tangailUsers');
        //Count All Tangail Active Users
        $tangailActiveUsers = Cache('tangailActiveUsers')->count();
        //Count All Tangail Users
        $getAllTangailUsersCount = Cache('tangailUsers')->count('id');
        $getAllSirajganjUsers = Cache('sirajGanjUsers');

        //Count All Sirajganj Users
        $sirajganjUsersCount = Cache('sirajGanjUsers')->count('id');
        $sirajganjActiveUsersCount = Cache('sirajganjActiveUsers')->count('id');

        $tangailActiveUserPercent = round((100 * $tangailActiveUsers) / $getAllTangailUsersCount);
        $tangailInactiveUserPercent = 100 - $tangailActiveUserPercent;
        $tangailInactiveUsers = $getAllTangailUsersCount - $tangailActiveUsers;

        $sirajganjActiveUserPercent = round((100 * $sirajganjActiveUsersCount) / $sirajganjUsersCount);
        $sirajganjInactiveUserPercent = 100 - $sirajganjActiveUserPercent;
        $tangailInactiveUsers = $getAllTangailUsersCount - $tangailActiveUsers;

        /*Sirajgong data form ekshop starts*/


        $sir_latest_total = cache('sirLatestTotal');
        $sir_latst_active_trans = cache('sirLatestact');


        $sir_latst_active_trans_percent = round((100 * $sir_latst_active_trans) / $sir_latest_total);
        $sir_latst_inactive_trans_percent = 100 - $sir_latst_active_trans_percent;
        $sir_latst_inactive_trans = $sir_latest_total - $sir_latst_active_trans;


        $totalNumTransByDate = cache('numberOfTrans');
        $totalAmountByDate = cache('amountOfTrans');
        $totalNumTransInTangail = cache('tangailTransNum');
        $totalNumTransinSirajgonj = cache('sirajgonjTransNum');
        $totalAmountInTangail = cache('totalAmountTangail');
        $totalAmountInSirajgonj = cache('totalAmountSirajgonj');
        $averageAmountInTangail = cache('averageAmountTangail');
        $averageAmountInSirajgonj = cache('averageAmountSirajgonj');

        /*Sirajgong data form ekshop end*/


        /*Date formatting end*/

        /*Date formatting end*/


        /*  $totalNumTransByDate = [];

          for ($i = 0; $i < count($trans_latest_last7_ln); $i++) {
               $totalNumTransByDate[$i] = DB::connection('ekshoplive')
                  ->table('orders')
                  ->join('users', 'orders.user_id', '=', 'users.id')
                  ->where('users.center_name', 'like', '%MM')
                  ->where('orders.created_at', 'LIKE', '%' . $trans_latest_last7_ln[$i] . '%')
                  ->count();
          }

          dd($totalNumTransByDate);*/


        //Total Transaction number BY date


        /*//Total Transaction amount in Tangail
        $averageAmountInTangail = []; //last 7 days number of total transaction
        for ($i = 0; $i < count($trans_latest_last7_ln); $i++) {
            $averageAmountInTangail[$i] = DB::connection('ekshoplive')
                ->table('orders')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->where('users.district', '=', 'tangail')
                ->where('users.center_name', 'like', '%MM')
                ->where('orders.created_at', 'LIKE', '%' . $trans_latest_last7_ln[$i] . '%')
                ->sum('orders.total_price');
        }*/

        //dd($averageAmountInSirajgonj);


//        $trans_dates = DB::table('transactions')
//            ->select('trans_date')
//            ->distinct()
//            ->limit(15)
//            ->orderByDesc('trans_date')
//            ->get();
//
//
//        /*Last 7 days Tangail Transaction*/
//
//        $trans_last7 = []; //get last 7 days
//        for ($i = 0; $i < count($trans_dates); $i++) {
//            $trans_last7[$i] = $trans_dates[$i]->trans_date;
//        }
//
//        $tan_total_last7 = [];
//
//        for ($i = 0; $i < count($trans_dates); $i++) {
//            $tan_total_last7[$i] = DB::table('transactions')
//                ->select('transactions.amount')
//                ->join('onboard_mms', 'transactions.id_onboard_mm', '=', 'onboard_mms.id_onboard_mm')
//                ->where('onboard_mms.district_id', '=', 34)
//                ->where('trans_date', $trans_dates[$i]->trans_date)
//                ->where('transactions.is_order_completed', '=', 1)
//                ->orderByDesc('transactions.trans_date')
//                ->sum('transactions.amount');
//        }
//
//        $tan_total_last7_avg = [];
//
//        for ($i = 0; $i < count($trans_dates); $i++) {
//            $tan_total_last7_average[$i] = DB::table('transactions')
//                ->select('transactions.amount')
//                ->join('onboard_mms', 'transactions.id_onboard_mm', '=', 'onboard_mms.id_onboard_mm')
//                ->where('onboard_mms.district_id', '=', 34)
//                ->where('trans_date', $trans_dates[$i]->trans_date)
//                ->where('transactions.is_order_completed', '=', 1)
//                ->orderByDesc('transactions.trans_date')
//                ->avg('transactions.amount');
//
//            $tan_total_last7_avg[$i] = round($tan_total_last7_average[$i]);
//        }
//
//
//        $tan_total_last7_count = [];
//        for ($i = 0; $i < count($trans_dates); $i++) {
//            $tan_total_last7_count[$i] = DB::table('transactions')
//                ->select('transactions.amount')
//                ->join('onboard_mms', 'transactions.id_onboard_mm', '=', 'onboard_mms.id_onboard_mm')
//                ->where('onboard_mms.district_id', '=', 34)
//                ->where('trans_date', $trans_dates[$i]->trans_date)
//                ->where('transactions.is_order_completed', '=', 1)
//                ->orderByDesc('transactions.trans_date')
//                ->count();
//        }
//        //dd($tan_total_last7_count);
//
//        $sir_total_last7_count = [];
//        for ($i = 0; $i < count($trans_dates); $i++) {
//            $sir_total_last7_count[$i] = DB::table('transactions')
//                ->select('transactions.amount')
//                ->join('onboard_mms', 'transactions.id_onboard_mm', '=', 'onboard_mms.id_onboard_mm')
//                ->where('onboard_mms.district_id', '=', 52)
//                ->where('trans_date', $trans_dates[$i]->trans_date)
//                ->where('transactions.is_order_completed', '=', 1)
//                ->orderByDesc('transactions.trans_date')
//                ->count();
//        }
//        //dd($sir_total_last7_count);
//
//
//        /*Last 7 days Tangail Transaction end*/
//
//
//        /*Last 7 days Sirajgonj Transaction starts*/
//
//        $sir_total_last7 = [];
//
//        for ($i = 0; $i < count($trans_dates); $i++) {
//            $sir_total_last7[$i] = DB::table('transactions')
//                ->select('transactions.amount')
//                ->join('onboard_mms', 'transactions.id_onboard_mm', '=', 'onboard_mms.id_onboard_mm')
//                ->where('onboard_mms.district_id', '=', 52)
//                ->where('trans_date', $trans_dates[$i]->trans_date)
//                ->where('transactions.is_order_completed', '=', 1)
//                ->orderByDesc('transactions.trans_date')
//                ->sum('transactions.amount');
//        }
//
//        $sir_total_last7_avg = [];
//
//        for ($i = 0; $i < count($trans_dates); $i++) {
//            $sir_total_last7_average[$i] = DB::table('transactions')
//                ->select('transactions.amount')
//                ->join('onboard_mms', 'transactions.id_onboard_mm', '=', 'onboard_mms.id_onboard_mm')
//                ->where('onboard_mms.district_id', '=', 52)
//                ->where('trans_date', $trans_dates[$i]->trans_date)
//                ->where('transactions.is_order_completed', '=', 1)
//                ->orderByDesc('transactions.trans_date')
//                ->avg('transactions.amount');
//            $sir_total_last7_avg[$i] = round($sir_total_last7_average[$i]);
//        }
//
//
//        //dd($sir_total_last7_avg); // Sirajgong Last 15 days
//
//        /*Last 7 days Sirajgonj Transaction ends*/
//
//
//        $trans_last7 = []; //get last 7 days
//        for ($i = 0; $i < count($trans_dates); $i++) {
//            $trans_last7[$i] = $trans_dates[$i]->trans_date;
//        }
//
//
//        $trans_form_date = []; // date formatting like: 30 Mar
//
//        for ($i = 0; $i < count($trans_dates); $i++) {
//            $yrdata = strtotime($trans_last7[$i]);
//            $trans_form_date[$i] = date("d M", $yrdata);
//        }
//
//        $trans_amount = []; //last 7 days total amount
//
//        for ($i = 0; $i < count($trans_dates); $i++) {
//            $trans_amount[$i] = DB::table('transactions')
//                ->select('amount')
//                ->where('trans_date', $trans_dates[$i]->trans_date)
//                ->sum('amount');
//        }
//
//
//        $trans_successful = []; //last 7 days successfull transaction
//
//        for ($i = 0; $i < count($trans_dates); $i++) {
//            $trans_successful[$i] = DB::table('transactions')
//                ->select('amount')
//                ->where('trans_date', $trans_dates[$i]->trans_date)
//                ->where('is_order_completed', 1)
//                ->sum('amount');
//        }
//
//        $trans_total_count = []; //last 7 days number of total transaction
//
//        for ($i = 0; $i < count($trans_dates); $i++) {
//            $trans_total_count[$i] = DB::table('transactions')
//                ->where('trans_date', $trans_dates[$i]->trans_date)
//                ->count();
//        }
//        //dd($trans_total_count);
//
//        $trans_successful_count = []; //last 7 days number of successfull transaction
//
//        for ($i = 0; $i < count($trans_dates); $i++) {
//            $trans_successful_count[$i] = DB::table('transactions')
//                ->select('amount')
//                ->where('trans_date', $trans_dates[$i]->trans_date)
//                ->where('is_order_completed', 1)
//                ->count('amount');
//        }
//        //dd($trans_successful_count);
//
//
//        $av_districts = DB::table('onboard_mms')
//            ->select('districts.district_name', 'districts.id')
//            ->join('districts', 'onboard_mms.district_id', '=', 'districts.id')
//            ->distinct()
//            ->get();
//
//        $totalMm = DB::table('onboard_mms')
//            ->count();
//
//        $activeMm = DB::table('onboard_mms')
//            ->where('is_active', '1')
//            ->count();
//        if ($totalMm != 0) {
//            $active_percentage = round(($activeMm * 100) / $totalMm);
//            $inactive_percentage = round(100 - $active_percentage);
//        } else {
//            $active_percentage = 'None';
//            $inactive_percentage = 'None';
//        }
//
//        /*graph data retrive for Tangail District Starts*/
//
//        $tangailTotal = DB::table('onboard_mms')
//            ->where('district_id', 34)
//            ->count();
//
//        $tangailActive = DB::table('onboard_mms')
//            ->where('district_id', 34)
//            ->where('is_active', '1')
//            ->count();
//        if ($tangailTotal != 0) {
//            $tangail_active_percentage = round(($tangailActive * 100) / $tangailTotal);
//            $tangail_inactive_percentage = round(100 - $tangail_active_percentage);
//        } else {
//            $tangail_active_percentage = 'None';
//            $tangail_inactive_percentage = 'None';
//        }
//
//        /*graph data retrive for Tangail District Ends*/
//
//        /*graph data retrive for Sirajgonj District Starts*/
//
//        $sirajgonjTotal = DB::table('onboard_mms')
//            ->where('district_id', 52)
//            ->count();
//
//        $sirajgonjActive = DB::table('onboard_mms')
//            ->where('district_id', 52)
//            ->where('is_active', '1')
//            ->count();
//        if ($sirajgonjTotal != 0) {
//            $sirajgonj_active_percentage = round(($sirajgonjActive * 100) / $sirajgonjTotal);
//            $sirajgonj_inactive_percentage = round(100 - $sirajgonj_active_percentage);
//        } else {
//            $sirajgonj_active_percentage = 'None';
//            $sirajgonj_inactive_percentage = 'None';
//        }
        /*graph data retrive for Sirajgonj District Ends*/


        return view('home', compact(
        //'av_districts',
        //'inactive_percentage',
        //'totalMm',
        //'active_percentage',
        //'activeMm',

        //'totalMm',
        //'activeMm',
        //'tangailTotal',
        //'tangailActive',
        //'tangail_inactive_percentage',
        //'tangail_active_percentage',
        //'sirajgonjTotal',
        //'sirajgonjActive',
        //'sirajgonj_inactive_percentage',
        //'sirajgonj_active_percentage',
        //'trans_form_date',
        //'trans_amount',
        //'trans_successful',
        //'trans_total_count',
        //'trans_successful_count',

        //'tan_total_last7',
        //'sir_total_last7',
        //'tan_total_last7_count',
        //'sir_total_last7_count',
        //'tan_total_last7_avg',
        //'sir_total_last7_avg',
            'trans_latest_last7',
            'userType',
            'getAllEkshopUsers',
            'getAllEkshopUsersCount',
            'getEkshopActiveUsersCount',
            'activeUserInPercentage',
            'totalNumTransByDate',
            'tangailActiveUserPercent',
            'getAllTangailUsersCount',
            'tangailActiveUsers',
            'tangailInactiveUsers',
            'tangailInactiveUserPercent',
            'trans_latest_last7',
            'totalAmountByDate',
            'sirajganjUsersCount',
            'sirajganjActiveUsersCount',
            'sirajganjActiveUserPercent',
            'sirajganjInactiveUserPercent',
            'totalAmountInTangail',
            'averageAmountInTangail',
            'averageAmountInSirajgonj',
            'totalAmountInSirajgonj',
            'totalNumTransInTangail',
            'totalNumTransinSirajgonj',
            'sir_latst_active_trans',
            'sir_latst_inactive_trans',
            'sir_latest_total',
            'districtTarget',
            'getAllEkshopUserOrders',
            'sir_latst_active_trans_percent',
            'sir_latst_inactive_trans_percent'
        //'trans_latest_count'
        ));
    }


    public function setUserCache()
    {
        Cache::forget('ekShopUsers');
        Cache::rememberForever('ekShopUsers', function () {
            return DB::connection('ekshoplive')->table('users')
                ->where('users.center_name', 'like', '%MM')
                ->select(
                    'name_en',
                    'users.center_name',
                    'users.contact_number',
                    'users.id',
                    'users.district',
                    'users.created_at'
                )
                ->distinct('users.center_id')
                ->orderByDesc('users.id')
                ->get();
        });
    }

    public function setOrderCache()
    {
        cache::forget('ekShopUsersOrders');
        Cache::rememberForever('ekShopUsersOrders', function () {
            return DB::connection('ekshoplive')
                ->table('orders')
                ->where('users.center_name', 'like', '%MM')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->select(
                    'users.id',
                    'orders.order_code',
                    'orders.total_price',
                    'orders.payment_method',
                    'orders.total_quantity',
                    'orders.total_price',
                    'orders.created_at'
                )->orderByDesc('orders.id')
                ->get();
        });
    }

    public function getAllTangailUsers()
    {
        cache::forget('tangailUsers');
        $data = Cache::rememberForever('tangailUsers', function () {
            return DB::connection('ekshoplive')
                ->table('users')
                ->where('users.center_name', 'like', '%MM')
                ->where('users.district', '=', 'tangail')
                ->get();
        });
    }

    public function getAllTangailActiveUsers()
    {
        cache::forget('tangailActiveUsers');
        Cache::rememberForever('tangailActiveUsers', function () {
            return DB::connection('ekshoplive')
                ->table('orders')
                ->join('users', 'users.id', '=', 'orders.user_id')
                ->where('users.center_name', 'like', '%MM')
                ->where('users.district', '=', 'tangail')
                ->get();
        });
    }

    public function getAllSirajganjUsers()
    {
        cache::forget('sirajGanjUsers');
        Cache::rememberForever('sirajGanjUsers', function () {
            return DB::connection('ekshoplive')
                ->table('users')
                ->where('users.center_name', 'like', '%MM')
                ->where('users.district', '=', 'sirajganj')
                ->get();
        });
    }

    public function getAllSirajganjActiveUsers()
    {
        cache::forget('sirajganjActiveUsers');
        Cache::rememberForever('sirajganjActiveUsers', function () {
            return DB::connection('ekshoplive')
                ->table('orders')
                ->join('users', 'users.id', '=', 'orders.user_id')
                ->where('users.center_name', 'like', '%MM')
                ->where('users.district', '=', 'sirajganj')
                ->get();
        });
    }


    public function getEkshopLiveUserCount()
    {
        return DB::connection('ekshoplive')
            ->table('users')
            ->where('center_name', 'like', '%MM')
            ->count();
    }

    public function getEkshopLiveOrderCount()
    {
        return DB::connection('ekshoplive')
            ->table('orders')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->where('users.center_name', 'like', '%MM')
            ->count();
    }

    public function getAllSirajgonjUserData()
    {
        Cache::forget('sirLatestTotal');
        Cache::rememberForever('sirLatestTotal', function () {
            return DB::connection('ekshoplive')
                ->table('users')
                ->where('users.center_name', 'like', '%MM')
                ->where('users.district', '=', 'sirajganj')
                ->count();
        });
    }

    public function getAllSirajgonjUniqueUserData()
    {
        Cache::forget('sirLatestact');
        Cache::rememberForever('sirLatestact', function () {
            return DB::connection('ekshoplive')
                ->table('users')
                ->join('orders', 'users.id', '=', 'orders.user_id')
                ->where('users.center_name', 'like', '%MM')
                ->where('users.district', '=', 'sirajganj')
                ->distinct('orders.user_id')
                ->count();
        });
    }

    public function getDate()
    {
        Cache::forget('allDates');
        Cache::rememberForever('allDates', function () {
            return DB::connection('ekshoplive')
                ->table('orders')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->where('users.center_name', 'like', '%MM')
                ->select('orders.created_at')
                ->get();
        });
    }

    public function getNumberOfTrans($trans_latest_last7)
    {
        Cache::forget('numberOfTrans');
        $totalNumTransByDate = [];
        Cache::rememberForever('numberOfTrans', function () use ($trans_latest_last7) {

            for ($i = 0; $i < count($trans_latest_last7); $i++) {
                $totalNumTransByDate[$i] = DB::connection('ekshoplive')
                    ->table('orders')
                    ->join('users', 'orders.user_id', '=', 'users.id')
                    ->where('users.center_name', 'like', '%MM')
                    ->where('orders.created_at', 'LIKE', $trans_latest_last7[$i] . '%')
                    ->count('orders.created_at');

            }
            return $totalNumTransByDate;
        });
    }

    public function getTotalAmountByDate($trans_latest_last7)
    {

        Cache::forget('amountOfTrans');
        $totalAmountByDate = [];
        Cache::rememberForever('amountOfTrans', function () use ($trans_latest_last7) {

            for ($i = 0; $i < count($trans_latest_last7); $i++) {
                $totalAmountByDate[$i] = DB::connection('ekshoplive')
                    ->table('orders')
                    ->join('users', 'orders.user_id', '=', 'users.id')
                    ->where('users.center_name', 'like', '%MM')
                    ->where('orders.created_at', 'LIKE', '%' . $trans_latest_last7[$i] . '%')
                    ->sum('orders.total_price');
            }
            return $totalAmountByDate;
        });

    }

    public function getNumOfTransTangail($trans_latest_last7)
    {
        Cache::forget('tangailTransNum');
        $totalNumTransInTangail = [];
        Cache::rememberForever('tangailTransNum', function () use ($trans_latest_last7) {

            for ($i = 0; $i < count($trans_latest_last7); $i++) {
                $totalNumTransInTangail[$i] = DB::connection('ekshoplive')
                    ->table('orders')
                    ->join('users', 'orders.user_id', '=', 'users.id')
                    ->where('users.district', '=', 'tangail')
                    ->where('users.center_name', 'like', '%MM')
                    ->where('orders.created_at', 'LIKE', '%' . $trans_latest_last7[$i] . '%')
                    ->count();
            }
            return $totalNumTransInTangail;
        });

    }

    public function getNumOfTransSirajgonj($trans_latest_last7)
    {
        Cache::forget('sirajgonjTransNum');
        $totalNumTransinSirajgonj = [];
        Cache::rememberForever('sirajgonjTransNum', function () use ($trans_latest_last7) {

            for ($i = 0; $i < count($trans_latest_last7); $i++) {
                $totalNumTransinSirajgonj[$i] = DB::connection('ekshoplive')
                    ->table('orders')
                    ->join('users', 'orders.user_id', '=', 'users.id')
                    ->where('users.district', '=', 'Sirajganj')
                    ->where('users.center_name', 'like', '%MM')
                    ->where('orders.created_at', 'LIKE', '%' . $trans_latest_last7[$i] . '%')
                    ->count();
            }
            return $totalNumTransinSirajgonj;
        });

    }

    public function getTotalAmountInTangail($trans_latest_last7)
    {
        Cache::forget('totalAmountTangail');
        $totalAmountInTangail = [];
        Cache::rememberForever('totalAmountTangail', function () use ($trans_latest_last7) {

            for ($i = 0; $i < count($trans_latest_last7); $i++) {
                $totalAmountInTangail[$i] = DB::connection('ekshoplive')
                    ->table('orders')
                    ->join('users', 'orders.user_id', '=', 'users.id')
                    ->where('users.district', '=', 'tangail')
                    ->where('users.center_name', 'like', '%MM')
                    ->where('orders.created_at', 'LIKE', '%' . $trans_latest_last7[$i] . '%')
                    ->sum('orders.total_price');
            }
            return $totalAmountInTangail;
        });

    }

    public function getTotalAmountInSirajgong($trans_latest_last7)
    {
        Cache::forget('totalAmountSirajgonj');
        $totalAmountInSirajgonj = [];
        Cache::rememberForever('totalAmountSirajgonj', function () use ($trans_latest_last7) {

            for ($i = 0; $i < count($trans_latest_last7); $i++) {
                $totalAmountInSirajgonj[$i] = DB::connection('ekshoplive')
                    ->table('orders')
                    ->join('users', 'orders.user_id', '=', 'users.id')
                    ->where('users.district', '=', 'Sirajganj')
                    ->where('users.center_name', 'like', '%MM')
                    ->where('orders.created_at', 'LIKE', '%' . $trans_latest_last7[$i] . '%')
                    ->sum('orders.total_price');
            }

            return $totalAmountInSirajgonj;
        });

    }

    public function getAverageAmountInTangail($trans_latest_last7)
    {
        Cache::forget('averageAmountTangail');
        $averageAmountInTangail = [];
        Cache::rememberForever('averageAmountTangail', function () use ($trans_latest_last7) {

            for ($i = 0; $i < count($trans_latest_last7); $i++) {
                $averageAmountInTangail[$i] = DB::connection('ekshoplive')
                    ->table('orders')
                    ->join('users', 'orders.user_id', '=', 'users.id')
                    ->where('users.district', '=', 'tangail')
                    ->where('users.center_name', 'like', '%MM')
                    ->where('orders.created_at', 'LIKE', '%' . $trans_latest_last7[$i] . '%')
                    ->sum('orders.total_price');
            }

            return $averageAmountInTangail;
        });

    }

    public function getAverageAmountInSirajgonj($trans_latest_last7)
    {
        Cache::forget('averageAmountSirajgonj');
        $averageAmountInSirajgonj = [];
        Cache::rememberForever('averageAmountSirajgonj', function () use ($trans_latest_last7) {

            for ($i = 0; $i < count($trans_latest_last7); $i++) {
                $averageAmountInSirajgonj[$i] = DB::connection('ekshoplive')
                    ->table('orders')
                    ->join('users', 'orders.user_id', '=', 'users.id')
                    ->where('users.district', '=', 'Sirajganj')
                    ->where('users.center_name', 'like', '%MM')
                    ->where('orders.created_at', 'LIKE', '%' . $trans_latest_last7[$i] . '%')
                    ->sum('orders.total_price');
            }

            return $averageAmountInSirajgonj;
        });

    }

    public function getDateCount($trans_date_count, $trans_latest_dates)
    {
        Cache::forget('getDateCount');
        Cache::rememberForever('getDateCount', function () use ($trans_date_count, $trans_latest_dates) {
            $trans_latest_last7_lg = [];
            for ($i = 0; $i < $trans_date_count; $i++) {
                $trans_latest_last7_lg[$i] = $trans_latest_dates[$i]->created_at;
            }

            $trans_latest_time = [];
            for ($i = 0; $i < $trans_date_count; $i++) {
                $trans_latest_time[$i] = date("Y-m-d", strtotime($trans_latest_last7_lg[$i]));
            }
            $trans_latest_count = array_values(array_count_values($trans_latest_time));

            $trans_latest_last7_in_ln = array_unique($trans_latest_time);

            $trans_latest_last7_ln = array_values($trans_latest_last7_in_ln);

            $trans_latest_last7_nu = [];
            for ($i = 0; $i < $trans_date_count; $i++) {
                $trans_latest_last7_nu[$i] = date("d M", strtotime($trans_latest_time[$i]));
            }
            $trans_latest_last7_in = array_unique($trans_latest_last7_nu);

            $trans_latest_last7 = array_values($trans_latest_last7_in);
            return $trans_latest_last7 = $trans_latest_last7_ln;
        });


    }


    public function getAlldistrictTarget()
    {
        Cache::forget('getDistrictTarget');
        Cache::rememberForever('getDistrictTarget', function () {
            $targated_trans = DB::connection('ekshoplive')
                ->table('users')
                ->select('users.district')
                ->where('users.center_name', 'like', '%MM')
                ->get();

            if (count($targated_trans) != 0) {
                $districtCounter = [];

                for ($i = 0; $i < count($targated_trans); $i++) {
                    $districtCounter[$i] = $targated_trans[$i]->district;

                }
                $targated_trans = array_count_values($districtCounter);
                $targated_count = [];

                $targated_count[0] = $targated_trans['Tangail'];
                $targated_count[1] = $targated_trans['Sirajganj'];

                //dd($targated_count);

                return $targated_count;

            } else {
                $targated_count = [];

                $targated_count[0] = 0;
                $targated_count[1] = 0;

                //dd($targated_count);

                return $targated_count;
            }
        });


    }

}

