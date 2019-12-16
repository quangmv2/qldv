@extends('admin.index')
@section('content')

    <div class="container-fluid" style="margin-left: 0px;">

        {{-- <div id="preloader" style="display: none;">
            <div id="status" style="display: none;">&nbsp;</div>
        </div> --}}

        <div class="row">
        

            <div class="col-sm-12" >
                
                <h1>DANH SÁCH <small>Sinh viên</small> </h1>

            </div>

            <div class="col-sm-3">
                <div class="form-group">
                    <select id="selectClass" class="custom-select" name="" style="display: inline">
                        <option value="0"> Tất cả </option>
                        @foreach ($class as $value)
                            <option value="{{ $value->id_class }}"> {{ $value->id_class }} </option>
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
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <table class="table table-striped table-bordered table-hover" style="width: 100%">

                    <thead>
                        <tr>
                            <td>Mã SV</td>
                            <td>Họ tên sinh viên</td>
                            <td>Email</td>
                            <td>Ngày sinh</td>
                            <td>Chức vụ</td>
                            <td>Lớp</td>
                            <td>Xóa</td>
                        </tr>
                    </thead>

                    <tbody id="dataStudent">
                        @foreach ($students as $index => $value)
                            <tr>
                                <td> {{ $value->id_student }} </td>
                                <td> {{ $value->profile->first_name." ".$value->profile->last_name }} </td>
                                <td> {{ $value->profile->email }} </td>
                                <td> {{ \Carbon\Carbon::parse($value->profile->birthday)->format('d-m-Y') }} </td>
                                <td> {{ $value->position->name }} </td>
                                <td> {{ $value->classs->id_class }} </td>
                                <td> <a href="{{ route('editStudent', ['id_student' => $value->id_student]) }}">Edit</a> </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

@endsection