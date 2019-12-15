@extends('client.index')
@section('content')
<div class="container-fluid" style="margin-left: 0px;">

    <div class="row">


        <div class="col-sm-12" >

            <h1>DANH SÁCH <small>Sinh viên</small> </h1>

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
                        <td>Mã SV</td>
                        <td>Họ và tên</td>
                        <td>Trạng thái</td>
                        <td>Điểm</td>
                        <td>Xếp loại</td>
                        <td>Ghi chú</td>
                        <td>Đánh giá</td>
                        <td>Tải về</td>
                    </tr>
                </thead>

                <tbody id="dataPage">
                    @foreach ($students as $student)
                        <tr>
                            <td> {{ $student->id_student }} </td>
                            <td style="text-align: left; width: 20%"><a href="{{ route('getDanhGia', ['id_dot' => $id_dot, 'id_detail'=> $student->id_point, 'name' => tenKhongDau( $student->first_name . " " . $student->last_name ),'id_student' => $student->id_student]) }}">{{ $student->first_name . " " . $student->last_name }}</a></td>
                            <td> {{ $student->confirm == 0 ? "Chưa đánh giá" : "Đã đánh giá" }} </td>
                            <td> {{ $student->total }} </td>
                            <td> {{ danhGia($student->total) }} </td>
                            <td><input type="text" class="form-control" id="{{ $student->id_student }}" value="{{$student->note}}"></td>
                            <td><a href="{{ route('getDanhGia', ['id_dot' => $id_dot,'id_detail'=> $student->id_point, 'name' => tenKhongDau( $student->first_name . " " . $student->last_name ),'id_student' => $student->id_student]) }}"><i class="fas fa-notes-medical"></i></a></td>
                            <td><a href="{{ route('downloadPointPDF', ['id_student' => $student->id_student, 'id_dot' => $id_dot]) }}"><i class="fas fa-cloud-download-alt"></i></a>  </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('input').keyup(function (e) { 
            if (e.which == 13){
                e.preventDefault();
            }
            var id = this.id;
            $.ajax({
                type: "GET",
                url: '{{ route('getDotNote', ['id_dot'=> $id_dot, 'id_student' => '']) }}/'+id,
                data: {
                    note : this.value
                },
                success: function (response) {
                    console.log(response)
                }
            });
        });
    });
</script>

@endsection
