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
    $wpdb->query('UPDATE `'.DEX_BCCF_CONFIG_TABLE_NAME.'` SET conwer='.$_GET["owner"].',`'.TDE_BCCFCALDELETED_FIELD.'`='.$_GET["public"].',`'.TDE_BCCFCONFIG_USER.'`="'.$_GET["name"].'" WHERE `'.TDE_BCCFCONFIG_ID.'`='.$_GET['u']);           
    $message = "Item updated";        
}


if ($message) echo "<div id='setting-error-settings_updated' class='updated settings-error'><p><strong>".$message."</strong></p></div>";

?>
<div class="wrap">
<h2>Booking Calendar Contact Form</h2>

<script type="text/javascript">
 function cp_addItem()
 {
    var calname = document.getElementById("cp_itemname").value;
    document.location = 'admin.php?page=dex_bccf&a=1&r='+Math.random()+'&name='+encodeURIComponent(calname);       
 }
 
 function cp_updateItem(id)
 {
    var calname = document.getElementById("calname_"+id).value;
    var owner = document.getElementById("calowner_"+id).options[document.getElementById("calowner_"+id).options.selectedIndex].value;    
    if (owner == '')
        owner = 0;
    var is_public = (document.getElementById("calpublic_"+id).checked?"0":"1");
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
 
</script>


<div id="normal-sortables" class="meta-box-sortables">


 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Calendar List / Items List</span></h3>
  <div class="inside">
  
  
  <table cellspacing="1"> 
   <tr>
    <th align="left">ID</th><th align="left">Item Name</th><th align="left">Owner</th><th align="left">Public</th><th align="left">&nbsp; &nbsp; Options</th><th align="left">Shorttag for Pages and Posts</th>
   </tr> 
<?php  

  $users = $wpdb->get_results( "SELECT user_login,ID FROM ".$wpdb->users." WHERE id=1 ORDER BY ID DESC" );                                                                     

  $myrows = $wpdb->get_results( "SELECT * FROM ".DEX_BCCF_CONFIG_TABLE_NAME );                                                                     
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
    
    <td nowrap align="center">
       <?php if (cp_bccf_is_administrator()) { ?> 
         &nbsp; &nbsp; <input type="checkbox" name="calpublic_<?php echo $item->id; ?>" id="calpublic_<?php echo $item->id; ?>" value="1" <?php if (!$item->caldeleted) echo " checked "; ?> />
       <?php } else { ?>  
         <?php if (!$item->caldeleted) echo "Yes"; else echo "No"; ?> 
       <?php } ?>   
    </td>    
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

  
</div> 


[<a href="http://wordpress.dwbooster.com/contact-us" target="_blank">Request Custom Modifications</a>] | [<a href="http://wordpress.dwbooster.com/calendars/booking-calendar-contact-form" target="_blank">Help</a>]
</form>
</div>














