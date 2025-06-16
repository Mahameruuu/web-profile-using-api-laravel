<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Selamat Datang, {{ $user['name'] }}</h2>
    <p>Role: {{ $user['role'] }}</p>
    <a href="{{ route('logout') }}">Logout</a>
</body>
</html>
