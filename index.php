<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLTMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <div>
        <nav>
            <div class="logo">
                <img src="workwise.png" atl="..." height="50%" width="50%">
                <?php if (isset($_SESSION['name'])) {
            echo '<span class="welcome" style="color: white; font-size: 20px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WELCOME   </span><span style="color: white; font-size: 20px;">' . $_SESSION['name'] . '</span>';
        } ?>
            </div>
            <ul>
              <li><a href="index.html"class="active">HOME</a></li>  
              <li><a href="self.html">SELF</a></li>
              <li><a href="studt.html">STUDY LINK</a></li>
              <!--<li><a href="pomo.html">POMODORO TIMER</a></li>
              <li><a href="todo.html">TO-DO-LIST</a></li>
              <li><a href="cal.html" >CALENDAR SCHEDULING</a></li>-->
            </ul>
        </nav>
    </div>
    <div style="text-align: center; padding-top: 5%;" class="selfnstud disabled">
    <a href='self.html'>
        <!-- Image acting as button for 'self.html' -->
        <img src="self.png" alt="Self" onclick="window.location.href='self.html';">
    </a>
    <a href='studt.html'> 
        <!-- Image acting as button for 'studt.html' -->
        <img src="sl.png" alt="Study Link"  onclick="window.location.href='studt.html';">
    </a>
</div>
</body>
</html>