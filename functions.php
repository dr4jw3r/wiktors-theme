<?php 

	//Enabling menu
	if(function_exists('add_theme_support')){
		add_theme_support('menus');
		register_nav_menu('main', 'Main Menu');
	}

	//Function which registers all required CSS stylesheets
	function w_getAllCss() {
		$styles = array();
		array_push($styles, ['name' => 'reset-css', 'file' => 'reset']);
		array_push($styles, ['name' => 'main-css', 'file' => 'style']);
		array_push($styles, ['name' => 'slider-css', 'file' => 'slider']);
		array_push($styles, ['name' => 'jqueryui-css', 'file' => 'jqueryui']);
		array_push($styles, ['name' => 'fonts-css', 'file' => 'fonts']);

		foreach($styles as $style){
			wp_register_style( $style['name'], get_template_directory_uri() . '/css/' . $style['file'] . '.css');
			wp_enqueue_style( $style['name'] );			
		}
	}
	add_action( 'wp_enqueue_scripts', 'w_getAllCss' );

	//Function which registers all required javascript files.
	function w_getAllJs(){
		wp_enqueue_script('jquery');

		$scripts = array();
		array_push($scripts, ['name' => 'jquery-ui', 'file' => 'jquery-ui']);
		array_push($scripts, ['name' => 'image-slider', 'file' => 'js-image-slider']);
		array_push($scripts, ['name' => 'init-jqueryui', 'file' => 'init-jqueryui']);
		array_push($scripts, ['name' => 'menu-beautifier', 'file' => 'menu-beautifier']);

		foreach($scripts as $script){
			wp_register_script( $script['name'], get_template_directory_uri() . '/wp-scripts/' . $script['file'] . '.js' );
			wp_enqueue_script( $script['name'] );
		}

	}
	add_action( 'wp_enqueue_scripts', 'w_getAllJs' );

	//This function decides on the content of the sidebar
	function w_sidebar(){
		?>
		<div id="sidebar">
			<div id="accordion">
				<h3><?php _e('Archive', 'wiktors-theme');?></h3>
				<div id="archive_container">
					<?php 
						wp_get_archives(array(
							'type' => 'postbypost',
						));
					?>
				</div>

				<?php if(!is_user_logged_in()){ ?>
					<h3>Log In</h3>
					<div id="login_form_container">
						<?php wp_login_form(); ?>
						<div id="reglink">
							<?php
								_e('Not registered yet?'); 
								wp_register();
							?>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
		<?php
	}

	//This function returns a URI for an image
	//PARAM: The name of the image
	function w_image_uri($url){
		echo '<img src="' . $url . '" alt=""/>';
	}

	//This function registers a theme customizer
	function w_theme_customizer_register($wp_customize){

		// Allowing the user to change various colors in the theme
		$colors = array();
		$colors[] = array(
			'slug' => 'content_text_color',
			'default' => '#FFF',
			'label' => __('Content Text Color', 'wiktors-theme')
		);
		$colors[] = array(
			'slug' => 'content_link_color',
			'default' => '#F00',
			'label' => __('Content Link Color', 'wiktors-theme')
		);
		$colors[] = array(
			'slug' => 'heading_link_color',
			'default' => '#FFF',
			'label' => __('Post Heading Color', 'wiktors-theme')
		);
		$colors[] = array(
			'slug' => 'gallery_background_color',
			'default' => '#FFF',
			'label' => __('Gallery Background Color', 'wiktors-theme')
		);

		foreach($colors as $color){
			$wp_customize->add_setting(
				$color['slug'],
				array(
					'default' => $color['default'],
					'type' => 'option',
					'capability' => 'edit_theme_options'
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$color['slug'],
					array(
						'label' => $color['label'],
						'section' => 'colors',
						'settings' => $color['slug']
					)
				)
			);

			//Allowing the user to choose the position of the sidebar
			$wp_customize->add_setting('sidebar_position', array());
			$wp_customize->add_control('sidebar_position', 
				array(
					'label' => __('Sidebar Position', 'wiktors-theme'),
					'section' => 'layout',
					'settings' => 'sidebar_position',
					'type' => 'radio',
					'choices' => array(
									'left' => 'Left',
									'right' => 'Right'
								)
				)
			);

			$wp_customize->add_section('layout', 
				array(
					'title' => __('Layout', 'wiktors-theme'),
					'priority' => 30
				)
			);

			//Allowing the user to change the size and position of the image slider.
			$wp_customize->add_section('slider_options',
				array(
					'title' => __('Image Slider', 'wiktors-theme'),
					'priority' => 40
				)
			);

			$wp_customize->add_setting('slider_display', array(
				'default' => true
			));
			$wp_customize->add_control('slider_display',
				array(
					'label' => __('Show Image Slider', 'wiktors-theme'),
					'section' => 'slider_options',
					'settings' => 'slider_display',
					'type' => 'checkbox',
				)
			);

			$wp_customize->add_setting('slider_size_w', array(
				'default' => 700
			));
			$wp_customize->add_control('slider_size_w',
				array(
					'label' => __('Image Slider Width', 'wiktors-theme'),
					'section' => 'slider_options',
					'settings' => 'slider_size_w',
					'type' => 'number',
				)
			);

			$wp_customize->add_setting('slider_size_h', array(
				'default' => 306
			));
			$wp_customize->add_control('slider_size_h',
				array(
					'label' => __('Image Slider Height', 'wiktors-theme'),
					'section' => 'slider_options',
					'settings' => 'slider_size_h',
					'type' => 'number',
				)
			);

			$wp_customize->add_setting('slider_position_v', array());
			$wp_customize->add_control('slider_position_v', 
				array(
					'label' => __('Slider Position (Vertical)', 'wiktors-theme'),
					'section' => 'slider_options',
					'settings' => 'slider_position_v',
					'type' => 'radio',
					'choices' => array(
									'top' => 'Top',
									'bottom' => 'Bottom'
								)
				)
			);

			$wp_customize->add_setting('slider_position_h', array());
			$wp_customize->add_control('slider_position_h', 
				array(
					'label' => __('Slider Position (Horizontal)', 'wiktors-theme'),
					'section' => 'slider_options',
					'settings' => 'slider_position_h',
					'type' => 'radio',
					'choices' => array(
									'left' => 'Left',
									'center' => 'Center',
									'right' => 'Right'
								)
				)
			);

		}
	}
	add_action( 'customize_register', 'w_theme_customizer_register' );

	// This function generates the custom CSS from the customizer
	function w_customize_css(){
			
			$content_text_color 		= get_option('content_text_color');
			$content_link_color 		= get_option('content_link_color');
			$heading_link_color 		= get_option('heading_link_color');
			$gallery_background_color 	= get_option('gallery_background_color');
			$sidebar_position 			= get_theme_mod('sidebar_position');
			$content_position 			= ($sidebar_position == 'left') ? 'right' : 'left';
			$slider_position_h 			= get_theme_mod('slider_position_h');
			$slider_size_h 				= get_theme_mod('slider_size_h', '306');
			$slider_size_w 				= get_theme_mod('slider_size_w', '700');

		?>
		<style>
			.content { color: <?php echo $content_text_color; ?>; }
			#content > a { color: <?php echo $content_link_color; ?>; }
			.post_header { color: <?php echo $heading_link_color; ?>; }
			#sidebar { float: <?php echo $sidebar_position; ?>; }
			#content_column { float: <?php echo $content_position; ?>; }
			<?php if($slider_position_h == 'left' || $slider_position_h == 'right'){ ?>
			#slider{float: <?php echo $slider_position_h; ?>; }
			<?php } ?>
			#slider, #slider div.sliderInner{
				width: <?php echo $slider_size_w; ?>px;				
				height: <?php echo $slider_size_h; ?>px;
			}
			.background-replace{
				background: <?php echo $gallery_background_color; ?> !important;
			}
			
		</style>	
		<?php
	}
	add_action( 'wp_head', 'w_customize_css' );

	//This function prints out formatted posts.
	function w_posts(){

		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post(); ?>
				
				<div class="post">
					<div class="post_header">
						<div class="post_title"><?php the_title(); ?></div>
						<div class="post_time"><?php the_time('F jS, Y'); ?></div>
					</div>
					<div class="post_content"><?php the_content(); ?></div>
					<div class="post_footer">
						<div class="post_tags"><?php the_tags(); ?></div>
						<div class="post_author"><?php echo __('Author: ', 'wiktors-theme'); the_author(); ?></div>
					</div>
					<div class="comments">
						<?php global $withcomments; $withcomments = true; comments_template(); ?>
					</div>
				</div>

			<?php endwhile;
		else:
			echo __("Sorry, no posts found!", 'wiktors-theme');
		endif;
	}

	// This function returns the vertical position of the slider
	function w_slider_position(){
		return get_theme_mod('slider_position_v');
	}

	// This function adds the image slider to the page
	function w_image_slider(){
		$display_slider = get_theme_mod('slider_display');
		if($display_slider){
			?>
				<div id="slider">
					<?php 
						$query_images_args = array(
						    'post_type' => 'attachment', 'post_mime_type' =>'image', 'post_status' => 'inherit', 'posts_per_page' => -1,
						);

						$query_images = new WP_Query( $query_images_args );
						$images = array();
						foreach ( $query_images->posts as $image) {
						    w_image_uri(wp_get_attachment_url( $image->ID ));
						}
					?>
	   			</div>
    		<?php
    	}
	}

	// This function filters out the bad words from the content
	// The list of bad words is stored in a file and is editable by the user in
	// the wordpress options pane. 
	function w_content_filter($content){

		$filter_enabled = esc_attr(get_option('contentfilter_enabled'));

		if($filter_enabled == 'on'){
			$filepath = get_template_directory_uri() . '/ajax-php/bwlist.txt';

			if(!file_exists($filepath)){
				touch($filepath);
			}

			$list = explode(PHP_EOL, file_get_contents($filepath));

			for($i = 0; $i < count($list) - 1; $i++){
				$content = preg_replace("/$list[$i]\b/i", "***", $content);
			}


		}

		return $content;

	}
	add_filter('the_content', 'w_content_filter');
	add_filter('comment_text', 'w_content_filter');

	// Requiring the file containing the menu for the mature language filter
	require(get_theme_root() . '/wiktors-theme/options-php/options-contentfilter.php');

	// Requiring the file containing the menu for the image slider image upload.
	require(get_theme_root() . '/wiktors-theme/options-php/options-imageupload.php');


?>

