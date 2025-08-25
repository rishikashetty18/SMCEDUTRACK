<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .form-container {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            color: #1E90FF;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group input[type='text'],
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
            box-sizing: border-box;
        }

        .form-group input[type='submit'] {
            background-color: #1E90FF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .form-group input[type='submit']:hover {
            background-color: #0e74b8;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Subject Form</h2>
        <form method="POST" action="secondbainsert.php">
            <div class="form-group">
                <label for="subject_code">Subject Code:</label>
                <input type="text" id="subject_code" name="subject_code" placeholder="Enter Your Subject Code" required>
            </div>
            <div class="form-group">
                <label for="subject_name">Subject Name:</label>
                <select id="subject_name" name="subject_name" required>
                    <option value="">Select Subject Name</option>
                    <option value="Mathematics">Mathematics</option>
                    <option value="C Programming">C Programming</option>
                    <option value="Fundamentals of Computer">Fundamentals of Computer</option>
                    <option value="Kannada">Kannada</option>
                    <option value="English">English</option>
                    <option value="Digital Fluency">Digital Fluency</option>
                    <!-- Add more options as needed -->
                </select>
            </div>
            <div class="form-group">
                <label for="faculty_name">Faculty Name:</label>
                <input type="text" id="faculty_name" name="faculty_name" placeholder="Enter Your faculty name" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Submit">
                <input type="submit" value="View" formaction="sbalist.php">
            </div>
        </form>
    </div>
</body>

</html>
