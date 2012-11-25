<?php 

$wgtHeaderBgColor = $_POST['header_bg'];
$wgtFooterBgColor = $_POST['footer_bg'];

if( isset( $_POST['url'] ) )
{
  parse_str($_POST['url'], $params );
}
else 
{
  $defTheme = <<<DEF
?&ffDefault=Verdana,Arial,sans-serif&fwDefault=normal&fsDefault=1em&cornerRadius=3px&bgColorHeader=750003&bgTextureHeader=04_highlight_hard.png&bgImgOpacityHeader=20&borderColorHeader=5c5c5c&fcHeader=cccccc&iconColorHeader=cccccc&bgColorContent=f8f8f8&bgTextureContent=01_flat.png&bgImgOpacityContent=95&borderColorContent=5c5c5c&fcContent=222222&iconColorContent=222222&bgColorDefault=ababab&bgTextureDefault=04_highlight_hard.png&bgImgOpacityDefault=45&borderColorDefault=5c5c5c&fcDefault=ffffff&iconColorDefault=ffffff&bgColorHover=ffdea3&bgTextureHover=04_highlight_hard.png&bgImgOpacityHover=55&borderColorHover=5c5c5c&fcHover=750003&iconColorHover=750003&bgColorActive=474747&bgTextureActive=03_highlight_soft.png&bgImgOpacityActive=50&borderColorActive=5c5c5c&fcActive=ffffff&iconColorActive=ffffff&bgColorHighlight=f8da4e&bgTextureHighlight=02_glass.png&bgImgOpacityHighlight=55&borderColorHighlight=fcd113&fcHighlight=750003&iconColorHighlight=750003&bgColorError=e14f1c&bgTextureError=12_gloss_wave.png&bgImgOpacityError=45&borderColorError=750003&fcError=ffffff&iconColorError=fcd113&bgColorOverlay=aaaaaa&bgTextureOverlay=07_diagonals_small.png&bgImgOpacityOverlay=75&opacityOverlay=30&bgColorShadow=999999&bgTextureShadow=01_flat.png&bgImgOpacityShadow=55&opacityShadow=45&thicknessShadow=0px&offsetTopShadow=5px&offsetLeftShadow=5px&cornerRadiusShadow=5px
DEF;
  
  parse_str( $defTheme, $params );
  
}


$ffDefault      = $params['ffDefault']; // Verdana,Arial,sans-serif
$fwDefault      = $params['fwDefault']; // normal
$fsDefault      = $params['fsDefault']; // 1.1em
$cornerRadius   = $params['cornerRadius']; // 4px

$bgColorHeader        = $params['bgColorHeader']; // d7c6c6
$bgImgOpacityHeader   = $params['bgImgOpacityHeader']; // 71
$borderColorHeader    = $params['borderColorHeader']; // 582c2c
$fcHeader             = $params['fcHeader']; // caa863
$iconColorHeader      = $params['iconColorHeader']; // d8cbcb

$bgColorContent       = $params['bgColorContent']; // fd6dfc
$bgImgOpacityContent  = $params['bgImgOpacityContent']; // 72
$borderColorContent   = $params['borderColorContent']; // 257b93
$fcContent            = $params['fcContent']; // 6018c3
$iconColorContent     = $params['iconColorContent']; // 5e2c2c

$bgColorDefault       = $params['bgColorDefault']; // c77b43
$bgImgOpacityDefault  = $params['bgImgOpacityDefault']; //73
$borderColorDefault   = $params['borderColorDefault']; //5f4266
$fcDefault            = $params['fcDefault']; // dc2e2e
$iconColorDefault     = $params['iconColorDefault']; // 988f25

$bgColorHover         = $params['bgColorHover']; // 114528
$bgImgOpacityHover    = $params['bgImgOpacityHover']; //74
$borderColorHover     = $params['borderColorHover']; // 0ed810
$fcHover              = $params['fcHover']; // 847a2e
$iconColorHover       = $params['iconColorHover']; // f462ba

$bgColorActive        = $params['bgColorActive']; // f39416
$bgImgOpacityActive   = $params['bgImgOpacityActive']; // 65
$borderColorActive    = $params['borderColorActive']; // 092edc
$iconColorActive      = $params['iconColorActive']; // 0a85c2
$fcActive             = $params['fcActive']; // 99aa46

$bgColorHighlight     = $params['bgColorHighlight']; // f8628f
$bgImgOpacityHighlight = $params['bgImgOpacityHighlight']; // 55
$borderColorHighlight = $params['borderColorHighlight']; // e1623d
$iconColorHighlight   = $params['iconColorHighlight']; // 8d1621
$fcHighlight          = $params['fcHighlight']; // bfa336

$bgColorError         = $params['bgColorError']; // 95181a
$bgImgOpacityError    = $params['bgImgOpacityError']; // 95
$borderColorError     = $params['borderColorError']; // 3e2323
$fcError              = $params['fcError']; // 6d65ae
$iconColorError       = $params['iconColorError']; // 849a42

$bgColorOverlay       = $params['bgColorOverlay']; // c6762a
$bgImgOpacityOverlay  = $params['bgImgOpacityOverlay']; // 12
$opacityOverlay       = $params['opacityOverlay']; //34
$bgColorShadow        = $params['bgColorShadow']; // 640b98

$bgImgOpacityShadow   = $params['bgImgOpacityShadow']; // 33
$opacityShadow        = $params['opacityShadow']; // 32
$thicknessShadow      = $params['thicknessShadow']; // 7px // check if this affects more than only the replaced ones
$offsetTopShadow      = $params['offsetTopShadow']; // -8px
$offsetLeftShadow     = $params['offsetLeftShadow']; // -9px
$cornerRadiusShadow   = $params['cornerRadiusShadow']; // 12px

$sizes = array();
$sizes['01_flat.png'] = '40x100';
$sizes['02_glass.png'] = '1x400';
$sizes['03_highlight_soft.png'] = '1x100';
$sizes['04_highlight_hard.png'] = '1x100';
$sizes['05_inset_soft.png'] = '1x100';
$sizes['06_inset_hard.png'] = '1x100';
$sizes['07_diagonals_small.png'] = '40x40';
$sizes['07_diagonals_medium.png'] = '40x40';
$sizes['08_diagonals_thick.png'] = '40x40';
$sizes['09_dots_small.png'] = '2x2';
$sizes['10_dots_medium.png'] = '4x4';
$sizes['11_white_lines.png'] = '40x100';
$sizes['12_gloss_wave.png'] = '500x100';
$sizes['13_diamond.png'] = '10x8';
$sizes['14_loop.png'] = '21x21';
$sizes['15_carbon_fiber.png'] = '8x9';
$sizes['16_diagonal_maze.png'] = '10x10';
$sizes['17_diamond_ripple.png'] = '22x22';
$sizes['18_hexagon.png'] = '12x10';
$sizes['19_layered_circles.png'] = '13x13';
$sizes['20_3D_boxes.png'] = '12x10';
$sizes['21_glow_ball.png'] = '16x16';
$sizes['22_spotlight.png'] = '16x16';
$sizes['23_fine_grain.png'] = '60x60';

// bgTextureHeader
$bgTextureHeader = $params['bgTextureHeader'];

$texture = str_replace( '_', '-', substr($bgTextureHeader, strpos($bgTextureHeader,'_')+1, (strlen($bgTextureHeader)-strpos($bgTextureHeader,'.'))*-1 ) );
$ending  = substr($bgTextureHeader, strpos($bgTextureHeader,'.')+1 );

$img_bgTextureHeader =  'ui-bg_'.$texture.'_'.$bgImgOpacityHeader.'_'.$bgColorHeader.'_'.$sizes[$bgTextureHeader].'.'.$ending;
//\ bgTextureHeader

// bgTextureContent
$bgTextureContent = $params['bgTextureContent'];

$texture = str_replace( '_', '-', substr($bgTextureContent, strpos($bgTextureContent,'_')+1, (strlen($bgTextureContent)-strpos($bgTextureContent,'.'))*-1 ) );
$ending  = substr($bgTextureContent, strpos($bgTextureContent,'.')+1 );

$img_bgTextureContent =  'ui-bg_'.$texture.'_'.$bgImgOpacityContent.'_'.$bgColorContent.'_'.$sizes[$bgTextureContent].'.'.$ending;
//\ bgTextureContent

// bgTextureDefault
$bgTextureDefault = $params['bgTextureDefault'];

$texture = str_replace( '_', '-', substr($bgTextureDefault, strpos($bgTextureDefault,'_')+1, (strlen($bgTextureDefault)-strpos($bgTextureDefault,'.'))*-1 ) );
$ending  = substr($bgTextureDefault, strpos($bgTextureDefault,'.')+1 );

$img_bgTextureDefault =  'ui-bg_'.$texture.'_'.$bgImgOpacityDefault.'_'.$bgColorDefault.'_'.$sizes[$bgTextureDefault].'.'.$ending;
//\ bgTextureDefault


// bgTextureHover
$bgTextureHover         = $params['bgTextureHover'];

$texture = str_replace( '_', '-', substr($bgTextureHover, strpos($bgTextureHover,'_')+1, (strlen($bgTextureHover)-strpos($bgTextureHover,'.'))*-1 ) );
$ending  = substr($bgTextureHover, strpos($bgTextureHover,'.')+1 );

$img_bgTextureHover =  'ui-bg_'.$texture.'_'.$bgImgOpacityHover.'_'.$bgColorHover.'_'.$sizes[$bgTextureHover].'.'.$ending;
//\ bgTextureHover

