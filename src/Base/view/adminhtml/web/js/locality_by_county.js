require(['jquery',
    'uiRegistry',
    'mage/translate'
], function ($, uiRegistry) {
    'use strict';

    $(function() {
        let destinationLocality = null;

        function waitSelectorDestinationCounty() {
            let selector = 'select[name="destination_county"]';
            return new Promise(resolve => {
                if (document.querySelector(selector)) {
                    return resolve($(selector));
                }

                const observer = new MutationObserver(mutations => {
                    if (document.querySelector(selector)) {
                        resolve($(selector));
                        observer.disconnect();
                    }
                });

                observer.observe(document.body, {
                    childList: true,
                    subtree: true
                });
            });
        }

        function customerLocality() {
            let customerLocalityInput = $('input[name="customer_locality"]');
            if (customerLocalityInput.val()) {
                let o = new Option(customerLocalityInput.val(), '0', true);
                destinationLocality.append(o);
            }
        }

        function getUrl() {
            return window.location.origin + '/urgent/nomenclature/getlocalitiesbycounty/';
        }

        function fetchLocalitiesByCounty(county) {
            let data = {
                'county_name': county
            };

            destinationLocality.prop('disabled', true);
            destinationLocality.html('');

            $.ajax({
                url: getUrl(),
                type: 'GET',
                data: data,
                dataType: 'JSON'
            }).done(function (response) {
                if (response.error) {
                    if (response.message.length) {
                        let errorHtml = '<label class="admin__field-error" for="' + destinationLocality.attr('id') + '">';
                        errorHtml += response.message;
                        errorHtml += '</label>'
                        destinationLocality.parent().append(errorHtml);
                    }
                } else {
                    let uae = uiRegistry.get('urgentcargus_awb_edit.urgentcargus_awb_edit');
                    destinationLocality.prop('disabled', false);
                    let autoSelect = null;
                    response.localities.forEach(locality => {
                        let name = locality.name;
                        name = name.charAt(0).toUpperCase() + name.slice(1).toLowerCase();
                        let o = new Option(name, locality.name);
                        if (name === uae.source.data.destination_locality_original) {
                            autoSelect = locality.name;
                        }
                        destinationLocality.append(o);
                    });

                    if (autoSelect.length) {
                        destinationLocality.find('option[value="' + autoSelect + '"]').attr('selected', true);
                    }
                    destinationLocality.trigger('change');
                }
            });
        }

        async function init() {

            const destinationCounty = await waitSelectorDestinationCounty();
            destinationLocality = $('select[name="destination_locality"]');
            let destinationValue = destinationCounty.val();
            switch (destinationValue) {
                case '0':
                    customerLocality();
                    break;
                default:
                    fetchLocalitiesByCounty(destinationValue);
            }

            let uae = uiRegistry.get('urgentcargus_awb_edit.urgentcargus_awb_edit');

            destinationCounty.on('change', function () {
                fetchLocalitiesByCounty(destinationCounty.val());
            });

            destinationLocality.on('change', function (e) {
                uae.set('urgentcargus_awb_edit.urgentcargus_awb_edit.source.data.destination_locality', e.target.value);
            });
        }

        init();
    });
});
