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
                navText: [`<svg  width="21.361" height="12.817" viewBox="0 0 21.361 12.817">
                <path fill="#ffffff" id="Path_67" data-name="Path 67" d="M111.1,172.65a.542.542,0,0,1,0-.754l4.432-4.966h-19a.534.534,0,0,1,0-1.068h19l-4.426-4.966a.533.533,0,1,1,.754-.754s5.287,5.808,5.34,5.874a.579.579,0,0,1,.16.38.548.548,0,0,1-.16.38c-.053.053-5.34,5.874-5.34,5.874a.541.541,0,0,1-.38.154A.552.552,0,0,1,111.1,172.65Z" transform="translate(117.361 172.804) rotate(180)"/>
              </svg>
              `, `<svg  width="21.361" height="12.817" viewBox="0 0 21.361 12.817">
                <path fill="#ffffff" id="Path_63" data-name="Path 63" d="M111.1,172.65a.542.542,0,0,1,0-.754l4.432-4.966h-19a.534.534,0,0,1,0-1.068h19l-4.426-4.966a.533.533,0,1,1,.754-.754s5.287,5.808,5.34,5.874a.579.579,0,0,1,.16.38.548.548,0,0,1-.16.38c-.053.053-5.34,5.874-5.34,5.874a.541.541,0,0,1-.38.154A.552.552,0,0,1,111.1,172.65Z" transform="translate(-96 -159.986)"/>
              </svg>
              `],
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