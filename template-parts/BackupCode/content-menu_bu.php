
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

/*************************************************************************************************/
/***                                                                                           ***/
/***   T O P   L E V E L   O F   T A X O N O M Y                                               ***/
/***                                                                                           ***/
/***   GET THE TOP LEVEL OF THE TAXONOMY rs_menu_type BY SETTING PARENT TO ZERO                ***/
/***   THE TOP LEVEL ARE THE MENUS FOR BREAKFAST, BRUNCH, LUNCH, DINNER, ETC...                ***/
/***                                                                                           ***/
/*************************************************************************************************/
$args1 = array(
  'taxonomy'      => 'rs_menu_type',
  'orderby'       =>  'meta_value_num',
  'order'         =>  'ASC',
  'hide_empty'    => false,
  'hierarchical'  =>  false,
  'parent'        =>  0,
  'meta_query'    => [[
    'key'   => '_menu_type_order',
    'type'  => 'NUMERIC',
  ]],
);

$terms = get_terms( $args1 );

if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
  $tab_control_htm = '';
  $tab_content_htm = '';
  $loop_count = 0;
  /*********************************************************************************************/
  /***   M E N U   L O O P   ( Breakfast, Lunch, Dinner )   Tab Control Outer                ***/
  /*********************************************************************************************/
  foreach( $terms as $term ) :
    $loop_count++;
    $tab_id_1 = 'id1_'. $loop_count;
    $tab_id_2 = 'id2_'. $loop_count .'_tab';

    if ( $loop_count == 1 ) {
      $tab_control_htm .= '<li class="nav-item"><a href="#'. $tab_id_1 .'" id="'. $tab_id_2 .'" class="nav-link active" data-toggle="tab" role="tab" aria-controls="'. $tab_id_1 .'" aria-selected="true">'. $term->name .'</a></li>';
      $tab_content_htm .= '<div id="'. $tab_id_1 .'" class="tab-pane fade show active" role="tabpanel" aria-labelledby="'. $tab_id_2 .'" >';
      $tab_content_htm .= '<div class="row gal-row">';
    } else {
      $tab_control_htm .= '<li class="nav-item"><a href="#'. $tab_id_1 .'" id="'. $tab_id_2 .'" class="nav-link" data-toggle="tab" role="tab" aria-controls="'. $tab_id_1 .'" aria-selected="false">'. $term->name .'</a></li>';
      $tab_content_htm .= '<div id="'. $tab_id_1 .'" class="tab-pane fade" role="tabpanel" aria-labelledby="'. $tab_id_2 .'" >';
      $tab_content_htm .= '<div class="row gal-row">';
    }

    $args2 = array(
      'taxonomy'      => 'rs_menu_type',
      'orderby'       =>  'meta_value_num',
      'order'         =>  'ASC',
      'hide_empty'    => false,
      'hierarchical'  =>  false,
      'parent'        =>  $term->term_id,
      'meta_query'    => [[
        'key'   => '_menu_type_order',
        'type'  => 'NUMERIC',
      ]],
    );

    $sections = get_terms( $args2 );

    if ( ! empty( $sections ) && ! is_wp_error( $sections ) ) :
      foreach( $sections as $section ) :

        $tab_content_htm .= '<div class="col-md-6"><h1>'. $section->name .'</h1>';

        /*****************************************************************************************/
        /***   M E N U   S E C T I O N   L O O P                                               ***/
        /*****************************************************************************************/
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
            'meta_key'        => '_menu_item_order',
        );
        $mnMenuItems = new WP_Query( $mnSectionItemsArgs );
        if ( $mnMenuItems->have_posts() ) :
          //$tab_content_htm .= '';
          /***************************************************************************************/
          /***   M E N U   S E C T I O N   I T E M S   L O O P                                 ***/
          /***************************************************************************************/
          while ( $mnMenuItems->have_posts() ) :
            $mnMenuItems->the_post();

            $menu_item_title = get_post_meta( get_the_ID(), '_menu_item_title', true );
            $menu_item_price = get_post_meta( get_the_ID(), '_menu_item_price', true );

            //$tab_content_htm .= '<div class="col-md-4">';
            $tab_content_htm .= '<div class="card">';
            if ( has_post_thumbnail() ) :
              $tab_content_htm .= get_the_post_thumbnail( get_the_ID(), 'medium', array('class' => 'card-img-top') );
            endif;
            $tab_content_htm .= '<div class="card-body"><h4 class="card-title">'. get_the_title() .'</h4>';

            $tab_content_htm .= '<div class="dot-lead"><div>'. $menu_item_title .'</div><div>'. $menu_item_price .'</div></div>';


            $tab_content_htm .= '<p class="card-text">'. get_the_content() .'</p>';
            $tab_content_htm .= '</div><!-- .card-body --></div><!-- .card -->';
            //$tab_content_htm .= '</div><!-- .col-md-4 -->';
          endwhile;
        else :
          ?><p><?php _e( 'No Section Item Posts.', 'dhd-vr1' ); ?></p><?php
        endif;
        // RESET POST DATA
        wp_reset_postdata();

        $tab_content_htm .= '</div><!-- .col-md-6 -->';

      endforeach;

      $tab_content_htm .= '</div><!-- .row --></div><!-- .tab-pane -->';

    else :
      ?><h2>Found No Sections</h2><?php
    endif;
  endforeach;
  ?>
  <ul class="nav nav-tabs" id="vrTabControl" role="tablist">
    <?php echo $tab_control_htm;  ?>
  </ul>
  <div class="tab-content" id="vrTabContent">
    <?php echo $tab_content_htm;  ?>
  </div><!-- .tab-content -->

  <?php

else :
  ?><h1>Found Nothing</h1><?php
endif;





