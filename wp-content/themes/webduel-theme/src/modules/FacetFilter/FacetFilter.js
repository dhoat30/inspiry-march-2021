import StickyScroller from 'sticky-scroller'
const $ = jQuery

class FacetFilter {
    constructor() {


        // mobile and desktop filter show/hide
        this.closeButton = $('.mobile-filter-container .close-button')
        this.closeIcon = $('.mobile-filter-container .close-icon')
        this.showResultsButton = $('.mobile-filter-container .primary-button')
        // desktop filter show 
        this.filterButton = $('.filter-sort-container .filter-button')
        // facet label button
        this.labelButton = $('.facet-label-button')
        this.events()

    }
    events() {
        //    set cookie to false every page load to hide the facet container 
        Cookies.set('showingProductFacetContainer', 'false')

        // show filter button in the bottom on mobile div
        $(window).on('scroll', function (event) {
            var scroll = $(window).scrollTop();
            // Do something
            if (scroll > 400 && window.matchMedia("(max-width: 1100px)").matches) {
                $('.archive  .filter-button').addClass('fixed-filter-button')
            }
            else {
                $('.archive .filter-button').removeClass('fixed-filter-button')
            }
        });
        // show filter container
        this.filterButton.on('click', this.showDesktopContainer)

        // hide filter container
        this.closeIcon.on('click', this.hideDesktopContainer)
        this.showResultsButton.on('click', this.hideDesktopContainer)
        // show filter when clicked on label desktop 

        this.labelButton.on('click', this.showFilter)
    }



    // show desktop filter container on button click
    showDesktopContainer() {
        console.log("filter button clicked")
        const showContainer = Cookies.get('showingProductFacetContainer')

        console.log(showContainer)
        if (window.matchMedia("(max-width: 1100px)").matches) {
            $('.facet-wp-container').slideDown('slow')
        }
        else {

            if (showContainer === 'true') {
                console.log('hide the filter container')
                $('.facet-wp-container').animate({
                    width: '0',
                    marginRight: "0"
                })
                Cookies.set('showingProductFacetContainer', 'false')
                $('.filter-sort-container .filter-button span').text('Show Filters')
            }
            else {
                console.log('show the filter container')
                $('.facet-wp-container').animate({
                    width: '100%',
                    marginRight: "40px"
                })
                $('.filter-sort-container .filter-button span').text('Hide Filters')

                Cookies.set('showingProductFacetContainer', 'true')
            }
        }

    }

    hideDesktopContainer() {
        $('.filter-sort-container .filter-button span').text('Show Filters')
        $('.facet-wp-container').hide('slow')
    }

    showFilter(e) {
        $(this).siblings('.facetwp-facet').slideToggle('fast')
        $(this).find('i').toggleClass('fa-plus')
        $(this).find('i').toggleClass('fa-minus')
    }
}

export default FacetFilter