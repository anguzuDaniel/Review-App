<?php require_once "./includes/header.php"; ?>

<?php
Auth::isLoggedIn();

$conn = new Database();
$conn = $conn->getConn();

if (isset($_POST['submit'])) {
    $user = new User();
    $user->name = $_POST['name'];
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];


    $user = $user->addUser($conn,  $user->email, $user->name, $user->password);

    var_dump($user);
    if ($user) {
        header('Location: index.php');
    } else {
        echo "Invalid credentials";
    }
}
?>
<!-- navbar | start -->
<?php require_once "includes/navigation.php" ?>
<!-- navbar | end -->
<!-- Main Content -->
<main class="main-content">
    <div class="container heading-container"></div>
    <div class="container container-login">
        <form class="login-form mx-auto" method="post">
            <h1 class="login-form--header">Please login!</h1>

            <div class="form-group mb-3">
                <label for="email" class="font-weight-bold">User Name</label>
                <input type="text" class="form-control" id="email" placeholder="Enter your email" name="name">
            </div>

            <div class="form-group mb-3">
                <label for="email" class="font-weight-bold">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Enter your email" name="email">
            </div>

            <div class="form-group mb-5">
                <label for="password" class="font-weight-bold">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter your password" name="password">
            </div>

            <div class="btn-area">
                <button type="submit" class="btn btn-primary btn-block font-weight-bold" name="submit">Create an account</button>
                <a href="./index.php" class="btn btn-secondary btn-block font-weight-bold">Login</a>
            </div>

            <a href="create.html" class="btn btn-link-login">Forgot password?</a>
        </form>
    </div>
</main>

<!-- Footer -->
<?php require_once "includes/footer.php"; ?>