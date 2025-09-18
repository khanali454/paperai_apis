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

**GET** `/user/classes/all-subjects`

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

# 📘 Study Material API Documentation


### Fields

| Field              | Type     | Description                               |
| ------------------ | -------- | ----------------------------------------- |
| `id`               | integer  | Unique identifier.                        |
| `title`            | string   | Study material title (max **100 chars**). |
| `description`      | string   | Optional description (max **200 chars**). |
| `material_type_id` | integer  | FK → `material_types.id`.                 |
| `class_id`         | integer  | FK → `student_classes.id`.                |
| `subject_id`       | integer  | FK → `subjects.id`.                       |
| `user_id`          | integer  | FK → `users.id` (owner).                  |
| `is_public`        | boolean  | Whether material is publicly available.   |
| `file_path`        | string   | Path to uploaded file.                    |
| `file_url`         | string   | Publicly accessible file URL.             |
| `file_name`        | string   | Original filename.                        |
| `file_type`        | string   | File extension.                           |
| `thumbnail`        | string   | Path to thumbnail (optional).             |
| `thumbnail_url`    | string   | Publicly accessible thumbnail URL.        |
| `created_at`       | datetime | Timestamp.                                |
| `updated_at`       | datetime | Timestamp.                                |

---

## 📌 Validation Rules

| Field              | Rule                                                                                 |
| ------------------ | ------------------------------------------------------------------------------------ |
| `title`            | required, string, max:100                                                            |
| `description`      | nullable, string, max:200                                                            |
| `material_type_id` | required, exists\:material\_types,id                                                 |
| `class_id`         | required, exists\:student\_classes,id                                                |
| `subject_id`       | required, exists\:subjects,id                                                        |
| `is_public`        | boolean                                                                              |
| `file`             | required, file, mimes\:pdf,ppt,pptx,doc,docx,xls,xlsx,txt,png,jpeg,jpg, max:46080 KB |
| `thumbnail`        | nullable, image, mimes\:jpeg,png,jpg, max:2048 KB                                    |

---

## 📌 Endpoints


### 1️⃣ **List All Study Material Types**

`GET /api/user/study-materials/types`

**Response (200 OK)**:
```json
{
  "status": true,
  "data": {
    "material_types": [
      {
        "id":1,
        "name":"Notes",
        "created_at":"2025-08-30T07:22:03.000000Z",
        "updated_at":"2025-08-30T07:22:03.000000Z"
      },
      {
        "id":2,
        "name":"Books",
        "created_at":"2025-08-30T07:22:03.000000Z",
        "updated_at":"2025-08-30T07:22:03.000000Z"
      }
    ]
  },
 "message": "Material types fetched successfully",
}

```

### 1️⃣ **List All Study Materials**

`GET /api/user/study-materials`

**Response (200 OK)**:

```json
{
  "status": true,
  "data": {
    "materials": [
      {
        "id": 1,
        "title": "Math Algebra Notes",
        "description": "Chapter 1 to 3 summary",
        "file_name": "algebra_notes.pdf",
        "file_type": "pdf",
        "file_url": "https://yourapp.com/storage/study_materials/files/algebra_notes.pdf",
        "thumbnail_url": null,
        "is_public": false,
        "user": {
          "id": 5,
          "name": "John Doe"
        },
        "student_class": {
          "id": 2,
          "name": "Grade 10"
        },
        "subject": {
          "id": 4,
          "name": "Mathematics"
        },
        "type": {
          "id": 1,
          "name": "Notes"
        }
      }
    ]
  },
  "message": "Study materials fetched successfully"
}
```
---

### **Query Parameters**

| Parameter    | Type    | Required | Description                                       |
| ------------ | ------- | -------- | ------------------------------------------------- |
| `search`     | string  | No       | Search keyword to match `title` or `description`. |
| `class_id`   | integer | No       | Filter by class ID.                               |
| `subject_id` | integer | No       | Filter by subject ID.                             |
| `type_id`    | integer | No       | Filter by type ID.                                |
| `visibility` | string  | No       | Filter by visibility (`public`, `private`, etc.). |
| `per_page`   | integer | No       | Number of results per page (default: `10`).       |
| `page`       | integer | No       | Pagination page number (default: `1`).            |

---


---

### 2️⃣ **Create Study Material**

`POST /api/user/study-materials`

**Request (multipart/form-data)**:

```http
title=Physics Notes
description=Important formulas for exams
material_type_id=1
class_id=2
subject_id=3
is_public=true
file=@notes.pdf
thumbnail=@cover.jpg
```

**Response (201 Created)**:

