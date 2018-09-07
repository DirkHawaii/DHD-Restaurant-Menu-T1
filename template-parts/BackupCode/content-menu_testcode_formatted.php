<?php

$restmenu_options_arr = get_option( 'restaurant_menu_options' );  // LOAD THE PLUGIN OPTIONS ARRAY
$show_cents = ( ! empty( $restmenu_options_arr['show_cents'] ) ) ? $restmenu_options_arr['show_cents'] : false;
$dot_lead = ( ! empty( $restmenu_options_arr['dot_lead'] ) ) ? $restmenu_options_arr['dot_lead'] : false;
$currency_sign = ( ! empty( $restmenu_options_arr['currency_sign'] ) ) ? $restmenu_options_arr['currency_sign'] : '';

/*
 *   Custom Post Types & Meta Data
 *
 *   Tabs:                rs_menu_tab
 *     CPT Meta
 *        Tab Order            _menu_tab_order        Textbox
 *        Tab Columns          _menu_tab_columns      Textbox
 *
 *   Sections:            rs_menu_section
 *     CPT Meta
 *        Tab ID               _menu_tab_id           Select
 *        Section Column       _menu_section_col      Textbox
 *        Section Row          _menu_section_row      Textbox
 *
 *
 *   Items:               rs_menu_item
 *     CPT Meta
 *        Section ID           _menu_section_id       Select
 *        Item Order           _menu_item_order       Textbox
 *        Item Title           _menu_item_title       Textbox
 *        Item Price           _menu_item_price       Textbox
 */

/*
 *   GET MENU TABS
 */
