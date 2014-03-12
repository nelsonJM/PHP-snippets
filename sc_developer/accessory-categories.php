    $args = array(
            'type' => 'accessories',
            'taxonomy' => 'category',
			'exclude' => 1,
			'hide_empty' => 0
            );
    $categories = get_categories($args);
    $html .= '<ul>';
    foreach ($categories as $category) {
		$html .=  '<li><a href="#'.$category->slug.'">'.$category->cat_name.'</a></li>';
    }
    $html .=  '</ul>';