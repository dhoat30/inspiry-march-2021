import GetUrlParam from "./GetUrlParam";

const $ = jQuery

class StockToggle {
    constructor() {

        this.events();

    }
    events() {

        document.addEventListener('facetwp-refresh', function () {
            let facetVar

            facetVar = FWP
            // FWP.facets['availability'] = ['instock'];
            // FWP.fetchData();
            // if (null !== FWP.active_facet) {
            //     let facet = FWP.active_facet;
            //     let facet_name = facet.attr('data-name');
            //     let facet_type = facet.attr('data-type');
            //     console.log(facet_name);
            //     console.log(facet_type);
            // }
            console.log(facetVar)
            $('#stock-toggle-input').on('change', () => {
                const getUrlParam = new GetUrlParam()
                if (getUrlParam.getUrlParam()["_availability"] === "instock") {
                    FWP.facets['availability'] = [''];
                    FWP.fetchData();
                    // window.location.href = window.location.href + '?' + FWP.buildQueryString();
                    var refresh = window.location.protocol + "//" + window.location.host + window.location.pathname + `?${FWP.buildQueryString()}`;
                    window.history.pushState({ path: refresh }, '', refresh);
                    $('.stock-toggle').removeClass('enabled')
                    $('#stock-toggle-input').prop('checked', false);
                    $('#stock-toggle-label span').text("OFF")
                }
                else {
                    console.log($('#stock-toggle-input').is(":checked"))
                    $('.stock-toggle').addClass('enabled')
                    FWP.facets['availability'] = ['instock'];
                    FWP.fetchData();
                    // window.location.href = window.location.href + '?' + FWP.buildQueryString();
                    var refresh = window.location.protocol + "//" + window.location.host + window.location.pathname + `?${FWP.buildQueryString()}`;
                    window.history.pushState({ path: refresh }, '', refresh);
                    $('#stock-toggle-input').prop('checked', true);
                    $('#stock-toggle-label span').text("ON")
                }

            })
        });

        this.toggleStyle()
        // on change handler for toggle input 

    }
    toggleValue() {
        console.log("hello")

        // console.log($('#cmn-toggle-1').is(":checked"))
        // var url = window.location.href;
        // console.log(url)
        // const getUrlParam = new GetUrlParam()

        // if (getUrlParam.getUrlParam()["hide_sold_products"]) {
        //     location.assign(`${url}`)

        // }
        // else {
        //     location.assign(`${url}?hide_sold_products=true`)


        // }
    }
    toggleStyle() {
        // function to get param value 
        const getUrlParam = new GetUrlParam()
        // console.log(getUrlParam.getUrlParam()["hide_sold_products"])
    }
}
export default StockToggle