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
use fb_model\fb_model\Voucher as ChildVoucher;
use fb_model\fb_model\VoucherQuery as ChildVoucherQuery;
use fb_model\fb_model\Map\VoucherTableMap;

/**
 * Base class that represents a query for the 'fb_voucher' table.
 *
 *
 *
 * @method     ChildVoucherQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildVoucherQuery orderByCode($order = Criteria::ASC) Order by the code column
 * @method     ChildVoucherQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildVoucherQuery orderByEvenementId($order = Criteria::ASC) Order by the evenement_id column
 * @method     ChildVoucherQuery orderByOorspronkelijkeWaarde($order = Criteria::ASC) Order by the oorsprongwaarde column
 * @method     ChildVoucherQuery orderByRestWaarde($order = Criteria::ASC) Order by the restwaarde column
 * @method     ChildVoucherQuery orderByVerbruikt($order = Criteria::ASC) Order by the verbruikt column
 * @method     ChildVoucherQuery orderByVoucherType($order = Criteria::ASC) Order by the vouchertype column
 * @method     ChildVoucherQuery orderByIsActief($order = Criteria::ASC) Order by the actief column
 * @method     ChildVoucherQuery orderByGeldigTot($order = Criteria::ASC) Order by the geldig_tot column
 * @method     ChildVoucherQuery orderByDatumGemaakt($order = Criteria::ASC) Order by the gemaakt_datum column
 * @method     ChildVoucherQuery orderByGemaaktDoor($order = Criteria::ASC) Order by the gemaakt_door column
 * @method     ChildVoucherQuery orderByDatumGewijzigd($order = Criteria::ASC) Order by the gewijzigd_datum column
 * @method     ChildVoucherQuery orderByGewijzigdDoor($order = Criteria::ASC) Order by the gewijzigd_door column
 *
 * @method     ChildVoucherQuery groupById() Group by the id column
 * @method     ChildVoucherQuery groupByCode() Group by the code column
 * @method     ChildVoucherQuery groupByEmail() Group by the email column
 * @method     ChildVoucherQuery groupByEvenementId() Group by the evenement_id column
 * @method     ChildVoucherQuery groupByOorspronkelijkeWaarde() Group by the oorsprongwaarde column
 * @method     ChildVoucherQuery groupByRestWaarde() Group by the restwaarde column
 * @method     ChildVoucherQuery groupByVerbruikt() Group by the verbruikt column
 * @method     ChildVoucherQuery groupByVoucherType() Group by the vouchertype column
 * @method     ChildVoucherQuery groupByIsActief() Group by the actief column
 * @method     ChildVoucherQuery groupByGeldigTot() Group by the geldig_tot column
 * @method     ChildVoucherQuery groupByDatumGemaakt() Group by the gemaakt_datum column
 * @method     ChildVoucherQuery groupByGemaaktDoor() Group by the gemaakt_door column
 * @method     ChildVoucherQuery groupByDatumGewijzigd() Group by the gewijzigd_datum column
 * @method     ChildVoucherQuery groupByGewijzigdDoor() Group by the gewijzigd_door column
 *
 * @method     ChildVoucherQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildVoucherQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildVoucherQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildVoucherQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildVoucherQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildVoucherQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildVoucherQuery leftJoinEvenement($relationAlias = null) Adds a LEFT JOIN clause to the query using the Evenement relation
 * @method     ChildVoucherQuery rightJoinEvenement($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Evenement relation
 * @method     ChildVoucherQuery innerJoinEvenement($relationAlias = null) Adds a INNER JOIN clause to the query using the Evenement relation
 *
 * @method     ChildVoucherQuery joinWithEvenement($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Evenement relation
 *
 * @method     ChildVoucherQuery leftJoinWithEvenement() Adds a LEFT JOIN clause and with to the query using the Evenement relation
 * @method     ChildVoucherQuery rightJoinWithEvenement() Adds a RIGHT JOIN clause and with to the query using the Evenement relation
 * @method     ChildVoucherQuery innerJoinWithEvenement() Adds a INNER JOIN clause and with to the query using the Evenement relation
 *
 * @method     ChildVoucherQuery leftJoinInschrijving($relationAlias = null) Adds a LEFT JOIN clause to the query using the Inschrijving relation
 * @method     ChildVoucherQuery rightJoinInschrijving($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Inschrijving relation
 * @method     ChildVoucherQuery innerJoinInschrijving($relationAlias = null) Adds a INNER JOIN clause to the query using the Inschrijving relation
 *
 * @method     ChildVoucherQuery joinWithInschrijving($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Inschrijving relation
 *
 * @method     ChildVoucherQuery leftJoinWithInschrijving() Adds a LEFT JOIN clause and with to the query using the Inschrijving relation
 * @method     ChildVoucherQuery rightJoinWithInschrijving() Adds a RIGHT JOIN clause and with to the query using the Inschrijving relation
 * @method     ChildVoucherQuery innerJoinWithInschrijving() Adds a INNER JOIN clause and with to the query using the Inschrijving relation
 *
 * @method     \fb_model\fb_model\EvenementQuery|\fb_model\fb_model\InschrijvingQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildVoucher findOne(ConnectionInterface $con = null) Return the first ChildVoucher matching the query
 * @method     ChildVoucher findOneOrCreate(ConnectionInterface $con = null) Return the first ChildVoucher matching the query, or a new ChildVoucher object populated from the query conditions when no match is found
 *
 * @method     ChildVoucher findOneById(int $id) Return the first ChildVoucher filtered by the id column
 * @method     ChildVoucher findOneByCode(string $code) Return the first ChildVoucher filtered by the code column
 * @method     ChildVoucher findOneByEmail(string $email) Return the first ChildVoucher filtered by the email column
 * @method     ChildVoucher findOneByEvenementId(int $evenement_id) Return the first ChildVoucher filtered by the evenement_id column
 * @method     ChildVoucher findOneByOorspronkelijkeWaarde(string $oorsprongwaarde) Return the first ChildVoucher filtered by the oorsprongwaarde column
 * @method     ChildVoucher findOneByRestWaarde(string $restwaarde) Return the first ChildVoucher filtered by the restwaarde column
 * @method     ChildVoucher findOneByVerbruikt(string $verbruikt) Return the first ChildVoucher filtered by the verbruikt column
 * @method     ChildVoucher findOneByVoucherType(int $vouchertype) Return the first ChildVoucher filtered by the vouchertype column
 * @method     ChildVoucher findOneByIsActief(int $actief) Return the first ChildVoucher filtered by the actief column
 * @method     ChildVoucher findOneByGeldigTot(string $geldig_tot) Return the first ChildVoucher filtered by the geldig_tot column
 * @method     ChildVoucher findOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildVoucher filtered by the gemaakt_datum column
 * @method     ChildVoucher findOneByGemaaktDoor(string $gemaakt_door) Return the first ChildVoucher filtered by the gemaakt_door column
 * @method     ChildVoucher findOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildVoucher filtered by the gewijzigd_datum column
 * @method     ChildVoucher findOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildVoucher filtered by the gewijzigd_door column *

 * @method     ChildVoucher requirePk($key, ConnectionInterface $con = null) Return the ChildVoucher by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoucher requireOne(ConnectionInterface $con = null) Return the first ChildVoucher matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVoucher requireOneById(int $id) Return the first ChildVoucher filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoucher requireOneByCode(string $code) Return the first ChildVoucher filtered by the code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoucher requireOneByEmail(string $email) Return the first ChildVoucher filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoucher requireOneByEvenementId(int $evenement_id) Return the first ChildVoucher filtered by the evenement_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoucher requireOneByOorspronkelijkeWaarde(string $oorsprongwaarde) Return the first ChildVoucher filtered by the oorsprongwaarde column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoucher requireOneByRestWaarde(string $restwaarde) Return the first ChildVoucher filtered by the restwaarde column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoucher requireOneByVerbruikt(string $verbruikt) Return the first ChildVoucher filtered by the verbruikt column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoucher requireOneByVoucherType(int $vouchertype) Return the first ChildVoucher filtered by the vouchertype column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoucher requireOneByIsActief(int $actief) Return the first ChildVoucher filtered by the actief column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoucher requireOneByGeldigTot(string $geldig_tot) Return the first ChildVoucher filtered by the geldig_tot column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoucher requireOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildVoucher filtered by the gemaakt_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoucher requireOneByGemaaktDoor(string $gemaakt_door) Return the first ChildVoucher filtered by the gemaakt_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoucher requireOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildVoucher filtered by the gewijzigd_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoucher requireOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildVoucher filtered by the gewijzigd_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVoucher[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildVoucher objects based on current ModelCriteria
 * @method     ChildVoucher[]|ObjectCollection findById(int $id) Return ChildVoucher objects filtered by the id column
 * @method     ChildVoucher[]|ObjectCollection findByCode(string $code) Return ChildVoucher objects filtered by the code column
 * @method     ChildVoucher[]|ObjectCollection findByEmail(string $email) Return ChildVoucher objects filtered by the email column
 * @method     ChildVoucher[]|ObjectCollection findByEvenementId(int $evenement_id) Return ChildVoucher objects filtered by the evenement_id column
 * @method     ChildVoucher[]|ObjectCollection findByOorspronkelijkeWaarde(string $oorsprongwaarde) Return ChildVoucher objects filtered by the oorsprongwaarde column
 * @method     ChildVoucher[]|ObjectCollection findByRestWaarde(string $restwaarde) Return ChildVoucher objects filtered by the restwaarde column
 * @method     ChildVoucher[]|ObjectCollection findByVerbruikt(string $verbruikt) Return ChildVoucher objects filtered by the verbruikt column
 * @method     ChildVoucher[]|ObjectCollection findByVoucherType(int $vouchertype) Return ChildVoucher objects filtered by the vouchertype column
 * @method     ChildVoucher[]|ObjectCollection findByIsActief(int $actief) Return ChildVoucher objects filtered by the actief column
 * @method     ChildVoucher[]|ObjectCollection findByGeldigTot(string $geldig_tot) Return ChildVoucher objects filtered by the geldig_tot column
 * @method     ChildVoucher[]|ObjectCollection findByDatumGemaakt(string $gemaakt_datum) Return ChildVoucher objects filtered by the gemaakt_datum column
 * @method     ChildVoucher[]|ObjectCollection findByGemaaktDoor(string $gemaakt_door) Return ChildVoucher objects filtered by the gemaakt_door column
 * @method     ChildVoucher[]|ObjectCollection findByDatumGewijzigd(string $gewijzigd_datum) Return ChildVoucher objects filtered by the gewijzigd_datum column
 * @method     ChildVoucher[]|ObjectCollection findByGewijzigdDoor(string $gewijzigd_door) Return ChildVoucher objects filtered by the gewijzigd_door column
 * @method     ChildVoucher[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class VoucherQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \fb_model\fb_model\Base\VoucherQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\fb_model\\fb_model\\Voucher', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildVoucherQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildVoucherQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildVoucherQuery) {
            return $criteria;
        }
        $query = new ChildVoucherQuery();
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
     * @return ChildVoucher|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(VoucherTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = VoucherTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildVoucher A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, code, email, evenement_id, oorsprongwaarde, restwaarde, verbruikt, vouchertype, actief, geldig_tot, gemaakt_datum, gemaakt_door, gewijzigd_datum, gewijzigd_door FROM fb_voucher WHERE id = :p0';
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
            /** @var ChildVoucher $obj */
            $obj = new ChildVoucher();
            $obj->hydrate($row);
            VoucherTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildVoucher|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(VoucherTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(VoucherTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(VoucherTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(VoucherTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoucherTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the code column
     *
     * Example usage:
     * <code>
     * $query->filterByCode('fooValue');   // WHERE code = 'fooValue'
     * $query->filterByCode('%fooValue%', Criteria::LIKE); // WHERE code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $code The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByCode($code = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($code)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoucherTableMap::COL_CODE, $code, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%', Criteria::LIKE); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoucherTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the evenement_id column
     *
     * Example usage:
     * <code>
     * $query->filterByEvenementId(1234); // WHERE evenement_id = 1234
     * $query->filterByEvenementId(array(12, 34)); // WHERE evenement_id IN (12, 34)
     * $query->filterByEvenementId(array('min' => 12)); // WHERE evenement_id > 12
     * </code>
     *
     * @see       filterByEvenement()
     *
     * @param     mixed $evenementId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByEvenementId($evenementId = null, $comparison = null)
    {
        if (is_array($evenementId)) {
            $useMinMax = false;
            if (isset($evenementId['min'])) {
                $this->addUsingAlias(VoucherTableMap::COL_EVENEMENT_ID, $evenementId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($evenementId['max'])) {
                $this->addUsingAlias(VoucherTableMap::COL_EVENEMENT_ID, $evenementId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoucherTableMap::COL_EVENEMENT_ID, $evenementId, $comparison);
    }

    /**
     * Filter the query on the oorsprongwaarde column
     *
     * Example usage:
     * <code>
     * $query->filterByOorspronkelijkeWaarde(1234); // WHERE oorsprongwaarde = 1234
     * $query->filterByOorspronkelijkeWaarde(array(12, 34)); // WHERE oorsprongwaarde IN (12, 34)
     * $query->filterByOorspronkelijkeWaarde(array('min' => 12)); // WHERE oorsprongwaarde > 12
     * </code>
     *
     * @param     mixed $oorspronkelijkeWaarde The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByOorspronkelijkeWaarde($oorspronkelijkeWaarde = null, $comparison = null)
    {
        if (is_array($oorspronkelijkeWaarde)) {
            $useMinMax = false;
            if (isset($oorspronkelijkeWaarde['min'])) {
                $this->addUsingAlias(VoucherTableMap::COL_OORSPRONGWAARDE, $oorspronkelijkeWaarde['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($oorspronkelijkeWaarde['max'])) {
                $this->addUsingAlias(VoucherTableMap::COL_OORSPRONGWAARDE, $oorspronkelijkeWaarde['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoucherTableMap::COL_OORSPRONGWAARDE, $oorspronkelijkeWaarde, $comparison);
    }

    /**
     * Filter the query on the restwaarde column
     *
     * Example usage:
     * <code>
     * $query->filterByRestWaarde(1234); // WHERE restwaarde = 1234
     * $query->filterByRestWaarde(array(12, 34)); // WHERE restwaarde IN (12, 34)
     * $query->filterByRestWaarde(array('min' => 12)); // WHERE restwaarde > 12
     * </code>
     *
     * @param     mixed $restWaarde The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByRestWaarde($restWaarde = null, $comparison = null)
    {
        if (is_array($restWaarde)) {
            $useMinMax = false;
            if (isset($restWaarde['min'])) {
                $this->addUsingAlias(VoucherTableMap::COL_RESTWAARDE, $restWaarde['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($restWaarde['max'])) {
                $this->addUsingAlias(VoucherTableMap::COL_RESTWAARDE, $restWaarde['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoucherTableMap::COL_RESTWAARDE, $restWaarde, $comparison);
    }

    /**
     * Filter the query on the verbruikt column
     *
     * Example usage:
     * <code>
     * $query->filterByVerbruikt(1234); // WHERE verbruikt = 1234
     * $query->filterByVerbruikt(array(12, 34)); // WHERE verbruikt IN (12, 34)
     * $query->filterByVerbruikt(array('min' => 12)); // WHERE verbruikt > 12
     * </code>
     *
     * @param     mixed $verbruikt The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByVerbruikt($verbruikt = null, $comparison = null)
    {
        if (is_array($verbruikt)) {
            $useMinMax = false;
            if (isset($verbruikt['min'])) {
                $this->addUsingAlias(VoucherTableMap::COL_VERBRUIKT, $verbruikt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($verbruikt['max'])) {
                $this->addUsingAlias(VoucherTableMap::COL_VERBRUIKT, $verbruikt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoucherTableMap::COL_VERBRUIKT, $verbruikt, $comparison);
    }

    /**
     * Filter the query on the vouchertype column
     *
     * Example usage:
     * <code>
     * $query->filterByVoucherType(1234); // WHERE vouchertype = 1234
     * $query->filterByVoucherType(array(12, 34)); // WHERE vouchertype IN (12, 34)
     * $query->filterByVoucherType(array('min' => 12)); // WHERE vouchertype > 12
     * </code>
     *
     * @param     mixed $voucherType The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByVoucherType($voucherType = null, $comparison = null)
    {
        if (is_array($voucherType)) {
            $useMinMax = false;
            if (isset($voucherType['min'])) {
                $this->addUsingAlias(VoucherTableMap::COL_VOUCHERTYPE, $voucherType['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($voucherType['max'])) {
                $this->addUsingAlias(VoucherTableMap::COL_VOUCHERTYPE, $voucherType['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoucherTableMap::COL_VOUCHERTYPE, $voucherType, $comparison);
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
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByIsActief($isActief = null, $comparison = null)
    {
        if (is_array($isActief)) {
            $useMinMax = false;
            if (isset($isActief['min'])) {
                $this->addUsingAlias(VoucherTableMap::COL_ACTIEF, $isActief['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isActief['max'])) {
                $this->addUsingAlias(VoucherTableMap::COL_ACTIEF, $isActief['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoucherTableMap::COL_ACTIEF, $isActief, $comparison);
    }

    /**
     * Filter the query on the geldig_tot column
     *
     * Example usage:
     * <code>
     * $query->filterByGeldigTot('2011-03-14'); // WHERE geldig_tot = '2011-03-14'
     * $query->filterByGeldigTot('now'); // WHERE geldig_tot = '2011-03-14'
     * $query->filterByGeldigTot(array('max' => 'yesterday')); // WHERE geldig_tot > '2011-03-13'
     * </code>
     *
     * @param     mixed $geldigTot The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByGeldigTot($geldigTot = null, $comparison = null)
    {
        if (is_array($geldigTot)) {
            $useMinMax = false;
            if (isset($geldigTot['min'])) {
                $this->addUsingAlias(VoucherTableMap::COL_GELDIG_TOT, $geldigTot['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($geldigTot['max'])) {
                $this->addUsingAlias(VoucherTableMap::COL_GELDIG_TOT, $geldigTot['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoucherTableMap::COL_GELDIG_TOT, $geldigTot, $comparison);
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
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByDatumGemaakt($datumGemaakt = null, $comparison = null)
    {
        if (is_array($datumGemaakt)) {
            $useMinMax = false;
            if (isset($datumGemaakt['min'])) {
                $this->addUsingAlias(VoucherTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGemaakt['max'])) {
                $this->addUsingAlias(VoucherTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoucherTableMap::COL_GEMAAKT_DATUM, $datumGemaakt, $comparison);
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
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByGemaaktDoor($gemaaktDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gemaaktDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoucherTableMap::COL_GEMAAKT_DOOR, $gemaaktDoor, $comparison);
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
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByDatumGewijzigd($datumGewijzigd = null, $comparison = null)
    {
        if (is_array($datumGewijzigd)) {
            $useMinMax = false;
            if (isset($datumGewijzigd['min'])) {
                $this->addUsingAlias(VoucherTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGewijzigd['max'])) {
                $this->addUsingAlias(VoucherTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoucherTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd, $comparison);
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
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByGewijzigdDoor($gewijzigdDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gewijzigdDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoucherTableMap::COL_GEWIJZIGD_DOOR, $gewijzigdDoor, $comparison);
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Evenement object
     *
     * @param \fb_model\fb_model\Evenement|ObjectCollection $evenement The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByEvenement($evenement, $comparison = null)
    {
        if ($evenement instanceof \fb_model\fb_model\Evenement) {
            return $this
                ->addUsingAlias(VoucherTableMap::COL_EVENEMENT_ID, $evenement->getId(), $comparison);
        } elseif ($evenement instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(VoucherTableMap::COL_EVENEMENT_ID, $evenement->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function joinEvenement($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useEvenementQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinEvenement($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Evenement', '\fb_model\fb_model\EvenementQuery');
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Inschrijving object
     *
     * @param \fb_model\fb_model\Inschrijving|ObjectCollection $inschrijving the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildVoucherQuery The current query, for fluid interface
     */
    public function filterByInschrijving($inschrijving, $comparison = null)
    {
        if ($inschrijving instanceof \fb_model\fb_model\Inschrijving) {
            return $this
                ->addUsingAlias(VoucherTableMap::COL_ID, $inschrijving->getVoucherId(), $comparison);
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
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function joinInschrijving($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useInschrijvingQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinInschrijving($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Inschrijving', '\fb_model\fb_model\InschrijvingQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildVoucher $voucher Object to remove from the list of results
     *
     * @return $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function prune($voucher = null)
    {
        if ($voucher) {
            $this->addUsingAlias(VoucherTableMap::COL_ID, $voucher->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fb_voucher table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VoucherTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            VoucherTableMap::clearInstancePool();
            VoucherTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(VoucherTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(VoucherTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            VoucherTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            VoucherTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(VoucherTableMap::COL_GEWIJZIGD_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(VoucherTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(VoucherTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(VoucherTableMap::COL_GEMAAKT_DATUM);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(VoucherTableMap::COL_GEMAAKT_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildVoucherQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(VoucherTableMap::COL_GEMAAKT_DATUM);
    }

} // VoucherQuery
