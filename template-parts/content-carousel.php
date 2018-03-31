<?php
/*************************************************************************************************/
/***                                                                                           ***/
/***   C O N T E N T - C A R O U S E L                                                         ***/
/***                                                                                           ***/
/***   Render the contents of the rs_carousel custom post type.                                ***/
/***                                                                                           ***/
/***   Post Title:     Carousel Image Title                                                    ***/
/***   Post Content:   Carousel Image Text                                                     ***/
/***   Post Thumbnail: Carousel Image                                                          ***/
/***                                                                                           ***/
/***   -------------------------------------------------------------------------------------   ***/
/***   Meta:                  Field:                                                           ***/
/***   -------------------------------------------------------------------------------------   ***/
/***     Order                  _carousel_order                                                ***/
/***     Text Position          _carousel_position                                             ***/
/***     Text Color             _carousel_text_color                                           ***/
/***     Text Shadow Color      _carousel_text_shadow                                          ***/
/***     Title Color            _carousel_title_color                                          ***/
/***     Title Shadow Color     _carousel_title_shadow                                         ***/
/***                                                                                           ***/
/*************************************************************************************************/
/* QUERY CAROUSEL FROM THE DATABASE. */
$myCarousel = new WP_Query(
  array(
    'post_type'       => 'bkcpt_carousel',
    'orderby'         => 'meta_value_num',
    'meta_key'        => '_carousel_order',
    'order'           => 'ASC',
    'posts_per_page'  => -1,
  )
);

if ( $myCarousel->have_posts() ) :
  $row_count = $myCarousel->post_count;
  ?><div id="headCarousel" class="carousel slide" data-ride="carousel" data-interval="10000">
      <!-- Indicators -->
      <ol class="carousel-indicators">
  <?php

  for ( $i = 0; $i < $row_count; $i++ ) {
    if ( $i == 0 ) :
      ?><li data-target="#headCarousel" data-slide-to="0" class="active"></li><?php
    else :
      ?><li data-target="#headCarousel" data-slide-to="<?php echo $i; ?>"></li><?php
    endif;
  }
  $post_counter = 0;
  ?></ol>
  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
  <?php
  /** THE LOOP FOR THE CAROUSEL POSTS **/
  while ( $myCarousel->have_posts() ) : $myCarousel->the_post();
    /**  GET THE TEXT POSITION  **/
    $carousel_text_pos = get_post_meta( get_the_ID(), '_carousel_position', true );

    $carousel_data = get_post_meta( get_the_ID(), '_carousel_data', true );

    $carousel_text_pos     = ( ! empty( $carousel_data['position']     ) ) ? $carousel_data['position']     : '';
    $carousel_title_color  = ( ! empty( $carousel_data['title_color']  ) ) ? $carousel_data['title_color']  : '';
    $carousel_title_shadow = ( ! empty( $carousel_data['title_shadow'] ) ) ? $carousel_data['title_shadow'] : '';
    $carousel_text_color   = ( ! empty( $carousel_data['text_color']   ) ) ? $carousel_data['text_color']   : '';
    $carousel_text_shadow  = ( ! empty( $carousel_data['text_shadow']  ) ) ? $carousel_data['text_shadow']  : '';



    /**  GET THE TEXT COLORS  **/
    //$carousel_text_color  = get_post_meta( get_the_ID(), '_carousel_text_color', true );
    //$carousel_text_shadow = get_post_meta( get_the_ID(), '_carousel_text_shadow', true );
    /**  GET THE TITLE COLORS  **/
    //$carousel_title_color  = get_post_meta( get_the_ID(), '_carousel_title_color', true );
    //$carousel_title_shadow = get_post_meta( get_the_ID(), '_carousel_title_shadow', true );


    if ( $post_counter == 0 ) :
      ?><div class="carousel-item active"><?php
    else :
      ?><div class="carousel-item"><?php
    endif;
    $post_counter++;
    // CHECK IF THE POST HAS A POST THUMBNAIL ASSIGNED TO IT.
    if ( has_post_thumbnail() ) {
      the_post_thumbnail();
    }
    ?>
    <div class="container">
      <?php
        if ( $carousel_text_pos == 'center' ) :
          ?><div class="carousel-caption d-none d-md-block"><?php
        elseif ( $carousel_text_pos == 'left' ) :
          ?><div class="carousel-caption d-none d-md-block text-left"><?php
        elseif ( $carousel_text_pos == 'right' ) :
          ?><div class="carousel-caption d-none d-md-block text-right"><?php
        else :
          ?><div class="carousel-caption d-none d-md-block"><?php
        endif;
        ?>
        <h3 style="color:<?php echo $carousel_title_color; ?>;text-shadow:1px 1px 0 <?php echo $carousel_title_shadow; ?>;"><?php the_title(); ?></h3>
        <p style="color:<?php echo $carousel_text_color; ?>;text-shadow:1px 1px 0 <?php echo $carousel_text_shadow; ?>;">
        <?php the_content(); ?>
        </p>
      </div>
    </div><!-- end container -->
  </div><!-- end carousel-item -->
  <?php
  endwhile;
  ?>
  </div><!-- end carousel-inner -->
  <a class="carousel-control-prev" href="#headCarousel" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#headCarousel" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div><!-- end #headCarousel -->
<?php

else :

  ?><p><?php _e( 'Sorry, no carousel posts.', 'dhd-rs1' ); ?></p><?php

endif;

// RESET POST DATA
wp_reset_postdata();

