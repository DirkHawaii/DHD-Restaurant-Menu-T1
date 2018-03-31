<div class="row">
  <div class="col-md-8">
    <?php the_content( sprintf( __( 'Continue reading %s', 'black_knight_t2' ), the_title( '<span class="screen-reader-text">', '</span>', false ) ) ); ?>
  </div>
  <div class="col-md-4">
    <?php
      //   C H E C K   F O R   S I D E   I M A G E
      if ( has_post_thumbnail() ) :
        ?>
        <div class="page-img">
          <?php the_post_thumbnail(); ?>
        </div>
        <?php
      endif;
    ?>
  </div>
</div><!-- .row -->
