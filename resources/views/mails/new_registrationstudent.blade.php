<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Student Registration</title>
</head>
<body>
    <h2>New Student Registration</h2>
    
    <p>Dear Backend Team,</p>
    <p>We have a new student registration in the system. Please find the details below for your reference and further processing:</p>
    
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Student Name</th>
            <td>{{ $student_name }}</td>
        </tr>
        <tr>
            <th>Student Mail ID</th>
            <td>{{ $student_email }}</td>
        </tr>
        <tr>
            <th>Student Mobile No.</th>
            <td>{{ $student_mobile }}</td>
        </tr>
        <tr>
            <th>Student Country</th>
            <td>{{ $student_country }}</td>
        </tr>
        <tr>
            <th>Registration Date</th>
            <td>{{ $registration_date }}</td>
        </tr>
        <tr>
            <th>Registration Time</th>
            <td>{{ $registration_time }}</td>
        </tr>
    </table>

    <p>Kind regards,</p>
    <p>Your System Team</p>

</body>
</html>
