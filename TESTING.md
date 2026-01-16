# Testing Guide - PM Validation Workflow

## Test Credentials

### Admin
- Email: admin@example.com
- Password: password

### Project Manager (PM)
- Email: pm1@example.com (or pm2@example.com)
- Password: password

### Team Member
- Email: member1@example.com (through member5@example.com)
- Password: password

## Pre-Requisites
1. Database seeded with test data
2. Server running on http://localhost:8000
3. All migrations executed

## Test Case 1: Complete Approval Flow

### Step 1: Login as Member
```
1. Go to http://localhost:8000/login
2. Email: member1@example.com
3. Password: password
4. Click "Login"
```

### Step 2: View Assigned Task
```
1. Click "Tugas Saya" in sidebar
2. Find a task in "To Do" status
3. Click the task to open detail view
```

### Step 3: Progress Task Through Stages
```
1. Update Status to "In Progress" and click "Update Status"
2. See status changed to "In Progress"
3. Upload a file (any file < 5MB)
4. Status should remain "In Progress"
```

### Step 4: Submit for Review
```
1. Change status dropdown to "Submit untuk Review"
2. Click "Update Status"
3. See status changed to "Review"
4. You should see notification: "Anda berhasil submit tugas untuk divalidasi"
```

### Step 5: Login as PM
```
1. Logout from member account
2. Login as PM: pm1@example.com / password
3. Go to dashboard/projects to see pending reviews
4. Look for notification about new review request
```

### Step 6: View Task as PM
```
1. Navigate to the task that's in "Review" status
2. You should see yellow "Menunggu Validasi PM" section
3. This section should contain:
   - Feedback textarea
   - "✓ Setujui & Selesaikan" button
   - "✗ Tolak" button
```

### Step 7: Approve Task
```
1. (Optional) Add feedback in textarea
2. Click "✓ Setujui & Selesaikan"
3. Task status should change to "Done"
4. "validated_at" column should have current timestamp
```

### Step 8: Verify Notification
```
1. Login back as member1@example.com
2. Check Notifications
3. Should see: "✓ Tugas '[Task Name]' telah disetujui dan selesai oleh Project Manager."
```

### Step 9: Verify Task Status
```
1. Click on the task
2. Status should show "Done"
3. Should NOT see "Update Status" form anymore
4. Should NOT see "Menunggu Validasi PM" section
```

## Test Case 2: Rejection with Feedback Flow

### Step 1-5: Same as Test Case 1
(Repeat steps 1-5)

### Step 6: View Task as PM (same)
(Same as step 6)

### Step 7: Reject Task with Feedback
```
1. Fill feedback: "Hasil belum sesuai dengan requirement. Silakan perbaiki error di bagian..."
2. Click "✗ Tolak"
3. Confirm rejection in dialog
4. Task status should change back to "In Progress"
5. "validated_at" should be cleared/null
```

### Step 8: Verify Notification with Feedback
```
1. Login as member1@example.com
2. Check Notifications
3. Should see: "✗ Tugas '[Task Name]' ditolak oleh Project Manager. Feedback: [your feedback]"
```

### Step 9: Verify Task Status Reset
```
1. Click on the task
2. Status should show "In Progress"
3. Should see "Update Status" form again
4. Member can now rework and resubmit
```

### Step 10: Rework and Resubmit
```
1. Update status back to "In Progress" (already there)
2. Upload new/updated file
3. Change status to "Review" again
4. Submit for re-validation
```

## Test Case 3: Validation Access Control

### Step 1: Try to Approve as Member
```
1. Login as member1@example.com
2. Find a task in "Review" status (if any)
3. Should NOT see "Menunggu Validasi PM" section
4. Should NOT see approve/reject buttons
```

### Step 2: Try to Approve as Wrong PM
```
1. Login as pm1@example.com
2. Find a task assigned to pm2's project
3. Should NOT see "Menunggu Validasi PM" section
4. (Or should see error if trying direct URL access)
```

### Step 3: Try to Force "Done" Status
```
1. Login as member1@example.com
2. Try to manually select "Done" in status dropdown
3. Should not see "Done" option (removed from form)
4. If somehow submitted, should get error: "Status 'Done' hanya dapat ditetapkan melalui validasi PM!"
```

## Test Case 4: Admin Override

### Step 1: Admin Can Approve Any Task
```
1. Login as admin@example.com
2. Navigate to any task in "Review" status
3. Should see "Menunggu Validasi PM" section even if not the assigned PM
4. Can approve/reject any task
```

### Step 2: Admin Can View All Tasks
```
1. Login as admin
2. Go to admin dashboard
3. Should see all projects
4. Should see all tasks across all projects
```

## Expected Behaviors Summary

| Action | Role | Result |
|--------|------|--------|
| Change to "Review" | Member | ✅ Allowed, notifies PM |
| Change to "Done" directly | Member | ❌ Not allowed, error shown |
| Approve task | PM (of project) | ✅ Allowed, task → Done |
| Approve task | PM (other project) | ❌ Not allowed, error shown |
| Approve task | Admin | ✅ Allowed, task → Done |
| Reject task | PM (of project) | ✅ Allowed, task → In Progress |
| Reject task | Member | ❌ Not allowed, form hidden |
| Upload file | Assigned member | ✅ Allowed, < 5MB |
| Upload file | Other member | ❌ Not allowed, upload hidden |

## Troubleshooting

### Task Status Not Updating
- Check that user is authenticated
- Verify CSRF token is in form
- Check Laravel logs: `storage/logs/laravel.log`

### Validation Form Not Showing
- Task must be in "Review" status
- User must be PM of that project or Admin
- Refresh page if just changed status

### File Upload Failing
- Check file size < 5MB
- Check `storage/app/public` has write permissions
- Verify symlink: `php artisan storage:link`

### Notifications Not Appearing
- Check `notification_items` table for new records
- Verify user_id in notifications matches current logged-in user
- Check notification creation time

## Performance Notes
- Task queries use eager loading (with 'project')
- Notifications paginated, 10 per page
- File storage uses public disk with symlink
- Fallback to public/uploads if symlink missing

## Database Checks

### See All Tasks and Their Status
```sql
SELECT id, title, status, assignee_id, validated_at FROM tasks;
```

### See Pending Reviews
```sql
SELECT * FROM tasks WHERE status = 'Review';
```

### See Recent Notifications
```sql
SELECT * FROM notification_items ORDER BY created_at DESC LIMIT 10;
```

### Check Task Files
```sql
SELECT id, title, files FROM tasks WHERE files IS NOT NULL;
```
