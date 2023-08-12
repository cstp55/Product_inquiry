// app/code/Company/ProductInquiry/view/adminhtml/web/js/sendreply.js
define([
    'Magento_Ui/js/modal/modal',
    'mage/url'
], function (modal, url) {
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
                    var subject = $('#send-reply-modal-subject').val();
                    var message = $('#send-reply-modal-message').val();
                    var inquiryId = config.inquiryId;

                    $.ajax({
                        url: url.build('productinquiry/inquiry/sendreply'),
                        type: 'post',
                        data: {id: inquiryId, subject: subject, message: message},
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                alert('Reply email sent successfully.');
                            } else {
                                alert('Error sending reply email.');
                            }
                        },
                        error: function() {
                            alert('Error sending reply email.');
                        }
                    });

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
