
@extends('client.index')
@section('title') @endsection
@section('content')

<div class="container-fluid" style="margin-left: 0px;">

    <div class="row">
    

        <div class="col-sm-12" >
            
            <h1>Thông tin cá nhân</h1>

        </div>

    </div>

</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            
                <form action="" method="POST" enctype="multipart/form-data" id="myForm">

                    {{ csrf_field() }}

                    <div class="form-group">
                        <label>Họ</label>
                        <input type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Họ</label>
                        <input type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Lớp</label>
                        <input type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Chức vụ</label>
                        <input type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <input type="text" class="form-control">
                    </div>
                    
                    <input type="submit" name="submit" class="btn btn-primary" value="THÊM MỚI">

                </form>
        </div>

    </div>
</div>
    
@endsection