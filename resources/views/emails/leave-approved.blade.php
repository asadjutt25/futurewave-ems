<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Leave Approved</title>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; padding: 2rem; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); overflow: hidden; }
        .header { background: linear-gradient(135deg, #4f46e5, #06b6d4); padding: 2rem; text-align: center; color: white; }
        .content { padding: 2rem; }
        .footer { background: #f1f5f9; padding: 1rem; text-align: center; color: #64748b; font-size: 0.875rem; }
        .badge { display: inline-block; padding: 0.25rem 1rem; background: #10b981; color: white; border-radius: 50px; font-size: 0.875rem; }
        .button { display: inline-block; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #4f46e5, #06b6d4); color: white; text-decoration: none; border-radius: 50px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Leave Request Approved</h1>
            <p>FutureWave Employee Management</p>
        </div>
        <div class="content">
            <p>Dear <strong>{{ $employee->name }}</strong>,</p>
            <p>Your leave request has been <strong style="color: #10b981;">APPROVED</strong>.</p>
            
            <div style="background: #f1f5f9; padding: 1rem; border-radius: 10px; margin: 1.5rem 0;">
                <p><strong>Leave Type:</strong> {{ ucfirst($leave->leave_type) }}</p>
                <p><strong>Duration:</strong> {{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</p>
                <p><strong>Total Days:</strong> {{ $leave->total_days }}</p>
                <p><strong>Reason:</strong> {{ $leave->reason }}</p>
            </div>
            
            <p>You can view your leave balance in the employee dashboard.</p>
            
            <div style="text-align: center; margin-top: 2rem;">
                <a href="{{ url('/dashboard') }}" class="button">Go to Dashboard</a>
            </div>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} FutureWave Software. All rights reserved.</p>
            <p>This is an automated message, please do not reply.</p>
        </div>
    </div>
</body>
</html>