// bgTextureActive
$bgTextureActive         = $params['bgTextureActive'];

$texture = str_replace( '_', '-', substr($bgTextureActive, strpos($bgTextureActive,'_')+1, (strlen($bgTextureActive)-strpos($bgTextureActive,'.'))*-1 ) );
$ending  = substr($bgTextureActive, strpos($bgTextureActive,'.')+1 );


$img_bgTextureActive =  'ui-bg_'.$texture.'_'.$bgImgOpacityActive.'_'.$bgColorActive.'_'.$sizes[$bgTextureActive].'.'.$ending;
//\ bgTextureActive

// bgTextureHighlight
$bgTextureHighlight        = $params['bgTextureHighlight'];

$texture = str_replace( '_', '-', substr($bgTextureHighlight, strpos($bgTextureHighlight,'_')+1, (strlen($bgTextureHighlight)-strpos($bgTextureHighlight,'.'))*-1 ) );
$ending  = substr($bgTextureHighlight, strpos($bgTextureHighlight,'.')+1 );

$img_bgTextureHighlight =  'ui-bg_'.$texture.'_'.$bgImgOpacityHighlight.'_'.$bgColorHighlight.'_'.$sizes[$bgTextureHighlight].'.'.$ending;
//\ bgTextureHighlight


// bgTextureError
$bgTextureError       = $params['bgTextureError'];

$texture = str_replace( '_', '-', substr($bgTextureError, strpos($bgTextureError,'_')+1, (strlen($bgTextureError)-strpos($bgTextureError,'.'))*-1 ) );
$ending  = substr($bgTextureError, strpos($bgTextureError,'.')+1 );

$img_bgTextureError =  'ui-bg_'.$texture.'_'.$bgImgOpacityError.'_'.$bgColorError.'_'.$sizes[$bgTextureError].'.'.$ending;
//\ bgTextureError

// bgTextureOverlay
$bgTextureOverlay       = $params['bgTextureOverlay'];

$texture = str_replace( '_', '-', substr($bgTextureOverlay, strpos($bgTextureOverlay,'_')+1, (strlen($bgTextureOverlay)-strpos($bgTextureOverlay,'.'))*-1 ) );
$ending  = substr($bgTextureOverlay, strpos($bgTextureOverlay,'.')+1 );

$img_bgTextureOverlay =  'ui-bg_'.$texture.'_'.$bgImgOpacityOverlay.'_'.$bgColorOverlay.'_'.$sizes[$bgTextureOverlay].'.'.$ending;
//\ bgTextureOverlay


// bgTextureShadow
$bgTextureShadow       = $params['bgTextureShadow'];

$texture = str_replace( '_', '-', substr($bgTextureShadow, strpos($bgTextureShadow,'_')+1, (strlen($bgTextureShadow)-strpos($bgTextureShadow,'.'))*-1 ) );
$ending  = substr($bgTextureShadow, strpos($bgTextureShadow,'.')+1 );

$img_bgTextureShadow =  'ui-bg_'.$texture.'_'.$bgImgOpacityShadow.'_'.$bgColorShadow.'_'.$sizes[$bgTextureShadow].'.'.$ending;
//\ bgTextureShadow


$imagePath = '<?php echo $images ?>';

$browserSpecials = false;


?>
/*******************************************************************************
* WebFrap UI CSS Framework, extends jQuery UI CSS Framework
*******************************************************************************/

/*
Theme URL:

?<?php echo $_POST['url'] ?>

*/

/* clean all */
*
{
  font-family: <?php echo $ffDefault ?>;
}


/* Base Elements
------------------------------------------------------------------------------*/

body
{
  background-color:#<?php echo $bgColorContent ?>;
}

a,
a:link,
a:visited
{
  color: #<?php echo $fcContent ?>;
  font-weight: <?php echo $fwDefault  ?>;
}

a:focus,
a:hover,
a:active
{
  color: #<?php echo  $fcHover ?>;
  font-weight: <?php echo $fwDefault  ?>;
  text-decoration: none;
}

h1,
h2,
h3,
h4,
h5,
h6,
legend
{
  padding-left:4px;
  color: #<?php echo $fcContent ?>;
  font-weight: <?php echo $fwDefault  ?>;  
}

h1 a,
h2 a,
h3 a,
h4 a,
h5 a,
h6 a
{
  color: #<?php echo $fcContent ?>;
  font-weight: <?php echo $fwDefault  ?>;
}


/* Layout Theme
------------------------------------------------------------------------------*/

.wgt_underline,
div#wbf-ui-panel,
.wgt-panel,
.ui-widget-header.bar,
.wgt_tab_head
{
  border-bottom:1px solid #<?php echo $borderColorContent ?> !important;
}

div#wbf-menu
{
  border-right:solid 1px #<?php echo $borderColorContent ?>;
}

div#wbf-footer
{
  border-top:solid 1px #<?php echo $borderColorContent ?>;
  border-right:solid 1px #<?php echo $borderColorContent ?>;  
  background-color:<?php echo $wgtHeaderBgColor ?>;
}

div#wbf-menu,
div.bar,
div.wgt-panel,
div.wgt_tab_head,
div.wgt-tab-head,
div.wgt-bgbox
{
  background-color:<?php echo $wgtHeaderBgColor ?>;
}

div#wbf-body,
div#wbf-content,
div.wgt_window,
table.wgt-table tbody,
.wgt-content,
.wgt-bg-control
{
  background: #fcfdfd url(<?php echo $imagePath ?>ui/<?php echo $img_bgTextureContent ?>) 50% 50% repeat;
  color: #<?php echo $fcContent ?>;
}


#wgt-panel-switch-profile
{
  height:22px;
}

.wgt-lyt-logo
{
  background: white url('./files/logo/logo_small.png') fixed no-repeat !important;
}

.wgt-lyt-logo a
{
  padding:0xp;
  margin:0px;
  width:75px !important;
  background:inherit !important;
}

/* Boxes, Backgrounds & Borders
------------------------------------------------------------------------------*/

.wgt-border-bopen
{
  border:1px solid #<?php echo $borderColorContent ?> !important;
  border-bottom:none !important;
}

.wgt-border-vert
{
  border-top:1px solid #<?php echo $borderColorContent ?> !important;
  border-bottom:1px solid #<?php echo $borderColorContent ?> !important;
}

.wgt-border
{
  border:1px solid #<?php echo $borderColorContent ?> !important;
}

.wgt-border-top
{
  border-top:1px solid #<?php echo $borderColorContent ?> !important;
}

.wgt-border-bottom
{
  border-bottom:1px solid #<?php echo $borderColorContent ?> !important;
}

.wgt-border-left
{
  border-left:1px solid #<?php echo $borderColorContent ?> !important;
}

.wgt-border-right
{
  border-right:1px solid #<?php echo $borderColorContent ?> !important;
}

.wgt-bgbox
{
  background-color:<?php echo $wgtHeaderBgColor ?>;
  padding:4px;
}

.wgt-padding
{
  padding:3px;
}

div.wgt-content_box div.head h2,
div.wgt-ui-desktop h1,
div.wgt-news-box h2
{
  color: #<?php echo $fcHover ?>;
}

/* Semantics
------------------------------------------------------------------------------*/

.wgt-hover,
.wgt-selected,
.wgt-hover a,
.wgt-selected a
{
  background-color: #<?php echo $bgColorHighlight ?> !important;
  color: #<?php echo $fcHighlight ?> !important;
}

.wgt-active
{
  border: 1px solid #<?php echo $borderColorActive  ?>;
  background: #<?php echo $bgColorActive ?> url(<?php echo $imagePath ?>ui/<?php echo $img_bgTextureActive?>) 50% 50% repeat;
  color: #<?php echo $fcActive ?>;
}

/* Form Styles
------------------------------------------------------------------------------*/

input, 
textarea, 
select,
div.wgt-fake-input
{
  border:solid 1px #<?php echo $borderColorContent ?>;
}


fieldset
{
  border: 1px solid #<?php echo $borderColorHeader ?>;
}


.wgt-button:hover,
.wgt-button.append:hover
{
  border: 1px solid #<?php echo $borderColorHover ?>;
  background: #<?php echo $bgColorHover ?> url(<?php echo $imagePath ?>ui/<?php echo $img_bgTextureHover?>) 50% 50% repeat-x;
  color: #<?php echo  $fcHover ?>;
  font-weight: <?php echo $fwDefault  ?>;
  <?php if( $browserSpecials ){ ?>
  -moz-border-radius: <?php echo $cornerRadius ?>;
  -webkit-border-radius: <?php echo $cornerRadius ?>;  
  <?php } ?>
  border-radius: <?php echo $cornerRadius ?>;
}

.wgt-button.append:hover
{
  /* right borders */
  <?php if( $browserSpecials ){ ?>
  -moz-border-radius-topleft: 0px;
  -webkit-border-top-left-radius: 0px;
  <?php } ?>
  border-top-left-radius: 0px;
  <?php if( $browserSpecials ){ ?>
  -moz-border-radius-bottomleft: 0px;
  -webkit-border-bottom-left-radius: 0px;
  <?php } ?>
  border-bottom-right-left: 0px;
}

