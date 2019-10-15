@extends('admin.index')
@section('content')

    <div class="container-fluid" style="margin-left: 0px;">

        

        <div class="row">
        

            <div class="col-sm-12" >
                
                <h1>DANH SÁCH <small>Sinh viên</small> </h1>

            </div>

            <div class="col-sm-3">
                <div class="form-group">
                    <select id="my-select" class="custom-select" name="" style="display: inline">
                        <option>18IT5</option>
                        <option>18IT5</option>
                    </select>
                </div>
            </div>


        </div>
        <!-- /.row -->
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped table-bordered table-hover">

                    <thead>
                        <tr>
                            <td>Mã SV</td>
                            <td>Họ tên SV</td>
                            <td>Email</td>
                            <td>Ngày sinh</td>
                            <td>Địa chỉ</td>
                            <td>Lớp</td>
                            <td>Xóa</td>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>

@endsection