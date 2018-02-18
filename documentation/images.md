## ======= [/images]

### Get all items [GET]
Available includes: [review, loading]
+ Request (application/json)
    <!-- include(request/header.md) -->
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Ok (string)
        + data: (array[Image, Image])

<!-- include(response/401.md) -->
<!-- include(response/500.md) -->
### Create item [POST]
Available includes: [review, loading]
+ Request Rules:
    {
        "review_id": 'required',
        "loading_id": 'required',
        "url": 'required',

    }
+ Request (application/json)
    <!-- include(request/header.md) -->
    + Body
    {
            "review_id": 9 (number),
            "loading_id": 17 (number),
            "url": aut (string),

    }
+ Response 201 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Image successfully created (string)
        + data: (Image)

<!-- include(response/401.md) -->
<!-- include(response/422.md) -->
<!-- include(response/500.md) -->

## ======= [/images/{id}]
### Update item [PUT]
Available includes: [review, loading]
<!-- include(parameters/id.md) -->
+ Request Rules:
    {
        "url": 'required',

    }
+ Request (application/json)
    <!-- include(request/header.md) -->
    + Body
    {
            "url": eligendi (string),

    }
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Image successfully updated (string)
        + data: (Image)

<!-- include(response/401.md) -->
<!-- include(response/404.md) -->
<!-- include(response/422.md) -->
<!-- include(response/500.md) -->
### Get single item [GET]
Available includes: [review, loading]
<!-- include(parameters/id.md) -->
+ Request (application/json)
    <!-- include(request/header.md) -->
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Ok (string)
        + data: (Image)

<!-- include(response/401.md) -->
<!-- include(response/404.md) -->
<!-- include(response/500.md) -->
### Delete item [DELETE]
<!-- include(parameters/id.md) -->
+ Request (application/json)
    <!-- include(request/header.md) -->    
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Image successfully deleted (string)
        + data: null

<!-- include(response/401.md) -->
<!-- include(response/404.md) -->
<!-- include(response/500.md) -->

## ======= [/images/paginate?page={page}&pagination={pagination}]
### Paginated items [GET]
Available includes: [review, loading]
<!-- include(parameters/pagination.md) -->
+ Request (application/json)
    <!-- include(request/header.md) -->
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Ok (string)
        + data: (array[Image, Image])
        + meta
            + pagination (Pagination)

<!-- include(response/401.md) -->
<!-- include(response/500.md) -->


