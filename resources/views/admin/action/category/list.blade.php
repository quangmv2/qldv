@extends('admin.index')
@section('content')

    <div class="container-fluid" style="margin-left: 0px;">

        {{-- <div id="preloader" style="display: none;">
            <div id="status" style="display: none;">&nbsp;</div>
        </div> --}}

        <div class="row">
        

            <div class="col-sm-12" >
                
                <h1>DANH SÁCH <small>Thể loại</small> </h1>

            </div>

        </div>
        <!-- /.row -->
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
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <table class="table table-striped table-bordered table-hover" style="width: 100%">

                    <thead>
                        <tr>
                            <td>TT</td>
                            <td>Tên thể loại</td>
                            <td>Xóa</td>
                        </tr>
                    </thead>

                    <tbody id="dataStudent">
                        @foreach ($categories as $index => $value)
                            <tr>
                                <td> {{ $index +1 }} </td>
                                <td> {{ $value->name }} </td>
                                <td> <a href="{{ route('deleteCategoryAD', ['id' => $value->id_category]) }}">DELETE</a> </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
<style>
    td, th{
        text-align: center;
    }
</style>
@endsection