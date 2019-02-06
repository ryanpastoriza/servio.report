<?php 


	// sets the header title of every page
	if (!function_exists('set_header_title')) {
		function set_header_title($title){
			define('HEADER_TITLE', $title);
		}
	}
	// sets the header title of every page

	// sets the name of the website
	if (!function_exists('set_site_name')) {

		function set_site_name($name){
			define('SITE_NAME', $name);
		}
	}
	// sets the name of the website

	// sets the logo of the website
	if (!function_exists('set_site_logo')) {
		function set_site_logo($str){
			define('SITE_LOGO', $str);
		}
	}
	// sets the logo of the website

	// sets the main home page
	if (!function_exists('set_main_page')) {
		function set_main_page($str){
			define('MAIN_PAGE', $str);
		}
	}
	// sets link of logo

	// creating admin lte header
	if (!function_exists('create_header')) {

		function create_header($vars = array(),$addPlugins = array(),$addStyles = array()){
			$CI =& get_instance();
			$vars['addPlugins'] = $addPlugins;
			$vars['addStyles'] = $addStyles;

			$CI->load->view("admin_lte/header",$vars);

		}
	}
	// creating admin lte header

	// creates side navigation
	if (!function_exists('create_navigation')) {
		function create_navigation($vars){
			$CI =& get_instance();
			ksort($vars['options']);

			$CI->load->view('admin_lte/side_nav',$vars);
		}
	}	
	// creates side navigation

	// creates alert div
	if (!function_exists('lte_alert')) {
		function lte_alert($vars = array()){
			$CI =& get_instance();
			
			return $CI->load->view('admin_lte/alert',$vars,true);			
		}
	}

	// creates callout div
	if (!function_exists('lte_callout')) {
		function lte_callout($vars = false){
			$CI =& get_instance();

			return $CI->load->view('admin_lte/callout',$vars, true);
		}
	}
	// creates a simple tab
	if (!function_exists('lte_tab')) {
		function lte_tab($vars = false){
			$CI =& get_instance();

			return $CI->load->view("admin_lte/simple_tab",$vars,true);
		}
	}

	// creates an accordion
	if (!function_exists('lte_accordion')) {
		function lte_accordion($vars = array()){
			$CI =& get_instance();
			
			return $CI->load->view("admin_lte/accordion",$vars,true);
		}
	}

	// creates the first widget in the widgets.html page
	if (!function_exists('lte_widget')) {
		function lte_widget($type = 1,$vars,$page = true){
			$CI =& get_instance();
			$toret = $CI->load->view("admin_lte/widget{$type}",$vars,$page);

			return $toret;
		}
	}

	// creates a footer
	if (!function_exists('create_footer')) {
		function create_footer($vars = array(), $addScripts = false ){
			$CI =& get_instance();
			$vars['addScripts'] = $addScripts;
			$CI->load->view("admin_lte/footer",$vars);
		}
	}

	// returns admin lte asset url
	if (!function_exists('asset_url')) {
		function asset_url($str){
			return base_url("public/adminlte/".$str);
		}
	}
	// returns admin lte asset url

	// returns columns for grid classes	
	if (!function_exists('col_grid')) {
		function col_grid($xs = 12, $sm = false, $m = false, $lg = false, $xl = false){
			$class = "";

			if ($xs) {
				$class .= " col-xs-{$xs} ";
			}
			if ($sm) {
				$class .= " col-sm-{$sm} ";
			}
			if ($m) {
				$class .= " col-md-{$m} ";
			}
			if ($lg) {
				$class .= "col-lg-{$lg}";
			}
			if ($xl) {
				$class .= " col-xl-{$xl}";
			}
			return $class;
		}
	}

	// creates content
	if (!function_exists('create_content')) {
		function create_content($vars = array()){
			$CI =& get_instance();
			$CI->load->view('admin_lte/content',$vars);
		}
	}
	// creates content

	// creates lte_table
	if (!function_exists('lte_table')) {
		function lte_table($vars = array()){
			return lte_load_view("datatable",$vars);
		}
	}

	// TOP BAR NAVIGATION

	// creates a message notification
	if (!function_exists('nav_bar_msg_notif')) {
		function nav_bar_msg_notif($vars = array()){
			$CI =& get_instance();

			return $CI->load->view("admin_lte/nav_bar_msg_notif",$vars,true);
		}
	}

	// creates a notification area
	if (!function_exists('nav_bar_dropdown')) {
		function nav_bar_dropdown($vars = array()){
			$CI =& get_instance();

			return $CI->load->view("admin_lte/nav_bar_dropdown",$vars,true);
		}
	}
	// creates a user menu dropdown on top navigation
	if (!function_exists("nav_bar_user_menu")) {
		function nav_bar_user_menu($vars = array()){
			$CI =& get_instance();
		}
	}

	// generic adminlte view loader
	if (!function_exists('lte_load_view')) {
		function lte_load_view($page, $vars = array()){
			$CI =& get_instance();

			return $CI->load->view('admin_lte/'.$page,$vars,true);
		}
	}

?>