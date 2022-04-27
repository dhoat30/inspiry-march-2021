import GetUrlParam from "./GetUrlParam";

const $ = jQuery

class StockToggle {
    constructor() {

        this.events();

    }
    events() {
        // facet in stock for toggle button
        document.addEventListener('facetwp-refresh', this.toggleStyleOnRefresh);
        $('.product-archive-reset').on('click', this.resetFacet)
        // change toggle style on facet load 

    }


    toggleStyleOnRefresh() {
        $('#stock-toggle-input').on('change', () => {
            // get url param to check the url parameter
            const getUrlParam = new GetUrlParam()

            console.log(FWP)

            if (getUrlParam.getUrlParam()["_availability"] === "instock") {
                console.log('availability exist')
                // if the instock exist when toggling in stock button off then pass empty value to availability facet 
                FWP.facets['availability'] = [];
                FWP.fetchData();
                $('#stock-toggle-input').prop('checked', false);
                $('#stock-toggle-label span').text("OFF")
                $('.stock-toggle').removeClass('enabled')

                document.addEventListener('facetwp-loaded', () => {
                    console.log("facet loaded")
                    // remove the availability param from url 
                    var refresh = window.location.protocol + "//" + window.location.host + window.location.pathname + `?${FWP.buildQueryString()}`;
                    window.history.pushState({ path: refresh }, '', refresh);

                });

            }
            else {
                console.log('availability does not exist')
                console.log($('#stock-toggle-input').is(":checked"))
                $('.stock-toggle').addClass('enabled')
                FWP.facets['availability'] = ['instock'];
                FWP.fetchData();
                $('#stock-toggle-input').prop('checked', true);
                $('#stock-toggle-label span').text("ON")
                document.addEventListener('facetwp-loaded', () => {

                    // window.location.href = window.location.href + '?' + FWP.buildQueryString();
                    var refresh = window.location.protocol + "//" + window.location.host + window.location.pathname + `?${FWP.buildQueryString()}`;
                    window.history.pushState({ path: refresh }, '', refresh);

                });
            }
        })
    }

    resetFacet() {
        // remove the availability param from url 
        var refresh = window.location.protocol + "//" + window.location.host + window.location.pathname + `?${FWP.buildQueryString()}`;
        window.history.pushState({ path: refresh }, '', refresh);
        $('.stock-toggle').removeClass('enabled')
        $('#stock-toggle-input').prop('checked', false);
        $('#stock-toggle-label span').text("OFF")
    }
}
export default StockToggle