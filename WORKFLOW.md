# Project Management Workflow

## Overview
Sistem ini mengimplementasikan workflow ketat dimana setiap kemajuan tugas memerlukan validasi dari Project Manager (PM) sebelum tim dapat melanjutkan ke tahap berikutnya.

## Task Status Flow

### Stages
```
To Do → In Progress → Review (Submit) → [PM Validation] → Done
                                              ↓
                                         (if rejected)
                                              ↓
                                         In Progress
```

## Role-Based Responsibilities

### 1. **Member (Anggota Tim)**
**Akses:**
- Lihat detail tugas yang ditugaskan
- Upload file bukti pekerjaan
- Update status: To Do, In Progress, atau Submit untuk Review

**Workflow:**
1. Mulai dengan status "To Do"
2. Ubah ke "In Progress" saat mengerjakan
3. Upload bukti/hasil kerja
4. Submit untuk Review ketika sudah siap
5. Tunggu validasi dari PM
6. Jika disetujui → Status menjadi "Done"
7. Jika ditolak → Kembali ke "In Progress" + menerima feedback dari PM

**Batasan:**
- ❌ TIDAK bisa mengubah status langsung ke "Done"
- ❌ TIDAK bisa menolak/menerima validasi
- ✅ Hanya bisa submit untuk review

### 2. **Project Manager (PM)**
**Akses:**
- Lihat semua tugas di project yang dikelola
- Validasi hasil pekerjaan anggota tim
- Berikan feedback pada penolakan
- View Gantt Chart, Kanban Board, Reports

**Workflow:**
1. Lihat tugas yang statusnya "Review"
2. Lihat bukti/file yang di-upload
3. Pilih untuk:
   - **Approve & Selesaikan** → Status menjadi "Done", validated_at terisi
   - **Tolak** → Status kembali ke "In Progress", PM bisa memberikan feedback
4. Anggota tim menerima notifikasi dengan hasil validasi

**Catatan Penting:**
- PM adalah gatekeeper untuk task progression
- Feedback pada penolakan harus jelas untuk membantu anggota tim
- Approval secara otomatis menyelesaikan tugas

### 3. **Admin**
**Akses:**
- Akses ke semua fitur PM
- Lihat semua project dan tugas di sistem
- Bisa melakukan validasi jika diperlukan
- Kelola user, project, dan settings

## Notification System

### Events yang Trigger Notifikasi

1. **Member Submit untuk Review**
   - Penerima: PM project
   - Pesan: "[Member] mengajukan tugas '[Title]' untuk divalidasi."
   - Aksi: PM perlu review dan decide

2. **PM Approve Tugas**
   - Penerima: Member (assignee)
   - Pesan: "✓ Tugas '[Title]' telah disetujui dan selesai oleh Project Manager."
   - Status Update: To Do/In Progress/Review → Done

3. **PM Reject dengan Feedback**
   - Penerima: Member (assignee)
   - Pesan: "✗ Tugas '[Title]' ditolak oleh Project Manager. Feedback: [feedback text]"
   - Status Update: Review → In Progress (untuk dikerjakan ulang)

## API Endpoints

### Status Update (Member)
```
POST /tasks/{task}/update-status
Payload: {
  "status": "To Do|In Progress|Review"
}
```

### Task Validation (PM/Admin)
```
POST /projects/{project}/validate/{task}
Payload: {
  "approval": "approve|reject",
  "feedback": "optional feedback text (max 500 chars)"
}
```

### File Upload (Member)
```
POST /tasks/{task}/upload
Payload: {
  "file": "file binary"
}
```

## Database Schema

### Tasks Table
```
- id
- title
- description
- status: To Do|In Progress|Review|Done
- assignee_id (FK to users)
- project_id (FK to projects)
- progress (0-100)
- files (JSON array)
- start_date
- due_date
- validated_at (timestamp when PM approves)
- created_at, updated_at
```

### Projects Table
```
- id
- name
- description
- pm_id (FK to users - the PM managing this project)
- created_by (FK to users)
- created_at, updated_at
```

### NotificationItem Table
```
- id
- user_id (FK to users)
- message (text)
- read (boolean)
- created_at, updated_at
```

## Key Features

### 1. Validation Gate
- Tasks TIDAK bisa mencapai "Done" tanpa approval dari PM
- Ini memastikan quality control

### 2. Feedback Mechanism
- PM bisa memberikan feedback saat menolak
- Feedback dikirimkan ke member melalui notifikasi
- Member bisa lihat feedback di detail tugas

### 3. Audit Trail
- `validated_at` column tracking kapan PM approve
- Semua status changes tercatat di database
- Notification history tersimpan

### 4. Status Restrictions
- Member hanya bisa set: To Do, In Progress, Review
- PM bisa set: Done (via validation), In Progress (via rejection)
- Admin memiliki akses penuh

## Testing Workflow

### Scenario 1: Happy Path (Approve)
1. Login as Member (user assigned to task)
2. Change task status to "In Progress"
3. Upload task file
4. Submit to "Review"
5. Login as PM
6. See "Review" tasks in notification
7. Click task → see validation form
8. Fill optional feedback
9. Click "✓ Setujui & Selesaikan"
10. Confirm task status changed to "Done"
11. Member gets approval notification

### Scenario 2: Rejection Path
1. Member submits task to "Review"
2. PM opens validation form
3. Fills feedback: "Hasil belum sesuai requirement"
4. Click "✗ Tolak"
5. Confirm rejection
6. Task status reverts to "In Progress"
7. Member gets rejection notification with feedback
8. Member reworks and resubmits

## Error Handling

### Common Errors
- "Status 'Done' hanya dapat ditetapkan melalui validasi PM!" 
  → Member tried to force Done status
- "Anda tidak memiliki akses untuk memvalidasi tugas ini."
  → Non-PM trying to validate
- File upload > 5MB
  → File too large error

## Best Practices

1. **For Members:**
   - Upload bukti kerja sebelum submit review
   - Submit hanya ketika ready untuk QA
   - Respons cepat pada feedback PM

2. **For PMs:**
   - Check tugas yang pending review secara regular
   - Berikan feedback yang actionable saat reject
   - Approve hanya tugas yang memenuhi requirement

3. **For Admin:**
   - Monitor workflow di Dashboard
   - Ensure PMs melakukan validasi tepat waktu
   - Use Reports untuk track project progress
