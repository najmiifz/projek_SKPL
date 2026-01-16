# Project Management Application (Manpro)

**Aplikasi Manajemen Proyek dengan Sistem Validasi Workflow PM**

## 🎯 Overview

Sistem manajemen proyek yang komprehensif dengan 3 role (Admin, PM, Member) yang mengimplementasikan workflow ketat dimana setiap kemajuan tugas memerlukan validasi dari Project Manager sebelum tim dapat melanjutkan.

## ✨ Key Features

### 1. **Three-Role System**
- **Admin**: Full system access, can override any validation, manage users
- **Project Manager (PM)**: Manage projects, validate task progress, provide feedback
- **Team Members**: Execute tasks, upload work evidence, submit for review

### 2. **Strict Task Validation Workflow**
```
To Do → In Progress → Review (Submit) → [PM Validation] → Done
                                              ↓
                                         (if rejected)
                                              ↓
                                         In Progress
```

**Members CANNOT mark tasks as "Done"** - Only PM approval can finalize tasks.

### 3. **Work Submission & Review**
- Members upload file evidence when task is ready
- Submit to "Review" status to notify PM
- PM reviews and either:
  - ✓ Approves → Task moves to "Done" with timestamp
  - ✗ Rejects → Task returns to "In Progress" with feedback

### 4. **Project Planning Tools**
- Gantt Chart visualization
- Kanban Board for task management
- Project reports and analytics
- Task progress tracking (0-100%)

### 5. **Collaboration & Communication**
- Task-level discussion/comments
- Real-time notifications
- Feedback on rejected tasks
- Audit trail (who validated when)

### 6. **Admin Dashboard**
- View all projects and tasks
- User management
- Activity logs
- System settings

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- MySQL/MariaDB
- Node.js (for Vite)

### Installation

```bash
# Clone repository
git clone [repo-url]
cd project_manpro

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database
php artisan migrate
php artisan db:seed

# Build assets
npm run build

# Start server
php artisan serve

# (In another terminal) Start Vite
npm run dev

# Create storage symlink
php artisan storage:link
```

Visit: http://localhost:8000

### Test Credentials
```
Admin:  admin@example.com / password
PM1:    pm1@example.com / password  
PM2:    pm2@example.com / password
Member: member1@example.com / password (member1-member5)
```

## 📋 Workflow Details

### Member Workflow
1. View assigned tasks
2. Change status: To Do → In Progress
3. Upload work evidence/files
4. Submit to "Review" (triggers PM notification)
5. Wait for PM validation
6. If approved: Task completes ✓
7. If rejected: Receive feedback, rework, and resubmit

### PM Workflow
1. Receive notification when member submits for review
2. Open task to review work evidence
3. Make decision:
   - **Approve**: Provide optional feedback → Task marked "Done"
   - **Reject**: Provide required feedback → Task returns "In Progress"
4. Monitor project progress
5. Use Gantt/Kanban for overview

### Admin Workflow
1. Create/manage projects
2. Assign PMs and members
3. Can override any validation if needed
4. View system-wide reports
5. Manage user accounts

## 📚 Documentation

### Core Documents
- **[WORKFLOW.md](WORKFLOW.md)** - Complete system workflow, roles, responsibilities, API endpoints
- **[TESTING.md](TESTING.md)** - Testing guide with 4 complete test scenarios
- **[IMPLEMENTATION.md](IMPLEMENTATION.md)** - Technical implementation details and changes made

### Quick Links
- Task status flow and restrictions
- Notification trigger system
- Database schema
- API endpoint documentation
- Troubleshooting guide

## 🗄️ Database Schema

### Core Tables
- **users** - Admin, PM, Member accounts
- **projects** - Project management (pm_id assigned)
- **tasks** - Tasks with status, assignee, validation info
- **comments** - Task discussions
- **notification_items** - Real-time notifications
- **project_members** - Team composition

### Key Fields
- `tasks.status` - To Do | In Progress | Review | Done
- `tasks.validated_at` - When PM approved (null if pending/rejected)
- `tasks.files` - JSON array of uploaded files
- `projects.pm_id` - Assigned Project Manager

## 🔐 Security Features

- **Role-Based Access Control (RBAC)**
  - Members restricted to assigned tasks
  - PM can only validate their projects
  - Admin has full access

