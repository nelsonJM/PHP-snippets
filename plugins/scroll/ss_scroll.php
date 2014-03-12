<?php
/**
 * Plugin Name: Scroll plugin 
 * Description: This plugin provides a scroll location effect.
 * Author: Josh Nelson
 */

/* Place custom code below this line. */

function ss_scroll() { 
	if (is_page(array('accessories', 'gallery'))) { ?>
	<script>
	(function($){
	$(".scroll").click(function(e) {
		e.preventDefault();
		var $this = $(this);
		var $thisScroll = $this.data("scroll");
		var animateStuff = $('html, body');
		animateStuff.animate({
			scrollTop: $("#"+$thisScroll).offset().top
		}, 400);

	});
})(jQuery);
	</script>
<?php }
}
add_action('wp_footer', 'ss_scroll', 100);
/* Place custom code above this line. */

