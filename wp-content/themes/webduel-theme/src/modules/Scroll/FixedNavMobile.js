const $ = jQuery

class FixedNavMobile {
    constructor() {
        this.events()
    }

    events() {
        //    fixed nav on upscroll 
        var lastScrollTop = 0;
        $(window).on('scroll', function (event) {
            var st = $(this).scrollTop();
            if (st > lastScrollTop || st < 200) {

                $(".fixed-nav-container").removeClass('fixed-nav-active')

            } else {
                $(".fixed-nav-container").addClass('fixed-nav-active')
            }
            lastScrollTop = st;
        });
    }
}
export default FixedNavMobile