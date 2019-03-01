(function ($) {
    'use strict';

    jQuery(document).ready(function () {
        function aic_get_current_count() {
            jQuery.ajax({
                url : aic_block_count.ajax_url,
                type : 'post',
                data : {
                    action : 'aic_get_current_count',
                },
                success: function (response) {
                    addNewAdElement(response);
                }
            });
        }

        function addNewAdElement(aicNewCount) {
            var elementLayout = $('#aic_field_template').text();
            var newItem = elementLayout.replace( /\%id\%/g, aicNewCount );

            jQuery('.aic_ad_list').append(newItem);

            var lastAddedItem = $('.aic_field:last-child');
            jQuery(lastAddedItem).addClass("active");
            lastAddedItem.find('.aic_field_body').stop().slideToggle("slow");
            lastAddedItem.find('.aic_field_body').css("display", "block");
        }

        $('.aic_new_add').click(function(){
            jQuery.ajax({
                url : aic_block_count.ajax_url,
                type : 'post',
                data : {
                    action : 'aic_count_increase',
                },
                success: function () {
                    aic_get_current_count();
                }
            });
        });

        jQuery('.delete_ad').click(function () {
            var result = confirm("If you delete it, the places you use this ad won't work.");
            if (result) {
                jQuery(this).closest('.aic_field').remove();
            }
        });

        jQuery('.aic_field_title').on( "click", function(e) {
            var accordion = jQuery(this).closest('.aic_field');
            if (jQuery(this).hasClass('active')){
                jQuery(this).removeClass("active");
                accordion.find('.aic_field_body').stop().slideToggle("slow");
            } else {
                jQuery(this).addClass("active");
                accordion.find('.aic_field_body').stop().slideToggle("slow");
                accordion.find('.aic_field_body').css("display", "block");
            }
            e.stopImmediatePropagation();
            e.preventDefault();
        });
    });

})(jQuery);
