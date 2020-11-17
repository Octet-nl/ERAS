<?php

namespace fb_model\fb_model\Base;

use \Exception;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use fb_model\fb_model\System as ChildSystem;
use fb_model\fb_model\SystemQuery as ChildSystemQuery;
use fb_model\fb_model\Map\SystemTableMap;

/**
 * Base class that represents a query for the 'fb_system' table.
 *
 *
 *
 * @method     ChildSystemQuery orderByNaam($order = Criteria::ASC) Order by the naam column
 * @method     ChildSystemQuery orderByVersionMajor($order = Criteria::ASC) Order by the version_major column
 * @method     ChildSystemQuery orderByVersionMinor($order = Criteria::ASC) Order by the version_minor column
 * @method     ChildSystemQuery orderByOtap($order = Criteria::ASC) Order by the otap column
 * @method     ChildSystemQuery orderByDebug($order = Criteria::ASC) Order by the debug column
 * @method     ChildSystemQuery orderByDeployDirectory($order = Criteria::ASC) Order by the deploy_directory column
 * @method     ChildSystemQuery orderByDbVersionMajor($order = Criteria::ASC) Order by the db_version_major column
 * @method     ChildSystemQuery orderByDbVersionMinor($order = Criteria::ASC) Order by the db_version_minor column
 * @method     ChildSystemQuery orderByDatumGemaakt($order = Criteria::ASC) Order by the gemaakt_datum column
 * @method     ChildSystemQuery orderByGemaaktDoor($order = Criteria::ASC) Order by the gemaakt_door column
 * @method     ChildSystemQuery orderByDatumGewijzigd($order = Criteria::ASC) Order by the gewijzigd_datum column
 * @method     ChildSystemQuery orderByGewijzigdDoor($order = Criteria::ASC) Order by the gewijzigd_door column
 *
 * @method     ChildSystemQuery groupByNaam() Group by the naam column
 * @method     ChildSystemQuery groupByVersionMajor() Group by the version_major column
 * @method     ChildSystemQuery groupByVersionMinor() Group by the version_minor column
 * @method     ChildSystemQuery groupByOtap() Group by the otap column
 * @method     ChildSystemQuery groupByDebug() Group by the debug column
 * @method     ChildSystemQuery groupByDeployDirectory() Group by the deploy_directory column
 * @method     ChildSystemQuery groupByDbVersionMajor() Group by the db_version_major column
 * @method     ChildSystemQuery groupByDbVersionMinor() Group by the db_version_minor column
 * @method     ChildSystemQuery groupByDatumGemaakt() Group by the gemaakt_datum column
 * @method     ChildSystemQuery groupByGemaaktDoor() Group by the gemaakt_door column
 * @method     ChildSystemQuery groupByDatumGewijzigd() Group by the gewijzigd_datum column
 * @method     ChildSystemQuery groupByGewijzigdDoor() Group by the gewijzigd_door column
 *
 * @method     ChildSystemQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSystemQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSystemQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSystemQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSystemQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSystemQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSystem findOne(ConnectionInterface $con = null) Return the first ChildSystem matching the query
 * @method     ChildSystem findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSystem matching the query, or a new ChildSystem object populated from the query conditions when no match is found
 *
 * @method     ChildSystem findOneByNaam(string $naam) Return the first ChildSystem filtered by the naam column
 * @method     ChildSystem findOneByVersionMajor(string $version_major) Return the first ChildSystem filtered by the version_major column
 * @method     ChildSystem findOneByVersionMinor(string $version_minor) Return the first ChildSystem filtered by the version_minor column
 * @method     ChildSystem findOneByOtap(int $otap) Return the first ChildSystem filtered by the otap column
 * @method     ChildSystem findOneByDebug(int $debug) Return the first ChildSystem filtered by the debug column
 * @method     ChildSystem findOneByDeployDirectory(string $deploy_directory) Return the first ChildSystem filtered by the deploy_directory column
 * @method     ChildSystem findOneByDbVersionMajor(string $db_version_major) Return the first ChildSystem filtered by the db_version_major column
 * @method     ChildSystem findOneByDbVersionMinor(string $db_version_minor) Return the first ChildSystem filtered by the db_version_minor column
 * @method     ChildSystem findOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildSystem filtered by the gemaakt_datum column
 * @method     ChildSystem findOneByGemaaktDoor(string $gemaakt_door) Return the first ChildSystem filtered by the gemaakt_door column
 * @method     ChildSystem findOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildSystem filtered by the gewijzigd_datum column
 * @method     ChildSystem findOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildSystem filtered by the gewijzigd_door column *

 * @method     ChildSystem requirePk($key, ConnectionInterface $con = null) Return the ChildSystem by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSystem requireOne(ConnectionInterface $con = null) Return the first ChildSystem matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSystem requireOneByNaam(string $naam) Return the first ChildSystem filtered by the naam column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSystem requireOneByVersionMajor(string $version_major) Return the first ChildSystem filtered by the version_major column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSystem requireOneByVersionMinor(string $version_minor) Return the first ChildSystem filtered by the version_minor column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSystem requireOneByOtap(int $otap) Return the first ChildSystem filtered by the otap column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSystem requireOneByDebug(int $debug) Return the first ChildSystem filtered by the debug column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSystem requireOneByDeployDirectory(string $deploy_directory) Return the first ChildSystem filtered by the deploy_directory column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSystem requireOneByDbVersionMajor(string $db_version_major) Return the first ChildSystem filtered by the db_version_major column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSystem requireOneByDbVersionMinor(string $db_version_minor) Return the first ChildSystem filtered by the db_version_minor column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSystem requireOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildSystem filtered by the gemaakt_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSystem requireOneByGemaaktDoor(string $gemaakt_door) Return the first ChildSystem filtered by the gemaakt_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSystem requireOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildSystem filtered by the gewijzigd_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSystem requireOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildSystem filtered by the gewijzigd_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSystem[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSystem objects based on current ModelCriteria
 * @method     ChildSystem[]|ObjectCollection findByNaam(string $naam) Return ChildSystem objects filtered by the naam column
 * @method     ChildSystem[]|ObjectCollection findByVersionMajor(string $version_major) Return ChildSystem objects filtered by the version_major column
 * @method     ChildSystem[]|ObjectCollection findByVersionMinor(string $version_minor) Return ChildSystem objects filtered by the version_minor column
 * @method     ChildSystem[]|ObjectCollection findByOtap(int $otap) Return ChildSystem objects filtered by the otap column
 * @method     ChildSystem[]|ObjectCollection findByDebug(int $debug) Return ChildSystem objects filtered by the debug column
 * @method     ChildSystem[]|ObjectCollection findByDeployDirectory(string $deploy_directory) Return ChildSystem objects filtered by the deploy_directory column
 * @method     ChildSystem[]|ObjectCollection findByDbVersionMajor(string $db_version_major) Return ChildSystem objects filtered by the db_version_major column
 * @method     ChildSystem[]|ObjectCollection findByDbVersionMinor(string $db_version_minor) Return ChildSystem objects filtered by the db_version_minor column
 * @method     ChildSystem[]|ObjectCollection findByDatumGemaakt(string $gemaakt_datum) Return ChildSystem objects filtered by the gemaakt_datum column
 * @method     ChildSystem[]|ObjectCollection findByGemaaktDoor(string $gemaakt_door) Return ChildSystem objects filtered by the gemaakt_door column
 * @method     ChildSystem[]|ObjectCollection findByDatumGewijzigd(string $gewijzigd_datum) Return ChildSystem objects filtered by the gewijzigd_datum column
 * @method     ChildSystem[]|ObjectCollection findByGewijzigdDoor(string $gewijzigd_door) Return ChildSystem objects filtered by the gewijzigd_door column
 * @method     ChildSystem[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SystemQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \fb_model\fb_model\Base\SystemQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\fb_model\\fb_model\\System', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSystemQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSystemQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSystemQuery) {
            return $criteria;
        }
        $query = new ChildSystemQuery();
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
     * @return ChildSystem|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        throw new LogicException('The System object has no primary key');
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
        throw new LogicException('The System object has no primary key');
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildSystemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        throw new LogicException('The System object has no primary key');
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSystemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        throw new LogicException('The System object has no primary key');
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
     * @return $this|ChildSystemQuery The current query, for fluid interface
     */
    public function filterByNaam($naam = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($naam)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SystemTableMap::COL_NAAM, $naam, $comparison);
    }

    /**
     * Filter the query on the version_major column
     *
     * Example usage:
     * <code>
     * $query->filterByVersionMajor('fooValue');   // WHERE version_major = 'fooValue'
     * $query->filterByVersionMajor('%fooValue%', Criteria::LIKE); // WHERE version_major LIKE '%fooValue%'
     * </code>
     *
     * @param     string $versionMajor The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSystemQuery The current query, for fluid interface
     */
    public function filterByVersionMajor($versionMajor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($versionMajor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SystemTableMap::COL_VERSION_MAJOR, $versionMajor, $comparison);
    }

    /**
     * Filter the query on the version_minor column
     *
     * Example usage:
     * <code>
     * $query->filterByVersionMinor('fooValue');   // WHERE version_minor = 'fooValue'
     * $query->filterByVersionMinor('%fooValue%', Criteria::LIKE); // WHERE version_minor LIKE '%fooValue%'
     * </code>
     *
     * @param     string $versionMinor The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSystemQuery The current query, for fluid interface
     */
    public function filterByVersionMinor($versionMinor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($versionMinor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SystemTableMap::COL_VERSION_MINOR, $versionMinor, $comparison);
    }

    /**
     * Filter the query on the otap column
     *
     * Example usage:
     * <code>
     * $query->filterByOtap(1234); // WHERE otap = 1234
     * $query->filterByOtap(array(12, 34)); // WHERE otap IN (12, 34)
     * $query->filterByOtap(array('min' => 12)); // WHERE otap > 12
     * </code>
     *
     * @param     mixed $otap The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSystemQuery The current query, for fluid interface
     */
    public function filterByOtap($otap = null, $comparison = null)
    {
        if (is_array($otap)) {
            $useMinMax = false;
            if (isset($otap['min'])) {
                $this->addUsingAlias(SystemTableMap::COL_OTAP, $otap['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($otap['max'])) {
                $this->addUsingAlias(SystemTableMap::COL_OTAP, $otap['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SystemTableMap::COL_OTAP, $otap, $comparison);
    }

    /**
     * Filter the query on the debug column
     *
     * Example usage:
     * <code>
     * $query->filterByDebug(1234); // WHERE debug = 1234
     * $query->filterByDebug(array(12, 34)); // WHERE debug IN (12, 34)
     * $query->filterByDebug(array('min' => 12)); // WHERE debug > 12
     * </code>
     *
     * @param     mixed $debug The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSystemQuery The current query, for fluid interface
     */
    public function filterByDebug($debug = null, $comparison = null)
    {
        if (is_array($debug)) {
            $useMinMax = false;
            if (isset($debug['min'])) {
                $this->addUsingAlias(SystemTableMap::COL_DEBUG, $debug['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($debug['max'])) {
                $this->addUsingAlias(SystemTableMap::COL_DEBUG, $debug['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SystemTableMap::COL_DEBUG, $debug, $comparison);
    }

    /**
     * Filter the query on the deploy_directory column
     *
     * Example usage:
     * <code>
     * $query->filterByDeployDirectory('fooValue');   // WHERE deploy_directory = 'fooValue'
     * $query->filterByDeployDirectory('%fooValue%', Criteria::LIKE); // WHERE deploy_directory LIKE '%fooValue%'
     * </code>
     *
     * @param     string $deployDirectory The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSystemQuery The current query, for fluid interface
     */
    public function filterByDeployDirectory($deployDirectory = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($deployDirectory)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SystemTableMap::COL_DEPLOY_DIRECTORY, $deployDirectory, $comparison);
    }

    /**
     * Filter the query on the db_version_major column
     *
     * Example usage:
     * <code>
     * $query->filterByDbVersionMajor('fooValue');   // WHERE db_version_major = 'fooValue'
     * $query->filterByDbVersionMajor('%fooValue%', Criteria::LIKE); // WHERE db_version_major LIKE '%fooValue%'
     * </code>
     *
     * @param     string $dbVersionMajor The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSystemQuery The current query, for fluid interface
     */
    public function filterByDbVersionMajor($dbVersionMajor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($dbVersionMajor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SystemTableMap::COL_DB_VERSION_MAJOR, $dbVersionMajor, $comparison);
    }

    /**
     * Filter the query on the db_version_minor column
     *
     * Example usage:
     * <code>
     * $query->filterByDbVersionMinor('fooValue');   // WHERE db_version_minor = 'fooValue'
     * $query->filterByDbVersionMinor('%fooValue%', Criteria::LIKE); // WHERE db_version_minor LIKE '%fooValue%'
     * </code>
     *
     * @param     string $dbVersionMinor The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSystemQuery The current query, for fluid interface
     */
    public function filterByDbVersionMinor($dbVersionMinor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($dbVersionMinor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SystemTableMap::COL_DB_VERSION_MINOR, $dbVersionMinor, $comparison);
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
     * @return $this|ChildSystemQuery The current query, for fluid interface
     */
    public function filterByDatumGemaakt($datumGemaakt = null, $comparison = null)
    {
        if (is_array($datumGemaakt)) {
            $useMinMax = false;
            if (isset($datumGemaakt['min'])) {
                $this->addUsingAlias(SystemTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGemaakt['max'])) {
                $this->addUsingAlias(SystemTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SystemTableMap::COL_GEMAAKT_DATUM, $datumGemaakt, $comparison);
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
     * @return $this|ChildSystemQuery The current query, for fluid interface
     */
    public function filterByGemaaktDoor($gemaaktDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gemaaktDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SystemTableMap::COL_GEMAAKT_DOOR, $gemaaktDoor, $comparison);
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
     * @return $this|ChildSystemQuery The current query, for fluid interface
     */
    public function filterByDatumGewijzigd($datumGewijzigd = null, $comparison = null)
    {
        if (is_array($datumGewijzigd)) {
            $useMinMax = false;
            if (isset($datumGewijzigd['min'])) {
                $this->addUsingAlias(SystemTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGewijzigd['max'])) {
                $this->addUsingAlias(SystemTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SystemTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd, $comparison);
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
     * @return $this|ChildSystemQuery The current query, for fluid interface
     */
    public function filterByGewijzigdDoor($gewijzigdDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gewijzigdDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SystemTableMap::COL_GEWIJZIGD_DOOR, $gewijzigdDoor, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSystem $system Object to remove from the list of results
     *
     * @return $this|ChildSystemQuery The current query, for fluid interface
     */
    public function prune($system = null)
    {
        if ($system) {
            throw new LogicException('System object has no primary key');

        }

        return $this;
    }

    /**
     * Deletes all rows from the fb_system table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SystemTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SystemTableMap::clearInstancePool();
            SystemTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SystemTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SystemTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SystemTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SystemTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildSystemQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(SystemTableMap::COL_GEWIJZIGD_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildSystemQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(SystemTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildSystemQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(SystemTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildSystemQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(SystemTableMap::COL_GEMAAKT_DATUM);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildSystemQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(SystemTableMap::COL_GEMAAKT_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildSystemQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(SystemTableMap::COL_GEMAAKT_DATUM);
    }

} // SystemQuery
