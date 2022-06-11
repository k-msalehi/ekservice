Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:
## Endpoints

**Login/Register**

`POST /login`

Inputs:
```
tel
````

Output on success example:
```
{
    "success": true,
    "message": "success",
    "data": {
        "hash": "938c55560cd7d8c1c06f678a74dffd6e"
    }
}
```

Output on failure example:
```
{
    "success": false,
    "message": "validation error",
    "data": {
        "tel": [
            "\u0641\u06cc\u0644\u062f tel \u0627\u0644\u0632\u0627\u0645\u06cc \u0627\u0633\u062a."
        ]
    }
}
```

`POST /checkLoginCode`

Inputs:
```
hash
tel
otp
````

Output on success example:
```
{
    "success": true,
    "message": "success",
    "data": {
        "apiToken": "2|zDXTieXZDPz7Lc1esbTblxxzqAbcwQQdiC3FiTmr",
        "role": 3
    }
}
```

Output on failure example:
```
{
    "success": false,
    "message": "validation error",
    "data": {
        "hash": [
            "\u0641\u06cc\u0644\u062f hash \u0627\u0644\u0632\u0627\u0645\u06cc \u0627\u0633\u062a."
        ]
    }
}
```

`GET /checkUser`

determine if user is authenticated or not

Response example:
```
{"login":false}
```

---

**Submit new order**

`POST /orders`

Inputs:
```
device_type 
device_brand 
device_model
user_note
name
national_id
province_id
city_id
address
lat (optional)
lon (optional)
````

Output on success example:
```
{
    "success": true,
    "message": "success",
    "data": {
        "device_type": "mobile",
        "device_brand": "samsung",
        "device_model": "a33",
        "user_note": "\u062e\u0631\u0627\u0628 \u0647\u0633\u062a",
        "name": "\u0645\u062d\u0645\u062f \u0635\u0627\u0644\u062d\u06cc",
        "national_id": "4990139593",
        "province_id": 8,
        "city_id": "301",
        "address": "\u062e \u0645\u0648\u0644\u0648\u06cc \u062e \u062d\u062c\u062a",
        "lat": "123",
        "lon": "456",
        "user_id": 1,
        "updated_at": "2022-06-08T06:22:32.000000Z",
        "created_at": "2022-06-08T06:22:32.000000Z",
        "id": 4
    }
}
```

---

**Get Order(s)**

Get a single order
`Get /orders/{order-id}`

Output on success example:
```
{
    "success": true,
    "message": "success",
    "data": {
        "id": 1001,
        "device_brand": "samsung",
        "device_type": "mobile",
        "device_model": "a33",
        "name": "\u0645\u062d\u0645\u062f \u0635\u0627\u0644\u062d\u06cc",
        "email": null,
        "city_id": "301",
        "address": "\u062e \u0645\u0648\u0644\u0648\u06cc \u062e \u062d\u062c\u062a",
        "national_id": "4990139593",
        "lon": "456",
        "lat": "123",
        "user_note": "\u062e\u0631\u0627\u0628 \u0647\u0633\u062a",
        "admin_note": null,
        "rough_price": null,
        "requested_price": null,
        "paid_price": null,
        "final_price": null,
        "status": 1,
        "created_at": "2022-06-08T12:53:10.000000Z"
    }
}
---

Output on failure example:
```
{
    "success": false,
    "message": "object not found"
}
```

Get all single orders
`Get /orders`

Output on success example:
```
{
    "data": [
        {
            "id": 1002,
            "device_brand": "samsung",
            "device_type": "mobile",
            "device_model": "a33",
            "name": "\u0645\u062d\u0645\u062f \u0635\u0627\u0644\u062d\u06cc",
            "email": null,
            "city_id": "301",
            "address": "\u062e \u0645\u0648\u0644\u0648\u06cc \u062e \u062d\u062c\u062a",
            "national_id": "4990139593",
            "lon": "456",
            "lat": "123",
            "user_note": "\u062e\u0631\u0627\u0628 \u0647\u0633\u062a",
            "admin_note": null,
            "rough_price": null,
            "requested_price": null,
            "paid_price": null,
            "final_price": null,
            "status": 1,
            "created_at": "2022-06-08T13:28:14.000000Z"
        },
        {
            "id": 1001,
            "device_brand": "samsung",
            "device_type": "mobile",
            "device_model": "a33",
            "name": "\u0645\u062d\u0645\u062f \u0635\u0627\u0644\u062d\u06cc",
            "email": null,
            "city_id": "301",
            "address": "\u062e \u0645\u0648\u0644\u0648\u06cc \u062e \u062d\u062c\u062a",
            "national_id": "4990139593",
            "lon": "456",
            "lat": "123",
            "user_note": "\u062e\u0631\u0627\u0628 \u0647\u0633\u062a",
            "admin_note": null,
            "rough_price": null,
            "requested_price": null,
            "paid_price": null,
            "final_price": null,
            "status": 1,
            "created_at": "2022-06-08T12:53:10.000000Z"
        }
    ]
}
```