<?php

trait SqlClauses
{
    /**
     * Select clause parameters.
     *
     * @var array
     */
    protected $select = [];

    /**
     * From clause parameters.
     *
     * @var array
     */
    protected $from = [];

    /**
     * Where clause parameters.
     *
     * @var array
     */
    protected $where = [];

    /**
     * Group By clause parameters.
     *
     * @var array
     */
    protected $groupBy = [];

    /**
     * Having clause parameters.
     *
     * @var array
     */
    protected $having = [];

    /**
     * Order By clause parameters.
     *
     * @var array
     */
    protected $orderBy = [];

    /**
     * Limit Clause parameters.
     *
     * @var integer
     */
    protected $limit;

    /**
     * Offset clause parameters.
     *
     * @var integer
     */
    protected $offset;

    /**
     * Apply select clause.
     *
     * @param  mixed  $fields
     * @return $this
     */
    public function select($fields = ['*'])
    {
        $fields = is_array($fields) ? $fields : func_get_args();

        $this->addSelect($fields);

        return $this;
    }

    public function delete() {

    }

    /**
     * Apply from clause.
     *
     * @param  mixed  $tables
     * @return $this
     */
    public function from($tables)
    {
        $tables = is_array($tables) ? $tables : func_get_args();

        $this->addFrom($tables);

        return $this;
    }

    /**
     * Apply where clause.
     *
     * @param  array  $params
     * @return $this
     */
    public function where(...$params)
    {
        return $this->andWhere(...$params);
    }

    /**
     * Apply where clause with and.
     *
     * @param  array  $params
     * @return $this
     */
    public function andWhere(...$params)
    {
        return $this->whereLogicOperator('and', ...$params);
    }

    /**
     * Apply where clause with or.
     *
     * @param  array  $params
     * @return $this
     */
    public function orWhere(...$params)
    {
        return $this->whereLogicOperator('or', ...$params);
    }
}

