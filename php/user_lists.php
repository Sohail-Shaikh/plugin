
<?php
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}


class Manage_List extends WP_List_Table {

	/** Class constructor */
	public function __construct() {

		parent::__construct( [
			'singular' => __( 'manage', 'ml' ), //singular name of the listed records
			'plural'   => __( 'manages', 'ml' ), //plural name of the listed records
			'ajax'     => false //should this table support ajax?

		] );

	}


	public static function get_customers( $per_page = 5, $page_number = 1 ) {

		  global $wpdb;

		  $sql = "SELECT * FROM {$wpdb->prefix}manage_list";

		  if ( ! empty( $_REQUEST['orderby'] ) ) {
		    $sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
		    $sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
		  }

		  $sql .= " LIMIT $per_page";

		  $sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;


		  $result = $wpdb->get_results( $sql, 'ARRAY_A' );

		  return $result;
	}

	public static function delete_customer( $id ) {
		  global $wpdb;

		  $wpdb->delete(
		    "{$wpdb->prefix}manage_list",
		    [ 'user_no' => $id ],
		    [ '%d' ]
		  );
	}

	public static function record_count() {
		  global $wpdb;

		  $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}manage_list";

		  return $wpdb->get_var( $sql );
	}

	public function no_items() {

	  	_e( 'No customers avaliable.', 'ml' );
	}

	function column_name( $item ) {

		  // create a nonce
		  $delete_nonce = wp_create_nonce( 'sp_delete_customer' );

		  $title = '<strong>' . $item['name'] . '</strong>';

		  $actions = [
		    'delete' => sprintf( '<a href="?page=%s&action=%s&customer=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['user_no'] ), $delete_nonce ),
		    'edit' => sprintf( '<a href="?page=%s&action=%s&customer=%s&_wpnonce=%s">Edit</a>', esc_attr( $_REQUEST['page'] ), 'edit', absint( $item['user_no'] ), $edit_nonce )
		  ];

		  return $title . $this->row_actions( $actions );
	}

	public function column_default( $item, $column_name ) {

		  switch ( $column_name ) {
		    case 'FirstName':
		    case 'LastName':
		      return $item[ $column_name ];
		    default:
		      return print_r( $item, true ); //Show the whole array for troubleshooting purposes
		  }
	}

	function column_cb( $item ) {
		  return sprintf(
		    '<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['user_no']
		  );
	}

	function get_columns() {
		  $columns = [
		    'cb'      => '<input type="checkbox" />',
		    'name'    => __( 'Name', 'ml' ),
		    'address' => __( 'Address', 'ml' ),
		    'city'    => __( 'City', 'ml' )
		  ];

		  return $columns;
	}

	public function get_sortable_columns() {
		  $sortable_columns = array(
		    'FirstName' => array( 'FirstName', true ),
		    'LastName' => array( 'LastName', false )
		  );

		  return $sortable_columns;
	}

	public function get_bulk_actions() {
		  $actions = [
		    'bulk-delete' => 'Delete',
		    'bulk-edit' => 'Edit'
		  ];

		  return $actions;
	}

	public function prepare_items() {

		  $this->_column_headers = $this->get_column_info();

		  /** Process bulk action */
		  $this->process_bulk_action();

		  $per_page     = $this->get_items_per_page( 'customers_per_page', 5 );
		  $current_page = $this->get_pagenum();
		  $total_items  = self::record_count();

		  $this->set_pagination_args( [
		    'total_items' => $total_items, //WE have to calculate the total number of items
		    'per_page'    => $per_page //WE have to determine how many items to show on a page
		  ] );


		  $this->items = self::get_customers( $per_page, $current_page );
	}

	public function process_bulk_action() {

		  //Detect when a bulk action is being triggered...
		  if ( 'delete' === $this->current_action() ) {

		    // In our file that handles the request, verify the nonce.
		    $nonce = esc_attr( $_REQUEST['_wpnonce'] );

		    if ( ! wp_verify_nonce( $nonce, 'sp_delete_customer' ) ) {
		      die( 'Go get a life script kiddies' );
		    }
		    else {
		      self::delete_customer( absint( $_GET['customer'] ) );

		      wp_redirect( esc_url( add_query_arg() ) );
		      exit;
		    }

		  }

		  // If the delete bulk action is triggered
		  if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' )
		       || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )
		  ) {

		    $delete_ids = esc_sql( $_POST['bulk-delete'] );

		    // loop over the array of record IDs and delete them
		    foreach ( $delete_ids as $id ) {
		      self::delete_customer( $id );

		    }

		    wp_redirect( esc_url( add_query_arg() ) );
		    exit;
	}
}
}


?>
<!DOCTYPE html>
<html>
<head>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"></link>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
	<script src="../JS/ajax.js"></script>
	 <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		</head>
			<body>
			          
			</body>
</html>
<?php
require_once('function_list.php');
$lists=new My_List();
$lists->user_list();
// function delete($data)
// {
// 	global $wpdb;
// 	$delete = $wpdb->query("DELETE from wp_manage_list WHERE user_no=".$data." limit 1");
// 	return $delete;
// }
?>