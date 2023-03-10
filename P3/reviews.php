<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'reservation';
try {
    $pdo = new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
} catch (PDOException $exception) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to database!');
}

// Page ID needs to exist, this is used to determine which reviews are for which page.
if (isset($_GET['page_id'])) {


    if (isset($_POST['name'], $_POST['rating'], $_POST['content'])) {
        // Insert a new review (user submitted form)
        $stmt = $pdo->prepare('INSERT INTO reviews (page_id, name, content, rating, submit_date) VALUES (?,?,?,?,NOW())');
        $stmt->execute([$_GET['page_id'], $_POST['name'], $_POST['content'], $_POST['rating']]);
        exit('Your review has been submitted!');
    }
    // Get all reviews by the Page ID ordered by the submit date
    $stmt = $pdo->prepare('SELECT * FROM reviews WHERE page_id = ? ORDER BY submit_date DESC');
    $stmt->execute([$_GET['page_id']]);
    $reviews = $stmt->fetchAll();
    // Get the overall rating and total amount of reviews
    $stmt = $pdo->prepare('SELECT AVG(rating) AS overall_rating, COUNT(*) AS total_reviews FROM reviews WHERE page_id = ?');
    $stmt->execute([$_GET['page_id']]);
    $reviews_info = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    exit('Please provide the page ID.');
}
?>

    <div class="overall_rating">
        <span class="num"><?=number_format($reviews_info['overall_rating'], 1)?></span>
        <span class="stars"><?=str_repeat('&#9733;', round($reviews_info['overall_rating']))?></span>
        <span class="total"><?=$reviews_info['total_reviews']?> reviews</span>
    </div>
    <a href="#" class="write_review_btn">Write Review</a>
    <div class="write_review">
        <form>
            <input name="name" type="text" placeholder="Your Name" required>
            <input name="rating" type="number" min="1" max="5" placeholder="Rating (1-5)" required>
            <textarea name="content" placeholder="Write your review here..." required></textarea>
            <button type="submit">Submit Review</button>
        </form>
    </div>

<?php foreach ($reviews as $review){ ?>
    <div class="review">
        <h3 class="name" style="padding: 0 0 3px 0; margin: 0; font-size: 18px; color: #FFFFFF;"><?=htmlspecialchars($review['name'], ENT_QUOTES)?></h3>
        <div>
            <span class="rating"><?php if(null !== str_repeat('&#9733;', $review['rating'])) echo str_repeat('&#9733;', $review['rating'])?></span>
            <span class="date"><?php if(null !== $review['submit_date']) echo $review['submit_date']?></span>
        </div>
        <p class="content"><?php if(null !== htmlspecialchars($review['content'], ENT_QUOTES)) echo htmlspecialchars($review['content'], ENT_QUOTES)?></p>
    </div>
<?php } ?>