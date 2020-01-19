<?php
/**
 *
 *
 * @description:  我起了，一枪秒了，有什么好说的XD
 * @author: shenzheng
 * @time: 2020/1/17 下午4:07
 *
 */


namespace app\common\business\admin;


use think\facade\App;
use think\facade\Db;

class AdminTable{


    public function generateJS($tableName){

        $origin = $tableName;
        $tableName = str_replace("_","",$tableName);

        if(file_exists(App::getRootPath()."public/assets/js/generate/".$tableName."/".$tableName.".js")){
            unlink(App::getRootPath()."public/assets/js/generate/".$tableName."/".$tableName.".js");
        }
        if(file_exists(App::getRootPath()."public/assets/js/generate/".$tableName."/add_edit.js")){
            unlink(App::getRootPath()."public/assets/js/generate/".$tableName."/add_edit.js");
        }
        if(!is_dir(App::getRootPath()."public/assets/js/generate/".$tableName)){
            mkdir(iconv("UTF-8", "GBK", App::getRootPath()."public/assets/js/generate/".$tableName),0777,true);
        }

        $allField = $this -> getAllTableField($origin);

        $template = $this -> templateJS($tableName, $allField);
        file_put_contents(App::getRootPath()."public/assets/js/generate/".$tableName."/".$tableName.".js", $template, FILE_APPEND | LOCK_EX);
        $template = $this -> templateAddEditJS($tableName, $allField);
        file_put_contents(App::getRootPath()."public/assets/js/generate/".$tableName."/add_edit.js", $template, FILE_APPEND | LOCK_EX);

        return 1;
    }

    /**视图生成
     * @param $tableName
     * @return int
     */
    public function generateView($tableName){

        $origin = $tableName;
        $tableName = str_replace("_","",$tableName);

        if(file_exists(App::getAppPath()."view/generate/".$tableName."/".$tableName.".html")){
            unlink(App::getAppPath()."view/generate/".$tableName."/".$tableName.".html");
        }
        if(file_exists(App::getAppPath()."view/generate/".$tableName."/add_edit.html")){
            unlink(App::getAppPath()."view/generate/".$tableName."/add_edit.html");
        }
        if(!is_dir(App::getAppPath()."view/generate/".$tableName)){
            mkdir(iconv("UTF-8", "GBK", App::getAppPath()."view/generate/".$tableName),0777,true);
        }
        $allField = $this -> getAllTableField($origin);
        $fieldNum = count($allField);

        $tableComment = $this -> getTableComment($origin);
        $title = $tableComment[0]["Comment"];

        $template = $this -> templateView($fieldNum, $title, $allField, $tableName);
        file_put_contents(App::getAppPath()."view/generate/".$tableName."/".$tableName.".html", $template, FILE_APPEND | LOCK_EX);
        $template = $this -> templateAddEdit($tableName, $allField);
        file_put_contents(App::getAppPath()."view/generate/".$tableName."/add_edit.html", $template, FILE_APPEND | LOCK_EX);

        return 1;
    }

    /**控制器生成
     * @param $tableName
     * @return int
     */
    public function generateController($tableName){

        $origin = $tableName;
        $tableName = str_replace("_","",$tableName);
        $allField = $this -> getAllTableField($origin);
        $template = $this -> templateController($tableName, $allField, $origin);
        $tableName = ucwords($tableName);

        if(file_exists(App::getAppPath()."controller/".$tableName.".php")){
            unlink(App::getAppPath()."controller/".$tableName.".php");
        }
        file_put_contents(App::getAppPath()."controller/".$tableName.".php", $template, FILE_APPEND | LOCK_EX);

        return 1;
    }

    /**获取所有表名
     * @return array
     */
    public function getAllTables(){
        $str = "SHOW TABLES";
        return Db::query($str);
    }

    /**获取所有字段
     * @param $tableName
     * @return array
     */
    public function getAllTableField($tableName){
        $str = "SHOW FULL FIELDS FROM ".$tableName;
        return Db::query($str);
    }

    /**获取表注释
     * @param $tableName
     * @return array
     */
    public function getTableComment($tableName){
        $str = "SHOW TABLE STATUS LIKE '$tableName'";
        return Db::query($str);
    }

