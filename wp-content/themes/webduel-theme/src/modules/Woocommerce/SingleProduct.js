const $ = jQuery

class SingleProduct {
    constructor() {
        this.variationProduct = $('.single-product .variations_form .variation_id')
        this.events()
    }
    events() {
        // set the availabilty depending on the variation selected 
        this.variationProduct.on('change', this.getVariationValue)
        this.variationProduct.on('change', this.setVariationDescription)
    }
    getVariationValue(e) {
        const variationID = $(this).val()
        const variationData = JSON.parse($('.single-product .variations_form .variation-availability-data').attr('data-variation_availability'))
        if (variationID > 0) {
            // set the availability 

            const selectedVariation = variationData.filter(item => item.variation_id === Number(variationID))
            // set availability data 
            if (selectedVariation[0].availability === "in-stock") {
                $('.single-product .availability .title span').text('In Stock')
                $('.single-product .availability .title span').css({ 'color': '#1fac75' })
                $('.single-product .availability .title .fa-circle-check').css({ 'color': '#1fac75' })
            }
            else {
                $('.single-product .availability .title span').text('Pre Order')
                $('.single-product .availability .title span').css({ 'color': '#d69400' })
                $('.single-product .availability .title .fa-circle-check').css({ 'color': '#d69400' })
            }

            // set the free sample product id 
            $('#order-free-sample-input').val(variationID)
        }
    }

    setVariationDescription() {
        let variationAllData = JSON.parse($('.single-product .variations_form').attr('data-product_variations'))
        console.log(variationAllData)
        const variationID = $(this).val()

        // strip html 
        const stripHtml = (html) => {
            let tmp = document.createElement("DIV");
            tmp.innerHTML = html;
            return tmp.textContent || tmp.innerText || "";
        }
        if (variationID > 0) {
            const selectedVariation = variationAllData.filter(item => item.variation_id === Number(variationID))
            const description = stripHtml(selectedVariation[0].variation_description)
            console.log(description)
            $('.accordion-container .description').text(description)
        }

    }


}
export default SingleProduct