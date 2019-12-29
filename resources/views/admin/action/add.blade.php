@extends('admin.index')
@section('content')
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

                        <select name="category" class="form-control"> 
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
                    <div id="chooseStudent">
                        <table class="table table-striped table-bordered table-hover">

                            <thead>
                                <tr>
                                    <th style="text-align: center">Lớp</th>
                                    <th style="text-align: center">Tham gia</th>
                                </tr>
                            </thead>

                            <tbody>
                                
                                @foreach ($class as $index => $value)
                                    <tr>
                                        <td align="center"> {{ $value->id_class }} </td>
                                        <td align="center"> <input type="checkbox" id="test{{ $value->id_class }}" name="id_class[]" class="form-check-input checkbox-large" value="{{ $value->id_class}}"><label for="test{{ $value->id_class }}"></label> </td>
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