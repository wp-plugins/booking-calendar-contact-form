<?php
/*
Plugin Name: Booking Calendar Contact Form
Plugin URI: http://wordpress.dwbooster.com/calendars/booking-calendar-contact-form
Description: Create a booking form with a reservation calendar or a classic contact form, connected to a PayPal payment button.
Version: 1.0.4
Author: CodePeople.net
Author URI: http://codepeople.net
License: GPL
*/


/* initialization / install / uninstall functions */

define('DEX_BCCF_DEFAULT_form_structure', '[[{"name":"email","index":0,"title":"Email","ftype":"femail","userhelp":"","csslayout":"","required":true,"predefined":"","size":"medium"},{"name":"subject","index":1,"title":"Subject","required":true,"ftype":"ftext","userhelp":"","csslayout":"","predefined":"","size":"medium"},{"name":"message","index":2,"size":"large","required":true,"title":"Message","ftype":"ftextarea","userhelp":"","csslayout":"","predefined":""}],[{"title":"","description":"","formlayout":"top_aligned"}]]');

define('DEX_BCCF_DEFAULT_DEFER_SCRIPTS_LOADING', (get_option('CP_BCCF_LOAD_SCRIPTS',"1") == "1"?true:false));

define('DEX_BCCF_DEFAULT_SERVICES_FIELDS', 3);

define('DEX_BCCF_DEFAULT_COLOR_STARTRES', '#CAFFCA');
define('DEX_BCCF_DEFAULT_COLOR_HOLIDAY', '#FF8080');

define('DEX_BCCF_DEFAULT_CALENDAR_LANGUAGE', '');
define('DEX_BCCF_DEFAULT_CALENDAR_DATEFORMAT', 'false');
define('DEX_BCCF_DEFAULT_CALENDAR_WEEKDAY', '0');
define('DEX_BCCF_DEFAULT_CALENDAR_MINDATE', 'today');
define('DEX_BCCF_DEFAULT_CALENDAR_MAXDATE', '');
define('DEX_BCCF_DEFAULT_CALENDAR_PAGES', 2);
define('DEX_BCCF_DEFAULT_CALENDAR_OVERLAPPED', 'false');
define('DEX_BCCF_DEFAULT_CALENDAR_ENABLED', 'true');

define('DEX_BCCF_DEFAULT_cu_user_email_field', 'email');
define('TDE_BCCFCALENDAR_DEFAULT_COLOR', '6FF');

define('DEX_BCCF_DEFAULT_ENABLE_PAYPAL', 1);
define('DEX_BCCF_DEFAULT_PAYPAL_EMAIL','put_your@email_here.com');
define('DEX_BCCF_DEFAULT_PRODUCT_NAME','Reservation');
define('DEX_BCCF_DEFAULT_COST','25');
define('DEX_BCCF_DEFAULT_OK_URL',get_site_url());
define('DEX_BCCF_DEFAULT_CANCEL_URL',get_site_url());
define('DEX_BCCF_DEFAULT_CURRENCY','USD');
define('DEX_BCCF_DEFAULT_PAYPAL_LANGUAGE','EN');

define('DEX_BCCF_DEFAULT_PAYPAL_OPTION_YES', 'Pay with PayPal.');
define('DEX_BCCF_DEFAULT_PAYPAL_OPTION_NO', 'Pay later.');

define('DEX_BCCF_DEFAULT_vs_text_is_required', 'This field is required.');
define('DEX_BCCF_DEFAULT_vs_text_is_email', 'Please enter a valid email address.');

define('DEX_BCCF_DEFAULT_vs_text_datemmddyyyy', 'Please enter a valid date with this format(mm/dd/yyyy)');
define('DEX_BCCF_DEFAULT_vs_text_dateddmmyyyy', 'Please enter a valid date with this format(dd/mm/yyyy)');
define('DEX_BCCF_DEFAULT_vs_text_number', 'Please enter a valid number.');
define('DEX_BCCF_DEFAULT_vs_text_digits', 'Please enter only digits.');
define('DEX_BCCF_DEFAULT_vs_text_max', 'Please enter a value less than or equal to {0}.');
define('DEX_BCCF_DEFAULT_vs_text_min', 'Please enter a value greater than or equal to {0}.');


define('DEX_BCCF_DEFAULT_SUBJECT_CONFIRMATION_EMAIL', 'Thank you for your request...');
define('DEX_BCCF_DEFAULT_CONFIRMATION_EMAIL', "We have received your request with the following information:\n\n%INFORMATION%\n\nThank you.\n\nBest regards.");
define('DEX_BCCF_DEFAULT_SUBJECT_NOTIFICATION_EMAIL','New reservation requested...');
define('DEX_BCCF_DEFAULT_NOTIFICATION_EMAIL', "New reservation made with the following information:\n\n%INFORMATION%\n\nBest regards.");

define('DEX_BCCF_DEFAULT_CP_CAL_CHECKBOXES',"");
define('DEX_BCCF_DEFAULT_CP_CAL_CHECKBOXES_TYPE',"0");
define('DEX_BCCF_DEFAULT_EXPLAIN_CP_CAL_CHECKBOXES',"1.00 | Service 1 for us$1.00\n5.00 | Service 2 for us$5.00\n10.00 | Service 3 for us$10.00");


// tables

define('DEX_BCCF_TABLE_NAME_NO_PREFIX', "bccf_dex_bccf_submissions");
define('DEX_BCCF_TABLE_NAME', @$wpdb->prefix . DEX_BCCF_TABLE_NAME_NO_PREFIX);

define('DEX_BCCF_CALENDARS_TABLE_NAME_NO_PREFIX', "bccf_reservation_calendars_data");
define('DEX_BCCF_CALENDARS_TABLE_NAME', @$wpdb->prefix ."bccf_reservation_calendars_data");

define('DEX_BCCF_CONFIG_TABLE_NAME_NO_PREFIX', "bccf_reservation_calendars");
define('DEX_BCCF_CONFIG_TABLE_NAME', @$wpdb->prefix ."bccf_reservation_calendars");

define('DEX_BCCF_DISCOUNT_CODES_TABLE_NAME_NO_PREFIX', "bccf_dex_discount_codes");
define('DEX_BCCF_SEASON_PRICES_TABLE_NAME_NO_PREFIX', "bccf_dex_season_prices");
define('DEX_BCCF_DISCOUNT_CODES_TABLE_NAME', @$wpdb->prefix ."bccf_dex_discount_codes");

// calendar constants

define("TDE_BCCFDEFAULT_CALENDAR_ID","1");
define("TDE_BCCFDEFAULT_CALENDAR_LANGUAGE","EN");
define("DEX_BCCF_DEFAULT_CALENDAR_MODE","true");

define("TDE_BCCFCAL_PREFIX", "RCalendar");
define("TDE_BCCFCONFIG",DEX_BCCF_CONFIG_TABLE_NAME);
define("TDE_BCCFCONFIG_ID","id");
define("TDE_BCCFCONFIG_TITLE","title");
define("TDE_BCCFCONFIG_USER","uname");
define("TDE_BCCFCONFIG_PASS","passwd");
define("TDE_BCCFCONFIG_LANG","lang");
define("TDE_BCCFCONFIG_CPAGES","cpages");
define("TDE_BCCFCONFIG_MSG","msg");
define("TDE_BCCFCALDELETED_FIELD","caldeleted");

define("TDE_BCCFCALENDAR_DATA_TABLE",DEX_BCCF_CALENDARS_TABLE_NAME);
define("TDE_BCCFDATA_ID","id");
define("TDE_BCCFDATA_IDCALENDAR","reservation_calendar_id");
define("TDE_BCCFDATA_DATETIME_S","datatime_s");
define("TDE_BCCFDATA_DATETIME_E","datatime_e");
define("TDE_BCCFDATA_TITLE","title");
define("TDE_BCCFDATA_DESCRIPTION","description");
// end calendar constants

define('TDE_BCCFDEFAULT_dexcv_enable_captcha', 'true');
define('TDE_BCCFDEFAULT_dexcv_width', '180');
define('TDE_BCCFDEFAULT_dexcv_height', '60');
define('TDE_BCCFDEFAULT_dexcv_chars', '5');
define('TDE_BCCFDEFAULT_dexcv_font', 'font-1.ttf');
define('TDE_BCCFDEFAULT_dexcv_min_font_size', '25');
define('TDE_BCCFDEFAULT_dexcv_max_font_size', '35');
define('TDE_BCCFDEFAULT_dexcv_noise', '200');
define('TDE_BCCFDEFAULT_dexcv_noise_length', '4');
define('TDE_BCCFDEFAULT_dexcv_background', 'ffffff');
define('TDE_BCCFDEFAULT_dexcv_border', '000000');
define('DEX_BCCF_DEFAULT_dexcv_text_enter_valid_captcha', 'Please enter a valid captcha code.');




register_activation_hook(__FILE__,'dex_bccf_install');
register_deactivation_hook( __FILE__, 'dex_bccf_remove' );

