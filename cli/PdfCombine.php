#!/usr/bin/php -q
<?php
/*******************************************************************************
 ____      ____  ________  ______   ________  _______          _       _______
|_  _|    |_  _||_   __  ||_   _ \ |_   __  ||_   __ \        / \     |_   __ \
  \ \  /\  / /    | |_ \_|  | |_) |  | |_ \_|  | |__) |      / _ \      | |__) |
   \ \/  \/ /     |  _| _   |  __'.  |  _|     |  __ /      / ___ \     |  ___/
    \  /\  /     _| |__/ | _| |__) |_| |_     _| |  \ \_  _/ /   \ \_  _| |_
     \/  \/     |________||_______/|_____|   |____| |___||____| |____||_____|


Autor: Dominik Bonsch <dominik.bonsch@webfrap.de>
Date:
Copyright: Webfrap Developer Network <contact@webfrap.de>
Project: Webfrap Web Frame Application (Server)
ProjectUrl: http://webfrap.de / http://webfrapdev.de

Licence: (GNU LESSER GENERAL PUBLIC LICENSE 3.0) see: LICENCE/LGPL.txt

Version: 1  Revision: 1

Changes:

*******************************************************************************/

set_time_limit(0);
error_reporting(E_ALL );
date_default_timezone_set( "Europe/Berlin" );

define('FPDF_FONTPATH','../pdf/font');
require('../pdf/fpdf.php');
require('../pdf/fpdi.php');

class PdfCombine
  extends fpdi
{

  var $files = array();

  function __construct($orientation='P',$unit='mm',$format='A4')
  {
    parent::fpdi($orientation,$unit,$format);
  }

  function setFiles($files)
  {
    $this->files = $files;
  }

  function concat()
  {
    foreach($this->files AS $file)
    {
      $pagecount = $this->setSourceFile($file);
      for ($i = 1; $i <= $pagecount; $i++)
      {
         $tplidx = $this->ImportPage($i);
         $this->AddPage();
         $this->useTemplate($tplidx);
      }
    }
  }

}

$pdf= new PdfCombine( 'L' ,'mm', 'A4'  );

$pdf->setFiles(array
(
"1.pdf",
"2.pdf",
/**/
));
$pdf->concat();


$pdf->Output("gesamt.pdf","F");
?>
