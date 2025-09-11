require(['jquery',
    'uiRegistry',
    'mage/translate',
    'underscore'
], function ($, uiRegistry, $t, _) {
    'use strict';

    $(function() {
        let locality = null;

        function waitSelectorCounty() {
            let selector = 'select[name="groups[location][fields][county][value]"]';
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

        function getUrl(countyId) {
            return window.location.origin + '/rest/V1/urgent-cargus/localities/by-county-id/' + countyId;
        }

        function fetchLocalitiesByCounty(county) {
            locality.prop('disabled', true);
            locality.html('');

            // Use native fetch to avoid Magento jQuery prefilters adding isAjax/form_key
            fetch(getUrl(county), {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            })
                .then(async (resp) => {
                    const text = await resp.text();
                    let payload;
                    try { payload = text ? JSON.parse(text) : {}; } catch (e) { payload = { error: true, message: 'Invalid JSON from server', raw: text }; }

                    if (!resp.ok) {
                        throw { status: resp.status, statusText: resp.statusText, payload };
                    }

                    return payload;
                })
                .then((response) => {
                    if (response.error) {
                        if (response.message && response.message.length) {
                            let errorHtml = '<label class="admin__field-error" for="' + locality.attr('id') + '">';
                            errorHtml += response.message;
                            errorHtml += '</label>';
                            locality.parent().append(errorHtml);
                        }
                        return;
                    }

                    locality.prop('disabled', false);
                    locality.append(new Option($t('Please select'), 0));

                    response.forEach(function(item){
                        let name = item.name || '';
                        name = name.charAt(0).toUpperCase() + name.slice(1).toLowerCase();
                        locality.append(new Option(name, item.locality_id));
                    });
                })
                .catch((err) => {
                    console.error('AJAX Error (fetch GET):', {
                        status: err && err.status,
                        statusText: err && err.statusText,
                        payload: err && err.payload,
                        url: getUrl(county),
                        countyId: county
                    });
                    locality.prop('disabled', false);
                    let errorHtml = '<label class="admin__field-error" for="' + locality.attr('id') + '">';
                    errorHtml += 'Error loading localities: ' + ( (err && (err.statusText || (err.payload && err.payload.message))) || 'Unknown error');
                    errorHtml += '</label>';
                    locality.parent().append(errorHtml);
                })
                .finally(function(){
                    if (locality.prop('disabled')) {
                        locality.prop('disabled', false);
                    }
                });
        }

        async function init() {

            const county = await waitSelectorCounty();
            locality = $('select[name="groups[location][fields][city][value]"]');

            county.on('change', function () {
                locality.next()?.remove();
                fetchLocalitiesByCounty(county.val());
            });
        }

        init();
    });
});
