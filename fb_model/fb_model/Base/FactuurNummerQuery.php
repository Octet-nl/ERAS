<?php

namespace fb_model\fb_model\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use fb_model\fb_model\FactuurNummer as ChildFactuurNummer;
use fb_model\fb_model\FactuurNummerQuery as ChildFactuurNummerQuery;
use fb_model\fb_model\Map\FactuurNummerTableMap;

/**
 * Base class that represents a query for the 'fb_factuur' table.
 *
 *
 *
 * @method     ChildFactuurNummerQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildFactuurNummerQuery orderByInschrijvingId($order = Criteria::ASC) Order by the inschrijving_id column
 * @method     ChildFactuurNummerQuery orderByDatumGemaakt($order = Criteria::ASC) Order by the gemaakt_datum column
 * @method     ChildFactuurNummerQuery orderByGemaaktDoor($order = Criteria::ASC) Order by the gemaakt_door column
 * @method     ChildFactuurNummerQuery orderByDatumGewijzigd($order = Criteria::ASC) Order by the gewijzigd_datum column
 * @method     ChildFactuurNummerQuery orderByGewijzigdDoor($order = Criteria::ASC) Order by the gewijzigd_door column
 *
 * @method     ChildFactuurNummerQuery groupById() Group by the id column
 * @method     ChildFactuurNummerQuery groupByInschrijvingId() Group by the inschrijving_id column
 * @method     ChildFactuurNummerQuery groupByDatumGemaakt() Group by the gemaakt_datum column
 * @method     ChildFactuurNummerQuery groupByGemaaktDoor() Group by the gemaakt_door column
 * @method     ChildFactuurNummerQuery groupByDatumGewijzigd() Group by the gewijzigd_datum column
 * @method     ChildFactuurNummerQuery groupByGewijzigdDoor() Group by the gewijzigd_door column
 *
 * @method     ChildFactuurNummerQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildFactuurNummerQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildFactuurNummerQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildFactuurNummerQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildFactuurNummerQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildFactuurNummerQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildFactuurNummerQuery leftJoinInschrijving($relationAlias = null) Adds a LEFT JOIN clause to the query using the Inschrijving relation
 * @method     ChildFactuurNummerQuery rightJoinInschrijving($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Inschrijving relation
 * @method     ChildFactuurNummerQuery innerJoinInschrijving($relationAlias = null) Adds a INNER JOIN clause to the query using the Inschrijving relation
 *
 * @method     ChildFactuurNummerQuery joinWithInschrijving($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Inschrijving relation
 *
 * @method     ChildFactuurNummerQuery leftJoinWithInschrijving() Adds a LEFT JOIN clause and with to the query using the Inschrijving relation
 * @method     ChildFactuurNummerQuery rightJoinWithInschrijving() Adds a RIGHT JOIN clause and with to the query using the Inschrijving relation
 * @method     ChildFactuurNummerQuery innerJoinWithInschrijving() Adds a INNER JOIN clause and with to the query using the Inschrijving relation
 *
 * @method     \fb_model\fb_model\InschrijvingQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildFactuurNummer findOne(ConnectionInterface $con = null) Return the first ChildFactuurNummer matching the query
 * @method     ChildFactuurNummer findOneOrCreate(ConnectionInterface $con = null) Return the first ChildFactuurNummer matching the query, or a new ChildFactuurNummer object populated from the query conditions when no match is found
 *
 * @method     ChildFactuurNummer findOneById(int $id) Return the first ChildFactuurNummer filtered by the id column
 * @method     ChildFactuurNummer findOneByInschrijvingId(int $inschrijving_id) Return the first ChildFactuurNummer filtered by the inschrijving_id column
 * @method     ChildFactuurNummer findOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildFactuurNummer filtered by the gemaakt_datum column
 * @method     ChildFactuurNummer findOneByGemaaktDoor(string $gemaakt_door) Return the first ChildFactuurNummer filtered by the gemaakt_door column
 * @method     ChildFactuurNummer findOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildFactuurNummer filtered by the gewijzigd_datum column
 * @method     ChildFactuurNummer findOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildFactuurNummer filtered by the gewijzigd_door column *

 * @method     ChildFactuurNummer requirePk($key, ConnectionInterface $con = null) Return the ChildFactuurNummer by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFactuurNummer requireOne(ConnectionInterface $con = null) Return the first ChildFactuurNummer matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFactuurNummer requireOneById(int $id) Return the first ChildFactuurNummer filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFactuurNummer requireOneByInschrijvingId(int $inschrijving_id) Return the first ChildFactuurNummer filtered by the inschrijving_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFactuurNummer requireOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildFactuurNummer filtered by the gemaakt_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFactuurNummer requireOneByGemaaktDoor(string $gemaakt_door) Return the first ChildFactuurNummer filtered by the gemaakt_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFactuurNummer requireOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildFactuurNummer filtered by the gewijzigd_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFactuurNummer requireOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildFactuurNummer filtered by the gewijzigd_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFactuurNummer[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildFactuurNummer objects based on current ModelCriteria
 * @method     ChildFactuurNummer[]|ObjectCollection findById(int $id) Return ChildFactuurNummer objects filtered by the id column
 * @method     ChildFactuurNummer[]|ObjectCollection findByInschrijvingId(int $inschrijving_id) Return ChildFactuurNummer objects filtered by the inschrijving_id column
 * @method     ChildFactuurNummer[]|ObjectCollection findByDatumGemaakt(string $gemaakt_datum) Return ChildFactuurNummer objects filtered by the gemaakt_datum column
 * @method     ChildFactuurNummer[]|ObjectCollection findByGemaaktDoor(string $gemaakt_door) Return ChildFactuurNummer objects filtered by the gemaakt_door column
 * @method     ChildFactuurNummer[]|ObjectCollection findByDatumGewijzigd(string $gewijzigd_datum) Return ChildFactuurNummer objects filtered by the gewijzigd_datum column
 * @method     ChildFactuurNummer[]|ObjectCollection findByGewijzigdDoor(string $gewijzigd_door) Return ChildFactuurNummer objects filtered by the gewijzigd_door column
 * @method     ChildFactuurNummer[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class FactuurNummerQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \fb_model\fb_model\Base\FactuurNummerQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\fb_model\\fb_model\\FactuurNummer', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildFactuurNummerQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildFactuurNummerQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildFactuurNummerQuery) {
            return $criteria;
        }
        $query = new ChildFactuurNummerQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
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
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildFactuurNummer|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FactuurNummerTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = FactuurNummerTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildFactuurNummer A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, inschrijving_id, gemaakt_datum, gemaakt_door, gewijzigd_datum, gewijzigd_door FROM fb_factuur WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildFactuurNummer $obj */
            $obj = new ChildFactuurNummer();
            $obj->hydrate($row);
            FactuurNummerTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildFactuurNummer|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildFactuurNummerQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FactuurNummerTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildFactuurNummerQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FactuurNummerTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFactuurNummerQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(FactuurNummerTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(FactuurNummerTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FactuurNummerTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the inschrijving_id column
     *
     * Example usage:
     * <code>
     * $query->filterByInschrijvingId(1234); // WHERE inschrijving_id = 1234
     * $query->filterByInschrijvingId(array(12, 34)); // WHERE inschrijving_id IN (12, 34)
     * $query->filterByInschrijvingId(array('min' => 12)); // WHERE inschrijving_id > 12
     * </code>
     *
     * @see       filterByInschrijving()
     *
     * @param     mixed $inschrijvingId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFactuurNummerQuery The current query, for fluid interface
     */
    public function filterByInschrijvingId($inschrijvingId = null, $comparison = null)
    {
        if (is_array($inschrijvingId)) {
            $useMinMax = false;
            if (isset($inschrijvingId['min'])) {
                $this->addUsingAlias(FactuurNummerTableMap::COL_INSCHRIJVING_ID, $inschrijvingId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($inschrijvingId['max'])) {
                $this->addUsingAlias(FactuurNummerTableMap::COL_INSCHRIJVING_ID, $inschrijvingId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FactuurNummerTableMap::COL_INSCHRIJVING_ID, $inschrijvingId, $comparison);
    }

    /**
     * Filter the query on the gemaakt_datum column
     *
     * Example usage:
     * <code>
     * $query->filterByDatumGemaakt('2011-03-14'); // WHERE gemaakt_datum = '2011-03-14'
     * $query->filterByDatumGemaakt('now'); // WHERE gemaakt_datum = '2011-03-14'
     * $query->filterByDatumGemaakt(array('max' => 'yesterday')); // WHERE gemaakt_datum > '2011-03-13'
     * </code>
     *
     * @param     mixed $datumGemaakt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFactuurNummerQuery The current query, for fluid interface
     */
    public function filterByDatumGemaakt($datumGemaakt = null, $comparison = null)
    {
        if (is_array($datumGemaakt)) {
            $useMinMax = false;
            if (isset($datumGemaakt['min'])) {
                $this->addUsingAlias(FactuurNummerTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGemaakt['max'])) {
                $this->addUsingAlias(FactuurNummerTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FactuurNummerTableMap::COL_GEMAAKT_DATUM, $datumGemaakt, $comparison);
    }

    /**
     * Filter the query on the gemaakt_door column
     *
     * Example usage:
     * <code>
     * $query->filterByGemaaktDoor('fooValue');   // WHERE gemaakt_door = 'fooValue'
     * $query->filterByGemaaktDoor('%fooValue%', Criteria::LIKE); // WHERE gemaakt_door LIKE '%fooValue%'
     * </code>
     *
     * @param     string $gemaaktDoor The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFactuurNummerQuery The current query, for fluid interface
     */
    public function filterByGemaaktDoor($gemaaktDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gemaaktDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FactuurNummerTableMap::COL_GEMAAKT_DOOR, $gemaaktDoor, $comparison);
    }

    /**
     * Filter the query on the gewijzigd_datum column
     *
     * Example usage:
     * <code>
     * $query->filterByDatumGewijzigd('2011-03-14'); // WHERE gewijzigd_datum = '2011-03-14'
     * $query->filterByDatumGewijzigd('now'); // WHERE gewijzigd_datum = '2011-03-14'
     * $query->filterByDatumGewijzigd(array('max' => 'yesterday')); // WHERE gewijzigd_datum > '2011-03-13'
     * </code>
     *
     * @param     mixed $datumGewijzigd The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFactuurNummerQuery The current query, for fluid interface
     */
    public function filterByDatumGewijzigd($datumGewijzigd = null, $comparison = null)
    {
        if (is_array($datumGewijzigd)) {
            $useMinMax = false;
            if (isset($datumGewijzigd['min'])) {
                $this->addUsingAlias(FactuurNummerTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGewijzigd['max'])) {
                $this->addUsingAlias(FactuurNummerTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FactuurNummerTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd, $comparison);
    }

    /**
     * Filter the query on the gewijzigd_door column
     *
     * Example usage:
     * <code>
     * $query->filterByGewijzigdDoor('fooValue');   // WHERE gewijzigd_door = 'fooValue'
     * $query->filterByGewijzigdDoor('%fooValue%', Criteria::LIKE); // WHERE gewijzigd_door LIKE '%fooValue%'
     * </code>
     *
     * @param     string $gewijzigdDoor The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFactuurNummerQuery The current query, for fluid interface
     */
    public function filterByGewijzigdDoor($gewijzigdDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gewijzigdDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FactuurNummerTableMap::COL_GEWIJZIGD_DOOR, $gewijzigdDoor, $comparison);
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Inschrijving object
     *
     * @param \fb_model\fb_model\Inschrijving|ObjectCollection $inschrijving The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildFactuurNummerQuery The current query, for fluid interface
     */
    public function filterByInschrijving($inschrijving, $comparison = null)
    {
        if ($inschrijving instanceof \fb_model\fb_model\Inschrijving) {
            return $this
                ->addUsingAlias(FactuurNummerTableMap::COL_INSCHRIJVING_ID, $inschrijving->getId(), $comparison);
        } elseif ($inschrijving instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FactuurNummerTableMap::COL_INSCHRIJVING_ID, $inschrijving->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByInschrijving() only accepts arguments of type \fb_model\fb_model\Inschrijving or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Inschrijving relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildFactuurNummerQuery The current query, for fluid interface
     */
    public function joinInschrijving($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Inschrijving');

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
            $this->addJoinObject($join, 'Inschrijving');
        }

        return $this;
    }

    /**
     * Use the Inschrijving relation Inschrijving object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \fb_model\fb_model\InschrijvingQuery A secondary query class using the current class as primary query
     */
    public function useInschrijvingQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinInschrijving($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Inschrijving', '\fb_model\fb_model\InschrijvingQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildFactuurNummer $factuurNummer Object to remove from the list of results
     *
     * @return $this|ChildFactuurNummerQuery The current query, for fluid interface
     */
    public function prune($factuurNummer = null)
    {
        if ($factuurNummer) {
            $this->addUsingAlias(FactuurNummerTableMap::COL_ID, $factuurNummer->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fb_factuur table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FactuurNummerTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            FactuurNummerTableMap::clearInstancePool();
            FactuurNummerTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FactuurNummerTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(FactuurNummerTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            FactuurNummerTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            FactuurNummerTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildFactuurNummerQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(FactuurNummerTableMap::COL_GEWIJZIGD_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildFactuurNummerQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(FactuurNummerTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildFactuurNummerQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(FactuurNummerTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildFactuurNummerQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(FactuurNummerTableMap::COL_GEMAAKT_DATUM);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildFactuurNummerQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(FactuurNummerTableMap::COL_GEMAAKT_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildFactuurNummerQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(FactuurNummerTableMap::COL_GEMAAKT_DATUM);
    }

} // FactuurNummerQuery
