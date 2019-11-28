@extends('client.index')
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
        <style>
            td{
                text-align: center
            }
        </style>
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" id="dataPage">
            <table class="table table-striped table-bordered table-hover" style="width: 100%">

                <thead>
                    <tr>
                        <td>Mã SV</td>
                        <td>Họ và tên</td>
                        <td>Trạng thái</td>
                        <td>Điểm</td>
                        <td>Xếp loại</td>
                        <td>Đánh giá</td>
                        <td>Tải về</td>
                    </tr>
                </thead>

                <tbody id="dataPage">
                    @foreach ($students as $student)
                        <tr>
                            <td> {{ $student->id_student }} </td>
                            <td> {{ $student->first_name . " " . $student->last_name }} </td>
                            <td> {{ $student->confirm == 0 ? "Chưa đánh giá" : "Đã đánh giá" }} </td>
                            <td> {{ $student->total }} </td>
                            <td> {{ danhGia($student->total) }} </td>
                            <td><a href="{{ route('getDanhGia', ['id_dot' => $id_dot, 'name' => tenKhongDau( $student->first_name . " " . $student->last_name ),'id_student' => $student->id_student]) }}"><i class="fas fa-notes-medical"></i></a>  </td>
                            <td><a href=""><i class="fas fa-cloud-download-alt"></i></a>  </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
