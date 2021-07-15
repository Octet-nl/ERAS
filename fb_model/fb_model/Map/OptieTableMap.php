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
use fb_model\fb_model\Optie;
use fb_model\fb_model\OptieQuery;


/**
 * This class defines the structure of the 'fb_optie' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class OptieTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'fb_model.fb_model.Map.OptieTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'fb_optie';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\fb_model\\fb_model\\Optie';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'fb_model.fb_model.Optie';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 20;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 20;

    /**
     * the column name for the id field
     */
    const COL_ID = 'fb_optie.id';

    /**
     * the column name for the per_deelnemer field
     */
    const COL_PER_DEELNEMER = 'fb_optie.per_deelnemer';

    /**
     * the column name for the naam field
     */
    const COL_NAAM = 'fb_optie.naam';

    /**
     * the column name for the tekst_voor field
     */
    const COL_TEKST_VOOR = 'fb_optie.tekst_voor';

    /**
     * the column name for the tekst_achter field
     */
    const COL_TEKST_ACHTER = 'fb_optie.tekst_achter';

    /**
     * the column name for the tooltip_tekst field
     */
    const COL_TOOLTIP_TEKST = 'fb_optie.tooltip_tekst';

    /**
     * the column name for the heeft_hor_lijn field
     */
    const COL_HEEFT_HOR_LIJN = 'fb_optie.heeft_hor_lijn';

    /**
     * the column name for the optietype field
     */
    const COL_OPTIETYPE = 'fb_optie.optietype';

    /**
     * the column name for the groep field
     */
    const COL_GROEP = 'fb_optie.groep';

    /**
     * the column name for the label field
     */
    const COL_LABEL = 'fb_optie.label';

    /**
     * the column name for the is_default field
     */
    const COL_IS_DEFAULT = 'fb_optie.is_default';

    /**
     * the column name for the later_wijzigen field
     */
    const COL_LATER_WIJZIGEN = 'fb_optie.later_wijzigen';

    /**
     * the column name for the totaal_aantal field
     */
    const COL_TOTAAL_AANTAL = 'fb_optie.totaal_aantal';

    /**
     * the column name for the prijs field
     */
    const COL_PRIJS = 'fb_optie.prijs';

    /**
     * the column name for the status field
     */
    const COL_STATUS = 'fb_optie.status';

    /**
     * the column name for the intern_gebruik field
     */
    const COL_INTERN_GEBRUIK = 'fb_optie.intern_gebruik';

    /**
     * the column name for the gemaakt_datum field
     */
    const COL_GEMAAKT_DATUM = 'fb_optie.gemaakt_datum';

    /**
     * the column name for the gemaakt_door field
     */
    const COL_GEMAAKT_DOOR = 'fb_optie.gemaakt_door';

    /**
     * the column name for the gewijzigd_datum field
     */
    const COL_GEWIJZIGD_DATUM = 'fb_optie.gewijzigd_datum';

    /**
     * the column name for the gewijzigd_door field
     */
    const COL_GEWIJZIGD_DOOR = 'fb_optie.gewijzigd_door';

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
        self::TYPE_PHPNAME       => array('Id', 'PerDeelnemer', 'Naam', 'TekstVoor', 'TekstAchter', 'TooltipTekst', 'HeeftHorizontaleLijn', 'OptieType', 'Groep', 'Label', 'IsDefault', 'LaterWijzigen', 'TotaalAantal', 'Prijs', 'Status', 'InternGebruik', 'DatumGemaakt', 'GemaaktDoor', 'DatumGewijzigd', 'GewijzigdDoor', ),
        self::TYPE_CAMELNAME     => array('id', 'perDeelnemer', 'naam', 'tekstVoor', 'tekstAchter', 'tooltipTekst', 'heeftHorizontaleLijn', 'optieType', 'groep', 'label', 'isDefault', 'laterWijzigen', 'totaalAantal', 'prijs', 'status', 'internGebruik', 'datumGemaakt', 'gemaaktDoor', 'datumGewijzigd', 'gewijzigdDoor', ),
        self::TYPE_COLNAME       => array(OptieTableMap::COL_ID, OptieTableMap::COL_PER_DEELNEMER, OptieTableMap::COL_NAAM, OptieTableMap::COL_TEKST_VOOR, OptieTableMap::COL_TEKST_ACHTER, OptieTableMap::COL_TOOLTIP_TEKST, OptieTableMap::COL_HEEFT_HOR_LIJN, OptieTableMap::COL_OPTIETYPE, OptieTableMap::COL_GROEP, OptieTableMap::COL_LABEL, OptieTableMap::COL_IS_DEFAULT, OptieTableMap::COL_LATER_WIJZIGEN, OptieTableMap::COL_TOTAAL_AANTAL, OptieTableMap::COL_PRIJS, OptieTableMap::COL_STATUS, OptieTableMap::COL_INTERN_GEBRUIK, OptieTableMap::COL_GEMAAKT_DATUM, OptieTableMap::COL_GEMAAKT_DOOR, OptieTableMap::COL_GEWIJZIGD_DATUM, OptieTableMap::COL_GEWIJZIGD_DOOR, ),
        self::TYPE_FIELDNAME     => array('id', 'per_deelnemer', 'naam', 'tekst_voor', 'tekst_achter', 'tooltip_tekst', 'heeft_hor_lijn', 'optietype', 'groep', 'label', 'is_default', 'later_wijzigen', 'totaal_aantal', 'prijs', 'status', 'intern_gebruik', 'gemaakt_datum', 'gemaakt_door', 'gewijzigd_datum', 'gewijzigd_door', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'PerDeelnemer' => 1, 'Naam' => 2, 'TekstVoor' => 3, 'TekstAchter' => 4, 'TooltipTekst' => 5, 'HeeftHorizontaleLijn' => 6, 'OptieType' => 7, 'Groep' => 8, 'Label' => 9, 'IsDefault' => 10, 'LaterWijzigen' => 11, 'TotaalAantal' => 12, 'Prijs' => 13, 'Status' => 14, 'InternGebruik' => 15, 'DatumGemaakt' => 16, 'GemaaktDoor' => 17, 'DatumGewijzigd' => 18, 'GewijzigdDoor' => 19, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'perDeelnemer' => 1, 'naam' => 2, 'tekstVoor' => 3, 'tekstAchter' => 4, 'tooltipTekst' => 5, 'heeftHorizontaleLijn' => 6, 'optieType' => 7, 'groep' => 8, 'label' => 9, 'isDefault' => 10, 'laterWijzigen' => 11, 'totaalAantal' => 12, 'prijs' => 13, 'status' => 14, 'internGebruik' => 15, 'datumGemaakt' => 16, 'gemaaktDoor' => 17, 'datumGewijzigd' => 18, 'gewijzigdDoor' => 19, ),
        self::TYPE_COLNAME       => array(OptieTableMap::COL_ID => 0, OptieTableMap::COL_PER_DEELNEMER => 1, OptieTableMap::COL_NAAM => 2, OptieTableMap::COL_TEKST_VOOR => 3, OptieTableMap::COL_TEKST_ACHTER => 4, OptieTableMap::COL_TOOLTIP_TEKST => 5, OptieTableMap::COL_HEEFT_HOR_LIJN => 6, OptieTableMap::COL_OPTIETYPE => 7, OptieTableMap::COL_GROEP => 8, OptieTableMap::COL_LABEL => 9, OptieTableMap::COL_IS_DEFAULT => 10, OptieTableMap::COL_LATER_WIJZIGEN => 11, OptieTableMap::COL_TOTAAL_AANTAL => 12, OptieTableMap::COL_PRIJS => 13, OptieTableMap::COL_STATUS => 14, OptieTableMap::COL_INTERN_GEBRUIK => 15, OptieTableMap::COL_GEMAAKT_DATUM => 16, OptieTableMap::COL_GEMAAKT_DOOR => 17, OptieTableMap::COL_GEWIJZIGD_DATUM => 18, OptieTableMap::COL_GEWIJZIGD_DOOR => 19, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'per_deelnemer' => 1, 'naam' => 2, 'tekst_voor' => 3, 'tekst_achter' => 4, 'tooltip_tekst' => 5, 'heeft_hor_lijn' => 6, 'optietype' => 7, 'groep' => 8, 'label' => 9, 'is_default' => 10, 'later_wijzigen' => 11, 'totaal_aantal' => 12, 'prijs' => 13, 'status' => 14, 'intern_gebruik' => 15, 'gemaakt_datum' => 16, 'gemaakt_door' => 17, 'gewijzigd_datum' => 18, 'gewijzigd_door' => 19, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, )
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
        $this->setName('fb_optie');
        $this->setPhpName('Optie');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\fb_model\\fb_model\\Optie');
        $this->setPackage('fb_model.fb_model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('per_deelnemer', 'PerDeelnemer', 'INTEGER', false, 1, null);
        $this->addColumn('naam', 'Naam', 'VARCHAR', true, 255, null);
        $this->addColumn('tekst_voor', 'TekstVoor', 'LONGVARCHAR', true, null, null);
        $this->addColumn('tekst_achter', 'TekstAchter', 'VARCHAR', false, 255, null);
        $this->addColumn('tooltip_tekst', 'TooltipTekst', 'VARCHAR', false, 255, null);
        $this->addColumn('heeft_hor_lijn', 'HeeftHorizontaleLijn', 'INTEGER', true, 2, null);
        $this->addForeignKey('optietype', 'OptieType', 'INTEGER', 'fb_type', 'id', false, 2, null);
        $this->addColumn('groep', 'Groep', 'VARCHAR', false, 255, null);
        $this->addColumn('label', 'Label', 'VARCHAR', false, 255, null);
        $this->addColumn('is_default', 'IsDefault', 'INTEGER', false, 1, null);
        $this->addColumn('later_wijzigen', 'LaterWijzigen', 'INTEGER', false, 1, 1);
        $this->addColumn('totaal_aantal', 'TotaalAantal', 'INTEGER', false, null, null);
        $this->addColumn('prijs', 'Prijs', 'DECIMAL', false, 9, null);
        $this->addColumn('status', 'Status', 'INTEGER', true, 2, null);
        $this->addColumn('intern_gebruik', 'InternGebruik', 'INTEGER', false, 1, null);
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
        $this->addRelation('Type', '\\fb_model\\fb_model\\Type', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':optietype',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('DeelnemerHeeftOptie', '\\fb_model\\fb_model\\DeelnemerHeeftOptie', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':optie_id',
    1 => ':id',
  ),
), null, null, 'DeelnemerHeeftOpties', false);
        $this->addRelation('EvenementHeeftOptie', '\\fb_model\\fb_model\\EvenementHeeftOptie', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':optie_id',
    1 => ':id',
  ),
), null, null, 'EvenementHeeftOpties', false);
        $this->addRelation('InschrijvingHeeftOptie', '\\fb_model\\fb_model\\InschrijvingHeeftOptie', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':optie_id',
    1 => ':id',
  ),
), null, null, 'InschrijvingHeeftOpties', false);
        $this->addRelation('Deelnemer', '\\fb_model\\fb_model\\Deelnemer', RelationMap::MANY_TO_MANY, array(), null, null, 'Deelnemers');
        $this->addRelation('Evenement', '\\fb_model\\fb_model\\Evenement', RelationMap::MANY_TO_MANY, array(), null, null, 'Evenements');
        $this->addRelation('Inschrijving', '\\fb_model\\fb_model\\Inschrijving', RelationMap::MANY_TO_MANY, array(), null, null, 'Inschrijvings');
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
        return $withPrefix ? OptieTableMap::CLASS_DEFAULT : OptieTableMap::OM_CLASS;
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
     * @return array           (Optie object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = OptieTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = OptieTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + OptieTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = OptieTableMap::OM_CLASS;
            /** @var Optie $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            OptieTableMap::addInstanceToPool($obj, $key);
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
            $key = OptieTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = OptieTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Optie $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                OptieTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(OptieTableMap::COL_ID);
            $criteria->addSelectColumn(OptieTableMap::COL_PER_DEELNEMER);
            $criteria->addSelectColumn(OptieTableMap::COL_NAAM);
            $criteria->addSelectColumn(OptieTableMap::COL_TEKST_VOOR);
            $criteria->addSelectColumn(OptieTableMap::COL_TEKST_ACHTER);
            $criteria->addSelectColumn(OptieTableMap::COL_TOOLTIP_TEKST);
            $criteria->addSelectColumn(OptieTableMap::COL_HEEFT_HOR_LIJN);
            $criteria->addSelectColumn(OptieTableMap::COL_OPTIETYPE);
            $criteria->addSelectColumn(OptieTableMap::COL_GROEP);
            $criteria->addSelectColumn(OptieTableMap::COL_LABEL);
            $criteria->addSelectColumn(OptieTableMap::COL_IS_DEFAULT);
            $criteria->addSelectColumn(OptieTableMap::COL_LATER_WIJZIGEN);
            $criteria->addSelectColumn(OptieTableMap::COL_TOTAAL_AANTAL);
            $criteria->addSelectColumn(OptieTableMap::COL_PRIJS);
            $criteria->addSelectColumn(OptieTableMap::COL_STATUS);
            $criteria->addSelectColumn(OptieTableMap::COL_INTERN_GEBRUIK);
            $criteria->addSelectColumn(OptieTableMap::COL_GEMAAKT_DATUM);
            $criteria->addSelectColumn(OptieTableMap::COL_GEMAAKT_DOOR);
            $criteria->addSelectColumn(OptieTableMap::COL_GEWIJZIGD_DATUM);
            $criteria->addSelectColumn(OptieTableMap::COL_GEWIJZIGD_DOOR);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.per_deelnemer');
            $criteria->addSelectColumn($alias . '.naam');
            $criteria->addSelectColumn($alias . '.tekst_voor');
            $criteria->addSelectColumn($alias . '.tekst_achter');
            $criteria->addSelectColumn($alias . '.tooltip_tekst');
            $criteria->addSelectColumn($alias . '.heeft_hor_lijn');
            $criteria->addSelectColumn($alias . '.optietype');
            $criteria->addSelectColumn($alias . '.groep');
            $criteria->addSelectColumn($alias . '.label');
            $criteria->addSelectColumn($alias . '.is_default');
            $criteria->addSelectColumn($alias . '.later_wijzigen');
            $criteria->addSelectColumn($alias . '.totaal_aantal');
            $criteria->addSelectColumn($alias . '.prijs');
            $criteria->addSelectColumn($alias . '.status');
            $criteria->addSelectColumn($alias . '.intern_gebruik');
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
        return Propel::getServiceContainer()->getDatabaseMap(OptieTableMap::DATABASE_NAME)->getTable(OptieTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(OptieTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(OptieTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new OptieTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Optie or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Optie object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(OptieTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \fb_model\fb_model\Optie) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(OptieTableMap::DATABASE_NAME);
            $criteria->add(OptieTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = OptieQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            OptieTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                OptieTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the fb_optie table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return OptieQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Optie or Criteria object.
     *
     * @param mixed               $criteria Criteria or Optie object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OptieTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Optie object
        }

        if ($criteria->containsKey(OptieTableMap::COL_ID) && $criteria->keyContainsValue(OptieTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.OptieTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = OptieQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // OptieTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
OptieTableMap::buildTableMap();
