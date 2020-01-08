<table class="table table-striped table-bordered table-hover" style="width: 100%">
    <style>
        th{
            text-align: center
        }
    </style>
    <thead>
        <tr>
            <th>STT</th>
            <th>Lớp</th>
            <th>Có mặt</th>
            <th>Vắng</th>
            <th>Tổng</th>
            <th>Chi tiết</th>
        </tr>
    </thead>

    <tbody id="dataPage">
        @foreach ($data as $index => $value)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $value['id_class'] }}</td>
                <td>{{ $value['data'][0]['count'] }} - {{ number_format($value['data'][0]['y'], 2, '.', ',') }}%</td>
                <td>{{ $value['data'][1]['count'] }} - {{ number_format($value['data'][1]['y'], 2, '.', ',') }}%</td>
                <td>{{ $value['data'][0]['count'] + $value['data'][1]['count'] }}</td>
                <td><button class="btn btn-success btnDetail" type="button" onclick="detail(this)" data-lop="{{$value['id_class']}}" data-action="{{$value['id_action']}}">Chi tiết</button></td>
            </tr>
        @endforeach
    </tbody>
</table>