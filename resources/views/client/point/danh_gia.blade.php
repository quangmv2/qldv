@extends('client.index')
@section('title'){{ $students[$index]->first_name." ".$students[$index]->last_name }} @endsection
@section('script')
<script src="{{ asset('assets/js/danhgia.js') }}"></script>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12 col-md-12">
            <h1 style="text-align: center">{{ $students[$index]->first_name." ".$students[$index]->last_name }}</h1>
            <form action="" method="POST" id="idForm">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 75%; text-align: center">Nội dung đánh giá</th>
                            <th>Khung điểm</th>
                            <th>Điểm do sinh viên tự đánh giá</th>
                            <th>Điểm do tập thể lớp đánh giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>1. ĐÁNH GIÁ VỀ Ý THỨC, THÁI ĐỘ VÀ KẾT QUẢ HỌC TẬP</th>
                            <th style="text-align: center">30</th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>
                                a) Ý thức và thái độ trong học tập: Có đi học chuyên cần, đúng giờ, nghiêm túc trong giờ học; đủ điều kiện dự thi tất cả các học phần (Không đủ điều kiện dự thi 01 học phần bị trừ 02 điểm; không đủ điều kiện dự thi từ 02 học phần trở lên bị trừ hết số điểm còn lại của tiêu chí)
                            </td>
                            <th style="text-align: center">
                                10
                            </th>
                            <td style="text-align: center">{{ renderKQ($my_temp_point->p1a) }}</td>
                            <td><input type="number" class="form-control" min="0" max="10" id="1a" name="p1a" value="{{ $my_point->p1a }}"></td>
                        </tr>
                        <tr>
                            <td>
                                b) Ý thức và thái độ tham gia các hoạt động học tập, hoạt động ngoại khóa, hoạt động nghiên cứu khoa học;
                            </td>
                            <th style="text-align: center">08</th>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                    -	Có đăng ký và hoàn thành đề tài nghiên cứu khoa học đúng tiến độ
                            </td>
                            <td style="text-align: center">03</td>
                            <td style="text-align: center">{{renderKQ($my_temp_point->p1b1) }}</td>
                            <td><input type="number" class="form-control" min="0" max="3" id="1b1" name="p1b1" value="{{ $my_point->p1b1 }}"></td>
                        </tr>
                        <tr>
                            <td>
                                    -	Có ý thức và tham gia các câu lạc bộ học thuật, các hoạt động học thuật, hoạt động ngoại khoá.
                            </td>
                            <td style="text-align: center">05</td>
                            <td style="text-align: center">{{renderKQ($my_temp_point->p1b2)}}</td>
                            <td><input type="number" class="form-control" min="0" max="5" id="1b2" name="p1b2" value="{{ $my_point->p1b2 }}"></td>
                        </tr>
                        <tr>
                            <td>
                                c) Ý thức và thái độ tham gia các kỳ thi, cuộc thi: Không vi phạm quy chế thi
                                    (Vi phạm 01 lần bị trừ 01 điểm, từ lần vi phạm thứ hai trở đi bị trừ hết số điểm còn lại của tiêu chí)
                            </td>
                            <td style="text-align: center">04</td>
                            <td style="text-align: center">{{renderKQ($my_temp_point->p1c)}}</td>
                            <td><input type="number" class="form-control" min="0" max="4" id="1c" name="p1c" value="{{ $my_point->p1c }}"></td>
                        </tr>
                        <tr>
                            <td>
                                    d) Tinh thần vượt khó, phấn đấu vươn lên trong học tập (Được tập thể lớp công nhận có tinh thần vượt khó, phấn đấu vươn lên trong học tập).
                            </td>
                            <td style="text-align: center">02</td>
                            <td style="text-align: center">{{renderKQ($my_temp_point->p1d)}}</td>
                            <td><input type="number" class="form-control" min="0" max="2" id="1d" name="p1d" value="{{ $my_point->p1d }}"></td>
                        </tr>
                        <tr>
                            <td>
                                    đ) Kết quả học tập.
                            </td>
                            <td style="text-align: center">06</td>
                            <td style="text-align: center">{{renderKQ($my_temp_point->p1dd) }}</td>
                            <td style="text-align: center">{{renderKQ($my_point->p1dd)}}</td>
                        </tr>
                        <tr>
                            <td>
                                    -	Điểm TBCHK từ 3,6 đến 4,0
                            </td>
                            <td style="text-align: center">06</td>
                            <td style="text-align: center">{{ $my_temp_point->p1dd>=3.6 ? 6 : '' }}</td>
                            <td><input type="number" class="form-control" min="0" max="6" value="{{ $my_point->p1dd>=3.6 ? 6 : '' }}" disabled></td>
                        </tr>
                        <tr>
                            <td>
                                    -	Điểm TBCHK từ 3,2 đến 3,59 
                            </td>
                            <td style="text-align: center">05</td>
                            <td style="text-align: center">{{ $my_temp_point->p1dd>=3.2 && $my_temp_point->p1dd <= 3.59 ? 5 : '' }}</td>
                            <td><input type="number" class="form-control" min="0" max="6" value="{{ $my_point->p1dd>=3.2 && $my_point->p1dd <= 3.59 ? 5 : '' }}" disabled></td>
                        </tr>
                        <tr>
                            <td>
                                    -	Điểm TBCHK 2,5 đến 3,19  
                            </td>
                            <td style="text-align: center">03</td>
                            <td style="text-align: center">{{ $my_temp_point->p1dd>=2.5 && $my_temp_point->p1dd <= 3.19 ? 3 : '' }}</td>
                            <td><input type="number" class="form-control" min="0" max="6" value="{{ $my_point->p1dd>=2.5 && $my_point->p1dd <= 3.19 ? 3 : '' }}" disabled></td>
                        </tr>
                        <tr>
                            <td>
                                    -	Điểm TBCHK 2,0 đến 2,49  
                            </td>
                            <td style="text-align: center">02</td>
                            <td style="text-align: center">{{ $my_temp_point->p1dd>=2 && $my_temp_point->p1dd <= 2.49 ? 2 : '' }}</td>
                            <td><input type="number" class="form-control" min="0" max="6" value="{{ $my_point->p1dd>=2 && $my_point->p1dd <= 2.49 ? 2 : '' }}" disabled></td>
                        </tr>
                        <tr>
                            <td>
                                    -	Điểm TBCHK dưới 2,0
                            </td>
                            <td style="text-align: center">0</td>
                            <td style="text-align: center">{{ $my_temp_point->p1dd<2 ? 0 : '' }}</td>
                            <td><input type="number" class="form-control" min="0" max="6" value="{{ $my_point->p1dd<2 ? 0 : '' }}" disabled></td>
                        </tr>
                        <tr>
                            <th>
                                    2.	ĐÁNH GIÁ VỀ Ý THỨC CHẤP HÀNH PHÁP LUẬT VÀ NỘI QUY, QUY CHẾ CỦA NHÀ TRƯỜNG
                            </th>
                            <th style="text-align: center">25</th>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                    a) Ý thức chấp hành các quy định của pháp luật đối với công dân, các văn bản chỉ đạo của Bộ, ngành, của cơ quan quản lý thực hiện trong Nhà trường
                            </td>
                            <td style="text-align: center">10</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                    -	Có ý thức chấp hành các quy định của pháp luật đối với công dân, các văn bản chỉ đạo của Bộ, ngành, của cơ quan quản lý thực hiện trong Nhà trường (Vi phạm 01 lần bị trừ 02 điểm, từ lần vi phạm thứ hai trở đi bị trừ hết số điểm còn lại của tiêu chí).
                            </td>
                            <td style="text-align: center">06</td>
                            <td style="text-align: center">{{renderKQ($my_temp_point->p2a1)}}</td>
                            <td><input type="number" class="form-control" min="0" max="6" id="2a1" name="p2a1" value="{{ $my_point->p2a1 }}"></td>
                        </tr>
                        <tr>
                            <td>
                                    -	Có ý thức tham gia đầy đủ, đạt yêu cầu các cuộc vận động, sinh hoạt chính trị theo chủ trương, của cấp trên, ĐHĐN và Nhà trường (Không tham gia 01 lần hoặc vi phạm quy định của các cuộc vận động bị trừ 01 điểm, từ lần vi phạm thứ hai trở đi bị trừ hết số điểm còn lại của tiêu chí).
                            </td>
                            <td style="text-align: center">04</td>
                            <td style="text-align: center">{{renderKQ($my_temp_point->p2a2)}}</td>
                            <td><input type="number" class="form-control" min="0" max="4" id="2a2" name="p2a2" value="{{ $my_point->p2a2 }}"></td>
                        </tr>
                        <tr>
                            <td>
                                    b) Ý thức chấp hành các nội quy, quy chế và các quy định khác của Nhà trường.
                            </td>
                            <td style="text-align: center">15</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                    -	Có ý thức chấp hành nội quy, quy chế và các quy định của Nhà trường (Vi phạm 01 lần bị trừ 02 điểm, từ lần vi phạm thứ ba trở đi bị trừ hết số điểm còn lại của tiêu chí.)
                            </td>
                            <td style="text-align: center">05</td>
                            <td style="text-align: center">{{renderKQ($my_temp_point->p2b1)}}</td>
                            <td><input type="number" class="form-control" min="0" max="5" id="2b1" name="p2b1" value="{{ $my_point->p2b1 }}"></td>
                        </tr>
                        <tr>
                            <td>
                                    -	Có ý thức chấp hành quy định về đóng học phí (Đóng học phí trễ hạn (không có phép) bị trừ 03 điểm, học phí trễ hạn (có phép) bị trừ 01 điểm; không đóng học phí bị trừ hết số điểm được cộng của tiêu chí).
                            </td>
                            <td style="text-align: center">05</td>
                            <td style="text-align: center">{{renderKQ($my_temp_point->p2b2)}}</td>
                            <td><input type="number" class="form-control" min="0" max="5" id="2b2" name="p2b2" value="{{ $my_point->p2b2 }}"></td>
                        </tr>
                        <tr>
                            <td>
                                    -	Có tham gia bảo hiểm y tế (bắt buộc) theo Luật bảo hiểm y tế  (Không tham gia bảo hiểm y tế (bắt buộc) bị trừ 05 điểm).
                            </td>
                            <td style="text-align: center">05</td>
                            <td style="text-align: center">{{renderKQ($my_temp_point->p2b3)}}</td>
                            <td><input type="number" class="form-control" min="0" max="5" id="2b3" name="p2b3" value="{{ $my_point->p2b3 }}"></td>
                        </tr>
                        <tr>
                            <th>
                                    3.	ĐÁNH GIÁ VỀ Ý THỨC THAM GIA CÁC HOẠT ĐỘNG CHÍNH TRỊ - XÃ HỘI, VĂN HÓA, VĂN NGHỆ, THỂ THAO, PHÒNG, CHỐNG TỘI PHẠM, TỆ NẠN XÃ HỘI, BẠO LỰC HỌC ĐƯỜNG
                            </th>
                            <th style="text-align: center">25</th>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                    a) Ý thức và hiệu quả tham gia các hoạt động rèn luyện về chính trị, xã hội, văn hóa, văn nghệ, thể thao. Sinh viên là người khuyết tật, được đánh giá ý thức tham gia các hoạt động tùy theo tình trạng sức khỏe phù hợp, đảm bảo sự công bằng trong từng trường hợp cụ thể:
                            </td>
                            <td style="text-align: center">15</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                    -	Tham gia đầy đủ, đạt yêu cầu “Tuần sinh hoạt công dân sinh viên” 
                                    (Vắng 01 lần (không có phép) bị trừ 02 điểm; Tham gia nhưng kết quả không đạt thì phải học lại và bị trừ 04 điểm; Không tham gia thì phải học lại và bị trừ 10 điểm)
                            </td>
                            <td style="text-align: center">10</td>
                            <td style="text-align: center">{{renderKQ($my_temp_point->p3a1)}}</td>
                            <td><input type="number" class="form-control" min="0" max="10" id="3a1" name="p3a1" value="{{ $my_point->p3a1 }}"></td>
                        </tr>
                        <tr>
                            <td>
                                    -	Có ý thức tham gia đầy đủ, nghiêm túc hoạt động rèn luyện về chính trị, xã hội, văn hóa, văn nghệ, thể thao do Nhà trường và ĐHĐN tổ chức, điều động
                                    (Vắng 01 lần (không có phép) bị trừ 02 điểm)
                            </td>
                            <td style="text-align: center">05</td>
                            <td style="text-align: center">{{renderKQ($my_temp_point->p3a2)}}</td>
                            <td><input type="number" class="form-control" min="0" max="5" id="3a2" name="p3a2" value="{{ $my_point->p3a2 }}"></td>
                        </tr>
                        <tr>
                            <td>
                                    b) Ý thức tham gia các hoạt động công ích, tình nguyện, công tác xã hội:
                            </td>
                            <td style="text-align: center">06</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                    -	Có ý thức tham gia các hoạt động công ích, tình nguyện, công tác xã hội trong nhà trường.
                            </td>
                            <td style="text-align: center">04</td>
                            <td style="text-align: center">{{renderKQ($my_temp_point->p3b1) }}</td>
                            <td><input type="number" class="form-control" min="0" max="4" id="3b1" name="p3b1" value="{{ $my_point->p3b1 }}"></td>
                        </tr>
                        <tr>
                            <td>
                                    -	Có thành tích được ghi nhận, biểu dương, khen thưởng khi tham gia các hoạt động công ích, tình nguyện, công tác xã hội trong Nhà trường.
                            </td>
                            <td style="text-align: center">01</td>
                            <td style="text-align: center">{{renderKQ($my_temp_point->p3b2) }}</td>
                            <td><input type="number" class="form-control" min="0" max="1" id="3b2" name="p3b2" value="{{ $my_point->p3b2 }}"></td>
                        </tr>
                        <tr>
                            <td>
                                    -	Có tinh thần chia sẻ, giúp đỡ người gặp khó khăn, hoạn nạn.
                            </td>
                            <td style="text-align: center">01</td>
                            <td style="text-align: center">{{ renderKQ($my_temp_point->p3b3) }}</td>
                            <td><input type="number" class="form-control" min="0" max="1" id="3b3" name="p3b3" value="{{ $my_point->p3b3 }}"></td>
                        </tr>
                        <tr>
                            <td>
                                    c) Tham gia tuyên truyền, phòng chống tội phạm và các tệ nạn xã hội.
                            </td>
                            <td style="text-align: center">04</td>
                            <td style="text-align: center">{{renderKQ($my_temp_point->p3c) }}</td>
                            <td><input type="number" class="form-control" min="0" max="4" id="3c" name="p3c" value="{{ $my_point->p3c }}"></td>
                        </tr>
                        <tr>
                            <th>
                                    4.	ĐÁNH GIÁ VỀ Ý THỨC VÀ KẾT QỦA THAM GIA CÔNG TÁC CÁN BỘ LỚP, CÔNG TÁC ĐOÀN THỂ, CÁC TỔ CHỨC KHÁC CỦA NHÀ TRƯỜNG HOẶC CÓ THÀNH TÍCH XUẤT SẮC TRONG HỌC TẬP, RÈN LUYỆN ĐƯỢC CƠ QUAN CÓ THẨM QUYỀN KHEN THƯỞNG.
                            </th>
                            <th style="text-align: center">20</th>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                    a) Ý thức, tinh thần, thái độ, uy tín, kỹ năng tổ chức và hiệu quả công việc của học sinh, sinh viên được phân công nhiệm vụ quản lý lớp, các tổ chức Đảng, Đoàn Thanh niên, Hội sinh viên và các tổ chức khác của sinh viên trong Nhà trường;
                            </td>
                            <td style="text-align: center">10</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                    -	Uỷ viên Ban chấp hành (BCH) Đoàn Thanh niên, Hội sinh viên Đại học Đà Nẵng và Bí thư Liên chi đoàn, Uỷ viên BCH Liên chi, Bí thư chi đoàn, Lớp trưởng, Ban đại diện sinh viên nội trú
                            </td>
                            <td style="text-align: center">05</td>
                            <td style="text-align: center">{{ renderKQ($my_temp_point->p4a1) }}</td>
                            <td><input type="number" class="form-control" min="0" max="5" id="4a1" name="p4a1" value="{{ $my_point->p4a1 }}"></td>
                        </tr>
                        <tr>
                            <td>
                                    -	Lớp phó, Uỷ viên chi đoàn, Trưởng, phó các câu lạc bộ/Hội/ Nhóm hoạt động tốt được tập thể công nhận.
                            </td>
                            <td style="text-align: center">03</td>
                            <td style="text-align: center">{{renderKQ($my_temp_point->p4a2)}}</td>
                            <td><input type="number" class="form-control" min="0" max="3" id="4a2" name="p4a2" value="{{ $my_point->p4a2 }}"></td>
                        </tr>
                        <tr>
                            <td>
                                    -	Tổ trưởng, và sinh viên có đóng góp cho phong trào lớp, khoa, trường được tập thể công nhận. 
                            </td>
                            <td style="text-align: center">02</td>
                            <td style="text-align: center">{{renderKQ($my_temp_point->p4a3)}}</td>
                            <td><input type="number" class="form-control" min="0" max="2" id="4a3" name="p4a3" value="{{ $my_point->p4a3 }}"></td>
                        </tr>
                        <tr>
                            <td>
                                    b) Hỗ trợ và tham gia tích cực vào các hoạt động chung của lớp, khoa và Nhà trường (Vắng từ 02 buổi trừ  trở lên trừ hết số điểm được cộng). 
                            </td>
                            <td style="text-align: center">08</td>
                            <td style="text-align: center">{{renderKQ($my_temp_point->p4b)}}</td>
                            <td><input type="number" class="form-control" min="0" max="8" id="4b" name="p4b" value="{{ $my_point->p4b }}"></td>
                        </tr>
                        <tr>
                            <td>
                                    c) Có thành tích trong nghiên cứu khoa học, tham gia các cuộc thi, sáng kiến cải tiến kỹ thuật được Nhà trường hoặc các cơ quan có thẩm quyền khen thưởng (bằng khen, giấy khen...).
                            </td>
                            <td style="text-align: center">02</td>
                            <td style="text-align: center">{{renderKQ($my_temp_point->p4c)}}</td>
                            <td><input type="number" class="form-control" min="0" max="2" id="4c" name="p4c" value="{{ $my_point->p4c }}"></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Tổng điểm 4 tiêu chí</strong>
                            </td>
                            <td style="text-align: center">
                                <strong>100</strong>
                            </td>
                            <td style="text-align: center">{{$my_temp_point->p4c == null ? 'Chưa đánh giá' : $my_temp_point->total }}</td>
                            <td style="text-align: center"><p id="total"></p></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align: center"><button type="button" class="btn btn-danger"
                                @if ($index == count($students)-1)
                                disabled
                            @else 
                                onclick="location = '{{ route('getDanhGia', ['id_dot' => $students[0]->id_dot, 'id_detail'=> $students[$index + 1]->id_point, 'name' => tenKhongDau( $students[$index + 1]->first_name . ' ' . $students[$index + 1]->last_name ),'id_student' => $students[$index  + 1]->id_student]) }}?type=dismis&id={{$my_point->id_point}}'"
                            @endif   
                            >Bỏ qua</button></td>
                            <td style="text-align: center"><button type="submit" class="btn btn-success">Submit</button></td>
                        </tr>
                    </tbody>
                </table>
                {{ csrf_field() }}
            </form>
            <p style="color: black"><strong id="sum"></strong></p>
            <p style="color: black"><strong id="danhgia"></strong></p>
            <button class="btn btn-success" type="button" 
            @if ($index == 0)
                disabled
            @else 
                onclick="location = '{{ route('getDanhGia', ['id_dot' => $students[0]->id_dot, 'id_detail'=> $students[$index - 1]->id_point, 'name' => tenKhongDau( $students[$index - 1]->first_name . ' ' . $students[$index - 1]->last_name ),'id_student' => $students[$index  - 1]->id_student]) }}'"
            @endif
            
            >Previous</button>
            <button class="btn btn-success" style="float: right" id="nextBTN"
            @if ($index == count($students)-1)
                disabled
            @else 
                onclick="location = '{{ route('getDanhGia', ['id_dot' => $students[0]->id_dot, 'id_detail'=> $students[$index + 1]->id_point, 'name' => tenKhongDau( $students[$index + 1]->first_name . ' ' . $students[$index + 1]->last_name ),'id_student' => $students[$index  + 1]->id_student]) }}'"
            @endif
            >Next</button>
        </div>
        
    </div>
