<?php
/*************************************************************************************************/
/***                                                                                           ***/
/***   M E N U S                                                                               ***/
/***                                                                                           ***/
/***   Render the contents of the rs_menu custom post type.                                    ***/
/***                                                                                           ***/
/***   There can be many posts for this type                                                   ***/
/***                                                                                           ***/
/*************************************************************************************************/
$restmenu_options_arr = get_option( 'restaurant_menu_options' );  // LOAD THE PLUGIN OPTIONS ARRAY
$show_cents = ( ! empty( $restmenu_options_arr['show_cents'] ) ) ? $restmenu_options_arr['show_cents'] : false;
$dot_lead = ( ! empty( $restmenu_options_arr['dot_lead'] ) ) ? $restmenu_options_arr['dot_lead'] : false;
$currency_sign = ( ! empty( $restmenu_options_arr['currency_sign'] ) ) ? $restmenu_options_arr['currency_sign'] : '';

/*************************************************************************************************/
/***                                                                                           ***/
/***   T O P   L E V E L   O F   T A X O N O M Y   Q U E R Y  -  T A B S                       ***/
/***                                                                                           ***/
/***   GET THE TOP LEVEL OF THE TAXONOMY rs_menu_type BY SETTING PARENT TO ZERO                ***/
/***   THE TOP LEVEL ARE THE MENU TABS FOR BREAKFAST, BRUNCH, LUNCH, DINNER, ETC...            ***/
/***                                                                                           ***/
/*************************************************************************************************/
$terms = get_terms( array(
  'taxonomy'      => 'rs_menu_type',
  'orderby'       =>  'meta_value_num',
  'order'         =>  'ASC',
  'hide_empty'    => false,
  'hierarchical'  =>  false,
  'parent'        =>  0,
  'meta_query'    => [[
    'key'   => '_taxonomy_tab_order',
    'type'  => 'NUMERIC',
  ]],
) );

