<?php
class UserDao
{
    public static function search(string $search, string $status): array
    {
        $conn = Connection::get();

        $sql = 'SELECT *'
            . ' FROM users';
        if ($search)
            $sql = $sql
                . ' WHERE id LIKE ' . '\'%' . $search . '%\''
                . ' OR username LIKE ' . '\'%' . $search . '%\''
                . ' OR tel LIKE ' . '\'%' . $search . '%\''
                . ' OR email LIKE ' . '\'%' . $search . '%\''
                . ' OR address LIKE ' . '\'%' . $search . '%\''
                . ' OR name LIKE' . '\'%' . $search . '%\'';
        if ($status)
            $sql = $sql
                . ' WHERE deactivate_flag = ' . $status;
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
