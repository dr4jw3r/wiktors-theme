<?php

class options_imageupload {

	function __construct() {
		add_action( 'admin_init', array( $this, 'admin_js' ) );	
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}
	function admin_js(){
		wp_register_script( 'imageupload-options-helper', get_template_directory_uri() . '/wp-scripts/imageupload-options-helper.js' );
		wp_enqueue_script( 'imageupload-options-helper' );
	}
	function admin_menu () {
		add_theme_page( 'Image slider upload', 'Image slider upload', 'manage_options' ,'imageupload_options', array($this, 'page_content') );
	}
	function page_content(){
	?>
		<style>
			.warn{
				color:#F00;
			}
			.italic{
				font-style: italic;
			}
		</style>
		<div class="wrap">
			<h2><?php _e("Image Slider Upload", 'wiktors-theme'); ?></h2>
			<p class="warn">Please note that all images should be the same size in order to ensure proper functioning of the gallery.</p>
			<table class="form-table">
		        <tr valign="top">
		        	<th scope="row">Upload Image</th>			   
		        	<td></td>
		        	<td>
		        		<?php 
							wp_enqueue_media();
							echo '<button class="upload_image_button button upload-button">Upload</button>';
		 				?>
	 				</td>
		        </tr>
			<br/>
			
			
		</div>
		<script type="text/javascript">
			var template_url = "<?php echo get_template_directory_uri(); ?>";
		</script>
		
	<?php
	}
}

new options_imageupload;

?>