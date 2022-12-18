<?php include "includes/header.php"; ?>
<?php
$conn = new Database();
$conn = $conn->getConn();


$reviews = new Review();
$reviews = $reviews->getReviews($conn);


?>
<!--[if lt IE 8]>
            <p class="browserupgrade">
            You are using an <strong>outdated</strong> browser. Please
            <a href="http://browsehappy.com/">upgrade your browser</a> to improve
            your experience.
            </p>
        <![endif]-->
<?php include "includes/navigation.php"; ?>
<!-- browse.html -->
<main class="main-content">
    <div class="container mt-5">
        <h1 class="text-center mb-5">Browse Reviews</h1>

        <?php foreach ($reviews as $review) : ?>
            <div class="review pb-5">
                <div class="review-header d-flex justify-content-between">
                    <div class="review-title">
                        <h3 class="mb-2"><?= $review['title']; ?></h3>
                        <div class="review-rating mb-2">
                            <?= $review['rating']; ?> stars
                        </div>
                    </div>
                    <div class="review-author">
                        <?= $review['user']; ?>
                    </div>
                </div>
                <div class="review-body mb-2">
                    <?= $review['content']; ?>

                </div>
                <div class="review-footer">
                    <?= $review['published_at']; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- <div class="reviews">
            <div class="review">
                <div class="review-header d-flex justify-content-between">
                    <div class="review-title">
                        <h3>Review Title</h3>
                        <div class="review-rating">
                            5 stars
                        </div>
                    </div>
                    <div class="review-author">
                        Review Author
                    </div>
                </div>
                <div class="review-body">
                    Lorem ipsum dolor sit amet, consectetur
                    adipiscing elit. Nulla quam velit,
                    vulputate eu pharetra nec, mattis ac neque.
                    Duis vulputate commodo lectus, ac blandit
                    elit tincidunt id. Sed rhoncus, tortor sed
                    eleifend tristique, tortor mauris molestie
                    elit, et lacinia ipsum quam nec dui.
                    Quisque nec mauris sit amet elit iaculis
                    pretium sit amet quis magna. Aenean velit
                    odio, elementum in tempus ut, vehicula eu
                    diam. Pellentesque rhoncus aliquam mattis.
                    Ut vulputate eros sed felis sodales nec
                    vulputate justo hendrerit.
                </div>
            </div>
        </div> -->
    </div>
</main>
<?php include "includes/footer.php"; ?>