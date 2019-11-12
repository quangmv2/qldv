@foreach ($list as $item)
    <div class="card text-white bg-dark mb-3">
        <div class="card-header" style="color: black"><h4><a href="">Học kỳ {{$item->hoc_ki}} năm học {{$item->nam_hoc}}.</a></h4> </div>
        <div class="card-body">
            <h5 class="card-title">Xuất sắc: 0. Giỏi: 0. Khá: 0. Trung bình: 0. Yếu: 0. Kém: 0.</h5>
            <div style="float: right;">
                <a href=""><i class="fas fa-edit" style="color: red"></i></a>
                <a href=""><i class="fas fa-trash" style="color: red"></i></a>
            </div>
        </div>
    </div>
@endforeach