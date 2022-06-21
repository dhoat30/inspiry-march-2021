const $ = jQuery

class PhoneModal {
    constructor() {
        this.stickyPhoneBtn = $('.sticky-phone-button .btn')
        this.events()
    }
    events() {
        this.stickyPhoneBtn.on('click', this.showStickyPhoneModal)
        // this.stickyPhoneBtn.hover(this.showStickyPhoneModal)
    }
    showStickyPhoneModal() {
        console.log("on hover")
        $('.sticky-phone-button .wd-phone-modal-container').toggle()
        $('.sticky-phone-button .btn .phone-icon').toggle()
        $('.sticky-phone-button .btn .close-icon').toggle()

    }

}
export default PhoneModal