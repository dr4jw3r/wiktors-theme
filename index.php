<?php get_header(); ?>
<body>
	<div id="main_frame">

		<?php require('menu.php'); ?>

		
		<?php w_sidebar(); ?>

		<section id="content_column" class="content">
			<?php w_posts(); ?>
		</section>

	</div>
	<?php get_footer(); ?>