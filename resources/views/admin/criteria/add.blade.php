@extends('admin.index')
@section('content')
    <div class="container-fluid" style="margin-left: 0px;">

        <div class="row">
        

            <div class="col-sm-12" >
                
                <h1>THÊM MỚI <small>Tiêu chí</small> </h1>

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

                            <label>Tiêu đề</label>

                            <input type="text" name="title" value="" class="form-control" placeholder="Tiêu đề" required>

                        </div>

                        <div class="form-group">
        
                            <label>Danh mục</label>
        
                            <select name="id_criteria_relationship" id="" class="form-control">
                                <option value="0">Danh mục gốc</option>
                                @foreach ($criterias as $value)
                                    <option value="{{$value->id_criteria}}">{{$value->title}}</option>
                                @endforeach
                            </select>
        
                        </div>

                        <div class="form-group">

                            <label>Điểm</label>

                            <input type="text" name="point" value="" class="form-control" placeholder="Điểm" required>

                        </div>
                        <input type="submit" name="submit" class="btn btn-primary" value="THÊM MỚI">

                    </form>
            </div>

        </div>
    </div>
@endsection