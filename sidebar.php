<?php
/**
 * The template for the sidebar containing the main widget area
 */
?>
<?php if ( is_active_sidebar( 'right_sidebar' )  ) : ?>
  <aside id="secondary" class="sidebar widget-area" role="complementary">
    <?php dynamic_sidebar( 'right_sidebar' ); ?>
  </aside><!-- .sidebar .widget-area -->
<?php endif; ?>
