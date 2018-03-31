<?php

/**
 * Class: Black_Knight_Theme_Contact
 *
 * @since 1.2.0
 *
 *
 */
class Black_Knight_Theme_Contact {
  private $version;

  /*
   *   C L A S S   C O N S T R U C T O R
   */
  public function __construct( $version ) {
    $this->version = $version;
  }

  /*
   *   I N I T I A L I Z E   C O N T A C T   C P T
   */
  public function init_contact() {
    register_post_type( 'bkcpt_contact', array(
      'labels'             => array(
        'name'               => 'Contact',
        'singular_name'      => 'Contact',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Contact',
        'edit_item'          => 'Edit Contact',
        'new_item'           => 'New Contact',
        'all_items'          => 'All Contact',
        'view_item'          => 'View Contact',
        'search_items'       => 'Search Contact',
        'not_found'          => 'No Contact found',
        'not_found_in_trash' => 'No Contact found in Trash',
        'menu_name'          => 'Contact'
      ),
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'rewrite'            => true,
      'capability_type'    => 'post',
      'has_archive'        => true,
      'hierarchical'       => false,
      'menu_position'      => 11,
      'supports'           => array( 'title', 'editor', 'thumbnail' ),
      'menu_icon'          => 'dashicons-format-gallery'
    ) );
  }

