<?php

namespace Propel\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Propel\Account;
use Propel\Category;
use Propel\Resource;
use Propel\ResourceAccount;
use Propel\ResourcePeer;
use Propel\ResourceQuery;

/**
 * Base class that represents a query for the 'resource' table.
 *
 * 资源表
 *
 * @method ResourceQuery orderById($order = Criteria::ASC) Order by the id column
 * @method ResourceQuery orderByCategoryId($order = Criteria::ASC) Order by the category_id column
 * @method ResourceQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method ResourceQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method ResourceQuery orderByCreateTime($order = Criteria::ASC) Order by the create_time column
 * @method ResourceQuery orderByUpdateTime($order = Criteria::ASC) Order by the update_time column
 *
 * @method ResourceQuery groupById() Group by the id column
 * @method ResourceQuery groupByCategoryId() Group by the category_id column
 * @method ResourceQuery groupByName() Group by the name column
 * @method ResourceQuery groupByDescription() Group by the description column
 * @method ResourceQuery groupByCreateTime() Group by the create_time column
 * @method ResourceQuery groupByUpdateTime() Group by the update_time column
 *
 * @method ResourceQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ResourceQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ResourceQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ResourceQuery leftJoinCategory($relationAlias = null) Adds a LEFT JOIN clause to the query using the Category relation
 * @method ResourceQuery rightJoinCategory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Category relation
 * @method ResourceQuery innerJoinCategory($relationAlias = null) Adds a INNER JOIN clause to the query using the Category relation
 *
 * @method ResourceQuery leftJoinResourceAccount($relationAlias = null) Adds a LEFT JOIN clause to the query using the ResourceAccount relation
 * @method ResourceQuery rightJoinResourceAccount($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ResourceAccount relation
 * @method ResourceQuery innerJoinResourceAccount($relationAlias = null) Adds a INNER JOIN clause to the query using the ResourceAccount relation
 *
 * @method Resource findOne(PropelPDO $con = null) Return the first Resource matching the query
 * @method Resource findOneOrCreate(PropelPDO $con = null) Return the first Resource matching the query, or a new Resource object populated from the query conditions when no match is found
 *
 * @method Resource findOneById(int $id) Return the first Resource filtered by the id column
 * @method Resource findOneByCategoryId(int $category_id) Return the first Resource filtered by the category_id column
 * @method Resource findOneByName(string $name) Return the first Resource filtered by the name column
 * @method Resource findOneByDescription(string $description) Return the first Resource filtered by the description column
 * @method Resource findOneByCreateTime(string $create_time) Return the first Resource filtered by the create_time column
 * @method Resource findOneByUpdateTime(string $update_time) Return the first Resource filtered by the update_time column
 *
 * @method array findById(int $id) Return Resource objects filtered by the id column
 * @method array findByCategoryId(int $category_id) Return Resource objects filtered by the category_id column
 * @method array findByName(string $name) Return Resource objects filtered by the name column
 * @method array findByDescription(string $description) Return Resource objects filtered by the description column
 * @method array findByCreateTime(string $create_time) Return Resource objects filtered by the create_time column
 * @method array findByUpdateTime(string $update_time) Return Resource objects filtered by the update_time column
 *
 * @package    propel.generator.Propel.om
 */
