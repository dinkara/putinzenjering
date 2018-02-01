## Forgot Password [POST /forgot/password]
+ Request Rules:
        {
            "email": required|email,
        }
+ Request (application/json)   
        {
            "email": "test@user.com"
        }

+ Response 200 (application/json)

    + Attributes
        + success: true (boolean)
        + message: `We have e-mailed your password reset link!` (string)
	+ data: null

<!-- include(response/404.md) -->
<!-- include(response/422.md) -->
<!-- include(response/500.md) -->

## Reset Password [POST /password/reset]
+ Request Rules:
    {
        "email": required|email|max:255,
        "password": required|confirmed|min:6,
        "token": required,
    }
+ Request (application/json)   
    {
        "email": "test@user.com",
        "password": "123456",
        "password_confirmation": "123456",
        "token": "abcdefghijkl"
    }
+ Response 200 (application/json)

    + Attributes
        + success: true (boolean)
        + message: Your password has been reset! (string)
	+ data: null

<!-- include(response/404.md) -->
<!-- include(response/422.md) -->
<!-- include(response/500.md) -->