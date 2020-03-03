@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Create User</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-lg-6">
                                {!! Form::open(['route' => 'data.store', 'method' => 'POST']) !!}
                                <label>Date Range</label>
                                <input type="date" class="form-control" name="start_date"> To
                                <input type="date" class="form-control" name="end_date"><br>
                                <label>No. of MM</label>
                                <input type="text" class="form-control" name="number_mm"><br>
                                <label>No. of Active MM</label>
                                <input type="text" class="form-control" name="number_mm_active"><br>

                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Division</label>
                                    <select class="form-control" name="division" id="" required="">
                                        <option value="">--</option>
                                        @foreach($divisions as $division)
                                            <option value="{{$division->id}}">{{$division->division_name}}</option>
                                        @endforeach
                                    </select><br>
                                    <label>District</label>
                                    <select class="form-control" name="district" id="" required="">
                                        <option value="">-select-</option>
                                    </select><br>
                                    <label>Upazila</label>
                                    <select class="form-control" id="" name="upazila">
                                        <option value="" selected>- select-</option>
                                    </select> <br>
                                    <label>Union</label>
                                    <select class="form-control" name="union" id="">
                                        <option value="">-select-</option>
                                    </select>
                                    <button type="submit" style="float: right; margin-top: 10px;" name="submit" value="submited" class="btn btn-primary">Submit
                                    </button>

                                    {!! Form::close() !!}

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                    <div class="card" style="border:1px solid #adb5bd">
                        <div class="card-header" style="text-align: center; background-color: #1d68a7; color: white">
                            Summery
                        </div>
                        <div class="card-body">
                            <table width="100%" class="table-striped">
                                <tr >
                                    <td colspan="2">
                                        <select class="form-control" name="available-districts" id="" required="">
                                            <option value="">-All-</option>
                                            @foreach($av_districts as $district)
                                                <option value="{{$district->id}}">{{$district->district_name}}</option>
                                            @endforeach
                                        </select><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="80%">Total MM:</td>
                                    <td width="20%" id="total_mm">{{$totalMm}}</td>
                                </tr>
                                <tr>
                                    <td width="80%">Active MM:</td>
                                    <td width="20%" id="active_mm">{{$activeMm}}</td>
                                </tr>
                                <tr>
                                    <td width="80%">Active Percentage:</td>
                                    <td width="20%" id="avg_mm">{{$percentage}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <
    {{--Dependency Dropdown JS--}}


    <script type="text/javascript">
        /*Districts dropdown starts*/
        jQuery(document).ready(function () {
            jQuery('select[name="division"]').on('change', function () {
                var countryID = jQuery(this).val();
                if (countryID) {
                    jQuery.ajax({
                        url: 'getdistricts/' + countryID,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            console.log(data);
                            jQuery('select[name="district"]').empty();
                            jQuery.each(data, function (key, value) {
                                $('select[name="district"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="district"]').empty();
                }
            });
        });
        /*Districts dropdown ends*/

        /*upazilla dropdown starts*/
        jQuery(document).ready(function () {
            jQuery('select[name="district"]').on('click', function () {
                var districtID = jQuery(this).val();
                if (districtID) {
                    jQuery.ajax({
                        url: 'getupazilas/' + districtID,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            console.log(data);
                            jQuery('select[name="upazila"]').empty();

                            $('select[name="upazila"]').append('<option value="0">' + "--select--" + '</option>');
                            jQuery.each(data, function (key, value) {
                                $('select[name="upazila"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="district"]').empty();
                }
            });
        });
        /*upazilla dropdown end*/

        /*upazilla dropdown starts*/
        jQuery(document).ready(function () {
            jQuery('select[name="upazila"]').on('click', function () {
                var upazilaID = jQuery(this).val();
                if (upazilaID) {
                    jQuery.ajax({
                        url: 'getunions/' + upazilaID,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            console.log(data);
                            jQuery('select[name="union"]').empty();
                            jQuery.each(data, function (key, value) {
                                $('select[name="union"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="union"]').empty();
                }
            });
        });
        /*upazilla dropdown end*/



        jQuery(document).ready(function () {
            jQuery('select[name="available-districts"]').on('change', function () {
                var districtID = jQuery(this).val();
                if (districtID) {
                    jQuery.ajax({
                        url: 'totalmm/' + districtID,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            console.log(data);
                            $('#total_mm').html(data.total);
                            $('#active_mm').html(data.active);
                            $('#avg_mm').html(data.average);
                        }
                    });
                }
            });
        });


    </script>
@endsection

