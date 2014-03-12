<?php

/*
*	Available Variables 
*
*	$content: Text entered between the shortcode open / close tags. Defaults to null 
*	$category: Defaults to ""
*/

$html = "";

$args = array(
    	'post_type' => 'accessories',
    	'category_name' => $category
    	); 

$custom_query = new WP_Query($args); // exclude Asides category
while($custom_query->have_posts()) : $custom_query->the_post();
$title = get_the_title();
$link = get_permalink();
$excerpt = get_the_excerpt();

	$html .= '<dl class="acc-list-1 list-square">';
$html .= '<dt class="acc-rel-name"><a href="/accessories">'.$title.'</a></dt>';
			$html .= '<dd class="acc-rel-desc bullet-text">'.$excerpt.'</dd>';
	$html .= '</dl>';
endwhile;
wp_reset_query();

return $html;

?>