<?php

/*
Plugin Name: Assetify DM Manager
Plugin URI: https://github.com/arif-ca-solutions/assetify-dm-helper
Description: Manage DM data for assetify.in.
Version: 1.0
Author: Arif
Author URI: https://in.linkedin.com/in/arif-ca-59840847
Copyright: © 2022 Aassetify.in. All rights reserved.
*/

/**
 * The API baseurl
 * 
 * @author Arif <caarif123@gmail.com>
 * 
 * @reutrn assetify api base url
*/
function assetyUrl() {
	return 'https://testsite.com/api/';
}

/**
 * Admin menu item
 * 
 * @author Arif <caarif123@gmail.com>
 * 
 * @reutrn null
*/
function dmOptiosLeftMenu() {
    add_menu_page( 
        __( 'Assetify Pages', 'Page manager' ),
        'Page manager',
        'manage_options',
        'assetify-pages',
        'assetfyDmPages',
        plugins_url( 'assetify-dm-helper/assets/images/assetify.png' ),
        6
    ); 
}
add_action( 'admin_menu', 'dmOptiosLeftMenu' );

/**
 * Add scripts and CSS
 * 
 * @author Arif <caarif123@gmail.com>
 * 
 * @reutrn null
*/
function enqueueAssets() {
	// The css
	wp_enqueue_style( 'dataTableCss', 'https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css');
	wp_enqueue_style( 'bStrapCss', 'https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css');
	wp_enqueue_style( 'dmCss', plugins_url( 'assetify-dm-helper/assets/css/style.css' ));

	// The scripts
	wp_enqueue_script( 'jQuerySlim', 'https://code.jquery.com/jquery-3.5.1.min.js' );
	wp_enqueue_script( 'popperJs', 'https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js' );
	wp_enqueue_script( 'bStrapJs', 'https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js' );
	wp_enqueue_script( 'dataTableJs', 'https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js' );
    wp_enqueue_script( 'sweetAlertJs', 'https://unpkg.com/sweetalert/dist/sweetalert.min.js' );
}

/**
 * The options page layout
 * 
 * @author Arif <caarif123@gmail.com>
 * 
 * @reutrn null
*/
function assetfyDmPages() {
	// Register the update endpoint for Ajax
	enqueueAssets();
	$savedPages = getAssetifyPages();
	include(plugin_dir_path( __FILE__ ).'templates/list.php');
}

/**
 * Collect the DM pages added on assetify and return
 * 
 * @author Arif <caarif123@gmail.com>
 * 
 * @reutrn Array response data from assetify
*/
function getAssetifyPages() {
	$response = wp_remote_get( assetyUrl().'dm-pages' );
	return json_decode($response['body']);
}

// Register the endpoint for Ajax
add_action( 'wp_ajax_dm_create_page', 'dm_create_page' );
add_action( 'wp_ajax_dm_save_page', 'dm_save_page' );
add_action( 'wp_ajax_dm_delete_page', 'dm_delete_page' );

/**
 * Will call the update API to save SEO data
 * 
 * @author Arif <caarif123@gmail.com>
 * 
 * @reutrn Array response data from assetify
*/
function dm_create_page() {
	$data = $_POST;
	$response = wp_remote_post( assetyUrl().'dm-pages/store', ['body'=>$data]);
	echo $response['body'];
	exit;
}

/**
 * Will call the update API to save SEO data
 * 
 * @author Arif <caarif123@gmail.com>
 * 
 * @reutrn Array response data from assetify
*/
function dm_save_page() {
    $data = $_POST;
    $itemId = $data['id'];
    unset($data['id']);
    $response = wp_remote_post( assetyUrl().'dm-pages/update/'.$itemId, ['body'=>$data]);
    echo $response['body'];
    exit;
}

/**
 * Will call the delete API
 * 
 * @author Arif <caarif123@gmail.com>
 * 
 * @reutrn Array response data from assetify
*/
function dm_delete_page() {
    $data = $_POST;
    $itemId = $data['id'];
    unset($data['id']);
    $response = wp_remote_post( assetyUrl().'dm-pages/delete/'.$itemId);
    echo $response['body'];
    exit;
}
