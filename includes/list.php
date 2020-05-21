<?php
global $wpdb,$woocommerce;
$exiting =  $wpdb->prefix ."users"; 
$result = $wpdb->get_results("SELECT * FROM $exiting ORDER by id DESC");
if(isset($_POST['DataTables_Table_0_length'])){
    foreach($result as $re=>$recVal){
		update_user_meta( $recVal->ID, 'hide_notification_user', sanitize_text_field( 'no' ) );
	}
}
if(isset($_POST['selectCheckbox'])){
	foreach($_POST['selectCheckbox'] as $key=>$valu){
		update_user_meta( $valu, 'hide_notification_user', sanitize_text_field( 'yes' ) );
	}
}
if(isset($_POST['DataTables_Table_0_length'])){
    echo "<h3><span style='color:green;'>Updated Successfully</span></h3>";
}
?>
<script src="../wp-content/plugins/hide-user-notification/js/jquery-3.3.1.js" type="text/javascript" /></script>
<script src="../wp-content/plugins/hide-user-notification/js/dataTables.min.js" type="text/javascript" /></script>
<link rel='stylesheet'  href="../wp-content/plugins/hide-user-notification/css/datatable.css" />    

<h2>Select User to Show Notification</h2>
<style>
.dataTables_length{
	display:none !important;
}

</style>
<form name="hideForm" id="hideForm" action="" method="POST">

<table class="wp-list-table">
	<thead>
	<tr>
	<th style="max-width:20px !important;">&nbsp;#</th>
	<th style="text-align:left;">Username</th>
	<th style="text-align:left;">Name</th>
	<th style="text-align:left;">Email</th>
	</tr>
	</thead>
	<tbody>
	<?php 
	
	foreach($result as $key=>$val){
		$value=get_user_meta($val->ID,'hide_notification_user');
		$uID='';
		if(isset($value[0]) && $value[0]=="yes"){
			$uID=$val->ID;
		}
	?>
		<tr>
			<td><input type="checkbox" <?php if($uID==$val->ID){ echo 'checked="checked"';} ?> value="<?php echo $val->ID; ?>" name="selectCheckbox[]" /></td>
			<td><?php echo ucfirst($val->user_login);?></td>
			<td><?php echo ucfirst($val->display_name);?></td>
			<td><?php echo ucfirst($val->user_email);?></td>
		</tr>
	<?php } ?>
	</tbody>
	
</table>
<button style="background-color:green;" class="btn button-primary">Show HIde Notification</button>
</form>
<script>

jQuery(document).ready(function() {
	jQuery('.wp-list-table').DataTable({
	  "pageLength": 100
	});
});
</script>
