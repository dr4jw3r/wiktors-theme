<?php get_header(); ?>
<body class="no-scroll">
	<div id="main_frame">

		<?php require('menu.php'); ?>

		<div id="blog_info">
				<div id="shade-wrapper">
				<div id="blog_title">
					<?php bloginfo('name'); ?>
				</div>
				<div id="blog_description">
					<?php bloginfo('description'); ?>
				</div>
			</div>
		</div>
		
	</div>
	<?php get_footer(); ?>