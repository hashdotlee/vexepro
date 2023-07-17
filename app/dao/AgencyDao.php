<?php
class AgencyDao
{
    public static function search(string $search): array
    {
        $conn = Connection::get();

        $sql = 'SELECT a.*, COUNT(v.id) v_number'
            . ' FROM agencies a'
            . ' LEFT JOIN vehicles v on v.agency_id = a.id'
            . ' GROUP BY a.id';
        if ($search)
            $sql = $sql
                . ' WHERE id LIKE ' . '\'%' . $search . '%\''
                . ' OR name LIKE ' . '\'%' . $search . '%\''
                . ' OR tel LIKE' . '\'%' . $search . '%\'';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
