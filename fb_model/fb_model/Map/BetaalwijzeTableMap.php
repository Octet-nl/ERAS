<?php

namespace fb_model\fb_model\Map;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use fb_model\fb_model\Betaalwijze;
use fb_model\fb_model\BetaalwijzeQuery;


/**
 * This class defines the structure of the 'fb_betaalwijze' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class BetaalwijzeTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'fb_model.fb_model.Map.BetaalwijzeTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'fb_betaalwijze';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\fb_model\\fb_model\\Betaalwijze';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'fb_model.fb_model.Betaalwijze';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 11;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 11;

    /**
     * the column name for the id field
     */
    const COL_ID = 'fb_betaalwijze.id';

    /**
     * the column name for the code field
     */
    const COL_CODE = 'fb_betaalwijze.code';

    /**
     * the column name for the naam field
     */
    const COL_NAAM = 'fb_betaalwijze.naam';

    /**
     * the column name for the kosten field
     */
    const COL_KOSTEN = 'fb_betaalwijze.kosten';

    /**
     * the column name for the percentage field
     */
    const COL_PERCENTAGE = 'fb_betaalwijze.percentage';

    /**
     * the column name for the btw field
     */
    const COL_BTW = 'fb_betaalwijze.btw';

    /**
     * the column name for the actief field
     */
    const COL_ACTIEF = 'fb_betaalwijze.actief';

    /**
     * the column name for the gemaakt_datum field
     */
    const COL_GEMAAKT_DATUM = 'fb_betaalwijze.gemaakt_datum';

    /**
     * the column name for the gemaakt_door field
     */
    const COL_GEMAAKT_DOOR = 'fb_betaalwijze.gemaakt_door';

    /**
     * the column name for the gewijzigd_datum field
     */
    const COL_GEWIJZIGD_DATUM = 'fb_betaalwijze.gewijzigd_datum';

    /**
     * the column name for the gewijzigd_door field
     */
    const COL_GEWIJZIGD_DOOR = 'fb_betaalwijze.gewijzigd_door';

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
        self::TYPE_PHPNAME       => array('Id', 'Code', 'Naam', 'Kosten', 'Percentage', 'BTW', 'IsActief', 'DatumGemaakt', 'GemaaktDoor', 'DatumGewijzigd', 'GewijzigdDoor', ),
        self::TYPE_CAMELNAME     => array('id', 'code', 'naam', 'kosten', 'percentage', 'bTW', 'isActief', 'datumGemaakt', 'gemaaktDoor', 'datumGewijzigd', 'gewijzigdDoor', ),
        self::TYPE_COLNAME       => array(BetaalwijzeTableMap::COL_ID, BetaalwijzeTableMap::COL_CODE, BetaalwijzeTableMap::COL_NAAM, BetaalwijzeTableMap::COL_KOSTEN, BetaalwijzeTableMap::COL_PERCENTAGE, BetaalwijzeTableMap::COL_BTW, BetaalwijzeTableMap::COL_ACTIEF, BetaalwijzeTableMap::COL_GEMAAKT_DATUM, BetaalwijzeTableMap::COL_GEMAAKT_DOOR, BetaalwijzeTableMap::COL_GEWIJZIGD_DATUM, BetaalwijzeTableMap::COL_GEWIJZIGD_DOOR, ),
        self::TYPE_FIELDNAME     => array('id', 'code', 'naam', 'kosten', 'percentage', 'btw', 'actief', 'gemaakt_datum', 'gemaakt_door', 'gewijzigd_datum', 'gewijzigd_door', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Code' => 1, 'Naam' => 2, 'Kosten' => 3, 'Percentage' => 4, 'BTW' => 5, 'IsActief' => 6, 'DatumGemaakt' => 7, 'GemaaktDoor' => 8, 'DatumGewijzigd' => 9, 'GewijzigdDoor' => 10, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'code' => 1, 'naam' => 2, 'kosten' => 3, 'percentage' => 4, 'bTW' => 5, 'isActief' => 6, 'datumGemaakt' => 7, 'gemaaktDoor' => 8, 'datumGewijzigd' => 9, 'gewijzigdDoor' => 10, ),
        self::TYPE_COLNAME       => array(BetaalwijzeTableMap::COL_ID => 0, BetaalwijzeTableMap::COL_CODE => 1, BetaalwijzeTableMap::COL_NAAM => 2, BetaalwijzeTableMap::COL_KOSTEN => 3, BetaalwijzeTableMap::COL_PERCENTAGE => 4, BetaalwijzeTableMap::COL_BTW => 5, BetaalwijzeTableMap::COL_ACTIEF => 6, BetaalwijzeTableMap::COL_GEMAAKT_DATUM => 7, BetaalwijzeTableMap::COL_GEMAAKT_DOOR => 8, BetaalwijzeTableMap::COL_GEWIJZIGD_DATUM => 9, BetaalwijzeTableMap::COL_GEWIJZIGD_DOOR => 10, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'code' => 1, 'naam' => 2, 'kosten' => 3, 'percentage' => 4, 'btw' => 5, 'actief' => 6, 'gemaakt_datum' => 7, 'gemaakt_door' => 8, 'gewijzigd_datum' => 9, 'gewijzigd_door' => 10, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
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
        $this->setName('fb_betaalwijze');
        $this->setPhpName('Betaalwijze');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\fb_model\\fb_model\\Betaalwijze');
        $this->setPackage('fb_model.fb_model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('code', 'Code', 'INTEGER', true, 2, null);
        $this->addColumn('naam', 'Naam', 'VARCHAR', true, 255, null);
        $this->addColumn('kosten', 'Kosten', 'DECIMAL', false, 4, null);
        $this->addColumn('percentage', 'Percentage', 'DECIMAL', false, 5, null);
        $this->addColumn('btw', 'BTW', 'DECIMAL', false, 4, null);
        $this->addColumn('actief', 'IsActief', 'INTEGER', true, 1, null);
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
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
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
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
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
        return $withPrefix ? BetaalwijzeTableMap::CLASS_DEFAULT : BetaalwijzeTableMap::OM_CLASS;
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
     * @return array           (Betaalwijze object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = BetaalwijzeTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = BetaalwijzeTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + BetaalwijzeTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = BetaalwijzeTableMap::OM_CLASS;
            /** @var Betaalwijze $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            BetaalwijzeTableMap::addInstanceToPool($obj, $key);
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
            $key = BetaalwijzeTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = BetaalwijzeTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Betaalwijze $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                BetaalwijzeTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(BetaalwijzeTableMap::COL_ID);
            $criteria->addSelectColumn(BetaalwijzeTableMap::COL_CODE);
            $criteria->addSelectColumn(BetaalwijzeTableMap::COL_NAAM);
            $criteria->addSelectColumn(BetaalwijzeTableMap::COL_KOSTEN);
            $criteria->addSelectColumn(BetaalwijzeTableMap::COL_PERCENTAGE);
            $criteria->addSelectColumn(BetaalwijzeTableMap::COL_BTW);
            $criteria->addSelectColumn(BetaalwijzeTableMap::COL_ACTIEF);
            $criteria->addSelectColumn(BetaalwijzeTableMap::COL_GEMAAKT_DATUM);
            $criteria->addSelectColumn(BetaalwijzeTableMap::COL_GEMAAKT_DOOR);
            $criteria->addSelectColumn(BetaalwijzeTableMap::COL_GEWIJZIGD_DATUM);
            $criteria->addSelectColumn(BetaalwijzeTableMap::COL_GEWIJZIGD_DOOR);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.code');
            $criteria->addSelectColumn($alias . '.naam');
            $criteria->addSelectColumn($alias . '.kosten');
            $criteria->addSelectColumn($alias . '.percentage');
            $criteria->addSelectColumn($alias . '.btw');
            $criteria->addSelectColumn($alias . '.actief');
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
        return Propel::getServiceContainer()->getDatabaseMap(BetaalwijzeTableMap::DATABASE_NAME)->getTable(BetaalwijzeTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(BetaalwijzeTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(BetaalwijzeTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new BetaalwijzeTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Betaalwijze or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Betaalwijze object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(BetaalwijzeTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \fb_model\fb_model\Betaalwijze) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(BetaalwijzeTableMap::DATABASE_NAME);
            $criteria->add(BetaalwijzeTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = BetaalwijzeQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            BetaalwijzeTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                BetaalwijzeTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the fb_betaalwijze table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return BetaalwijzeQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Betaalwijze or Criteria object.
     *
     * @param mixed               $criteria Criteria or Betaalwijze object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BetaalwijzeTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Betaalwijze object
        }

        if ($criteria->containsKey(BetaalwijzeTableMap::COL_ID) && $criteria->keyContainsValue(BetaalwijzeTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.BetaalwijzeTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = BetaalwijzeQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // BetaalwijzeTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BetaalwijzeTableMap::buildTableMap();
