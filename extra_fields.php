<?php 

$thisfile = basename(__FILE__, '.php');

if (!is_frontend()) i18n_merge($thisfile) || i18n_merge($thisfile, 'en_US');

register_plugin(
  $thisfile,
  i18n_r($thisfile.'/TITLE'),
  '1.0',
  'Dmitry Yakovlev',
  'https://github.com/dimayakovlev',
  i18n_r($thisfile.'/DESCRIPTION'),
  '',
  ''
);

/*
 * This function return old field value after form submission, so I need to check if (basename($_SERVER['PHP_SELF']) == 'settings.php' && isset($_POST['submitted'])) to use $xmls instead $dataw in real plugins
 */
function get_website_field($field, $echo = true) {
  global $dataw;
  return echoReturn(stripslashes($dataw->$field), $echo);
}
/*

Possible solution:

if (!is_fontend() && basename($_SERVER['PHP_SELF']) == 'settings.php' && isset($_POST['submitted'])) {
  function get_website_field($field, $echo = true) {
    global $xmls;
    return echoReturn(stripslashes($xmls->$field), $echo);
  }
} else {
  function get_website_field($field, $echo = true) {
    global $dataw;
    return echoReturn(stripslashes($dataw->$field), $echo);
  }
}
*/

function pluginExtraFieldGUI($plugin_name) {
  /*
  
  Update $dataw with plugin:
  
  global $dataw;
  
  if (isset($_POST['submitted'])) {
    $dataw = getXML(GSDATAOTHERPATH.'website.xml');
  }
  
  or
  
  global $dataw, $xmls;
  
  if (isset($_POST['submitted'])) {
    $dataw = $xmls;
  }
  
  */
?>
<h3><?php i18n($plugin_name.'/TITLE'); ?></h3>
<div class="widesec">
  <p><label for="extraField1"><?php i18n($plugin_name.'/EXTRAFIELD'); ?> 1:</label><input name="extraField1" class="text" type="text" value="<?php get_website_field('extraField1'); ?>"></p>
</div>
<div class="widesec">
  <p><label for="extraField2"><?php i18n($plugin_name.'/EXTRAFIELD'); ?> 2:</label><input name="extraField2" class="text" type="text" value="<?php get_website_field('extraField2'); ?>"></p>
</div>
<?php 
}

function pluginExtraFieldSaveData() {
  global $xmls;
  $xmls->addChild('extraField1')->addCData(isset($_POST['extraField1']) ? safe_slash_html($_POST['extraField1']) : '');
  $xmls->addChild('extraField2')->addCData(isset($_POST['extraField2']) ? safe_slash_html($_POST['extraField2']) : '');
}

add_action('settings-website-extras', 'pluginExtraFieldGUI', array($thisfile));
add_action('settings-website', 'pluginExtraFieldSaveData'); // filter needed