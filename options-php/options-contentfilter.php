<?php

class options_contentfilter {

	function __construct() {
		add_action( 'admin_init', array( $this, 'admin_js' ) );	
		add_action( 'admin_init', array( $this, 'admin_css' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	function admin_js(){
		wp_register_script( 'contentfilter-options-helper', get_template_directory_uri() . '/wp-scripts/contentfilter-options-helper.js' );
		wp_enqueue_script( 'contentfilter-options-helper' );
	}

	function admin_css(){
		wp_register_style( 'contentfilter-css', get_template_directory_uri() . '/css/contentfilter.css' );
		wp_enqueue_style( 'contentfilter-css' );
	}

	function admin_menu () {
		add_options_page( 'Mature Language Filter', 'Mature Language Filter', 'manage_options' ,'contentfilter_options', array($this, 'page_content') );
	}

	function register_settings(){
		register_setting("contentfilter_opts", "contentfilter_enabled");
	}
	
	function page_content(){
	?>
		<div class="wrap">
			<h2><?php _e("Content Filter Settings", 'wiktors-theme'); ?></h2>
			<form method="post" action="options.php">
				<?php
					settings_fields('contentfilter_opts');
					do_settings_sections( 'contentfilter_opts' );
				?>
				
				<table class="form-table">
			        <tr valign="top">
			        	<th scope="row"><?php _e("Enable Mature Language Filter"); ?></th>			   
			        	<td><input type="checkbox" name="contentfilter_enabled" <?php if(esc_attr(get_option('contentfilter_enabled')) == 'on'){echo "checked";} ?>/></td>
			        </tr>
			        <tr valign="top">
			        	<th scope="row"><?php _e("List of words to filter"); ?></th>			   
			        	<td><input type="text" name="contentfilter_addword" id="addword_input"></td>
			        </tr>
			        <tr valign="top">
			        	<td></td>
			        	<td>
			        		<button class="button button-primary" id="wordaddbutton"><?php _e('Add', 'wiktors-theme'); ?></button>
			        	</td>
		        	</tr>
		        	<tr valign="top">
		        		<td></td>
			        	<td id="word_list">
			        		<div id="bad_word_wrap_overlay"></div>
			        		<div id="bad_word_wrap"></div>
			        	</td>
		        	</tr>
				</table>

				<?php submit_button(); ?>
			</form>
		</div>
		<script type="text/javascript">
			var template_url = "<?php echo get_template_directory_uri(); ?>";
		</script>
	<?php
	}
}

new options_contentfilter;

?>