function dex_bccf_plugin_init() {
  load_plugin_textdomain( 'bccf', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action('plugins_loaded', 'dex_bccf_plugin_init');

function dex_bccf_install($networkwide)  {
	global $wpdb;

	if (function_exists('is_multisite') && is_multisite()) {
		// check if it is a network activation - if so, run the activation function for each blog id
		if ($networkwide) {
	                $old_blog = $wpdb->blogid;
			// Get all blog ids
			$blogids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
			foreach ($blogids as $blog_id) {
				switch_to_blog($blog_id);
				_dex_bccf_install();
			}
			switch_to_blog($old_blog);
			return;
		}
	}
	_dex_bccf_install();
}

function _dex_bccf_install() {
    global $wpdb;

    $sql = "CREATE TABLE ".$wpdb->prefix.DEX_BCCF_DISCOUNT_CODES_TABLE_NAME_NO_PREFIX." (
         id mediumint(9) NOT NULL AUTO_INCREMENT,
         cal_id mediumint(9) NOT NULL DEFAULT 1,
         code VARCHAR(250) DEFAULT '' NOT NULL,
         discount VARCHAR(250) DEFAULT '' NOT NULL,
         expires datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
         availability int(10) unsigned NOT NULL DEFAULT 0,
         used int(10) unsigned NOT NULL DEFAULT 0,
         UNIQUE KEY id (id)
         );";
    $wpdb->query($sql);

    $sql = "CREATE TABLE ".$wpdb->prefix.DEX_BCCF_SEASON_PRICES_TABLE_NAME_NO_PREFIX." (
         id mediumint(9) NOT NULL AUTO_INCREMENT,
         cal_id mediumint(9) NOT NULL DEFAULT 1,
         price VARCHAR(250) DEFAULT '' NOT NULL,
         date_from datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
         date_to datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
         UNIQUE KEY id (id)
         );";
    $wpdb->query($sql);


    $sql = "CREATE TABLE ".$wpdb->prefix.DEX_BCCF_TABLE_NAME_NO_PREFIX." (
         id mediumint(9) NOT NULL AUTO_INCREMENT,
         calendar INT NOT NULL,
         time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
         booked_time_s VARCHAR(250) DEFAULT '' NOT NULL,
         booked_time_e VARCHAR(250) DEFAULT '' NOT NULL,
         booked_time_unformatted_s VARCHAR(250) DEFAULT '' NOT NULL,
         booked_time_unformatted_e VARCHAR(250) DEFAULT '' NOT NULL,
         name VARCHAR(250) DEFAULT '' NOT NULL,
         email VARCHAR(250) DEFAULT '' NOT NULL,
         phone VARCHAR(250) DEFAULT '' NOT NULL,
         notifyto VARCHAR(250) DEFAULT '' NOT NULL,
         question mediumtext,
         buffered_date mediumtext,
         UNIQUE KEY id (id)
         );";
    $wpdb->query($sql);


    $sql = "CREATE TABLE `".$wpdb->prefix.DEX_BCCF_CONFIG_TABLE_NAME."` (".
                   "`".TDE_BCCFCONFIG_ID."` int(10) unsigned NOT NULL auto_increment,".
                   "`".TDE_BCCFCONFIG_TITLE."` varchar(255) NOT NULL default '',".
                   "`".TDE_BCCFCONFIG_USER."` varchar(100) default NULL,".
                   "`".TDE_BCCFCONFIG_PASS."` varchar(100) default NULL,".
                   "`".TDE_BCCFCONFIG_LANG."` varchar(5) default NULL,".
                   "`".TDE_BCCFCONFIG_CPAGES."` tinyint(3) unsigned default NULL,".
                   "`".TDE_BCCFCONFIG_MSG."` varchar(255) NOT NULL default '',".
                   "`".TDE_BCCFCALDELETED_FIELD."` tinyint(3) unsigned default NULL,".
                   "`conwer` INT NOT NULL,".
                   "`form_structure` mediumtext,".
                   "`calendar_language` varchar(10) DEFAULT '' NOT NULL,".
                   "`calendar_mode` varchar(10) DEFAULT '' NOT NULL,".
                   "`calendar_dateformat` varchar(10) DEFAULT '',".
                   "`calendar_overlapped` varchar(10) DEFAULT '',".
                   "`calendar_enabled` varchar(10) DEFAULT '',".
                   "`calendar_pages` varchar(10) DEFAULT '' NOT NULL,".
                   "`calendar_weekday` varchar(10) DEFAULT '' NOT NULL,".
                   "`calendar_mindate` varchar(255) DEFAULT '' NOT NULL,".
                   "`calendar_maxdate` varchar(255) DEFAULT '' NOT NULL,".
                   "`calendar_minnights` varchar(255) DEFAULT '0' NOT NULL,".
                   "`calendar_maxnights` varchar(255) DEFAULT '365' NOT NULL,".
                   "`calendar_suplement` varchar(255) DEFAULT '0' NOT NULL,".
                   "`calendar_suplementminnight` varchar(255) DEFAULT '0' NOT NULL,".
                   "`calendar_suplementmaxnight` varchar(255) DEFAULT '0' NOT NULL,".
                   "`calendar_startres` text,".
                   "`calendar_holidays` text,".
                   "`calendar_fixedmode` varchar(10) DEFAULT '0' NOT NULL,".
                   "`calendar_holidaysdays` varchar(20) DEFAULT '1111111' NOT NULL,".
                   "`calendar_startresdays` varchar(20) DEFAULT '1111111' NOT NULL,".
                   "`calendar_fixedreslength` varchar(20) DEFAULT '1' NOT NULL,".
                   "`calendar_showcost` varchar(1) DEFAULT '1' NOT NULL,".
                   // paypal
                   "`enable_paypal` varchar(10) DEFAULT '' NOT NULL,".
                   "`paypal_email` varchar(255) DEFAULT '' NOT NULL ,".
                   "`request_cost` varchar(255) DEFAULT '' NOT NULL ,".
                   "`max_slots` varchar(20) DEFAULT '0' NOT NULL ,".
                   "`paypal_product_name` varchar(255) DEFAULT '' NOT NULL,".
                   "`currency` varchar(10) DEFAULT '' NOT NULL,".
                   "`request_taxes` varchar(20) DEFAULT '' NOT NULL ,".
                   "`url_ok` text,".
                   "`url_cancel` text,".
                   "`paypal_language` varchar(10) DEFAULT '' NOT NULL,".
                   // copy to user
                   "`cu_user_email_field` VARCHAR(250) DEFAULT '' NOT NULL,".
                   "`notification_from_email` text,".
                   "`notification_destination_email` text,".
                   "`email_subject_confirmation_to_user` text,".
                   "`email_confirmation_to_user` text,".
                   "`email_subject_notification_to_admin` text,".
                   "`email_notification_to_admin` text,".
                   // validation
                   "`enable_paypal_option_yes` VARCHAR(250) DEFAULT '' NOT NULL,".
                   "`enable_paypal_option_no` VARCHAR(250) DEFAULT '' NOT NULL,".                  
                   "`vs_use_validation` VARCHAR(10) DEFAULT '' NOT NULL,".
                   "`vs_text_is_required` VARCHAR(250) DEFAULT '' NOT NULL,".
                   "`vs_text_is_email` VARCHAR(250) DEFAULT '' NOT NULL,".
                   "`vs_text_datemmddyyyy` VARCHAR(250) DEFAULT '' NOT NULL,".
                   "`vs_text_dateddmmyyyy` VARCHAR(250) DEFAULT '' NOT NULL,".
                   "`vs_text_number` VARCHAR(250) DEFAULT '' NOT NULL,".
                   "`vs_text_digits` VARCHAR(250) DEFAULT '' NOT NULL,".
                   "`vs_text_max` VARCHAR(250) DEFAULT '' NOT NULL,".
                   "`vs_text_min` VARCHAR(250) DEFAULT '' NOT NULL,".

                   "`vs_text_submitbtn` VARCHAR(250) DEFAULT '' NOT NULL,".
                   "`vs_text_previousbtn` VARCHAR(250) DEFAULT '' NOT NULL,".
                   "`vs_text_nextbtn` VARCHAR(250) DEFAULT '' NOT NULL,  ".                 

                   "`calendar_depositenable` VARCHAR(20) DEFAULT '' NOT NULL,  ".
                   "`calendar_depositamount` VARCHAR(20) DEFAULT '' NOT NULL,  ".
                   "`calendar_deposittype` VARCHAR(20) DEFAULT '' NOT NULL,  ".                   
                   
                   // captcha
                   "`dexcv_enable_captcha` varchar(10) DEFAULT '' NOT NULL,".
                   "`dexcv_width` varchar(10) DEFAULT '' NOT NULL,".
                   "`dexcv_height` varchar(10) DEFAULT '' NOT NULL,".
                   "`dexcv_chars` varchar(10) DEFAULT '' NOT NULL,".
                   "`dexcv_min_font_size` varchar(10) DEFAULT '' NOT NULL,".
                   "`dexcv_max_font_size` varchar(10) DEFAULT '' NOT NULL,".
                   "`dexcv_noise` varchar(10) DEFAULT '' NOT NULL,".
                   "`dexcv_noise_length` varchar(10) DEFAULT '' NOT NULL,".
                   "`dexcv_background` varchar(10) DEFAULT '' NOT NULL,".
                   "`dexcv_border` varchar(10) DEFAULT '' NOT NULL,".
                   "`dexcv_font` varchar(100) DEFAULT '' NOT NULL,".
                   "`cv_text_enter_valid_captcha` VARCHAR(250) DEFAULT '' NOT NULL,".
                   // services field
                   "`cp_cal_checkboxes` text,".
                   "`cp_cal_checkboxes_type` varchar(10) DEFAULT '' NOT NULL,".
                   "PRIMARY KEY (`".TDE_BCCFCONFIG_ID."`)); ";
    $wpdb->query($sql);

    $sql = 'INSERT INTO `'.$wpdb->prefix.DEX_BCCF_CONFIG_TABLE_NAME.'` (`'.TDE_BCCFCONFIG_ID.'`,`form_structure`,`'.TDE_BCCFCONFIG_TITLE.'`,`'.TDE_BCCFCONFIG_USER.'`,`'.TDE_BCCFCONFIG_PASS.'`,`'.TDE_BCCFCONFIG_LANG.'`,`'.TDE_BCCFCONFIG_CPAGES.'`,`'.TDE_BCCFCONFIG_MSG.'`,`'.TDE_BCCFCALDELETED_FIELD.'`,calendar_mode) VALUES("1","'.esc_sql(DEX_BCCF_DEFAULT_form_structure).'","cal1","Calendar Item 1","","ENG","1","Please, select your reservation.","0","true");';
    $wpdb->query($sql);

    $sql = "CREATE TABLE `".$wpdb->prefix.DEX_BCCF_CALENDARS_TABLE_NAME."` (".
                   "`".TDE_BCCFDATA_ID."` int(10) unsigned NOT NULL auto_increment,".
                   "`".TDE_BCCFDATA_IDCALENDAR."` int(10) unsigned default NULL,".
                   "`".TDE_BCCFDATA_DATETIME_S."`datetime NOT NULL default '0000-00-00 00:00:00',".
                   "`".TDE_BCCFDATA_DATETIME_E."`datetime NOT NULL default '0000-00-00 00:00:00',".
                   "`".TDE_BCCFDATA_TITLE."` varchar(250) default NULL,".
                   "`".TDE_BCCFDATA_DESCRIPTION."` mediumtext,".
                   "`viadmin` varchar(10) DEFAULT '0' NOT NULL,".
                   "`color` varchar(10),".
                   "PRIMARY KEY (`".TDE_BCCFDATA_ID."`)) ;";
    $wpdb->query($sql);



    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
}

function dex_bccf_remove() {

}


