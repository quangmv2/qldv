<table class="table table-striped table-bordered table-hover" style="width: 100%">

    <thead>
        <tr>
            <td>STT</td>
            <td>Tên lớp</td>
            <td>Xem</td>
        </tr>
    </thead>

    <tbody id="dataPage">
        @foreach ($dots as $index => $value)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ "Học kì ".$value->hoc_ki." - Năm học ".$value->nam_hoc."." }}</td> 
                <td><button class="btn btn-success" onclick="window.location = '{{ route('DRLDotAD', ['id_dot'=>$value->id_dot_xet]) }}'">Chi tiết</button></td>
            </tr>
        @endforeach
    </tbody>
</table>
