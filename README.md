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

**Get a single image by id**

`GET /wallpaper/wallpapers/{id}`

Output:
```{
  "success": true,
  "data": {
    "id": 1,
    "url": "https://picsum.photos/id/995/600/500",
    "title": "non minus",
    "tags": [
      {
        "id": 1,
        "title": "طبیعت",
        "slug": "nature",
        "created_at": null,
        "updated_at": null,
        "pivot": {
          "wallpaper_id": 1,
          "tag_id": 1
        }
      },
      {
        "id": 2,
        "title": "آیفون",
        "slug": "iphone",
        "created_at": null,
        "updated_at": null,
        "pivot": {
          "wallpaper_id": 1,
          "tag_id": 2
        }
      },
      {
        "id": 3,
        "title": "کهکشان",
        "slug": "galaxy",
        "created_at": null,
        "updated_at": null,
        "pivot": {
          "wallpaper_id": 1,
          "tag_id": 3
        }
      }
    ],
    "likes": 2,
    "created_at": "2022-01-20",
    "updated_at": "2022-01-20"
  },
  "message": "Wallpaper fetched."
}
```
---

**Get All images with specific tag**

`GET /wallpaper/wallpapers/tag/{slug}`

Output is same as `/wallpaper/wallpapers` with requested tag

---
**Get all tags**

`GET /wallpaper/tags`

Output:
```
[
  {
    "id": 1,
    "slug": "nature",
    "title": "طبیعت",
    "image": "https://picsum.photos/id/1043/400/500"
  },
  {
    "id": 2,
    "slug": "iphone",
    "title": "آیفون",
    "image": "https://picsum.photos/id/719/700/700"
  },
  {
    "id": 3,
    "slug": "galaxy",
    "title": "کهکشان",
    "image": "https://picsum.photos/id/988/400/400"
  }
]
```
---
**Login and get API token**


`POST /login`  
Output:
```
{
  "success": true,
  "data": {
    "token": "1|hkJQ8NaCXGLtS13G6LhVK5BvtJKxZI4Sz07h3ogK",
    "name": "admin"
  },
  "message": "User signed in"
}
```
---
**All CRUD actions must have Authorization Header Using Bearer Token**
 
Exapmle:<br> `Authorization: Bearer 1|PnZaOacPyHjjOA7eOcSJT33VxJuvUo8TGVBnW186`

---

**Create a new image/wallpaper**

`POST  /wallpaper/wallpapers`

Params:

- `title` image title
- `url` image full URL
- `likes` number of liker
- `tags[]` (as array) each wallpaper/image can have multiple tags 

After successful image creation, system will return created Item.
```
{
  "success": true,
  "data": {
    "id": 52,
    "url": "https://via.placeholder.coem/500x500.png?text=repudiandae%20w",
    "title": "yes",
    "tags": [
      {
        "id": 1,
        "title": "طبیعت",
        "slug": "nature",
        "created_at": null,
        "updated_at": null,
        "pivot": {
          "wallpaper_id": 52,
          "tag_id": 1
        }
      },
      {
        "id": 2,
        "title": "آیفون",
        "slug": "iphone",
        "created_at": null,
        "updated_at": null,
        "pivot": {
          "wallpaper_id": 52,
          "tag_id": 2
        }
      }
    ],
    "likes": null,
    "created_at": "2022-01-23",
    "updated_at": "2022-01-23"
  },
  "message": "Wallpaper created."
}
```

**Update a wallpaper**

`POST http://localhost:8000/wallpaper/wallpapers/{id}`

Params:

- `title` image new title
- `url` image new full URL
- `likes` number of liker
- `tags[]` (as array) each wallpaper/image can have multiple tags 
- `_method` MUST equals to 'PATCH'update readme.md


After successful image update, system will return created Item.
```
{
  "success": true,
  "data": {
    "id": 52,
    "url": "https://via.placeholder.coem/500x500.png?text=repudiandae%20w",
    "title": "yes",
    "tags": [
      {
        "id": 1,
        "title": "طبیعت",
        "slug": "nature",
        "created_at": null,
        "updated_at": null,
        "pivot": {
          "wallpaper_id": 52,
          "tag_id": 1
        }
      },
      {
        "id": 2,
        "title": "آیفون",
        "slug": "iphone",
        "created_at": null,
        "updated_at": null,
        "pivot": {
          "wallpaper_id": 52,
          "tag_id": 2
        }
      }
    ],
    "likes": 0,
    "created_at": "2022-01-23",
    "updated_at": "2022-01-23"
  },
  "message": "Wallpaper updated."
}
```