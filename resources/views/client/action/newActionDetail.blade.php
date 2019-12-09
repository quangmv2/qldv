@extends('client.index')
@section('title'){{$action->name}} @endsection
@section('content')
<div class="container-fluid" style="margin-left: 0px;">

    <div class="row">
    

        <div class="col-sm-12" >
            
            <h1>HOẠT ĐỘNG <small>{{ $action->name }}</small> </h1>

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
                @if (session('myErrors'))
                    <div class="alert alert-danger">
                        {{ session('myErrors') }}
                    </div>
                @endif
                @if (session('notification'))
                    <div class="alert alert-success">
                        {{ session('notification') }}
                    </div>
                @endif
        </div>
        <div class="col-sm-12 col-lg-12">
            
            {!! $action->content !!}
            @if ($action->type == 2)
                @switch($action->register)
                    @case(0)
                        <button class="btn btn-primary" id="registerAction" type="button" >Đăng ký</button>
                        @break
                    @default
                        @if ($action->confirm == 1 && \Carbon\Carbon::parse($action->time)<=\Carbon\Carbon::now())
                            <button class="btn btn-primary" disabled>Đã đăng ký</button>
                        @else
                            <button class="btn btn-primary" id="registerAction" type="button">Hủy đăng ký</button>
                        @endif
                        
                    @break
                @endswitch
            @endif
        </div>
        <p id="_token"> {{ csrf_field() }} </p>
    </div>
</div>
    
@endsection