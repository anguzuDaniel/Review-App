<?php require_once "includes/header.php"; ?>

<?php
$conn = new Database();
$conn = $conn->getConn();


$rates = new Rate();
$rates = $rates->getRates($conn);

$review = new Review();

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    $review = $review->addReview($conn, $name, $email, $rating, $review);

    if ($review) {
        Url::redirect('/review-app/browse.php');
    } else {
        $error = 'Something went wrong, Please try again';
    }
}
?>

<!-- navbar | start here -->
<?php include "includes/navigation.php"; ?>
<!-- navbar | end here -->

<!-- Main Content -->
<main class="main-content">
    <div class="container mt-5 submit-container">
        <h1 class="text-center mb-5">Submit a Review</h1>
        <form method="post" class="submit-form">
            <div class="form-group">
                <label for="name">Name</label> <input type="text" class="form-control px-2 py-2" id="name" placeholder="Enter your name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label> <input type="email" class="form-control px-2 py-2" id="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="review-rating">Rating:</label><br>
                <select id="review-rating" name="rating" class="px-2 py-2">
                    <?php foreach ($rates as $rate) : ?>
                        <option value="<?= $rate['id']; ?>"><?= $rate['star']; ?> stars</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="review">Review</label>
                <textarea class="form-control px-2 py-2" id="review" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
    </div>
</main>

<!-- Footer -->
<?php include "includes/footer.php"; ?>