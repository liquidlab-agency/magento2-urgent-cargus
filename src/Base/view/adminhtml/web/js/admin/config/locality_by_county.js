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

        function getUrl() {
            return window.location.origin + '/urgent/nomenclature/getlocalitiesbycountyid/';
        }

        function fetchLocalitiesByCounty(county) {
            let data = {
                'county_id': county
            };

            locality.prop('disabled', true);
            locality.html('');

            $.ajax({
                url: getUrl(),
                type: 'GET',
                data: data,
                dataType: 'JSON'
            }).done(function (response) {
                if (response.error) {
                    if (response.message.length) {
                        let errorHtml = '<label class="admin__field-error" for="' + locality.attr('id') + '">';
                        errorHtml += response.message;
                        errorHtml += '</label>'
                        locality.parent().append(errorHtml);
                    }
                } else {
                    locality.prop('disabled', false);
                    locality.append(new Option($t('Please select'), 0));
                    let localities = _.sortBy(response.localities, 'name');
                    localities.forEach(item => {
                        let name = item.name;
                        name = name.charAt(0).toUpperCase() + name.slice(1).toLowerCase();
                        locality.append(new Option(name, item.locality_id));
                    });
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
