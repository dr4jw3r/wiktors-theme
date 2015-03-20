jQuery(document).ready(function($){

	if(typeof template_url !== 'undefined'){

		$('.upload_image_button')
			.click(function(e){
				e.preventDefault();

				var custom_uploader = wp.media({
						title: 'Gallery Image Upload',
						button: {
						text: 'Upload'
					},
					multiple: true
				})
				.on('select', function() {
					var attachment = custom_uploader.state().get('selection').first().toJSON();
					$('.custom_media_image').attr('src', attachment.url);
					$('.custom_media_url').val(attachment.url);
					$('.custom_media_id').val(attachment.id);
				})
				.open();
			});
	}

});

