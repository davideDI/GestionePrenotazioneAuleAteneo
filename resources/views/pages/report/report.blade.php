@extends('layouts.layout')
    @section('content')
    
        <div class="row">
            <div class="col-md-12">
                <legend>{{ trans('messages.report_title') }}</legend>
            </div>
        </div>
    
        <div class="row">
            
            <!-- Graphs 1 -->
            <div class="col-md-6" id="testCanvas" style="width: 45%; height: 400px;display: inline-block;">
                
                
            </div>
            
            <!-- Graphs 2 -->
            <div class="col-md-6" id="testCanvas2" style="width: 45%; height: 400px;display: inline-block;">
                
                
            </div>
            
        </div>
    
        <div class="row">
            
            <!-- Graphs 1 -->
            <div class="col-md-6" id="testCanvas3" style="width: 45%; height: 400px;display: inline-block;">
                
                
            </div>
            
            <!-- Graphs 2 -->
            <div class="col-md-6" id="testCanvas4" style="width: 45%; height: 400px;display: inline-block;">
                
                
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
                                        { y: {{$surveyStatus1}}, exploded: true, legendText: "{{ trans('messages.report_checked') }}", indexLabel: "{{ trans('messages.report_checked') }}" },
                                        { y: {{$surveyStatus1}}, legendText: "{{ trans('messages.report_unchecked') }}", indexLabel: "{{ trans('messages.report_unchecked') }}" },
                                ]
                            }
                        ]
                    };
                $("#testCanvas").CanvasJSChart(options);
                        
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
                    $("#testCanvas2").CanvasJSChart(options2);
                        
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
						{ y: 4181, legendText: "PS 3", indexLabel: "PlayStation 3" },
						{ y: 2175, legendText: "Wii", indexLabel: "Wii" },
						{ y: 3125, legendText: "360", exploded: true, indexLabel: "Xbox 360" },
						{ y: 1176, legendText: "DS", indexLabel: "Nintendo DS" },
						{ y: 1727, legendText: "PSP", indexLabel: "PSP" },
						{ y: 4303, legendText: "3DS", indexLabel: "Nintendo 3DS" },
						{ y: 1717, legendText: "Vita", indexLabel: "PS Vita" }
					]
				}
				]
			};
                        $("#testCanvas3").CanvasJSChart(options3);
                        
                        var options4 = {
				title: {
					text: "{{ trans('messages.report_title4') }}"
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
						{ y: 4181, legendText: "PS 3", indexLabel: "PlayStation 3" },
						{ y: 2175, legendText: "Wii", indexLabel: "Wii" },
						{ y: 3125, legendText: "360", exploded: true, indexLabel: "Xbox 360" },
						{ y: 1176, legendText: "DS", indexLabel: "Nintendo DS" },
						{ y: 1727, legendText: "PSP", indexLabel: "PSP" },
						{ y: 4303, legendText: "3DS", indexLabel: "Nintendo 3DS" },
						{ y: 1717, legendText: "Vita", indexLabel: "PS Vita" }
					]
				}
				]
			};
                        $("#testCanvas4").CanvasJSChart(options4);
		});


        </script>
    
    @endsection