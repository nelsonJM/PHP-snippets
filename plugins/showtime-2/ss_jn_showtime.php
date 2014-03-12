<?php
/**
 * Plugin Name: Showtime 2
 * Description: A plugin for images on the product page.
 * Author: Josh Nelson
 * Version: 0.2.0
 */

add_shortcode('itsshowtime', function($atts) { // $atts is an array
// override the $atts we have by returning shortcode_atts in a variable called $atts

	$atts = shortcode_atts( // store what's returned by shortcode_atts in $atts
		array(
			'type' => 'thumbs-side',
			'productgalleryclass' => '',
			'featuredprodheight' => '',
			'displayConfig' => '',
			'visibility' => ''
			
		), $atts // override our defaults above with the attributes supplied by user
	);
	extract($atts); // extract the array so each key of the array are available as simple variables

	switch( $atts['type']) {
		case 'thumbs-bottom':
			$productgalleryclass = 'thb-btm';
			$displayConfig = 'none';
			break;
		default:
			break;
	}


	$mainImage1 = get_field('first_main_image');
	$main1url = $mainImage1['url'];
	$main1alt = $mainImage1['alt'];

	$mainImage2 = get_field('second_main_image');
	$main2url = $mainImage2['url'];
	$main2alt = $mainImage2['alt'];

	$mainImage3 = get_field('third_main_image');
	$main3url = $mainImage3['url'];
	$main3alt = $mainImage3['alt'];

	$mainImage4 = get_field('fourth_main_image');
	$main4url = $mainImage4['url'];
	$main4alt = $mainImage4['alt'];

	$firstthumb = get_field('first_thumbnail_image');
	$t1url = $firstthumb['url'];
	$t1alt = $firstthumb['alt'];

	$secondthumb = get_field('second_thumbnail_image');
	$t2url = $secondthumb['url'];
	$t2alt = $secondthumb['alt'];

	$thirdthumb = get_field('third_thumbnail_image');
	$t3url = $thirdthumb['url'];
	$t3alt = $thirdthumb['alt'];

	$fourththumb = get_field('fourth_thumbnail_image');
	$t4url = $fourththumb['url'];
	$t4alt = $fourththumb['alt'];
	
	return "<div class='product-gallery $featuredprodheight $productgalleryclass'>
			<div id='featured-product'>
				<ul class='deck'>
					<li class='prod $visibility' id='image4'><a href='$main4url' class='group1' rel='group' alt='$main4alt'><img src='$main4url' alt='$main4alt' id='main-image'/></a></li>
					<li class='prod $visibility' id='image3'><a href='$main3url' class='group1' rel='group' alt='$main3alt'><img src='$main3url' alt='$main3alt' id='main-image'/></a></li>
					<li class='prod $visibility' id='image2'><a href='$main2url' class='group1' rel='group' alt='$main2alt'><img src='$main2url' alt='$main2alt' id='main-image'/></a></li>
					<li class='prod' id='image1'><a href='$main1url' class='group1' rel='group' alt='$main1alt'><img src='$main1url' alt='$main1alt' id='main-image'/></a></li>
				</ul>
			</div>
			<div class='pg window-section'>
				<ul class='grid-thumbs window-list thumbs'>
					<li style='display: $displayConfig;'>
						<p class='configExamplesBTN'></p>
					</li>
					<li data-file='image1'>
					<img src='$t1url' alt='$t1alt' />
					</li>

					<li data-file='image2'>
					<img src='$t2url' alt='$t2alt' />
					</li>

					<li data-file='image3'>
					<img src='$t3url' alt='$t3alt' />
					</li>
					<li data-file='image4'>
					<img src='$t4url' alt='$t4alt' />
					</li>
				</ul>
			</div>
			</div>";	
});

?>