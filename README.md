# YouDemy Courses Platform

## Configuration and Execution of the Project

### Prerequisites
- **Node.js** and **npm** installed ([Download Node.js](https://nodejs.org)).
- **Laragon** installed ([Download Laragon](https://laragon.org)).
- **PHP** installed and added to the system PATH.

---

### Installation Steps

#### 1. Clone the Project
Open a terminal and run the following command:
```bash
git clone https://github.com/Youcode-Classe-E-2024-2025/Hamza-Atig-Youdemy.git
```

#### 2. Place the Project in the Laragon Directory
- Click the **Root** button in Laragon to open the `www` folder (default: `C:\laragon\www`).
- Move the cloned project folder to this location. The project path should now be:
  ```
  C:\laragon\www\Hamza-Atig-Youdemy
  ```

#### 3. Configure the Database
- Right-click on Laragon, then go to **Tools > Quick Add** to download phpMyAdmin and MySQL.
- Open phpMyAdmin via Laragon:
  - Click the **Database** button in Laragon to access phpMyAdmin.
  - Use the following credentials:
    - Username: `root`
    - Password: (leave empty)
- Create a database named `youdemy_db`.
- Import the `script.sql` file located in the `/database/` folder of the project.

#### 4. Install Node.js Dependencies
Open a terminal in the project folder and run:
```bash
npm install
```

#### 5. Install Composer
Run the following commands in a terminal within the project folder:
```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') echo Installer verified && exit; echo Installer corrupt && del composer-setup.php && exit /b 1"
php composer-setup.php
php -r "unlink('composer-setup.php');"
move composer.phar C:\bin\composer.phar
```
- Add `C:\bin` to your system PATH for global Composer usage.

#### 6. Initialize Composer in the Project
Run the following command in the project root:
```bash
composer init
```
Follow the prompts to generate a `composer.json` file and accept `psr-4`.

#### 7. Install PHP Dependencies
Run:
```bash
composer install
```

#### 8. Configure Laragon for the Local Server
- Start Laragon and ensure both Apache and MySQL services are running.
- Access the project in your browser:
  ```
  http://localhost/Hamza-Atig-Youdemy
  ```

---

## Project Context
The YouDemy platform is an innovative online learning solution designed to enhance the educational experience for students and teachers through interactive and personalized features.

---

## Key Features

### Front Office

#### Visitor:
- Browse the course catalog with pagination.
- Search for courses by keywords.
- Create an account and choose a role (Student or Teacher).

#### Student:
- View the course catalog.
- Search and view detailed course information (description, content, teacher, etc.).
- Enroll in courses after authentication.
- Access a "My Courses" section with enrolled courses.

#### Teacher:
- Add new courses with:
  - Title, description, content (video or document), tags, and category.
- Manage courses:
  - Edit, delete, and view enrolled students.
- Access a "Statistics" section:
  - Total students, total courses, etc.

### Back Office

#### Administrator:
- Validate teacher accounts.
- Manage users:
  - Activate, suspend, or delete accounts.
- Manage content:
  - Courses, categories, and tags.
- Add tags in bulk for efficiency.
- View global statistics:
  - Total courses, category distribution, most enrolled course, and top 3 teachers.

---

## Special Features
- **Course Certificates**: Generate completion certificates in PDF format for students.
- **Multiple Course Types**: Support for both video courses and document-based courses.
- **Advanced Search**: Filter courses by category, tags, and teacher.
- **Interactive Dashboard**: Statistics and insights for teachers and administrators.

---

## Technical Requirements

- Adherence to **Object-Oriented Programming (OOP)** principles (encapsulation, inheritance, polymorphism).
- Relational database with relationships (one-to-many, many-to-many).
- Session-based user management.
- Robust data validation and security measures:
  - Prevent Cross-Site Scripting (XSS).
  - Use prepared statements to avoid SQL injection.
  - Implement input validation and escaping to avoid malicious injections.

---

**Repository Link**: [YouDemy GitHub Repository](https://github.com/Youcode-Classe-E-2024-2025/Hamza-Atig-Youdemy.git)

