define([
    'jquery',
    'ko',
    'Magento_Checkout/js/action/select-shipping-method',
    'Magento_Checkout/js/checkout-data',
    'Magento_Ui/js/modal/modal',
    'initMap',
    'mage/translate',
    'Magento_Checkout/js/model/quote',
    'loader'
], function (
    $,
    ko,
    selectShippingMethodAction,
    checkoutData,
    modal,
    initMap,
    $t,
    quote
) {
    'use strict';

    let mapModal = null;

    window.selectedPudo = function (pudoId) {
        checkoutData.setSelectedShippingPudoPoint(pudoId);
        mapModal.closeModal();
        return true;
    };

    return function (Shipping) {
        let pudoPoint =  ko.observable(null);
        let infoMessage = ko.observable(null);

        let pudoLocation = function () {
            if (checkoutData.getSelectedShippingPudoPoint() > 0) {
                let pudo = _.findWhere(window.checkoutConfig.cargus.pins, {pudo_id: checkoutData.getSelectedShippingPudoPoint().toString()});
                pudoPoint(pudo ? pudo.name : null);
                let info = $t('The following payment methods are available at the chosen location') + ':';
                let PaymentsType = JSON.parse(pudo.accepted_payment_type);
                let comma = false;
                if (PaymentsType?.Cash) {
                    info += ' ' + $t('Cash');
                    comma = true;
                }
                if (PaymentsType.Card) {
                    info += (comma ? ', ' : ' ') + $t('Card');
                    comma = true;
                }
                if (PaymentsType.Online) {
                    info += (comma ? ', ' : ' ') + $t('Link to pay the refund on the phone');
                }
                infoMessage(info);
            } else {
                pudoPoint(null);
                infoMessage(null);
            }
        };

        return Shipping.extend({
            defaults: {
                shippingMethodItemTemplate: 'Urgent_CargusShipGo/shipping-address/shipping-method-item',
            },

            pudoPoint: pudoPoint,
            infoMessage: infoMessage,


            /**
             * Initialize shipping
             */
            initialize: function () {
                this._super();
                pudoLocation();

                return this;
            },

            /**
             * @param {Object} shippingMethod
             * @return {Boolean}
             */
            selectShippingMethod: function (shippingMethod) {
                selectShippingMethodAction(shippingMethod);
                checkoutData.setSelectedShippingRate(shippingMethod['carrier_code'] + '_' + shippingMethod['method_code']);

                if (!shippingMethod?.extension_attributes?.has_map) {
                    checkoutData.setSelectedShippingPudoPoint(null);
                    pudoLocation();
                }

                return true;
            },

            /**
             * @return {Boolean}
             */
            validateShippingInformation: function () {
                const superResult = this._super();

                let shippingMethod = checkoutData.getSelectedShippingRate();
                if ((shippingMethod === 'cargus_shipandgo_cargus_shipandgo' || quote.shippingMethod().carrier_code === 'cargus_shipandgo') &&
                    !checkoutData.getSelectedShippingPudoPoint()) {
                    this.errorValidationMessage(
                        $t('The shipping method is missing pudo location. Select the pudo location and try again.')
                    );
                    return false;
                }

                return superResult;
            },

            openMap: function (shippingMethod) {
                let modalId = shippingMethod.carrier_code;
                let map = $('<div id="' + modalId + '_map" class="map">' +
                    '<div id="' + modalId + '_content" class="map_content"></div>' +
                    '</div>'
                );
                let options = {
                    type: 'slide',
                    responsive: true,
                    buttons: [],
                    closed: function (e) {
                        $('#'  + modalId + '_content').fadeOut();
                        pudoLocation();
                        $(e.target).parents('aside').remove();
                    },
                    opened: function (e) {
                        initMap.init(modalId);
                    }
                };
                mapModal = modal(options, map);
                mapModal.openModal();
                map.trigger('processStart');
            },
        });
    }
});
