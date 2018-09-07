jQuery(document).ready(function($) {

  // UPLOADING FILES
  var file_frame;

  /***********************************************************************************************/
  jQuery.fn.upload_listing_image = function( button, i_num ) {
    var button_id = button.attr('id');
    var field_id = button_id.replace( '_button', '' );

    // IF THE MEDIA FRAME ALREADY EXISTS, REOPEN IT.
    if ( file_frame ) {
      file_frame.open();
      return;
    }
    // CREATE THE MEDIA FRAME.
    file_frame = wp.media.frames.file_frame = wp.media({
      title: button.data( 'uploader_title' ),
      button: {
        text: button.data( 'uploader_button_text' ),
      },
      multiple: false
    });

    // WHEN AN IMAGE IS SELECTED, RUN A CALLBACK.
    file_frame.on( 'select', function() {
      var attachment = file_frame.state().get('selection').first().toJSON();
      jQuery("#"+field_id).val(attachment.id);
      jQuery("#listingimagediv"+ i_num +" img").attr("src",attachment.url);
      jQuery("#listingimagediv"+ i_num +" img").show();
      jQuery("#" + button_id ).attr( "id", "remove_listing_image_button"+ i_num  );
      jQuery("#remove_listing_image_button"+ i_num ).text( "Remove Image"+ i_num );
    });

    // FINALLY, OPEN THE MODAL
    file_frame.open();
  };

  /***********************************************************************************************/
  /**   I M A G E 1                                                                             **/
  /***********************************************************************************************/
  jQuery('#listingimagediv1').on( 'click', '#upload_listing_image_button1', function( event ) {
    event.preventDefault();
    jQuery.fn.upload_listing_image( jQuery(this), "1" );
  });
  /***********************************************************************************************/
  /**   I M A G E 2                                                                             **/
  /***********************************************************************************************/
  jQuery('#listingimagediv2').on( 'click', '#upload_listing_image_button2', function( event ) {
    event.preventDefault();
    jQuery.fn.upload_listing_image( jQuery(this), "2" );
  });
  /***********************************************************************************************/
  /**   I M A G E 3                                                                             **/
  /***********************************************************************************************/
  jQuery('#listingimagediv3').on( 'click', '#upload_listing_image_button3', function( event ) {
    event.preventDefault();
    jQuery.fn.upload_listing_image( jQuery(this), "3" );
  });
  /***********************************************************************************************/
  /**   I M A G E 4                                                                             **/
  /***********************************************************************************************/
  jQuery('#listingimagediv4').on( 'click', '#upload_listing_image_button4', function( event ) {
    event.preventDefault();
    jQuery.fn.upload_listing_image( jQuery(this), "4" );
  });


  /***********************************************************************************************/
  /**   I M A G E 1                                                                             **/
  /***********************************************************************************************/
  jQuery('#listingimagediv1').on( 'click', '#remove_listing_image_button1', function( event ) {
    event.preventDefault();
    jQuery( '#upload_listing_image1' ).val( '' );
    jQuery( '#listingimagediv img' ).attr( 'src', '' );
    jQuery( '#listingimagediv img' ).hide();
    jQuery( this ).attr( 'id', 'upload_listing_image_button1' );
    jQuery( '#upload_listing_image_button1' ).text( 'Set Image 1' );
  });
  /***********************************************************************************************/
  /**   I M A G E 2                                                                             **/
  /***********************************************************************************************/
  jQuery('#listingimagediv2').on( 'click', '#remove_listing_image_button2', function( event ) {
    event.preventDefault();
    jQuery( '#upload_listing_image2' ).val( '' );
    jQuery( '#listingimagediv img' ).attr( 'src', '' );
    jQuery( '#listingimagediv img' ).hide();
    jQuery( this ).attr( 'id', 'upload_listing_image_button2' );
    jQuery( '#upload_listing_image_button2' ).text( 'Set Image 2' );
  });
  /***********************************************************************************************/
  /**   I M A G E 3                                                                             **/
  /***********************************************************************************************/
  jQuery('#listingimagediv3').on( 'click', '#remove_listing_image_button3', function( event ) {
    event.preventDefault();
    jQuery( '#upload_listing_image3' ).val( '' );
    jQuery( '#listingimagediv img' ).attr( 'src', '' );
    jQuery( '#listingimagediv img' ).hide();
    jQuery( this ).attr( 'id', 'upload_listing_image_button3' );
    jQuery( '#upload_listing_image_button3' ).text( 'Set Image 3' );
  });
  /***********************************************************************************************/
  /**   I M A G E 4                                                                             **/
  /***********************************************************************************************/
  jQuery('#listingimagediv4').on( 'click', '#remove_listing_image_button4', function( event ) {
    event.preventDefault();
    jQuery( '#upload_listing_image4' ).val( '' );
    jQuery( '#listingimagediv img' ).attr( 'src', '' );
    jQuery( '#listingimagediv img' ).hide();
    jQuery( this ).attr( 'id', 'upload_listing_image_button4' );
    jQuery( '#upload_listing_image_button4' ).text( 'Set Image 4' );
  });

});