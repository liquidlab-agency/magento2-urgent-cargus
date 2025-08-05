var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/view/shipping': {
                'Urgent_CargusShipGo/js/view/shipping': true
            },
            'Magento_Checkout/js/checkout-data': {
                'Urgent_CargusShipGo/js/checkout-data': true
            },
            'Magento_Checkout/js/model/shipping-save-processor/payload-extender': {
                'Urgent_CargusShipGo/js/model/shipping-save-processor/payload-extender-mixin': true
            }
        }
    },
    map: {
        '*': {
            'leaflet': 'Urgent_CargusShipGo/js/leaflet',
            'initMap' : 'Urgent_CargusShipGo/js/initMap',

        }
    },
    shim: {
        'leaflet': {
            exports: 'L'
        },
    }
};
