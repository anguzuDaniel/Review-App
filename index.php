<?php require_once "./includes/header.php"; ?>

<?php
Auth::isLoggedIn();

$conn = new Database();
$conn = $conn->getConn();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = User::authenticate($conn, $email, $password);

    var_dump($result);

    if ($result) {
        Auth::login();

        Url::redirect('/review-app/home.php');
    } else {
        $error = 'Incorrect username/password, Please enter correct details';
    }
}
?>
<!-- navbar | start -->
<?php require_once "./includes/navigation.php" ?>
<!-- navbar | end -->

<!-- Main Content -->
<main class="main-content ">
    <div class="container heading-container"></div>
    <div class=" d-lg-flex">
        <div class="form-img">
            <img src="./img/review.jpg" alt="" class="img w-100">
        </div>
        <form class="login-form" method="post">
            <h1 class="login-form--header">Please login!</h1>
            <div class="form-group mb-3">
                <label for="email" class="font-weight-bold">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Enter your email" name="email">
            </div>

            <div class="form-group mb-5">
                <label for="password" class="font-weight-bold">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter your password" name="password">
            </div>

            <div class="btn-area">
                <button type="submit" class="btn btn-primary btn-block font-weight-bold" name="login">Login</button>
                <a href="./signup.php" class="btn btn-secondary btn-block font-weight-bold">Create an account</a>
            </div>

            <a href="create.html" class="btn btn-link-login">Forgot password?</a>
        </form>
    </div>
</main>

<!-- Footer -->
<?php require_once "includes/footer.php"; ?>