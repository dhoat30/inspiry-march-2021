import OwlCarousel from './OwlCarousel';
import 'owl.carousel/dist/assets/owl.carousel.css';

import 'owl.carousel';
let $ = jQuery;
class EveryOwlCarousel {
    constructor() {
        this.events();
    }
    events() {
        // home page hero slider 
        this.homeHeroSlider()
        //trending section carousel 
        this.trendingCarousel();

        // this.brandLogoHomePageCarousel();
        // product gallery on single product page
        // this.productGallery();

        // // banner carousel 
        this.banner();

        // recently viewed carousel 
        this.recentlyViewedCarousel()

        // home page category cards 
        this.homeCategoryCards()
        // be inspired home page
        this.beInspiredHome()
    }
    homeHeroSlider() {

        // owl carousel 
        let className = '.slider-container .owl-carousel';
        let args = {
            loop: true,
            nav: true,
            margin: 20,
            lazyLoad: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            responsiveBaseElement: ".row-container",
            responsiveClass: true,
            rewind: true,
            dots: true,
            animateOut: 'fadeOut',
            items: 1
        }
        const trendingNow = new OwlCarousel(args, className);
    }

    // banner carousel 
    banner() {
        // // owl carousel 

        let className = '.banner-container .owl-carousel';
        let args = {
            lazyLoad: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            responsiveBaseElement: ".row-container",
            responsiveClass: true,
            rewind: true,
            dots: false,
            loop: true,
            responsive: {
                0: {
                    items: 1,
                    dots: false
                }

            }
        }
        const banner = new OwlCarousel(args, className);
    }

    productGallery() {
        // // owl carousel 
        // $('.single-product .flex-control-thumbs').addClass('splide');
        let className = '.woocommerce-product-gallery .owl-carousel';
        let args = {
            margin: 20,
            autoplay: true,
            autoplayTimeout: 2000,
            autoplayHoverPause: true,
            responsiveBaseElement: ".row-container",
            responsiveClass: true,
            rewind: true,
            dots: false,
            responsive: {
                0: {
                    items: 4,

                    dots: false
                },
                600: {
                    items: 4,
                    dots: false
                }

            }
        }
        // const trendingNow = new OwlCarousel(args, className);
    };


    brandLogoHomePageCarousel() {

        // owl carousel 
        let className = '.brand-logo-section .owl-carousel';
        let args = {
            loop: true,
            navText: "G",
            margin: 20,
            lazyLoad: true,
            autoplay: true,
            autoplayTimeout: 2000,
            autoplayHoverPause: true,
            responsiveBaseElement: ".row-container",
            responsiveClass: true,
            rewind: true,
            responsive: {
                0: {
                    items: 1,
                    dots: true
                },
                600: {
                    items: 2,

                    dots: true
                },
                900: {
                    items: 3,

                    dots: true
                },
                1200: {
                    items: 3,
                    dots: true
                },
                1500: {
                    items: 4,
                    dots: true
                }
            }
        }
        const trendingNow = new OwlCarousel(args, className);
    }
    trendingCarousel() {

        // owl carousel 
        let className = '.trending-section .owl-carousel';
        let args = {
            loop: true,
            navText: [`<svg  width="21.361" height="12.817" viewBox="0 0 21.361 12.817">
            <path fill="#ffffff" id="Path_67" data-name="Path 67" d="M111.1,172.65a.542.542,0,0,1,0-.754l4.432-4.966h-19a.534.534,0,0,1,0-1.068h19l-4.426-4.966a.533.533,0,1,1,.754-.754s5.287,5.808,5.34,5.874a.579.579,0,0,1,.16.38.548.548,0,0,1-.16.38c-.053.053-5.34,5.874-5.34,5.874a.541.541,0,0,1-.38.154A.552.552,0,0,1,111.1,172.65Z" transform="translate(117.361 172.804) rotate(180)"/>
          </svg>
          `, `<svg  width="21.361" height="12.817" viewBox="0 0 21.361 12.817">
            <path fill="#ffffff" id="Path_63" data-name="Path 63" d="M111.1,172.65a.542.542,0,0,1,0-.754l4.432-4.966h-19a.534.534,0,0,1,0-1.068h19l-4.426-4.966a.533.533,0,1,1,.754-.754s5.287,5.808,5.34,5.874a.579.579,0,0,1,.16.38.548.548,0,0,1-.16.38c-.053.053-5.34,5.874-5.34,5.874a.541.541,0,0,1-.38.154A.552.552,0,0,1,111.1,172.65Z" transform="translate(-96 -159.986)"/>
          </svg>
          `],
            margin: 20,
            center: true,
            lazyLoad: true,
            responsiveBaseElement: ".row-container",
            responsiveClass: true,
            rewind: true,
            mouseDrag: true,
            touchDrag: true,
            nav: true,
            responsive: {
                0: {
                    items: 1,
                    dots: false
                },
                600: {
                    items: 2,
                    dots: false
                },
                700: {
                    items: 3,
                    dots: false
                },
                1440: {
                    items: 3,
                    dots: false
                }
            }
        }
        const trendingNow = new OwlCarousel(args, className);
    }

