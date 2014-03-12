<?php
/* By taking advantage of hooks, filters, and the Custom Loop API, you can make Thesis
 * do ANYTHING you want. For more information, please see the following articles from
 * the Thesis User’s Guide or visit the members-only Thesis Support Forums:
 * 
 * Hooks: http://diythemes.com/thesis/rtfm/customizing-with-hooks/
 * Filters: http://diythemes.com/thesis/rtfm/customizing-with-filters/
 * Custom Loop API: http://diythemes.com/thesis/rtfm/custom-loop-api/

---:[ place your custom code below this line ]:---*/
global $woocommerce;

add_action( 'after_setup_theme', 'steelsentry_theme_setup' );

function steelsentry_theme_setup() {
  global $content_width;

  /* Set the $content_width for things such as video embeds. */
  if ( !isset( $content_width ) )
    $content_width = 600;

  /* Add theme support for automatic feed links. */ 
  add_theme_support( 'automatic-feed-links' );

  /* Add theme support for post thumbnails (featured images). */
  add_theme_support( 'post-thumbnails' );

  /* Add theme support for custom backgrounds. */
  add_theme_support( 'custom-background' );

  /* Add your nav menus function to the 'init' action hook. */
  add_action( 'init', 'steelsentry_register_menus' );

  /* Add your sidebars function to the 'widgets_init' action hook. */
  add_action( 'widgets_init', 'steelsentry_register_sidebars' );

  /* Load JavaScript files on the 'wp_enqueue_scripts' action hook. */
  add_action( 'wp_enqueue_scripts', 'steelsentry_load_scripts' );

}

function steelsentry_register_menus() {
  /* Register nav menus using register_nav_menu() or register_nav_menus() here. */

  // Main products menu for QB page
  register_nav_menu( 'quote-builder-menu', __( 'Quote Builder Menu'));

  // Side Menu
  register_nav_menu('side','Side Menu');
  
  // Footer Menus
  register_nav_menu('footer','Footer Products');

  register_nav_menu('footer2','Footer Menu');

}

function steelsentry_register_sidebars() {
  /* Register dynamic sidebars using register_sidebar() here. */
}

function steelsentry_load_scripts() {
  wp_enqueue_style( 'example', get_template_directory_uri() . '/custom/example.css' );

  /* Enqueue custom Javascript here using wp_enqueue_script(). */
 wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/custom/js/modernizr.js', array('jquery'), false, false );

  wp_enqueue_script( 'event_util', get_template_directory_uri() . '/custom/js/test/event_util.js', null, false, true );

  wp_enqueue_script( 'cookie_util', get_template_directory_uri() . '/custom/js/test/cookie_util.js', null, false, true );

  wp_enqueue_script( 'subcookie_util', get_template_directory_uri() . '/custom/js/test/subcookie_util.js', null, false, true );

  wp_enqueue_script( 'js_example', get_template_directory_uri() . '/custom/js/test/js_example.js', null, false, true );

  wp_enqueue_script( 'example', get_template_directory_uri() . '/custom/js/test/example.js', null, 'event_util', true );

 // wp_enqueue_script( 'validate-script', get_template_directory_uri() . '/custom/js/steelsentry-theme.validate.min.js', array('jquery'), false, true );




/**************************************
* Scripts
**************************************/

// JavaScripts from original site

  if (!is_page(array('esd-sales', 'heavy-duty-workbenches'))) {

  wp_enqueue_script( 'legacy-scripts', get_template_directory_uri() . '/custom/js/legacy.min.js', array('jquery'), false, false );

  wp_enqueue_script( 'steelsentry-js', get_template_directory_uri() . '/custom/js/steelsentry-theme.min.js', array('jquery'), false, true );

  }


  if (is_page('gallery')) {
    wp_enqueue_script( 'gallery-script', get_template_directory_uri() . '/custom/js/steelsentry-theme.gallery.min.js', array('jquery'), false, true );
  }

  if (is_page(array('esd-sales','heavy-duty-workbenches'))) {
    wp_enqueue_style( 'salespage-style', get_template_directory_uri() . '/custom/salespage.css' );

    wp_enqueue_script( 'sales-js', get_template_directory_uri() . '/custom/js/sales.min.js', array('jquery'), false, true );

  }
}

// LiveReload script
function ss_livereload() {?>
  <script src="//10.10.4.15:35729/livereload.js"></script>
  <?php
}
add_action('wp_footer', 'ss_livereload');