if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
  $tab_htm_control = '';
  $tab_htm_content = '';
  $loop_count = 0;
  /*********************************************************************************************/
  /***   M E N U   L O O P   ( Breakfast, Lunch, Dinner )   Tab Control Outer                ***/
  /*********************************************************************************************/
  foreach( $terms as $term ) :
    $loop_count++;
    $tab_id_1 = 'id1_'. $loop_count;
    $tab_id_2 = 'id2_'. $loop_count .'_tab';

    if ( $loop_count == 1 ) {
      $tab_htm_control .= '<li class="nav-item"><a href="#'. $tab_id_1 .'" id="'. $tab_id_2 .'" class="nav-link active" data-toggle="tab" role="tab" aria-controls="'. $tab_id_1 .'" aria-selected="true">'. $term->name .'</a></li>';
      $tab_htm_content .= '<div id="'. $tab_id_1 .'" class="tab-pane fade show active" role="tabpanel" aria-labelledby="'. $tab_id_2 .'" >';
      $tab_htm_content .= '<div class="row gal-row">';
    } else {
      $tab_htm_control .= '<li class="nav-item"><a href="#'. $tab_id_1 .'" id="'. $tab_id_2 .'" class="nav-link" data-toggle="tab" role="tab" aria-controls="'. $tab_id_1 .'" aria-selected="false">'. $term->name .'</a></li>';
      $tab_htm_content .= '<div id="'. $tab_id_1 .'" class="tab-pane fade" role="tabpanel" aria-labelledby="'. $tab_id_2 .'" >';
      $tab_htm_content .= '<div class="row gal-row">';
    }

    /*********************************************************************************************/
    /***                                                                                       ***/
    /***   S E C O N D   L E V E L   O F   T A X O N O M Y   Q U E R Y  -  S E C T I O N S     ***/
    /***                                                                                       ***/
    /***   GET THE SECOND LEVEL OF THE TAXONOMY rs_menu_type BY SETTING PARENT TO              ***/
    /***   $term->term_id FROM THE PREVIOUS QUERY. THIS WILL GIVE THE MENU SECTIONS.           ***/
    /***                                                                                       ***/
    /*********************************************************************************************/
    $sections = get_terms( array(
      'taxonomy'      => 'rs_menu_type',
      'orderby'       =>  'meta_value_num',
      'order'         =>  'ASC',
      'hide_empty'    => false,
      'hierarchical'  =>  false,
      'parent'        =>  $term->term_id,
      'meta_query'    => array(
        'key'   => '_taxonomy_col_order',
        'type'  => 'NUMERIC',
      ),
    ) );

    if ( ! empty( $sections ) && ! is_wp_error( $sections ) ) :
      /*******************************************************************************************/
      /***   M E N U   S E C T I O N   L O O P                                                 ***/
      /*******************************************************************************************/
      foreach( $sections as $section ) :

        $tab_htm_content .= '<div class="col-md-6"><h1>'. $section->term_id .' - '. $section->name .'</h1><p>'. $section->slug .'</p><p>Meta:'. $section->meta .'</p>';

        $mnSectionItemsArgs = array(
            'posts_per_page'  => -1,
            'post_type'       => 'rs_menu_item',
            'tax_query' => array(
              array(
                'taxonomy'  => 'rs_menu_type',
                'field'     => 'slug',
                'terms'     => array( 'slug' => $section->slug, 'name' => $section->name )
              )
            ),
            'orderby'         => 'meta_value_num',
            'order'         =>  'ASC',
            'meta_key'        => '_menu_item_order',
        );
        $mnMenuItems = new WP_Query( $mnSectionItemsArgs );

        if ( $mnMenuItems->have_posts() ) :
          //$tab_htm_content .= '';
          /***************************************************************************************/
          /***   M E N U   S E C T I O N   I T E M S   L O O P                                 ***/
          /***************************************************************************************/
          while ( $mnMenuItems->have_posts() ) :
            $mnMenuItems->the_post();

            $item_price_str = '';
            $price_str = '';
            $menu_item_title = get_post_meta( get_the_ID(), '_menu_item_title', true );  // String: Item
                                                                                         //      or One Item|Two Items|Three Items|Four Items
            $menu_item_price = get_post_meta( get_the_ID(), '_menu_item_price', true );  // String: 12.50
                                                                                         //      or 12.50,14.50,16.50
                                                                                         //      or 12.50 or 12.50,14.50,16.50|13.50,15.50,17.50|14.50,16.50,18.50


            if ( strpos( $menu_item_title, '|' ) === false ) {  // IT IS NOT A LIST OF TITLES
              $price_str = '<div class="dot-lead"><div>'. $menu_item_title .'</div><div>'. $menu_item_price .'</div></div>';
            } else {                                            // IT IS A LIST OF TITLES AND NEEDS TO BE EXPANDED INTO AN ARRAY AND LOOPED THROUGH
              $item_title_ar = explode('|', $menu_item_title);  // EXAMPLE title|title|title...
              $item_price_ar = explode('|', $menu_item_price);  // EXAMPLE price,price,price|price,price,price|price,price,price... or price:price:price...
              for ($i = 0; $i < count($item_title_ar); ++$i) {        // LOOP THROUGH ARRAY OF TITLES
                if ( strpos( $item_price_ar[$i], ',' ) === false ) {    // IT IS A SINGLE PRICE
                  $price_val = floatval( $item_price_ar[$i] );            // CONVERT TO A FLOAT
                  if ($show_cents) {
                    $item_price_str = $currency_sign . round( $price_val, 2 );  // SHOW CENTS IS TRUE SO SHOW TWO DECIMAL PLACES
                  } else {
                    $item_price_str = $currency_sign . round( $price_val, 0 );  // SHOW CENTS IS FALSE SO SHOW NO DECIMAL PLACES
                  }
                  if ($dot_lead) {
                    $price_str = '<div class="dot-lead"><div>'. $item_title_ar[$i] .'</div><div>'. $item_price_str .'</div></div>';
                  } else {
                    $price_str = '<div class="not-lead"><div>'. $item_title_ar[$i] .'</div><div>'. $item_price_str .'</div></div>';
                  }
                } else {                                                // IT IS A LIST OF PRICES
                  $price_ar = explode(',', $menu_item_price);  // CREATE ARRAY FROM THE STRING

                  for ($j = 0; $j < count($price_ar); ++$j) {  // LOOP THROUGH ARRAY OF PRICES
                    // CONVERT TO A FLOAT
                    $price_val = floatval( $price_ar[$j] );  // WAYS TO DISPLAY: $12.00/$14.00/$16.00  OR  $12/$14/$16  OR  12.00/14.00/16.00  OR  12/14/16
                    if ($show_cents) {
                      $item_price_str = $currency_sign . round( $price_val, 2 );  // SHOW CENTS IS TRUE SO SHOW TWO DECIMAL PLACES
                    } else {
                      $item_price_str = $currency_sign . round( $price_val, 0 );  // SHOW CENTS IS FALSE SO SHOW NO DECIMAL PLACES
                    }
                    if ( $j == 0 ) { // FIRST TIME THROUGH
                      $partial_price_str = $item_price_str;
                    } else {
                      $partial_price_str .= '/'. $item_price_str;
                    }
                  } // END PRICE LOOP
                  if ($dot_lead) {
                    $price_str = '<div class="dot-lead"><div>'. $item_title_ar[$i] .'</div><div>'. $partial_price_str .'</div></div>';
                  } else {
                    $price_str = '<div class="not-lead"><div>'. $item_title_ar[$i] .'</div><div>'. $partial_price_str .'</div></div>';
                  }
                }
              }
            }
            $tab_htm_content .= '<div class="card">';
            if ( has_post_thumbnail() ) :
              $tab_htm_content .= get_the_post_thumbnail( get_the_ID(), 'medium', array('class' => 'card-img-top') );
            endif;
            $tab_htm_content .= '<div class="card-body"><h4 class="card-title">'. get_the_ID() .' - '. get_the_title() .'</h4>';

            $tab_htm_content .= $price_str;
            //$tab_htm_content .= '<div class="dot-lead"><div>'. $menu_item_title .'</div><div>'. $menu_item_price .'</div></div>';
            $tab_htm_content .= '<p class="card-text">'. get_the_content() .'</p>';
            $tab_htm_content .= '</div><!-- .card-body --></div><!-- .card -->';
            //$tab_htm_content .= '</div><!-- .col-md-4 -->';
          endwhile;
        else :
          ?><p><?php

            // _e( 'No Section Item Posts.', 'dhd-vr1' );

            ?></p><?php
        endif;
        // RESET POST DATA
        wp_reset_postdata();

        $tab_htm_content .= '</div><!-- .col-md-6 -->';

      endforeach;

      $tab_htm_content .= '</div><!-- .row --></div><!-- .tab-pane -->';

    else :
      ?><h2>Found No Sections</h2><?php
    endif;
  endforeach;
  ?>
  <ul class="nav nav-tabs" id="vrTabControl" role="tablist">
    <?php echo $tab_htm_control;  ?>
  </ul>
  <div class="tab-content" id="vrTabContent">
    <?php echo $tab_htm_content;  ?>
  </div><!-- .tab-content -->

  <?php

else :
  ?><h1>Found Nothing</h1><?php
endif;


