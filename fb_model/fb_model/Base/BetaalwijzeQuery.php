<?php

namespace fb_model\fb_model\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use fb_model\fb_model\Betaalwijze as ChildBetaalwijze;
use fb_model\fb_model\BetaalwijzeQuery as ChildBetaalwijzeQuery;
use fb_model\fb_model\Map\BetaalwijzeTableMap;

/**
 * Base class that represents a query for the 'fb_betaalwijze' table.
 *
 *
 *
 * @method     ChildBetaalwijzeQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildBetaalwijzeQuery orderByCode($order = Criteria::ASC) Order by the code column
 * @method     ChildBetaalwijzeQuery orderByNaam($order = Criteria::ASC) Order by the naam column
 * @method     ChildBetaalwijzeQuery orderByKosten($order = Criteria::ASC) Order by the kosten column
 * @method     ChildBetaalwijzeQuery orderByPercentage($order = Criteria::ASC) Order by the percentage column
 * @method     ChildBetaalwijzeQuery orderByBTW($order = Criteria::ASC) Order by the btw column
 * @method     ChildBetaalwijzeQuery orderByIsActief($order = Criteria::ASC) Order by the actief column
 * @method     ChildBetaalwijzeQuery orderByDatumGemaakt($order = Criteria::ASC) Order by the gemaakt_datum column
 * @method     ChildBetaalwijzeQuery orderByGemaaktDoor($order = Criteria::ASC) Order by the gemaakt_door column
 * @method     ChildBetaalwijzeQuery orderByDatumGewijzigd($order = Criteria::ASC) Order by the gewijzigd_datum column
 * @method     ChildBetaalwijzeQuery orderByGewijzigdDoor($order = Criteria::ASC) Order by the gewijzigd_door column
 *
 * @method     ChildBetaalwijzeQuery groupById() Group by the id column
 * @method     ChildBetaalwijzeQuery groupByCode() Group by the code column
 * @method     ChildBetaalwijzeQuery groupByNaam() Group by the naam column
 * @method     ChildBetaalwijzeQuery groupByKosten() Group by the kosten column
 * @method     ChildBetaalwijzeQuery groupByPercentage() Group by the percentage column
 * @method     ChildBetaalwijzeQuery groupByBTW() Group by the btw column
 * @method     ChildBetaalwijzeQuery groupByIsActief() Group by the actief column
 * @method     ChildBetaalwijzeQuery groupByDatumGemaakt() Group by the gemaakt_datum column
 * @method     ChildBetaalwijzeQuery groupByGemaaktDoor() Group by the gemaakt_door column
 * @method     ChildBetaalwijzeQuery groupByDatumGewijzigd() Group by the gewijzigd_datum column
 * @method     ChildBetaalwijzeQuery groupByGewijzigdDoor() Group by the gewijzigd_door column
 *
 * @method     ChildBetaalwijzeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBetaalwijzeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBetaalwijzeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBetaalwijzeQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildBetaalwijzeQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildBetaalwijzeQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildBetaalwijze findOne(ConnectionInterface $con = null) Return the first ChildBetaalwijze matching the query
 * @method     ChildBetaalwijze findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBetaalwijze matching the query, or a new ChildBetaalwijze object populated from the query conditions when no match is found
 *
 * @method     ChildBetaalwijze findOneById(int $id) Return the first ChildBetaalwijze filtered by the id column
 * @method     ChildBetaalwijze findOneByCode(int $code) Return the first ChildBetaalwijze filtered by the code column
 * @method     ChildBetaalwijze findOneByNaam(string $naam) Return the first ChildBetaalwijze filtered by the naam column
 * @method     ChildBetaalwijze findOneByKosten(string $kosten) Return the first ChildBetaalwijze filtered by the kosten column
 * @method     ChildBetaalwijze findOneByPercentage(string $percentage) Return the first ChildBetaalwijze filtered by the percentage column
 * @method     ChildBetaalwijze findOneByBTW(string $btw) Return the first ChildBetaalwijze filtered by the btw column
 * @method     ChildBetaalwijze findOneByIsActief(int $actief) Return the first ChildBetaalwijze filtered by the actief column
 * @method     ChildBetaalwijze findOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildBetaalwijze filtered by the gemaakt_datum column
 * @method     ChildBetaalwijze findOneByGemaaktDoor(string $gemaakt_door) Return the first ChildBetaalwijze filtered by the gemaakt_door column
 * @method     ChildBetaalwijze findOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildBetaalwijze filtered by the gewijzigd_datum column
 * @method     ChildBetaalwijze findOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildBetaalwijze filtered by the gewijzigd_door column *

 * @method     ChildBetaalwijze requirePk($key, ConnectionInterface $con = null) Return the ChildBetaalwijze by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBetaalwijze requireOne(ConnectionInterface $con = null) Return the first ChildBetaalwijze matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBetaalwijze requireOneById(int $id) Return the first ChildBetaalwijze filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBetaalwijze requireOneByCode(int $code) Return the first ChildBetaalwijze filtered by the code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBetaalwijze requireOneByNaam(string $naam) Return the first ChildBetaalwijze filtered by the naam column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBetaalwijze requireOneByKosten(string $kosten) Return the first ChildBetaalwijze filtered by the kosten column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBetaalwijze requireOneByPercentage(string $percentage) Return the first ChildBetaalwijze filtered by the percentage column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBetaalwijze requireOneByBTW(string $btw) Return the first ChildBetaalwijze filtered by the btw column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBetaalwijze requireOneByIsActief(int $actief) Return the first ChildBetaalwijze filtered by the actief column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBetaalwijze requireOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildBetaalwijze filtered by the gemaakt_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBetaalwijze requireOneByGemaaktDoor(string $gemaakt_door) Return the first ChildBetaalwijze filtered by the gemaakt_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBetaalwijze requireOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildBetaalwijze filtered by the gewijzigd_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBetaalwijze requireOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildBetaalwijze filtered by the gewijzigd_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBetaalwijze[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildBetaalwijze objects based on current ModelCriteria
 * @method     ChildBetaalwijze[]|ObjectCollection findById(int $id) Return ChildBetaalwijze objects filtered by the id column
 * @method     ChildBetaalwijze[]|ObjectCollection findByCode(int $code) Return ChildBetaalwijze objects filtered by the code column
 * @method     ChildBetaalwijze[]|ObjectCollection findByNaam(string $naam) Return ChildBetaalwijze objects filtered by the naam column
 * @method     ChildBetaalwijze[]|ObjectCollection findByKosten(string $kosten) Return ChildBetaalwijze objects filtered by the kosten column
 * @method     ChildBetaalwijze[]|ObjectCollection findByPercentage(string $percentage) Return ChildBetaalwijze objects filtered by the percentage column
 * @method     ChildBetaalwijze[]|ObjectCollection findByBTW(string $btw) Return ChildBetaalwijze objects filtered by the btw column
 * @method     ChildBetaalwijze[]|ObjectCollection findByIsActief(int $actief) Return ChildBetaalwijze objects filtered by the actief column
 * @method     ChildBetaalwijze[]|ObjectCollection findByDatumGemaakt(string $gemaakt_datum) Return ChildBetaalwijze objects filtered by the gemaakt_datum column
 * @method     ChildBetaalwijze[]|ObjectCollection findByGemaaktDoor(string $gemaakt_door) Return ChildBetaalwijze objects filtered by the gemaakt_door column
 * @method     ChildBetaalwijze[]|ObjectCollection findByDatumGewijzigd(string $gewijzigd_datum) Return ChildBetaalwijze objects filtered by the gewijzigd_datum column
 * @method     ChildBetaalwijze[]|ObjectCollection findByGewijzigdDoor(string $gewijzigd_door) Return ChildBetaalwijze objects filtered by the gewijzigd_door column
 * @method     ChildBetaalwijze[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class BetaalwijzeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \fb_model\fb_model\Base\BetaalwijzeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\fb_model\\fb_model\\Betaalwijze', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBetaalwijzeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBetaalwijzeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildBetaalwijzeQuery) {
            return $criteria;
        }
        $query = new ChildBetaalwijzeQuery();
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
     * @return ChildBetaalwijze|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BetaalwijzeTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = BetaalwijzeTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildBetaalwijze A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, code, naam, kosten, percentage, btw, actief, gemaakt_datum, gemaakt_door, gewijzigd_datum, gewijzigd_door FROM fb_betaalwijze WHERE id = :p0';
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
            /** @var ChildBetaalwijze $obj */
            $obj = new ChildBetaalwijze();
            $obj->hydrate($row);
            BetaalwijzeTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildBetaalwijze|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildBetaalwijzeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BetaalwijzeTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildBetaalwijzeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BetaalwijzeTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildBetaalwijzeQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(BetaalwijzeTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(BetaalwijzeTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BetaalwijzeTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildBetaalwijzeQuery The current query, for fluid interface
     */
    public function filterByCode($code = null, $comparison = null)
    {
        if (is_array($code)) {
            $useMinMax = false;
            if (isset($code['min'])) {
                $this->addUsingAlias(BetaalwijzeTableMap::COL_CODE, $code['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($code['max'])) {
                $this->addUsingAlias(BetaalwijzeTableMap::COL_CODE, $code['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BetaalwijzeTableMap::COL_CODE, $code, $comparison);
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
     * @return $this|ChildBetaalwijzeQuery The current query, for fluid interface
     */
    public function filterByNaam($naam = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($naam)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BetaalwijzeTableMap::COL_NAAM, $naam, $comparison);
    }

    /**
     * Filter the query on the kosten column
     *
     * Example usage:
     * <code>
     * $query->filterByKosten(1234); // WHERE kosten = 1234
     * $query->filterByKosten(array(12, 34)); // WHERE kosten IN (12, 34)
     * $query->filterByKosten(array('min' => 12)); // WHERE kosten > 12
     * </code>
     *
     * @param     mixed $kosten The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBetaalwijzeQuery The current query, for fluid interface
     */
    public function filterByKosten($kosten = null, $comparison = null)
    {
        if (is_array($kosten)) {
            $useMinMax = false;
            if (isset($kosten['min'])) {
                $this->addUsingAlias(BetaalwijzeTableMap::COL_KOSTEN, $kosten['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($kosten['max'])) {
                $this->addUsingAlias(BetaalwijzeTableMap::COL_KOSTEN, $kosten['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BetaalwijzeTableMap::COL_KOSTEN, $kosten, $comparison);
    }

    /**
     * Filter the query on the percentage column
     *
     * Example usage:
     * <code>
     * $query->filterByPercentage(1234); // WHERE percentage = 1234
     * $query->filterByPercentage(array(12, 34)); // WHERE percentage IN (12, 34)
     * $query->filterByPercentage(array('min' => 12)); // WHERE percentage > 12
     * </code>
     *
     * @param     mixed $percentage The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBetaalwijzeQuery The current query, for fluid interface
     */
    public function filterByPercentage($percentage = null, $comparison = null)
    {
        if (is_array($percentage)) {
            $useMinMax = false;
            if (isset($percentage['min'])) {
                $this->addUsingAlias(BetaalwijzeTableMap::COL_PERCENTAGE, $percentage['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($percentage['max'])) {
                $this->addUsingAlias(BetaalwijzeTableMap::COL_PERCENTAGE, $percentage['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BetaalwijzeTableMap::COL_PERCENTAGE, $percentage, $comparison);
    }

    /**
     * Filter the query on the btw column
     *
     * Example usage:
     * <code>
     * $query->filterByBTW(1234); // WHERE btw = 1234
     * $query->filterByBTW(array(12, 34)); // WHERE btw IN (12, 34)
     * $query->filterByBTW(array('min' => 12)); // WHERE btw > 12
     * </code>
     *
     * @param     mixed $bTW The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBetaalwijzeQuery The current query, for fluid interface
     */
    public function filterByBTW($bTW = null, $comparison = null)
    {
        if (is_array($bTW)) {
            $useMinMax = false;
            if (isset($bTW['min'])) {
                $this->addUsingAlias(BetaalwijzeTableMap::COL_BTW, $bTW['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bTW['max'])) {
                $this->addUsingAlias(BetaalwijzeTableMap::COL_BTW, $bTW['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BetaalwijzeTableMap::COL_BTW, $bTW, $comparison);
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
     * @return $this|ChildBetaalwijzeQuery The current query, for fluid interface
     */
    public function filterByIsActief($isActief = null, $comparison = null)
    {
        if (is_array($isActief)) {
            $useMinMax = false;
            if (isset($isActief['min'])) {
                $this->addUsingAlias(BetaalwijzeTableMap::COL_ACTIEF, $isActief['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isActief['max'])) {
                $this->addUsingAlias(BetaalwijzeTableMap::COL_ACTIEF, $isActief['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BetaalwijzeTableMap::COL_ACTIEF, $isActief, $comparison);
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
     * @return $this|ChildBetaalwijzeQuery The current query, for fluid interface
     */
    public function filterByDatumGemaakt($datumGemaakt = null, $comparison = null)
    {
        if (is_array($datumGemaakt)) {
            $useMinMax = false;
            if (isset($datumGemaakt['min'])) {
                $this->addUsingAlias(BetaalwijzeTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGemaakt['max'])) {
                $this->addUsingAlias(BetaalwijzeTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BetaalwijzeTableMap::COL_GEMAAKT_DATUM, $datumGemaakt, $comparison);
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
     * @return $this|ChildBetaalwijzeQuery The current query, for fluid interface
     */
    public function filterByGemaaktDoor($gemaaktDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gemaaktDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BetaalwijzeTableMap::COL_GEMAAKT_DOOR, $gemaaktDoor, $comparison);
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
     * @return $this|ChildBetaalwijzeQuery The current query, for fluid interface
     */
    public function filterByDatumGewijzigd($datumGewijzigd = null, $comparison = null)
    {
        if (is_array($datumGewijzigd)) {
            $useMinMax = false;
            if (isset($datumGewijzigd['min'])) {
                $this->addUsingAlias(BetaalwijzeTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGewijzigd['max'])) {
                $this->addUsingAlias(BetaalwijzeTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BetaalwijzeTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd, $comparison);
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
     * @return $this|ChildBetaalwijzeQuery The current query, for fluid interface
     */
    public function filterByGewijzigdDoor($gewijzigdDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gewijzigdDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BetaalwijzeTableMap::COL_GEWIJZIGD_DOOR, $gewijzigdDoor, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildBetaalwijze $betaalwijze Object to remove from the list of results
     *
     * @return $this|ChildBetaalwijzeQuery The current query, for fluid interface
     */
    public function prune($betaalwijze = null)
    {
        if ($betaalwijze) {
            $this->addUsingAlias(BetaalwijzeTableMap::COL_ID, $betaalwijze->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fb_betaalwijze table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BetaalwijzeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BetaalwijzeTableMap::clearInstancePool();
            BetaalwijzeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(BetaalwijzeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BetaalwijzeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            BetaalwijzeTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            BetaalwijzeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildBetaalwijzeQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(BetaalwijzeTableMap::COL_GEWIJZIGD_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildBetaalwijzeQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(BetaalwijzeTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildBetaalwijzeQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(BetaalwijzeTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildBetaalwijzeQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(BetaalwijzeTableMap::COL_GEMAAKT_DATUM);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildBetaalwijzeQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(BetaalwijzeTableMap::COL_GEMAAKT_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildBetaalwijzeQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(BetaalwijzeTableMap::COL_GEMAAKT_DATUM);
    }

} // BetaalwijzeQuery
