# 📚 REST API Documentation — Utero Group

> **Base URL:** `https://api.uterogroup.com/api/v1`
> **Version:** v1
> **Format:** JSON (`Content-Type: application/json`)
> **Last Updated:** 28 Juli 2026

---

## 📑 Table of Contents

1. [Overview](#1-overview)
2. [Authentication](#2-authentication)
3. [Rate Limiting](#3-rate-limiting)
4. [Error Handling](#4-error-handling)
5. [Pagination](#5-pagination)
6. [Endpoints — Products](#6-endpoints--products)
7. [Endpoints — News](#7-endpoints--news)
8. [Endpoints — Gallery](#8-endpoints--gallery)
9. [Endpoints — Testimonials](#9-endpoints--testimonials)
10. [Endpoints — Pages](#10-endpoints--pages)
11. [Endpoints — Orders](#11-endpoints--orders)
12. [Endpoints — Contact](#12-endpoints--contact)
13. [Endpoints — Authentication](#13-endpoints--authentication)
14. [Data Models](#14-data-models)
15. [Example Responses](#15-example-responses)

---

## 1. Overview

The Utero Group REST API provides programmatic access to website data including products, news, gallery, testimonials, and static pages. It also supports order submission and contact form functionality.

### Key Features

- **RESTful design** — resource-oriented endpoints with standard HTTP methods
- **JSON responses** — all responses return JSON with consistent structure
- **Pagination** — all list endpoints support paginated responses
- **Token authentication** — Laravel Sanctum for protected endpoints
- **Rate limiting** — automatic throttling to prevent abuse
- **API versioning** — all endpoints prefixed with `/v1` for future compatibility

### Requirements

- HTTP client capable of making HTTPS requests
- `Accept: application/json` header (recommended for all requests)
- For write endpoints: `Content-Type: application/json` header
- For protected endpoints: `Authorization: Bearer {token}` header

---

## 2. Authentication

The API uses **Laravel Sanctum** for token-based authentication. Public endpoints require no authentication. Protected endpoints require a valid token in the `Authorization` header.

### Public Endpoints (No Auth Required)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/products` | List products |
| GET | `/products/categories` | List product categories |
| GET | `/products/{slug}` | Show product detail |
| GET | `/news` | List news articles |
| GET | `/news/{slug}` | Show news detail |
| GET | `/gallery` | List gallery albums |
| GET | `/gallery/photos/{slug}` | Show album photos |
| GET | `/gallery/videos` | List videos |
| GET | `/gallery/audios` | List audio |
| GET | `/testimonials` | List testimonials |
| POST | `/testimonials` | Submit testimonial |
| GET | `/pages` | List static pages |
| GET | `/pages/{slug}` | Show page detail |
| POST | `/orders` | Submit order |
| POST | `/contact` | Submit contact message |

### Protected Endpoints (Auth Required)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/user` | Get authenticated user profile |
| POST | `/logout` | Revoke current access token |

### How to Get a Token

```http
POST /api/v1/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "your-password",
  "device_name": "mobile-app"
}
```

**Response:**
```json
{
  "token": "1|abc123xyz...",
  "user": {
    "id": 1,
    "name": "Admin User",
    "email": "user@example.com",
    "role": "admin"
  }
}
```

### Using the Token

Include the token in the `Authorization` header for all protected requests:

```http
GET /api/v1/user
Authorization: Bearer 1|abc123xyz...
Accept: application/json
```

---

## 3. Rate Limiting

The API applies rate limiting to prevent abuse:

| Endpoint Type | Limit | Window |
|---------------|-------|--------|
| General API (all endpoints) | 60 requests | 1 minute |
| Write endpoints (orders, contact) | 10 requests | 1 minute |

When rate limited, the API returns:

```json
{
  "message": "Too Many Requests."
}
```

**Status Code:** `429 Too Many Requests`

**Headers:**
- `X-RateLimit-Limit` — Maximum requests allowed
- `X-RateLimit-Remaining` — Requests remaining in window
- `X-RateLimit-Reset` — Time until window resets (Unix timestamp)

---

## 4. Error Handling

The API uses standard HTTP status codes and returns consistent error responses.

### Status Codes

| Code | Description |
|------|-------------|
| `200` | Success |
| `201` | Created (POST success) |
| `400` | Bad Request (invalid parameters) |
| `404` | Not Found (resource doesn't exist) |
| `422` | Unprocessable Entity (validation error) |
| `429` | Too Many Requests (rate limited) |
| `500` | Internal Server Error |

### Error Response Format

**Validation Error (422):**
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "name": ["The name field is required."],
    "email": ["The email must be a valid email address."]
  }
}
```

**Not Found Error (404):**
```json
{
  "message": "Product not found"
}
```

**General Error:**
```json
{
  "message": "Error description here"
}
```

---

## 5. Pagination

All list endpoints return paginated results. The response includes pagination metadata.

### Query Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `per_page` | integer | varies | Items per page (min: 1, max: 50) |
| `page` | integer | 1 | Page number |

### Pagination Response Format

```json
{
  "data": [...],
  "links": {
    "first": "https://api.uterogroup.com/api/v1/products?page=1",
    "last": "https://api.uterogroup.com/api/v1/products?page=5",
    "prev": null,
    "next": "https://api.uterogroup.com/api/v1/products?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 5,
    "path": "https://api.uterogroup.com/api/v1/products",
    "per_page": 12,
    "to": 12,
    "total": 52
  }
}
```

---

## 6. Endpoints — Products

### List Products

```http
GET /api/v1/products
```

**Query Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `category` | string | Filter by category slug |
| `search` | string | Search by product name |
| `promo` | boolean | Filter promo products only (`true`/`1`) |
| `per_page` | integer | Items per page (1-50, default: 12) |
| `page` | integer | Page number (default: 1) |

**Example Request:**
```bash
curl "https://api.uterogroup.com/api/v1/products?category=spanduk&per_page=5"
```

**Response (200):**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Spanduk Vinyl 440gsm",
      "slug": "spanduk-vinyl-440gsm",
      "image": "products/spanduk.jpg",
      "size": "100x50 cm",
      "thickness": "440gsm",
      "min_order": 10,
      "unit_price": 25000,
      "description": "Spanduk vinyl berkualitas tinggi...",
      "is_promo": false,
      "category": {
        "id": 1,
        "name": "Spanduk",
        "slug": "spanduk",
        "description": "Berbagai jenis spanduk",
        "products_count": 12
      },
      "images": [
        {
          "id": 1,
          "filename": "spanduk-vinyl.jpg",
          "path": "products/spanduk-vinyl.jpg",
          "is_thumbnail": true
        }
      ],
      "created_at": "2026-07-28T10:00:00.000000Z",
      "updated_at": "2026-07-28T10:00:00.000000Z"
    }
  ],
  "links": {
    "first": "https://api.uterogroup.com/api/v1/products?page=1",
    "last": "https://api.uterogroup.com/api/v1/products?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "path": "https://api.uterogroup.com/api/v1/products",
    "per_page": 5,
    "to": 5,
    "total": 5
  }
}
```

### List Product Categories

```http
GET /api/v1/products/categories
```

**Response (200):**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Spanduk",
      "slug": "spanduk",
      "description": "Berbagai jenis spanduk",
      "products_count": 12
    },
    {
      "id": 2,
      "name": "Banner",
      "slug": "banner",
      "description": "Banner indoor & outdoor",
      "products_count": 8
    }
  ]
}
```

### Show Product

```http
GET /api/v1/products/{slug}
```

**Path Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `slug` | string | Product slug |

**Example Request:**
```bash
curl "https://api.uterogroup.com/api/v1/products/spanduk-vinyl-440gsm"
```

**Response (200):**
```json
{
  "data": {
    "id": 1,
    "name": "Spanduk Vinyl 440gsm",
    "slug": "spanduk-vinyl-440gsm",
    "image": "products/spanduk.jpg",
    "size": "100x50 cm",
    "thickness": "440gsm",
    "min_order": 10,
    "unit_price": 25000,
    "description": "Spanduk vinyl berkualitas tinggi untuk kebutuhan outdoor dan indoor.",
    "is_promo": false,
    "category": {
      "id": 1,
      "name": "Spanduk",
      "slug": "spanduk",
      "description": "Berbagai jenis spanduk",
      "products_count": 12
    },
    "images": [
      {
        "id": 1,
        "filename": "spanduk-vinyl.jpg",
        "path": "products/spanduk-vinyl.jpg",
        "is_thumbnail": true
      },
      {
        "id": 2,
        "filename": "spanduk-vinyl-2.jpg",
        "path": "products/spanduk-vinyl-2.jpg",
        "is_thumbnail": false
      }
    ],
    "created_at": "2026-07-28T10:00:00.000000Z",
    "updated_at": "2026-07-28T10:00:00.000000Z"
  }
}
```

**Response (404):**
```json
{
  "message": "Product not found"
}
```

---

## 7. Endpoints — News

### List News

```http
GET /api/v1/news
```

**Query Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `search` | string | Search by title |
| `per_page` | integer | Items per page (1-50, default: 9) |
| `page` | integer | Page number (default: 1) |

**Example Request:**
```bash
curl "https://api.uterogroup.com/api/v1/news?per_page=5"
```

**Response (200):**
```json
{
  "data": [
    {
      "id": 1,
      "title": "Tips Memilih Spanduk yang Tepat",
      "slug": "tips-memilih-spanduk-yang-tepat",
      "excerpt": "Memilih spanduk yang tepat untuk bisnis Anda...",
      "content": "<p>Berikut adalah tips memilih spanduk...</p>",
      "image": "news/spanduk-tips.jpg",
      "published_at": "2026-07-28T08:00:00.000000Z",
      "created_at": "2026-07-28T08:00:00.000000Z",
      "updated_at": "2026-07-28T08:00:00.000000Z"
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

### Show News

```http
GET /api/v1/news/{slug}
```

**Response (200):**
```json
{
  "data": {
    "id": 1,
    "title": "Tips Memilih Spanduk yang Tepat",
    "slug": "tips-memilih-spanduk-yang-tepat",
    "excerpt": "Memilih spanduk yang tepat untuk bisnis Anda...",
    "content": "<p>Berikut adalah tips memilih spanduk yang tepat untuk kebutuhan bisnis Anda. Spanduk merupakan salah satu media promosi yang efektif...</p>",
    "image": "news/spanduk-tips.jpg",
    "published_at": "2026-07-28T08:00:00.000000Z",
    "created_at": "2026-07-28T08:00:00.000000Z",
    "updated_at": "2026-07-28T08:00:00.000000Z"
  }
}
```

---

## 8. Endpoints — Gallery

### List Albums

```http
GET /api/v1/gallery
```

**Query Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `per_page` | integer | Items per page (1-50, default: 12) |
| `page` | integer | Page number (default: 1) |

**Response (200):**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Proyek Billboard Malang",
      "slug": "proyek-billboard-malang",
      "description": "Galeri proyek billboard di kota Malang",
      "category": {
        "id": 1,
        "name": "Outdoor",
        "slug": "outdoor",
        "description": "Proyek outdoor advertising"
      },
      "photos": [
        {
          "id": 1,
          "filename": "billboard-1.jpg",
          "caption": "Billboard Jl. Sudirman"
        }
      ],
      "videos": [],
      "audios": [],
      "photos_count": 5,
      "created_at": "2026-07-28T08:00:00.000000Z",
      "updated_at": "2026-07-28T08:00:00.000000Z"
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

### Show Album Photos

```http
GET /api/v1/gallery/photos/{slug}
```

**Response (200):**
```json
{
  "data": {
    "id": 1,
    "name": "Proyek Billboard Malang",
    "slug": "proyek-billboard-malang",
    "description": "Galeri proyek billboard di kota Malang",
    "category": {
      "id": 1,
      "name": "Outdoor",
      "slug": "outdoor",
      "description": "Proyek outdoor advertising"
    },
    "photos": [
      {
        "id": 1,
        "filename": "billboard-1.jpg",
        "caption": "Billboard Jl. Sudirman",
        "created_at": "2026-07-28T08:00:00.000000Z"
      },
      {
        "id": 2,
        "filename": "billboard-2.jpg",
        "caption": "Billboard Jl. Veteran",
        "created_at": "2026-07-28T08:00:00.000000Z"
      }
    ],
    "videos": [],
    "audios": [],
    "photos_count": 5,
    "created_at": "2026-07-28T08:00:00.000000Z",
    "updated_at": "2026-07-28T08:00:00.000000Z"
  }
}
```

### List Videos

```http
GET /api/v1/gallery/videos
```

**Response (200):**
```json
{
  "data": [
    {
      "id": 1,
      "title": "Proses Cetak Spanduk",
      "slug": "proses-cetak-spanduk",
      "url": "https://youtube.com/watch?v=abc123",
      "youtube_id": "abc123",
      "description": "Video proses cetak spanduk di workshop kami",
      "created_at": "2026-07-28T08:00:00.000000Z"
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

### List Audio

```http
GET /api/v1/gallery/audios
```

**Response (200):**
```json
{
  "data": [
    {
      "id": 1,
      "title": "Jingle Utero Group",
      "slug": "jingle-utero-group",
      "filename": "audio/jingle.mp3",
      "description": "Jingle resmi Utero Group",
      "created_at": "2026-07-28T08:00:00.000000Z"
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

---

## 9. Endpoints — Testimonials

### List Testimonials

```http
GET /api/v1/testimonials
```

**Query Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `per_page` | integer | Items per page (1-50, default: 10) |
| `page` | integer | Page number (default: 1) |

**Response (200):**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Budi Santoso",
      "company": "PT. Maju Jaya",
      "content": "Pelayanan sangat memuaskan! Spanduk yang dihasilkan berkualitas tinggi.",
      "rating": 5,
      "status": "approved",
      "created_at": "2026-07-20T10:00:00.000000Z"
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

### Submit Testimonial

```http
POST /api/v1/testimonials
```

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `name` | string | ✅ | Your name |
| `email` | string | ✅ | Your email |
| `company` | string | ❌ | Company name |
| `content` | string | ✅ | Testimonial content |
| `rating` | integer | ✅ | Rating (1-5) |

**Example Request:**
```bash
curl -X POST "https://api.uterogroup.com/api/v1/testimonials" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Budi Santoso",
    "email": "budi@example.com",
    "company": "PT. Maju Jaya",
    "content": "Pelayanan sangat memuaskan!",
    "rating": 5
  }'
```

**Response (201):**
```json
{
  "message": "Testimonial submitted successfully. It will be visible after approval.",
  "data": {
    "id": 1,
    "name": "Budi Santoso",
    "company": "PT. Maju Jaya",
    "content": "Pelayanan sangat memuaskan!",
    "rating": 5,
    "status": "pending",
    "created_at": "2026-07-28T10:00:00.000000Z"
  }
}
```

**Validation Error (422):**
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "name": ["The name field is required."],
    "email": ["The email must be a valid email address."],
    "rating": ["The rating must be at least 1."]
  }
}
```

---

## 10. Endpoints — Pages

### List Pages

```http
GET /api/v1/pages
```

**Response (200):**
```json
{
  "data": [
    {
      "id": 1,
      "title": "Tentang Kami",
      "slug": "tentang-kami",
      "content": "<p>PT. Utero Kreatif Indonesia adalah perusahaan...</p>",
      "image": "pages/about.jpg",
      "created_at": "2026-07-28T08:00:00.000000Z",
      "updated_at": "2026-07-28T08:00:00.000000Z"
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

### Show Page

```http
GET /api/v1/pages/{slug}
```

**Response (200):**
```json
{
  "data": {
    "id": 1,
    "title": "Tentang Kami",
    "slug": "tentang-kami",
    "content": "<p>PT. Utero Kreatif Indonesia (Rumah Merah OXYZ) adalah perusahaan periklanan, digital printing, dan creative agency yang berbasis di Malang, Jawa Timur.</p>",
    "image": "pages/about.jpg",
    "created_at": "2026-07-28T08:00:00.000000Z",
    "updated_at": "2026-07-28T08:00:00.000000Z"
  }
}
```

---

## 11. Endpoints — Orders

### Submit Order

```http
POST /api/v1/orders
```

**Rate Limit:** 10 requests per minute

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `name` | string | ✅ | Customer name |
| `email` | string | ✅ | Customer email |
| `phone` | string | ✅ | Phone number |
| `address` | string | ✅ | Delivery address |
| `city` | string | ✅ | City |
| `postal_code` | string | ❌ | Postal code |
| `message` | string | ❌ | Additional message |
| `items` | array | ✅ | Order items (min: 1) |
| `items[].product_id` | integer | ❌ | Product ID (if available) |
| `items[].product_name` | string | ✅ | Product name |
| `items[].quantity` | integer | ✅ | Quantity (min: 1) |

**Example Request:**
```bash
curl -X POST "https://api.uterogroup.com/api/v1/orders" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Budi Santoso",
    "email": "budi@example.com",
    "phone": "081234567890",
    "address": "Jl. Merdeka No. 123",
    "city": "Malang",
    "postal_code": "65141",
    "message": "Mohon urgent ya",
    "items": [
      {
        "product_id": 1,
        "product_name": "Spanduk Vinyl 440gsm",
        "quantity": 10
      },
      {
        "product_name": "Banner Custom 1x2m",
        "quantity": 5
      }
    ]
  }'
```

**Response (201):**
```json
{
  "message": "Order submitted successfully.",
  "data": {
    "id": 1,
    "status": "pending",
    "created_at": "2026-07-28T10:00:00.000000Z"
  }
}
```

**Side Effects:**
- Confirmation email sent to customer
- Notification email sent to admin
- WhatsApp notification sent to admin

**Validation Error (422):**
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "name": ["The name field is required."],
    "phone": ["The phone field is required."],
    "items": ["The items field must have at least 1 items."],
    "items.0.product_id": ["The selected product id is invalid."]
  }
}
```

---

## 12. Endpoints — Contact

### Submit Contact Message

```http
POST /api/v1/contact
```

**Rate Limit:** 10 requests per minute

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `name` | string | ✅ | Your name |
| `email` | string | ✅ | Your email |
| `phone` | string | ❌ | Phone number |
| `subject` | string | ✅ | Message subject |
| `message` | string | ✅ | Message content |

**Example Request:**
```bash
curl -X POST "https://api.uterogroup.com/api/v1/contact" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Budi Santoso",
    "email": "budi@example.com",
    "phone": "081234567890",
    "subject": "Konsultasi Desain",
    "message": "Saya ingin berkonsultasi tentang desain spanduk untuk event."
  }'
```

**Response (201):**
```json
{
  "message": "Message sent successfully. We will respond shortly."
}
```

**Side Effects:**
- Contact message email sent to admin

---

## 13. Endpoints — Authentication

### Login

```http
POST /api/v1/login
```

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `email` | string | ✅ | User email |
| `password` | string | ✅ | User password |
| `device_name` | string | ✅ | Device identifier (e.g., "mobile-app", "web-client") |

**Example Request:**
```bash
curl -X POST "https://api.uterogroup.com/api/v1/login" \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@uterogroup.com",
    "password": "secret-password",
    "device_name": "web-client"
  }'
```

**Response (200):**
```json
{
  "token": "1|abc123xyzDEF456...",
  "user": {
    "id": 1,
    "name": "Admin User",
    "email": "admin@uterogroup.com",
    "role": "admin"
  }
}
```

**Error Response (422):**
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The provided credentials are incorrect."]
  }
}
```

### Get User Profile

```http
GET /api/v1/user
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "data": {
    "id": 1,
    "name": "Admin User",
    "email": "admin@uterogroup.com",
    "role": "admin"
  }
}
```

### Logout

```http
POST /api/v1/logout
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "message": "Logged out successfully."
}
```

---

## 14. Data Models

### Product

| Field | Type | Description |
|-------|------|-------------|
| `id` | integer | Unique identifier |
| `name` | string | Product name |
| `slug` | string | URL-friendly identifier |
| `image` | string | Main image path |
| `size` | string | Product size |
| `thickness` | string | Material thickness |
| `min_order` | integer | Minimum order quantity |
| `unit_price` | integer | Price per unit (Rp) |
| `description` | string | Product description (HTML) |
| `is_promo` | boolean | Whether product is on promo |
| `category` | object | Product category (nested) |
| `images` | array | Product images (nested) |
| `created_at` | datetime | Creation timestamp |
| `updated_at` | datetime | Last update timestamp |

### ProductCategory

| Field | Type | Description |
|-------|------|-------------|
| `id` | integer | Unique identifier |
| `name` | string | Category name |
| `slug` | string | URL-friendly identifier |
| `description` | string | Category description |
| `products_count` | integer | Number of products in category |

### ProductImage

| Field | Type | Description |
|-------|------|-------------|
| `id` | integer | Unique identifier |
| `filename` | string | Image filename |
| `path` | string | Image file path |
| `is_thumbnail` | boolean | Whether image is thumbnail |

### News

| Field | Type | Description |
|-------|------|-------------|
| `id` | integer | Unique identifier |
| `title` | string | Article title |
| `slug` | string | URL-friendly identifier |
| `excerpt` | string | Short excerpt |
| `content` | string | Full content (HTML) |
| `image` | string | Featured image path |
| `published_at` | datetime | Publication timestamp |
| `created_at` | datetime | Creation timestamp |
| `updated_at` | datetime | Last update timestamp |

### Album

| Field | Type | Description |
|-------|------|-------------|
| `id` | integer | Unique identifier |
| `name` | string | Album name |
| `slug` | string | URL-friendly identifier |
| `description` | string | Album description |
| `category` | object | Album category (nested) |
| `photos` | array | Album photos (nested) |
| `videos` | array | Album videos (nested) |
| `audios` | array | Album audios (nested) |
| `photos_count` | integer | Number of photos |
| `created_at` | datetime | Creation timestamp |
| `updated_at` | datetime | Last update timestamp |

### AlbumPhoto

| Field | Type | Description |
|-------|------|-------------|
| `id` | integer | Unique identifier |
| `filename` | string | Photo filename |
| `caption` | string | Photo caption |
| `created_at` | datetime | Creation timestamp |

### AlbumVideo

| Field | Type | Description |
|-------|------|-------------|
| `id` | integer | Unique identifier |
| `title` | string | Video title |
| `slug` | string | URL-friendly identifier |
| `url` | string | Video URL (YouTube) |
| `youtube_id` | string | YouTube video ID |
| `description` | string | Video description |
| `created_at` | datetime | Creation timestamp |

### AlbumAudio

| Field | Type | Description |
|-------|------|-------------|
| `id` | integer | Unique identifier |
| `title` | string | Audio title |
| `slug` | string | URL-friendly identifier |
| `filename` | string | Audio file path |
| `description` | string | Audio description |
| `created_at` | datetime | Creation timestamp |

### Testimonial

| Field | Type | Description |
|-------|------|-------------|
| `id` | integer | Unique identifier |
| `name` | string | Customer name |
| `company` | string | Company name |
| `content` | string | Testimonial content |
| `rating` | integer | Rating (1-5) |
| `status` | string | Status (`pending`, `approved`, `rejected`) |
| `created_at` | datetime | Creation timestamp |

### Page

| Field | Type | Description |
|-------|------|-------------|
| `id` | integer | Unique identifier |
| `title` | string | Page title |
| `slug` | string | URL-friendly identifier |
| `content` | string | Page content (HTML) |
| `image` | string | Featured image path |
| `created_at` | datetime | Creation timestamp |
| `updated_at` | datetime | Last update timestamp |

---

## 15. Example Responses

### Successful List Response

```json
{
  "data": [
    {
      "id": 1,
      "name": "Spanduk Vinyl 440gsm",
      "slug": "spanduk-vinyl-440gsm",
      "image": "products/spanduk.jpg",
      "size": "100x50 cm",
      "thickness": "440gsm",
      "min_order": 10,
      "unit_price": 25000,
      "description": "Spanduk vinyl berkualitas tinggi",
      "is_promo": false,
      "category": {
        "id": 1,
        "name": "Spanduk",
        "slug": "spanduk"
      },
      "images": [],
      "created_at": "2026-07-28T10:00:00.000000Z",
      "updated_at": "2026-07-28T10:00:00.000000Z"
    }
  ],
  "links": {
    "first": "https://api.uterogroup.com/api/v1/products?page=1",
    "last": "https://api.uterogroup.com/api/v1/products?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "path": "https://api.uterogroup.com/api/v1/products",
    "per_page": 12,
    "to": 1,
    "total": 1
  }
}
```

### Successful Single Resource Response

```json
{
  "data": {
    "id": 1,
    "title": "Tips Memilih Spanduk",
    "slug": "tips-memilih-spanduk",
    "excerpt": "Memilih spanduk yang tepat...",
    "content": "<p>Berikut adalah tips...</p>",
    "image": "news/tips.jpg",
    "published_at": "2026-07-28T08:00:00.000000Z",
    "created_at": "2026-07-28T08:00:00.000000Z",
    "updated_at": "2026-07-28T08:00:00.000000Z"
  }
}
```

### Validation Error Response

```json
{
  "message": "The given data was invalid.",
  "errors": {
    "name": ["The name field is required."],
    "email": ["The email must be a valid email address."],
    "rating": ["The rating must be between 1 and 5."]
  }
}
```

### Not Found Response

```json
{
  "message": "Product not found"
}
```

### Rate Limit Response

```json
{
  "message": "Too Many Requests."
}
```

---

## Quick Reference

### All Endpoints

| Method | Endpoint | Auth | Rate Limit | Description |
|--------|----------|------|------------|-------------|
| POST | `/login` | ❌ | 60/min | Get access token |
| POST | `/logout` | ✅ | 60/min | Revoke token |
| GET | `/user` | ✅ | 60/min | Get user profile |
| GET | `/products` | ❌ | 60/min | List products |
| GET | `/products/categories` | ❌ | 60/min | List categories |
| GET | `/products/{slug}` | ❌ | 60/min | Show product |
| GET | `/news` | ❌ | 60/min | List news |
| GET | `/news/{slug}` | ❌ | 60/min | Show news |
| GET | `/gallery` | ❌ | 60/min | List albums |
| GET | `/gallery/photos/{slug}` | ❌ | 60/min | Show album photos |
| GET | `/gallery/videos` | ❌ | 60/min | List videos |
| GET | `/gallery/audios` | ❌ | 60/min | List audio |
| GET | `/testimonials` | ❌ | 60/min | List testimonials |
| POST | `/testimonials` | ❌ | 60/min | Submit testimonial |
| GET | `/pages` | ❌ | 60/min | List pages |
| GET | `/pages/{slug}` | ❌ | 60/min | Show page |
| POST | `/orders` | ❌ | 10/min | Submit order |
| POST | `/contact` | ❌ | 10/min | Submit contact |

### Image URLs

All image paths returned by the API are relative to the storage disk. To construct the full URL:

```
https://uterogroup.com/storage/{path}
```

For example, if the API returns `"image": "products/spanduk.jpg"`, the full URL would be:
```
https://uterogroup.com/storage/products/spanduk.jpg
```

---

## Changelog

### v1.0.0 (28 Juli 2026)
- Initial API release
- Products, News, Gallery, Testimonials, Pages endpoints
- Order and Contact submission
- Token authentication via Sanctum
- Rate limiting

---

> **Utero Group REST API v1.0.0**
> Built with Laravel 10 + Sanctum
> © 2026 PT. Utero Kreatif Indonesia
