// app/code/Company/ProductInquiry/view/adminhtml/web/js/sendreply.js
define([
    'Magento_Ui/js/modal/modal'
], function (modal) {
    'use strict';

    return function (config, element) {
        var options = {
            type: 'popup',
            responsive: true,
            title: config.title,
            buttons: [{
                text: $.mage.__('Send'),
                class: 'action-primary',
                click: function () {
                    //send the email
                    
                    this.closeModal();
                }
            }]
        };

        var popup = modal(options, $(config.modalId));

        $(element).on('click', function () {
            popup.openModal();
        });
    };
});
