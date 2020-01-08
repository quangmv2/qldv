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
            
            <h1 id="lblList">DANH SÁCH <small>Hoạt động</small> </h1>
            <h1 id="lblChart" style="text-align: center"></h1>
            <div class="row">
                <div class="col-sm-2" >
                    <select name="" id="selectCategory" class="form-control">
                        <option value="all">Tất cả</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id_category }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-9">

                </div>
                <div style="float: right;">
                    <button class="btn btn-success" id="btnList" style="margin-bottom: 10px; display: none">Danh sách</button>
                    {{-- <button class="btn btn-success" id="btnThongKe" style=" margin-bottom: 10px;">Thống kê</button> --}}
                </div>
            </div>
            
        </div>

    </div>

</div>

<div class="container-fluid">
    <div class="row">
        @php
            $page = 1;
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
            <table class="table table-striped table-bordered table-hover" style="width: 100%">

                <thead>
                    <tr>
                        <td>STT</td>
                        <td>Tên hoạt động</td>
                        <td>Thời gian</td>
                        <td>Thống kê</td>
                        <td>Chi tiết</td>
                        <td>Sửa</td>
                        <td>Xóa</td>
                    </tr>
                </thead>
            
                <tbody id="dataPage">
                    @foreach ($actions as $index => $value)
                        <tr>
                            <td>{{ (($page-1)*20 + $index+1) }}</td>
                            <td>{{ $value->getAction->name}}</td>
                            <td>{{ \Carbon\Carbon::parse($value->getAction->time)->format('d-m-Y') }}</td>
                            <td>
                                <button class="btn btn-success btnTable" data-name="{{$value->getAction->name}}" data-action="{{$value->getAction->id_action}}">Bảng</button>
                                <button class="btn btn-success btnChart" data-name="{{$value->getAction->name}}" data-action="{{$value->getAction->id_action}}">Biểu đồ</button>
                            </td>
                            <td> <button class="btn btn-success">Chi tiết</button></td>
                            <td><a href=""><i class="fas fa-edit" style="color: red"></i></a>  </td>
                            <td><a class="deleteajax" href="{{ route('deleteAction', ['id'=> $value->getAction->id_action]) }}"><i class="fas fa-trash" style="color: red"></i></a>  </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $actions->links() }}
        </div>
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" id="dataChart" style="display: none">
        </div>
    </div>
</div>

<script type="text/javascript">

    var status = 0;

    function detail(button) {  
        var id_action = $(button).data('action');
        var id_class = $(button).data('lop')

        axios({
            method: "GET",
            url: window.location.href + '/chart-action-class/' + id_action + '/' + id_class,
            data: {},
        })
        .then((response)=>{
            console.log(response.data)
            var result = '<table class="table table-striped table-bordered table-hover" style="width: 100%">'+
                            '<style>th{text-align: center}</style>'+
                            '<thead><tr><th>Mã SV</th><th>Họ và tên</th><th>Điểm danh</th><th>Ghi chú</th></thead>'+
                            '<tbody>'
            var data = response.data
            $.each(data, function (index, value) { 
                var str = value.status == 0 ? 'Vắng' : 'Có mặt'
                var note = value.note == null ? '' : value.note
                 result += '<tr>'+
                                '<td>' + value.id_student+ '</td>'+
                                '<td>' + value.first_name + ' ' + value.last_name + '</td>'+
                                '<td>' + str + '</td>' + 
                                '<td>' + note + '</td>' +
                            '</tr>'
            });
            result += '</tbody></table>'
            $('#modalTableContent').html(result)
            $('#modalTable').modal(true)
        })
        .catch((err)=>{
            console.log(err.response)
        })
    }

    jQuery(document).ready(function () {

        $('#selectCategory').change(function (e) { 
            e.preventDefault();
            var op = $(this).children('option:selected').val();
            console.log(op)
            loadBegin()
            $.ajax({
                url: window.location.href,
                type: 'GET',
                dataType: 'html',
                data: {
                    type    : 'ajaxCategory',
                    category : op,
                },
                success : function (data) {
                    $('#dataPage').html(data)
                    loadEnd()
                }
            })
            .fail((err) => {
                ajaxSuccess()
                console.log(err)
            })
        });

        $(document).on('click', '#btnList', function (e) {
            e.preventDefault();
            $('#dataPage').show()
            $('#dataChart').hide()
            $('#lblList').show()
            $('#lblChart').hide()
            $('#btnThongKe').show()
            $(this).hide()
        });

        $(document).on('click', '.btnTable', function (e) {

            e.preventDefault();

            var id_action = $(this).data('action');
            var name_action = $(this).data('name')
            var data = {}

            $.ajax({
                type: "GET",
                url: window.location.href + '/chart/' + id_action,
                data: {
                    type: 'table',
                },
                dataType: "html",
                success: function (response) {
                    console.log(response)
                    $('#dataPage').hide()
                    $('#dataChart').html(response).show()
                    $('#btnList').show()
                    $('#lblList').hide()
                    $('#lblChart').html('Thống kê hoạt động ' + name_action).show()
                    $('#btnThongKe').hide()
                },  
                fail: function(xhr, textStatus, errorThrown){
                    alert('request failed');
                }
            });
            
        });
        $(document).on('click', '.btnChart', function (e) {
            e.preventDefault();
            
            var id_action = $(this).data('action');
            var name_action = $(this).data('name')
            var data = {}

            $.ajax({
                type: "GET",
                url: window.location.href + '/chart/' + id_action,
                data: {
                    type: 'chart',
                },
                dataType: "html",
                success: function (response) {
                    console.log(response)
                    $('#dataPage').hide()
                    $('#btnThongKe').hide()
                    $('#dataChart').html(response).show()
                    $('#btnList').show()
                    $('#lblList').hide()
                    $('#lblChart').html('Thống kê hoạt động ' + name_action).show()
                },  
                fail: function(xhr, textStatus, errorThrown){
                    alert('request failed');
                }
            });

        });

    });

</script>
   
@endsection