    public function templateAddEditJS($tableName, $allField){

        $lower = $tableName;
        $upper = ucwords($tableName);
$template1 = "
$(document).ready(function() {

    var url = location.search; //获取url中\"?\"符后的字串
    url=decodeURI(url);
    var theRequest = new Object();
    if (url.indexOf(\"?\") != -1) {
        var str = url.substr(1);
        strs = str.split(\"&\");
        for(var i = 0; i < strs.length; i ++) {
            theRequest[strs[i].split(\"=\")[0]]=unescape(strs[i].split(\"=\")[1]);
        }
    }
    var target=theRequest.id;
    $.ajax({
        type : \"POST\",
        contentType : \"application/x-www-form-urlencoded\",
        url : \"/admin/$upper/retrieveData\",
        data : {
            key:'id',
            value:target
        },
        success : function(res) {
";
$template2 = "
        }
    });
    
    $(\"#commit\").click(function() {
";
$template3 = "
        var aaa = $(\"#aaa\").val();
        var bbb = $(\"#bbb\").val();

        $.ajax({
            type : \"POST\",
            contentType: \"application/x-www-form-urlencoded\",
            url : \"/admin/$upper/updateData\",
            data : {
                target:target,
";
$template4 = "
            },
            success : function(res) {
                if(res.status == 200){
                    window.parent.location.reload();
                }
            }
        });
    })

})

";
        $str1 = '';$str2 = '';$str3 = '';
        foreach ($allField as $key){
            $str1 .= "$('#".$key['Field']."').val(res.result[0]['".$key['Field']."']);";
        }
        foreach ($allField as $key){
            $str2 .= "var ".$key['Field']." = $('#".$key['Field']."').val();";
        }
        foreach ($allField as $key){
            $str3 .= $key['Field'].":".$key['Field'].",";
        }
        $str3 = rtrim($str3, ',');
        return $template1.$str1.$template2.$str2.$template3.$str3.$template4;
    }

    /**JS
     * @param $tableName
     * @param $allField
     * @return string
     */
    public function templateJS($tableName, $allField){
        $lower = $tableName;
        $upper = ucwords($tableName);

$template1 = "
$(document).ready(function(){

    $(document).ready(function(){

        $.ajax({
            type : \"POST\",
            contentType : \"application/x-www-form-urlencoded\",
            url : \"/admin/$upper/seeAll\",
            success : function(res) {
                var i = 1;
                for(let key of res.result){

                    $(\"#dataRoom\").append(
                        \"<tr>\" +
                            \"<td>\"+i+\"</td>>\" +
";
$template2 = "
                            \"<td class='td-manage'>\" +
                                \"<span class='label label - success radius'><a onClick='edit(\"+key['id']+\")'>编辑</a></span>\" +
                                \"<span class='label radius'><a id='delete\"+key['id']+\"' href='#'>删除</a></span>\" +
                            \"</td>\" +
                        \"</tr>\"
                    );
                    i++;
                }

            }
        });

    });
});

function edit(id) {

    layer_show('代码生成','/admin/$upper/viewAddEdit?id='+id,800,500);

}


";
        $str = '';
        foreach ($allField as $key){
            $str .= "\"<td>\"+key['".$key['Field']."']+\"</td>\" +";
        }
        return $template1.$str.$template2;
    }

    /**添加编辑视图
     * @param $allField
     * @return string
     */
    public function templateAddEdit($tableName, $allField){

$template1 = "
<!DOCTYPE HTML>
<html>
<head>
	{include file=\"public/_meta\" /}
</head>
<body>
<article class=\"page-container\">
	<form class=\"form form-horizontal\" id=\"form-admin-add\">
";
$template2 = "
	    <div class=\"row cl\">
		    <div class=\"col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3\">
			    <input id='commit' class=\"btn btn-primary radius\" type=\"button\" value=\"&nbsp;&nbsp;提交&nbsp;&nbsp;\">
		    </div>
	    </div>
	</form>
</article>
{include file=\"public/_footer\" /}
<script src=\"/assets/js/generate/$tableName/add_edit.js\"></script>
</body>
</html>
";
        $str = '';
        foreach ($allField as $field){
            $str .= "
            <div class=\"row cl\">
		        <label class=\"form-label col-xs-4 col-sm-3\">".$field['Comment']."</label>
		        <div class=\"formControls col-xs-8 col-sm-9\">
			        <input type=\"text\" class=\"input-text\"id=\"".$field['Field']."\">
		        </div>
	        </div>
            ";
        }
        return $template1.$str.$template2;
    }

    /**视图模版
     * @param $fieldNum
     * @param $title
     * @param $allField
     * @param $tableName
     * @return string
     */
    public function templateView($fieldNum, $title, $allField, $tableName){

        $fieldNum += 2;
$template1 = "
<!DOCTYPE html>
<html lang=\"en\">
<head>
    {include file=\"public/_meta\" /}
</head>
<body>

<nav class=\"breadcrumb\">
    <i class=\"Hui-iconfont\">&#xe67f;</i> 首页
    <span class=\"c-gray en\">&gt;</span> 测试表
    <span class=\"c-gray en\">&gt;</span> 测试表
    <a class=\"btn btn-success radius r\" style=\"line-height:1.6em;margin-top:3px\" href=\"javascript:location.replace(location.href);\" title=\"刷新\" ><i class=\"Hui-iconfont\">&#xe68f;</i></a>
</nav>

<div class=\"page-container\">

    <div class=\"cl pd-5 bg-1 bk-gray mt-20\">
        <span class=\"l\">
            <a href=\"javascript:;\" id='batchDelete' class=\"btn btn-danger radius\">
                <i class=\"Hui-iconfont\">&#xe6e2;</i> 批量删除
            </a>
            <a id=\"add\" href=\"#\" class=\"btn btn-primary radius\">
                <i class=\"Hui-iconfont\">&#xe600;</i> 添加数据
            </a>
        </span>
        <span class=\"r\">共有数据：<strong id='data_num'></strong> 条</span>
    </div>
    
    <table class=\"table table-border table-bordered table-bg\">
        <thead>
            <tr>
                <th scope=\"col\" colspan=\"$fieldNum\">$title</th>
            </tr>
            <tr class=\"text-c\">
                <th></th>
";
$template2 = "
                <th>操作</th>
            </tr>
        </thead>
        <tbody id='dataRoom'>
        </tbody>
    </table>
</div>
{include file=\"public/_footer\" /}
<script src=\"/assets/js/admin/admin.command.js\"></script>
<script src=\"/assets/js/generate/$tableName/$tableName.js\"></script>

</body>
</html>
";
        $str = '';
        foreach ($allField as $field){
            $str .= "<th id='".$field['Field']."'>".$field['Comment']."</th>";
        }
        return $template1.$str.$template2;
    }

    /**控制器模版
     * @param $tableName
     * @return string
     */
    public function templateController($tableName, $allField, $origin){
        $str = '';
        foreach($allField as $key){
            $str .= "'".$key['Field']."',";
        }
        $str = rtrim($str, ',');

        $lower = $tableName;
        $upper = ucwords($tableName);
return "<?php
namespace app\admin\controller;
use app\common\business\lib\BaseMethod;
use think\\facade\View;
class $upper extends BaseMethod {

    public function view(){
        return View::fetch('generate/$lower/$lower');
    }

    public function viewAddEdit(){
        return View::fetch('generate/$lower/add_edit');
    }

    public function retrieveData(){
        \$key = \$this -> request -> param(\"key\", '', 'trim');
        \$value = \$this -> request -> param(\"value\", '', 'trim');
        return \$this -> show(
            config(\"status.success\"),
            config(\"message.success\"),
            \$this -> Retrieve('$origin', \$key, \$value)
        );
    }
    
    public function updateData(){
        \$id = \$this -> request -> param(\"target\", '', 'trim');
        \$data = \$this -> request -> param([$str]);
        \$backInfo = \$this -> Update('$origin', \$id ,\$data);
        return \$this -> show(
            config(\"status.success\"),
            config(\"message.success\"),
            \"更改了\".\$backInfo.\"条数据\"
        );
    }
    
    public function deleteData(){
        \$id = \$this -> request -> param(\"target\", '', 'trim');
        return \$this -> show(
            config(\"status.success\"),
            config(\"message.success\"),
            \$this -> Delete('$origin', \$id)
        );
    }
    
    public function createData(){
        \$data = \$this -> request -> param();
        \$backInfo = \$this -> Create('$origin', \$data);
        if(\$backInfo == 1){
            return \$this -> show(
                config(\"status.success\"),
                config(\"message.success\"),
                NULL
            );
        }
        return \$this -> show(
            config(\"status.failed\"),
            config(\"message.failed\"),
            \$backInfo
        );
    }
    
    public function seeAll(){
        return \$this -> show(
            config(\"status.success\"),
            config(\"message.success\"),
            \$this -> throwAll('$origin')
        );
    }
    
    public function batchDeleteData(){
        \$ids = \$this -> request -> param();
        return \$this -> show(
            config(\"status.success\"),
            config(\"message.success\"),
            \$this -> batchDelete('$origin', \$ids)
        );
    }

}
        ";
    }

}