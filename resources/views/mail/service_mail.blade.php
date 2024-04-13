<!DOCTYPE html>
<html>
<head>
    <title>Service Requested</title>
</head>
<body>
    <h2>Service Requested</h2>
    <p>A new service has been submitted:</p>
    <ul>
        <li><strong>Service Provider:</strong> {{ $service->service_provider }}</li>
        <li><strong>Service Name:</strong> {{ $service->service_name }}</li>
        <li><strong>Service Type:</strong> {{ $service->service_type_id }}</li>
        <li><strong>Details:</strong> {{ $service->details }}</li>
    </ul>
    <p>Please review and take necessary actions.</p>
</body>
</html>
