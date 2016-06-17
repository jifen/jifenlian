<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>检测时间</title>
<body onload='javascript:reloadPage();'>
最新开始检测时间：<?php echo date('Y-m-d H:i:s');?>



	<script type="text/javascript">



		function reloadPage () {
		   setTimeout(function(){location.reload();},20000);
		}


	</script>


</body>
</html>