$chairs = get_field('chairs');

if( $chairs ) {
	$html .= '<ul class="group stations">';
		while(the_repeater_field('chairs')) {
		$chairImg  = get_sub_field('chair_image');
		$chairName = get_sub_field('chair_name');
		$chairBullets = get_sub_field('chair_bullets');
		$qbLink = get_sub_field('qb_link');
			$html .= '<li class="bite-size left">';
				$html .= '<img src="' . $chairImg . '">';
				$html .= '<h3>' . $chairName . '</h3>';
					if($chairBullets) {
						$html .= '<ul class="list-square tiny">';
						while(the_repeater_field('chair_bullets')) {
							$singleBullet = get_sub_field('bullet');
							$html .= '<li>' . $singleBullet . '</li>';
						}
						$html .= '</ul>';
					}
				$html .= '<div class="qb-link"><a href="' . $qbLink . '" class="quoteBuilderBTN"></a></div>';
			$html .= '</li>';	
		}
	$html .= '</ul>';
}