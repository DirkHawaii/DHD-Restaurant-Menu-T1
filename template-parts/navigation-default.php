<?php
$main_nav_options = array(
  'theme_location'    => 'main_menu',
  'depth'             => 2,
  'container'         => '',
  'container_class'   => '',
  'menu_class'        => 'navbar-nav mr-auto',
  'fallback_cb'       => 'bootstrap_four_wp_navwalker::fallback',
  'walker'            => new bootstrap_four_wp_navwalker()
);
?>
<?php if ( has_nav_menu( 'main_menu' ) ) : ?>
  <nav class="navbar navbar-expand-md navbar-light" id="main-nav">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMainNav" aria-controls="navbarMainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarMainNav">
      <?php if ( has_custom_logo() ) : ?>
        <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php the_custom_logo(); ?></a>
      <?php else : ?>
        <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
      <?php endif; ?>
      <?php wp_nav_menu( $main_nav_options ); ?>
    </div>
  </nav>
<?php endif; ?>