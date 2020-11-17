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
use fb_model\fb_model\Deelnemer as ChildDeelnemer;
use fb_model\fb_model\DeelnemerQuery as ChildDeelnemerQuery;
use fb_model\fb_model\Map\DeelnemerTableMap;

/**
 * Base class that represents a query for the 'fb_deelnemer' table.
 *
 *
 *
 * @method     ChildDeelnemerQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildDeelnemerQuery orderByInschrijvingId($order = Criteria::ASC) Order by the inschrijving_id column
 * @method     ChildDeelnemerQuery orderByPersoonId($order = Criteria::ASC) Order by the persoon_id column
 * @method     ChildDeelnemerQuery orderByTotaalbedrag($order = Criteria::ASC) Order by the totaalbedrag column
 * @method     ChildDeelnemerQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildDeelnemerQuery orderByDatumGemaakt($order = Criteria::ASC) Order by the gemaakt_datum column
 * @method     ChildDeelnemerQuery orderByGemaaktDoor($order = Criteria::ASC) Order by the gemaakt_door column
 * @method     ChildDeelnemerQuery orderByDatumGewijzigd($order = Criteria::ASC) Order by the gewijzigd_datum column
 * @method     ChildDeelnemerQuery orderByGewijzigdDoor($order = Criteria::ASC) Order by the gewijzigd_door column
 *
 * @method     ChildDeelnemerQuery groupById() Group by the id column
 * @method     ChildDeelnemerQuery groupByInschrijvingId() Group by the inschrijving_id column
 * @method     ChildDeelnemerQuery groupByPersoonId() Group by the persoon_id column
 * @method     ChildDeelnemerQuery groupByTotaalbedrag() Group by the totaalbedrag column
 * @method     ChildDeelnemerQuery groupByStatus() Group by the status column
 * @method     ChildDeelnemerQuery groupByDatumGemaakt() Group by the gemaakt_datum column
 * @method     ChildDeelnemerQuery groupByGemaaktDoor() Group by the gemaakt_door column
 * @method     ChildDeelnemerQuery groupByDatumGewijzigd() Group by the gewijzigd_datum column
 * @method     ChildDeelnemerQuery groupByGewijzigdDoor() Group by the gewijzigd_door column
 *
 * @method     ChildDeelnemerQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDeelnemerQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDeelnemerQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDeelnemerQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDeelnemerQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDeelnemerQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDeelnemerQuery leftJoinInschrijving($relationAlias = null) Adds a LEFT JOIN clause to the query using the Inschrijving relation
 * @method     ChildDeelnemerQuery rightJoinInschrijving($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Inschrijving relation
 * @method     ChildDeelnemerQuery innerJoinInschrijving($relationAlias = null) Adds a INNER JOIN clause to the query using the Inschrijving relation
 *
 * @method     ChildDeelnemerQuery joinWithInschrijving($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Inschrijving relation
 *
 * @method     ChildDeelnemerQuery leftJoinWithInschrijving() Adds a LEFT JOIN clause and with to the query using the Inschrijving relation
 * @method     ChildDeelnemerQuery rightJoinWithInschrijving() Adds a RIGHT JOIN clause and with to the query using the Inschrijving relation
 * @method     ChildDeelnemerQuery innerJoinWithInschrijving() Adds a INNER JOIN clause and with to the query using the Inschrijving relation
 *
 * @method     ChildDeelnemerQuery leftJoinPersoon($relationAlias = null) Adds a LEFT JOIN clause to the query using the Persoon relation
 * @method     ChildDeelnemerQuery rightJoinPersoon($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Persoon relation
 * @method     ChildDeelnemerQuery innerJoinPersoon($relationAlias = null) Adds a INNER JOIN clause to the query using the Persoon relation
 *
 * @method     ChildDeelnemerQuery joinWithPersoon($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Persoon relation
 *
 * @method     ChildDeelnemerQuery leftJoinWithPersoon() Adds a LEFT JOIN clause and with to the query using the Persoon relation
 * @method     ChildDeelnemerQuery rightJoinWithPersoon() Adds a RIGHT JOIN clause and with to the query using the Persoon relation
 * @method     ChildDeelnemerQuery innerJoinWithPersoon() Adds a INNER JOIN clause and with to the query using the Persoon relation
 *
 * @method     ChildDeelnemerQuery leftJoinDeelnemerHeeftOptie($relationAlias = null) Adds a LEFT JOIN clause to the query using the DeelnemerHeeftOptie relation
 * @method     ChildDeelnemerQuery rightJoinDeelnemerHeeftOptie($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DeelnemerHeeftOptie relation
 * @method     ChildDeelnemerQuery innerJoinDeelnemerHeeftOptie($relationAlias = null) Adds a INNER JOIN clause to the query using the DeelnemerHeeftOptie relation
 *
 * @method     ChildDeelnemerQuery joinWithDeelnemerHeeftOptie($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DeelnemerHeeftOptie relation
 *
 * @method     ChildDeelnemerQuery leftJoinWithDeelnemerHeeftOptie() Adds a LEFT JOIN clause and with to the query using the DeelnemerHeeftOptie relation
 * @method     ChildDeelnemerQuery rightJoinWithDeelnemerHeeftOptie() Adds a RIGHT JOIN clause and with to the query using the DeelnemerHeeftOptie relation
 * @method     ChildDeelnemerQuery innerJoinWithDeelnemerHeeftOptie() Adds a INNER JOIN clause and with to the query using the DeelnemerHeeftOptie relation
 *
 * @method     \fb_model\fb_model\InschrijvingQuery|\fb_model\fb_model\PersoonQuery|\fb_model\fb_model\DeelnemerHeeftOptieQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDeelnemer findOne(ConnectionInterface $con = null) Return the first ChildDeelnemer matching the query
 * @method     ChildDeelnemer findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDeelnemer matching the query, or a new ChildDeelnemer object populated from the query conditions when no match is found
 *
 * @method     ChildDeelnemer findOneById(int $id) Return the first ChildDeelnemer filtered by the id column
 * @method     ChildDeelnemer findOneByInschrijvingId(int $inschrijving_id) Return the first ChildDeelnemer filtered by the inschrijving_id column
 * @method     ChildDeelnemer findOneByPersoonId(int $persoon_id) Return the first ChildDeelnemer filtered by the persoon_id column
 * @method     ChildDeelnemer findOneByTotaalbedrag(string $totaalbedrag) Return the first ChildDeelnemer filtered by the totaalbedrag column
 * @method     ChildDeelnemer findOneByStatus(int $status) Return the first ChildDeelnemer filtered by the status column
 * @method     ChildDeelnemer findOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildDeelnemer filtered by the gemaakt_datum column
 * @method     ChildDeelnemer findOneByGemaaktDoor(string $gemaakt_door) Return the first ChildDeelnemer filtered by the gemaakt_door column
 * @method     ChildDeelnemer findOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildDeelnemer filtered by the gewijzigd_datum column
 * @method     ChildDeelnemer findOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildDeelnemer filtered by the gewijzigd_door column *

 * @method     ChildDeelnemer requirePk($key, ConnectionInterface $con = null) Return the ChildDeelnemer by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDeelnemer requireOne(ConnectionInterface $con = null) Return the first ChildDeelnemer matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDeelnemer requireOneById(int $id) Return the first ChildDeelnemer filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDeelnemer requireOneByInschrijvingId(int $inschrijving_id) Return the first ChildDeelnemer filtered by the inschrijving_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDeelnemer requireOneByPersoonId(int $persoon_id) Return the first ChildDeelnemer filtered by the persoon_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDeelnemer requireOneByTotaalbedrag(string $totaalbedrag) Return the first ChildDeelnemer filtered by the totaalbedrag column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDeelnemer requireOneByStatus(int $status) Return the first ChildDeelnemer filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDeelnemer requireOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildDeelnemer filtered by the gemaakt_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDeelnemer requireOneByGemaaktDoor(string $gemaakt_door) Return the first ChildDeelnemer filtered by the gemaakt_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDeelnemer requireOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildDeelnemer filtered by the gewijzigd_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDeelnemer requireOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildDeelnemer filtered by the gewijzigd_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDeelnemer[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDeelnemer objects based on current ModelCriteria
 * @method     ChildDeelnemer[]|ObjectCollection findById(int $id) Return ChildDeelnemer objects filtered by the id column
 * @method     ChildDeelnemer[]|ObjectCollection findByInschrijvingId(int $inschrijving_id) Return ChildDeelnemer objects filtered by the inschrijving_id column
 * @method     ChildDeelnemer[]|ObjectCollection findByPersoonId(int $persoon_id) Return ChildDeelnemer objects filtered by the persoon_id column
 * @method     ChildDeelnemer[]|ObjectCollection findByTotaalbedrag(string $totaalbedrag) Return ChildDeelnemer objects filtered by the totaalbedrag column
 * @method     ChildDeelnemer[]|ObjectCollection findByStatus(int $status) Return ChildDeelnemer objects filtered by the status column
 * @method     ChildDeelnemer[]|ObjectCollection findByDatumGemaakt(string $gemaakt_datum) Return ChildDeelnemer objects filtered by the gemaakt_datum column
 * @method     ChildDeelnemer[]|ObjectCollection findByGemaaktDoor(string $gemaakt_door) Return ChildDeelnemer objects filtered by the gemaakt_door column
 * @method     ChildDeelnemer[]|ObjectCollection findByDatumGewijzigd(string $gewijzigd_datum) Return ChildDeelnemer objects filtered by the gewijzigd_datum column
 * @method     ChildDeelnemer[]|ObjectCollection findByGewijzigdDoor(string $gewijzigd_door) Return ChildDeelnemer objects filtered by the gewijzigd_door column
 * @method     ChildDeelnemer[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DeelnemerQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \fb_model\fb_model\Base\DeelnemerQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\fb_model\\fb_model\\Deelnemer', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDeelnemerQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDeelnemerQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDeelnemerQuery) {
            return $criteria;
        }
        $query = new ChildDeelnemerQuery();
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
     * @return ChildDeelnemer|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DeelnemerTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = DeelnemerTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildDeelnemer A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, inschrijving_id, persoon_id, totaalbedrag, status, gemaakt_datum, gemaakt_door, gewijzigd_datum, gewijzigd_door FROM fb_deelnemer WHERE id = :p0';
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
            /** @var ChildDeelnemer $obj */
            $obj = new ChildDeelnemer();
            $obj->hydrate($row);
            DeelnemerTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildDeelnemer|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildDeelnemerQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DeelnemerTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDeelnemerQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DeelnemerTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildDeelnemerQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(DeelnemerTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(DeelnemerTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DeelnemerTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildDeelnemerQuery The current query, for fluid interface
     */
    public function filterByInschrijvingId($inschrijvingId = null, $comparison = null)
    {
        if (is_array($inschrijvingId)) {
            $useMinMax = false;
            if (isset($inschrijvingId['min'])) {
                $this->addUsingAlias(DeelnemerTableMap::COL_INSCHRIJVING_ID, $inschrijvingId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($inschrijvingId['max'])) {
                $this->addUsingAlias(DeelnemerTableMap::COL_INSCHRIJVING_ID, $inschrijvingId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DeelnemerTableMap::COL_INSCHRIJVING_ID, $inschrijvingId, $comparison);
    }

    /**
     * Filter the query on the persoon_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPersoonId(1234); // WHERE persoon_id = 1234
     * $query->filterByPersoonId(array(12, 34)); // WHERE persoon_id IN (12, 34)
     * $query->filterByPersoonId(array('min' => 12)); // WHERE persoon_id > 12
     * </code>
     *
     * @see       filterByPersoon()
     *
     * @param     mixed $persoonId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDeelnemerQuery The current query, for fluid interface
     */
    public function filterByPersoonId($persoonId = null, $comparison = null)
    {
        if (is_array($persoonId)) {
            $useMinMax = false;
            if (isset($persoonId['min'])) {
                $this->addUsingAlias(DeelnemerTableMap::COL_PERSOON_ID, $persoonId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($persoonId['max'])) {
                $this->addUsingAlias(DeelnemerTableMap::COL_PERSOON_ID, $persoonId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DeelnemerTableMap::COL_PERSOON_ID, $persoonId, $comparison);
    }

    /**
     * Filter the query on the totaalbedrag column
     *
     * Example usage:
     * <code>
     * $query->filterByTotaalbedrag(1234); // WHERE totaalbedrag = 1234
     * $query->filterByTotaalbedrag(array(12, 34)); // WHERE totaalbedrag IN (12, 34)
     * $query->filterByTotaalbedrag(array('min' => 12)); // WHERE totaalbedrag > 12
     * </code>
     *
     * @param     mixed $totaalbedrag The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDeelnemerQuery The current query, for fluid interface
     */
    public function filterByTotaalbedrag($totaalbedrag = null, $comparison = null)
    {
        if (is_array($totaalbedrag)) {
            $useMinMax = false;
            if (isset($totaalbedrag['min'])) {
                $this->addUsingAlias(DeelnemerTableMap::COL_TOTAALBEDRAG, $totaalbedrag['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($totaalbedrag['max'])) {
                $this->addUsingAlias(DeelnemerTableMap::COL_TOTAALBEDRAG, $totaalbedrag['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DeelnemerTableMap::COL_TOTAALBEDRAG, $totaalbedrag, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus(1234); // WHERE status = 1234
     * $query->filterByStatus(array(12, 34)); // WHERE status IN (12, 34)
     * $query->filterByStatus(array('min' => 12)); // WHERE status > 12
     * </code>
     *
     * @param     mixed $status The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDeelnemerQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (is_array($status)) {
            $useMinMax = false;
            if (isset($status['min'])) {
                $this->addUsingAlias(DeelnemerTableMap::COL_STATUS, $status['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($status['max'])) {
                $this->addUsingAlias(DeelnemerTableMap::COL_STATUS, $status['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DeelnemerTableMap::COL_STATUS, $status, $comparison);
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
     * @return $this|ChildDeelnemerQuery The current query, for fluid interface
     */
    public function filterByDatumGemaakt($datumGemaakt = null, $comparison = null)
    {
        if (is_array($datumGemaakt)) {
            $useMinMax = false;
            if (isset($datumGemaakt['min'])) {
                $this->addUsingAlias(DeelnemerTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGemaakt['max'])) {
                $this->addUsingAlias(DeelnemerTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DeelnemerTableMap::COL_GEMAAKT_DATUM, $datumGemaakt, $comparison);
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
     * @return $this|ChildDeelnemerQuery The current query, for fluid interface
     */
    public function filterByGemaaktDoor($gemaaktDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gemaaktDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DeelnemerTableMap::COL_GEMAAKT_DOOR, $gemaaktDoor, $comparison);
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
     * @return $this|ChildDeelnemerQuery The current query, for fluid interface
     */
    public function filterByDatumGewijzigd($datumGewijzigd = null, $comparison = null)
    {
        if (is_array($datumGewijzigd)) {
            $useMinMax = false;
            if (isset($datumGewijzigd['min'])) {
                $this->addUsingAlias(DeelnemerTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGewijzigd['max'])) {
                $this->addUsingAlias(DeelnemerTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DeelnemerTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd, $comparison);
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
     * @return $this|ChildDeelnemerQuery The current query, for fluid interface
     */
    public function filterByGewijzigdDoor($gewijzigdDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gewijzigdDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DeelnemerTableMap::COL_GEWIJZIGD_DOOR, $gewijzigdDoor, $comparison);
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Inschrijving object
     *
     * @param \fb_model\fb_model\Inschrijving|ObjectCollection $inschrijving The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDeelnemerQuery The current query, for fluid interface
     */
    public function filterByInschrijving($inschrijving, $comparison = null)
    {
        if ($inschrijving instanceof \fb_model\fb_model\Inschrijving) {
            return $this
                ->addUsingAlias(DeelnemerTableMap::COL_INSCHRIJVING_ID, $inschrijving->getId(), $comparison);
        } elseif ($inschrijving instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DeelnemerTableMap::COL_INSCHRIJVING_ID, $inschrijving->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildDeelnemerQuery The current query, for fluid interface
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
     * Filter the query by a related \fb_model\fb_model\Persoon object
     *
     * @param \fb_model\fb_model\Persoon|ObjectCollection $persoon The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDeelnemerQuery The current query, for fluid interface
     */
    public function filterByPersoon($persoon, $comparison = null)
    {
        if ($persoon instanceof \fb_model\fb_model\Persoon) {
            return $this
                ->addUsingAlias(DeelnemerTableMap::COL_PERSOON_ID, $persoon->getId(), $comparison);
        } elseif ($persoon instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DeelnemerTableMap::COL_PERSOON_ID, $persoon->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPersoon() only accepts arguments of type \fb_model\fb_model\Persoon or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Persoon relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDeelnemerQuery The current query, for fluid interface
     */
    public function joinPersoon($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Persoon');

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
            $this->addJoinObject($join, 'Persoon');
        }

        return $this;
    }

    /**
     * Use the Persoon relation Persoon object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \fb_model\fb_model\PersoonQuery A secondary query class using the current class as primary query
     */
    public function usePersoonQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPersoon($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Persoon', '\fb_model\fb_model\PersoonQuery');
    }

    /**
     * Filter the query by a related \fb_model\fb_model\DeelnemerHeeftOptie object
     *
     * @param \fb_model\fb_model\DeelnemerHeeftOptie|ObjectCollection $deelnemerHeeftOptie the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDeelnemerQuery The current query, for fluid interface
     */
    public function filterByDeelnemerHeeftOptie($deelnemerHeeftOptie, $comparison = null)
    {
        if ($deelnemerHeeftOptie instanceof \fb_model\fb_model\DeelnemerHeeftOptie) {
            return $this
                ->addUsingAlias(DeelnemerTableMap::COL_ID, $deelnemerHeeftOptie->getDeelnemerId(), $comparison);
        } elseif ($deelnemerHeeftOptie instanceof ObjectCollection) {
            return $this
                ->useDeelnemerHeeftOptieQuery()
                ->filterByPrimaryKeys($deelnemerHeeftOptie->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDeelnemerHeeftOptie() only accepts arguments of type \fb_model\fb_model\DeelnemerHeeftOptie or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DeelnemerHeeftOptie relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDeelnemerQuery The current query, for fluid interface
     */
    public function joinDeelnemerHeeftOptie($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DeelnemerHeeftOptie');

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
            $this->addJoinObject($join, 'DeelnemerHeeftOptie');
        }

        return $this;
    }

    /**
     * Use the DeelnemerHeeftOptie relation DeelnemerHeeftOptie object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \fb_model\fb_model\DeelnemerHeeftOptieQuery A secondary query class using the current class as primary query
     */
    public function useDeelnemerHeeftOptieQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDeelnemerHeeftOptie($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DeelnemerHeeftOptie', '\fb_model\fb_model\DeelnemerHeeftOptieQuery');
    }

    /**
     * Filter the query by a related Optie object
     * using the fb_deelnemer_heeft_optie table as cross reference
     *
     * @param Optie $optie the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDeelnemerQuery The current query, for fluid interface
     */
    public function filterByOptie($optie, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useDeelnemerHeeftOptieQuery()
            ->filterByOptie($optie, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDeelnemer $deelnemer Object to remove from the list of results
     *
     * @return $this|ChildDeelnemerQuery The current query, for fluid interface
     */
    public function prune($deelnemer = null)
    {
        if ($deelnemer) {
            $this->addUsingAlias(DeelnemerTableMap::COL_ID, $deelnemer->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fb_deelnemer table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DeelnemerTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DeelnemerTableMap::clearInstancePool();
            DeelnemerTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DeelnemerTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DeelnemerTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DeelnemerTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DeelnemerTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildDeelnemerQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(DeelnemerTableMap::COL_GEWIJZIGD_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildDeelnemerQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(DeelnemerTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildDeelnemerQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(DeelnemerTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildDeelnemerQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(DeelnemerTableMap::COL_GEMAAKT_DATUM);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildDeelnemerQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(DeelnemerTableMap::COL_GEMAAKT_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildDeelnemerQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(DeelnemerTableMap::COL_GEMAAKT_DATUM);
    }

} // DeelnemerQuery
