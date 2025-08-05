define([
    'jquery',
    'Magento_Customer/js/customer-data',
], function ($, storage) {
    'use strict';

    let cacheKey = 'checkout-data',

        /**
         * @param {Object} data
         */
        saveData = function (data) {
            storage.set(cacheKey, data);
        },

        /**
         * @return {*}
         */
        initData = function () {
            return {
                'selectedShippingAddress': null, //Selected shipping address pulled from persistence storage
                'shippingAddressFromData': null, //Shipping address pulled from persistence storage
                'newCustomerShippingAddress': null, //Shipping address pulled from persistence storage for customer
                'selectedShippingRate': null, //Shipping rate pulled from persistence storage
                'selectedPaymentMethod': null, //Payment method pulled from persistence storage
                'selectedBillingAddress': null, //Selected billing address pulled from persistence storage
                'billingAddressFromData': null, //Billing address pulled from persistence storage
                'newCustomerBillingAddress': null, //Billing address pulled from persistence storage for new customer
                'selectedShippingPudoPoint': null //Shipping pudo point for urgent cargus ship & go
            };
        },

        /**
         * @return {*}
         */
        getData = function () {
            let data = storage.get(cacheKey)();

            if ($.isEmptyObject(data)) {
                data = $.initNamespaceStorage('mage-cache-storage').localStorage.get(cacheKey);

                if ($.isEmptyObject(data)) {
                    data = initData();
                    saveData(data);
                }
            }

            return data;
        };

    return function (checkoutData) {
        return $.extend(checkoutData, {
            setSelectedShippingPudoPoint: function (data) {
                let obj = getData();

                obj.selectedShippingPudoPoint = data;
                saveData(obj);
            },

            getSelectedShippingPudoPoint: function () {
                return getData().selectedShippingPudoPoint;
            },
        });
    }
});
