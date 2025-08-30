# 📘 API Documentation

Base URL:

```
http://apis.babalrukn.com/api

```

Some endpoints require **Bearer Token** (Sanctum authentication).  

---

## 🚀 Authentication

### 🔹 Register  
**POST** `/user/register`

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "yameen@gmail.com",
  "phone": "1234567890",
  "password": "password123"
}
````

**✅ Success Response:**

```json
{
  "status": true,
  "data": {
    "token": "4|sTaKiL9SycXFt2xvbZ1vlQIznqPXVvoq3oEE5mgh5feb1ed5",
    "user": {
      "name": "John Doe",
      "email": "yameen@gmail.com",
      "phone": "1234567890",
      "role": "teacher",
      "updated_at": "2025-08-30T07:22:03.000000Z",
      "created_at": "2025-08-30T07:22:03.000000Z",
      "id": 4
    }
  },
  "message": "Account Created successfully."
}
```

**❌ Error Responses:**

```json
{
  "status": false,
  "data": {
    "errors": {
      "name": [
        "The name field is required."
      ],
      "email": [
        "The email field is required."
      ],
      "phone": [
        "The phone field is required."
      ],
      "password": [
        "The password field is required."
      ]
    }
  },
  "message": "The name field is required."
}
```

```json
{
  "status": false,
  "data": {
    "errors": {
      "email": [
        "The email has already been taken."
      ]
    }
  },
  "message": "The email has already been taken."
}
```

---

### 🔹 Login

**POST** `/user/login`

**Request Body:**

```json
{
  "email": "aqeel@gmail.com",
  "password": "password123"
}
```

**✅ Success Response:**

```json
{
  "status": true,
  "data": {
    "token": "2|ILUWQ0HcCzIxFnFy8C4TLG874E88KQF8RO0MY8Nw95d5f90c",
    "user": {
      "id": 1,
      "name": "Aqeel Abbas",
      "email": "aqeel@gmail.com",
      "phone": 1234567890,
      "email_verified_at": null,
      "role": "teacher",
      "status": "active",
      "profile_picture": null,
      "organization": null,
      "created_at": "2025-08-28T12:03:53.000000Z",
      "updated_at": "2025-08-28T12:03:53.000000Z"
    }
  },
  "message": "Logged in successfully."
}
```

**❌ Error Responses:**

```json
{
  "status": false,
  "message": "Invalid credentials"
}
```

```json
{
  "status": false,
  "data": {
    "errors": {
      "email": [
        "The email field is required."
      ],
      "password": [
        "The password field is required."
      ]
    }
  },
  "message": "The email field is required."
}
```

```json
{
  "status": false,
  "data": {
    "errors": {
      "email": [
        "The email field is required."
      ]
    }
  },
  "message": "The email field is required."
}
```

---

### 🔹 Profile (Requires Token)

**GET** `/user/profile`

**Headers:**

```
Authorization: Bearer YOUR_AUTH_TOKEN
```

**✅ Success Response:**

```json
{
  "status": true,
  "data": {
    "profile": {
      "id": 1,
      "name": "Aqeel Abbas",
      "email": "aqeel@gmail.com",
      "phone": 1234567890,
      "email_verified_at": null,
      "role": "teacher",
      "status": "active",
      "profile_picture": null,
      "organization": null,
      "created_at": "2025-08-28T12:03:53.000000Z",
      "updated_at": "2025-08-28T12:03:53.000000Z"
    }
  },
  "message": "Data retrieved successfully"
}
```

**❌ Error Response:**

```json
{
  "message": "Unauthenticated."
}
```

---

### 🔹 Logout (Requires Token)

**POST** `/user/logout`

**Headers:**

```
Authorization: Bearer YOUR_AUTH_TOKEN
```

**✅ Success Response:**

```json
{
  "status": true,
  "message": "Logged out successfully"
}
```

**❌ Error Response:**

```json
{
  "message": "Unauthenticated."
}
```

---

## 📚 Classes API (Requires Token)

### 🔹 Get All Classes

**GET** `/user/classes`

**✅ Success Response:**

```json
{
  "status": true,
  "data": {
    "classes": [
      {
        "id": 1,
        "name": "8th Grade",
        "description": "Class for 8th grade students",
        "organized_by": 1,
        "created_at": "2025-08-28T12:03:54.000000Z",
        "updated_at": "2025-08-28T12:03:54.000000Z"
      },
      {
        "id": 2,
        "name": "9th Grade",
        "description": "Class for 9th grade students",
        "organized_by": 1,
        "created_at": "2025-08-28T12:03:54.000000Z",
        "updated_at": "2025-08-28T12:03:54.000000Z"
      },
      {
        "id": 3,
        "name": "10th Grade",
        "description": "Class for 10th grade students",
        "organized_by": 1,
        "created_at": "2025-08-28T12:03:54.000000Z",
        "updated_at": "2025-08-28T12:03:54.000000Z"
      },
      {
        "id": 4,
        "name": "11th Grade",
        "description": "Class for 11th grade students",
        "organized_by": 1,
        "created_at": "2025-08-28T12:03:54.000000Z",
        "updated_at": "2025-08-28T12:03:54.000000Z"
      },
      {
        "id": 5,
        "name": "12th Grade",
        "description": "Class for 12th grade students",
        "organized_by": 1,
        "created_at": "2025-08-28T12:03:54.000000Z",
        "updated_at": "2025-08-28T12:03:54.000000Z"
      },
      {
        "id": 6,
        "name": "12th",
        "description": null,
        "organized_by": 1,
        "created_at": "2025-08-30T06:42:08.000000Z",
        "updated_at": "2025-08-30T06:42:08.000000Z"
      },
      {
        "id": 7,
        "name": "11th",
        "description": null,
        "organized_by": 1,
        "created_at": "2025-08-30T06:43:05.000000Z",
        "updated_at": "2025-08-30T06:43:05.000000Z"
      }
    ]
  },
  "message": "Classes fetched successfully"
}
```

