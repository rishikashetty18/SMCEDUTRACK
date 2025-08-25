<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Information Form</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0; /* Light gray background */
    }
    .form-container {
        max-width: 500px;
        margin: 50px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #ffffff; /* White background */
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
        color: #333; /* Dark text color */
    }
    .form-group input[type="text"], .form-group input[type="password"],
    .form-group select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 3px;
        box-sizing: border-box;
    }
    .form-group input[type="submit"],
    .form-group input[type="reset"] {
        background-color: #1E90FF; /* Dark blue background */
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 3px;
        cursor: pointer;
        margin-right: 10px;
        text-align: center;
    }
    .form-group input[type="submit"]:hover,
    .form-group input[type="reset"]:hover {
        background-color: #0066cc; /* Darker blue on hover */
    }
</style>
</head>
<body>
    <div class="form-container">
        <h2>Student Information Form</h2>
        <form action="submit_student.php" method="post">
            <div class="form-group">
                <label for="student_id">Student ID:</label>
                <input type="text" id="student_id" name="student_id" required>
            </div>
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="class">Class:</label>
                <select id="class" name="class" required>
                    <option value="">Select class</option>
                    <option value="First BCA">First BCA</option>
                    <option value="Second BCA">Second BCA</option>
                    <option value="Third BCA">Third BCA</option>
                    <option value="First Bcom">First Bcom</option>
                    <option value="Second Bcom">Second Bcom</option>
                    <option value="Third Bcom">Third Bcom</option>
                    <option value="First BA">First BA</option>
                    <option value="Second BA">Second BA</option>
                    <option value="Third BA">Third BA</option>
                </select>
                <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" id="pwd" name="pwd" required>
            </div>
            </div>
            <div class="form-group">
                <input type="submit" value="Submit">
                <input type="reset" value="Reset">
            </div>
        </form>
    </div>
</body>
</html>
