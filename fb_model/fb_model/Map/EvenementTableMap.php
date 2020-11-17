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
use fb_model\fb_model\Evenement;
use fb_model\fb_model\EvenementQuery;


/**
 * This class defines the structure of the 'fb_evenement' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class EvenementTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'fb_model.fb_model.Map.EvenementTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'fb_evenement';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\fb_model\\fb_model\\Evenement';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'fb_model.fb_model.Evenement';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 23;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 23;

    /**
     * the column name for the id field
     */
    const COL_ID = 'fb_evenement.id';

    /**
     * the column name for the naam field
     */
    const COL_NAAM = 'fb_evenement.naam';

    /**
     * the column name for the categorie field
     */
    const COL_CATEGORIE = 'fb_evenement.categorie';

    /**
     * the column name for the korte_omschrijving field
     */
    const COL_KORTE_OMSCHRIJVING = 'fb_evenement.korte_omschrijving';

    /**
     * the column name for the lange_omschrijving field
     */
    const COL_LANGE_OMSCHRIJVING = 'fb_evenement.lange_omschrijving';

    /**
     * the column name for the datum_begin field
     */
    const COL_DATUM_BEGIN = 'fb_evenement.datum_begin';

    /**
     * the column name for the datum_eind field
     */
    const COL_DATUM_EIND = 'fb_evenement.datum_eind';

    /**
     * the column name for the aantal_dagen field
     */
    const COL_AANTAL_DAGEN = 'fb_evenement.aantal_dagen';

    /**
     * the column name for the frequentie field
     */
    const COL_FREQUENTIE = 'fb_evenement.frequentie';

    /**
     * the column name for the inschrijving_begin field
     */
    const COL_INSCHRIJVING_BEGIN = 'fb_evenement.inschrijving_begin';

    /**
     * the column name for the inschrijving_eind field
     */
    const COL_INSCHRIJVING_EIND = 'fb_evenement.inschrijving_eind';

    /**
     * the column name for the extra_deelnemer_gegevens field
     */
    const COL_EXTRA_DEELNEMER_GEGEVENS = 'fb_evenement.extra_deelnemer_gegevens';

    /**
     * the column name for the extra_contact_gegevens field
     */
    const COL_EXTRA_CONTACT_GEGEVENS = 'fb_evenement.extra_contact_gegevens';

    /**
     * the column name for the prijs field
     */
    const COL_PRIJS = 'fb_evenement.prijs';

    /**
     * the column name for the betaalwijze field
     */
    const COL_BETAALWIJZE = 'fb_evenement.betaalwijze';

    /**
     * the column name for the max_deelnemers field
     */
    const COL_MAX_DEELNEMERS = 'fb_evenement.max_deelnemers';

    /**
     * the column name for the annuleringsverzekering field
     */
    const COL_ANNULERINGSVERZEKERING = 'fb_evenement.annuleringsverzekering';

    /**
     * the column name for the account_nodig field
     */
    const COL_ACCOUNT_NODIG = 'fb_evenement.account_nodig';

    /**
     * the column name for the status field
     */
    const COL_STATUS = 'fb_evenement.status';

    /**
     * the column name for the gemaakt_datum field
     */
    const COL_GEMAAKT_DATUM = 'fb_evenement.gemaakt_datum';

    /**
     * the column name for the gemaakt_door field
     */
    const COL_GEMAAKT_DOOR = 'fb_evenement.gemaakt_door';

    /**
     * the column name for the gewijzigd_datum field
     */
    const COL_GEWIJZIGD_DATUM = 'fb_evenement.gewijzigd_datum';

    /**
     * the column name for the gewijzigd_door field
     */
    const COL_GEWIJZIGD_DOOR = 'fb_evenement.gewijzigd_door';

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
        self::TYPE_PHPNAME       => array('Id', 'Naam', 'Categorie', 'KorteOmschrijving', 'LangeOmschrijving', 'DatumBegin', 'DatumEind', 'AantalDagen', 'Frequentie', 'InschrijvingBegin', 'InschrijvingEind', 'ExtraDeelnemerGegevens', 'ExtraContactGegevens', 'Prijs', 'Betaalwijze', 'MaxDeelnemers', 'Annuleringsverzekering', 'AccountNodig', 'Status', 'DatumGemaakt', 'GemaaktDoor', 'DatumGewijzigd', 'GewijzigdDoor', ),
        self::TYPE_CAMELNAME     => array('id', 'naam', 'categorie', 'korteOmschrijving', 'langeOmschrijving', 'datumBegin', 'datumEind', 'aantalDagen', 'frequentie', 'inschrijvingBegin', 'inschrijvingEind', 'extraDeelnemerGegevens', 'extraContactGegevens', 'prijs', 'betaalwijze', 'maxDeelnemers', 'annuleringsverzekering', 'accountNodig', 'status', 'datumGemaakt', 'gemaaktDoor', 'datumGewijzigd', 'gewijzigdDoor', ),
        self::TYPE_COLNAME       => array(EvenementTableMap::COL_ID, EvenementTableMap::COL_NAAM, EvenementTableMap::COL_CATEGORIE, EvenementTableMap::COL_KORTE_OMSCHRIJVING, EvenementTableMap::COL_LANGE_OMSCHRIJVING, EvenementTableMap::COL_DATUM_BEGIN, EvenementTableMap::COL_DATUM_EIND, EvenementTableMap::COL_AANTAL_DAGEN, EvenementTableMap::COL_FREQUENTIE, EvenementTableMap::COL_INSCHRIJVING_BEGIN, EvenementTableMap::COL_INSCHRIJVING_EIND, EvenementTableMap::COL_EXTRA_DEELNEMER_GEGEVENS, EvenementTableMap::COL_EXTRA_CONTACT_GEGEVENS, EvenementTableMap::COL_PRIJS, EvenementTableMap::COL_BETAALWIJZE, EvenementTableMap::COL_MAX_DEELNEMERS, EvenementTableMap::COL_ANNULERINGSVERZEKERING, EvenementTableMap::COL_ACCOUNT_NODIG, EvenementTableMap::COL_STATUS, EvenementTableMap::COL_GEMAAKT_DATUM, EvenementTableMap::COL_GEMAAKT_DOOR, EvenementTableMap::COL_GEWIJZIGD_DATUM, EvenementTableMap::COL_GEWIJZIGD_DOOR, ),
        self::TYPE_FIELDNAME     => array('id', 'naam', 'categorie', 'korte_omschrijving', 'lange_omschrijving', 'datum_begin', 'datum_eind', 'aantal_dagen', 'frequentie', 'inschrijving_begin', 'inschrijving_eind', 'extra_deelnemer_gegevens', 'extra_contact_gegevens', 'prijs', 'betaalwijze', 'max_deelnemers', 'annuleringsverzekering', 'account_nodig', 'status', 'gemaakt_datum', 'gemaakt_door', 'gewijzigd_datum', 'gewijzigd_door', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Naam' => 1, 'Categorie' => 2, 'KorteOmschrijving' => 3, 'LangeOmschrijving' => 4, 'DatumBegin' => 5, 'DatumEind' => 6, 'AantalDagen' => 7, 'Frequentie' => 8, 'InschrijvingBegin' => 9, 'InschrijvingEind' => 10, 'ExtraDeelnemerGegevens' => 11, 'ExtraContactGegevens' => 12, 'Prijs' => 13, 'Betaalwijze' => 14, 'MaxDeelnemers' => 15, 'Annuleringsverzekering' => 16, 'AccountNodig' => 17, 'Status' => 18, 'DatumGemaakt' => 19, 'GemaaktDoor' => 20, 'DatumGewijzigd' => 21, 'GewijzigdDoor' => 22, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'naam' => 1, 'categorie' => 2, 'korteOmschrijving' => 3, 'langeOmschrijving' => 4, 'datumBegin' => 5, 'datumEind' => 6, 'aantalDagen' => 7, 'frequentie' => 8, 'inschrijvingBegin' => 9, 'inschrijvingEind' => 10, 'extraDeelnemerGegevens' => 11, 'extraContactGegevens' => 12, 'prijs' => 13, 'betaalwijze' => 14, 'maxDeelnemers' => 15, 'annuleringsverzekering' => 16, 'accountNodig' => 17, 'status' => 18, 'datumGemaakt' => 19, 'gemaaktDoor' => 20, 'datumGewijzigd' => 21, 'gewijzigdDoor' => 22, ),
        self::TYPE_COLNAME       => array(EvenementTableMap::COL_ID => 0, EvenementTableMap::COL_NAAM => 1, EvenementTableMap::COL_CATEGORIE => 2, EvenementTableMap::COL_KORTE_OMSCHRIJVING => 3, EvenementTableMap::COL_LANGE_OMSCHRIJVING => 4, EvenementTableMap::COL_DATUM_BEGIN => 5, EvenementTableMap::COL_DATUM_EIND => 6, EvenementTableMap::COL_AANTAL_DAGEN => 7, EvenementTableMap::COL_FREQUENTIE => 8, EvenementTableMap::COL_INSCHRIJVING_BEGIN => 9, EvenementTableMap::COL_INSCHRIJVING_EIND => 10, EvenementTableMap::COL_EXTRA_DEELNEMER_GEGEVENS => 11, EvenementTableMap::COL_EXTRA_CONTACT_GEGEVENS => 12, EvenementTableMap::COL_PRIJS => 13, EvenementTableMap::COL_BETAALWIJZE => 14, EvenementTableMap::COL_MAX_DEELNEMERS => 15, EvenementTableMap::COL_ANNULERINGSVERZEKERING => 16, EvenementTableMap::COL_ACCOUNT_NODIG => 17, EvenementTableMap::COL_STATUS => 18, EvenementTableMap::COL_GEMAAKT_DATUM => 19, EvenementTableMap::COL_GEMAAKT_DOOR => 20, EvenementTableMap::COL_GEWIJZIGD_DATUM => 21, EvenementTableMap::COL_GEWIJZIGD_DOOR => 22, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'naam' => 1, 'categorie' => 2, 'korte_omschrijving' => 3, 'lange_omschrijving' => 4, 'datum_begin' => 5, 'datum_eind' => 6, 'aantal_dagen' => 7, 'frequentie' => 8, 'inschrijving_begin' => 9, 'inschrijving_eind' => 10, 'extra_deelnemer_gegevens' => 11, 'extra_contact_gegevens' => 12, 'prijs' => 13, 'betaalwijze' => 14, 'max_deelnemers' => 15, 'annuleringsverzekering' => 16, 'account_nodig' => 17, 'status' => 18, 'gemaakt_datum' => 19, 'gemaakt_door' => 20, 'gewijzigd_datum' => 21, 'gewijzigd_door' => 22, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, )
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
        $this->setName('fb_evenement');
        $this->setPhpName('Evenement');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\fb_model\\fb_model\\Evenement');
        $this->setPackage('fb_model.fb_model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('naam', 'Naam', 'VARCHAR', true, 255, null);
        $this->addColumn('categorie', 'Categorie', 'VARCHAR', true, 255, null);
        $this->addColumn('korte_omschrijving', 'KorteOmschrijving', 'LONGVARCHAR', true, null, null);
        $this->addColumn('lange_omschrijving', 'LangeOmschrijving', 'LONGVARCHAR', true, null, null);
        $this->addColumn('datum_begin', 'DatumBegin', 'DATE', true, null, null);
        $this->addColumn('datum_eind', 'DatumEind', 'DATE', true, null, null);
        $this->addColumn('aantal_dagen', 'AantalDagen', 'INTEGER', true, 3, null);
        $this->addColumn('frequentie', 'Frequentie', 'VARCHAR', true, 255, null);
        $this->addColumn('inschrijving_begin', 'InschrijvingBegin', 'TIMESTAMP', true, null, null);
        $this->addColumn('inschrijving_eind', 'InschrijvingEind', 'TIMESTAMP', true, null, null);
        $this->addColumn('extra_deelnemer_gegevens', 'ExtraDeelnemerGegevens', 'INTEGER', true, 2, null);
        $this->addColumn('extra_contact_gegevens', 'ExtraContactGegevens', 'INTEGER', true, 2, null);
        $this->addColumn('prijs', 'Prijs', 'DECIMAL', true, 9, null);
        $this->addColumn('betaalwijze', 'Betaalwijze', 'INTEGER', true, 4, null);
        $this->addColumn('max_deelnemers', 'MaxDeelnemers', 'INTEGER', true, null, null);
        $this->addColumn('annuleringsverzekering', 'Annuleringsverzekering', 'INTEGER', true, 1, null);
        $this->addColumn('account_nodig', 'AccountNodig', 'INTEGER', true, 1, null);
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
        $this->addRelation('Keuzes', '\\fb_model\\fb_model\\Keuzes', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':status',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('EvenementHeeftOptie', '\\fb_model\\fb_model\\EvenementHeeftOptie', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':evenement_id',
    1 => ':id',
  ),
), null, null, 'EvenementHeeftOpties', false);
        $this->addRelation('Inschrijving', '\\fb_model\\fb_model\\Inschrijving', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':evenement_id',
    1 => ':id',
  ),
), null, null, 'Inschrijvings', false);
        $this->addRelation('Mailinglist', '\\fb_model\\fb_model\\Mailinglist', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':evenement_id',
    1 => ':id',
  ),
), null, null, 'Mailinglists', false);
        $this->addRelation('Voucher', '\\fb_model\\fb_model\\Voucher', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':evenement_id',
    1 => ':id',
  ),
), null, null, 'Vouchers', false);
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
        return $withPrefix ? EvenementTableMap::CLASS_DEFAULT : EvenementTableMap::OM_CLASS;
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
     * @return array           (Evenement object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = EvenementTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = EvenementTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + EvenementTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = EvenementTableMap::OM_CLASS;
            /** @var Evenement $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            EvenementTableMap::addInstanceToPool($obj, $key);
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
            $key = EvenementTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = EvenementTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Evenement $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                EvenementTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(EvenementTableMap::COL_ID);
            $criteria->addSelectColumn(EvenementTableMap::COL_NAAM);
            $criteria->addSelectColumn(EvenementTableMap::COL_CATEGORIE);
            $criteria->addSelectColumn(EvenementTableMap::COL_KORTE_OMSCHRIJVING);
            $criteria->addSelectColumn(EvenementTableMap::COL_LANGE_OMSCHRIJVING);
            $criteria->addSelectColumn(EvenementTableMap::COL_DATUM_BEGIN);
            $criteria->addSelectColumn(EvenementTableMap::COL_DATUM_EIND);
            $criteria->addSelectColumn(EvenementTableMap::COL_AANTAL_DAGEN);
            $criteria->addSelectColumn(EvenementTableMap::COL_FREQUENTIE);
            $criteria->addSelectColumn(EvenementTableMap::COL_INSCHRIJVING_BEGIN);
            $criteria->addSelectColumn(EvenementTableMap::COL_INSCHRIJVING_EIND);
            $criteria->addSelectColumn(EvenementTableMap::COL_EXTRA_DEELNEMER_GEGEVENS);
            $criteria->addSelectColumn(EvenementTableMap::COL_EXTRA_CONTACT_GEGEVENS);
            $criteria->addSelectColumn(EvenementTableMap::COL_PRIJS);
            $criteria->addSelectColumn(EvenementTableMap::COL_BETAALWIJZE);
            $criteria->addSelectColumn(EvenementTableMap::COL_MAX_DEELNEMERS);
            $criteria->addSelectColumn(EvenementTableMap::COL_ANNULERINGSVERZEKERING);
            $criteria->addSelectColumn(EvenementTableMap::COL_ACCOUNT_NODIG);
            $criteria->addSelectColumn(EvenementTableMap::COL_STATUS);
            $criteria->addSelectColumn(EvenementTableMap::COL_GEMAAKT_DATUM);
            $criteria->addSelectColumn(EvenementTableMap::COL_GEMAAKT_DOOR);
            $criteria->addSelectColumn(EvenementTableMap::COL_GEWIJZIGD_DATUM);
            $criteria->addSelectColumn(EvenementTableMap::COL_GEWIJZIGD_DOOR);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.naam');
            $criteria->addSelectColumn($alias . '.categorie');
            $criteria->addSelectColumn($alias . '.korte_omschrijving');
            $criteria->addSelectColumn($alias . '.lange_omschrijving');
            $criteria->addSelectColumn($alias . '.datum_begin');
            $criteria->addSelectColumn($alias . '.datum_eind');
            $criteria->addSelectColumn($alias . '.aantal_dagen');
            $criteria->addSelectColumn($alias . '.frequentie');
            $criteria->addSelectColumn($alias . '.inschrijving_begin');
            $criteria->addSelectColumn($alias . '.inschrijving_eind');
            $criteria->addSelectColumn($alias . '.extra_deelnemer_gegevens');
            $criteria->addSelectColumn($alias . '.extra_contact_gegevens');
            $criteria->addSelectColumn($alias . '.prijs');
            $criteria->addSelectColumn($alias . '.betaalwijze');
            $criteria->addSelectColumn($alias . '.max_deelnemers');
            $criteria->addSelectColumn($alias . '.annuleringsverzekering');
            $criteria->addSelectColumn($alias . '.account_nodig');
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
        return Propel::getServiceContainer()->getDatabaseMap(EvenementTableMap::DATABASE_NAME)->getTable(EvenementTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(EvenementTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(EvenementTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new EvenementTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Evenement or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Evenement object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(EvenementTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \fb_model\fb_model\Evenement) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(EvenementTableMap::DATABASE_NAME);
            $criteria->add(EvenementTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = EvenementQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            EvenementTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                EvenementTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the fb_evenement table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return EvenementQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Evenement or Criteria object.
     *
     * @param mixed               $criteria Criteria or Evenement object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EvenementTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Evenement object
        }

        if ($criteria->containsKey(EvenementTableMap::COL_ID) && $criteria->keyContainsValue(EvenementTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.EvenementTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = EvenementQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // EvenementTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
EvenementTableMap::buildTableMap();