/* Filter for placing the maps into the contents */

function dex_bccf_filter_content($atts) {
    global $wpdb;
    extract( shortcode_atts( array(
		'calendar' => '',
		'user' => '',
	), $atts ) );
    if ($calendar != '')
        define ('DEX_BCCF_CALENDAR_FIXED_ID',$calendar);
    else if ($user != '')
    {
        $users = $wpdb->get_results( "SELECT user_login,ID FROM ".$wpdb->users." WHERE user_login='".esc_sql($user)."'" );
        if (isset($users[0]))
            define ('DEX_CALENDAR_USER',$users[0]->ID);
        else
            define ('DEX_CALENDAR_USER',0);
    }
    else
        define ('DEX_CALENDAR_USER',0);
    ob_start();
    dex_bccf_get_public_form();
    $buffered_contents = ob_get_contents();
    ob_end_clean();
    return $buffered_contents;
}


function dex_bccf_filter_content_allcalendars($atts) {
    global $wpdb;    
    define ('DEX_CALENDAR_USER',0);
    ob_start();
    wp_enqueue_script( "jquery" );
    wp_enqueue_script( "jquery-ui-core" );
    wp_enqueue_script( "jquery-ui-datepicker" );
    $myrows = $wpdb->get_results( "SELECT * FROM ".DEX_BCCF_CONFIG_TABLE_NAME );
    define('DEX_AUTH_INCLUDE', true);
    @include dirname( __FILE__ ) . '/addons/dex_allcals.inc.php';    
    $buffered_contents = ob_get_contents();
    ob_end_clean();
    return $buffered_contents;
}

function dex_bccf_get_public_form() {
    global $wpdb;

    if (defined('DEX_CALENDAR_USER') && DEX_CALENDAR_USER != 0)
        $myrows = $wpdb->get_results( "SELECT * FROM ".DEX_BCCF_CONFIG_TABLE_NAME." WHERE conwer=".DEX_CALENDAR_USER );
    else if (defined('DEX_BCCF_CALENDAR_FIXED_ID'))
        $myrows = $wpdb->get_results( "SELECT * FROM ".DEX_BCCF_CONFIG_TABLE_NAME." WHERE id=".DEX_BCCF_CALENDAR_FIXED_ID );
    else
        $myrows = $wpdb->get_results( "SELECT * FROM ".DEX_BCCF_CONFIG_TABLE_NAME );

    define ('CP_BCCF_CALENDAR_ID',$myrows[0]->id);

    $previous_label = dex_bccf_get_option('vs_text_previousbtn', 'Previous');
    $previous_label = ($previous_label==''?'Previous':$previous_label);
    $next_label = dex_bccf_get_option('vs_text_nextbtn', 'Next');
    $next_label = ($next_label==''?'Next':$next_label);  
    
    // for the additional services field if needed
    $dex_buffer = array();
    for ($k=1;$k<=DEX_BCCF_DEFAULT_SERVICES_FIELDS; $k++)
    {
        $dex_buffer[$k] = "";
        $services = explode("\n",dex_bccf_get_option('cp_cal_checkboxes'.$k, DEX_BCCF_DEFAULT_CP_CAL_CHECKBOXES));
        foreach ($services as $item)
            if (trim($item) != '')
            {
                $dex_buffer[$k] .= '<option value="'.esc_attr($item).'">'.__(trim(substr($item,strpos($item,"|")+1)),'bccf').'</option>';
            }
    }

    $calendar_language = dex_bccf_get_option('calendar_language',DEX_BCCF_DEFAULT_CALENDAR_LANGUAGE);
    if ($calendar_language == '') $calendar_language = dex_bccf_autodetect_language();

    if (DEX_BCCF_DEFAULT_DEFER_SCRIPTS_LOADING)
    {
        wp_deregister_script('query-stringify');
        wp_register_script('query-stringify', plugins_url('/js/jQuery.stringify.js', __FILE__));

        wp_deregister_script('cp_contactformpp_validate_script');
        wp_register_script('cp_contactformpp_validate_script', plugins_url('/js/jquery.validate.js', __FILE__));
        
        wp_deregister_script('cp_contactformpp_rcalendar');
        wp_register_script('cp_contactformpp_rcalendar', plugins_url('/js/jquery.rcalendar.js', __FILE__));        
       
        $dependencies = array("jquery","jquery-ui-core","jquery-ui-button","jquery-ui-datepicker","jquery-ui-widget","jquery-ui-position","jquery-ui-tooltip","query-stringify","cp_contactformpp_validate_script", "cp_contactformpp_rcalendar"); 
        if ($calendar_language != '') {
            wp_deregister_script('cp_contactformpp_rclang');
            wp_register_script('cp_contactformpp_rclang', plugins_url('/js/languages/jquery.ui.datepicker-'.$calendar_language.'.js', __FILE__));        
            $dependencies[] = 'cp_contactformpp_rclang';
        }    

        wp_enqueue_script( 'dex_bccf_builder_script',
        plugins_url('/js/fbuilder.jquery.js', __FILE__),$dependencies, false, true );

        // localize script
        wp_localize_script('dex_bccf_builder_script', 'dex_bccf_fbuilder_config', array('obj'  	=>
        '{"pub":true,"messages": {
        	                	"required": "'.str_replace(array('"'),array('\\"'),__(dex_bccf_get_option('vs_text_is_required', DEX_BCCF_DEFAULT_vs_text_is_required),'bccf')).'",
        	                	"email": "'.str_replace(array('"'),array('\\"'),__(dex_bccf_get_option('vs_text_is_email', DEX_BCCF_DEFAULT_vs_text_is_email),'bccf')).'",
        	                	"datemmddyyyy": "'.str_replace(array('"'),array('\\"'),__(dex_bccf_get_option('vs_text_datemmddyyyy', DEX_BCCF_DEFAULT_vs_text_datemmddyyyy),'bccf')).'",
        	                	"dateddmmyyyy": "'.str_replace(array('"'),array('\\"'),__(dex_bccf_get_option('vs_text_dateddmmyyyy', DEX_BCCF_DEFAULT_vs_text_dateddmmyyyy),'bccf')).'",
        	                	"number": "'.str_replace(array('"'),array('\\"'),__(dex_bccf_get_option('vs_text_number', DEX_BCCF_DEFAULT_vs_text_number),'bccf')).'",
        	                	"digits": "'.str_replace(array('"'),array('\\"'),__(dex_bccf_get_option('vs_text_digits', DEX_BCCF_DEFAULT_vs_text_digits),'bccf')).'",
        	                	"max": "'.str_replace(array('"'),array('\\"'),__(dex_bccf_get_option('vs_text_max', DEX_BCCF_DEFAULT_vs_text_max),'bccf')).'",
        	                	"min": "'.str_replace(array('"'),array('\\"'),__(dex_bccf_get_option('vs_text_min', DEX_BCCF_DEFAULT_vs_text_min),'bccf')).'",
    	                    	"previous": "'.str_replace(array('"'),array('\\"'),$previous_label).'",
    	                    	"next": "'.str_replace(array('"'),array('\\"'),$next_label).'"
        	                }}'
        ));
    }
    else
    {
        wp_enqueue_script( "jquery" );
        wp_enqueue_script( "jquery-ui-core" );
        wp_enqueue_script( "jquery-ui-datepicker" );
    }

    $option_calendar_enabled = dex_bccf_get_option('calendar_enabled', DEX_BCCF_DEFAULT_CALENDAR_ENABLED);

    $button_label = dex_bccf_get_option('vs_text_submitbtn', 'Continue');
    $button_label = ($button_label==''?'Continue':$button_label);
    define('DEX_AUTH_INCLUDE', true);       
    
    if (!DEX_BCCF_DEFAULT_DEFER_SCRIPTS_LOADING) {
        
        $prefix_ui = '';
        if (@file_exists(dirname( __FILE__ ).'/../../../wp-includes/js/jquery/ui/jquery.ui.core.min.js'))
            $prefix_ui = 'jquery.ui.'; 
                    
?>
<?php $plugin_url = plugins_url('', __FILE__); ?>
<script> if( typeof jQuery != 'undefined' ) var jQueryBK = jQuery.noConflict(); </script>
<script type='text/javascript' src='<?php echo $plugin_url.'/../../../wp-includes/js/jquery/jquery.js'; ?>'></script>
<script type='text/javascript' src='<?php echo $plugin_url.'/../../../wp-includes/js/jquery/ui/'.$prefix_ui.'core.min.js'; ?>'></script>
<script type='text/javascript' src='<?php echo $plugin_url.'/../../../wp-includes/js/jquery/ui/'.$prefix_ui.'datepicker.min.js'; ?>'></script>
<script type='text/javascript' src='<?php echo $plugin_url.'/../../../wp-includes/js/jquery/ui/'.$prefix_ui.'widget.min.js'; ?>'></script>
<script type='text/javascript' src='<?php echo $plugin_url.'/../../../wp-includes/js/jquery/ui/'.$prefix_ui.'position.min.js'; ?>'></script>
<script type='text/javascript' src='<?php echo $plugin_url.'/../../../wp-includes/js/jquery/ui/'.$prefix_ui.'tooltip.min.js'; ?>'></script>
<script> 
        var myjQuery = jQuery.noConflict( ); 
        if( typeof jQueryBK != 'undefined' ) {jQuery = jQueryBK;};
</script>
<script type='text/javascript' src='<?php echo plugins_url('js/jQuery.stringify.js', __FILE__); ?>'></script>
<script type='text/javascript' src='<?php echo plugins_url('js/jquery.validate.js', __FILE__); ?>'></script>
<?php if ($calendar_language != '') { ?><script type="text/javascript" src="<?php echo plugins_url('/js/languages/jquery.ui.datepicker-'.$calendar_language.'.js', __FILE__); ?>"></script><?php } ?>
<script type='text/javascript' src='<?php echo plugins_url('js/jquery.rcalendar.js', __FILE__); ?>'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var dex_bccf_fbuilder_config = {"obj":"{\"pub\":true,\"messages\": {\n    \t                \t\"required\": \"This field is required.\",\n    \t                \t\"email\": \"Please enter a valid email address.\",\n    \t                \t\"datemmddyyyy\": \"Please enter a valid date with this format(mm\/dd\/yyyy)\",\n    \t                \t\"dateddmmyyyy\": \"Please enter a valid date with this format(dd\/mm\/yyyy)\",\n    \t                \t\"number\": \"Please enter a valid number.\",\n    \t                \t\"digits\": \"Please enter only digits.\",\n    \t                \t\"max\": \"Please enter a value less than or equal to {0}.\",\n    \t                \t\"min\": \"Please enter a value greater than or equal to {0}.\"\n    \t                }}"};
/* ]]> */
</script>
<?php
    }
    @include dirname( __FILE__ ) . '/dex_scheduler.inc.php';
    if (!DEX_BCCF_DEFAULT_DEFER_SCRIPTS_LOADING) {    
        ?><script type='text/javascript' src='<?php echo plugins_url('js/fbuilder.jquery.js', __FILE__); ?>'></script><?php
    }
}