abstract class BaseResourceQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseResourceQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = null, $modelName = null, $modelAlias = null)
    {
        if (null === $dbName) {
            $dbName = 'account_manager';
        }
        if (null === $modelName) {
            $modelName = 'Propel\\Resource';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ResourceQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ResourceQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ResourceQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ResourceQuery) {
            return $criteria;
        }
        $query = new ResourceQuery(null, null, $modelAlias);

        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array $key Primary key to use for the query
                         A Primary key composition: [$id, $category_id]
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Resource|Resource[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ResourcePeer::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ResourcePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Resource A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `category_id`, `name`, `description`, `create_time`, `update_time` FROM `resource` WHERE `id` = :p0 AND `category_id` = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Resource();
            $obj->hydrate($row);
            ResourcePeer::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return Resource|Resource[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|Resource[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ResourceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ResourcePeer::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ResourcePeer::CATEGORY_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ResourceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ResourcePeer::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ResourcePeer::CATEGORY_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ResourceQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ResourcePeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ResourcePeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ResourcePeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the category_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoryId(1234); // WHERE category_id = 1234
     * $query->filterByCategoryId(array(12, 34)); // WHERE category_id IN (12, 34)
     * $query->filterByCategoryId(array('min' => 12)); // WHERE category_id >= 12
     * $query->filterByCategoryId(array('max' => 12)); // WHERE category_id <= 12
     * </code>
     *
     * @see       filterByCategory()
     *
     * @param     mixed $categoryId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ResourceQuery The current query, for fluid interface
     */
    public function filterByCategoryId($categoryId = null, $comparison = null)
    {
        if (is_array($categoryId)) {
            $useMinMax = false;
            if (isset($categoryId['min'])) {
                $this->addUsingAlias(ResourcePeer::CATEGORY_ID, $categoryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categoryId['max'])) {
                $this->addUsingAlias(ResourcePeer::CATEGORY_ID, $categoryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ResourcePeer::CATEGORY_ID, $categoryId, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ResourceQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ResourcePeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ResourceQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ResourcePeer::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the create_time column
     *
     * Example usage:
     * <code>
     * $query->filterByCreateTime('2011-03-14'); // WHERE create_time = '2011-03-14'
     * $query->filterByCreateTime('now'); // WHERE create_time = '2011-03-14'
     * $query->filterByCreateTime(array('max' => 'yesterday')); // WHERE create_time < '2011-03-13'
     * </code>
     *
     * @param     mixed $createTime The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ResourceQuery The current query, for fluid interface
     */
    public function filterByCreateTime($createTime = null, $comparison = null)
    {
        if (is_array($createTime)) {
            $useMinMax = false;
            if (isset($createTime['min'])) {
                $this->addUsingAlias(ResourcePeer::CREATE_TIME, $createTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createTime['max'])) {
                $this->addUsingAlias(ResourcePeer::CREATE_TIME, $createTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ResourcePeer::CREATE_TIME, $createTime, $comparison);
    }

    /**
     * Filter the query on the update_time column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdateTime('2011-03-14'); // WHERE update_time = '2011-03-14'
     * $query->filterByUpdateTime('now'); // WHERE update_time = '2011-03-14'
     * $query->filterByUpdateTime(array('max' => 'yesterday')); // WHERE update_time < '2011-03-13'
     * </code>
     *
     * @param     mixed $updateTime The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ResourceQuery The current query, for fluid interface
     */
    public function filterByUpdateTime($updateTime = null, $comparison = null)
    {
        if (is_array($updateTime)) {
            $useMinMax = false;
            if (isset($updateTime['min'])) {
                $this->addUsingAlias(ResourcePeer::UPDATE_TIME, $updateTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updateTime['max'])) {
                $this->addUsingAlias(ResourcePeer::UPDATE_TIME, $updateTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ResourcePeer::UPDATE_TIME, $updateTime, $comparison);
    }

    /**
     * Filter the query by a related Category object
     *
     * @param   Category|PropelObjectCollection $category The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ResourceQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCategory($category, $comparison = null)
    {
        if ($category instanceof Category) {
            return $this
                ->addUsingAlias(ResourcePeer::CATEGORY_ID, $category->getId(), $comparison);
        } elseif ($category instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ResourcePeer::CATEGORY_ID, $category->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCategory() only accepts arguments of type Category or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Category relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ResourceQuery The current query, for fluid interface
     */
    public function joinCategory($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Category');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Category');
        }

        return $this;
    }

    /**
     * Use the Category relation Category object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Propel\CategoryQuery A secondary query class using the current class as primary query
     */
    public function useCategoryQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCategory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Category', '\Propel\CategoryQuery');
    }

    /**
     * Filter the query by a related ResourceAccount object
     *
     * @param   ResourceAccount|PropelObjectCollection $resourceAccount  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ResourceQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByResourceAccount($resourceAccount, $comparison = null)
    {
        if ($resourceAccount instanceof ResourceAccount) {
            return $this
                ->addUsingAlias(ResourcePeer::ID, $resourceAccount->getResourceId(), $comparison);
        } elseif ($resourceAccount instanceof PropelObjectCollection) {
            return $this
                ->useResourceAccountQuery()
                ->filterByPrimaryKeys($resourceAccount->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByResourceAccount() only accepts arguments of type ResourceAccount or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ResourceAccount relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ResourceQuery The current query, for fluid interface
     */
    public function joinResourceAccount($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ResourceAccount');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ResourceAccount');
        }

        return $this;
    }

    /**
     * Use the ResourceAccount relation ResourceAccount object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Propel\ResourceAccountQuery A secondary query class using the current class as primary query
     */
    public function useResourceAccountQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinResourceAccount($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ResourceAccount', '\Propel\ResourceAccountQuery');
    }

    /**
     * Filter the query by a related Account object
     * using the resource_account table as cross reference
     *
     * @param   Account $account the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   ResourceQuery The current query, for fluid interface
     */
    public function filterByAccount($account, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useResourceAccountQuery()
            ->filterByAccount($account, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   Resource $resource Object to remove from the list of results
     *
     * @return ResourceQuery The current query, for fluid interface
     */
    public function prune($resource = null)
    {
        if ($resource) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ResourcePeer::ID), $resource->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ResourcePeer::CATEGORY_ID), $resource->getCategoryId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     ResourceQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(ResourcePeer::UPDATE_TIME, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     ResourceQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(ResourcePeer::UPDATE_TIME);
    }

    /**
     * Order by update date asc
     *
     * @return     ResourceQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(ResourcePeer::UPDATE_TIME);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ResourceQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(ResourcePeer::CREATE_TIME, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     ResourceQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(ResourcePeer::CREATE_TIME);
    }

    /**
     * Order by create date asc
     *
     * @return     ResourceQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(ResourcePeer::CREATE_TIME);
    }
}
