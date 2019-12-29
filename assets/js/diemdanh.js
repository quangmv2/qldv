function attendance(btn, id_student) {  
    //điểm danh hoạt động
    var text = $(btn).text()
    $(btn).html('<span class="spinner-border spinner-border-sm"></span>')
    var id = $(btn).attr('id')
    console.log(id)
    $.ajax({
        type: "GET",
        url: window.location.href + "/" + id_student,
        data: {

        },
        dataType: "json",
        success: function (response) {

            console.log(response)
            if (response.code == 500) {
                alert(response.message)
                $(btn).html(text)
                return
            }
            $(btn).removeClass()
            $(btn).addClass(response.class)
            $(btn).html(response.status);
            $('#input'+id).val(response.point)
        }
    })
    .fail(function(error) {
        console.log(error)
        alert('Một ngoại lệ đã xảy ra. Yêu cầu bị chấm dứt. Vui lòng thử lại sau!')
        $(btn).html(text)
    })
}
async function submitNote(id) {  

    //submit ghi chú lên server

    var btn = $('#btn'+id)

    btn.html('<span class="spinner-border spinner-border-sm"></span>')

    var form = $('#form'+id);
    var method = form.attr('method')
    var url = form.attr('action')
    var data = form.serialize();
    var notifi = $('#notificationNote'+id)

    console.log(data)

    await axios({
        method : method,
        url : url,
        data : data
    })
    .then((response)=>{
        console.log(response)
        if (response.data.status == 1) {
            notifi.css('color', '#858796');
        } else{
            notifi.css('color', 'red');
        }
        notifi.html(response.data.message)
        $('#noteTD'+id).html(response.data.note)
    })
    .catch((err)=>{
        console.log(err.response)
        notifi.css('color', 'red')
        notifi.html('Xảy ra ngoại lệ. Lưu không thành công!')
    })

    btn.html('Ghi chú')

}
jQuery(document).ready(function ($) {
    
    $('input').keyup(function (e) { 
        if ($(this).attr('id') === undefined) return;
        if (e.which == 13) {
            e.preventDefault();
        }
        if (this.value == '') return
        if (Number(this.value) > Number(this.max) || Number(this.value) < Number(this.min)){
            $(this).css({borderColor : 'red'});
            return
        } else{
            $(this).css({borderColor : ''})
        }
        
        var point  = Number(this.value)

        axios({
            method : "GET",
            url : window.location.href + "/point/" + $(this).attr('id').split('input')[1] + '?point='+point,
            data : {
               
            }
        })
        .then((response)=>{
            console.log(response)
        })
        .catch((err)=>{
            console.log(err.response)
        })


    });

});

function updatePoint(input, id_student) {  
    axios({
        method : "GET",
        url : window.location.href + "/point/" + id_student+"?type=update",
        data : {
           
        }
    })
    .then((response)=>{
        console.log(response)
        $(input).val(response.data.point)
    })
    .catch((err)=>{
        console.log(err.response)
    })


}