jQuery(document).ready(function ($) {
    function loadPortfolio(page = 1, category = '') {
        jQuery.ajax({
            url: portfolioPlugin.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'portfolio_filter',
                nonce: portfolioPlugin.nonce,
                category: category,
                paged: page
            },
            beforeSend: function () {
                jQuery('#portfolio-items').html('<p>Loading...</p>');
            },
            success: function (response) {
                if (response.success) {
                    jQuery('#portfolio-items').html(response.data);
                }
            },
            error: function () {
                jQuery('#portfolio-items').html('<p>An error occurred.</p>');
            }
        });
    }

    // Filter Category Click
    jQuery(document).on('click', '.filter-button', function (e) {
        e.preventDefault();
        var category = jQuery(this).data('category');

        jQuery('.filter-button').removeClass('active');
        jQuery(this).addClass('active');

        loadPortfolio(1, category);
    });

    // Pagination Click
    jQuery(document).on('click', '.portfolio-pagination a', function (e) {
        e.preventDefault();
        var page = jQuery(this).data('page');
        var category = jQuery('.filter-button.active').data('category');

        loadPortfolio(page, category);
    });
});
