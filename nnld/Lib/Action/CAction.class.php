<?php
class CAction extends Action {
	// 框架首页
	public function index() {


	/*


		$url='https://www.allcoin.com/';
		$data=$this->get_file($url);
		$match=array();
		$pattern='/<div\id=\"area_USD\"\class=\"col-xs-12\">[\s\S]*<\/div>/';



		preg_match($pattern,$data,$match);
		print_r($data);


		*/


		$url = "https://www.allcoin.com/";
		$ch = curl_init();
		$timeout = 50;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		//在需要用户检测的网页里需要增加下面两行
		//curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		//curl_setopt($ch, CURLOPT_USERPWD, US_NAME.":".US_PWD);
		$contents = curl_exec($ch);
		curl_close($ch);

		if(preg_match("/<table[^>]+>(.*)<\/table>/isU", $contents ,$match)) {


			print_r($match[0]);

		} else {
			echo "不匹配.";
		}





	}



	public function get_file($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION ,1); //加入重定向处理
		$output = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);
		return $output;
	}





/*

	// 框架首页
	public function index() {


		$url='https://www.allcoin.com/';
		$data=get_file($url);
		print_r($data);
		$pattern='你的内容正则表达式';
		//	perg_match($pattern,$data,$match);

		//	print_r($match);


	}










*/







}
?>