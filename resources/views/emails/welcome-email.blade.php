<!DOCTYPE html>
<html>
<head>
    <title>Paragon Education</title>
</head>
<body>
    <p>Hi, {{ $user->name }} </p>
    <p>You have been successfully registered at Paragon Education as {{ $user->roles[0]->name }}</p>
    <p>Your Login credentials are below:</p>
    <p>Email: {{ $user->email }}</p>
    <p>New Password: {{ $newPassword }}</p>
    <p>Click <a href="{{ $loginUrl }}">here</a> to log in.</p>
    
</body>
</html>
