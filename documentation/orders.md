## ======= [/orders]

### Get all items [GET]
Available includes: [reviews, loadings, category, project]
+ Request (application/json)
    <!-- include(request/header.md) -->
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Ok (string)
        + data: (array[Order, Order])

<!-- include(response/401.md) -->
<!-- include(response/500.md) -->
### Create item [POST]
Available includes: [reviews, loadings, category, project]
+ Request Rules:
    {
        "category_id": 'required',
        "project_id": 'required',
        "quantity": 'required',
        "description": 'required',

    }
+ Request (application/json)
    <!-- include(request/header.md) -->
    + Body
    {
            "category_id": 7 (number),
            "project_id": 20 (number),
            "quantity": 18 (number),
            "description": mollitia (string),

    }
+ Response 201 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Order successfully created (string)
        + data: (Order)

<!-- include(response/401.md) -->
<!-- include(response/422.md) -->
<!-- include(response/500.md) -->

## ======= [/orders/{id}]
### Update item [PUT]
Available includes: [reviews, loadings, category, project]
<!-- include(parameters/id.md) -->
+ Request Rules:
    {
        "quantity": 'required',
        "description": 'required',

    }
+ Request (application/json)
    <!-- include(request/header.md) -->
    + Body
    {
            "quantity": 8 (number),
            "description": et (string),

    }
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Order successfully updated (string)
        + data: (Order)

<!-- include(response/401.md) -->
<!-- include(response/404.md) -->
<!-- include(response/422.md) -->
<!-- include(response/500.md) -->
### Get single item [GET]
Available includes: [reviews, loadings, category, project]
<!-- include(parameters/id.md) -->
+ Request (application/json)
    <!-- include(request/header.md) -->
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Ok (string)
        + data: (Order)

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
        + message: Order successfully deleted (string)
        + data: null

<!-- include(response/401.md) -->
<!-- include(response/404.md) -->
<!-- include(response/500.md) -->

## ======= [/orders/paginate?page={page}&pagination={pagination}]
### Paginated items [GET]
Available includes: [reviews, loadings, category, project]
<!-- include(parameters/pagination.md) -->
+ Request (application/json)
    <!-- include(request/header.md) -->
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Ok (string)
        + data: (array[Order, Order])
        + meta
            + pagination (Pagination)

<!-- include(response/401.md) -->
<!-- include(response/500.md) -->


