<?php
/**
 * Plugin Name: My Back to Top plugin 
 * Description: This plugin provides a scroll to top of page effect.
 * Author: Josh Nelson
 */

/* Place custom code below this line. */

function back_to_top() { 
	if (is_page('accessories')) { ?>
	<script>
	(function($) {
		// hide #back-top first
		$("#back-top").hide();
		
		// fade in #back-top
		$(function () {
			$(window).scroll(function () {
				if ($(this).scrollTop() > 100) {
					$('#back-top').fadeIn();
				} else {
					$('#back-top').fadeOut();
				}
			});

			// scroll body to 0px on click
			$('#back-top a').click(function () {
				$('body,html').animate({
					scrollTop: 0
				}, 400);
				return false;
			});
		});
		
	})(jQuery);
	</script>
<?php }
}
add_action('thesis_hook_after_html', 'back_to_top');
/* Place custom code above this line. */

