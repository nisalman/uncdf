<style>

    .table-height {
        line-height: 40px;
    }

    .ct-label {
        font-size: 12px;
    }
    .card-header{
        background-color: #92298D;
        color: white;
    }
    .ekshop_purchase {
        background-color: Transparent;
        background-repeat: no-repeat;
        border: none;
        cursor: pointer;
        overflow: hidden;
        outline: none;

    }

    .ct-chart-donut .ct-label {
        fill: #ffd400;
    }

    #chart5 {
        width: 100%;
        height: 300px;
        /*margin-left: 90px*/
    }

    #chart6 {
        width: 100%;
        height: 200px;
    }

    #chart7 {
        width: 100%;
        height: 200px;
    }

    #chart8 {
        width: 100%;
        height: 200px;
    }

    #chart9 {
        width: 100%;
        height: 200px;
    }

    .district {
        text-align: center;
        color: #5C5955;
    }

    .td-district {
        font-weight: bold;
    }

    .s1c {
        fill: #93D049;
    }

    .tan-active {
        fill: #33a215;
    }

    .tan-inactive {
        fill: #ee9a75;
    }

    .none {
        fill: #d6c7b1;
    }

    .si-inactive {
        fill: #c6eed7;
    }

    .barChartContainer {
        height: 400px;
        padding: 20px 0;
        background-color: white;
    }

    .s2c {
        fill: #A354A3;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        font-size: 16px;
        line-height: 1.5;
        color: #24292e;
        background-color: #fff;
        padding: 24px;
    }

    input,
    select,
    button {
        font-family: inherit;
        font-size: inherit;
        width: 120px;
    }

    select {
        width: 120px;
    }

    .monthly-wrp {
        padding: 1em;
        top: 6px;
        z-index: 1000;
        border-radius: 3px;
        background-color: #d3d3e1;
    }

    .monthly-wrp:before {
        content: "";
        border-bottom: 6px solid transparent;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        position: absolute;
        top: -6px;
        left: 6px;
        z-index: 1002;
    }


    .monthly-wrp .years {
        margin-bottom: 0.8em;
        text-align: center;
    }

    .monthly-wrp .years select {
        border: 0;
        border-radius: 3px;
        width: 100%;
    }

    .monthly-wrp .years select:focus {
        outline: none;
    }

    .monthly-wrp table {
        border-collapse: collapse;
        table-layout: fixed;
    }

    .monthly-wrp td {
        padding: 1px;
    }

    .monthly-wrp table button {
        width: 100%;
        border: none;
        background-color: #92298D;
        color: #FFFFFF;
        font-size: 14px;
        padding: 0.6em;
        cursor: pointer;
        border-radius: 3px;
    }

    .monthly-wrp table button:hover {
        background-color: #8CC543;
    }

    .monthly-wrp table button:focus {
        outline: none;
    }


</style>

{{--<div>--}}

{{--    {!! Form::open(['route' => 'getvalue.date', 'method' => 'POST']) !!}--}}
{{--        <p style="display: inline">Start Date: <input type="date" name="start_date"></p>--}}
{{--        <p style="display: inline">End Date: <input type="date" name="end_date"></p>--}}
{{--        <button style="display: inline" type="submit" name="submit" value="submited" class="btn btn-primary">Submit--}}
{{--    </button>--}}

{{--    {!! Form::close() !!}--}}
{{--</div>--}}

