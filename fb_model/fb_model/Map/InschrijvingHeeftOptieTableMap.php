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
use fb_model\fb_model\InschrijvingHeeftOptie;
use fb_model\fb_model\InschrijvingHeeftOptieQuery;


/**
 * This class defines the structure of the 'fb_inschrijving_heeft_optie' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class InschrijvingHeeftOptieTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'fb_model.fb_model.Map.InschrijvingHeeftOptieTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'fb_inschrijving_heeft_optie';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\fb_model\\fb_model\\InschrijvingHeeftOptie';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'fb_model.fb_model.InschrijvingHeeftOptie';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the id field
     */
    const COL_ID = 'fb_inschrijving_heeft_optie.id';

    /**
     * the column name for the optie_id field
     */
    const COL_OPTIE_ID = 'fb_inschrijving_heeft_optie.optie_id';

    /**
     * the column name for the inschrijving_id field
     */
    const COL_INSCHRIJVING_ID = 'fb_inschrijving_heeft_optie.inschrijving_id';

    /**
     * the column name for the waarde field
     */
    const COL_WAARDE = 'fb_inschrijving_heeft_optie.waarde';

    /**
     * the column name for the prijs field
     */
    const COL_PRIJS = 'fb_inschrijving_heeft_optie.prijs';

    /**
     * the column name for the gemaakt_datum field
     */
    const COL_GEMAAKT_DATUM = 'fb_inschrijving_heeft_optie.gemaakt_datum';

    /**
     * the column name for the gemaakt_door field
     */
    const COL_GEMAAKT_DOOR = 'fb_inschrijving_heeft_optie.gemaakt_door';

    /**
     * the column name for the gewijzigd_datum field
     */
    const COL_GEWIJZIGD_DATUM = 'fb_inschrijving_heeft_optie.gewijzigd_datum';

    /**
     * the column name for the gewijzigd_door field
     */
    const COL_GEWIJZIGD_DOOR = 'fb_inschrijving_heeft_optie.gewijzigd_door';

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
        self::TYPE_PHPNAME       => array('Id', 'OptieId', 'InschrijvingId', 'Waarde', 'Prijs', 'DatumGemaakt', 'GemaaktDoor', 'DatumGewijzigd', 'GewijzigdDoor', ),
        self::TYPE_CAMELNAME     => array('id', 'optieId', 'inschrijvingId', 'waarde', 'prijs', 'datumGemaakt', 'gemaaktDoor', 'datumGewijzigd', 'gewijzigdDoor', ),
        self::TYPE_COLNAME       => array(InschrijvingHeeftOptieTableMap::COL_ID, InschrijvingHeeftOptieTableMap::COL_OPTIE_ID, InschrijvingHeeftOptieTableMap::COL_INSCHRIJVING_ID, InschrijvingHeeftOptieTableMap::COL_WAARDE, InschrijvingHeeftOptieTableMap::COL_PRIJS, InschrijvingHeeftOptieTableMap::COL_GEMAAKT_DATUM, InschrijvingHeeftOptieTableMap::COL_GEMAAKT_DOOR, InschrijvingHeeftOptieTableMap::COL_GEWIJZIGD_DATUM, InschrijvingHeeftOptieTableMap::COL_GEWIJZIGD_DOOR, ),
        self::TYPE_FIELDNAME     => array('id', 'optie_id', 'inschrijving_id', 'waarde', 'prijs', 'gemaakt_datum', 'gemaakt_door', 'gewijzigd_datum', 'gewijzigd_door', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'OptieId' => 1, 'InschrijvingId' => 2, 'Waarde' => 3, 'Prijs' => 4, 'DatumGemaakt' => 5, 'GemaaktDoor' => 6, 'DatumGewijzigd' => 7, 'GewijzigdDoor' => 8, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'optieId' => 1, 'inschrijvingId' => 2, 'waarde' => 3, 'prijs' => 4, 'datumGemaakt' => 5, 'gemaaktDoor' => 6, 'datumGewijzigd' => 7, 'gewijzigdDoor' => 8, ),
        self::TYPE_COLNAME       => array(InschrijvingHeeftOptieTableMap::COL_ID => 0, InschrijvingHeeftOptieTableMap::COL_OPTIE_ID => 1, InschrijvingHeeftOptieTableMap::COL_INSCHRIJVING_ID => 2, InschrijvingHeeftOptieTableMap::COL_WAARDE => 3, InschrijvingHeeftOptieTableMap::COL_PRIJS => 4, InschrijvingHeeftOptieTableMap::COL_GEMAAKT_DATUM => 5, InschrijvingHeeftOptieTableMap::COL_GEMAAKT_DOOR => 6, InschrijvingHeeftOptieTableMap::COL_GEWIJZIGD_DATUM => 7, InschrijvingHeeftOptieTableMap::COL_GEWIJZIGD_DOOR => 8, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'optie_id' => 1, 'inschrijving_id' => 2, 'waarde' => 3, 'prijs' => 4, 'gemaakt_datum' => 5, 'gemaakt_door' => 6, 'gewijzigd_datum' => 7, 'gewijzigd_door' => 8, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
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
        $this->setName('fb_inschrijving_heeft_optie');
        $this->setPhpName('InschrijvingHeeftOptie');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\fb_model\\fb_model\\InschrijvingHeeftOptie');
        $this->setPackage('fb_model.fb_model');
        $this->setUseIdGenerator(true);
        $this->setIsCrossRef(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignPrimaryKey('optie_id', 'OptieId', 'INTEGER' , 'fb_optie', 'id', true, null, null);
        $this->addForeignPrimaryKey('inschrijving_id', 'InschrijvingId', 'INTEGER' , 'fb_inschrijving', 'id', true, null, null);
        $this->addColumn('waarde', 'Waarde', 'VARCHAR', false, 512, null);
        $this->addColumn('prijs', 'Prijs', 'DECIMAL', false, 9, null);
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
        $this->addRelation('Optie', '\\fb_model\\fb_model\\Optie', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':optie_id',
    1 => ':id',
  ),
), null, null, null, false);
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
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \fb_model\fb_model\InschrijvingHeeftOptie $obj A \fb_model\fb_model\InschrijvingHeeftOptie object.
     * @param string $key             (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize([(null === $obj->getId() || is_scalar($obj->getId()) || is_callable([$obj->getId(), '__toString']) ? (string) $obj->getId() : $obj->getId()), (null === $obj->getOptieId() || is_scalar($obj->getOptieId()) || is_callable([$obj->getOptieId(), '__toString']) ? (string) $obj->getOptieId() : $obj->getOptieId()), (null === $obj->getInschrijvingId() || is_scalar($obj->getInschrijvingId()) || is_callable([$obj->getInschrijvingId(), '__toString']) ? (string) $obj->getInschrijvingId() : $obj->getInschrijvingId())]);
            } // if key === null
            self::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A \fb_model\fb_model\InschrijvingHeeftOptie object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \fb_model\fb_model\InschrijvingHeeftOptie) {
                $key = serialize([(null === $value->getId() || is_scalar($value->getId()) || is_callable([$value->getId(), '__toString']) ? (string) $value->getId() : $value->getId()), (null === $value->getOptieId() || is_scalar($value->getOptieId()) || is_callable([$value->getOptieId(), '__toString']) ? (string) $value->getOptieId() : $value->getOptieId()), (null === $value->getInschrijvingId() || is_scalar($value->getInschrijvingId()) || is_callable([$value->getInschrijvingId(), '__toString']) ? (string) $value->getInschrijvingId() : $value->getInschrijvingId())]);

            } elseif (is_array($value) && count($value) === 3) {
                // assume we've been passed a primary key";
                $key = serialize([(null === $value[0] || is_scalar($value[0]) || is_callable([$value[0], '__toString']) ? (string) $value[0] : $value[0]), (null === $value[1] || is_scalar($value[1]) || is_callable([$value[1], '__toString']) ? (string) $value[1] : $value[1]), (null === $value[2] || is_scalar($value[2]) || is_callable([$value[2], '__toString']) ? (string) $value[2] : $value[2])]);
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \fb_model\fb_model\InschrijvingHeeftOptie object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
    }

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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('OptieId', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('InschrijvingId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([(null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('OptieId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('OptieId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('OptieId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('OptieId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('OptieId', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('InschrijvingId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('InschrijvingId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('InschrijvingId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('InschrijvingId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('InschrijvingId', TableMap::TYPE_PHPNAME, $indexType)])]);
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
            $pks = [];

        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 1 + $offset
                : self::translateFieldName('OptieId', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 2 + $offset
                : self::translateFieldName('InschrijvingId', TableMap::TYPE_PHPNAME, $indexType)
        ];

        return $pks;
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
        return $withPrefix ? InschrijvingHeeftOptieTableMap::CLASS_DEFAULT : InschrijvingHeeftOptieTableMap::OM_CLASS;
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
     * @return array           (InschrijvingHeeftOptie object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = InschrijvingHeeftOptieTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = InschrijvingHeeftOptieTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + InschrijvingHeeftOptieTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = InschrijvingHeeftOptieTableMap::OM_CLASS;
            /** @var InschrijvingHeeftOptie $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            InschrijvingHeeftOptieTableMap::addInstanceToPool($obj, $key);
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
            $key = InschrijvingHeeftOptieTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = InschrijvingHeeftOptieTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var InschrijvingHeeftOptie $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                InschrijvingHeeftOptieTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(InschrijvingHeeftOptieTableMap::COL_ID);
            $criteria->addSelectColumn(InschrijvingHeeftOptieTableMap::COL_OPTIE_ID);
            $criteria->addSelectColumn(InschrijvingHeeftOptieTableMap::COL_INSCHRIJVING_ID);
            $criteria->addSelectColumn(InschrijvingHeeftOptieTableMap::COL_WAARDE);
            $criteria->addSelectColumn(InschrijvingHeeftOptieTableMap::COL_PRIJS);
            $criteria->addSelectColumn(InschrijvingHeeftOptieTableMap::COL_GEMAAKT_DATUM);
            $criteria->addSelectColumn(InschrijvingHeeftOptieTableMap::COL_GEMAAKT_DOOR);
            $criteria->addSelectColumn(InschrijvingHeeftOptieTableMap::COL_GEWIJZIGD_DATUM);
            $criteria->addSelectColumn(InschrijvingHeeftOptieTableMap::COL_GEWIJZIGD_DOOR);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.optie_id');
            $criteria->addSelectColumn($alias . '.inschrijving_id');
            $criteria->addSelectColumn($alias . '.waarde');
            $criteria->addSelectColumn($alias . '.prijs');
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
        return Propel::getServiceContainer()->getDatabaseMap(InschrijvingHeeftOptieTableMap::DATABASE_NAME)->getTable(InschrijvingHeeftOptieTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(InschrijvingHeeftOptieTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(InschrijvingHeeftOptieTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new InschrijvingHeeftOptieTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a InschrijvingHeeftOptie or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or InschrijvingHeeftOptie object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(InschrijvingHeeftOptieTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \fb_model\fb_model\InschrijvingHeeftOptie) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(InschrijvingHeeftOptieTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(InschrijvingHeeftOptieTableMap::COL_ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(InschrijvingHeeftOptieTableMap::COL_OPTIE_ID, $value[1]));
                $criterion->addAnd($criteria->getNewCriterion(InschrijvingHeeftOptieTableMap::COL_INSCHRIJVING_ID, $value[2]));
                $criteria->addOr($criterion);
            }
        }

        $query = InschrijvingHeeftOptieQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            InschrijvingHeeftOptieTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                InschrijvingHeeftOptieTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the fb_inschrijving_heeft_optie table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return InschrijvingHeeftOptieQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a InschrijvingHeeftOptie or Criteria object.
     *
     * @param mixed               $criteria Criteria or InschrijvingHeeftOptie object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InschrijvingHeeftOptieTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from InschrijvingHeeftOptie object
        }

        if ($criteria->containsKey(InschrijvingHeeftOptieTableMap::COL_ID) && $criteria->keyContainsValue(InschrijvingHeeftOptieTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.InschrijvingHeeftOptieTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = InschrijvingHeeftOptieQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // InschrijvingHeeftOptieTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
InschrijvingHeeftOptieTableMap::buildTableMap();
