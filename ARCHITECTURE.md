# Workflow Architecture Diagrams

## 1. Task Status State Machine

```
┌─────────────────────────────────────────────────────────────┐
│                    TASK STATUS WORKFLOW                      │
└─────────────────────────────────────────────────────────────┘

                            ┌──────────┐
                            │  To Do   │ (Initial Status)
                            └────┬─────┘
                                 │
                    Member updates (updateStatus)
                                 │
                                 ▼
                        ┌─────────────────┐
                        │  In Progress    │
                        │ (Member working)│
                        └────┬────────┬───┘
                             │        │
        Member uploads files │        │ Member rejects
             and submits      │        │
                             │        │ (Keeps in progress)
                             ▼        │
                        ┌─────────────┘
                        │  Review     │
                        │(PM pending) │
                        └────┬────┬───┘
                             │    │
                             │    │
          PM validates        │    │ PM approves
         (validateTask)       │    │
                             │    │
                     Reject  │    │ Approve
                             │    │
                    ┌────────┘    └──────────┐
                    ▼                        ▼
                IN PROGRESS                DONE ✓
            (With feedback)         (With timestamp)
                    │
                    │ Member reworks
                    │ and resubmits
                    │
                    └──────→ Review


KEY TRANSITIONS:
═════════════════════════════════════════════════════
Member Can:     To Do → In Progress → Review
                       ↑ (return)   ↓ (submit)

PM/Admin Can:   Review → Done (Approve)
                Review → In Progress (Reject)

Member Cannot:  ✗ Directly set to "Done"
                ✗ Self-validate
                ✗ Skip Review stage
═════════════════════════════════════════════════════
```

## 2. Role-Based Permission Matrix

```
┌──────────────────────────────────────────────────────────────┐
│         ROLE-BASED ACCESS CONTROL MATRIX                     │
└──────────────────────────────────────────────────────────────┘

ACTION                          MEMBER    PM*      ADMIN
─────────────────────────────────────────────────────────
View all tasks                    ✗       ✓        ✓
View assigned tasks only          ✓       ✗        ✗
Upload file evidence              ✓       ✗        ✗
Change status (To Do/In Progress) ✓       ✗        ✗
Submit for Review                 ✓       ✗        ✗
Approve task                      ✗       ✓        ✓
Reject task with feedback         ✗       ✓        ✓
Mark task as Done                 ✗       ✓        ✓
View Gantt Chart                  ✗       ✓        ✓
View Kanban Board                 ✗       ✓        ✓
Generate Reports                  ✗       ✓        ✓
Create Projects                   ✗       ✓        ✓
Manage Users                       ✗       ✗        ✓
View Activity Logs                ✗       ✗        ✓
System Settings                   ✗       ✗        ✓

* PM = Can only for their assigned projects
```

## 3. Data Flow Diagram: Task Submission & Validation

```
┌─────────────────────────────────────────────────────────────┐
│         TASK SUBMISSION & VALIDATION FLOW                    │
└─────────────────────────────────────────────────────────────┘

MEMBER SIDE                          DATABASE                 PM SIDE
═══════════════════════════════════════════════════════════════════

    Task Page
       │
       │ 1. Click "Submit untuk Review"
       │
       ├─────────────────────→ tasks.status="Review" ─→ [PM sees
       │                                               pending review]
       │
       ├──────────────────────→ notification_items ───→ PM receives
       │ [Submit notification]     [message: "Member X  notification
       │                           submitted task Y"]
       │
       │ 2. Wait for PM validation
       │
       │ 3. Check notifications  
       │
       ├─────────────────────← [PM opens task]  ←──────── PM Reviews
       │                                                   
       │                    VALIDATION FORM
       │                    ┌──────────────┐
       │                    │ Feedback Box │
       │                    │              │  PM decides
       │                    │ ✓ Approve    │
       │                    │ ✗ Reject     │
       │                    └──────────────┘
       │
       │ ┌─ APPROVAL PATH ─────────────────────┐
       │ │                                      │
       │ ├→ tasks.status="Done"                │
       │ │  tasks.validated_at=NOW()           │
       │ │  Notification: "✓ Task approved"   │
       │ │                                      │
       │ └─ [Task Complete] ─→ ✓ DONE ────────┘
       │
       │ ┌─ REJECTION PATH ────────────────────┐
       │ │                                      │
       │ ├→ tasks.status="In Progress"         │
       │ │  tasks.validated_at=NULL            │
       │ │  Notification: "✗ Rejected"        │
       │ │              + "[Feedback text]"    │
       │ │                                      │
       │ └─ [Task Returned] → Member Reworks ──┘
       │
       ▼
    [Cycle repeats if rejected]


NOTIFICATION TIMELINE:
═════════════════════════════════════════════════════════
Time Event                      Receiver  Message
─────────────────────────────────────────────────────────
T0   Member submits Review      PM        "[Member] submitted task"
T0+5 PM opens task notification PM        (marks as read)
T0+10 PM approves/rejects       Member    "✓/✗ Task [status]..."
T0+15 Member sees notification  Member    (marks as read)
```

