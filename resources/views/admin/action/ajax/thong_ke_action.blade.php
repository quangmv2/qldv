<div class="row">
    @foreach ($data as $item)
        <div class="col-sm-6" id="dau{{ $item['id_class'] }}">
                                    
        </div>
    @endforeach 
</div>

@php
    $data = json_encode($data);
@endphp
<script type="text/javascript">
 
    var data = {!! $data !!}
   
    $.each(data, function (indexInArray, value) { 
        fillPieChart(value.data, 'dau' + value.id_class, 
                    'Lớp '+ value.id_class, value.id_action, 'Chi tiết', 'aGetDetail')
    });
</script>

