# API

Website URL
> https://desk.guidely.in

Headers
- *Accept:* application/json
- *Authorization:* Bearer `{{token}}`

Secret Key (for all Api)
> apikey: qw42yunk
___
## Send OTP
- **URL** : `api/v1/send_otp`
- *Method* : `post`
- *Body*: mobile, apikey
- *Header*: `Accept`: application/json
- output:
```php
"{
    ""status"": 1,
    ""message"": ""success"",
    ""data"": {
        ""otp"": 1234
    }
}"
```
Error
```php
"{
    ""status"": 0,
    ""message"": ""Bad Request"",
    ""data"": {
        ""error"": ""Validation Error"",
        ""error_details"": {
            ""mobile"": [
                ""The selected mobile is invalid.""
            ]
        }
    }
}"
```