## 4. Database Relationships

```
┌─────────────────────────────────────────────────────────────┐
│            DATABASE SCHEMA RELATIONSHIPS                     │
└─────────────────────────────────────────────────────────────┘

users (Admin, PM, Member)
    │
    ├─────────────┐
    │             │
    ▼             ▼
projects          notification_items
    │ (pm_id)         │
    │                 ├─→ user_id
    │                 ├─→ message
    │                 ├─→ read
    │                 └─→ created_at
    │
    ├─────────────────┐
    │                 │
    ▼                 ▼
tasks            Comments
    │ (assignee_id)
    ├─→ project_id
    ├─→ status: To Do|In Progress|Review|Done
    ├─→ validated_at (CRITICAL)
    ├─→ files (JSON)
    ├─→ description
    ├─→ start_date
    ├─→ due_date
    └─→ created_at


KEY FOREIGN KEYS FOR VALIDATION:
═════════════════════════════════════════════════════════
- tasks.assignee_id → users.id (Who does the work)
- tasks.project_id → projects.id (Which project)
- projects.pm_id → users.id (Who validates)
- notification_items.user_id → users.id (Who receives)
- comments.user_id → users.id (Who commented)
```

## 5. Request Flow in Laravel Routes

```
┌─────────────────────────────────────────────────────────────┐
│           HTTP REQUEST & ROUTING FLOW                        │
└─────────────────────────────────────────────────────────────┘

MEMBER SUBMISSION:
═════════════════════════════════════════════════════════
POST /tasks/{task}/update-status
    ↓
TaskController@updateStatus()
    ├─→ Validate: status ∈ [To Do, In Progress, Review]
    ├─→ Check: $canUpload (is member & assignee)
    ├─→ Block: if status === 'Done'
    ├─→ Update: tasks.status = Review
    ├─→ Create: notification_items (notify PM)
    └─→ Redirect: back() with success

PM VALIDATION:
═════════════════════════════════════════════════════════
POST /projects/{project}/validate/{task}
    ↓
TaskController@validateTask()
    ├─→ Check Auth: Role === 'pm' OR 'admin'
    ├─→ Check: project.pm_id === user.id (if PM)
    ├─→ Validate:
    │   ├─ approval ∈ [approve, reject]
    │   └─ feedback ≤ 500 chars
    ├─→ IF Approve:
    │   ├─ tasks.status = Done
    │   ├─ tasks.validated_at = NOW()
    │   └─ message = "✓ Task approved"
    ├─→ IF Reject:
    │   ├─ tasks.status = In Progress
    │   ├─ tasks.validated_at = NULL
    │   └─ message = "✗ Task rejected. Feedback: ..."
    ├─→ Create: notification_items
    │   └─→ user_id = task.assignee_id
    └─→ Redirect: back() with success


AUTHORIZATION MIDDLEWARE STACK:
═════════════════════════════════════════════════════════
Every Protected Route:
    1. Middleware('auth')           ← User logged in?
    2. Route-specific middleware    ← Role check (PM/Admin)
    3. In-method authorization      ← Resource ownership check
```

## 6. Validation Gate Logic (Pseudo-code)

```
┌─────────────────────────────────────────────────────────────┐
│              VALIDATION GATE - PSEUDO CODE                   │
└─────────────────────────────────────────────────────────────┘

FUNCTION updateStatus(task, newStatus):
    ──────────────────────────────────────────────
    # Member can only set these statuses
    IF newStatus NOT IN ['To Do', 'In Progress', 'Review']:
        RETURN ERROR "Invalid status"
    
    # Block attempt to force "Done"
    IF newStatus == 'Done':
        RETURN ERROR "Only PM can set Done status"
    
    # Prevent member from updating other tasks
    IF task.assignee_id != currentUser.id:
        RETURN ERROR "Not your task"
    
    # Update and notify
    task.status = newStatus
    task.save()
    
    IF newStatus == 'Review':
        NotifyPM(task.project.pm, 
                "[Member] submitted task for review")
    
    RETURN SUCCESS


FUNCTION validateTask(task, approval, feedback):
    ──────────────────────────────────────────────
    # Only PM or Admin can validate
    IF currentUser.role == 'member':
        RETURN ERROR "Access denied"
    
    IF currentUser.role == 'pm':
        IF task.project.pm_id != currentUser.id:
            RETURN ERROR "Not your project"
    
    # Task must be in Review status
    IF task.status != 'Review':
        RETURN ERROR "Task not in Review status"
    
    # Handle approval
    IF approval == 'approve':
        task.status = 'Done'
        task.validated_at = NOW()
        message = "✓ Task approved"
    
    ELSE IF approval == 'reject':
        task.status = 'In Progress'
        task.validated_at = NULL
        message = "✗ Task rejected"
        IF feedback PROVIDED:
            message += " Feedback: " + feedback
    
    ELSE:
        RETURN ERROR "Invalid approval value"
    
    # Save and notify
    task.save()
    NotifyMember(task.assignee, message)
    
    RETURN SUCCESS
```