    recentlyViewedCarousel() {

        // owl carousel 
        let className = '.recently-viewed-section .owl-carousel';
        let args = {
            loop: true,
            navText: [`<svg  width="21.361" height="12.817" viewBox="0 0 21.361 12.817">
            <path fill="#ffffff" id="Path_67" data-name="Path 67" d="M111.1,172.65a.542.542,0,0,1,0-.754l4.432-4.966h-19a.534.534,0,0,1,0-1.068h19l-4.426-4.966a.533.533,0,1,1,.754-.754s5.287,5.808,5.34,5.874a.579.579,0,0,1,.16.38.548.548,0,0,1-.16.38c-.053.053-5.34,5.874-5.34,5.874a.541.541,0,0,1-.38.154A.552.552,0,0,1,111.1,172.65Z" transform="translate(117.361 172.804) rotate(180)"/>
          </svg>
          `, `<svg  width="21.361" height="12.817" viewBox="0 0 21.361 12.817">
            <path fill="#ffffff" id="Path_63" data-name="Path 63" d="M111.1,172.65a.542.542,0,0,1,0-.754l4.432-4.966h-19a.534.534,0,0,1,0-1.068h19l-4.426-4.966a.533.533,0,1,1,.754-.754s5.287,5.808,5.34,5.874a.579.579,0,0,1,.16.38.548.548,0,0,1-.16.38c-.053.053-5.34,5.874-5.34,5.874a.541.541,0,0,1-.38.154A.552.552,0,0,1,111.1,172.65Z" transform="translate(-96 -159.986)"/>
          </svg>
          `],
            margin: 20,
            center: true,
            lazyLoad: true,
            responsiveBaseElement: ".row-container",
            responsiveClass: true,
            rewind: true,
            mouseDrag: true,
            touchDrag: true,
            nav: true,
            responsive: {
                0: {
                    items: 1,
                    dots: false
                },
                600: {
                    items: 2,
                    dots: false
                },
                900: {
                    items: 3,
                    dots: false
                },
                1440: {
                    items: 3,
                    dots: false
                }
            }
        }
        const recentlyViewed = new OwlCarousel(args, className);
    }

    // home page category cards
    homeCategoryCards() {

        // owl carousel 
        let className = '.home .category-cards-section .owl-carousel';
        let args = {
            mouseDrag: true,
            touchDrag: true,
            nav: true,
            lazyLoad: true,
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            navText: [`<svg  width="21.361" height="12.817" viewBox="0 0 21.361 12.817">
            <path fill="#ffffff" id="Path_67" data-name="Path 67" d="M111.1,172.65a.542.542,0,0,1,0-.754l4.432-4.966h-19a.534.534,0,0,1,0-1.068h19l-4.426-4.966a.533.533,0,1,1,.754-.754s5.287,5.808,5.34,5.874a.579.579,0,0,1,.16.38.548.548,0,0,1-.16.38c-.053.053-5.34,5.874-5.34,5.874a.541.541,0,0,1-.38.154A.552.552,0,0,1,111.1,172.65Z" transform="translate(117.361 172.804) rotate(180)"/>
          </svg>
          `, `<svg  width="21.361" height="12.817" viewBox="0 0 21.361 12.817">
            <path fill="#ffffff" id="Path_63" data-name="Path 63" d="M111.1,172.65a.542.542,0,0,1,0-.754l4.432-4.966h-19a.534.534,0,0,1,0-1.068h19l-4.426-4.966a.533.533,0,1,1,.754-.754s5.287,5.808,5.34,5.874a.579.579,0,0,1,.16.38.548.548,0,0,1-.16.38c-.053.053-5.34,5.874-5.34,5.874a.541.541,0,0,1-.38.154A.552.552,0,0,1,111.1,172.65Z" transform="translate(-96 -159.986)"/>
          </svg>
          `],
            margin: 20,
            responsive: {
                0: {
                    items: 1,
                    dots: false
                },
                600: {
                    items: 2,
                    dots: false
                },
                900: {
                    items: 3,
                    dots: false
                },
                1350: {
                    loop: false,
                    autoplay: false,
                    items: 4,
                    dots: false
                }
            }
        }
        const homeCategoryCards = new OwlCarousel(args, className);
    }
    // home page be inspired

    beInspiredHome() {

        // owl carousel 
        let className = '.home .be-inspired-section .owl-carousel';
        let args = {
            mouseDrag: true,
            touchDrag: true,
            nav: true,
            lazyLoad: true,
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            navText: [`<svg  width="21.361" height="12.817" viewBox="0 0 21.361 12.817">
            <path fill="#ffffff" id="Path_67" data-name="Path 67" d="M111.1,172.65a.542.542,0,0,1,0-.754l4.432-4.966h-19a.534.534,0,0,1,0-1.068h19l-4.426-4.966a.533.533,0,1,1,.754-.754s5.287,5.808,5.34,5.874a.579.579,0,0,1,.16.38.548.548,0,0,1-.16.38c-.053.053-5.34,5.874-5.34,5.874a.541.541,0,0,1-.38.154A.552.552,0,0,1,111.1,172.65Z" transform="translate(117.361 172.804) rotate(180)"/>
          </svg>
          `, `<svg  width="21.361" height="12.817" viewBox="0 0 21.361 12.817">
            <path fill="#ffffff" id="Path_63" data-name="Path 63" d="M111.1,172.65a.542.542,0,0,1,0-.754l4.432-4.966h-19a.534.534,0,0,1,0-1.068h19l-4.426-4.966a.533.533,0,1,1,.754-.754s5.287,5.808,5.34,5.874a.579.579,0,0,1,.16.38.548.548,0,0,1-.16.38c-.053.053-5.34,5.874-5.34,5.874a.541.541,0,0,1-.38.154A.552.552,0,0,1,111.1,172.65Z" transform="translate(-96 -159.986)"/>
          </svg>
          `],
            responsive: {
                0: {
                    items: 1,
                    dots: false
                },
                600: {
                    items: 2,
                    dots: false
                },
                900: {
                    loop: false,
                    autoplay: false,
                    items: 3,
                    dots: false
                }
            }
        }
        const homeCategoryCards = new OwlCarousel(args, className);
    }

}
export default EveryOwlCarousel;