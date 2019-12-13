@extends('client.index')
@section('title')Điểm rèn luyện của tôi @endsection
@section('content')
<div class="container-fluid" style="margin-left: 0px;">

    <div class="row">


        <div class="col-sm-12" >

            <h1>DANH SÁCH <small>Hoạt động</small> </h1>

        </div>

    </div>

</div>

<div class="container-fluid">
    <div class="row">
        <style>
            td{
                text-align: center
            }
        </style>
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" id="dataPage">
            <table class="table table-striped table-bordered table-hover" style="width: 100%">

                <thead>
                    <tr>
                        <td>TT</td>
                        <td>Tên đợt</td>
                        <td>Trạng thái</td>
                        <td>Điểm</td>
                        <td>Xếp loại</td>
                        <td>Tự đánh giá</td>
                        <td>Tải về</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $index => $item)
                        <tr>
                            <td> {{ $index + 1 }} </td>
                            <td> <a href="{{ route('getMyDot', ['id_dot'=> $item->id_dot_xet]) }}">Học kì {{ $item->hoc_ki }} năm học {{ $item->nam_hoc }} </a> </td>
                            <td> {{ $item->confirm == 0 ? "Chưa đánh giá" : "Đã đánh giá" }} </td>
                            <td> {{ $item->total }} </td>
                            <td> {{ danhGia($item->total) }} </td>
                            <td> <a href="{{ route('getMyDot', ['id_dot'=> $item->id_dot_xet]) }}"><i class="fas fa-notes-medical"></i></a> </td>
                            <td><a href="{{ route('downloadPointPDF', ['id_student' => session('account')->id_student, 'id_dot' => $item->id_dot_xet]) }}"><i class="fas fa-cloud-download-alt"></i></a>  </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection
