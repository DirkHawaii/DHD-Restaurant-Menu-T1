<?php
/*************************************************************************************************/
/***                                                                                           ***/
/***   C O N T A C T                                                                           ***/
/***                                                                                           ***/
/***   Render the contents of the rs_contact custom post type.                                 ***/
/***                                                                                           ***/
/***   There can be many posts for this type                                                   ***/
/***                                                                                           ***/
/*************************************************************************************************/
/* QUERY MENUS FROM THE DATABASE. */
$cptContact = new WP_Query(
  array(
      'post_type'       => 'bkcpt_contact',
      'orderby'         => 'date',
      'order'           => 'ASC',
      'posts_per_page'  => -1,
  )
);

if ( $cptContact->have_posts() ) :
  // THE LOOP
  while ( $cptContact->have_posts() ) :
    $cptContact->the_post();
    $contact_data = get_post_meta( $cptContact->post->ID, '_contact_data',  true );          /*   GET POST: Data Array           */
    $contact_data_map = get_post_meta( $cptContact->post->ID, '_contact_data_map',  true );  /*   GET POST: Data Array           */

    $contact_hours      = ( ! empty( $contact_data['contact_hours'] ) ) ? $contact_data['contact_hours']  : '';
    $contact_name       = ( ! empty( $contact_data['contact_name']  ) ) ? $contact_data['contact_name']   : '';
    $contact_location   = ( ! empty( $contact_data['contact_loc']   ) ) ? $contact_data['contact_loc']    : '';
    $contact_address    = ( ! empty( $contact_data['contact_address']  ) ) ? $contact_data['contact_address']   : '';
    $contact_city       = ( ! empty( $contact_data['contact_city']  ) ) ? $contact_data['contact_city']   : '';
    $contact_state      = ( ! empty( $contact_data['contact_state'] ) ) ? $contact_data['contact_state']  : '';
    $contact_zip        = ( ! empty( $contact_data['contact_zip']   ) ) ? $contact_data['contact_zip']    : '';
    $contact_phone      = ( ! empty( $contact_data['contact_phone'] ) ) ? $contact_data['contact_phone']  : '';
    $contact_email      = ( ! empty( $contact_data['contact_email'] ) ) ? $contact_data['contact_email']  : '';


    ?>
    <div class="row">
      <div class="col-md-6">
        <div id="contactWrap">
          <div class="leftSide">Hours Of Operation</div>
          <div class="rightSide"><?php echo $contact_hours; ?></div>
          <div class="leftSide">Address</div>
          <div class="rightSide"><?php echo $contact_name; ?><br /><?php echo $contact_location; ?><br /><?php echo $contact_address; ?><br /><?php echo $contact_city; ?>, <?php echo $contact_state; ?> <?php echo $contact_zip; ?></div>
          <div class="leftSide">Phone</div>
          <div class="rightSide"><a href="tel:+1<?php echo $contact_phone; ?>"><?php echo $contact_phone; ?></a></div>
          <div class="leftSide">Email</div>
          <div class="rightSide"><a href="mailto:<?php echo $contact_email; ?>"><?php echo $contact_email; ?></a></div>
        </div>

        <h3><?php the_title(); ?></h3>
        <p><?php the_content(); ?></p>


      </div><!-- .col-md-6 -->
      <div class="col-md-6">
        <iframe id="googleMap" width="100%" height="500" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="<?php echo $contact_data_map; ?>"></iframe>
      </div><!-- .col-md-6 -->
    </div><!-- .row -->
    <?php
  endwhile;
else:
  ?><h1>No Contact To List</h1><?php
endif;
// RESET POST DATA
wp_reset_postdata();