function dex_bccf_show_booking_form($id = "")
{
    if ($id != '')
        define ('DEX_BCCF_CALENDAR_FIXED_ID',$id);
    define('DEX_AUTH_INCLUDE', true);
    @include dirname( __FILE__ ) . '/dex_scheduler.inc.php';
}


/* Code for the admin area */

if ( is_admin() ) {
    add_action('media_buttons', 'set_dex_bccf_insert_button', 100);
    add_action('admin_enqueue_scripts', 'set_dex_bccf_insert_adminScripts', 1);
    add_action('admin_menu', 'dex_bccf_admin_menu');

    $plugin = plugin_basename(__FILE__);
    add_filter("plugin_action_links_".$plugin, 'dex_bccf_customAdjustmentsLink');
    add_filter("plugin_action_links_".$plugin, 'dex_bccf_settingsLink');
    add_filter("plugin_action_links_".$plugin, 'dex_bccf_helpLink');


    function dex_bccf_admin_menu() {
        add_options_page('Booking Calendar Contact Form Options', 'Booking Calendar Contact Form', 'manage_options', 'dex_bccf', 'dex_bccf_html_post_page' );
        add_menu_page( 'Booking Calendar Contact Form Options', 'Booking Calend. Contact Form', 'edit_pages', 'dex_bccf', 'dex_bccf_html_post_page' );
        
        add_submenu_page( 'dex_bccf', 'Manage Calendar', 'Manage Calendar', 'edit_pages', "dex_bccf",  'dex_bccf_html_post_page' );
        add_submenu_page( 'dex_bccf', 'Help: Online demo', 'Help: Online demo', 'edit_pages', "dex_bccf_demo", 'dex_bccf_html_post_page' );       
        add_submenu_page( 'dex_bccf', 'Upgrade', 'Upgrade', 'edit_pages', "dex_bccf_upgrade", 'dex_bccf_html_post_page' );
                 
    }
}
else
{
    add_shortcode( 'CP_BCCF_FORM', 'dex_bccf_filter_content' );
    add_shortcode( 'CP_BCCF_ALLCALS', 'dex_bccf_filter_content_allcalendars' );
}

function dex_bccf_settingsLink($links) {
    $settings_link = '<a href="options-general.php?page=dex_bccf">'.__('Settings','bccf').'</a>';
	array_unshift($links, $settings_link);
	return $links;
}


function dex_bccf_helpLink($links) {
    $help_link = '<a href="http://wordpress.dwbooster.com/calendars/booking-calendar-contact-form">'.__('Help','bccf').'</a>';
	array_unshift($links, $help_link);
	return $links;
}

function dex_bccf_customAdjustmentsLink($links) {
    $customAdjustments_link = '<a href="http://wordpress.dwbooster.com/contact-us">'.__('Request custom changes','bccf').'</a>';
	array_unshift($links, $customAdjustments_link);
	return $links;
}

function dex_bccf_html_post_page() {
    if (isset($_GET["cal"]) && $_GET["cal"] != '')
    {
        if (isset($_GET["list"]) && $_GET["list"] == '1')
            @include_once dirname( __FILE__ ) . '/dex_bccf_admin_int_bookings_list.inc.php';
        else
            @include_once dirname( __FILE__ ) . '/dex_bccf_admin_int.inc.php';
    }
    else
    {
        if (isset($_GET["page"]) &&$_GET["page"] == 'dex_bccf_upgrade')
        {
            echo("Redirecting to upgrade page...<script type='text/javascript'>document.location='http://wordpress.dwbooster.com/calendars/booking-calendar-contact-form#download';</script>");
            exit;
        } 
        else if (isset($_GET["page"]) &&$_GET["page"] == 'dex_bccf_demo')
        {
            echo("Redirecting to demo page...<script type='text/javascript'>document.location='http://wordpress.dwbooster.com/calendars/booking-calendar-contact-form#demo';</script>");
            exit;
        } 
        else        
            @include_once dirname( __FILE__ ) . '/dex_bccf_admin_int_calendar_list.inc.php';
    }

}

function set_dex_bccf_insert_button() {
    print '<a href="javascript:send_to_editor(\'[CP_BCCF_FORM]\')" title="'.__('Insert Booking Calendar','bccf').'"><img hspace="5" src="'.plugins_url('/images/dex_apps.gif', __FILE__).'" alt="'.__('Insert  Booking Calendar','bccf').'" /></a>';
}

function set_dex_bccf_insert_adminScripts($hook) {
    if (isset($_GET["page"]) && $_GET["page"] == "dex_bccf")
    {
        wp_deregister_script('query-stringify');
        wp_register_script('query-stringify', plugins_url('/js/jQuery.stringify.js', __FILE__));
        wp_deregister_script('cp_contactformpp_rcalendar');
        wp_register_script('cp_contactformpp_rcalendar', plugins_url('/js/jquery.rcalendar.js', __FILE__));
        wp_deregister_script('cp_contactformpp_rcalendaradmin');
        wp_register_script('cp_contactformpp_rcalendaradmin', plugins_url('/js/jquery.rcalendaradmin.js', __FILE__));
        wp_enqueue_script( 'dex_bccf_builder_script', plugins_url('/js/fbuilder.jquery.js', __FILE__),array("jquery","jquery-ui-core","jquery-ui-sortable","jquery-ui-tabs","jquery-ui-dialog","jquery-ui-droppable","jquery-ui-button","jquery-ui-datepicker","query-stringify","cp_contactformpp_rcalendar","cp_contactformpp_rcalendaradmin") );

        wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
    }
    if( 'post.php' != $hook  && 'post-new.php' != $hook )
        return;    
}


/* hook for checking posted data for the admin area */


add_action( 'init', 'dex_bccf_check_posted_data', 11 );