.wgt-button,
.wgt-button.append,
.wgt-button2,
.wgt-button2.append
{
  border: 1px solid #<?php echo $borderColorDefault ?>;
  background: #<?php echo $bgColorDefault ?> url(<?php echo $imagePath ?>ui/<?php echo  $img_bgTextureDefault ?>) 50% 50% repeat-x;
  color: #<?php echo  $fcDefault ?>;
  font-weight: <?php echo $fwDefault  ?>;
  <?php if( $browserSpecials ){ ?>
  -moz-border-radius: <?php echo $cornerRadius ?>;
  -webkit-border-radius: <?php echo $cornerRadius ?>;
  <?php } ?>
  border-radius: <?php echo $cornerRadius ?>;
}

.wgt-button.append,
.wgt-button.right,
.wgt-button2.append,
.wgt-button2.right
{

  /* clear borders */
  <?php if( $browserSpecials ){ ?>
  -moz-border-radius: 0px;
  -webkit-border-radius: 0px;
  <?php } ?>
  border-radius: 0px;

  /* right borders */
  <?php if( $browserSpecials ){ ?>
  -moz-border-radius-topright: <?php echo $cornerRadius ?>;
  -webkit-border-top-right-radius: <?php echo $cornerRadius ?>;
  <?php } ?>
  border-top-right-radius: <?php echo $cornerRadius ?>;
  <?php if( $browserSpecials ){ ?>
  -moz-border-radius-bottomright: <?php echo $cornerRadius ?>;
  -webkit-border-bottom-right-radius: <?php echo $cornerRadius ?>;
  <?php } ?>
  border-bottom-right-radius: <?php echo $cornerRadius ?>;
}

.wgt-button.splitted,
.wgt-button2.splitted
{
  padding-right:10px;
}

.wgt-button .ui-icon,
.wgt-button.append .ui-icon
{
  background-image: url(<?php echo $imagePath ?>ui/ui-icons_<?php echo  $iconColorDefault ?>_256x240.png);
}

.wgt-button:hover .ui-icon,
.wgt-button.append:hover .ui-icon
{
  background-image: url(<?php echo $imagePath ?>ui/ui-icons_<?php echo $iconColorHover ?>_256x240.png);
}


/* Mega Menu
------------------------------------------------------------------------------*/

ul.wgt-mega-menu 
{
  text-decoration: none;
  width: 100%; 
  height: 18px; 
  position: relative;
  border-left:0px;
  border-right:0px;
  background: #<?php echo $bgColorHeader ?> url(<?php echo $imagePath ?>ui/<?php echo  $img_bgTextureHeader ?>) 50% 50% repeat-x;
  color: #<?php echo  $fcContent ?>;
  font-weight: <?php echo $fwDefault  ?>;
}

ul.wgt-mega-menu a.wgt-mega-menu ,
ul.wgt-mega-menu li.custom>a
{
	color: #<?php echo  $fcHeader ?>;
}

ul.wgt-mega-menu li,
ul.wgt-mega-menu li.notify.end
{
  border-right:1px ridge <?php echo $borderColorHeader ?>;
}

ul.wgt-mega-menu ul.sub li
{
  border-right:0px; 
}

ul.wgt-mega-menu li.wgt-mega-menu-li>a,
ul.wgt-mega-menu li.custom>a,
ul.wgt-mega-menu li.notify>a
{
  text-shadow: none;  
  height: 18px;
  text-decoration: none;
  padding: 5px 12px 5px 9px;
  background: #<?php echo $bgColorHeader ?> url(<?php echo $imagePath ?>ui/<?php echo  $img_bgTextureHeader ?>) 50% 50% repeat-x;
  color: #<?php echo  $fcHeader ?>;
  font-weight: <?php echo $fwDefault  ?>;
}

ul.wgt-mega-menu li a
{
  text-shadow: none;  
  height: 18px;
  text-decoration: none;
  padding: 5px 12px 5px 9px;
  background: #<?php echo $bgColorContent ?> url(<?php echo $imagePath ?>ui/<?php echo  $img_bgTextureContent ?>) 50% 50% repeat-x;
  color: #<?php echo  $fcContent ?>;
  font-weight: <?php echo $fwDefault  ?>;
}

ul.wgt-mega-menu li.notify
{
  border-right:0px;
}

ul.wgt-mega-menu li.notify a 
{
  padding: 3px 3px 8px 3px;
  color: #<?php echo  $fcDefault ?>;
}

ul.wgt-mega-menu li.notify.end a 
{
  padding: 3px 10px 8px 3px;
}

ul.wgt-mega-menu li.notify.start a 
{
  padding: 3px 3px 8px 10px;
}


ul.wgt-mega-menu li a:hover,
ul.wgt-mega-menu li p:hover,
ul.wgt-mega-menu .mega-hover a
{
  border: 1px solid #<?php echo $borderColorHover ?>;
  background: #<?php echo $bgColorHover ?> url(<?php echo $imagePath ?>ui/<?php echo $img_bgTextureHover?>) 50% 50% repeat-x;
  font-weight: <?php echo $fwDefault  ?>;
  color: #<?php echo  $fcHover ?>;
  border:0px !important;	
  -webkit-user-select: none;  /* Chrome all / Safari all */
  -moz-user-select: none;     /* Firefox all */
  -ms-user-select: none;      /* IE 10+ */
  -o-user-select: none;
  user-select: none; 
}

ul.wgt-mega-menu li .sub li.mega-hdr a.mega-hdr-a,
ul.wgt-mega-menu li .sub li.mega-hdr p.mega-hdr-a 
{
  padding: 3px 5px 3px 15px; 
  margin-bottom: 3px; 
  text-transform: uppercase; 
  text-shadow: none; 
  text-decoration: none;
  cursor:pointer;
  background: #<?php echo $bgColorHeader ?> url(<?php echo $imagePath ?>ui/<?php echo  $img_bgTextureHeader ?>) 50% 50% repeat-x;
  color: #<?php echo  $fcHeader ?> !important;
  font-weight: <?php echo $fwDefault  ?> !important;
}

ul.wgt-mega-menu li .sub-container.mega .sub
{
  opacity: .97;
  filter:Alpha(Opacity=97);
}

/* Table & Grid
------------------------------------------------------------------------------*/

.ui-widget-footer,
.wgt-head,
table.wgt-table tfoot,
table.wgt-table thead,
table.wgt-grid tfoot,
table.wgt-grid thead
{
  border: 1px solid #<?php echo $borderColorHeader ?>;
  background: #<?php echo $bgColorHeader ?> url(<?php echo $imagePath ?>ui/<?php echo  $img_bgTextureHeader ?>) 50% 50% repeat-x;
  color: #<?php echo  $fcHeader ?> !important;
  font-weight: <?php echo $fwDefault  ?> !important;
}

table.wgt-table tfoot a,
table.wgt-table tfoot td,
table.wgt-table tfoot span,
table.wgt-table tfoot div,
table.wgt-table thead a,
table.wgt-table thead th,
table.wgt-table thead span,
table.wgt-grid tfoot a,
table.wgt-grid tfoot td,
table.wgt-grid tfoot span,
table.wgt-grid tfoot div,
table.wgt-grid thead a,
table.wgt-grid thead th,
table.wgt-grid thead span
{
  color: #<?php echo $fcHeader ?> !important;
  font-weight: <?php echo $fcHeader ?>  !important;
  text-decoration: none;
}

div.wgt-grid-head table thead th
{
  color: #<?php echo $fcHeader ?> !important;
  font-weight: <?php echo $fcHeader ?>;
  background: #<?php echo $bgColorHeader ?> url(<?php echo $imagePath ?>ui/<?php echo  $img_bgTextureHeader ?>) 50% 50% repeat-x;
  text-decoration: none;
}

table.wgt-grid tbody tr.title,
table.wgt-table tbody tr.title
{
  background-color:#<?php echo $bgColorDefault ?> !important;
  color: #<?php echo  $fcDefault ?>;
  font-weight: <?php echo $fcHeader ?>;
}

table.wgt-grid tbody tr.subtitle,
table.wgt-table tbody tr.subtitle
{
  background-color:#<?php echo $wgtFooterBgColor ?> !important;
  color: #<?php echo  $fcDefault ?>;
  font-weight: <?php echo $fcHeader ?>;
}

div.wgt-grid-body tr.wgt-selected td.pos
{
  border: 1px solid #<?php echo $borderColorActive ?>;
  background-color: #<?php echo $bgColorActive ?>;
  font-weight: <?php echo $fwDefault  ?>;
  color: #<?php echo $fcActive ?>;
}

table.wgt-table li,
table.wgt-grid li
{
  list-style:circle;
}

table.wgt-table tbody tr.row1,
table.wgt-grid tbody tr.row1
{
  background-color:white;
}

table.wgt-table tbody tr.row2,
table.wgt-grid tbody tr.row2
{
  background-color:#<?php echo $bgColorContent; ?>;
}


/* Panel
------------------------------------------------------------------------------*/

div.wgt-panel.title
{
  background: <?php echo $wgtHeaderBgColor ?> url(<?php echo $imagePath ?>wgt/bg_shadow_light.png) 100% 100% repeat-x;
  color: #222222;
}

div.wgt-panel.menu
{
  padding:2px;
}


/* Tabs
------------------------------------------------------------------------------*/


span.tab,
div.wgt-tab-head a.tab
{
  border: 1px solid #<?php echo $borderColorDefault ?>;
  background: #<?php echo $bgColorDefault ?> url(<?php echo $imagePath ?>ui/<?php echo  $img_bgTextureDefault ?>) 50% 50% repeat-x;
  color: #<?php echo  $fcDefault ?>;
  font-weight: <?php echo $fwDefault  ?>;
}

