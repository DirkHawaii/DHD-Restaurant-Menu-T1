<?php get_header(); ?>

  <div class="row">
    <div class="col-lg-9">
<?php
  if ( have_posts() ) :
    while ( have_posts() ) : the_post();
      get_template_part( 'template-parts/content', get_post_format() );
    endwhile;
    $bkt2->the_posts_pagination();
  else :
    ?><p><?php _e( 'Sorry, no posts matched your criteria.', 'black_knight_t2' ); ?></p><?php
  endif;
?>
    </div><!-- .col -->
    <div class='col-lg-3'>
      <?php get_sidebar(); ?>
    </div><!-- .col -->
  </div><!-- .row -->

<?php get_footer(); ?>
