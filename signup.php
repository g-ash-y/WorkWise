<?php
session_start();
$HOSTNAME='localhost';
$USERNAME='root';
$PASSWORD='';
$DATABASE='learning management sys';


$con=mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];
    $name = $_POST['name'];

    // SQL to insert data into signup table
    $sql = "INSERT INTO signup (username, password, user_type,name) VALUES ('$username', '$password', '$user_type','$name')";

    if ($con->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

// Close connection
$con->close();
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="C:\Users\LENOVO\Desktop\WorkWise\stylesign.css">
    <link rel="stylesheet" href="C:\Users\LENOVO\Desktop\WorkWise\style.css">
    <title>sign in/sign up</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Montserrat', sans-serif;
    
}
.logo {
    position: fixed;
    top: 20px; /* Adjust as needed */
    left: 20px; /* Adjust as needed */
}
body{
    background-color: #1a2b50;
    background: linear-gradient(to right, #221838, #1a1e2b);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    height: 100vh;
}

.container{
    background-color: #fff;
    border-radius: 30px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
    position: relative;
    overflow: hidden;
    width: 768px;
    max-width: 100%;
    min-height: 480px;
}

.container p{
    font-size: 14px;
    line-height: 20px;
    letter-spacing: 0.3px;
    margin: 20px 0;
}

.container span{
    font-size: 12px;
}

.container a{
    color: #333;
    font-size: 13px;
    text-decoration: none;
    margin: 15px 0 10px;
}

.container button{
    background-color: #512da8;
    color: #fff;
    font-size: 12px;
    padding: 10px 45px;
    border: 1px solid transparent;
    border-radius: 8px;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    margin-top: 10px;
    cursor: pointer;
}

.container button.hidden{
    background-color: transparent;
    border-color: #fff;
}

.container form{
    background-color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 40px;
    height: 100%;
}

.container input{
    background-color: #eee;
    border: none;
    margin: 8px 0;
    padding: 10px 15px;
    font-size: 13px;
    border-radius: 8px;
    width: 100%;
    outline: none;
}

.form-container{
    position: absolute;
    top: 0;
    height: 100%;
    transition: all 0.6s ease-in-out;
}

.sign-in{
    left: 0;
    width: 50%;
    z-index: 2;
}

.container.active .sign-in{
    transform: translateX(100%);
}

.sign-up{
    left: 0;
    width: 50%;
    opacity: 0;
    z-index: 1;
}

.container.active .sign-up{
    transform: translateX(100%);
    opacity: 1;
    z-index: 5;
    animation: move 0.6s;
}

@keyframes move{
    0%, 49.99%{
        opacity: 0;
        z-index: 1;
    }
    50%, 100%{
        opacity: 1;
        z-index: 5;
    }
}

.social-icons{
    margin: 20px 0;
}

.social-icons a{
    border: 1px solid #ccc;
    border-radius: 20%;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    margin: 0 3px;
    width: 40px;
    height: 40px;
}

.toggle-container{
    position: absolute;
    top: 0;
    left: 50%;
    width: 50%;
    height: 100%;
    overflow: hidden;
    transition: all 0.6s ease-in-out;
    border-radius: 150px 0 0 100px;
    z-index: 1000;
}

.container.active .toggle-container{
    transform: translateX(-100%);
    border-radius: 0 150px 100px 0;
}

.toggle{
    background-color: #18171a;
    height: 100%;
    background: linear-gradient(to right, #161929, #211340);
    color: #fff;
    position: relative;
    left: -100%;
    height: 100%;
    width: 200%;
    transform: translateX(0);
    transition: all 0.6s ease-in-out;
}

.container.active .toggle{
    transform: translateX(50%);
}

.toggle-panel{
    position: absolute;
    width: 50%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 30px;
    text-align: center;
    top: 0;
    transform: translateX(0);
    transition: all 0.6s ease-in-out;
}

.toggle-left{
    transform: translateX(-200%);
}

.container.active .toggle-left{
    transform: translateX(0);
}

.toggle-right{
    right: 0;
    transform: translateX(0);
}

.container.active .toggle-right{
    transform: translateX(200%);
}
.radio{
    transform: scale(1.0); /* Increase the size of the radio button */
    margin-right: 10px;
    display: flex;
    flex-direction: row;
}
body {
  font-family: Arial, sans-serif;
}

.container {
  text-align: center;
}
nav {
  background-color: #333;
  padding: 10px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: 0%;
  width: auto;
  margin-left: 0%;
  margin-right: 0%;


}
.logo img {
  size: 100PX;
  width:200px;
  color: #ccc;
}
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  display: flex;
}
li {
  margin-right: 20px;
}
a {
  color: #fff;
  text-decoration: none;
  padding: 10px;
  transition: background-color 0.3s ease;
}
a:hover {
  background-color: #555;
}
a.active {
  background-color: #555;
}

#timer {
  margin-top: 20px;
}