```json
{
  "status": true,
  "data": {
    "classes": []
  },
  "message": "Classes fetched successfully"
}
```

**❌ Error Response:**

```json
{
  "message": "Unauthenticated."
}
```

---

### 🔹 Create Class

**POST** `/user/classes`

**Request Body:**

```json
{
  "name": "Science Class",
  "description": "Physics and Chemistry"
}
```

**✅ Success Response:**

```json
{
  "status": true,
  "data": {
    "class": {
      "name": "6th Class",
      "description": null,
      "organized_by": 2,
      "updated_at": "2025-08-30T12:51:18.000000Z",
      "created_at": "2025-08-30T12:51:18.000000Z",
      "id": 8
    }
  },
  "message": "Class created successfully"
}
```

**❌ Error Responses:**

```json
{
  "status": false,
  "data": {
    "errors": {
      "name": [
        "The name field is required."
      ]
    }
  },
  "message": "The name field is required."
}
```

```json
{
  "message": "Unauthenticated."
}
```

---

### 🔹 Get Class by ID

**GET** `/user/classes/{id}`

**❌ Error Response:**

```json
{
  "status": false,
  "message": "Class not found."
}
```

---

### 🔹 Update Class

**PUT** `/user/classes/{id}`

**Request Body:**

```json
{
  "name": "Updated Class",
  "description": "Updated Description"
}
```

**✅ Success Response:**

```json
{
  "status": true,
  "data": {
    "class": {
      "id": 1,
      "name": "Updated Class",
      "description": "Updated Description"
    }
  },
  "message": "Class updated successfully"
}
```

**❌ Error Response:**

```json
{
  "status": false,
  "message": "Class not found."
}
```

---

### 🔹 Delete Class

**DELETE** `/user/classes/{id}`

**✅ Success Response:**

```json
{
  "status": true,
  "message": "Class deleted successfully"
}
```

**❌ Error Response:**

```json
{
  "status": false,
  "message": "Class not found."
}
```

---

## 📘 Subjects API (Requires Token)

### 🔹 Get All Subjects

**GET** `/user/classes/subjects`

**❌ Error Response:**

```json
{
  "status": false,
  "message": "Unauthenticated."
}
```

---

### 🔹 Get Subjects of a Class

**GET** `/user/classes/{class_id}/subjects`

**❌ Error Response:**

```json
{
  "status": false,
  "message": "Class not found."
}
```

---

### 🔹 Create Subject in Class

**POST** `/user/classes/{class_id}/subjects`

**Request Body:**

```json
{
  "name": "Algebra",
  "description": "Basic Algebra course"
}
```

**✅ Success Response:**

```json
{
  "status": true,
  "data": {
    "subject": {
      "id": 1,
      "name": "Algebra",
      "description": "Basic Algebra course",
      "class_id": 1
    }
  },
  "message": "Subject created successfully"
}
```

**❌ Error Responses:**

```json
{
  "status": false,
  "message": "The name field is required."
}
```

```json
{
  "status": false,
  "message": "Class not found."
}
```

---

### 🔹 Get Subject by ID

**GET** `/user/classes/{class_id}/subjects/{subject_id}`

**❌ Error Response:**

```json
{
  "status": false,
  "message": "Subject not found."
}
```

---

### 🔹 Update Subject

**PUT** `/user/classes/{class_id}/subjects/{subject_id}`

**Request Body:**

```json
{
  "name": "Advanced Algebra",
  "description": "Updated description"
}
```

**✅ Success Response:**

```json
{
  "status": true,
  "data": {
    "subject": {
      "id": 1,
      "name": "Advanced Algebra",
      "description": "Updated description"
    }
  },
  "message": "Subject updated successfully"
}
```

**❌ Error Response:**

```json
{
  "status": false,
  "message": "Subject not found."
}
```

---

### 🔹 Delete Subject

**DELETE** `/user/classes/{class_id}/subjects/{subject_id}`

**✅ Success Response:**

```json
{
  "status": true,
  "message": "Subject deleted successfully"
}
```

**❌ Error Response:**

```json
{
  "status": false,
  "message": "Subject not found."
}
```

---

## ⚡ Health Check

**GET** `/`

**✅ Success Response:**

```json
{
  "status": "OK"
}
```

---

## 🛠️ Notes

* Use `Authorization: Bearer <token>` in headers for all protected routes.
* Register/Login APIs return the token required for subsequent requests.
* All responses are JSON formatted.
* Error messages are clear and descriptive for easy debugging.

---
