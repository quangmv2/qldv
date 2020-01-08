@php
    if (isset($page)) {
        $page = 1;
    }
@endphp
<table class="table table-striped table-bordered table-hover" style="width: 100%">

    <thead>
        <tr>
            <td>STT</td>
            <td>Tên hoạt động</td>
            <td>Thời gian</td>
            <td>Thống kê</td>
            <td>Chi tiết</td>
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
                    <button class="btn btn-success btnTable" data-name="{{$value->getAction->name}}" data-action="{{$value->getAction->id_action}}">Bảng</button>
                    <button class="btn btn-success btnChart" data-name="{{$value->getAction->name}}" data-action="{{$value->getAction->id_action}}">Biểu đồ</button>
                </td>
                <td> <button class="btn btn-success">Chi tiết</button></td>
                <td><a href=""><i class="fas fa-edit" style="color: red"></i></a>  </td>
                <td><a class="deleteajax" href="{{ route('deleteAction', ['id'=> $value->getAction->id_action]) }}"><i class="fas fa-trash" style="color: red"></i></a>  </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $actions->links() }}