</div>
{{-- @if ($my_point->total  == 65)
<script type="text/javascript">

    function renderType(type, point) {  
        switch (type) {
            case 0:
                if (point >= 90) return true;
                break;
            case 1:
                if (point < 90 && point >=80) return true;
                break;
            case 2:
                if (point < 80 && point >= 65) return true;
                break;
            case 3:
                if (point < 65 && point >= 50) return true;
                break;
            case 4:
                if (point < 50 && point >= 40) return true;
                break;
            case 5:
                if (point < 40) return true;
                break;
        }
        return false;
    }
    async function autord() {  
        var type = getRndInteger(0, 1);
        var count = 0;
        do{
            count++;
            $("#idForm :input").each(function(){
                if (!($(this).attr('disabled') === undefined)) return;
                var rd = getRndInteger(this.min, this.max)
                $(this).val(rd)
            });
            console.log(type +" " + tinhDiem())
            console.log(renderType(type, tinhDiem()))
            if (count == 1000) {
                type = getRndInteger(0, 1);
                count = 0;
            }
        } while(!renderType(type, tinhDiem()))

        tinhDiem()
        var form = $("#idForm");
        var url = form.attr('action');
        var method = form.attr('method');
        var data = form.serialize();
        axios({
            method : method,
            url : window.location.href,
            data : data
        })
        .then((response) => {
            console.log(response)
            console.log(response.data.code)
            data_temp = response
            if (response.data.code == 200){
                ajaxSuccess("Lưu thành công")
            }
        })
        .catch((err) => {
            console.log(err.response)
            ajaxSuccess("Một ngoại lệ đã xảy ra, bảng điểm chưa được lưu lại. Vui lòng thử lại sau!");
        })

        setTimeout(() => {
            $('#nextBTN').click()
        }, 1);
    }
    autord();
    
</script>
@else
<script type="text/javascript">
    $('#nextBTN').click()
</script>
@endif --}}
<script type="text/javascript">
    tinhDiem()
</script>
@endsection