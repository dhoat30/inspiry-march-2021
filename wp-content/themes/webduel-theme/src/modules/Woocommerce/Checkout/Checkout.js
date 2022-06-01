import Windcave from "./Windcave";

const $ = jQuery
class Checkout {
    constructor() {
        // disable the pay securely button  
        $(":submit").removeAttr("disabled");

        this.onPaymentSelectionChange
        this.windcavePaymentSelected = $("input[type='radio'][name='payment_method']:checked").val();
        this.events()
    }

    events() {
        //    set cookie to false every page load to hide the payment options
        Cookies.set('showPaymentOptions', 'false')
        // hide the payment options if the ship to different address is checked - I am trying to fix issue when customer is seeing the payment options but change the mind to change the shipping address so he can go through the validation process again 
        $('#ship-to-different-address-checkbox').on('change', () => {
            let shipToDifferentAddress = $("input[type='checkbox'][name='ship_to_different_address']:checked").val()
            if (shipToDifferentAddress) {
                Cookies.set('showPaymentOptions', 'false')
                // hide the payment options 
                $('#payment').hide()
                // show the pay button 
                $('#pay-button').show()
            }
        })
        // show payment options on a button click
        $('#pay-button').on('click', this.showPaymentOptions)
        // listen for form input change and show the payment options if the cookie exists 
        $('#customer_details input').on('change', this.showPaymentOptionsUsingCookie)
        $('#customer_details select').on('change', this.showPaymentOptionsUsingCookie)

    }

