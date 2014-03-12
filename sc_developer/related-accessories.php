$acc_list = get_field($acclist);

if( $acc_list) {
	$html .= '<ul class="list-square left">';
		while(has_sub_field($acclist)) {
		$p = get_sub_field('acc_item');
		$accID = $p->ID; 
		$accName = $p->post_title;
		$accContent = $p->post_content;
		$accExcerpt = $p->post_excerpt;
		$accLink = get_permalink($accID);
		
			$html .= '<li><a href="' . $accLink . '">' . $accName . '</a></li>';
		}
	$html .= '</ul>';
}