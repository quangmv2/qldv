jQuery(document).ready(function ($) {

    $('#option').change(function (e) { 
        e.preventDefault();
        var op = $(this).children('option:selected').val();
        if (op == 1){
            $('#chooseStudent').show();
        } else {
            $('#chooseStudent').hide();
        }
    });

    $('#selectClass').change(function (e) { 
        e.preventDefault();
        var op = $(this).children('option:selected').val();
        getStudent(op)
    });

});

function getStudent(id_class, class_name) {
    $('#status').css('display', 'block');
    $('#preloader').css('display', 'block')
    class_name = "18IT5";
    console.log(id_class)
    $.ajax({
        type: "get",
        url: "http://localhost/qldv/admin/student/ajaxList",
        data: {
            id_class : id_class,
        },
        dataType: "json",
        success: function (response) {
            if (response.code == 500) {
                jQuery('#modelNotification').modal({show: true})
                console.log(response.code)
                return 0
            }
            
            data = response.data
            
            console.log(data)
            var result = "";

            $.each(data, function (index, value) { 
                var date = new Date(value.birthday);
                var birthday = date.getDay() + " - " + date.getMonth() + " - " + date.getFullYear()
                result+= "<tr>"+
                              "<td>" + value.id_student + "</td>"+
                              "<td>" + value.first_name + " " + value.last_name + "</td>"+
                              "<td>" + value.email + "</td>"+
                              "<td>" + value.birthday + "</td>"+
                              "<td>" + value.address + "</td>"+
                              "<td>" + class_name + "</td>"+
                              "<td>" + "Xóa" + "</td>"
                
            });

            $('#dataStudent').html(result)
            $('#status').fadeOut(); 
            $('#preloader').delay(100).fadeOut('slow'); 
            $('body').delay(100).css({
                'overflow': 'visible'
            });
        }
    })
    .fail(function() {
        jQuery('#modelNotification').modal({show: true})
        $('#status').fadeOut(); 
        $('#preloader').delay(100).fadeOut('slow'); 
        $('body').delay(100).css({
            'overflow': 'visible'
        });
    })

}

function attendance(btn, id_student) {  
    $.ajax({
        type: "GET",
        url: window.location.href + "/" + id_student,
        data: {

        },
        dataType: "json",
        success: function (response) {
            $(btn).removeClass()
            $(btn).addClass(response.class)
            $(btn).html(response.status);
        }
    })
    .fail(function() {
        alert('Một ngoại lệ đã xảy ra. Yêu cầu bị chấm dứt. Vui lòng thử lại sau!')
    })
}

function loadEnd() {
    $('#loader').fadeOut(); // will first fade out the loading animation
    $('#preloader').delay(100).fadeOut('slow'); // will fade out the white DIV that covers the website.
    $('body').delay(100).css({
        'overflow': 'visible'
    });
}

function loadBegin() {
    $('#loader').css('display', 'block')
    $('#preloader').css('display', 'block')
}

function callServer(page) {
    loadBegin()
    if (page == null) page = 1;
    $.ajax({
        url: window.location.href,
        type: 'GET',
        dataType: 'html',
        data: {
            page    : page,
            type    : 'ajax'
        },
        success : function (data) {
            $('#dataPage').html(data)
            loadEnd()
        }
    })
    .fail(function() {
        loadEnd()
        $('#modelNotification').modal('show');
    })
    
}

jQuery(document).ready(function($) {
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        callServer(page)
        $('html, body').animate({scrollTop : 0}, 'slow')
    });
});

jQuery(document).ready(function($) {
    loadEnd()

    $("#idForm").submit(function(e) {

        loadBegin()
        e.preventDefault(); 
    
        var form = $(this);
        var url = form.attr('action');
        var method = form.attr('method');
        $.ajax({
            type: method,
            url: window.location.href,
            data: form.serialize(),
            dataType: 'json',
            success: function(data)
            {
                console.log(data)
                console.log(data.code)
                data_temp = data
                if (data.code == 200){
                    jQuery('#notification').html("Lưu thành công")
                    loadEnd()
                    jQuery('#modelNotification').modal({show: true})
                }
                
            }
        }).fail(function () {  
            loadEnd()
            jQuery('#notification').html("Một ngoại lệ đã xảy ra, bảng điểm chưa được lưu lại. Vui lòng thử lại sau!")
            jQuery('#modelNotification').modal('show');
        })
    
    });


});

var data_temp;

jQuery(document).ready(function ($) {
    $("input").keyup(function (e) { 
        if (e.which == 13) {
            e.preventDefault();
        }

        tinhDiem()
        
    });

    $("input").on('change', function () {
        tinhDiem()
    });
})

function tinhDiem() {
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
    });
    $('#total').html(total)
    $('#sum').html('Điểm rèn luyện (sau khi thông qua tập thể lớp và giảng viên chủ nhiệm/cố vấn học tập): ' + total)
    $('#danhgia').html('Xếp loại kết quả rèn luyện (sau khi thông qua tập thể và giảng viên chủ nhiệm/cố vấn học tập): '+ danhGia(total))
}

function danhGia(diem) {  
    if (diem >= 90) return "Xuất sắc."
    if (diem >= 80) return "Tốt."
    if (diem >= 65) return "Khá."
    if (diem >= 50) return "Trung bình."
    if (diem >= 40) return "Yếu."
    return "Kém."
}

// window.history.pushState('', 'Title', '/page2.php');
// $(window).bind('scroll', function () {
//     if ($(window).scrollTop() > 50) {
//         console.log(1)
//         $('#accordionSidebar').addClass('fixed');
//     } else {
//         $('#accordionSidebar').removeClass('fixed');
//     }
// });