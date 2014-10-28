<?php

if( $_SERVER["HTTP_HOST"] == 'localhost' || $_SERVER["HTTP_HOST"] == '127.0.0.1' || $_SERVER["HTTP_HOST"] == 'local.olympe.in' )
	exit();

$url = str_replace(array('..', '\\', '|', '*', ' ', 'http://'), array('', '', '', '', '', ''), $_GET['url']);
$file = $url.'.png';

function resize($content)
{
	$percent = 0.5;
	
	if( $content )
	{
		$filename = '/tmp/' . md5(time());
		file_put_contents($filename, $content);
			
		list($width, $height) = getimagesize($filename);
		$thumb_w = $width * $percent;
		$thumb_h = $height * $percent;

		$source = imagecreatefrompng($filename);
		imageAlphaBlending($source, true);
		imageSaveAlpha($source, true);
		
		$thumb = imagecreatetruecolor($thumb_w, $thumb_h);
		imageAlphaBlending($thumb, true);
		imageSaveAlpha($thumb, true);
		$trans_colour = imagecolorallocatealpha($thumb, 0, 0, 0, 127);
		imagefill($thumb, 0, 0, $trans_colour);
		
		imagecopyresampled($thumb, $source, 0, 0, 0, 0, $thumb_w, $thumb_h, $width, $height);
		unlink($filename);
		
		return $thumb;
	}
}

if( file_exists($file) )
{
	$mod = filemtime($file);
	$size = filesize ($file);
	$current = time();
	
	if( $mod <= $current-(3600*24*30) || $size < 10 || isset($_GET['refresh']))
	{
		$address = 'http://172.16.1.200:3000?url=' . $url . '&clipRect={"top":0,"left":0,"width":1024,"height":768}';
		$content = file_get_contents($address);
		$thumb = resize($content);
		
		imagepng($thumb, $file);
	}
}
else
{
	$address = 'http://172.16.1.200:3000?url=' . $url . '&clipRect={"top":0,"left":0,"width":1024,"height":768}';
	$content = file_get_contents($address);
	$thumb = resize($content);
		
	imagepng($thumb, $file);
}

header("content-type: image/png");
echo file_get_contents($file);

?>
