@extends('admin.index')
@section('content')
    <div class="container-fluid" style="margin-left: 0px;">

        <div class="row">
        

            <div class="col-sm-12" >
                
                <h1>THÊM MỚI <small>Lớp học</small> </h1>

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
    
                            <label>Tên lớp</label>
    
                            <input type="text" name="name" value="{{$class->name}}" class="form-control" placeholder="Tên lớp" required>
    
                        </div>
    
                        <div class="form-group">
        
                            <label>Giảng viên chủ nhiệm</label>
        
                            <select name="teacher" id="" class="form-control">
                                @foreach ($teachers as $value)
                                    <option value="{{$value->id}}"
                                        @if ($class->teacher == $value->id)
                                            selected
                                        @endif
                                    >{{$value->profile->name}}</option>
                                @endforeach
                            </select>
        
                        </div>
                        
                        <div class="form-group">
                          <label for="">Thời gian bắt đầu học</label>
                          <input type="date"
                            class="form-control" name="begin" value="{{ $class->start_study }}" id="" aria-describedby="helpId" placeholder="">
                          <small id="helpId" class="form-text text-muted">Help text</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Thời gian kết thúc</label>
                            <input type="date"
                                class="form-control" name="end" value="{{ $class->end_study }}" id="" aria-describedby="helpId" placeholder="">
                            <small id="helpId" class="form-text text-muted">Help text</small>
                        </div>
      
                        <input type="submit" name="submit" class="btn btn-primary" value="Cập nhật">
    
                    </form>
            </div>

        </div>
    </div>

@endsection