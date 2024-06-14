Introduction
The AMR Technik Service Management System is a web-based application designed to streamline the process of managing vehicle services. It provides portals for customers, managers, and clerks, allowing for efficient handling of appointments, service records, payments, and inventory management.

Features
Customer Portal: Book appointments, view service history, upload payment receipts.

Manager Portal: Manage appointments, services, payments, and inventory; assign tasks to mechanics.

Clerk Portak: Manage Inventory items.

Payment Management: Track and update payment statuses, upload and download receipts.

Inventory Management: Track items used in services, update inventory levels.

Installation
Clone the repository:
sh
Copy code
git clone https://github.com/Haziqazmi20/AMRTechnikGarageManagementSystem.git

Navigate to the project directory:
sh

cd AMRTechnik
Install dependencies (if applicable):
sh

composer install  # For PHP dependencies, if using Composer
npm install       # For JavaScript dependencies, if applicable

Database Setup
Create the database:
sql

CREATE DATABASE amrtechnik;
Import the database schema:
sh

Copy code
$servername = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$dbname = "amrtechnik";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
Usage
Customer Portal

Book Appointments: Customers can book new appointments through the appointment page.

View Service History: Customers can view their past service records and payment statuses.

Upload Receipts: After making a payment, customers can upload the receipt for verification.

Manager Portal

Manage Appointments: View and update appointment details.

Service Management: Assign tasks to mechanics, update service records, and track items used.

Payment Management: View and update payment statuses, download receipts uploaded by customers.

Inventory Management: Track and update inventory levels.

File Structure
index.php: Landing page of the system.
login.php: Login page for customers, managers, and clerks.
register.php: Registration page for new customers.
appointment.php: Page for customers to book appointments.
contact.php: Contact page.
db.php: Database connection file.
servicehistory.php: Service history page for managers.
servicedetails.php: Page for managers to update service details.
task.php: Task management page for managers.
report.php: Report generation page.
adminstyle.css: CSS styles for admin pages.
uploads/: Directory for storing uploaded receipts.
Security Considerations
Input Validation: Ensure all user inputs are validated and sanitized to prevent SQL injection and XSS attacks.
Authentication: Implement proper authentication and session management to protect user data.
File Uploads: Validate and sanitize file uploads to prevent malicious files from being uploaded.
