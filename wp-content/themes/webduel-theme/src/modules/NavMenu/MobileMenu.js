const $ = jQuery

class MobileMenu {
    constructor() {
        this.events()
    }
    events() {
        // show overlay when the mobile menu is open
        jQuery(document).ready(function ($) {
            $("ul#mega-menu-inspiry_main_menu_mobile").on("mmm:showMobileMenu", function () {
                $('.mobile-nav-overlay').show()
            });
        });

        //   hide overlay when the mobile menu is closed 
        jQuery(document).ready(function ($) {
            $("ul#mega-menu-inspiry_main_menu_mobile").on("mmm:hideMobileMenu", function () {
                $('.mobile-nav-overlay').hide()
            });
        });
    }


}

export default MobileMenu