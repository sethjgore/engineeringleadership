<?php
/*
Plugin Name: Advanced Custom Fields: ui_drag
Plugin URI: {{git_url}}
Description: {{short_description}}
Version: 1.0.0
Author: {{full_name}}
Author URI: {{website}}
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


class acf_field_ui_drag_plugin
{
	/*
	*  Construct
	*
	*  @description: 
	*  @since: 3.6
	*  @created: 1/04/13
	*/
	
	function __construct()
	{
		// set text domain
		/*
		$domain = 'acf-ui_drag';
		$mofile = trailingslashit(dirname(__File__)) . 'lang/' . $domain . '-' . get_locale() . '.mo';
		load_theme_textdomain( $domain, $mofile );
		*/
		
		
		// version 4+
		add_action('acf/register_fields', array($this, 'register_fields'));	

		
		// version 3-
		add_action( 'init', array( $this, 'init' ));
	}
	
	
	/*
	*  Init
	*
	*  @description: 
	*  @since: 3.6
	*  @created: 1/04/13
	*/
	
	function init()
	{
		if(function_exists('register_field'))
		{ 
			register_field('acf_field_ui_drag', dirname(__File__) . '/ui_drag-v3.php');
		}
	}
	
	/*
	*  register_fields
	*
	*  @description: 
	*  @since: 3.6
	*  @created: 1/04/13
	*/
	
	function register_fields()
	{
		include_once('ui_drag-v4.php');
	}
	
}

new acf_field_ui_drag_plugin();
		
?>
