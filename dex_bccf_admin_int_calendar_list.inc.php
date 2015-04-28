<?php

if ( !is_admin() ) 
{
    echo 'Direct access not allowed.';
    exit;
}

$current_user = wp_get_current_user();

global $wpdb;
$message = "";
if (isset($_GET['u']) && $_GET['u'] != '')
{
    $wpdb->query('UPDATE `'.DEX_BCCF_CONFIG_TABLE_NAME.'` SET conwer='.intval($_GET["owner"]).',`'.TDE_BCCFCALDELETED_FIELD.'`='.intval($_GET["public"]).',`'.TDE_BCCFCONFIG_USER.'`="'.$_GET["name"].'" WHERE `'.TDE_BCCFCONFIG_ID.'`='.intval($_GET['u']));           
    $message = "Item updated";        
}
else if (isset($_GET['ac']) && $_GET['ac'] == 'st')
{   
    update_option( 'CP_BCCF_LOAD_SCRIPTS', ($_GET["scr"]=="1"?"0":"1") );   
    if ($_GET["chs"] != '')
    {
        $target_charset = esc_sql($_GET["chs"]);
        $tables = array( $wpdb->prefix.DEX_BCCF_TABLE_NAME_NO_PREFIX, $wpdb->prefix.DEX_BCCF_CALENDARS_TABLE_NAME_NO_PREFIX, $wpdb->prefix.DEX_BCCF_CONFIG_TABLE_NAME_NO_PREFIX );                
        foreach ($tables as $tab)
        {  
            $myrows = $wpdb->get_results( "DESCRIBE {$tab}" );                                                                                 
            foreach ($myrows as $item)
	        {
	            $name = $item->Field;
		        $type = $item->Type;
		        if (preg_match("/^varchar\((\d+)\)$/i", $type, $mat) || !strcasecmp($type, "CHAR") || !strcasecmp($type, "TEXT") || !strcasecmp($type, "MEDIUMTEXT"))
		        {
	                $wpdb->query("ALTER TABLE {$tab} CHANGE {$name} {$name} {$type} COLLATE {$target_charset}");	            
	            }
	        }
        }
    }
    $message = "Troubleshoot settings updated";
}


if ($message) echo "<div id='setting-error-settings_updated' class='updated settings-error'><p><strong>".$message."</strong></p></div>";

?>
<div class="wrap">
<h2>Booking Calendar Contact Form</h2>

<script type="text/javascript">
 
 function cp_updateItem(id)
 {
    var calname = document.getElementById("calname_"+id).value;
    var owner = document.getElementById("calowner_"+id).options[document.getElementById("calowner_"+id).options.selectedIndex].value;    
    if (owner == '')
        owner = 0;
    var is_public = "1";
    document.location = 'admin.php?page=dex_bccf&u='+id+'&r='+Math.random()+'&public='+is_public+'&owner='+owner+'&name='+encodeURIComponent(calname);    
 }
 
 function cp_manageSettings(id)
 {
    document.location = 'admin.php?page=dex_bccf&cal='+id+'&r='+Math.random();
 }
 
 function cp_BookingsList(id)
 {
    document.location = 'admin.php?page=dex_bccf&cal='+id+'&list=1&r='+Math.random();
 }
 
 function cp_updateConfig()
 {
    if (confirm('Are you sure that you want to update these settings?'))
    {        
        var scr = document.getElementById("ccscriptload").value;    
        var chs = document.getElementById("cccharsets").value;    
        document.location = 'admin.php?page=dex_bccf&ac=st&scr='+scr+'&chs='+chs+'&r='+Math.random();
    }    
 }
 
</script>


<div id="normal-sortables" class="meta-box-sortables">


 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Calendar List / Items List</span></h3>
  <div class="inside">
  
  
  <table cellspacing="1"> 
   <tr>
    <th align="left">ID</th><th align="left">Item Name</th><th align="left">Owner</th><th align="left">Feed</th><th align="left">&nbsp; &nbsp; Options</th><th align="left">Shorttag for Pages and Posts</th>    
   </tr> 
