<?php 

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

?>


<form action="index.php?serv=ThemeBuilder:render" target="code" method="POST" >

  <div class="wgt-slice full" >
    <fieldset >
      <legend>Theme Link</legend>
      <textarea name="url" style="width:100%;height:200px;" >&ffDefault=Verdana,Arial,sans-serif&fwDefault=normal&fsDefault=1em&cornerRadius=3px&bgColorHeader=750003&bgTextureHeader=04_highlight_hard.png&bgImgOpacityHeader=20&borderColorHeader=5c5c5c&fcHeader=cccccc&iconColorHeader=cccccc&bgColorContent=f8f8f8&bgTextureContent=01_flat.png&bgImgOpacityContent=95&borderColorContent=5c5c5c&fcContent=222222&iconColorContent=222222&bgColorDefault=ababab&bgTextureDefault=04_highlight_hard.png&bgImgOpacityDefault=45&borderColorDefault=5c5c5c&fcDefault=ffffff&iconColorDefault=ffffff&bgColorHover=ffdea3&bgTextureHover=04_highlight_hard.png&bgImgOpacityHover=55&borderColorHover=5c5c5c&fcHover=750003&iconColorHover=750003&bgColorActive=474747&bgTextureActive=03_highlight_soft.png&bgImgOpacityActive=50&borderColorActive=5c5c5c&fcActive=ffffff&iconColorActive=ffffff&bgColorHighlight=f8da4e&bgTextureHighlight=02_glass.png&bgImgOpacityHighlight=55&borderColorHighlight=fcd113&fcHighlight=750003&iconColorHighlight=750003&bgColorError=e14f1c&bgTextureError=12_gloss_wave.png&bgImgOpacityError=45&borderColorError=750003&fcError=ffffff&iconColorError=fcd113&bgColorOverlay=aaaaaa&bgTextureOverlay=07_diagonals_small.png&bgImgOpacityOverlay=75&opacityOverlay=30&bgColorShadow=999999&bgTextureShadow=01_flat.png&bgImgOpacityShadow=55&opacityShadow=45&thicknessShadow=0px&offsetTopShadow=5px&offsetLeftShadow=5px&cornerRadiusShadow=5px</textarea>
    </fieldset>
  </div>

  <div class="wgt-slice full" >
  
    <fieldset style="width:310px;" class="left" >
      <legend>WGT Styles</legend>
      
      <div class="wgt-box-input" >
        <label style="width:120px;" >Header Bg</label>
        <div class="element" ><input name="header_bg" value="#CBCBCB" /> <span>#dfeffc</span></div>
      </div>
      
      <div class="wgt-box-input" >
        <label style="width:120px;" >Footer Bg</label>
        <div class="element" ><input name="footer_bg" value="#F2F2F2" /></div>
      </div>
      
    </fieldset>
    
    <fieldset style="width:310px;" class="inline" >
      <legend>Color Mapping</legend>
      
      <div class="wgt-box-input" >
        <label style="width:120px;" >Button Style</label>
        <div class="element" >
        
          <select name="button_style" >
            <option>content</option>
            <option>header</option>
          </select>
        
        </div>
      </div>
      
    </fieldset>
    
  </div>
  
  <div class="wgt-slice full" >
  
    <fieldset style="width:310px;" class="left" >
      <legend>UI Default</legend>
      
      <div class="wgt-box-input" >
        <label>Font Family</label>
        <div class="element" ><input name="ff_default" value="<?php echo $ffDefault ?>" /></div>
      </div>
      
      <div class="wgt-box-input" >
        <label>Font Weight</label>
        <div class="element" ><input name="fw_default" value="<?php echo $fwDefault  ?>" /></div>
      </div>
      
      <div class="wgt-box-input" >
        <label>Font Size</label>
        <div class="element" ><input name="fs_default" value="<?php echo $fsDefault  ?>" /></div>
      </div>
      
      <div class="wgt-box-input" >
        <label>Corner Radius</label>
        <div class="element" ><input name="corner_radius" value="<?php echo $cornerRadius  ?>" /></div>
      </div>
      
    </fieldset>

    <fieldset style="width:310px;" class="inline" >
      <legend>Overlay</legend>
      
      <div class="wgt-box-input" >
        <label>bg color</label>
        <div class="element" >
          <input name="bg_color_overlay" value="<?php echo $bgColorOverlay ?>" />
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>bg img opacity</label>
        <div class="element" >
          <input name="bg_img_op_overly" value="<?php echo $bgImgOpacityOverlay  ?>" />
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>opacity</label>
        <div class="element" >
          <input name="opacity_overlay" value="<?php echo $opacityOverlay  ?>" />
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>bg color shadow</label>
        <div class="element" >
          <input name="bg_color_shadow" value="<?php echo $bgColorShadow  ?>" />
        </div>
      </div>
      
    </fieldset>
    
    <fieldset style="width:310px;" class="inline" >
      <legend>Shadow</legend>
      
      <div class="wgt-box-input" >
        <label>img opacity</label>
        <div class="element" >
          <input name="img_opacity_shadow" value="<?php echo $bgImgOpacityShadow ?>" />
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>opacity</label>
        <div class="element" >
          <input name="opacity_shadow" value="<?php echo $opacityShadow  ?>" />
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>thickness</label>
        <div class="element" >
          <input name="thickness_shadow" value="<?php echo $thicknessShadow  ?>" />
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>offset top</label>
        <div class="element" >
          <input name="offset_top_shadow" value="<?php echo $offsetTopShadow  ?>" />
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>offset left</label>
        <div class="element" >
          <input name="offset_left_shadow" value="<?php echo $offsetLeftShadow  ?>" />
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>Corner Radius</label>
        <div class="element" >
          <input name="corner_rad_shadow" value="<?php echo $cornerRadiusShadow  ?>" />
        </div>
      </div>
      
    </fieldset>
    
  </div>
  

  <div class="wgt-slice full" >

    <fieldset style="width:310px;" class="left" >
      <legend>Default</legend>
      
      <div class="wgt-box-input" >
        <label>bg color</label>
        <div class="element"  >
          <input name="bg_color_default" value="<?php echo $bgColorDefault ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $bgColorDefault ?>" >&nbsp;</div>
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>bg opacity</label>
        <div class="element" ><input name="bg_img_op_default" value="<?php echo $bgImgOpacityDefault  ?>" /></div>
      </div>
      
      <div class="wgt-box-input" >
        <label>border color</label>
        <div class="element">
          <input name="border_color_default" value="<?php echo $borderColorDefault  ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $borderColorDefault ?>" >&nbsp;</div>
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>font color</label>
        <div class="element" >
          <input name="font_color_default" value="<?php echo $fcDefault  ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $fcDefault ?>" >&nbsp;</div>
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>icon color</label>
        <div class="element" >
          <input name="icon_color_default" value="<?php echo $iconColorDefault  ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $iconColorDefault ?>" >&nbsp;</div>
        </div>
      </div>
      
    </fieldset>
    
     <fieldset style="width:310px;" class="inline" >
      <legend>Content</legend>
      
      <div class="wgt-box-input" >
        <label>bg color</label>
        <div class="element" >
          <input name="bg_color_content" value="<?php echo $bgColorContent ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $bgColorContent ?>" >&nbsp;</div>
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>bg opacity</label>
        <div class="element" >
          <input name="bg_img_op_content" value="<?php echo $bgImgOpacityContent  ?>" />
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>border color</label>
        <div class="element" >
          <input name="border_color_content" value="<?php echo $borderColorContent  ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $borderColorContent ?>" >&nbsp;</div>
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>font color</label>
        <div class="element" >
          <input name="font_color_content" value="<?php echo $fcContent  ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $fcContent ?>" >&nbsp;</div>
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>icon color</label>
        <div class="element" >
          <input name="icon_color_content" value="<?php echo $iconColorContent  ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $iconColorContent ?>" >&nbsp;</div>
        </div>
      </div>
      
    </fieldset>

    <fieldset style="width:310px;" class="inline" >
      <legend>Header</legend>
      
      <div class="wgt-box-input" >
        <label>bg color</label>
        <div class="element"  >
          <input name="bg_color_header" value="<?php echo $bgColorHeader ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $bgColorHeader ?>" >&nbsp;</div>
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>bg opacity</label>
        <div class="element" ><input name="bg_img_op_header" value="<?php echo $bgImgOpacityHeader  ?>" /></div>
      </div>
      
      <div class="wgt-box-input" >
        <label>border color</label>
        <div class="element">
          <input name="border_color_header" value="<?php echo $borderColorHeader  ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $borderColorHeader ?>" >&nbsp;</div>
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>font color</label>
        <div class="element" >
          <input name="font_color_header" value="<?php echo $fcHeader  ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $fcHeader ?>" >&nbsp;</div>
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>icon color</label>
        <div class="element" >
          <input name="icon_color_header" value="<?php echo $iconColorHeader  ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $iconColorHeader ?>" >&nbsp;</div>
        </div>
      </div>
      
    </fieldset>

  </div>
  
  <div class="wgt-slice full" >

    <fieldset style="width:310px;" class="left" >
      <legend>Active</legend>
      
      <div class="wgt-box-input" >
        <label>bg color</label>
        <div class="element"  >
          <input name="bg_color_active" value="<?php echo $bgColorActive ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $bgColorActive ?>" >&nbsp;</div>
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>bg opacity</label>
        <div class="element" ><input name="bg_img_op_active" value="<?php echo $bgImgOpacityActive  ?>" /></div>
      </div>
      
      <div class="wgt-box-input" >
        <label>border color</label>
        <div class="element">
          <input name="border_color_active" value="<?php echo $borderColorActive  ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $borderColorActive ?>" >&nbsp;</div>
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>font color</label>
        <div class="element" >
          <input name="font_color_active" value="<?php echo $fcActive  ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $fcActive ?>" >&nbsp;</div>
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>icon color</label>
        <div class="element" >
          <input name="icon_color_active" value="<?php echo $iconColorActive  ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $iconColorActive ?>" >&nbsp;</div>
        </div>
      </div>
      
    </fieldset>

     <fieldset style="width:310px;" class="inline" >
      <legend>Hover</legend>
      
      <div class="wgt-box-input" >
        <label>bg color</label>
        <div class="element" >
          <input name="bg_color_hover" value="<?php echo $bgColorHover ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $bgColorHover ?>" >&nbsp;</div>
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>bg opacity</label>
        <div class="element" >
          <input name="bg_img_op_hover" value="<?php echo $bgImgOpacityHover  ?>" />
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>border color</label>
        <div class="element" >
          <input name="border_color_hover" value="<?php echo $borderColorHover  ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $borderColorHover ?>" >&nbsp;</div>
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>font color</label>
        <div class="element" >
          <input name="font_color_hover" value="<?php echo $fcHover  ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $fcHover ?>" >&nbsp;</div>
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>icon color</label>
        <div class="element" >
          <input name="icon_color_hover" value="<?php echo $iconColorHover  ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $iconColorHover ?>" >&nbsp;</div>
        </div>
      </div>
      
    </fieldset>

    <fieldset style="width:310px;" class="inline" >
      <legend>Highlight</legend>
      
      <div class="wgt-box-input" >
        <label>bg color</label>
        <div class="element"  >
          <input name="bg_color_highlight" value="<?php echo $bgColorHighlight ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $bgColorHighlight ?>" >&nbsp;</div>
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>bg opacity</label>
        <div class="element" ><input name="bg_img_op_highlight" value="<?php echo $bgImgOpacityHighlight  ?>" /></div>
      </div>
      
      <div class="wgt-box-input" >
        <label>border color</label>
        <div class="element">
          <input name="border_color_highlight" value="<?php echo $borderColorHighlight  ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $borderColorHighlight ?>" >&nbsp;</div>
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>font color</label>
        <div class="element" >
          <input name="font_color_highlight" value="<?php echo $fcHighlight  ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $fcHighlight ?>" >&nbsp;</div>
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>icon color</label>
        <div class="element" >
          <input name="icon_color_highlight" value="<?php echo $iconColorHighlight  ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $iconColorHighlight ?>" >&nbsp;</div>
        </div>
      </div>
      
    </fieldset>

  </div>
  
  <div class="wgt-slice full" >

    <fieldset style="width:310px;" class="left" >
      <legend>Error</legend>
      
      <div class="wgt-box-input" >
        <label>bg color</label>
        <div class="element"  >
          <input name="bg_color_error" value="<?php echo   $bgColorError ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo   $bgColorError ?>" >&nbsp;</div>
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>bg opacity</label>
        <div class="element" ><input name="bg_img_op_error" value="<?php echo $bgImgOpacityError  ?>" /></div>
      </div>
      
      <div class="wgt-box-input" >
        <label>border color</label>
        <div class="element">
          <input name="border_color_error" value="<?php echo $borderColorError  ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $borderColorError ?>" >&nbsp;</div>
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>font color</label>
        <div class="element" >
          <input name="font_color_error" value="<?php echo $fcError  ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $fcError ?>" >&nbsp;</div>
        </div>
      </div>
      
      <div class="wgt-box-input" >
        <label>icon color</label>
        <div class="element" >
          <input name="icon_color_error" value="<?php echo $iconColorError  ?>" />
          <div class="wgt-color_example" style="background-color:#<?php echo $iconColorError ?>" >&nbsp;</div>
        </div>
      </div>
      
    </fieldset>

  </div>

  <fieldset class="wgt-clear" >
    <legend>Build</legend>
    
    <select name="wgt_theme" >
      <option>light</option>
      <option>dark</option>
    </select>
    
    <button>Build Theme</button>
    
  </fieldset>


</form>


<fieldset class="wgt-clear" >
  <legend>Code</legend>
  <iframe name="code" style="width:100%;height:400px;border:1px dotted silver;" ></iframe>
</fieldset>

<fieldset class="wgt-clear" >
  <legend>Preview</legend>
  <iframe name="preview" style="width:100%;height:600px;border:1px dotted silver;" ></iframe>
</fieldset>