#time {
  font-size: 36px;
  margin-bottom: 10px;
}

button {
  font-size: 18px;
  padding: 10px 20px;
  margin: 0 10px;
  cursor: pointer;
}
.image-container{
  background-color: #afaeae;
  text-align: center;
  height:150px;
}
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
.oc{
  width: 70%;
}
.gallery{
width: 900px;
display: flex;
overflow-x: scroll;
}
.gallery div{
width: 100%;
display: grid;
grid-template-columns: auto auto auto;
grid-gap:20px;
padding: 10px;
flex: none;
}
.gallery div img{
width: 100%; 
 filter:grayscale(100%);
transition:  transform 0.5s;
}
.gallery::-webkit-scrollbar{
display: none;
}
.gallery-wrap{
display: flex;
align-items: center;
justify-content: center;
margin: 10% auto;
}

.gallery div img:hover{
filter:grayscale(0);
cursor: pointer;
transform: scale(1.1);

}
nav {
  background-color: #333;
  padding: 10px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.logo img {
  width: 100px;
}

ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  display: flex;
}

li {
  margin-right: 20px;
}

a {
  color: #fff;
  text-decoration: none;
  padding: 10px;
  transition: background-color 0.3s ease;
}

a:hover {
  background-color: #555;
}

a.active {
  background-color: #555;
}
.content {
  /* Adjust the bottom padding to accommodate the fixed footer */
  padding-bottom: 30px; /* Height of the fixed footer */
}

.footer {
  position:relative;
  bottom: 0;
  width: 100%;
  background-color: #333;
  color: white;
  text-align: center;
  padding: 15px;
}
.selfnstud:hover {
  pointer-events: none;
  background-color: #fff;
}
        </style>
</head>

<body>
    <!--<div>
        <nav>
            <div class="logo">
                <img src="workwise.png" atl="..." height="50%" width="50%">
            </div>
            <ul>
              <li><a href="index.html"class="active">HOME</a></li>  
              <li><a href="self.html">SELF</a></li>
              <li><a href="studt.html">STUDY LINK</a></li>
             <li><a href="pomo.html">POMODORO TIMER</a></li>
              <li><a href="todo.html">TO-DO-LIST</a></li>
              <li><a href="cal.html" >CALENDAR SCHEDULING</a></li>
            </ul>
        </nav>
    </div>-->
    <div class="logo">
        <img src="workwise.png" atl="..." height="50%" width="50%">
    </div>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="signup.php" method="post" class="contact-input mt-5 position-relative" >
                <h1>Create Account</h1>
                <div class="social-icons">
                    <!--
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                    -->
                </div>
                <!--
                <span>or use your email for registeration</span>
                -->
                <input type="text" placeholder="Name" name="name" >
                <input type="email" placeholder="Email" name="username">
                <input type="password" placeholder="Password" name="password">
                <div class="radio">
                <input type="radio" name="user_type" value="teacher">Teacher</input>&nbsp;&nbsp;&nbsp;
 
                 <input type="radio" name="user_type" value="student">Student</input>&nbsp;&nbsp;
               
                 <input type="radio" name="user_type" value="personal">Personal</input>&nbsp;&nbsp;&nbsp;
            </div>
                <button>Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="signin.php" method="post" class="contact-input mt-5 position-relative">
                <h1>Sign In</h1>
                <div class="social-icons">
                    <!--
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                    -->
                </div>
                <!--
                <span>or use your email password</span>
                -->
                <input type="email" placeholder="Email" name="usernamein">
                <input type="password" placeholder="Password" name="passwordin">
                <br>
               
            <!--
                <a href="#">Forget Your Password?</a>
            -->
                <button>Sign In</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});
    </script>
    <?php if(isset($_SESSION['login_error']) && $_SESSION['login_error']): ?>
    <div id="popup-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 999;"></div>
    <div id="popup" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff; padding: 20px; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); z-index: 1000;">
        <p style="margin: 0; text-align: center; color: darkblue;"><b>Invalid credentials or user not approved by admin</b></p>
        <button onclick="dismissPopup()" style="margin-top: 10px; padding: 5px 10px; background-color: blue; color: white; border-radius: 50px; cursor: pointer;">Dismiss</button>
    </div>
    <?php endif; ?>

    <!-- Your HTML script content goes here -->
    <script>
        function dismissPopup() {
            document.getElementById('popup-overlay').style.display = 'none';
            document.getElementById('popup').style.display = 'none';
        }
    </script>

    <script src="scriptsign.js"></script>
</body>

</html>