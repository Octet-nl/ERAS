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
use fb_model\fb_model\Inschrijving;
use fb_model\fb_model\InschrijvingQuery;


/**
 * This class defines the structure of the 'fb_inschrijving' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class InschrijvingTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'fb_model.fb_model.Map.InschrijvingTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'fb_inschrijving';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\fb_model\\fb_model\\Inschrijving';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'fb_model.fb_model.Inschrijving';

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
    const COL_ID = 'fb_inschrijving.id';

    /**
     * the column name for the evenement_id field
     */
    const COL_EVENEMENT_ID = 'fb_inschrijving.evenement_id';

    /**
     * the column name for the contactpersoon_id field
     */
    const COL_CONTACTPERSOON_ID = 'fb_inschrijving.contactpersoon_id';

    /**
     * the column name for the datum_inschrijving field
     */
    const COL_DATUM_INSCHRIJVING = 'fb_inschrijving.datum_inschrijving';

    /**
     * the column name for the annuleringsverzekering_afgesloten field
     */
    const COL_ANNULERINGSVERZEKERING_AFGESLOTEN = 'fb_inschrijving.annuleringsverzekering_afgesloten';

    /**
     * the column name for the totaalbedrag field
     */
    const COL_TOTAALBEDRAG = 'fb_inschrijving.totaalbedrag';

    /**
     * the column name for the reeds_betaald field
     */
    const COL_REEDS_BETAALD = 'fb_inschrijving.reeds_betaald';

    /**
     * the column name for the nog_te_betalen field
     */
    const COL_NOG_TE_BETALEN = 'fb_inschrijving.nog_te_betalen';

    /**
     * the column name for the korting field
     */
    const COL_KORTING = 'fb_inschrijving.korting';

    /**
     * the column name for the betaald_per_voucher field
     */
    const COL_BETAALD_PER_VOUCHER = 'fb_inschrijving.betaald_per_voucher';

    /**
     * the column name for the voucher_id field
     */
    const COL_VOUCHER_ID = 'fb_inschrijving.voucher_id';

    /**
     * the column name for the betaalwijze field
     */
    const COL_BETAALWIJZE = 'fb_inschrijving.betaalwijze';

    /**
     * the column name for the annuleringsverzekering field
     */
    const COL_ANNULERINGSVERZEKERING = 'fb_inschrijving.annuleringsverzekering';

    /**
     * the column name for the status field
     */
    const COL_STATUS = 'fb_inschrijving.status';

    /**
     * the column name for the gemaakt_datum field
     */
    const COL_GEMAAKT_DATUM = 'fb_inschrijving.gemaakt_datum';

    /**
     * the column name for the gemaakt_door field
     */
    const COL_GEMAAKT_DOOR = 'fb_inschrijving.gemaakt_door';

    /**
     * the column name for the gewijzigd_datum field
     */
    const COL_GEWIJZIGD_DATUM = 'fb_inschrijving.gewijzigd_datum';

    /**
     * the column name for the gewijzigd_door field
     */
    const COL_GEWIJZIGD_DOOR = 'fb_inschrijving.gewijzigd_door';

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
        self::TYPE_PHPNAME       => array('Id', 'EvenementId', 'ContactPersoonId', 'DatumInschrijving', 'AnnuleringsverzekeringAfgesloten', 'Totaalbedrag', 'ReedsBetaald', 'NogTeBetalen', 'Korting', 'BetaaldPerVoucher', 'VoucherId', 'Betaalwijze', 'Annuleringsverzekering', 'Status', 'DatumGemaakt', 'GemaaktDoor', 'DatumGewijzigd', 'GewijzigdDoor', ),
        self::TYPE_CAMELNAME     => array('id', 'evenementId', 'contactPersoonId', 'datumInschrijving', 'annuleringsverzekeringAfgesloten', 'totaalbedrag', 'reedsBetaald', 'nogTeBetalen', 'korting', 'betaaldPerVoucher', 'voucherId', 'betaalwijze', 'annuleringsverzekering', 'status', 'datumGemaakt', 'gemaaktDoor', 'datumGewijzigd', 'gewijzigdDoor', ),
        self::TYPE_COLNAME       => array(InschrijvingTableMap::COL_ID, InschrijvingTableMap::COL_EVENEMENT_ID, InschrijvingTableMap::COL_CONTACTPERSOON_ID, InschrijvingTableMap::COL_DATUM_INSCHRIJVING, InschrijvingTableMap::COL_ANNULERINGSVERZEKERING_AFGESLOTEN, InschrijvingTableMap::COL_TOTAALBEDRAG, InschrijvingTableMap::COL_REEDS_BETAALD, InschrijvingTableMap::COL_NOG_TE_BETALEN, InschrijvingTableMap::COL_KORTING, InschrijvingTableMap::COL_BETAALD_PER_VOUCHER, InschrijvingTableMap::COL_VOUCHER_ID, InschrijvingTableMap::COL_BETAALWIJZE, InschrijvingTableMap::COL_ANNULERINGSVERZEKERING, InschrijvingTableMap::COL_STATUS, InschrijvingTableMap::COL_GEMAAKT_DATUM, InschrijvingTableMap::COL_GEMAAKT_DOOR, InschrijvingTableMap::COL_GEWIJZIGD_DATUM, InschrijvingTableMap::COL_GEWIJZIGD_DOOR, ),
        self::TYPE_FIELDNAME     => array('id', 'evenement_id', 'contactpersoon_id', 'datum_inschrijving', 'annuleringsverzekering_afgesloten', 'totaalbedrag', 'reeds_betaald', 'nog_te_betalen', 'korting', 'betaald_per_voucher', 'voucher_id', 'betaalwijze', 'annuleringsverzekering', 'status', 'gemaakt_datum', 'gemaakt_door', 'gewijzigd_datum', 'gewijzigd_door', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'EvenementId' => 1, 'ContactPersoonId' => 2, 'DatumInschrijving' => 3, 'AnnuleringsverzekeringAfgesloten' => 4, 'Totaalbedrag' => 5, 'ReedsBetaald' => 6, 'NogTeBetalen' => 7, 'Korting' => 8, 'BetaaldPerVoucher' => 9, 'VoucherId' => 10, 'Betaalwijze' => 11, 'Annuleringsverzekering' => 12, 'Status' => 13, 'DatumGemaakt' => 14, 'GemaaktDoor' => 15, 'DatumGewijzigd' => 16, 'GewijzigdDoor' => 17, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'evenementId' => 1, 'contactPersoonId' => 2, 'datumInschrijving' => 3, 'annuleringsverzekeringAfgesloten' => 4, 'totaalbedrag' => 5, 'reedsBetaald' => 6, 'nogTeBetalen' => 7, 'korting' => 8, 'betaaldPerVoucher' => 9, 'voucherId' => 10, 'betaalwijze' => 11, 'annuleringsverzekering' => 12, 'status' => 13, 'datumGemaakt' => 14, 'gemaaktDoor' => 15, 'datumGewijzigd' => 16, 'gewijzigdDoor' => 17, ),
        self::TYPE_COLNAME       => array(InschrijvingTableMap::COL_ID => 0, InschrijvingTableMap::COL_EVENEMENT_ID => 1, InschrijvingTableMap::COL_CONTACTPERSOON_ID => 2, InschrijvingTableMap::COL_DATUM_INSCHRIJVING => 3, InschrijvingTableMap::COL_ANNULERINGSVERZEKERING_AFGESLOTEN => 4, InschrijvingTableMap::COL_TOTAALBEDRAG => 5, InschrijvingTableMap::COL_REEDS_BETAALD => 6, InschrijvingTableMap::COL_NOG_TE_BETALEN => 7, InschrijvingTableMap::COL_KORTING => 8, InschrijvingTableMap::COL_BETAALD_PER_VOUCHER => 9, InschrijvingTableMap::COL_VOUCHER_ID => 10, InschrijvingTableMap::COL_BETAALWIJZE => 11, InschrijvingTableMap::COL_ANNULERINGSVERZEKERING => 12, InschrijvingTableMap::COL_STATUS => 13, InschrijvingTableMap::COL_GEMAAKT_DATUM => 14, InschrijvingTableMap::COL_GEMAAKT_DOOR => 15, InschrijvingTableMap::COL_GEWIJZIGD_DATUM => 16, InschrijvingTableMap::COL_GEWIJZIGD_DOOR => 17, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'evenement_id' => 1, 'contactpersoon_id' => 2, 'datum_inschrijving' => 3, 'annuleringsverzekering_afgesloten' => 4, 'totaalbedrag' => 5, 'reeds_betaald' => 6, 'nog_te_betalen' => 7, 'korting' => 8, 'betaald_per_voucher' => 9, 'voucher_id' => 10, 'betaalwijze' => 11, 'annuleringsverzekering' => 12, 'status' => 13, 'gemaakt_datum' => 14, 'gemaakt_door' => 15, 'gewijzigd_datum' => 16, 'gewijzigd_door' => 17, ),
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
        $this->setName('fb_inschrijving');
        $this->setPhpName('Inschrijving');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\fb_model\\fb_model\\Inschrijving');
        $this->setPackage('fb_model.fb_model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('evenement_id', 'EvenementId', 'INTEGER', 'fb_evenement', 'id', true, null, null);
        $this->addForeignKey('contactpersoon_id', 'ContactPersoonId', 'INTEGER', 'fb_persoon', 'id', true, null, null);
        $this->addColumn('datum_inschrijving', 'DatumInschrijving', 'TIMESTAMP', true, null, null);
        $this->addColumn('annuleringsverzekering_afgesloten', 'AnnuleringsverzekeringAfgesloten', 'TIMESTAMP', false, null, null);
        $this->addColumn('totaalbedrag', 'Totaalbedrag', 'DECIMAL', true, 9, null);
        $this->addColumn('reeds_betaald', 'ReedsBetaald', 'DECIMAL', false, 9, null);
        $this->addColumn('nog_te_betalen', 'NogTeBetalen', 'DECIMAL', false, 9, null);
        $this->addColumn('korting', 'Korting', 'DECIMAL', false, 9, null);
        $this->addColumn('betaald_per_voucher', 'BetaaldPerVoucher', 'DECIMAL', false, 9, null);
        $this->addForeignKey('voucher_id', 'VoucherId', 'INTEGER', 'fb_voucher', 'id', false, null, null);
        $this->addColumn('betaalwijze', 'Betaalwijze', 'INTEGER', false, 1, null);
        $this->addColumn('annuleringsverzekering', 'Annuleringsverzekering', 'INTEGER', false, 1, null);
        $this->addForeignKey('status', 'Status', 'INTEGER', 'fb_keuzes', 'id', true, 2, null);
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
        $this->addRelation('Keuzes', '\\fb_model\\fb_model\\Keuzes', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':status',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Voucher', '\\fb_model\\fb_model\\Voucher', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':voucher_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Persoon', '\\fb_model\\fb_model\\Persoon', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':contactpersoon_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Deelnemer', '\\fb_model\\fb_model\\Deelnemer', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':inschrijving_id',
    1 => ':id',
  ),
), null, null, 'Deelnemers', false);
        $this->addRelation('FactuurNummer', '\\fb_model\\fb_model\\FactuurNummer', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':inschrijving_id',
    1 => ':id',
  ),
), null, null, 'FactuurNummers', false);
        $this->addRelation('InschrijvingHeeftOptie', '\\fb_model\\fb_model\\InschrijvingHeeftOptie', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':inschrijving_id',
    1 => ':id',
  ),
), null, null, 'InschrijvingHeeftOpties', false);
        $this->addRelation('Optie', '\\fb_model\\fb_model\\Optie', RelationMap::MANY_TO_MANY, array(), null, null, 'Opties');
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
        return $withPrefix ? InschrijvingTableMap::CLASS_DEFAULT : InschrijvingTableMap::OM_CLASS;
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
     * @return array           (Inschrijving object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = InschrijvingTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = InschrijvingTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + InschrijvingTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = InschrijvingTableMap::OM_CLASS;
            /** @var Inschrijving $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            InschrijvingTableMap::addInstanceToPool($obj, $key);
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
            $key = InschrijvingTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = InschrijvingTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Inschrijving $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                InschrijvingTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(InschrijvingTableMap::COL_ID);
            $criteria->addSelectColumn(InschrijvingTableMap::COL_EVENEMENT_ID);
            $criteria->addSelectColumn(InschrijvingTableMap::COL_CONTACTPERSOON_ID);
            $criteria->addSelectColumn(InschrijvingTableMap::COL_DATUM_INSCHRIJVING);
            $criteria->addSelectColumn(InschrijvingTableMap::COL_ANNULERINGSVERZEKERING_AFGESLOTEN);
            $criteria->addSelectColumn(InschrijvingTableMap::COL_TOTAALBEDRAG);
            $criteria->addSelectColumn(InschrijvingTableMap::COL_REEDS_BETAALD);
            $criteria->addSelectColumn(InschrijvingTableMap::COL_NOG_TE_BETALEN);
            $criteria->addSelectColumn(InschrijvingTableMap::COL_KORTING);
            $criteria->addSelectColumn(InschrijvingTableMap::COL_BETAALD_PER_VOUCHER);
            $criteria->addSelectColumn(InschrijvingTableMap::COL_VOUCHER_ID);
            $criteria->addSelectColumn(InschrijvingTableMap::COL_BETAALWIJZE);
            $criteria->addSelectColumn(InschrijvingTableMap::COL_ANNULERINGSVERZEKERING);
            $criteria->addSelectColumn(InschrijvingTableMap::COL_STATUS);
            $criteria->addSelectColumn(InschrijvingTableMap::COL_GEMAAKT_DATUM);
            $criteria->addSelectColumn(InschrijvingTableMap::COL_GEMAAKT_DOOR);
            $criteria->addSelectColumn(InschrijvingTableMap::COL_GEWIJZIGD_DATUM);
            $criteria->addSelectColumn(InschrijvingTableMap::COL_GEWIJZIGD_DOOR);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.evenement_id');
            $criteria->addSelectColumn($alias . '.contactpersoon_id');
            $criteria->addSelectColumn($alias . '.datum_inschrijving');
            $criteria->addSelectColumn($alias . '.annuleringsverzekering_afgesloten');
            $criteria->addSelectColumn($alias . '.totaalbedrag');
            $criteria->addSelectColumn($alias . '.reeds_betaald');
            $criteria->addSelectColumn($alias . '.nog_te_betalen');
            $criteria->addSelectColumn($alias . '.korting');
            $criteria->addSelectColumn($alias . '.betaald_per_voucher');
            $criteria->addSelectColumn($alias . '.voucher_id');
            $criteria->addSelectColumn($alias . '.betaalwijze');
            $criteria->addSelectColumn($alias . '.annuleringsverzekering');
            $criteria->addSelectColumn($alias . '.status');
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
        return Propel::getServiceContainer()->getDatabaseMap(InschrijvingTableMap::DATABASE_NAME)->getTable(InschrijvingTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(InschrijvingTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(InschrijvingTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new InschrijvingTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Inschrijving or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Inschrijving object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(InschrijvingTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \fb_model\fb_model\Inschrijving) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(InschrijvingTableMap::DATABASE_NAME);
            $criteria->add(InschrijvingTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = InschrijvingQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            InschrijvingTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                InschrijvingTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the fb_inschrijving table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return InschrijvingQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Inschrijving or Criteria object.
     *
     * @param mixed               $criteria Criteria or Inschrijving object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InschrijvingTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Inschrijving object
        }

        if ($criteria->containsKey(InschrijvingTableMap::COL_ID) && $criteria->keyContainsValue(InschrijvingTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.InschrijvingTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = InschrijvingQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // InschrijvingTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
InschrijvingTableMap::buildTableMap();
