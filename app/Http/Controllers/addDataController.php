<?php

namespace App\Http\Controllers;

use App\district;
use App\division;
use App\Mm_profile;
use App\Onboard_mm;
use App\union;
use App\upazila;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use DB;

class addDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $districts = DB::table("onboard_mms")
            ->where('district_id', '=', 21)
            ->count();

        dd($districts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $divisions = division::all();
        //return $divisions;
        $districts = district::all();
        $upazilas = upazila::all();
        $unions = union::all();

        $av_districts = DB::table('onboard_mms')
            ->select('districts.district_name', 'districts.id')
            ->join('districts', 'onboard_mms.district_id', '=', 'districts.id')
            ->distinct()
            ->get();

        $totalMm = DB::table('onboard_mms')
            ->count();

        $activeMm = DB::table('onboard_mms')
            ->where('is_active','1')
            ->count();
        if ($totalMm!=0)
        {
            $percentage=($activeMm*100)/$totalMm.'%';
        }
        else
        {
            $percentage='None';
        }



        return view('add-data', compact('percentage','activeMm','totalMm','av_districts','divisions', 'districts', 'upazilas', 'unions'));
    }

    public function getTotalMm($id)
    {
        $check_data=DB::table("onboard_mms")
            ->get();
        if ($check_data!=null)
        {
            $districts=[];

            $districts['total'] = DB::table("onboard_mms")
                ->where('district_id', '=', $id)
                ->count();
            $districts['active'] = DB::table("onboard_mms")
                ->where('district_id', '=', $id)
                ->where('is_active',1)
                ->count();

            $districts['average']=round($districts['active']*100/$districts['total']);

            return json_encode($districts);
        }


    }


    public function getDivisions()
    {
        $divisions = DB::table('divisions')->pluck("name", "id");
        return view('add-data', compact('divisions'));
    }

    public function getDistricts($id)
    {
        $districts = DB::table("districts")->where("division_id", $id)->pluck("district_name", "id");
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
        if ($request->submit!="submited"){
            return redirect()->back();
        }

        //return $request;
        $max_profile_id = (Onboard_mm::max('id_profile')) + 1;
        $max_mm_profile_id = Mm_profile::max('id_mm_profile');
        //return $max;

        // Convert to timetamps
        $min = strtotime($request->start_date);
        $max = strtotime($request->end_date);
        // Generate random number using above bounds

        for ($i = 0; $i < $request->number_mm; $i++) {

            if ($max_profile_id < $max_mm_profile_id) {

                $val = rand($min, $max);
                $joining_date = date('Y-m-d H:i:s', $val);

                if ($i < $request->number_mm_active) {
                    DB::table('onboard_mms')->insert([
                        [
                            'id_profile' => $max_profile_id + $i,
                            'division_id' => $request->division,
                            'district_id' => $request->district,
                            'upazila_id' => $request->upazila,
                            'union_id' => $request->union,
                            'joining_date' => $joining_date,
                            'is_active' => '1',
                        ]
                    ]);
                } else {
                    DB::table('onboard_mms')->insert([
                        [
                            'id_profile' => $max_profile_id + $i,
                            'division_id' => $request->division,
                            'district_id' => $request->district,
                            'upazila_id' => $request->upazila,
                            'union_id' => $request->union,
                            'joining_date' => $joining_date,
                        ]
                    ]);
                }

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
