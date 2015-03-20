jQuery(document).ready(function(){

if (typeof template_url !== 'undefined') {

	// This function sends an ajax call to the server to retrieve a list of bad words
	function loadBadWords(){
		jQuery('#bad_word_wrap_overlay').toggle();
		jQuery.ajax({
			type: "POST",
			url: template_url + "/ajax-php/contentfilter_ajax.php",
			data: {"function": "get"},
			success: function(data){
				jQuery('#bad_word_wrap_overlay').toggle();
				updateBadWordList(data);
			},
			error: function(){
				alert("Could not load the word list. Please check if the file exists.");
			}
		});
	}

	// This function updates the list of bad words on the page after the ajax call has been made
	function updateBadWordList(data){
		var html = "";
		if(data.length > 0){
			for(var i = 0; i < data.length - 1; i++){
				html += '<div class="word_wrap">' + data[i] + '<div class="delicon" data-word="' + data[i] + '"></div></div>';
			}
			jQuery('#bad_word_wrap').html(html);
			jQuery('.delicon').click(removeBadWord);
		}
		else{
			jQuery('#bad_word_wrap').html('No words found.');
		}
	}

	// This function sends an ajax call to the server to remove a bad word from the list.
	function removeBadWord(){
		jQuery('#bad_word_wrap_overlay').toggle();
		var word = jQuery(this).attr('data-word');
		jQuery.ajax({
			type: "POST",
			url: template_url + "/ajax-php/contentfilter_ajax.php",
			data: {"function": "remove", "word": word},
			success: function(data){
				jQuery('#bad_word_wrap_overlay').toggle();
				updateBadWordList(data);
			},
			error: function(data){
				alert('Could not remove the word. Please try again.');
			}
		});
	}

	// Initiall call to the function to load the words.
	loadBadWords();

	// Click function for the "Add" button. The button sends the new word via ajax.
	jQuery('#wordaddbutton').click(function(e){
		jQuery('#bad_word_wrap_overlay').toggle();
		e.preventDefault();
		var word = jQuery('#addword_input').val().trim();
		if(word == ''){
			jQuery('#addword_input').css("box-shadow", "0 0 10px #F00");
		}
		else{
			jQuery('#addword_input').css("box-shadow", "none");
			jQuery.ajax({
				type: "POST",
				data: {"function": "save", "word": word},
				url: template_url + "/ajax-php/contentfilter_ajax.php",
				success: function(data){
					jQuery('#bad_word_wrap_overlay').toggle();
					jQuery('#addword_input').val('');
					updateBadWordList(data);
				},
				error: function(a){
					console.log(a);
					alert("Failed to save the word. Please try again");
				}
			});
		}
	});

}

});