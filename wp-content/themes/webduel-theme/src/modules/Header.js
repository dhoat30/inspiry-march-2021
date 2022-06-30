const $ = jQuery

class Header {
    constructor() {
        this.events()
    }
    events() {
        // show phone modal 
        $('.useful-links-container .phone-container').hover(
            (e) => {
                this.showSignInModal('.useful-links-container', '.wd-phone-modal-container')
            },
            (e) => {
                this.hideSignInModal('.useful-links-container', '.wd-phone-modal-container')
            },
        )
        // show sign in modal 
        $('.useful-links-container .sign-in-container').hover(
            (e) => {
                this.showSignInModal('.useful-links-container', '.sign-in-modal')
            },
            (e) => {
                this.hideSignInModal('.useful-links-container', '.sign-in-modal')
            },
        )
        // show design board in modal 
        $('.useful-links-container .design-board-icon-container ').hover(
            (e) => {
                this.showSignInModal('.useful-links-container', '.design-board-header-modal')
            },
            (e) => {
                this.hideSignInModal('.useful-links-container', '.design-board-header-modal')
            }
        )

    }
    // show phone modal 

    // sign in modal 
    showSignInModal(e, modalClass) {

        $(e).find(modalClass).show()
    }
    hideSignInModal(e, modalClass) {
        $(e).find(modalClass).hide()

    }

}
export default Header