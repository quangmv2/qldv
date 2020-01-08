@extends('admin.index')
@section('title')Danh sách hoạt động @endsection
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
            
            <h1 id="lblList">Điểm rèn luyện</h1>
            <div class="row" style="margin-bottom: 10px">
                <div class="col-sm-2">
                    <select name="" id="select" class="form-control">
                        <option value="class">Xem theo lớp</option>
                        <option value="dot">Xem theo các đợt xét điểm</option>
                    </select>
                </div>
            </div>
        </div>

    </div>

</div>

<div class="container-fluid">
    <div class="row">
        {{-- @php
            $page = 1;
            if (isset($_GET['page'])) {
                $page = $_GET['page']-1;
            }
        @endphp --}}
        <style>
            td{
                text-align: center
            }
        </style>
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" id="dataPage">
            
        </div>
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" id="dataChart" style="display: none">
        </div>
    </div>
</div>
<script type="text/javascript">

    jQuery(document).ready(function () {
        getMyTable('class')  

        $('#select').change(function (e) { 
            e.preventDefault();
            var op = $(this).children('option:selected').val();
            getMyTable(op)
        });      


    });

    function getMyTable(type){
        $.ajax({
            type: "GET",
            url: window.location.href,
            data: {
                type: type,
            },
            dataType: "html",
            success: function (response) {
                $('#dataPage').html(response)
            }
        });
    }

</script>

   
@endsection