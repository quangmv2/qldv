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
                <td>{{ $value->getAction->name}}</td>
                <td>{{ \Carbon\Carbon::parse($value->getAction->time)->format('d-m-Y') }}</td>
                <td> 
                    @php
                       echo $value->getAction->confirm == 1 ? "Đã điểm danh - ". $value->getAction->join."/".$value->getAction->sum: "Chưa điểm danh";
                    @endphp 
                </td>
                <td> 
                    @if ($value->getAction->type == 0)
                        Cả lớp
                    @else
                        @if ($value->getAction->type == 1)
                            Bắt buộc
                        @else
                            Đăng ký
                        @endif
                    @endif 
                </td>
                <td><a href=""><i class="fas fa-edit" style="color: red"></i></a>  </td>
                <td><a class="deleteajax" href="{{ route('deleteAction', ['id'=> $value->getAction->id_action]) }}"><i class="fas fa-trash" style="color: red"></i></a>  </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $actions->links() }}