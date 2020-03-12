<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DateResultController extends Controller
{
    public function dataRangeValue(Request $request)
    {
        dd($request->all());
    }
}
