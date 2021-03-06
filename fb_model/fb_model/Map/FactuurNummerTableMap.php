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
use fb_model\fb_model\FactuurNummer;
use fb_model\fb_model\FactuurNummerQuery;


/**
 * This class defines the structure of the 'fb_factuur' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class FactuurNummerTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'fb_model.fb_model.Map.FactuurNummerTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'fb_factuur';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\fb_model\\fb_model\\FactuurNummer';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'fb_model.fb_model.FactuurNummer';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the id field
     */
    const COL_ID = 'fb_factuur.id';

    /**
     * the column name for the inschrijving_id field
     */
    const COL_INSCHRIJVING_ID = 'fb_factuur.inschrijving_id';

    /**
     * the column name for the factuurnummer field
     */
    const COL_FACTUURNUMMER = 'fb_factuur.factuurnummer';

    /**
     * the column name for the verzonden field
     */
    const COL_VERZONDEN = 'fb_factuur.verzonden';

    /**
     * the column name for the gemaakt_datum field
     */
    const COL_GEMAAKT_DATUM = 'fb_factuur.gemaakt_datum';

    /**
     * the column name for the gemaakt_door field
     */
    const COL_GEMAAKT_DOOR = 'fb_factuur.gemaakt_door';

    /**
     * the column name for the gewijzigd_datum field
     */
    const COL_GEWIJZIGD_DATUM = 'fb_factuur.gewijzigd_datum';

    /**
     * the column name for the gewijzigd_door field
     */
    const COL_GEWIJZIGD_DOOR = 'fb_factuur.gewijzigd_door';

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
        self::TYPE_PHPNAME       => array('Id', 'InschrijvingId', 'factuurNummer', 'verzonden', 'DatumGemaakt', 'GemaaktDoor', 'DatumGewijzigd', 'GewijzigdDoor', ),
        self::TYPE_CAMELNAME     => array('id', 'inschrijvingId', 'factuurNummer', 'verzonden', 'datumGemaakt', 'gemaaktDoor', 'datumGewijzigd', 'gewijzigdDoor', ),
        self::TYPE_COLNAME       => array(FactuurNummerTableMap::COL_ID, FactuurNummerTableMap::COL_INSCHRIJVING_ID, FactuurNummerTableMap::COL_FACTUURNUMMER, FactuurNummerTableMap::COL_VERZONDEN, FactuurNummerTableMap::COL_GEMAAKT_DATUM, FactuurNummerTableMap::COL_GEMAAKT_DOOR, FactuurNummerTableMap::COL_GEWIJZIGD_DATUM, FactuurNummerTableMap::COL_GEWIJZIGD_DOOR, ),
        self::TYPE_FIELDNAME     => array('id', 'inschrijving_id', 'factuurnummer', 'verzonden', 'gemaakt_datum', 'gemaakt_door', 'gewijzigd_datum', 'gewijzigd_door', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'InschrijvingId' => 1, 'factuurNummer' => 2, 'verzonden' => 3, 'DatumGemaakt' => 4, 'GemaaktDoor' => 5, 'DatumGewijzigd' => 6, 'GewijzigdDoor' => 7, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'inschrijvingId' => 1, 'factuurNummer' => 2, 'verzonden' => 3, 'datumGemaakt' => 4, 'gemaaktDoor' => 5, 'datumGewijzigd' => 6, 'gewijzigdDoor' => 7, ),
        self::TYPE_COLNAME       => array(FactuurNummerTableMap::COL_ID => 0, FactuurNummerTableMap::COL_INSCHRIJVING_ID => 1, FactuurNummerTableMap::COL_FACTUURNUMMER => 2, FactuurNummerTableMap::COL_VERZONDEN => 3, FactuurNummerTableMap::COL_GEMAAKT_DATUM => 4, FactuurNummerTableMap::COL_GEMAAKT_DOOR => 5, FactuurNummerTableMap::COL_GEWIJZIGD_DATUM => 6, FactuurNummerTableMap::COL_GEWIJZIGD_DOOR => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'inschrijving_id' => 1, 'factuurnummer' => 2, 'verzonden' => 3, 'gemaakt_datum' => 4, 'gemaakt_door' => 5, 'gewijzigd_datum' => 6, 'gewijzigd_door' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
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
        $this->setName('fb_factuur');
        $this->setPhpName('FactuurNummer');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\fb_model\\fb_model\\FactuurNummer');
        $this->setPackage('fb_model.fb_model');
        $this->setUseIdGenerator(true);
        $this->setIsCrossRef(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('inschrijving_id', 'InschrijvingId', 'INTEGER', 'fb_inschrijving', 'id', true, null, null);
        $this->addColumn('factuurnummer', 'factuurNummer', 'VARCHAR', true, 255, null);
        $this->addColumn('verzonden', 'verzonden', 'INTEGER', true, 1, null);
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
        $this->addRelation('Inschrijving', '\\fb_model\\fb_model\\Inschrijving', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':inschrijving_id',
    1 => ':id',
  ),
), null, null, null, false);
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
        return $withPrefix ? FactuurNummerTableMap::CLASS_DEFAULT : FactuurNummerTableMap::OM_CLASS;
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
     * @return array           (FactuurNummer object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = FactuurNummerTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = FactuurNummerTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + FactuurNummerTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = FactuurNummerTableMap::OM_CLASS;
            /** @var FactuurNummer $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            FactuurNummerTableMap::addInstanceToPool($obj, $key);
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
            $key = FactuurNummerTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = FactuurNummerTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var FactuurNummer $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                FactuurNummerTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(FactuurNummerTableMap::COL_ID);
            $criteria->addSelectColumn(FactuurNummerTableMap::COL_INSCHRIJVING_ID);
            $criteria->addSelectColumn(FactuurNummerTableMap::COL_FACTUURNUMMER);
            $criteria->addSelectColumn(FactuurNummerTableMap::COL_VERZONDEN);
            $criteria->addSelectColumn(FactuurNummerTableMap::COL_GEMAAKT_DATUM);
            $criteria->addSelectColumn(FactuurNummerTableMap::COL_GEMAAKT_DOOR);
            $criteria->addSelectColumn(FactuurNummerTableMap::COL_GEWIJZIGD_DATUM);
            $criteria->addSelectColumn(FactuurNummerTableMap::COL_GEWIJZIGD_DOOR);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.inschrijving_id');
            $criteria->addSelectColumn($alias . '.factuurnummer');
            $criteria->addSelectColumn($alias . '.verzonden');
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
        return Propel::getServiceContainer()->getDatabaseMap(FactuurNummerTableMap::DATABASE_NAME)->getTable(FactuurNummerTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(FactuurNummerTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(FactuurNummerTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new FactuurNummerTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a FactuurNummer or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or FactuurNummer object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(FactuurNummerTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \fb_model\fb_model\FactuurNummer) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(FactuurNummerTableMap::DATABASE_NAME);
            $criteria->add(FactuurNummerTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = FactuurNummerQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            FactuurNummerTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                FactuurNummerTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the fb_factuur table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return FactuurNummerQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a FactuurNummer or Criteria object.
     *
     * @param mixed               $criteria Criteria or FactuurNummer object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FactuurNummerTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from FactuurNummer object
        }

        if ($criteria->containsKey(FactuurNummerTableMap::COL_ID) && $criteria->keyContainsValue(FactuurNummerTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.FactuurNummerTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = FactuurNummerQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // FactuurNummerTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
FactuurNummerTableMap::buildTableMap();
