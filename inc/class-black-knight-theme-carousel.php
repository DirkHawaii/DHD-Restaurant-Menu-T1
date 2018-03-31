<?php

/**
 * Class: Black_Knight_Theme_Carousel
 *
 * @since 1.2.0
 *
 *
 */
class Black_Knight_Theme_Carousel {
  private $version;

  /*
   *   C L A S S   C O N S T R U C T O R
   */
  public function __construct( $version ) {
    $this->version = $version;
  }

  /*
   *   I N I T I A L I Z E   C A R O U S E L   C P T
   */
  public function init_carousel() {
    register_post_type( 'bkcpt_carousel', array(
      'labels'             => array(
        'name'               => 'Carousel',
        'singular_name'      => 'Carousel',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Carousel',
        'edit_item'          => 'Edit Carousel',
        'new_item'           => 'New Carousel',
        'all_items'          => 'All Carousel',
        'view_item'          => 'View Carousel',
        'search_items'       => 'Search Carousel',
        'not_found'          => 'No Carousel found',
        'not_found_in_trash' => 'No Carousel found in Trash',
        'menu_name'          => 'Carousel'
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
   *   A D D   C A R O U S E L   C P T
   */
  public function add_carousel_meta_box() {
    add_meta_box( 'bkcpt_carousel_meta' , __( 'Carousel Options', 'dhd-rs1' ), array( $this, 'carousel_meta_box'), 'bkcpt_carousel', 'normal', 'default');
  }
  /*
   *   C A R O U S E L   C P T  -  A D M I N   F O R M
   */
  public function carousel_meta_box( $post ) {
    // RETRIEVE OUR CUSTOM META BOX VALUES
    $carousel_order        = get_post_meta( $post->ID, '_carousel_order', true );          /*   GET POST: Order                */
    $carousel_data         = get_post_meta( $post->ID, '_carousel_data',  true );          /*   GET POST: Data Array           */

    $carousel_position     = ( ! empty( $carousel_data['position']     ) ) ? $carousel_data['position']     : '';
    $carousel_title_color  = ( ! empty( $carousel_data['title_color']  ) ) ? $carousel_data['title_color']  : '';
    $carousel_title_shadow = ( ! empty( $carousel_data['title_shadow'] ) ) ? $carousel_data['title_shadow'] : '';
    $carousel_text_color   = ( ! empty( $carousel_data['text_color']   ) ) ? $carousel_data['text_color']   : '';
    $carousel_text_shadow  = ( ! empty( $carousel_data['text_shadow']  ) ) ? $carousel_data['text_shadow']  : '';

    // NONCE FIELD FOR SECURITY
    wp_nonce_field( 'save_carousel_meta', 'bkcpt_carousel_meta_box' );

    // DISPLAY META BOX FORM
    echo '<div class="carousel-form"><table><tr><th>Order:</th><td>';
    if ( $carousel_order ) {
      echo '<input type="text" name="carousel_order" id="carousel_order" value="'. $carousel_order .'" style="width:2rem;" />';
    } else {
      echo '<input type="text" name="carousel_order" id="carousel_order" value="0" style="width:2rem;" />';
    }
    echo '</td><th>Position: </th><td>';
    echo '<select name="carousel_data[text_position]" id="carousel_data[text_position]">';
    echo '<option value="center" ' .selected( $carousel_position, 'center', false ). '>Center</option>';
    echo '<option value="left" '   .selected( $carousel_position, 'left',   false ). '>Left</option>';
    echo '<option value="right" '  .selected( $carousel_position, 'right',  false ). '>Right</option>';
    echo '</select>';
    echo '</td><th>Title Color: </th><td>';
    if ( $carousel_title_color ) {
      echo '<input type="text" class="bkt2-color-picker" name="carousel_data[title_color]" id="carousel_data[title_color]" value="'. $carousel_title_color .'" style="width:4rem;" />';
    } else {
      echo '<input type="text" class="bkt2-color-picker" name="carousel_data[title_color]" id="carousel_data[title_color]" value="ffffff" style="width:4rem;" />';
    }
    echo '</td><th>Title Shadow: </th><td>';
    if ( $carousel_title_shadow ) {
      echo '<input type="text" class="bkt2-color-picker" name="carousel_data[title_shadow]" id="carousel_data[title_shadow]" value="'. $carousel_title_shadow .'" style="width:4rem;" />';
    } else {
      echo '<input type="text" class="bkt2-color-picker" name="carousel_data[title_shadow]" id="carousel_data[title_shadow]" value="000000" style="width:4rem;" />';
    }
    echo '</td><th>Text Color: </th><td>';
    if ( $carousel_text_color ) {
      echo '<input type="text" class="bkt2-color-picker" name="carousel_data[text_color]" id="carousel_data[text_color]" value="'. $carousel_text_color .'" style="width:4rem;" />';
    } else {
      echo '<input type="text" class="bkt2-color-picker" name="carousel_data[text_color]" id="carousel_data[text_color]" value="ffffff" style="width:4rem;" />';
    }
    echo '</td><th>Text Shadow: </th><td>';
    if ( $carousel_text_color ) {
      echo '<input type="text" class="bkt2-color-picker" name="carousel_data[text_shadow]" id="carousel_data[text_shadow]" value="'. $carousel_text_shadow .'" style="width:4rem;" />';
    } else {
      echo '<input type="text" class="bkt2-color-picker" name="carousel_data[text_shadow]" id="carousel_data[text_shadow]" value="ffffff" style="width:4rem;" />';
    }
    echo '</td></tr></table></div>';
  }
  /*
   *   S A V E   C A R O U S E L   C P T   M E T A   F O R M
   */
  function save_carousel_meta_box( $post_id ) {
    if ( get_post_type( $post_id ) == 'bkcpt_carousel' ) {                    // VERIFY THE POST TYPE IS FOR CAROUSEL AND METADATA HAS BEEN POSTED
      if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                    // IF AUTOSAVE SKIP SAVING DATA
        return;
      wp_verify_nonce( 'save_carousel_meta', 'bkcpt_carousel_meta_box' );     // CHECK NONCE FOR SECURITY

      if ( isset( $_POST['carousel_order'] ) ) {
        $carousel_order = $_POST['carousel_order'];                           // GET CAROUSEL ORDER POSITION DATA
        update_post_meta( $post_id, '_carousel_order', $carousel_order );     // SAVE THE CAROUSEL ORDER POSITION DATA AS POST METADATA
      }
      if ( isset( $_POST['carousel_data'] ) ) {
        $carousel_data = $_POST['carousel_data'];                             // GET CAROUSEL DATA ARRAY
        update_post_meta( $post_id, '_carousel_data', $carousel_data );       // SAVE THE CAROUSEL DATA ARRAY AS POST METADATA
      }
    }
  }

  /*
   *   COLOR PICKER SCRIPTS
   */
  public function color_picker_scripts() {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker' );

    //wp_enqueue_script( 'bkt2-color-picker-handle', plugins_url( 'custom-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );

    wp_enqueue_script( 'bkt2-color-picker-handle', get_template_directory_uri() .'/js/jquery.custom.js', array( 'jquery', 'wp-color-picker' ), $this->version, true );



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
   *   rs_carousel             Yes
   *
   */
  function manage_autop( $content ) {
    global $post;

    $post_type = $post->post_type;

    switch ($post_type) {
      case 'image':
        remove_filter('the_content', 'wpautop');
        break;
      case 'bkcpt_carousel':
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

