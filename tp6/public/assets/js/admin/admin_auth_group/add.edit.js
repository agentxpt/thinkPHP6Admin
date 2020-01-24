
$(document).ready(function() {

    var url = location.search; //获取url中"?"符后的字串
    url=decodeURI(url);
    var theRequest = new Object();
    if (url.indexOf("?") != -1) {
        var str = url.substr(1);
        strs = str.split("&");
        for(var i = 0; i < strs.length; i ++) {
            theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]);
        }
    }
    var target=theRequest.id;
    if(target != -1){
        $.ajax({
            type : "POST",
            contentType : "application/x-www-form-urlencoded",
            url : "/admin/AdminAuthGroup/retrieveData",
            data : {
                key:'id',
                value:target
            },
            success : function(res) {
                $('#id').val(res.result[0]['id']);$('#name').val(res.result[0]['name']);$('#rules').val(res.result[0]['rules']);$('#createtime').val(res.result[0]['createtime']);$('#updatetime').val(res.result[0]['updatetime']);
            }
        });
    
        $("#commit").click(function() {
            var id = $('#id').val();var name = $('#name').val();var rules = $('#rules').val();var createtime = $('#createtime').val();var updatetime = $('#updatetime').val();

            $.ajax({
                type : "POST",
                contentType: "application/x-www-form-urlencoded",
                url : "/admin/AdminAuthGroup/updateData",
                data : {
                    target:target,
                    id:id,name:name,rules:rules,createtime:createtime,updatetime:updatetime
                },
                success : function(res) {
                    if(res.status == 200){
                        window.parent.location.reload();
                    }
                }
            });
        })
    }
    if(target == -1){
        $("#commit").click(function() {
            var id = $('#id').val();var name = $('#name').val();var rules = $('#rules').val();var createtime = $('#createtime').val();var updatetime = $('#updatetime').val();
            $.ajax({
                type : "POST",
                contentType: "application/x-www-form-urlencoded",
                url : "/admin/AdminAuthGroup/createData",
                data : {
                    id:id,name:name,rules:rules,createtime:createtime,updatetime:updatetime
                },
                success : function(res) {
                    if(res.status == 200){
                        window.parent.location.reload();
                    }
                }
            });
        })
    }
})

