<?php
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class My_List extends WP_List_Table
{
	public $list;
	public $myrows;
	public $row;
	public $old_row;
	function __construct()
	{
		$this->list ='';
		$this->myrows='';
		$this->row='';
		$this->old_row='';
		parent::__construct();
		//$this->user_list();
	}

	public function display_Old_Data($data)
	{
		global $wpdb;
		$this->old_row = $wpdb->get_results("select * from wp_manage_list where user_no='$data';",ARRAY_A);
		// print_r($this->old_row);
		return $this->old_row;
	}
	public function user_list()
	{
		global $wpdb;
		$this->list.="<div class='wrap'>".
  		"<h2>Management List</h2>".
		"<table class='widefat' class='form-table' id='sortable'>".
		"<thead >".
		"<tr>".
		"<th class='manage-column column-columnname' scope='col' >"."<strong>user no</strong>"."</th>".
		"<th class='manage-column column-columnname' scope='col'>"."<strong>FirstName</strong>"."</th>".
		"<th class='manage-column column-columnname' scope='col'>"."<strong>LastName</strong>". "</th>".
		"<th class='manage-column column-columnname' scope='col'>"."<strong>User Profile</strong>". "</th>".
		"<th class='manage-column column-columnname' scope='col'>"."<strong>Action</strong>". "</th>".    
		"</tr>".
		"</thead>";
		$this->myrows = $wpdb->get_results( "select user_no,FirstName,LastName,user_img from wp_manage_list",ARRAY_A);
		//print_r($this->myrows);
		foreach($this->myrows as $this->row)
		{
			$this->list.="<tbody>".
			"<tr class='alternate' valign='top'>".
			"<td class='column-columnname'>" .$this->row['user_no'] ."</td>".
			// "<td class='column-columnname'><a herf='user_lists.php' onclick='user_detail( {". $this->row['user_no']."} ); return false;'>" .$this->row['FirstName']. "</a> </td>".
			"<td><a name='user_id' href='javascript:onclickFunction(". $this->row['user_no'].")'>" .$this->row['FirstName']. "</a> </td>".
			"<td><a href='?page=menu-list?id=" . $this->row['user_no'] . "'>".$this->row['LastName']. "</a> </td>".
			"<td class='column-columnname'><img src=".$this->row['user_img']." width='80' height='60'></td>".
			"<td class='column-columnname'><a  href='?page=menu-add&id=". $this->row['user_no']."'>Edit</a> <a class='delbutton' id='". $this->row['user_no']."' href='?page=menu-list&id=". $this->row['user_no']."' >Delete</a></td>".
			"</tr>".
			"</tbody>";
		}		
		echo $this->list;
	}
}
new My_List();
?>
