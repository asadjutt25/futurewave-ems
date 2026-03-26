{{-- resources/views/emails/leave-status.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Application Status</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: bold;
            margin: 15px 0;
        }
        .status-approved {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .status-rejected {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .info-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .info-table td:first-child {
            font-weight: bold;
            width: 120px;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>FutureWave Technologies</h1>
            <p>Employee Management System</p>
        </div>

        <div class="content">
            <h2>Dear {{ $leave->user->name }},</h2>

            <p>Your leave application has been <strong>{{ ucfirst($status) }}</strong>.</p>

            <div class="status-badge status-{{ $status === 'approved' ? 'approved' : 'rejected' }}">
                {{ strtoupper($status) }}
            </div>

            <h3>Leave Details:</h3>
            <table class="info-table">
                <tr>
                    <td>Leave Type:</td>
                    <td>{{ ucfirst($leave->type) }}</td>
                </tr>
                <tr>
                    <td>Start Date:</td>
                    <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d M, Y') }}</td>
                </tr>
                <tr>
                    <td>End Date:</td>
                    <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d M, Y') }}</td>
                </tr>
                <tr>
                    <td>Total Days:</td>
                    <td>{{ \Carbon\Carbon::parse($leave->start_date)->diffInDays(\Carbon\Carbon::parse($leave->end_date)) + 1 }} days</td>
                </tr>
                <tr>
                    <td>Reason:</td>
                    <td>{{ $leave->reason }}</td>
                </tr>
                @if($leave->admin_remarks)
                <tr>
                    <td>Admin Remarks:</td>
                    <td>{{ $leave->admin_remarks }}</td>
                </tr>
                @endif
                <tr>
                    <td>Reviewed By:</td>
                    <td>{{ $leave->approver->name ?? 'Admin' }}</td>
                </tr>
                <tr>
                    <td>Reviewed At:</td>
                    <td>{{ $leave->approved_at ? \Carbon\Carbon::parse($leave->approved_at)->format('d M, Y h:i A') : 'N/A' }}</td>
                </tr>
            </table>

            @if($status === 'approved')
                <p style="color: green;">✅ Your leave has been approved. Enjoy your time off!</p>
            @else
                <p style="color: red;">❌ Unfortunately, your leave request has been rejected. Please contact HR for more details.</p>
            @endif

            <a href="{{ url('/leaves') }}" class="btn">View My Leaves</a>
        </div>

        <div class="footer">
            <p>This is an automated email. Please do not reply.</p>
            <p>&copy; {{ date('Y') }} FutureWave Technologies. All rights reserved.</p>
        </div>
    </div>
</body>
</html>