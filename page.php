<?php get_header(); ?>
<?php
/*************************************************************************************************/
/***                                                                                           ***/
/***   PAGES:       Post      CPT             Meta                Form Field                   ***/
/***   -------------------------------------------------------------------------------------   ***/
/***   charters     default   rs_charters     _charter_order      charter_order                ***/
/***                                          _charter_pricing    charter_price[title]         ***/
/***   about                                                      charter_price[price]         ***/
/***                                                                                           ***/
/***   gallery                rs_gallery                                                       ***/
/***                                                                                           ***/
/***   faq                    rs_faq                                                           ***/
/***                                                                                           ***/
/***   contact                rs_contact                                                       ***/
/***                                                                                           ***/
/***                                                                                           ***/
/*************************************************************************************************/

if ( is_page( 'about' )) :
  /*******************************************************************   A B O U T   P A G E   ***/
  get_template_part( 'template-parts/content', 'about' );

elseif ( is_page( 'menu' )) :
  /*********************************************************************   M E N U   P A G E   ***/
  if ( have_posts() ) :
    while ( have_posts() ) :
      the_post();
      get_template_part( 'template-parts/content', get_post_format() );     // REGULAR PAGE POST
    endwhile;
    $bkt2->the_posts_pagination();
  else :
    ?><p><?php _e( 'No Menu Posts', 'black_knight_t2' ); ?></p><?php
  endif;
  wp_reset_postdata();
  get_template_part( 'template-parts/content', 'menu' );                    // MENU CPT PAGE POST

elseif ( is_page( 'contact' )) :
  /***************************************************************   C O N T A C T   P A G E   ***/
  get_template_part( 'template-parts/content', 'contact' );

else :
  /************************************************************   N O T   ( A B O U T,   C O N T A C T,   M E N U   P A G E   ***/
  // NOT DJ PAGE OR CONTACT PAGE
  ?>
  <div class="row">
    <div class="col-lg-9">
    <?php

      if ( have_posts() ) :
        while ( have_posts() ) : the_post();
          get_template_part( 'template-parts/content', get_post_format() );
        endwhile;
        $bkt2->the_posts_pagination();
      else :
        ?><p><?php _e( 'No Std Posts To Show', 'black_knight_t2' ); ?></p><?php
      endif;
    ?>
    </div><!-- .col -->
    <div class='col-lg-3'>
      <?php get_sidebar(); ?>
    </div><!-- .col -->
  </div><!-- .row -->

  <?php
endif;


?><br/>&nbsp;<br/>&nbsp;<br/><?php

?>
<?php get_footer(); ?>