span.tab:hover,
div.wgt-tab-head a.tab:hover
{
  border: 1px solid #<?php echo $borderColorHover ?>;
  background: #<?php echo $bgColorHover ?> url(<?php echo $imagePath ?>ui/<?php echo $img_bgTextureHover?>) 50% 50% repeat-x;
  font-weight: <?php echo $fwDefault  ?>;
  color: #<?php echo  $fcHover ?>;
}

span.tab a
{
  color: #<?php echo  $fcDefault ?>;
  font-weight: <?php echo $fwDefault  ?>;
}

span.tab:hover a
{
  color: #<?php echo  $fcHover ?>;
  font-weight: <?php echo $fwDefault  ?>;
}

span.tab.ui-state-active,
span.tab.ui-state-active a,
div.wgt-tab-head a.tab.active
{
  border: 1px solid #<?php echo $borderColorActive ?>;
  background: #<?php echo $bgColorActive ?> url(<?php echo $imagePath ?>ui/<?php echo $img_bgTextureActive?>) 50% 50% repeat;
  font-weight: <?php echo $fwDefault  ?>;
  color: #<?php echo $fcActive ?>;
}

.ui-accordion-content label
{
  color: #<?php echo  $fcHover ?>;
  font-weight:bold;
}

.ui-accordion-content label.hint
{
  color: #<?php echo  $fcDefault ?>;
}

.ui-accordion-content label.hint,
.ui-accordion-content p.hint
{
  font-style:italic;
}


/* Drop Menu
------------------------------------------------------------------------------*/


.wgt-dropmenu li.wgt-hover>a:first-child,
.wgt-dropmenu li.wgt-hover>p:first-child
{
  /*border: 1px solid #<?php echo $borderColorHighlight  ?>;*/
  background: #<?php echo $bgColorHighlight ?> url(<?php echo $imagePath ?>ui/<?php echo $img_bgTextureHighlight?>) 50% 50% repeat;
  color: #<?php echo $fcHighlight ?>;
}

.wgt-dropmenu ul
{
  border-left: 1px solid #<?php echo $borderColorDefault  ?>;
  border-top: 1px solid #<?php echo $borderColorDefault  ?>;
}

.wgt-dropmenu li li,
.wgt-dropmenu li li li,
.wgt-dropmenu li li li li
{
  border-bottom: 1px solid #<?php echo $borderColorDefault  ?>;
  border-right: 1px solid #<?php echo $borderColorDefault  ?>;
  background: #<?php echo $bgColorDefault ?> url(<?php echo $imagePath ?>ui/<?php echo $img_bgTextureDefault ?>) 50% 50% repeat;
}

.wgt-dropmenu a:focus,
.wgt-dropmenu a:hover,
.wgt-dropmenu a:active,
.wgt-dropmenu p:focus,
.wgt-dropmenu p:hover,
.wgt-dropmenu p:active
{
  background: #<?php echo $bgColorHover ?> url(<?php echo $imagePath ?>ui/<?php echo $img_bgTextureHover?>) 50% 50% repeat-x;
  font-weight: <?php echo $fwDefault  ?>;
  color: #<?php echo  $fcHover ?>;
}


.wgt-dropmenu a,
.wgt-dropmenu p
{
  background: #<?php echo $bgColorContent ?> url(<?php echo $imagePath ?>ui/<?php echo $img_bgTextureContent ?>) 50% 50% repeat;
  color: #<?php echo $fcContent ?>;
  font-weight: <?php echo $fwDefault  ?>;
}


/* Message Pipe
------------------------------------------------------------------------------*/

ul.wgt-message-pipe li
{
  border:1px solid #<?php echo $borderColorContent ?>;
}

ul.wgt-message-pipe li div.title
{
  border-bottom:1px dotted #<?php echo $borderColorContent ?>;
  background-color:<?php echo $wgtHeaderBgColor ?>;
}

ul.wgt-message-pipe li div.content
{
  border-bottom:1px dotted #<?php echo $borderColorContent ?>;  
}

ul.wgt-message-pipe li div.footer
{
  background-color:#<?php echo $wgtFooterBgColor ?>;    
}

ul.wgt-message-pipe li div.footer span
{
  color:#<?php echo $fcContent ?>;
}

div.box-message a
{
	border-bottom:1px dotted #<?php echo $borderColorContent ?>;
}


/*
 * jQuery UI CSS Framework @VERSION
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Theming/API
 */

/* Layout helpers
----------------------------------*/
.ui-helper-hidden
{
  display: none;
}

.ui-helper-hidden-accessible
{
  position: absolute;
  left: -99999999px;
}

.ui-helper-reset
{
  margin: 0;
  padding: 0;
  border: 0;
  outline: 0;
  line-height: 1.1;
  text-decoration: none;
  font-size: 100%;
  list-style: none;
}

.ui-helper-clearfix:after
{
  content: ".";
  display: block;
  height: 0;
  clear: both;
  visibility: hidden;
}

.ui-helper-clearfix
{
  display: inline-block;
}

/* required comment for clearfix to work in Opera \*/
* html .ui-helper-clearfix
{
}

.ui-helper-clearfix
{
  display:block;
}
/* end clearfix */

.ui-helper-zfix
{
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  position: absolute;
  opacity: 0;
  filter:Alpha(Opacity=0);
}


/* Interaction Cues
----------------------------------*/
.ui-state-disabled
{
  cursor: default !important;
}


/* Icons
----------------------------------*/

/* states and images */
.ui-icon
{
  display: block;
  text-indent: -99999px;
  overflow: hidden;
  background-repeat: no-repeat;
}


/* Misc visuals
----------------------------------*/

/* Overlays */
.ui-widget-overlay
{
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}



/* Component containers
----------------------------------*/

.ui-widget{}

.ui-widget .ui-widget{}

.ui-widget input,
.ui-widget select,
.ui-widget textarea,
.ui-widget button
{
}

/* Content
----------------------------------*/

.ui-widget-content
{
  border: 1px solid #<?php echo $borderColorContent ?>;
  background: #<?php echo $bgColorContent ?> url(<?php echo $imagePath ?>ui/<?php echo $img_bgTextureContent ?>) 50% 50% repeat;
  color: #<?php echo $fcContent ?>;
}


/* Header
----------------------------------*/

.ui-widget-header
{
  border: 1px solid #<?php echo $borderColorHeader ?>;
  background: #<?php echo $bgColorHeader ?> url(<?php echo $imagePath ?>ui/<?php echo  $img_bgTextureHeader ?>) 50% 50% repeat-x;
  color: #<?php echo  $fcHeader ?>;
  font-weight: <?php echo $fwDefault  ?>;
}


/* Interaction states
----------------------------------*/

.ui-state-default,
.ui-widget-content .ui-state-default,
.ui-widget-header .ui-state-default
{
  border: 1px solid #<?php echo $borderColorDefault ?>;
  background: #<?php echo $bgColorDefault ?> url(<?php echo $imagePath ?>ui/<?php echo $img_bgTextureDefault ?>) 50% 50% repeat;
  font-weight: <?php echo $fwDefault  ?>;
  color: #<?php echo $fcDefault ?>;
}

.ui-state-default a,
.ui-state-default a:link,
.ui-state-default a:visited
{
  color: #<?php echo $fcDefault ?>;
  font-weight: <?php echo $fwDefault  ?>;
  text-decoration: none;
}

.ui-state-hover,
.ui-widget-content .ui-state-hover,
.ui-widget-header .ui-state-hover,
.ui-state-focus,
.ui-widget-content .ui-state-focus,
.ui-widget-header .ui-state-focus
{
  border: 1px solid #<?php echo $borderColorHover ?>;
  background: #<?php echo $bgColorHover ?> url(<?php echo $imagePath ?>ui/<?php echo $img_bgTextureHover?>) 50% 50% repeat-x;
  font-weight: <?php echo $fwDefault  ?>;
  color: #<?php echo  $fcHover ?>;
}

.ui-state-hover a,
.ui-state-hover a:hover
{
  color: #<?php echo  $fcHover ?>;
  text-decoration: none;
}

.ui-state-active,
.ui-widget-content .ui-state-active,
.ui-widget-header .ui-state-active
{
  border: 1px solid #<?php echo $borderColorActive ?>;
  background: #<?php echo $bgColorActive ?> url(<?php echo $imagePath ?>ui/<?php echo $img_bgTextureActive?>) 50% 50% repeat;
  font-weight: <?php echo $fwDefault  ?>;
  color: #<?php echo $fcActive ?>;
}

.ui-state-active a,
.ui-state-active a:link,
.ui-state-active a:visited,
{
  color: #<?php echo $fcActive ?>;
  text-decoration: none;
}

.ui-widget:active
{
  outline: none;
}

/* Interaction Cues
----------------------------------*/

.ui-state-highlight,
.ui-widget-content .ui-state-highlight,
.ui-widget-header .ui-state-highlight
{
  border: 1px solid #<?php echo $borderColorHighlight  ?>;
  background: #<?php echo $bgColorHighlight ?> url(<?php echo $imagePath ?>ui/<?php echo $img_bgTextureHighlight?>) 50% 50% repeat;
  color: #<?php echo $fcHighlight ?>;
}

.ui-state-highlight a,
.ui-widget-content .ui-state-highlight a,
.ui-widget-header .ui-state-highlight a
{
  color: #<?php echo $fcHighlight ?>;
}

.ui-state-error,
.ui-widget-content .ui-state-error,
.ui-widget-header .ui-state-error
{
  border: 1px solid #<?php echo $borderColorError ?>;
  background:#<?php echo  $bgColorError ?> url(<?php echo $imagePath ?>ui/<?php echo $img_bgTextureError ?>) 50% 50% repeat;
  color: #<?php echo $fcError ?>;
}

