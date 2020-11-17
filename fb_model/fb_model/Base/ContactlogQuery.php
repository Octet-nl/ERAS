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
use fb_model\fb_model\Contactlog as ChildContactlog;
use fb_model\fb_model\ContactlogQuery as ChildContactlogQuery;
use fb_model\fb_model\Map\ContactlogTableMap;

/**
 * Base class that represents a query for the 'fb_contactlog' table.
 *
 *
 *
 * @method     ChildContactlogQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildContactlogQuery orderByPersoonId($order = Criteria::ASC) Order by the persoon_id column
 * @method     ChildContactlogQuery orderByTekst($order = Criteria::ASC) Order by the tekst column
 * @method     ChildContactlogQuery orderByDatumGemaakt($order = Criteria::ASC) Order by the gemaakt_datum column
 * @method     ChildContactlogQuery orderByGemaaktDoor($order = Criteria::ASC) Order by the gemaakt_door column
 * @method     ChildContactlogQuery orderByDatumGewijzigd($order = Criteria::ASC) Order by the gewijzigd_datum column
 * @method     ChildContactlogQuery orderByGewijzigdDoor($order = Criteria::ASC) Order by the gewijzigd_door column
 *
 * @method     ChildContactlogQuery groupById() Group by the id column
 * @method     ChildContactlogQuery groupByPersoonId() Group by the persoon_id column
 * @method     ChildContactlogQuery groupByTekst() Group by the tekst column
 * @method     ChildContactlogQuery groupByDatumGemaakt() Group by the gemaakt_datum column
 * @method     ChildContactlogQuery groupByGemaaktDoor() Group by the gemaakt_door column
 * @method     ChildContactlogQuery groupByDatumGewijzigd() Group by the gewijzigd_datum column
 * @method     ChildContactlogQuery groupByGewijzigdDoor() Group by the gewijzigd_door column
 *
 * @method     ChildContactlogQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildContactlogQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildContactlogQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildContactlogQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildContactlogQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildContactlogQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildContactlogQuery leftJoinPersoon($relationAlias = null) Adds a LEFT JOIN clause to the query using the Persoon relation
 * @method     ChildContactlogQuery rightJoinPersoon($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Persoon relation
 * @method     ChildContactlogQuery innerJoinPersoon($relationAlias = null) Adds a INNER JOIN clause to the query using the Persoon relation
 *
 * @method     ChildContactlogQuery joinWithPersoon($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Persoon relation
 *
 * @method     ChildContactlogQuery leftJoinWithPersoon() Adds a LEFT JOIN clause and with to the query using the Persoon relation
 * @method     ChildContactlogQuery rightJoinWithPersoon() Adds a RIGHT JOIN clause and with to the query using the Persoon relation
 * @method     ChildContactlogQuery innerJoinWithPersoon() Adds a INNER JOIN clause and with to the query using the Persoon relation
 *
 * @method     \fb_model\fb_model\PersoonQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildContactlog findOne(ConnectionInterface $con = null) Return the first ChildContactlog matching the query
 * @method     ChildContactlog findOneOrCreate(ConnectionInterface $con = null) Return the first ChildContactlog matching the query, or a new ChildContactlog object populated from the query conditions when no match is found
 *
 * @method     ChildContactlog findOneById(int $id) Return the first ChildContactlog filtered by the id column
 * @method     ChildContactlog findOneByPersoonId(int $persoon_id) Return the first ChildContactlog filtered by the persoon_id column
 * @method     ChildContactlog findOneByTekst(string $tekst) Return the first ChildContactlog filtered by the tekst column
 * @method     ChildContactlog findOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildContactlog filtered by the gemaakt_datum column
 * @method     ChildContactlog findOneByGemaaktDoor(string $gemaakt_door) Return the first ChildContactlog filtered by the gemaakt_door column
 * @method     ChildContactlog findOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildContactlog filtered by the gewijzigd_datum column
 * @method     ChildContactlog findOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildContactlog filtered by the gewijzigd_door column *

 * @method     ChildContactlog requirePk($key, ConnectionInterface $con = null) Return the ChildContactlog by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContactlog requireOne(ConnectionInterface $con = null) Return the first ChildContactlog matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildContactlog requireOneById(int $id) Return the first ChildContactlog filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContactlog requireOneByPersoonId(int $persoon_id) Return the first ChildContactlog filtered by the persoon_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContactlog requireOneByTekst(string $tekst) Return the first ChildContactlog filtered by the tekst column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContactlog requireOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildContactlog filtered by the gemaakt_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContactlog requireOneByGemaaktDoor(string $gemaakt_door) Return the first ChildContactlog filtered by the gemaakt_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContactlog requireOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildContactlog filtered by the gewijzigd_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContactlog requireOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildContactlog filtered by the gewijzigd_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildContactlog[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildContactlog objects based on current ModelCriteria
 * @method     ChildContactlog[]|ObjectCollection findById(int $id) Return ChildContactlog objects filtered by the id column
 * @method     ChildContactlog[]|ObjectCollection findByPersoonId(int $persoon_id) Return ChildContactlog objects filtered by the persoon_id column
 * @method     ChildContactlog[]|ObjectCollection findByTekst(string $tekst) Return ChildContactlog objects filtered by the tekst column
 * @method     ChildContactlog[]|ObjectCollection findByDatumGemaakt(string $gemaakt_datum) Return ChildContactlog objects filtered by the gemaakt_datum column
 * @method     ChildContactlog[]|ObjectCollection findByGemaaktDoor(string $gemaakt_door) Return ChildContactlog objects filtered by the gemaakt_door column
 * @method     ChildContactlog[]|ObjectCollection findByDatumGewijzigd(string $gewijzigd_datum) Return ChildContactlog objects filtered by the gewijzigd_datum column
 * @method     ChildContactlog[]|ObjectCollection findByGewijzigdDoor(string $gewijzigd_door) Return ChildContactlog objects filtered by the gewijzigd_door column
 * @method     ChildContactlog[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ContactlogQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \fb_model\fb_model\Base\ContactlogQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\fb_model\\fb_model\\Contactlog', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildContactlogQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildContactlogQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildContactlogQuery) {
            return $criteria;
        }
        $query = new ChildContactlogQuery();
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
     * @return ChildContactlog|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ContactlogTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ContactlogTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildContactlog A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, persoon_id, tekst, gemaakt_datum, gemaakt_door, gewijzigd_datum, gewijzigd_door FROM fb_contactlog WHERE id = :p0';
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
            /** @var ChildContactlog $obj */
            $obj = new ChildContactlog();
            $obj->hydrate($row);
            ContactlogTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildContactlog|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildContactlogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ContactlogTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildContactlogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ContactlogTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildContactlogQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ContactlogTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ContactlogTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContactlogTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildContactlogQuery The current query, for fluid interface
     */
    public function filterByPersoonId($persoonId = null, $comparison = null)
    {
        if (is_array($persoonId)) {
            $useMinMax = false;
            if (isset($persoonId['min'])) {
                $this->addUsingAlias(ContactlogTableMap::COL_PERSOON_ID, $persoonId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($persoonId['max'])) {
                $this->addUsingAlias(ContactlogTableMap::COL_PERSOON_ID, $persoonId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContactlogTableMap::COL_PERSOON_ID, $persoonId, $comparison);
    }

    /**
     * Filter the query on the tekst column
     *
     * Example usage:
     * <code>
     * $query->filterByTekst('fooValue');   // WHERE tekst = 'fooValue'
     * $query->filterByTekst('%fooValue%', Criteria::LIKE); // WHERE tekst LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tekst The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContactlogQuery The current query, for fluid interface
     */
    public function filterByTekst($tekst = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tekst)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContactlogTableMap::COL_TEKST, $tekst, $comparison);
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
     * @return $this|ChildContactlogQuery The current query, for fluid interface
     */
    public function filterByDatumGemaakt($datumGemaakt = null, $comparison = null)
    {
        if (is_array($datumGemaakt)) {
            $useMinMax = false;
            if (isset($datumGemaakt['min'])) {
                $this->addUsingAlias(ContactlogTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGemaakt['max'])) {
                $this->addUsingAlias(ContactlogTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContactlogTableMap::COL_GEMAAKT_DATUM, $datumGemaakt, $comparison);
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
     * @return $this|ChildContactlogQuery The current query, for fluid interface
     */
    public function filterByGemaaktDoor($gemaaktDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gemaaktDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContactlogTableMap::COL_GEMAAKT_DOOR, $gemaaktDoor, $comparison);
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
     * @return $this|ChildContactlogQuery The current query, for fluid interface
     */
    public function filterByDatumGewijzigd($datumGewijzigd = null, $comparison = null)
    {
        if (is_array($datumGewijzigd)) {
            $useMinMax = false;
            if (isset($datumGewijzigd['min'])) {
                $this->addUsingAlias(ContactlogTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGewijzigd['max'])) {
                $this->addUsingAlias(ContactlogTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContactlogTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd, $comparison);
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
     * @return $this|ChildContactlogQuery The current query, for fluid interface
     */
    public function filterByGewijzigdDoor($gewijzigdDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gewijzigdDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContactlogTableMap::COL_GEWIJZIGD_DOOR, $gewijzigdDoor, $comparison);
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Persoon object
     *
     * @param \fb_model\fb_model\Persoon|ObjectCollection $persoon The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildContactlogQuery The current query, for fluid interface
     */
    public function filterByPersoon($persoon, $comparison = null)
    {
        if ($persoon instanceof \fb_model\fb_model\Persoon) {
            return $this
                ->addUsingAlias(ContactlogTableMap::COL_PERSOON_ID, $persoon->getId(), $comparison);
        } elseif ($persoon instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ContactlogTableMap::COL_PERSOON_ID, $persoon->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildContactlogQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildContactlog $contactlog Object to remove from the list of results
     *
     * @return $this|ChildContactlogQuery The current query, for fluid interface
     */
    public function prune($contactlog = null)
    {
        if ($contactlog) {
            $this->addUsingAlias(ContactlogTableMap::COL_ID, $contactlog->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fb_contactlog table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ContactlogTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ContactlogTableMap::clearInstancePool();
            ContactlogTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ContactlogTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ContactlogTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ContactlogTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ContactlogTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildContactlogQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(ContactlogTableMap::COL_GEWIJZIGD_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildContactlogQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(ContactlogTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildContactlogQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(ContactlogTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildContactlogQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(ContactlogTableMap::COL_GEMAAKT_DATUM);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildContactlogQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(ContactlogTableMap::COL_GEMAAKT_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildContactlogQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(ContactlogTableMap::COL_GEMAAKT_DATUM);
    }

} // ContactlogQuery
