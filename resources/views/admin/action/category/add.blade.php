@extends('admin.index')
@section('content')
    <div class="container-fluid" style="margin-left: 0px;">

        <div class="row">
        

            <div class="col-sm-12" >
                
                <h1>THÊM MỚI <small>Thể loại</small> </h1>

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

                            <label>Tên thể loại</label>

                            <input type="text" name="name" value="" class="form-control" placeholder="Tên thể loại" required>

                        </div>

                        <input type="submit" name="submit" class="btn btn-primary" value="THÊM MỚI">

                    </form>
            </div>

        </div>
    </div>
@endsection