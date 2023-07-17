<?php

abstract class BaseSqlBuilder
{
    use SqlClauses;

    /**
     * The database connection object.
     *
     * @var mixed
     */
    protected $connection;

    /**
     * The type of data that should be fetched from results.
     *
     * @var integer
     */
    protected $fetchType = PDO::FETCH_OBJ;

    /**
     * The insentitive case for database type.
     *
     * @var string
     */
    protected $insensitive;

    /**
     * The logic operators (and, or).
     *
     * @var array
     */
    protected $logicOperatorss = [
        'or',
        'and',
    ];

    /**
     * Available comparisons for where clause.
     */
    protected $comparisons = [
        'equal' => '=',
        'not_equal' => '<>',
        'not_equal_other' => '!=',
        'less' => '<',
        'less_or_equal' => '<=',
        'greater' => '>',
        'greater_or_equal' => '>=',
        'like' => 'like',
        'in' => 'in',
        'not_in' => 'not in',
        'between' => 'between',
        'not_between' => 'not between',
    ];

    /**
     * Create a new query builder instance.
     *
     * @param  mixed  $connection
     * @return void
     */
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    /**
     * Get all records from query results.
     *
     * @return array
     */
    public function all()
    {
        $sql = $this->getCompiledSelectStatement();

        return $this->connection->query($sql)->fetchAll($this->fetchType);
    }

    /**
     * Get the first record from result.
     *
     * @return mixed
     */
    public function first()
    {
        $sql = $this->getCompiledSelectStatement();

        return $this->connection->query($sql)->fetch($this->fetchType);
    }

    /**
     * Add fields to the select clause.
     *
     * @param  array  $fields
     * @return void
     */
    protected function addSelect(array $fields)
    {
//        foreach ($fields as $key => $field) {
//            $fields[$key] = $this->identifierOf($field);
//        }

        $this->select = array_merge($this->select, $fields);
    }

    /**
     * Get the compiled select clause.
     *
     * @return string
     */
    protected function getCompiledSelectClause(): string
    {
        return 'select ' . implode(', ', $this->select);
    }

    /**
     * Add tables for from clause.
     *
     * @param  array  $tables
     * @return void
     */
    protected function addFrom(array $tables): void
    {
        foreach ($tables as $key => $table) {
            $tables[$key] = $this->identifierOf($table);
        }

        $this->from = array_merge($this->from, $tables);
    }

    /**
     * Get the compiled from clause.
     *
     * @return string
     */
    protected function getCompiledFromClause(): string
    {
        return 'from ' . implode(', ', $this->from);
    }

    /**
     * Add condition for where clause.
     *
     * @param string $field
     * @param string $operator
     * @param mixed $value
     * @param string $logicOperator
     * @return void
     */
    protected function addWhere(string $field, string $operator, mixed $value, string $logicOperator = 'and'): void
    {
        if (! in_array($operator, $this->comparisons)) {
            die("$operator is invalid operator.");
        }

        switch ($operator) {
            case $this->comparisons['in']:
            case $this->comparisons['not_in']:
                $value = $this->getValueForInClause($value);
                break;
            case $this->comparisons['between']:
            case $this->comparisons['not_between']:
                $value = $this->getValueForBetweenClause($value);
                break;
            default:
        }

        $field = $this->identifierOf($field);

        $this->where[] = [
            'logic_operator' => $logicOperator,
            'params' => compact('field', 'operator', 'value'),
        ];
    }

    /**
     * Add condition with logic operator to where clause.
     *
     * @param string $logicOperator
     * @param  array  $params
     * @return $this
     */
    protected function whereLogicOperator(string $logicOperator, ...$params)
    {
        list($field, $operator, $value) = $this->getParseWhereParameters($params);

        $this->addWhere($field, $operator, $value, $logicOperator);

        return $this;
    }

    /**
     * Get parse where parameters.
     *
     * @param  array  $params
     * @return array
     */
    protected function getParseWhereParameters(array $params): array
    {
        if (count($params) === 3) {
            $params[2] = "'$params[2]'";
            return $params;
        }

        if (count($params) === 2) {
            return [$params[0], $this->comparisons['equal'], "'$params[1]'"];
        }

        die('Not valid where parameters.');
    }

    /**
     * Get the compiled where clause.
     *
     * @return string
     */
    protected function getCompiledWhereClause(): string
    {
        if (empty($this->where)) {
            return '';
        }

        $conditions = '';

        foreach ($this->where as $key => $where) {
            $conditions .= $where['logic_operator'] . ' '
                . $where['params']['field'] . ' '
                . $where['params']['operator'] . ' '
                . $where['params']['value'] . ' ';
        }

        $conditions = '(' . ltrim(ltrim($conditions, 'or'), 'and') . ')';

        return 'where ' . trim($conditions);
    }

    /**
     * Get the identifier of a field or a table.
     *
     * @param string $identifier
     * @return string
     */
    protected function identifierOf(string $identifier): string
    {
        $identifier = strtolower($identifier);

        if (preg_match('/^(.+) as (.+)$/', $identifier)) {
            return $this->identifierWithAsKeywordOf($identifier);
        }

        if (strpos($identifier, '.') !== false) {
            return $this->identifierWithDotOf($identifier);
        }

        return $this->insensitive . trim($identifier) . $this->insensitive;
    }

    /**
     * Get the identifier (include as keyword) of a field or a table.
     *
     * @param string $identifier
     * @return string
     */
    protected function identifierWithAsKeywordOf(string $identifier): string
    {
        $data = explode(' as ', $identifier);

        if (count($data) == 2) {
            $baseField = $this->identifierOf($data[0]);
            $aliasField = $this->identifierOf($data[1]);

            return $baseField . ' as ' . $aliasField;
        }

        die($identifier . ' is invalid.');
    }

    /**
     * Get the identifier (include as dot) of a field or a table.
     *
     * @param string $identifier
     * @return string
     */
    protected function identifierWithDotOf(string $identifier): string
    {
        $data = explode('.', $identifier);

        if (count($data) == 2) {
            $table = $this->identifierOf($data[0]);
            $field = $this->identifierOf($data[1]);

            return $table . '.' . $field;
        }

        die($identifier . ' is invalid.');
    }

    /**
     * Get compiled sql statement.
     *
     * @return string
     */
    public function getCompiledSelectStatement(): string
    {
        $clauses['select'] = $this->getCompiledSelectClause();
        $clauses['from'] = $this->getCompiledFromClause();
        $clauses['where'] = $this->getCompiledWhereClause();

        $this->clearAllClauses();

        return implode(' ', $clauses);
    }

    /**
     * Get value of in or not in comparison.
     *
     * @param  array  $values
     * @return string
     */
    protected function getValueForInClause(array $values): string
    {
        return '(' . implode(', ', $values) . ')';
    }

    /**
     * Get value for between comparison.
     *
     * @param  array  $values
     * @return string
     */
    protected function getValueForBetweenClause(array $values): string
    {
        if (count($values) !== 2) {
            die('This is invalid for between clause.');
        }

        return $values[0] . ' and ' . $values[1];
    }

    /**
     * Clear all clauses.
     *
     * @return void
     */
    protected function clearAllClauses(): void
    {
        $this->select = [];
        $this->from = [];
        $this->where = [];
    }
}

