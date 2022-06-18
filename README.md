* Set header "Accept: application/json" for all requests.
* `/admin` prefix requires admin role

## Endpoints


**Login/Logout/Register**

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

`POST /logout`

Output on success
```
{
    "success": true,
    "message": "success",
    "data": "logout success"
}
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
        "id": 1013,
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
        "status_text": "\u062b\u0628\u062a \u0627\u0648\u0644\u06cc\u0647",
        "created_at": "2022-06-11T10:57:02.000000Z"
    }
}
```

---

**Get an Order or list of orders**

Get a single order
`Get /orders/{order-id}` Or `Get /admin/orders/{order-id}`

Output on success example:
```
{
{
{
    "success": true,
    "message": "success",
    "data": {
        "id": 1001,
        "user_id": 1,
        "device_brand": "samsung",
        "device_type": "mobile",
        "device_model": "a33",
        "name": "\u0645\u062d\u0645\u062f \u0645\u062d\u0645\u062f\u06cc",
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
        "status_text": "\u062b\u0628\u062a \u0627\u0648\u0644\u06cc\u0647",
        "created_at": "2022-06-12T09:06:29.000000Z",
        "payments": [
            {
                "id": 3,
                "user_id": 1,
                "amount": 25000,
                "ref_id": "MWQ1M2M1ZWFKMZI5",
                "bank_sale_order_id": "",
                "bank_sale_refrence_id": "",
                "status": 2,
                "note": "", // ONLY for admin and expert role
                "created_at": "2022-06-18T09:45:18.000000Z",
                "updated_at": "2022-06-18T09:45:24.000000Z"
            }
        ]
    }
}
```

Output on failure example:
```
{
    "success": false,
    "message": "object not found"
}
```

Get all orders
`Get /orders` Or `Get /admin/orders`

* You can filter orders by `status`, `device_type`, `device_brand` and `user_id` in query parameter.
* if `id` parametere exists in url, only order with that id returns as response.

Output on success example:
```
{
    "success": true,
    "message": "Orders fetched successfully.",
    "data": [
        {
            "id": 1003,
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
            "created_at": "2022-06-11T07:32:40.000000Z"
        },
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
---
*Order Statuses*
```
'status' => [
    'submitted' => 1,
    'deliverySent1' => 2,
    'pickedByDelivery1' => '3',
    'pickedByHead' => '4',
    'debugging' => '5',
    'waitingForCustomerConfirm' => '6',
    'fixing' => '7',
    'cannotFix' => '8',
    'fixed' => '9',
    'deliverySent2' => '10',
    'completed' => '11',
    'autocanceled' => '12',
    'cancelRequestByCustomer' => '13',
    'canceledByCustomer' => '14',
    'canceledByHead' => '15',
],

```
---
**Modify/Manage an order(s)**

update an order `POST /admin/orders/{order-id}/update` 

inputs *(all inputs are optional)*:
```
name
address
rough_price
requested_price
final_price
admin_note
status    
device_type
device_brand
device_model
lat
lon
```

add new note to order `POST /admin/orders/{order-id}/note`

inputs:
```
value
```

Response on success:
```
{
    "success": true,
    "message": "Note added successfully.",
    "data": {
        "order_id": 1001,
        "user_id": 1,
        "name": "note",
        "value": "\u062e\u0631\u0627\u0628 \u0647\u0633\u062a",
        "updated_at": "2022-06-13T06:54:28.000000Z",
        "created_at": "2022-06-13T06:54:28.000000Z",
        "id": 8
    }
}
```

get notes of an order `GET /admin/orders/{order-id}/note`

get payment token and url `POST /pay/order/{order-number}`

Example response on success
```
{
  "action": "https://banktest.ir/gateway/pgw.bpm.bankmellat.ir/pgwchannel/startpay.mellat",
  "inputs": {
    "RefId": "ODE2YTY2Y2JKM2JK"
  },
  "method": "POST"
}
```

---

**Create new user**

`POST /admin/users`

Inputs:
```
tel
role
````

Output on success example:
```
{
    "success": true,
    "message": "User created successfully.",
    "data": {
        "tel": "09000000000",
        "role": "1",
        "updated_at": "2022-06-12T11:22:58.000000Z",
        "created_at": "2022-06-12T11:22:58.000000Z",
        "id": 6
    }
}
```
---

**Get a  user or list of users**

Get a single user `GET admin/users/{user-id}`
On success example output:

```
{
    "success": true,
    "message": "User fetched successfully.",
    "data": {
        "id": 2,
        "name": "reza",
        "tel": "09116656565",
        "national_id": null,
        "email": null,
        "email_verified_at": null,
        "role": 2,
        "status": 1,
        "created_at": "2022-06-12T11:13:34.000000Z",
        "updated_at": "2022-06-13T08:21:05.000000Z"
    }
}
```


get list of users `GET admin/users`

Example output:
```
{
    "success": true,
    "message": "Users fetched successfully.",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 5,
                "name": null,
                "tel": "09116656568",
                "national_id": null,
                "email": null,
                "email_verified_at": null,
                "role": 1,
                "status": 1,
                "created_at": "2022-06-12T11:18:59.000000Z",
                "updated_at": "2022-06-12T11:18:59.000000Z"
            },
            {
                "id": 4,
                "name": null,
                "tel": "09116656567",
                "national_id": null,
                "email": null,
                "email_verified_at": null,
                "role": 3,
                "status": 1,
                "created_at": "2022-06-12T11:18:30.000000Z",
                "updated_at": "2022-06-12T11:18:30.000000Z"
            },
            {
                "id": 3,
                "name": "note",
                "tel": "09116656566",
                "national_id": null,
                "email": null,
                "email_verified_at": null,
                "role": 3,
                "status": 1,
                "created_at": "2022-06-12T11:17:34.000000Z",
                "updated_at": "2022-06-12T11:17:34.000000Z"
            },
            {
                "id": 1,
                "name": null,
                "tel": "9116659582",
                "national_id": null,
                "email": null,
                "email_verified_at": null,
                "role": 1,
                "status": 1,
                "created_at": "2022-06-12T09:03:27.000000Z",
                "updated_at": "2022-06-12T09:06:19.000000Z"
            }
        ],
        "first_page_url": "http:\/\/localhost:8000\/api\/admin\/users?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http:\/\/localhost:8000\/api\/admin\/users?page=1",
        "links": [
            {
                "url": null,
                "label": "&laquo; \u0642\u0628\u0644\u06cc",
                "active": false
            },
            {
                "url": "http:\/\/localhost:8000\/api\/admin\/users?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "\u0628\u0639\u062f\u06cc &raquo;",
                "active": false
            }
        ],
        "next_page_url": null,
        "path": "http:\/\/localhost:8000\/api\/admin\/users",
        "per_page": 30,
        "prev_page_url": null,
        "to": 6,
        "total": 6
    }
}
```