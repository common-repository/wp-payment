( function( blocks, element ) {
    var el = element.createElement;
 
    var blockStyle = {
        padding: '20px',
    };
 
    blocks.registerBlockType( 'wps-wp-payment-guten/wps-wp-payment-guten-shortcode-text', {
        title: 'WP Payment',
        icon: 'feedback',
        category: 'embed',
        edit: function() {
            return el(
                'p',
                { style: blockStyle },
                '[WP_PAYMENT_FORM]'
            );
        },
        save: function() {
            return el(
                'p',
                { style: blockStyle },
                '[WP_PAYMENT_FORM]'
            );
        },
    } );
}(
    window.wp.blocks,
    window.wp.element
) );