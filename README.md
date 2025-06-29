
# 📦 rawrear_ecommerce Database Schema

SimpleTrack CRM uses a MySQL database called **`rawrear_ecommerce`**. Below are the key tables, their fields, and SQL queries to create them.

---

## 🧑‍💼 Table: `customers`

| Field        | Type         | Description             |
|--------------|--------------|-------------------------|
| id           | int (PK)     | Auto-increment, Primary Key |
| name         | varchar(255) | Customer name           |
| email        | varchar(255) | Customer email          |
| phone        | varchar(20)  | Customer phone number   |
| timezone     | varchar(100) | Customer timezone       |
| created_at   | timestamp    | Record creation time    |
| created_by   | int          | User ID who created this customer |

```sql
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(20),
    timezone VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT
);
```

---

## 🛒 Table: `sales`

| Field        | Type         | Description                 |
|--------------|--------------|-----------------------------|
| id           | int (PK)     | Auto-increment, Primary Key |
| customer_id  | int          | Foreign Key (customers.id)  |
| product_name | varchar(255) | Name of the sold product    |
| amount       | decimal(10,2)| Sale amount                 |
| sale_date    | datetime     | Date of the sale            |
| notes        | text         | Optional sale notes         |
| created_by   | int          | User ID who created this sale |

```sql
CREATE TABLE sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    product_name VARCHAR(255),
    amount DECIMAL(10,2),
    sale_date DATETIME,
    notes TEXT,
    created_by INT,
    FOREIGN KEY (customer_id) REFERENCES customers(id)
);
```

---

## 📧 Table: `email_schedule`

| Field               | Type          | Description                       |
|---------------------|---------------|-----------------------------------|
| id                  | int (PK)      | Auto-increment, Primary Key       |
| customer_id         | int           | Foreign Key (customers.id)        |
| subject             | varchar(255)  | Email subject                     |
| body                | text          | Email body content                |
| scheduled_time_utc  | datetime      | Scheduled send time (UTC)         |
| sent                | tinyint(1)    | Sent status (0 = No, 1 = Yes)     |
| created_by          | int           | User ID who scheduled the email   |

```sql
CREATE TABLE email_schedule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    subject VARCHAR(255),
    body TEXT,
    scheduled_time_utc DATETIME,
    sent TINYINT(1) DEFAULT 0,
    created_by INT,
    FOREIGN KEY (customer_id) REFERENCES customers(id)
);
```

---

## 🔔 Table: `follow_ups`

| Field          | Type                           | Description                    |
|----------------|--------------------------------|--------------------------------|
| id             | int (PK)                       | Auto-increment, Primary Key    |
| customer_id    | int                            | Foreign Key (customers.id)     |
| follow_up_date | datetime                       | Follow-up date and time        |
| status         | enum('pending', 'done')        | Follow-up status               |
| notes          | text                           | Follow-up notes                |

```sql
CREATE TABLE follow_ups (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    follow_up_date DATETIME,
    status ENUM('pending', 'done') DEFAULT 'pending',
    notes TEXT,
    FOREIGN KEY (customer_id) REFERENCES customers(id)
);
```

---

## 👤 Table: `users`

| Field                     | Type          | Description                           |
|---------------------------|---------------|---------------------------------------|
| id                        | int (PK)      | Auto-increment, Primary Key           |
| name                      | varchar(255)  | User name                             |
| email                     | varchar(255)  | User email                            |
| password                  | varchar(255)  | Hashed user password                  |
| created_at                | timestamp     | Record creation time                  |
| role                      | varchar(50)   | User role (`user`, `admin`, etc.)     |
| email_verified            | tinyint(1)    | Email verification status (0/1)       |
| email_verification_token  | varchar(255)  | Token for email verification          |
| password_reset_token      | varchar(255)  | Token for password reset              |

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    role VARCHAR(50) NOT NULL DEFAULT 'user',
    email_verified TINYINT(1) DEFAULT 0,
    email_verification_token VARCHAR(255),
    password_reset_token VARCHAR(255)
);
```

---

**Note:** Foreign key constraints on `created_by` columns can be added if needed to reference the `users` table.
