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
use fb_model\fb_model\Keuzes as ChildKeuzes;
use fb_model\fb_model\KeuzesQuery as ChildKeuzesQuery;
use fb_model\fb_model\Map\KeuzesTableMap;

/**
 * Base class that represents a query for the 'fb_keuzes' table.
 *
 *
 *
 * @method     ChildKeuzesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildKeuzesQuery orderByCode($order = Criteria::ASC) Order by the code column
 * @method     ChildKeuzesQuery orderByKeuzeType($order = Criteria::ASC) Order by the keuzetype column
 * @method     ChildKeuzesQuery orderByNaam($order = Criteria::ASC) Order by the naam column
 * @method     ChildKeuzesQuery orderByIsActief($order = Criteria::ASC) Order by the actief column
 * @method     ChildKeuzesQuery orderByDatumGemaakt($order = Criteria::ASC) Order by the gemaakt_datum column
 * @method     ChildKeuzesQuery orderByGemaaktDoor($order = Criteria::ASC) Order by the gemaakt_door column
 * @method     ChildKeuzesQuery orderByDatumGewijzigd($order = Criteria::ASC) Order by the gewijzigd_datum column
 * @method     ChildKeuzesQuery orderByGewijzigdDoor($order = Criteria::ASC) Order by the gewijzigd_door column
 *
 * @method     ChildKeuzesQuery groupById() Group by the id column
 * @method     ChildKeuzesQuery groupByCode() Group by the code column
 * @method     ChildKeuzesQuery groupByKeuzeType() Group by the keuzetype column
 * @method     ChildKeuzesQuery groupByNaam() Group by the naam column
 * @method     ChildKeuzesQuery groupByIsActief() Group by the actief column
 * @method     ChildKeuzesQuery groupByDatumGemaakt() Group by the gemaakt_datum column
 * @method     ChildKeuzesQuery groupByGemaaktDoor() Group by the gemaakt_door column
 * @method     ChildKeuzesQuery groupByDatumGewijzigd() Group by the gewijzigd_datum column
 * @method     ChildKeuzesQuery groupByGewijzigdDoor() Group by the gewijzigd_door column
 *
 * @method     ChildKeuzesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildKeuzesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildKeuzesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildKeuzesQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildKeuzesQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildKeuzesQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildKeuzesQuery leftJoinEvenement($relationAlias = null) Adds a LEFT JOIN clause to the query using the Evenement relation
 * @method     ChildKeuzesQuery rightJoinEvenement($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Evenement relation
 * @method     ChildKeuzesQuery innerJoinEvenement($relationAlias = null) Adds a INNER JOIN clause to the query using the Evenement relation
 *
 * @method     ChildKeuzesQuery joinWithEvenement($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Evenement relation
 *
 * @method     ChildKeuzesQuery leftJoinWithEvenement() Adds a LEFT JOIN clause and with to the query using the Evenement relation
 * @method     ChildKeuzesQuery rightJoinWithEvenement() Adds a RIGHT JOIN clause and with to the query using the Evenement relation
 * @method     ChildKeuzesQuery innerJoinWithEvenement() Adds a INNER JOIN clause and with to the query using the Evenement relation
 *
 * @method     ChildKeuzesQuery leftJoinGebruiker($relationAlias = null) Adds a LEFT JOIN clause to the query using the Gebruiker relation
 * @method     ChildKeuzesQuery rightJoinGebruiker($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Gebruiker relation
 * @method     ChildKeuzesQuery innerJoinGebruiker($relationAlias = null) Adds a INNER JOIN clause to the query using the Gebruiker relation
 *
 * @method     ChildKeuzesQuery joinWithGebruiker($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Gebruiker relation
 *
 * @method     ChildKeuzesQuery leftJoinWithGebruiker() Adds a LEFT JOIN clause and with to the query using the Gebruiker relation
 * @method     ChildKeuzesQuery rightJoinWithGebruiker() Adds a RIGHT JOIN clause and with to the query using the Gebruiker relation
 * @method     ChildKeuzesQuery innerJoinWithGebruiker() Adds a INNER JOIN clause and with to the query using the Gebruiker relation
 *
 * @method     ChildKeuzesQuery leftJoinInschrijving($relationAlias = null) Adds a LEFT JOIN clause to the query using the Inschrijving relation
 * @method     ChildKeuzesQuery rightJoinInschrijving($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Inschrijving relation
 * @method     ChildKeuzesQuery innerJoinInschrijving($relationAlias = null) Adds a INNER JOIN clause to the query using the Inschrijving relation
 *
 * @method     ChildKeuzesQuery joinWithInschrijving($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Inschrijving relation
 *
 * @method     ChildKeuzesQuery leftJoinWithInschrijving() Adds a LEFT JOIN clause and with to the query using the Inschrijving relation
 * @method     ChildKeuzesQuery rightJoinWithInschrijving() Adds a RIGHT JOIN clause and with to the query using the Inschrijving relation
 * @method     ChildKeuzesQuery innerJoinWithInschrijving() Adds a INNER JOIN clause and with to the query using the Inschrijving relation
 *
 * @method     \fb_model\fb_model\EvenementQuery|\fb_model\fb_model\GebruikerQuery|\fb_model\fb_model\InschrijvingQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildKeuzes findOne(ConnectionInterface $con = null) Return the first ChildKeuzes matching the query
 * @method     ChildKeuzes findOneOrCreate(ConnectionInterface $con = null) Return the first ChildKeuzes matching the query, or a new ChildKeuzes object populated from the query conditions when no match is found
 *
 * @method     ChildKeuzes findOneById(int $id) Return the first ChildKeuzes filtered by the id column
 * @method     ChildKeuzes findOneByCode(int $code) Return the first ChildKeuzes filtered by the code column
 * @method     ChildKeuzes findOneByKeuzeType(int $keuzetype) Return the first ChildKeuzes filtered by the keuzetype column
 * @method     ChildKeuzes findOneByNaam(string $naam) Return the first ChildKeuzes filtered by the naam column
 * @method     ChildKeuzes findOneByIsActief(int $actief) Return the first ChildKeuzes filtered by the actief column
 * @method     ChildKeuzes findOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildKeuzes filtered by the gemaakt_datum column
 * @method     ChildKeuzes findOneByGemaaktDoor(string $gemaakt_door) Return the first ChildKeuzes filtered by the gemaakt_door column
 * @method     ChildKeuzes findOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildKeuzes filtered by the gewijzigd_datum column
 * @method     ChildKeuzes findOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildKeuzes filtered by the gewijzigd_door column *

 * @method     ChildKeuzes requirePk($key, ConnectionInterface $con = null) Return the ChildKeuzes by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildKeuzes requireOne(ConnectionInterface $con = null) Return the first ChildKeuzes matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildKeuzes requireOneById(int $id) Return the first ChildKeuzes filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildKeuzes requireOneByCode(int $code) Return the first ChildKeuzes filtered by the code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildKeuzes requireOneByKeuzeType(int $keuzetype) Return the first ChildKeuzes filtered by the keuzetype column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildKeuzes requireOneByNaam(string $naam) Return the first ChildKeuzes filtered by the naam column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildKeuzes requireOneByIsActief(int $actief) Return the first ChildKeuzes filtered by the actief column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildKeuzes requireOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildKeuzes filtered by the gemaakt_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildKeuzes requireOneByGemaaktDoor(string $gemaakt_door) Return the first ChildKeuzes filtered by the gemaakt_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildKeuzes requireOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildKeuzes filtered by the gewijzigd_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildKeuzes requireOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildKeuzes filtered by the gewijzigd_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildKeuzes[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildKeuzes objects based on current ModelCriteria
 * @method     ChildKeuzes[]|ObjectCollection findById(int $id) Return ChildKeuzes objects filtered by the id column
 * @method     ChildKeuzes[]|ObjectCollection findByCode(int $code) Return ChildKeuzes objects filtered by the code column
 * @method     ChildKeuzes[]|ObjectCollection findByKeuzeType(int $keuzetype) Return ChildKeuzes objects filtered by the keuzetype column
 * @method     ChildKeuzes[]|ObjectCollection findByNaam(string $naam) Return ChildKeuzes objects filtered by the naam column
 * @method     ChildKeuzes[]|ObjectCollection findByIsActief(int $actief) Return ChildKeuzes objects filtered by the actief column
 * @method     ChildKeuzes[]|ObjectCollection findByDatumGemaakt(string $gemaakt_datum) Return ChildKeuzes objects filtered by the gemaakt_datum column
 * @method     ChildKeuzes[]|ObjectCollection findByGemaaktDoor(string $gemaakt_door) Return ChildKeuzes objects filtered by the gemaakt_door column
 * @method     ChildKeuzes[]|ObjectCollection findByDatumGewijzigd(string $gewijzigd_datum) Return ChildKeuzes objects filtered by the gewijzigd_datum column
 * @method     ChildKeuzes[]|ObjectCollection findByGewijzigdDoor(string $gewijzigd_door) Return ChildKeuzes objects filtered by the gewijzigd_door column
 * @method     ChildKeuzes[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class KeuzesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \fb_model\fb_model\Base\KeuzesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\fb_model\\fb_model\\Keuzes', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildKeuzesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildKeuzesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildKeuzesQuery) {
            return $criteria;
        }
        $query = new ChildKeuzesQuery();
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
     * @return ChildKeuzes|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(KeuzesTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = KeuzesTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildKeuzes A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, code, keuzetype, naam, actief, gemaakt_datum, gemaakt_door, gewijzigd_datum, gewijzigd_door FROM fb_keuzes WHERE id = :p0';
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
            /** @var ChildKeuzes $obj */
            $obj = new ChildKeuzes();
            $obj->hydrate($row);
            KeuzesTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildKeuzes|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildKeuzesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(KeuzesTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildKeuzesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(KeuzesTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildKeuzesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(KeuzesTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(KeuzesTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(KeuzesTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildKeuzesQuery The current query, for fluid interface
     */
    public function filterByCode($code = null, $comparison = null)
    {
        if (is_array($code)) {
            $useMinMax = false;
            if (isset($code['min'])) {
                $this->addUsingAlias(KeuzesTableMap::COL_CODE, $code['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($code['max'])) {
                $this->addUsingAlias(KeuzesTableMap::COL_CODE, $code['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(KeuzesTableMap::COL_CODE, $code, $comparison);
    }

    /**
     * Filter the query on the keuzetype column
     *
     * Example usage:
     * <code>
     * $query->filterByKeuzeType(1234); // WHERE keuzetype = 1234
     * $query->filterByKeuzeType(array(12, 34)); // WHERE keuzetype IN (12, 34)
     * $query->filterByKeuzeType(array('min' => 12)); // WHERE keuzetype > 12
     * </code>
     *
     * @param     mixed $keuzeType The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildKeuzesQuery The current query, for fluid interface
     */
    public function filterByKeuzeType($keuzeType = null, $comparison = null)
    {
        if (is_array($keuzeType)) {
            $useMinMax = false;
            if (isset($keuzeType['min'])) {
                $this->addUsingAlias(KeuzesTableMap::COL_KEUZETYPE, $keuzeType['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($keuzeType['max'])) {
                $this->addUsingAlias(KeuzesTableMap::COL_KEUZETYPE, $keuzeType['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(KeuzesTableMap::COL_KEUZETYPE, $keuzeType, $comparison);
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
     * @return $this|ChildKeuzesQuery The current query, for fluid interface
     */
    public function filterByNaam($naam = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($naam)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(KeuzesTableMap::COL_NAAM, $naam, $comparison);
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
     * @return $this|ChildKeuzesQuery The current query, for fluid interface
     */
    public function filterByIsActief($isActief = null, $comparison = null)
    {
        if (is_array($isActief)) {
            $useMinMax = false;
            if (isset($isActief['min'])) {
                $this->addUsingAlias(KeuzesTableMap::COL_ACTIEF, $isActief['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isActief['max'])) {
                $this->addUsingAlias(KeuzesTableMap::COL_ACTIEF, $isActief['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(KeuzesTableMap::COL_ACTIEF, $isActief, $comparison);
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
     * @return $this|ChildKeuzesQuery The current query, for fluid interface
     */
    public function filterByDatumGemaakt($datumGemaakt = null, $comparison = null)
    {
        if (is_array($datumGemaakt)) {
            $useMinMax = false;
            if (isset($datumGemaakt['min'])) {
                $this->addUsingAlias(KeuzesTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGemaakt['max'])) {
                $this->addUsingAlias(KeuzesTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(KeuzesTableMap::COL_GEMAAKT_DATUM, $datumGemaakt, $comparison);
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
     * @return $this|ChildKeuzesQuery The current query, for fluid interface
     */
    public function filterByGemaaktDoor($gemaaktDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gemaaktDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(KeuzesTableMap::COL_GEMAAKT_DOOR, $gemaaktDoor, $comparison);
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
     * @return $this|ChildKeuzesQuery The current query, for fluid interface
     */
    public function filterByDatumGewijzigd($datumGewijzigd = null, $comparison = null)
    {
        if (is_array($datumGewijzigd)) {
            $useMinMax = false;
            if (isset($datumGewijzigd['min'])) {
                $this->addUsingAlias(KeuzesTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGewijzigd['max'])) {
                $this->addUsingAlias(KeuzesTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(KeuzesTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd, $comparison);
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
     * @return $this|ChildKeuzesQuery The current query, for fluid interface
     */
    public function filterByGewijzigdDoor($gewijzigdDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gewijzigdDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(KeuzesTableMap::COL_GEWIJZIGD_DOOR, $gewijzigdDoor, $comparison);
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Evenement object
     *
     * @param \fb_model\fb_model\Evenement|ObjectCollection $evenement the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildKeuzesQuery The current query, for fluid interface
     */
    public function filterByEvenement($evenement, $comparison = null)
    {
        if ($evenement instanceof \fb_model\fb_model\Evenement) {
            return $this
                ->addUsingAlias(KeuzesTableMap::COL_ID, $evenement->getStatus(), $comparison);
        } elseif ($evenement instanceof ObjectCollection) {
            return $this
                ->useEvenementQuery()
                ->filterByPrimaryKeys($evenement->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByEvenement() only accepts arguments of type \fb_model\fb_model\Evenement or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Evenement relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildKeuzesQuery The current query, for fluid interface
     */
    public function joinEvenement($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Evenement');

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
            $this->addJoinObject($join, 'Evenement');
        }

        return $this;
    }

    /**
     * Use the Evenement relation Evenement object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \fb_model\fb_model\EvenementQuery A secondary query class using the current class as primary query
     */
    public function useEvenementQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinEvenement($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Evenement', '\fb_model\fb_model\EvenementQuery');
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Gebruiker object
     *
     * @param \fb_model\fb_model\Gebruiker|ObjectCollection $gebruiker the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildKeuzesQuery The current query, for fluid interface
     */
    public function filterByGebruiker($gebruiker, $comparison = null)
    {
        if ($gebruiker instanceof \fb_model\fb_model\Gebruiker) {
            return $this
                ->addUsingAlias(KeuzesTableMap::COL_ID, $gebruiker->getRol(), $comparison);
        } elseif ($gebruiker instanceof ObjectCollection) {
            return $this
                ->useGebruikerQuery()
                ->filterByPrimaryKeys($gebruiker->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGebruiker() only accepts arguments of type \fb_model\fb_model\Gebruiker or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Gebruiker relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildKeuzesQuery The current query, for fluid interface
     */
    public function joinGebruiker($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Gebruiker');

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
            $this->addJoinObject($join, 'Gebruiker');
        }

        return $this;
    }

    /**
     * Use the Gebruiker relation Gebruiker object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \fb_model\fb_model\GebruikerQuery A secondary query class using the current class as primary query
     */
    public function useGebruikerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGebruiker($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Gebruiker', '\fb_model\fb_model\GebruikerQuery');
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Inschrijving object
     *
     * @param \fb_model\fb_model\Inschrijving|ObjectCollection $inschrijving the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildKeuzesQuery The current query, for fluid interface
     */
    public function filterByInschrijving($inschrijving, $comparison = null)
    {
        if ($inschrijving instanceof \fb_model\fb_model\Inschrijving) {
            return $this
                ->addUsingAlias(KeuzesTableMap::COL_ID, $inschrijving->getStatus(), $comparison);
        } elseif ($inschrijving instanceof ObjectCollection) {
            return $this
                ->useInschrijvingQuery()
                ->filterByPrimaryKeys($inschrijving->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildKeuzesQuery The current query, for fluid interface
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
     * @param   ChildKeuzes $keuzes Object to remove from the list of results
     *
     * @return $this|ChildKeuzesQuery The current query, for fluid interface
     */
    public function prune($keuzes = null)
    {
        if ($keuzes) {
            $this->addUsingAlias(KeuzesTableMap::COL_ID, $keuzes->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fb_keuzes table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(KeuzesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            KeuzesTableMap::clearInstancePool();
            KeuzesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(KeuzesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(KeuzesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            KeuzesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            KeuzesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildKeuzesQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(KeuzesTableMap::COL_GEWIJZIGD_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildKeuzesQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(KeuzesTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildKeuzesQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(KeuzesTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildKeuzesQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(KeuzesTableMap::COL_GEMAAKT_DATUM);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildKeuzesQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(KeuzesTableMap::COL_GEMAAKT_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildKeuzesQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(KeuzesTableMap::COL_GEMAAKT_DATUM);
    }

} // KeuzesQuery
