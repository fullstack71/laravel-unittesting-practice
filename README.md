# Laravel Unit Testing Practice – Product API

A practice project built with **Laravel** for exploring **API development** and **testing**.  
The project covers a **Product Management API** with related entities like **Categories**, **Tags**, and **Variations**, while focusing on **Unit Tests** and **Feature Tests**.

---

## 🎯 Purpose

- Practice designing and building structured APIs in Laravel.  
- Strengthen knowledge of **Eloquent relationships**. # Laravel Unit Testing Practice – Product API

This project is a practice playground for **API development** and **automated testing** in Laravel.  
It focuses on building and testing a simple **Product CRUD API** with proper validation, structured responses, and test coverage.

---

## 🎯 Purpose

- Build a real-world style **mini-ecommerce API** to gain practical experience.  
- Practice developing **RESTful APIs** in Laravel.  
- Apply **TDD (Test Driven Development)** concepts.  
- Strengthen **debugging, validation, and error handling** skills.  
- implement **Unit Testing** and **Feature Testing** using Laravel’s testing tools.  
- Experiment with **factories**, **seeders**, and **database testing**.   

---

## ⚡ Features

### ✅ Product Module
- CRUD operations (create, read, update, delete).  
- Validations for product fields (name, price, stock, etc.).  
- API Resource for consistent JSON response.  

### 📂 Category Module
- Assign categories to products.  
- Manage product categories (CRUD).  
- Relationship: **Product belongsTo Category**, **Category hasMany Products**.  

### 🏷️ Tag Module
- Attach multiple tags to products.  
- Relationship: **Many-to-Many** between Product and Tag.  
- Sync/Detach tags via API.  

### 🔄 Variations Module
- Define product variations (e.g., size, color).  
- Relationship: **Product hasMany Variations**.  
- Variation-level pricing or attributes.  

### 🧪 Testing
- **Unit Tests** → Models & relationships.  
- **Feature Tests** → API endpoints with request/response assertions.  
- Use of **factories** & **RefreshDatabase** for isolated tests.  
- Covers both **success** and **failure** scenarios.  

---

## 📂 Project Structure

