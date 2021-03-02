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
use fb_model\fb_model\Persoon as ChildPersoon;
use fb_model\fb_model\PersoonQuery as ChildPersoonQuery;
use fb_model\fb_model\Map\PersoonTableMap;

/**
 * Base class that represents a query for the 'fb_persoon' table.
 *
 *
 *
 * @method     ChildPersoonQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPersoonQuery orderByVoornaam($order = Criteria::ASC) Order by the voornaam column
 * @method     ChildPersoonQuery orderByTussenvoegsel($order = Criteria::ASC) Order by the tussenvoegsel column
 * @method     ChildPersoonQuery orderByAchternaam($order = Criteria::ASC) Order by the achternaam column
 * @method     ChildPersoonQuery orderByGeboorteDatum($order = Criteria::ASC) Order by the geboortedatum column
 * @method     ChildPersoonQuery orderByGeslacht($order = Criteria::ASC) Order by the geslacht column
 * @method     ChildPersoonQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildPersoonQuery orderByBanknummer($order = Criteria::ASC) Order by the banknummer column
 * @method     ChildPersoonQuery orderByTelefoonnummer($order = Criteria::ASC) Order by the telefoonnummer column
 * @method     ChildPersoonQuery orderByStraat($order = Criteria::ASC) Order by the straat column
 * @method     ChildPersoonQuery orderByHuisnummer($order = Criteria::ASC) Order by the huisnummer column
 * @method     ChildPersoonQuery orderByToevoeging($order = Criteria::ASC) Order by the toevoeging column
 * @method     ChildPersoonQuery orderByPostcode($order = Criteria::ASC) Order by the postcode column
 * @method     ChildPersoonQuery orderByWoonplaats($order = Criteria::ASC) Order by the woonplaats column
 * @method     ChildPersoonQuery orderByLandnaam($order = Criteria::ASC) Order by the landnaam column
 * @method     ChildPersoonQuery orderByDatumGemaakt($order = Criteria::ASC) Order by the gemaakt_datum column
 * @method     ChildPersoonQuery orderByGemaaktDoor($order = Criteria::ASC) Order by the gemaakt_door column
 * @method     ChildPersoonQuery orderByDatumGewijzigd($order = Criteria::ASC) Order by the gewijzigd_datum column
 * @method     ChildPersoonQuery orderByGewijzigdDoor($order = Criteria::ASC) Order by the gewijzigd_door column
 *
 * @method     ChildPersoonQuery groupById() Group by the id column
 * @method     ChildPersoonQuery groupByVoornaam() Group by the voornaam column
 * @method     ChildPersoonQuery groupByTussenvoegsel() Group by the tussenvoegsel column
 * @method     ChildPersoonQuery groupByAchternaam() Group by the achternaam column
 * @method     ChildPersoonQuery groupByGeboorteDatum() Group by the geboortedatum column
 * @method     ChildPersoonQuery groupByGeslacht() Group by the geslacht column
 * @method     ChildPersoonQuery groupByEmail() Group by the email column
 * @method     ChildPersoonQuery groupByBanknummer() Group by the banknummer column
 * @method     ChildPersoonQuery groupByTelefoonnummer() Group by the telefoonnummer column
 * @method     ChildPersoonQuery groupByStraat() Group by the straat column
 * @method     ChildPersoonQuery groupByHuisnummer() Group by the huisnummer column
 * @method     ChildPersoonQuery groupByToevoeging() Group by the toevoeging column
 * @method     ChildPersoonQuery groupByPostcode() Group by the postcode column
 * @method     ChildPersoonQuery groupByWoonplaats() Group by the woonplaats column
 * @method     ChildPersoonQuery groupByLandnaam() Group by the landnaam column
 * @method     ChildPersoonQuery groupByDatumGemaakt() Group by the gemaakt_datum column
 * @method     ChildPersoonQuery groupByGemaaktDoor() Group by the gemaakt_door column
 * @method     ChildPersoonQuery groupByDatumGewijzigd() Group by the gewijzigd_datum column
 * @method     ChildPersoonQuery groupByGewijzigdDoor() Group by the gewijzigd_door column
 *
 * @method     ChildPersoonQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPersoonQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPersoonQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPersoonQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPersoonQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPersoonQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPersoonQuery leftJoinContactlog($relationAlias = null) Adds a LEFT JOIN clause to the query using the Contactlog relation
 * @method     ChildPersoonQuery rightJoinContactlog($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Contactlog relation
 * @method     ChildPersoonQuery innerJoinContactlog($relationAlias = null) Adds a INNER JOIN clause to the query using the Contactlog relation
 *
 * @method     ChildPersoonQuery joinWithContactlog($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Contactlog relation
 *
 * @method     ChildPersoonQuery leftJoinWithContactlog() Adds a LEFT JOIN clause and with to the query using the Contactlog relation
 * @method     ChildPersoonQuery rightJoinWithContactlog() Adds a RIGHT JOIN clause and with to the query using the Contactlog relation
 * @method     ChildPersoonQuery innerJoinWithContactlog() Adds a INNER JOIN clause and with to the query using the Contactlog relation
 *
 * @method     ChildPersoonQuery leftJoinDeelnemer($relationAlias = null) Adds a LEFT JOIN clause to the query using the Deelnemer relation
 * @method     ChildPersoonQuery rightJoinDeelnemer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Deelnemer relation
 * @method     ChildPersoonQuery innerJoinDeelnemer($relationAlias = null) Adds a INNER JOIN clause to the query using the Deelnemer relation
 *
 * @method     ChildPersoonQuery joinWithDeelnemer($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Deelnemer relation
 *
 * @method     ChildPersoonQuery leftJoinWithDeelnemer() Adds a LEFT JOIN clause and with to the query using the Deelnemer relation
 * @method     ChildPersoonQuery rightJoinWithDeelnemer() Adds a RIGHT JOIN clause and with to the query using the Deelnemer relation
 * @method     ChildPersoonQuery innerJoinWithDeelnemer() Adds a INNER JOIN clause and with to the query using the Deelnemer relation
 *
 * @method     ChildPersoonQuery leftJoinGebruiker($relationAlias = null) Adds a LEFT JOIN clause to the query using the Gebruiker relation
 * @method     ChildPersoonQuery rightJoinGebruiker($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Gebruiker relation
 * @method     ChildPersoonQuery innerJoinGebruiker($relationAlias = null) Adds a INNER JOIN clause to the query using the Gebruiker relation
 *
 * @method     ChildPersoonQuery joinWithGebruiker($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Gebruiker relation
 *
 * @method     ChildPersoonQuery leftJoinWithGebruiker() Adds a LEFT JOIN clause and with to the query using the Gebruiker relation
 * @method     ChildPersoonQuery rightJoinWithGebruiker() Adds a RIGHT JOIN clause and with to the query using the Gebruiker relation
 * @method     ChildPersoonQuery innerJoinWithGebruiker() Adds a INNER JOIN clause and with to the query using the Gebruiker relation
 *
 * @method     ChildPersoonQuery leftJoinInschrijving($relationAlias = null) Adds a LEFT JOIN clause to the query using the Inschrijving relation
 * @method     ChildPersoonQuery rightJoinInschrijving($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Inschrijving relation
 * @method     ChildPersoonQuery innerJoinInschrijving($relationAlias = null) Adds a INNER JOIN clause to the query using the Inschrijving relation
 *
 * @method     ChildPersoonQuery joinWithInschrijving($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Inschrijving relation
 *
 * @method     ChildPersoonQuery leftJoinWithInschrijving() Adds a LEFT JOIN clause and with to the query using the Inschrijving relation
 * @method     ChildPersoonQuery rightJoinWithInschrijving() Adds a RIGHT JOIN clause and with to the query using the Inschrijving relation
 * @method     ChildPersoonQuery innerJoinWithInschrijving() Adds a INNER JOIN clause and with to the query using the Inschrijving relation
 *
 * @method     \fb_model\fb_model\ContactlogQuery|\fb_model\fb_model\DeelnemerQuery|\fb_model\fb_model\GebruikerQuery|\fb_model\fb_model\InschrijvingQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPersoon findOne(ConnectionInterface $con = null) Return the first ChildPersoon matching the query
 * @method     ChildPersoon findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPersoon matching the query, or a new ChildPersoon object populated from the query conditions when no match is found
 *
 * @method     ChildPersoon findOneById(int $id) Return the first ChildPersoon filtered by the id column
 * @method     ChildPersoon findOneByVoornaam(string $voornaam) Return the first ChildPersoon filtered by the voornaam column
 * @method     ChildPersoon findOneByTussenvoegsel(string $tussenvoegsel) Return the first ChildPersoon filtered by the tussenvoegsel column
 * @method     ChildPersoon findOneByAchternaam(string $achternaam) Return the first ChildPersoon filtered by the achternaam column
 * @method     ChildPersoon findOneByGeboorteDatum(string $geboortedatum) Return the first ChildPersoon filtered by the geboortedatum column
 * @method     ChildPersoon findOneByGeslacht(string $geslacht) Return the first ChildPersoon filtered by the geslacht column
 * @method     ChildPersoon findOneByEmail(string $email) Return the first ChildPersoon filtered by the email column
 * @method     ChildPersoon findOneByBanknummer(string $banknummer) Return the first ChildPersoon filtered by the banknummer column
 * @method     ChildPersoon findOneByTelefoonnummer(string $telefoonnummer) Return the first ChildPersoon filtered by the telefoonnummer column
 * @method     ChildPersoon findOneByStraat(string $straat) Return the first ChildPersoon filtered by the straat column
 * @method     ChildPersoon findOneByHuisnummer(int $huisnummer) Return the first ChildPersoon filtered by the huisnummer column
 * @method     ChildPersoon findOneByToevoeging(string $toevoeging) Return the first ChildPersoon filtered by the toevoeging column
 * @method     ChildPersoon findOneByPostcode(string $postcode) Return the first ChildPersoon filtered by the postcode column
 * @method     ChildPersoon findOneByWoonplaats(string $woonplaats) Return the first ChildPersoon filtered by the woonplaats column
 * @method     ChildPersoon findOneByLandnaam(string $landnaam) Return the first ChildPersoon filtered by the landnaam column
 * @method     ChildPersoon findOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildPersoon filtered by the gemaakt_datum column
 * @method     ChildPersoon findOneByGemaaktDoor(string $gemaakt_door) Return the first ChildPersoon filtered by the gemaakt_door column
 * @method     ChildPersoon findOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildPersoon filtered by the gewijzigd_datum column
 * @method     ChildPersoon findOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildPersoon filtered by the gewijzigd_door column *

 * @method     ChildPersoon requirePk($key, ConnectionInterface $con = null) Return the ChildPersoon by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPersoon requireOne(ConnectionInterface $con = null) Return the first ChildPersoon matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPersoon requireOneById(int $id) Return the first ChildPersoon filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPersoon requireOneByVoornaam(string $voornaam) Return the first ChildPersoon filtered by the voornaam column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPersoon requireOneByTussenvoegsel(string $tussenvoegsel) Return the first ChildPersoon filtered by the tussenvoegsel column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPersoon requireOneByAchternaam(string $achternaam) Return the first ChildPersoon filtered by the achternaam column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPersoon requireOneByGeboorteDatum(string $geboortedatum) Return the first ChildPersoon filtered by the geboortedatum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPersoon requireOneByGeslacht(string $geslacht) Return the first ChildPersoon filtered by the geslacht column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPersoon requireOneByEmail(string $email) Return the first ChildPersoon filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPersoon requireOneByBanknummer(string $banknummer) Return the first ChildPersoon filtered by the banknummer column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPersoon requireOneByTelefoonnummer(string $telefoonnummer) Return the first ChildPersoon filtered by the telefoonnummer column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPersoon requireOneByStraat(string $straat) Return the first ChildPersoon filtered by the straat column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPersoon requireOneByHuisnummer(int $huisnummer) Return the first ChildPersoon filtered by the huisnummer column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPersoon requireOneByToevoeging(string $toevoeging) Return the first ChildPersoon filtered by the toevoeging column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPersoon requireOneByPostcode(string $postcode) Return the first ChildPersoon filtered by the postcode column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPersoon requireOneByWoonplaats(string $woonplaats) Return the first ChildPersoon filtered by the woonplaats column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPersoon requireOneByLandnaam(string $landnaam) Return the first ChildPersoon filtered by the landnaam column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPersoon requireOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildPersoon filtered by the gemaakt_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPersoon requireOneByGemaaktDoor(string $gemaakt_door) Return the first ChildPersoon filtered by the gemaakt_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPersoon requireOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildPersoon filtered by the gewijzigd_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPersoon requireOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildPersoon filtered by the gewijzigd_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPersoon[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPersoon objects based on current ModelCriteria
 * @method     ChildPersoon[]|ObjectCollection findById(int $id) Return ChildPersoon objects filtered by the id column
 * @method     ChildPersoon[]|ObjectCollection findByVoornaam(string $voornaam) Return ChildPersoon objects filtered by the voornaam column
 * @method     ChildPersoon[]|ObjectCollection findByTussenvoegsel(string $tussenvoegsel) Return ChildPersoon objects filtered by the tussenvoegsel column
 * @method     ChildPersoon[]|ObjectCollection findByAchternaam(string $achternaam) Return ChildPersoon objects filtered by the achternaam column
 * @method     ChildPersoon[]|ObjectCollection findByGeboorteDatum(string $geboortedatum) Return ChildPersoon objects filtered by the geboortedatum column
 * @method     ChildPersoon[]|ObjectCollection findByGeslacht(string $geslacht) Return ChildPersoon objects filtered by the geslacht column
 * @method     ChildPersoon[]|ObjectCollection findByEmail(string $email) Return ChildPersoon objects filtered by the email column
 * @method     ChildPersoon[]|ObjectCollection findByBanknummer(string $banknummer) Return ChildPersoon objects filtered by the banknummer column
 * @method     ChildPersoon[]|ObjectCollection findByTelefoonnummer(string $telefoonnummer) Return ChildPersoon objects filtered by the telefoonnummer column
 * @method     ChildPersoon[]|ObjectCollection findByStraat(string $straat) Return ChildPersoon objects filtered by the straat column
 * @method     ChildPersoon[]|ObjectCollection findByHuisnummer(int $huisnummer) Return ChildPersoon objects filtered by the huisnummer column
 * @method     ChildPersoon[]|ObjectCollection findByToevoeging(string $toevoeging) Return ChildPersoon objects filtered by the toevoeging column
 * @method     ChildPersoon[]|ObjectCollection findByPostcode(string $postcode) Return ChildPersoon objects filtered by the postcode column
 * @method     ChildPersoon[]|ObjectCollection findByWoonplaats(string $woonplaats) Return ChildPersoon objects filtered by the woonplaats column
 * @method     ChildPersoon[]|ObjectCollection findByLandnaam(string $landnaam) Return ChildPersoon objects filtered by the landnaam column
 * @method     ChildPersoon[]|ObjectCollection findByDatumGemaakt(string $gemaakt_datum) Return ChildPersoon objects filtered by the gemaakt_datum column
 * @method     ChildPersoon[]|ObjectCollection findByGemaaktDoor(string $gemaakt_door) Return ChildPersoon objects filtered by the gemaakt_door column
 * @method     ChildPersoon[]|ObjectCollection findByDatumGewijzigd(string $gewijzigd_datum) Return ChildPersoon objects filtered by the gewijzigd_datum column
 * @method     ChildPersoon[]|ObjectCollection findByGewijzigdDoor(string $gewijzigd_door) Return ChildPersoon objects filtered by the gewijzigd_door column
 * @method     ChildPersoon[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PersoonQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \fb_model\fb_model\Base\PersoonQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\fb_model\\fb_model\\Persoon', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPersoonQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPersoonQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPersoonQuery) {
            return $criteria;
        }
        $query = new ChildPersoonQuery();
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
     * @return ChildPersoon|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PersoonTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PersoonTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPersoon A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, voornaam, tussenvoegsel, achternaam, geboortedatum, geslacht, email, banknummer, telefoonnummer, straat, huisnummer, toevoeging, postcode, woonplaats, landnaam, gemaakt_datum, gemaakt_door, gewijzigd_datum, gewijzigd_door FROM fb_persoon WHERE id = :p0';
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
            /** @var ChildPersoon $obj */
            $obj = new ChildPersoon();
            $obj->hydrate($row);
            PersoonTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPersoon|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PersoonTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PersoonTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PersoonTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PersoonTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersoonTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the voornaam column
     *
     * Example usage:
     * <code>
     * $query->filterByVoornaam('fooValue');   // WHERE voornaam = 'fooValue'
     * $query->filterByVoornaam('%fooValue%', Criteria::LIKE); // WHERE voornaam LIKE '%fooValue%'
     * </code>
     *
     * @param     string $voornaam The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function filterByVoornaam($voornaam = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($voornaam)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersoonTableMap::COL_VOORNAAM, $voornaam, $comparison);
    }

    /**
     * Filter the query on the tussenvoegsel column
     *
     * Example usage:
     * <code>
     * $query->filterByTussenvoegsel('fooValue');   // WHERE tussenvoegsel = 'fooValue'
     * $query->filterByTussenvoegsel('%fooValue%', Criteria::LIKE); // WHERE tussenvoegsel LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tussenvoegsel The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function filterByTussenvoegsel($tussenvoegsel = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tussenvoegsel)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersoonTableMap::COL_TUSSENVOEGSEL, $tussenvoegsel, $comparison);
    }

    /**
     * Filter the query on the achternaam column
     *
     * Example usage:
     * <code>
     * $query->filterByAchternaam('fooValue');   // WHERE achternaam = 'fooValue'
     * $query->filterByAchternaam('%fooValue%', Criteria::LIKE); // WHERE achternaam LIKE '%fooValue%'
     * </code>
     *
     * @param     string $achternaam The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function filterByAchternaam($achternaam = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($achternaam)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersoonTableMap::COL_ACHTERNAAM, $achternaam, $comparison);
    }

    /**
     * Filter the query on the geboortedatum column
     *
     * Example usage:
     * <code>
     * $query->filterByGeboorteDatum('2011-03-14'); // WHERE geboortedatum = '2011-03-14'
     * $query->filterByGeboorteDatum('now'); // WHERE geboortedatum = '2011-03-14'
     * $query->filterByGeboorteDatum(array('max' => 'yesterday')); // WHERE geboortedatum > '2011-03-13'
     * </code>
     *
     * @param     mixed $geboorteDatum The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function filterByGeboorteDatum($geboorteDatum = null, $comparison = null)
    {
        if (is_array($geboorteDatum)) {
            $useMinMax = false;
            if (isset($geboorteDatum['min'])) {
                $this->addUsingAlias(PersoonTableMap::COL_GEBOORTEDATUM, $geboorteDatum['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($geboorteDatum['max'])) {
                $this->addUsingAlias(PersoonTableMap::COL_GEBOORTEDATUM, $geboorteDatum['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersoonTableMap::COL_GEBOORTEDATUM, $geboorteDatum, $comparison);
    }

    /**
     * Filter the query on the geslacht column
     *
     * Example usage:
     * <code>
     * $query->filterByGeslacht('fooValue');   // WHERE geslacht = 'fooValue'
     * $query->filterByGeslacht('%fooValue%', Criteria::LIKE); // WHERE geslacht LIKE '%fooValue%'
     * </code>
     *
     * @param     string $geslacht The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function filterByGeslacht($geslacht = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($geslacht)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersoonTableMap::COL_GESLACHT, $geslacht, $comparison);
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
     * @return $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersoonTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the banknummer column
     *
     * Example usage:
     * <code>
     * $query->filterByBanknummer('fooValue');   // WHERE banknummer = 'fooValue'
     * $query->filterByBanknummer('%fooValue%', Criteria::LIKE); // WHERE banknummer LIKE '%fooValue%'
     * </code>
     *
     * @param     string $banknummer The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function filterByBanknummer($banknummer = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($banknummer)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersoonTableMap::COL_BANKNUMMER, $banknummer, $comparison);
    }

    /**
     * Filter the query on the telefoonnummer column
     *
     * Example usage:
     * <code>
     * $query->filterByTelefoonnummer('fooValue');   // WHERE telefoonnummer = 'fooValue'
     * $query->filterByTelefoonnummer('%fooValue%', Criteria::LIKE); // WHERE telefoonnummer LIKE '%fooValue%'
     * </code>
     *
     * @param     string $telefoonnummer The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function filterByTelefoonnummer($telefoonnummer = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($telefoonnummer)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersoonTableMap::COL_TELEFOONNUMMER, $telefoonnummer, $comparison);
    }

    /**
     * Filter the query on the straat column
     *
     * Example usage:
     * <code>
     * $query->filterByStraat('fooValue');   // WHERE straat = 'fooValue'
     * $query->filterByStraat('%fooValue%', Criteria::LIKE); // WHERE straat LIKE '%fooValue%'
     * </code>
     *
     * @param     string $straat The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function filterByStraat($straat = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($straat)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersoonTableMap::COL_STRAAT, $straat, $comparison);
    }

    /**
     * Filter the query on the huisnummer column
     *
     * Example usage:
     * <code>
     * $query->filterByHuisnummer(1234); // WHERE huisnummer = 1234
     * $query->filterByHuisnummer(array(12, 34)); // WHERE huisnummer IN (12, 34)
     * $query->filterByHuisnummer(array('min' => 12)); // WHERE huisnummer > 12
     * </code>
     *
     * @param     mixed $huisnummer The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function filterByHuisnummer($huisnummer = null, $comparison = null)
    {
        if (is_array($huisnummer)) {
            $useMinMax = false;
            if (isset($huisnummer['min'])) {
                $this->addUsingAlias(PersoonTableMap::COL_HUISNUMMER, $huisnummer['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($huisnummer['max'])) {
                $this->addUsingAlias(PersoonTableMap::COL_HUISNUMMER, $huisnummer['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersoonTableMap::COL_HUISNUMMER, $huisnummer, $comparison);
    }

    /**
     * Filter the query on the toevoeging column
     *
     * Example usage:
     * <code>
     * $query->filterByToevoeging('fooValue');   // WHERE toevoeging = 'fooValue'
     * $query->filterByToevoeging('%fooValue%', Criteria::LIKE); // WHERE toevoeging LIKE '%fooValue%'
     * </code>
     *
     * @param     string $toevoeging The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function filterByToevoeging($toevoeging = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($toevoeging)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersoonTableMap::COL_TOEVOEGING, $toevoeging, $comparison);
    }

    /**
     * Filter the query on the postcode column
     *
     * Example usage:
     * <code>
     * $query->filterByPostcode('fooValue');   // WHERE postcode = 'fooValue'
     * $query->filterByPostcode('%fooValue%', Criteria::LIKE); // WHERE postcode LIKE '%fooValue%'
     * </code>
     *
     * @param     string $postcode The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function filterByPostcode($postcode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($postcode)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersoonTableMap::COL_POSTCODE, $postcode, $comparison);
    }

    /**
     * Filter the query on the woonplaats column
     *
     * Example usage:
     * <code>
     * $query->filterByWoonplaats('fooValue');   // WHERE woonplaats = 'fooValue'
     * $query->filterByWoonplaats('%fooValue%', Criteria::LIKE); // WHERE woonplaats LIKE '%fooValue%'
     * </code>
     *
     * @param     string $woonplaats The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function filterByWoonplaats($woonplaats = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($woonplaats)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersoonTableMap::COL_WOONPLAATS, $woonplaats, $comparison);
    }

    /**
     * Filter the query on the landnaam column
     *
     * Example usage:
     * <code>
     * $query->filterByLandnaam('fooValue');   // WHERE landnaam = 'fooValue'
     * $query->filterByLandnaam('%fooValue%', Criteria::LIKE); // WHERE landnaam LIKE '%fooValue%'
     * </code>
     *
     * @param     string $landnaam The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function filterByLandnaam($landnaam = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($landnaam)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersoonTableMap::COL_LANDNAAM, $landnaam, $comparison);
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
     * @return $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function filterByDatumGemaakt($datumGemaakt = null, $comparison = null)
    {
        if (is_array($datumGemaakt)) {
            $useMinMax = false;
            if (isset($datumGemaakt['min'])) {
                $this->addUsingAlias(PersoonTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGemaakt['max'])) {
                $this->addUsingAlias(PersoonTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersoonTableMap::COL_GEMAAKT_DATUM, $datumGemaakt, $comparison);
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
     * @return $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function filterByGemaaktDoor($gemaaktDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gemaaktDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersoonTableMap::COL_GEMAAKT_DOOR, $gemaaktDoor, $comparison);
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
     * @return $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function filterByDatumGewijzigd($datumGewijzigd = null, $comparison = null)
    {
        if (is_array($datumGewijzigd)) {
            $useMinMax = false;
            if (isset($datumGewijzigd['min'])) {
                $this->addUsingAlias(PersoonTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGewijzigd['max'])) {
                $this->addUsingAlias(PersoonTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersoonTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd, $comparison);
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
     * @return $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function filterByGewijzigdDoor($gewijzigdDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gewijzigdDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersoonTableMap::COL_GEWIJZIGD_DOOR, $gewijzigdDoor, $comparison);
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Contactlog object
     *
     * @param \fb_model\fb_model\Contactlog|ObjectCollection $contactlog the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPersoonQuery The current query, for fluid interface
     */
    public function filterByContactlog($contactlog, $comparison = null)
    {
        if ($contactlog instanceof \fb_model\fb_model\Contactlog) {
            return $this
                ->addUsingAlias(PersoonTableMap::COL_ID, $contactlog->getPersoonId(), $comparison);
        } elseif ($contactlog instanceof ObjectCollection) {
            return $this
                ->useContactlogQuery()
                ->filterByPrimaryKeys($contactlog->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByContactlog() only accepts arguments of type \fb_model\fb_model\Contactlog or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Contactlog relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function joinContactlog($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Contactlog');

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
            $this->addJoinObject($join, 'Contactlog');
        }

        return $this;
    }

    /**
     * Use the Contactlog relation Contactlog object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \fb_model\fb_model\ContactlogQuery A secondary query class using the current class as primary query
     */
    public function useContactlogQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinContactlog($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Contactlog', '\fb_model\fb_model\ContactlogQuery');
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Deelnemer object
     *
     * @param \fb_model\fb_model\Deelnemer|ObjectCollection $deelnemer the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPersoonQuery The current query, for fluid interface
     */
    public function filterByDeelnemer($deelnemer, $comparison = null)
    {
        if ($deelnemer instanceof \fb_model\fb_model\Deelnemer) {
            return $this
                ->addUsingAlias(PersoonTableMap::COL_ID, $deelnemer->getPersoonId(), $comparison);
        } elseif ($deelnemer instanceof ObjectCollection) {
            return $this
                ->useDeelnemerQuery()
                ->filterByPrimaryKeys($deelnemer->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDeelnemer() only accepts arguments of type \fb_model\fb_model\Deelnemer or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Deelnemer relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function joinDeelnemer($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Deelnemer');

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
            $this->addJoinObject($join, 'Deelnemer');
        }

        return $this;
    }

    /**
     * Use the Deelnemer relation Deelnemer object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \fb_model\fb_model\DeelnemerQuery A secondary query class using the current class as primary query
     */
    public function useDeelnemerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDeelnemer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Deelnemer', '\fb_model\fb_model\DeelnemerQuery');
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Gebruiker object
     *
     * @param \fb_model\fb_model\Gebruiker|ObjectCollection $gebruiker the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPersoonQuery The current query, for fluid interface
     */
    public function filterByGebruiker($gebruiker, $comparison = null)
    {
        if ($gebruiker instanceof \fb_model\fb_model\Gebruiker) {
            return $this
                ->addUsingAlias(PersoonTableMap::COL_ID, $gebruiker->getPersoonId(), $comparison);
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
     * @return $this|ChildPersoonQuery The current query, for fluid interface
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
     * @return ChildPersoonQuery The current query, for fluid interface
     */
    public function filterByInschrijving($inschrijving, $comparison = null)
    {
        if ($inschrijving instanceof \fb_model\fb_model\Inschrijving) {
            return $this
                ->addUsingAlias(PersoonTableMap::COL_ID, $inschrijving->getContactPersoonId(), $comparison);
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
     * @return $this|ChildPersoonQuery The current query, for fluid interface
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
     * @param   ChildPersoon $persoon Object to remove from the list of results
     *
     * @return $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function prune($persoon = null)
    {
        if ($persoon) {
            $this->addUsingAlias(PersoonTableMap::COL_ID, $persoon->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fb_persoon table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PersoonTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PersoonTableMap::clearInstancePool();
            PersoonTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PersoonTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PersoonTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PersoonTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PersoonTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(PersoonTableMap::COL_GEWIJZIGD_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(PersoonTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(PersoonTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(PersoonTableMap::COL_GEMAAKT_DATUM);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(PersoonTableMap::COL_GEMAAKT_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildPersoonQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(PersoonTableMap::COL_GEMAAKT_DATUM);
    }

} // PersoonQuery
