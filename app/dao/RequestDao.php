<?php
class RequestDao
{
    public static function search(string $search, string $status): array
    {
        $conn = Connection::get();

        $sql = 'SELECT *'
            . ' FROM requests r' 
            . ' LEFT JOIN users u on u.id = r.user_id';
        if ($search)
            $sql = $sql
                . ' WHERE id LIKE ' . '\'%' . $search . '%\''
                . ' OR ticket_id LIKE ' . '\'%' . $search . '%\''
                . ' OR u.name LIKE ' . '\'%' . $search . '%\''
                . ' OR bank_name LIKE ' . '\'%' . $search . '%\''
                . ' OR content LIKE ' . '\'%' . $search . '%\''
                . ' OR name LIKE' . '\'%' . $search . '%\'';
        if ($status)
            $sql = $sql
                . ' WHERE status = ' . $status;
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
