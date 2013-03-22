<?php 

$files = array
(
  'jQuery.js'
);

$content = '';

foreach($files as $file)
{
  $content .= file_get_contents('./javascript/'.$file);
}


header('content-type: application/javascript');
header('ETag: '.md5($content));
header('Content-Length: '.strlen($content));
header('Expires: Thu, 13 Nov 2179 00:00:00 GMT');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

echo $content;