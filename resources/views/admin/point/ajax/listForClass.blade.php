<table class="table table-striped table-bordered table-hover" style="width: 100%">

    <thead>
        <tr>
            <td>STT</td>
            <td>Tên lớp</td>
            <td>Khóa học</td>
            <td>Xem</td>
        </tr>
    </thead>

    <tbody id="dataPage">
        @foreach ($classs as $index => $value)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $value->id_class }}</td>
                <td>{{ explode('-', $value->start_study)[0]."-".explode('-', $value->end_study)[0] }}</td>
                <td> <button class="btn btn-success" onclick="window.location = '{{ route('DRLClassAD', ['id_class'=>$value->id_class]) }}'">Chi tiết</button></td>
            </tr>
        @endforeach
    </tbody>
</table>
