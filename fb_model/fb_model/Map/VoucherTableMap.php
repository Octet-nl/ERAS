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
use fb_model\fb_model\Voucher;
use fb_model\fb_model\VoucherQuery;


/**
 * This class defines the structure of the 'fb_voucher' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class VoucherTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'fb_model.fb_model.Map.VoucherTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'fb_voucher';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\fb_model\\fb_model\\Voucher';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'fb_model.fb_model.Voucher';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 14;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 14;

    /**
     * the column name for the id field
     */
    const COL_ID = 'fb_voucher.id';

    /**
     * the column name for the code field
     */
    const COL_CODE = 'fb_voucher.code';

    /**
     * the column name for the email field
     */
    const COL_EMAIL = 'fb_voucher.email';

    /**
     * the column name for the evenement_id field
     */
    const COL_EVENEMENT_ID = 'fb_voucher.evenement_id';

    /**
     * the column name for the oorsprongwaarde field
     */
    const COL_OORSPRONGWAARDE = 'fb_voucher.oorsprongwaarde';

    /**
     * the column name for the restwaarde field
     */
    const COL_RESTWAARDE = 'fb_voucher.restwaarde';

    /**
     * the column name for the verbruikt field
     */
    const COL_VERBRUIKT = 'fb_voucher.verbruikt';

    /**
     * the column name for the vouchertype field
     */
    const COL_VOUCHERTYPE = 'fb_voucher.vouchertype';

    /**
     * the column name for the actief field
     */
    const COL_ACTIEF = 'fb_voucher.actief';

    /**
     * the column name for the geldig_tot field
     */
    const COL_GELDIG_TOT = 'fb_voucher.geldig_tot';

    /**
     * the column name for the gemaakt_datum field
     */
    const COL_GEMAAKT_DATUM = 'fb_voucher.gemaakt_datum';

    /**
     * the column name for the gemaakt_door field
     */
    const COL_GEMAAKT_DOOR = 'fb_voucher.gemaakt_door';

    /**
     * the column name for the gewijzigd_datum field
     */
    const COL_GEWIJZIGD_DATUM = 'fb_voucher.gewijzigd_datum';

    /**
     * the column name for the gewijzigd_door field
     */
    const COL_GEWIJZIGD_DOOR = 'fb_voucher.gewijzigd_door';

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
        self::TYPE_PHPNAME       => array('Id', 'Code', 'Email', 'EvenementId', 'OorspronkelijkeWaarde', 'RestWaarde', 'Verbruikt', 'VoucherType', 'IsActief', 'GeldigTot', 'DatumGemaakt', 'GemaaktDoor', 'DatumGewijzigd', 'GewijzigdDoor', ),
        self::TYPE_CAMELNAME     => array('id', 'code', 'email', 'evenementId', 'oorspronkelijkeWaarde', 'restWaarde', 'verbruikt', 'voucherType', 'isActief', 'geldigTot', 'datumGemaakt', 'gemaaktDoor', 'datumGewijzigd', 'gewijzigdDoor', ),
        self::TYPE_COLNAME       => array(VoucherTableMap::COL_ID, VoucherTableMap::COL_CODE, VoucherTableMap::COL_EMAIL, VoucherTableMap::COL_EVENEMENT_ID, VoucherTableMap::COL_OORSPRONGWAARDE, VoucherTableMap::COL_RESTWAARDE, VoucherTableMap::COL_VERBRUIKT, VoucherTableMap::COL_VOUCHERTYPE, VoucherTableMap::COL_ACTIEF, VoucherTableMap::COL_GELDIG_TOT, VoucherTableMap::COL_GEMAAKT_DATUM, VoucherTableMap::COL_GEMAAKT_DOOR, VoucherTableMap::COL_GEWIJZIGD_DATUM, VoucherTableMap::COL_GEWIJZIGD_DOOR, ),
        self::TYPE_FIELDNAME     => array('id', 'code', 'email', 'evenement_id', 'oorsprongwaarde', 'restwaarde', 'verbruikt', 'vouchertype', 'actief', 'geldig_tot', 'gemaakt_datum', 'gemaakt_door', 'gewijzigd_datum', 'gewijzigd_door', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Code' => 1, 'Email' => 2, 'EvenementId' => 3, 'OorspronkelijkeWaarde' => 4, 'RestWaarde' => 5, 'Verbruikt' => 6, 'VoucherType' => 7, 'IsActief' => 8, 'GeldigTot' => 9, 'DatumGemaakt' => 10, 'GemaaktDoor' => 11, 'DatumGewijzigd' => 12, 'GewijzigdDoor' => 13, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'code' => 1, 'email' => 2, 'evenementId' => 3, 'oorspronkelijkeWaarde' => 4, 'restWaarde' => 5, 'verbruikt' => 6, 'voucherType' => 7, 'isActief' => 8, 'geldigTot' => 9, 'datumGemaakt' => 10, 'gemaaktDoor' => 11, 'datumGewijzigd' => 12, 'gewijzigdDoor' => 13, ),
        self::TYPE_COLNAME       => array(VoucherTableMap::COL_ID => 0, VoucherTableMap::COL_CODE => 1, VoucherTableMap::COL_EMAIL => 2, VoucherTableMap::COL_EVENEMENT_ID => 3, VoucherTableMap::COL_OORSPRONGWAARDE => 4, VoucherTableMap::COL_RESTWAARDE => 5, VoucherTableMap::COL_VERBRUIKT => 6, VoucherTableMap::COL_VOUCHERTYPE => 7, VoucherTableMap::COL_ACTIEF => 8, VoucherTableMap::COL_GELDIG_TOT => 9, VoucherTableMap::COL_GEMAAKT_DATUM => 10, VoucherTableMap::COL_GEMAAKT_DOOR => 11, VoucherTableMap::COL_GEWIJZIGD_DATUM => 12, VoucherTableMap::COL_GEWIJZIGD_DOOR => 13, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'code' => 1, 'email' => 2, 'evenement_id' => 3, 'oorsprongwaarde' => 4, 'restwaarde' => 5, 'verbruikt' => 6, 'vouchertype' => 7, 'actief' => 8, 'geldig_tot' => 9, 'gemaakt_datum' => 10, 'gemaakt_door' => 11, 'gewijzigd_datum' => 12, 'gewijzigd_door' => 13, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
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
        $this->setName('fb_voucher');
        $this->setPhpName('Voucher');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\fb_model\\fb_model\\Voucher');
        $this->setPackage('fb_model.fb_model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('code', 'Code', 'VARCHAR', true, 255, null);
        $this->addColumn('email', 'Email', 'VARCHAR', false, 255, null);
        $this->addForeignKey('evenement_id', 'EvenementId', 'INTEGER', 'fb_evenement', 'id', false, null, null);
        $this->addColumn('oorsprongwaarde', 'OorspronkelijkeWaarde', 'DECIMAL', false, 9, null);
        $this->addColumn('restwaarde', 'RestWaarde', 'DECIMAL', false, 9, null);
        $this->addColumn('verbruikt', 'Verbruikt', 'DECIMAL', false, 9, null);
        $this->addColumn('vouchertype', 'VoucherType', 'INTEGER', true, 2, null);
        $this->addColumn('actief', 'IsActief', 'INTEGER', true, 1, null);
        $this->addColumn('geldig_tot', 'GeldigTot', 'TIMESTAMP', true, null, null);
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
        $this->addRelation('Evenement', '\\fb_model\\fb_model\\Evenement', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':evenement_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Inschrijving', '\\fb_model\\fb_model\\Inschrijving', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':voucher_id',
    1 => ':id',
  ),
), null, null, 'Inschrijvings', false);
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
        return $withPrefix ? VoucherTableMap::CLASS_DEFAULT : VoucherTableMap::OM_CLASS;
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
     * @return array           (Voucher object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = VoucherTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = VoucherTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + VoucherTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = VoucherTableMap::OM_CLASS;
            /** @var Voucher $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            VoucherTableMap::addInstanceToPool($obj, $key);
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
            $key = VoucherTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = VoucherTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Voucher $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                VoucherTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(VoucherTableMap::COL_ID);
            $criteria->addSelectColumn(VoucherTableMap::COL_CODE);
            $criteria->addSelectColumn(VoucherTableMap::COL_EMAIL);
            $criteria->addSelectColumn(VoucherTableMap::COL_EVENEMENT_ID);
            $criteria->addSelectColumn(VoucherTableMap::COL_OORSPRONGWAARDE);
            $criteria->addSelectColumn(VoucherTableMap::COL_RESTWAARDE);
            $criteria->addSelectColumn(VoucherTableMap::COL_VERBRUIKT);
            $criteria->addSelectColumn(VoucherTableMap::COL_VOUCHERTYPE);
            $criteria->addSelectColumn(VoucherTableMap::COL_ACTIEF);
            $criteria->addSelectColumn(VoucherTableMap::COL_GELDIG_TOT);
            $criteria->addSelectColumn(VoucherTableMap::COL_GEMAAKT_DATUM);
            $criteria->addSelectColumn(VoucherTableMap::COL_GEMAAKT_DOOR);
            $criteria->addSelectColumn(VoucherTableMap::COL_GEWIJZIGD_DATUM);
            $criteria->addSelectColumn(VoucherTableMap::COL_GEWIJZIGD_DOOR);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.code');
            $criteria->addSelectColumn($alias . '.email');
            $criteria->addSelectColumn($alias . '.evenement_id');
            $criteria->addSelectColumn($alias . '.oorsprongwaarde');
            $criteria->addSelectColumn($alias . '.restwaarde');
            $criteria->addSelectColumn($alias . '.verbruikt');
            $criteria->addSelectColumn($alias . '.vouchertype');
            $criteria->addSelectColumn($alias . '.actief');
            $criteria->addSelectColumn($alias . '.geldig_tot');
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
        return Propel::getServiceContainer()->getDatabaseMap(VoucherTableMap::DATABASE_NAME)->getTable(VoucherTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(VoucherTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(VoucherTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new VoucherTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Voucher or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Voucher object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(VoucherTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \fb_model\fb_model\Voucher) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(VoucherTableMap::DATABASE_NAME);
            $criteria->add(VoucherTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = VoucherQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            VoucherTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                VoucherTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the fb_voucher table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return VoucherQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Voucher or Criteria object.
     *
     * @param mixed               $criteria Criteria or Voucher object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VoucherTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Voucher object
        }

        if ($criteria->containsKey(VoucherTableMap::COL_ID) && $criteria->keyContainsValue(VoucherTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.VoucherTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = VoucherQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // VoucherTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
VoucherTableMap::buildTableMap();