.ui-state-error a,
.ui-widget-content .ui-state-error a,
.ui-widget-header .ui-state-error a
{
  color: #<?php echo $fcError ?>;
}

.ui-state-error-text,
.ui-widget-content .ui-state-error-text,
.ui-widget-header .ui-state-error-text
{
  color: #<?php echo $fcError ?>;
}

.ui-priority-primary,
.ui-widget-content .ui-priority-primary,
.ui-widget-header .ui-priority-primary
{
  font-weight: <?php echo $fwDefault  ?>;
}

.ui-priority-secondary,
.ui-widget-content .ui-priority-secondary,
.ui-widget-header .ui-priority-secondary
{
  opacity: .7;
  filter:Alpha(Opacity=70);
  font-weight: <?php echo $fwDefault  ?>;
}

.ui-state-disabled,
.ui-widget-content .ui-state-disabled,
.ui-widget-header .ui-state-disabled
{
  opacity: .35;
  filter:Alpha(Opacity=35);
  background-image: none;
}

/* Icons
----------------------------------*/

/* states and images */
.ui-icon
{
  width: 16px;
  height: 16px;
  background-image: url(<?php echo $imagePath ?>ui/ui-icons_<?php echo $iconColorContent ?>_256x240.png);
}

.ui-widget-content .ui-icon
{
  background-image: url(<?php echo $imagePath ?>ui/ui-icons_<?php echo $iconColorContent ?>_256x240.png);
}

.ui-widget-header .ui-icon
{
  background-image: url(<?php echo $imagePath ?>ui/ui-icons_<?php echo $iconColorHeader ?>_256x240.png);
}

.ui-state-default .ui-icon
{
  background-image: url(<?php echo $imagePath ?>ui/ui-icons_<?php echo  $iconColorDefault ?>_256x240.png);
}

.ui-state-hover .ui-icon,
.ui-state-focus .ui-icon
{
  background-image: url(<?php echo $imagePath ?>ui/ui-icons_<?php echo $iconColorHover ?>_256x240.png);
}

.ui-state-active .ui-icon
{
  background-image: url(<?php echo $imagePath ?>ui/ui-icons_<?php echo  $iconColorActive ?>_256x240.png);
}

.ui-state-highlight .ui-icon
{
  background-image: url(<?php echo $imagePath ?>ui/ui-icons_<?php echo $iconColorHighlight  ?>_256x240.png);
}

.ui-state-error .ui-icon,
.ui-state-error-text .ui-icon
{
  background-image: url(<?php echo $imagePath ?>ui/ui-icons_<?php echo $iconColorError ?>_256x240.png);
}

/* positioning */
.ui-icon-carat-1-n
{
  background-position: 0 0;
}
.ui-icon-carat-1-ne
{
  background-position: -16px 0;
}
.ui-icon-carat-1-e
{
  background-position: -32px 0;
}
.ui-icon-carat-1-se
{
  background-position: -48px 0;
}
.ui-icon-carat-1-s
{
  background-position: -64px 0;
}
.ui-icon-carat-1-sw
{
  background-position: -80px 0;
}
.ui-icon-carat-1-w
{
  background-position: -96px 0;
}
.ui-icon-carat-1-nw
{
  background-position: -112px 0;
}
.ui-icon-carat-2-n-s
{
  background-position: -128px 0;
}
.ui-icon-carat-2-e-w
{
  background-position: -144px 0;
}
.ui-icon-triangle-1-n
{
  background-position: 0 -16px;
}
.ui-icon-triangle-1-ne
{
  background-position: -16px -16px;
}
.ui-icon-triangle-1-e
{
  background-position: -32px -16px;
}
.ui-icon-triangle-1-se
{
  background-position: -48px -16px;
}
.ui-icon-triangle-1-s
{
  background-position: -64px -16px;
}
.ui-icon-triangle-1-sw
{
  background-position: -80px -16px;
}
.ui-icon-triangle-1-w
{
  background-position: -96px -16px;
}
.ui-icon-triangle-1-nw
{
  background-position: -112px -16px;
}
.ui-icon-triangle-2-n-s
{
  background-position: -128px -16px;
}
.ui-icon-triangle-2-e-w
{
  background-position: -144px -16px;
}
.ui-icon-arrow-1-n
{
  background-position: 0 -32px;
}
.ui-icon-arrow-1-ne
{
  background-position: -16px -32px;
}
.ui-icon-arrow-1-e
{
  background-position: -32px -32px;
}
.ui-icon-arrow-1-se
{
  background-position: -48px -32px;
}
.ui-icon-arrow-1-s
{
  background-position: -64px -32px;
}
.ui-icon-arrow-1-sw
{
  background-position: -80px -32px;
}
.ui-icon-arrow-1-w
{
  background-position: -96px -32px;
}
.ui-icon-arrow-1-nw
{
  background-position: -112px -32px;
}
.ui-icon-arrow-2-n-s
{
  background-position: -128px -32px;
}
.ui-icon-arrow-2-ne-sw
{
  background-position: -144px -32px;
}
.ui-icon-arrow-2-e-w
{
  background-position: -160px -32px;
}
.ui-icon-arrow-2-se-nw
{
  background-position: -176px -32px;
}
.ui-icon-arrowstop-1-n
{
  background-position: -192px -32px;
}
.ui-icon-arrowstop-1-e
{
  background-position: -208px -32px;
}
.ui-icon-arrowstop-1-s
{
  background-position: -224px -32px;
}
.ui-icon-arrowstop-1-w
{
  background-position: -240px -32px;
}
.ui-icon-arrowthick-1-n
{
  background-position: 0 -48px;
}
.ui-icon-arrowthick-1-ne
{
  background-position: -16px -48px;
}
.ui-icon-arrowthick-1-e
{
  background-position: -32px -48px;
}
.ui-icon-arrowthick-1-se
{
  background-position: -48px -48px;
}
.ui-icon-arrowthick-1-s
{
  background-position: -64px -48px;
}
.ui-icon-arrowthick-1-sw
{
  background-position: -80px -48px;
}
.ui-icon-arrowthick-1-w
{
  background-position: -96px -48px;
}
.ui-icon-arrowthick-1-nw
{
  background-position: -112px -48px;
}
.ui-icon-arrowthick-2-n-s
{
  background-position: -128px -48px;
}
.ui-icon-arrowthick-2-ne-sw
{
  background-position: -144px -48px;
}
.ui-icon-arrowthick-2-e-w
{
  background-position: -160px -48px;
}
.ui-icon-arrowthick-2-se-nw
{
  background-position: -176px -48px;
}
.ui-icon-arrowthickstop-1-n
{
  background-position: -192px -48px;
}
.ui-icon-arrowthickstop-1-e
{
  background-position: -208px -48px;
}
.ui-icon-arrowthickstop-1-s
{
  background-position: -224px -48px;
}
.ui-icon-arrowthickstop-1-w
{
  background-position: -240px -48px;
}
.ui-icon-arrowreturnthick-1-w
{
  background-position: 0 -64px;
}
.ui-icon-arrowreturnthick-1-n
{
  background-position: -16px -64px;
}
.ui-icon-arrowreturnthick-1-e
{
  background-position: -32px -64px;
}
.ui-icon-arrowreturnthick-1-s
{
  background-position: -48px -64px;
}
.ui-icon-arrowreturn-1-w
{
  background-position: -64px -64px;
}
.ui-icon-arrowreturn-1-n
{
  background-position: -80px -64px;
}
.ui-icon-arrowreturn-1-e
{
  background-position: -96px -64px;
}
.ui-icon-arrowreturn-1-s
{
  background-position: -112px -64px;
}
.ui-icon-arrowrefresh-1-w
{
  background-position: -128px -64px;
}
.ui-icon-arrowrefresh-1-n
{
  background-position: -144px -64px;
}
.ui-icon-arrowrefresh-1-e
{
  background-position: -160px -64px;
}
.ui-icon-arrowrefresh-1-s
{
  background-position: -176px -64px;
}
.ui-icon-arrow-4
{
  background-position: 0 -80px;
}
.ui-icon-arrow-4-diag
{
  background-position: -16px -80px;
}
.ui-icon-extlink
{
  background-position: -32px -80px;
}
.ui-icon-newwin
{
  background-position: -48px -80px;
}
.ui-icon-refresh
{
  background-position: -64px -80px;
}
.ui-icon-shuffle
{
background-position: -80px -80px;
}
.ui-icon-transfer-e-w
{
  background-position: -96px -80px;
}
.ui-icon-transferthick-e-w
{
  background-position: -112px -80px;
}
.ui-icon-folder-collapsed
{
  background-position: 0 -96px;
}
.ui-icon-folder-open
{
background-position: -16px -96px;
}
.ui-icon-document
{
  background-position: -32px -96px;
}
.ui-icon-document-b
{
  background-position: -48px -96px;
}
.ui-icon-note
{
  background-position: -64px -96px;
}
.ui-icon-mail-closed
{
  background-position: -80px -96px;
}
.ui-icon-mail-open
{
  background-position: -96px -96px;
}
.ui-icon-suitcase
{
  background-position: -112px -96px;
}
.ui-icon-comment
{
  background-position: -128px -96px;
}
.ui-icon-person
{
  background-position: -144px -96px;
}
.ui-icon-print
{
  background-position: -160px -96px;
}
.ui-icon-trash
{
  background-position: -176px -96px;
}
.ui-icon-locked
{
  background-position: -192px -96px;
}
.ui-icon-unlocked
{
  background-position: -208px -96px;
}
.ui-icon-bookmark
{
  background-position: -224px -96px;
}
.ui-icon-tag
{
  background-position: -240px -96px;
}
.ui-icon-home
{
  background-position: 0 -112px;
}
.ui-icon-flag
{
  background-position: -16px -112px;
}
.ui-icon-calendar
{
  background-position: -32px -112px;
}
.ui-icon-cart
{
  background-position: -48px -112px;
}
.ui-icon-pencil
{
  background-position: -64px -112px;
}
.ui-icon-clock
{
  background-position: -80px -112px;
}
.ui-icon-disk
{
  background-position: -96px -112px;
}
.ui-icon-calculator
{
  background-position: -112px -112px;
}
.ui-icon-zoomin
{
  background-position: -128px -112px;
}
.ui-icon-zoomout
{
  background-position: -144px -112px;
}
.ui-icon-search
{
  background-position: -160px -112px;
}
.ui-icon-wrench
{
  background-position: -176px -112px;
}
.ui-icon-gear
{
  background-position: -192px -112px;
}
.ui-icon-heart
{
  background-position: -208px -112px;
}
.ui-icon-star
{
  background-position: -224px -112px;
}
.ui-icon-link
{
  background-position: -240px -112px;
}
.ui-icon-cancel
{
  background-position: 0 -128px;
}
.ui-icon-plus
{
  background-position: -16px -128px;
}
.ui-icon-plusthick
{
  background-position: -32px -128px;
}
.ui-icon-minus
{
  background-position: -48px -128px;
}
.ui-icon-minusthick
{
  background-position: -64px -128px;
}
.ui-icon-close
{
  background-position: -80px -128px;
}
.ui-icon-closethick
{
  background-position: -96px -128px;
}
.ui-icon-key
{
  background-position: -112px -128px;
}
.ui-icon-lightbulb
{
  background-position: -128px -128px;
}
.ui-icon-scissors
{
  background-position: -144px -128px;
}
.ui-icon-clipboard
{
  background-position: -160px -128px;
}
.ui-icon-copy
{
  background-position: -176px -128px;
}
.ui-icon-contact
{
  background-position: -192px -128px;
}
.ui-icon-image
{
  background-position: -208px -128px;
}
.ui-icon-video
{
  background-position: -224px -128px;
}
.ui-icon-script
{
  background-position: -240px -128px;
}
.ui-icon-alert
{
  background-position: 0 -144px;
}
.ui-icon-info
{
  background-position: -16px -144px;
}
.ui-icon-notice
{
  background-position: -32px -144px;
}
.ui-icon-help
{
  background-position: -48px -144px;
}
.ui-icon-check
{
  background-position: -64px -144px;
}
.ui-icon-bullet
{
  background-position: -80px -144px;
}
.ui-icon-radio-off
{
  background-position: -96px -144px;
}
.ui-icon-radio-on
{
  background-position: -112px -144px;
}
.ui-icon-pin-w
{
  background-position: -128px -144px;
}
.ui-icon-pin-s
{
  background-position: -144px -144px;
}
.ui-icon-play
{
  background-position: 0 -160px;
}
.ui-icon-pause
{
  background-position: -16px -160px;
}
.ui-icon-seek-next
{
  background-position: -32px -160px;
}
.ui-icon-seek-prev
{
  background-position: -48px -160px;
}
.ui-icon-seek-end
{
  background-position: -64px -160px;
}
.ui-icon-seek-start
{
  background-position: -80px -160px;
}
/* ui-icon-seek-first is deprecated, use ui-icon-seek-start instead */
.ui-icon-seek-first
{
  background-position: -80px -160px;
}
.ui-icon-stop
{
  background-position: -96px -160px;
}
.ui-icon-eject
{
  background-position: -112px -160px;
}
.ui-icon-volume-off
{
  background-position: -128px -160px;
}
.ui-icon-volume-on
{
  background-position: -144px -160px;
}
.ui-icon-power
{
  background-position: 0 -176px;
}
.ui-icon-signal-diag
{
  background-position: -16px -176px;
}
.ui-icon-signal
{
  background-position: -32px -176px;
}
.ui-icon-battery-0
{
  background-position: -48px -176px;
}
.ui-icon-battery-1
{
  background-position: -64px -176px;
}
.ui-icon-battery-2
{
  background-position: -80px -176px;
}
.ui-icon-battery-3
{
  background-position: -96px -176px;
}
.ui-icon-circle-plus
{
  background-position: 0 -192px;
}
.ui-icon-circle-minus
{
  background-position: -16px -192px;
}
.ui-icon-circle-close
{
  background-position: -32px -192px;
}
.ui-icon-circle-triangle-e
{
  background-position: -48px -192px;
}
.ui-icon-circle-triangle-s
{
  background-position: -64px -192px;
}
.ui-icon-circle-triangle-w
{
  background-position: -80px -192px;
}
.ui-icon-circle-triangle-n
{
  background-position: -96px -192px;
}
.ui-icon-circle-arrow-e
{
  background-position: -112px -192px;
}
.ui-icon-circle-arrow-s
{
  background-position: -128px -192px;
}
.ui-icon-circle-arrow-w
{
  background-position: -144px -192px;
}
.ui-icon-circle-arrow-n
{
  background-position: -160px -192px;
}
.ui-icon-circle-zoomin
{
  background-position: -176px -192px;
}
.ui-icon-circle-zoomout
{
  background-position: -192px -192px;
}
.ui-icon-circle-check
{
  background-position: -208px -192px;
}
.ui-icon-circlesmall-plus
{
  background-position: 0 -208px;
}
.ui-icon-circlesmall-minus
{
  background-position: -16px -208px;
}
.ui-icon-circlesmall-close
{
  background-position: -32px -208px;
}
.ui-icon-squaresmall-plus
{
  background-position: -48px -208px;
}
.ui-icon-squaresmall-minus
{
  background-position: -64px -208px;
}
.ui-icon-squaresmall-close
{
  background-position: -80px -208px;
}
.ui-icon-grip-dotted-vertical
{
  background-position: 0 -224px;
}
.ui-icon-grip-dotted-horizontal
{
  background-position: -16px -224px;
}
.ui-icon-grip-solid-vertical
{
  background-position: -32px -224px;
}
.ui-icon-grip-solid-horizontal
{
  background-position: -48px -224px;
}
.ui-icon-gripsmall-diagonal-se
{
  background-position: -64px -224px;
}
.ui-icon-grip-diagonal-se
{
  background-position: -80px -224px;
}


