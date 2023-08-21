<!DOCTYPE html>
<html>
    <head>
        <title>Contact Form</title>
    </head>
    <body>
        <h2>Contact Form</h2>
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="fullName">Full Name : </label>
            <input type="text" id="fullName" name="fullName" autocomplete="off" placeholder="full name...">
            <br><br>
            <label for="contact">Contact : </label>
            <input type="number" id="contact" name="contact" autocomplete="off" placeholder="phone number...">
            <br><br>
            <label for="email">Email : </label>
            <input type="email" id="email" name="email" autocomplete="off" placeholder="email...">
            <br><br>
            <label for="subject">Subject : </label>
            <input type="text" id="subject" name="subject" autocomplete="off" placeholder="subject">
            <br><br>
            <label for="message">Message : </label>
            <textarea name="message" id="message" cols="22" rows="4" placeholder="atleast 20 characters"></textarea>
            <br><br>
            <input type="submit" name="submit">
        </form>
        <?php
            if(isset($_POST['submit'])){
                if($_POST['fullName'] == "" || strlen($_POST['fullName']) < 5 || strlen($_POST['fullName']) > 20){
                    echo "Please Enter Your Full Name correctly";
                    die();
                }else if(strlen($_POST['contact']) <= 8 || strlen($_POST['contact']) >= 15){
                    echo "Please Enter a Valid Contact Number";
                    die();
                }else if(strlen($_POST['subject']) <=5 || strlen($_POST['subject']) >= 50){
                    echo "Please Enter a Valid Subject";
                    die();
                }else if(strlen($_POST['message']) <= 20){
                    echo "Please enter atleast 20 charaters in your message box.";
                    die();
                }else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                    echo "Please enter valid email format";
                }else {
                    $conn = new mysqli("localhost", "root", "", "saloon");
                    $name = mysqli_real_escape_string($conn, $_POST['fullName']);
                    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
                    $email = mysqli_real_escape_string($conn, $_POST['email']);
                    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
                    $message = mysqli_real_escape_string($conn, $_POST['message']);
                    $user_ip = $_SERVER['REMOTE_ADDR'];
                    date_default_timezone_set('Asia/Kolkata');
                    $response = $conn->query("INSERT INTO contact_form (`fullName`, `contact`, `email`, `subject`, `message`, `user_ip`, `created_at`) VALUES ('$name', '$contact', '$email', '$subject', '$message', '$user_ip', date('Y-m-d'))");
                    if($response){
                        mail('admin@email.com', $subject, $message);
                        echo "Message Inserted Successfully";
                    }
                }
            }
        ?>
    </body>
</html>
