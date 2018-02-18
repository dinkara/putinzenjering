## ======= [/projects]

### Get all items [GET]
Available includes: [orders, users]
+ Request (application/json)
    <!-- include(request/header.md) -->
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Ok (string)
        + data: (array[Project, Project])

<!-- include(response/401.md) -->
<!-- include(response/500.md) -->
### Create item [POST]
Available includes: [orders, users]
+ Request Rules:
    {
        "name": 'required',
        "location": 'required',
        "description": 'required',

    }
+ Request (application/json)
    <!-- include(request/header.md) -->
    + Body
    {
            "name": laboriosam (string),
            "location": voluptas (string),
            "description": incidunt (string),

    }
+ Response 201 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Project successfully created (string)
        + data: (Project)

<!-- include(response/401.md) -->
<!-- include(response/422.md) -->
<!-- include(response/500.md) -->

## ======= [/projects/{id}]
### Update item [PUT]
Available includes: [orders, users]
<!-- include(parameters/id.md) -->
+ Request Rules:
    {
        "name": 'required',
        "location": 'required',
        "description": 'required',

    }
+ Request (application/json)
    <!-- include(request/header.md) -->
    + Body
    {
<<<<<<< HEAD
            "name": ea (string),
            "location": nesciunt (string),
            "description": quam (string),
=======
            "name": inventore (string),
            "location": asperiores (string),
            "description": non (string),
>>>>>>> 420bf4b7ba2552e68f3c35963ae88370a6e60f15

    }
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Project successfully updated (string)
        + data: (Project)

<!-- include(response/401.md) -->
<!-- include(response/404.md) -->
<!-- include(response/422.md) -->
<!-- include(response/500.md) -->
### Get single item [GET]
Available includes: [orders, users]
<!-- include(parameters/id.md) -->
+ Request (application/json)
    <!-- include(request/header.md) -->
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Ok (string)
        + data: (Project)

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
        + message: Project successfully deleted (string)
        + data: null

<!-- include(response/401.md) -->
<!-- include(response/404.md) -->
<!-- include(response/500.md) -->

## ======= [/projects/paginate?page={page}&pagination={pagination}]
### Paginated items [GET]
Available includes: [orders, users]
<!-- include(parameters/pagination.md) -->
+ Request (application/json)
    <!-- include(request/header.md) -->
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Ok (string)
        + data: (array[Project, Project])
        + meta
            + pagination (Pagination)

<!-- include(response/401.md) -->
<!-- include(response/500.md) -->


