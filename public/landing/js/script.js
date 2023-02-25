$.fn.andSelf = function () {
    return this.addBack.apply(this, arguments);
}
jQuery(document).ready(function ($) {
    function checkClasses() {
        var FindActive = jQuery('.owl-stage').find('.owl-item.active');
        for (var i = 0; i < 2; i++) {

            if (i == 0) {
                $(FindActive[0]).find('.item').css('opacity', '1');
            } else {
                $(FindActive[i]).find('.item').css('opacity', '0.5');
            }
        }
    }
});
