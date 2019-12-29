@extends('admin.index')
@section('title')Thêm mới đợt xét điểm rèn luyện @endsection
@section('content')
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="{{ asset('assets/js/chart.js') }}"></script>
<div class="container-fluid" style="margin-left: 0px;">

    <div class="row">
    

        <div class="col-sm-12" >
            
            <h1>THÊM MỚI <small>Đợt xét điểm rèn luyện</small> </h1>
            <form action="" id="formChart">
                <div class="row">
                
                    <div class="col-sm-2">
                        <select name="nam_hoc" id="" class="form-control">
                            <option value="all">Tất cả</option>
                            @foreach ($years as $year)
                                <option value="{{$year->id_year}}">{{$year->id_year}}</option>
                            @endforeach
                        </select>
                    </div>
        
                    <div class="col-sm-1">
                        <select name="hoc_ki" id="" class="form-control">
                            <option value="all">Tất cả</option>
                            <option value="1">I</option>
                            <option value="2">II</option>
                        </select>
                    </div>
        
                    <div class="col-sm-2">
                        <select name="lop" id="" class="form-control">
                            <option value="all">Tất cả</option>
                            @foreach ($classs as $class)
                                <option value="{{ $class->id_class }}">{{ $class->id_class }}</option>    
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success" id="btnSubmit">Xem</button>
                </div>
            </form>

        </div>

    </div>

</div>

<div class="container-fluid" style="margin-top: 10px;">
    <div class="row" id="data">
    

    </div>
</div>
<p id="link" style="display: none">{{ route('thongKeADAJAX') }}</p>
<script type="text/javascript">
    
    $(document).ready(function () {
        $('#formChart').submit(function (e) { 
            e.preventDefault();
            console.log($(this).serialize())
            getDataChart($(this).serialize())
        });
        $('#btnSubmit').click();
    });

    function getDataChart(data) {  
        console.log(data)
        $.ajax({
            type: "GET",
            url: $('#link').text(),
            data: data,
            dataType: "html",
            success: function (response) {
                console.log(response)
                $('#data').html(response)
            }
        });
    }

    

</script>
    
@endsection