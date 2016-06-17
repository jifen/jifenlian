<?php
// +----------------------------------------------------------------------
// | ThinkPHP
// +----------------------------------------------------------------------
// | Copyright (c) 2007 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

/* --------------------公共函数----------------------*/

	//通过玩家AutoId找到玩家编号user_id
	function user_id($id){
		$rs = M ('fck') -> where('id ='.$id) -> field('user_id') -> find();
		return $rs['user_id'];
	}
	
	function cp_name($cid){
		$rs = M ('cptype') -> where('id ='.$cid) -> field('tpname') -> find();
		if($rs){
			return $rs['tpname'];
		}else{
			return "无";
		}
	}


function url_encode($url){

	return urlencode($url);

}



function chanpin($id){
	$rs = M ('product') -> where('id ='.$id) -> field('name') -> find();
	return $rs['name'];
}

function shangpin($id){
	$rs = M ('shangpin') -> where('id ='.$id) -> field('name') -> find();
	return $rs['name'];
}

function fenlei($id){
	$rs = M ('shangpin') -> where('id ='.$id) -> field('cptype') -> find();

	$rss = M ('cptype') -> where('id ='.$rs['cptype']) -> field('tpname') -> find();
	return $rss['tpname'];
}


function baodan($id){
	$rs = M ('fck') -> where('shop_id ='.$id) -> count();
	return $rs;
}


function renshu($province){
	$map['province']=array('eq',$province);
	$rs = M ('fck') -> where($map) -> count();
	return $rs;
}



function mysubstr($string, $sublen, $start = 0, $code = 'UTF-8'){
		//字符串截取函数 默认UTF-8
		if($code == 'UTF-8'){
			$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
			preg_match_all($pa, $string, $t_string);
	
			if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen))."...";
			return join('', array_slice($t_string[0], $start, $sublen));
		}else{
			$start = $start*2;
			$sublen = $sublen*2;
			$strlen = strlen($string);
			$tmpstr = '';
	
			for($i=0; $i< $strlen; $i++)
			{
				if($i>=$start && $i< ($start+$sublen))
				{
					if(ord(substr($string, $i, 1))>129)
					{
						$tmpstr.= substr($string, $i, 2);
					}
					else
					{
						$tmpstr.= substr($string, $i, 1);
					}
				}
				if(ord(substr($string, $i, 1))>129) $i++;
			}
			if(strlen($tmpstr)< $strlen ) $tmpstr.= "...";
			return $tmpstr;
		}
	}

	//如果user_id等于800000就返回公司
	function conname($n){
		if($n == '800000'){
			return '公司';
		}else{
			return $n;
		}
	}

	function pwdHash($password, $type = 'md5') {
		return hash ( $type, $password );
	}
	//对密码进行加密
	function pwdHash_pass($password, $type = 'md5') {
		return hash ( $type, $password );
	}
	
	function noHTML($content){
		
		$content = preg_replace("/<a[^>]*>/i",'', $content);
		$content = preg_replace("/<\/a>/i", '', $content);
		$content = preg_replace("/<div[^>]*>/i",'', $content);
		$content = preg_replace("/<\/div>/i",'', $content);
		$content = preg_replace("/<font[^>]*>/i",'', $content);
		$content = preg_replace("/<\/font>/i",'', $content);
		$content = preg_replace("/<p[^>]*>/i",'', $content);
		$content = preg_replace("/<\/p>/i",'', $content);
		$content = preg_replace("/<span[^>]*>/i",'', $content);
		$content = preg_replace("/<\/span>/i",'', $content);
		$content = preg_replace("/<\?xml[^>]*>/i",'', $content);
		$content = preg_replace("/<\/\?xml>/i",'', $content);
		$content = preg_replace("/<o:p[^>]*>/i",'', $content);
		$content = preg_replace("/<\/o:p>/i",'', $content);
		$content = preg_replace("/<u[^>]*>/i",'', $content);
		$content = preg_replace("/<\/u>/i",'', $content);
		$content = preg_replace("/<b[^>]*>/i",'', $content);
		$content = preg_replace("/<\/b>/i",'', $content);
		$content = preg_replace("/<meta[^>]*>/i",'', $content);
		$content = preg_replace("/<\/meta>/i",'', $content);
		$content = preg_replace("/<!--[^>]*-->/i",'', $content);
		$content = preg_replace("/<p[^>]*-->/i",'', $content);
		$content = preg_replace("/style=.+?['|\"]/i",'',$content);
		$content = preg_replace("/class=.+?['|\"]/i",'',$content);
		$content = preg_replace("/id=.+?['|\"]/i",'',$content);
		$content = preg_replace("/lang=.+?['|\"]/i",'',$content);
		$content = preg_replace("/width=.+?['|\"]/i",'',$content);
		$content = preg_replace("/height=.+?['|\"]/i",'',$content);
		$content = preg_replace("/border=.+?['|\"]/i",'',$content);
		$content = preg_replace("/face=.+?['|\"]/i",'',$content);
		$content = preg_replace("/face=.+?['|\"]/",'',$content);
		$content = preg_replace("/face=.+?['|\"]/",'',$content);
		$content = str_replace( " ","",$content);
		$content = str_replace( "&nbsp;","",$content);
		return $content;
	}

?>