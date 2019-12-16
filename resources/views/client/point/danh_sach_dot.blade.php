@extends('client.index')
@section('title')Danh sách đợt xét @endsection
@section('content')
<div class="container-fluid" style="margin-left: 0px;">

    <div class="row">
    

        <div class="col-sm-12" >
            
            <h1>DANH SÁCH <small>Đợt xét điểm</small> </h1>

        </div>

    </div>

</div>

<div class="container-fluid">
    <div class="row">
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