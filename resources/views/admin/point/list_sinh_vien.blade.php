@extends('admin.index')
@section('title')Học kì {{$dot->hoc_ki}} Năm học {{$dot->nam_hoc}} @endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
@endsection
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
                        <td>Tình trạng</td>
                        <td>Tải về</td>
                    </tr>
                </thead>

                <tbody id="dataPage">
                    @foreach ($students as $student)
                        <tr>
                            <td> {{ $student->id_student }} </td>
                            <td style="text-align: left; width: 20%" class="tagADetail"><a data-student="{{$student->id_student}}" data-dot="{{$id_dot}}" style="cursor: pointer">
                                {{ $student->first_name . " " . $student->last_name }}</a>
                            </td>
                            <td> {{ $student->confirm == 0 ? "Chưa đánh giá" : "Đã đánh giá" }} </td>
                            <td> {{ $student->total }} </td>
                            <td> {{ danhGia($student->total) }} </td>
                            <td><input type="text" class="form-control" id="{{ $student->id_student }}" value="{{$student->note}}"></td>
                            <td><button type="button" class="
                                @if ($student->status == 1)
                                    btn btn-success
                                @else
                                    btn btn-danger
                                @endif    
                            " onclick="tinhTrang(this)"
                            data-student="{{ $student->id_student }}"
                            >
                                @if ($student->status == 1)
                                    Đang học
                                @else
                                    Nghỉ học
                                @endif
                            
                            </button></td>
                            <td><a href="{{ route('downloadPointPDF', ['id_student' => $student->id_student, 'id_dot' => $id_dot]) }}?type=read"><i class="fas fa-cloud-download-alt"></i></a>  </td>
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

        $(document).on('click', '.tagADetail a', function(event) {
            event.preventDefault();
            var id_student = $(this).data('student')
            var id_dot = $(this).data('dot')
            var url = '{{ route('downloadPointPDF', ['id_student' => '', 'id_dot' => '']) }}'
            url = url.substr(0, url.length-1) + url.substr(url.length);
            $.ajax({
                type: "GET",
                url:  url + id_student + '_' +id_dot+'?type=html',
                data: {},
                dataType: 'html',
                success: function(response) {
                    $('#modalTable').modal('show')
                    $('#modalTableContent').html(response)
                }
            });
        });

    });

    function tinhTrang(button) { 
        var id = $(button).data('student');
        console.log(id)
        var url = '{{ route('changeStatus', ['id_dot'=>$id_dot]) }}?id_student='+id

        axios({
            url: url,
            method: "GET",
            data: {},
        })
        .then((response)=>{
            console.log(response)
            if (response.data.ok == 0) return;
            var data = response.data
            $(button).html(data.message)
            $(button).removeClass().addClass(data.class)
            $('#'+id).val(data.note) 
        })
        .catch((err)=>{
            console.log(err.response)
        })
        
    }
</script>

@endsection