// Product gallery pages
function jn_new_showtime(){

$i = 1;

$return_string .= '<div class="jn-npg product-gallery">';
    if(get_field('main_images')):
      $return_string .= '<div id="featured-product">';
        $return_string .= '<ul class="deck">';
        while(has_sub_field('main_images')):
          $mainImage = get_sub_field('main_image');
          $lbMainImage = get_sub_field('lb_main_image');

          $mainImageUrl = $mainImage['url'];
          $mainImageAlt = $mainImage['alt'];

          if($lbMainImage) {
            $lbMainImageUrl = $lbMainImage['url'];
            $lbMainImageAlt = $lbMainImage['alt'];
            $lbImageURL = $lbMainImageUrl;
            $lbImageAlt = $lbMainImageAlt;
          } else {
            $lbImageURL = $mainImageUrl;
            $lbImageAlt = $mainImageAlt;
          }

        $return_string .= '<li class="prod" id="image'.$i.'">';
          $return_string .= '<a href="'.$lbImageURL.'" class="group1" alt="'.$lbImageAlt.'">';
            $return_string .= '<img src="'.$mainImageUrl.'" alt="'.$mainImageAlt.'" />';
          $return_string .= '</a>';
        $return_string .= '</li>';
        $i++;
        endwhile;
      
        $return_string .= '</ul>';
    $return_string .= '</div>';
    endif;

    $i = 1;
    if(get_field('thumbnail_images')):
    $return_string .= '<div class="pg window-section">';
      $return_string .= '<p class="configExamplesBTN"></p>';
      $return_string .= '<ul class="grid-thumbs window-list thumbs">';
        while(has_sub_field('thumbnail_images')):
    
          $thumbImage = get_sub_field('thumbnail_image');
          $thumbUrl = $thumbImage['url'];
          $thumbAlt = $thumbImage['alt'];
       
        $return_string .= '<li data-file="image'.$i.'">';
        $return_string .= '<img src="'.$thumbUrl.'" alt="'.$thumbAlt.'" />';
        $return_string .= '</li>';
        $i++;
        endwhile;
        $return_string .= '</ul>';
      $return_string .= '</div>';
        endif;
        $return_string .= '</div>';
      return $return_string;
}

function register_shortcodes(){
  add_shortcode('product-gallery', 'jn_new_showtime');
}

/* Add shortcodes function to the 'init' action hook. */
add_action( 'init', 'register_shortcodes' );

/**************************************
* Add shortcodes to widgets
**************************************/
add_filter('widget_text', 'do_shortcode');

// WooCommerce
add_action( 'init', 'jn_remove_wc_breadcrumbs');
function jn_remove_wc_breadcrumbs() {
  remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
  add_action( 'woocommerce_before_single_product', 'woocommerce_breadcrumb', 20, 0 );
}
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );

/*
 * wc_remove_related_products
 * 
 * Clear the query arguments for related products so none show.
 * Add this code to your theme functions.php file.  
 */
function wc_remove_related_products( $args ) {
  return array();
}
add_filter('woocommerce_related_products_args','wc_remove_related_products', 10); 

add_action( 'wp_head', 'load_ie');
function load_ie(){
  ?>
<!--[if lt IE 9]>
<link href='<?php echo get_template_directory_uri(); ?>/css/ie-8.css' rel='stylesheet' type='text/css'>
<![endif]-->
  <?php
}

// Add jn-cart to header
add_action('esd_cart_widget', 'esd_jn_cart');
function esd_jn_cart() {
  ?>
    <div class="jn-your-cart">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>cart/" class="jn-cart-tog cb">My Cart<span class="icon-cart"></span></a>
      <div id="jn-cart">
        <?php get_sidebar('cart'); ?>
      </div>
    </div>
  <?php
}
// remove this code when enabling cart widget in header
remove_action('esd_cart_widget', 'esd_jn_cart'); 

// Disable woocommerce styles
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

// Remove eCommmerce part of WooCommerce
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 25);
add_action('woocommerce_single_product_summary', 'esd_jn_quote_form', 25);
function esd_jn_quote_form() {
  ?>
    <div class="md-modal md-effect-5" id="modal-5">
      <div class="md-content">
        <h3 class="sf-title"><?php the_field('sf_title'); ?></h3>
        <div>
          <p>Let us provide you with all the details you need to make a sound decision on your ESD protection.</p>
          <?php get_template_part( 'short-form-slide' ); ?>
          <a class="md-close md-btn">Close me!</a>
        </div>
      </div>
    </div>
  <div class="md-overlay"> </div>
  <button class="md-trigger md-btn-trigger product_trigger greenbtn button" data-modal="modal-5"><span class="icon-mobile"></span>Get a Free Quote!</button>
  <?php
}
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);