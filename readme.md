# 📘 API Documentation

Base URL:

```
http://apis.babalrukn.com/api
````

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

**Response:**

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
  "message": "Paper templates retrieved successfully."
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

**Response:**

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

---

### 🔹 Profile (Requires Token)

**GET** `/user/profile`

**Headers:**

```
Authorization: Bearer YOUR_AUTH_TOKEN
```

**Response:**

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

---

### 🔹 Logout (Requires Token)

**POST** `/user/logout`

**Headers:**

```
Authorization: Bearer YOUR_AUTH_TOKEN
```

**Response:**

```json
{
  "status": true,
  "message": "Logged out successfully"
}
```

---

## 📚 Classes API (Requires Token)

### 🔹 Get All Classes

**GET** `/user/classes`

**Headers:**

```
Authorization: Bearer YOUR_AUTH_TOKEN
```

**Response:**

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

**Response:**

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

---

### 🔹 Get Class by ID

**GET** `/user/classes/{id}`

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

---

### 🔹 Delete Class

**DELETE** `/user/classes/{id}`

---

## 📘 Subjects API (Requires Token)

### 🔹 Get All Subjects

**GET** `/user/classes/subjects`

---

### 🔹 Get Subjects of a Class

**GET** `/user/classes/{class_id}/subjects`

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

---

### 🔹 Get Subject by ID

**GET** `/user/classes/{class_id}/subjects/{subject_id}`

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

---

### 🔹 Delete Subject

**DELETE** `/user/classes/{class_id}/subjects/{subject_id}`

---

## ⚡ Health Check

**GET** `/`

Response:

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

---

