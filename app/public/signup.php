<!DOCTYPE html>
 <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
  </head>
  <body>
    <form method = "post" action="../Routes/signup.php">
        <label>Name:</label>
        <input type="text" name="name">
        <label>Email:</label>
        <input type="email" name="email">
        <label>Password:</label>
        <input type="password" name="password">
        <label>Phone:</label>
        <input type="text" name="phone">
        <label>Address:</label>
        <input type="text" name="address">
        <select name="role" id="role">
            <option name="role" value="">Select a role</option>
            <option name="role" value="Student">Student</option>
            <option name="role" value="Company">Company Admin</option>
            <option name="role" value="Admin">Admin</option>
        </select>

        <button type="submit">Submit</button>

    </form>
  </body>
  </html>
 