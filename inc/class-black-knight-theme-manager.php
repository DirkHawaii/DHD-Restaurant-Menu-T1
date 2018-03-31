<?php
/* class-black-knight-theme-manager.php */

/**
 * Class Black_Knight_Theme_Manager
 *
 *
 */
class Black_Knight_Theme_Manager {
  protected $loader;              // ATTRIBUTE - LOADER CLASS OBJECT
  protected $version;             // ATTRIBUTE - VERSION
  protected $content_width;       // ATTRIBUTE - CONTENT WIDTH

  public function __construct() {
    $this->version = '1.2.0';               // SET THE VERSION
    $this->content_width = 837;             // SET CONTENT WIDTH
    $this->load_dependencies();             // LOAD DEPENDENCIES
    $this->define_admin_hooks();            // SET ALL ADMIN HOOKS
  }
  private function load_dependencies() {
    require_once get_template_directory() .'/lib/bootstrap-four-wp-navwalker.php';
    require_once get_template_directory() .'/inc/class-black-knight-theme-carousel.php';
    require_once get_template_directory() .'/inc/class-black-knight-theme-contact.php';
    require_once get_template_directory() .'/inc/class-black-knight-theme-obj.php';
    require_once get_template_directory() .'/inc/class-black-knight-theme-widgets.php';
    require_once get_template_directory() .'/inc/class-black-knight-theme-style.php';
    require_once get_template_directory() .'/inc/class-black-knight-theme-loader.php';
    $this->loader = new Black_Knight_Theme_Loader();
  }

  private function define_admin_hooks() {
    $style = new Black_Knight_Theme_Style( $this->get_version() );
    $this->loader->add_action( 'wp_enqueue_scripts', $style, 'theme_scripts', 10, 1 );
    $this->loader->add_action( 'admin_enqueue_scripts', $style, 'admin_style', 10, 1 );
    $this->loader->add_filter( 'nav_menu_css_class', $style, 'nav_li_class', 10, 2 );
    $this->loader->add_filter( 'nav_menu_link_attributes', $style, 'nav_anchor_class', 10, 3 );

    $carousel = new Black_Knight_Theme_Carousel( $this->get_version() );
    $this->loader->add_action( 'init', $carousel, 'init_carousel', 10, 1 );
    $this->loader->add_action( 'add_meta_boxes', $carousel, 'add_carousel_meta_box', 10, 1 );
    $this->loader->add_action( 'save_post', $carousel, 'save_carousel_meta_box', 10, 1 );
    $this->loader->add_action( 'admin_enqueue_scripts', $carousel, 'color_picker_scripts', 10, 1 );
    $this->loader->add_filter( 'the_content', $carousel, 'manage_autop', 0, 1 );

    $contact = new Black_Knight_Theme_Contact( $this->get_version() );
    $this->loader->add_action( 'init', $contact, 'init_contact', 10, 1 );
    $this->loader->add_action( 'add_meta_boxes', $contact, 'add_contact_meta_box', 10, 1 );
    $this->loader->add_action( 'save_post', $contact, 'save_contact_meta_box', 10, 1 );
    //$this->loader->add_filter( 'the_content', $contact, 'manage_autop', 0, 1 );

    $widgets = new Black_Knight_Theme_Widgets( $this->get_version() );
    $this->loader->add_action( 'widgets_init', $widgets, 'init', 10, 1 );

    $theme = new Black_Knight_Theme_Obj( $this->get_version() );
    $this->loader->add_action( 'after_setup_theme', $theme, 'setup_theme', 10, 1 );
    $this->loader->add_action( 'admin_menu', $theme, 'change_post_label', 10, 1 );
    $this->loader->add_action( 'init', $theme, 'change_post_object', 10, 1 );
    $this->loader->add_action( 'comment_form_before', $theme, 'comment_form_before', 10, 5 );
    $this->loader->add_filter( 'comment_form_defaults', $theme, 'comment_form_defaults', 10, 5 );
    $this->loader->add_action( 'comment_form_after', $theme, 'comment_form_after', 10, 5 );

  }
  public function run() {
    $this->loader->run();
  }
  public function get_version() {
    return $this->version;
  }
  public function get_content_width() {
    return $this->content_width;
  }
  public function get_posts_pagination( $args = '' ) {
    global $wp_query;
    $pagination = '';

    if ( $GLOBALS['wp_query']->max_num_pages > 1 ) :

      $defaults = array(
        'total'     => isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1,
        'current'   => get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1,
        'type'      => 'array',
        'prev_text' => '&laquo;',
        'next_text' => '&raquo;',
      );

      $params = wp_parse_args( $args, $defaults );

      $paginate = paginate_links( $params );

      if( $paginate ) :
        $pagination .= "<ul class='pagination'>";
        foreach( $paginate as $page ) :
          if( strpos( $page, 'current' ) ) :
            $pagination .= "<li class='active'>$page</li>";
          else :
            $pagination .= "<li>$page</li>";
          endif;
        endforeach;
        $pagination .= "</ul>";
      endif;

    endif;

    return $pagination;
  }
  public function the_posts_pagination( $args = '' ) {
    echo $this->get_posts_pagination( $args );
  }
}









