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
use fb_model\fb_model\EvenementHeeftOptie as ChildEvenementHeeftOptie;
use fb_model\fb_model\EvenementHeeftOptieQuery as ChildEvenementHeeftOptieQuery;
use fb_model\fb_model\Map\EvenementHeeftOptieTableMap;

/**
 * Base class that represents a query for the 'fb_evenement_heeft_optie' table.
 *
 *
 *
 * @method     ChildEvenementHeeftOptieQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildEvenementHeeftOptieQuery orderByEvenementId($order = Criteria::ASC) Order by the evenement_id column
 * @method     ChildEvenementHeeftOptieQuery orderByOptieId($order = Criteria::ASC) Order by the optie_id column
 * @method     ChildEvenementHeeftOptieQuery orderByVolgorde($order = Criteria::ASC) Order by the volgorde column
 * @method     ChildEvenementHeeftOptieQuery orderByDatumGemaakt($order = Criteria::ASC) Order by the gemaakt_datum column
 * @method     ChildEvenementHeeftOptieQuery orderByGemaaktDoor($order = Criteria::ASC) Order by the gemaakt_door column
 * @method     ChildEvenementHeeftOptieQuery orderByDatumGewijzigd($order = Criteria::ASC) Order by the gewijzigd_datum column
 * @method     ChildEvenementHeeftOptieQuery orderByGewijzigdDoor($order = Criteria::ASC) Order by the gewijzigd_door column
 *
 * @method     ChildEvenementHeeftOptieQuery groupById() Group by the id column
 * @method     ChildEvenementHeeftOptieQuery groupByEvenementId() Group by the evenement_id column
 * @method     ChildEvenementHeeftOptieQuery groupByOptieId() Group by the optie_id column
 * @method     ChildEvenementHeeftOptieQuery groupByVolgorde() Group by the volgorde column
 * @method     ChildEvenementHeeftOptieQuery groupByDatumGemaakt() Group by the gemaakt_datum column
 * @method     ChildEvenementHeeftOptieQuery groupByGemaaktDoor() Group by the gemaakt_door column
 * @method     ChildEvenementHeeftOptieQuery groupByDatumGewijzigd() Group by the gewijzigd_datum column
 * @method     ChildEvenementHeeftOptieQuery groupByGewijzigdDoor() Group by the gewijzigd_door column
 *
 * @method     ChildEvenementHeeftOptieQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildEvenementHeeftOptieQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildEvenementHeeftOptieQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildEvenementHeeftOptieQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildEvenementHeeftOptieQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildEvenementHeeftOptieQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildEvenementHeeftOptieQuery leftJoinEvenement($relationAlias = null) Adds a LEFT JOIN clause to the query using the Evenement relation
 * @method     ChildEvenementHeeftOptieQuery rightJoinEvenement($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Evenement relation
 * @method     ChildEvenementHeeftOptieQuery innerJoinEvenement($relationAlias = null) Adds a INNER JOIN clause to the query using the Evenement relation
 *
 * @method     ChildEvenementHeeftOptieQuery joinWithEvenement($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Evenement relation
 *
 * @method     ChildEvenementHeeftOptieQuery leftJoinWithEvenement() Adds a LEFT JOIN clause and with to the query using the Evenement relation
 * @method     ChildEvenementHeeftOptieQuery rightJoinWithEvenement() Adds a RIGHT JOIN clause and with to the query using the Evenement relation
 * @method     ChildEvenementHeeftOptieQuery innerJoinWithEvenement() Adds a INNER JOIN clause and with to the query using the Evenement relation
 *
 * @method     ChildEvenementHeeftOptieQuery leftJoinOptie($relationAlias = null) Adds a LEFT JOIN clause to the query using the Optie relation
 * @method     ChildEvenementHeeftOptieQuery rightJoinOptie($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Optie relation
 * @method     ChildEvenementHeeftOptieQuery innerJoinOptie($relationAlias = null) Adds a INNER JOIN clause to the query using the Optie relation
 *
 * @method     ChildEvenementHeeftOptieQuery joinWithOptie($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Optie relation
 *
 * @method     ChildEvenementHeeftOptieQuery leftJoinWithOptie() Adds a LEFT JOIN clause and with to the query using the Optie relation
 * @method     ChildEvenementHeeftOptieQuery rightJoinWithOptie() Adds a RIGHT JOIN clause and with to the query using the Optie relation
 * @method     ChildEvenementHeeftOptieQuery innerJoinWithOptie() Adds a INNER JOIN clause and with to the query using the Optie relation
 *
 * @method     \fb_model\fb_model\EvenementQuery|\fb_model\fb_model\OptieQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildEvenementHeeftOptie findOne(ConnectionInterface $con = null) Return the first ChildEvenementHeeftOptie matching the query
 * @method     ChildEvenementHeeftOptie findOneOrCreate(ConnectionInterface $con = null) Return the first ChildEvenementHeeftOptie matching the query, or a new ChildEvenementHeeftOptie object populated from the query conditions when no match is found
 *
 * @method     ChildEvenementHeeftOptie findOneById(int $id) Return the first ChildEvenementHeeftOptie filtered by the id column
 * @method     ChildEvenementHeeftOptie findOneByEvenementId(int $evenement_id) Return the first ChildEvenementHeeftOptie filtered by the evenement_id column
 * @method     ChildEvenementHeeftOptie findOneByOptieId(int $optie_id) Return the first ChildEvenementHeeftOptie filtered by the optie_id column
 * @method     ChildEvenementHeeftOptie findOneByVolgorde(int $volgorde) Return the first ChildEvenementHeeftOptie filtered by the volgorde column
 * @method     ChildEvenementHeeftOptie findOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildEvenementHeeftOptie filtered by the gemaakt_datum column
 * @method     ChildEvenementHeeftOptie findOneByGemaaktDoor(string $gemaakt_door) Return the first ChildEvenementHeeftOptie filtered by the gemaakt_door column
 * @method     ChildEvenementHeeftOptie findOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildEvenementHeeftOptie filtered by the gewijzigd_datum column
 * @method     ChildEvenementHeeftOptie findOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildEvenementHeeftOptie filtered by the gewijzigd_door column *

 * @method     ChildEvenementHeeftOptie requirePk($key, ConnectionInterface $con = null) Return the ChildEvenementHeeftOptie by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenementHeeftOptie requireOne(ConnectionInterface $con = null) Return the first ChildEvenementHeeftOptie matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEvenementHeeftOptie requireOneById(int $id) Return the first ChildEvenementHeeftOptie filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenementHeeftOptie requireOneByEvenementId(int $evenement_id) Return the first ChildEvenementHeeftOptie filtered by the evenement_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenementHeeftOptie requireOneByOptieId(int $optie_id) Return the first ChildEvenementHeeftOptie filtered by the optie_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenementHeeftOptie requireOneByVolgorde(int $volgorde) Return the first ChildEvenementHeeftOptie filtered by the volgorde column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenementHeeftOptie requireOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildEvenementHeeftOptie filtered by the gemaakt_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenementHeeftOptie requireOneByGemaaktDoor(string $gemaakt_door) Return the first ChildEvenementHeeftOptie filtered by the gemaakt_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenementHeeftOptie requireOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildEvenementHeeftOptie filtered by the gewijzigd_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenementHeeftOptie requireOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildEvenementHeeftOptie filtered by the gewijzigd_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEvenementHeeftOptie[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildEvenementHeeftOptie objects based on current ModelCriteria
 * @method     ChildEvenementHeeftOptie[]|ObjectCollection findById(int $id) Return ChildEvenementHeeftOptie objects filtered by the id column
 * @method     ChildEvenementHeeftOptie[]|ObjectCollection findByEvenementId(int $evenement_id) Return ChildEvenementHeeftOptie objects filtered by the evenement_id column
 * @method     ChildEvenementHeeftOptie[]|ObjectCollection findByOptieId(int $optie_id) Return ChildEvenementHeeftOptie objects filtered by the optie_id column
 * @method     ChildEvenementHeeftOptie[]|ObjectCollection findByVolgorde(int $volgorde) Return ChildEvenementHeeftOptie objects filtered by the volgorde column
 * @method     ChildEvenementHeeftOptie[]|ObjectCollection findByDatumGemaakt(string $gemaakt_datum) Return ChildEvenementHeeftOptie objects filtered by the gemaakt_datum column
 * @method     ChildEvenementHeeftOptie[]|ObjectCollection findByGemaaktDoor(string $gemaakt_door) Return ChildEvenementHeeftOptie objects filtered by the gemaakt_door column
 * @method     ChildEvenementHeeftOptie[]|ObjectCollection findByDatumGewijzigd(string $gewijzigd_datum) Return ChildEvenementHeeftOptie objects filtered by the gewijzigd_datum column
 * @method     ChildEvenementHeeftOptie[]|ObjectCollection findByGewijzigdDoor(string $gewijzigd_door) Return ChildEvenementHeeftOptie objects filtered by the gewijzigd_door column
 * @method     ChildEvenementHeeftOptie[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class EvenementHeeftOptieQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \fb_model\fb_model\Base\EvenementHeeftOptieQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\fb_model\\fb_model\\EvenementHeeftOptie', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildEvenementHeeftOptieQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildEvenementHeeftOptieQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildEvenementHeeftOptieQuery) {
            return $criteria;
        }
        $query = new ChildEvenementHeeftOptieQuery();
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
     * @param array[$id, $evenement_id, $optie_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildEvenementHeeftOptie|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EvenementHeeftOptieTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = EvenementHeeftOptieTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])]))))) {
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
     * @return ChildEvenementHeeftOptie A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, evenement_id, optie_id, volgorde, gemaakt_datum, gemaakt_door, gewijzigd_datum, gewijzigd_door FROM fb_evenement_heeft_optie WHERE id = :p0 AND evenement_id = :p1 AND optie_id = :p2';
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
            /** @var ChildEvenementHeeftOptie $obj */
            $obj = new ChildEvenementHeeftOptie();
            $obj->hydrate($row);
            EvenementHeeftOptieTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])]));
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
     * @return ChildEvenementHeeftOptie|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildEvenementHeeftOptieQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(EvenementHeeftOptieTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(EvenementHeeftOptieTableMap::COL_EVENEMENT_ID, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(EvenementHeeftOptieTableMap::COL_OPTIE_ID, $key[2], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildEvenementHeeftOptieQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(EvenementHeeftOptieTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(EvenementHeeftOptieTableMap::COL_EVENEMENT_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(EvenementHeeftOptieTableMap::COL_OPTIE_ID, $key[2], Criteria::EQUAL);
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
     * @return $this|ChildEvenementHeeftOptieQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(EvenementHeeftOptieTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(EvenementHeeftOptieTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementHeeftOptieTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildEvenementHeeftOptieQuery The current query, for fluid interface
     */
    public function filterByEvenementId($evenementId = null, $comparison = null)
    {
        if (is_array($evenementId)) {
            $useMinMax = false;
            if (isset($evenementId['min'])) {
                $this->addUsingAlias(EvenementHeeftOptieTableMap::COL_EVENEMENT_ID, $evenementId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($evenementId['max'])) {
                $this->addUsingAlias(EvenementHeeftOptieTableMap::COL_EVENEMENT_ID, $evenementId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementHeeftOptieTableMap::COL_EVENEMENT_ID, $evenementId, $comparison);
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
     * @return $this|ChildEvenementHeeftOptieQuery The current query, for fluid interface
     */
    public function filterByOptieId($optieId = null, $comparison = null)
    {
        if (is_array($optieId)) {
            $useMinMax = false;
            if (isset($optieId['min'])) {
                $this->addUsingAlias(EvenementHeeftOptieTableMap::COL_OPTIE_ID, $optieId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($optieId['max'])) {
                $this->addUsingAlias(EvenementHeeftOptieTableMap::COL_OPTIE_ID, $optieId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementHeeftOptieTableMap::COL_OPTIE_ID, $optieId, $comparison);
    }

    /**
     * Filter the query on the volgorde column
     *
     * Example usage:
     * <code>
     * $query->filterByVolgorde(1234); // WHERE volgorde = 1234
     * $query->filterByVolgorde(array(12, 34)); // WHERE volgorde IN (12, 34)
     * $query->filterByVolgorde(array('min' => 12)); // WHERE volgorde > 12
     * </code>
     *
     * @param     mixed $volgorde The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEvenementHeeftOptieQuery The current query, for fluid interface
     */
    public function filterByVolgorde($volgorde = null, $comparison = null)
    {
        if (is_array($volgorde)) {
            $useMinMax = false;
            if (isset($volgorde['min'])) {
                $this->addUsingAlias(EvenementHeeftOptieTableMap::COL_VOLGORDE, $volgorde['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($volgorde['max'])) {
                $this->addUsingAlias(EvenementHeeftOptieTableMap::COL_VOLGORDE, $volgorde['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementHeeftOptieTableMap::COL_VOLGORDE, $volgorde, $comparison);
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
     * @return $this|ChildEvenementHeeftOptieQuery The current query, for fluid interface
     */
    public function filterByDatumGemaakt($datumGemaakt = null, $comparison = null)
    {
        if (is_array($datumGemaakt)) {
            $useMinMax = false;
            if (isset($datumGemaakt['min'])) {
                $this->addUsingAlias(EvenementHeeftOptieTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGemaakt['max'])) {
                $this->addUsingAlias(EvenementHeeftOptieTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementHeeftOptieTableMap::COL_GEMAAKT_DATUM, $datumGemaakt, $comparison);
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
     * @return $this|ChildEvenementHeeftOptieQuery The current query, for fluid interface
     */
    public function filterByGemaaktDoor($gemaaktDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gemaaktDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementHeeftOptieTableMap::COL_GEMAAKT_DOOR, $gemaaktDoor, $comparison);
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
     * @return $this|ChildEvenementHeeftOptieQuery The current query, for fluid interface
     */
    public function filterByDatumGewijzigd($datumGewijzigd = null, $comparison = null)
    {
        if (is_array($datumGewijzigd)) {
            $useMinMax = false;
            if (isset($datumGewijzigd['min'])) {
                $this->addUsingAlias(EvenementHeeftOptieTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGewijzigd['max'])) {
                $this->addUsingAlias(EvenementHeeftOptieTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementHeeftOptieTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd, $comparison);
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
     * @return $this|ChildEvenementHeeftOptieQuery The current query, for fluid interface
     */
    public function filterByGewijzigdDoor($gewijzigdDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gewijzigdDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementHeeftOptieTableMap::COL_GEWIJZIGD_DOOR, $gewijzigdDoor, $comparison);
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Evenement object
     *
     * @param \fb_model\fb_model\Evenement|ObjectCollection $evenement The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildEvenementHeeftOptieQuery The current query, for fluid interface
     */
    public function filterByEvenement($evenement, $comparison = null)
    {
        if ($evenement instanceof \fb_model\fb_model\Evenement) {
            return $this
                ->addUsingAlias(EvenementHeeftOptieTableMap::COL_EVENEMENT_ID, $evenement->getId(), $comparison);
        } elseif ($evenement instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(EvenementHeeftOptieTableMap::COL_EVENEMENT_ID, $evenement->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildEvenementHeeftOptieQuery The current query, for fluid interface
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
     * Filter the query by a related \fb_model\fb_model\Optie object
     *
     * @param \fb_model\fb_model\Optie|ObjectCollection $optie The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildEvenementHeeftOptieQuery The current query, for fluid interface
     */
    public function filterByOptie($optie, $comparison = null)
    {
        if ($optie instanceof \fb_model\fb_model\Optie) {
            return $this
                ->addUsingAlias(EvenementHeeftOptieTableMap::COL_OPTIE_ID, $optie->getId(), $comparison);
        } elseif ($optie instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(EvenementHeeftOptieTableMap::COL_OPTIE_ID, $optie->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildEvenementHeeftOptieQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildEvenementHeeftOptie $evenementHeeftOptie Object to remove from the list of results
     *
     * @return $this|ChildEvenementHeeftOptieQuery The current query, for fluid interface
     */
    public function prune($evenementHeeftOptie = null)
    {
        if ($evenementHeeftOptie) {
            $this->addCond('pruneCond0', $this->getAliasedColName(EvenementHeeftOptieTableMap::COL_ID), $evenementHeeftOptie->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(EvenementHeeftOptieTableMap::COL_EVENEMENT_ID), $evenementHeeftOptie->getEvenementId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(EvenementHeeftOptieTableMap::COL_OPTIE_ID), $evenementHeeftOptie->getOptieId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fb_evenement_heeft_optie table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EvenementHeeftOptieTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            EvenementHeeftOptieTableMap::clearInstancePool();
            EvenementHeeftOptieTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(EvenementHeeftOptieTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(EvenementHeeftOptieTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            EvenementHeeftOptieTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            EvenementHeeftOptieTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildEvenementHeeftOptieQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(EvenementHeeftOptieTableMap::COL_GEWIJZIGD_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildEvenementHeeftOptieQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(EvenementHeeftOptieTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildEvenementHeeftOptieQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(EvenementHeeftOptieTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildEvenementHeeftOptieQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(EvenementHeeftOptieTableMap::COL_GEMAAKT_DATUM);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildEvenementHeeftOptieQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(EvenementHeeftOptieTableMap::COL_GEMAAKT_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildEvenementHeeftOptieQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(EvenementHeeftOptieTableMap::COL_GEMAAKT_DATUM);
    }

} // EvenementHeeftOptieQuery