<?php  

  $users = $wpdb->get_results( "SELECT user_login,ID FROM ".$wpdb->users." ORDER BY ID DESC" );                                                                     

  $myrows = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix ."bccf_reservation_calendars" );                                                                     
  foreach ($myrows as $item)   
      if (cp_bccf_is_administrator() || ($current_user->ID == $item->conwer))
      {
?>
   <tr> 
    <td nowrap><?php echo $item->id; ?></td>
    <td nowrap><input type="text" style="width:100px;" <?php if (!cp_bccf_is_administrator()) echo ' readonly '; ?>name="calname_<?php echo $item->id; ?>" id="calname_<?php echo $item->id; ?>" value="<?php echo esc_attr($item->uname); ?>" /></td>
    
    <?php if (cp_bccf_is_administrator()) { ?>
    <td nowrap>
      <select name="calowner_<?php echo $item->id; ?>" id="calowner_<?php echo $item->id; ?>">
       <option value="0"<?php if (!$item->conwer) echo ' selected'; ?>></option>
       <?php foreach ($users as $user) { 
       ?>
          <option value="<?php echo $user->ID; ?>"<?php if ($user->ID."" == $item->conwer) echo ' selected'; ?>><?php echo $user->user_login; ?></option>
       <?php  } ?>
      </select>
    </td>    
    <?php } else { ?>
        <td nowrap>
        <?php echo $current_user->user_login; ?>
        </td>
    <?php } ?>
    
    <input type="hidden" name="calpublic_<?php echo $item->id; ?>" id="calpublic_<?php echo $item->id; ?>" value="1" />
    
    <td nowrap><a href="javascript:alert('iCal feed available only in pro version.');">iCal</a></td>
    <td nowrap>&nbsp; &nbsp; 
                             <?php if (cp_bccf_is_administrator()) { ?> 
                               <input type="button" name="calupdate_<?php echo $item->id; ?>" value="Update" onclick="cp_updateItem(<?php echo $item->id; ?>);" /> &nbsp; 
                             <?php } ?>    
                             <input type="button" name="calmanage_<?php echo $item->id; ?>" value="Settings " onclick="cp_manageSettings(<?php echo $item->id; ?>);" /> &nbsp; 
                             <input type="button" name="calbookings_<?php echo $item->id; ?>" value="Bookings / Contacts" onclick="cp_BookingsList(<?php echo $item->id; ?>);" /> &nbsp; 
    </td>
    <td style="font-size:11px;" nowrap>[CP_BCCF_FORM calendar="<?php echo $item->id; ?>"]</td> 
   </tr>
<?php  
      } 
?>   
     
  </table> 
    
    
   
  </div>    
 </div> 
 
<?php if (cp_bccf_is_administrator()) { ?> 
 
 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>New Calendar / Item</span></h3>
  <div class="inside"> 
   
    This version supports one calendar. For a version that supports unlimited calendars upgrade to the <a href="http://wordpress.dwbooster.com/calendars/booking-calendar-contact-form#download">pro version</a>.

  </div>    
 </div>
 

 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Troubleshoot Area</span></h3>
  <div class="inside"> 
    <p><strong>Important!</strong>: Use this area <strong>only</strong> if you are experiencing conflicts with third party plugins, with the theme scripts or with the character encoding.</p>
    <form name="updatesettings">
      Script load method:<br />
       <select id="ccscriptload" name="ccscriptload">
        <option value="0" <?php if (get_option('CP_BCCF_LOAD_SCRIPTS',"1") == "1") echo 'selected'; ?>>Classic (Recommended)</option>
        <option value="1" <?php if (get_option('CP_BCCF_LOAD_SCRIPTS',"1") != "1") echo 'selected'; ?>>Direct</option>
       </select><br />
       <em>* Change the script load method if the form doesn't appear in the public website.</em>
      
      <br /><br />
      Character encoding:<br />
       <select id="cccharsets" name="cccharsets">
        <option value="">Keep current charset (Recommended)</option>
        <option value="utf8_general_ci">UTF-8 (try this first)</option>
        <option value="latin1_swedish_ci">latin1_swedish_ci</option>
       </select><br />
       <em>* Update the charset if you are getting problems displaying special/non-latin characters. After updated you need to edit the special characters again.</em>
       <br />
       <input type="button" onclick="cp_updateConfig();" name="gobtn" value="UPDATE" />
      <br /><br />      
    </form>

  </div>    
 </div> 

<?php } ?> 



  
</div> 


[<a href="http://wordpress.dwbooster.com/support" target="_blank">Request Custom Modifications</a>] | [<a href="http://wordpress.dwbooster.com/calendars/booking-calendar-contact-form" target="_blank">Help</a>]
</form>
</div>