<div class="row">
    <div class="col-lg-12">
        @php
            $last_updated=DB::table('last_update')
                ->where('id','1')
                ->first();

        @endphp
        <b>Last Updated:</b> {{\Carbon\Carbon::parse($last_updated->updated_at)->format('j F, Y h:i a') }}
        <a href="{{url('/checkupdate')}}"><button style="position:relative; float: right; margin-bottom: 5px" class="btn btn-warning btn-sm">Refresh</button></a>
    </div>
    <div class="card col-lg-12">
        <div class="card-header" style="text-align: center;">
            Onboarded Micro Merchant
        </div>
        <div class="card-body">
            <div class="row">
                <div class="table-responsive-lg col-lg-6 col-sm-12" width="100%">
                    <div style="background-color:#a09d90; color: white; padding: 3px 2px ">Select a month:</div>
                    <div class="form-group">
                        <input class="form-control" type="text" id="selection" value="March 2020">
                    </div>
                    <table class="table-striped table-height" width="100%">
                        <thead class="table-height">
                        <th class="table-height">
                            District
                        </th>
                        <th class="table-height">Tangail</th>
                        <th class="table-height">Sirajganj</th>
                        <th class="table-height">Jamalpur</th>
                        <th class="table-height">Sherpur</th>
                        </thead>
                        <tbody class="table-height">
                        <tr class="table-height">
                            <td class="table-height">Target</td>
                            <td class="table-height">30</td>
                            <td class="table-height">20</td>
                            <td class="table-height">0</td>
                            <td class="table-height">0</td>
                        </tr>
                        <tr class="table-height">
                            <td class="table-height">Achieved</td>
                            <td class="table-height" id="tangailTar">{{$districtTarget[0]}}</td>
                            <td class="table-height" id="sirajgonjTar">{{$districtTarget[1]}}</td>
                            <td class="table-height">0</td>
                            <td class="table-height">0</td>
                        </tr>
                        </tbody>

                    </table>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="barChartContainer" >
                        <canvas id="barChart" width="600" height="350" style=" display: inline" ></canvas>
                        <canvas id="ChangedBarChart" width="600" height="350" style="display:none"></canvas>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <br>


    <div class="card col-lg-12">
        <div class="card-header" style="text-align: center">
            Merchants and Transactions
        </div>
        <div class="card-body s1c">
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <table id="table-mm" class="table-striped" width="100%">
                        <tr class="table-height">
                            <td colspan="5"
                                style="font-weight: bold; text-align: center">
                                Micro Merchant List
                            </td>
                        </tr>
                        <th class="table-height" width="40%">Name</th>
                        <th class="table-height" width="40%">Contact Number</th>
                        <th class="table-height" width="20%">District</th>


                        <tbody>
                        @foreach($getAllEkshopUsers as $ekShopLive)
                            <tr class="table-height">
                                <td>
                                    <button class="ekshop_purchase"
                                            data-id="{{$ekShopLive->id}}">{{$ekShopLive->name_en}}</button>
                                </td>
                                <td>{{$ekShopLive->contact_number}}</td>
                                <td>{{$ekShopLive->district}}</td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                    {{--    <div style="position:relative; float:right">
                            <br>
                            @if (count($getAllEkshopUsers)>9)
                                {{$getAllEkshopUsers->links()}}
                            @endif

                        </div>--}}
                </div>

                <div class="col-lg-6 col-sm-12">

                    <table class="table-striped" width="100%" id="myTable">
                        <tr class="table-height">
                            <td colspan="2" id="infoName"
                                style="font-weight: bold; padding-left: 8px">
                                Latest Transaction
                            </td>
                            <td style=""></td>
                            <td colspan="2"
                                style="padding-right: 8px; font-weight: bold; text-align: right">
                                All Data
                            </td>
                        </tr>

                        <th class="table-height">Order ID</th>
                        <th class="table-height">Price</th>
                        <th class="table-height">Quantity</th>
                        <th class="table-height">TX Amount</th>
                        <th class="table-height">Date</th>


                        <tbody>
                        @foreach($getAllEkshopUserOrders as $ekShopLive)
                            <tr class="table-height">
                                <td>{{$ekShopLive->order_code}}
                                <td>{{$ekShopLive->total_price}}</td>
                                <td>{{$ekShopLive->payment_method}}</td>
                                <td>{{$ekShopLive->total_quantity}}</td>
                                <td>{{date('d-M-y', strtotime($ekShopLive->created_at))}}</td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-sm-12">
        <div class="card" style="border:1px solid #adb5bd; margin-top: 20px;">
            <div class="card-header" style="text-align: center;">
                Quick Overview
            </div>
            <div class="card-body">
                <table width="100%" class="table-striped" style="margin-left: 15px; padding:2px 2px ">
                    <tr class="table-height">
                        <td style="width: 80%">Total Micro Merchend</td>
                        <td id="total_mm">{{$getAllEkshopUsersCount}}</td>
                    </tr>
                    <tr class="table-height">
                        <td style="width: 80%">Total Active Micro Merchend</td>
                        <td id="active_mm">{{$getEkshopActiveUsersCount}}</td>
                    </tr>
                    <tr class="table-height">
                        <td style="width: 80%">Total Active Micro Merchend(%)</td>
                        <td id="active_percentage">{{$activeUserInPercentage}}%</td>
                        <td id="inactive_percentage" style="visibility: hidden"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-12">
        <div id="chart5" class="ct-chart ct-major-tenth"></div>
    </div>
    <br>
    <hr>
    <br>

    <div class="row district col-lg-12">
        <div class="col-lg-3 col-sm-12">
            <div class="">
                <table class="table-active" width="100%">
                    <tr>
                        <td class="td-district" colspan="3" style="">Tangail</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>Active</td>
                        <td>Active(%)</td>
                    </tr>
                    <tr>
                        <td>{{$getAllTangailUsersCount}}</td>
                        <td>{{$tangailActiveUsers}}</td>
                        <td id="tangail_active_percentage">{{$tangailActiveUserPercent}}%</td>
                    </tr>
                </table>
            </div>
            <div id="chart6" class="ct-chart ct-major-tenth">
            </div>
        </div>
        <div class="col-lg-3 col-sm-12">
            <table class="table-active" width="100%">
                <tr>
                    <td class="td-district" colspan="3">Sirajganj</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>Active</td>
                    <td>Active(%)</td>
                </tr>
                <tr>
                    <td>{{$sirajganjUsersCount}}</td>
                    <td>{{$sirajganjActiveUsersCount}}</td>
                    <td id="sirajgonj_active_percentage">{{$sirajganjActiveUserPercent}}%</td>
                    <td id="sirajgonj_inactive_percentage"
                        style="visibility: hidden"></td>
                </tr>
            </table>
            <div id="chart7" class="ct-chart ct-major-tenth"></div>
        </div>
        <div class="col-lg-3 col-sm-12">
            <table class="table-active" width="100%">
                <tr>
                    <td class="td-district" colspan="3">Jamalpur</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>Active</td>
                    <td>Active(%)</td>
                </tr>
                <tr>
                    <td>0</td>
                    <td>0</td>
                    <td>0%</td>
                </tr>
            </table>

            <div id="chart8" class="ct-chart ct-major-tenth"></div>
        </div>
        <div class="col-lg-3 col-sm-12">
            <table class="table-active" width="100%">
                <tr>
                    <td class="td-district" colspan="3">Sherpur</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>Active</td>
                    <td>Active(%)</td>
                </tr>
                <tr>
                    <td>0</td>
                    <td>0</td>
                    <td>0%</td>
                </tr>
            </table>
            <div id="chart9" class="ct-chart ct-major-tenth"></div>
        </div>
    </div>
    <br>
    <hr>
    <div class="col-lg-12">
        <div class="card" style="border:1px solid #adb5bd; margin-top: 20px;">
            <div class="card-header" style="text-align: center">
                Transaction Overview
            </div>
            <div class="card-body">
                <div style="width:100%">
                    <canvas id="linechart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card" style="border:1px solid #adb5bd; margin-top: 20px;">
            <div class="card-header" style="text-align: center">
                Transaction Comparison
                <br>
                <div class="small">(Total no of transactions and total transacting amount)</div>
            </div>
            <div class="card-body">
                <div style="width:100%">
                    <canvas id="linechart2"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card" style="border:1px solid #adb5bd; margin-top: 20px;">
            <div class="card-header" style="text-align: center">
                 Average Transaction
            </div>
            <div class="card-body">
                <div style="width:100%">
                    <canvas id="linechart3"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div>

    </div>
