<?php
/**
 * THE FRONT PAGE TEMPLATE FILE
 */
?>
<?php get_header(); ?>
<?php
  if ( have_posts() ) :
    while ( have_posts() ) : the_post();
      get_template_part( 'template-parts/content', get_post_format() );
    endwhile;
    // RESET POST DATA
    wp_reset_postdata();

  else :
    ?><p><?php _e( 'No Front Page Posts', 'black_knight_t2' ); ?></p><?php
  endif;

  //get_template_part( 'template-parts/content', 'menus' );

?>
<?php get_footer(); ?>