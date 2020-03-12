<?php

namespace App\Http\Controllers;

use Illuminate\Filesystem\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EkshopCacheController extends Controller
{
    public function updateUserCache()
    {

//        $getLiveUserCount = DB::connection('ekshoplive')->table('users')
//            ->where('users.center_name', 'like', '%MM')
//            ->count('users.id');

            Cache::remember('ekShopUsers','60', function () {
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
                    ->paginate(10);
            });

            }
}
