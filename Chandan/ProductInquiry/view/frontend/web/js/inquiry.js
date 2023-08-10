// app/code/Chandan/ProductInquiry/view/frontend/web/js/inquiry.js
require(['jquery'], function ($) {
    $(document).on('submit', '#product-inquiry-form', function (event) {
        event.preventDefault();
        
        var form = $(this);
        var formData = form.serialize();
        
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // Handle success
                    alert(response.message);
                } else {
                    // Handle error
                    alert(response.message);
                }
            },
            error: function () {
                alert('An error occurred while submitting the inquiry.');
            }
        });
    });
});
