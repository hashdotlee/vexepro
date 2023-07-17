<?php
class MessageDao {
    public static function getByComplain(int $cid) : array {
        $conn = Connection::get();

        $sql = 'SELECT m.id, m.content, m.user_id, u.`role`, m.complain_id, u.name user_name'
            .' FROM messages m'
            .' JOIN users u ON m.user_id = u.id'
            .' JOIN complains c ON m.complain_id = c.id'
            .' WHERE c.id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->execute([$cid]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}