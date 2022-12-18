<?php
class Review
{
    public $id;
    public $content;
    public $rating;
    public $userId;
    public static $count = 0;

    /**
     * @param mixed $conn
     * @param mixed $userId
     * @param mixed $content
     * @param mixed $rating
     * 
     * @return [type]
     */
    public function addReview($conn, $userId, $content, $rating)
    {
        $sql = 'INSERT INTO review (content, rating, user_id) 
                VALUES (:content, :rating, :userId)';

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':content', $content, PDO::PARAM_STR);
        $stmt->bindValue(':rating', $rating, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getReviews($conn)
    {
        $sql = "SELECT 
                r.id, 
                r.title, 
                r.content, 
                r.published_at, 
                r.rating, 
                r.user_id,
                u.user_name AS user
                FROM review AS r
                INNER JOIN user AS u ON r.user_id = u.id";

        $stmt = $conn->prepare($sql);


        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
