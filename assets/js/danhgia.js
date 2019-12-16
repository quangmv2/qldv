var select = false;

jQuery(document).ready(function ($) {
    //bắt sự kiện nhập điểm vào chi tiết điểm rèn luyện
    $("input").keyup(function (e) { 
        if (e.which == 13) {
            e.preventDefault();
        }
        tinhDiem()
        select = true
    });
    //bắt sự kiện thay đổi chi tiết điểm rèn luyện
    $("input").on('change', function () {
        tinhDiem()
        select = true
    });
})

function formatP() {  
    $("#idForm :input").each(function(){
        console.log(isNaN(this.value) + " " + this.max)
        this.required = true
        if (isNaN(this.value)) {
            $(this).val('')
            $(this).val(Number(0))
        }
    })
    
}

function tinhDiem() {
    //duyệt các input trong form kiểm tra validate dữ liệu
    total = 0;
    $("#idForm :input").each(function(){
        if (!isNaN(this.value)){
            if (Number(this.value) > Number(this.max) || Number(this.value) < Number(this.min)){
                $(this).css({borderColor : 'red'});
            } else{
                $(this).css({borderColor : ''})
                total+=Number(this.value)
            }  
        }
        this.title = "Điểm không bé hơn " + this.min + " và không lớn hơn " + this.max
        console.log("Điểm không bé hơn " + this.min + " và không lớn hơn " + this.max)
    });
    $('#total').html(total)
    $('#sum').html('Điểm rèn luyện (sau khi thông qua tập thể lớp và giảng viên chủ nhiệm/cố vấn học tập): ' + total)
    $('#danhgia').html('Xếp loại kết quả rèn luyện (sau khi thông qua tập thể và giảng viên chủ nhiệm/cố vấn học tập): '+ danhGia(total))
    return Number(total);
}
