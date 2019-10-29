@extends('client.index')
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
            use App\ActionRelationship;
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
                        <td>STT</td>
                        <td>Tên hoạt động</td>
                        <td>Thời gian</td>
                        <td>Trạng thái</td>
                        <td>Xem</td>
                    </tr>
                </thead>

                <tbody id="dataStudent">
                    @foreach ($actions as $index => $value)
                        <tr>
                            <td>{{ ($page*50 + $index+1) }}</td>
                            <td>{{ $value->name}}</td>
                            <td>{{ \Carbon\Carbon::parse($value->time)->format('d-m-Y') }}</td>
                            <td> 
                                @php
                                    $AR = ActionRelationship::where('id_student', session('account')->id_student)->where('id_action', $value->id_action)->get();
                                    if (count($AR) < 1) {
                                        echo "Không tham gia";
                                    } else {
                                        $AR = $AR[0];
                                        if ($AR->status == 0) {
                                            echo "Đã tham gia - Chưa điểm danh";
                                        } else {
                                            echo "Đã tham gia - Đã điểm danh";
                                        }
                                    }
                                @endphp
                            </td>
                            <td><a href=""><i class="fas fa-eye" style="color: green"></i></a>  </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $actions->links() }}
        </div>
    </div>
</div>
    
@endsection