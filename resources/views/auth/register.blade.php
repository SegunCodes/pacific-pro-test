<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>
<body>

    <h2>User Registration Form</h2>

    <form method="POST" action="{{ url('/register') }}" enctype="multipart/form-data">
        <!-- No @csrf directive, Laravel will handle CSRF protection automatically -->

        <label for="name">Name:</label>
        <input type="text" name="name" required>

        <br>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <br>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <br>

        <label for="profile_picture">Profile Picture:</label>
        <input type="file" name="profile_picture" accept="image/*">

        <br>

        <button type="submit">Register</button>
    </form>

</body>
</html>
