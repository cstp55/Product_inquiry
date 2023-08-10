define([
    'ko',
    'jquery',
    'underscore',
    'uiComponent',
    'Magento_Ui/js/modal/confirm',
    'mage/url',
    'mage/translate',
    'Magento_Checkout/js/model/shipping-address/form-popup-state',
    'Magento_Customer/js/model/customer',
    'Magento_Ui/js/modal/modal',
    'Magento_Checkout/js/action/create-shipping-address',
    'Magento_Ui/js/modal/alert',
    'mage/validation'
], function(ko, $, _, Component, confirm, urlBuilder, $t, formPopUpState, customer, modal, createShippingAddress, alert) {
    'use strict';
    var popUp = null;

    return Component.extend({
        defaults: {
            template: 'Chandan_ProductInquiry/inquiry-button',
            formTemplate: 'Chandan_ProductInquiry/form-address/form',
            buttonText: window.whatsappConfig.pageViewButtonTitle,
            redirectUrl: urlBuilder.build('product/inquiry/index'),
            productFormSelector: '#product_inquiry_form'
        },
        isFormPopUpVisible: formPopUpState.isVisible,
        isCustomerLoggedIn: customer.isLoggedIn,
        isVirtual: ko.observable(window.whatsappConfig.isVirtual),

        initObservable: function() {
            this._super();
            return this;
        },

        /**
         * @return {exports}
         */
        initialize: function() {
            var self = this;
            this._super();

            this.isFormPopUpVisible.subscribe(function(value) {
                if (value) {
                    self.getPopUp().openModal();
                }
            });
            if (!_.isEmpty(window.whatsappConfig.customerData.addresses)) {
                $('#co-shipping-form').hide();
            } else {
                $('#co-shipping-form').show();
            }
            return this;
        },

        /**
         * Confirmation method
         */
        buyNow: function() {
            var form = $(this.productFormSelector),
                self = this
            if (!(form.validation() && form.validation('isValid'))) {
                return;
            }
            if (self.isAddressAvailable()) {

                var formData = new FormData(form[0]);
                formData.set('from_product', '1');
                $.ajax({
                    url: requestUrl,
                    data: formData,
                    type: 'post',
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,

                    /** Show loader before send */
                    beforeSend: function() {
                        $('body').trigger('processStart');
                    },
                    success: function(response) {
                        if (response.error === false) {
                            
                        } else {
                            alert({
                                title: $.mage.__('Alert!'),
                                content: response.message,
                                actions: {
                                    always: function() {}
                                }
                            });
                        }
                        $('body').trigger('processStop');
                    },
                    complete: function(response) {
                        $('body').trigger('processStop');
                    }
                });
            } else {
                self.showFormPopUp();
            }
        },
        /**
         * Show address form popup
         */
        showFormPopUp: function() {
            this.isFormPopUpVisible(true);
        },

        /**
         * @return {*}
         */
        getPopUp: function() {
            var self = this,
                buttons;

            if (!popUp) {
                buttons = this.popUpForm.options.buttons;
                this.popUpForm.options.buttons = [{
                        text: buttons.save.text ? buttons.save.text : $t('Save Address'),
                        class: buttons.save.class ? buttons.save.class : 'action primary action-save-address',
                        click: self.saveNewAddress.bind(self)
                    },
                    {
                        text: buttons.cancel.text ? buttons.cancel.text : $t('Cancel'),
                        class: buttons.cancel.class ? buttons.cancel.class : 'action secondary action-hide-popup',

                        /** @inheritdoc */
                        click: this.onClosePopUp.bind(this)
                    }
                ];

                /** @inheritdoc */
                this.popUpForm.options.closed = function() {
                    self.isFormPopUpVisible(false);
                };

                this.popUpForm.options.modalCloseBtnHandler = this.onClosePopUp.bind(this);
                this.popUpForm.options.keyEventHandlers = {
                    escapeKey: this.onClosePopUp.bind(this)
                };
                popUp = modal(this.popUpForm.options, $(this.popUpForm.element));
            }

            return popUp;
        },

        /**
         * Revert address and close modal.
         */
        onClosePopUp: function() {
            this.getPopUp().closeModal();
        },

        /**
         * Check if address avaialble
         */
        isAddressAvailable: function() {
            var self = this,
                isAvalable = false;

            if (self.isVirtual()) {
                if (!_.isEmpty(self.billingAddress())) {
                    isAvalable = true;
                }
            } else {
                if (!_.isEmpty(self.shippingAddress())) {
                    isAvalable = true;
                }
            }
            return isAvalable;
        },

        /**
         * Trigger Shipping data Validate Event.
         */
        triggerShippingDataValidateEvent: function() {
            this.source.trigger('shipping-address-fieldset.data.validate');
        },
        getAddressList: function() {
            var addressList = [];
            if (!_.isEmpty(window.whatsappConfig.customerData.addresses)) {
                var address = Object.keys(window.whatsappConfig.customerData.addresses).map((key) => [key, window.whatsappConfig.customerData.addresses[key]]);
                for (let i = 0; i < address.length; i++) {
                    for (let j = 0; j < address[0].length; j++) {
                        if (j == 1) {
                            addressList[i] = [{ 'id': address[i][j]['id'] }, { 'inlineaddress': address[i][j]['inline'] }];
                            // addressList['inlineaddress'] = address[i][j]['inline'];
                        }
                    }
                }
            }
            //console.log(addressList);
            return addressList;
        },
        isFormInline: function() {
            return true;
        },
        addressChanged: function(event) {
            var addressId = $('select#selectedAddress.select').val();
            console.log(addressId);
            if (addressId == "newAddress") {
                $('#co-shipping-form').show();
            } else {
                $('#co-shipping-form').hide();
                this.shippingAddress(
                    this.formatAddress(_.findWhere(window.whatsappConfig.customerData.addresses, { id: addressId }))
                );
                this.billingAddress(
                    this.formatAddress(_.findWhere(window.whatsappConfig.customerData.addresses, { id: addressId }))
                );
            }

        },
        proceedForWhatsapp: function() {
            this.buyNow();
        }
    });
});