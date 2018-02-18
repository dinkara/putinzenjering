## ======= [/loadings]

### Get all items [GET]
Available includes: [images, user, review, truck, order]
+ Request (application/json)
    <!-- include(request/header.md) -->
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Ok (string)
        + data: (array[Loading, Loading])

<!-- include(response/401.md) -->
<!-- include(response/500.md) -->
### Create item [POST]
Available includes: [images, user, review, truck, order]
+ Request Rules:
    {
        "review_id": 'required',
        "truck_id": 'required',
        "order_id": 'required',

    }
+ Request (application/json)
    <!-- include(request/header.md) -->
    + Body
    {
            "review_id": 20 (number),
            "truck_id": 17 (number),
            "order_id": 9 (number),

    }
+ Response 201 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Loading successfully created (string)
        + data: (Loading)

<!-- include(response/401.md) -->
<!-- include(response/422.md) -->
<!-- include(response/500.md) -->

## ======= [/loadings/{id}]
### Update item [PUT]
Available includes: [images, user, review, truck, order]
<!-- include(parameters/id.md) -->
+ Request Rules:
    {

    }
+ Request (application/json)
    <!-- include(request/header.md) -->
    + Body
    {

    }
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Loading successfully updated (string)
        + data: (Loading)

<!-- include(response/401.md) -->
<!-- include(response/404.md) -->
<!-- include(response/422.md) -->
<!-- include(response/500.md) -->
### Get single item [GET]
Available includes: [images, user, review, truck, order]
<!-- include(parameters/id.md) -->
+ Request (application/json)
    <!-- include(request/header.md) -->
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Ok (string)
        + data: (Loading)

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
        + message: Loading successfully deleted (string)
        + data: null

<!-- include(response/401.md) -->
<!-- include(response/404.md) -->
<!-- include(response/500.md) -->

## ======= [/loadings/paginate?page={page}&pagination={pagination}]
### Paginated items [GET]
Available includes: [images, user, review, truck, order]
<!-- include(parameters/pagination.md) -->
+ Request (application/json)
    <!-- include(request/header.md) -->
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Ok (string)
        + data: (array[Loading, Loading])
        + meta
            + pagination (Pagination)

<!-- include(response/401.md) -->
<!-- include(response/500.md) -->


