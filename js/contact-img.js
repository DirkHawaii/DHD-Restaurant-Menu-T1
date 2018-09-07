jQuery(document).ready(function($) {

  // UPLOADING FILES
  var file_frame;

  /***********************************************************************************************/
  jQuery.fn.upload_property_image = function( button ) {
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
      jQuery("#propertyimgdiv img").attr("src",attachment.url);
      jQuery("#propertyimgdiv img").show();
      jQuery("#" + button_id ).attr( "id", "remove_property_image_button"  );
      jQuery("#remove_property_image_button" ).text( "Remove Property Image" );
    });

    // FINALLY, OPEN THE MODAL
    file_frame.open();
  };
  /***********************************************************************************************/
  jQuery.fn.upload_agent_image = function( button ) {
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
      jQuery("#agentimgdiv img").attr("src",attachment.url);
      jQuery("#agentimgdiv img").show();
      jQuery("#" + button_id ).attr( "id", "remove_agent_image_button"  );
      jQuery("#remove_agent_image_button").text( "Remove Agent Image" );
    });

    // FINALLY, OPEN THE MODAL
    file_frame.open();
  };

  /***********************************************************************************************/
  /**   P R O P E R T Y   I M A G E                                                             **/
  /***********************************************************************************************/
  jQuery('#propertyimgdiv').on( 'click', '#upload_property_image_button', function( event ) {
    event.preventDefault();
    jQuery.fn.upload_property_image( jQuery(this) );
  });
  /***********************************************************************************************/
  /**   A G E N T   I M A G E                                                                   **/
  /***********************************************************************************************/
  jQuery('#agentimgdiv').on( 'click', '#upload_agent_image_button', function( event ) {
    event.preventDefault();
    jQuery.fn.upload_agent_image( jQuery(this) );
  });

  /***********************************************************************************************/
  /**   P R O P E R T Y   I M A G E                                                             **/
  /***********************************************************************************************/
  jQuery('#propertyimgdiv').on( 'click', '#remove_property_image_button', function( event ) {
    event.preventDefault();
    jQuery( '#upload_property_image' ).val( '' );
    jQuery( '#propertyimgdiv img' ).attr( 'src', '' );
    jQuery( '#propertyimgdiv img' ).hide();
    jQuery( this ).attr( 'id', 'upload_property_image_button' );
    jQuery( '#upload_property_image_button' ).text( 'Set Property Image' );
  });
  /***********************************************************************************************/
  /**   A G E N T   I M A G E                                                                   **/
  /***********************************************************************************************/
  jQuery('#agentimgdiv').on( 'click', '#remove_agent_image_button', function( event ) {
    event.preventDefault();
    jQuery( '#upload_agent_image' ).val( '' );
    jQuery( '#agentimgdiv img' ).attr( 'src', '' );
    jQuery( '#agentimgdiv img' ).hide();
    jQuery( this ).attr( 'id', 'upload_agent_image_button' );
    jQuery( '#upload_agent_image_button' ).text( 'Set Agent Image' );
  });

});