```json
{
  "status": true,
  "data": {
    "material": {
      "id": 12,
      "title": "Physics Notes",
      "description": "Important formulas for exams",
      "file_name": "notes.pdf",
      "file_type": "pdf",
      "file_url": "https://yourapp.com/storage/study_materials/files/notes.pdf",
      "thumbnail_url": "https://yourapp.com/storage/study_materials/thumbnails/cover.jpg",
      "is_public": true
    }
  },
  "message": "Study material created successfully"
}
```

---

### 3️⃣ **Get Single Study Material**

`GET /api/user/study-materials/{id}`

**Response (200 OK)**:

```json
{
  "status": true,
  "data": {
    "material": {
      "id": 12,
      "title": "Physics Notes",
      "description": "Important formulas for exams",
      "file_name": "notes.pdf",
      "file_type": "pdf",
      "file_url": "https://yourapp.com/storage/study_materials/files/notes.pdf",
      "thumbnail_url": "https://yourapp.com/storage/study_materials/thumbnails/cover.jpg",
      "is_public": true,
      "user": {
        "id": 5,
        "name": "John Doe"
      },
      "student_class": {
        "id": 2,
        "name": "Grade 10"
      },
      "subject": {
        "id": 3,
        "name": "Physics"
      },
      "type": {
        "id": 1,
        "name": "Notes"
      }
    }
  },
  "message": "Study material retrieved successfully"
}
```

---

### 4️⃣ **Update Study Material**

`PUT /api/user/study-materials/{id}`

**Request (multipart/form-data)**:

```http
title=Updated Physics Notes
file=@updated_notes.pdf
```

**Response (200 OK)**:

```json
{
  "status": true,
  "data": {
    "material": {
      "id": 12,
      "title": "Updated Physics Notes",
      "file_name": "updated_notes.pdf",
      "file_type": "pdf",
      "file_url": "https://yourapp.com/storage/study_materials/files/updated_notes.pdf"
    }
  },
  "message": "Study material updated successfully"
}
```

---

### 5️⃣ **Delete Study Material**

`DELETE /api/user/study-materials/{id}`

**Response (200 OK)**:

```json
{
  "status": true,
  "message": "Study material deleted successfully"
}
```


# Paper Management API Documentation
Base endpoint for it
```
/user
```


## 1. Question Types

### Get All Question Types
**Endpoint:** `GET /question-types`

**Response:**
```json
{
  "status": true,
  "data": {
    "question_types": [
      {
        "id": 1,
        "name": "Multiple Choice Questions",
        "slug": "mcq",
        "description": "Questions with multiple choices and one correct answer",
        "has_options": true,
        "has_correct_answer": true,
        "can_have_sub_questions": false,
        "has_paragraph": false,
        "created_at": "2023-08-21T10:22:45.000000Z",
        "updated_at": "2023-08-21T10:22:45.000000Z"
      }
    ]
  },
  "message": "Question types fetched successfully"
}
```

---

## 2. Papers

### Get All Papers
**Endpoint:** `GET /papers`

**Response:**
```json
{
  "status": true,
  "data": {
    "papers": [
      {
        "id": 1,
        "title": "Mathematics Final Exam",
        "user_id": 1,
        "class_id": 5,
        "subject_id": 3,
        "created_by": "manual",
        "uploaded_paper_file": null,
        "data_source": "personal",
        "duration": 120,
        "total_marks": 100,
        "created_at": "2023-09-09T12:22:45.000000Z",
        "updated_at": "2023-09-09T12:22:45.000000Z",
        "sections": []
      }
    ]
  },
  "message": "Papers fetched successfully"
}
```

### Create a Paper
**Endpoint:** `POST /papers`

**Payload:**
```json
{
  "title": "Mathematics Final Exam",
  "class_id": 5,
  "subject_id": 3,
  "created_by": "manual",
  "uploaded_paper_file": null,
  "data_source": "personal",
  "duration": 120
}
```

**Response:**
```json
{
  "status": true,
  "data": {
    "paper": {
      "id": 1,
      "title": "Mathematics Final Exam",
      "user_id": 1,
      "class_id": 5,
      "subject_id": 3,
      "created_by": "manual",
      "uploaded_paper_file": null,
      "data_source": "personal",
      "duration": 120,
      "total_marks": 0,
      "created_at": "2023-09-09T12:22:45.000000Z",
      "updated_at": "2023-09-09T12:22:45.000000Z",
      "sections": []
    }
  },
  "message": "Paper created successfully"
}
```

### Get a Specific Paper
**Endpoint:** `GET /papers/{id}`

