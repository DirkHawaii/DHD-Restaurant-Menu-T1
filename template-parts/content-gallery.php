<?php


  /*   C U S T O M   G A L L E R Y   P O S T S   */
  $sfGallery = new WP_Query(
    array(
        'post_type'       => 'rs_gallery',
        'orderby'         => 'title',
        'order'           => 'ASC',
        'posts_per_page'  => -1,
    )
  );
  if ( $sfGallery->have_posts() ) :
    ?><div class="row" id="dj-list"><?php
    //   T H E   L O O P   F O R   G A L L E R Y   P O S T S
    while ( $sfGallery->have_posts() ) : $sfGallery->the_post();
      ?><div class="col-lg-2 dj-image"><?php
      //   C H E C K   F O R   I M A G E
      if ( has_post_thumbnail() ) {
        the_post_thumbnail();
      } else {
        ?><img src="<?php echo get_bloginfo('template_directory') . '/img/male-user.png' ?>" /><?php
      }
      ?></div>
      <div class="col-lg-10 dj-bio">
        <h3><?php the_title(); ?></h3>
        <?php the_content(); ?>
      </div>
      <?php

    endwhile;
    ?></div><?php
  else :
    ?><p><?php _e( 'No Gallery Posts.', 'black_knight_t2' ); ?></p><?php
  endif;
  // RESET POST DATA
  wp_reset_postdata();
