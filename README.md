# Book API Documentation

## Overview

The Book Management API provides a set of endpoints to manage books in a system. It allows users to create, retrieve, update, and delete book records efficiently. 

## Base URL

The base URL for the API is: https://book-api-dzuuras-projects.vercel.app/api/api/
<br>
Or if you are using localhost: [http:localhost:8000/api/](http:localhost:8000/api/)


## Endpoints

### 1. Create Book

- **Endpoint:** `/books`
- **Method:** `POST`
- **Description:** Create a new book.
- **Response:**
  - **Status Code:** 201 Created
  - **Response Body:** JSON object of the created book.

#### Example Request
```json
{
  "title": "5 Minute to Learn Go",
  "author": "Sundar Pichai",
  "year": "2023-10-25"
}
```

#### Example Response
```json
{
  "id": 1,
  "title": "5 Minute to Learn Go",
  "author": "Sundar Pichai",
  "year": "2023-10-25"
}
```

### 2. Read Book

- **Endpoint:** `/books`
- **Method:** `GET`
- **Description:** Retrieve a list of all books.
- **Response:**
  - **Status Code:** 200
  - **Response Body:** JSON array of books.

#### Example Request
```curl
'https://book-api-dzuuras-projects.vercel.app/api/api/books'
```

#### Example Response
```json
{
  "id": 1,
  "title": "Book Title",
  "author": "Author Name",
  "year": 2023
},
{
  "id": 2,
  "title": "Another Book",
  "author": "Another Author",
  "year": 2022
}
```

### 3. Read Single Book

- **Endpoint:** `/books/{id}`
- **Method:** `GET`
- **Description:** Retrieve a specific of books.
- **Response:**
  - **Status Code:** 200
  - **Response Body:** JSON object of book.

#### Example Request
```curl
curl --location --request GET 'https://book-api-dzuuras-projects.vercel.app/api/api/books/1'
```

#### Example Response
```json
{
  "id": 1,
  "title": "5 Minute to Learn Go",
  "author": "Sundar Pichai",
  "year": "2023-10-25"
}
```

### 4. Update Book

- **Endpoint:** `/books/{id}`
- **Method:** `PUT`
- **Description:** Update an existing book by ID.
- **Response:**
  - **Status Code:** 200
  - **Response Body:** JSON object of the updated book.

#### Example Request
```json
{
  "title": "Updated Book Title",
  "author": "Updated Author Name",
  "year": 2024
}
```

#### Example Response
```json
{
  "id": 1,
  "title": "Updated Book Title",
  "author": "Updated Author Name",
  "year": 2024
}
```

### 5. Delete Book

- **Endpoint:** `/books/{id}`
- **Method:** `DELETE`
- **Description:** Delete a book by ID.
- **Response:**
  - **Status Code:** 200
  - **Response Body:** Confirmation message.

#### Example Request
```curl
curl --location --request DELETE 'https://book-api-dzuuras-projects.vercel.app/api/api/books/1'
```

#### Example Response
```json
{
  "message": "Book deleted successfully."
}
```

### 6. Not Found Book

- **Endpoint:** `/books/{id}`
- **Method:** `GET`
- **Description:** Attempt to retrieve a book that does not exist.
- **Response:**
  - **Status Code:** 404 Not Found
  - **Response Body:** Error message with required fields.

#### Example Request
```curl
curl --location --request GET 'https://book-api-dzuuras-projects.vercel.app/api/api/books/8'
```

#### Example Response
```json
{
  "error": {
    "message": "Book not found.",
    "status": 404
  }
}
```
