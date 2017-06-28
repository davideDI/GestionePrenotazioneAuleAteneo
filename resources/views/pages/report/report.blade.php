@extends('layouts.layout')
    @section('content')
    
        <div class="row">
            <div class="col-md-12">
                <legend>{{ trans('messages.report_title') }}</legend>
            </div>
        </div>
    
        <div class="row">
            
            <!-- Graphs 1 -->
            <div class="col-md-6" id="pie1" style="width: 45%; height: 400px;display: inline-block;">
                
                
            </div>
            
            <!-- Graphs 2 -->
            <div class="col-md-6" id="pie2" style="width: 45%; height: 400px;display: inline-block;">
                
                
            </div>
            
        </div>
    
        <hr>
    
        <div class="row">
            
            <!-- Graphs 3 -->
            <div class="col-md-6" id="pie3" style="width: 45%; height: 400px;display: inline-block;">
                
                
            </div>
            
        </div>
    
        <script>

            $(document).ready(function() {
                var options = {
                    title: {
                            text: "{{ trans('messages.report_title1') }}"
                        },
                    animationEnabled: true,
                    legend: {
                            verticalAlign: "bottom",
                            horizontalAlign: "center"
                        },
                    data: [
                        {
                            type: "pie",
                            showInLegend: true,
                            toolTipContent: "{y} - <strong>#percent%</strong>",
                            dataPoints: [
                                    { y: {{$surveyStatus2}}, exploded: true, legendText: "{{ trans('messages.report_checked') }}", indexLabel: "{{ trans('messages.report_checked') }}" },
                                    { y: {{$surveyStatus1}}, legendText: "{{ trans('messages.report_unchecked') }}", indexLabel: "{{ trans('messages.report_unchecked') }}" },
                            ]
                        }
                    ]
                };
                $("#pie1").CanvasJSChart(options);
                    var options2 = {
                        title: {
                                text: "{{ trans('messages.report_title2') }}"
                            },
                        animationEnabled: true,
                        legend: {
                                verticalAlign: "bottom",
                                horizontalAlign: "center"
                            },
                        data: [
                                {
                                type: "pie",
                                showInLegend: true,
                                toolTipContent: "{y} - <strong>#percent%</strong>",
                                dataPoints: [
                                        { y: {{ $tot1 }}, exploded: true, legendText: "{{ trans('messages.report_real_use') }}", indexLabel: "{{ trans('messages.report_real_use') }}" },
                                        { y: {{ $tot2 }}, legendText: "{{ trans('messages.report_waste') }}", indexLabel: "{{ trans('messages.report_waste') }}" }
                                ]
                                }
                            ]
                    };
                    $("#pie2").CanvasJSChart(options2);
                        var options3 = {
                            title: {
                                    text: "{{ trans('messages.report_title3') }}"
                            },
                            animationEnabled: true,
                            legend: {
                                    verticalAlign: "bottom",
                                    horizontalAlign: "center"
                            },
                            data: [
                                {
                                    type: "pie",
                                    showInLegend: true,
                                    toolTipContent: "{y} - <strong>#percent%</strong>",
                                    dataPoints: [
                                            { y: {{ $numRepeats }}, legendText: "{{ trans('messages.report_bookings') }}", indexLabel: "{{ trans('messages.report_bookings') }}" },
                                            { y: {{ $numSurveys }}, exploded: true, legendText: "{{ trans('messages.report_surveys') }}", indexLabel: "{{ trans('messages.report_surveys') }}" }
                                    ]
                                }
                            ]
			};
                        $("#pie3").CanvasJSChart(options3);
                        
		});


        </script>
    
    @endsection