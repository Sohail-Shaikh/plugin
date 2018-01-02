<?php
/*
  Plugin Name: Manage_list
  Description: Management system to manage the user detail like add user, Delete user, Update User Information.
  Version: 1.0
  Author: Sohail Shaikh
  License: GPLv2+
  Text Domain: WP_manage_list
*/

class WP_manage_list{
    function __construct() {	
        add_action('admin_menu',array($this,'wpa_add_menu'));
        register_activation_hook(__FILE__,array($this,'wpa_install'));
        register_deactivation_hook(__FILE__,array($this,'wpa_uninstall'));
    }
    /*
      * Actions perform at loading of admin menu
      */
    public static function wpa_add_menu() {
        add_menu_page('Main Menu','Home','manage_options','Sub-menu');
        add_submenu_page('Sub-menu','User List','User List','manage_options','menu-list',array( __CLASS__,'wpa_page_file_path'));
        add_submenu_page('Sub-menu','Add User','Add User','manage_options','menu-add',array(__CLASS__,'wpa_page_file_path'));
    }
    /*
     * Actions perform on loading of menu pages
     */
    public static function wpa_page_file_path()
    {
    	$screen = get_current_screen();
    	if (strpos($screen->base,'menu-add' )!==false) 
        {
            require_once plugin_dir_path(__FILE__) . 'php/user_register.php';   
        }
        elseif(strpos($screen->base,'menu-list')!==false) {
            require_once plugin_dir_path(__FILE__) . 'php/user_lists.php';
        }
        elseif(strpos($screen->base,'menu-map')!==false) {
            require_once plugin_dir_path(__FILE__) . 'php/map.php';
        }
        else
        {
        	//echo 'error';
        	return false;
        }

        wp_enqueue_media();
        wp_register_script( 'media-lib-uploader-js', plugins_url( 'media-lib-uploader.js' , __FILE__ ), array('jquery') );
        wp_enqueue_script( 'media-lib-uploader-js' );
        wp_enqueue_script('js_jquery', plugin_dir_url( __FILE__ ) . 'JS/jquery-1.12.4.js',array('jquery'));
        wp_enqueue_style( 'jquery_ui_css', plugin_dir_url( __FILE__ ). 'css/jquery-ui.css');
        wp_enqueue_script('js_validator', plugin_dir_url( __FILE__ ) . 'JS/jquery.validate.js',array('jquery'));
        wp_enqueue_script('ui', plugin_dir_url( __FILE__ ) . 'JS/jquery-ui.js', array('jquery'));
        wp_enqueue_script('own_file', plugin_dir_url( __FILE__ ) . 'JS/ajax.js',array('jquery'));
        wp_register_script( 'script_file', plugin_dir_url( __FILE__ ) . 'JS/ajax.js', array('jquery'), null,'' );
        wp_localize_script( 'script_file', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php')));
        
    }
    /*
     * Actions perform on activation of plugin
     */
    
    public static function wpa_install() {
    	global $wpdb;
    	$charset_collate = $wpdb->get_charset_collate();
   		$table = $wpdb->prefix.'manage_list'; 
		$sql = "CREATE TABLE  $table(
				list_id int(10),
				FirstName varchar(55),
				LastName varchar(55),
				user_gender varchar(10),
				user_no int(10),
				user_city varchar(55),
			    user_dob varchar(55),
				user_email varchar(55),
				user_mobile_no varchar(55),
				user_img varchar(55),
				user_lang varchar(55)
	    		)$charset_collate;";
		require_once(ABSPATH.'wp-admin/includes/upgrade.php');
		$wpdb->query($sql);
    }
    /*
     * Actions perform on de-activation of plugin
     */
    function wpa_uninstall() {  	
    }

    public function WP_Update()
    {
    	require_once plugin_dir_path(__FILE__) . 'php/user_register.php';
        if(isset($_POST['update-form']))
        {
            $a=implode(',',$_POST['user_lang']);
            $language=array("user_lang"=>"$a");
            $insert_var=array_merge($_POST,$language);
            unset($insert_var['update-form']);
            global $wpdb;
            $table = $wpdb->prefix.'manage_list';
            $where=array("user_no"=>$insert_var['user_no']);
            $insert=$wpdb->update($table,$insert_var,$where);
            if($insert)
            {
                echo"<script>alert('data is updated');</script>";
            }
            else
            {
                echo"error";
            }

        }
    }
   
}
$object1=new WP_manage_list();
add_action( 'wp_default_scripts', function( $scripts ) {
if ( ! empty( $scripts->registered['jquery'] ) ) {
$jquery_dependencies = $scripts->registered['jquery']->deps;
$scripts->registered['jquery']->deps = array_diff( $jquery_dependencies, array( 'jquery-migrate' ) );
}
} );
function delete_ajax_request() {
 
    // The $_REQUEST contains all the data sent via ajax
    if ( isset($_REQUEST) ) {
        // print_r($_REQUEST);
        if(isset($_POST['info']['id']))
        {
            global $wpdb;
            $delete = $wpdb->query("DELETE from wp_manage_list WHERE user_no=".$_POST['info']['id']."");
            echo "The user data has been deleted from the list Successfully";
        }
     
    }
     
    // Always die in functions echoing ajax content
   die();
}
add_action( 'wp_ajax_delete_ajax_request','delete_ajax_request' );
// 

add_action('wp_ajax_insert_ajax_request', 'insert_ajax_request');

function insert_ajax_request() {
 
    if (isset($_POST['submit-form'])) {
       $a=implode(',',$_POST['user_lang']);
        $language=array("user_lang"=>"$a");
        $insert_var=array_merge($_POST,$language);
        unset($insert_var['submit-form']);
        unset($insert_var['action']);
        // print_r($insert_var);
        global $wpdb;
        $table = $wpdb->prefix.'manage_list';
        $insert=$wpdb->insert($table,$insert_var);
        echo "The user data is Added to the List Successfully";
    }
    wp_die();
}

add_action('wp_ajax_update_ajax_request', 'update_ajax_request');
function update_ajax_request() {
 
    if (isset($_POST['update-form'])) {
       if($_POST['user_img']=='')
        {
            $_POST['user_img']= $record['user_img'];
        }
        $a=implode(',',$_POST['user_lang']);
        $language=array("user_lang"=>"$a");
        $insert_var=array_merge($_POST,$language);
        unset($insert_var['update-form']);
        unset($insert_var['action']);
        // print_r($insert_var);
        global $wpdb;
        $table = $wpdb->prefix.'manage_list';
        $where=array("user_no"=>$insert_var['user_no']);
        $insert=$wpdb->update($table,$insert_var,$where);
        echo"The User Data Successfully Updated!";
    }
    wp_die();
}


