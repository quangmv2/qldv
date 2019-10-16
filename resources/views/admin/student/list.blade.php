@extends('admin.index')
@section('content')

    <div class="container-fluid" style="margin-left: 0px;">

        

        <div class="row">
        

            <div class="col-sm-12" >
                
                <h1>DANH SÁCH <small>Sinh viên</small> </h1>

            </div>

            <div class="col-sm-3">
                <div class="form-group">
                    <select id="my-select" class="custom-select" name="" style="display: inline">
                        <option value="all"> Tất cả </option>
                        @foreach ($class as $value)
                            <option value="{{ $value->name }}"> {{ $value->name }} </option>
                        @endforeach
                    </select>
                </div>
            </div>


        </div>
        <!-- /.row -->
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
                    @if (session('myError'))
                            <div class="alert alert-danger">
                                {{ session('myError') }}
                            </div>
                    @endif
                    @if (session('notification'))
                            <div class="alert alert-success">
                                {{ session('notification') }}
                            </div>
                        @endif
            </div>
            <div class="col-lg-12">
                <table class="table table-striped table-bordered table-hover">

                    <thead>
                        <tr>
                            <td>Mã SV</td>
                            <td>Họ tên sinh viên</td>
                            <td>Email</td>
                            <td>Ngày sinh</td>
                            <td>Địa chỉ</td>
                            <td>Lớp</td>
                            <td>Xóa</td>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($students as $index => $value)
                            <tr>
                                <td> {{ $value->id_student }} </td>
                                <td> {{ $value->profile->name }} </td>
                                <td> {{ $value->profile->email }} </td>
                                <td> {{ \Carbon\Carbon::parse($value->profile->birthday)->format('d-m-Y') }} </td>
                                <td> {{ $value->profile->address }} </td>
                                <td> {{ $value->classs->name }} </td>
                                <td> Xóa </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

@endsection