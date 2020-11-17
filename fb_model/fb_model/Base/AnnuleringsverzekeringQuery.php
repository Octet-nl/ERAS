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
use fb_model\fb_model\Annuleringsverzekering as ChildAnnuleringsverzekering;
use fb_model\fb_model\AnnuleringsverzekeringQuery as ChildAnnuleringsverzekeringQuery;
use fb_model\fb_model\Map\AnnuleringsverzekeringTableMap;

/**
 * Base class that represents a query for the 'fb_annuleringsverzekering' table.
 *
 *
 *
 * @method     ChildAnnuleringsverzekeringQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAnnuleringsverzekeringQuery orderByCode($order = Criteria::ASC) Order by the code column
 * @method     ChildAnnuleringsverzekeringQuery orderByNaam($order = Criteria::ASC) Order by the naam column
 * @method     ChildAnnuleringsverzekeringQuery orderByAfsluitkosten($order = Criteria::ASC) Order by the afsluitkosten column
 * @method     ChildAnnuleringsverzekeringQuery orderByPercentage($order = Criteria::ASC) Order by the percentage column
 * @method     ChildAnnuleringsverzekeringQuery orderByBTW($order = Criteria::ASC) Order by the btw column
 * @method     ChildAnnuleringsverzekeringQuery orderByDatumGemaakt($order = Criteria::ASC) Order by the gemaakt_datum column
 * @method     ChildAnnuleringsverzekeringQuery orderByGemaaktDoor($order = Criteria::ASC) Order by the gemaakt_door column
 * @method     ChildAnnuleringsverzekeringQuery orderByDatumGewijzigd($order = Criteria::ASC) Order by the gewijzigd_datum column
 * @method     ChildAnnuleringsverzekeringQuery orderByGewijzigdDoor($order = Criteria::ASC) Order by the gewijzigd_door column
 *
 * @method     ChildAnnuleringsverzekeringQuery groupById() Group by the id column
 * @method     ChildAnnuleringsverzekeringQuery groupByCode() Group by the code column
 * @method     ChildAnnuleringsverzekeringQuery groupByNaam() Group by the naam column
 * @method     ChildAnnuleringsverzekeringQuery groupByAfsluitkosten() Group by the afsluitkosten column
 * @method     ChildAnnuleringsverzekeringQuery groupByPercentage() Group by the percentage column
 * @method     ChildAnnuleringsverzekeringQuery groupByBTW() Group by the btw column
 * @method     ChildAnnuleringsverzekeringQuery groupByDatumGemaakt() Group by the gemaakt_datum column
 * @method     ChildAnnuleringsverzekeringQuery groupByGemaaktDoor() Group by the gemaakt_door column
 * @method     ChildAnnuleringsverzekeringQuery groupByDatumGewijzigd() Group by the gewijzigd_datum column
 * @method     ChildAnnuleringsverzekeringQuery groupByGewijzigdDoor() Group by the gewijzigd_door column
 *
 * @method     ChildAnnuleringsverzekeringQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAnnuleringsverzekeringQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAnnuleringsverzekeringQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAnnuleringsverzekeringQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAnnuleringsverzekeringQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAnnuleringsverzekeringQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAnnuleringsverzekering findOne(ConnectionInterface $con = null) Return the first ChildAnnuleringsverzekering matching the query
 * @method     ChildAnnuleringsverzekering findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAnnuleringsverzekering matching the query, or a new ChildAnnuleringsverzekering object populated from the query conditions when no match is found
 *
 * @method     ChildAnnuleringsverzekering findOneById(int $id) Return the first ChildAnnuleringsverzekering filtered by the id column
 * @method     ChildAnnuleringsverzekering findOneByCode(int $code) Return the first ChildAnnuleringsverzekering filtered by the code column
 * @method     ChildAnnuleringsverzekering findOneByNaam(string $naam) Return the first ChildAnnuleringsverzekering filtered by the naam column
 * @method     ChildAnnuleringsverzekering findOneByAfsluitkosten(string $afsluitkosten) Return the first ChildAnnuleringsverzekering filtered by the afsluitkosten column
 * @method     ChildAnnuleringsverzekering findOneByPercentage(string $percentage) Return the first ChildAnnuleringsverzekering filtered by the percentage column
 * @method     ChildAnnuleringsverzekering findOneByBTW(string $btw) Return the first ChildAnnuleringsverzekering filtered by the btw column
 * @method     ChildAnnuleringsverzekering findOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildAnnuleringsverzekering filtered by the gemaakt_datum column
 * @method     ChildAnnuleringsverzekering findOneByGemaaktDoor(string $gemaakt_door) Return the first ChildAnnuleringsverzekering filtered by the gemaakt_door column
 * @method     ChildAnnuleringsverzekering findOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildAnnuleringsverzekering filtered by the gewijzigd_datum column
 * @method     ChildAnnuleringsverzekering findOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildAnnuleringsverzekering filtered by the gewijzigd_door column *

 * @method     ChildAnnuleringsverzekering requirePk($key, ConnectionInterface $con = null) Return the ChildAnnuleringsverzekering by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnnuleringsverzekering requireOne(ConnectionInterface $con = null) Return the first ChildAnnuleringsverzekering matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAnnuleringsverzekering requireOneById(int $id) Return the first ChildAnnuleringsverzekering filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnnuleringsverzekering requireOneByCode(int $code) Return the first ChildAnnuleringsverzekering filtered by the code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnnuleringsverzekering requireOneByNaam(string $naam) Return the first ChildAnnuleringsverzekering filtered by the naam column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnnuleringsverzekering requireOneByAfsluitkosten(string $afsluitkosten) Return the first ChildAnnuleringsverzekering filtered by the afsluitkosten column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnnuleringsverzekering requireOneByPercentage(string $percentage) Return the first ChildAnnuleringsverzekering filtered by the percentage column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnnuleringsverzekering requireOneByBTW(string $btw) Return the first ChildAnnuleringsverzekering filtered by the btw column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnnuleringsverzekering requireOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildAnnuleringsverzekering filtered by the gemaakt_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnnuleringsverzekering requireOneByGemaaktDoor(string $gemaakt_door) Return the first ChildAnnuleringsverzekering filtered by the gemaakt_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnnuleringsverzekering requireOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildAnnuleringsverzekering filtered by the gewijzigd_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnnuleringsverzekering requireOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildAnnuleringsverzekering filtered by the gewijzigd_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAnnuleringsverzekering[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAnnuleringsverzekering objects based on current ModelCriteria
 * @method     ChildAnnuleringsverzekering[]|ObjectCollection findById(int $id) Return ChildAnnuleringsverzekering objects filtered by the id column
 * @method     ChildAnnuleringsverzekering[]|ObjectCollection findByCode(int $code) Return ChildAnnuleringsverzekering objects filtered by the code column
 * @method     ChildAnnuleringsverzekering[]|ObjectCollection findByNaam(string $naam) Return ChildAnnuleringsverzekering objects filtered by the naam column
 * @method     ChildAnnuleringsverzekering[]|ObjectCollection findByAfsluitkosten(string $afsluitkosten) Return ChildAnnuleringsverzekering objects filtered by the afsluitkosten column
 * @method     ChildAnnuleringsverzekering[]|ObjectCollection findByPercentage(string $percentage) Return ChildAnnuleringsverzekering objects filtered by the percentage column
 * @method     ChildAnnuleringsverzekering[]|ObjectCollection findByBTW(string $btw) Return ChildAnnuleringsverzekering objects filtered by the btw column
 * @method     ChildAnnuleringsverzekering[]|ObjectCollection findByDatumGemaakt(string $gemaakt_datum) Return ChildAnnuleringsverzekering objects filtered by the gemaakt_datum column
 * @method     ChildAnnuleringsverzekering[]|ObjectCollection findByGemaaktDoor(string $gemaakt_door) Return ChildAnnuleringsverzekering objects filtered by the gemaakt_door column
 * @method     ChildAnnuleringsverzekering[]|ObjectCollection findByDatumGewijzigd(string $gewijzigd_datum) Return ChildAnnuleringsverzekering objects filtered by the gewijzigd_datum column
 * @method     ChildAnnuleringsverzekering[]|ObjectCollection findByGewijzigdDoor(string $gewijzigd_door) Return ChildAnnuleringsverzekering objects filtered by the gewijzigd_door column
 * @method     ChildAnnuleringsverzekering[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AnnuleringsverzekeringQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \fb_model\fb_model\Base\AnnuleringsverzekeringQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\fb_model\\fb_model\\Annuleringsverzekering', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAnnuleringsverzekeringQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAnnuleringsverzekeringQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAnnuleringsverzekeringQuery) {
            return $criteria;
        }
        $query = new ChildAnnuleringsverzekeringQuery();
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
     * @return ChildAnnuleringsverzekering|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AnnuleringsverzekeringTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AnnuleringsverzekeringTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildAnnuleringsverzekering A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, code, naam, afsluitkosten, percentage, btw, gemaakt_datum, gemaakt_door, gewijzigd_datum, gewijzigd_door FROM fb_annuleringsverzekering WHERE id = :p0';
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
            /** @var ChildAnnuleringsverzekering $obj */
            $obj = new ChildAnnuleringsverzekering();
            $obj->hydrate($row);
            AnnuleringsverzekeringTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAnnuleringsverzekering|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAnnuleringsverzekeringQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAnnuleringsverzekeringQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildAnnuleringsverzekeringQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildAnnuleringsverzekeringQuery The current query, for fluid interface
     */
    public function filterByCode($code = null, $comparison = null)
    {
        if (is_array($code)) {
            $useMinMax = false;
            if (isset($code['min'])) {
                $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_CODE, $code['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($code['max'])) {
                $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_CODE, $code['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_CODE, $code, $comparison);
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
     * @return $this|ChildAnnuleringsverzekeringQuery The current query, for fluid interface
     */
    public function filterByNaam($naam = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($naam)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_NAAM, $naam, $comparison);
    }

    /**
     * Filter the query on the afsluitkosten column
     *
     * Example usage:
     * <code>
     * $query->filterByAfsluitkosten(1234); // WHERE afsluitkosten = 1234
     * $query->filterByAfsluitkosten(array(12, 34)); // WHERE afsluitkosten IN (12, 34)
     * $query->filterByAfsluitkosten(array('min' => 12)); // WHERE afsluitkosten > 12
     * </code>
     *
     * @param     mixed $afsluitkosten The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAnnuleringsverzekeringQuery The current query, for fluid interface
     */
    public function filterByAfsluitkosten($afsluitkosten = null, $comparison = null)
    {
        if (is_array($afsluitkosten)) {
            $useMinMax = false;
            if (isset($afsluitkosten['min'])) {
                $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_AFSLUITKOSTEN, $afsluitkosten['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($afsluitkosten['max'])) {
                $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_AFSLUITKOSTEN, $afsluitkosten['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_AFSLUITKOSTEN, $afsluitkosten, $comparison);
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
     * @return $this|ChildAnnuleringsverzekeringQuery The current query, for fluid interface
     */
    public function filterByPercentage($percentage = null, $comparison = null)
    {
        if (is_array($percentage)) {
            $useMinMax = false;
            if (isset($percentage['min'])) {
                $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_PERCENTAGE, $percentage['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($percentage['max'])) {
                $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_PERCENTAGE, $percentage['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_PERCENTAGE, $percentage, $comparison);
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
     * @return $this|ChildAnnuleringsverzekeringQuery The current query, for fluid interface
     */
    public function filterByBTW($bTW = null, $comparison = null)
    {
        if (is_array($bTW)) {
            $useMinMax = false;
            if (isset($bTW['min'])) {
                $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_BTW, $bTW['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bTW['max'])) {
                $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_BTW, $bTW['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_BTW, $bTW, $comparison);
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
     * @return $this|ChildAnnuleringsverzekeringQuery The current query, for fluid interface
     */
    public function filterByDatumGemaakt($datumGemaakt = null, $comparison = null)
    {
        if (is_array($datumGemaakt)) {
            $useMinMax = false;
            if (isset($datumGemaakt['min'])) {
                $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGemaakt['max'])) {
                $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_GEMAAKT_DATUM, $datumGemaakt, $comparison);
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
     * @return $this|ChildAnnuleringsverzekeringQuery The current query, for fluid interface
     */
    public function filterByGemaaktDoor($gemaaktDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gemaaktDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_GEMAAKT_DOOR, $gemaaktDoor, $comparison);
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
     * @return $this|ChildAnnuleringsverzekeringQuery The current query, for fluid interface
     */
    public function filterByDatumGewijzigd($datumGewijzigd = null, $comparison = null)
    {
        if (is_array($datumGewijzigd)) {
            $useMinMax = false;
            if (isset($datumGewijzigd['min'])) {
                $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGewijzigd['max'])) {
                $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd, $comparison);
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
     * @return $this|ChildAnnuleringsverzekeringQuery The current query, for fluid interface
     */
    public function filterByGewijzigdDoor($gewijzigdDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gewijzigdDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_GEWIJZIGD_DOOR, $gewijzigdDoor, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAnnuleringsverzekering $annuleringsverzekering Object to remove from the list of results
     *
     * @return $this|ChildAnnuleringsverzekeringQuery The current query, for fluid interface
     */
    public function prune($annuleringsverzekering = null)
    {
        if ($annuleringsverzekering) {
            $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_ID, $annuleringsverzekering->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fb_annuleringsverzekering table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AnnuleringsverzekeringTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AnnuleringsverzekeringTableMap::clearInstancePool();
            AnnuleringsverzekeringTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AnnuleringsverzekeringTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AnnuleringsverzekeringTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AnnuleringsverzekeringTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AnnuleringsverzekeringTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildAnnuleringsverzekeringQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_GEWIJZIGD_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildAnnuleringsverzekeringQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(AnnuleringsverzekeringTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildAnnuleringsverzekeringQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(AnnuleringsverzekeringTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildAnnuleringsverzekeringQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(AnnuleringsverzekeringTableMap::COL_GEMAAKT_DATUM);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildAnnuleringsverzekeringQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(AnnuleringsverzekeringTableMap::COL_GEMAAKT_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildAnnuleringsverzekeringQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(AnnuleringsverzekeringTableMap::COL_GEMAAKT_DATUM);
    }

} // AnnuleringsverzekeringQuery
