$(document).ready(function(){

    $(document).ready(function(){

        $.ajax({
            type : "POST",
            contentType : "application/x-www-form-urlencoded",
            url : "/admin/AdminTable/getAllTable",
            success : function(res) {
                for (let key of res.result){

                    $("#tables_name").append(
                        "<option id='key['Tables_in_tp6']'>"+key['Tables_in_tp6']+"</option>"
                    );
                }
            }
        });

    });

    $("#send").click(function(){

        var tableName = $("#tables_name").val();
        $.ajax({
            type : "POST",
            contentType : "application/x-www-form-urlencoded",
            url : "/admin/AdminTable/codeGenerator",
            data : {
                tableName:tableName
            },
            success : function(res) {
                console.log(res);
            }
        });

    });

});