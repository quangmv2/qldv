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
    $.ajax({
        type: "get",
        url: "http://localhost/qldv/admin/student/ajaxList",
        data: {
            id_class : id_class,
        },
        dataType: "json",
        success: function (response) {
            if (response.code == 500) alert("Một ngoại lệ đã xảy ra. Yêu cầu bị chấm dứt. Vui lòng thử lại sau!")
            console.log(response.code)
            
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
        alert('Một ngoại lệ đã xảy ra. Yêu cầu bị chấm dứt. Vui lòng thử lại sau!')
        $('#status').fadeOut(); 
        $('#preloader').delay(100).fadeOut('slow'); 
        $('body').delay(100).css({
            'overflow': 'visible'
        });
    })

}

// jQuery(document).ready(function($) {
//     $('#status').fadeOut(); // will first fade out the loading animation
//     $('#preloader').delay(100).fadeOut('slow'); // will fade out the white DIV that covers the website.
//     $('body').delay(100).css({
//         'overflow': 'visible'
//     });
// });
