@extends('layouts.app')

@section('css')

@endsection

@section('script')

    <script type="text/javascript">
        $(document).ready(function() {
            $(document.body).on('click', '#export_graph', function() {
                printContent('print-graph', 'table-code');
            });

            function printContent(el, el2){
                var restorepage = document.body.innerHTML;
                var printcontent = document.getElementById(el).innerHTML;
                var printcontent2 = document.getElementById(el2).innerHTML;
                document.body.innerHTML = printcontent + printcontent2;
                window.print();
                document.body.innerHTML = restorepage;
            }
        });

        function exportReport() {
            $('.loader').show();
            year = '<?php echo $year; ?>';

            $.ajax({
                method: "POST",
                url: "<?php echo url('staff/searchReport/exportRecordCount'); ?>",
                data: {
                    _token: "{{ csrf_token() }}",
                    year: year
                }
            }).done(function( data ) {
                if ( data ) {
                    window.location.href = '<?php echo url('export_result_record') ?>'+ '/' + data;

                    // // delete file
                    // $.ajax({
                    //     method: "POST",
                    //     url: "<?php //echo url('deleteFileForExcelRecord'); ?>",
                    //     data: {
                    //         name_file: data
                    //     }
                    // });
                }
                $('.loader').hide();
            });
        }
    </script>

@endsection

@section('header')
    <?php
        $headerName = "Search Report";
        $iconFileName = "icon_search_report.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Search Report'] = url('staff/searchReport/dashboard');
        $breadcump['Record Count Chart'] = url('staff/searchReport/taxonomy');
    ?>
@endsection

@section('contain')

    <div class="row row-with-margin">
        <div class="col-md-6 col-md-offset-3">
            <div class="content-box">
                <p class="content-header">Record Count Over a Year</p>
                <p class="content-help-text">The count is based on the collector date.</p>
                <form class="form-inline" method="POST" action="{{ url('staff/searchReport/record_count_chart') }}">
                    @csrf
                    <div class="form-group">
                        <label class="sr-only">Enter Year Label</label>
                        <p class="form-control-static">Enter Year (Ex.2016)</p>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="year">Year</label>
                        <input type="text" class="form-control input-gold" id="year" name="year" minlength="4" maxlength="4" size="4" placeholder="0000" required>
                    </div>
                    <button type="submit" class="btn btn-default btn-gold btn-last">Generate Chart</button>
                </form>
            </div>
        </div>
    </div>

    @if(!empty($data))
    <div id="print-graph">
        <div class="row">
            <div class="col-md-12">
                <p class="content-header" align="center">Record Count Chart</p>
                <p class="content-help-text" align="center">Chart of record in @if(!empty($year)) {{ $year }} @else - @endif</p>
            </div>
        </div>

        <div class="row row-with-margin">
            <div class="col-md-8 col-md-offset-2">
                <div class="chart-box">
                    <div id="top_x_div" style="width: 100%; height: 500px;"></div> <!-- 900*450 style="width: 100%; height: 40vw;" -->
                </div>
            </div>
        </div>
    </div>

        <div id="table-code" style="display: none;">
            <!-- <table class="table table-stripped" style="margin-top: 20px;">
                <tr>
                    <td>Months</td>
                    @foreach ($data as $key => $month)
                        @if ( $key !== 0 ) <td>{{ $month[0] }}</td> @endif
                    @endforeach
                </tr>
                <tr>
                    <td>Density</td>
                    @foreach ($data as $key => $density)
                        @if ( $key !== 0 ) <td>{{ $density[1] }}</td> @endif
                    @endforeach
                </tr>
            </table> -->
            <p style="font-size: 14px; margin-top: 5px; margin-bottom: 5px;">* Search Report Type: Record count over a year by collector date.</p>
            <table class="table table-bordered" style="width: 250px;">
                <tr>
                    <th style="width: 100px;">Months</th>
                    <th style="text-align: right;">Density</th>
                </tr>
                <?php $sum = 0; ?>
                @foreach ($data as $key => $get)
                    @if ( $key !== 0 ) <tr><td>{{ $get[0] }}</td><td style="text-align: right;">{{ $get[1] }}</td></tr> <?php $sum += $get[1]; ?> @endif
                @endforeach
                <!-- <tr>
                    <th>Total</th>
                    <th style="text-align: right;">{{ $sum }}</th>
                </tr> -->
            </table>

        </div>

        <div class="row">
            <div class="col-md-12 div-col-centered">
                <button class="btn btn-default btn-gold btn-before" id="export_graph">Export Graph</button>
                <button type="button" class="btn btn-default btn-gold" onclick="exportReport();">View Export</button>
            </div>
        </div>


        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <script type="text/javascript">
            var countData = <?php echo json_encode($data); ?>;

            // console.log(countData);
            google.charts.load('current', {'packages':['bar']});
            google.charts.setOnLoadCallback(drawStuff);

            function drawStuff() {
                var data = new google.visualization.arrayToDataTable(countData);

                var options = {
                    // title: "TAXONOMY COUNT CHART",
                    // chart: { subtitle: 'Chart taxonomy in 1987' },
                    // width: 900,
                    isStacked: true,
                    hAxis: {title: 'Year', titleTextStyle: {color: '#636363'}},
                    colors: ['#85ccff','green'],
                    legend: { position: 'none' },
                    axes: {
                        x: {
                            0: { side: 'bottom', label: 'Month'},
                        },
                        y: {
                            0: { side: 'left', label: 'Quantity'},
                        }
                    },
                    bar: { groupWidth: "50%" }
                };

                var chart = new google.charts.Bar(document.getElementById('top_x_div'));
                // Convert the Classic options to Material options.
                chart.draw(data, google.charts.Bar.convertOptions(options));
            };
        </script>

    @endif

@endsection