function dex_bccf_check_posted_data()
{
    global $wpdb;

    if (isset($_GET["dex_item"]) && $_GET["dex_item"] != '')
        $_POST["dex_item"] = $_GET["dex_item"];
    if (!defined('CP_BCCF_CALENDAR_ID') && isset($_POST["dex_item"]) && $_POST["dex_item"] != '')
        define ('CP_BCCF_CALENDAR_ID',$_POST["dex_item"]);

    // define which action is being requested
    //-------------------------------------------------
    if (isset($_GET["dex_bccf"]) && $_GET["dex_bccf"] == 'getcost')
    {
        $default_price = dex_bccf_get_option('request_cost', DEX_BCCF_DEFAULT_COST);
        $services_formatted = array();
        for ($k=1;$k<=DEX_BCCF_DEFAULT_SERVICES_FIELDS; $k++)
        {
            $services_formatted[$k] = array();
            if (isset($_GET["ser".$k]))
                $services_formatted[$k] = explode("|",$_GET["ser".$k]);
        }
        echo dex_bccf_caculate_price_overall(strtotime($_GET["from"]), strtotime($_GET["to"]), $_POST["dex_item"], $default_price, $services_formatted);
        exit;
    }

    if (isset($_GET["dex_bccf"]) && $_GET["dex_bccf"] == 'loadseasonprices')
        dex_bccf_load_season_prices();

    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset( $_POST['dex_bccf_post_options'] ) && is_admin() )
    {
        dex_bccf_save_options();
        return;
    }

    // if this isn't the expected post and isn't the captcha verification then nothing to do
	if ( 'POST' != $_SERVER['REQUEST_METHOD'] || ! isset( $_POST['dex_bccf_post'] ) )
		if ( 'GET' != $_SERVER['REQUEST_METHOD'] || !isset( $_GET['hdcaptcha_dex_bccf_post'] ) )
		    return;

    // captcha verification
    //-------------------------------------------------
    session_start();
    if (!isset($_GET['hdcaptcha_dex_bccf_post']) ||$_GET['hdcaptcha_dex_bccf_post'] == '') $_GET['hdcaptcha_dex_bccf_post'] = @$_POST['hdcaptcha_dex_bccf_post'];
    if (
           (dex_bccf_get_option('dexcv_enable_captcha', TDE_BCCFDEFAULT_dexcv_enable_captcha) != 'false') &&
           ( (strtolower($_GET['hdcaptcha_dex_bccf_post']) != strtolower($_SESSION['rand_code'])) ||
             ($_SESSION['rand_code'] == '')
           )
           &&
           ( (md5(strtolower($_GET['hdcaptcha_dex_bccf_post'])) != ($_COOKIE['rand_code'])) ||
             ($_COOKIE['rand_code'] == '')
           )
       )
    {
        $_SESSION['rand_code'] = '';
        echo 'captchafailed';
        exit;
    }

	// if this isn't the real post (it was the captcha verification) then echo ok and exit
    if ( 'POST' != $_SERVER['REQUEST_METHOD'] || ! isset( $_POST['dex_bccf_post'] ) )
	{
	    echo 'ok';
        exit;
	}

    $_SESSION['rand_code'] = '';



    // get calendar and selected date
    //-------------------------------------------------
    $selectedCalendar = $_POST["dex_item"];
    $selectedCalendar_sfx = 'calarea'.$selectedCalendar;
    $option_calendar_enabled = dex_bccf_get_option('calendar_enabled', DEX_BCCF_DEFAULT_CALENDAR_ENABLED);
    if ($option_calendar_enabled != 'false')
    {
        $_POST["dateAndTime_s"] =  $_POST["selYear_start".$selectedCalendar_sfx]."-".$_POST["selMonth_start".$selectedCalendar_sfx]."-".$_POST["selDay_start".$selectedCalendar_sfx];
        $_POST["dateAndTime_e"] =  $_POST["selYear_end".$selectedCalendar_sfx]."-".$_POST["selMonth_end".$selectedCalendar_sfx]."-".$_POST["selDay_end".$selectedCalendar_sfx];

        if (dex_bccf_get_option('calendar_dateformat', DEX_BCCF_DEFAULT_CALENDAR_DATEFORMAT))
        {
            $_POST["Date_s"] = date("d/m/Y",strtotime($_POST["dateAndTime_s"]));
            $_POST["Date_e"] = date("d/m/Y",strtotime($_POST["dateAndTime_e"]));
        }
        else
        {
            $_POST["Date_s"] = date("m/d/Y",strtotime($_POST["dateAndTime_s"]));
            $_POST["Date_e"] = date("m/d/Y",strtotime($_POST["dateAndTime_e"]));
        }

        // calculate days
        $days = round(
                       (strtotime($_POST["dateAndTime_e"]) - strtotime($_POST["dateAndTime_s"])) / (24 * 60 * 60)
                     );
        if (dex_bccf_get_option('calendar_mode',DEX_BCCF_DEFAULT_CALENDAR_MODE) == 'false')
            $days++;
    }
    else
    {
        $days = 1;
        $_POST["dateAndTime_s"] = date("Y-m-d", time());
        $_POST["dateAndTime_e"] = date("Y-m-d", time());
        $_POST["Date_s"] = date("m/d/Y",strtotime($_POST["dateAndTime_s"]));
        $_POST["Date_e"] = date("m/d/Y",strtotime($_POST["dateAndTime_e"]));
    }

    $services_formatted = array();
    $services_text = "";


    // calculate price from services field or dates
    //-------------------------------------------------    
    $price = dex_bccf_caculate_price_overall(strtotime($_POST["dateAndTime_s"]), strtotime($_POST["dateAndTime_e"]), CP_BCCF_CALENDAR_ID, @$default_price, $services_formatted);

    $taxes = trim(str_replace("%","",dex_bccf_get_option('request_taxes', '0')));

    // check discount codes
    //-------------------------------------------------
    $discount_note = "";
    $coupon = false;
    $codes = array();


    // get form info
    //---------------------------
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    $form_data = json_decode(dex_bccf_cleanJSON(dex_bccf_get_option('form_structure', DEX_BCCF_DEFAULT_form_structure)));
    $fields = array();
    foreach ($form_data[0] as $item)
    {
        $fields[$item->name] = $item->title;
    }

    // grab posted data
    //---------------------------
    $buffer = "";
    $params = array();
    $params["startdate"] = $_POST["Date_s"];
    $params["enddate"] = $_POST["Date_e"];
    $params["discount"] = @$discount_note;
    $params["coupon"] = ($coupon?$coupon->code:"");
    $params["service"] = $services_text;
    $params["totalcost"] = dex_bccf_get_option('currency', DEX_BCCF_DEFAULT_CURRENCY).' '.$price;

    foreach ($_POST as $item => $value)
        if (isset($fields[$item]))
        {
            $buffer .= $fields[$item] . ": ". (is_array($value)?(implode(", ",$value)):($value)) . "\n\n";
            $params[$item] = $value;
        }
    $buffer_A = trim($buffer)."\n\n";
    $buffer_A .= ($services_text != ''?$services_text."\n\n":"").
                 ($coupon?"\nCoupon code: ".$coupon->code.$discount_note."\n\n":"");

    if ($price != 0) $buffer_A .= 'Total Cost: '.dex_bccf_get_option('currency', DEX_BCCF_DEFAULT_CURRENCY).' '.$price."\n\n";

    $buffer = $_POST["selMonth_start".$selectedCalendar_sfx]."/".$_POST["selDay_start".$selectedCalendar_sfx]."/".$_POST["selYear_start".$selectedCalendar_sfx]."-".
              $_POST["selMonth_end".$selectedCalendar_sfx]."/".$_POST["selDay_end".$selectedCalendar_sfx]."/".$_POST["selYear_end".$selectedCalendar_sfx]."\n".
              $buffer_A."*-*\n";

    // insert into database
    //---------------------------
    $to = dex_bccf_get_option('cu_user_email_field', DEX_BCCF_DEFAULT_cu_user_email_field);
    $rows_affected = $wpdb->insert( DEX_BCCF_TABLE_NAME, array( 'calendar' => $selectedCalendar,
                                                                        'time' => current_time('mysql'),
                                                                        'booked_time_s' => $_POST["Date_s"],
                                                                        'booked_time_e' => $_POST["Date_e"],
                                                                        'booked_time_unformatted_s' => $_POST["dateAndTime_s"],
                                                                        'booked_time_unformatted_e' => $_POST["dateAndTime_e"],
                                                                        'question' => $buffer_A,
                                                                        'notifyto' => $_POST[$to],
                                                                        'buffered_date' => serialize($params)
                                                                         ) );
    if (!$rows_affected)
    {
        echo 'Error saving data! Please try again.';
        echo '<br /><br />Error debug information: '.mysql_error();
        echo '<br /><br />If the error persists contact support service at http://wordpress.dwbooster.com/support';
        exit;
    }


    $myrows = $wpdb->get_results( "SELECT MAX(id) as max_id FROM ".DEX_BCCF_TABLE_NAME );

 	// save data here
    $item_number = $myrows[0]->max_id;
   
    $paypal_optional = (dex_bccf_get_option('enable_paypal',DEX_BCCF_DEFAULT_ENABLE_PAYPAL) == '2');

    if (dex_bccf_get_option('calendar_depositenable','0') == '1')
    {
        if (dex_bccf_get_option('calendar_deposittype','0') == '0')
            $price = round($price * dex_bccf_get_option('calendar_depositamount','0')/100,2);
        else
            $price =  dex_bccf_get_option('calendar_depositamount','0');
    }

?>
<html>
<head><title>Redirecting to Paypal...</title></head>
<body>
<form action="https://www.paypal.com/cgi-bin/webscr" name="ppform3" method="post">
<input type="hidden" name="cmd" value="_xclick" />
<input type="hidden" name="business" value="<?php echo dex_bccf_get_option('paypal_email', DEX_BCCF_DEFAULT_PAYPAL_EMAIL); ?>" />
<input type="hidden" name="item_name" value="<?php echo dex_bccf_get_option('paypal_product_name', DEX_BCCF_DEFAULT_PRODUCT_NAME).($services_text!=''?", ".str_replace("\n\n",", ",$services_text).". ":"").$discount_note; ?>" />
<input type="hidden" name="item_number" value="<?php echo $item_number; ?>" />
<input type="hidden" name="amount" value="<?php echo $price; ?>" />
<?php if ($taxes != '0' && $taxes != '') { ?>
<input type="hidden" name="tax_rate"  value="<?php echo $taxes; ?>" />
<?php } ?>
<input type="hidden" name="page_style" value="Primary" />
<input type="hidden" name="charset" value="utf-8">
<input type="hidden" name="no_shipping" value="1" />
<input type="hidden" name="return" value="<?php echo dex_bccf_get_option('url_ok', DEX_BCCF_DEFAULT_OK_URL); ?>">
<input type="hidden" name="cancel_return" value="<?php echo dex_bccf_get_option('url_cancel', DEX_BCCF_DEFAULT_CANCEL_URL); ?>" />
<input type="hidden" name="no_note" value="1" />
<input type="hidden" name="currency_code" value="<?php echo dex_bccf_get_option('currency', DEX_BCCF_DEFAULT_CURRENCY); ?>" />
<input type="hidden" name="lc" value="<?php echo dex_bccf_get_option('paypal_language', DEX_BCCF_DEFAULT_PAYPAL_LANGUAGE); ?>" />
<input type="hidden" name="bn" value="NetFactorSL_SI_Custom" />
<input type="hidden" name="notify_url" value="<?php echo cp_bccf_get_FULL_site_url(); ?>/?dex_bccf=ipn&ipncheck=1&itemnumber=<?php echo $item_number; ?>" />
<input type="hidden" name="ipn_test" value="1" />
<input class="pbutton" type="hidden" value="Buy Now" />
</form>
<script type="text/javascript">
document.ppform3.submit();
</script>
</body>
</html>
<?php
        exit(); 
}


function dex_bccf_check_upload($uploadfiles) {
    $filetmp = $uploadfiles['tmp_name'];
    //clean filename and extract extension
    $filename = $uploadfiles['name'];
    // get file info
    $filetype = wp_check_filetype( basename( $filename ), null );

    if ( in_array ($filetype["ext"],array("php","asp","aspx","cgi","pl","perl","exe","js","com")) )
        return false;
    else
        return true;
}


function dex_bccf_caculate_price_overall($startday, $enddate, $calendar, $default_price, $services_formatted)
{
    $days = round(
                   ($enddate - $startday) / (24 * 60 * 60)
                  );
    if (dex_bccf_get_option('calendar_mode',DEX_BCCF_DEFAULT_CALENDAR_MODE) == 'false')
        $days++;

    $min_nights = intval(dex_bccf_get_option('calendar_suplementminnight','0'));
    $max_nights = intval(dex_bccf_get_option('calendar_suplementmaxnight','365'));
    $suplement = 0;

    if ($days >= $min_nights && $days <= $max_nights)
        $suplement  = floatval(dex_bccf_get_option('calendar_suplement', 0));

    $default_price = dex_bccf_get_option('request_cost', DEX_BCCF_DEFAULT_COST);    
    $price = dex_bccf_caculate_price($startday, $enddate, CP_BCCF_CALENDAR_ID, $default_price);

    return $price+$suplement;
}

function dex_bccf_caculate_price($startday, $enddate, $calendar, $default_price) {
    global $wpdb;
 
    $default_price_array = explode (';', $default_price);
    $default_price = $default_price_array[0];
    $season_prices = array();
    $days = 0;
    $price = 0;
    $codes = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.DEX_BCCF_SEASON_PRICES_TABLE_NAME_NO_PREFIX.' WHERE `cal_id`='.$calendar);
    $mode = (dex_bccf_get_option('calendar_mode',DEX_BCCF_DEFAULT_CALENDAR_MODE) == 'false');
    while (
           (($enddate>$startday) && !$mode) ||
           (($enddate>=$startday) && $mode)
           )
    {
        $daily_price = $default_price;
        $sprice = array();
        foreach ($codes as $value)
        {
           $sfrom = strtotime($value->date_from);
           $sto = strtotime($value->date_to);
           if ($startday >= $sfrom && $startday <= $sto)
           {
               $sprice = explode (';', $value->price);               
               $daily_price = $sprice[0];
           }    
        }       
        $season_prices[] = $sprice; 
        $price += $daily_price;        
        $startday = strtotime (date("Y-m-d", $startday)." +1 day"); //60*60*24;        
        $days++;
    }
    
    if (trim(@$default_price_array[$days]))
        $price = trim($default_price_array[$days]);
    if (trim(@$season_prices[0][$days]))
        $price = trim($season_prices[0][$days]);
    if (trim(@$season_prices[count($season_prices)-1][$days]) 
        && 
        floatval($price) < floatval(trim(@$season_prices[count($season_prices)-1][$days]))) // get higher price if different seasons
        $price = trim($season_prices[count($season_prices)-1][$days]);
        
    return $price;
}


