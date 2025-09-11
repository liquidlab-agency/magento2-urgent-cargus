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
            return window.location.origin + '/rest/V1/urgent-cargus/localities/by-county-name';
        }

        function fetchLocalitiesByCounty(county) {
            destinationLocality.prop('disabled', true);
            destinationLocality.html('');

            fetch(getUrl(), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ countyName: county })
            })
                .then(async (resp) => {
                    const text = await resp.text();
                    let payload;
                    try { payload = text ? JSON.parse(text) : {}; } catch (e) { payload = { error: true, message: 'Invalid JSON from server', raw: text }; }

                    if (!resp.ok) {
                        // surface server-provided error
                        throw { status: resp.status, statusText: resp.statusText, payload };
                    }

                    return payload;
                })
                .then((response) => {
                    if (response.error) {
                        if (response.message && response.message.length) {
                            let errorHtml = '<label class="admin__field-error" for="' + destinationLocality.attr('id') + '">';
                            errorHtml += response.message;
                            errorHtml += '</label>';
                            destinationLocality.parent().append(errorHtml);
                        }
                        return;
                    }

                    let uae = uiRegistry.get('urgentcargus_awb_edit.urgentcargus_awb_edit');
                    destinationLocality.prop('disabled', false);
                    let autoSelect = null;

                    response.forEach(function(locality){
                        let name = locality.name;
                        name = name.charAt(0).toUpperCase() + name.slice(1).toLowerCase();
                        const o = new Option(name, locality.name);
                        if (name === uae.source.data.destination_locality_original) {
                            autoSelect = locality.name;
                        }
                        destinationLocality.append(o);
                    });

                    if (autoSelect) {
                        destinationLocality.find('option[value="' + autoSelect + '"]').attr('selected', true);
                    }

                    destinationLocality.trigger('change');
                })
                .catch((err) => {
                    console.error('AJAX Error (fetch):', {
                        status: err && err.status,
                        statusText: err && err.statusText,
                        payload: err && err.payload,
                        url: getUrl(),
                        county: county
                    });
                    destinationLocality.prop('disabled', false);
                    let errorHtml = '<label class="admin__field-error" for="' + destinationLocality.attr('id') + '">';
                    errorHtml += 'Error loading localities: ' + ( (err && (err.statusText || (err.payload && err.payload.message))) || 'Unknown error');
                    errorHtml += '</label>';
                    destinationLocality.parent().append(errorHtml);
                })
                .finally(function(){
                    if (destinationLocality.prop('disabled')) {
                        destinationLocality.prop('disabled', false);
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
