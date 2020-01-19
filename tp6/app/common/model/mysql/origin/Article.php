<?php
namespace app\common\model\mysql\origin;

use think\Model;

class Article extends Model{
	
	public function getArticleById($key){

        return $this -> where('id', $key)
							-> find()
							-> toArray();
		
	}
	
}