    showPaymentOptions(e) {
        e.preventDefault()
        const validateInputField = (selector, errorText, selectorID, validationFormat) => {
            if (selector.val().length < 1 && !validationFormat) {
                selector.closest('p').append(`<div class="error">${errorText}</div>`)
                $('html, body').animate({
                    scrollTop: $(selectorID).offset().top
                }, 100);
                return false
            }
            else if (validationFormat === 'email'
                && !selector.val().match(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)) {
                selector.closest('p').append(`<div class="error">${errorText}</div>`)
                $('html, body').animate({
                    scrollTop: $(selectorID).offset().top
                }, 100);
                return false
            }
            else if (validationFormat === 'phone'
                && !selector.val().match(/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{1,6}$/im)) {
                selector.closest('p').append(`<div class="error">${errorText}</div>`)
                $('html, body').animate({
                    scrollTop: $(selectorID).offset().top
                }, 100);
                return false
            }
            else {
                return true
            }
        }
        // validate shipping form 
        const validateShippingForm = () => {
            $('.error').remove()
            let firstName = $('.woocommerce-checkout #shipping_first_name')
            let lastName = $('.woocommerce-checkout #shipping_last_name')
            let country = $('.woocommerce-checkout #shipping_country')
            let address1 = $('.woocommerce-checkout #shipping_address_1')
            let city = $('.woocommerce-checkout #shipping_city')
            let region = $(".woocommerce-checkout #shipping_state")

            let postCode = $('.woocommerce-checkout #shipping_postcode')
            // validate first name
            const isFirstNameValid = validateInputField(firstName, 'Please enter your first name', '#billing_phone')
            // validate last name
            const isLastNameValid = validateInputField(lastName, 'Please enter your last name', '#billing_phone')
            const isCountryValid = validateInputField(country, 'Please enter your last name', '#billing_phone')

            // validate address1
            const isAddress1Valid = validateInputField(address1, 'Please enter your street address', '#billing_phone')
            // validate city
            const isCityValid = validateInputField(city, 'Please enter your city', '#shipping_first_name')
            // validate region 
            const isRegionValid = validateInputField(region, 'Please select your region', '#shipping_first_name')

            // validate post code
            const isPostCodeValid = validateInputField(postCode, 'Please enter your post Code', '#shipping_first_name')
            // validate phone
            if (isFirstNameValid && isLastNameValid && isCountryValid && isAddress1Valid && isCityValid && isRegionValid && isPostCodeValid) {
                return true
            }
        }
        // validate if the shipping method is selected 
        const shippingMethodValidation = () => {
            var shippingMethod = $('input[name^="shipping_method"]').val();
            console.log("shipping method")
            // Check if string contains substring
            if (shippingMethod && shippingMethod.length > 0) {
                console.log('shipping method available')
                return true
            }
            else {
                console.log('shipping method is not selected ')
                $(this).closest('.pay-button-container').append(`<div class="error">*Shipping method is not selected.</div>`)
            }
        }
        const validateBillingForm = () => {
            $('.error').remove()
            // check the required values 
            let firstName = $('.woocommerce-checkout #billing_first_name')
            let lastName = $('.woocommerce-checkout #billing_last_name')
            let country = $(".woocommerce-checkout #billing_country")
            let address1 = $('.woocommerce-checkout #billing_address_1')
            let city = $('.woocommerce-checkout #billing_city')
            let postCode = $('.woocommerce-checkout #billing_postcode')
            let region = $(".woocommerce-checkout #billing_state")
            let phone = $('.woocommerce-checkout #billing_phone')
            let emailAddress = $('.woocommerce-checkout #billing_email')


            const validationObj = {
                isFirstNameValid: validateInputField(firstName, 'Please enter your first name', '.woocommerce-checkout'),
                isLastNameValid: validateInputField(lastName, 'Please enter your last name', '.woocommerce-checkout'),
                isCountryValid: validateInputField(country, 'Please enter your last name', '.woocommerce-checkout'),
                isAddress1Valid: validateInputField(address1, 'Please enter your street address', '#billing_first_name_field'),
                isCityValid: validateInputField(city, 'Please enter your city', '#billing_first_name_field'),
                isPostCodeValid: validateInputField(postCode, 'Please enter your post Code', '#billing_first_name_field'),
                isRegionValid: validateInputField(region, 'Please select your region', '#billing_first_name_field'),
                isPhoneValid: validateInputField(phone, 'Please enter your phone number', '#billing_state_field', 'phone'),
                isEmailAddressValid: validateInputField(emailAddress, 'Please enter your email address', '#billing_state_field', 'email')
            }

            // ship to different address validation
            let shipToDifferentAddress = $("input[type='checkbox'][name='ship_to_different_address']:checked").val()
            if (shipToDifferentAddress) {
                if (validationObj.isFirstNameValid && validationObj.isLastNameValid && validationObj.isCountryValid && validationObj.isAddress1Valid && validationObj.isCityValid && validationObj.isPostCodeValid && validationObj.isPhoneValid && validationObj.isEmailAddressValid && validationObj.isRegionValid && validateShippingForm()) {
                    if (shippingMethodValidation()) {
                        Cookies.set('showPaymentOptions', 'true')
                        return true
                    }

                }
            }
            else {
                if (validationObj.isFirstNameValid && validationObj.isLastNameValid && validationObj.isCountryValid && validationObj.isAddress1Valid && validationObj.isCityValid && validationObj.isPostCodeValid && validationObj.isPhoneValid && validationObj.isEmailAddressValid && validationObj.isRegionValid && shippingMethodValidation()) {
                    Cookies.set('showPaymentOptions', 'true')
                    return true
                }
            }

        }
        if (validateBillingForm()) {
            // show payment options 
            // hide the pay now button 
            if (Cookies.get('showPaymentOptions') === "true") {
                // show payment options 
                $(this).hide()
                $('#payment').show()
                setTimeout(() => {
                    $('#payment').show()
                    $(this).hide()
                }, 2000)
            }
            else {
                $(this).show()
                $('#payment').hide()
            }
        }
    }
    showPaymentOptionsUsingCookie() {
        Cookies.set('showPaymentOptions', 'false')
        const showPaymentCookie = Cookies.get('showPaymentOptions')
        if (showPaymentCookie === 'false') {

            // show payment options 
            setTimeout(() => {
                $('#payment').hide()
                $('#pay-button').show()

            }, 2000)

        }

    }

}
export default Checkout