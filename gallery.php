<?php 
/*
	Template Name: gallery page template
*/
 ?>

<?php get_header(); ?>
<body>
	<div id="main_frame" class="gallery_wrap">

		<?php require('menu.php'); ?>

		<section id="gallery" class="content">
			<?php w_image_slider(); ?>
		</section>

	</div>
	<?php get_footer(); ?>