/* Misc visuals
----------------------------------*/

/* Corner radius */
.ui-corner-tl
{
  -moz-border-radius-topleft: <?php echo $cornerRadius ?>;
  -webkit-border-top-left-radius: <?php echo $cornerRadius ?>;
  border-top-left-radius: <?php echo $cornerRadius ?>;
}

.ui-corner-tr
{
  -moz-border-radius-topright: <?php echo $cornerRadius ?>;
  -webkit-border-top-right-radius: <?php echo $cornerRadius ?>;
  border-top-right-radius: <?php echo $cornerRadius ?>;
}

.ui-corner-bl
{
  -moz-border-radius-bottomleft: <?php echo $cornerRadius ?>;
  -webkit-border-bottom-left-radius: <?php echo $cornerRadius ?>;
  border-bottom-left-radius: <?php echo $cornerRadius ?>;
}

.ui-corner-br
{
  -moz-border-radius-bottomright: <?php echo $cornerRadius ?>;
  -webkit-border-bottom-right-radius: <?php echo $cornerRadius ?>;
  border-bottom-right-radius: <?php echo $cornerRadius ?>;
}

.ui-corner-top
{
  -moz-border-radius-topleft: <?php echo $cornerRadius ?>;
  -webkit-border-top-left-radius: <?php echo $cornerRadius ?>;
  border-top-left-radius: <?php echo $cornerRadius ?>;
  -moz-border-radius-topright: <?php echo $cornerRadius ?>;
  -webkit-border-top-right-radius: <?php echo $cornerRadius ?>;
  border-top-right-radius: <?php echo $cornerRadius ?>;
}

.ui-corner-bottom
{
  -moz-border-radius-bottomleft: <?php echo $cornerRadius ?>;
  -webkit-border-bottom-left-radius: <?php echo $cornerRadius ?>;
  border-bottom-left-radius: <?php echo $cornerRadius ?>;
  -moz-border-radius-bottomright: <?php echo $cornerRadius ?>;
  -webkit-border-bottom-right-radius: <?php echo $cornerRadius ?>;
  border-bottom-right-radius: <?php echo $cornerRadius ?>;
}

.ui-corner-right
{
  -moz-border-radius-topright: <?php echo $cornerRadius ?>;
  -webkit-border-top-right-radius: <?php echo $cornerRadius ?>;
  border-top-right-radius: <?php echo $cornerRadius ?>;
  -moz-border-radius-bottomright: <?php echo $cornerRadius ?>;
  -webkit-border-bottom-right-radius: <?php echo $cornerRadius ?>;
  border-bottom-right-radius: <?php echo $cornerRadius ?>;
}

.ui-corner-left
{
  -moz-border-radius-topleft: <?php echo $cornerRadius ?>;
  -webkit-border-top-left-radius: <?php echo $cornerRadius ?>;
  border-top-left-radius: <?php echo $cornerRadius ?>;
  -moz-border-radius-bottomleft: <?php echo $cornerRadius ?>;
  -webkit-border-bottom-left-radius: <?php echo $cornerRadius ?>;
  border-bottom-left-radius: <?php echo $cornerRadius ?>;
}

