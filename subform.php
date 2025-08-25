<?php
// sub.php — This PHP file handles form submissions and inserts data into fbcasubjects table

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sample";

try {
    // Establish PDO connection to the 'sample' database
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    // Set PDO error mode to Exception for better debugging
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form was submitted via POST method
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Retrieve form data sent from the HTML form
        $course = $_POST['course'];                 // Course (bca/ba/bcom)
        $year_of_course = $_POST['year_of_course']; // Year (First/Second/Third)
        $semester = $_POST['semester'];             // Semester number
        $subject_code = $_POST['subject_code'];     // Subject Code like BCA101
        $subject_name = $_POST['subject_name'];     // Subject Name like "C Programming"
        $faculty_name = $_POST['faculty_name'];     // Faculty Name
        $f_id = $_POST['f_id'];                     // Faculty ID

        // Prepare the SQL INSERT query — this will insert ALL form data into the table
        $stmt = $conn->prepare("INSERT INTO fbcasubjects 
            (course, year_of_course, semester, subject_code, subject_name, faculty_name, faculty_id) 
            VALUES (:course, :year_of_course, :semester, :subject_code, :subject_name, :faculty_name, :faculty_id)");

        // Binding the parameters to prevent SQL injection attacks
        $stmt->bindParam(':course', $course);
        $stmt->bindParam(':year_of_course', $year_of_course);
        $stmt->bindParam(':semester', $semester);
        $stmt->bindParam(':subject_code', $subject_code);
        $stmt->bindParam(':subject_name', $subject_name);
        $stmt->bindParam(':faculty_name', $faculty_name);
        $stmt->bindParam(':faculty_id', $f_id);

        // Execute the prepared statement
        $stmt->execute();

        // Alert the user and redirect to the list page to view the inserted data
        echo "<script>alert('Record inserted successfully!'); window.location.href='sbcalist.php';</script>";
    }
} catch(PDOException $e) {
    // Catch any PDO error and display it
    echo "Error: " . $e->getMessage();
}

// Close the database connection
$conn = null;
?>



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
        <h2> Subject Form</h2>
        <form method="POST" action="sub.php">
        <div class="form-group">
            <label for="course">Course:</label>
            <select id="course" name="course" required>
                <option value="">Select Course</option>
                <option value="bca">BCA</option>
                <option value="ba">BA</option>
                <option value="bcom">BCOM</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="year_of_course">Year of Course:</label>
            <select id="year_of_course" name="year_of_course" required>
                <option value="">Select Year of Course</option>
                <option value="First Year">First Year</option>
                <option value="Second Year">Second Year</option>
                <option value="Third Year">Third Year</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="semester">Semester:</label>
            <select id="semester" name="semester" required>
                <option value="">Select Semester</option>
                <!-- Options will be populated based on selected year -->
            </select>
        </div>
        
        <div class="form-group">
            <label for="subject_code">Subject Code:</label>
            <select id="subject_code" name="subject_code" required>
                <option value="">Select Subject Code</option>
                <!-- Options will be populated based on selected course, year, and semester -->
            </select>
        </div> 

        <div class="form-group">
            <label for="subject_name">Subject Name:</label>
            <select id="subject_name" name="subject_name" required>
                <option value="">Select Subject Name</option>
                <option value="">kannada</option>
                <!-- Options will be populated based on selected subject code -->
            </select>
        </div>

            <div class="form-group">
                <label for="faculty_name">Faculty Name:</label>
                <input type="text" id="faculty_name" name="faculty_name" placeholder="Enter your faculty name" required>
            </div>

            <div class="form-group">
            <label for="subject_code">Faculty Id:</label>
                <input type="text" name="f_id" placeholder="Enter Faculty ID">
        </div> 

            <div class="form-group">
                <input type="submit" value="Submit">
                <!-- <input type="submit" value="View" formaction="sbcalist.php"> -->
            </div>
        </form>
    </div>
