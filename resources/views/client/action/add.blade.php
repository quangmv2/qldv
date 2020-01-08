@extends('client.index')
@section('title')Thêm mới hoạt động @endsection

@section('content')
<script>

    $(document).ready(function () {
        
        $('#autoSelect').click(async function (e) { 
            e.preventDefault();
            var list = {}
            var category = $('#category :selected').val()
            await axios({
                method: "GET",
                url: window.location.href +"/example?category=" + category + '&count=' + $('#countRes').val(),
                data: {

                },
            })
            .then((response)=>{
                console.log(response)
                list = response.data
            })
            .catch((err)=>{
                console.log(err.response)
            })

            await $('#myForm :input:checkbox').each(function (index, element) {
                var checkbox = this
                $(checkbox).attr('checked', false)
                var id_student = $(this).val()
                $.each(list, function (indexInArray, valueOfElement) { 
                    if (id_student == valueOfElement.id_student) $(checkbox).attr('checked', true)
                });
            });

            console.log('inp')
            
        });
    });

   

</script>
<div class="container-fluid" style="margin-left: 0px;">

    <div class="row">
    

        <div class="col-sm-12" >
            
            <h1>THÊM MỚI <small>Hoạt động</small> </h1>

        </div>

    </div>

</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            
                <form action="" method="POST" enctype="multipart/form-data" id="myForm">

                    {{ csrf_field() }}

                    <div class="form-group">

                        <label>Tên hoạt động</label>

                        <input type="text" name="name" value="" class="form-control" placeholder="Tên hoạt động" >

                    </div>

                    <div class="form-group">

                        <label>Thể  loại</label>

                        <select name="category" class="form-control" id="category">
                            @foreach ($categorys as $category)
                                <option value="{{ $category->id_category }}">{{ $category->name }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="form-group">

                            <label>Ngày giờ</label>

                            <input type="date" name="time" value="" class="form-control" placeholder="Họ và tên" >

                    </div>
                    
                    <div class="form-group">
                        <label>Nội dung</label>
                        <textarea id="editor01" name="content" class="form-control" placeholder="Nội dung..."></textarea>
                        <script>

							CKEDITOR.replace( 'editor01',{

							        filebrowserBrowseUrl: '{{ asset('ckfinder/ckfinder.html') }}',

							        filebrowserImageBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Images') }}',

							        filebrowserFlashBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Flash') }}',

							        filebrowserUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}',

							        filebrowserImageUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}',

							        filebrowserFlashUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}'

							    } );

	            		</script>
                    </div>

                    <div class="form-group">

                        <label style="display:block;">Thành viên tham gia</label>
                        <select name="object" id="option" class="form-control">
                            <option value="0">Cả lớp</option>
                            <option value="1">Thành viên</option>
                            <option value="2">Đăng ký</option>
                        </select>
			        
                    </div>
                    
                    <div class="form-group" id="res" style="display: none">

                        <label style="display:inline;">Số lượng</label>
                        <input type="number" class=" col-sm-2 form-control" name="res" value="0" style="display: inline">
                
                    </div>    
                
                    <div id="chooseStudent" style="display: none">
                        <div class="col-sm-1" style="float: left">
                            <input type="number" class="form-control" value="0" id="countRes">
                        </div>
                        <button type="button" class="btn btn-success" id="autoSelect" style="float: right; margin-bottom: 10px">Tự chọn</button>
                        <table class="table table-striped table-bordered table-hover">

                            <thead>
                                <tr>
                                    <th style="text-align: center">Mã SV</th>
                                    <th style="text-align: center">Họ và tên</th>
                                    <th style="text-align: center">Tham gia</th>
                                </tr>
                            </thead>

                            <tbody>
                                
                                @foreach ($students as $index => $value)
                                    <tr>
                                        <td align="center"> {{ $value->id_student }} </td>
                                        <td align="center"> {{$value->profile->first_name." ".$value->profile->last_name}} </td>
                                        <td align="center"> <input type="checkbox" id="test{{ $value->id_student }}" name="id_student[]" class="form-check-input checkbox-large" value="{{ $value->id_student }}"><label for="test{{ $value->id_student }}"></label> </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div>

                    <input type="submit" name="submit" class="btn btn-primary" value="THÊM MỚI">

                </form>
        </div>

    </div>
</div>


<style>
    /* Base for label styling */
    [type="checkbox"]:not(:checked),
    [type="checkbox"]:checked {
    position: absolute;
    left: -9999px;
    }
    [type="checkbox"]:not(:checked) + label,
    [type="checkbox"]:checked + label {
    position: relative;
    padding-left: 1.95em;
    cursor: pointer;
    }

    /* checkbox aspect */
    [type="checkbox"]:not(:checked) + label:before,
    [type="checkbox"]:checked + label:before {
    content: '';
    position: absolute;
    left: 0; top: 0;
    width: 1.25em; height: 1.25em;
    border: 2px solid #ccc;
    background: #fff;
    border-radius: 4px;
    box-shadow: inset 0 1px 3px rgba(0,0,0,.1);
    }
    /* checked mark aspect */
    [type="checkbox"]:not(:checked) + label:after,
    [type="checkbox"]:checked + label:after {
    content: '\2713\0020';
    position: absolute;
    top: .15em; left: .22em;
    font-size: 1.3em;
    line-height: 0.8;
    color: #09ad7e;
    transition: all .2s;
    font-family: 'Lucida Sans Unicode', 'Arial Unicode MS', Arial;
    }
    /* checked mark aspect changes */
    [type="checkbox"]:not(:checked) + label:after {
    opacity: 0;
    transform: scale(0);
    }
    [type="checkbox"]:checked + label:after {
    opacity: 1;
    transform: scale(1);
    }
    /* disabled checkbox */
    [type="checkbox"]:disabled:not(:checked) + label:before,
    [type="checkbox"]:disabled:checked + label:before {
    box-shadow: none;
    border-color: #bbb;
    background-color: #ddd;
    }
    [type="checkbox"]:disabled:checked + label:after {
    color: #999;
    }
    [type="checkbox"]:disabled + label {
    color: #aaa;
    }
    /* accessibility */
    [type="checkbox"]:checked:focus + label:before,
    [type="checkbox"]:not(:checked):focus + label:before {
    border: 2px dotted blue;
    }

</style>
    
@endsection