<?php
class Database
{
    public static function add(string $table, array $data): bool
    {
        $conn = Connection::get();
        $columns = implode(', ', array_keys($data));
        $values = array_values($data);

        $s = sizeof($data);
        $blanks = implode(', ', array_fill(0, $s, '?'));

        $sql = "INSERT INTO " . $table . "(" . $columns . ") values (" . $blanks . ")";

        $stmt = $conn->prepare($sql);

        return $stmt->execute($values);
    }

    public static function get(string $table, string $col, string $comparison, mixed $value): array
    {
        $conn = Connection::get();

        $builder = new MySqlBuilder($conn);

        $obj = $builder
            ->select('*')
            ->from($table)
            ->where($col, $comparison, $value)
            ->all();

        return $obj;
    }

    public static function getDistinct(string $table, string $col): array
    {
        $conn = Connection::get();

        $builder = new MySqlBuilder($conn);

        $obj = $builder
            ->select('distinct(' . $col . ')')
            ->from($table)
            ->all();

        return $obj;
    }

    public static function getAll(string $table): array
    {
        $conn = Connection::get();

        $builder = new MySqlBuilder($conn);
        $data = $builder
            ->select()
            ->from($table)
            ->all();

        return $data;
    }

    public static function delete(string $table, int $id): bool
    {
        $conn = Connection::get();

        $sql = "DELETE FROM " . $table . " WHERE id = ?";
        $stmt = $conn->prepare($sql);

        return $stmt->execute([$id]);
    }

    public static function update(string $table, string $col, string $value, int $id): bool
    {
        $conn = Connection::get();

        $sql = "UPDATE " . $table . " SET " . $col . " = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);

        return $stmt->execute([$value, $id]);
    }
    public static function updateMany(string $tableName, $data, $where): bool
    {
        $conn = Connection::get();
        // Build the SET clause of the SQL statement
        $setClause = '';
        foreach ($data as $key => $value) {
            $setClause .= "`$key`=:value_$key,";
        }
        $setClause = rtrim($setClause, ',');

        // Build the WHERE clause of the SQL statement
        $whereClause = '';
        foreach ($where as $key => $value) {
            $whereClause .= "`$key`=:where_$key AND ";
        }
        $whereClause = rtrim($whereClause, ' AND ');

        // Build the complete SQL statement
        $sql = "UPDATE `$tableName` SET $setClause WHERE $whereClause";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Bind the values to the placeholders in the SQL statement
        foreach ($data as $key => $value) {
            $stmt->bindValue(":value_$key", $value);
        }
        foreach ($where as $key => $value) {
            $stmt->bindValue(":where_$key", $value);
        }

        return  $stmt->execute();
    }
}
