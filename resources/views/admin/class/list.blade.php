@extends('admin.index')
@section('content')

    <div class="container-fluid" style="margin-left: 0px;">

        

        <div class="row">
        

            <div class="col-sm-12" >
                
                <h1>DANH SÁCH <small>Lớp học</small> </h1>

            </div>

        </div>
        <!-- /.row -->
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped table-bordered table-hover">

                    <thead>
                        <tr>
                            <td>STT</td>
                            <td>Lớp</td>
                            <td>Khóa học</td>
                            <td>Giảng viên chủ nhiệm</td>
                            <td>Trạng thái</td>
                            <td>Xóa</td>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($class as $index => $value)
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($value->start_study)->format('Y') }} - {{ \Carbon\Carbon::parse($value->end_study)->format('Y') }}</td>
                                <td>{{ $value->teachers->profile->name }}</td>
                                <td>Đang học</td>
                                <td>Xóa</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

@endsection