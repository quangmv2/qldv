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

    <tbody id="dataPage">
        @foreach ($actions as $index => $value)
            <tr>
                <td>{{ (($page-1)*20 + $index+1) }}</td>
                <td>{{ $value->name}}</td>
                <td>{{ \Carbon\Carbon::parse($value->time)->format('d-m-Y') }}</td>
                <td> 
                    @php
                       echo $value->confirm == 1 ? "Đã điểm danh - ". $value->join."/".$value->sum: "Chưa điểm danh";
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
                <td><a class="deleteajax" href="{{ route('deleteAction', ['id'=> $value->id_action]) }}"><i class="fas fa-trash" style="color: red"></i></a>  </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $actions->links() }}