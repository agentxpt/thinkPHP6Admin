$(document).ready(function(){

    $.ajax({
        type : "POST",
        contentType : "application/x-www-form-urlencoded",
        url : "/admin/AdminGenerator/seeAll",
        success : function(res) {
            console.log()
            var i = 1;
            $("#data_num").append(
                "<strong>"+res.result.length+"</strong>"
            );
            for(let key of res.result){

                $("#dataRoom").append(
                    "<tr>" +
                    "<td><input type='checkbox' name='multiple' value="+key['id']+"></td>>" +
                    "<td>"+key['id']+"</td>" +"<td>"+key['table_name']+"</td>" +"<td>"+key['table_comment']+"</td>" +"<td>"+key['catalogue_bind']+"</td>" +"<td>"+key['executor']+"</td>" +"<td>"+key['create_time']+"</td>" +
                    "<td class='td-manage'>" +
                    "<span class='label label - success radius'><a onClick='edit("+key['id']+")'>编辑</a></span>" +
                    "<span class='label radius'><a onClick='delete_single("+key['id']+")'>删除</a></span>" +
                    "</td>" +
                    "</tr>"
                );
                i++;
            }

        }
    });
    $("#add_table_crud").click(function(){
        layer_show('代码生成','/admin/AdminView/add_table_crud',800,500);
    });

    $("#batchDelete").click(function(){
        var ids = [], i = 1;
        $("input[name='multiple']:checked").each(function(index, key){
            ids[i] = $(key).val();
            i++;
        });

        $.ajax({
            type : "POST",
            contentType: "application/x-www-form-urlencoded",
            url : "/admin/AdminGenerator/batchDeleteData",
            data : {
                ids:ids
            },
            success : function(res) {
                if(res.status == 200){
                    window.parent.location.reload();
                }
            }
        });
    })

});

function edit(id) {
    layer_show('代码生成','/admin/AdminGenerator/viewAddEdit?id='+id,800,500);
}

function delete_single(id) {

    $.ajax({
        type : "POST",
        contentType: "application/x-www-form-urlencoded",
        url : "/admin/AdminGenerator/deleteData",
        data : {
            target:id
        },
        success : function(res) {
            if(res.status == 200){
                window.parent.location.reload();
            }
        }
    });

}