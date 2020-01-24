$(document).ready(function(){

    $.ajax({
        type : "POST",
        contentType : "application/x-www-form-urlencoded",
        url : "/admin/AdminBaseAccess/adminInfo",
        success : function(res) {
            if(res.status == 200){
                if(res.result['group_id'] != '*'){
                    $("#super_admin").remove();
                }
            }

        }
    });

    var data = [];
    $.ajax({
        type : "POST",
        contentType : "application/x-www-form-urlencoded",
        url : "/admin/AdminBaseAccess/seeAllTable",
        success : function(res) {
            var i = 1;
            for(let key of res.result){
                key['table_name'] = key['table_name'].replace(/_/g, "");
                key['table_name'] = key['table_name'].firstUpperCase();
                data[i] = key;
                i++;
            }
            show_menu(data)
        }
    });

});

function show_menu(data){

    $.ajax({
        type : "POST",
        contentType : "application/x-www-form-urlencoded",
        url : "/admin/AdminBaseAccess/seeAllCatalogue",
        success : function(res) {

            if(res.result == ""){

                for(let key_data of data){
                    if(typeof key_data == "undefined"){
                        continue;
                    }

                    if(key_data['catalogue_bind'] == '不选择'){
                        $("#catalogue_here").append(
                            "<li><a data-href=\"/admin/"+key_data['table_name']+"/view\" data-title="+key_data['table_comment']+">"+key_data['table_comment']+"</a></li>"
                        );
                    }
                }
            }
            for(let key of res.result){
                $("#catalogue_here").append(
                    "<dl>" +
                        "<dt onclick=\"dis("+key['id']+")\"><i class=\"Hui-iconfont\">"+key['icon']+"</i> "+key['catalogue_name']+"<i class=\"Hui-iconfont menu_dropdown-arrow\">&#xe6d5;</i></dt>" +
                        "<dd id=dd"+key['id']+" style=\"display: none;\" class=\"Hui-menu-item\">" +
                            "<ul id=cato"+key['id']+">" +
                            "</ul>" +
                        "</dd>" +
                    "</dl>"
                );

            }

            for(let key of res.result){


                for(let key_data of data){
                    if(typeof key_data == "undefined"){
                        continue;
                    }

                    if(key_data['catalogue_bind'] == key['id']){

                        $("#cato"+key['id']).append(
                            "<li><a data-href=\"/admin/"+key_data['table_name']+"/view\" data-title="+key_data['table_comment']+">"+key_data['table_comment']+"</a></li>"
                        );
                    }else if(key_data['catalogue_bind'] == '不选择'){
                        $("#catalogue_here").append(
                            "<li><a data-href=\"/admin/"+key_data['table_name']+"/view\" data-title="+key_data['table_comment']+">"+key_data['table_comment']+"</a></li>"
                        );
                    }
                }

            }
        }
    });
}

function dis(id) {

    var v= $('#dd'+id).css('display');
    if(v=='none'){
        $('#dd'+id).css('display','block');
    }else{
        $('#dd'+id).css('display','none');
    }
}

String.prototype.firstUpperCase = function(){
    return this.replace(/\b(\w)(\w*)/g, function($0, $1, $2) {
        return $1.toUpperCase() + $2.toLowerCase();
    });
}