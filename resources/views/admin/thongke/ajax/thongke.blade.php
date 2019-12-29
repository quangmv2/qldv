<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="{{ asset('assets/js/chart.js') }}"></script>
@php
    $index = 0
@endphp
@foreach ($classs as $class)

    @foreach ($years as $year)
        @if ($hoc_ki == 'all')
            @for ($i = 1; $i <= 2; $i++)
                
                @if (\count($data[$index]) != 0)
                    <div class="col-sm-6" id="{{ $class->id_class."_".$year->id_year."_".$i }}">
                            
                    </div>
                @endif
                @php
                    $index++;
                @endphp

            @endfor
        @else
            @if (\count($data[$index]) != 0)
                <div class="col-sm-6" id="{{ $class->id_class."_".$year->id_year."_".$hoc_ki }}">
                        
                </div>
            @endif
            @php
                $index++;
            @endphp
        @endif

    @endforeach
    
@endforeach

@php
    $data = json_encode($data);
@endphp
<script type="text/javascript">
    var classs = {!! $classs !!}
    var hoc_ki = '{{ $hoc_ki }}'
    var data = {!! $data !!}
    var years = {!! $years !!}
    var i = 0
    $.each(classs, function (indexInArray, value) { 
        $.each(years, function (indexInArray, valueOfElement) { 
            if (hoc_ki == 'all') {
                for (let index = 1; index <= 2; index++) {
                    if (data[i].length == 0) {
                        i++;
                    } else
                    {
                        fillPieChart(data[i], value.id_class + '_' + valueOfElement.id_year + '_' + index, 
                        'Thống kê điểm rèn luyện lớp ' + value.id_class + ' học kì ' + index + ' năm học ' + valueOfElement.id_year, '', '')
                        i++
                    }
                    
                }
            } 
            else{
                if (data[i].length == 0) {
                    i++
                } else{
                    fillPieChart(data[i], value.id_class + '_' + valueOfElement.id_year + '_' + hoc_ki, 'Thống kê điểm rèn luyện lớp ' + value.id_class + ' học kì ' + hoc_ki + ' năm học ' + valueOfElement.id_year)
                    i++
                }
            }
        });
    });
</script>

