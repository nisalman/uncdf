<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EkshopliveController extends Controller
{
    public function getEkshopTransaction($id)
    {

        $ekShop_trans = DB::connection('ekshoplive')
            ->table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('users.id', '=', $id)
            ->select(
                'orders.order_code',
                'orders.total_price',
                'users.name_en',
                'users.center_name',
                'orders.payment_method',
                'users.contact_number',
                'orders.total_quantity',
                'users.center_id',
                'users.district',
                'orders.total_price',
                'orders.created_at'
            )

            ->get();
       return json_encode($ekShop_trans);
    }

    public function getTargatedTransaction($yearMonth)
    {

        $targated_trans = DB::connection('ekshoplive')
            ->table('orders')
            ->select('users.district')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('users.center_name', 'like', '%MM')
            ->where('orders.created_at', 'LIKE', $yearMonth . '%')
            ->get();

        if(count($targated_trans)!=0)
        {
            $districtCounter=[];

            for($i=0; $i<count($targated_trans); $i++)
            {
                $districtCounter[$i] = $targated_trans[$i]->district;

            }
            $targated_trans = array_count_values($districtCounter);
            $targated_count=[];

            $targated_count[0] = $targated_trans['Tangail'];
            $targated_count[1] = $targated_trans['Sirajganj'];

            //dd($targated_count);

            return json_encode($targated_count);

        }else
        {
            $targated_count=[];

            $targated_count[0] = 0;
            $targated_count[1] = 0;

            //dd($targated_count);

            return json_encode($targated_count);
        }


    }



}
