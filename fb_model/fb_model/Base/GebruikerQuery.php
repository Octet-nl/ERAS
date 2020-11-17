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
use fb_model\fb_model\Gebruiker as ChildGebruiker;
use fb_model\fb_model\GebruikerQuery as ChildGebruikerQuery;
use fb_model\fb_model\Map\GebruikerTableMap;

/**
 * Base class that represents a query for the 'fb_gebruiker' table.
 *
 *
 *
 * @method     ChildGebruikerQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildGebruikerQuery orderByUserId($order = Criteria::ASC) Order by the userid column
 * @method     ChildGebruikerQuery orderByPersoonId($order = Criteria::ASC) Order by the persoon_id column
 * @method     ChildGebruikerQuery orderByRol($order = Criteria::ASC) Order by the rol column
 * @method     ChildGebruikerQuery orderByIsActief($order = Criteria::ASC) Order by the actief column
 * @method     ChildGebruikerQuery orderByWachtwoord($order = Criteria::ASC) Order by the wachtwoord column
 * @method     ChildGebruikerQuery orderByDatumWachtwoordWijzig($order = Criteria::ASC) Order by the wachtwoord_wijzig_datum column
 * @method     ChildGebruikerQuery orderByDatumLaatsteLogin($order = Criteria::ASC) Order by the laatste_login_datum column
 * @method     ChildGebruikerQuery orderByLaatsteLoginAdres($order = Criteria::ASC) Order by the laatste_login_adres column
 * @method     ChildGebruikerQuery orderByDatumGemaakt($order = Criteria::ASC) Order by the gemaakt_datum column
 * @method     ChildGebruikerQuery orderByGemaaktDoor($order = Criteria::ASC) Order by the gemaakt_door column
 * @method     ChildGebruikerQuery orderByDatumGewijzigd($order = Criteria::ASC) Order by the gewijzigd_datum column
 * @method     ChildGebruikerQuery orderByGewijzigdDoor($order = Criteria::ASC) Order by the gewijzigd_door column
 *
 * @method     ChildGebruikerQuery groupById() Group by the id column
 * @method     ChildGebruikerQuery groupByUserId() Group by the userid column
 * @method     ChildGebruikerQuery groupByPersoonId() Group by the persoon_id column
 * @method     ChildGebruikerQuery groupByRol() Group by the rol column
 * @method     ChildGebruikerQuery groupByIsActief() Group by the actief column
 * @method     ChildGebruikerQuery groupByWachtwoord() Group by the wachtwoord column
 * @method     ChildGebruikerQuery groupByDatumWachtwoordWijzig() Group by the wachtwoord_wijzig_datum column
 * @method     ChildGebruikerQuery groupByDatumLaatsteLogin() Group by the laatste_login_datum column
 * @method     ChildGebruikerQuery groupByLaatsteLoginAdres() Group by the laatste_login_adres column
 * @method     ChildGebruikerQuery groupByDatumGemaakt() Group by the gemaakt_datum column
 * @method     ChildGebruikerQuery groupByGemaaktDoor() Group by the gemaakt_door column
 * @method     ChildGebruikerQuery groupByDatumGewijzigd() Group by the gewijzigd_datum column
 * @method     ChildGebruikerQuery groupByGewijzigdDoor() Group by the gewijzigd_door column
 *
 * @method     ChildGebruikerQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGebruikerQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGebruikerQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGebruikerQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildGebruikerQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildGebruikerQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildGebruikerQuery leftJoinPersoon($relationAlias = null) Adds a LEFT JOIN clause to the query using the Persoon relation
 * @method     ChildGebruikerQuery rightJoinPersoon($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Persoon relation
 * @method     ChildGebruikerQuery innerJoinPersoon($relationAlias = null) Adds a INNER JOIN clause to the query using the Persoon relation
 *
 * @method     ChildGebruikerQuery joinWithPersoon($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Persoon relation
 *
 * @method     ChildGebruikerQuery leftJoinWithPersoon() Adds a LEFT JOIN clause and with to the query using the Persoon relation
 * @method     ChildGebruikerQuery rightJoinWithPersoon() Adds a RIGHT JOIN clause and with to the query using the Persoon relation
 * @method     ChildGebruikerQuery innerJoinWithPersoon() Adds a INNER JOIN clause and with to the query using the Persoon relation
 *
 * @method     ChildGebruikerQuery leftJoinKeuzes($relationAlias = null) Adds a LEFT JOIN clause to the query using the Keuzes relation
 * @method     ChildGebruikerQuery rightJoinKeuzes($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Keuzes relation
 * @method     ChildGebruikerQuery innerJoinKeuzes($relationAlias = null) Adds a INNER JOIN clause to the query using the Keuzes relation
 *
 * @method     ChildGebruikerQuery joinWithKeuzes($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Keuzes relation
 *
 * @method     ChildGebruikerQuery leftJoinWithKeuzes() Adds a LEFT JOIN clause and with to the query using the Keuzes relation
 * @method     ChildGebruikerQuery rightJoinWithKeuzes() Adds a RIGHT JOIN clause and with to the query using the Keuzes relation
 * @method     ChildGebruikerQuery innerJoinWithKeuzes() Adds a INNER JOIN clause and with to the query using the Keuzes relation
 *
 * @method     ChildGebruikerQuery leftJoinWachtwoordReset($relationAlias = null) Adds a LEFT JOIN clause to the query using the WachtwoordReset relation
 * @method     ChildGebruikerQuery rightJoinWachtwoordReset($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WachtwoordReset relation
 * @method     ChildGebruikerQuery innerJoinWachtwoordReset($relationAlias = null) Adds a INNER JOIN clause to the query using the WachtwoordReset relation
 *
 * @method     ChildGebruikerQuery joinWithWachtwoordReset($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the WachtwoordReset relation
 *
 * @method     ChildGebruikerQuery leftJoinWithWachtwoordReset() Adds a LEFT JOIN clause and with to the query using the WachtwoordReset relation
 * @method     ChildGebruikerQuery rightJoinWithWachtwoordReset() Adds a RIGHT JOIN clause and with to the query using the WachtwoordReset relation
 * @method     ChildGebruikerQuery innerJoinWithWachtwoordReset() Adds a INNER JOIN clause and with to the query using the WachtwoordReset relation
 *
 * @method     \fb_model\fb_model\PersoonQuery|\fb_model\fb_model\KeuzesQuery|\fb_model\fb_model\WachtwoordResetQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildGebruiker findOne(ConnectionInterface $con = null) Return the first ChildGebruiker matching the query
 * @method     ChildGebruiker findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGebruiker matching the query, or a new ChildGebruiker object populated from the query conditions when no match is found
 *
 * @method     ChildGebruiker findOneById(int $id) Return the first ChildGebruiker filtered by the id column
 * @method     ChildGebruiker findOneByUserId(string $userid) Return the first ChildGebruiker filtered by the userid column
 * @method     ChildGebruiker findOneByPersoonId(int $persoon_id) Return the first ChildGebruiker filtered by the persoon_id column
 * @method     ChildGebruiker findOneByRol(int $rol) Return the first ChildGebruiker filtered by the rol column
 * @method     ChildGebruiker findOneByIsActief(int $actief) Return the first ChildGebruiker filtered by the actief column
 * @method     ChildGebruiker findOneByWachtwoord(string $wachtwoord) Return the first ChildGebruiker filtered by the wachtwoord column
 * @method     ChildGebruiker findOneByDatumWachtwoordWijzig(string $wachtwoord_wijzig_datum) Return the first ChildGebruiker filtered by the wachtwoord_wijzig_datum column
 * @method     ChildGebruiker findOneByDatumLaatsteLogin(string $laatste_login_datum) Return the first ChildGebruiker filtered by the laatste_login_datum column
 * @method     ChildGebruiker findOneByLaatsteLoginAdres(string $laatste_login_adres) Return the first ChildGebruiker filtered by the laatste_login_adres column
 * @method     ChildGebruiker findOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildGebruiker filtered by the gemaakt_datum column
 * @method     ChildGebruiker findOneByGemaaktDoor(string $gemaakt_door) Return the first ChildGebruiker filtered by the gemaakt_door column
 * @method     ChildGebruiker findOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildGebruiker filtered by the gewijzigd_datum column
 * @method     ChildGebruiker findOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildGebruiker filtered by the gewijzigd_door column *

 * @method     ChildGebruiker requirePk($key, ConnectionInterface $con = null) Return the ChildGebruiker by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGebruiker requireOne(ConnectionInterface $con = null) Return the first ChildGebruiker matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGebruiker requireOneById(int $id) Return the first ChildGebruiker filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGebruiker requireOneByUserId(string $userid) Return the first ChildGebruiker filtered by the userid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGebruiker requireOneByPersoonId(int $persoon_id) Return the first ChildGebruiker filtered by the persoon_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGebruiker requireOneByRol(int $rol) Return the first ChildGebruiker filtered by the rol column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGebruiker requireOneByIsActief(int $actief) Return the first ChildGebruiker filtered by the actief column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGebruiker requireOneByWachtwoord(string $wachtwoord) Return the first ChildGebruiker filtered by the wachtwoord column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGebruiker requireOneByDatumWachtwoordWijzig(string $wachtwoord_wijzig_datum) Return the first ChildGebruiker filtered by the wachtwoord_wijzig_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGebruiker requireOneByDatumLaatsteLogin(string $laatste_login_datum) Return the first ChildGebruiker filtered by the laatste_login_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGebruiker requireOneByLaatsteLoginAdres(string $laatste_login_adres) Return the first ChildGebruiker filtered by the laatste_login_adres column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGebruiker requireOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildGebruiker filtered by the gemaakt_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGebruiker requireOneByGemaaktDoor(string $gemaakt_door) Return the first ChildGebruiker filtered by the gemaakt_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGebruiker requireOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildGebruiker filtered by the gewijzigd_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGebruiker requireOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildGebruiker filtered by the gewijzigd_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGebruiker[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGebruiker objects based on current ModelCriteria
 * @method     ChildGebruiker[]|ObjectCollection findById(int $id) Return ChildGebruiker objects filtered by the id column
 * @method     ChildGebruiker[]|ObjectCollection findByUserId(string $userid) Return ChildGebruiker objects filtered by the userid column
 * @method     ChildGebruiker[]|ObjectCollection findByPersoonId(int $persoon_id) Return ChildGebruiker objects filtered by the persoon_id column
 * @method     ChildGebruiker[]|ObjectCollection findByRol(int $rol) Return ChildGebruiker objects filtered by the rol column
 * @method     ChildGebruiker[]|ObjectCollection findByIsActief(int $actief) Return ChildGebruiker objects filtered by the actief column
 * @method     ChildGebruiker[]|ObjectCollection findByWachtwoord(string $wachtwoord) Return ChildGebruiker objects filtered by the wachtwoord column
 * @method     ChildGebruiker[]|ObjectCollection findByDatumWachtwoordWijzig(string $wachtwoord_wijzig_datum) Return ChildGebruiker objects filtered by the wachtwoord_wijzig_datum column
 * @method     ChildGebruiker[]|ObjectCollection findByDatumLaatsteLogin(string $laatste_login_datum) Return ChildGebruiker objects filtered by the laatste_login_datum column
 * @method     ChildGebruiker[]|ObjectCollection findByLaatsteLoginAdres(string $laatste_login_adres) Return ChildGebruiker objects filtered by the laatste_login_adres column
 * @method     ChildGebruiker[]|ObjectCollection findByDatumGemaakt(string $gemaakt_datum) Return ChildGebruiker objects filtered by the gemaakt_datum column
 * @method     ChildGebruiker[]|ObjectCollection findByGemaaktDoor(string $gemaakt_door) Return ChildGebruiker objects filtered by the gemaakt_door column
 * @method     ChildGebruiker[]|ObjectCollection findByDatumGewijzigd(string $gewijzigd_datum) Return ChildGebruiker objects filtered by the gewijzigd_datum column
 * @method     ChildGebruiker[]|ObjectCollection findByGewijzigdDoor(string $gewijzigd_door) Return ChildGebruiker objects filtered by the gewijzigd_door column
 * @method     ChildGebruiker[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GebruikerQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \fb_model\fb_model\Base\GebruikerQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\fb_model\\fb_model\\Gebruiker', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGebruikerQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGebruikerQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGebruikerQuery) {
            return $criteria;
        }
        $query = new ChildGebruikerQuery();
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
     * @return ChildGebruiker|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GebruikerTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = GebruikerTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildGebruiker A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, userid, persoon_id, rol, actief, wachtwoord, wachtwoord_wijzig_datum, laatste_login_datum, laatste_login_adres, gemaakt_datum, gemaakt_door, gewijzigd_datum, gewijzigd_door FROM fb_gebruiker WHERE id = :p0';
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
            /** @var ChildGebruiker $obj */
            $obj = new ChildGebruiker();
            $obj->hydrate($row);
            GebruikerTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildGebruiker|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildGebruikerQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GebruikerTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGebruikerQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GebruikerTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildGebruikerQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(GebruikerTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(GebruikerTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GebruikerTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the userid column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId('fooValue');   // WHERE userid = 'fooValue'
     * $query->filterByUserId('%fooValue%', Criteria::LIKE); // WHERE userid LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userId The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGebruikerQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GebruikerTableMap::COL_USERID, $userId, $comparison);
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
     * @return $this|ChildGebruikerQuery The current query, for fluid interface
     */
    public function filterByPersoonId($persoonId = null, $comparison = null)
    {
        if (is_array($persoonId)) {
            $useMinMax = false;
            if (isset($persoonId['min'])) {
                $this->addUsingAlias(GebruikerTableMap::COL_PERSOON_ID, $persoonId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($persoonId['max'])) {
                $this->addUsingAlias(GebruikerTableMap::COL_PERSOON_ID, $persoonId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GebruikerTableMap::COL_PERSOON_ID, $persoonId, $comparison);
    }

    /**
     * Filter the query on the rol column
     *
     * Example usage:
     * <code>
     * $query->filterByRol(1234); // WHERE rol = 1234
     * $query->filterByRol(array(12, 34)); // WHERE rol IN (12, 34)
     * $query->filterByRol(array('min' => 12)); // WHERE rol > 12
     * </code>
     *
     * @see       filterByKeuzes()
     *
     * @param     mixed $rol The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGebruikerQuery The current query, for fluid interface
     */
    public function filterByRol($rol = null, $comparison = null)
    {
        if (is_array($rol)) {
            $useMinMax = false;
            if (isset($rol['min'])) {
                $this->addUsingAlias(GebruikerTableMap::COL_ROL, $rol['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rol['max'])) {
                $this->addUsingAlias(GebruikerTableMap::COL_ROL, $rol['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GebruikerTableMap::COL_ROL, $rol, $comparison);
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
     * @return $this|ChildGebruikerQuery The current query, for fluid interface
     */
    public function filterByIsActief($isActief = null, $comparison = null)
    {
        if (is_array($isActief)) {
            $useMinMax = false;
            if (isset($isActief['min'])) {
                $this->addUsingAlias(GebruikerTableMap::COL_ACTIEF, $isActief['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isActief['max'])) {
                $this->addUsingAlias(GebruikerTableMap::COL_ACTIEF, $isActief['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GebruikerTableMap::COL_ACTIEF, $isActief, $comparison);
    }

    /**
     * Filter the query on the wachtwoord column
     *
     * Example usage:
     * <code>
     * $query->filterByWachtwoord('fooValue');   // WHERE wachtwoord = 'fooValue'
     * $query->filterByWachtwoord('%fooValue%', Criteria::LIKE); // WHERE wachtwoord LIKE '%fooValue%'
     * </code>
     *
     * @param     string $wachtwoord The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGebruikerQuery The current query, for fluid interface
     */
    public function filterByWachtwoord($wachtwoord = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($wachtwoord)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GebruikerTableMap::COL_WACHTWOORD, $wachtwoord, $comparison);
    }

    /**
     * Filter the query on the wachtwoord_wijzig_datum column
     *
     * Example usage:
     * <code>
     * $query->filterByDatumWachtwoordWijzig('2011-03-14'); // WHERE wachtwoord_wijzig_datum = '2011-03-14'
     * $query->filterByDatumWachtwoordWijzig('now'); // WHERE wachtwoord_wijzig_datum = '2011-03-14'
     * $query->filterByDatumWachtwoordWijzig(array('max' => 'yesterday')); // WHERE wachtwoord_wijzig_datum > '2011-03-13'
     * </code>
     *
     * @param     mixed $datumWachtwoordWijzig The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGebruikerQuery The current query, for fluid interface
     */
    public function filterByDatumWachtwoordWijzig($datumWachtwoordWijzig = null, $comparison = null)
    {
        if (is_array($datumWachtwoordWijzig)) {
            $useMinMax = false;
            if (isset($datumWachtwoordWijzig['min'])) {
                $this->addUsingAlias(GebruikerTableMap::COL_WACHTWOORD_WIJZIG_DATUM, $datumWachtwoordWijzig['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumWachtwoordWijzig['max'])) {
                $this->addUsingAlias(GebruikerTableMap::COL_WACHTWOORD_WIJZIG_DATUM, $datumWachtwoordWijzig['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GebruikerTableMap::COL_WACHTWOORD_WIJZIG_DATUM, $datumWachtwoordWijzig, $comparison);
    }

    /**
     * Filter the query on the laatste_login_datum column
     *
     * Example usage:
     * <code>
     * $query->filterByDatumLaatsteLogin('2011-03-14'); // WHERE laatste_login_datum = '2011-03-14'
     * $query->filterByDatumLaatsteLogin('now'); // WHERE laatste_login_datum = '2011-03-14'
     * $query->filterByDatumLaatsteLogin(array('max' => 'yesterday')); // WHERE laatste_login_datum > '2011-03-13'
     * </code>
     *
     * @param     mixed $datumLaatsteLogin The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGebruikerQuery The current query, for fluid interface
     */
    public function filterByDatumLaatsteLogin($datumLaatsteLogin = null, $comparison = null)
    {
        if (is_array($datumLaatsteLogin)) {
            $useMinMax = false;
            if (isset($datumLaatsteLogin['min'])) {
                $this->addUsingAlias(GebruikerTableMap::COL_LAATSTE_LOGIN_DATUM, $datumLaatsteLogin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumLaatsteLogin['max'])) {
                $this->addUsingAlias(GebruikerTableMap::COL_LAATSTE_LOGIN_DATUM, $datumLaatsteLogin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GebruikerTableMap::COL_LAATSTE_LOGIN_DATUM, $datumLaatsteLogin, $comparison);
    }

    /**
     * Filter the query on the laatste_login_adres column
     *
     * Example usage:
     * <code>
     * $query->filterByLaatsteLoginAdres('fooValue');   // WHERE laatste_login_adres = 'fooValue'
     * $query->filterByLaatsteLoginAdres('%fooValue%', Criteria::LIKE); // WHERE laatste_login_adres LIKE '%fooValue%'
     * </code>
     *
     * @param     string $laatsteLoginAdres The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGebruikerQuery The current query, for fluid interface
     */
    public function filterByLaatsteLoginAdres($laatsteLoginAdres = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($laatsteLoginAdres)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GebruikerTableMap::COL_LAATSTE_LOGIN_ADRES, $laatsteLoginAdres, $comparison);
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
     * @return $this|ChildGebruikerQuery The current query, for fluid interface
     */
    public function filterByDatumGemaakt($datumGemaakt = null, $comparison = null)
    {
        if (is_array($datumGemaakt)) {
            $useMinMax = false;
            if (isset($datumGemaakt['min'])) {
                $this->addUsingAlias(GebruikerTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGemaakt['max'])) {
                $this->addUsingAlias(GebruikerTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GebruikerTableMap::COL_GEMAAKT_DATUM, $datumGemaakt, $comparison);
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
     * @return $this|ChildGebruikerQuery The current query, for fluid interface
     */
    public function filterByGemaaktDoor($gemaaktDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gemaaktDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GebruikerTableMap::COL_GEMAAKT_DOOR, $gemaaktDoor, $comparison);
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
     * @return $this|ChildGebruikerQuery The current query, for fluid interface
     */
    public function filterByDatumGewijzigd($datumGewijzigd = null, $comparison = null)
    {
        if (is_array($datumGewijzigd)) {
            $useMinMax = false;
            if (isset($datumGewijzigd['min'])) {
                $this->addUsingAlias(GebruikerTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGewijzigd['max'])) {
                $this->addUsingAlias(GebruikerTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GebruikerTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd, $comparison);
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
     * @return $this|ChildGebruikerQuery The current query, for fluid interface
     */
    public function filterByGewijzigdDoor($gewijzigdDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gewijzigdDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GebruikerTableMap::COL_GEWIJZIGD_DOOR, $gewijzigdDoor, $comparison);
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Persoon object
     *
     * @param \fb_model\fb_model\Persoon|ObjectCollection $persoon The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGebruikerQuery The current query, for fluid interface
     */
    public function filterByPersoon($persoon, $comparison = null)
    {
        if ($persoon instanceof \fb_model\fb_model\Persoon) {
            return $this
                ->addUsingAlias(GebruikerTableMap::COL_PERSOON_ID, $persoon->getId(), $comparison);
        } elseif ($persoon instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GebruikerTableMap::COL_PERSOON_ID, $persoon->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildGebruikerQuery The current query, for fluid interface
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
     * Filter the query by a related \fb_model\fb_model\Keuzes object
     *
     * @param \fb_model\fb_model\Keuzes|ObjectCollection $keuzes The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGebruikerQuery The current query, for fluid interface
     */
    public function filterByKeuzes($keuzes, $comparison = null)
    {
        if ($keuzes instanceof \fb_model\fb_model\Keuzes) {
            return $this
                ->addUsingAlias(GebruikerTableMap::COL_ROL, $keuzes->getId(), $comparison);
        } elseif ($keuzes instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GebruikerTableMap::COL_ROL, $keuzes->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByKeuzes() only accepts arguments of type \fb_model\fb_model\Keuzes or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Keuzes relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGebruikerQuery The current query, for fluid interface
     */
    public function joinKeuzes($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Keuzes');

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
            $this->addJoinObject($join, 'Keuzes');
        }

        return $this;
    }

    /**
     * Use the Keuzes relation Keuzes object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \fb_model\fb_model\KeuzesQuery A secondary query class using the current class as primary query
     */
    public function useKeuzesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinKeuzes($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Keuzes', '\fb_model\fb_model\KeuzesQuery');
    }

    /**
     * Filter the query by a related \fb_model\fb_model\WachtwoordReset object
     *
     * @param \fb_model\fb_model\WachtwoordReset|ObjectCollection $wachtwoordReset the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGebruikerQuery The current query, for fluid interface
     */
    public function filterByWachtwoordReset($wachtwoordReset, $comparison = null)
    {
        if ($wachtwoordReset instanceof \fb_model\fb_model\WachtwoordReset) {
            return $this
                ->addUsingAlias(GebruikerTableMap::COL_USERID, $wachtwoordReset->getEmail(), $comparison);
        } elseif ($wachtwoordReset instanceof ObjectCollection) {
            return $this
                ->useWachtwoordResetQuery()
                ->filterByPrimaryKeys($wachtwoordReset->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByWachtwoordReset() only accepts arguments of type \fb_model\fb_model\WachtwoordReset or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the WachtwoordReset relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGebruikerQuery The current query, for fluid interface
     */
    public function joinWachtwoordReset($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('WachtwoordReset');

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
            $this->addJoinObject($join, 'WachtwoordReset');
        }

        return $this;
    }

    /**
     * Use the WachtwoordReset relation WachtwoordReset object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \fb_model\fb_model\WachtwoordResetQuery A secondary query class using the current class as primary query
     */
    public function useWachtwoordResetQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinWachtwoordReset($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'WachtwoordReset', '\fb_model\fb_model\WachtwoordResetQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildGebruiker $gebruiker Object to remove from the list of results
     *
     * @return $this|ChildGebruikerQuery The current query, for fluid interface
     */
    public function prune($gebruiker = null)
    {
        if ($gebruiker) {
            $this->addUsingAlias(GebruikerTableMap::COL_ID, $gebruiker->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fb_gebruiker table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GebruikerTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GebruikerTableMap::clearInstancePool();
            GebruikerTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(GebruikerTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GebruikerTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            GebruikerTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            GebruikerTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildGebruikerQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(GebruikerTableMap::COL_GEWIJZIGD_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildGebruikerQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(GebruikerTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildGebruikerQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(GebruikerTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildGebruikerQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(GebruikerTableMap::COL_GEMAAKT_DATUM);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildGebruikerQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(GebruikerTableMap::COL_GEMAAKT_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildGebruikerQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(GebruikerTableMap::COL_GEMAAKT_DATUM);
    }

} // GebruikerQuery
