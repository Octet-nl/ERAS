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
use fb_model\fb_model\Type as ChildType;
use fb_model\fb_model\TypeQuery as ChildTypeQuery;
use fb_model\fb_model\Map\TypeTableMap;

/**
 * Base class that represents a query for the 'fb_type' table.
 *
 *
 *
 * @method     ChildTypeQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTypeQuery orderByCode($order = Criteria::ASC) Order by the code column
 * @method     ChildTypeQuery orderByNaam($order = Criteria::ASC) Order by the naam column
 * @method     ChildTypeQuery orderByIsActief($order = Criteria::ASC) Order by the actief column
 * @method     ChildTypeQuery orderByDatumGemaakt($order = Criteria::ASC) Order by the gemaakt_datum column
 * @method     ChildTypeQuery orderByGemaaktDoor($order = Criteria::ASC) Order by the gemaakt_door column
 * @method     ChildTypeQuery orderByDatumGewijzigd($order = Criteria::ASC) Order by the gewijzigd_datum column
 * @method     ChildTypeQuery orderByGewijzigdDoor($order = Criteria::ASC) Order by the gewijzigd_door column
 *
 * @method     ChildTypeQuery groupById() Group by the id column
 * @method     ChildTypeQuery groupByCode() Group by the code column
 * @method     ChildTypeQuery groupByNaam() Group by the naam column
 * @method     ChildTypeQuery groupByIsActief() Group by the actief column
 * @method     ChildTypeQuery groupByDatumGemaakt() Group by the gemaakt_datum column
 * @method     ChildTypeQuery groupByGemaaktDoor() Group by the gemaakt_door column
 * @method     ChildTypeQuery groupByDatumGewijzigd() Group by the gewijzigd_datum column
 * @method     ChildTypeQuery groupByGewijzigdDoor() Group by the gewijzigd_door column
 *
 * @method     ChildTypeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTypeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTypeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTypeQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTypeQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTypeQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTypeQuery leftJoinOptie($relationAlias = null) Adds a LEFT JOIN clause to the query using the Optie relation
 * @method     ChildTypeQuery rightJoinOptie($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Optie relation
 * @method     ChildTypeQuery innerJoinOptie($relationAlias = null) Adds a INNER JOIN clause to the query using the Optie relation
 *
 * @method     ChildTypeQuery joinWithOptie($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Optie relation
 *
 * @method     ChildTypeQuery leftJoinWithOptie() Adds a LEFT JOIN clause and with to the query using the Optie relation
 * @method     ChildTypeQuery rightJoinWithOptie() Adds a RIGHT JOIN clause and with to the query using the Optie relation
 * @method     ChildTypeQuery innerJoinWithOptie() Adds a INNER JOIN clause and with to the query using the Optie relation
 *
 * @method     \fb_model\fb_model\OptieQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildType findOne(ConnectionInterface $con = null) Return the first ChildType matching the query
 * @method     ChildType findOneOrCreate(ConnectionInterface $con = null) Return the first ChildType matching the query, or a new ChildType object populated from the query conditions when no match is found
 *
 * @method     ChildType findOneById(int $id) Return the first ChildType filtered by the id column
 * @method     ChildType findOneByCode(int $code) Return the first ChildType filtered by the code column
 * @method     ChildType findOneByNaam(string $naam) Return the first ChildType filtered by the naam column
 * @method     ChildType findOneByIsActief(int $actief) Return the first ChildType filtered by the actief column
 * @method     ChildType findOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildType filtered by the gemaakt_datum column
 * @method     ChildType findOneByGemaaktDoor(string $gemaakt_door) Return the first ChildType filtered by the gemaakt_door column
 * @method     ChildType findOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildType filtered by the gewijzigd_datum column
 * @method     ChildType findOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildType filtered by the gewijzigd_door column *

 * @method     ChildType requirePk($key, ConnectionInterface $con = null) Return the ChildType by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildType requireOne(ConnectionInterface $con = null) Return the first ChildType matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildType requireOneById(int $id) Return the first ChildType filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildType requireOneByCode(int $code) Return the first ChildType filtered by the code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildType requireOneByNaam(string $naam) Return the first ChildType filtered by the naam column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildType requireOneByIsActief(int $actief) Return the first ChildType filtered by the actief column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildType requireOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildType filtered by the gemaakt_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildType requireOneByGemaaktDoor(string $gemaakt_door) Return the first ChildType filtered by the gemaakt_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildType requireOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildType filtered by the gewijzigd_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildType requireOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildType filtered by the gewijzigd_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildType[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildType objects based on current ModelCriteria
 * @method     ChildType[]|ObjectCollection findById(int $id) Return ChildType objects filtered by the id column
 * @method     ChildType[]|ObjectCollection findByCode(int $code) Return ChildType objects filtered by the code column
 * @method     ChildType[]|ObjectCollection findByNaam(string $naam) Return ChildType objects filtered by the naam column
 * @method     ChildType[]|ObjectCollection findByIsActief(int $actief) Return ChildType objects filtered by the actief column
 * @method     ChildType[]|ObjectCollection findByDatumGemaakt(string $gemaakt_datum) Return ChildType objects filtered by the gemaakt_datum column
 * @method     ChildType[]|ObjectCollection findByGemaaktDoor(string $gemaakt_door) Return ChildType objects filtered by the gemaakt_door column
 * @method     ChildType[]|ObjectCollection findByDatumGewijzigd(string $gewijzigd_datum) Return ChildType objects filtered by the gewijzigd_datum column
 * @method     ChildType[]|ObjectCollection findByGewijzigdDoor(string $gewijzigd_door) Return ChildType objects filtered by the gewijzigd_door column
 * @method     ChildType[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TypeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \fb_model\fb_model\Base\TypeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\fb_model\\fb_model\\Type', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTypeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTypeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTypeQuery) {
            return $criteria;
        }
        $query = new ChildTypeQuery();
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
     * @return ChildType|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TypeTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = TypeTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildType A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, code, naam, actief, gemaakt_datum, gemaakt_door, gewijzigd_datum, gewijzigd_door FROM fb_type WHERE id = :p0';
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
            /** @var ChildType $obj */
            $obj = new ChildType();
            $obj->hydrate($row);
            TypeTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildType|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTypeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TypeTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTypeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TypeTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildTypeQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TypeTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TypeTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TypeTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the code column
     *
     * Example usage:
     * <code>
     * $query->filterByCode(1234); // WHERE code = 1234
     * $query->filterByCode(array(12, 34)); // WHERE code IN (12, 34)
     * $query->filterByCode(array('min' => 12)); // WHERE code > 12
     * </code>
     *
     * @param     mixed $code The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTypeQuery The current query, for fluid interface
     */
    public function filterByCode($code = null, $comparison = null)
    {
        if (is_array($code)) {
            $useMinMax = false;
            if (isset($code['min'])) {
                $this->addUsingAlias(TypeTableMap::COL_CODE, $code['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($code['max'])) {
                $this->addUsingAlias(TypeTableMap::COL_CODE, $code['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TypeTableMap::COL_CODE, $code, $comparison);
    }

    /**
     * Filter the query on the naam column
     *
     * Example usage:
     * <code>
     * $query->filterByNaam('fooValue');   // WHERE naam = 'fooValue'
     * $query->filterByNaam('%fooValue%', Criteria::LIKE); // WHERE naam LIKE '%fooValue%'
     * </code>
     *
     * @param     string $naam The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTypeQuery The current query, for fluid interface
     */
    public function filterByNaam($naam = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($naam)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TypeTableMap::COL_NAAM, $naam, $comparison);
    }

    /**
     * Filter the query on the actief column
     *
     * Example usage:
     * <code>
     * $query->filterByIsActief(1234); // WHERE actief = 1234
     * $query->filterByIsActief(array(12, 34)); // WHERE actief IN (12, 34)
     * $query->filterByIsActief(array('min' => 12)); // WHERE actief > 12
     * </code>
     *
     * @param     mixed $isActief The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTypeQuery The current query, for fluid interface
     */
    public function filterByIsActief($isActief = null, $comparison = null)
    {
        if (is_array($isActief)) {
            $useMinMax = false;
            if (isset($isActief['min'])) {
                $this->addUsingAlias(TypeTableMap::COL_ACTIEF, $isActief['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isActief['max'])) {
                $this->addUsingAlias(TypeTableMap::COL_ACTIEF, $isActief['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TypeTableMap::COL_ACTIEF, $isActief, $comparison);
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
     * @return $this|ChildTypeQuery The current query, for fluid interface
     */
    public function filterByDatumGemaakt($datumGemaakt = null, $comparison = null)
    {
        if (is_array($datumGemaakt)) {
            $useMinMax = false;
            if (isset($datumGemaakt['min'])) {
                $this->addUsingAlias(TypeTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGemaakt['max'])) {
                $this->addUsingAlias(TypeTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TypeTableMap::COL_GEMAAKT_DATUM, $datumGemaakt, $comparison);
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
     * @return $this|ChildTypeQuery The current query, for fluid interface
     */
    public function filterByGemaaktDoor($gemaaktDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gemaaktDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TypeTableMap::COL_GEMAAKT_DOOR, $gemaaktDoor, $comparison);
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
     * @return $this|ChildTypeQuery The current query, for fluid interface
     */
    public function filterByDatumGewijzigd($datumGewijzigd = null, $comparison = null)
    {
        if (is_array($datumGewijzigd)) {
            $useMinMax = false;
            if (isset($datumGewijzigd['min'])) {
                $this->addUsingAlias(TypeTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGewijzigd['max'])) {
                $this->addUsingAlias(TypeTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TypeTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd, $comparison);
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
     * @return $this|ChildTypeQuery The current query, for fluid interface
     */
    public function filterByGewijzigdDoor($gewijzigdDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gewijzigdDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TypeTableMap::COL_GEWIJZIGD_DOOR, $gewijzigdDoor, $comparison);
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Optie object
     *
     * @param \fb_model\fb_model\Optie|ObjectCollection $optie the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTypeQuery The current query, for fluid interface
     */
    public function filterByOptie($optie, $comparison = null)
    {
        if ($optie instanceof \fb_model\fb_model\Optie) {
            return $this
                ->addUsingAlias(TypeTableMap::COL_ID, $optie->getOptieType(), $comparison);
        } elseif ($optie instanceof ObjectCollection) {
            return $this
                ->useOptieQuery()
                ->filterByPrimaryKeys($optie->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByOptie() only accepts arguments of type \fb_model\fb_model\Optie or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Optie relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTypeQuery The current query, for fluid interface
     */
    public function joinOptie($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Optie');

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
            $this->addJoinObject($join, 'Optie');
        }

        return $this;
    }

    /**
     * Use the Optie relation Optie object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \fb_model\fb_model\OptieQuery A secondary query class using the current class as primary query
     */
    public function useOptieQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinOptie($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Optie', '\fb_model\fb_model\OptieQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildType $type Object to remove from the list of results
     *
     * @return $this|ChildTypeQuery The current query, for fluid interface
     */
    public function prune($type = null)
    {
        if ($type) {
            $this->addUsingAlias(TypeTableMap::COL_ID, $type->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fb_type table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TypeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TypeTableMap::clearInstancePool();
            TypeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TypeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TypeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TypeTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TypeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildTypeQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(TypeTableMap::COL_GEWIJZIGD_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildTypeQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(TypeTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildTypeQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(TypeTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildTypeQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(TypeTableMap::COL_GEMAAKT_DATUM);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildTypeQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(TypeTableMap::COL_GEMAAKT_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildTypeQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(TypeTableMap::COL_GEMAAKT_DATUM);
    }

} // TypeQuery
