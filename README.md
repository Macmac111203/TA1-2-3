# Task Management System (TMS)
### A comprehensive Task Management System built with PHP, MySQL, and XAMPP that allows administrators and employees to manage tasks, assign roles, track task progress, and receive real-time notifications.

## 🎯 Project Overview
This Task Management System (TMS) is designed to streamline task assignment, tracking, and notification for organizations. It provides a robust platform where administrators can efficiently manage users and tasks, while employees can view, update, and complete their assigned tasks with real-time notifications and dashboard overviews.

## ✨ Core Features

### 🔐 Authentication & Authorization
- **User Registration and Login:** Secure registration and login system
- **Role-Based Access Control (RBAC):** Two distinct roles - Admin and Employee
- **Session Management:** Secure session handling with proper validation

### 👥 User Management
- **Admin Features:**
  - Create, edit, and delete employee accounts
  - View all users in the system
  - Manage user profiles and permissions
- **Employee Features:**
  - View and edit personal profile
  - Update account information securely

### 📋 Task Management
- **CRUD Operations:** Complete Create, Read, Update, Delete functionality
- **Task Assignment:** Admins can assign tasks to specific employees
- **Status Tracking:** Track task status (Pending, In Progress, Completed)
- **Due Date Management:** Set and monitor task deadlines
- **Task Filtering:** Filter by status, due date, and priority

### 🔍 Search & Filtering
- **User Search:** Instantly search for users by name, username, email, or department.
- **Task Search:** Find tasks by title, description, or assigned user.
- **Dynamic Filtering:** Combine search with existing filters for powerful data retrieval.
- **Task Filtering:** Filter tasks by status and due date (Due Today, Overdue, No Deadline).

### 📊 Dashboard & Analytics
- **Admin Dashboard:**
  - Total employee count
  - All tasks overview
  - Overdue tasks count
  - Tasks due today
  - Pending, in-progress, and completed tasks
  - Total notifications count
- **Employee Dashboard:**
  - Personal task count
  - Missing/overdue tasks
  - Tasks without deadlines
  - Status-based task filtering
  - Personal notifications

### 🔔 Notification System
- **Real-time Notifications:** Instant notifications for task assignments
- **Unread Count:** Track unread notifications
- **Admin Overview:** Admins can view all system notifications
- **Employee Notifications:** Employees see only their relevant notifications
- **Notification Types:** Task assignments, updates, and system alerts

### 📁 File Upload & Media Handling
- **File Attachments:** Upload files (PDFs, images, documents) to tasks
- **File Validation:** Type and size validation for security
- **Secure Storage:** Files stored in dedicated uploads directory
- **File Management:** View and download attached files

### 🔌 RESTful API
- **Task API Endpoints:**
  - `GET /api/tasks_api.php` - Retrieve all tasks
  - `GET /api/tasks_api.php/{id}` - Get specific task
  - `POST /api/tasks_api.php` - Create new task (Admin only)
  - `PUT /api/tasks_api.php/{id}` - Update task
  - `DELETE /api/tasks_api.php/{id}` - Delete task (Admin only)

## 🛡️ Security Features

### 🔒 CSRF Protection
- All forms and API endpoints protected with CSRF tokens
- Token validation on every request
- Secure token generation and verification

### ✅ Input Validation & Sanitization
- Comprehensive input validation for all user inputs
- SQL injection prevention through prepared statements
- XSS protection through output sanitization
- File upload validation (type, size, content)

### 🔐 Role-Based Security
- Strict role-based access control
- Session-based authentication
- Secure redirects for unauthorized access
- Error handling without information disclosure

## 🛠️ Technologies Used

- **Backend:** PHP 7.4+ (Vanilla PHP)
- **Database:** MySQL 5.7+
- **Frontend:** HTML5, CSS3, JavaScript, jQuery
- **UI Framework:** Bootstrap (partial)
- **Server:** Apache (XAMPP)
- **Version Control:** Git/GitHub
- **Development Environment:** XAMPP

## 📋 Requirements

- **XAMPP** (PHP, MySQL, Apache)
- **PHP 7.4** or higher
- **MySQL 5.7** or higher
- **Apache Web Server**
- **Modern Web Browser**

## 🚀 Installation & Setup

### 1. Clone the Repository
```bash
git clone [your-repository-url]
cd TMS
```

### 2. Database Setup
1. Start XAMPP and ensure Apache and MySQL are running
2. Open phpMyAdmin (http://localhost/phpmyadmin)
3. Create a new database named `task_management_db`
4. Import the database schema from `task_management_db.sql`

### 3. Configuration
1. Open `DB_connection.php`
2. Update database credentials if needed:
   ```php
   $host = "localhost";
   $username = "root";
   $password = "";
   $database = "task_management_db";
   ```

### 4. File Permissions
Ensure the `uploads/` directory has write permissions:
```bash
chmod 755 uploads/
```

### 5. Access the Application
Open your browser and navigate to:
```
http://localhost/TMS/
```

## 👤 Default Login Credentials

### Admin Users:
- **Username:** `admin` | **Password:** `123`
- **Username:** `admin@example.com` | **Password:** `marc_carolino123`

### Employee Users:
- **Username:** `user@example.com` | **Password:** `user123`
- **Username:** `Leoragos` | **Password:** `Leoragos@1`
- **Username:** `praise_asejo` | **Password:** `praise_asejo123`
- **Username:** `mark_angelo` | **Password:** `mark_angelo123`

## 🧪 Testing

### Functional Testing
- Test all user registration and login flows
- Verify CRUD operations for tasks and users
- Test file upload functionality
- Validate notification system
- Test search and filtering for both users and tasks with various keywords.

### Security Testing
- Test CSRF protection on all forms
- Verify role-based access restrictions
- Test input validation and sanitization
- Check file upload security

### API Testing
- Test all RESTful API endpoints
- Verify proper authentication and authorization
- Test error handling and responses

## 📱 Screenshots

*(Add screenshots of key interfaces here)*
- Login/Registration Page
- Admin Dashboard
- Employee Dashboard
- Task Management Interface
- Notifications Page
- File Upload Interface

## 🔧 API Documentation

### Authentication
All API requests require valid session authentication.

### Endpoints

| Endpoint | Method | Description | Access |
|----------|--------|-------------|---------|
| `/api/tasks_api.php` | GET | Get all tasks | Admin/Employee |
| `/api/tasks_api.php/{id}` | GET | Get specific task | Admin/Employee |
| `/api/tasks_api.php` | POST | Create new task | Admin only |
| `/api/tasks_api.php/{id}` | PUT | Update task | Admin/Employee* |
| `/api/tasks_api.php/{id}` | DELETE | Delete task | Admin only |

*Employees can only update their own assigned tasks.

### Response Format
```json
{
  "status": "success|error",
  "message": "Response message",
  "data": {}
}
```

## 🚨 Troubleshooting

### Common Issues
1. **Database Connection Error:** Check XAMPP services and database credentials
2. **File Upload Issues:** Verify uploads directory permissions
3. **Session Problems:** Clear browser cache and cookies
4. **CSRF Token Errors:** Ensure all forms include CSRF tokens

### Error Logs
Check Apache error logs in XAMPP for detailed error information.

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 📞 Support

For support and questions:
- Create an issue in the GitHub repository
- Contact the development team

## 🔄 Version History

- **v1.0.0** - Initial release with basic task management
- **v1.1.0** - Added notification system and file uploads
- **v1.2.0** - Enhanced security and API endpoints
- **v1.3.0** - Improved dashboard and user experience

---

**Developed with ❤️ for efficient task management**