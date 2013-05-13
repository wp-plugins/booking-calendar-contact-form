<?php

if ( !is_admin() )
{
    echo 'Direct access not allowed.';
    exit;
}

if (!defined('CP_BCCF_CALENDAR_ID'))
    define ('CP_BCCF_CALENDAR_ID',intval($_GET["cal"]));

global $wpdb;
$mycalendarrows = $wpdb->get_results( 'SELECT * FROM '.DEX_BCCF_CONFIG_TABLE_NAME .' WHERE `'.TDE_BCCFCONFIG_ID.'`='.CP_BCCF_CALENDAR_ID);


if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset( $_POST['dex_bccf_post_options'] ) )
    echo "<div id='setting-error-settings_updated' class='updated settings-error'> <p><strong>Settings saved.</strong></p></div>";

$current_user = wp_get_current_user();

if (cp_bccf_is_administrator() || $mycalendarrows[0]->conwer == $current_user->ID) {

?>
<div class="wrap">
<h2>Booking Calendar Contact Form - Manage Calendar Availability</h2>

<input type="button" name="backbtn" value="Back to items list..." onclick="document.location='admin.php?page=dex_bccf';">

<form method="post" name="dexconfigofrm" action="">
<input name="dex_bccf_post_options" type="hidden" id="1" />
<input name="dex_item" type="hidden" value="<?php echo intval($_GET["cal"]); ?>" />

<div id="normal-sortables" class="meta-box-sortables">

 <hr />
 <h3>These calendar settings apply only to: <?php echo $mycalendarrows[0]->uname; ?></h3>

 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Calendar Configuration / Administration</span></h3>
  <div class="inside">
     <table class="form-table">
        <tr valign="top">        
        <td colspan="5">
          &nbsp; <strong>Use/display calendar in the booking form?</strong><br />
          <?php $option = dex_bccf_get_option('calendar_enabled', DEX_BCCF_DEFAULT_CALENDAR_ENABLED); ?>
          &nbsp; <select name="calendar_enabled">
           <option value="true"<?php if ($option == 'true') echo ' selected'; ?>>Yes, use it in the booking form</option>
           <option value="false"<?php if ($option == 'false') echo ' selected'; ?>>No, ignore it, isn't needed</option>
          </select>
        </td>
        </tr>  
     </table>

<?php 
    $option_use_calendar = $option;
    $option_overlapped = dex_bccf_get_option('calendar_overlapped', DEX_BCCF_DEFAULT_CALENDAR_OVERLAPPED);     
    if ($option_use_calendar == 'false')  
    {
?>     
   <div style="background-color:#bbffff;width:450px;border: 1px solid black;padding:10px;margin:10px;">
    <strong>Note:</strong> Calendar has been disabled in the field above, so there isn't need to display and edit it. 
     <strong>To re-enable</strong> the calendar select that option in the field above and <strong>save the settings</strong> to render the calendar again.
   </div> 
<?php        
    } else if ($option_overlapped == 'true') {         
?>     
   <div style="background-color:#ffff55;width:450px;border: 1px solid black;padding:10px;margin:10px;">
    <strong>Note:</strong> Overlapped reservations are enabled below, so you cannot use the calendar to block dates and the booking should be checked in the <a href="admin.php?page=dex_bccf&cal=<?php echo CP_BCCF_CALENDAR_ID; ?>&list=1">bookings list area</a>.
   </div> 
<?php } else { ?>  
   <link rel="stylesheet" type="text/css" href="<?php echo plugins_url('TDE_RCalendar/all-css-admin.css', __FILE__); ?>" />
   <script>
   var pathCalendar = "<?php echo cp_bccf_get_site_url(); ?>";
   var pathCalendar_full = pathCalendar + "/wp-content/plugins/<?php echo basename(dirname(__FILE__));?>/TDE_RCalendar";
   var minDateConfigTDE = "";  //month/day/year like this "10/5/2008" or "now" for current date
   var maxDateConfigTDE = "";  //month/day/year like this "10/5/2008" or "now" for current date
   var dex_global_date_format = '<?php echo dex_bccf_get_option('calendar_dateformat', DEX_BCCF_DEFAULT_CALENDAR_DATEFORMAT); ?>';
   var dex_global_start_weekday = '<?php echo dex_bccf_get_option('calendar_weekday', DEX_BCCF_DEFAULT_CALENDAR_WEEKDAY); ?>';
   </script>
   <script type="text/javascript" src="<?php echo plugins_url('TDE_RCalendar/all-scripts.js', __FILE__); ?>"></script>

   <div style="padding:10px"><div id="caladmin">
     <input name="selDay_start<?php echo CP_BCCF_CALENDAR_ID; ?>" type="hidden" id="selDay_start<?php echo CP_BCCF_CALENDAR_ID; ?>" />
     <input name="selMonth_start<?php echo CP_BCCF_CALENDAR_ID; ?>" type="hidden" id="selMonth_start<?php echo CP_BCCF_CALENDAR_ID; ?>" />
     <input name="selYear_start<?php echo CP_BCCF_CALENDAR_ID; ?>" type="hidden" id="selYear_start<?php echo CP_BCCF_CALENDAR_ID; ?>" />
     <input name="selDay_end<?php echo CP_BCCF_CALENDAR_ID; ?>" type="hidden" id="selDay_end<?php echo CP_BCCF_CALENDAR_ID; ?>" />
     <input name="selMonth_end<?php echo CP_BCCF_CALENDAR_ID; ?>" type="hidden" id="selMonth_end<?php echo CP_BCCF_CALENDAR_ID; ?>" />
     <input name="selYear_end<?php echo CP_BCCF_CALENDAR_ID; ?>" type="hidden" id="selYear_end<?php echo CP_BCCF_CALENDAR_ID; ?>" />
     <div style="z-index:1000;">
       <div id="containerRCalendar<?php echo CP_BCCF_CALENDAR_ID; ?>"></div>
     </div>
   </div></div>

   <script type="text/javascript">initCalendar('<?php echo CP_BCCF_CALENDAR_ID; ?>','<?php echo TDE_BCCFDEFAULT_CALENDAR_LANGUAGE; ?>',true,<?php echo dex_bccf_get_option('calendar_mode',DEX_BCCF_DEFAULT_CALENDAR_MODE); ?>,'<?php _e('Select Start Date'); ?>','<?php _e('Select End Date'); ?>','<?php _e('Cancel Selection'); ?>','<?php _e('Successfully'); ?>');</script>
   
   <div style="clear:both;height:20px" ></div>
<?php } ?>

<?php if ($option_use_calendar != 'false') { ?>
   <div id="demo" class="yui-navset" style="padding-left:10px;width:690px;"></div>
   <div style="clear:both;height:0px" ></div>

   <table class="form-table" style="width:650px">       
       <tr>        
        <td valign="top" nowrap>
             <strong>Calendar language</strong><br />
             <?php $value = dex_bccf_get_option('calendar_language',DEX_BCCF_DEFAULT_CALENDAR_LANGUAGE); ?>
             <select name="calendar_language">
               <option value="DE" <?php if ($value == 'DE') echo ' selected="selected"'; ?>>German</option>
               <option value="DU" <?php if ($value == 'DU') echo ' selected="selected"'; ?>>Dutch</option>
               <option value="EN" <?php if ($value == 'EN') echo ' selected="selected"'; ?>>English</option>
               <option value="FR" <?php if ($value == 'FR') echo ' selected="selected"'; ?>>French</option>
               <option value="IT" <?php if ($value == 'IT') echo ' selected="selected"'; ?>>Italian</option>
               <option value="JP" <?php if ($value == 'JP') echo ' selected="selected"'; ?>>Japanese</option>
               <option value="PT" <?php if ($value == 'PT') echo ' selected="selected"'; ?>>Portuguese</option>
               <option value="SP" <?php if ($value == 'SP') echo ' selected="selected"'; ?>>Spanish</option>
            </select>
        </td>      
        <td valign="top" nowrap>
             <strong>Start weekday</strong><br />
             <?php $value = dex_bccf_get_option('calendar_weekday',DEX_BCCF_DEFAULT_CALENDAR_WEEKDAY); ?>
             <select name="calendar_weekday">
               <option value="0" <?php if ($value == '0') echo ' selected="selected"'; ?>>Sunday</option>
               <option value="1" <?php if ($value == '1') echo ' selected="selected"'; ?>>Monday</option>
               <option value="2" <?php if ($value == '2') echo ' selected="selected"'; ?>>Tuesday</option>
               <option value="3" <?php if ($value == '3') echo ' selected="selected"'; ?>>Wednesday</option>
               <option value="4" <?php if ($value == '4') echo ' selected="selected"'; ?>>Thursday</option>
               <option value="5" <?php if ($value == '5') echo ' selected="selected"'; ?>>Friday</option>
               <option value="6" <?php if ($value == '6') echo ' selected="selected"'; ?>>Saturday</option>
             </select>
        </td>          
        <td valign="top">
             <strong>Date format</strong><br />
             <?php $value = dex_bccf_get_option('calendar_dateformat',DEX_BCCF_DEFAULT_CALENDAR_DATEFORMAT); ?>
             <select name="calendar_dateformat">
               <option value="0" <?php if ($value == '0') echo ' selected="selected"'; ?>>mm/dd/yyyy</option>
               <option value="1" <?php if ($value == '1') echo ' selected="selected"'; ?>>dd/mm/yyyy</option>
             </select>
        </td>
        <td valign="top" nowrap>
          <strong>Accept overlapped reservations?</strong><br />
          <?php $option = dex_bccf_get_option('calendar_overlapped', DEX_BCCF_DEFAULT_CALENDAR_OVERLAPPED); ?>
          <select name="calendar_overlapped">
           <option value="true"<?php if ($option == 'true') echo ' selected'; ?>>Yes</option>
           <option value="false"<?php if ($option == 'false') echo ' selected'; ?>>No</option>
          </select>
        </td>
       </tr>
       <tr>       
        <td valign="top" colspan="1">
             <strong>Reservation Mode</strong><br />
             <?php $value = dex_bccf_get_option('calendar_mode',DEX_BCCF_DEFAULT_CALENDAR_MODE); ?>
             <select name="calendar_mode">
               <option value="true" <?php if ($value == 'true') echo ' selected="selected"'; ?>>Partial Days</option>
               <option value="false" <?php if ($value == 'false') echo ' selected="selected"'; ?>>Complete Days</option>
             </select>
             <br />
        </td>     
        <td colspan="3" valign="top">
             <em style="font-size:11px;">Complete day means that the first and the last days booked are charged as full days;<br />Partial Day means that they are charged as half-days only.</em>
        </td>        
       </tr>
       <tr>
        <td width="1%" nowrap valign="top" colspan="2">
         <strong>Minimum  available date:</strong><br />
         <input type="text" name="calendar_mindate" size="40" value="<?php echo esc_attr(dex_bccf_get_option('calendar_mindate',DEX_BCCF_DEFAULT_CALENDAR_MINDATE)); ?>" /><br />
         <em style="font-size:11px;">Examples: 2012-10-25, today, today + 3 days</em>
        </td>        
        <td valign="top" colspan="2">
         <strong>Maximum  available date:</strong><br />
         <input type="text" name="calendar_maxdate" size="40" value="<?php echo esc_attr(dex_bccf_get_option('calendar_maxdate',DEX_BCCF_DEFAULT_CALENDAR_MAXDATE)); ?>" /><br />
         <em style="font-size:11px;">Examples: 2012-10-25, today, today + 3 days</em>
        </td>
        </tr>

   </table>
<?php } else { ?>
    <input type="hidden" name="calendar_language" value="<?php echo esc_attr(dex_bccf_get_option('calendar_language',DEX_BCCF_DEFAULT_CALENDAR_LANGUAGE)); ?>" />                 
    <input type="hidden" name="calendar_weekday" value="<?php echo esc_attr(dex_bccf_get_option('calendar_weekday',DEX_BCCF_DEFAULT_CALENDAR_WEEKDAY)); ?>" />                 
    <input type="hidden" name="calendar_dateformat" value="<?php echo esc_attr(dex_bccf_get_option('calendar_dateformat',DEX_BCCF_DEFAULT_CALENDAR_DATEFORMAT)); ?>" /> 
    <input type="hidden" name="calendar_overlapped" value="<?php echo esc_attr(dex_bccf_get_option('calendar_overlapped', DEX_BCCF_DEFAULT_CALENDAR_OVERLAPPED)); ?>" />
    <input type="hidden" name="calendar_mode" value="<?php echo esc_attr(dex_bccf_get_option('calendar_mode',DEX_BCCF_DEFAULT_CALENDAR_MODE)); ?>" />
    <input type="hidden" name="calendar_mindate" value="<?php echo esc_attr(dex_bccf_get_option('calendar_mindate',DEX_BCCF_DEFAULT_CALENDAR_MINDATE)); ?>" />
    <input type="hidden" name="calendar_maxdate" value="<?php echo esc_attr(dex_bccf_get_option('calendar_maxdate',DEX_BCCF_DEFAULT_CALENDAR_MAXDATE)); ?>" />
<?php } ?>

  </div>
 </div>


 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Form Builder</span></h3>
  <div class="inside">
     <em>* Note: The Form Builder is read-only in this version.</em>
     <input type="hidden" name="form_structure" id="form_structure" size="180" value="<?php echo str_replace("\r","",str_replace("\n","",esc_attr(dex_bccf_cleanJSON(dex_bccf_get_option('form_structure', DEX_BCCF_DEFAULT_form_structure))))); ?>" />

     <link href="<?php echo plugins_url('css/style.css', __FILE__); ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo plugins_url('css/cupertino/jquery-ui-1.8.20.custom.css', __FILE__); ?>" type="text/css" rel="stylesheet" />

     <script>
         $contactFormPPQuery = jQuery.noConflict();
         $contactFormPPQuery(document).ready(function() {
            var f = $contactFormPPQuery("#fbuilder").fbuilderbccfree();
            f.fBuild.loadData("form_structure");

            $contactFormPPQuery("#saveForm").click(function() {
                f.fBuild.saveData("form_structure");
            });

            $contactFormPPQuery(".itemForm").click(function() {
     	       f.fBuild.addItem($contactFormPPQuery(this).attr("id"));
     	   });

           $contactFormPPQuery( ".itemForm" ).draggable({revert1: "invalid",helper: "clone",cursor: "move"});
     	   $contactFormPPQuery( "#fbuilder" ).droppable({
     	       accept: ".button",
     	       drop: function( event, ui ) {
     	           f.fBuild.addItem(ui.draggable.attr("id"));
     	       }
     	   });

         });

     </script>

     <div style="background:#fafafa;width:780px;" class="form-builder">

         <div class="column width50">
             <div id="tabs">
     			<ul>
     				<li><a href="#tabs-1">Add a Field</a></li>
     				<li><a href="#tabs-2">Field Settings</a></li>
     				<li><a href="#tabs-3">Form Settings</a></li>
     			</ul>
     			<div id="tabs-1">

     			</div>
     			<div id="tabs-2"></div>
     			<div id="tabs-3"></div>
     		</div>
         </div>
         <div class="columnr width50 padding10" id="fbuilder">
             <div id="formheader"></div>
             <div id="fieldlist"></div>
             <div class="button" id="saveForm">Save Form</div>
         </div>
         <div class="clearer"></div>

     </div>

  </div>
 </div>

  <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Validation Texts</span></h3>
  <div class="inside">
     <?php $option = dex_bccf_get_option('vs_use_validation', DEX_BCCF_DEFAULT_vs_use_validation); ?>
     <input type="hidden" name="vs_use_validation" value="<?php echo $option; ?>" />
     <table class="form-table">    
        <tr valign="top">        
         <td width="1%" nowrap><strong>"is required" text:</strong><br /><input type="text" name="vs_text_is_required" size="40" value="<?php echo esc_attr(dex_bccf_get_option('vs_text_is_required', DEX_BCCF_DEFAULT_vs_text_is_required)); ?>" /></td>
         <td><strong>"is email" text:</strong><br /><input type="text" name="vs_text_is_email" size="70" value="<?php echo esc_attr(dex_bccf_get_option('vs_text_is_email', DEX_BCCF_DEFAULT_vs_text_is_email)); ?>" /></td>
        </tr>
        <tr valign="top">        
         <td><strong>"is valid captcha" text:</strong><br /><input type="text" name="cv_text_enter_valid_captcha" size="70" value="<?php echo esc_attr(dex_bccf_get_option('cv_text_enter_valid_captcha', DEX_BCCF_DEFAULT_dexcv_text_enter_valid_captcha)); ?>" /></td>
         <td><strong>"is valid date (mm/dd/yyyy)" text:</strong><br /><input type="text" name="vs_text_datemmddyyyy" size="70" value="<?php echo esc_attr(dex_bccf_get_option('vs_text_datemmddyyyy', DEX_BCCF_DEFAULT_vs_text_datemmddyyyy)); ?>" /></td>
        </tr>
        <tr valign="top">
         <td><strong>"is valid date (dd/mm/yyyy)" text:</strong><br /><input type="text" name="vs_text_dateddmmyyyy" size="70" value="<?php echo esc_attr(dex_bccf_get_option('vs_text_dateddmmyyyy', DEX_BCCF_DEFAULT_vs_text_dateddmmyyyy)); ?>" /></td>
         <td><strong>"is number" text:</strong><br /><input type="text" name="vs_text_number" size="70" value="<?php echo esc_attr(dex_bccf_get_option('vs_text_number', DEX_BCCF_DEFAULT_vs_text_number)); ?>" /></td>
        </tr>
        <tr valign="top">        
         <td><strong>"only digits" text:</strong><br /><input type="text" name="vs_text_digits" size="70" value="<?php echo esc_attr(dex_bccf_get_option('vs_text_digits', DEX_BCCF_DEFAULT_vs_text_digits)); ?>" /></td>
         <td><strong>"under maximum" text:</strong><br /><input type="text" name="vs_text_max" size="70" value="<?php echo esc_attr(dex_bccf_get_option('vs_text_max', DEX_BCCF_DEFAULT_vs_text_max)); ?>" /></td>
        </tr>
        <tr valign="top">
         <td><strong>"over minimum" text:</strong><br /><input type="text" name="vs_text_min" size="70" value="<?php echo esc_attr(dex_bccf_get_option('vs_text_min', DEX_BCCF_DEFAULT_vs_text_min)); ?>" /></td>
        </tr>

     </table>
  </div>
 </div>


 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Paypal Payment Configuration</span></h3>
  <div class="inside">

    <table class="form-table">
        <tr valign="top">
        <th scope="row">Enable Paypal Payments?</th>
        <td><input type="checkbox" readonly disabled  name="enable_paypal" size="40" value="1" checked /> <br />
         <em>* PayPal is required in this version. For other versions without PayPal payments please check the <a href="http://wordpress.dwbooster.com/calendars/booking-calendar-contact-form">plugin's page</a>.</em>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">Paypal email</th>
        <td><input type="text" name="paypal_email" size="40" value="<?php echo esc_attr(dex_bccf_get_option('paypal_email',DEX_BCCF_DEFAULT_PAYPAL_EMAIL)); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Default request cost (per day)</th>
        <td><input type="text" name="request_cost" value="<?php echo esc_attr(dex_bccf_get_option('request_cost',DEX_BCCF_DEFAULT_COST)); ?>" /></td>
        </tr>


        <tr valign="top">
        <th scope="row">Season cost (per day)</th>
        <td>
           <div id="dex_noseasons_availmsg">Loading...</div>

           <br />
           <strong>Add new season:</strong>
           <br />
           Cost: <input type="text" name="dex_dc_price" id="dex_dc_price" value="" /> &nbsp; &nbsp; &nbsp;
           From: <input type="text"  size="10" name="dex_dc_season_dfrom" id="dex_dc_season_dfrom" value="" />&nbsp; &nbsp; &nbsp;
           To: <input type="text"  size="10" name="dex_dc_season_dto" id="dex_dc_season_dto" value="" />&nbsp; &nbsp; &nbsp;
           <input type="button" name="dex_dc_subcseasons" id="dex_dc_subcseasons" value="Add" />
           <br />
           <em>Note: Season prices override the "Default request cost" specified above.</em>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">Paypal product name</th>
        <td><input type="text" name="paypal_product_name" size="50" value="<?php echo esc_attr(dex_bccf_get_option('paypal_product_name',DEX_BCCF_DEFAULT_PRODUCT_NAME)); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Currency</th>
        <td><input type="text" name="currency" value="<?php echo esc_attr(dex_bccf_get_option('currency',DEX_BCCF_DEFAULT_CURRENCY)); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">URL to return after successful  payment</th>
        <td><input type="text" name="url_ok" size="70" value="<?php echo esc_attr(dex_bccf_get_option('url_ok',DEX_BCCF_DEFAULT_OK_URL)); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">URL to return after an incomplete or cancelled payment</th>
        <td><input type="text" name="url_cancel" size="70" value="<?php echo esc_attr(dex_bccf_get_option('url_cancel',DEX_BCCF_DEFAULT_CANCEL_URL)); ?>" /></td>
        </tr>


        <tr valign="top">
        <th scope="row">Paypal language</th>
        <td><input type="text" name="paypal_language" value="<?php echo esc_attr(dex_bccf_get_option('paypal_language',DEX_BCCF_DEFAULT_PAYPAL_LANGUAGE)); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Discount Codes</th>
        <td>
           <em>This feature is available in the <a href="http://wordpress.dwbooster.com/calendars/booking-calendar-contact-form">pro version</a>.</em>
        </td>
        </tr>

     </table>

  </div>
 </div>

 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Optional Services/Items Field</span></h3>
  <div class="inside">
     <table class="form-table">
        <tr valign="top">        
        <td colspan="5">
          <strong>If enabled, use the services/items field as:</strong><br />
          <?php $option = dex_bccf_get_option('cp_cal_checkboxes_type', DEX_BCCF_DEFAULT_CP_CAL_CHECKBOXES_TYPE); ?>
          <select name="cp_cal_checkboxes_type">
           <option value="0"<?php if ($option == '0') echo ' selected'; ?>>Additional items field. The item price will be added ONCE to the above prices.</option>
           <option value="4"<?php if ($option == '4') echo ' selected'; ?>>Additional items field per day. The item price will be added for each day to the above prices.</option>
           <option value="1"<?php if ($option == '1') echo ' selected'; ?>>Price per day field. This price will overwrite the above prices.</option>
           <option value="2"<?php if ($option == '2') echo ' selected'; ?>>Fixed price. This price will overwrite the above prices.</option>
          </select>
        </td>
        </tr>  
     </table>  
     <table class="form-table">     
        <tr valign="top">
        <th scope="row">Options (drop-down select, one item per line with format: <span style="color:#ff0000">price | title</span>)<br />
        <br />
        <em>Note: This is an optional field that appears only if some option is specified.</em>
        <br />
        <br />
        <ul>Sample Format:</ul>
        <?php echo str_replace("\n", "<br />", DEX_BCCF_DEFAULT_EXPLAIN_CP_CAL_CHECKBOXES); ?>
        </th>
        <td><textarea cols="50" wrap="on" rows="9" name="cp_cal_checkboxesnok" readonly disabled style="color:#999999;">This feature isn't available in this version. Please check the plugin's page for other versions.</textarea>
           <input type="hidden" name="cp_cal_checkboxes" value="<?php echo esc_attr(dex_bccf_get_option('cp_cal_checkboxes', DEX_BCCF_DEFAULT_CP_CAL_CHECKBOXES)); ?>">
        </td>
        </tr>
     </table>
  </div>
 </div>

 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Notification Settings to Administrator(s)</span></h3>
  <div class="inside">
     <table class="form-table">
        <tr valign="top">
        <th scope="row">Notification "from" email</th>
        <td><input type="text" name="notification_from_email" size="40" value="<?php echo esc_attr(dex_bccf_get_option('notification_from_email', DEX_BCCF_DEFAULT_PAYPAL_EMAIL)); ?>" /></td>
        </tr>
        <tr valign="top">
        <th scope="row">Send notification to email</th>
        <td><input type="text" name="notification_destination_email" size="40" value="<?php echo esc_attr(dex_bccf_get_option('notification_destination_email', DEX_BCCF_DEFAULT_PAYPAL_EMAIL)); ?>" /></td>
        </tr>
        <tr valign="top">
        <th scope="row">Email subject notification to admin</th>
        <td><input type="text" name="email_subject_notification_to_admin" size="70" value="<?php echo esc_attr(dex_bccf_get_option('email_subject_notification_to_admin', DEX_BCCF_DEFAULT_SUBJECT_NOTIFICATION_EMAIL)); ?>" /></td>
        </tr>
        <tr valign="top">
        <th scope="row">Email notification to admin</th>
        <td><textarea cols="70" rows="5" name="email_notification_to_admin"><?php echo dex_bccf_get_option('email_notification_to_admin', DEX_BCCF_DEFAULT_NOTIFICATION_EMAIL); ?></textarea></td>
        </tr>
     </table>
  </div>
 </div>


 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Email Copy to User</span></h3>
  <div class="inside">
     <table class="form-table">
        <tr valign="top">
        <th scope="row">Email field on the form</th>
        <td><select id="cu_user_email_field" name="cu_user_email_field" def="<?php echo esc_attr(dex_bccf_get_option('cu_user_email_field', DEX_BCCF_DEFAULT_cu_user_email_field)); ?>"></select></td>
        </tr>
        <tr valign="top">
        <th scope="row">Email subject confirmation to user</th>
        <td><input type="text" name="email_subject_confirmation_to_user" size="70" value="<?php echo esc_attr(dex_bccf_get_option('email_subject_confirmation_to_user', DEX_BCCF_DEFAULT_SUBJECT_CONFIRMATION_EMAIL)); ?>" /></td>
        </tr>
        <tr valign="top">
        <th scope="row">Email confirmation to user</th>
        <td><textarea cols="70" rows="5" name="email_confirmation_to_user"><?php echo dex_bccf_get_option('email_confirmation_to_user', DEX_BCCF_DEFAULT_CONFIRMATION_EMAIL); ?></textarea></td>
        </tr>
     </table>
  </div>
 </div>


 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Captcha Verification</span></h3>
  <div class="inside">
     <table class="form-table">
        <tr valign="top">
        <th scope="row">Use Captcha Verification?</th>
        <td colspan="5">
          <?php $option = dex_bccf_get_option('dexcv_enable_captcha', TDE_BCCFDEFAULT_dexcv_enable_captcha); ?>
          <select name="dexcv_enable_captcha">
           <option value="true"<?php if ($option == 'true') echo ' selected'; ?>>Yes</option>
           <option value="false"<?php if ($option == 'false') echo ' selected'; ?>>No</option>
          </select>
        </td>
        </tr>

        <tr valign="top">
         <th scope="row">Width:</th>
         <td><input type="text" name="dexcv_width" size="10" value="<?php echo esc_attr(dex_bccf_get_option('dexcv_width', TDE_BCCFDEFAULT_dexcv_width)); ?>"  onblur="generateCaptcha();"  /></td>
         <th scope="row">Height:</th>
         <td><input type="text" name="dexcv_height" size="10" value="<?php echo esc_attr(dex_bccf_get_option('dexcv_height', TDE_BCCFDEFAULT_dexcv_height)); ?>" onblur="generateCaptcha();"  /></td>
         <th scope="row">Chars:</th>
         <td><input type="text" name="dexcv_chars" size="10" value="<?php echo esc_attr(dex_bccf_get_option('dexcv_chars', TDE_BCCFDEFAULT_dexcv_chars)); ?>" onblur="generateCaptcha();"  /></td>
        </tr>

        <tr valign="top">
         <th scope="row">Min font size:</th>
         <td><input type="text" name="dexcv_min_font_size" size="10" value="<?php echo esc_attr(dex_bccf_get_option('dexcv_min_font_size', TDE_BCCFDEFAULT_dexcv_min_font_size)); ?>" onblur="generateCaptcha();"  /></td>
         <th scope="row">Max font size:</th>
         <td><input type="text" name="dexcv_max_font_size" size="10" value="<?php echo esc_attr(dex_bccf_get_option('dexcv_max_font_size', TDE_BCCFDEFAULT_dexcv_max_font_size)); ?>" onblur="generateCaptcha();"  /></td>
         <td colspan="2" rowspan="">
           Preview:<br />
             <br />
            <img src="<?php echo plugins_url('/captcha/captcha.php', __FILE__); ?>"  id="captchaimg" alt="security code" border="0"  />
         </td>
        </tr>


        <tr valign="top">
         <th scope="row">Noise:</th>
         <td><input type="text" name="dexcv_noise" size="10" value="<?php echo esc_attr(dex_bccf_get_option('dexcv_noise', TDE_BCCFDEFAULT_dexcv_noise)); ?>" onblur="generateCaptcha();" /></td>
         <th scope="row">Noise Length:</th>
         <td><input type="text" name="dexcv_noise_length" size="10" value="<?php echo esc_attr(dex_bccf_get_option('dexcv_noise_length', TDE_BCCFDEFAULT_dexcv_noise_length)); ?>" onblur="generateCaptcha();" /></td>
        </tr>


        <tr valign="top">
         <th scope="row">Background:</th>
         <td><input type="text" name="dexcv_background" size="10" value="<?php echo esc_attr(dex_bccf_get_option('dexcv_background', TDE_BCCFDEFAULT_dexcv_background)); ?>" onblur="generateCaptcha();" /></td>
         <th scope="row">Border:</th>
         <td><input type="text" name="dexcv_border" size="10" value="<?php echo esc_attr(dex_bccf_get_option('dexcv_border', TDE_BCCFDEFAULT_dexcv_border)); ?>" onblur="generateCaptcha();" /></td>
        </tr>

        <tr valign="top">
         <th scope="row">Font:</th>
         <td>
            <select name="dexcv_font" onchange="generateCaptcha();" >
              <option value="font-1.ttf"<?php if ("font-1.ttf" == dex_bccf_get_option('dexcv_font', TDE_BCCFDEFAULT_dexcv_font)) echo " selected"; ?>>Font 1</option>
              <option value="font-2.ttf"<?php if ("font-2.ttf" == dex_bccf_get_option('dexcv_font', TDE_BCCFDEFAULT_dexcv_font)) echo " selected"; ?>>Font 2</option>
              <option value="font-3.ttf"<?php if ("font-3.ttf" == dex_bccf_get_option('dexcv_font', TDE_BCCFDEFAULT_dexcv_font)) echo " selected"; ?>>Font 3</option>
              <option value="font-4.ttf"<?php if ("font-4.ttf" == dex_bccf_get_option('dexcv_font', TDE_BCCFDEFAULT_dexcv_font)) echo " selected"; ?>>Font 4</option>
            </select>
         </td>
        </tr>


     </table>
  </div>
 </div>

  <div id="metabox_basic_settings" class="postbox" >
    <h3 class='hndle' style="padding:5px;"><span>Note</span></h3>
    <div class="inside">
     To insert this form in a post/page, use the dedicated icon
     <?php print '<img hspace="5" src="'.plugins_url('/images/dex_apps.gif', __FILE__).'" alt="'.__('Insert Booking Calendar').'" />';     ?>
     which has been added to your Upload/Insert Menu, just below the title of your Post/Page.
     <br /><br />
    </div>
  </div>

</div>


<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="Save Changes"  /></p>

[<a href="http://wordpress.dwbooster.com/contact-us" target="_blank">Request Custom Modifications</a>] | [<a href="http://wordpress.dwbooster.com/calendars/booking-calendar-contact-form" target="_blank">Help</a>]
</form>
</div>
<script type="text/javascript">
 function generateCaptcha()
 {
    var d=new Date();
    var f = document.dexconfigofrm;
    var qs = "?width="+f.dexcv_width.value;
    qs += "&height="+f.dexcv_height.value;
    qs += "&letter_count="+f.dexcv_chars.value;
    qs += "&min_size="+f.dexcv_min_font_size.value;
    qs += "&max_size="+f.dexcv_max_font_size.value;
    qs += "&noise="+f.dexcv_noise.value;
    qs += "&noiselength="+f.dexcv_noise_length.value;
    qs += "&bcolor="+f.dexcv_background.value;
    qs += "&border="+f.dexcv_border.value;
    qs += "&font="+f.dexcv_font.options[f.dexcv_font.selectedIndex].value;
    qs += "&rand="+d;
    document.getElementById("captchaimg").src= "<?php echo plugins_url('/captcha/captcha.php', __FILE__); ?>"+qs;
 }
 generateCaptcha();
 var $j = jQuery.noConflict(); 
  $j(function() {
 	$j("#dex_dc_season_dfrom").datepicker({
                    dateFormat: 'yy-mm-dd'
                 });
    $j("#dex_dc_season_dto").datepicker({
                    dateFormat: 'yy-mm-dd'
                 });
  });
  $j('#dex_noseasons_availmsg').load('<?php echo cp_bccf_get_site_url(); ?>/?dex_bccf=loadseasonprices&dex_item=<?php echo CP_BCCF_CALENDAR_ID; ?>');
  $j('#dex_dc_subcseasons').click (function() {
                               var code = $j('#dex_dc_price').val();
                               var dfrom = $j('#dex_dc_season_dfrom').val();
                               var dto = $j('#dex_dc_season_dto').val();
                               if (parseInt(code)+"" != code) { alert('Please enter a price (valid number).'); return; }
                               if (dfrom == '') { alert('Please enter an expiration date for the code'); return; }
                               if (dto == '') { alert('Please enter an expiration date for the code'); return; }
                               var params = '&add=1&dto='+encodeURI(dto)+'&dfrom='+encodeURI(dfrom)+'&price='+encodeURI(code);
                               $j('#dex_noseasons_availmsg').load('<?php echo cp_bccf_get_site_url(); ?>/?dex_bccf=loadseasonprices&dex_item=<?php echo CP_BCCF_CALENDAR_ID; ?>'+params);
                               $j('#dex_dc_price').val();
                             });
  function dex_delete_season_price(id)
  {
     $j('#dex_noseasons_availmsg').load('<?php echo cp_bccf_get_site_url(); ?>/?dex_bccf=loadseasonprices&dex_item=<?php echo CP_BCCF_CALENDAR_ID; ?>&delete=1&code='+id);
  }
</script>


<?php } else { ?>
  <br />
  The current user logged in doesn't have enough permissions to edit this calendar. This user can edit only his/her own calendars. Please log in as administrator to get access to all calendars.
<?php } ?>