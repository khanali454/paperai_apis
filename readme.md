# 📘 API Documentation

Base URL:

```
http://apis.babalrukn.com/api

```

Some endpoints require **Bearer Token** (Sanctum authentication).  

---

## 🚀 Authentication

### 🔹 Register  
**POST** `/register`

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "1234567890",
  "password": "secret123"
}
````

**✅ Success Response:**

```json
{
  "status": true,
  "data": {
    "token": "YOUR_AUTH_TOKEN",
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "phone": "1234567890",
      "role": "teacher"
    }
  },
  "message": "Account Created successfully."
}
```

**❌ Error Responses:**

```json
{
  "status": false,
  "message": "The email has already been taken."
}
```

```json
{
  "status": false,
  "message": "Validation failed",
  "errors": {
    "email": ["The email field is required."]
  }
}
```

---

### 🔹 Login

**POST** `/login`

**Request Body:**

```json
{
  "email": "john@example.com",
  "password": "secret123"
}
```

**✅ Success Response:**

```json
{
  "status": true,
  "data": {
    "token": "YOUR_AUTH_TOKEN",
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "phone": "1234567890",
      "role": "teacher"
    }
  },
  "message": "Logged in successfully."
}
```

**❌ Error Responses:**

```json
{
  "status": false,
  "message": "Invalid credentials."
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
      "name": "John Doe",
      "email": "john@example.com",
      "phone": "1234567890",
      "role": "teacher"
    }
  },
  "message": "Data retrieved successfully"
}
```

**❌ Error Response:**

```json
{
  "status": false,
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
  "status": false,
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
        "name": "Math Class",
        "description": "Basic Mathematics",
        "organized_by": 1
      }
    ]
  },
  "message": "Classes fetched successfully"
}
```

**❌ Error Response:**

```json
{
  "status": false,
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
      "id": 2,
      "name": "Science Class",
      "description": "Physics and Chemistry",
      "organized_by": 1
    }
  },
  "message": "Class created successfully"
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
