<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLTMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        body{
            background-color:rgba(0, 131, 140, 0.13) ;
            
        }
        </style>
</head>
<body>
  <div>
        <nav>
            <div class="logo">
                <img src="workwise.png" atl="..." height="50%" width="50%">
                <?php if (isset($_SESSION['name'])) {
            echo '<span class="welcome" style="color: white; font-size: 20px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>WELCOME  </b> </span><span style="color: white; font-size: 20px; ">'. $_SESSION['name'] . '</span>';
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
    <div>

      <a href="self.html" class="button"><img id="button" src="self.png" style="padding:  30px; margin-left: 50px; margin-right: 50px;" ></a>

      <a href="studt.html"  class="button"><img id="button" src="sl.png" style="padding:  30px; margin-left:50px ; margin-right: 50px;" ></a></div>
    

</body>
</html>