let $ = jQuery

class Search {
    // describe and create/initiate our object
    constructor() {
        this.url = `${inspiryData.root_url}/wp-json/inspiry/v1/search?term=`
        this.allProductsURL = `${inspiryData.root_url}/wp-json/inspiry/v1/all-products-search?term=`
        this.loading = $('.fa-spinner')
        this.searchIcon = $('.search-code .desktop-search')
        this.resultDiv = $('.search-code .result-div')
        this.searchField = $('#search-term')
        this.typingTimer
        this.searchBar = $('.search-bar')
        this.events()
        this.isSpinnerVisible = false
        this.previousValue
    }
    // events 
    events() {
        this.searchField.on("keyup", this.typingLogic.bind(this))
        this.searchField.on("click", this.searchFieldClickHandler.bind(this))
        $(document).on("click", this.documentClickHandler.bind(this))
        // redirect to result page when clicked on search icon  
        this.searchIcon.on('click', this.takeToQueryPage)
        $(document).on('keypress', this.takeToQueryPageOnEnter);
    }

    // document click handler
    documentClickHandler(e) {
        if (!this.searchBar.is(e.target) && this.searchBar.has(e.target).length === 0) {
            this.resultDiv.hide()
        }
    }
    // search field click
    searchFieldClickHandler() {
        this.resultDiv.show()
    }
    // methods
    typingLogic() {
        if (this.searchField.val() != this.previousValue) {
            clearTimeout(this.typingTimer)
            // check if the value is not empty
            if (this.searchField.val()) {
                if (!this.isSpinnerVisible) {
                    // show loading spinner
                    this.loading.show()
                    this.isSpinnerVisible = true
                }
                this.typingTimer = setTimeout(this.getResults.bind(this), 2000)
            }
            else {
                // hide loading
                this.loading.hide()
                this.isSpinnerVisible = false
            }
        }
        this.previousValue = this.searchField.val()

    }


    // get result method
    async getResults() {
        console.log(this.searchField.val())
        // send request 
        $.getJSON(`${this.url}${this.searchField.val()}`, (data) => {
            this.resultDiv.show()
            if (data.length) {
                this.resultDiv.html(`<ul class="search-list">
                ${data.map(item => {
                    return `<li>
                    <a href="${item.link}"> 
                    <img src="${item.image}" alt=${item.title}/>
                    <span>${item.title}</span>
                    </a>
                    </li>`
                }).join('')}
                </ul>`)

                // get rest of the query projects
                $.getJSON(`${this.allProductsURL}${this.searchField.val()}`, (allProducts) => {

                    if (allProducts.length) {
                        $('.search-list').append(` ${allProducts.map(item => {
                            return `<li>
                            <a href="${item.link}"> 
                            <img src="${item.image}" alt=${item.title}/>
                            <span>${item.title}</span>
                            </a>
                            </li>`
                        }).join('')}`)
                    }

                })

            }
            else {
                this.resultDiv.html(`<p class="center-align medium">Nothing found</p>`)
            }
            // hide loading spinner 
            if (this.isSpinnerVisible) {
                this.loading.hide()
                this.isSpinnerVisible = false
            }
        })
    }

    // query page redirect 
    takeToQueryPage(e) {

        if ($('#search-term').val().length >= 1) {
            window.location.href = `${inspiryData.root_url}/products/?_search=${$('#search-term').val()}`;
        }

    }

    takeToQueryPageOnEnter(e) {
        if ($('#search-term').val().length >= 1 && e.which == 13) {
            window.location.href = `${inspiryData.root_url}/products/?_search=${$('#search-term').val()}`;
        }
    }
}
export default Search