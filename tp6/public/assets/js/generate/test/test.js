
$(document).ready(function(){

    $(document).ready(function(){

        $.ajax({
            type : "POST",
            contentType : "application/x-www-form-urlencoded",
            url : "/admin/Test/seeAll",
            success : function(res) {
                var i = 1;
                for(let key of res.result){

                    $("#dataRoom").append(
                        "<tr>" +
                            "<td>"+i+"</td>>" +
"<td>"+key['id']+"</td>" +"<td>"+key['aaa']+"</td>" +"<td>"+key['bbb']+"</td>" +
                            "<td class='td-manage'>" +
                                "<span class='label label - success radius'><a onClick='edit("+key['id']+")'>编辑</a></span>" +
                                "<span class='label radius'><a id='delete"+key['id']+"' href='#'>删除</a></span>" +
                            "</td>" +
                        "</tr>"
                    );
                    i++;
                }

            }
        });

    });
});

function edit(id) {

    layer_show('代码生成','/admin/Test/viewAddEdit?id='+id,800,500);

}


