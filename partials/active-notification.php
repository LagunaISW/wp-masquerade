<style>
	.wpmasq-notification {
		font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;
		position: fixed;
		bottom: 0;
		color: white;
		width: 100%;
		text-align: center;
		border-top: solid rgb(192, 94, 94) 1px;
		z-index: 9999;
		padding: 3px 0;
		background: rgb(167, 62, 59);
		background: repeating-linear-gradient( 45deg, rgba(167, 62, 59, 1), rgba(147, 49, 46, 1) 10px, rgba(167, 62, 59, 1) 10px, rgba(173, 72, 69, 1) 20px );
		text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.43);
	}
	.wpmasq-notification a {
		font-weight: bold;
		color: white;
		text-decoration: none;
	}
	.wpmasq-notification a:hover {
		text-decoration: underline;
	}
</style>

<div class="wpmasq-notification">
	<?php $current_user = wp_get_current_user(); ?>
	Currently masquerading as <strong><?php echo $current_user->user_login; ?></strong>.
	<a id="wpmasq-revert-link" href='#' title='Click here to restore your session.'>Click here</a> to restore your session or
	<a href="<?php echo wp_logout_url( get_permalink() ); ?>">log out.</a>
</div>

<script>
	(function($){
		$('#wpmasq-revert-link').click(function(){
			var ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';
			var data = {
				action: 'masq_user',
				wponce: '<?php echo wp_create_nonce('masq_once')?>',
				reset: true
			};
			$.post(ajax_url, data, function(response){
				if(response == '1'){
					location.reload();
				}
			});
		});
	})(jQuery);
</script>