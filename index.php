<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    label{
        font-weight:bold;
        font-size: 20px;
    }
    .login-container {
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      padding: 40px;
      border-radius: 10px;
      width: 500px;
      height : 400px;
      max-width: 100%;
      text-align: center;
    }

    .login-container img {
      max-width: 100%;
      height: 50px;
      margin-bottom: 20px;
    }

    .login-container input {
      width: 80%;
      margin-top:30px;
      padding: 15px;
      margin-bottom: 15px;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .login-container button {
      background-color: #4caf50;
      color: #fff;
      padding: 10px 25px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }

    @media screen and (max-width: 400px) {
      .login-container {
        width: 90%;
      }
    }
  </style>
</head>
<body>
<?php
    if(isset($_GET['notif'])){
      if($_GET['notif'] == "gagal"){
        echo "<script>alert('Username or Password Failed !')</script>";
      }
  }
  if(isset($_GET['alert'])){
    if($_GET['alert'] == "logout"){
      echo "<script>alert('Success Logout !')</script>";
    }
}
?>

<div class="login-container">
    <img src="assets/images/logo.png" alt="Logo" width="200" height="auto"/><br>
    <label for="login">LOGIN</label><br><br>
    <form action="auth.php" method="post">
        <input type="text" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign in</button>
    </form>
</div>


</body>
</html>