.ui-corner-all
{
  -moz-border-radius: <?php echo $cornerRadius ?>;
  -webkit-border-radius: <?php echo $cornerRadius ?>;
  border-radius: <?php echo $cornerRadius ?>;
}

/* Overlays */
.ui-widget-overlay
{
  background: #<?php echo  $bgColorOverlay ?> url(<?php echo $imagePath ?>ui/<?php echo $img_bgTextureOverlay ?>) 50% 50% repeat;
  opacity: .<?php echo $opacityOverlay ?>;
  filter:Alpha(Opacity=<?php echo $opacityOverlay ?>);
}

.ui-widget-shadow
{
  margin: <?php echo $offsetTopShadow ?> 0 0 <?php echo $offsetLeftShadow ?>;
  padding: <?php echo $thicknessShadow ?>;
  background: #<?php echo $bgColorShadow  ?> url(<?php echo $imagePath ?>ui/<?php echo $img_bgTextureShadow  ?>) 50% 50% repeat;
  opacity: .<?php echo $opacityShadow ?>;
  filter:Alpha(Opacity=<?php echo $opacityShadow ?>);
  -moz-border-radius: <?php echo $cornerRadiusShadow ?>;
  -webkit-border-radius: <?php echo $cornerRadiusShadow ?>;
  border-radius: <?php echo $cornerRadiusShadow ?>;
}

/*
 * jQuery UI Resizable @VERSION
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Resizable#theming
 */
.ui-resizable
{
  position: relative;
}

.ui-resizable-handle
{
  position: absolute;
  font-size: 0.1px;
  z-index: 99999;
  display: block;
}

.ui-resizable-disabled .ui-resizable-handle,
.ui-resizable-autohide .ui-resizable-handle
{
  display: none;
}

.ui-resizable-n
{
  cursor: n-resize;
  height: 7px;
  width: 100%;
  top: -5px;
  left: 0;
}

.ui-resizable-s
{
  cursor: s-resize;
  height: 7px;
  width: 100%;
  bottom: -5px;
  left: 0;
}

.ui-resizable-e
{
  cursor: e-resize;
  width: 7px;
  right: -5px;
  top: 0;
  height: 100%;
}

.ui-resizable-w
{
  cursor: w-resize;
  width: 7px;
  left: -5px;
  top: 0;
  height: 100%;
}

.ui-resizable-se
{
  cursor: se-resize;
  width: <?php echo $cornerRadiusShadow ?>;
  height: <?php echo $cornerRadiusShadow ?>;
  right: 1px;
  bottom: 1px;
}

.ui-resizable-sw
{
  cursor: sw-resize;
  width: 9px;
  height: 9px;
  left: -5px;
  bottom: -5px;
}

.ui-resizable-nw
{
  cursor: nw-resize;
  width: 9px; height: 9px;
  left: -5px;
  top: -5px;
}

.ui-resizable-ne
{
  cursor: ne-resize;
  width: 9px;
  height: 9px; right: -5px; top: -5px;
}

/*
 * jQuery UI Selectable @VERSION
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Selectable#theming
 */
.ui-selectable-helper
{
  position: absolute;
  z-index: 100;
  border:1px dotted black;
}

/*
 * jQuery UI Accordion @VERSION
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Accordion#theming
 */
/* IE/Win - Fix animation bug - #4615 */
.ui-accordion
{
  width: 100%;
}

.ui-accordion .ui-accordion-header
{
  cursor: pointer;
  position: relative;
  margin-top: 1px;
  zoom: 1;
}

.ui-accordion .ui-accordion-li-fix
{
  display: inline;
}

.ui-accordion .ui-accordion-header-active
{
  border-bottom: 0 !important;
}

.ui-accordion .ui-accordion-header a
{
  display: block;
  font-size: 1em;
  padding: .5em .5em .5em .7em;
}

.ui-accordion-icons .ui-accordion-header a
{
  padding-left: 2.2em;
}

.ui-accordion .ui-accordion-header .ui-icon
{
  position: absolute;
  left: .5em;
  top: 50%;
  /*margin-top: <?php echo $offsetTopShadow ?>;*/
}

.ui-accordion .ui-accordion-content
{
  padding: .8em 1.2em;
  border-top: 0;
  margin-top: 0px;
  position: relative;
  top: 1px;
  margin-bottom: 2px;
  overflow: auto;
  display: none;
  zoom: 1;
}

.ui-accordion .ui-accordion-content-active
{
  display: block;
}

/*
 * jQuery UI Autocomplete @VERSION
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Autocomplete#theming
 */
.ui-autocomplete
{
  position: absolute;
  cursor: default;
}

/* workarounds */
* html .ui-autocomplete
{
  width:1px;
} /* without this, the menu expands to 100% in IE6 */

/*
 * jQuery UI Menu @VERSION
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Menu#theming
 */
.ui-menu
{
  list-style:none;
  padding: 2px;
  margin: 0;
  display:block;
  float: left;
}

.ui-menu .ui-menu
{
  margin-top: -3px;
}

.ui-menu .ui-menu-item
{
  margin:0;
  padding: 0;
  zoom: 1;
  float: left;
  clear: left;
  width: 100%;
}

.ui-menu .ui-menu-item a
{
  text-decoration:none;
  display:block;
  padding:.2em .4em;
  line-height:1.0;
  zoom:1;
}

.ui-menu .ui-menu-item a.ui-state-hover,
.ui-menu .ui-menu-item a.ui-state-active
{
  font-weight: <?php echo $fwDefault  ?>;
  margin: -1px;
}

/*
 * jQuery UI Button @VERSION
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Button#theming
 */
.ui-button
{
  display: inline-block;
  position: relative;
  padding: 0;
  margin-right: .1em;
  text-decoration: none !important;
  cursor: pointer;
  text-align: center;
  zoom: 1;
  overflow: visible;
} /* the overflow property removes extra width in IE */

.ui-button-icon-only
{
  width: 2.2em;
} /* to make room for the icon, a width needs to be set here */

button.ui-button-icon-only
{
  width: 2.4em;
} /* button elements seem to need a little more width */

.ui-button-icons-only
{
  width: 3.4em;
}

button.ui-button-icons-only { width: 3.7em; }

/*button text element */
.ui-button .ui-button-text
{
  display: block;
  line-height: 0.9;
}

.ui-button-text-only .ui-button-text
{
  padding: .3em .5em;
}

.ui-button-icon-only .ui-button-text,
.ui-button-icons-only .ui-button-text
{
  padding: .3em; text-indent: -9999999px;
}

.ui-button-text-icon-primary .ui-button-text,
.ui-button-text-icons .ui-button-text
{
  padding: .3em .5em .3em 2.1em;
}

.ui-button-text-icon-secondary .ui-button-text, .ui-button-text-icons .ui-button-text
{
  padding: .3em 2.1em .3em .5em;
}

.ui-button-text-icons .ui-button-text
{
  padding-left: 2.1em;
  padding-right: 2.1em;
}
/* no icon support for input elements, provide padding by default */
input.ui-button
{
  padding: .3em .5em;
}

/*button icon element(s) */
.ui-button-icon-only .ui-icon,
.ui-button-text-icon-primary .ui-icon,
.ui-button-text-icon-secondary .ui-icon,
.ui-button-text-icons .ui-icon,
.ui-button-icons-only .ui-icon
{
  position: absolute; top: 50%;
  margin-top: <?php echo $offsetTopShadow ?>;
}

.ui-button-icon-only .ui-icon
{
  left: 50%;
  margin-left: <?php echo $offsetTopShadow ?>;
}

.ui-button-text-icon-primary .ui-button-icon-primary,
.ui-button-text-icons .ui-button-icon-primary,
.ui-button-icons-only .ui-button-icon-primary
{
  left: .4em;
}

.ui-button-text-icon-secondary .ui-button-icon-secondary,
.ui-button-text-icons .ui-button-icon-secondary,
.ui-button-icons-only .ui-button-icon-secondary
{
  right: .4em;
}

.ui-button-text-icons .ui-button-icon-secondary,
.ui-button-icons-only .ui-button-icon-secondary
{
  right: .4em;
}

/*button sets*/
.ui-buttonset
{
  margin-right: 7px;
}

.ui-buttonset .ui-button
{
  margin-left: 0;
  margin-right: -.3em;
}

/* workarounds */
button.ui-button::-moz-focus-inner
{
  border: 0;
  padding: 0;
} /* reset extra padding in Firefox */


/*
 * jQuery UI Dialog @VERSION
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Dialog#theming
 */
.ui-dialog
{
  position: absolute;
  padding: .2em;
  width: 300px;
  overflow: hidden;
}

.ui-dialog .ui-dialog-titlebar
{
  padding: .2em 0.8em .2em;
  position: relative;
}

.ui-dialog .ui-dialog-title
{
  float: left;
  margin: .1em 16px .2em 0;
}

.ui-dialog .ui-dialog-titlebar-close
{
  position: absolute;
  right: .3em;
  top: 50%;
  width: 19px;
  margin: -10px 0 0 0;
  padding: 1px;
  height: 18px;
}

.ui-dialog .ui-dialog-titlebar-close span
{
  display: block;
  margin: 1px;
}

.ui-dialog .ui-dialog-titlebar-close:hover,
.ui-dialog .ui-dialog-titlebar-close:focus
{
  padding: 0;
}

