const $ = jQuery
import 'owl.carousel/dist/assets/owl.carousel.css';
import 'owl.carousel';

class WooGallery {
    constructor() {
        this.events()
    }
    events() {
        // owl  carousel for single product page
        this.slideShow()

    }
    slideShow() {
        // $('.single-product .flex-control-nauv').addClass('owl-carousel')
        // setTimeout(() => {
        $(".flex-control-nav ").ready(function () {
            // Handler for .load() called.
            var x = window.matchMedia("(max-width: 3000px)")
            // if (x.matches) {
            var thubmNav = $('.woocommerce-product-gallery .flex-control-nav');
            if (thubmNav.length) {
                if (!thubmNav.closest('.navWrapper').length) {
                    thubmNav.addClass('owl-carousel')
                }
            }
            $('.owl-carousel').owlCarousel({
                loop: false,
                rewind: true,
                autoplay: true,
                margin: 10,
                nav: true,
                navText: ['<i class="fa-thin fa-arrow-left-long"></i>', '<i class="fa-thin fa-arrow-right-long"></i>'],
                responsive: {
                    0: {
                        items: 4
                    },
                    400: {
                        items: 6
                    },
                    600: {
                        items: 8
                    },
                    1366: {
                        items: 10
                    }
                }
            })
        });


        // }

        // }, 200)


    }

}
export default WooGallery