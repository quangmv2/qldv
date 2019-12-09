@extends('client.index')
@section('title')Thêm mới hoạt động @endsection
@section('content')

<div class="container-fluid" style="margin-left: 0px;">

    <div class="row">
    

        <div class="col-sm-12" >
            
            <h1>THÊM MỚI <small>Hoạt động</small> </h1>

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
            
                <form action="" method="POST" enctype="multipart/form-data" id="myForm">

                    {{ csrf_field() }}

                    <div class="form-group">

                        <label>Tên hoạt động</label>

                        <input type="text" name="name" value="" class="form-control" placeholder="Tên hoạt động" >

                    </div>

                    <div class="form-group">

                            <label>Ngày giờ</label>

                            <input type="date" name="time" value="" class="form-control" placeholder="Họ và tên" >

                    </div>
                    
                    <div class="form-group">
                        <label>Nội dung</label>
                        <textarea id="editor01" name="content" class="form-control" placeholder="Nội dung..."></textarea>
                        <script>

							CKEDITOR.replace( 'editor01',{

							        filebrowserBrowseUrl: '{{ asset('ckfinder/ckfinder.html') }}',

							        filebrowserImageBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Images') }}',

							        filebrowserFlashBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Flash') }}',

							        filebrowserUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}',

							        filebrowserImageUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}',

							        filebrowserFlashUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}'

							    } );

	            		</script>
                    </div>

                    <div class="form-group">

                        <label style="display:block;">Thành viên tham gia</label>
                        <select name="object" id="option" class="form-control">
                            <option value="0">Cả lớp</option>
                            <option value="1">Thành viên</option>
                            <option value="2">Đăng ký</option>
                        </select>
			        
                    </div>
                    <div id="chooseStudent" style="display: none">
                        <table class="table table-striped table-bordered table-hover">

                            <thead>
                                <tr>
                                    <th style="text-align: center">Mã SV</th>
                                    <th style="text-align: center">Họ và tên</th>
                                    <th style="text-align: center">Tham gia</th>
                                </tr>
                            </thead>

                            <tbody>
                                
                                @foreach ($students as $index => $value)
                                    <tr>
                                        <td align="center"> {{ $value->id_student }} </td>
                                        <td align="center"> {{$value->profile->first_name." ".$value->profile->last_name}} </td>
                                        <td align="center"> <input type="checkbox" name="id_student[]" class="form-check-input checkbox-large" value="{{ $value->id_student }}"> </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div>

                    <input type="submit" name="submit" class="btn btn-primary" value="THÊM MỚI">

                </form>
        </div>

    </div>
</div>
    
@endsection