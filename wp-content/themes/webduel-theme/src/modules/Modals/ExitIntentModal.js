const $ = jQuery

class ExitIntentModal {
    constructor() {
        this.closeIcon = $('.close-icon')
        // get the show modal value to check the modal exist
        this.showModalValue = $('.inspiry-modal .show-modal').data('show-modal')
        // get local storage 
        this.showModalObject = JSON.parse(localStorage.getItem("modalShowed")),
            this.events()
    }

    events() {
        console.log("hello")

        // set empty local storage on load if the show modal object doesn't exist. 
        // This allow us to set the time stamp for the first time in showModalOnExit method and won't reset every time the exit intent method is called 
        if (!this.showModalObject) {
            var object = { value: null, timestamp: null }
            localStorage.setItem("modalShowed", JSON.stringify(object));
        }

        // reset the local storage item "modalShowed" after an hour
        this.resetLocalStorage()

        // show modal on exit 
        setTimeout(() => {
            $(document).on("mouseout", this.showModalOnExit.bind(this));
        }, 100);

        // close the modal 
        this.closeIcon.on('click', this.hideModal)
        $('.dark-overlay').on('click', this.hideModal)
    }

    resetLocalStorage() {
        if (this.showModalObject.timestamp) {
            const dateString = this.showModalObject.timestamp
            const now = new Date().getTime().toString();

            // calculate time difference in minutes 
            const timeDifference = (((now - dateString) / 1000) / 60); //to implement
            console.log('this is a time difference' + timeDifference)
            // reset the modal show value after 180 minutes 
            if (timeDifference > 180) {
                var object = { value: null, timestamp: null }
                localStorage.setItem("modalShowed", JSON.stringify(object));
                this.showModalObject = JSON.parse(localStorage.getItem("modalShowed"))
            }
        }
    }

    showModalOnExit(evt) {
        // !this.showModalObject.value
        // && !localStorage.getItem('modalShowed')
        if (evt.toElement === null && evt.relatedTarget === null && this.showModalValue && !this.showModalObject.value) {
            $(evt.currentTarget).off("mouseout");
            // An intent to exit has happened
            $('.inspiry-modal').show();
            $('.dark-overlay').show()
            // set local storage item so that the modal is not shown multiple time on different pages to the same customer
            if (!this.showModalObject.value) {
                var object = { value: true, timestamp: new Date().getTime() }
                localStorage.setItem("modalShowed", JSON.stringify(object));
            }
        }
    }
    hideModal() {
        $('.inspiry-modal').hide()
        $('.dark-overlay').hide()

    }
}

export default ExitIntentModal