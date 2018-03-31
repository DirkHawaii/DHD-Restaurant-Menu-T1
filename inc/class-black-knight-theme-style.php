<?php
/* class-black-knight-theme-style.php */

/**
 * Class Black_Knight_Theme_Style
 *
 *
 */
class Black_Knight_Theme_Style {
  protected $version;             // ATTRIBUTE - VERSION

  public function __construct( $version ) {
    $this->version = $version;
  }
  private function fonts_url() {
    $fonts_url = '';
    $fonts     = array();
    $subsets   = 'latin,latin-ext';

    /*** TRANSLATORS: IF THERE ARE CHARACTERS IN YOUR LANGUAGE THAT ARE NOT SUPPORTED BY THE     ***/
    /*** FOLLOWING FONTS, TRANSLATE THIS TO 'off'. DO NOT TRANSLATE INTO YOUR OWN LANGUAGE.      ***/
    if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'black_knight_t2' ) )    { $fonts[] = 'Open Sans';    }
    if ( 'off' !== _x( 'on', 'Hind font: on or off', 'black_knight_t2' ) )         { $fonts[] = 'Hind:400,700'; }
    if ( 'off' !== _x( 'on', 'Varela Round font: on or off', 'black_knight_t2' ) ) { $fonts[] = 'Varela Round'; }
    if ( $fonts ) {
      $fonts_url = add_query_arg( array(
        'family' => urlencode( implode( '|', $fonts ) ),
        'subset' => urlencode( $subsets ),
      ), 'https://fonts.googleapis.com/css' );
    }
    return $fonts_url;
  }
  public function admin_style() {
    wp_enqueue_style( 'admin-styles', get_template_directory_uri().'/css/admin.css');
  }
  public function theme_scripts() {
    global $black_knight_t2_version;


    wp_enqueue_style( 'black_knight_t2-fonts', $this->fonts_url(), array(), null );
    wp_register_style( 'black_knight_t2-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), $this->version );
    wp_enqueue_style( 'black_knight_t2-styles', get_stylesheet_uri(), array( 'black_knight_t2-bootstrap' ), '1' );
    wp_enqueue_script( 'dhd_sf1-popper',    get_template_directory_uri() .'/js/vendor/popper.min.js', array( 'jquery' ), $this->version, true );
    wp_enqueue_script( 'dhd_sf1-docs',      get_template_directory_uri() .'/js/docs.min.js', array( 'jquery' ), $this->version, true );
    wp_enqueue_script( 'dhd_sf1-bootstrap', get_template_directory_uri() .'/js/bootstrap.min.js', array( 'jquery' ), $this->version, true );
    wp_enqueue_script( 'dhd_sf1-iewo',      get_template_directory_uri() .'/js/ie10-viewport-bug-workaround.js', array( 'jquery' ), $this->version, true );
  }


  /*************************************************************************************************/
  /**   N A V   L I   C L A S S   ( $classes, $item )                                             **/
  /*************************************************************************************************/
  public function nav_li_class( $classes ) {
    $classes[] .= ' nav-item';
    return $classes;
  }
  /*************************************************************************************************/
  /**   N A V   A N C H O R   C L A S S    ( $atts, $item, $args )                                **/
  /*************************************************************************************************/
  public function nav_anchor_class( $atts ) {
    $atts['class'] .= ' nav-link';
    return $atts;
  }




}
