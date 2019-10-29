@extends('admin.index')
@section('content')
    <div class="container-fluid" style="margin-left: 0px;">

        <div class="row">
        

            <div class="col-sm-12" >
                
                <h1>THÊM MỚI <small>Sinh viên</small> </h1>

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
            <div class="col-sm-12">
                
                    <form action="" method="POST" enctype="multipart/form-data">

                        {{ csrf_field() }}

                        <div class="form-group">

                            <label>Mã SV</label>

                            <input type="text" name="id_student" value="" class="form-control" placeholder="Mã SV" required>

                        </div>

                        <div class="form-group">

                                <label>Họ và tên</label>
    
                                <input type="text" name="name" value="" class="form-control" placeholder="Họ và tên" required>
    
                        </div>
                        
                        <div class="form-group">
                            <label for="">Ngày sinh</label>
                            <input type="date"
                                class="form-control" name="birthday" id="" aria-describedby="helpId" placeholder="">
                            <small id="helpId" class="form-text text-muted">Help text</small>
                        </div>

                        <div class="form-group">
        
                            <label>Lớp học</label>
        
                            <select name="class" id="" class="form-control">
                                @foreach ($class as $value)
                                    <option value="{{$value->id_class}}">{{$value->id_class}}</option>
                                @endforeach
                            </select>
        
                        </div>

                        <div class="form-group">

                            <label>Số điện thoại</label>

                            <input type="text" name="phone_number" value="" class="form-control" placeholder="Số điện thoại" required>

                        </div>

                        <div class="form-group">

                            <label>Địa chỉ</label>

                            <input type="text" name="address" value="" class="form-control" placeholder="Địa chỉ" required>

                        </div>

                        <div class="form-group">
        
                            <label>Chức vụ</label>
        
                            <select name="position" id="" class="form-control">
                                @foreach ($positions as $value)
                                    <option value="{{$value->id_position}}" selected>{{$value->name}}</option>
                                @endforeach
                            </select>
            
                        </div>
                        
                        
                        
                        <input type="submit" name="submit" class="btn btn-primary" value="THÊM MỚI">

                    </form>
            </div>

        </div>
    </div>
@endsection