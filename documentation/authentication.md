## Login [POST /login]
+ Request Rules:
    {
        "email": required|email,
        "password": required
    }
+ Request (application/json)        
    {
        "email": "test@user.com", 
        "password": "123456"
    }
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Ok (string)
        + data (Token)
        

<!-- include(response/401.md) -->
<!-- include(response/422.md) -->
<!-- include(response/500.md) -->

## Facebook Auth [POST /auth/facebook]

In order to get your test Facebook Access Token, click here: https://developers.facebook.com/tools/explorer/?method=GET&path=me%3Ffields%3Did%2Cname%2Cemail%2Ccover&version=v2.9

+ Request Rules:
    {
        "access_token": required            
    }

+ Request (application/json)
    {
        "access_token": "EAACEdEose0cBAAqZABUHZBZAsPjPTBYjnxcA9hBZC17l81MUckv9Ky0FsruosHJYob4cgSQ0krajCG5nX2Td5Ynwh2s5roNzmQRRewjLXi0aMbFHfpxuNRrZAKk6g2DSYiUvU0fnF3QiiA3eyZC7bZASxQQn56qJZC4WCHrrVGEcOvp54n9ng1XTXjUZC5MYyhCHbaQ0UlnEwvgZDZD"              
    }
+ Response 200 (application/json)

    + Attributes
        + success: true (boolean)
        + message: Ok (string)
        + data (Token)

<!-- include(response/401.md) -->
<!-- include(response/422.md) -->
<!-- include(response/500.md) -->

## Google Auth [POST /auth/google]

In order to get your test Google Access Token, click here: https://developers.google.com/oauthplayground/

+ Request Rules:
    {
        "access_token": required            
    }

+ Request (application/json)
    {
        "access_token": "ya29.GlsNBe4IoiWsucF5lgv8JbKwK7U-L1DFMxzBa-uUuVXcFZpZ5zerPUqahzcVSFHLKlcJhZay-4kYFDC9lmUiXI4KD8zRm4mnegzpIBUyHQ5hdLTaCsSLAjMCVqzU"              
    }
+ Response 200 (application/json)

    + Attributes
        + success: true (boolean)
        + message: Ok (string)
        + data (Token)

<!-- include(response/401.md) -->
<!-- include(response/422.md) -->
<!-- include(response/500.md) -->

## Register [POST /register]
+ Request Rules:
    {
        "email": required|email|max:255|unique:users
        "password": required|confirmed|min:6
    }

+ Request (application/json)
    {
        "email": "test@user.com",
        "password": "123456",
        "password_confirmation": "123456",
    }
+ Response 201 (application/json)

    + Attributes
        + success: true (boolean)
        + message: You are successfully registered! Please confirm your email. (string)
        + data: null

<!-- include(response/422.md) -->
<!-- include(response/500.md) -->