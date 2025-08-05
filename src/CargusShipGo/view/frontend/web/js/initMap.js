define([
    'jquery',
    'leaflet',
    'underscore',
    'mage/translate',
    'Urgent_CargusShipGo/js/view/shipping'
], function ($, L, _, $t, shipping) {
    "use strict";

    window.showMore = function (pudoId) {
        mapObj.showMore(pudoId);
    };

    window.openGoogleMaps = function (latitude, longitude) {
        mapObj.openGoogleMaps(latitude, longitude);
    };

    window.locationSelect = function (element) {
        mapObj.locationSelect(element);
    };

    $(document).on('keyup', '#searchPudoInput', function () {
        mapObj.searchPudo(this);
    });

    $(document).on('click', '.choose_elements', function () {
        mapObj.chooseElements();
    });

    $(document).on('click', '.leaflet-popup-close-button', function () {
        mapObj.removeHighlight();
    });

    let mapObj = {
        map: null,
        markers: null,
        elementId: null,
        icons: window.checkoutConfig.cargus.icons,
        pins: window.checkoutConfig.cargus.pins,
        pudoIcon: new L.Icon({
            iconSize: [50, 56],
            iconAnchor: [15, 36],
            popupAnchor: [10, 12],
            iconUrl: window.checkoutConfig.cargus.icons.pin
        }),
        lockerIcon: new L.Icon({
            iconSize: [50, 56],
            iconAnchor: [15, 36],
            popupAnchor: [10, 12],
            iconUrl: window.checkoutConfig.cargus.icons.locker
        }),

        init: function (elemId) {
            let mapElement = $('#' + elemId + '_map');
            this.elementId = elemId;
            let locationPosition = this.geoLocation() ?? [44.4268, 26.1025];
            let container = $('#' + this.elementId + '_content');
            container.html(this.getContent(this.elementId));
            container.fadeIn();
            if (this.map !== null) {
                this.map.off();
                this.map.remove();
                this.map = null;
            }
            this.map = L.map('pudo_' + this.elementId + '_map').setView(locationPosition, 12);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                minZoom: 7,
                maxZoom: 19,
                attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(this.map);

            this.showPins();
            mapElement.trigger('processStop');
        },

        getContent: function (elementId) {
            let c = '<div class="pudo_' + elementId + '_container">';
            c += '<div id="pudo_' + elementId + '_map">';
            c += '</div>';
            c += '<div class="pudo_search_container">';
            c += '<div class="pudo_search_header">';
            c += '<input id="searchPudoInput" placeholder="' + $t('City, Zip or Address') + '">';
            c += '</div>'; //pudo_search_header
            c += '<hr>';
            c += '<div class="pudo_search_elements">';
            c += '<div><input type="checkbox" id="pudo_element" class="choose_elements" checked value="pudo"><label for="pudo_element">Pudo</label></div>';
            c += '<div><input type="checkbox" id="locker_element" class="choose_elements" checked value="locker"><label for="locker_element">Lockers</label></div>';
            c += '</div>'; //pudo_search_choose
            c += '<hr>';
            c += '<div class="pudo_search_body">';
            c += '<ul class="pudo_search_list">';
            c += '</ul>';
            c += '</div>'; //pudo_search_body
            c += '</div>'; //pudo_search_container
            c += '</div>'; //pudo_container
            return c;
        },

        geoLocation: function () {
            function success(position) {
                return [position.coords.latitude, position.coords.longitude];
            }

            function error() {
                return [44.4268, 26.1025];
            }

            if (navigator.geolocation) {
                return navigator.geolocation.getCurrentPosition(success, error);
            }
            return null;
        },

        showPins: function () {
            let that = this;
            this.markers = L.layerGroup().addTo(this.map);
            let pudoListUl = $('.pudo_search_list');
            for (let i = 0; i < this.pins.length; i++) {
                pudoListUl.append(this.getLiContent(this.pins[i]));
                var ico = null;
                if (this.pins[i].point_type < 50) {
                    ico = this.pudoIcon;
                } else {
                    ico = this.lockerIcon;
                }
                this.markers.addLayer(L.marker([this.pins[i].latitude, this.pins[i].longitude], {
                        key: this.pins[i].pudo_id,
                        icon: ico
                    })
                        .addTo(this.map)
                        .on('click', function (e) {
                            that.removeHighlight();
                            that.scrollToPudo(e.target.options.key);
                        })
                        .bindPopup(this.getPopupContent(this.pins[i]), {
                            minWidth: 400,
                            className: 'pudo_custom_popup'
                        })

                );
            }
            that.map.on('popupclose', function(e) {
                that.removeHighlight();
            });
        },

        getLiContent: function (pudo) {
            let type = pudo.point_type < 50 ? 'pudo' : 'locker';
            let ico = pudo.point_type < 50 ? this.icons.pin : this.icons.locker
            let c = '<li id="' + pudo.pudo_id + '" class="pudo_location_item" ' +
                'data-id="' + pudo.pudo_id + '" ' +
                'data-name="' + pudo.name + '" ' +
                'data-address="' + pudo.city + ', ' + pudo.street_name + (pudo.street_no ? ' ' + pudo.street_no : '') + (pudo.postal_code ? ', Cod postal:' + pudo.postal_code : '') + '" ' +
                'data-latitude="' + pudo.latitude + '" ' +
                'data-longitude="' + pudo.longitude + '"' +
                'data-type="' + type + '"' +
                'onclick="locationSelect(this)">';
            c += '<div class="pudo_location_item_content">';
            c += '<div class="pudo_location_item_details">';
            c += '<div class="pudo_location_item_name">' + pudo.name + '</div>';
            c += '<div class="pudo_location_item_address">';
            c += pudo.street_name + ' ' + (pudo.street_no ? pudo.street_no : '') + '<br/>';
            c += pudo.city + ' ' + (pudo.postal_code ? pudo.postal_code : '');
            c += '</div>'; //pudo_location_item_address
            if (type === 'locker') {
                c += '<div class="pudo_location_item_locker">';
                c += pudo.additional_address_info;
                c += '</div>'; //pudo_location_item_locker
            }
            c += '</div>'; //pudo_location_item_details
            c += '<div class="pudo_location_item_icon">';
            c += '<img src="' + ico + '" alt="PinPoint">';
            c += '</div>'; //pudo_location_item_icon
            c += '</div>'; //pudo_location_item_content
            c += '</li>'; //pudo_location_item
            return c;
        },

        getPopupContent: function (pudo) {
            let ico = pudo.point_type < 50 ? this.icons.pin : this.icons.locker;
            let c = '<div class="pudo_container">';
            c += '<div class="pudo_details">';
            c += '<div class="pudo_location_name">';
            c += '<img src="' + this.icons.store + '" class="pudo_store_icon" alt="Store" />';
            c += '<h2>' + pudo.name + '</h2>';
            c += '</div>'; //pudo_location_name
            c += '<div class="pudo_location_address">';
            c += pudo.street_name + ' ' + (pudo.street_no ? pudo.street_no : '') + '<br/>';
            c += pudo.city + ' ' + (pudo.postal_code ? pudo.postal_code : '');
            c += '</div>'; //pudo_location_address
            c += '<hr class="pudo_separator" />';

            c += '<div class="pudo_work_hours_container">';
            c += '<img class="pudo_icon" src="' + this.icons.work + '" alt="Icon"/>';
            c += '<div class="pudo_work_hours">';
            c += '<div class="pudo_work_hours_row">';
            c += '<span>Luni - Vineri</span>' +
                '<span>' + this.calculateWorkTime(pudo.open_hours_mo_start, pudo.open_hours_mo_end) + '</span>';
            c += '</div>'; //pudo_work_hours_row
            c += '<div class="pudo_work_hours_row">';
            c += '<span>Marti</span>' +
                '<span>' + this.calculateWorkTime(pudo.open_hours_tu_start, pudo.open_hours_tu_end) + '</span>';
            c += '</div>'; //pudo_work_hours_row
            c += '<div class="pudo_work_hours_row">';
            c += '<span>Miercuri</span>' +
                '<span>' + this.calculateWorkTime(pudo.open_hours_we_start, pudo.open_hours_we_end) + '</span>';
            c += '</div>'; //pudo_work_hours_row
            c += '<div class="pudo_work_hours_row">';
            c += '<span>Joi</span>' +
                '<span>' + this.calculateWorkTime(pudo.open_hours_th_start, pudo.open_hours_th_end) + '</span>';
            c += '</div>'; //pudo_work_hours_row
            c += '<div class="pudo_work_hours_row">';
            c += '<span>Vineri</span>' +
                '<span>' + this.calculateWorkTime(pudo.open_hours_fr_start, pudo.open_hours_fr_end) + '</span>';
            c += '</div>'; //pudo_work_hours_row
            c += '<div class="pudo_work_hours_row">';
            c += '<span>Sambata</span>' +
                '<span>' + this.calculateWorkTime(pudo.open_hours_sa_start, pudo.open_hours_sa_end) + '</span>';
            c += '</div>'; //pudo_work_hours_row
            c += '<div class="pudo_work_hours_row">';
            c += '<span>Duminica</span>' +
                '<span>' + this.calculateWorkTime(pudo.open_hours_su_start, pudo.open_hours_su_end) + '</span>';
            c += '</div>'; //pudo_work_hours_row
            c += '</div>'; //pudo_work_hours
            c += '</div>'; //pudo_work_hours_container

            c += '<div class="pudo_payment">';
            c += '<img class="pudo_icon" src="' + this.icons.pay + '" alt="Icon"/>';
            c += '<div class="pudo_details_row"><span>COD:</span><span>' + this.getPaymentType(pudo.accepted_payment_type) + '</span></div>';
            c += '</div>'; //pudo_payment

            if (pudo.point_type >= 50) {
                c += '<div class="pudo_details_locker">' + pudo.additional_address_info + '</div>';
            }

            c += '<div class="pudo_select_button">';
            c += '<button class="pudo_button" onClick="selectedPudo(' + pudo.pudo_id + ')">' + $t('Choose this point') + '</button>';
            c += '<button class="pudo_button more_button" onClick="showMore(' + pudo.pudo_id + ')">' + $t('Details') + '</button>';
            c += '</div>'; //pudo_select_button
            c += '</div>'; //pudo_details
            c += '<div class="pudo_location_image">';
            c += pudo.main_picture ? '<img src="' + pudo.main_picture + '" alt=""/>' : '<img src="' + ico + '" alt="PinPoint"/>';
            c += '</div>';
                c += '<div id="pudo_show_more_' + pudo.pudo_id + '" class="pudo_show_more"></div>';
            c += '</div>';
            return c;
        },

        calculateWorkTime: function (startHour, endHour) {
            return startHour && endHour ? startHour + ' - ' + endHour : 'inchis';
        },

        showMore: function (pudoId) {
            let pudo = this.find(pudoId);
            if (!pudo) {
                return;
            }
            let ico = pudo.point_type < 50 ? this.icons.pin : this.icons.locker;
            let showMoreModal = $('#pudo_show_more_' + pudoId);
            showMoreModal.empty();
            let c = '<div class="pudo_more_popup_container">';
            c += '<div class="pudo_more_popup_details">';
            c += '<div class="pudo_more_popup_details_wrapper">';
            c += '<div class="pudo_more_popup_address_details">';
            c += pudo.street_name + ' ' + (pudo.street_no ? pudo.street_no : '') + ' ';
            c += pudo.city + ' ' + (pudo.postal_code ? pudo.postal_code : '');
            c += '<div class="pudo_more_popup_location_address">';
            c += '<div><img src="' + this.icons.store + '" alt="Store" /></div>';
            c += '<div><strong>Program</strong><br>';
            c += ' L:' + this.calculateWorkTime(pudo.open_hours_mo_start, pudo.open_hours_mo_end) + '<br>';
            c += ' Ma: ' + this.calculateWorkTime(pudo.open_hours_tu_start, pudo.open_hours_tu_end) + '<br>';
            c += ' Mi: ' + this.calculateWorkTime(pudo.open_hours_we_start, pudo.open_hours_we_end) + '<br>';
            c += ' J: ' + this.calculateWorkTime(pudo.open_hours_th_start, pudo.open_hours_th_end) + '<br>';
            c += ' V: ' + this.calculateWorkTime(pudo.open_hours_fr_start, pudo.open_hours_fr_end) + '<br>';
            c += ' S: ' + this.calculateWorkTime(pudo.open_hours_sa_start, pudo.open_hours_sa_end) + '<br>';
            c += ' D: ' + this.calculateWorkTime(pudo.open_hours_su_start, pudo.open_hours_su_end);
            c += '</div></div>'; //pudo_more_popup_location_address
            c += '<div><strong>Plati:</strong> ' + (pudo.service_cod ? 'Incaseaza ramburs' : 'Nu incaseaza ramburs') + '</div>';
            c += '<div><strong>Tip plata:</strong> ' + this.getPaymentType(pudo.accepted_payment_type) + '</div>';
            c += '</div>'; //pudo_more_popup_address_details
            c += '<div class="pudo_more_popup_location_description">';
            c += '<span>' + pudo.address_description + '</span>';
            c += '</div>'; //pudo_more_popup_location_description
            c += '</div>'; //pudo_more_popup_details_wrapper
            c += '<div class="pudo_more_popup_select_button">';
            c += '<button class="pudo_more_popup_button navigate-btn" onclick="openGoogleMaps(' + pudo.latitude + ' , ' + pudo.longitude + ')">Navigare</button>';
            c += '</div>'; //pudo_more_popup_select_button
            c += '</div>'; //pudo_more_popup_details
            c += '<div class="pudo_more_popup_location_details">';
            c += pudo.main_picture ? '<img src="' + pudo.main_picture + '" alt=""/>' : '<img src="' + ico + '" alt="PinPoint"/>';
            c += '</div>'; //pudo_more_popup_location_details
            c += '</div>'; //pudo_more_popup_container

            showMoreModal.append(c);
            showMoreModal.modal({
                title: pudo.name,
                responsive: true,
                buttons: [],
            });
            showMoreModal.modal('openModal');
        },

        find: function (pudoId) {
            return _.findWhere(this.pins, {pudo_id: pudoId.toString()});
        },

        getPaymentType: function (paymentType) {
            paymentType = JSON.parse(paymentType);
            var paymentString = '';
            if (paymentType.Cash) {
                paymentString = 'Numerar';
            }
            if (paymentType.Card) {
                paymentString += paymentString != '' ? ', Card' : 'Card';
            }
            if (paymentType.Online) {
                paymentString += paymentString != '' ? ', Online' : 'Online';
            }
            if (!paymentType.Cash && !paymentType.Card && !paymentType.Online) {
                paymentString = 'Fara Plata';
            }
            return paymentString;
        },

        openGoogleMaps: function (latitude, longitude) {
            window.open("https://www.google.com/maps/dir/?api=1&travelmode=driving&layer=traffic&destination=" + latitude + "," + longitude);
        },

        searchPudo: function (element) {
            let errors = $('#error_search');
            errors.remove();
            let text = $(element).val();

            let lis = [];
            $('.choose_elements').each(function (idx, val) {
                let ele = $(val);
                if (ele.is(':checked')) {
                    lis = lis.concat($('ul.pudo_search_list li[data-type="' + ele.val() + '"]').toArray());
                }
            });

            if (lis.length === 0) {
                errors.remove();
                $('div.pudo_search_header').append('<p id="error_search">Minim 3 litere</p>');
                return;
            }

            if (text.length >= 3) {
                lis.forEach(function (val) {
                    let li = $(val);
                    if (li.data('address').toLowerCase().indexOf(text.toLowerCase()) < 0) {
                        li.hide();
                    } else {
                        li.show();
                    }
                });
            } else {
                lis.forEach(function (val) {
                    let li = $(val);
                    li.show();
                });
                $('div.pudo_search_header').append('<p id="error_search">Minim 3 litere</p>');
            }
        },

        chooseElements: function () {
            let elements = $('.choose_elements');
            // let lis = $('ul.pudo_search_list li');
            elements.each(function (idx, val) {
                let ele = $(val);
                if (ele.is(':checked')) {
                    $('ul.pudo_search_list li[data-type="' + ele.val() + '"]').show();
                } else {
                    $('ul.pudo_search_list li[data-type="' + ele.val() + '"]').hide();
                }
            });
        },

        locationSelect: function (element) {
            let that = this;
            let ele = $(element);
            that.removeHighlight();
            if (ele.data('id') > 0) {
                ele.addClass('pudo-highlight');
                that.markers.eachLayer(function (layer) {
                    if (ele.data('id') === parseInt(layer.options.key)) {
                        that.map.setView([ele.data('latitude'), ele.data('longitude')], 12);
                        layer.openPopup();
                    }
                });
            }

        },

        removeHighlight: function () {
            $('ul.pudo_search_list li').each(function (idx, val) {
                let li = $(val);
                li.removeClass('pudo-highlight');
            });
        },

        scrollToPudo: function (key) {
            let pudoItem = $('#' + key);
            pudoItem.addClass('pudo-highlight');
            document.getElementById(key).scrollIntoView();
        }
    };

    return mapObj;
})
