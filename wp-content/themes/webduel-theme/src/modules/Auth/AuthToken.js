let $ = jQuery

class AuthToken {
    constructor(redirectLink, username, password, email) {
        this.username = username
        this.password = password
        this.email = email
        this.redirectLink = redirectLink
        this.events()
    }

    events() {
        let formData = {
            username: this.username,
            email: this.email,
            password: this.password
        }
        console.log(formData)
        // erase existing cookies 
        this.eraseCookie('inpiryAuthToken')

        let url = 'https://inspiry.co.nz/wp-json/jwt-auth/v1/token';
        if (location.hostname === "localhost" || location.hostname === "127.0.0.1") {
            url = 'http://localhost/inspirynew/wp-json/jwt-auth/v1/token';
        }

        console.log("this is url" + url)
        // set auth cookies 
        fetch(url, {
            method: "POST",
            body: JSON.stringify(formData),
            headers: {
                'Content-Type': 'application/json'
            },
        })
            .then(res => res.json())
            .then(res => {
                // document.forms["login-form"].submit();
                console.log(res)
                if (res.data) {
                    console.log(res.data.status)
                }
                else {
                    this.setCookie('inpiryAuthToken', res.token, 3)
                    if (this.redirectLink) {
                        window.location.replace(this.redirectLink);
                    }
                    else {
                        window.location.replace("/");
                    }

                }
            })
            .catch(err => console.log(err))

    }

    setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }
    eraseCookie(name) {
        document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    }
}
export default AuthToken