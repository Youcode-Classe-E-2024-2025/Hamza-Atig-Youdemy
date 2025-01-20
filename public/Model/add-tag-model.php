<?php
class Tag {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function addTag($tagName) {
        $query = 'INSERT INTO tags (tag_name) VALUES (:tag_name)';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':tag_name', $tagName);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // 23000 is the SQLSTATE for duplicate entry
                return false;
            }
            throw $e;
        }
    }

    public function addTags($tags) {
        $results = [];
        foreach ($tags as $tag) {
            $tag = trim($tag);
            if (!empty($tag)) {
                $results[$tag] = $this->addTag($tag);
            }
        }
        return $results;
    }
}
?>