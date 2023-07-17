<?php
class StationDao
{
    public static function search(string $search): array
    {
        $conn = Connection::get();

        $sql = 'SELECT *'
            . ' FROM stations'
            . ' WHERE id LIKE ' . '\'%' . $search . '%\''
            . ' OR name LIKE ' . '\'%' . $search . '%\''
            . ' OR province LIKE' . '\'%' . $search . '%\'';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