**Response:**
```json
{
  "status": true,
  "data": {
    "paper": {
      "id": 1,
      "title": "Mathematics Final Exam",
      "user_id": 1,
      "class_id": 5,
      "subject_id": 3,
      "created_by": "manual",
      "uploaded_paper_file": null,
      "data_source": "personal",
      "duration": 120,
      "total_marks": 100,
      "created_at": "2023-09-09T12:22:45.000000Z",
      "updated_at": "2023-09-09T12:22:45.000000Z",
      "sections": [
        {
          "id": 1,
          "paper_id": 1,
          "title": "Section A",
          "instructions": "Answer all questions",
          "order": 0,
          "created_at": "2023-09-09T12:22:45.000000Z",
          "updated_at": "2023-09-09T12:22:45.000000Z",
          "section_groups": []
        }
      ]
    }
  },
  "message": "Paper retrieved successfully"
}
```

### Update a Paper
**Endpoint:** `PUT /papers/{id}`

**Payload:**
```json
{
  "title": "Updated Mathematics Final Exam",
  "duration": 150
}
```

**Response:**
```json
{
  "status": true,
  "data": {
    "paper": {
      "id": 1,
      "title": "Updated Mathematics Final Exam",
      "user_id": 1,
      "class_id": 5,
      "subject_id": 3,
      "created_by": "manual",
      "uploaded_paper_file": null,
      "data_source": "personal",
      "duration": 150,
      "total_marks": 100,
      "created_at": "2023-09-09T12:22:45.000000Z",
      "updated_at": "2023-09-09T12:22:45.000000Z",
      "sections": []
    }
  },
  "message": "Paper updated successfully"
}
```

### Delete a Paper
**Endpoint:** `DELETE /papers/{id}`

**Response:**
```json
{
  "status": true,
  "message": "Paper deleted successfully"
}
```

---

## 3. Paper Sections

### Create a Section
**Endpoint:** `POST /papers/{paper}/sections`

**Payload:**
```json
{
  "title": "Section A",
  "instructions": "Answer all questions in this section",
  "order": 0
}
```

**Response:**
```json
{
  "status": true,
  "data": {
    "section": {
      "id": 1,
      "paper_id": 1,
      "title": "Section A",
      "instructions": "Answer all questions in this section",
      "order": 0,
      "created_at": "2023-09-09T12:22:45.000000Z",
      "updated_at": "2023-09-09T12:22:45.000000Z",
      "section_groups": []
    }
  },
  "message": "Section created successfully"
}
```

### Update a Section
**Endpoint:** `PUT /papers/{paper}/sections/{section}`

**Payload:**
```json
{
  "title": "Updated Section A",
  "instructions": "Updated instructions",
  "order": 1
}
```

**Response:**
```json
{
  "status": true,
  "data": {
    "section": {
      "id": 1,
      "paper_id": 1,
      "title": "Updated Section A",
      "instructions": "Updated instructions",
      "order": 1,
      "created_at": "2023-09-09T12:22:45.000000Z",
      "updated_at": "2023-09-09T12:22:45.000000Z",
      "section_groups": []
    }
  },
  "message": "Section updated successfully"
}
```

### Delete a Section
**Endpoint:** `DELETE /papers/{paper}/sections/{section}`

**Response:**
```json
{
  "status": true,
  "message": "Section deleted successfully"
}
```

---

## 4. Section Groups

### Create a Section Group
**Endpoint:** `POST /sections/{section}/groups`

**Payload:**
```json
{
  "question_type_id": 1,
  "instructions": "Choose the correct option",
  "logic": null,
  "order": 0
}
```

**Response:**
```json
{
  "status": true,
  "data": {
    "group": {
      "id": 1,
      "section_id": 1,
      "question_type_id": 1,
      "instructions": "Choose the correct option",
      "logic": null,
      "order": 0,
      "created_at": "2023-09-16T14:38:02.000000Z",
      "updated_at": "2023-09-16T14:38:02.000000Z",
      "questions": []
    }
  },
  "message": "Section group created successfully"
}
```

### Update a Section Group
**Endpoint:** `PUT /sections/{section}/groups/{group}`

**Payload:**
```json
{
  "instructions": "Updated instructions",
  "order": 1
}
```

**Response:**
```json
{
  "status": true,
  "data": {
    "group": {
      "id": 1,
      "section_id": 1,
      "question_type_id": 1,
      "instructions": "Updated instructions",
      "logic": null,
      "order": 1,
      "created_at": "2023-09-16T14:38:02.000000Z",
      "updated_at": "2023-09-16T14:38:02.000000Z",
      "questions": []
    }
  },
  "message": "Section group updated successfully"
}
```

### Delete a Section Group
**Endpoint:** `DELETE /sections/{section}/groups/{group}`

**Response:**
```json
{
  "status": true,
  "message": "Section group deleted successfully"
}
```

---

## 5. Questions

### Create a Question (Multiple Choice)
**Endpoint:** `POST /groups/{group}/questions`

