## ======= [/reviews]

### Get all items [GET]
Available includes: [questions, images, user, order]
+ Request (application/json)
    <!-- include(request/header.md) -->
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Ok (string)
        + data: (array[Review, Review])

<!-- include(response/401.md) -->
<!-- include(response/500.md) -->
### Create item [POST]
Available includes: [questions, images, user, order]
+ Request Rules:
    {
        "order_id": 'required',
        "order": 'required',
        "description": 'required',

    }
+ Request (application/json)
    <!-- include(request/header.md) -->
    + Body
    {
            "order_id": 14 (number),
            "order": 10 (number),
            "description": perspiciatis (string),

    }
+ Response 201 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Review successfully created (string)
        + data: (Review)

<!-- include(response/401.md) -->
<!-- include(response/422.md) -->
<!-- include(response/500.md) -->

## ======= [/reviews/{id}]
### Update item [PUT]
Available includes: [questions, images, user, order]
<!-- include(parameters/id.md) -->
+ Request Rules:
    {
        "order": 'required',
        "description": 'required',

    }
+ Request (application/json)
    <!-- include(request/header.md) -->
    + Body
    {
            "order": 16 (number),
            "description": velit (string),

    }
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Review successfully updated (string)
        + data: (Review)

<!-- include(response/401.md) -->
<!-- include(response/404.md) -->
<!-- include(response/422.md) -->
<!-- include(response/500.md) -->
### Get single item [GET]
Available includes: [questions, images, user, order]
<!-- include(parameters/id.md) -->
+ Request (application/json)
    <!-- include(request/header.md) -->
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Ok (string)
        + data: (Review)

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
        + message: Review successfully deleted (string)
        + data: null

<!-- include(response/401.md) -->
<!-- include(response/404.md) -->
<!-- include(response/500.md) -->

## ======= [/reviews/paginate?page={page}&pagination={pagination}]
### Paginated items [GET]
Available includes: [questions, images, user, order]
<!-- include(parameters/pagination.md) -->
+ Request (application/json)
    <!-- include(request/header.md) -->
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Ok (string)
        + data: (array[Review, Review])
        + meta
            + pagination (Pagination)

<!-- include(response/401.md) -->
<!-- include(response/500.md) -->


