// This script makes the menu look better.
jQuery(document).ready(function(){

	var colors = ['#F00', '#0F0', '#00F', '#FF0'];

	// Changing the color of the active link and the border of the nav bar.
	jQuery('.menu > .menu-item').each(function(index, element){
		var cls = jQuery(element).attr('class');
		if(cls.indexOf('current-menu-item') != -1){
			var colorIndex = index % colors.length;
			var activeColor = colors[colorIndex];
			jQuery('.current-menu-item').children().first().css("color", activeColor);
			jQuery('nav').css('border-bottom-color', activeColor);
			jQuery('.sub-menu > li').css('border-color', activeColor);
		}
	});

	// Nav bar opacity animation.
	// For some reason CSS transition was glitchy, opted for jQ instead.
	jQuery('nav').hover(function(){
		jQuery('nav').stop().animate({"opacity": "1"}, 500);
	}, function(){
		if(jQuery(window).scrollTop() == 0){
			jQuery('nav').stop().animate({"opacity": ".8"}, 500);
		}
	});

	// Dim the menu on scroll to avoid content being visible underneath the menu bar.
	jQuery(window).scroll(function(){
		var top = jQuery(window).scrollTop();
		if(top == 0){
			jQuery("nav").stop().animate({"opacity": ".8"}, 500);
		}
		else{
			jQuery("nav").stop().animate({"opacity": "1"}, 500);
		}
	});

	// Slide-toggling submenus.
	jQuery('nav').hover(function(){
		jQuery('.sub-menu').slideToggle();
	});

	// Gallery only. Image background looks very bad, so the image is replaced
	// with a user-defined color. Color is defined in the options.
	var frameClass = jQuery('#main_frame').attr('class');
	if(frameClass == 'gallery_wrap'){
		jQuery('html').addClass("background-replace");
	}

});