.ui-dialog .ui-dialog-content
{
  position: relative;
  border: 0;
  /*padding: .5em 1em;*/
  background: none;
  overflow: auto;
  zoom: 1;
}

.ui-dialog .ui-dialog-buttonpane
{
  text-align: left;
  border-width: 1px 0 0 0;
  background-image: none;
  margin: .5em 0 0 0;
  padding: .2em 0.8em .2em .3em;
}

.ui-dialog .ui-dialog-buttonpane .ui-dialog-buttonset
{
  float: right;
}

.ui-dialog .ui-dialog-buttonpane button
{
  margin: .5em .4em .5em 0;
  cursor: pointer;
}

.ui-dialog .ui-resizable-se
{
  width: 14px;
  height: 14px;
  right: 3px;
  bottom: 3px;
}

.ui-draggable .ui-dialog-titlebar
{
  cursor: move;
}

/*
 * jQuery UI Slider @VERSION
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Slider#theming
 */
.ui-slider
{
  position: relative;
  text-align: left;
}

.ui-slider .ui-slider-handle
{
  position: absolute;
  z-index: 2;
  width: 1.2em;
  height: 1.2em;
  cursor: default;
}

.ui-slider .ui-slider-range
{
  position: absolute;
  z-index: 1;
  font-size: .7em;
  display: block;
  border: 0;
  background-position: 0 0;
}

.ui-slider-horizontal
{
  height: .8em;
}

.ui-slider-horizontal .ui-slider-handle
{
  top: -.3em;
  margin-left: -.6em;
}

.ui-slider-horizontal .ui-slider-range
{
  top: 0;
  height: 100%;
}

.ui-slider-horizontal .ui-slider-range-min
{
  left: 0;
}

.ui-slider-horizontal .ui-slider-range-max
{
  right: 0;
}

.ui-slider-vertical
{
  width: .8em;
  height: 100px;
}

.ui-slider-vertical .ui-slider-handle
{
  left: -.3em;
  margin-left: 0;
  margin-bottom: -.6em;
}

.ui-slider-vertical .ui-slider-range
{
  left: 0;
  width: 100%;
}

.ui-slider-vertical .ui-slider-range-min
{
  bottom: 0;
}

.ui-slider-vertical .ui-slider-range-max
{
  top: 0;
}

/*
 * jQuery UI Tabs @VERSION
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Tabs#theming
 */
.ui-tabs
{
  position: relative;
  padding: .2em; zoom: 1;
} /* position: relative prevents IE scroll bug (element with position: relative inside container with overflow: auto appear as "fixed") */

.ui-tabs .ui-tabs-nav
{
  margin: 0;
  padding: .2em .2em 0;
}

.ui-tabs .ui-tabs-nav li
{
  list-style: none;
  float: left;
  position: relative; top: 1px;
  margin: 0 .2em 1px 0;
  border-bottom: 0 !important;
  padding: 0; white-space: nowrap;
}

.ui-tabs .ui-tabs-nav li a
{
  float: left;
  padding: .5em 1em;
  text-decoration: none;
}

.ui-tabs .ui-tabs-nav li.ui-tabs-selected
{
  margin-bottom: 0;
  padding-bottom: 1px;
}

.ui-tabs .ui-tabs-nav li.ui-tabs-selected a,
.ui-tabs .ui-tabs-nav li.ui-state-disabled a,
.ui-tabs .ui-tabs-nav li.ui-state-processing a
{
  cursor: text;
}

.ui-tabs .ui-tabs-nav li a,
.ui-tabs.ui-tabs-collapsible .ui-tabs-nav li.ui-tabs-selected a
{
  cursor: pointer;
} /* first selector in group seems obsolete, but required to overcome bug in Opera applying cursor: text overall if defined elsewhere... */

.ui-tabs .ui-tabs-panel
{
  display: block;
  border-width: 0;
  padding: 1em 1.4em;
  background: none;
}

.ui-tabs .ui-tabs-hide
{
  display: none !important;
}

/*
 * jQuery UI Datepicker @VERSION
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Datepicker#theming
 */
.ui-datepicker
{
  padding: .3em .3em 0;
}

.ui-datepicker .ui-datepicker-header
{
  position:relative;
  padding:.2em 0;
}

.ui-datepicker .ui-datepicker-prev,
.ui-datepicker .ui-datepicker-next
{
  position:absolute;
  top: 2px;
  width: 1.8em;
  height: 1.8em;
}

.ui-datepicker .ui-datepicker-prev-hover,
.ui-datepicker .ui-datepicker-next-hover
{
  top: 1px;
}

.ui-datepicker .ui-datepicker-prev
{
  left:2px;
}

.ui-datepicker .ui-datepicker-next
{
  right:2px;
}

.ui-datepicker .ui-datepicker-prev-hover
{
  left:1px;
}

.ui-datepicker .ui-datepicker-next-hover
{
  right:1px;
}

.ui-datepicker .ui-datepicker-prev span,
.ui-datepicker .ui-datepicker-next span
{
  display: block;
  position: absolute;
  left: 50%;  
  top: 50%;
  /*
  margin-left: <?php echo $offsetTopShadow ?>;
  margin-top: <?php echo $offsetTopShadow ?>;
  */
}

.ui-datepicker .ui-datepicker-title
{
  margin: 0 2.3em;
  line-height: 1.6em;
  text-align: center;
}

.ui-datepicker .ui-datepicker-title select
{
  font-size:1em;
  margin:1px 0;
}

.ui-datepicker select.ui-datepicker-month-year
{
  width: 100%;
}

.ui-datepicker select.ui-datepicker-month,
.ui-datepicker select.ui-datepicker-year
{
  width: 49%;
}

.ui-datepicker table
{
  width: 100%;
  font-size: .9em;
  border-collapse: collapse;
  margin:0 0 .4em;
}

.ui-datepicker th
{
  padding: .7em .3em;
  text-align: center;
  font-weight: <?php echo $fwDefault  ?>;
  border: 0;
}

.ui-datepicker td
{
  border: 0;
  padding: 1px;
}

.ui-datepicker td span, .ui-datepicker td a
{
  display: block;
  padding: .2em;
  text-align: right;
  text-decoration: none;
}

.ui-datepicker .ui-datepicker-buttonpane
{
  background-image: none;
  margin: .7em 0 0 0;
  padding:0 .2em;
  border-left: 0;
  border-right: 0;
  border-bottom: 0;
}

.ui-datepicker .ui-datepicker-buttonpane button
{
  float: right;
  margin: .5em .2em .4em;
  cursor: pointer;
  padding: .2em .6em .3em .6em;
  width:auto;
  overflow:visible;
}

.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current
{
  float:left;
}

/* with multiple calendars */
.ui-datepicker.ui-datepicker-multi
{
  width:auto;
}

.ui-datepicker-multi .ui-datepicker-group
{
  float:left;
}

.ui-datepicker-multi .ui-datepicker-group table
{
  width:95%;
  margin:0 auto .4em;
}

.ui-datepicker-multi-2 .ui-datepicker-group
{
  width:50%;
}

.ui-datepicker-multi-3 .ui-datepicker-group
{
  width:33.3%;
}

.ui-datepicker-multi-4 .ui-datepicker-group
{
  width:25%;
}

.ui-datepicker-multi .ui-datepicker-group-last .ui-datepicker-header
{
  border-left-width:0;
}

.ui-datepicker-multi .ui-datepicker-group-middle .ui-datepicker-header
{
  border-left-width:0;
}

.ui-datepicker-multi .ui-datepicker-buttonpane
{
  clear:left;
}

.ui-datepicker-row-break
{
  clear:both; width:100%;
}

/* RTL support */
.ui-datepicker-rtl
{
  direction: rtl;
}

.ui-datepicker-rtl .ui-datepicker-prev
{
  right: 2px; left: auto;
}

.ui-datepicker-rtl .ui-datepicker-next
{
  left: 2px; right: auto;
}

.ui-datepicker-rtl .ui-datepicker-prev:hover
{
  right: 1px; left: auto;
}

.ui-datepicker-rtl .ui-datepicker-next:hover
{
  left: 1px; right: auto;
}

.ui-datepicker-rtl .ui-datepicker-buttonpane
{
  clear:right;
}

.ui-datepicker-rtl .ui-datepicker-buttonpane button
{
  float: left;
}

.ui-datepicker-rtl .ui-datepicker-buttonpane button.ui-datepicker-current
{
  float:right;
}

.ui-datepicker-rtl .ui-datepicker-group
{
  float:right;
}

.ui-datepicker-rtl .ui-datepicker-group-last .ui-datepicker-header
{
  border-right-width:0; border-left-width:1px;
}

.ui-datepicker-rtl .ui-datepicker-group-middle .ui-datepicker-header
{
  border-right-width:0;
  border-left-width:1px;
}

/* IE6 IFRAME FIX (taken from datepicker 1.5.3 */
.ui-datepicker-cover {
    display: none; /*sorry for IE5*/
    display/**/: block; /*sorry for IE5*/
    position: absolute; /*must have*/
    z-index: -1; /*must have*/
    filter: mask(); /*must have*/
    top: -4px; /*must have*/
    left: -4px; /*must have*/
    width: 200px; /*must have*/
    height: 200px; /*must have*/
}

/*
 * jQuery UI Progressbar @VERSION
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Progressbar#theming
 */
.ui-progressbar
{
  height:2em;
  text-align: left;
}

.ui-progressbar .ui-progressbar-value
{
  margin: -1px;
  height:100%;
}
