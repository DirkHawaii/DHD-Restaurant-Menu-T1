<?php
/**
 *   Class: Black_Knight_Theme_Obj
 *
 */
class Black_Knight_Theme_Obj {
  protected $version;             // ATTRIBUTE - VERSION

  public function __construct( $version ) {
    $this->version = $version;
  }

  public function setup_theme() {

    /***   A D D   T H E M E   S U P P O R T   ***/
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-header', array(
        'random-default'  => false,
        'width'           => 1110,
        'height'          => 300,
        'flex-height'     => false,
        'flex-width'      => false,
        'default-text-color' => '',
        'header-text'     => true,
        'uploads'         => true,
    ) );
    //add_theme_support( 'custom-background', array( 'default-color' => 'ffffff', ) );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', ) );

    add_theme_support( 'custom-logo', array(
              'height'      => 115,
              'width'       => 320,
              'flex-height' => false,
              'flex-width'  => false,
              'header-text' => array( 'site-title', 'site-description' ),
    ) );

    /***   A D D   N A V I G A T I O N   M E N U   ***/
    register_nav_menus( array( 'main_menu' => __( 'Main Menu', 'black_knight_t2' ), ) );


    add_theme_support( 'starter-content', apply_filters( 'dhd_bkk_starter_content', array(
      'posts' => array(
         'home' => array(
           'post_type'    => 'page',
           'post_title'   => _x( 'Home', 'Theme starter content' ),
           'post_content' => _x( 'Home page text', 'Theme starter content' ),
         ),
         'menus' => array(
           'post_type'     => 'page',
           'post_title'    => _x( 'Menu', 'Theme starter content' ),
           'post_content'  => _x( '', 'Theme starter content' ),
         ),
         'about' => array(
           'post_type'     => 'page',
           'post_title'    => _x( 'About', 'Theme starter content' ),
           'post_content'  => _x( '', 'Theme starter content' ),
         ),
         'contact' => array(
           'post_type'     => 'page',
           'post_title'    => _x( 'Contact', 'Theme starter content' ),
           'post_content'  => _x( '', 'Theme starter content' ),
         ),
      ),
      'nav_menus' => array(
        'main_menu' => array(
          'name'  => __( 'Main Menu', 'black_knight_t2' ),
          'items' => array(
            'link_home',
            'page_menus' => array(
              'type' => 'post_type',
              'object' => 'page',
              'object_id' => '{{menus}}',
              ),
            'page_about',
            'page_contact',
            ),
        ),
      ),
      // DEFAULT TO A STATIC FRONT PAGE AND ASSIGN THE FRONT AND POSTS PAGES.
      'options' => array( 'show_on_front' => 'page', 'page_on_front' => '{{home}}', ),
    ) ) );

  }
  public function change_post_label() {
      global $menu;
      global $submenu;
      $menu[5][0] = 'Newsletter';
      $submenu['edit.php'][5][0] = 'Newsletter';
      $submenu['edit.php'][10][0] = 'Add News';
      $submenu['edit.php'][16][0] = 'News Tags';
  }
  public function change_post_object() {
      global $wp_post_types;
      $labels = &$wp_post_types['post']->labels;
      $labels->name = 'Newsletter';
      $labels->singular_name = 'Newsletter';
      $labels->add_new = 'Add News';
      $labels->add_new_item = 'Add News';
      $labels->edit_item = 'Edit News';
      $labels->new_item = 'Newsletter';
      $labels->view_item = 'View News';
      $labels->search_items = 'Search News';
      $labels->not_found = 'No News found';
      $labels->not_found_in_trash = 'No News found in Trash';
      $labels->all_items = 'All News';
      $labels->menu_name = 'Newsletter';
      $labels->name_admin_bar = 'Newsletter';
  }

  /*************************************************************************************************/
  /**   C O M M E N T   F O R M   B E F O R E                                                     **/
  /*************************************************************************************************/
  public function comment_form_before() {
    echo '<div class="card"><div class="card-block">';
  }

  /*************************************************************************************************/
  /**   C O M M E N T   F O R M                                                                   **/
  /*************************************************************************************************/
  public function comment_form_defaults( $fields ) {
    $fields['fields']['author'] = '
    <fieldset class="form-group comment-form-email">
      <label for="author">' . __( 'Name *', 'black_knight_t2' ) . '</label>
      <input type="text" class="form-control" name="author" id="author" placeholder="' . __( 'Name', 'black_knight_t2' ) . '" aria-required="true" required>
    </fieldset>';
    $fields['fields']['email'] ='
    <fieldset class="form-group comment-form-email">
      <label for="email">' . __( 'Email address *', 'black_knight_t2' ) . 'Email address *</label>
      <input type="email" class="form-control" id="email" placeholder="' . __( 'Enter email', 'black_knight_t2' ) . '" aria-required="true" required>
      <small class="text-muted">' . __( 'Your email address will not be published.', 'black_knight_t2' ) . '</small>
    </fieldset>';
    $fields['fields']['url'] = '
    <fieldset class="form-group comment-form-email">
      <label for="url">' . __( 'Website *', 'black_knight_t2' ) . '</label>
      <input type="text" class="form-control" name="url" id="url" placeholder="' . __( 'http://example.org', 'black_knight_t2' ) . '">
    </fieldset>';
    $fields['comment_field'] = '
    <fieldset class="form-group">
      <label for="comment">' . __( 'Comment *', 'black_knight_t2' ) . '</label>
      <textarea class="form-control" id="comment" name="comment" rows="3" aria-required="true" required></textarea>
    </fieldset>';
    $fields['comment_notes_before'] = '';
    $fields['class_submit'] = 'btn btn-primary';
    return $fields;
  }


  /*************************************************************************************************/
  /**   C O M M E N T   F O R M   A F T E R                                                       **/
  /*************************************************************************************************/
  public function comment_form_after() {
    echo '</div><!-- .card-block --></div><!-- .card -->';
  }




}

