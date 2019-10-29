@extends('client.index')
@section('content')
<div class="container-fluid" style="margin-left: 0px;">

    <div class="row">
    

        <div class="col-sm-12" >
            
            <h1>DANH SÁCH <small>Hoạt động</small> </h1>

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
                        <td>STT</td>
                        <td>Tên hoạt động</td>
                        <td>Thời gian</td>
                        <td>Trạng thái</td>
                        <td>Kiểu</td>
                        <td>Sửa</td>
                        <td>Xóa</td>
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
                                   echo $value->confirm == 1 ? "Đã điểm danh": "Chưa điểm danh"
                                @endphp 
                            </td>
                            <td> 
                                @if ($value->type == 0)
                                    Cả lớp
                                @else
                                    @if ($value->type == 1)
                                        Bắt buộc
                                    @else
                                        Đăng ký
                                    @endif
                                @endif 
                            </td>
                            <td><a href=""><i class="fas fa-edit" style="color: red"></i></a>  </td>
                            <td><a href="{{ route('deleteAction', ['id'=> $value->id_action]) }}"><i class="fas fa-trash" style="color: red"></i></a>  </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $actions->links() }}
        </div>
    </div>
</div>
    
@endsection