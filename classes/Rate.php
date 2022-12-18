<?php

class Rate
{
    /**
     * @var [type]
     */
    public $id;

    /**
     * @var [type]
     */
    public $star;

    public function getRates($conn)
    {
        $sql = "SELECT * FROM `rating`";

        $stmt = $conn->prepare($sql);


        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
