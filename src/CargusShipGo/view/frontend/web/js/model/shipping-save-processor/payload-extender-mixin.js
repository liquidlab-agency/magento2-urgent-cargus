define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/checkout-data',
], function ($, wrapper, checkoutData) {
    'use strict';

    return function (payloadExtender) {
        return wrapper.wrap(payloadExtender, function (originalAction, payload) {
            payload = originalAction(payload);

            let shippingMethod = checkoutData.getSelectedShippingRate();
            if (shippingMethod === 'cargus_shipandgo_cargus_shipandgo') {
                payload.addressInformation.extension_attributes = {pudo_id: checkoutData.getSelectedShippingPudoPoint()};
            }

            return payload;
        });
    };
});
