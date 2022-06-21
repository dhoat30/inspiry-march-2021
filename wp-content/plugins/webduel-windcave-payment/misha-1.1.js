const $ = jQuery
class WindcavePaymentProcessor {
    constructor() {
        this.events()
    }
    events() {
        // windcave iframe code
        $(window).on('hashchange', this.prepareIframe)
        // hide windcave iframe code
        $("#windcave-custom-container .close-icon").on('click', this.hideWindcaveModal)
        //windcave submit button 
        $(document).on('click', '.windcave-submit-button', this.windcaveSubmitButton)
        // try again button 
        $('.woocommerce-checkout .error-modal button').on('click', () => location.reload())
        $('.woocommerce-checkout .error-modal').on('click', () => location.reload())
    }
    prepareIframe() {
        if ($("input[type='radio'][name='payment_method']:checked").val() === 'inspiry_windcave_gateway') {
            var myHash = window.location.hash.substring(1);
            var params = myHash.split('&')
            let href = params[0]

            // prepare iframe 

            WindcavePayments.Seamless.prepareIframe({
                url: href,
                containerId: "windcave-iframe-container",
                loadTimeout: 30,
                width: 400,
                height: 500,
                onProcessed: function (response) {
                    $('#windcave-custom-container').show()
                },
                onError: function (error) {
                    console.log(error)
                }
            });
        }

    }
    windcaveSubmitButton() {
        $('#windcave-custom-container .white-overlay').show()
        var myHash = window.location.hash.substring(1);
        var params = myHash.split('&')
        let orderID = params[1]
        let sessionID = params[2]
        let returnURL = params[4]
        // validate windcave credit card form 
        $('.error-bg').remove()
        WindcavePayments.Seamless.validate({
            onProcessed: function (isValid) {
                if (isValid) {
                    // if the credit card is valid, submit the form 
                    WindcavePayments.Seamless.submit({
                        onProcessed: function (response) {
                            processPayment()
                        },
                        onError: function (error) {
                            console.log(error)
                            errorCallback()
                        }
                    });
                }
                else {
                    $('#windcave-custom-container .white-overlay').hide()
                }
            },
            onError: function (error) {
                console.log(error)
                $('.windcave-submit-button').show()
            }
        });
        // process payment by ajax call 
        const processPayment = () => {
            $.ajax({
                beforeSend: (xhr) => {
                    xhr.setRequestHeader('X-WP-NONCE', inspiryData.nonce)
                },
                url: '/wp-admin/admin-ajax.php',
                type: 'POST',
                data: {
                    orderID: orderID,
                    windcaveSessionID: sessionID,
                    returnURL: returnURL,
                    action: 'webduel_complete_order'
                },
                complete: () => {
                },
                success: (response) => {
                    if (response.code === 200) {
                        window.location.href = returnURL
                    }
                    else if (response.code === 404) {
                        $('.error-modal .content').text(response.data)
                        $('.error-modal button').text("Try Again")
                        $('.error-modal').show()
                        // hide white overlay 
                        $('#windcave-custom-container .white-overlay').hide()

                    }

                },
                error: (response) => {
                    console.log(response)
                }
            });
        }

    }
    hideWindcaveModal() {
        $('.windcave-custom-container').hide()
        location.reload()
    }
}

const windcavePaymentProcessor = new WindcavePaymentProcessor() 