$menu_tabs = new WP_Query( array(
    'posts_per_page'  => -1,
    'post_type'       => 'rs_menu_tab',
    'orderby'         => 'meta_value_num',
    'order'           =>  'ASC',
    'meta_key'        => '_menu_tab_order',
) );
if ( $menu_tabs->have_posts() ) :
  $tab_htm_control = '';
  $tab_htm_content = '';
  $tab_count = 0;
  while ( $menu_tabs->have_posts() ) :  // TAB LOOP
    $menu_tabs->the_post();
    $tab_count++;
    $tab_id_1 = 'id1_'. $tab_count;
    $tab_id_2 = 'id2_'. $tab_count .'_tab';

    $menu_tab_order = get_post_meta( get_the_ID(), '_menu_tab_order', true );
    $menu_tab_columns = get_post_meta( get_the_ID(), '_menu_tab_columns', true );  // THE NUMBER OF COLUMNS IN THE TAB
    $menu_tab_id = get_the_ID();
    $menu_tab_title = get_the_title();

    $section_class = '';
    switch (intval($menu_tab_columns)) {
      case 1:
        $section_class = 'menu-column col-md-12';
        break;
      case 2:
        $section_class = 'menu-column col-md-6';
        break;
      case 3:
        $section_class = 'menu-column col-md-4';
        break;
    }

    if ( $tab_count == 1 ) {
      $tab_htm_control .= '<li class="nav-item"><a href="#'. $tab_id_1 .'" id="'. $tab_id_2 .'" class="nav-link active" data-toggle="tab" role="tab" aria-controls="'. $tab_id_1 .'" aria-selected="true">'. $menu_tab_title .'</a></li>';
      $tab_htm_content .= '<div id="'. $tab_id_1 .'" class="tab-pane fade show active" role="tabpanel" aria-labelledby="'. $tab_id_2 .'" ><div>'. get_the_content() .'</div>';
      $tab_htm_content .= '<div class="row gal-row">';
    } else {
      $tab_htm_control .= '<li class="nav-item"><a href="#'. $tab_id_1 .'" id="'. $tab_id_2 .'" class="nav-link" data-toggle="tab" role="tab" aria-controls="'. $tab_id_1 .'" aria-selected="false">'. $menu_tab_title .'</a></li>';
      $tab_htm_content .= '<div id="'. $tab_id_1 .'" class="tab-pane fade" role="tabpanel" aria-labelledby="'. $tab_id_2 .'" ><div>'. get_the_content() .'</div>';
      $tab_htm_content .= '<div id="menuWrap" class="row">';
    }

    /*
     *   GET MENU SECTIONS
     */
    $menu_sections = new WP_Query( array(
        'posts_per_page'  => -1,
        'post_type'       => 'rs_menu_section',
        'meta_query'      => array(
          'get_clause' => array( 'key' => '_menu_tab_id', 'value' => $menu_tab_id ),
          'col_clause' => array( 'key' => '_menu_section_col', 'compare' => 'EXISTS', 'type' => 'NUMERIC', ),
          'row_clause' => array( 'key' => '_menu_section_row', 'compare' => 'EXISTS', 'type' => 'NUMERIC', ),
        ),
        'orderby'  => array(
          'col_clause' => 'ASC',
          'row_clause' => 'ASC',
        ),
    ) );
    if ( $menu_sections->have_posts() ) :
      $section_count = 0;
      $current_column = 1;
      $tab_htm_content .= '<div class="'. $section_class .'">';
      while ( $menu_sections->have_posts() ) :  // SECTION LOOP
        $menu_sections->the_post();
        $section_count++;
        $menu_section_column = get_post_meta( get_the_ID(), '_menu_section_col', true );  // CURRENT COLUMN
        $menu_section_row = get_post_meta( get_the_ID(), '_menu_section_row', true );
        $menu_section_id = get_the_ID();
        $menu_section_title = get_the_title();

        if ($section_count == 1) {
          $current_column = intval($menu_section_column);
        }

        // TEST FOR COLUMN CHANGE
        if ( $current_column != $menu_section_column ) { // COLUMN HAS CHANGED
          $current_column = intval($menu_section_column);
          $tab_htm_content .= '</div><div class="'. $section_class .'">Column Change<br/>';
        }

        $tab_htm_content .= '<h1>'. $menu_section_title .'</h1><p>N:'. $section_count .' C:'. $menu_section_column .' R:'. $menu_section_row .'</p><p>'. get_the_content() .'</p>';

        /*
         *   GET MENU ITEMS
         */
        $menu_items = new WP_Query( array(
            'posts_per_page'  => -1,
            'post_type'       => 'rs_menu_item',
            'orderby'  => array(
              '_menu_item_order' => 'ASC'
            ),
            'meta_query'      => array( array(
              'key'   => '_menu_section_id',
              'value' => $menu_section_id
            ) )
        ) );
        if ( $menu_items->have_posts() ) :
          while ( $menu_items->have_posts() ) :  // ITEM LOOP
            $menu_items->the_post();
            $item_price_str = '';
            $price_str = '';
            $menu_item_title = get_post_meta( get_the_ID(), '_menu_item_title', true );  // String: Could be a simple single string or a delimited string
            $menu_item_price = get_post_meta( get_the_ID(), '_menu_item_price', true );  // String: Could be a simple single string or a delimited string
            if ( strpos( $menu_item_title, '|' ) === false ) {  // IT IS NOT A LIST OF TITLES
              $price_str = '<div class="dot-lead"><div>'. $menu_item_title .'</div><div>'. $menu_item_price .'</div></div>';
            } else {                                            // IT IS A LIST OF TITLES AND NEEDS TO BE EXPANDED INTO AN ARRAY AND LOOPED THROUGH
              $item_title_ar = explode('|', $menu_item_title);  // EXAMPLE title|title|title|...
              $item_price_ar = explode('|', $menu_item_price);  // EXAMPLE price|price|price|...  OR   price,price,price|price,price,price|price,price,price|...
              for ($i = 0; $i < count($item_title_ar); ++$i) {        // LOOP THROUGH ARRAY OF TITLES

                if ( strpos( $item_price_ar[$i], ',' ) === false ) {                                          /***   S I N G L E   P R I C E   ***/

                  $price_val = floatval( $item_price_ar[$i] );
                  if ($show_cents) {
                    $item_price_str = $currency_sign . number_format( $price_val, 2 );
                  } else {
                    $item_price_str = $currency_sign . number_format( $price_val, 0 );
                  }
                  if ($dot_lead) {
                    $price_str .= '<div class="dot-lead"><div>'. $item_title_ar[$i] .'</div><div>'. $item_price_str .'</div></div>';
                  } else {
                    $price_str .= '<div class="not-lead"><div>'. $item_title_ar[$i] .'</div><div>'. $item_price_str .'</div></div>';
                  }
                } else {                                                                                      /***   L I S T   O F   P R I C E S   ***/
                  $price_ar = explode(',', $item_price_ar[$i]);  // CREATE ARRAY FROM THE STRING
                  for ($j = 0; $j < count($price_ar); ++$j) {    // LOOP THROUGH ARRAY OF PRICES
                    // CONVERT ARRAY ITEM TO A FLOAT
                    $price_val = floatval( $price_ar[$j] );      // WAYS TO DISPLAY: $12.00/$14.00/$16.00  OR  $12/$14/$16  OR  12.00/14.00/16.00  OR  12/14/16

                    if ($show_cents) {
                      $item_price_str = $currency_sign . number_format( $price_val, 2 );  // SHOW CENTS IS TRUE SO SHOW TWO DECIMAL PLACES
                    } else {
                      $item_price_str = $currency_sign . number_format( $price_val, 0 );  // SHOW CENTS IS FALSE SO SHOW NO DECIMAL PLACES
                    }

                    if ( $j == 0 ) { // FIRST TIME THROUGH
                      $partial_price_str = $item_price_str;
                    } else {
                      $partial_price_str .= ' / '. $item_price_str;
                    }
                  } // END PRICE LOOP

                  if ($dot_lead) {
                    $price_str .= '<div class="dot-lead"><div>'. $item_title_ar[$i] .'</div><div>'. $partial_price_str .'</div></div>';
                  } else {
                    $price_str .= '<div class="not-lead"><div>'. $item_title_ar[$i] .'</div><div>'. $partial_price_str .'</div></div>';
                  }
                }
              }
            }
            $tab_htm_content .= '<div class="card">';
            if ( has_post_thumbnail() ) :
              $tab_htm_content .= get_the_post_thumbnail( get_the_ID(), 'medium', array('class' => 'card-img-top') );
            endif;
            $tab_htm_content .= '<div class="card-body"><h4 class="card-title">'. get_the_title() .'</h4>';

            $tab_htm_content .= $price_str;
            $tab_htm_content .= '<div class="card-text">'. get_the_content() .'</div>';
            $tab_htm_content .= '</div><!-- .card-body --></div><!-- .card -->';

          endwhile; // END OF ITEM LOOP
        else :
          ?><p><?php //_e( 'No Item Posts.', 'dhd-vr1' ); ?></p><?php
        endif;



      endwhile; // END OF SECTION LOOP
      $tab_htm_content .= '</div><!-- .end-column -->';
      $tab_htm_content .= '</div><!-- .row --></div><!-- .tab-pane -->';

    else :
      ?><p><?php _e( 'No Section Posts.', 'dhd-vr1' ); ?></p><?php
    endif;
  endwhile; // END OF TAB LOOP

  ?>
  <ul class="nav nav-tabs" id="vrTabControl" role="tablist">
    <?php echo $tab_htm_control;  ?>
  </ul>
  <div class="tab-content" id="vrTabContent">
    <?php echo $tab_htm_content;  ?>
  </div><!-- .tab-content -->

  <?php


else :
  ?><p><?php _e( 'No Tab Posts.', 'dhd-vr1' ); ?></p><?php
endif;
// RESET POST DATA
wp_reset_postdata();




