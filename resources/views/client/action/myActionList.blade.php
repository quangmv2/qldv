@extends('client.index')
@section('title')Hoạt động của bạn @endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="{{ asset('assets/js/chart.js') }}"></script>
@endsection
@section('content')
<div class="container-fluid" style="margin-left: 0px;">

    <div class="row">
    

        <div class="col-sm-12" >
            
            <h1>DANH SÁCH <small>Hoạt động của tôi</small> </h1>
            <button type="button" class="btn btn-success" id="btnDisplay" style="display: inline; float: right; margin-bottom: 10px;">Thống kê</button>

        </div>

    </div>

</div>

<div class="container-fluid" id="myContent">
    <div class="row">
        <div class="col-sm-12">
                @if (count($errors)>0)
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $element)
                            {{ $element }} <br>
                        @endforeach
                    </div>
                @endif
                @if (session('myErrors'))
                    <div class="alert alert-danger">
                        {{ session('myErrors') }}
                    </div>
                @endif
                @if (session('notification'))
                    <div class="alert alert-success">
                        {{ session('notification') }}
                    </div>
                @endif
        </div>
        @php
            $page = 0;
            if (isset($_GET['page'])) {
                $page = $_GET['page']-1;
            }
        @endphp
        <style>
            td{
                text-align: center
            }
        </style>
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" id="dataPage">
           
        </div>
    </div>
</div>
<div class="container-fluid" id="myChart" style="display: none">
    <div class="row">
        <div class="col-sm-6" id="myData"></div>
        <div class="col-sm-6" id="myDataWithCategory"></div>
        <div class="col-sm-12" style="margin-top: 10px;">
            <select name="" class="form-control" id="seclectCategory">
                @foreach ($categories as $category)
                    <option value="{{$category->id_category}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12" id="myChartCategory"></div>
    </div>
</div>

<script>
    callServer(1)
</script>
<script type="text/javascript">
    let vang_co = {!! $dataChart !!}
    let data_with_category = {!! $dataChartWithCategorys !!}
    $(document).ready(function(){

        $('#seclectCategory').change(function (e) { 
            e.preventDefault();
            var op = $(this).children('option:selected').val();
            var title = $(this).children('option:selected').text();
            console.log(op)
            getCategoryChart(op, title)
            
        });

        $('#btnDisplay').on('click', ()=>{
            console.log($('#myContent').css('display'))
            if ($('#myContent').css('display') === "none"){
                $('#myContent').show()
                $('#myChart').hide()
                $('#btnDisplay').html('Thống kê')
            } else{
                $('#myContent').hide()
                $('#myChart').show()
                $('#btnDisplay').html('Bảng')
                fillPieChart(vang_co, 'myData', 'Thống kê điểm danh hoạt động')
                fillBarChart(data_with_category, 'myDataWithCategory', 'Các hoạt động đã điểm danh theo loại')
                getCategoryChart($('#seclectCategory').children('option:selected').val(), $('#seclectCategory').children('option:selected').text())
                
            }
        })

    });

    function getCategoryChart(id_category, title) {
        axios({
                url: window.location.href + '/chart?category=' + id_category,
                method: "GET",
                data: {
                    category: id_category,
                }
            })
            .then((response) => {
                console.log(response)
                fillPieChart(response.data, 'myChartCategory', 'Thống kê điểm danh hoạt động theo ' + title)
            })
            .catch((err) => {
                ajaxSuccess()
            })
    }

</script>
@endsection