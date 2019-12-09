<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12" id="notification">
            @if (count($errors)>0)
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $element)
                            {{ $element }} <br>
                        @endforeach
                    </div>
            @endif
            @if (session('myError'))
                    <div class="alert alert-danger">
                        {{ session('myError') }}
                    </div>
            @endif
            @if (session('notification'))
                    <div class="alert alert-success">
                        {{ session('notification') }}
                    </div>
                @endif
        </div>
    </div>
</div>