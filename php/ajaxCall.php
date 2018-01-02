<?php


function detail($data)
{
	global $wpdb;
	$myrows = $wpdb->get_results( "select * from wp_manage_list where user_no=$data",ARRAY_A);
	// for($i=0; $i<$fields_num; $i++)
	// // {
	// //     $field = mysqli_fetch_field($result);
	// //     echo "<td>{$field->name}</td>";
	// // }
	
	    $detail.="<tr>".
	  	"<td width='10%'>" . $myrows['FirstName'] . "</td>".
	    "<td>" . $myrows['LastName'] . "</td>".
		"<td>" . $myrows['user_gender'] . "</td>".
		"<td>" . $myrows['user_no'] . "</td>".
		"<td>" . $myrows['user_city'] . "</td>".
		"<td>" . $myrows['user_dob'] . "</td>".
		"<td>" . $myrows['user_email'] . "</td>".
		"<td>" . $myrows['user_mobile_no'] . "</td>".
		"<td>" . $myrows['user_lang'] . "</td>".
		"<td>" . "<img src='".$myrows['user_img']."' width='80' height='60'>" . "</td>".
	    "</tr>";
		echo $detail;
}

// if(isset($_POST['submit-form']))
// {
// 	$a=implode(',',$_POST['user_lang']);
// 	$language=array("user_lang"=>"$a");
// 		$insert_var=array_merge($_POST,$language);
// 	unset($insert_var['submit-form']);
// 	global $wpdb;
// 	$table = $wpdb->prefix.'manage_list';
// 	$insert=$wpdb->insert($table,$insert_var);
// 	if($insert)
// 	{
// 		echo"<div class='alert alert-success'>The user data is Added to the List Successfully</div>";
// 	}
// 	else
// 	{
// 		//echo"error";
// 	}        	
// } 

?>