## 7. Timeline Example: Full Task Lifecycle

```
┌─────────────────────────────────────────────────────────────┐
│           COMPLETE TASK LIFECYCLE TIMELINE                   │
└─────────────────────────────────────────────────────────────┘

DAY 1 - TASK CREATION
─────────────────────────────────────────────────────────────
09:00  Admin creates project "Website Redesign"
09:05  PM1 assigned to project
09:10  PM1 creates task "Homepage Design" assigned to Member1
       Status: To Do

DAY 2 - MEMBER STARTS WORK
─────────────────────────────────────────────────────────────
10:00  Member1 changes status → In Progress
       [Member1 now working]

DAY 3 - MEMBER UPLOADS & SUBMITS
─────────────────────────────────────────────────────────────
14:30  Member1 uploads file "homepage-v1.figma"
14:35  Member1 changes status → Review
       ✉️ Notification sent to PM1: 
          "Member1 submitted 'Homepage Design' for review"
       DB: tasks.status = "Review"

DAY 4 - PM REVIEWS
─────────────────────────────────────────────────────────────
11:00  PM1 sees notification
11:05  PM1 opens task, reviews work & files
11:10  PM1 enters feedback: "Good work, but need darker colors"
11:11  PM1 clicks "✗ Tolak" (Reject)
       DB: tasks.status = "In Progress"
       DB: tasks.validated_at = NULL
       ✉️ Notification sent to Member1:
          "Homepage Design rejected. Feedback: Good work..."

DAY 4-5 - MEMBER REWORKS
─────────────────────────────────────────────────────────────
15:00  Member1 sees rejection notification with feedback
16:00  Member1 reworks design with darker colors
09:00  Member1 uploads new file "homepage-v2.figma"
10:00  Member1 changes status → Review (again)
       ✉️ PM1 notified of new submission

DAY 5 - PM APPROVES
─────────────────────────────────────────────────────────────
14:00  PM1 sees new submission
14:05  PM1 reviews v2 - approves changes
14:06  PM1 clicks "✓ Setujui & Selesaikan" (Approve)
       DB: tasks.status = "Done"
       DB: tasks.validated_at = "2026-01-15 14:06:00"
       ✉️ Notification sent to Member1:
          "Homepage Design approved and completed!"

FINAL STATE
─────────────────────────────────────────────────────────────
Task Status:        DONE ✓
Assignee:           Member1
Validated By:       PM1
Validated At:       2026-01-15 14:06:00
Work History:       2 submissions (1 rejection, 1 approval)
Total Duration:     ~5 days
```

## 8. Error Scenarios

```
┌─────────────────────────────────────────────────────────────┐
│              ERROR HANDLING SCENARIOS                         │
└─────────────────────────────────────────────────────────────┘

SCENARIO 1: Member Tries to Force "Done"
─────────────────────────────────────────────────────────────
Member1 submits form with status="Done"
    ↓
updateStatus() validates
    ↓
IF status == 'Done':
    ✗ BLOCKED: Error message shown
    "Status 'Done' hanya dapat ditetapkan melalui validasi PM!"

RESULT: No database change, form shows error

═════════════════════════════════════════════════════════════

SCENARIO 2: Member2 Tries to Update Member1's Task
─────────────────────────────────────────────────────────────
Member2 directly accesses task/123/update-status
    ↓
updateStatus() checks: task.assignee_id != currentUser.id
    ↓
✗ BLOCKED: "You are not assigned to this task"

RESULT: No update performed

═════════════════════════════════════════════════════════════

SCENARIO 3: PM from Project2 Tries to Validate Task in Project1
─────────────────────────────────────────────────────────────
PM2 tries: POST /projects/1/validate/task/5
    ↓
validateTask() checks:
    - user.role == 'pm' ✓
    - project.pm_id == user.id ?
    - project.1.pm_id = PM1 (not PM2)
    ↓
✗ BLOCKED: "You don't have access to validate this task"

RESULT: Redirect with error

═════════════════════════════════════════════════════════════

SCENARIO 4: Member Tries to Validate Task
─────────────────────────────────────────────────────────────
Member1 tries: POST /projects/1/validate/task/5
    ↓
validateTask() checks: user.role == 'pm' OR 'admin'?
    - user.role = 'member' ✗
    ↓
✗ BLOCKED: "You don't have access to validate this task"

RESULT: Validation form never shown in UI anyway

═════════════════════════════════════════════════════════════

SCENARIO 5: Admin Overrides (ALLOWED)
─────────────────────────────────────────────────────────────
Admin1 tries: POST /projects/1/validate/task/5
    ↓
validateTask() checks:
    - user.role == 'admin' ✓
    ↓
✓ ALLOWED: Admin can validate any task

RESULT: Task validated successfully

═════════════════════════════════════════════════════════════
```

---

## Summary

The workflow ensures:
1. **Members** can only submit work, not self-approve
2. **PMs** are gatekeepers for task completion
3. **Admins** have override capabilities
4. **Quality Control** through mandatory review
5. **Feedback Loop** for rejected tasks
6. **Audit Trail** with validated_at timestamp
