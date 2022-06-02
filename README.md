Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:
## Endpoints

**Login/Register**

`POST /login`

Inputs:
```
tel
````

Output on success:
```
{
    "success": true,
    "message": "success",
    "data": {
        "hash": "938c55560cd7d8c1c06f678a74dffd6e"
    }
}
```

Output on failure:
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

On success
```
{
    "success": true,
    "message": "success",
    "data": {
        "apiToken": "XXXXXXXXXXXXXXXXXXXXXXXXXXX"
    }
}
```

On failure
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

---

**other**

`GET `


---