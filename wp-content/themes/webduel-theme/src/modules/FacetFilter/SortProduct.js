const $ = jQuery

class SortProduct {
    constructor() {
        this.sortBtn = $('#sort-product-btn')
        this.events()
    }

    events() {
        this.sortBtn.on('click', this.showSortDropDown)
    }
    showSortDropDown() {
        //$('#sel1').find('option[value="2"]').prop('selected', true);
        $('.orderby').css({ "opacity": "1" })
    }
}
export default SortProduct