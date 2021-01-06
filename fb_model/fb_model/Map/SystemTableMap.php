<?php

namespace fb_model\fb_model\Map;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use fb_model\fb_model\System;
use fb_model\fb_model\SystemQuery;


/**
 * This class defines the structure of the 'fb_system' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class SystemTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'fb_model.fb_model.Map.SystemTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'fb_system';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\fb_model\\fb_model\\System';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'fb_model.fb_model.System';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 12;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 12;

    /**
     * the column name for the naam field
     */
    const COL_NAAM = 'fb_system.naam';

    /**
     * the column name for the version_major field
     */
    const COL_VERSION_MAJOR = 'fb_system.version_major';

    /**
     * the column name for the version_minor field
     */
    const COL_VERSION_MINOR = 'fb_system.version_minor';

    /**
     * the column name for the valid field
     */
    const COL_VALID = 'fb_system.valid';

    /**
     * the column name for the debug field
     */
    const COL_DEBUG = 'fb_system.debug';

    /**
     * the column name for the deploy_directory field
     */
    const COL_DEPLOY_DIRECTORY = 'fb_system.deploy_directory';

    /**
     * the column name for the db_version_major field
     */
    const COL_DB_VERSION_MAJOR = 'fb_system.db_version_major';

    /**
     * the column name for the db_version_minor field
     */
    const COL_DB_VERSION_MINOR = 'fb_system.db_version_minor';

    /**
     * the column name for the gemaakt_datum field
     */
    const COL_GEMAAKT_DATUM = 'fb_system.gemaakt_datum';

    /**
     * the column name for the gemaakt_door field
     */
    const COL_GEMAAKT_DOOR = 'fb_system.gemaakt_door';

    /**
     * the column name for the gewijzigd_datum field
     */
    const COL_GEWIJZIGD_DATUM = 'fb_system.gewijzigd_datum';

    /**
     * the column name for the gewijzigd_door field
     */
    const COL_GEWIJZIGD_DOOR = 'fb_system.gewijzigd_door';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Naam', 'VersionMajor', 'VersionMinor', 'Valid', 'Debug', 'DeployDirectory', 'DbVersionMajor', 'DbVersionMinor', 'DatumGemaakt', 'GemaaktDoor', 'DatumGewijzigd', 'GewijzigdDoor', ),
        self::TYPE_CAMELNAME     => array('naam', 'versionMajor', 'versionMinor', 'valid', 'debug', 'deployDirectory', 'dbVersionMajor', 'dbVersionMinor', 'datumGemaakt', 'gemaaktDoor', 'datumGewijzigd', 'gewijzigdDoor', ),
        self::TYPE_COLNAME       => array(SystemTableMap::COL_NAAM, SystemTableMap::COL_VERSION_MAJOR, SystemTableMap::COL_VERSION_MINOR, SystemTableMap::COL_VALID, SystemTableMap::COL_DEBUG, SystemTableMap::COL_DEPLOY_DIRECTORY, SystemTableMap::COL_DB_VERSION_MAJOR, SystemTableMap::COL_DB_VERSION_MINOR, SystemTableMap::COL_GEMAAKT_DATUM, SystemTableMap::COL_GEMAAKT_DOOR, SystemTableMap::COL_GEWIJZIGD_DATUM, SystemTableMap::COL_GEWIJZIGD_DOOR, ),
        self::TYPE_FIELDNAME     => array('naam', 'version_major', 'version_minor', 'valid', 'debug', 'deploy_directory', 'db_version_major', 'db_version_minor', 'gemaakt_datum', 'gemaakt_door', 'gewijzigd_datum', 'gewijzigd_door', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Naam' => 0, 'VersionMajor' => 1, 'VersionMinor' => 2, 'Valid' => 3, 'Debug' => 4, 'DeployDirectory' => 5, 'DbVersionMajor' => 6, 'DbVersionMinor' => 7, 'DatumGemaakt' => 8, 'GemaaktDoor' => 9, 'DatumGewijzigd' => 10, 'GewijzigdDoor' => 11, ),
        self::TYPE_CAMELNAME     => array('naam' => 0, 'versionMajor' => 1, 'versionMinor' => 2, 'valid' => 3, 'debug' => 4, 'deployDirectory' => 5, 'dbVersionMajor' => 6, 'dbVersionMinor' => 7, 'datumGemaakt' => 8, 'gemaaktDoor' => 9, 'datumGewijzigd' => 10, 'gewijzigdDoor' => 11, ),
        self::TYPE_COLNAME       => array(SystemTableMap::COL_NAAM => 0, SystemTableMap::COL_VERSION_MAJOR => 1, SystemTableMap::COL_VERSION_MINOR => 2, SystemTableMap::COL_VALID => 3, SystemTableMap::COL_DEBUG => 4, SystemTableMap::COL_DEPLOY_DIRECTORY => 5, SystemTableMap::COL_DB_VERSION_MAJOR => 6, SystemTableMap::COL_DB_VERSION_MINOR => 7, SystemTableMap::COL_GEMAAKT_DATUM => 8, SystemTableMap::COL_GEMAAKT_DOOR => 9, SystemTableMap::COL_GEWIJZIGD_DATUM => 10, SystemTableMap::COL_GEWIJZIGD_DOOR => 11, ),
        self::TYPE_FIELDNAME     => array('naam' => 0, 'version_major' => 1, 'version_minor' => 2, 'valid' => 3, 'debug' => 4, 'deploy_directory' => 5, 'db_version_major' => 6, 'db_version_minor' => 7, 'gemaakt_datum' => 8, 'gemaakt_door' => 9, 'gewijzigd_datum' => 10, 'gewijzigd_door' => 11, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('fb_system');
        $this->setPhpName('System');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\fb_model\\fb_model\\System');
        $this->setPackage('fb_model.fb_model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addColumn('naam', 'Naam', 'VARCHAR', true, 255, null);
        $this->addColumn('version_major', 'VersionMajor', 'VARCHAR', true, 10, null);
        $this->addColumn('version_minor', 'VersionMinor', 'VARCHAR', true, 10, null);
        $this->addColumn('valid', 'Valid', 'INTEGER', true, 1, null);
        $this->addColumn('debug', 'Debug', 'INTEGER', true, 1, null);
        $this->addColumn('deploy_directory', 'DeployDirectory', 'VARCHAR', true, 255, null);
        $this->addColumn('db_version_major', 'DbVersionMajor', 'VARCHAR', true, 10, null);
        $this->addColumn('db_version_minor', 'DbVersionMinor', 'VARCHAR', true, 10, null);
        $this->addColumn('gemaakt_datum', 'DatumGemaakt', 'TIMESTAMP', true, null, null);
        $this->addColumn('gemaakt_door', 'GemaaktDoor', 'VARCHAR', true, 255, null);
        $this->addColumn('gewijzigd_datum', 'DatumGewijzigd', 'TIMESTAMP', true, null, null);
        $this->addColumn('gewijzigd_door', 'GewijzigdDoor', 'VARCHAR', true, 255, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'gemaakt_datum', 'update_column' => 'gewijzigd_datum', 'disable_created_at' => 'false', 'disable_updated_at' => 'false', ),
        );
    } // getBehaviors()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return null;
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return '';
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? SystemTableMap::CLASS_DEFAULT : SystemTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (System object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SystemTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SystemTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SystemTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SystemTableMap::OM_CLASS;
            /** @var System $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SystemTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = SystemTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SystemTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var System $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SystemTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(SystemTableMap::COL_NAAM);
            $criteria->addSelectColumn(SystemTableMap::COL_VERSION_MAJOR);
            $criteria->addSelectColumn(SystemTableMap::COL_VERSION_MINOR);
            $criteria->addSelectColumn(SystemTableMap::COL_VALID);
            $criteria->addSelectColumn(SystemTableMap::COL_DEBUG);
            $criteria->addSelectColumn(SystemTableMap::COL_DEPLOY_DIRECTORY);
            $criteria->addSelectColumn(SystemTableMap::COL_DB_VERSION_MAJOR);
            $criteria->addSelectColumn(SystemTableMap::COL_DB_VERSION_MINOR);
            $criteria->addSelectColumn(SystemTableMap::COL_GEMAAKT_DATUM);
            $criteria->addSelectColumn(SystemTableMap::COL_GEMAAKT_DOOR);
            $criteria->addSelectColumn(SystemTableMap::COL_GEWIJZIGD_DATUM);
            $criteria->addSelectColumn(SystemTableMap::COL_GEWIJZIGD_DOOR);
        } else {
            $criteria->addSelectColumn($alias . '.naam');
            $criteria->addSelectColumn($alias . '.version_major');
            $criteria->addSelectColumn($alias . '.version_minor');
            $criteria->addSelectColumn($alias . '.valid');
            $criteria->addSelectColumn($alias . '.debug');
            $criteria->addSelectColumn($alias . '.deploy_directory');
            $criteria->addSelectColumn($alias . '.db_version_major');
            $criteria->addSelectColumn($alias . '.db_version_minor');
            $criteria->addSelectColumn($alias . '.gemaakt_datum');
            $criteria->addSelectColumn($alias . '.gemaakt_door');
            $criteria->addSelectColumn($alias . '.gewijzigd_datum');
            $criteria->addSelectColumn($alias . '.gewijzigd_door');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(SystemTableMap::DATABASE_NAME)->getTable(SystemTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SystemTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SystemTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SystemTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a System or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or System object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SystemTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \fb_model\fb_model\System) { // it's a model object
            // create criteria based on pk value
            $criteria = $values->buildCriteria();
        } else { // it's a primary key, or an array of pks
            throw new LogicException('The System object has no primary key');
        }

        $query = SystemQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SystemTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SystemTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the fb_system table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SystemQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a System or Criteria object.
     *
     * @param mixed               $criteria Criteria or System object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SystemTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from System object
        }


        // Set the correct dbName
        $query = SystemQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SystemTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SystemTableMap::buildTableMap();
