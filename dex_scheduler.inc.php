<?php

if ( !defined('DEX_AUTH_INCLUDE') )
{
    echo 'Direct access not allowed.';
    exit;
}

global $wpdb;
if (defined('DEX_CALENDAR_USER') && DEX_CALENDAR_USER != 0)
    $myrows = $wpdb->get_results( "SELECT * FROM ".DEX_BCCF_CONFIG_TABLE_NAME." WHERE conwer=".DEX_CALENDAR_USER." AND caldeleted=0" );
else if (defined('DEX_BCCF_CALENDAR_FIXED_ID'))
    $myrows = $wpdb->get_results( "SELECT * FROM ".DEX_BCCF_CONFIG_TABLE_NAME." WHERE id=".DEX_BCCF_CALENDAR_FIXED_ID." AND caldeleted=0" );
else
    $myrows = $wpdb->get_results( "SELECT * FROM ".DEX_BCCF_CONFIG_TABLE_NAME." WHERE caldeleted=0" );

define ('CP_BCCF_CALENDAR_ID',$myrows[0]->id);

// for the additional services field if needed
$dex_buffer = "";
$services = explode("\n",dex_bccf_get_option('cp_cal_checkboxes', DEX_BCCF_DEFAULT_CP_CAL_CHECKBOXES));
foreach ($services as $item)
    if (trim($item) != '')
    {
        $dex_buffer .= '<option value="'.esc_attr($item).'">'.trim(substr($item,strpos($item,"|")+1)).'</option>';
    }

// localize script
wp_localize_script('dex_bccf_builder_script', 'dex_bccf_fbuilder_config', array('obj'  	=>
'{"pub":true,"messages": {
	                	"required": "'.str_replace(array('"', "'"),array('\\"', "\\'"),dex_bccf_get_option('vs_text_is_required', DEX_BCCF_DEFAULT_vs_text_is_required)).'",
	                	"email": "'.str_replace(array('"', "'"),array('\\"', "\\'"),dex_bccf_get_option('vs_text_is_email', DEX_BCCF_DEFAULT_vs_text_is_email)).'",
	                	"datemmddyyyy": "'.str_replace(array('"', "'"),array('\\"', "\\'"),dex_bccf_get_option('vs_text_datemmddyyyy', DEX_BCCF_DEFAULT_vs_text_datemmddyyyy)).'",
	                	"dateddmmyyyy": "'.str_replace(array('"', "'"),array('\\"', "\\'"),dex_bccf_get_option('vs_text_dateddmmyyyy', DEX_BCCF_DEFAULT_vs_text_dateddmmyyyy)).'",
	                	"number": "'.str_replace(array('"', "'"),array('\\"', "\\'"),dex_bccf_get_option('vs_text_number', DEX_BCCF_DEFAULT_vs_text_number)).'",
	                	"digits": "'.str_replace(array('"', "'"),array('\\"', "\\'"),dex_bccf_get_option('vs_text_digits', DEX_BCCF_DEFAULT_vs_text_digits)).'",
	                	"max": "'.str_replace(array('"', "'"),array('\\"', "\\'"),dex_bccf_get_option('vs_text_max', DEX_BCCF_DEFAULT_vs_text_max)).'",
	                	"min": "'.str_replace(array('"', "'"),array('\\"', "\\'"),dex_bccf_get_option('vs_text_min', DEX_BCCF_DEFAULT_vs_text_min)).'"
	                }}'
));

 $option_calendar_enabled = dex_bccf_get_option('calendar_enabled', DEX_BCCF_DEFAULT_CALENDAR_ENABLED);
?>
<link href="<?php echo plugins_url('css/stylepublic.css', __FILE__); ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo plugins_url('css/cupertino/jquery-ui-1.8.20.custom.css', __FILE__); ?>" type="text/css" rel="stylesheet" />
<form name="dex_bccf_pform" id="dex_bccf_pform" action="<?php get_site_url(); ?>" method="post" onsubmit="return doValidate(this);">
 <input name="dex_bccf_post" type="hidden" id="1" />
 
<?php if ($option_calendar_enabled != 'false') { ?>
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url('TDE_RCalendar/all-css.css', __FILE__); ?>" />
<script>
var pathCalendar = "<?php echo cp_bccf_get_site_url(); ?>";
var pathCalendar_full = pathCalendar + "/wp-content/plugins/<?php echo basename(dirname(__FILE__));?>/TDE_RCalendar";
var minDateConfigTDE = "<?php $value = dex_bccf_get_option('calendar_mindate', DEX_BCCF_DEFAULT_CALENDAR_MINDATE); if ($value != '') echo date("n/j/Y", strtotime($value)); ?>";  //month/day/year like this "10/5/2008" or "now" for current date
var maxDateConfigTDE = "<?php $value = dex_bccf_get_option('calendar_maxdate', DEX_BCCF_DEFAULT_CALENDAR_MAXDATE); if ($value != '') echo date("n/j/Y",strtotime($value)); ?>";  //month/day/year like this "10/5/2008" or "now" for current date
var dex_global_date_format = '<?php echo dex_bccf_get_option('calendar_dateformat', DEX_BCCF_DEFAULT_CALENDAR_DATEFORMAT); ?>';
var dex_global_start_weekday = '<?php echo dex_bccf_get_option('calendar_weekday', DEX_BCCF_DEFAULT_CALENDAR_WEEKDAY); ?>';
</script>
<script type="text/javascript" src="<?php echo plugins_url('TDE_RCalendar/all-scripts.js', __FILE__); ?>"></script>
<?php if (count($myrows) < 2) { ?>
  <div style="display:none">
<?php } else {?>
  <div>
<?php } ?>
<?php
  echo __("Calendar").":";
?>
<br />
<select name="dex_item" id="dex_item" onchange="dex_updateItem()">
<?php
  foreach ($myrows as $item)
  {
      echo '<option value='.$item->id.'>'.$item->uname.'</option>';
  }
?>
</select>
<br /><br />
</div>
<?php
  echo __("Select start and end dates").":";
?>
<?php
  foreach ($myrows as $item)
  {
?>
<div id="calarea_<?php echo $item->id; ?>" style="display:none">
 <input name="selDay_start<?php echo $item->id; ?>" type="hidden" id="selDay_start<?php echo $item->id; ?>" /><input name="selMonth_start<?php echo $item->id; ?>" type="hidden" id="selMonth_start<?php echo $item->id; ?>" /><input name="selYear_start<?php echo $item->id; ?>" type="hidden" id="selYear_start<?php echo $item->id; ?>" /><input name="selDay_end<?php echo $item->id; ?>" type="hidden" id="selDay_end<?php echo $item->id; ?>" /><input name="selMonth_end<?php echo $item->id; ?>" type="hidden" id="selMonth_end<?php echo $item->id; ?>" /><input name="selYear_end<?php echo $item->id; ?>" type="hidden" id="selYear_end<?php echo $item->id; ?>" />
 <div style="z-index:1000;">
 <div id="containerRCalendar<?php echo $item->id; ?>"></div>
 </div>
 <div style="clear:both;"></div>
</div>
<?php
  }
?>

<div id="bccf_display_price"> 
Price:          
</div>
<?php } else { ?>
  <input name="dex_item" id="dex_item" type="hidden" value="<?php echo $myrows[0]->id; ?>" />
<?php } ?>      
      
<div id="selddiv" style="font-weight: bold;margin-top:0px;padding-top:0px;padding-right:3px;padding-left:3px;"></div>
<script type="text/javascript"><?php if ($option_calendar_enabled != 'false') { ?>
 var dex_current_calendar_item;
 function dex_updateItem()
 {
    document.getElementById("calarea_"+dex_current_calendar_item).style.display = "none";
    var i = document.dex_bccf_pform.dex_item.options.selectedIndex;
    var selecteditem = document.dex_bccf_pform.dex_item.options[i].value;
    dex_do_init(selecteditem);
 }
 function dex_do_init(id)
 {
    dex_current_calendar_item = id;
    document.getElementById("calarea_"+dex_current_calendar_item).style.display = "";
    initCalendar(id,'<?php echo dex_bccf_get_option('calendar_language', DEX_BCCF_DEFAULT_CALENDAR_LANGUAGE); ?>',false,<?php echo dex_bccf_get_option('calendar_mode',DEX_BCCF_DEFAULT_CALENDAR_MODE); ?>,'<?php _e('Select Start Date'); ?>','<?php _e('Select End Date'); ?>','<?php _e('Cancel Selection'); ?>','<?php _e('Successfully'); ?>');
    document.getElementById("selddiv").innerHTML = "";
 }
 dex_do_init(<?php echo $myrows[0]->id; ?>);
 var bccf_d1 = "";
 var bccf_d2 = ""
 function updatedate()
 {
    if (document.getElementById("selDay_start"+dex_current_calendar_item ).value != '' && document.getElementById("selDay_end"+dex_current_calendar_item ).value != '')
    {   
        var d1 = document.getElementById("selYear_start"+dex_current_calendar_item ).value+"-"+document.getElementById("selMonth_start"+dex_current_calendar_item ).value+"-"+document.getElementById("selDay_start"+dex_current_calendar_item ).value;
        var d2 = document.getElementById("selYear_end"+dex_current_calendar_item ).value+"-"+document.getElementById("selMonth_end"+dex_current_calendar_item ).value+"-"+document.getElementById("selDay_end"+dex_current_calendar_item ).value;        
        if (bccf_d1 != d1 || bccf_d2 != d2)
        {
            bccf_d1 = d1;
            bccf_d2 = d2;
            $dexQuery = jQuery.noConflict();
            $dexQuery.ajax({
              type: "GET",
              url: "<?php echo cp_bccf_get_site_url(); ?>/?dex_bccf=getcost&dex_item="+dex_current_calendar_item+"&from="+d1+"&to="+d2,
            }).done(function( html ) {
                $dexQuery("#bccf_display_price").append('<b><?php _e("Cost"); ?>:</b> <?php echo dex_bccf_get_option('currency', DEX_BCCF_DEFAULT_CURRENCY); ?> '+html);
            });
        }    
    }
    else         
    {
        bccf_d1 = "";
        bccf_d2 = "";
        document.getElementById("bccf_display_price").innerHTML = '';
    }    
 } 
 setInterval('updatedate()',200);
<?php } ?> 
 function doValidate(form)
 {
    document.dex_bccf_pform.dex_bccf_ref_page.value = document.location;<?php if ($option_calendar_enabled != 'false') { ?>    
    if (document.getElementById("selDay_start"+dex_current_calendar_item).value == '' || document.getElementById("selDay_end"+dex_current_calendar_item).value == '')
    {
        alert('<?php _e('Please select start and end dates'); ?>.');
        return false;
    }
<?php } ?>     
    <?php if (dex_bccf_get_option('dexcv_enable_captcha', TDE_BCCFDEFAULT_dexcv_enable_captcha) != 'false') { ?> if (form.hdcaptcha_dex_bccf_post.value == '')
    {
        alert('<?php echo dex_bccf_get_option('cv_text_enter_valid_captcha', TDE_BCCFDEFAULT_dexcv_text_enter_valid_captcha); ?>');
        return false;
    }
    // check captcha
    $dexQuery = jQuery.noConflict();
    var result = $dexQuery.ajax({
        type: "GET",
        url: "<?php echo cp_bccf_get_site_url(); ?>?hdcaptcha_dex_bccf_post="+form.hdcaptcha_dex_bccf_post.value,
        async: false
    }).responseText;
    if (result == "captchafailed")
    {
        $dexQuery("#dex_bccf_captchaimg").attr('src', $dexQuery("#dex_bccf_captchaimg").attr('src')+'&'+Date());
        alert('<?php echo dex_bccf_get_option('cv_text_enter_valid_captcha', TDE_BCCFDEFAULT_dexcv_text_enter_valid_captcha); ?>');
        return false;
    }
    else <?php } ?>
        return true;
 }
