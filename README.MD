# How to Run the Project Locally

This guide provides step-by-step instructions to set up and run the project on your local machine using XAMPP.

## Prerequisites
- [XAMPP](https://www.apachefriends.org/index.html) installed on your system
- [Git](https://git-scm.com/) installed on your system

## Steps to Set Up the Project

### 1. Clone the Repository

Open your terminal or Git Bash and navigate to the `htdocs` directory inside your XAMPP installation:

```sh
cd C:\xampp\htdocs  # Adjust the path if needed
```

Clone the GitHub repository:

```sh
git clone https://github.com/AbrahamNdiwa/learn-hub-project
```

Move into the project directory:

```sh
cd learnhub
```

### 2. Import the Database

1. Start XAMPP and ensure the **Apache** and **MySQL** services are running.
2. Open your browser and go to [phpMyAdmin](http://localhost/phpmyadmin/).
3. Create a new database named `learnhub`.
4. Click on the newly created database and go to the **Import** tab.
5. Click **Choose File** and select `learnhub.sql` from `sql` folder inside your project directory.
6. Click **Go** to import the database.

### 3. Configure the Database Connection

Edit the configuration file `db.php` to match your local database settings:

```php
$servername = "localhost";
$username = "root";
$password = "";
$database = "learnhub";
$port = 3306;
```

Save the changes.

### 4. Start the Server

1. Ensure XAMPP's **Apache** and **MySQL** services are running.
2. Open your browser and visit:
   ```
   http://localhost/learnhub
   ```

You should now see your project running locally!

## Troubleshooting
- If you encounter database connection issues, ensure `db.php` has the correct credentials.
- If Apache or MySQL won’t start, check if another service is using port 80 (Apache) or port 3306 (MySQL).
- Check your `error_log` file inside `xampp/apache/logs/` for any errors.

Happy coding! 🚀