function dex_bccf_load_season_prices() {
    global $wpdb;

    if ( ! current_user_can('edit_pages') ) // prevent loading coupons from outside admin area
    {
        echo 'No enough privilegies to load this content.';
        exit;
    }

    if (!defined('CP_BCCF_CALENDAR_ID'))
        define ('CP_BCCF_CALENDAR_ID',$_GET["dex_item"]);

    if (isset($_GET["add"]) && $_GET["add"] == "1")
        $wpdb->insert( $wpdb->prefix.DEX_BCCF_SEASON_PRICES_TABLE_NAME_NO_PREFIX, array('cal_id' => CP_BCCF_CALENDAR_ID,
                                                                         'price' => $_GET["price"],
                                                                         'date_from' => $_GET["dfrom"],
                                                                         'date_to' => $_GET["dto"],
                                                                         ));
    if (isset($_GET["delete"]) && $_GET["delete"] == "1")
        $wpdb->query( $wpdb->prepare( "DELETE FROM ".$wpdb->prefix.DEX_BCCF_SEASON_PRICES_TABLE_NAME_NO_PREFIX." WHERE id = %d", $_GET["code"] ));

    $codes = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.DEX_BCCF_SEASON_PRICES_TABLE_NAME_NO_PREFIX.' WHERE `cal_id`='.CP_BCCF_CALENDAR_ID);
    $maxcosts = 0;
    foreach ($codes as $value)
        if (substr_count($value->price,';') > $maxcosts)
            $maxcosts = substr_count($value->price,';');
    if (count ($codes))
    {
        echo '<table>';
        echo '<tr>';
        echo '  <th style="padding:2px;background-color: #cccccc;font-weight:bold;">Default Cost</th>';
        for ($k=1; $k<=$maxcosts; $k++)
            echo '  <th style="padding:2px;background-color: #cccccc;font-weight:bold;">'.$k.' day'.($k==1?'':'s').'</th>';
        echo '  <th style="padding:2px;background-color: #cccccc;font-weight:bold;">From</th>';
        echo '  <th style="padding:2px;background-color: #cccccc;font-weight:bold;">To</th>';
        echo '  <th style="padding:2px;background-color: #cccccc;font-weight:bold;">Options</th>';
        echo '</tr>';
        foreach ($codes as $value)
        {
           echo '<tr>';
           $price = explode(';',$value->price);
           echo '<td>'.$price[0].'</td>';
           for ($k=1; $k<=$maxcosts; $k++)
               echo '<td>'.@$price[$k].'</td>';
           echo '<td>'.substr($value->date_from,0,10).'</td>';
           echo '<td>'.substr($value->date_to,0,10).'</td>';
           echo '<td>[<a href="javascript:dex_delete_season_price('.$value->id.')">Delete</a>]</td>';
           echo '</tr>';
        }
        echo '</table>';
    }
    else
        echo 'No season prices listed for this calendar yet.';
    exit;
}

add_action( 'init', 'dex_bccf_check_IPN_verification', 11 );

function dex_bccf_check_IPN_verification() {

    global $wpdb;

	if ( ! isset( $_GET['ipncheck'] ) || $_GET['ipncheck'] != '1' ||  ! isset( $_GET["itemnumber"] ) )
		return;

	if ( ! isset( $_GET['dex_bccf'] ) || $_GET['dex_bccf'] != 'ipn' )
		return;

    $item_name = $_POST['item_name'];
    $item_number = $_POST['item_number'];
    $payment_status = $_POST['payment_status'];
    $payment_amount = $_POST['mc_gross'];
    $payment_currency = $_POST['mc_currency'];
    $txn_id = $_POST['txn_id'];
    $receiver_email = $_POST['receiver_email'];
    $payer_email = $_POST['payer_email'];
    $payment_type = $_POST['payment_type'];


	if ($payment_status != 'Completed' && $payment_type != 'echeck')
	    return;

	if ($payment_type == 'echeck' && $payment_status != 'Pending')
	    return;

    $myrows = $wpdb->get_results( "SELECT * FROM ".DEX_BCCF_TABLE_NAME." WHERE id=".intval($itemnumber) );
    $params = unserialize($myrows[0]->buffered_date);

    dex_process_ready_to_go_bccf(intval($_GET["itemnumber"]), $payer_email, $params);

    echo 'OK';

    exit();

}

function dex_process_ready_to_go_bccf($itemnumber, $payer_email = "", $params)
{
   global $wpdb;

   $myrows = $wpdb->get_results( "SELECT * FROM ".DEX_BCCF_TABLE_NAME." WHERE id=".intval($itemnumber) );

   $mycalendarrows = $wpdb->get_results( 'SELECT * FROM '.DEX_BCCF_CONFIG_TABLE_NAME .' WHERE `'.TDE_BCCFCONFIG_ID.'`='.$myrows[0]->calendar);

   if (!defined('CP_BCCF_CALENDAR_ID'))
        define ('CP_BCCF_CALENDAR_ID',$myrows[0]->calendar);

   $SYSTEM_EMAIL = dex_bccf_get_option('notification_from_email', DEX_BCCF_DEFAULT_PAYPAL_EMAIL);
   $SYSTEM_RCPT_EMAIL = dex_bccf_get_option('notification_destination_email', DEX_BCCF_DEFAULT_PAYPAL_EMAIL);


   $email_subject1 = __(dex_bccf_get_option('email_subject_confirmation_to_user', DEX_BCCF_DEFAULT_SUBJECT_CONFIRMATION_EMAIL),'bccf');
   $email_content1 = __(dex_bccf_get_option('email_confirmation_to_user', DEX_BCCF_DEFAULT_CONFIRMATION_EMAIL),'bccf');
   $email_subject2 = __(dex_bccf_get_option('email_subject_notification_to_admin', DEX_BCCF_DEFAULT_SUBJECT_NOTIFICATION_EMAIL),'bccf');
   $email_content2 = __(dex_bccf_get_option('email_notification_to_admin', DEX_BCCF_DEFAULT_NOTIFICATION_EMAIL),'bccf');

   $option_calendar_enabled = dex_bccf_get_option('calendar_enabled', DEX_BCCF_DEFAULT_CALENDAR_ENABLED);
   if ($option_calendar_enabled != 'false')
   {
       $information = "Item: ".$mycalendarrows[0]->uname."\n\n".
                      "Date From-To: ".$myrows[0]->booked_time_s." - ".$myrows[0]->booked_time_e."\n\n".
                      $myrows[0]->question;
   }
   else
   {
       $information = "Item: ".$mycalendarrows[0]->uname."\n\n".
                      $myrows[0]->question;
   }

   $email_content1 = str_replace("%INFORMATION%", $information, $email_content1);
   $email_content2 = str_replace("%INFORMATION%", $information, $email_content2);

   dex_bccf_add_field_verify(TDE_BCCFCALENDAR_DATA_TABLE, "color", "varchar(10)");

   $rows_affected = $wpdb->insert( TDE_BCCFCALENDAR_DATA_TABLE, array( 'reservation_calendar_id' => $myrows[0]->calendar,
                                                                       'datatime_s' => date("Y-m-d H:i:s", strtotime($myrows[0]->booked_time_unformatted_s)),
                                                                       'datatime_e' => date("Y-m-d H:i:s", strtotime($myrows[0]->booked_time_unformatted_e)),
                                                                       'title' => ($_POST[$to]?$_POST[$to]:"Booked"),
                                                                       'description' => str_replace("\n","<br />", $information),
                                                                       'color' => TDE_BCCFCALENDAR_DEFAULT_COLOR
                                                                        ) );
   $newitemnum = $wpdb->insert_id;
   $email_content1 = str_replace("<%itemnumber%>", $newitemnum, $email_content1);
   $email_content2 = str_replace("<%itemnumber%>", $newitemnum, $email_content2);

   $attachments = array();
   foreach ($params as $item => $value)
    {
        $email_content1 = str_replace('<%'.$item.'%>',(is_array($value)?(implode(", ",$value)):($value)),$email_content1);
        $email_content2 = str_replace('<%'.$item.'%>',(is_array($value)?(implode(", ",$value)):($value)),$email_content2);
        if (strpos($item,"_link"))
            $attachments[] = $value;
    }

   // SEND EMAIL TO USER
   $to = dex_bccf_get_option('cu_user_email_field', DEX_BCCF_DEFAULT_cu_user_email_field);
   $_POST[$to] = $myrows[0]->notifyto;
   if (trim($_POST[$to]) != '')
       wp_mail(trim($_POST[$to]), $email_subject1, $email_content1,
                "From: \"$SYSTEM_EMAIL\" <".$SYSTEM_EMAIL.">\r\n".
                "Content-Type: text/plain; charset=utf-8\n".
                "X-Mailer: PHP/" . phpversion());

   if ($payer_email && strtolower($payer_email) != strtolower($_POST[$to]))
       wp_mail($payer_email , $email_subject1, $email_content1,
                "From: \"$SYSTEM_EMAIL\" <".$SYSTEM_EMAIL.">\r\n".
                "Content-Type: text/plain; charset=utf-8\n".
                "X-Mailer: PHP/" . phpversion());


   // SEND EMAIL TO ADMIN
   if ($SYSTEM_RCPT_EMAIL != '')
       wp_mail($SYSTEM_RCPT_EMAIL, $email_subject2, $email_content2,
            "From: \"$SYSTEM_EMAIL\" <".$SYSTEM_EMAIL.">\r\n".
            "Content-Type: text/plain; charset=utf-8\n".
            "X-Mailer: PHP/" . phpversion(), $attachments);

}


function dex_bccf_add_field_verify ($table, $field, $type = "text")
{
    global $wpdb;
    $results = $wpdb->get_results("SHOW columns FROM `".$table."` where field='".$field."'");
    if (!count($results))
    {
        $sql = "ALTER TABLE  `".$table."` ADD `".$field."` ".$type;
        $wpdb->query($sql);
    }
}


