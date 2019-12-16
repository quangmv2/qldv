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
        ajaxSuccess()
    })

}

function loadEnd() {
    //tắt hiệu ứng preloader
    $('#loader').fadeOut(); // will first fade out the loading animation
    $('#preloader').delay(100).fadeOut('slow'); // will fade out the white DIV that covers the website.
    $('body').delay(100).css({
        'overflow': 'visible'
    });
}

function loadBegin() {
    //bật hiệu ứng preloader
    $('#loader').css('display', 'block')
    $('#preloader').css('display', 'block')
}

function callServer(page) {
    //Get dữ liệu phân trang ajax cho mọi phân trang
    loadBegin()
    if (page == null) page = 1;
    // console.log(window.location.href)
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
    .fail(() => {
        ajaxSuccess()
    })
    
}

// var dataState = {
//     urls : [

//     ],

//     titles : [

//     ],
//     documents : [

//     ]
// }


jQuery(document).ready(function($) {
    //bắt sự kiện nhấn phân trang
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        callServer(page)
        $('html, body').animate({scrollTop : 0}, 'slow')
    });

    
    
    // $(document).on('click', '.hrefLink a', async function(event) {
    //     event.preventDefault();
    //     const url = $(this).attr('href');
    //     if (url == '#') return;
    //     var dom;
    //     documents = dataState.documents;
    //     await $.ajax({
    //         method: "GET",
    //         url : url,
    //         data : {
    //             type: 'ajax',
    //             page : 1,
                
    //         },
    //         dataType: "html",
    //         success : (response) => { 
    //             $('#dataPage').html(response)
    //             documents.push(response)
    //         }
    //     })

    //     dataState.documents = documents;
        
    //     urls = dataState.urls
    //     if (urls[urls.length - 1] == url) {
    //         return;
    //     }

    //     console.log(url)
    //     console.log($(this).text().trim())
    //     titles = dataState.titles;
    //     titles.push($(this).text().trim())
    //     dataState.titles = titles
    //     document.title = $(this).text().trim()
    //     urls = dataState.urls
    //     urls.push(url)
    //     dataState.urls = urls

    //     history.pushState(dataState, $(this).text().trim(), url)
    // });

});



$(document).ready(function ($) {
    //submit các form có id myForm ajax
    $('#myForm').submit(function(e){ 
        loadBegin();
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        if (url == '') url = window.location.href;
        var method = form.attr('method');
        var data = form.serialize();

        axios({
            method : method,
            url : url,
            data : data
        })
        .then((response) => {
            console.log(response)
            alertErr(response.data.success, response.data.code)
            loadEnd()
            if (!(response.data.callback === undefined)){
                $('html, body').animate({scrollTop: 0}, 'slow')
                window.location = response.data.callback
            }
        })
        .catch((err) => {
            loadEnd()
            if (err.response === undefined ) {
                ajaxSuccess()
                return
            }
            console.log(err.response)
            alertErr(err.response.data.errors, 500)
        })
        $('html, body').animate({scrollTop: 0}, 'slow')

    });

    //đăng ký hoạt động
    $('#registerAction').on('click', async () => {
        var text = $('#registerAction').text();
        $('#registerAction').html('<span class="spinner-border spinner-border-sm"></span>');
        await axios({
            method : 'POST',
            url : window.location.href,
            data : {
                
            }
        })
        .then((response)=>{
            console.log(response)
            data = response.data
            if (data.status == 0){
                ajaxSuccess(data.err)
                return
            }
            $('#registerAction').html(data.message)
        })
        .catch((err)=>{
            ajaxSuccess()
            $('#registerAction').html(text)
        })
        

    });


});
function alertErr(data, code) {
    //hiển thị các lỗi validte từ server khi submit form
    if (code == 200) {
        var result = '<div class="alert alert-success">'
    } else {
        var result = '<div class="alert alert-danger">'
    }

    console.log(data)

    $.each(data, (index, value) => {
        result +=( value + '<br>')
        console.log(value)
    })

    result+= '</div>'
    console.log(result)
    $('#notification').html(result);

}

function ajaxSuccess(err) {
    //hiển thị thông báo trả về từ server (modal)
    if (err === undefined || err == null || err.length <= 0) 
        err =  "Một ngoại lệ đã xảy ra, yêu cầu bị chấm dứt. Vui lòng thử lại sau!"
    
    loadEnd()
    $('#notificationModal').html(err)
    $('#modelNotification').modal('show');
}



jQuery(document).ready(function($) {

    loadEnd()
    formatP()
    //submit form chi tiết điểm rèn luyện
    $("#idForm").submit(function(e) {

        loadBegin()
        e.preventDefault(); 
    
        var form = $(this);
        var url = form.attr('action');
        var method = form.attr('method');
        var data = form.serialize();
        // $.ajax({
        //     type: method,
        //     url: window.location.href,
        //     data: form.serialize(),
        //     dataType: 'json',
        //     success: function(data)
        //     {
                
                
        //     }
        // }).fail(() => {  
        // })

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
    
    });


});

function danhGia(diem) {  
    //convert điểm => xếp loại
    if (diem >= 90) return "Xuất sắc."
    if (diem >= 80) return "Tốt."
    if (diem >= 65) return "Khá."
    if (diem >= 50) return "Trung bình."
    if (diem >= 40) return "Yếu."
    return "Kém."
}

// if($('#dataPage').text() == '') $('#dataPage').html('Không có dữ liệu')

// window.history.pushState('', 'Title', '/page2.php');
// $(window).bind('scroll', function () {
//     if ($(window).scrollTop() > 50) {
//         console.log(1)
//         $('#accordionSidebar').addClass('fixed');
//     } else {
//         $('#accordionSidebar').removeClass('fixed');
//     }
// });
jQuery(document).ready(function ($) {
    $('#form_profile').submit(function (e) { 
        e.preventDefault();
        $('#form_profile :button').html('<span class="spinner-border spinner-border-sm"></span>')
        var url = $(this).attr('action')
        var method = $(this).attr('method')
        var data = $(this).serialize();
        axios({
          method : method,
          url : url,
          data : data
        })
        .then((response) => {
          console.log(response)
          alert(response.data.message)
          $('#form_profile :button').html('Cập nhật')
        })
        .catch((err) => {
          console.log(err.response)
          alert('Cập nhật thất bại')
          $('#form_profile :button').html('Cập nhật')
        })
    });  
});
function getRndInteger(min, max) {
    var k = max - min + 1;

    return Math.floor(Math.random() * k) + min/10;
}
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