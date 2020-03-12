<?php

namespace App\Http\Controllers;

use App\district;
use App\division;
use App\Onboard_mm;
use App\union;
use App\upazila;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function MongoDB\BSON\toJSON;

class transactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*        $districts = DB::table("onboard_mms")
                ->join('districts', 'onboard_mms.id_onboard_mm', '=', 'transactions.id_onboard_mm')
                ->where('onboard_mms.id_onboard_mm', '=', 45)
                ->where('is_order_completed',1)
                ->count();*/

        $districts = DB::table("transactions")
            ->join('onboard_mms', 'onboard_mms.id_onboard_mm', '=', 'transactions.id_onboard_mm')
            ->where('onboard_mms.district_id', '=', 45)
            ->where('transactions.is_order_completed', 1)
            ->count();
        return $districts;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $divisions = division::all();
        $districts = district::all();
        $upazilas = upazila::all();
        $unions = union::all();

        $av_districts = DB::table('onboard_mms')
            ->select('districts.district_name', 'districts.id')
            ->join('districts', 'onboard_mms.district_id', '=', 'districts.id')
            ->distinct()
            ->get();

        /*        total transaction number calculation*/
        $total_transaction = DB::table('transactions')
            ->count();

        /* total successfull transaction calculation*/
        $total_successful_transaction = DB::table('transactions')
            ->where('is_order_completed', 1)
            ->count();

        /* total successfull transaction amount calculation*/
        $total_transaction_value = DB::table('transactions')
            ->where('is_order_completed', 1)
            ->sum('amount');


        return view('transaction.create', compact('total_transaction_value', 'total_successful_transaction', 'total_transaction', 'av_districts', 'divisions', 'districts', 'upazilas', 'unions'));
    }


    public function getDistricts($id)
    {

        $districts = DB::table('onboard_mms')
            ->join('districts', 'onboard_mms.district_id', '=', 'districts.id')
            ->where('onboard_mms.division_id', '=', $id)
            ->distinct()
            ->pluck('districts.district_name', 'id');

        return json_encode($districts);
    }

    public function numberOfTrans($id)
    {
        $districts = [];

        $districts['number_of_trans'] = DB::table("transactions")
            ->join('onboard_mms', 'onboard_mms.id_onboard_mm', '=', 'transactions.id_onboard_mm')
            ->where('onboard_mms.district_id', '=', $id)
            //->where('transactions.is_order_completed',1)
            ->count();

        $districts['number_of_successfull_trans'] = DB::table("transactions")
            ->join('onboard_mms', 'onboard_mms.id_onboard_mm', '=', 'transactions.id_onboard_mm')
            ->where('onboard_mms.district_id', '=', $id)
            ->where('transactions.is_order_completed', 1)
            ->count();

        $districts['total_amount_of_trans'] = DB::table("transactions")
            ->join('onboard_mms', 'onboard_mms.id_onboard_mm', '=', 'transactions.id_onboard_mm')
            ->where('onboard_mms.district_id', '=', $id)
            ->where('transactions.is_order_completed', 1)
            ->sum('amount');

        return json_encode($districts);
    }

    public function numberOfSuccTrans($id)
    {
        $districts = DB::table("transactions")
            ->join('onboard_mms', 'onboard_mms.id_onboard_mm', '=', 'transactions.id_onboard_mm')
            ->where('onboard_mms.district_id', '=', $id)
            ->where('transactions.is_order_completed', 1)
            ->count();
        return json_encode($districts);
    }

    public function totalAmountTransaction($id)
    {
        $districts = DB::table("transactions")
            ->join('onboard_mms', 'onboard_mms.id_onboard_mm', '=', 'transactions.id_onboard_mm')
            ->where('onboard_mms.district_id', '=', $id)
            ->where('transactions.is_order_completed', 1)
            ->sum('amount');
        return json_encode($districts);
    }

    public function getUpazilas($id)
    {
        $districts = DB::table("upazilas")->where("district_id", $id)->pluck("upazila_name", "id");
        return json_encode($districts);
    }

    public function getUnions($id)
    {
        $unions = DB::table("unions")->where("id_upazila_list", $id)->pluck("union_name", "id");
        return json_encode($unions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $trans_amount = $request->trans_value;
        $max_amount = $trans_amount + 100;
        $min_amount = $trans_amount - 100;

        $onboard_mm = DB::table('onboard_mms')
            ->select('id_onboard_mm')
            ->where('is_active', 1)
            ->where('district_id', $request->district)
            ->pluck('id_onboard_mm');

        $arr = array();
        foreach ($onboard_mm as $onboard) {
            array_push($arr, $onboard);
        }

        for ($i = 0; $i < $request->number_of_trans; $i++) {

            $ar = array_rand($arr);
            $v = $arr[$ar];

            $random_amount = mt_rand($min_amount, $max_amount);
            $reference_number = substr(str_shuffle($permitted_chars), 8, 8);

            $min = strtotime($request->start_date);
            $max = strtotime($request->end_date);
            $val = rand($min, $max);

            $trans_date = date('Y-m-d H:i:s', $val);

            if ($i < $request->succ_trans) {

                DB::table('transactions')->insert([
                    [
                        'id_onboard_mm' => $v,
                        'trans_date' => $trans_date,
                        'reference' => $reference_number,
                        'amount' => $random_amount,
                        'is_order_completed' => '1',
                    ]
                ]);
            } else {
                DB::table('transactions')->insert([
                    [
                        'id_onboard_mm' => $v,
                        'trans_date' => $trans_date,
                        'reference' => $reference_number,
                        'amount' => $random_amount,
                    ]
                ]);
            }
        }
        return redirect()->back()->with('status', 'Saved Successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