- **Validation Gates**
  - Members cannot force "Done" status
  - Only PM/Admin can approve
  - Clear error messages on unauthorized access

- **CSRF Protection**
  - All forms include CSRF tokens
  - POST method for state-changing operations

- **Audit Trail**
  - `validated_at` timestamp on approval
  - Notification history
  - Status change logging

## 🛠️ Technology Stack

- **Backend**: Laravel 12.46.0
- **PHP**: 8.2.12
- **Database**: MySQL
- **Frontend**: Blade templating
- **Styling**: Tailwind CSS (CDN)
- **Build**: Vite
- **ORM**: Eloquent

## 📊 Project Structure

```
project_manpro/
├── app/
│   ├── Http/Controllers/     # Business logic
│   ├── Models/               # Database models
│   └── Middleware/           # Auth middleware
├── database/
│   ├── migrations/           # Database schema
│   └── seeders/              # Test data
├── resources/
│   ├── views/                # Blade templates
│   ├── css/                  # Styling
│   └── js/                   # JavaScript
├── routes/                   # URL routing
├── storage/                  # File uploads
└── tests/                    # Unit tests
```

## 🧪 Testing

See [TESTING.md](TESTING.md) for complete testing guide.

### Key Test Scenarios
1. **Approval Flow** - Member submits, PM approves → Done
2. **Rejection Flow** - Member submits, PM rejects with feedback
3. **Access Control** - Verify role-based permissions
4. **Admin Override** - Admin validates any project task

## 🔗 API Endpoints

### Member Operations
```
POST /tasks/{task}/update-status
- Update task status: To Do, In Progress, or Review

POST /tasks/{task}/upload
- Upload work evidence file

POST /tasks/{task}/comment
- Add task discussion comment
```

### PM/Admin Operations
```
POST /projects/{project}/validate/{task}
- Approve or reject task validation
- Body: { "approval": "approve|reject", "feedback": "..." }

GET /projects/{project}/gantt
- View project Gantt chart

GET /projects/{project}/kanban
- View project Kanban board

GET /reports
- Generate project reports
```

## 📈 Notifications

### Automatic Notifications
- **Member submits**: PM notified of pending review
- **PM approves**: Member notified, task complete
- **PM rejects**: Member notified with feedback

### Notification Status
- Mark as read
- Mark all as read
- Persistent storage

## 🐛 Troubleshooting

### Common Issues
- **File upload failing**: Check storage permissions, verify < 5MB
- **Validation form not showing**: Task must be in "Review", user must be PM or Admin
- **Notifications missing**: Check `notification_items` table, verify user_id
- **Status not updating**: Ensure CSRF token in form, check Laravel logs

See [TESTING.md - Troubleshooting](TESTING.md#troubleshooting) for solutions.

## 📝 Usage Examples

### Example 1: Complete Task
```
1. Login as member1@example.com
2. Go to "Tugas Saya"
3. Click task → Change to "In Progress"
4. Upload file evidence
5. Change to "Review"
6. Logout → Login as pm1@example.com
7. Find task in "Review"
8. Click "✓ Setujui & Selesaikan"
9. Task now shows "Done" with validated_at timestamp
```

### Example 2: Reject and Rework
```
1. PM sees Review task
2. Clicks "✗ Tolak"
3. Enters feedback: "Perlu perbaikan di..."
4. Confirms rejection
5. Member gets notification with feedback
6. Member reworks task
7. Resubmits to "Review"
8. PM approves on second review
```

## 🚧 Future Enhancements

- Task dependencies (blocking relationships)
- Automated reminders for pending reviews
- Email notifications
- Bulk approval actions
- Task history/audit log
- SLA tracking
- Approval chains (multiple approvers)
- Advanced reporting and analytics

## 📞 Support

For issues or questions:
1. Check [WORKFLOW.md](WORKFLOW.md) for system documentation
2. Review [TESTING.md](TESTING.md) for test scenarios
3. See [IMPLEMENTATION.md](IMPLEMENTATION.md) for technical details
4. Check Laravel logs: `storage/logs/laravel.log`

## 📄 License

Open source project for team collaboration.

---

**Version**: 1.0  
**Last Updated**: January 2026  
**Status**: Production Ready