</body>
<script>
        document.addEventListener("DOMContentLoaded", function() {
            const yearSemesters = {
                "First Year": ["1", "2"],
                "Second Year": ["3", "4"],
                "Third Year": ["5", "6"]
            };

            const subjectCodes = {
                "bca": {
                    "First Year": {
                        "1": ["BCA101", "BCA102","BCA103","BCA104","BCA105","BCA106"],
                        "2": ["BCA107", "BCA108","BCA109","BCA110","BCA111","BCA112"]
                    },
                    "Second Year": {
                        "3": ["BCA113", "BCA114","BCA115", "BCA116","BCA117", "BCA118"],
                        "4": ["BCA119", "BCA120","BCA121", "BCA122","BCA123", "BCA124"]
                    },
                    "Third Year": {
                        "5": ["BCA125", "BCA126","BCA127", "BCA128","BCA129", "BCA130"],
                        "6": ["BCA131", "BCA132","BCA133", "BCA134","BCA135", "BCA136"]
                    }
                },
                "bcom": {
                    "First Year": {
                        "1": ["BCOM101", "BCOM102","BCOM103","BCOM104","BCOM105","BCOM106"],
                        "2": ["BCOM107", "BCOM108","BCOM109","BCOM110","BCOM111","BCOM112"]
                    },
                    "Second Year": {
                        "3": ["BCOM113", "BCOM114","BCOM115", "BCOM116","BCOM117", "BCOM118"],
                        "4": ["BCOM119", "BCOM120","BCOM121", "BCOM122","BCOM123", "BCOM124"]
                    },
                    "Third Year": {
                        "5": ["BCOM125", "BCOM126","BCOM127", "BCOM128","BCOM129", "BCOM130"],
                        "6": ["BCOM131", "BCOM132","BCOM133", "BCOM134","BCOM135", "BCOM136"]
                    }
                },
                "ba": {
                    "First Year": {
                        "1": ["BA101", "BA102","BA103","BA104","BA105","BA106"],
                        "2": ["BA107", "BA108","BA109","BA110","BA111","BA112"]
                    },
                    "Second Year": {
                        "3": ["BA113", "BA114","BA115", "BA116","BA117", "BA118"],
                        "4": ["BA119", "BA120","BA121", "BA122","BA123", "BA124"]
                    },
                    "Third Year": {
                        "5": ["BA125", "BA126","BA127", "BA128","BA129", "BA130"],
                        "6": ["BA131", "BA132","BA133", "BA134","BA135", "BA136"]
                    }
                }
            };

            const subjectNames = {
                "BCA101": "C Programming",
                "BCA102": "Kannada",
                "BCA103": "English",
                "BCA104": "Digital Fluency",
                "BCA105": "Maths",
                "BCA106": "Fundamentals of Computer",

                "BCA107": "Data Structure",
                "BCA108": "Java",
                "BCA109": "Kannada",
                "BCA110": "English",
                "BCA111": "EVS",
                "BCA112": "Mathemetics",

                "BCA113": "C#",
                "BCA114": "DBMS",
                "BCA115": "Operating System",
                "BCA116": "Kannada",
                "BCA117": "English",
                "BCA118": "Financial Environment",

                "BCA119": "CMA",
                "BCA120": "Python",
                "BCA121": "Constitution",
                "BCA122": "Kannada",
                "BCA123": "English",
                "BCA124": "Open source Tool",

                "BCA125": "R programming",
                "BCA126": "ADA",
                "BCA127": "Employability Skills",
                "BCA128": "Software Engineering",
                "BCA129": "Cloud Computing",
                "BCA130": "Digital Marketing",
                
                "BCA131": "Advanced Java",
                "BCA132": "PHP and MySQL",
                "BCA133": "Artificial Intelligence",
                "BCA134": "MAD",
                "BCA135": "WCMS",
                "BCA136": "PHP lab",

                "BCOM101": "Office Automation",
                "BCOM102": "Financial Accounting",
                "BCOM103": "English",
                "BCOM104": "Kannada",
                "BCOM105": "Digital Fluency",
                "BCOM106": "Principles of Marketing",
                "BCOM107": "Web Designing",
                "BCOM108": "Adu FA",
                "BCOM109": "Kannada",
                "BCOM110": "English",
                "BCOM111": "Corporate Admin",
                "BCOM112": "Law and Prove of Banking",
                "BCOM113": "Program in C",
                "BCOM114": "Corporate accounting",
                "BCOM115": "Business stat",
                "BCOM116": "Kannada",
                "BCOM117": "English",
                "BCOM118": "financial education and investment",
                "BCOM119": "Cost",
                "BCOM120": "Advanced corporate accounts",
                "BCOM121": "Business Reputory",
                "BCOM122": "Kannada",
                "BCOM123": "English",
                "BCOM124": "Constitution",
                "BCOM125": "Financial Institution and Markets",
                "BCOM126": "Retail Management",
                "BCOM127": "Financial Management",
                "BCOM128": "income Tax",
                "BCOM129": "GST",
                "BCOM130": "Employability Skills",

                "BCOM131": "Investment management",
                "BCOM132": "Advanced Financial management",
                "BCOM133": "E- commerce",
                "BCOM134": "Management accounting",
                "BCOM135": "customer relationship management",
                "BCOM136": "Income Tax Law ",

                "BA101": "Basic Economics-1",
                "BA102": "Kannada",
                "BA103": "English",
                "BA104": "Contemptory Indian Economy",
                "BA105": "Cultural heritage of India",
                "BA106": "Political history of karnataka-1",

                "BA107": "Basic Economics-2",
                "BA108": "Karnataka Economy",
                "BA109": "Kannada",
                "BA110": "English",
                "BA111": "Political history of karnataka-2",
                "BA112": "EVS",

                "BA113": "Micro Economics",
                "BA114": "Mathemetics for Economics",
                "BA115": "Political history of India",
                "BA116": "Kannada",
                "BA117": "English",
                "BA118": "History of coastal Karnataka and kodagu",

                "BA119": "MacroEconoics",
                "BA120": "Statistics for Economics",
                "BA121": "Constitution",
                "BA122": "Kannada",
                "BA123": "English",
                "BA124": "History of madieval india",

                "BA125": "Public Economics",
                "BA126": "Development Economics",
                "BA127": "Indian Banking and Finance",
                "BA128": "History of western Civilization",
                "BA129": "History of eurpean",
                "BA130": "Employability skills",
                
                "BA131": "History of freedom movement and unification of karnataka",
                "BA132": "Environmental Economics",
                "BA133": "History of India",
                "BA134": "Indian public Finance",
                "BA135": "International Economics",
                "BA136": "Process of Urbanisation in India",


                // Add other subject code to name mappings here
            };
           

            

            const courseSelect = document.getElementById("course");
            const yearSelect = document.getElementById("year_of_course");
            const semesterSelect = document.getElementById("semester");
            const subjectCodeSelect = document.getElementById("subject_code");
            const subjectNameSelect = document.getElementById("subject_name");

            yearSelect.addEventListener("change", updateSemesters);
            courseSelect.addEventListener("change", updateSemesters);
            semesterSelect.addEventListener("change", updateSubjectCodes);
            subjectCodeSelect.addEventListener("change", updateSubjectNames);

            function updateSemesters() {
                const selectedYear = yearSelect.value;
                const semesters = yearSemesters[selectedYear] || [];
                
                // Clear current semester options
                semesterSelect.innerHTML = '<option value="">Select Semester</option>';
                
                // Populate new semester options
                semesters.forEach(sem => {
                    const option = document.createElement("option");
                    option.value = sem;
                    option.textContent = sem;
                    semesterSelect.appendChild(option);
                });

                // Clear subject codes and subject names when year or course changes
                subjectCodeSelect.innerHTML = '<option value="">Select Subject Code</option>';
                subjectNameSelect.innerHTML = '<option value="">Select Subject Name</option>';
            }

            function updateSubjectCodes() {
                const selectedCourse = courseSelect.value;
                const selectedYear = yearSelect.value;
                const selectedSemester = semesterSelect.value;

                const subjectCodesForSelection = (subjectCodes[selectedCourse] &&
                                                  subjectCodes[selectedCourse][selectedYear] &&
                                                  subjectCodes[selectedCourse][selectedYear][selectedSemester]) || [];
                
                // Clear current subject code options
                subjectCodeSelect.innerHTML = '<option value="">Select Subject Code</option>';
                
                // Populate new subject code options
                subjectCodesForSelection.forEach(code => {
                    const option = document.createElement("option");
                    option.value = code;
                    option.textContent = code;
                    subjectCodeSelect.appendChild(option);
                });

                // Clear subject names when subject codes change
                subjectNameSelect.innerHTML = '<option value="">Select Subject Name</option>';
            }

            function updateSubjectNames() {
                const selectedSubjectCode = subjectCodeSelect.value;
                const subjectName = subjectNames[selectedSubjectCode] || '';
                const ssubjectName = subjectNames[selectedSubjectCode] || '';

                // Clear current subject name options
                subjectNameSelect.innerHTML = '<option value="">Select Subject Name</option>';
                

                // Populate new subject name option
                if (subjectName) {
                    const option = document.createElement("option");
                    option.value = subjectName;
                    option.textContent = subjectName;
                    option.selected = true; // Automatically select the option
                    subjectNameSelect.appendChild(option);
                }
               
            }
        });
    </script>



</html>