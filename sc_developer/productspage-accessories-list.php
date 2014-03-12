$args = array(
    	'post_type' => 'accessories',
    	'category_name' => $category,
		'orderby' => 'name',
		'order' => 'ASC'
    	); 

$custom_query = new WP_Query($args); // exclude Asides category
$html .= '<a id="'.$category.'"></a>';
$html .= '<h3 class="cat-head '.$category.'">'.$list_title.'</h3>';
while($custom_query->have_posts()) : $custom_query->the_post();
$accID = get_the_ID();
$title = get_the_title();
$defClass = sanitize_title_with_dashes( $title );
$link = get_permalink();
$accImg = get_the_post_thumbnail($accID, 'gallery_thumb_size');
$excerpt = get_the_excerpt();
$html .= '<div class="media">';
$html .= '<a href="'.$link.'">';
$html .= $accImg;
$html .= '</a>';
$html .= '<div class="bd">';
$html .= '<h4 class=""><a href="'.$link.'">'.$title.'</a></h4>';
$html .= '<p>'.$excerpt.'</p>';
$html .= '</div>';
$html .= '</div>';
endwhile;
wp_reset_query();