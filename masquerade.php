<?php
/**
* Plugin Name: WP Masquerade
* Description: Allow WP Admin users to easily masquerade as other users on a site
* Plugin URI: https://github.com/Swingline0/masquerade
* Author: JR King/Eran Schoellhorn
* Author URI: https://github.com/Swingline0/masquerade
* Version: 1.01
* License: GPL2
*/

/*
Copyright (C) 2014 Eran Schoellhorn me@eran.sh

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'plugins_loaded', array('WPMasquerade', 'get_instance'));

class WPMasquerade {

	private static $instance = null;

	public static function get_instance(){
		if(!isset(self::$instance))
			self::$instance = new self;

		return self::$instance;
	}

	private function __construct(){
		add_action('admin_init',        array($this, 'masq_init'      ));
		add_action('admin_footer',      array($this, 'masq_as_user_js'));
		add_action('wp_ajax_masq_user', array($this, 'ajax_masq_login'));
	}

	public function masq_init(){
		if(is_admin()){
			add_filter('user_row_actions', array($this, 'masq_user_link'), 99, 2);
		}
	}

	public function masq_user_link($actions, $user_object){
		if(current_user_can('delete_users')){
			$current_user = wp_get_current_user();
			if($current_user->ID != $user_object->ID){
				$actions['masquerade'] = "<a class='masquerade-link' data-uid='{$user_object->ID}' href='#' title='Masquerade'>Masquerade</a>";
			}
		}
		return $actions;
	}

	public function masq_as_user_js(){
		if (is_admin()){
			?>
				<script type="text/javascript">
					(function($){
						$('.masquerade-link').click(function(){
							var ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';
							var data = {
								action: 'masq_user',
								wponce: '<?php echo wp_create_nonce('masq_once')?>',
								uid: $(this).data('uid')
							}
							$.post(ajax_url, data, function(response){
								if(response == '1'){
									window.location = "<?php echo site_url();?>"
								}
							});
						});
					})(jQuery);
				</script>
			<?php
		}
	}

	public function ajax_masq_login(){

		if(!isset($_POST['wponce']) || !wp_verify_nonce($_POST['wponce'], 'masq_once'))
			wp_die('Security check');

		$uid = filter_input(INPUT_POST, 'uid', FILTER_SANITIZE_NUMBER_INT);

		if(!$uid)
			wp_die('Security Check');

		$user_info = get_userdata($uid);
		$uname = $user_info->user_login;

		if(current_user_can('delete_users')){
			wp_set_current_user($uid, $uname);
			wp_set_auth_cookie($uid);
			do_action('wp_login', $uname);
			$new_user = wp_get_current_user();
			if($new_user->ID == $uid){
				echo 1;
				exit();
			}
		}
	}

}