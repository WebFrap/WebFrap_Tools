<?php

$files = array
(
  'theme.css'
);

ob_start();

foreach( $files as $file )
{
  include './theme/default/'.$file;
}

$content = '@charset "utf-8";'."\n".ob_get_contents();
ob_end_clean();

header( 'content-type: text/css' );
header( 'ETag: '.md5($content) );
header( 'Content-Length: '.strlen( $content ) );
header( 'Expires: Thu, 13 Nov 2179 00:00:00 GMT' );
header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );

echo $content;
