@extends('client.index')
@section('content')
<div class="container-fluid" style="margin-left: 0px;">

    <div class="row">
    

        <div class="col-sm-12" >
            
            <h1>ĐIỂM DANH <small>Hoạt động {{ $action->name }}</small> </h1>

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
        @php
            $page = 0;
            if (isset($_GET['page'])) {
                $page = $_GET['page']-1;
            }
        @endphp
        <style>
            td{
                text-align: center
            }
        </style>
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <table class="table table-striped table-bordered table-hover" style="width: 100%">

                <thead>
                    <tr>
                        <td>MÃ SV</td>
                        <td>Họ và tên</td>
                        <td>Điểm danh</td>
                    </tr>
                </thead>

                <tbody id="dataStudent">
                    @foreach ($students as $index => $value)
                        <tr>
                            <td>{{ $value->id_student }}</td>
                            <td>{{ $value->profile->first_name." ".$value->profile->last_name}}</td>
                            <td><button class="
                                @if ($value->status == 0)
                                    btn btn-danger
                                @else
                                    btn btn-success
                                @endif    
                            " onclick="attendance(this, '{{$value->id_student}}')">
                            @if ($value->status == 0)
                                Vắng
                            @else
                                Có mặt
                            @endif
                            </button></a>  </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
    
@endsection