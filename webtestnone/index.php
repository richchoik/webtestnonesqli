<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spine - Đăng nhập hoặc đăng ký</title>
    <style>
        .container {
            max-width: 1170px;
            width: 100%;
            padding-left: 15px;
            padding-right: 15px;
            margin: auto;
            padding-bottom:15px;
            border-radius: 15px;
            border: 2px solid rgb(137, 247, 192);
        }
        .row {
            display: flex;
            button {
                background-color: rgb(13, 171, 108);
                width: 150px;
                height: 40px;
                border-radius: 10px;
                margin-right:20px;
            }
            button:hover{
                background-color: aquamarine;
            }
        }
        .col-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }
        .col-6 {
            flex: 0 0 50%;
            max-width: 50%;
            
        }
        .left {
            width: 30%;
            padding-top: 10px;
            font-size: 20px;
        }
        .right {
            input {
                width: 300px;
                height: 40px;
                margin-bottom: 10px;
                font-size: 14px;
                font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                font-weight: 500;
                border-radius: 20px;
                padding-left: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
      <div class="row">
        <div class="col-3"></div>
          <div class="col-6">
            <h1>ĐĂNG NHẬP</h1>
              <form action="index.php" method="post">
                <div class="row">
                  <div class="left">
                    Tên đăng nhập
                  </div>
                  <div class="right">
                    <input type="text" name="username">
                  </div>
                </div>
                <div class="row">
                  <div class="left">
                    Mật khẩu
                  </div>
                  <div class="right">
                    <input type="password" name="password">
                  </div>
                </div>
                <div class="row">
                  <button name="login_btn">Đăng nhập</button>
                  <button name="signup_btn">Đăng ký</button>
                </div>    
                    
              </form>
        </div>
      </div>
    </div>
    
</body>
</html>

<?php
    include "connect.php";
    session_start();
    
    function isValid($input) {
        // Biểu thức chính quy kiểm tra xem chuỗi có chỉ chứa chữ cái in hoa, in thường, số và dấu chấm không
        return preg_match('/^[a-zA-Z0-9.]+$/', $input);
    }

    if(isset($_SESSION['username'])) {
        header('location:newfeed.php');
    }
    $message = "";
    if(isset($_POST['login_btn'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
            $query = "SELECT * FROM users_acc WHERE username='$username' AND password='$password' ";
            $result = mysqLi_query($conn, $query);
            $count = mysqli_num_rows($result);

            if($count!==0) { //nếu tìm thấy tài khoản
                $_SESSION['username']=$username;
                $query2 = "SELECT user_id FROM users_acc WHERE username = '$username'";//lấy user_id ra để dùng cho các thao tác sau
                $query3 = "SELECT name FROM users_acc WHERE username = '$username'"; //lấy tên ra để sau dùng
                $result2 = mysqli_query($conn, $query2);
                if(mysqli_num_rows($result2) > 0)
                {
                    $row = mysqli_fetch_assoc($result2);
                    $user_id = $row['user_id'];
                    $_SESSION['user_id'] = $user_id;
                }
                $result3 = mysqli_query($conn, $query3);
                //var_dump($result3);
                if(mysqli_num_rows($result3) > 0)
                {
                    $row = mysqli_fetch_assoc($result3);
                    $name = $row['name'];
                    $_SESSION['name'] = $name;
                }
                header("location:newfeed.php?id=$user_id");
                //var_dump($result);
            }
            else 
            {
              $message = "Tài khoản không tồn tại hoặc mật khẩu không chính xác";   
              //var_dump($username);
              //var_dump($query);
            }
        }
        echo $message;
    //}
    if(isset($_POST['signup_btn'])) header("location:signup.php");
?>