function dex_bccf_save_options()
{
    global $wpdb;
    if (!defined('CP_BCCF_CALENDAR_ID'))
        define ('CP_BCCF_CALENDAR_ID',$_POST["dex_item"]);

    dex_bccf_add_field_verify(DEX_BCCF_CONFIG_TABLE_NAME, "calendar_minnights", "varchar(255) DEFAULT '0' NOT NULL");
    dex_bccf_add_field_verify(DEX_BCCF_CONFIG_TABLE_NAME, "calendar_maxnights", "varchar(255) DEFAULT '365' NOT NULL");
    dex_bccf_add_field_verify(DEX_BCCF_CONFIG_TABLE_NAME, "calendar_suplement", "varchar(255) DEFAULT '0' NOT NULL");
    dex_bccf_add_field_verify(DEX_BCCF_CONFIG_TABLE_NAME, "calendar_suplementminnight", "varchar(255) DEFAULT '0' NOT NULL");
    dex_bccf_add_field_verify(DEX_BCCF_CONFIG_TABLE_NAME, "calendar_suplementmaxnight", "varchar(255) DEFAULT '0' NOT NULL");
    
    dex_bccf_add_field_verify(DEX_BCCF_CONFIG_TABLE_NAME, "calendar_startres");
    dex_bccf_add_field_verify(DEX_BCCF_CONFIG_TABLE_NAME, "calendar_holidays");
    dex_bccf_add_field_verify(DEX_BCCF_CONFIG_TABLE_NAME, "calendar_fixedmode", "varchar(10) DEFAULT '0' NOT NULL");
    dex_bccf_add_field_verify(DEX_BCCF_CONFIG_TABLE_NAME, "calendar_holidaysdays", "varchar(20) DEFAULT '1111111' NOT NULL");
    dex_bccf_add_field_verify(DEX_BCCF_CONFIG_TABLE_NAME, "calendar_startresdays", "varchar(20) DEFAULT '1111111' NOT NULL");
    dex_bccf_add_field_verify(DEX_BCCF_CONFIG_TABLE_NAME, "calendar_fixedreslength", "varchar(20) DEFAULT '1' NOT NULL");
    
    dex_bccf_add_field_verify(DEX_BCCF_CONFIG_TABLE_NAME, "max_slots", "varchar(20) DEFAULT '0' NOT NULL");    
    dex_bccf_add_field_verify(DEX_BCCF_CONFIG_TABLE_NAME, "enable_paypal_option_yes", "varchar(250) DEFAULT '' NOT NULL");  
    dex_bccf_add_field_verify(DEX_BCCF_CONFIG_TABLE_NAME, "enable_paypal_option_no", "varchar(250) DEFAULT '' NOT NULL");  
    
    dex_bccf_add_field_verify(DEX_BCCF_CONFIG_TABLE_NAME, "vs_text_submitbtn", "varchar(250) DEFAULT '' NOT NULL");  
    dex_bccf_add_field_verify(DEX_BCCF_CONFIG_TABLE_NAME, "vs_text_previousbtn", "varchar(250) DEFAULT '' NOT NULL");  
    dex_bccf_add_field_verify(DEX_BCCF_CONFIG_TABLE_NAME, "vs_text_nextbtn", "varchar(250) DEFAULT '' NOT NULL");  
    
    dex_bccf_add_field_verify(DEX_BCCF_CONFIG_TABLE_NAME, "calendar_depositenable", "varchar(20) DEFAULT '' NOT NULL");
    dex_bccf_add_field_verify(DEX_BCCF_CONFIG_TABLE_NAME, "calendar_depositamount", "varchar(20) DEFAULT '' NOT NULL");
    dex_bccf_add_field_verify(DEX_BCCF_CONFIG_TABLE_NAME, "calendar_deposittype", "varchar(20) DEFAULT '' NOT NULL"); 
    dex_bccf_add_field_verify(DEX_BCCF_CONFIG_TABLE_NAME, "calendar_showcost", "varchar(1) DEFAULT '' NOT NULL");
    
    dex_bccf_add_field_verify(DEX_BCCF_CONFIG_TABLE_NAME,'request_taxes'," varchar(20) NOT NULL default ''");    
    
    $calendar_holidaysdays = (@$_POST["wd1"]?"1":"0").(@$_POST["wd2"]?"1":"0").(@$_POST["wd3"]?"1":"0").(@$_POST["wd4"]?"1":"0").(@$_POST["wd5"]?"1":"0").(@$_POST["wd6"]?"1":"0").(@$_POST["wd7"]?"1":"0");
    $calendar_startresdays = (@$_POST["sd1"]?"1":"0").(@$_POST["sd2"]?"1":"0").(@$_POST["sd3"]?"1":"0").(@$_POST["sd4"]?"1":"0").(@$_POST["sd5"]?"1":"0").(@$_POST["sd6"]?"1":"0").(@$_POST["sd7"]?"1":"0");    

    for ($k=1;$k<=DEX_BCCF_DEFAULT_SERVICES_FIELDS; $k++)
    {
        dex_bccf_add_field_verify(DEX_BCCF_CONFIG_TABLE_NAME, "cp_cal_checkboxes_label".$k);
        dex_bccf_add_field_verify(DEX_BCCF_CONFIG_TABLE_NAME, "cp_cal_checkboxes_type".$k);
        dex_bccf_add_field_verify(DEX_BCCF_CONFIG_TABLE_NAME, "cp_cal_checkboxes".$k);
    }

    foreach ($_POST as $item => $value)
        $_POST[$item] = stripcslashes($value);

    for ($k=1;$k <= intval($_POST["max_slots"]); $k++)
        $_POST["request_cost"] .= ";".$_POST["request_cost_".$k];


    $data = array(
         'calendar_language' => $_POST["calendar_language"],
         'calendar_dateformat' => $_POST["calendar_dateformat"],
         'calendar_overlapped' => $_POST["calendar_overlapped"],
         'calendar_enabled' => $_POST["calendar_enabled"],
         'calendar_mode' => $_POST["calendar_mode"],
         'calendar_pages' => (isset($_POST["calendar_pages"])?$_POST["calendar_pages"]:1),
         'calendar_weekday' => $_POST["calendar_weekday"],
         'calendar_mindate' => $_POST["calendar_mindate"],
         'calendar_maxdate' => $_POST["calendar_maxdate"],

         'calendar_minnights' => @$_POST["calendar_minnights"],
         'calendar_maxnights' => @$_POST["calendar_maxnights"],
         'calendar_suplement' => @$_POST["calendar_suplement"],
         'calendar_suplementminnight' => @$_POST["calendar_suplementminnight"],
         'calendar_suplementmaxnight' => @$_POST["calendar_suplementmaxnight"],
         'calendar_fixedmode' => (@$_POST["calendar_fixedmode"]?"1":"0"),         
         'calendar_holidaysdays' => $calendar_holidaysdays,
         'calendar_startresdays' => $calendar_startresdays,
         'calendar_fixedreslength' => @$_POST["calendar_fixedreslength"],
         
         'calendar_startres' => @$_POST["calendar_startres"],
         'calendar_holidays' => @$_POST["calendar_holidays"],
         'calendar_showcost' => $_POST["calendar_showcost"],

         'cu_user_email_field' => $_POST['cu_user_email_field'],

         'enable_paypal' => @$_POST["enable_paypal"],
         'paypal_email' => $_POST["paypal_email"],
         'request_cost' => $_POST["request_cost"],
         'max_slots' => @$_POST["max_slots"],
         'paypal_product_name' => $_POST["paypal_product_name"],
         'currency' => $_POST["currency"],
         'url_ok' => $_POST["url_ok"],
         'url_cancel' => $_POST["url_cancel"],
         'paypal_language' => $_POST["paypal_language"],
         'request_taxes' => $_POST["request_taxes"],

         'notification_from_email' => $_POST["notification_from_email"],
         'notification_destination_email' => $_POST["notification_destination_email"],
         'email_subject_confirmation_to_user' => $_POST["email_subject_confirmation_to_user"],
         'email_confirmation_to_user' => $_POST["email_confirmation_to_user"],
         'email_subject_notification_to_admin' => $_POST["email_subject_notification_to_admin"],
         'email_notification_to_admin' => $_POST["email_notification_to_admin"],

         'enable_paypal_option_yes' => (@$_POST['enable_paypal_option_yes']?$_POST['enable_paypal_option_yes']:DEX_BCCF_DEFAULT_PAYPAL_OPTION_YES),
         'enable_paypal_option_no' => (@$_POST['enable_paypal_option_no']?$_POST['enable_paypal_option_no']:DEX_BCCF_DEFAULT_PAYPAL_OPTION_NO),

         //'vs_use_validation' => $_POST['vs_use_validation'],
         'vs_text_is_required' => $_POST['vs_text_is_required'],
         'vs_text_is_email' => $_POST['vs_text_is_email'],
         'vs_text_datemmddyyyy' => $_POST['vs_text_datemmddyyyy'],
         'vs_text_dateddmmyyyy' => $_POST['vs_text_dateddmmyyyy'],
         'vs_text_number' => $_POST['vs_text_number'],
         'vs_text_digits' => $_POST['vs_text_digits'],
         'vs_text_max' => $_POST['vs_text_max'],
         'vs_text_min' => $_POST['vs_text_min'],

         'vs_text_submitbtn' => $_POST['vs_text_submitbtn'],
         'vs_text_previousbtn' => $_POST['vs_text_previousbtn'],
         'vs_text_nextbtn' => $_POST['vs_text_nextbtn'],

         'calendar_depositenable' => $_POST['calendar_depositenable'],
         'calendar_depositamount' => $_POST['calendar_depositamount'],
         'calendar_deposittype' => $_POST['calendar_deposittype'],
                           
         'dexcv_enable_captcha' => $_POST["dexcv_enable_captcha"],
         'dexcv_width' => $_POST["dexcv_width"],
         'dexcv_height' => $_POST["dexcv_height"],
         'dexcv_chars' => $_POST["dexcv_chars"],
         'dexcv_min_font_size' => $_POST["dexcv_min_font_size"],
         'dexcv_max_font_size' => $_POST["dexcv_max_font_size"],
         'dexcv_noise' => $_POST["dexcv_noise"],
         'dexcv_noise_length' => $_POST["dexcv_noise_length"],
         'dexcv_background' => $_POST["dexcv_background"],
         'dexcv_border' => $_POST["dexcv_border"],
         'dexcv_font' => $_POST["dexcv_font"],
         'cv_text_enter_valid_captcha' => $_POST['cv_text_enter_valid_captcha'],

         'cp_cal_checkboxes' => @$_POST["cp_cal_checkboxes"],
         'cp_cal_checkboxes_type' => @$_POST["cp_cal_checkboxes_type"]
	);

    $wpdb->update ( DEX_BCCF_CONFIG_TABLE_NAME, $data, array( 'id' => CP_BCCF_CALENDAR_ID ));
}


