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
use fb_model\fb_model\Persoon;
use fb_model\fb_model\PersoonQuery;


/**
 * This class defines the structure of the 'fb_persoon' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PersoonTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'fb_model.fb_model.Map.PersoonTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'fb_persoon';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\fb_model\\fb_model\\Persoon';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'fb_model.fb_model.Persoon';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 18;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 18;

    /**
     * the column name for the id field
     */
    const COL_ID = 'fb_persoon.id';

    /**
     * the column name for the voornaam field
     */
    const COL_VOORNAAM = 'fb_persoon.voornaam';

    /**
     * the column name for the tussenvoegsel field
     */
    const COL_TUSSENVOEGSEL = 'fb_persoon.tussenvoegsel';

    /**
     * the column name for the achternaam field
     */
    const COL_ACHTERNAAM = 'fb_persoon.achternaam';

    /**
     * the column name for the geboortedatum field
     */
    const COL_GEBOORTEDATUM = 'fb_persoon.geboortedatum';

    /**
     * the column name for the geslacht field
     */
    const COL_GESLACHT = 'fb_persoon.geslacht';

    /**
     * the column name for the email field
     */
    const COL_EMAIL = 'fb_persoon.email';

    /**
     * the column name for the telefoonnummer field
     */
    const COL_TELEFOONNUMMER = 'fb_persoon.telefoonnummer';

    /**
     * the column name for the straat field
     */
    const COL_STRAAT = 'fb_persoon.straat';

    /**
     * the column name for the huisnummer field
     */
    const COL_HUISNUMMER = 'fb_persoon.huisnummer';

    /**
     * the column name for the toevoeging field
     */
    const COL_TOEVOEGING = 'fb_persoon.toevoeging';

    /**
     * the column name for the postcode field
     */
    const COL_POSTCODE = 'fb_persoon.postcode';

    /**
     * the column name for the woonplaats field
     */
    const COL_WOONPLAATS = 'fb_persoon.woonplaats';

    /**
     * the column name for the landnaam field
     */
    const COL_LANDNAAM = 'fb_persoon.landnaam';

    /**
     * the column name for the gemaakt_datum field
     */
    const COL_GEMAAKT_DATUM = 'fb_persoon.gemaakt_datum';

    /**
     * the column name for the gemaakt_door field
     */
    const COL_GEMAAKT_DOOR = 'fb_persoon.gemaakt_door';

    /**
     * the column name for the gewijzigd_datum field
     */
    const COL_GEWIJZIGD_DATUM = 'fb_persoon.gewijzigd_datum';

    /**
     * the column name for the gewijzigd_door field
     */
    const COL_GEWIJZIGD_DOOR = 'fb_persoon.gewijzigd_door';

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
        self::TYPE_PHPNAME       => array('Id', 'Voornaam', 'Tussenvoegsel', 'Achternaam', 'GeboorteDatum', 'Geslacht', 'Email', 'Telefoonnummer', 'Straat', 'Huisnummer', 'Toevoeging', 'Postcode', 'Woonplaats', 'Landnaam', 'DatumGemaakt', 'GemaaktDoor', 'DatumGewijzigd', 'GewijzigdDoor', ),
        self::TYPE_CAMELNAME     => array('id', 'voornaam', 'tussenvoegsel', 'achternaam', 'geboorteDatum', 'geslacht', 'email', 'telefoonnummer', 'straat', 'huisnummer', 'toevoeging', 'postcode', 'woonplaats', 'landnaam', 'datumGemaakt', 'gemaaktDoor', 'datumGewijzigd', 'gewijzigdDoor', ),
        self::TYPE_COLNAME       => array(PersoonTableMap::COL_ID, PersoonTableMap::COL_VOORNAAM, PersoonTableMap::COL_TUSSENVOEGSEL, PersoonTableMap::COL_ACHTERNAAM, PersoonTableMap::COL_GEBOORTEDATUM, PersoonTableMap::COL_GESLACHT, PersoonTableMap::COL_EMAIL, PersoonTableMap::COL_TELEFOONNUMMER, PersoonTableMap::COL_STRAAT, PersoonTableMap::COL_HUISNUMMER, PersoonTableMap::COL_TOEVOEGING, PersoonTableMap::COL_POSTCODE, PersoonTableMap::COL_WOONPLAATS, PersoonTableMap::COL_LANDNAAM, PersoonTableMap::COL_GEMAAKT_DATUM, PersoonTableMap::COL_GEMAAKT_DOOR, PersoonTableMap::COL_GEWIJZIGD_DATUM, PersoonTableMap::COL_GEWIJZIGD_DOOR, ),
        self::TYPE_FIELDNAME     => array('id', 'voornaam', 'tussenvoegsel', 'achternaam', 'geboortedatum', 'geslacht', 'email', 'telefoonnummer', 'straat', 'huisnummer', 'toevoeging', 'postcode', 'woonplaats', 'landnaam', 'gemaakt_datum', 'gemaakt_door', 'gewijzigd_datum', 'gewijzigd_door', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Voornaam' => 1, 'Tussenvoegsel' => 2, 'Achternaam' => 3, 'GeboorteDatum' => 4, 'Geslacht' => 5, 'Email' => 6, 'Telefoonnummer' => 7, 'Straat' => 8, 'Huisnummer' => 9, 'Toevoeging' => 10, 'Postcode' => 11, 'Woonplaats' => 12, 'Landnaam' => 13, 'DatumGemaakt' => 14, 'GemaaktDoor' => 15, 'DatumGewijzigd' => 16, 'GewijzigdDoor' => 17, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'voornaam' => 1, 'tussenvoegsel' => 2, 'achternaam' => 3, 'geboorteDatum' => 4, 'geslacht' => 5, 'email' => 6, 'telefoonnummer' => 7, 'straat' => 8, 'huisnummer' => 9, 'toevoeging' => 10, 'postcode' => 11, 'woonplaats' => 12, 'landnaam' => 13, 'datumGemaakt' => 14, 'gemaaktDoor' => 15, 'datumGewijzigd' => 16, 'gewijzigdDoor' => 17, ),
        self::TYPE_COLNAME       => array(PersoonTableMap::COL_ID => 0, PersoonTableMap::COL_VOORNAAM => 1, PersoonTableMap::COL_TUSSENVOEGSEL => 2, PersoonTableMap::COL_ACHTERNAAM => 3, PersoonTableMap::COL_GEBOORTEDATUM => 4, PersoonTableMap::COL_GESLACHT => 5, PersoonTableMap::COL_EMAIL => 6, PersoonTableMap::COL_TELEFOONNUMMER => 7, PersoonTableMap::COL_STRAAT => 8, PersoonTableMap::COL_HUISNUMMER => 9, PersoonTableMap::COL_TOEVOEGING => 10, PersoonTableMap::COL_POSTCODE => 11, PersoonTableMap::COL_WOONPLAATS => 12, PersoonTableMap::COL_LANDNAAM => 13, PersoonTableMap::COL_GEMAAKT_DATUM => 14, PersoonTableMap::COL_GEMAAKT_DOOR => 15, PersoonTableMap::COL_GEWIJZIGD_DATUM => 16, PersoonTableMap::COL_GEWIJZIGD_DOOR => 17, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'voornaam' => 1, 'tussenvoegsel' => 2, 'achternaam' => 3, 'geboortedatum' => 4, 'geslacht' => 5, 'email' => 6, 'telefoonnummer' => 7, 'straat' => 8, 'huisnummer' => 9, 'toevoeging' => 10, 'postcode' => 11, 'woonplaats' => 12, 'landnaam' => 13, 'gemaakt_datum' => 14, 'gemaakt_door' => 15, 'gewijzigd_datum' => 16, 'gewijzigd_door' => 17, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
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
        $this->setName('fb_persoon');
        $this->setPhpName('Persoon');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\fb_model\\fb_model\\Persoon');
        $this->setPackage('fb_model.fb_model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('voornaam', 'Voornaam', 'VARCHAR', true, 255, null);
        $this->addColumn('tussenvoegsel', 'Tussenvoegsel', 'VARCHAR', false, 255, null);
        $this->addColumn('achternaam', 'Achternaam', 'VARCHAR', true, 255, null);
        $this->addColumn('geboortedatum', 'GeboorteDatum', 'DATE', false, null, null);
        $this->addColumn('geslacht', 'Geslacht', 'CHAR', true, 1, null);
        $this->addColumn('email', 'Email', 'VARCHAR', false, 255, null);
        $this->addColumn('telefoonnummer', 'Telefoonnummer', 'VARCHAR', false, 255, null);
        $this->addColumn('straat', 'Straat', 'VARCHAR', true, 255, null);
        $this->addColumn('huisnummer', 'Huisnummer', 'INTEGER', true, null, null);
        $this->addColumn('toevoeging', 'Toevoeging', 'VARCHAR', false, 255, null);
        $this->addColumn('postcode', 'Postcode', 'VARCHAR', true, 255, null);
        $this->addColumn('woonplaats', 'Woonplaats', 'VARCHAR', true, 255, null);
        $this->addColumn('landnaam', 'Landnaam', 'VARCHAR', false, 255, null);
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
        $this->addRelation('Contactlog', '\\fb_model\\fb_model\\Contactlog', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':persoon_id',
    1 => ':id',
  ),
), null, null, 'Contactlogs', false);
        $this->addRelation('Deelnemer', '\\fb_model\\fb_model\\Deelnemer', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':persoon_id',
    1 => ':id',
  ),
), null, null, 'Deelnemers', false);
        $this->addRelation('Gebruiker', '\\fb_model\\fb_model\\Gebruiker', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':persoon_id',
    1 => ':id',
  ),
), null, null, 'Gebruikers', false);
        $this->addRelation('Inschrijving', '\\fb_model\\fb_model\\Inschrijving', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':contactpersoon_id',
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
        return $withPrefix ? PersoonTableMap::CLASS_DEFAULT : PersoonTableMap::OM_CLASS;
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
     * @return array           (Persoon object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PersoonTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PersoonTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PersoonTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PersoonTableMap::OM_CLASS;
            /** @var Persoon $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PersoonTableMap::addInstanceToPool($obj, $key);
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
            $key = PersoonTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PersoonTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Persoon $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PersoonTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PersoonTableMap::COL_ID);
            $criteria->addSelectColumn(PersoonTableMap::COL_VOORNAAM);
            $criteria->addSelectColumn(PersoonTableMap::COL_TUSSENVOEGSEL);
            $criteria->addSelectColumn(PersoonTableMap::COL_ACHTERNAAM);
            $criteria->addSelectColumn(PersoonTableMap::COL_GEBOORTEDATUM);
            $criteria->addSelectColumn(PersoonTableMap::COL_GESLACHT);
            $criteria->addSelectColumn(PersoonTableMap::COL_EMAIL);
            $criteria->addSelectColumn(PersoonTableMap::COL_TELEFOONNUMMER);
            $criteria->addSelectColumn(PersoonTableMap::COL_STRAAT);
            $criteria->addSelectColumn(PersoonTableMap::COL_HUISNUMMER);
            $criteria->addSelectColumn(PersoonTableMap::COL_TOEVOEGING);
            $criteria->addSelectColumn(PersoonTableMap::COL_POSTCODE);
            $criteria->addSelectColumn(PersoonTableMap::COL_WOONPLAATS);
            $criteria->addSelectColumn(PersoonTableMap::COL_LANDNAAM);
            $criteria->addSelectColumn(PersoonTableMap::COL_GEMAAKT_DATUM);
            $criteria->addSelectColumn(PersoonTableMap::COL_GEMAAKT_DOOR);
            $criteria->addSelectColumn(PersoonTableMap::COL_GEWIJZIGD_DATUM);
            $criteria->addSelectColumn(PersoonTableMap::COL_GEWIJZIGD_DOOR);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.voornaam');
            $criteria->addSelectColumn($alias . '.tussenvoegsel');
            $criteria->addSelectColumn($alias . '.achternaam');
            $criteria->addSelectColumn($alias . '.geboortedatum');
            $criteria->addSelectColumn($alias . '.geslacht');
            $criteria->addSelectColumn($alias . '.email');
            $criteria->addSelectColumn($alias . '.telefoonnummer');
            $criteria->addSelectColumn($alias . '.straat');
            $criteria->addSelectColumn($alias . '.huisnummer');
            $criteria->addSelectColumn($alias . '.toevoeging');
            $criteria->addSelectColumn($alias . '.postcode');
            $criteria->addSelectColumn($alias . '.woonplaats');
            $criteria->addSelectColumn($alias . '.landnaam');
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
        return Propel::getServiceContainer()->getDatabaseMap(PersoonTableMap::DATABASE_NAME)->getTable(PersoonTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PersoonTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PersoonTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PersoonTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Persoon or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Persoon object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PersoonTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \fb_model\fb_model\Persoon) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PersoonTableMap::DATABASE_NAME);
            $criteria->add(PersoonTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PersoonQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PersoonTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PersoonTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the fb_persoon table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PersoonQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Persoon or Criteria object.
     *
     * @param mixed               $criteria Criteria or Persoon object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PersoonTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Persoon object
        }

        if ($criteria->containsKey(PersoonTableMap::COL_ID) && $criteria->keyContainsValue(PersoonTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PersoonTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PersoonQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PersoonTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PersoonTableMap::buildTableMap();
