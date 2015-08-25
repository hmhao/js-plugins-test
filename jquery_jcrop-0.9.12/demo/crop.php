<?php

/**
 * jQuery图片剪裁插件Jcrop示例脚本
 */

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$targ_w = $targ_h = 150; //保存的图片的大小
	$jpeg_quality = 90;

	$src = '../image/xuwanting.jpg';
	$img_r = imagecreatefromjpeg($src);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
	$targ_w,$targ_h,$_POST['w'],$_POST['h']);

	header('Content-type: image/jpeg');
	imagejpeg($dst_r,null,$jpeg_quality);

	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="description" content="jQuery图像照片剪裁插件Jcrop" />
<title>jQuery图像照片剪裁插件Jcrop</title>
<link rel="stylesheet" href="../css/jquery.Jcrop-0.9.8.css" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.11.3.js"></script>
<script type="text/javascript" src="../js/jquery.browser.js"></script>
<script type="text/javascript" src="../js/jquery.Jcrop-0.9.8.js"></script>
<style type="text/css">
.rel{position: relative;}
.crop_preview{position:absolute; left:520px; top:0; width:150px; height:150px; overflow:hidden;}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		//记得放在jQuery(window).load(...)内调用，否则Jcrop无法正确初始化
		$("#xuwanting").Jcrop({
			aspectRatio:1,
			onChange:showCoords,
			onSelect:showCoords
		});	
		//简单的事件处理程序，响应自onChange,onSelect事件，按照上面的Jcrop调用
		function showCoords(obj){
			$("#x").val(obj.x);
			$("#y").val(obj.y);
			$("#w").val(obj.w);
			$("#h").val(obj.h);
			if(parseInt(obj.w) > 0){
				//计算预览区域图片缩放的比例，通过计算显示区域的宽度(与高度)与剪裁的宽度(与高度)之比得到
				var rx = $("#preview_box").width() / obj.w; 
				var ry = $("#preview_box").height() / obj.h;
				//通过比例值控制图片的样式与显示
				$("#crop_preview").css({
					width:Math.round(rx * $("#xuwanting").width()) + "px",	//预览图片宽度为计算比例值与原图片宽度的乘积
					height:Math.round(rx * $("#xuwanting").height()) + "px",	//预览图片高度为计算比例值与原图片高度的乘积
					marginLeft:"-" + Math.round(rx * obj.x) + "px",
					marginTop:"-" + Math.round(ry * obj.y) + "px"
				});
			}
		}
		$("#crop_submit").click(function(){
			if(parseInt($("#x").val())){
				$("#crop_form").submit();	
			}else{
				alert("要先在图片上划一个选区再单击确认剪裁的按钮哦！");	
			}
		});
	});
</script>
</head>

<body>
<h1>Jcrop照片剪裁插件PHP实时演示</h1>
<div class="rel">
  <img id="xuwanting" src="../image/xuwanting.jpg" />
  <span id="preview_box" class="crop_preview"><img id="crop_preview" src="../image/xuwanting.jpg" /></span>
</div>
<form action="crop.php" method="post" id="crop_form">
  <input type="hidden" id="x" name="x" />
  <input type="hidden" id="y" name="y" />
  <input type="hidden" id="w" name="w" />
  <input type="hidden" id="h" name="h" />
  <input type="button" value="确认剪裁" id="crop_submit" />
</form>
<p><strong>服务器端图片剪裁脚本示例。</strong>当划定选区或移动的时候，一些参数值被传递到了隐藏的表单控件中。当您单击“确认剪裁”按钮后，会传递这些参数，浏览器会获取这些参数并生成一个(这里是150像素*150像素)缩略图并显示出来，您可以试试！</p>
<p><a href="../index.html">&lt;&lt; 返回Demo实例首页</a></p>
</body>
</html>
