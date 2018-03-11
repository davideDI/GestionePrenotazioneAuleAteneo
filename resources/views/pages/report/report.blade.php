@extends('layouts.layout')
    @section('content')

        <div class="row">
            <div class="col-md-12">
                <legend>{{ trans('messages.report_title') }}</legend>
            </div>
        </div>

        <div class="row" style="margin-top: 80px">

            <!-- Graphs 1 -->
            <div class="col-md-4 col-sm-4 col-xs-4" style="width: 33%;">
                <canvas id="pie1"></canvas>
            </div>

            <!-- Graphs 2 -->
            <div class="col-md-4 col-sm-4 col-xs-4" style="width: 33%;">
                <canvas id="pie2"></canvas>
            </div>

            <!-- Graphs 3 -->
            <div class="col-md-4 col-sm-4 col-xs-4" style="width: 33%;">
                <canvas id="pie3"></canvas>
            </div>

        </div>

        <script>

            $(document).ready(function() {
                var pie1 = document.getElementById('pie1').getContext('2d');
                var pie2 = document.getElementById('pie2').getContext('2d');
                var pie3 = document.getElementById('pie3').getContext('2d');

                var chart = new Chart(pie1, {
                    type: 'doughnut',

                    data: {
                        labels: ["{{ trans('messages.report_bookings') }}", "{{ trans('messages.report_surveys') }}"],
                        datasets: [{
                            label: "{{ trans('messages.report_title1') }}",
                            backgroundColor:  ['#ccc',
                                               '#822627'],
                            data: [{{$numRepeats}}, {{$numSurveys}}],
                        }]
                    },

                    options: {
                      title: {
                          display: true,
                          text: "{{ trans('messages.report_title3') }}"
                      }
                    }

                });

                var chart = new Chart(pie2, {
                    type: 'doughnut',

                    data: {
                        labels: ["{{ trans('messages.report_checked') }}", "{{ trans('messages.report_unchecked') }}"],
                        datasets: [{
                            label: "{{ trans('messages.report_title1') }}",
                            backgroundColor:  ['#ccc',
                                               '#822627'],
                            data: [{{$surveyStatus2}}, {{$surveyStatus1}}],
                        }]
                    },

                    options: {
                      title: {
                          display: true,
                          text: "{{ trans('messages.report_title1') }}"
                      }
                    }

                });

                var chart = new Chart(pie3, {
                    type: 'doughnut',

                    data: {
                        labels: ["{{ trans('messages.report_real_use') }}", "{{ trans('messages.report_waste') }}"],
                        datasets: [{
                            label: "{{ trans('messages.report_title1') }}",
                            backgroundColor:  ['#ccc',
                                               '#822627'],
                            data: [{{$tot1}}, {{$tot2}}],
                        }]
                    },

                    options: {
                      title: {
                          display: true,
                          text: "{{ trans('messages.report_title2') }}"
                      }
                    }

                });

            });

        </script>

    @endsection
