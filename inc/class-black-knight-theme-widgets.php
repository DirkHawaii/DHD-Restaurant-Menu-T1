<?php
/**
 *   Class: Black_Knight_Theme_Widgets
 *
 */
class Black_Knight_Theme_Widgets {
  protected $version;             // ATTRIBUTE - VERSION

  public function __construct( $version ) {
    $this->version = $version;
  }

  public function init() {
    register_sidebar( array(
      'name'          => __( 'Right Sidebar', 'black_knight_t2' ),
      'id'            => 'right_sidebar',
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h3>',
      'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
      'name'          => __( 'Extra Sidebar 1', 'black_knight_t2' ),
      'id'            => 'extra_sidebar1',
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h3>',
      'after_title'   => '</h3>',
    ) );
  }

}

