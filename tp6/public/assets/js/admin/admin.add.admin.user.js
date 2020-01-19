$(document).ready(function(){

    $("#login_send").click(function(){
        var username = $("#username").val();
        var password = $("#password").val();

        $.ajax({
            type : "POST",
            contentType: "application/x-www-form-urlencoded",
            url : "/admin/AdminUser/addAdminUser",
            data : {
                username:username,
                password:password
            },
            success : function(res) {

                console.log(res);
                if(res.status == 0){
                    $("#remove").remove();
                    $("#alert").append(
                        "<div id='remove'><p>"+res.result+"</p></div>"
                    );

                }else if(res.status == 200){
                    $(window).attr('location','/admin/adminIndex');
                }

            }
        });

    });


});