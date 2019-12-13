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
        
                            <label>Lớp học</label>
        
                            <select name="class" id="" class="form-control">
                                @foreach ($class as $value)
                                    <option value="{{$value->id_class}}">{{$value->id_class}}</option>
                                @endforeach
                            </select>
        
                        </div>

                        <div class="form-group">
        
                            <label>File</label>
        
                            <input type="file" name="file" class="form-control">
            
                        </div>                        
                        <input type="submit" name="submit" class="btn btn-primary" value="THÊM MỚI">

                    </form>
            </div>

        </div>
    </div>
@endsection