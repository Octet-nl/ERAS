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
use fb_model\fb_model\InschrijvingHeeftOptie as ChildInschrijvingHeeftOptie;
use fb_model\fb_model\InschrijvingHeeftOptieQuery as ChildInschrijvingHeeftOptieQuery;
use fb_model\fb_model\Map\InschrijvingHeeftOptieTableMap;

/**
 * Base class that represents a query for the 'fb_inschrijving_heeft_optie' table.
 *
 *
 *
 * @method     ChildInschrijvingHeeftOptieQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildInschrijvingHeeftOptieQuery orderByOptieId($order = Criteria::ASC) Order by the optie_id column
 * @method     ChildInschrijvingHeeftOptieQuery orderByInschrijvingId($order = Criteria::ASC) Order by the inschrijving_id column
 * @method     ChildInschrijvingHeeftOptieQuery orderByWaarde($order = Criteria::ASC) Order by the waarde column
 * @method     ChildInschrijvingHeeftOptieQuery orderByPrijs($order = Criteria::ASC) Order by the prijs column
 * @method     ChildInschrijvingHeeftOptieQuery orderByDatumGemaakt($order = Criteria::ASC) Order by the gemaakt_datum column
 * @method     ChildInschrijvingHeeftOptieQuery orderByGemaaktDoor($order = Criteria::ASC) Order by the gemaakt_door column
 * @method     ChildInschrijvingHeeftOptieQuery orderByDatumGewijzigd($order = Criteria::ASC) Order by the gewijzigd_datum column
 * @method     ChildInschrijvingHeeftOptieQuery orderByGewijzigdDoor($order = Criteria::ASC) Order by the gewijzigd_door column
 *
 * @method     ChildInschrijvingHeeftOptieQuery groupById() Group by the id column
 * @method     ChildInschrijvingHeeftOptieQuery groupByOptieId() Group by the optie_id column
 * @method     ChildInschrijvingHeeftOptieQuery groupByInschrijvingId() Group by the inschrijving_id column
 * @method     ChildInschrijvingHeeftOptieQuery groupByWaarde() Group by the waarde column
 * @method     ChildInschrijvingHeeftOptieQuery groupByPrijs() Group by the prijs column
 * @method     ChildInschrijvingHeeftOptieQuery groupByDatumGemaakt() Group by the gemaakt_datum column
 * @method     ChildInschrijvingHeeftOptieQuery groupByGemaaktDoor() Group by the gemaakt_door column
 * @method     ChildInschrijvingHeeftOptieQuery groupByDatumGewijzigd() Group by the gewijzigd_datum column
 * @method     ChildInschrijvingHeeftOptieQuery groupByGewijzigdDoor() Group by the gewijzigd_door column
 *
 * @method     ChildInschrijvingHeeftOptieQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildInschrijvingHeeftOptieQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildInschrijvingHeeftOptieQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildInschrijvingHeeftOptieQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildInschrijvingHeeftOptieQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildInschrijvingHeeftOptieQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildInschrijvingHeeftOptieQuery leftJoinOptie($relationAlias = null) Adds a LEFT JOIN clause to the query using the Optie relation
 * @method     ChildInschrijvingHeeftOptieQuery rightJoinOptie($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Optie relation
 * @method     ChildInschrijvingHeeftOptieQuery innerJoinOptie($relationAlias = null) Adds a INNER JOIN clause to the query using the Optie relation
 *
 * @method     ChildInschrijvingHeeftOptieQuery joinWithOptie($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Optie relation
 *
 * @method     ChildInschrijvingHeeftOptieQuery leftJoinWithOptie() Adds a LEFT JOIN clause and with to the query using the Optie relation
 * @method     ChildInschrijvingHeeftOptieQuery rightJoinWithOptie() Adds a RIGHT JOIN clause and with to the query using the Optie relation
 * @method     ChildInschrijvingHeeftOptieQuery innerJoinWithOptie() Adds a INNER JOIN clause and with to the query using the Optie relation
 *
 * @method     ChildInschrijvingHeeftOptieQuery leftJoinInschrijving($relationAlias = null) Adds a LEFT JOIN clause to the query using the Inschrijving relation
 * @method     ChildInschrijvingHeeftOptieQuery rightJoinInschrijving($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Inschrijving relation
 * @method     ChildInschrijvingHeeftOptieQuery innerJoinInschrijving($relationAlias = null) Adds a INNER JOIN clause to the query using the Inschrijving relation
 *
 * @method     ChildInschrijvingHeeftOptieQuery joinWithInschrijving($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Inschrijving relation
 *
 * @method     ChildInschrijvingHeeftOptieQuery leftJoinWithInschrijving() Adds a LEFT JOIN clause and with to the query using the Inschrijving relation
 * @method     ChildInschrijvingHeeftOptieQuery rightJoinWithInschrijving() Adds a RIGHT JOIN clause and with to the query using the Inschrijving relation
 * @method     ChildInschrijvingHeeftOptieQuery innerJoinWithInschrijving() Adds a INNER JOIN clause and with to the query using the Inschrijving relation
 *
 * @method     \fb_model\fb_model\OptieQuery|\fb_model\fb_model\InschrijvingQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildInschrijvingHeeftOptie findOne(ConnectionInterface $con = null) Return the first ChildInschrijvingHeeftOptie matching the query
 * @method     ChildInschrijvingHeeftOptie findOneOrCreate(ConnectionInterface $con = null) Return the first ChildInschrijvingHeeftOptie matching the query, or a new ChildInschrijvingHeeftOptie object populated from the query conditions when no match is found
 *
 * @method     ChildInschrijvingHeeftOptie findOneById(int $id) Return the first ChildInschrijvingHeeftOptie filtered by the id column
 * @method     ChildInschrijvingHeeftOptie findOneByOptieId(int $optie_id) Return the first ChildInschrijvingHeeftOptie filtered by the optie_id column
 * @method     ChildInschrijvingHeeftOptie findOneByInschrijvingId(int $inschrijving_id) Return the first ChildInschrijvingHeeftOptie filtered by the inschrijving_id column
 * @method     ChildInschrijvingHeeftOptie findOneByWaarde(string $waarde) Return the first ChildInschrijvingHeeftOptie filtered by the waarde column
 * @method     ChildInschrijvingHeeftOptie findOneByPrijs(string $prijs) Return the first ChildInschrijvingHeeftOptie filtered by the prijs column
 * @method     ChildInschrijvingHeeftOptie findOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildInschrijvingHeeftOptie filtered by the gemaakt_datum column
 * @method     ChildInschrijvingHeeftOptie findOneByGemaaktDoor(string $gemaakt_door) Return the first ChildInschrijvingHeeftOptie filtered by the gemaakt_door column
 * @method     ChildInschrijvingHeeftOptie findOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildInschrijvingHeeftOptie filtered by the gewijzigd_datum column
 * @method     ChildInschrijvingHeeftOptie findOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildInschrijvingHeeftOptie filtered by the gewijzigd_door column *

 * @method     ChildInschrijvingHeeftOptie requirePk($key, ConnectionInterface $con = null) Return the ChildInschrijvingHeeftOptie by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijvingHeeftOptie requireOne(ConnectionInterface $con = null) Return the first ChildInschrijvingHeeftOptie matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInschrijvingHeeftOptie requireOneById(int $id) Return the first ChildInschrijvingHeeftOptie filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijvingHeeftOptie requireOneByOptieId(int $optie_id) Return the first ChildInschrijvingHeeftOptie filtered by the optie_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijvingHeeftOptie requireOneByInschrijvingId(int $inschrijving_id) Return the first ChildInschrijvingHeeftOptie filtered by the inschrijving_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijvingHeeftOptie requireOneByWaarde(string $waarde) Return the first ChildInschrijvingHeeftOptie filtered by the waarde column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijvingHeeftOptie requireOneByPrijs(string $prijs) Return the first ChildInschrijvingHeeftOptie filtered by the prijs column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijvingHeeftOptie requireOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildInschrijvingHeeftOptie filtered by the gemaakt_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijvingHeeftOptie requireOneByGemaaktDoor(string $gemaakt_door) Return the first ChildInschrijvingHeeftOptie filtered by the gemaakt_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijvingHeeftOptie requireOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildInschrijvingHeeftOptie filtered by the gewijzigd_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijvingHeeftOptie requireOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildInschrijvingHeeftOptie filtered by the gewijzigd_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInschrijvingHeeftOptie[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildInschrijvingHeeftOptie objects based on current ModelCriteria
 * @method     ChildInschrijvingHeeftOptie[]|ObjectCollection findById(int $id) Return ChildInschrijvingHeeftOptie objects filtered by the id column
 * @method     ChildInschrijvingHeeftOptie[]|ObjectCollection findByOptieId(int $optie_id) Return ChildInschrijvingHeeftOptie objects filtered by the optie_id column
 * @method     ChildInschrijvingHeeftOptie[]|ObjectCollection findByInschrijvingId(int $inschrijving_id) Return ChildInschrijvingHeeftOptie objects filtered by the inschrijving_id column
 * @method     ChildInschrijvingHeeftOptie[]|ObjectCollection findByWaarde(string $waarde) Return ChildInschrijvingHeeftOptie objects filtered by the waarde column
 * @method     ChildInschrijvingHeeftOptie[]|ObjectCollection findByPrijs(string $prijs) Return ChildInschrijvingHeeftOptie objects filtered by the prijs column
 * @method     ChildInschrijvingHeeftOptie[]|ObjectCollection findByDatumGemaakt(string $gemaakt_datum) Return ChildInschrijvingHeeftOptie objects filtered by the gemaakt_datum column
 * @method     ChildInschrijvingHeeftOptie[]|ObjectCollection findByGemaaktDoor(string $gemaakt_door) Return ChildInschrijvingHeeftOptie objects filtered by the gemaakt_door column
 * @method     ChildInschrijvingHeeftOptie[]|ObjectCollection findByDatumGewijzigd(string $gewijzigd_datum) Return ChildInschrijvingHeeftOptie objects filtered by the gewijzigd_datum column
 * @method     ChildInschrijvingHeeftOptie[]|ObjectCollection findByGewijzigdDoor(string $gewijzigd_door) Return ChildInschrijvingHeeftOptie objects filtered by the gewijzigd_door column
 * @method     ChildInschrijvingHeeftOptie[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class InschrijvingHeeftOptieQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \fb_model\fb_model\Base\InschrijvingHeeftOptieQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\fb_model\\fb_model\\InschrijvingHeeftOptie', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildInschrijvingHeeftOptieQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildInschrijvingHeeftOptieQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildInschrijvingHeeftOptieQuery) {
            return $criteria;
        }
        $query = new ChildInschrijvingHeeftOptieQuery();
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
     * $obj = $c->findPk(array(12, 34, 56), $con);
     * </code>
     *
     * @param array[$id, $optie_id, $inschrijving_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildInschrijvingHeeftOptie|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(InschrijvingHeeftOptieTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = InschrijvingHeeftOptieTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])]))))) {
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
     * @return ChildInschrijvingHeeftOptie A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, optie_id, inschrijving_id, waarde, prijs, gemaakt_datum, gemaakt_door, gewijzigd_datum, gewijzigd_door FROM fb_inschrijving_heeft_optie WHERE id = :p0 AND optie_id = :p1 AND inschrijving_id = :p2';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->bindValue(':p2', $key[2], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildInschrijvingHeeftOptie $obj */
            $obj = new ChildInschrijvingHeeftOptie();
            $obj->hydrate($row);
            InschrijvingHeeftOptieTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])]));
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
     * @return ChildInschrijvingHeeftOptie|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildInschrijvingHeeftOptieQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_OPTIE_ID, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_INSCHRIJVING_ID, $key[2], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildInschrijvingHeeftOptieQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(InschrijvingHeeftOptieTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(InschrijvingHeeftOptieTableMap::COL_OPTIE_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(InschrijvingHeeftOptieTableMap::COL_INSCHRIJVING_ID, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
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
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInschrijvingHeeftOptieQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the optie_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOptieId(1234); // WHERE optie_id = 1234
     * $query->filterByOptieId(array(12, 34)); // WHERE optie_id IN (12, 34)
     * $query->filterByOptieId(array('min' => 12)); // WHERE optie_id > 12
     * </code>
     *
     * @see       filterByOptie()
     *
     * @param     mixed $optieId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInschrijvingHeeftOptieQuery The current query, for fluid interface
     */
    public function filterByOptieId($optieId = null, $comparison = null)
    {
        if (is_array($optieId)) {
            $useMinMax = false;
            if (isset($optieId['min'])) {
                $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_OPTIE_ID, $optieId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($optieId['max'])) {
                $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_OPTIE_ID, $optieId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_OPTIE_ID, $optieId, $comparison);
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
     * @return $this|ChildInschrijvingHeeftOptieQuery The current query, for fluid interface
     */
    public function filterByInschrijvingId($inschrijvingId = null, $comparison = null)
    {
        if (is_array($inschrijvingId)) {
            $useMinMax = false;
            if (isset($inschrijvingId['min'])) {
                $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_INSCHRIJVING_ID, $inschrijvingId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($inschrijvingId['max'])) {
                $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_INSCHRIJVING_ID, $inschrijvingId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_INSCHRIJVING_ID, $inschrijvingId, $comparison);
    }

    /**
     * Filter the query on the waarde column
     *
     * Example usage:
     * <code>
     * $query->filterByWaarde('fooValue');   // WHERE waarde = 'fooValue'
     * $query->filterByWaarde('%fooValue%', Criteria::LIKE); // WHERE waarde LIKE '%fooValue%'
     * </code>
     *
     * @param     string $waarde The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInschrijvingHeeftOptieQuery The current query, for fluid interface
     */
    public function filterByWaarde($waarde = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($waarde)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_WAARDE, $waarde, $comparison);
    }

    /**
     * Filter the query on the prijs column
     *
     * Example usage:
     * <code>
     * $query->filterByPrijs(1234); // WHERE prijs = 1234
     * $query->filterByPrijs(array(12, 34)); // WHERE prijs IN (12, 34)
     * $query->filterByPrijs(array('min' => 12)); // WHERE prijs > 12
     * </code>
     *
     * @param     mixed $prijs The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInschrijvingHeeftOptieQuery The current query, for fluid interface
     */
    public function filterByPrijs($prijs = null, $comparison = null)
    {
        if (is_array($prijs)) {
            $useMinMax = false;
            if (isset($prijs['min'])) {
                $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_PRIJS, $prijs['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($prijs['max'])) {
                $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_PRIJS, $prijs['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_PRIJS, $prijs, $comparison);
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
     * @return $this|ChildInschrijvingHeeftOptieQuery The current query, for fluid interface
     */
    public function filterByDatumGemaakt($datumGemaakt = null, $comparison = null)
    {
        if (is_array($datumGemaakt)) {
            $useMinMax = false;
            if (isset($datumGemaakt['min'])) {
                $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGemaakt['max'])) {
                $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_GEMAAKT_DATUM, $datumGemaakt, $comparison);
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
     * @return $this|ChildInschrijvingHeeftOptieQuery The current query, for fluid interface
     */
    public function filterByGemaaktDoor($gemaaktDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gemaaktDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_GEMAAKT_DOOR, $gemaaktDoor, $comparison);
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
     * @return $this|ChildInschrijvingHeeftOptieQuery The current query, for fluid interface
     */
    public function filterByDatumGewijzigd($datumGewijzigd = null, $comparison = null)
    {
        if (is_array($datumGewijzigd)) {
            $useMinMax = false;
            if (isset($datumGewijzigd['min'])) {
                $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGewijzigd['max'])) {
                $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd, $comparison);
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
     * @return $this|ChildInschrijvingHeeftOptieQuery The current query, for fluid interface
     */
    public function filterByGewijzigdDoor($gewijzigdDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gewijzigdDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_GEWIJZIGD_DOOR, $gewijzigdDoor, $comparison);
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Optie object
     *
     * @param \fb_model\fb_model\Optie|ObjectCollection $optie The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildInschrijvingHeeftOptieQuery The current query, for fluid interface
     */
    public function filterByOptie($optie, $comparison = null)
    {
        if ($optie instanceof \fb_model\fb_model\Optie) {
            return $this
                ->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_OPTIE_ID, $optie->getId(), $comparison);
        } elseif ($optie instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_OPTIE_ID, $optie->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildInschrijvingHeeftOptieQuery The current query, for fluid interface
     */
    public function joinOptie($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useOptieQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOptie($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Optie', '\fb_model\fb_model\OptieQuery');
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Inschrijving object
     *
     * @param \fb_model\fb_model\Inschrijving|ObjectCollection $inschrijving The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildInschrijvingHeeftOptieQuery The current query, for fluid interface
     */
    public function filterByInschrijving($inschrijving, $comparison = null)
    {
        if ($inschrijving instanceof \fb_model\fb_model\Inschrijving) {
            return $this
                ->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_INSCHRIJVING_ID, $inschrijving->getId(), $comparison);
        } elseif ($inschrijving instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_INSCHRIJVING_ID, $inschrijving->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildInschrijvingHeeftOptieQuery The current query, for fluid interface
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
     * @param   ChildInschrijvingHeeftOptie $inschrijvingHeeftOptie Object to remove from the list of results
     *
     * @return $this|ChildInschrijvingHeeftOptieQuery The current query, for fluid interface
     */
    public function prune($inschrijvingHeeftOptie = null)
    {
        if ($inschrijvingHeeftOptie) {
            $this->addCond('pruneCond0', $this->getAliasedColName(InschrijvingHeeftOptieTableMap::COL_ID), $inschrijvingHeeftOptie->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(InschrijvingHeeftOptieTableMap::COL_OPTIE_ID), $inschrijvingHeeftOptie->getOptieId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(InschrijvingHeeftOptieTableMap::COL_INSCHRIJVING_ID), $inschrijvingHeeftOptie->getInschrijvingId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fb_inschrijving_heeft_optie table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InschrijvingHeeftOptieTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            InschrijvingHeeftOptieTableMap::clearInstancePool();
            InschrijvingHeeftOptieTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(InschrijvingHeeftOptieTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(InschrijvingHeeftOptieTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            InschrijvingHeeftOptieTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            InschrijvingHeeftOptieTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildInschrijvingHeeftOptieQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_GEWIJZIGD_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildInschrijvingHeeftOptieQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(InschrijvingHeeftOptieTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildInschrijvingHeeftOptieQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(InschrijvingHeeftOptieTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildInschrijvingHeeftOptieQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(InschrijvingHeeftOptieTableMap::COL_GEMAAKT_DATUM);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildInschrijvingHeeftOptieQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(InschrijvingHeeftOptieTableMap::COL_GEMAAKT_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildInschrijvingHeeftOptieQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(InschrijvingHeeftOptieTableMap::COL_GEMAAKT_DATUM);
    }

} // InschrijvingHeeftOptieQuery
