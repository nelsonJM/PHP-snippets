/**
 * jQuery and AJAX for the Sample AJAX Chicago plugin.
 *
 * @since 1.0.0
 *
 * @package	Sample AJAX Chicago
 * @author	Thomas Griffin
 */
jQuery(document).ready(function($){

	/**
	 * Perform the AJAX request when the user clicks the "Get Plugin Data" button.
	 */
	$('body').on('click.getPluginData', '#query-api', function(e){
		/** Prevent the default action from occurring */
		e.preventDefault();

		/** Save the default text state for our button */
		var default_text = $(this).text();

		/** Output a message and loading icon */
		$('.waiting').remove();
		$(this).text(sample_ajax_chicago.searching).after('<span class="waiting"></span>');

		/** Setup our AJAX request */
		var opts = {
			url: sample_ajax_chicago.url,
			type: 'post',
			async: true,
			cache: false,
			dataType: 'json',
			data: {
				action: 'get_plugin_data',
				nonce: sample_ajax_chicago.nonce,
				plugin: $('#plugin-name').val()
			},
			success: function(html){
				/** Make sure to remove any previous error messages or data if we have any */
				$('.plugin-info').empty();

				/** Append our data to the div for formatting and display */
				$('.plugin-info').append(html);

				/** Remove the loading icon and replace the button with default text */
				$('.waiting').remove();
				$('#query-api').text(default_text);
			},
			error: function(xhr, textStatus ,e) {
				/** Make sure to remove any previous error messages or data if we have any */
				$('.plugin-info').empty();

				/** If we have a response as to why our request didn't work, let's output it or give a default error message */
				if ( xhr.responseText )
					$('.plugin-info').append('<p class="plugin-error">' + xhr.responseText + '</p>');
				else
					$('.plugin-info').append('<p class="plugin-error">' + sample_ajax_chicago.error + '</p>');

				/** Remove the loading icon and replace the button with default text */
				$('.waiting').remove();
				$('#query-api').text(default_text);
			}
		}
		$.ajax(opts);
	});

});