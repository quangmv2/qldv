@extends('client.index')
@section('content')
<div class="container-fluid" style="margin-left: 0px;">

    <div class="row">
    

        <div class="col-sm-12" >
            
            <h1>ĐIỂM DANH <small>Hoạt động {{ $action->name }}</small> </h1>

        </div>

    </div>

</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
                @if (count($errors)>0)
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $element)
                            {{ $element }} <br>
                        @endforeach
                    </div>
                @endif
                @if (session('myErrors'))
                    <div class="alert alert-danger">
                        {{ session('myErrors') }}
                    </div>
                @endif
                @if (session('notification'))
                    <div class="alert alert-success">
                        {{ session('notification') }}
                    </div>
                @endif
        </div>
        @php
            $page = 0;
            if (isset($_GET['page'])) {
                $page = $_GET['page']-1;
            }
        @endphp
        <style>
            td{
                text-align: center
            }
        </style>
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <table class="table table-striped table-bordered table-hover" style="width: 100%">

                <thead>
                    <tr>
                        <td>MÃ SV</td>
                        <td>Họ và tên</td>
                        <td colspan="2">Điểm danh</td>
                        <td>Ghi chú</td>
                    </tr>
                </thead>

                <tbody id="dataStudent">
                    @foreach ($students as $index => $value)
                        <tr>
                            <td>{{ $value->id_student }}</td>
                            <td>{{ $value->profile->first_name." ".$value->profile->last_name}}</td>
                            <td><button class="
                                @if ($value->status == 0)
                                    btn btn-danger
                                @else
                                    btn btn-success
                                @endif    
                            " onclick="attendance(this, '{{$value->id_student}}')">
                            @if ($value->status == 0)
                                Vắng
                            @else
                                Có mặt
                            @endif
                            </button></a></td>
                            <td><a class="btn btn-info btn-sm" style="cursor: pointer" data-toggle="modal" data-target="#popup{{$index}}" data-original-title="Ghi chú"> <i class="fas fa-pencil-alt text-white"></i></a></td>
                            {{-- <td><a href="#" role="button" data-toggle="popup{{$value->id}}" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-sticky-note" style="color: red">
                                </a>
                            </td> --}}
                            <td id="noteTD{{$index}}">{{$value->note}}</td>
                                
                        </tr>
                        <div class="modal fade top" id="popup{{$index}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                            aria-hidden="true" data-backdrop="true">
                            <div class="modal-dialog modal-frame modal-top modal-notify modal-info" role="document">
                            <!--Content-->
                            <div class="modal-content">
                                <!--Body-->
                                <div class="modal-body">
                                    <div class="row d-flex justify-content-center align-items-center">
                                        <h3>{{$value->profile->first_name." ".$value->profile->last_name}}</h3>
                                        <div class="col-sm-12">
                                            <form action="{{ route('note_attendance', ['id_action'=>$action->id_action, 'id_student'=>$value->id_student]) }}" id="form{{$index}}" method="POST" >
                                                <div class="form-group">
                                                    {{ csrf_field() }}
                                                    <label>Ghi chú</label>
                                                    <input class="form-control" type="text" name="note" value="{{$value->note}}" placeholder="Lý do nghỉ, đi muộn, về sớm,...">
                                                </div>
                                                <button class="btn btn-success" type="button" onclick="submitNote({{$index}})" id="btn{{$index}}" >Ghi chú</button>
                                                <p id="notificationNote{{$index}}" style="display: inline; margin-left: 10px;"></p>
                                            </form>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
                                </div>
                            </div>
                            <!--/.Content-->
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready( () => {
        $('form').submit((e)=>{
            e.preventDefault();
            // const form = $(this)
            // console.log(form.attr('id'))
        })
    });
</script>
@endsection