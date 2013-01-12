<?php

/**
 * This file handles the creation of the Genesis Post Navigation admin menu.
 */


class Genesis_Post_Navigation_Admin extends Genesis_Admin_Boxes {


	function __construct() {

		// load CSS and javascript

		add_action( 'admin_enqueue_scripts', array( &$this, 'gpn_file_loads' ) );

		if ( is_admin() ){

			add_action('admin_notices', array(&$this, 'gpn_error_notice'));
		}

		// Specify a unique page ID. 

		$page_id = 'gpn_design';

		// Set it as a child to genesis, and define the menu and page titles

		$menu_ops = array(

			'submenu' => array(

				'parent_slug'	=> 'genesis',

				'page_title'	=> 'Genesis Post Navigation',

				'menu_title'	=> 'Genesis Post Navigation',

				'capability'	=> 'manage_options',

			)

		);


		// Set up page options. 
		
		$page_ops = array(

			'save_button_text'  => 'Save Design',

			'reset_button_text' => 'Clear Design',

			'save_notice_text'  => 'Design saved.',

			'reset_notice_text' => 'Design cleared.',

		);		

		// $color = genesis_get_option( 'body_text', 'ihop-settings' );

		$settings_field = 'gpn-settings';

		// Set the default values

		$default_settings = array(

			// Default colors

			'gpn_bg'		    => '#D5D5D5',

			'gpn_bg_hover'		=> '#262626',

			'text_color'		=> '#666666',

			'text_hover'		=> '#F5F5F5',

			'cat_nav'		    => '0'

		);



		// Create the Admin Page

		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );


		// Initialize the Sanitization Filter

//		add_action( 'genesis_settings_sanitizer_init', array( $this, 'sanitization_filters' ) );		

	}



	function gpn_file_loads() {

	global $current_screen;

		if ( 'genesis_page_gpn_design' == $current_screen->id ) {

			// grab colorpicker because Farbtastic sucks

			wp_enqueue_script('jscolor', plugins_url('/jscolor/jscolor.js', __FILE__), array ('jquery'), null, false);

			wp_enqueue_script('js-init', plugins_url('/js/gs.init.js', __FILE__), array ('jquery'), null, true);

			wp_enqueue_style( 'gpn-admin', plugins_url('/css/gpn-admin.css', __FILE__) );

		}

	}


	// check to make sure that the folder is writeable

	public function gpn_error_notice() {

		global $current_screen;

		if ( 'genesis_page_gpn_design' == $current_screen->id ) {		

		if(isset($this->errors) ) :

			foreach($this->errors as $err){

				echo $err;

			}

		endif;

		}

	}

	/**
	 * Set up Help Tab 	 */
	 
	 function help() {
	 	$screen = get_current_screen();
		$screen->add_help_tab( array(
			'id'      => 'gpn-help', 
			'title'   => 'General',
			'content' => '<p>Click a field to generate a color</p>',

		) );

	 }

	/**
	 * Register metaboxes on admin settings page
	 */

	function metaboxes() {
		add_meta_box('gpn-design-panel', 'Genesis Post Navigation Color Options', array( $this, 'gpn_design_panel' ), $this->pagehook, 'main', 'high');
	}

		


	/**
	 * Callback for Design metabox
	 */

	function gpn_design_panel() {

	echo '<div class="design_group colors_group">';

	echo '<div class="dg_wrap" name="colors">';

		echo '<div class="dg_inner">';

		echo '<p><label id="bg">BackGround</label>';

		echo '<input class="color {hash:true}" type="text" name="' . $this->get_field_name( 'gpn_bg' ) . '" id="' . $this->get_field_id( 'gpn_bg' ) . '" value="' . esc_attr( $this->get_field_value( 'gpn_bg' ) ) . '" size="20" />';

		echo '</p>';



		echo '<p><label  id="bg-hover">BackGround Hover</label>';

		echo '<input class="color {hash:true}" type="text" name="' . $this->get_field_name( 'gpn_bg_hover' ) . '" id="' . $this->get_field_id( 'gpn_bg_hover' ) . '" value="' . esc_attr( $this->get_field_value( 'gpn_bg_hover' ) ) . '" size="20" />';

		echo '</p>';



		echo '<p><label  id="text">Text</label>';

		echo '<input class="color {hash:true}" type="text" name="' . $this->get_field_name( 'text_color' ) . '" id="' . $this->get_field_id( 'text_color' ) . '" value="' . esc_attr( $this->get_field_value( 'text_color' ) ) . '" size="20" />';

		echo '</p>';



		echo '<p><label  id="text-hover">Text Hover</label>';

		echo '<input class="color {hash:true}" type="text" name="' . $this->get_field_name( 'text_hover' ) . '" id="' . $this->get_field_id( 'text_hover' ) . '" value="' . esc_attr( $this->get_field_value( 'text_hover' ) ) . '" size="20" />';

		echo '</p>';
		
		echo '<p><label  id="text-hover">Navigate posts with in Category</label>';?>

		<input type="checkbox" name="<?php echo $this->get_field_name( 'cat_nav' ); ?>" id="<?php echo $this->get_field_id( 'cat_nav' ); ?>" value="1"<?php esc_attr( checked( $this->get_field_value( 'cat_nav' ) )); ?> />

		<?php echo '</p>';


		echo '</div>';
		
		echo 'If you like this plugin, <a href="http://iniyan.in/donate">Buy me a coffee</a>. Rate this Plugin on WordPress';
		
		// end Color options

	echo '</div>'; // end inner wrap
	
	
		if ( isset( $_GET['settins-updated'] ) )

			$save_trigger = 'true';

		if ( isset( $_GET['reset'] ) )

			$reset_trigger = 'true';

		if(!empty($save_trigger) || !empty($reset_trigger) )

			gpn_generate_css();
			gpn_after_post();
	}	
}
add_action( 'genesis_admin_menu', 'gpn_add_design_settings' );

/**

 * Instantiate the class to create the menu.

 */
function gpn_add_design_settings() {

	new Genesis_Post_Navigation_Admin;

}