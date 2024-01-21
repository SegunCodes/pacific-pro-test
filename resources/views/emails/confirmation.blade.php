<!DOCTYPE html>
<html>
<head>
    <title>Email Confirmation</title>
</head>
<body>
    <h2>Email Confirmation</h2>
    <p>Dear {{ $user->name }},</p>
    <p>Thank you for registering. Please click the link below to confirm your email:</p>
    <a href="{{ url('/confirm/' . $user->confirmation_token) }}">Confirm Email</a>
</body>
</html>
