<?php
/*
Templates For: Add/Edit currency value on admin side
Version: 1.0.0
Author: Arif
*/

/* --- Static initializer for Wordpress hooks --- */

global $wpdb;
$field_id = $_POST['fieldId'];
$field_value = $_POST['fieldValue'];
if(isset($field_id) && $field_id != '' & isset($field_value) && $field_value != '')
{
	$update_data =array( 'field_value' => $field_value);
		//print_r($insert_data);
	echo $wpdb->prefix."cfe_fileds";
		//$wpdb->update( $wpdb->prefix."cfe_fileds", $update_data, array('id'=>$field_id));
		echo 'success';
}
else echo 'error';
?>
