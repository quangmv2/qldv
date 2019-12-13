@extends('client.index')
@section('title')Hoạt động của bạn @endsection
@section('content')
<div class="container-fluid" style="margin-left: 0px;">

    <div class="row">
    

        <div class="col-sm-12" >
            
            <h1>DANH SÁCH <small>Hoạt động của tôi</small> </h1>

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
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" id="dataPage">
           
        </div>
    </div>
</div>
<script>
    callServer(1)
</script>
@endsection