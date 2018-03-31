<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="content-type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
<meta name="description" content="<?php echo esc_attr( get_bloginfo( 'description' ) ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="container main-container" id="main-container">
<?php get_template_part( 'template-parts/navigation', 'default' ); ?>
<?php if ( is_front_page() ) :                                        /***  FRONT PAGE - ONLY SHOW CAROUSEL ON FRONT PAGE   ***/
  get_template_part( 'template-parts/content', 'carousel' );
else :                                                                /***  NOT FRONT PAGE - NO CAROUSEL, JUST BANNER IMAGE   ***/
  if ( get_header_image() ) : ?>
    <div id="site-header">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
        <img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
      </a>
      <div id="header-text1"><?php bloginfo( 'name' ); ?></div>
      <?php
      $tagline = esc_attr( get_bloginfo( 'description' ) );
      if ( $tagline ) :
        ?>
        <div id="header-text2"><?php echo $tagline; ?></div>
      <?php endif; ?>
    </div>
  <?php endif; ?>
<?php endif; ?>
