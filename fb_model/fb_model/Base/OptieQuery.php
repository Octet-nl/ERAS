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
use fb_model\fb_model\Optie as ChildOptie;
use fb_model\fb_model\OptieQuery as ChildOptieQuery;
use fb_model\fb_model\Map\OptieTableMap;

/**
 * Base class that represents a query for the 'fb_optie' table.
 *
 *
 *
 * @method     ChildOptieQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildOptieQuery orderByPerDeelnemer($order = Criteria::ASC) Order by the per_deelnemer column
 * @method     ChildOptieQuery orderByNaam($order = Criteria::ASC) Order by the naam column
 * @method     ChildOptieQuery orderByTekstVoor($order = Criteria::ASC) Order by the tekst_voor column
 * @method     ChildOptieQuery orderByTekstAchter($order = Criteria::ASC) Order by the tekst_achter column
 * @method     ChildOptieQuery orderByTooltipTekst($order = Criteria::ASC) Order by the tooltip_tekst column
 * @method     ChildOptieQuery orderByHeeftHorizontaleLijn($order = Criteria::ASC) Order by the heeft_hor_lijn column
 * @method     ChildOptieQuery orderByOptieType($order = Criteria::ASC) Order by the optietype column
 * @method     ChildOptieQuery orderByGroep($order = Criteria::ASC) Order by the groep column
 * @method     ChildOptieQuery orderByLabel($order = Criteria::ASC) Order by the label column
 * @method     ChildOptieQuery orderByIsDefault($order = Criteria::ASC) Order by the is_default column
 * @method     ChildOptieQuery orderByLaterWijzigen($order = Criteria::ASC) Order by the later_wijzigen column
 * @method     ChildOptieQuery orderByTotaalAantal($order = Criteria::ASC) Order by the totaal_aantal column
 * @method     ChildOptieQuery orderByPrijs($order = Criteria::ASC) Order by the prijs column
 * @method     ChildOptieQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildOptieQuery orderByInternGebruik($order = Criteria::ASC) Order by the intern_gebruik column
 * @method     ChildOptieQuery orderByDatumGemaakt($order = Criteria::ASC) Order by the gemaakt_datum column
 * @method     ChildOptieQuery orderByGemaaktDoor($order = Criteria::ASC) Order by the gemaakt_door column
 * @method     ChildOptieQuery orderByDatumGewijzigd($order = Criteria::ASC) Order by the gewijzigd_datum column
 * @method     ChildOptieQuery orderByGewijzigdDoor($order = Criteria::ASC) Order by the gewijzigd_door column
 *
 * @method     ChildOptieQuery groupById() Group by the id column
 * @method     ChildOptieQuery groupByPerDeelnemer() Group by the per_deelnemer column
 * @method     ChildOptieQuery groupByNaam() Group by the naam column
 * @method     ChildOptieQuery groupByTekstVoor() Group by the tekst_voor column
 * @method     ChildOptieQuery groupByTekstAchter() Group by the tekst_achter column
 * @method     ChildOptieQuery groupByTooltipTekst() Group by the tooltip_tekst column
 * @method     ChildOptieQuery groupByHeeftHorizontaleLijn() Group by the heeft_hor_lijn column
 * @method     ChildOptieQuery groupByOptieType() Group by the optietype column
 * @method     ChildOptieQuery groupByGroep() Group by the groep column
 * @method     ChildOptieQuery groupByLabel() Group by the label column
 * @method     ChildOptieQuery groupByIsDefault() Group by the is_default column
 * @method     ChildOptieQuery groupByLaterWijzigen() Group by the later_wijzigen column
 * @method     ChildOptieQuery groupByTotaalAantal() Group by the totaal_aantal column
 * @method     ChildOptieQuery groupByPrijs() Group by the prijs column
 * @method     ChildOptieQuery groupByStatus() Group by the status column
 * @method     ChildOptieQuery groupByInternGebruik() Group by the intern_gebruik column
 * @method     ChildOptieQuery groupByDatumGemaakt() Group by the gemaakt_datum column
 * @method     ChildOptieQuery groupByGemaaktDoor() Group by the gemaakt_door column
 * @method     ChildOptieQuery groupByDatumGewijzigd() Group by the gewijzigd_datum column
 * @method     ChildOptieQuery groupByGewijzigdDoor() Group by the gewijzigd_door column
 *
 * @method     ChildOptieQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildOptieQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildOptieQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildOptieQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildOptieQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildOptieQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildOptieQuery leftJoinType($relationAlias = null) Adds a LEFT JOIN clause to the query using the Type relation
 * @method     ChildOptieQuery rightJoinType($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Type relation
 * @method     ChildOptieQuery innerJoinType($relationAlias = null) Adds a INNER JOIN clause to the query using the Type relation
 *
 * @method     ChildOptieQuery joinWithType($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Type relation
 *
 * @method     ChildOptieQuery leftJoinWithType() Adds a LEFT JOIN clause and with to the query using the Type relation
 * @method     ChildOptieQuery rightJoinWithType() Adds a RIGHT JOIN clause and with to the query using the Type relation
 * @method     ChildOptieQuery innerJoinWithType() Adds a INNER JOIN clause and with to the query using the Type relation
 *
 * @method     ChildOptieQuery leftJoinDeelnemerHeeftOptie($relationAlias = null) Adds a LEFT JOIN clause to the query using the DeelnemerHeeftOptie relation
 * @method     ChildOptieQuery rightJoinDeelnemerHeeftOptie($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DeelnemerHeeftOptie relation
 * @method     ChildOptieQuery innerJoinDeelnemerHeeftOptie($relationAlias = null) Adds a INNER JOIN clause to the query using the DeelnemerHeeftOptie relation
 *
 * @method     ChildOptieQuery joinWithDeelnemerHeeftOptie($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DeelnemerHeeftOptie relation
 *
 * @method     ChildOptieQuery leftJoinWithDeelnemerHeeftOptie() Adds a LEFT JOIN clause and with to the query using the DeelnemerHeeftOptie relation
 * @method     ChildOptieQuery rightJoinWithDeelnemerHeeftOptie() Adds a RIGHT JOIN clause and with to the query using the DeelnemerHeeftOptie relation
 * @method     ChildOptieQuery innerJoinWithDeelnemerHeeftOptie() Adds a INNER JOIN clause and with to the query using the DeelnemerHeeftOptie relation
 *
 * @method     ChildOptieQuery leftJoinEvenementHeeftOptie($relationAlias = null) Adds a LEFT JOIN clause to the query using the EvenementHeeftOptie relation
 * @method     ChildOptieQuery rightJoinEvenementHeeftOptie($relationAlias = null) Adds a RIGHT JOIN clause to the query using the EvenementHeeftOptie relation
 * @method     ChildOptieQuery innerJoinEvenementHeeftOptie($relationAlias = null) Adds a INNER JOIN clause to the query using the EvenementHeeftOptie relation
 *
 * @method     ChildOptieQuery joinWithEvenementHeeftOptie($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the EvenementHeeftOptie relation
 *
 * @method     ChildOptieQuery leftJoinWithEvenementHeeftOptie() Adds a LEFT JOIN clause and with to the query using the EvenementHeeftOptie relation
 * @method     ChildOptieQuery rightJoinWithEvenementHeeftOptie() Adds a RIGHT JOIN clause and with to the query using the EvenementHeeftOptie relation
 * @method     ChildOptieQuery innerJoinWithEvenementHeeftOptie() Adds a INNER JOIN clause and with to the query using the EvenementHeeftOptie relation
 *
 * @method     ChildOptieQuery leftJoinInschrijvingHeeftOptie($relationAlias = null) Adds a LEFT JOIN clause to the query using the InschrijvingHeeftOptie relation
 * @method     ChildOptieQuery rightJoinInschrijvingHeeftOptie($relationAlias = null) Adds a RIGHT JOIN clause to the query using the InschrijvingHeeftOptie relation
 * @method     ChildOptieQuery innerJoinInschrijvingHeeftOptie($relationAlias = null) Adds a INNER JOIN clause to the query using the InschrijvingHeeftOptie relation
 *
 * @method     ChildOptieQuery joinWithInschrijvingHeeftOptie($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the InschrijvingHeeftOptie relation
 *
 * @method     ChildOptieQuery leftJoinWithInschrijvingHeeftOptie() Adds a LEFT JOIN clause and with to the query using the InschrijvingHeeftOptie relation
 * @method     ChildOptieQuery rightJoinWithInschrijvingHeeftOptie() Adds a RIGHT JOIN clause and with to the query using the InschrijvingHeeftOptie relation
 * @method     ChildOptieQuery innerJoinWithInschrijvingHeeftOptie() Adds a INNER JOIN clause and with to the query using the InschrijvingHeeftOptie relation
 *
 * @method     \fb_model\fb_model\TypeQuery|\fb_model\fb_model\DeelnemerHeeftOptieQuery|\fb_model\fb_model\EvenementHeeftOptieQuery|\fb_model\fb_model\InschrijvingHeeftOptieQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildOptie findOne(ConnectionInterface $con = null) Return the first ChildOptie matching the query
 * @method     ChildOptie findOneOrCreate(ConnectionInterface $con = null) Return the first ChildOptie matching the query, or a new ChildOptie object populated from the query conditions when no match is found
 *
 * @method     ChildOptie findOneById(int $id) Return the first ChildOptie filtered by the id column
 * @method     ChildOptie findOneByPerDeelnemer(int $per_deelnemer) Return the first ChildOptie filtered by the per_deelnemer column
 * @method     ChildOptie findOneByNaam(string $naam) Return the first ChildOptie filtered by the naam column
 * @method     ChildOptie findOneByTekstVoor(string $tekst_voor) Return the first ChildOptie filtered by the tekst_voor column
 * @method     ChildOptie findOneByTekstAchter(string $tekst_achter) Return the first ChildOptie filtered by the tekst_achter column
 * @method     ChildOptie findOneByTooltipTekst(string $tooltip_tekst) Return the first ChildOptie filtered by the tooltip_tekst column
 * @method     ChildOptie findOneByHeeftHorizontaleLijn(int $heeft_hor_lijn) Return the first ChildOptie filtered by the heeft_hor_lijn column
 * @method     ChildOptie findOneByOptieType(int $optietype) Return the first ChildOptie filtered by the optietype column
 * @method     ChildOptie findOneByGroep(string $groep) Return the first ChildOptie filtered by the groep column
 * @method     ChildOptie findOneByLabel(string $label) Return the first ChildOptie filtered by the label column
 * @method     ChildOptie findOneByIsDefault(int $is_default) Return the first ChildOptie filtered by the is_default column
 * @method     ChildOptie findOneByLaterWijzigen(int $later_wijzigen) Return the first ChildOptie filtered by the later_wijzigen column
 * @method     ChildOptie findOneByTotaalAantal(int $totaal_aantal) Return the first ChildOptie filtered by the totaal_aantal column
 * @method     ChildOptie findOneByPrijs(string $prijs) Return the first ChildOptie filtered by the prijs column
 * @method     ChildOptie findOneByStatus(int $status) Return the first ChildOptie filtered by the status column
 * @method     ChildOptie findOneByInternGebruik(int $intern_gebruik) Return the first ChildOptie filtered by the intern_gebruik column
 * @method     ChildOptie findOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildOptie filtered by the gemaakt_datum column
 * @method     ChildOptie findOneByGemaaktDoor(string $gemaakt_door) Return the first ChildOptie filtered by the gemaakt_door column
 * @method     ChildOptie findOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildOptie filtered by the gewijzigd_datum column
 * @method     ChildOptie findOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildOptie filtered by the gewijzigd_door column *

 * @method     ChildOptie requirePk($key, ConnectionInterface $con = null) Return the ChildOptie by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOptie requireOne(ConnectionInterface $con = null) Return the first ChildOptie matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildOptie requireOneById(int $id) Return the first ChildOptie filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOptie requireOneByPerDeelnemer(int $per_deelnemer) Return the first ChildOptie filtered by the per_deelnemer column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOptie requireOneByNaam(string $naam) Return the first ChildOptie filtered by the naam column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOptie requireOneByTekstVoor(string $tekst_voor) Return the first ChildOptie filtered by the tekst_voor column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOptie requireOneByTekstAchter(string $tekst_achter) Return the first ChildOptie filtered by the tekst_achter column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOptie requireOneByTooltipTekst(string $tooltip_tekst) Return the first ChildOptie filtered by the tooltip_tekst column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOptie requireOneByHeeftHorizontaleLijn(int $heeft_hor_lijn) Return the first ChildOptie filtered by the heeft_hor_lijn column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOptie requireOneByOptieType(int $optietype) Return the first ChildOptie filtered by the optietype column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOptie requireOneByGroep(string $groep) Return the first ChildOptie filtered by the groep column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOptie requireOneByLabel(string $label) Return the first ChildOptie filtered by the label column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOptie requireOneByIsDefault(int $is_default) Return the first ChildOptie filtered by the is_default column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOptie requireOneByLaterWijzigen(int $later_wijzigen) Return the first ChildOptie filtered by the later_wijzigen column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOptie requireOneByTotaalAantal(int $totaal_aantal) Return the first ChildOptie filtered by the totaal_aantal column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOptie requireOneByPrijs(string $prijs) Return the first ChildOptie filtered by the prijs column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOptie requireOneByStatus(int $status) Return the first ChildOptie filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOptie requireOneByInternGebruik(int $intern_gebruik) Return the first ChildOptie filtered by the intern_gebruik column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOptie requireOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildOptie filtered by the gemaakt_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOptie requireOneByGemaaktDoor(string $gemaakt_door) Return the first ChildOptie filtered by the gemaakt_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOptie requireOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildOptie filtered by the gewijzigd_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOptie requireOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildOptie filtered by the gewijzigd_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildOptie[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildOptie objects based on current ModelCriteria
 * @method     ChildOptie[]|ObjectCollection findById(int $id) Return ChildOptie objects filtered by the id column
 * @method     ChildOptie[]|ObjectCollection findByPerDeelnemer(int $per_deelnemer) Return ChildOptie objects filtered by the per_deelnemer column
 * @method     ChildOptie[]|ObjectCollection findByNaam(string $naam) Return ChildOptie objects filtered by the naam column
 * @method     ChildOptie[]|ObjectCollection findByTekstVoor(string $tekst_voor) Return ChildOptie objects filtered by the tekst_voor column
 * @method     ChildOptie[]|ObjectCollection findByTekstAchter(string $tekst_achter) Return ChildOptie objects filtered by the tekst_achter column
 * @method     ChildOptie[]|ObjectCollection findByTooltipTekst(string $tooltip_tekst) Return ChildOptie objects filtered by the tooltip_tekst column
 * @method     ChildOptie[]|ObjectCollection findByHeeftHorizontaleLijn(int $heeft_hor_lijn) Return ChildOptie objects filtered by the heeft_hor_lijn column
 * @method     ChildOptie[]|ObjectCollection findByOptieType(int $optietype) Return ChildOptie objects filtered by the optietype column
 * @method     ChildOptie[]|ObjectCollection findByGroep(string $groep) Return ChildOptie objects filtered by the groep column
 * @method     ChildOptie[]|ObjectCollection findByLabel(string $label) Return ChildOptie objects filtered by the label column
 * @method     ChildOptie[]|ObjectCollection findByIsDefault(int $is_default) Return ChildOptie objects filtered by the is_default column
 * @method     ChildOptie[]|ObjectCollection findByLaterWijzigen(int $later_wijzigen) Return ChildOptie objects filtered by the later_wijzigen column
 * @method     ChildOptie[]|ObjectCollection findByTotaalAantal(int $totaal_aantal) Return ChildOptie objects filtered by the totaal_aantal column
 * @method     ChildOptie[]|ObjectCollection findByPrijs(string $prijs) Return ChildOptie objects filtered by the prijs column
 * @method     ChildOptie[]|ObjectCollection findByStatus(int $status) Return ChildOptie objects filtered by the status column
 * @method     ChildOptie[]|ObjectCollection findByInternGebruik(int $intern_gebruik) Return ChildOptie objects filtered by the intern_gebruik column
 * @method     ChildOptie[]|ObjectCollection findByDatumGemaakt(string $gemaakt_datum) Return ChildOptie objects filtered by the gemaakt_datum column
 * @method     ChildOptie[]|ObjectCollection findByGemaaktDoor(string $gemaakt_door) Return ChildOptie objects filtered by the gemaakt_door column
 * @method     ChildOptie[]|ObjectCollection findByDatumGewijzigd(string $gewijzigd_datum) Return ChildOptie objects filtered by the gewijzigd_datum column
 * @method     ChildOptie[]|ObjectCollection findByGewijzigdDoor(string $gewijzigd_door) Return ChildOptie objects filtered by the gewijzigd_door column
 * @method     ChildOptie[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class OptieQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \fb_model\fb_model\Base\OptieQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\fb_model\\fb_model\\Optie', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildOptieQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildOptieQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildOptieQuery) {
            return $criteria;
        }
        $query = new ChildOptieQuery();
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
     * @return ChildOptie|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OptieTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = OptieTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildOptie A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, per_deelnemer, naam, tekst_voor, tekst_achter, tooltip_tekst, heeft_hor_lijn, optietype, groep, label, is_default, later_wijzigen, totaal_aantal, prijs, status, intern_gebruik, gemaakt_datum, gemaakt_door, gewijzigd_datum, gewijzigd_door FROM fb_optie WHERE id = :p0';
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
            /** @var ChildOptie $obj */
            $obj = new ChildOptie();
            $obj->hydrate($row);
            OptieTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildOptie|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(OptieTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(OptieTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(OptieTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(OptieTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OptieTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the per_deelnemer column
     *
     * Example usage:
     * <code>
     * $query->filterByPerDeelnemer(1234); // WHERE per_deelnemer = 1234
     * $query->filterByPerDeelnemer(array(12, 34)); // WHERE per_deelnemer IN (12, 34)
     * $query->filterByPerDeelnemer(array('min' => 12)); // WHERE per_deelnemer > 12
     * </code>
     *
     * @param     mixed $perDeelnemer The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function filterByPerDeelnemer($perDeelnemer = null, $comparison = null)
    {
        if (is_array($perDeelnemer)) {
            $useMinMax = false;
            if (isset($perDeelnemer['min'])) {
                $this->addUsingAlias(OptieTableMap::COL_PER_DEELNEMER, $perDeelnemer['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($perDeelnemer['max'])) {
                $this->addUsingAlias(OptieTableMap::COL_PER_DEELNEMER, $perDeelnemer['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OptieTableMap::COL_PER_DEELNEMER, $perDeelnemer, $comparison);
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
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function filterByNaam($naam = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($naam)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OptieTableMap::COL_NAAM, $naam, $comparison);
    }

    /**
     * Filter the query on the tekst_voor column
     *
     * Example usage:
     * <code>
     * $query->filterByTekstVoor('fooValue');   // WHERE tekst_voor = 'fooValue'
     * $query->filterByTekstVoor('%fooValue%', Criteria::LIKE); // WHERE tekst_voor LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tekstVoor The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function filterByTekstVoor($tekstVoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tekstVoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OptieTableMap::COL_TEKST_VOOR, $tekstVoor, $comparison);
    }

    /**
     * Filter the query on the tekst_achter column
     *
     * Example usage:
     * <code>
     * $query->filterByTekstAchter('fooValue');   // WHERE tekst_achter = 'fooValue'
     * $query->filterByTekstAchter('%fooValue%', Criteria::LIKE); // WHERE tekst_achter LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tekstAchter The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function filterByTekstAchter($tekstAchter = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tekstAchter)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OptieTableMap::COL_TEKST_ACHTER, $tekstAchter, $comparison);
    }

    /**
     * Filter the query on the tooltip_tekst column
     *
     * Example usage:
     * <code>
     * $query->filterByTooltipTekst('fooValue');   // WHERE tooltip_tekst = 'fooValue'
     * $query->filterByTooltipTekst('%fooValue%', Criteria::LIKE); // WHERE tooltip_tekst LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tooltipTekst The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function filterByTooltipTekst($tooltipTekst = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tooltipTekst)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OptieTableMap::COL_TOOLTIP_TEKST, $tooltipTekst, $comparison);
    }

    /**
     * Filter the query on the heeft_hor_lijn column
     *
     * Example usage:
     * <code>
     * $query->filterByHeeftHorizontaleLijn(1234); // WHERE heeft_hor_lijn = 1234
     * $query->filterByHeeftHorizontaleLijn(array(12, 34)); // WHERE heeft_hor_lijn IN (12, 34)
     * $query->filterByHeeftHorizontaleLijn(array('min' => 12)); // WHERE heeft_hor_lijn > 12
     * </code>
     *
     * @param     mixed $heeftHorizontaleLijn The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function filterByHeeftHorizontaleLijn($heeftHorizontaleLijn = null, $comparison = null)
    {
        if (is_array($heeftHorizontaleLijn)) {
            $useMinMax = false;
            if (isset($heeftHorizontaleLijn['min'])) {
                $this->addUsingAlias(OptieTableMap::COL_HEEFT_HOR_LIJN, $heeftHorizontaleLijn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($heeftHorizontaleLijn['max'])) {
                $this->addUsingAlias(OptieTableMap::COL_HEEFT_HOR_LIJN, $heeftHorizontaleLijn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OptieTableMap::COL_HEEFT_HOR_LIJN, $heeftHorizontaleLijn, $comparison);
    }

    /**
     * Filter the query on the optietype column
     *
     * Example usage:
     * <code>
     * $query->filterByOptieType(1234); // WHERE optietype = 1234
     * $query->filterByOptieType(array(12, 34)); // WHERE optietype IN (12, 34)
     * $query->filterByOptieType(array('min' => 12)); // WHERE optietype > 12
     * </code>
     *
     * @see       filterByType()
     *
     * @param     mixed $optieType The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function filterByOptieType($optieType = null, $comparison = null)
    {
        if (is_array($optieType)) {
            $useMinMax = false;
            if (isset($optieType['min'])) {
                $this->addUsingAlias(OptieTableMap::COL_OPTIETYPE, $optieType['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($optieType['max'])) {
                $this->addUsingAlias(OptieTableMap::COL_OPTIETYPE, $optieType['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OptieTableMap::COL_OPTIETYPE, $optieType, $comparison);
    }

    /**
     * Filter the query on the groep column
     *
     * Example usage:
     * <code>
     * $query->filterByGroep('fooValue');   // WHERE groep = 'fooValue'
     * $query->filterByGroep('%fooValue%', Criteria::LIKE); // WHERE groep LIKE '%fooValue%'
     * </code>
     *
     * @param     string $groep The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function filterByGroep($groep = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($groep)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OptieTableMap::COL_GROEP, $groep, $comparison);
    }

    /**
     * Filter the query on the label column
     *
     * Example usage:
     * <code>
     * $query->filterByLabel('fooValue');   // WHERE label = 'fooValue'
     * $query->filterByLabel('%fooValue%', Criteria::LIKE); // WHERE label LIKE '%fooValue%'
     * </code>
     *
     * @param     string $label The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function filterByLabel($label = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($label)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OptieTableMap::COL_LABEL, $label, $comparison);
    }

    /**
     * Filter the query on the is_default column
     *
     * Example usage:
     * <code>
     * $query->filterByIsDefault(1234); // WHERE is_default = 1234
     * $query->filterByIsDefault(array(12, 34)); // WHERE is_default IN (12, 34)
     * $query->filterByIsDefault(array('min' => 12)); // WHERE is_default > 12
     * </code>
     *
     * @param     mixed $isDefault The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function filterByIsDefault($isDefault = null, $comparison = null)
    {
        if (is_array($isDefault)) {
            $useMinMax = false;
            if (isset($isDefault['min'])) {
                $this->addUsingAlias(OptieTableMap::COL_IS_DEFAULT, $isDefault['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isDefault['max'])) {
                $this->addUsingAlias(OptieTableMap::COL_IS_DEFAULT, $isDefault['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OptieTableMap::COL_IS_DEFAULT, $isDefault, $comparison);
    }

    /**
     * Filter the query on the later_wijzigen column
     *
     * Example usage:
     * <code>
     * $query->filterByLaterWijzigen(1234); // WHERE later_wijzigen = 1234
     * $query->filterByLaterWijzigen(array(12, 34)); // WHERE later_wijzigen IN (12, 34)
     * $query->filterByLaterWijzigen(array('min' => 12)); // WHERE later_wijzigen > 12
     * </code>
     *
     * @param     mixed $laterWijzigen The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function filterByLaterWijzigen($laterWijzigen = null, $comparison = null)
    {
        if (is_array($laterWijzigen)) {
            $useMinMax = false;
            if (isset($laterWijzigen['min'])) {
                $this->addUsingAlias(OptieTableMap::COL_LATER_WIJZIGEN, $laterWijzigen['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($laterWijzigen['max'])) {
                $this->addUsingAlias(OptieTableMap::COL_LATER_WIJZIGEN, $laterWijzigen['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OptieTableMap::COL_LATER_WIJZIGEN, $laterWijzigen, $comparison);
    }

    /**
     * Filter the query on the totaal_aantal column
     *
     * Example usage:
     * <code>
     * $query->filterByTotaalAantal(1234); // WHERE totaal_aantal = 1234
     * $query->filterByTotaalAantal(array(12, 34)); // WHERE totaal_aantal IN (12, 34)
     * $query->filterByTotaalAantal(array('min' => 12)); // WHERE totaal_aantal > 12
     * </code>
     *
     * @param     mixed $totaalAantal The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function filterByTotaalAantal($totaalAantal = null, $comparison = null)
    {
        if (is_array($totaalAantal)) {
            $useMinMax = false;
            if (isset($totaalAantal['min'])) {
                $this->addUsingAlias(OptieTableMap::COL_TOTAAL_AANTAL, $totaalAantal['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($totaalAantal['max'])) {
                $this->addUsingAlias(OptieTableMap::COL_TOTAAL_AANTAL, $totaalAantal['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OptieTableMap::COL_TOTAAL_AANTAL, $totaalAantal, $comparison);
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
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function filterByPrijs($prijs = null, $comparison = null)
    {
        if (is_array($prijs)) {
            $useMinMax = false;
            if (isset($prijs['min'])) {
                $this->addUsingAlias(OptieTableMap::COL_PRIJS, $prijs['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($prijs['max'])) {
                $this->addUsingAlias(OptieTableMap::COL_PRIJS, $prijs['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OptieTableMap::COL_PRIJS, $prijs, $comparison);
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
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (is_array($status)) {
            $useMinMax = false;
            if (isset($status['min'])) {
                $this->addUsingAlias(OptieTableMap::COL_STATUS, $status['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($status['max'])) {
                $this->addUsingAlias(OptieTableMap::COL_STATUS, $status['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OptieTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the intern_gebruik column
     *
     * Example usage:
     * <code>
     * $query->filterByInternGebruik(1234); // WHERE intern_gebruik = 1234
     * $query->filterByInternGebruik(array(12, 34)); // WHERE intern_gebruik IN (12, 34)
     * $query->filterByInternGebruik(array('min' => 12)); // WHERE intern_gebruik > 12
     * </code>
     *
     * @param     mixed $internGebruik The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function filterByInternGebruik($internGebruik = null, $comparison = null)
    {
        if (is_array($internGebruik)) {
            $useMinMax = false;
            if (isset($internGebruik['min'])) {
                $this->addUsingAlias(OptieTableMap::COL_INTERN_GEBRUIK, $internGebruik['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($internGebruik['max'])) {
                $this->addUsingAlias(OptieTableMap::COL_INTERN_GEBRUIK, $internGebruik['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OptieTableMap::COL_INTERN_GEBRUIK, $internGebruik, $comparison);
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
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function filterByDatumGemaakt($datumGemaakt = null, $comparison = null)
    {
        if (is_array($datumGemaakt)) {
            $useMinMax = false;
            if (isset($datumGemaakt['min'])) {
                $this->addUsingAlias(OptieTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGemaakt['max'])) {
                $this->addUsingAlias(OptieTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OptieTableMap::COL_GEMAAKT_DATUM, $datumGemaakt, $comparison);
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
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function filterByGemaaktDoor($gemaaktDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gemaaktDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OptieTableMap::COL_GEMAAKT_DOOR, $gemaaktDoor, $comparison);
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
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function filterByDatumGewijzigd($datumGewijzigd = null, $comparison = null)
    {
        if (is_array($datumGewijzigd)) {
            $useMinMax = false;
            if (isset($datumGewijzigd['min'])) {
                $this->addUsingAlias(OptieTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGewijzigd['max'])) {
                $this->addUsingAlias(OptieTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OptieTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd, $comparison);
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
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function filterByGewijzigdDoor($gewijzigdDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gewijzigdDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OptieTableMap::COL_GEWIJZIGD_DOOR, $gewijzigdDoor, $comparison);
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Type object
     *
     * @param \fb_model\fb_model\Type|ObjectCollection $type The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildOptieQuery The current query, for fluid interface
     */
    public function filterByType($type, $comparison = null)
    {
        if ($type instanceof \fb_model\fb_model\Type) {
            return $this
                ->addUsingAlias(OptieTableMap::COL_OPTIETYPE, $type->getId(), $comparison);
        } elseif ($type instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OptieTableMap::COL_OPTIETYPE, $type->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByType() only accepts arguments of type \fb_model\fb_model\Type or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Type relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function joinType($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Type');

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
            $this->addJoinObject($join, 'Type');
        }

        return $this;
    }

    /**
     * Use the Type relation Type object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \fb_model\fb_model\TypeQuery A secondary query class using the current class as primary query
     */
    public function useTypeQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinType($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Type', '\fb_model\fb_model\TypeQuery');
    }

    /**
     * Filter the query by a related \fb_model\fb_model\DeelnemerHeeftOptie object
     *
     * @param \fb_model\fb_model\DeelnemerHeeftOptie|ObjectCollection $deelnemerHeeftOptie the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOptieQuery The current query, for fluid interface
     */
    public function filterByDeelnemerHeeftOptie($deelnemerHeeftOptie, $comparison = null)
    {
        if ($deelnemerHeeftOptie instanceof \fb_model\fb_model\DeelnemerHeeftOptie) {
            return $this
                ->addUsingAlias(OptieTableMap::COL_ID, $deelnemerHeeftOptie->getOptieId(), $comparison);
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
     * @return $this|ChildOptieQuery The current query, for fluid interface
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
     * Filter the query by a related \fb_model\fb_model\EvenementHeeftOptie object
     *
     * @param \fb_model\fb_model\EvenementHeeftOptie|ObjectCollection $evenementHeeftOptie the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOptieQuery The current query, for fluid interface
     */
    public function filterByEvenementHeeftOptie($evenementHeeftOptie, $comparison = null)
    {
        if ($evenementHeeftOptie instanceof \fb_model\fb_model\EvenementHeeftOptie) {
            return $this
                ->addUsingAlias(OptieTableMap::COL_ID, $evenementHeeftOptie->getOptieId(), $comparison);
        } elseif ($evenementHeeftOptie instanceof ObjectCollection) {
            return $this
                ->useEvenementHeeftOptieQuery()
                ->filterByPrimaryKeys($evenementHeeftOptie->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByEvenementHeeftOptie() only accepts arguments of type \fb_model\fb_model\EvenementHeeftOptie or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the EvenementHeeftOptie relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function joinEvenementHeeftOptie($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('EvenementHeeftOptie');

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
            $this->addJoinObject($join, 'EvenementHeeftOptie');
        }

        return $this;
    }

    /**
     * Use the EvenementHeeftOptie relation EvenementHeeftOptie object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \fb_model\fb_model\EvenementHeeftOptieQuery A secondary query class using the current class as primary query
     */
    public function useEvenementHeeftOptieQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinEvenementHeeftOptie($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'EvenementHeeftOptie', '\fb_model\fb_model\EvenementHeeftOptieQuery');
    }

    /**
     * Filter the query by a related \fb_model\fb_model\InschrijvingHeeftOptie object
     *
     * @param \fb_model\fb_model\InschrijvingHeeftOptie|ObjectCollection $inschrijvingHeeftOptie the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOptieQuery The current query, for fluid interface
     */
    public function filterByInschrijvingHeeftOptie($inschrijvingHeeftOptie, $comparison = null)
    {
        if ($inschrijvingHeeftOptie instanceof \fb_model\fb_model\InschrijvingHeeftOptie) {
            return $this
                ->addUsingAlias(OptieTableMap::COL_ID, $inschrijvingHeeftOptie->getOptieId(), $comparison);
        } elseif ($inschrijvingHeeftOptie instanceof ObjectCollection) {
            return $this
                ->useInschrijvingHeeftOptieQuery()
                ->filterByPrimaryKeys($inschrijvingHeeftOptie->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByInschrijvingHeeftOptie() only accepts arguments of type \fb_model\fb_model\InschrijvingHeeftOptie or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the InschrijvingHeeftOptie relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function joinInschrijvingHeeftOptie($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('InschrijvingHeeftOptie');

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
            $this->addJoinObject($join, 'InschrijvingHeeftOptie');
        }

        return $this;
    }

    /**
     * Use the InschrijvingHeeftOptie relation InschrijvingHeeftOptie object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \fb_model\fb_model\InschrijvingHeeftOptieQuery A secondary query class using the current class as primary query
     */
    public function useInschrijvingHeeftOptieQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinInschrijvingHeeftOptie($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'InschrijvingHeeftOptie', '\fb_model\fb_model\InschrijvingHeeftOptieQuery');
    }

    /**
     * Filter the query by a related Deelnemer object
     * using the fb_deelnemer_heeft_optie table as cross reference
     *
     * @param Deelnemer $deelnemer the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOptieQuery The current query, for fluid interface
     */
    public function filterByDeelnemer($deelnemer, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useDeelnemerHeeftOptieQuery()
            ->filterByDeelnemer($deelnemer, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Evenement object
     * using the fb_evenement_heeft_optie table as cross reference
     *
     * @param Evenement $evenement the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOptieQuery The current query, for fluid interface
     */
    public function filterByEvenement($evenement, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useEvenementHeeftOptieQuery()
            ->filterByEvenement($evenement, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Inschrijving object
     * using the fb_inschrijving_heeft_optie table as cross reference
     *
     * @param Inschrijving $inschrijving the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOptieQuery The current query, for fluid interface
     */
    public function filterByInschrijving($inschrijving, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useInschrijvingHeeftOptieQuery()
            ->filterByInschrijving($inschrijving, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildOptie $optie Object to remove from the list of results
     *
     * @return $this|ChildOptieQuery The current query, for fluid interface
     */
    public function prune($optie = null)
    {
        if ($optie) {
            $this->addUsingAlias(OptieTableMap::COL_ID, $optie->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fb_optie table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OptieTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            OptieTableMap::clearInstancePool();
            OptieTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(OptieTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(OptieTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            OptieTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            OptieTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildOptieQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(OptieTableMap::COL_GEWIJZIGD_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildOptieQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(OptieTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildOptieQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(OptieTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildOptieQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(OptieTableMap::COL_GEMAAKT_DATUM);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildOptieQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(OptieTableMap::COL_GEMAAKT_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildOptieQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(OptieTableMap::COL_GEMAAKT_DATUM);
    }

} // OptieQuery
