<table class="table table-striped table-bordered table-hover" style="width: 100%">

    <thead>
        <tr>
            <td>STT</td>
            <td>Tên hoạt động</td>
            <td>Thời gian</td>
            <td>Trạng thái</td>
            <td>Kiểu</td>
            <td>Xem</td>
        </tr>
    </thead>

    <tbody id="dataStudent">
        @foreach ($actions as $index => $value)
            <tr>
                <td>{{ (($page-1)*20 + $index+1) }}</td>
                <td>{{ $value->name}}</td>
                <td>{{ \Carbon\Carbon::parse($value->time)->format('d-m-Y') }}</td>
                <td> 
                    @php
                        echo $value->status == 1 ? "Đã điểm danh": "Chưa điểm danh"
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
                <td><a href=""><i class="fas fa-eye" style="color: green"></i></a>  </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $actions->links() }}