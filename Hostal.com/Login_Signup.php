<?php
session_start();

include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['full_name'])) {
        $full_name = $conn->real_escape_string($_POST['full_name']);
        $address = $conn->real_escape_string($_POST['address']);
        $NIC = $conn->real_escape_string($_POST['NIC']);
        $contact_num = $conn->real_escape_string($_POST['contact_num']);
        $dob = $conn->real_escape_string($_POST['dob']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);
        $confirmPassword = $conn->real_escape_string($_POST['confirmPassword']);
        $terms = isset($_POST['terms']) ? 1 : 0;

        if ($password !== $confirmPassword) {
            echo "<script>alert('Passwords do not match!');</script>";
            exit();
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);


        $sql = "INSERT INTO users (full_name, address, NIC, contact_num, dob, email, password, terms) 
                VALUES ('$full_name', '$address', '$NIC', '$contact_num', '$dob', '$email', '$hashedPassword', '$terms')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('New record created successfully');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } 
    
    if (isset($_POST['email'])) {
        $email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);

        if ($email == 'admin@gmail.com' && $password == 'admin') {
            header("Location: admin.php");
            exit();
        } else {
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = $conn->query($sql);

            if ($result && $result->num_rows == 1) {
                $row = $result->fetch_assoc();
                
                // Verify the password
                if (password_verify($password, $row['password'])) {
                    $_SESSION['email'] = $row['email']; 
                    
                    header("Location: home.php");
                    exit();
                } else {
                    $error_message = "Invalid password.";
                }
            } else {
                $error_message = "No user found with that email.";
            }
        }
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login/Signup</title>
    <link rel="stylesheet" href="Login_Signup.css">
  </head>
  <body>
    <div class="container" id="container">
      <div class="form-container sign-in-container">
      <form method="POST" action="Login_Signup.php">
          <h1>Log In</h1>
          <input type="email" name="email" id="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" placeholder="Email" required>
          <br>
        <!-- Display email error -->
              <?php if (!empty($email_error)) { ?>
                  <span class="error"><?php echo $email_error; ?></span>
              <?php } ?>
              <br>
          <input type="password" name = "password" placeholder="Password" required />
              <!-- Display password error -->
            <?php if (!empty($password_error)) { ?>
                <span class="error"><?php echo $password_error; ?></span>
            <?php } ?>
            <br><br>
            <?php
        if (isset($error_message)) {
            echo "<p style='color:red;'>$error_message</p>";
        }
        ?>
        <br>
          <button>Log In</button>
        </form>
      </div>

      <div class="form-container sign-up-container">
      <form id="signupForm" method="POST" action="Login_Signup.php">
      <h1>Create Account</h1>

          <div class="step active">
            <input
              type="text"
              id="fullName"
              name="full_name"
              placeholder="Full Name"
              required
            />
            <input
              type="text"
              id="address"
              name="address"
              placeholder="Address"
              required
            />
            <input
              type="text"
              id="NIC"
              name="NIC"
              placeholder="NID/Passport ID Number"
              required
            />
            <input
              type="tel"
              id="contact_num"
              name="contact_num"
              placeholder="Phone Number"
              required
            />
            <input type="date" id="dob" name="dob" required />
            <button type="button" id="nextButton">Next</button>
          </div>

          <div class="step">
            <input
              type="email"
              id="email"
              name="email"
              placeholder="Email Address"
              required
            />
            <input
              type="password"
              id="password"
              name="password"
              placeholder="Password"
              required
            />
            <input
              type="password"
              id="confirmPassword"
              name="confirmPassword"
              placeholder="Confirm Password"
              required
            />
            <label for="terms">
              <input type="checkbox" id="terms" name="terms" required /> terms
              and conditions
            </label>
            <input type="submit" value="Signup" />
          </div>
        </form>
      </div>

      <div class="overlay-container">
        <div class="overlay">
          <div class="overlay-panel overlay-left">
            <h1>Welcome Back!</h1>
            <p>Please Log in to continue</p>
            <button class="ghost" id="signIn">Log In</button>
          </div>
          <div class="overlay-panel overlay-right">
            <h1>Hello hosteller..!</h1>
            <p>Enter your details to start your journey with us!</p>
            <button class="ghost" id="signUp">Sign Up</button>
          </div>
        </div>
      </div>
    </div>

    <script>
      const signInButton = document.getElementById("signIn");
      const signUpButton = document.getElementById("signUp");
      const container = document.getElementById("container");
      const nextButton = document.getElementById("nextButton");
      const steps = document.querySelectorAll(".step");

      signUpButton.addEventListener("click", () => {
        container.classList.add("right-panel-active");
      });

      signInButton.addEventListener("click", () => {
        container.classList.remove("right-panel-active");
      });

      nextButton.addEventListener("click", () => {
        steps[0].classList.remove("active");
        steps[1].classList.add("active");
      });
    </script>
  </body>
</html>
