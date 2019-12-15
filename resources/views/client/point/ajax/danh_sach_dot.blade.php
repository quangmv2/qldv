@foreach ($list as $item)
    <div class="card text-white bg-dark mb-3">
        <div class="card-header" style="color: black"><h4><a href="{{ route('getDot', ['id_dot'=>$item->id_dot_xet]) }}">Học kỳ {{$item->hoc_ki}} năm học {{$item->nam_hoc}}.</a></h4> </div>
        <div class="card-body">
            <h5 class="card-title">Xuất sắc: {{ $item->xuat_sac }}. Giỏi: {{ $item->gioi }}. Khá: {{ $item->kha }}. Trung bình: {{ $item->trung_binh }}. Yếu: {{ $item->yeu }}. Kém: {{ $item->kem }}.</h5>
            <div style="float: right;">
                <a href="{{ route('downDot', ['id_dot'=> $item->id_dot_xet]) }}"><i class="fas fa-cloud-download-alt" style="color: red"></i></a>
                <a href=""><i class="fa fa-lock" aria-hidden="true" style="color: red"></i></a>
                <a href=""><i class="fas fa-edit" style="color: red"></i></a>
                <a href="{{ route('get_xoa_dot', ['id_dot'=>$item->id_dot_xet]) }}"><i class="fas fa-trash" style="color: red"></i></a>
            </div>
        </div>
    </div>
@endforeach