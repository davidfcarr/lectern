/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

    wp.customize.controlConstructor.banner_choice = wp.customize.Control.extend( {
        ready: function() {
            var control = this;
            wp.customize.Control.prototype.ready.call( control );
            $(".tmbanner").click(function(e){
                e.preventDefault();
                console.log('banner image clicked');
                var choice = $(this).attr('basename');
                console.log('image choice '+choice);
                $.get( "/wp-json/lectern/v1/getbranding/"+choice, function( data ) {
                    alert('Header changed to '+data+' - reload to see change');
                  });                //$('#banner_choice').val(choice);
                });                
        }
    } );

} )( jQuery );
