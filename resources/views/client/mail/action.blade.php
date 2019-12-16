<h3>Xin chào {{$context->fullname}}</h3>
<p>Hoạt động {{$context->name}} diễn ra vào ngày {{\Carbon\Carbon::parse($context->time)->format('d/m/Y')}}</p>
<p>Chi tiết xem <a href="{{$context->link}}">tại đây</a></p>