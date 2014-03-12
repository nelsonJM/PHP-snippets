<?php

/*
*	Available Variables 
*
*	$content: Text entered between the shortcode open / close tags. Defaults to null 
*	$category: Defaults to ""
*/

$html = "";

$furniture_galleries = get_field('furniture_galleries');

if( $furniture_galleries ) {
	$html .= '<ul class="group stations">';
		while(the_repeater_field('furniture_galleries')) {
		$fgproduct  = get_sub_field('fg_product');
		$fgID = $fgproduct->ID;
		$fgimage = get_the_post_thumbnail($fgID, 'thumbnail');
		$title = get_the_title($fgID);	
		$firstbullet = get_sub_field('first_bullet');
		$secondbullet = get_sub_field('second_bullet');	
		$firstlink = get_sub_field('first_link');
		$secondlink = get_sub_field('second_link');
			$html .= '<li class="bite-size left">';
					$html .= '<a href="' . $firstlink . '">';
						$html .= $fgimage;
					$html .= '</a>';
					$html .= '<h3>' . $title . '</h3>';
					$html .= '<ul class="list-square tiny">';
			$html .= '<li><span class="bullet-text">' . $firstbullet . '</span></li>';
			$html .= '<li><span class="bullet-text">' . $secondbullet . '</span></li>';
					$html .= '</ul>';
					$html .= '<ul class="second-list">';
						$html .= '<li class="no-list-type"><a href="' . $firstlink . '" class="learn-btn"></a></li>';
						$html .= '<li class="no-list-type"><a href="' . $secondlink . '" class="quoteBuilderBTN"></a></li>';
					$html .= '</ul>';
			$html .= '</li>';
		}
	$html .= '</ul>';
}

return $html;

?>