</script>


  <input type="hidden" name="dex_bccf_pform_process" value="1" />
  <input type="hidden" name="dex_bccf_id" value="<?php echo CP_BCCF_CALENDAR_ID; ?>" />
  <input type="hidden" name="dex_bccf_ref_page" value="<?php esc_attr(cp_bccf_get_FULL_site_url); ?>" />

  <input type="hidden" name="form_structure" id="form_structure" size="180" value="<?php echo str_replace("\r","",str_replace("\n","",esc_attr(dex_bccf_cleanJSON(dex_bccf_get_option('form_structure', DEX_BCCF_DEFAULT_form_structure))))); ?>" />


  <div id="fbuilder">
      <div id="formheader"></div>
      <div id="fieldlist"></div>
  </div>


<?php
     $codes = $wpdb->get_results( 'SELECT * FROM '.DEX_BCCF_DISCOUNT_CODES_TABLE_NAME.' WHERE `cal_id`='.CP_BCCF_CALENDAR_ID);
     if (count($codes))
     {
?>
      <div class="fields" id="field-c0"> 
         <label><?php _e('Coupon code (optional)'); ?>:</label>
         <div class="dfield"><input type="text" name="couponcode" value=""></div>
         <div class="clearer"></div>
      </div>
<?php } ?>

<?php
 if ($dex_buffer != '')
 {
    echo '<div class="fields" id="field-c1"><label>';
    _e('Service');
    echo ':</label><div class="dfield"><select name="services">'.$dex_buffer.'</select></div><div class="clearer"></div></div><br />';
 }
?>



<?php if (dex_bccf_get_option('dexcv_enable_captcha', TDE_BCCFDEFAULT_dexcv_enable_captcha) != 'false') { ?>
  Please enter the security code:<br />
  <img src="<?php echo plugins_url('/captcha/captcha.php?width='.dex_bccf_get_option('dexcv_width', TDE_BCCFDEFAULT_dexcv_width).'&height='.dex_bccf_get_option('dexcv_height', TDE_BCCFDEFAULT_dexcv_height).'&letter_count='.dex_bccf_get_option('dexcv_chars', TDE_BCCFDEFAULT_dexcv_chars).'&min_size='.dex_bccf_get_option('dexcv_min_font_size', TDE_BCCFDEFAULT_dexcv_min_font_size).'&max_size='.dex_bccf_get_option('dexcv_max_font_size', TDE_BCCFDEFAULT_dexcv_max_font_size).'&noise='.dex_bccf_get_option('dexcv_noise', TDE_BCCFDEFAULT_dexcv_noise).'&noiselength='.dex_bccf_get_option('dexcv_noise_length', TDE_BCCFDEFAULT_dexcv_noise_length).'&bcolor='.dex_bccf_get_option('dexcv_background', TDE_BCCFDEFAULT_dexcv_background).'&border='.dex_bccf_get_option('dexcv_border', TDE_BCCFDEFAULT_dexcv_border).'&font='.dex_bccf_get_option('dexcv_font', TDE_BCCFDEFAULT_dexcv_font), __FILE__); ?>"  id="dex_bccf_captchaimg" alt="security code" border="0"  />
  <br />
  <div class="fields" id="field-c2"> 
   <label>Security Code (lowercase letters):</label>
   <div class="dfield">  
     <input type="text" size="20" name="hdcaptcha_dex_bccf_post" id="hdcaptcha_dex_bccf_post" value="" />
     <div class="error message" id="hdcaptcha_error" generated="true" style="display:none;position: absolute; left: 0px; top: 25px;"></div>
     <div class="clearer"></div>
   </div>
  </div> 
  <br />
<?php } ?>

<input type="submit" name="subbtn" value="<?php _e("Continue"); ?>">
</form>
