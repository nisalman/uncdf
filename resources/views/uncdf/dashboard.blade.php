

<style>

    .table-height {
        line-height: 55px;
    }

    .ct-label {
        font-size: 12px;
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
        fill: #0366a8;
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


    .s2c {
        fill: #c4be00;
    }
</style>

<div class="row">
    <div class="col-lg-6 col-sm-12">
        <div class="card" style="border:1px solid #adb5bd; margin-top: 20px;">
            <div class="card-header" style="text-align: center; background-color: #1d68a7; color: white">
                Quick Overview
            </div>
            <div class="card-body">
                <table width="100%" class="table-striped" style="margin-left: 15px; padding:2px 2px ">
                    {{--                    <tr >
                                            <td colspan="2">
                                                <select class="form-control " name="available-districts" id="" required="">
                                                    <option value="">-All-</option>
                                                    @foreach($av_districts as $district)
                                                        <option value="{{$district->id}}">{{$district->district_name}}</option>
                                                    @endforeach
                                                </select><br>
                                            </td>
                                        </tr>--}}
                    <tr class="table-height">
                        <td style="width: 80%">Total MM</td>
                        <td id="total_mm">{{$totalMm}}</td>
                    </tr>
                    <tr class="table-height">
                        <td style="width: 80%">Total Active MM</td>
                        <td id="active_mm">{{$activeMm}}</td>
                    </tr>
                    <tr class="table-height">
                        <td style="width: 80%">Total Active MM (%)</td>
                        <td id="active_percentage">{{$active_percentage}}</td>
                        <td id="inactive_percentage" style="visibility: hidden">{{$inactive_percentage}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-12">
        <div id="chart5" class="ct-chart ct-major-tenth"></div>
    </div>
</div>
<br>
<hr>

{{--view for district 1--}}
<div class="row district">
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
                    <td>{{$tangailTotal}}</td>
                    <td>{{$tangailActive}}</td>
                    <td id="tangail_active_percentage">{{$tangail_active_percentage}}</td>
                    <td id="tangail_inactive_percentage"
                        style="visibility: hidden">{{$tangail_inactive_percentage}}</td>
                </tr>
            </table>
        </div>
        <div id="chart6" class="ct-chart ct-major-tenth">
        </div>
    </div>
    <div class="col-lg-3 col-sm-12">
        <table class="table-active" width="100%">
            <tr>
                <td class="td-district" colspan="3">Sirajgonj</td>
            </tr>
            <tr>
                <td>Total</td>
                <td>Active</td>
                <td>Active(%)</td>
            </tr>
            <tr>
                <td>{{$sirajgonjTotal}}</td>
                <td>{{$sirajgonjActive}}</td>
                <td id="sirajgonj_active_percentage">{{$sirajgonj_active_percentage}}</td>
                <td id="sirajgonj_inactive_percentage"
                    style="visibility: hidden">{{$sirajgonj_inactive_percentage}}</td>
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
    <div style="text-align: center">
        <table border="1px solid black" >
            <tr>
                <td>Line chart</td>
            </tr>
        </table>
    </div>

    <div style="width:100%;">
        <canvas id="linechart"></canvas>
    </div>
</div>
<div>

</div>

<!-- Resources -->
<script>

    // dropdown changes value

    /* jQuery(document).ready(function () {
         jQuery('select[name="available-districts"]').on('change', function () {
             var districtID = jQuery(this).val();
             if (districtID) {
                 jQuery.ajax({
                     url: 'data/totalmm/' + districtID,
                     type: "GET",
                     dataType: "json",
                     success: function (data) {
                         console.log(data);
                         $('#total_mm').html(data.total);
                         $('#active_mm').html(data.active);
                         $('#avg_mm').html(data.average);
                         var low=100-data.average;
                         var data1 = {
                             /!*labels: ['Active MM', 'Inactive MM'],
                             series: [{value: 60, className: "slice1Color"}, {value: 40, className: "slice2Color"}]*!/


                             labels: ['Active MM '+ data.average +'%', 'Inactive MM '+ low +'%'],
                             series: [data.average, low]
                         };
                         //new Chartist.Pie('#chart5', data1);

                         var options2 = {
                             donut: true
                         }
                         new Chartist.Pie('#chart5', data1, options2);
                     }
                 });
             }
         });
     });*/

    $(document).ready(function () {
        var active_percentage = document.getElementById("active_percentage").innerHTML;
        var inactive_percentage = document.getElementById("inactive_percentage").innerHTML;

        var data1 = {
            labels: ['Active MM', 'Inactive MM'],
            series: [{value: active_percentage, className: "s1c"}, {value: inactive_percentage, className: "s2c"}]

            /*labels: ['Active MM ' + active_percentage + '%', 'Inactive MM ' + inactive_percentage + '%'],
            series: [active_percentage, inactive_percentage],
            colors:["#333", "#bfeeb6"]*/
        };
        //new Chartist.Pie('#chart5', data1);

        var options2 = {
            donut: false,

        }
        new Chartist.Pie('#chart5', data1, options2);

    })
    $(document).ready(function () {
        var tangail_active_percentage = document.getElementById("tangail_active_percentage").innerHTML;
        var tangail_inactive_percentage = document.getElementById("tangail_inactive_percentage").innerHTML;

        var data1 = {
            labels: ['Active MM', 'Inactive MM'],
            series: [{value: tangail_active_percentage, className: "tan-active"}, {
                value: tangail_inactive_percentage,
                className: "tan-inactive"
            }]

            // labels: ['Active MM ' + active_percentage + '%', 'Inactive MM ' + inactive_percentage + '%'],
            // series: [active_percentage, inactive_percentage]
        };
        //new Chartist.Pie('#chart5', data1);

        var options2 = {
            donut: false
        }
        new Chartist.Pie('#chart6', data1, options2);

    })
    $(document).ready(function () {
        var sirajgonj_active_percentage = document.getElementById("sirajgonj_active_percentage").innerHTML;
        var sirajgonj_inactive_percentage = document.getElementById("sirajgonj_inactive_percentage").innerHTML;

        var data1 = {
            labels: ['Active MM', 'Inactive MM'],
            series: [{
                value: sirajgonj_active_percentage,
                className: "tan-active"
            }, {value: sirajgonj_inactive_percentage, className: "tan-inactive"}]

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

    $(document).ready(function () {
        var date_format = @json($trans_form_date);
        var total_trans = @json($trans_total_count);
        var transamount = @json($trans_amount);
        var transuccess = @json($trans_successful_count);
        console.log(transuccess);
        var canvas = document.getElementById("linechart");
        new Chart(canvas, {
            type: "line",
            data: {
                labels: date_format.reverse(),
                datasets: [
                    {
                        label: "Total Transaction",
                        yAxisID: "A",
                        data: total_trans.reverse(),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255,15,227, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgb(255,15,227)'
                        ],
                        borderWidth: 1
                    },
                    {
                        label: "Total Amount of Transaction ",
                        yAxisID: "B",
                        data: transamount.reverse(),
                        backgroundColor: [
                            'rgba(133,255,121, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(78,18,192, 0.2)',
                            'rgba(255,75,0, 0.2)',
                            'rgba(255,251,198, 0.2)'
                        ],
                        borderColor: [
                            'rgb(133,255,121)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgb(78,18,192)',
                            'rgb(255,75,0)',
                            'rgb(255,251,198)'
                        ],
                        borderWidth: 1
                    },
                    {
                        label: "Total Successfull Transaction",
                        yAxisID: "A",
                        data: transuccess.reverse(),
                        backgroundColor: [
                            'rgba(255,31,9, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(78,18,192, 0.2)',
                            'rgba(6,255,30, 0.2)',
                            'rgba(246,255,39, 0.2)'
                        ],
                        borderColor: [
                            'rgb(255,31,9)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgb(78,18,192)',
                            'rgb(6,255,30)',
                            'rgb(246,255,39)'
                        ],
                        borderWidth: 1
                    }
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
                                max: 20000,
                                min: 1000
                            }
                        }
                    ]
                }
            }
        });
    })

</script>