add_action( 'init', 'dex_bccf_calendar_ajaxevent', 11 );

function dex_bccf_calendar_ajaxevent() {
    if ( ! isset( $_GET['dex_bccf_calendar_load2'] ))
		return;

	//@ob_clean();
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Pragma: no-cache");

    $ret = array();
    $ret['events'] = array();
    $ret['isSuccess'] = true;
    $ret['msg'] = "";

    switch ($_GET['dex_bccf_calendar_load2']) {
        case 'list':
            $ret = dex_bccf_calendar_load2($ret);
            break;
        case 'add':
            if ( ! current_user_can('edit_pages') )
            {
                $ret['isSuccess'] = false;
                $ret['msg'] = "Permissions error: No enough privilegies to add an item.";
            }
            else
                $ret = dex_bccf_calendar_add($ret);
            break;
        case 'edit':
            if ( ! current_user_can('edit_pages') )
            {
                $ret['isSuccess'] = false;
                $ret['msg'] = "Permissions error: No enough privilegies to edit an item.";
            }
            else
                $ret = dex_bccf_calendar_update($ret);
            break;
        case 'delete':
            if ( ! current_user_can('edit_pages') )
            {
                $ret['isSuccess'] = false;
                $ret['msg'] = "Permissions error: No enough privilegies to delete an item.";
            }
            else
                $ret = dex_bccf_calendar_delete($ret);
            break;
        default:
          $ret['isSuccess'] = false;
          $ret['msg'] = "Unknown calendar action: ".$_GET['dex_bccf_calendar_load2'];
    }

    echo json_encode($ret);
    exit();
}

function dex_bccf_calendar_load2($ret) {
    global $wpdb;

    $calid = str_replace  (TDE_BCCFCAL_PREFIX, "",@$_GET["id"]);
    if (!defined('CP_BCCF_CALENDAR_ID') && $calid != '-1')
        define ('CP_BCCF_CALENDAR_ID',$calid);

    $option = dex_bccf_get_option('calendar_overlapped', DEX_BCCF_DEFAULT_CALENDAR_OVERLAPPED);

    if ($calid == '-1')
        $query = "SELECT * FROM ".TDE_BCCFCALENDAR_DATA_TABLE." where (1=1)";
    else
        $query = "SELECT * FROM ".TDE_BCCFCALENDAR_DATA_TABLE." where ".TDE_BCCFDATA_IDCALENDAR."='".esc_sql($calid)."'";
    if ($option == 'true')
        $query.= " AND viadmin='1'";
    
    $result = $wpdb->get_results($query, ARRAY_A);
    foreach ($result as $row)
    {
        if (@$row["color"] == '')
            $row["color"] = TDE_BCCFCALENDAR_DEFAULT_COLOR;
        $ret['events'][] = array(
                                  "id"=>$row["id"],
                                  "dl"=>date("m/d/Y", strtotime($row["datatime_s"])),
                                  "du"=>date("m/d/Y", strtotime($row["datatime_e"])),
                                  "title"=>$row["title"],
                                  "description"=>$row["description"],
                                  "c"=>@$row["color"]    // falta annadir este campo
                                );
    }    
    
    return $ret;
}


function dex_bccf_calendar_add($ret) {
    global $wpdb;

    $calid = str_replace  (TDE_BCCFCAL_PREFIX, "",@$_GET["id"]);
    if (!defined('CP_BCCF_CALENDAR_ID'))
        define ('CP_BCCF_CALENDAR_ID',$calid);

    dex_bccf_add_field_verify(TDE_BCCFCALENDAR_DATA_TABLE, "viadmin", "varchar(10) DEFAULT '0' NOT NULL");
    dex_bccf_add_field_verify(TDE_BCCFCALENDAR_DATA_TABLE, "color", "varchar(10)");

    $wpdb->query("insert into ".TDE_BCCFCALENDAR_DATA_TABLE."(viadmin,reservation_calendar_id,datatime_s,datatime_e,title,description,color) ".
                " values(1,".intval($calid).",'".esc_sql($_POST["startdate"])."','".esc_sql($_POST["enddate"])."','".esc_sql($_POST["title"])."','".esc_sql($_POST["description"])."','".esc_sql($_POST["color"])."')");
    $ret['events'][0] = array("id"=>$wpdb->insert_id,"dl"=>date("m/d/Y", strtotime($_POST["startdate"])),"du"=>date("m/d/Y", strtotime($_POST["enddate"])),"title"=>$_POST["title"],"description"=>$_POST["description"],"c"=>$_POST["color"]);
    return $ret;
}

function dex_bccf_calendar_update($ret) {
    global $wpdb;

    dex_bccf_add_field_verify(TDE_BCCFCALENDAR_DATA_TABLE, "viadmin", "varchar(10) DEFAULT '0' NOT NULL");
    dex_bccf_add_field_verify(TDE_BCCFCALENDAR_DATA_TABLE, "color", "varchar(10)");

    $wpdb->query("update ".TDE_BCCFCALENDAR_DATA_TABLE." set title='".esc_sql($_POST["title"])."',description='".esc_sql($_POST["description"])."',color='".esc_sql($_POST["color"])."' where id=".intval($_POST["id"]) );
    return $ret;
}

function dex_bccf_calendar_delete($ret) {
    global $wpdb;
    $wpdb->query( "delete from ".TDE_BCCFCALENDAR_DATA_TABLE." where id=".intval($_POST["id"]) );
    return $ret;
}


function cp_bccf_get_site_url($admin = false)
{
    $blog = get_current_blog_id();
    if( $admin ) 
        $url = get_admin_url( $blog );	
    else 
        $url = get_home_url( $blog );	

    $url = parse_url($url);
    $url = rtrim(@$url["path"],"/");
    return $url;
}

function cp_bccf_get_FULL_site_url($admin = false)
{
    $blog = get_current_blog_id();
    if( $admin ) 
        $url = get_admin_url( $blog );	
    else 
        $url = get_home_url( $blog );	

    $url = parse_url($url);
    $url = rtrim($url["path"],"/");
    $pos = strpos($url, "://");
    if ($pos === false)
        $url = 'http://'.$_SERVER["HTTP_HOST"].$url;
    if (!empty($_SERVER['HTTPS']))     
        $url = str_replace("http://","https://",$url);        
    return $url;
}

function dex_bccf_cleanJSON($str)
{
    $str = str_replace('&qquot;','"',$str);
    $str = str_replace('	',' ',$str);
    $str = str_replace("\n",'\n',$str);
    $str = str_replace("\r",'',$str);
    return $str;
}

function dex_bccf_translate_json($str)
{
    $form_data = json_decode(dex_bccf_cleanJSON($str));          
    
    $form_data[1][0]->title = __($form_data[1][0]->title,'bccf');   
    $form_data[1][0]->description = __($form_data[1][0]->description,'bccf');   
    
    
    for ($i=0; $i < count($form_data[0]); $i++)    
    {
        $form_data[0][$i]->title = __($form_data[0][$i]->title,'bccf');   
        $form_data[0][$i]->userhelpTooltip = __($form_data[0][$i]->userhelpTooltip,'bccf'); 
        $form_data[0][$i]->userhelp = __($form_data[0][$i]->userhelp,'bccf'); 
        if ($form_data[0][$i]->ftype == 'fCommentArea')
            $form_data[0][$i]->userhelp = __($form_data[0][$i]->userhelp,'bccf');   
        else 
            if ($form_data[0][$i]->ftype == 'fradio' || $form_data[0][$i]->ftype == 'fcheck' || $form_data[0][$i]->ftype == 'fradio')    
            {
                for ($j=0; $j < count($form_data[0][$i]->choices); $j++)  
                    $form_data[0][$i]->choices[$j] = __($form_data[0][$i]->choices[$j],'bccf'); 
            }    
    }    
    $str = json_encode($form_data);
    return $str;
}

function dex_bccf_autodetect_language()
{
    $basename = '/js/languages/jquery.ui.datepicker-';
    
    $options = array (get_bloginfo('language'),
                      strtolower(get_bloginfo('language')),
                      substr(strtolower(get_bloginfo('language')),0,2)."-".substr(strtoupper(get_bloginfo('language')),strlen(strtoupper(get_bloginfo('language')))-2,2),
                      substr(strtolower(get_bloginfo('language')),0,2),
                      substr(strtolower(get_bloginfo('language')),strlen(strtolower(get_bloginfo('language')))-2,2)                      
                      );
    foreach ($options as $option)
    {
        if (file_exists(dirname( __FILE__ ).$basename.$option.'.js'))
            return $option;
        $option = str_replace ("-","_", $option);    
        if (file_exists(dirname( __FILE__ ).$basename.$option.'.js'))
            return $option;
    }  
    return '';
}


// dex_dex_bccf_get_option:
$dex_option_buffered_item = false;
$dex_option_buffered_id = -1;

function dex_bccf_get_option ($field, $default_value)
{
    global $wpdb, $dex_option_buffered_item, $dex_option_buffered_id;
    if (!defined("CP_BCCF_CALENDAR_ID"))
        return  $default_value;
    if ($dex_option_buffered_id == CP_BCCF_CALENDAR_ID)
        $value = @$dex_option_buffered_item->$field;
    else
    {
       $myrows = $wpdb->get_results( "SELECT * FROM ".DEX_BCCF_CONFIG_TABLE_NAME." WHERE id=".CP_BCCF_CALENDAR_ID );
       $value = @$myrows[0]->$field;
       $dex_option_buffered_item = $myrows[0];
       $dex_option_buffered_id  = CP_BCCF_CALENDAR_ID;
    }
    if ($value == '' && $dex_option_buffered_item->calendar_language == '')
        $value = $default_value;
    return $value;
}

function cp_bccf_is_administrator()
{
    return current_user_can('manage_options');
}




?>