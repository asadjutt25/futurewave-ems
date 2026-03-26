<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Salary Slip - {{ $employee->name }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .salary-slip {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .company-name {
            font-size: 22px;
            font-weight: bold;
            color: #4f46e5;
        }
        .company-details {
            font-size: 11px;
            color: #4b5563;
            margin-top: 5px;
        }
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 15px 0;
        }
        .employee-info {
            background: #f3f4f6;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .info-row {
            display: flex;
            margin-bottom: 6px;
        }
        .info-label {
            width: 120px;
            font-weight: bold;
            color: #374151;
        }
        .info-value {
            flex: 1;
            color: #1f2937;
        }
        .salary-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .salary-table th, .salary-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .salary-table th {
            background: #4f46e5;
            color: white;
        }
        .total-row {
            background: #f3f4f6;
            font-weight: bold;
        }
        .net-salary {
            background: #dcfce7;
            padding: 12px;
            text-align: right;
            font-size: 16px;
            font-weight: bold;
            margin-top: 15px;
            border-radius: 8px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }
        .signature {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        .signature-line {
            text-align: center;
            width: 200px;
        }
        .signature-line div:first-child {
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="salary-slip">
        <!-- HEADER - COMPANY DETAILS -->
        <div class="header">
            <div class="company-name">FutureWave Technologies</div>
            <div class="company-details">Noorsha, Vehari, Pakistan</div>
            <div class="company-details">Phone: +92 305 777 3073  | Email: asadshabbir7373@gmail.com</div>
        </div>

        <div class="title">SALARY SLIP</div>

        <!-- EMPLOYEE DETAILS SECTION -->
        <div class="employee-info">
            <div class="info-row">
                <div class="info-label">Employee Name:</div>
                <div class="info-value">{{ $employee->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Employee ID:</div>
                <div class="info-value">EMP-{{ str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value">{{ $employee->email }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Phone:</div>
                <div class="info-value">{{ $employee->phone ?? 'Not provided' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Address:</div>
                <div class="info-value">{{ $employee->address ?? 'Not provided' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Department:</div>
                <div class="info-value">{{ $employee->department->name ?? 'Not assigned' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Position:</div>
                <div class="info-value">{{ $employee->position ?? 'Employee' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Month:</div>
                <div class="info-value">{{ $salary->month }} {{ $salary->year }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Payment Date:</div>
                <div class="info-value">{{ $salary->payment_date->format('d M Y') }}</div>
            </div>
        </div>

        <!-- SALARY BREAKDOWN TABLE -->
        <table class="salary-table">
            <thead>
                 <tr>
                    <th colspan="2">Earnings</th>
                    <th colspan="2">Deductions</th>
                 </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Basic Salary</td>
                    <td>{{ number_format($salary->basic_salary, 2) }}</td>
                    <td>Tax</td>
                    <td>{{ number_format($salary->tax, 2) }}</td>
                </tr>
                <tr>
                    <td>Allowances</td>
                    <td>{{ number_format($salary->allowances, 2) }}</td>
                    <td>Deductions</td>
                    <td>{{ number_format($salary->deductions, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td><strong>Total Earnings</strong></td>
                    <td><strong>{{ number_format($salary->basic_salary + $salary->allowances, 2) }}</strong></td>
                    <td><strong>Total Deductions</strong></td>
                    <td><strong>{{ number_format($salary->tax + $salary->deductions, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="net-salary">
            NET SALARY: PKR {{ number_format($salary->net_salary, 2) }}
        </div>

        <div class="signature">
            <div class="signature-line">
                <div></div>
                <div>Employee Signature</div>
            </div>
            <div class="signature-line">
                <div></div>
                <div>Authorized Signatory</div>
            </div>
        </div>

        <div class="footer">
            This is a computer-generated document. No physical signature required.<br>
            For any queries, please contact HR Department.
        </div>
    </div>
</body>
</html>