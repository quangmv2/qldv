@extends('client.index')
@section('title')Thêm mới đợt xét điểm rèn luyện @endsection
@section('content')

<div class="container-fluid" style="margin-left: 0px;">

    <div class="row">
    

        <div class="col-sm-12" >
            
            <h1>THÊM MỚI <small>Đợt xét điểm rèn luyện</small> </h1>

        </div>

    </div>

</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            
                <form action="" method="POST" enctype="multipart/form-data" id="myForm">

                    {{ csrf_field() }}

                    <div class="form-group">

                        <label>Năm học</label>

                        <select name="year" id="" class="form-control">
                           @foreach ($year as $value)
                               <option value="{{$value->id_year}}">{{$value->id_year}}</option>
                           @endforeach
                        </select>

                    </div>

                    <div class="form-group">

                        <label>Học kì</label>

                        <select name="semester" id="" class="form-control">
                            <option value="1">I</option>
                            <option value="2">II</option>
                        </select>

                    </div>

                    <div class="form-group">

                        <label>Ngày bắt đầu tính hoạt động</label>

                        <input type="date" name="begin" value="" class="form-control" >

                    </div>

                    <div class="form-group">

                        <label>Ngày kết thúc tính hoạt động</label>

                        <input type="date" name="end" value="" class="form-control">

                    </div>
                    
                    <input type="submit" name="submit" class="btn btn-primary" value="THÊM MỚI">

                </form>
        </div>

    </div>
</div>
    
@endsection