</div>


<script>

    $(document).ready(function () {
        var active_percentage = @json($activeUserInPercentage);
        var inactive_percentage = 100 - active_percentage;
        var data1 = {
            labels: ['Active MM', 'Inactive MM'],
            series: [{value: active_percentage, className: "s1c"}, {value: inactive_percentage, className: "s2c"}]
        };
        var options2 = {
            donut: false,
        }
        new Chartist.Pie('#chart5', data1, options2);
    })
    $(document).ready(function () {
        var tangail_active_percentage = @json($tangailActiveUserPercent);
        var tangail_inactive_percentage = 100 - tangail_active_percentage;

        var data1 = {
            labels: ['Active MM', 'Inactive MM'],
            series: [{value: tangail_active_percentage, className: "s1c"}, {
                value: tangail_inactive_percentage,
                className: "s2c"
            }]
        };

        var options2 = {
            donut: false
        }
        new Chartist.Pie('#chart6', data1, options2);

    })
    $(document).ready(function () {
        var sirajgonj_active_percentage = @json($sirajganjActiveUserPercent);
        var sirajgonj_inactive_percentage = @json($sirajganjInactiveUserPercent);

        var data1 = {
            labels: ['Active MM', 'Inactive MM'],
            series: [{
                value: sirajgonj_active_percentage,
                className: "s1c"
            }, {value: sirajgonj_inactive_percentage, className: "s2c"}]

            /*labels: ['Active MM ' + active_percentage + '%', 'Inactive MM ' + inactive_percentage + '%'],
            series: [active_percentage, inactive_percentage]*/
        };
        //new Chartist.Pie('#chart5', data1);

        var options2 = {
            donut: false
        }
        new Chartist.Pie('#chart7', data1, options2);

    })
    $(document).ready(function () {
        var active_percentage = document.getElementById("active_percentage").innerHTML;
        var inactive_percentage = document.getElementById("inactive_percentage").innerHTML;

        var data1 = {
            labels: ['Active MM', 'Inactive MM'],
            series: [{value: 100, className: "none"}, {value: 0, className: "slice2Color"}]

        };
        //new Chartist.Pie('#chart5', data1);

        var options2 = {
            donut: false
        }
        new Chartist.Pie('#chart8', data1, options2);

    })
    $(document).ready(function () {
        var active_percentage = document.getElementById("active_percentage").innerHTML;
        var inactive_percentage = document.getElementById("inactive_percentage").innerHTML;

        var data1 = {
            labels: ['Active MM', 'Inactive MM'],
            series: [{value: 100, className: "none"}, {value: 0, className: "slice2Color"}]

        };
        //new Chartist.Pie('#chart5', data1);

        var options2 = {
            donut: false
        }
        new Chartist.Pie('#chart9', data1, options2);

    })

    /*line chart 1 starts*/
    $(document).ready(function () {
        var date_format = @json($totalNumTransByDate);
        var date_ekshop = @json($trans_latest_last7);
        var total_trans = @json($totalAmountByDate);
        console.log(total_trans);

            {{--var total_trans = @json($trans_latest_count);--}}
            {{--var transamount = @json($trans_amount);--}}
            {{--var transuccess = @json($trans_successful_count);--}}
        var canvas = document.getElementById("linechart");
        console.log(date_ekshop);
        new Chart(canvas, {
            type: "line",
            data: {
                labels: date_ekshop,
                datasets: [
                    {
                        label: "Total No of Transaction",
                        yAxisID: "A",
                        data: date_format,
                        backgroundColor: [
                            'rgba(153, 102, 255, 0.2)',

                        ],
                        borderColor: [
                            'rgba(153, 102, 255,1)',
                        ],
                        borderWidth: 1
                    },
                    {
                        label: "Total Amount of Transaction ",
                        yAxisID: "B",
                        data: total_trans,
                        backgroundColor: [
                            'rgba(255,75,0, 0.2)',
                        ],
                        borderColor: [
                            'rgb(255,75, 0)',
                        ],
                        borderWidth: 1
                    },
                    /*{
                        label: "Total Successfull Transaction",
                        hidden: true,
                        yAxisID: "A",
                        data: [15,60,24],
                        backgroundColor: [
                            'rgba(255,31,9, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(78,18,192, 0.2)',
                            'rgba(6,255,30, 0.2)',
                            'rgba(246,255,39, 0.2)'
                        ],
                        borderColor: [
                            'rgb(6,255,30)',

                        ],
                        borderWidth: 1
                    }*/
                ]
            },
            options: {
                scales: {
                    yAxes: [
                        {
                            id: "A",
                            type: "linear",
                            position: "left",
                            scaleLabel: {
                                display: true,
                                labelString: "Number"
                            },
                            ticks: {
                                max: 100,
                                min: 0
                            }
                        },

                        {
                            id: "B",
                            type: "linear",
                            position: "right",
                            scaleLabel: {
                                display: true,
                                labelString: "Amount"
                            },
                            ticks: {
                                max: 10000,
                                min: 100
                            }
                        }
                    ]
                }
            }
        });
    })
    /*line chart 1 starts*/
    /*line chart 2 starts*/
    $(document).ready(function () {
        var date_format = @json($trans_latest_last7);
        var sir_total_last7 = @json($totalAmountInSirajgonj);
        var tan_total_last7_count = @json($totalNumTransInTangail);
        var sir_total_last7_count = @json($totalNumTransinSirajgonj);
        var tan_total_last7 = @json($totalAmountInTangail);
        //console.log(tan_total_last7);
        var canvas = document.getElementById("linechart2");
        new Chart(canvas, {
            type: "line",
            data: {
                labels: date_format,
                datasets: [
                    {
                        label: "Total TX (Tangail)",
                        yAxisID: "A",
                        data: tan_total_last7_count,
                        borderColor: [
                            'rgba(153, 102, 255,1)',
                        ],
                        fill: false,
                        borderWidth: 2
                    },
                    {
                        label: "Total TX (Sirajganj)",
                        yAxisID: "A",
                        data: sir_total_last7_count,
                        borderColor: [
                            'rgb(6,255,30)',
                        ],
                        fill: false,
                        borderWidth: 2
                    },
                    {
                        label: "Total TX Amount (Tangail)",
                        yAxisID: "B",
                        data: tan_total_last7,
                        borderColor: [
                            'rgb(255,75, 0)',
                        ],
                        fill: false,
                        borderWidth: 2
                    },
                    {
                        label: "Total TX Amount (Sirajganj)",
                        yAxisID: "B",
                        data: sir_total_last7,
                        borderColor: [
                            'rgb(255,247,16)',
                        ],
                        fill: false,
                        borderWidth: 2
                    },
                ]
            },
            options: {
                scales: {
                    yAxes: [
                        {
                            id: "A",
                            type: "linear",
                            position: "left",
                            scaleLabel: {
                                display: true,
                                labelString: "Count"
                            },
                            ticks: {
                                max: 100,
                                min: 0
                            }
                        },
                        {
                            id: "B",
                            type: "linear",
                            position: "right",
                            scaleLabel: {
                                display: true,
                                labelString: "Amount"
                            },
                            ticks: {
                                max: 10000,
                                min: 0
                            }
                        }
                    ]
                },
                legend: {
                    display: true,
                    labels: {
                        fontColor: 'rgb(87,0,71)'
                    }
                }
            }

        });

    })
    /*line chart 2 end*/
    /*line chart 3 starts*/
    $(document).ready(function () {
        var date_format = @json($trans_latest_last7);
        var tan_total_last7_avg = @json($averageAmountInTangail);
        var sir_total_last7_avg = @json($averageAmountInSirajgonj);
        //console.log(tan_total_last7_avg);
        var canvas = document.getElementById("linechart3");
        new Chart(canvas, {
            type: "line",
            data: {
                labels: date_format,
                datasets: [
                    {
                        label: "Tangail",
                        yAxisID: "A",
                        data: tan_total_last7_avg,
                        borderColor: [
                            'rgba(153, 102, 255,1)',
                        ],
                        fill: false,
                        borderWidth: 2
                    },
                    {
                        label: "Sirajganj",
                        yAxisID: "A",
                        data: sir_total_last7_avg,
                        borderColor: [
                            'rgb(6,255,30)',
                        ],
                        fill: false,
                        borderWidth: 2
                    },
                ]
            },
            options: {
                scales: {
                    yAxes: [
                        {
                            id: "A",
                            type: "linear",
                            position: "left",
                            scaleLabel: {
                                display: true,
                                labelString: "Count"
                            },
                            ticks: {
                                max: 10000,
                                min: 0
                            }
                        }
                    ]
                },
                legend: {
                    display: true,
                    labels: {
                        fontColor: 'rgb(87,0,71)'
                    }
                }
            }
        })
    });

    /*line chart 3 end*/
    $(document).on('click', 'button[data-id]', function (e) {
        var centerID = $(this).attr('data-id');
        //console.log(centerID);
        if (centerID) {
            jQuery.ajax({
                url: 'home/getxbyid/' + centerID,
                type: "GET",
                dataType: "json",
                success: function (data) {

                    var table = document.getElementById("myTable");
                    $("#myTable").find("tr:gt(1)").remove();
                    jQuery.each(data, function (key, value) {
                        $("#infoName").text(value.name_en);
                        var d = value.created_at;
                        var str = d.split(' ')[0];
                        var row = table.insertRow(2);
                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        var cell3 = row.insertCell(2);
                        var cell4 = row.insertCell(3);
                        var cell5 = row.insertCell(4);
                        cell1.innerHTML = value.order_code;
                        cell2.innerHTML = value.total_price;
                        cell3.innerHTML = value.total_quantity;
                        cell4.innerHTML = value.payment_method;
                        cell5.innerHTML = str;

                    });
                }
            });
        }

    });
    $(document).ready(function () {
        var target= @json($districtTarget);
        //console.log(target[0]);
        var barChartData = {
            "series": ["Achived", "Target"],
            "labels": [
                "Tangail", "Sirajganj", "Jamalpur", "Sherpur"
            ],
            "data": [
                [target[0], target[1], 0, 0],
                [30, 20, 0, 0]
            ]
        };

        var stackedBarChartData = {
            labels: barChartData.labels,
            datasets: [{
                label: barChartData.series[0],
                backgroundColor: "rgb(146,41,141,0.8)",
                borderColor: "rgb(146,41,141,1)",
                data: barChartData.data[0]
            }]
        };

        stackedBarChartData.datasets.push({
            label: barChartData.series[1],
            backgroundColor: "rgb(140,197,67,0.9)",
            borderColor: "rgb(140,197,67,1)",
            data: barChartData.data[1]
        });


        var configBarChart = {
            type: 'bar',
            data: stackedBarChartData,
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    mode: 'label',
                    bodySpacing: 6,
                    titleMarginBottom: 10,
                    footerMarginTop: 8,
                    titleFontSize: 14,
                    bodyFontSize: 14,
                    footerFontSize: 14,
                    callbacks: {
                        footer: function (tooltipItem /*, data*/) {
                            var total = 0;
                            tooltipItem.forEach(function (element /*, index, array*/) {
                                total += element.yLabel;
                            });
                           // return 'Total: ' + total;
                        }
                    }
                },
                scales: {
                    xAxes: [{
                        stacked: true,
                        ticks: {
                            maxRotation: 60,
                            autoSkip: false
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, 0.06)",
                            zeroLineColor: "rgba(0,0,0,0.1)"
                        }
                    }],
                    yAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "rgba(0, 0, 0, 0.06)",
                            zeroLineColor: "rgba(0,0,0,0.1)"
                        }
                    }]
                },
                legend: {
                    display: true
                }
            }
        };

        var ctxBarChart = document.getElementById("barChart").getContext("2d");
        new Chart(ctxBarChart, configBarChart);

    })
    $(document).ready(function () {
        function padToTwo(number) {
            if (number <= 9999) {
                number = ("0" + number).slice(-2);
            }
            return number;
        }

        (function ($) {
            $.fn.monthly = function (options) {
                var months = options.months || [
                        "January",
                        "February",
                        "March",
                        "April",
                        "May",
                        "June",
                        "July",
                        "August",
                        "September",
                        "October",
                        "November",
                        "December"
                    ],
                    Monthly = function (el) {
                        this._el = $(el);
                        this._init();
                        this._render();
                        this._renderYears();
                        this._renderMonths();
                        this._bind();
                    };

                Monthly.prototype = {
                    _init: function () {
                        this._el.html(months[0] + " " + options.years[0]);
                    },

                    _render: function () {
                        var linkPosition = this._el.offset(),
                            cssOptions = {
                                display: "none",
                                position: "absolute",
                                top:
                                    linkPosition.top + this._el.height() + (options.topOffset || 0),
                                left: linkPosition.left
                            };
                        this._container = $('<div class="monthly-wrp">')
                            .css(cssOptions)
                            .appendTo($("body"));
                    },

                    _bind: function () {
                        var self = this;
                        this._el.on("click", $.proxy(this._show, this));
                        $(document).on("click", $.proxy(this._hide, this));
                        this._yearsSelect.on("click", function (e) {
                            e.stopPropagation();
                        });
                        this._container.on("click", "button", $.proxy(this._selectMonth, this));
                    },

                    _show: function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        this._container.css("display", "inline-block");
                    },

                    _hide: function () {
                        this._container.css("display", "none");
                    },

                    _selectMonth: function (e) {
                        var monthIndex = $(e.target).data("value"),
                            month = months[monthIndex],
                            year = this._yearsSelect.val();
                        this._el.html(month + " " + year);
                        if (options.onMonthSelect) {
                            options.onMonthSelect(monthIndex, month, year);
                        }
                    },

                    _renderYears: function () {
                        var markup = $.map(options.years, function (year) {
                            return "<option>" + year + "</option>";
                        });
                        var yearsWrap = $('<div class="years">').appendTo(this._container);
                        this._yearsSelect = $("<select>")
                            .html(markup.join(""))
                            .appendTo(yearsWrap);
                    },

                    _renderMonths: function () {
                        var markup = ["<table>", "<tr>"];
                        $.each(months, function (i, month) {
                            if (i > 0 && i % 4 === 0) {
                                markup.push("</tr>");
                                markup.push("<tr>");
                            }
                            markup.push(
                                '<td><button data-value="' + i + '">' + month + "</button></td>"
                            );
                        });
                        markup.push("</tr>");
                        markup.push("</table>");
                        this._container.append(markup.join(""));
                    }
                };

                return this.each(function () {
                    return new Monthly(this);
                });
            };
        })(jQuery);

        $(function () {
            $("#selection").monthly({
                years: [2020],
                topOffset: 28,
                onMonthSelect: function (mi, m, y) {
                    var month = mi + 1;
                    mi = padToTwo(month);
                    var yearMonth = y + '-' + mi;
                    console.log(yearMonth);
                    if (yearMonth) {
                        jQuery.ajax({
                            url: 'home/getTargetByDate/' + yearMonth,
                            type: "GET",
                            dataType: "json",
                            success: function (data) {

                                console.log(yearMonth);

                                jQuery.each(data, function (key, value) {

                                    if(key==1){
                                        $("#sirajgonjTar").html(value);
                                    }
                                    if(key==0){
                                        $("#tangailTar").html(value);
                                    }

                                })

                                //console.log(data[0]);
                                $("#ChangedBarChart").css({
                                    "display": "inline"
                                });
                                $("#barChart").css({
                                    "display": "none"
                                });


                                var barChartData = {
                                    "series": ["Achived", "Target"],
                                    "labels": [
                                        "Tangail", "Sirajganj", "Jamalpur", "Sherpur"
                                    ],
                                    "data": [
                                        [data[0], data[1], 0, 0],
                                        [30, 20, 0, 0],

                                    ]
                                };

                                var stackedBarChartData = {
                                    labels: barChartData.labels,
                                    datasets: [{
                                        label: barChartData.series[0],
                                        backgroundColor: "rgb(146,41,141,0.8)",
                                        borderColor: "rgb(146,41,141,1)",
                                        data: barChartData.data[0]
                                    }]
                                };

                                stackedBarChartData.datasets.push({
                                    label: barChartData.series[1],
                                    backgroundColor: "rgb(140,197,67,0.9)",
                                    borderColor: "rgb(140,197,67,1)",
                                    data: barChartData.data[1]
                                });


                                var configBarChart = {
                                    type: 'bar',
                                    data: stackedBarChartData,
                                    options: {
                                        maintainAspectRatio: false,
                                        tooltips: {
                                            mode: 'label',
                                            bodySpacing: 6,
                                            titleMarginBottom: 10,
                                            footerMarginTop: 8,
                                            titleFontSize: 14,
                                            bodyFontSize: 14,
                                            footerFontSize: 14,

                                        },
                                        scales: {
                                            xAxes: [{
                                                stacked: true,
                                                ticks: {
                                                    maxRotation: 60,
                                                    autoSkip: false
                                                },
                                                gridLines: {
                                                    color: "rgba(0, 0, 0, 0.06)",
                                                    zeroLineColor: "rgba(0,0,0,0.1)"
                                                }
                                            }],
                                            yAxes: [{
                                                stacked: true,
                                                gridLines: {
                                                    color: "rgba(0, 0, 0, 0.06)",
                                                    zeroLineColor: "rgba(0,0,0,0.1)"
                                                }
                                            }]
                                        },
                                        legend: {
                                            display: true
                                        }
                                    }
                                };

                                var ctxBarChart = document.getElementById("ChangedBarChart").getContext("2d");
                                new Chart(ctxBarChart, configBarChart);
                            }
                        })

                    }
                }
            })

        })
    });
</script>

<script>

    $(document).ready(function () {
        $('#table-mm').DataTable();
    });

</script>