  /*
   *   A D D   C O N T A C T   C P T
   */
  public function add_contact_meta_box() {
    add_meta_box( 'bkcpt_contact_meta' , __( 'Contact Options', 'dhd-rs1' ), array( $this, 'contact_meta_box'), 'bkcpt_contact', 'normal', 'default');
  }
  /*
   *   C O N T A C T   C P T  -  A D M I N   F O R M
   */
  public function contact_meta_box( $post ) {
    // RETRIEVE OUR CUSTOM META BOX VALUES
    $contact_data = get_post_meta( $post->ID, '_contact_data',  true );          /*   GET POST: Data Array           */
    $contact_data_map = get_post_meta( $post->ID, '_contact_data_map',  true );  /*   GET POST: Data Array           */

    $contact_hours      = ( ! empty( $contact_data['contact_hours'] ) ) ? $contact_data['contact_hours']  : '';
    $contact_name       = ( ! empty( $contact_data['contact_name']  ) ) ? $contact_data['contact_name']   : '';
    $contact_location   = ( ! empty( $contact_data['contact_loc']   ) ) ? $contact_data['contact_loc']    : '';
    $contact_address    = ( ! empty( $contact_data['contact_address']  ) ) ? $contact_data['contact_address']   : '';
    $contact_city       = ( ! empty( $contact_data['contact_city']  ) ) ? $contact_data['contact_city']   : '';
    $contact_state      = ( ! empty( $contact_data['contact_state'] ) ) ? $contact_data['contact_state']  : '';
    $contact_zip        = ( ! empty( $contact_data['contact_zip']   ) ) ? $contact_data['contact_zip']    : '';
    $contact_phone      = ( ! empty( $contact_data['contact_phone'] ) ) ? $contact_data['contact_phone']  : '';
    $contact_email      = ( ! empty( $contact_data['contact_email'] ) ) ? $contact_data['contact_email']  : '';


    // NONCE FIELD FOR SECURITY
    wp_nonce_field( 'save_contact_meta', 'bkcpt_contact_meta_box' );

    // DISPLAY META BOX FORM
    echo '<div class="contact-form"><table><tr><th>Hours Of Operation</th><td>';
    if ( $contact_hours ) {
      echo '<input type="text" name="contact_data[contact_hours]" id="contact_data[contact_hours]" value="'. $contact_hours .'" style="width:10rem;" />';
    } else {
      echo '<input type="text" name="contact_data[contact_hours]" id="contact_data[contact_hours]" value="" style="width:10rem;" placeholder="eg: 11:00am - 2:00am" />';
    }
    echo '</td></tr><tr><th>Business Name</th><td>';
    if ( $contact_name ) {
      echo '<input type="text" name="contact_data[contact_name]" id="contact_data[contact_name]" value="'. $contact_name .'" style="width:20rem;" />';
    } else {
      echo '<input type="text" name="contact_data[contact_name]" id="contact_data[contact_name]" value="" style="width:20rem;" placeholder="eg: Joe\'s Bar" />';
    }
    echo '</td></tr><tr><th>Complex Name</th><td>';
    if ( $contact_location ) {
      echo '<input type="text" name="contact_data[contact_loc]" id="contact_data[contact_loc]" value="'. $contact_location .'" style="width:20rem;" />';
    } else {
      echo '<input type="text" name="contact_data[contact_loc]" id="contact_data[contact_loc]" value="" style="width:20rem;" placeholder="eg: The Spectrum Center" />';
    }
    echo '</td></tr><tr><th>Address</th><td>';
    if ( $contact_address ) {
      echo '<input type="text" name="contact_data[contact_address]" id="contact_data[contact_address]" value="'. $contact_address .'" style="width:20rem;" />';
    } else {
      echo '<input type="text" name="contact_data[contact_address]" id="contact_data[contact_address]" value="" style="width:20rem;" placeholder="eg: 1870 32nd Street" />';
    }
    echo '</td></tr><tr><th>City</th><td>';
    if ( $contact_city ) {
      echo '<input type="text" name="contact_data[contact_city]" id="contact_data[contact_city]" value="'. $contact_city .'" style="width:20rem;" />';
    } else {
      echo '<input type="text" name="contact_data[contact_city]" id="contact_data[contact_city]" value="" style="width:20rem;" placeholder="Las Vegas" />';
    }
    echo '</td></tr><tr><th>State</th><td>';
    if ( $contact_state ) {
      echo '<input type="text" name="contact_data[contact_state]" id="contact_data[contact_state]" value="'. $contact_state .'" style="width:20rem;" />';
    } else {
      echo '<input type="text" name="contact_data[contact_state]" id="contact_data[contact_state]" value="" style="width:20rem;" placeholder="eg: NV or Nevada" />';
    }
    echo '</td></tr><tr><th>Zip</th><td>';
    if ( $contact_zip ) {
      echo '<input type="text" name="contact_data[contact_zip]" id="contact_data[contact_zip]" value="'. $contact_zip .'" style="width:10rem;" />';
    } else {
      echo '<input type="text" name="contact_data[contact_zip]" id="contact_data[contact_zip]" value="" style="width:10rem;" placeholder="eg: 92546" />';
    }
    echo '</td></tr><tr><th>Phone</th><td>';
    if ( $contact_phone ) {
      echo '<input type="text" name="contact_data[contact_phone]" id="contact_data[contact_phone]" value="'. $contact_phone .'" style="width:20rem;" />';
    } else {
      echo '<input type="text" name="contact_data[contact_phone]" id="contact_data[contact_phone]" value="" style="width:20rem;" placeholder="eg: (555) 123-4567" />';
    }
    echo '</td></tr><tr><th>Email</th><td>';
    if ( $contact_email ) {
      echo '<input type="text" name="contact_data[contact_email]" id="contact_data[contact_email]" value="'. $contact_email .'" style="width:20rem;" />';
    } else {
      echo '<input type="text" name="contact_data[contact_email]" id="contact_data[contact_email]" value="" style="width:20rem;" placeholder="A Valid Email Address" />';
    }
    echo '</td></tr><tr><th>Map</th><td>';
    if ( $contact_data_map ) {
      echo '<input type="text" name="contact_data_map" id="contact_data_map" value="'. $contact_data_map .'" style="width:80rem;" />';
    } else {
      echo '<input type="text" name="contact_data_map" id="contact_data_map" value="" style="width:80rem;" placeholder="Google Maps Info" />';
    }
    echo '</td></tr></table></div>';
  }
  /*
   *   S A V E   C O N T A C T   C P T   M E T A   F O R M
   */
  function save_contact_meta_box( $post_id ) {
    if ( get_post_type( $post_id ) == 'bkcpt_contact' ) {                    // VERIFY THE POST TYPE IS FOR contact AND METADATA HAS BEEN POSTED
      if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                    // IF AUTOSAVE SKIP SAVING DATA
        return;
      wp_verify_nonce( 'save_contact_meta', 'bkcpt_contact_meta_box' );     // CHECK NONCE FOR SECURITY

      if ( isset( $_POST['contact_data_map'] ) ) {
        $contact_data_map = $_POST['contact_data_map'];                           // GET contact GOOGLE MAP DATA
        update_post_meta( $post_id, '_contact_data_map', $contact_data_map );     // SAVE THE contact GOOGLE MAP DATA AS POST METADATA
      }
      if ( isset( $_POST['contact_data'] ) ) {
        $contact_data = $_POST['contact_data'];                             // GET contact DATA ARRAY
        update_post_meta( $post_id, '_contact_data', $contact_data );       // SAVE THE contact DATA ARRAY AS POST METADATA
      }
    }
  }
  /*
   *
   *   M A N A G E _ A U T O P
   *
   *   Removes the paragraph tag from certain post types.
   *
   *   List Of Post Types:     Filter P Tag
   *   -------------------------------------------------------------------------------------
   *   post                    No
   *   page                    No
   *   image                   Yes
   *   rs_faq                  Yes
   *   rs_contact             Yes
   *
   */
  function manage_autop( $content ) {
    global $post;

    $post_type = $post->post_type;

    switch ($post_type) {
      case 'image':
        remove_filter('the_content', 'wpautop');
        break;
      case 'bkcpt_contact':
        remove_filter('the_content', 'wpautop');
        break;
      case 'rs_faq':
        remove_filter('the_content', 'wpautop');
        add_filter( 'the_content', 'black_knight_t1_faq_content' );  /* OPTIONALLY ADD A CUSTOM FILTER */
        break;
      case 'rs_trio': /* CASE WHERE ONE TYPE FOLLOWS THE OTHER AND MUST BE RESET */
        add_filter( 'the_content', 'wpautop' );
        break;
      case 'rs_menu_item': /* CASE WHERE ONE TYPE FOLLOWS THE OTHER AND MUST BE RESET */
        add_filter( 'the_content', 'wpautop' );
        break;
    }
    return $content;
  }

}

