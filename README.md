# SEAL Backend Technical Test


# Task Management API Documentation

## Overview
API untuk manajemen tugas yang memungkinkan pengguna untuk mengelola proyek dan tugas-tugas terkait. API ini menggunakan Laravel 11 dan mengimplementasikan autentikasi menggunakan Laravel Sanctum.

## API Endpoints & Test Cases

### Authentication

#### 1. Register User
- **Endpoint:** `POST /api/auth/register`
- **Auth:** Not Required
- **Test Cases:**
  - ✅ Register dengan data valid
  - ❌ Email sudah terdaftar
  - ❌ Password terlalu pendek
  - ❌ Email format invalid
- **Request Body:**
  ```json
  {
      "name": "John Doe",
      "email": "john@example.com",
      "password": "password123"
  }
  ```

#### 2. Login User
- **Endpoint:** `POST /api/auth/login`
- **Auth:** Not Required
- **Test Cases:**
  - ✅ Login dengan kredensial valid
  - ❌ Email tidak terdaftar
  - ❌ Password salah
- **Request Body:**
  ```json
  {
      "email": "john@example.com",
      "password": "password123"
  }
  ```

### Users API

#### 1. Get All Users
- **Endpoint:** `GET /api/users`
- **Auth:** Required
- **Test Cases:**
  - ✅ Get dengan valid token
  - ❌ Get tanpa token

#### 2. Get Single User
- **Endpoint:** `GET /api/users/{id}`
- **Auth:** Required
- **Test Cases:**
  - ✅ Get existing user
  - ❌ Get non-existent user

#### 3. Update User
- **Endpoint:** `PUT /api/users/{id}`
- **Auth:** Required
- **Authorization:** User hanya bisa update profilnya sendiri
- **Test Cases:**
  - ✅ Update data diri sendiri
  - ✅ Update password sendiri
  - ❌ Update data user lain (forbidden)
  - ❌ Update dengan email yang sudah ada
  - ❌ Update tanpa token
- **Request Body:**
  ```json
  {
      "name": "John Updated",
      "email": "john.updated@example.com",
      "password": "newpassword123"
  }
  ```

#### 4. Upload Avatar
- **Endpoint:** `POST /api/users/{id}/avatar`
- **Auth:** Required
- **Authorization:** User hanya bisa upload avatar untuk akunnya sendiri
- **Content-Type:** `multipart/form-data`
- **Test Cases:**
  - ✅ Upload avatar untuk akun sendiri
  - ❌ Upload avatar untuk user lain (forbidden)
  - ❌ Upload file non-image
  - ❌ Upload file terlalu besar (>2MB)
  - ❌ Upload tanpa file
  - ❌ Upload tanpa token
- **Request Body:**
  ```
  avatar: [file]
  ```

#### 5. Delete User
- **Endpoint:** `DELETE /api/users/{id}`
- **Auth:** Required
- **Authorization:** User hanya bisa menghapus akunnya sendiri
- **Test Cases:**
  - ✅ Delete akun sendiri
  - ❌ Delete akun user lain (forbidden)
  - ❌ Delete tanpa token
  - ❌ Delete user yang tidak ada

### Projects API

#### 1. Get All Projects
- **Endpoint:** `GET /api/projects`
- **Auth:** Required
- **Test Cases:**
  - ✅ Get semua project
  - ✅ Verify relasi dengan user
  - ❌ Get tanpa token

#### 2. Create Project
- **Endpoint:** `POST /api/projects`
- **Auth:** Required
- **Test Cases:**
  - ✅ Create dengan data valid
  - ❌ Create tanpa nama
  - ❌ Create dengan nama terlalu panjang
- **Request Body:**
  ```json
  {
      "name": "New Project",
      "description": "Project description"
  }
  ```

#### 3. Get Single Project
- **Endpoint:** `GET /api/projects/{id}`
- **Auth:** Required
- **Test Cases:**
  - ✅ Get existing project dengan tasks
  - ❌ Get non-existent project

#### 4. Update Project
- **Endpoint:** `PUT /api/projects/{id}`
- **Auth:** Required
- **Test Cases:**
  - ✅ Update own project
  - ❌ Update project user lain
  - ❌ Update non-existent project
- **Request Body:**
  ```json
  {
      "name": "Updated Project",
      "description": "Updated description"
  }
  ```

#### 5. Delete Project
- **Endpoint:** `DELETE /api/projects/{id}`
- **Auth:** Required
- **Test Cases:**
  - ✅ Delete own project
  - ❌ Delete project user lain
  - ❌ Delete non-existent project

### Tasks API

#### 1. Get All Tasks
- **Endpoint:** `GET /api/tasks`
- **Auth:** Required
- **Test Cases:**
  - ✅ Get semua tasks
  - ✅ Filter by project_id
  - ✅ Filter by status
  - ❌ Get tanpa token
- **Query Parameters:**
  - `project_id` (optional): Filter by project
  - `status` (optional): Filter by status (todo, in_progress, completed)

#### 2. Create Task
- **Endpoint:** `POST /api/tasks`
- **Auth:** Required
- **Test Cases:**
  - ✅ Create dengan data valid
  - ✅ Create dengan due date
  - ❌ Create dengan project_id invalid
  - ❌ Create dengan user_id invalid
  - ❌ Create dengan status invalid
- **Request Body:**
  ```json
  {
      "title": "New Task",
      "description": "Task description",
      "status": "todo",
      "due_date": "2024-02-01",
      "project_id": 1,
      "user_id": 1
  }
  ```

#### 3. Get Single Task
- **Endpoint:** `GET /api/tasks/{id}`
- **Auth:** Required
- **Test Cases:**
  - ✅ Get existing task dengan relasi
  - ❌ Get non-existent task

#### 4. Update Task
- **Endpoint:** `PUT /api/tasks/{id}`
- **Auth:** Required
- **Test Cases:**
  - ✅ Update status
  - ✅ Update due date
  - ✅ Reassign ke user lain
  - ❌ Update dengan status invalid
  - ❌ Update dengan user_id invalid
- **Request Body:**
  ```json
  {
      "title": "Updated Task",
      "status": "in_progress",
      "due_date": "2024-02-15",
      "user_id": 2
  }
  ```

#### 5. Delete Task
- **Endpoint:** `DELETE /api/tasks/{id}`
- **Auth:** Required
- **Test Cases:**
  - ✅ Delete existing task
  - ❌ Delete non-existent task