**Payload:**
```json
{
  "question_text": "What is 2 + 2?",
  "marks": 1,
  "order": 0,
  "options": [
    {
      "option_text": "3",
      "is_correct": false,
      "order": 0
    },
    {
      "option_text": "4",
      "is_correct": true,
      "order": 1
    },
    {
      "option_text": "5",
      "is_correct": false,
      "order": 2
    }
  ]
}
```

**Response:**
```json
{
  "status": true,
  "data": {
    "question": {
      "id": 1,
      "section_group_id": 1,
      "parent_question_id": null,
      "question_text": "What is 2 + 2?",
      "paragraph_text": null,
      "correct_answer": null,
      "marks": 1,
      "order": 0,
      "sub_order": 0,
      "created_at": "2023-09-16T17:51:04.000000Z",
      "updated_at": "2023-09-16T17:51:04.000000Z",
      "options": [
        {
          "id": 1,
          "paper_question_id": 1,
          "option_text": "3",
          "is_correct": false,
          "order": 0,
          "created_at": "2023-09-16T19:15:19.000000Z",
          "updated_at": "2023-09-16T19:15:19.000000Z"
        },
        {
          "id": 2,
          "paper_question_id": 1,
          "option_text": "4",
          "is_correct": true,
          "order": 1,
          "created_at": "2023-09-16T19:15:19.000000Z",
          "updated_at": "2023-09-16T19:15:19.000000Z"
        }
      ],
      "subQuestions": []
    }
  },
  "message": "Question created successfully"
}
```

### Create a Question (Fill in the Blanks)
**Endpoint:** `POST /groups/{group}/questions`

**Payload:**
```json
{
  "question_text": "The capital of France is _____.",
  "correct_answer": "Paris",
  "marks": 1,
  "order": 0
}
```

### Create a Question (Short Answer with Sub-questions)
**Endpoint:** `POST /groups/{group}/questions`

**Payload:**
```json
{
  "question_text": "Answer the following questions:",
  "marks": 0,
  "order": 0,
  "sub_questions": [
    {
      "question_text": "What is the formula for water?",
      "correct_answer": "H2O",
      "marks": 2,
      "sub_order": 0
    },
    {
      "question_text": "What is the chemical symbol for gold?",
      "correct_answer": "Au",
      "marks": 2,
      "sub_order": 1
    }
  ]
}
```

### Create a Question (Paragraph Type)
**Endpoint:** `POST /groups/{group}/questions`

**Payload:**
```json
{
  "paragraph_text": "Read the following passage and answer the questions below. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam euismod, nisl eget aliquam ultricies, nunc nisl aliquet nunc, quis aliquam nisl nunc eu nisl.",
  "marks": 0,
  "order": 0,
  "sub_questions": [
    {
      "question_text": "What is the main idea of the passage?",
      "marks": 5,
      "sub_order": 0
    },
    {
      "question_text": "What does 'Lorem ipsum' refer to?",
      "marks": 5,
      "sub_order": 1
    }
  ]
}
```

### Create a Question (True/False)
**Endpoint:** `POST /groups/{group}/questions`

**Payload:**
```json
{
  "question_text": "The Earth is flat.",
  "marks": 1,
  "order": 0,
  "options": [
    {
      "option_text": "True",
      "is_correct": false,
      "order": 0
    },
    {
      "option_text": "False",
      "is_correct": true,
      "order": 1
    }
  ]
}
```

### Update a Question
**Endpoint:** `PUT /groups/{group}/questions/{question}`

**Payload:**
```json
{
  "question_text": "Updated question text",
  "marks": 2
}
```

**Response:**
```json
{
  "status": true,
  "data": {
    "question": {
      "id": 1,
      "section_group_id": 1,
      "parent_question_id": null,
      "question_text": "Updated question text",
      "paragraph_text": null,
      "correct_answer": null,
      "marks": 2,
      "order": 0,
      "sub_order": 0,
      "created_at": "2023-09-16T17:51:04.000000Z",
      "updated_at": "2023-09-16T17:51:04.000000Z",
      "options": [],
      "subQuestions": []
    }
  },
  "message": "Question updated successfully"
}
```

### Delete a Question
**Endpoint:** `DELETE /groups/{group}/questions/{question}`

**Response:**
```json
{
  "status": true,
  "message": "Question deleted successfully"
}
```

## Error Responses

### Validation Error
```json
{
  "status": false,
  "data": {
    "errors": {
      "field_name": ["The field name is required."]
    }
  },
  "message": "The field name is required."
}
```

### Not Found Error
```json
{
  "status": false,
  "message": "Paper not found"
}
```


---

## 🛠️ Notes

* Use `Authorization: Bearer <token>` in headers for all protected routes.
* Register/Login APIs return the token required for subsequent requests.
* All responses are JSON formatted.
* Error messages are clear and descriptive for easy debugging.

---
