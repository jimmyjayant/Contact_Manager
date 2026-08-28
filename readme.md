# Contact Manager

A fully responsive **Contact Manager** web application that provides a single, organized place to store and manage contacts.

The application offers an easy-to-use and friendly interface where logged-in users can **search, add, edit, delete, filter, and view** their contacts efficiently.

---

## 🚀 Features

* 🔐 User registration and login
* 👤 Manage contacts for logged-in users
* ➕ Add new contacts
* ✏️ Edit existing contacts
* 🗑️ Delete contacts
* 🔍 Search contacts
* 🔎 Filter contacts
* 👁️ View contact details
* 📝 Support for additional contact fields
* 📩 Feedback functionality
* 📱 Fully responsive user interface
* ⚡ AJAX-based operations
* 🗄️ MySQL database integration
* 🏗️ Custom PHP MVC framework

---

## 🛠️ Technologies Used

The project is developed using the following technologies:

| Technology                   | Purpose                       |
| ---------------------------- | ----------------------------- |
| **HTML5**                    | Website structure             |
| **CSS3**                     | Styling and responsive design |
| **Vanilla JavaScript**       | Client-side functionality     |
| **PHP 8.0+**                 | Backend development           |
| **AJAX**                     | Asynchronous requests         |
| **SQL**                      | Database queries              |
| **MySQL**                    | Database management           |
| **Custom PHP MVC Framework** | Application architecture      |

---

## 🔧 Development Tools

The following tools are used during development:

* [Visual Studio Code](https://code.visualstudio.com/)
* Git
* GitHub
* XAMPP

---

# 📋 Requirements

Before running the project, make sure the following software is installed:

* **PHP 8.0 or higher**
* **MySQL**
* **Apache Web Server**
* **XAMPP**
* **Git**

---

# 📥 Installation & Setup

Follow the steps below to run the Contact Manager application successfully on your local machine.

## 1. Clone the Repository

Clone the project from GitHub and place the project inside the XAMPP `htdocs` directory.

For example:

```text
C:\xampp\htdocs\Contact_Manager
```

Then open the project using your preferred code editor, such as Visual Studio Code.

---

## 2. Start XAMPP

Open the **XAMPP Control Panel**.

Make sure the following services are running:

* **Apache**
* **MySQL**

Both services should show a running status.

---

## 3. Open phpMyAdmin

Open your web browser and navigate to:

```text
http://localhost/phpmyadmin
```

Once the phpMyAdmin dashboard appears, click on the **Databases** option in the top menu.

---

# 🗄️ Database Setup

## 4. Create the Database

In the **Create Database** section:

1. Enter the following database name:

```text
contact_manager_db
```

2. Click the **Create** button.

The `contact_manager_db` database will now be created.

---

## 5. Create the `user` Table

Select the newly created `contact_manager_db` database from the left sidebar.

Click the **SQL** button in the top menu.

Paste and execute the following SQL query:

```sql
CREATE TABLE IF NOT EXISTS user(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(200) NOT NULL,
    lastname VARCHAR(200) NOT NULL,
    email VARCHAR(200) NOT NULL UNIQUE,
    user_password VARCHAR(255) NOT NULL,
    contact INT(10) NOT NULL,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    token VARCHAR(100) NULL UNIQUE
);
```

Click **Go** to execute the query.

After successful execution, a table named `user` will appear inside the `contact_manager_db` database.

---

## 6. Create the `contacts` Table

Again, click the **SQL** button in the top menu and execute:

```sql
CREATE TABLE IF NOT EXISTS contacts(
    user_id INT(6) UNSIGNED,
    FOREIGN KEY(user_id) REFERENCES user(id) ON DELETE CASCADE,
    form_number INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    middle_name VARCHAR(255),
    last_name VARCHAR(255),
    nickname VARCHAR(100),
    gender ENUM('male', 'female'),
    mobile_number VARCHAR(100) NULL UNIQUE,
    landline_number VARCHAR(100) NULL UNIQUE,
    addr VARCHAR(255),
    relationship VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

Click **Go** to execute the query.

After successful execution, the `contacts` table will be created.

---

## 7. Create the `additional_fields` Table

Click the **SQL** button again and execute:

```sql
CREATE TABLE IF NOT EXISTS additional_fields(
    userID INT(6) UNSIGNED,
    FOREIGN KEY(userID) REFERENCES user(id) ON DELETE CASCADE,
    form_no INT(6) UNSIGNED,
    FOREIGN KEY(form_no) REFERENCES contacts(form_number) ON DELETE CASCADE,
    field_name VARCHAR(255) NOT NULL,
    field_value VARCHAR(255) NOT NULL
);
```

Click **Go** to execute the query.

After successful execution, the `additional_fields` table will be created.

---

## 8. Create the `feedback` Table

Click the **SQL** button once again and execute:

```sql
CREATE TABLE IF NOT EXISTS feedback(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(200) NOT NULL,
    lastname VARCHAR(200) NOT NULL,
    contact INT(10) NOT NULL,
    email VARCHAR(200) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    msg VARCHAR(255) NOT NULL,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

Click **Go** to execute the query.

After successful execution, the `feedback` table will be created.

---

# 📊 Database Structure

After completing the above steps, the `contact_manager_db` database should contain the following four tables:

```text
contact_manager_db
│
├── user
├── contacts
├── additional_fields
└── feedback
```

### Table Overview

| Table               | Description                                  |
| ------------------- | -------------------------------------------- |
| `user`              | Stores registered user information           |
| `contacts`          | Stores contacts belonging to users           |
| `additional_fields` | Stores additional/custom fields for contacts |
| `feedback`          | Stores feedback submitted by users           |

---

# 🔐 Database Configuration

By default, the project assumes the following MySQL credentials:

```text
Username: root
Password: 
```

In other words, the default MySQL username is `root` and the password is empty.

If you are using different MySQL credentials, update them in:

```text
app/Config/Database_Connection.php
```

Make sure the database name is also configured correctly:

```text
contact_manager_db
```

---

# ▶️ Running the Application

After completing the database configuration:

1. Make sure **Apache** and **MySQL** are running in XAMPP.
2. Make sure the project is located inside the XAMPP `htdocs` directory.
3. Verify that the database and all four tables have been created.
4. Verify the database credentials in:

```text
app/Config/Database_Connection.php
```

5. Open your browser and navigate to your project's localhost URL.

For example, if your project directory is:

```text
C:\xampp\htdocs\Contact_Manager
```

you can access it at:

```text
http://localhost/Contact_Manager/
```

> **Note:** Replace `Contact_Manager` with the actual name of the project directory if it is different.

---

# 📁 Project Architecture

The project follows a **custom PHP MVC architecture**, separating application logic into appropriate components.

A typical structure includes:

```text
project-root/
│
├── app/
│   ├── Config/
│   │   └── Database_Connection.php
|   |   |-- Routes.php
│   └── Controllers/
|   |-- Database/
|       |-- create_additional_fields_table.php
|       |-- create_contacts_table.php
|       |-- create_feedback_table.php
|       |-- create_user_table.php
|   |-- Filters/
|       |-- validationFilters.php
|   |-- Helpers/
|       |-- sanitize_input_helper.php
|   |-- Models/
|       |-- add_user_contact.php
|       |-- change_user_password.php
|       |-- delete_user_contact.php
|       |-- edit_user_contact.php
|       |-- filter_user_contact.php
|       |-- get_additional_fields.php
|       |-- get_particular_user_contact_data.php
|       |-- get_user_contacts.php
|       |-- get_user_data.php
|       |-- provide_feedback.php
|       |-- register_user_data.php
|       |-- search_user_contacts.php
|    |-- Views/
|       |-- 404.php
|             |
|             |
|       |-- sitemap.php
|-- public/
|       |-- index.php (Front Controller)
|       |-- css/
|       |-- images/
|       |-- script/
|       |-- .htaccess
│-- writable/
|       |-- cache/
|       |-- logs/
|       |-- uploads/
├── .gitignore
|-- .htaccess
│
└── README.md
```

The exact directory structure may vary depending on the current version of the repository.

---

# 🔄 Application Workflow

The general application workflow is:

```text
User
 │
 ▼
Registration / Login
 │
 ▼
Authenticated User
 │
 ▼
Contact Manager
 │
 ├── Add Contact
 ├── View Contacts
 ├── Search Contacts
 ├── Filter Contacts
 ├── Edit Contact
 └── Delete Contact
```

---

# 📱 Responsive Design

The Contact Manager interface is designed to be **fully responsive**, allowing users to access and manage their contacts across different screen sizes and devices.

---

# 🔒 Security Note

For local development, the default MySQL credentials may be:

```text
Username: root
Password: 
```

For production environments, it is strongly recommended to:

* Use a dedicated database user.
* Set a strong database password.
* Avoid exposing database credentials in publicly accessible files.
* Configure the application using appropriate environment-specific settings.
* Use HTTPS.
* Follow secure password-storage and input-validation practices.

---

# 🐛 Troubleshooting

### Apache is not starting

Make sure another application is not already using ports such as `80` or `443`.

### MySQL is not starting

Check whether another MySQL/MariaDB service is already running and occupying the required port.

### Database connection error

Verify the credentials and database name in:

```text
app/Config/Database_Connection.php
```

Default database:

```text
contact_manager_db
```

Default username:

```text
root
```

Default password:

```text
(empty)
```

### Page not found

Make sure the project is placed inside:

```text
C:\xampp\htdocs\
```

and access it using the correct localhost URL.

---

# 👨‍💻 Development

This project can be developed locally using:

* Visual Studio Code
* XAMPP
* Git
* GitHub

To check the PHP version installed on your machine:

```bash
php -v
```

---

# 📄 License

```text
This project is licensed under the MIT License.
```

---

# 🙌 Acknowledgements

Thanks for checking out **Contact Manager**.

The project was built to provide a simple, organized, and user-friendly solution for storing and managing personal contacts in one place.
