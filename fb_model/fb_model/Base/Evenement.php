<?php

namespace fb_model\fb_model\Base;

use \DateTime;
use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Collection\ObjectCombinationCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;
use fb_model\fb_model\Evenement as ChildEvenement;
use fb_model\fb_model\EvenementHeeftOptie as ChildEvenementHeeftOptie;
use fb_model\fb_model\EvenementHeeftOptieQuery as ChildEvenementHeeftOptieQuery;
use fb_model\fb_model\EvenementQuery as ChildEvenementQuery;
use fb_model\fb_model\Inschrijving as ChildInschrijving;
use fb_model\fb_model\InschrijvingQuery as ChildInschrijvingQuery;
use fb_model\fb_model\Keuzes as ChildKeuzes;
use fb_model\fb_model\KeuzesQuery as ChildKeuzesQuery;
use fb_model\fb_model\Mailinglist as ChildMailinglist;
use fb_model\fb_model\MailinglistQuery as ChildMailinglistQuery;
use fb_model\fb_model\Optie as ChildOptie;
use fb_model\fb_model\OptieQuery as ChildOptieQuery;
use fb_model\fb_model\Voucher as ChildVoucher;
use fb_model\fb_model\VoucherQuery as ChildVoucherQuery;
use fb_model\fb_model\Map\EvenementHeeftOptieTableMap;
use fb_model\fb_model\Map\EvenementTableMap;
use fb_model\fb_model\Map\InschrijvingTableMap;
use fb_model\fb_model\Map\MailinglistTableMap;
use fb_model\fb_model\Map\VoucherTableMap;

/**
 * Base class that represents a row from the 'fb_evenement' table.
 *
 *
 *
 * @package    propel.generator.fb_model.fb_model.Base
 */
abstract class Evenement implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\fb_model\\fb_model\\Map\\EvenementTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the naam field.
     *
     * @var        string
     */
    protected $naam;

    /**
     * The value for the categorie field.
     *
     * @var        string
     */
    protected $categorie;

    /**
     * The value for the korte_omschrijving field.
     *
     * @var        string
     */
    protected $korte_omschrijving;

    /**
     * The value for the lange_omschrijving field.
     *
     * @var        string
     */
    protected $lange_omschrijving;

    /**
     * The value for the datum_begin field.
     *
     * @var        DateTime
     */
    protected $datum_begin;

    /**
     * The value for the datum_eind field.
     *
     * @var        DateTime
     */
    protected $datum_eind;

    /**
     * The value for the aantal_dagen field.
     *
     * @var        int
     */
    protected $aantal_dagen;

    /**
     * The value for the frequentie field.
     *
     * @var        string
     */
    protected $frequentie;

    /**
     * The value for the inschrijving_begin field.
     *
     * @var        DateTime
     */
    protected $inschrijving_begin;

    /**
     * The value for the inschrijving_eind field.
     *
     * @var        DateTime
     */
    protected $inschrijving_eind;

    /**
     * The value for the extra_deelnemer_gegevens field.
     *
     * @var        int
     */
    protected $extra_deelnemer_gegevens;

    /**
     * The value for the extra_contact_gegevens field.
     *
     * @var        int
     */
    protected $extra_contact_gegevens;

    /**
     * The value for the prijs field.
     *
     * @var        string
     */
    protected $prijs;

    /**
     * The value for the betaalwijze field.
     *
     * @var        int
     */
    protected $betaalwijze;

    /**
     * The value for the max_deelnemers field.
     *
     * @var        int
     */
    protected $max_deelnemers;

    /**
     * The value for the annuleringsverzekering field.
     *
     * @var        int
     */
    protected $annuleringsverzekering;

    /**
     * The value for the account_nodig field.
     *
     * @var        int
     */
    protected $account_nodig;

    /**
     * The value for the status field.
     *
     * @var        int
     */
    protected $status;

    /**
     * The value for the gemaakt_datum field.
     *
     * @var        DateTime
     */
    protected $gemaakt_datum;

    /**
     * The value for the gemaakt_door field.
     *
     * @var        string
     */
    protected $gemaakt_door;

    /**
     * The value for the gewijzigd_datum field.
     *
     * @var        DateTime
     */
    protected $gewijzigd_datum;

    /**
     * The value for the gewijzigd_door field.
     *
     * @var        string
     */
    protected $gewijzigd_door;

    /**
     * @var        ChildKeuzes
     */
    protected $aKeuzes;

    /**
     * @var        ObjectCollection|ChildEvenementHeeftOptie[] Collection to store aggregation of ChildEvenementHeeftOptie objects.
     */
    protected $collEvenementHeeftOpties;
    protected $collEvenementHeeftOptiesPartial;

    /**
     * @var        ObjectCollection|ChildInschrijving[] Collection to store aggregation of ChildInschrijving objects.
     */
    protected $collInschrijvings;
    protected $collInschrijvingsPartial;

    /**
     * @var        ObjectCollection|ChildMailinglist[] Collection to store aggregation of ChildMailinglist objects.
     */
    protected $collMailinglists;
    protected $collMailinglistsPartial;

    /**
     * @var        ObjectCollection|ChildVoucher[] Collection to store aggregation of ChildVoucher objects.
     */
    protected $collVouchers;
    protected $collVouchersPartial;

    /**
     * @var ObjectCombinationCollection Cross CombinationCollection to store aggregation of ChildOptie combinations.
     */
    protected $combinationCollOptieIds;

    /**
     * @var bool
     */
    protected $combinationCollOptieIdsPartial;

    /**
     * @var        ObjectCollection|ChildOptie[] Cross Collection to store aggregation of ChildOptie objects.
     */
    protected $collOpties;

    /**
     * @var bool
     */
    protected $collOptiesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * @var ObjectCombinationCollection Cross CombinationCollection to store aggregation of ChildOptie combinations.
     */
    protected $combinationCollOptieIdsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildEvenementHeeftOptie[]
     */
    protected $evenementHeeftOptiesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildInschrijving[]
     */
    protected $inschrijvingsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMailinglist[]
     */
    protected $mailinglistsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildVoucher[]
     */
    protected $vouchersScheduledForDeletion = null;

    /**
     * Initializes internal state of fb_model\fb_model\Base\Evenement object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Evenement</code> instance.  If
     * <code>obj</code> is an instance of <code>Evenement</code>, delegates to
     * <code>equals(Evenement)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Evenement The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [naam] column value.
     *
     * @return string
     */
    public function getNaam()
    {
        return $this->naam;
    }

    /**
     * Get the [categorie] column value.
     *
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Get the [korte_omschrijving] column value.
     *
     * @return string
     */
    public function getKorteOmschrijving()
    {
        return $this->korte_omschrijving;
    }

    /**
     * Get the [lange_omschrijving] column value.
     *
     * @return string
     */
    public function getLangeOmschrijving()
    {
        return $this->lange_omschrijving;
    }

    /**
     * Get the [optionally formatted] temporal [datum_begin] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDatumBegin($format = NULL)
    {
        if ($format === null) {
            return $this->datum_begin;
        } else {
            return $this->datum_begin instanceof \DateTimeInterface ? $this->datum_begin->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [datum_eind] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDatumEind($format = NULL)
    {
        if ($format === null) {
            return $this->datum_eind;
        } else {
            return $this->datum_eind instanceof \DateTimeInterface ? $this->datum_eind->format($format) : null;
        }
    }

    /**
     * Get the [aantal_dagen] column value.
     *
     * @return int
     */
    public function getAantalDagen()
    {
        return $this->aantal_dagen;
    }

    /**
     * Get the [frequentie] column value.
     *
     * @return string
     */
    public function getFrequentie()
    {
        return $this->frequentie;
    }

    /**
     * Get the [optionally formatted] temporal [inschrijving_begin] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getInschrijvingBegin($format = NULL)
    {
        if ($format === null) {
            return $this->inschrijving_begin;
        } else {
            return $this->inschrijving_begin instanceof \DateTimeInterface ? $this->inschrijving_begin->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [inschrijving_eind] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getInschrijvingEind($format = NULL)
    {
        if ($format === null) {
            return $this->inschrijving_eind;
        } else {
            return $this->inschrijving_eind instanceof \DateTimeInterface ? $this->inschrijving_eind->format($format) : null;
        }
    }

    /**
     * Get the [extra_deelnemer_gegevens] column value.
     *
     * @return int
     */
    public function getExtraDeelnemerGegevens()
    {
        return $this->extra_deelnemer_gegevens;
    }

    /**
     * Get the [extra_contact_gegevens] column value.
     *
     * @return int
     */
    public function getExtraContactGegevens()
    {
        return $this->extra_contact_gegevens;
    }

    /**
     * Get the [prijs] column value.
     *
     * @return string
     */
    public function getPrijs()
    {
        return $this->prijs;
    }

    /**
     * Get the [betaalwijze] column value.
     *
     * @return int
     */
    public function getBetaalwijze()
    {
        return $this->betaalwijze;
    }

    /**
     * Get the [max_deelnemers] column value.
     *
     * @return int
     */
    public function getMaxDeelnemers()
    {
        return $this->max_deelnemers;
    }

    /**
     * Get the [annuleringsverzekering] column value.
     *
     * @return int
     */
    public function getAnnuleringsverzekering()
    {
        return $this->annuleringsverzekering;
    }

    /**
     * Get the [account_nodig] column value.
     *
     * @return int
     */
    public function getAccountNodig()
    {
        return $this->account_nodig;
    }

    /**
     * Get the [status] column value.
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the [optionally formatted] temporal [gemaakt_datum] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDatumGemaakt($format = NULL)
    {
        if ($format === null) {
            return $this->gemaakt_datum;
        } else {
            return $this->gemaakt_datum instanceof \DateTimeInterface ? $this->gemaakt_datum->format($format) : null;
        }
    }

    /**
     * Get the [gemaakt_door] column value.
     *
     * @return string
     */
    public function getGemaaktDoor()
    {
        return $this->gemaakt_door;
    }

    /**
     * Get the [optionally formatted] temporal [gewijzigd_datum] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDatumGewijzigd($format = NULL)
    {
        if ($format === null) {
            return $this->gewijzigd_datum;
        } else {
            return $this->gewijzigd_datum instanceof \DateTimeInterface ? $this->gewijzigd_datum->format($format) : null;
        }
    }

    /**
     * Get the [gewijzigd_door] column value.
     *
     * @return string
     */
    public function getGewijzigdDoor()
    {
        return $this->gewijzigd_door;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[EvenementTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [naam] column.
     *
     * @param string $v new value
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function setNaam($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->naam !== $v) {
            $this->naam = $v;
            $this->modifiedColumns[EvenementTableMap::COL_NAAM] = true;
        }

        return $this;
    } // setNaam()

    /**
     * Set the value of [categorie] column.
     *
     * @param string $v new value
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function setCategorie($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->categorie !== $v) {
            $this->categorie = $v;
            $this->modifiedColumns[EvenementTableMap::COL_CATEGORIE] = true;
        }

        return $this;
    } // setCategorie()

    /**
     * Set the value of [korte_omschrijving] column.
     *
     * @param string $v new value
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function setKorteOmschrijving($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->korte_omschrijving !== $v) {
            $this->korte_omschrijving = $v;
            $this->modifiedColumns[EvenementTableMap::COL_KORTE_OMSCHRIJVING] = true;
        }

        return $this;
    } // setKorteOmschrijving()

    /**
     * Set the value of [lange_omschrijving] column.
     *
     * @param string $v new value
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function setLangeOmschrijving($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->lange_omschrijving !== $v) {
            $this->lange_omschrijving = $v;
            $this->modifiedColumns[EvenementTableMap::COL_LANGE_OMSCHRIJVING] = true;
        }

        return $this;
    } // setLangeOmschrijving()

    /**
     * Sets the value of [datum_begin] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function setDatumBegin($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->datum_begin !== null || $dt !== null) {
            if ($this->datum_begin === null || $dt === null || $dt->format("Y-m-d") !== $this->datum_begin->format("Y-m-d")) {
                $this->datum_begin = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EvenementTableMap::COL_DATUM_BEGIN] = true;
            }
        } // if either are not null

        return $this;
    } // setDatumBegin()

    /**
     * Sets the value of [datum_eind] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function setDatumEind($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->datum_eind !== null || $dt !== null) {
            if ($this->datum_eind === null || $dt === null || $dt->format("Y-m-d") !== $this->datum_eind->format("Y-m-d")) {
                $this->datum_eind = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EvenementTableMap::COL_DATUM_EIND] = true;
            }
        } // if either are not null

        return $this;
    } // setDatumEind()

    /**
     * Set the value of [aantal_dagen] column.
     *
     * @param int $v new value
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function setAantalDagen($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->aantal_dagen !== $v) {
            $this->aantal_dagen = $v;
            $this->modifiedColumns[EvenementTableMap::COL_AANTAL_DAGEN] = true;
        }

        return $this;
    } // setAantalDagen()

    /**
     * Set the value of [frequentie] column.
     *
     * @param string $v new value
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function setFrequentie($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->frequentie !== $v) {
            $this->frequentie = $v;
            $this->modifiedColumns[EvenementTableMap::COL_FREQUENTIE] = true;
        }

        return $this;
    } // setFrequentie()

    /**
     * Sets the value of [inschrijving_begin] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function setInschrijvingBegin($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->inschrijving_begin !== null || $dt !== null) {
            if ($this->inschrijving_begin === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->inschrijving_begin->format("Y-m-d H:i:s.u")) {
                $this->inschrijving_begin = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EvenementTableMap::COL_INSCHRIJVING_BEGIN] = true;
            }
        } // if either are not null

        return $this;
    } // setInschrijvingBegin()

    /**
     * Sets the value of [inschrijving_eind] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function setInschrijvingEind($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->inschrijving_eind !== null || $dt !== null) {
            if ($this->inschrijving_eind === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->inschrijving_eind->format("Y-m-d H:i:s.u")) {
                $this->inschrijving_eind = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EvenementTableMap::COL_INSCHRIJVING_EIND] = true;
            }
        } // if either are not null

        return $this;
    } // setInschrijvingEind()

    /**
     * Set the value of [extra_deelnemer_gegevens] column.
     *
     * @param int $v new value
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function setExtraDeelnemerGegevens($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->extra_deelnemer_gegevens !== $v) {
            $this->extra_deelnemer_gegevens = $v;
            $this->modifiedColumns[EvenementTableMap::COL_EXTRA_DEELNEMER_GEGEVENS] = true;
        }

        return $this;
    } // setExtraDeelnemerGegevens()

    /**
     * Set the value of [extra_contact_gegevens] column.
     *
     * @param int $v new value
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function setExtraContactGegevens($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->extra_contact_gegevens !== $v) {
            $this->extra_contact_gegevens = $v;
            $this->modifiedColumns[EvenementTableMap::COL_EXTRA_CONTACT_GEGEVENS] = true;
        }

        return $this;
    } // setExtraContactGegevens()

    /**
     * Set the value of [prijs] column.
     *
     * @param string $v new value
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function setPrijs($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->prijs !== $v) {
            $this->prijs = $v;
            $this->modifiedColumns[EvenementTableMap::COL_PRIJS] = true;
        }

        return $this;
    } // setPrijs()

    /**
     * Set the value of [betaalwijze] column.
     *
     * @param int $v new value
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function setBetaalwijze($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->betaalwijze !== $v) {
            $this->betaalwijze = $v;
            $this->modifiedColumns[EvenementTableMap::COL_BETAALWIJZE] = true;
        }

        return $this;
    } // setBetaalwijze()

    /**
     * Set the value of [max_deelnemers] column.
     *
     * @param int $v new value
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function setMaxDeelnemers($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->max_deelnemers !== $v) {
            $this->max_deelnemers = $v;
            $this->modifiedColumns[EvenementTableMap::COL_MAX_DEELNEMERS] = true;
        }

        return $this;
    } // setMaxDeelnemers()

    /**
     * Set the value of [annuleringsverzekering] column.
     *
     * @param int $v new value
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function setAnnuleringsverzekering($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->annuleringsverzekering !== $v) {
            $this->annuleringsverzekering = $v;
            $this->modifiedColumns[EvenementTableMap::COL_ANNULERINGSVERZEKERING] = true;
        }

        return $this;
    } // setAnnuleringsverzekering()

    /**
     * Set the value of [account_nodig] column.
     *
     * @param int $v new value
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function setAccountNodig($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->account_nodig !== $v) {
            $this->account_nodig = $v;
            $this->modifiedColumns[EvenementTableMap::COL_ACCOUNT_NODIG] = true;
        }

        return $this;
    } // setAccountNodig()

    /**
     * Set the value of [status] column.
     *
     * @param int $v new value
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[EvenementTableMap::COL_STATUS] = true;
        }

        if ($this->aKeuzes !== null && $this->aKeuzes->getId() !== $v) {
            $this->aKeuzes = null;
        }

        return $this;
    } // setStatus()

    /**
     * Sets the value of [gemaakt_datum] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function setDatumGemaakt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->gemaakt_datum !== null || $dt !== null) {
            if ($this->gemaakt_datum === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->gemaakt_datum->format("Y-m-d H:i:s.u")) {
                $this->gemaakt_datum = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EvenementTableMap::COL_GEMAAKT_DATUM] = true;
            }
        } // if either are not null

        return $this;
    } // setDatumGemaakt()

    /**
     * Set the value of [gemaakt_door] column.
     *
     * @param string $v new value
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function setGemaaktDoor($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gemaakt_door !== $v) {
            $this->gemaakt_door = $v;
            $this->modifiedColumns[EvenementTableMap::COL_GEMAAKT_DOOR] = true;
        }

        return $this;
    } // setGemaaktDoor()

    /**
     * Sets the value of [gewijzigd_datum] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function setDatumGewijzigd($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->gewijzigd_datum !== null || $dt !== null) {
            if ($this->gewijzigd_datum === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->gewijzigd_datum->format("Y-m-d H:i:s.u")) {
                $this->gewijzigd_datum = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EvenementTableMap::COL_GEWIJZIGD_DATUM] = true;
            }
        } // if either are not null

        return $this;
    } // setDatumGewijzigd()

    /**
     * Set the value of [gewijzigd_door] column.
     *
     * @param string $v new value
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function setGewijzigdDoor($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gewijzigd_door !== $v) {
            $this->gewijzigd_door = $v;
            $this->modifiedColumns[EvenementTableMap::COL_GEWIJZIGD_DOOR] = true;
        }

        return $this;
    } // setGewijzigdDoor()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : EvenementTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : EvenementTableMap::translateFieldName('Naam', TableMap::TYPE_PHPNAME, $indexType)];
            $this->naam = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : EvenementTableMap::translateFieldName('Categorie', TableMap::TYPE_PHPNAME, $indexType)];
            $this->categorie = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : EvenementTableMap::translateFieldName('KorteOmschrijving', TableMap::TYPE_PHPNAME, $indexType)];
            $this->korte_omschrijving = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : EvenementTableMap::translateFieldName('LangeOmschrijving', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lange_omschrijving = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : EvenementTableMap::translateFieldName('DatumBegin', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->datum_begin = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : EvenementTableMap::translateFieldName('DatumEind', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->datum_eind = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : EvenementTableMap::translateFieldName('AantalDagen', TableMap::TYPE_PHPNAME, $indexType)];
            $this->aantal_dagen = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : EvenementTableMap::translateFieldName('Frequentie', TableMap::TYPE_PHPNAME, $indexType)];
            $this->frequentie = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : EvenementTableMap::translateFieldName('InschrijvingBegin', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->inschrijving_begin = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : EvenementTableMap::translateFieldName('InschrijvingEind', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->inschrijving_eind = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : EvenementTableMap::translateFieldName('ExtraDeelnemerGegevens', TableMap::TYPE_PHPNAME, $indexType)];
            $this->extra_deelnemer_gegevens = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : EvenementTableMap::translateFieldName('ExtraContactGegevens', TableMap::TYPE_PHPNAME, $indexType)];
            $this->extra_contact_gegevens = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : EvenementTableMap::translateFieldName('Prijs', TableMap::TYPE_PHPNAME, $indexType)];
            $this->prijs = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : EvenementTableMap::translateFieldName('Betaalwijze', TableMap::TYPE_PHPNAME, $indexType)];
            $this->betaalwijze = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : EvenementTableMap::translateFieldName('MaxDeelnemers', TableMap::TYPE_PHPNAME, $indexType)];
            $this->max_deelnemers = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : EvenementTableMap::translateFieldName('Annuleringsverzekering', TableMap::TYPE_PHPNAME, $indexType)];
            $this->annuleringsverzekering = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : EvenementTableMap::translateFieldName('AccountNodig', TableMap::TYPE_PHPNAME, $indexType)];
            $this->account_nodig = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : EvenementTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : EvenementTableMap::translateFieldName('DatumGemaakt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->gemaakt_datum = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : EvenementTableMap::translateFieldName('GemaaktDoor', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gemaakt_door = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 21 + $startcol : EvenementTableMap::translateFieldName('DatumGewijzigd', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->gewijzigd_datum = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 22 + $startcol : EvenementTableMap::translateFieldName('GewijzigdDoor', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gewijzigd_door = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 23; // 23 = EvenementTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\fb_model\\fb_model\\Evenement'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aKeuzes !== null && $this->status !== $this->aKeuzes->getId()) {
            $this->aKeuzes = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EvenementTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildEvenementQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aKeuzes = null;
            $this->collEvenementHeeftOpties = null;

            $this->collInschrijvings = null;

            $this->collMailinglists = null;

            $this->collVouchers = null;

            $this->collOptieIds = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Evenement::setDeleted()
     * @see Evenement::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(EvenementTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildEvenementQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(EvenementTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                $time = time();
                $highPrecision = \Propel\Runtime\Util\PropelDateTime::createHighPrecision();
                if (!$this->isColumnModified(EvenementTableMap::COL_GEMAAKT_DATUM)) {
                    $this->setDatumGemaakt($highPrecision);
                }
                if (!$this->isColumnModified(EvenementTableMap::COL_GEWIJZIGD_DATUM)) {
                    $this->setDatumGewijzigd($highPrecision);
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(EvenementTableMap::COL_GEWIJZIGD_DATUM)) {
                    $this->setDatumGewijzigd(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                EvenementTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aKeuzes !== null) {
                if ($this->aKeuzes->isModified() || $this->aKeuzes->isNew()) {
                    $affectedRows += $this->aKeuzes->save($con);
                }
                $this->setKeuzes($this->aKeuzes);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->combinationCollOptieIdsScheduledForDeletion !== null) {
                if (!$this->combinationCollOptieIdsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->combinationCollOptieIdsScheduledForDeletion as $combination) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[2] = $combination[0]->getId();
                        //$combination[1] = Id;
                        $entryPk[0] = $combination[1];

                        $pks[] = $entryPk;
                    }

                    \fb_model\fb_model\EvenementHeeftOptieQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->combinationCollOptieIdsScheduledForDeletion = null;
                }

            }

            if (null !== $this->combinationCollOptieIds) {
                foreach ($this->combinationCollOptieIds as $combination) {

                    //$combination[0] = Optie (fb_evenement_heeft_optie_fk_c81db2)
                    if (!$combination[0]->isDeleted() && ($combination[0]->isNew() || $combination[0]->isModified())) {
                        $combination[0]->save($con);
                    }

                    //$combination[1] = Id; Nothing to save.
                }
            }


            if ($this->evenementHeeftOptiesScheduledForDeletion !== null) {
                if (!$this->evenementHeeftOptiesScheduledForDeletion->isEmpty()) {
                    \fb_model\fb_model\EvenementHeeftOptieQuery::create()
                        ->filterByPrimaryKeys($this->evenementHeeftOptiesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->evenementHeeftOptiesScheduledForDeletion = null;
                }
            }

            if ($this->collEvenementHeeftOpties !== null) {
                foreach ($this->collEvenementHeeftOpties as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->inschrijvingsScheduledForDeletion !== null) {
                if (!$this->inschrijvingsScheduledForDeletion->isEmpty()) {
                    \fb_model\fb_model\InschrijvingQuery::create()
                        ->filterByPrimaryKeys($this->inschrijvingsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->inschrijvingsScheduledForDeletion = null;
                }
            }

            if ($this->collInschrijvings !== null) {
                foreach ($this->collInschrijvings as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->mailinglistsScheduledForDeletion !== null) {
                if (!$this->mailinglistsScheduledForDeletion->isEmpty()) {
                    \fb_model\fb_model\MailinglistQuery::create()
                        ->filterByPrimaryKeys($this->mailinglistsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->mailinglistsScheduledForDeletion = null;
                }
            }

            if ($this->collMailinglists !== null) {
                foreach ($this->collMailinglists as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->vouchersScheduledForDeletion !== null) {
                if (!$this->vouchersScheduledForDeletion->isEmpty()) {
                    foreach ($this->vouchersScheduledForDeletion as $voucher) {
                        // need to save related object because we set the relation to null
                        $voucher->save($con);
                    }
                    $this->vouchersScheduledForDeletion = null;
                }
            }

            if ($this->collVouchers !== null) {
                foreach ($this->collVouchers as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[EvenementTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . EvenementTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(EvenementTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(EvenementTableMap::COL_NAAM)) {
            $modifiedColumns[':p' . $index++]  = 'naam';
        }
        if ($this->isColumnModified(EvenementTableMap::COL_CATEGORIE)) {
            $modifiedColumns[':p' . $index++]  = 'categorie';
        }
        if ($this->isColumnModified(EvenementTableMap::COL_KORTE_OMSCHRIJVING)) {
            $modifiedColumns[':p' . $index++]  = 'korte_omschrijving';
        }
        if ($this->isColumnModified(EvenementTableMap::COL_LANGE_OMSCHRIJVING)) {
            $modifiedColumns[':p' . $index++]  = 'lange_omschrijving';
        }
        if ($this->isColumnModified(EvenementTableMap::COL_DATUM_BEGIN)) {
            $modifiedColumns[':p' . $index++]  = 'datum_begin';
        }
        if ($this->isColumnModified(EvenementTableMap::COL_DATUM_EIND)) {
            $modifiedColumns[':p' . $index++]  = 'datum_eind';
        }
        if ($this->isColumnModified(EvenementTableMap::COL_AANTAL_DAGEN)) {
            $modifiedColumns[':p' . $index++]  = 'aantal_dagen';
        }
        if ($this->isColumnModified(EvenementTableMap::COL_FREQUENTIE)) {
            $modifiedColumns[':p' . $index++]  = 'frequentie';
        }
        if ($this->isColumnModified(EvenementTableMap::COL_INSCHRIJVING_BEGIN)) {
            $modifiedColumns[':p' . $index++]  = 'inschrijving_begin';
        }
        if ($this->isColumnModified(EvenementTableMap::COL_INSCHRIJVING_EIND)) {
            $modifiedColumns[':p' . $index++]  = 'inschrijving_eind';
        }
        if ($this->isColumnModified(EvenementTableMap::COL_EXTRA_DEELNEMER_GEGEVENS)) {
            $modifiedColumns[':p' . $index++]  = 'extra_deelnemer_gegevens';
        }
        if ($this->isColumnModified(EvenementTableMap::COL_EXTRA_CONTACT_GEGEVENS)) {
            $modifiedColumns[':p' . $index++]  = 'extra_contact_gegevens';
        }
        if ($this->isColumnModified(EvenementTableMap::COL_PRIJS)) {
            $modifiedColumns[':p' . $index++]  = 'prijs';
        }
        if ($this->isColumnModified(EvenementTableMap::COL_BETAALWIJZE)) {
            $modifiedColumns[':p' . $index++]  = 'betaalwijze';
        }
        if ($this->isColumnModified(EvenementTableMap::COL_MAX_DEELNEMERS)) {
            $modifiedColumns[':p' . $index++]  = 'max_deelnemers';
        }
        if ($this->isColumnModified(EvenementTableMap::COL_ANNULERINGSVERZEKERING)) {
            $modifiedColumns[':p' . $index++]  = 'annuleringsverzekering';
        }
        if ($this->isColumnModified(EvenementTableMap::COL_ACCOUNT_NODIG)) {
            $modifiedColumns[':p' . $index++]  = 'account_nodig';
        }
        if ($this->isColumnModified(EvenementTableMap::COL_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'status';
        }
        if ($this->isColumnModified(EvenementTableMap::COL_GEMAAKT_DATUM)) {
            $modifiedColumns[':p' . $index++]  = 'gemaakt_datum';
        }
        if ($this->isColumnModified(EvenementTableMap::COL_GEMAAKT_DOOR)) {
            $modifiedColumns[':p' . $index++]  = 'gemaakt_door';
        }
        if ($this->isColumnModified(EvenementTableMap::COL_GEWIJZIGD_DATUM)) {
            $modifiedColumns[':p' . $index++]  = 'gewijzigd_datum';
        }
        if ($this->isColumnModified(EvenementTableMap::COL_GEWIJZIGD_DOOR)) {
            $modifiedColumns[':p' . $index++]  = 'gewijzigd_door';
        }

        $sql = sprintf(
            'INSERT INTO fb_evenement (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'naam':
                        $stmt->bindValue($identifier, $this->naam, PDO::PARAM_STR);
                        break;
                    case 'categorie':
                        $stmt->bindValue($identifier, $this->categorie, PDO::PARAM_STR);
                        break;
                    case 'korte_omschrijving':
                        $stmt->bindValue($identifier, $this->korte_omschrijving, PDO::PARAM_STR);
                        break;
                    case 'lange_omschrijving':
                        $stmt->bindValue($identifier, $this->lange_omschrijving, PDO::PARAM_STR);
                        break;
                    case 'datum_begin':
                        $stmt->bindValue($identifier, $this->datum_begin ? $this->datum_begin->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'datum_eind':
                        $stmt->bindValue($identifier, $this->datum_eind ? $this->datum_eind->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'aantal_dagen':
                        $stmt->bindValue($identifier, $this->aantal_dagen, PDO::PARAM_INT);
                        break;
                    case 'frequentie':
                        $stmt->bindValue($identifier, $this->frequentie, PDO::PARAM_STR);
                        break;
                    case 'inschrijving_begin':
                        $stmt->bindValue($identifier, $this->inschrijving_begin ? $this->inschrijving_begin->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'inschrijving_eind':
                        $stmt->bindValue($identifier, $this->inschrijving_eind ? $this->inschrijving_eind->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'extra_deelnemer_gegevens':
                        $stmt->bindValue($identifier, $this->extra_deelnemer_gegevens, PDO::PARAM_INT);
                        break;
                    case 'extra_contact_gegevens':
                        $stmt->bindValue($identifier, $this->extra_contact_gegevens, PDO::PARAM_INT);
                        break;
                    case 'prijs':
                        $stmt->bindValue($identifier, $this->prijs, PDO::PARAM_STR);
                        break;
                    case 'betaalwijze':
                        $stmt->bindValue($identifier, $this->betaalwijze, PDO::PARAM_INT);
                        break;
                    case 'max_deelnemers':
                        $stmt->bindValue($identifier, $this->max_deelnemers, PDO::PARAM_INT);
                        break;
                    case 'annuleringsverzekering':
                        $stmt->bindValue($identifier, $this->annuleringsverzekering, PDO::PARAM_INT);
                        break;
                    case 'account_nodig':
                        $stmt->bindValue($identifier, $this->account_nodig, PDO::PARAM_INT);
                        break;
                    case 'status':
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_INT);
                        break;
                    case 'gemaakt_datum':
                        $stmt->bindValue($identifier, $this->gemaakt_datum ? $this->gemaakt_datum->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'gemaakt_door':
                        $stmt->bindValue($identifier, $this->gemaakt_door, PDO::PARAM_STR);
                        break;
                    case 'gewijzigd_datum':
                        $stmt->bindValue($identifier, $this->gewijzigd_datum ? $this->gewijzigd_datum->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'gewijzigd_door':
                        $stmt->bindValue($identifier, $this->gewijzigd_door, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = EvenementTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getNaam();
                break;
            case 2:
                return $this->getCategorie();
                break;
            case 3:
                return $this->getKorteOmschrijving();
                break;
            case 4:
                return $this->getLangeOmschrijving();
                break;
            case 5:
                return $this->getDatumBegin();
                break;
            case 6:
                return $this->getDatumEind();
                break;
            case 7:
                return $this->getAantalDagen();
                break;
            case 8:
                return $this->getFrequentie();
                break;
            case 9:
                return $this->getInschrijvingBegin();
                break;
            case 10:
                return $this->getInschrijvingEind();
                break;
            case 11:
                return $this->getExtraDeelnemerGegevens();
                break;
            case 12:
                return $this->getExtraContactGegevens();
                break;
            case 13:
                return $this->getPrijs();
                break;
            case 14:
                return $this->getBetaalwijze();
                break;
            case 15:
                return $this->getMaxDeelnemers();
                break;
            case 16:
                return $this->getAnnuleringsverzekering();
                break;
            case 17:
                return $this->getAccountNodig();
                break;
            case 18:
                return $this->getStatus();
                break;
            case 19:
                return $this->getDatumGemaakt();
                break;
            case 20:
                return $this->getGemaaktDoor();
                break;
            case 21:
                return $this->getDatumGewijzigd();
                break;
            case 22:
                return $this->getGewijzigdDoor();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Evenement'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Evenement'][$this->hashCode()] = true;
        $keys = EvenementTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getNaam(),
            $keys[2] => $this->getCategorie(),
            $keys[3] => $this->getKorteOmschrijving(),
            $keys[4] => $this->getLangeOmschrijving(),
            $keys[5] => $this->getDatumBegin(),
            $keys[6] => $this->getDatumEind(),
            $keys[7] => $this->getAantalDagen(),
            $keys[8] => $this->getFrequentie(),
            $keys[9] => $this->getInschrijvingBegin(),
            $keys[10] => $this->getInschrijvingEind(),
            $keys[11] => $this->getExtraDeelnemerGegevens(),
            $keys[12] => $this->getExtraContactGegevens(),
            $keys[13] => $this->getPrijs(),
            $keys[14] => $this->getBetaalwijze(),
            $keys[15] => $this->getMaxDeelnemers(),
            $keys[16] => $this->getAnnuleringsverzekering(),
            $keys[17] => $this->getAccountNodig(),
            $keys[18] => $this->getStatus(),
            $keys[19] => $this->getDatumGemaakt(),
            $keys[20] => $this->getGemaaktDoor(),
            $keys[21] => $this->getDatumGewijzigd(),
            $keys[22] => $this->getGewijzigdDoor(),
        );
        if ($result[$keys[5]] instanceof \DateTimeInterface) {
            $result[$keys[5]] = $result[$keys[5]]->format('c');
        }

        if ($result[$keys[6]] instanceof \DateTimeInterface) {
            $result[$keys[6]] = $result[$keys[6]]->format('c');
        }

        if ($result[$keys[9]] instanceof \DateTimeInterface) {
            $result[$keys[9]] = $result[$keys[9]]->format('c');
        }

        if ($result[$keys[10]] instanceof \DateTimeInterface) {
            $result[$keys[10]] = $result[$keys[10]]->format('c');
        }

        if ($result[$keys[19]] instanceof \DateTimeInterface) {
            $result[$keys[19]] = $result[$keys[19]]->format('c');
        }

        if ($result[$keys[21]] instanceof \DateTimeInterface) {
            $result[$keys[21]] = $result[$keys[21]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aKeuzes) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'keuzes';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fb_keuzes';
                        break;
                    default:
                        $key = 'Keuzes';
                }

                $result[$key] = $this->aKeuzes->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collEvenementHeeftOpties) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'evenementHeeftOpties';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fb_evenement_heeft_opties';
                        break;
                    default:
                        $key = 'EvenementHeeftOpties';
                }

                $result[$key] = $this->collEvenementHeeftOpties->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collInschrijvings) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'inschrijvings';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fb_inschrijvings';
                        break;
                    default:
                        $key = 'Inschrijvings';
                }

                $result[$key] = $this->collInschrijvings->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collMailinglists) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'mailinglists';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fb_mailinglists';
                        break;
                    default:
                        $key = 'Mailinglists';
                }

                $result[$key] = $this->collMailinglists->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collVouchers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'vouchers';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fb_vouchers';
                        break;
                    default:
                        $key = 'Vouchers';
                }

                $result[$key] = $this->collVouchers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\fb_model\fb_model\Evenement
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = EvenementTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\fb_model\fb_model\Evenement
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setNaam($value);
                break;
            case 2:
                $this->setCategorie($value);
                break;
            case 3:
                $this->setKorteOmschrijving($value);
                break;
            case 4:
                $this->setLangeOmschrijving($value);
                break;
            case 5:
                $this->setDatumBegin($value);
                break;
            case 6:
                $this->setDatumEind($value);
                break;
            case 7:
                $this->setAantalDagen($value);
                break;
            case 8:
                $this->setFrequentie($value);
                break;
            case 9:
                $this->setInschrijvingBegin($value);
                break;
            case 10:
                $this->setInschrijvingEind($value);
                break;
            case 11:
                $this->setExtraDeelnemerGegevens($value);
                break;
            case 12:
                $this->setExtraContactGegevens($value);
                break;
            case 13:
                $this->setPrijs($value);
                break;
            case 14:
                $this->setBetaalwijze($value);
                break;
            case 15:
                $this->setMaxDeelnemers($value);
                break;
            case 16:
                $this->setAnnuleringsverzekering($value);
                break;
            case 17:
                $this->setAccountNodig($value);
                break;
            case 18:
                $this->setStatus($value);
                break;
            case 19:
                $this->setDatumGemaakt($value);
                break;
            case 20:
                $this->setGemaaktDoor($value);
                break;
            case 21:
                $this->setDatumGewijzigd($value);
                break;
            case 22:
                $this->setGewijzigdDoor($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = EvenementTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setNaam($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setCategorie($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setKorteOmschrijving($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setLangeOmschrijving($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setDatumBegin($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setDatumEind($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setAantalDagen($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setFrequentie($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setInschrijvingBegin($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setInschrijvingEind($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setExtraDeelnemerGegevens($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setExtraContactGegevens($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setPrijs($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setBetaalwijze($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setMaxDeelnemers($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setAnnuleringsverzekering($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setAccountNodig($arr[$keys[17]]);
        }
        if (array_key_exists($keys[18], $arr)) {
            $this->setStatus($arr[$keys[18]]);
        }
        if (array_key_exists($keys[19], $arr)) {
            $this->setDatumGemaakt($arr[$keys[19]]);
        }
        if (array_key_exists($keys[20], $arr)) {
            $this->setGemaaktDoor($arr[$keys[20]]);
        }
        if (array_key_exists($keys[21], $arr)) {
            $this->setDatumGewijzigd($arr[$keys[21]]);
        }
        if (array_key_exists($keys[22], $arr)) {
            $this->setGewijzigdDoor($arr[$keys[22]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\fb_model\fb_model\Evenement The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(EvenementTableMap::DATABASE_NAME);

        if ($this->isColumnModified(EvenementTableMap::COL_ID)) {
            $criteria->add(EvenementTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(EvenementTableMap::COL_NAAM)) {
            $criteria->add(EvenementTableMap::COL_NAAM, $this->naam);
        }
        if ($this->isColumnModified(EvenementTableMap::COL_CATEGORIE)) {
            $criteria->add(EvenementTableMap::COL_CATEGORIE, $this->categorie);
        }
        if ($this->isColumnModified(EvenementTableMap::COL_KORTE_OMSCHRIJVING)) {
            $criteria->add(EvenementTableMap::COL_KORTE_OMSCHRIJVING, $this->korte_omschrijving);
        }
        if ($this->isColumnModified(EvenementTableMap::COL_LANGE_OMSCHRIJVING)) {
            $criteria->add(EvenementTableMap::COL_LANGE_OMSCHRIJVING, $this->lange_omschrijving);
        }
        if ($this->isColumnModified(EvenementTableMap::COL_DATUM_BEGIN)) {
            $criteria->add(EvenementTableMap::COL_DATUM_BEGIN, $this->datum_begin);
        }
        if ($this->isColumnModified(EvenementTableMap::COL_DATUM_EIND)) {
            $criteria->add(EvenementTableMap::COL_DATUM_EIND, $this->datum_eind);
        }
        if ($this->isColumnModified(EvenementTableMap::COL_AANTAL_DAGEN)) {
            $criteria->add(EvenementTableMap::COL_AANTAL_DAGEN, $this->aantal_dagen);
        }
        if ($this->isColumnModified(EvenementTableMap::COL_FREQUENTIE)) {
            $criteria->add(EvenementTableMap::COL_FREQUENTIE, $this->frequentie);
        }
        if ($this->isColumnModified(EvenementTableMap::COL_INSCHRIJVING_BEGIN)) {
            $criteria->add(EvenementTableMap::COL_INSCHRIJVING_BEGIN, $this->inschrijving_begin);
        }
        if ($this->isColumnModified(EvenementTableMap::COL_INSCHRIJVING_EIND)) {
            $criteria->add(EvenementTableMap::COL_INSCHRIJVING_EIND, $this->inschrijving_eind);
        }
        if ($this->isColumnModified(EvenementTableMap::COL_EXTRA_DEELNEMER_GEGEVENS)) {
            $criteria->add(EvenementTableMap::COL_EXTRA_DEELNEMER_GEGEVENS, $this->extra_deelnemer_gegevens);
        }
        if ($this->isColumnModified(EvenementTableMap::COL_EXTRA_CONTACT_GEGEVENS)) {
            $criteria->add(EvenementTableMap::COL_EXTRA_CONTACT_GEGEVENS, $this->extra_contact_gegevens);
        }
        if ($this->isColumnModified(EvenementTableMap::COL_PRIJS)) {
            $criteria->add(EvenementTableMap::COL_PRIJS, $this->prijs);
        }
        if ($this->isColumnModified(EvenementTableMap::COL_BETAALWIJZE)) {
            $criteria->add(EvenementTableMap::COL_BETAALWIJZE, $this->betaalwijze);
        }
        if ($this->isColumnModified(EvenementTableMap::COL_MAX_DEELNEMERS)) {
            $criteria->add(EvenementTableMap::COL_MAX_DEELNEMERS, $this->max_deelnemers);
        }
        if ($this->isColumnModified(EvenementTableMap::COL_ANNULERINGSVERZEKERING)) {
            $criteria->add(EvenementTableMap::COL_ANNULERINGSVERZEKERING, $this->annuleringsverzekering);
        }
        if ($this->isColumnModified(EvenementTableMap::COL_ACCOUNT_NODIG)) {
            $criteria->add(EvenementTableMap::COL_ACCOUNT_NODIG, $this->account_nodig);
        }
        if ($this->isColumnModified(EvenementTableMap::COL_STATUS)) {
            $criteria->add(EvenementTableMap::COL_STATUS, $this->status);
        }
        if ($this->isColumnModified(EvenementTableMap::COL_GEMAAKT_DATUM)) {
            $criteria->add(EvenementTableMap::COL_GEMAAKT_DATUM, $this->gemaakt_datum);
        }
        if ($this->isColumnModified(EvenementTableMap::COL_GEMAAKT_DOOR)) {
            $criteria->add(EvenementTableMap::COL_GEMAAKT_DOOR, $this->gemaakt_door);
        }
        if ($this->isColumnModified(EvenementTableMap::COL_GEWIJZIGD_DATUM)) {
            $criteria->add(EvenementTableMap::COL_GEWIJZIGD_DATUM, $this->gewijzigd_datum);
        }
        if ($this->isColumnModified(EvenementTableMap::COL_GEWIJZIGD_DOOR)) {
            $criteria->add(EvenementTableMap::COL_GEWIJZIGD_DOOR, $this->gewijzigd_door);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildEvenementQuery::create();
        $criteria->add(EvenementTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \fb_model\fb_model\Evenement (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setNaam($this->getNaam());
        $copyObj->setCategorie($this->getCategorie());
        $copyObj->setKorteOmschrijving($this->getKorteOmschrijving());
        $copyObj->setLangeOmschrijving($this->getLangeOmschrijving());
        $copyObj->setDatumBegin($this->getDatumBegin());
        $copyObj->setDatumEind($this->getDatumEind());
        $copyObj->setAantalDagen($this->getAantalDagen());
        $copyObj->setFrequentie($this->getFrequentie());
        $copyObj->setInschrijvingBegin($this->getInschrijvingBegin());
        $copyObj->setInschrijvingEind($this->getInschrijvingEind());
        $copyObj->setExtraDeelnemerGegevens($this->getExtraDeelnemerGegevens());
        $copyObj->setExtraContactGegevens($this->getExtraContactGegevens());
        $copyObj->setPrijs($this->getPrijs());
        $copyObj->setBetaalwijze($this->getBetaalwijze());
        $copyObj->setMaxDeelnemers($this->getMaxDeelnemers());
        $copyObj->setAnnuleringsverzekering($this->getAnnuleringsverzekering());
        $copyObj->setAccountNodig($this->getAccountNodig());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setDatumGemaakt($this->getDatumGemaakt());
        $copyObj->setGemaaktDoor($this->getGemaaktDoor());
        $copyObj->setDatumGewijzigd($this->getDatumGewijzigd());
        $copyObj->setGewijzigdDoor($this->getGewijzigdDoor());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getEvenementHeeftOpties() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addEvenementHeeftOptie($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getInschrijvings() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addInschrijving($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMailinglists() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMailinglist($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getVouchers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addVoucher($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \fb_model\fb_model\Evenement Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildKeuzes object.
     *
     * @param  ChildKeuzes $v
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     * @throws PropelException
     */
    public function setKeuzes(ChildKeuzes $v = null)
    {
        if ($v === null) {
            $this->setStatus(NULL);
        } else {
            $this->setStatus($v->getId());
        }

        $this->aKeuzes = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildKeuzes object, it will not be re-added.
        if ($v !== null) {
            $v->addEvenement($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildKeuzes object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildKeuzes The associated ChildKeuzes object.
     * @throws PropelException
     */
    public function getKeuzes(ConnectionInterface $con = null)
    {
        if ($this->aKeuzes === null && ($this->status != 0)) {
            $this->aKeuzes = ChildKeuzesQuery::create()->findPk($this->status, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aKeuzes->addEvenements($this);
             */
        }

        return $this->aKeuzes;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('EvenementHeeftOptie' == $relationName) {
            $this->initEvenementHeeftOpties();
            return;
        }
        if ('Inschrijving' == $relationName) {
            $this->initInschrijvings();
            return;
        }
        if ('Mailinglist' == $relationName) {
            $this->initMailinglists();
            return;
        }
        if ('Voucher' == $relationName) {
            $this->initVouchers();
            return;
        }
    }

    /**
     * Clears out the collEvenementHeeftOpties collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addEvenementHeeftOpties()
     */
    public function clearEvenementHeeftOpties()
    {
        $this->collEvenementHeeftOpties = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collEvenementHeeftOpties collection loaded partially.
     */
    public function resetPartialEvenementHeeftOpties($v = true)
    {
        $this->collEvenementHeeftOptiesPartial = $v;
    }

    /**
     * Initializes the collEvenementHeeftOpties collection.
     *
     * By default this just sets the collEvenementHeeftOpties collection to an empty array (like clearcollEvenementHeeftOpties());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initEvenementHeeftOpties($overrideExisting = true)
    {
        if (null !== $this->collEvenementHeeftOpties && !$overrideExisting) {
            return;
        }

        $collectionClassName = EvenementHeeftOptieTableMap::getTableMap()->getCollectionClassName();

        $this->collEvenementHeeftOpties = new $collectionClassName;
        $this->collEvenementHeeftOpties->setModel('\fb_model\fb_model\EvenementHeeftOptie');
    }

    /**
     * Gets an array of ChildEvenementHeeftOptie objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEvenement is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildEvenementHeeftOptie[] List of ChildEvenementHeeftOptie objects
     * @throws PropelException
     */
    public function getEvenementHeeftOpties(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collEvenementHeeftOptiesPartial && !$this->isNew();
        if (null === $this->collEvenementHeeftOpties || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collEvenementHeeftOpties) {
                // return empty collection
                $this->initEvenementHeeftOpties();
            } else {
                $collEvenementHeeftOpties = ChildEvenementHeeftOptieQuery::create(null, $criteria)
                    ->filterByEvenement($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collEvenementHeeftOptiesPartial && count($collEvenementHeeftOpties)) {
                        $this->initEvenementHeeftOpties(false);

                        foreach ($collEvenementHeeftOpties as $obj) {
                            if (false == $this->collEvenementHeeftOpties->contains($obj)) {
                                $this->collEvenementHeeftOpties->append($obj);
                            }
                        }

                        $this->collEvenementHeeftOptiesPartial = true;
                    }

                    return $collEvenementHeeftOpties;
                }

                if ($partial && $this->collEvenementHeeftOpties) {
                    foreach ($this->collEvenementHeeftOpties as $obj) {
                        if ($obj->isNew()) {
                            $collEvenementHeeftOpties[] = $obj;
                        }
                    }
                }

                $this->collEvenementHeeftOpties = $collEvenementHeeftOpties;
                $this->collEvenementHeeftOptiesPartial = false;
            }
        }

        return $this->collEvenementHeeftOpties;
    }

    /**
     * Sets a collection of ChildEvenementHeeftOptie objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $evenementHeeftOpties A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEvenement The current object (for fluent API support)
     */
    public function setEvenementHeeftOpties(Collection $evenementHeeftOpties, ConnectionInterface $con = null)
    {
        /** @var ChildEvenementHeeftOptie[] $evenementHeeftOptiesToDelete */
        $evenementHeeftOptiesToDelete = $this->getEvenementHeeftOpties(new Criteria(), $con)->diff($evenementHeeftOpties);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->evenementHeeftOptiesScheduledForDeletion = clone $evenementHeeftOptiesToDelete;

        foreach ($evenementHeeftOptiesToDelete as $evenementHeeftOptieRemoved) {
            $evenementHeeftOptieRemoved->setEvenement(null);
        }

        $this->collEvenementHeeftOpties = null;
        foreach ($evenementHeeftOpties as $evenementHeeftOptie) {
            $this->addEvenementHeeftOptie($evenementHeeftOptie);
        }

        $this->collEvenementHeeftOpties = $evenementHeeftOpties;
        $this->collEvenementHeeftOptiesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related EvenementHeeftOptie objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related EvenementHeeftOptie objects.
     * @throws PropelException
     */
    public function countEvenementHeeftOpties(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collEvenementHeeftOptiesPartial && !$this->isNew();
        if (null === $this->collEvenementHeeftOpties || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collEvenementHeeftOpties) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getEvenementHeeftOpties());
            }

            $query = ChildEvenementHeeftOptieQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEvenement($this)
                ->count($con);
        }

        return count($this->collEvenementHeeftOpties);
    }

    /**
     * Method called to associate a ChildEvenementHeeftOptie object to this object
     * through the ChildEvenementHeeftOptie foreign key attribute.
     *
     * @param  ChildEvenementHeeftOptie $l ChildEvenementHeeftOptie
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function addEvenementHeeftOptie(ChildEvenementHeeftOptie $l)
    {
        if ($this->collEvenementHeeftOpties === null) {
            $this->initEvenementHeeftOpties();
            $this->collEvenementHeeftOptiesPartial = true;
        }

        if (!$this->collEvenementHeeftOpties->contains($l)) {
            $this->doAddEvenementHeeftOptie($l);

            if ($this->evenementHeeftOptiesScheduledForDeletion and $this->evenementHeeftOptiesScheduledForDeletion->contains($l)) {
                $this->evenementHeeftOptiesScheduledForDeletion->remove($this->evenementHeeftOptiesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildEvenementHeeftOptie $evenementHeeftOptie The ChildEvenementHeeftOptie object to add.
     */
    protected function doAddEvenementHeeftOptie(ChildEvenementHeeftOptie $evenementHeeftOptie)
    {
        $this->collEvenementHeeftOpties[]= $evenementHeeftOptie;
        $evenementHeeftOptie->setEvenement($this);
    }

    /**
     * @param  ChildEvenementHeeftOptie $evenementHeeftOptie The ChildEvenementHeeftOptie object to remove.
     * @return $this|ChildEvenement The current object (for fluent API support)
     */
    public function removeEvenementHeeftOptie(ChildEvenementHeeftOptie $evenementHeeftOptie)
    {
        if ($this->getEvenementHeeftOpties()->contains($evenementHeeftOptie)) {
            $pos = $this->collEvenementHeeftOpties->search($evenementHeeftOptie);
            $this->collEvenementHeeftOpties->remove($pos);
            if (null === $this->evenementHeeftOptiesScheduledForDeletion) {
                $this->evenementHeeftOptiesScheduledForDeletion = clone $this->collEvenementHeeftOpties;
                $this->evenementHeeftOptiesScheduledForDeletion->clear();
            }
            $this->evenementHeeftOptiesScheduledForDeletion[]= clone $evenementHeeftOptie;
            $evenementHeeftOptie->setEvenement(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Evenement is new, it will return
     * an empty collection; or if this Evenement has previously
     * been saved, it will retrieve related EvenementHeeftOpties from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Evenement.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildEvenementHeeftOptie[] List of ChildEvenementHeeftOptie objects
     */
    public function getEvenementHeeftOptiesJoinOptie(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildEvenementHeeftOptieQuery::create(null, $criteria);
        $query->joinWith('Optie', $joinBehavior);

        return $this->getEvenementHeeftOpties($query, $con);
    }

    /**
     * Clears out the collInschrijvings collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addInschrijvings()
     */
    public function clearInschrijvings()
    {
        $this->collInschrijvings = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collInschrijvings collection loaded partially.
     */
    public function resetPartialInschrijvings($v = true)
    {
        $this->collInschrijvingsPartial = $v;
    }

    /**
     * Initializes the collInschrijvings collection.
     *
     * By default this just sets the collInschrijvings collection to an empty array (like clearcollInschrijvings());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initInschrijvings($overrideExisting = true)
    {
        if (null !== $this->collInschrijvings && !$overrideExisting) {
            return;
        }

        $collectionClassName = InschrijvingTableMap::getTableMap()->getCollectionClassName();

        $this->collInschrijvings = new $collectionClassName;
        $this->collInschrijvings->setModel('\fb_model\fb_model\Inschrijving');
    }

    /**
     * Gets an array of ChildInschrijving objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEvenement is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildInschrijving[] List of ChildInschrijving objects
     * @throws PropelException
     */
    public function getInschrijvings(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collInschrijvingsPartial && !$this->isNew();
        if (null === $this->collInschrijvings || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collInschrijvings) {
                // return empty collection
                $this->initInschrijvings();
            } else {
                $collInschrijvings = ChildInschrijvingQuery::create(null, $criteria)
                    ->filterByEvenement($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collInschrijvingsPartial && count($collInschrijvings)) {
                        $this->initInschrijvings(false);

                        foreach ($collInschrijvings as $obj) {
                            if (false == $this->collInschrijvings->contains($obj)) {
                                $this->collInschrijvings->append($obj);
                            }
                        }

                        $this->collInschrijvingsPartial = true;
                    }

                    return $collInschrijvings;
                }

                if ($partial && $this->collInschrijvings) {
                    foreach ($this->collInschrijvings as $obj) {
                        if ($obj->isNew()) {
                            $collInschrijvings[] = $obj;
                        }
                    }
                }

                $this->collInschrijvings = $collInschrijvings;
                $this->collInschrijvingsPartial = false;
            }
        }

        return $this->collInschrijvings;
    }

    /**
     * Sets a collection of ChildInschrijving objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $inschrijvings A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEvenement The current object (for fluent API support)
     */
    public function setInschrijvings(Collection $inschrijvings, ConnectionInterface $con = null)
    {
        /** @var ChildInschrijving[] $inschrijvingsToDelete */
        $inschrijvingsToDelete = $this->getInschrijvings(new Criteria(), $con)->diff($inschrijvings);


        $this->inschrijvingsScheduledForDeletion = $inschrijvingsToDelete;

        foreach ($inschrijvingsToDelete as $inschrijvingRemoved) {
            $inschrijvingRemoved->setEvenement(null);
        }

        $this->collInschrijvings = null;
        foreach ($inschrijvings as $inschrijving) {
            $this->addInschrijving($inschrijving);
        }

        $this->collInschrijvings = $inschrijvings;
        $this->collInschrijvingsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Inschrijving objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Inschrijving objects.
     * @throws PropelException
     */
    public function countInschrijvings(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collInschrijvingsPartial && !$this->isNew();
        if (null === $this->collInschrijvings || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collInschrijvings) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getInschrijvings());
            }

            $query = ChildInschrijvingQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEvenement($this)
                ->count($con);
        }

        return count($this->collInschrijvings);
    }

    /**
     * Method called to associate a ChildInschrijving object to this object
     * through the ChildInschrijving foreign key attribute.
     *
     * @param  ChildInschrijving $l ChildInschrijving
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function addInschrijving(ChildInschrijving $l)
    {
        if ($this->collInschrijvings === null) {
            $this->initInschrijvings();
            $this->collInschrijvingsPartial = true;
        }

        if (!$this->collInschrijvings->contains($l)) {
            $this->doAddInschrijving($l);

            if ($this->inschrijvingsScheduledForDeletion and $this->inschrijvingsScheduledForDeletion->contains($l)) {
                $this->inschrijvingsScheduledForDeletion->remove($this->inschrijvingsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildInschrijving $inschrijving The ChildInschrijving object to add.
     */
    protected function doAddInschrijving(ChildInschrijving $inschrijving)
    {
        $this->collInschrijvings[]= $inschrijving;
        $inschrijving->setEvenement($this);
    }

    /**
     * @param  ChildInschrijving $inschrijving The ChildInschrijving object to remove.
     * @return $this|ChildEvenement The current object (for fluent API support)
     */
    public function removeInschrijving(ChildInschrijving $inschrijving)
    {
        if ($this->getInschrijvings()->contains($inschrijving)) {
            $pos = $this->collInschrijvings->search($inschrijving);
            $this->collInschrijvings->remove($pos);
            if (null === $this->inschrijvingsScheduledForDeletion) {
                $this->inschrijvingsScheduledForDeletion = clone $this->collInschrijvings;
                $this->inschrijvingsScheduledForDeletion->clear();
            }
            $this->inschrijvingsScheduledForDeletion[]= clone $inschrijving;
            $inschrijving->setEvenement(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Evenement is new, it will return
     * an empty collection; or if this Evenement has previously
     * been saved, it will retrieve related Inschrijvings from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Evenement.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildInschrijving[] List of ChildInschrijving objects
     */
    public function getInschrijvingsJoinKeuzes(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildInschrijvingQuery::create(null, $criteria);
        $query->joinWith('Keuzes', $joinBehavior);

        return $this->getInschrijvings($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Evenement is new, it will return
     * an empty collection; or if this Evenement has previously
     * been saved, it will retrieve related Inschrijvings from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Evenement.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildInschrijving[] List of ChildInschrijving objects
     */
    public function getInschrijvingsJoinVoucher(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildInschrijvingQuery::create(null, $criteria);
        $query->joinWith('Voucher', $joinBehavior);

        return $this->getInschrijvings($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Evenement is new, it will return
     * an empty collection; or if this Evenement has previously
     * been saved, it will retrieve related Inschrijvings from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Evenement.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildInschrijving[] List of ChildInschrijving objects
     */
    public function getInschrijvingsJoinPersoon(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildInschrijvingQuery::create(null, $criteria);
        $query->joinWith('Persoon', $joinBehavior);

        return $this->getInschrijvings($query, $con);
    }

    /**
     * Clears out the collMailinglists collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMailinglists()
     */
    public function clearMailinglists()
    {
        $this->collMailinglists = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collMailinglists collection loaded partially.
     */
    public function resetPartialMailinglists($v = true)
    {
        $this->collMailinglistsPartial = $v;
    }

    /**
     * Initializes the collMailinglists collection.
     *
     * By default this just sets the collMailinglists collection to an empty array (like clearcollMailinglists());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMailinglists($overrideExisting = true)
    {
        if (null !== $this->collMailinglists && !$overrideExisting) {
            return;
        }

        $collectionClassName = MailinglistTableMap::getTableMap()->getCollectionClassName();

        $this->collMailinglists = new $collectionClassName;
        $this->collMailinglists->setModel('\fb_model\fb_model\Mailinglist');
    }

    /**
     * Gets an array of ChildMailinglist objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEvenement is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildMailinglist[] List of ChildMailinglist objects
     * @throws PropelException
     */
    public function getMailinglists(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMailinglistsPartial && !$this->isNew();
        if (null === $this->collMailinglists || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMailinglists) {
                // return empty collection
                $this->initMailinglists();
            } else {
                $collMailinglists = ChildMailinglistQuery::create(null, $criteria)
                    ->filterByEvenement($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collMailinglistsPartial && count($collMailinglists)) {
                        $this->initMailinglists(false);

                        foreach ($collMailinglists as $obj) {
                            if (false == $this->collMailinglists->contains($obj)) {
                                $this->collMailinglists->append($obj);
                            }
                        }

                        $this->collMailinglistsPartial = true;
                    }

                    return $collMailinglists;
                }

                if ($partial && $this->collMailinglists) {
                    foreach ($this->collMailinglists as $obj) {
                        if ($obj->isNew()) {
                            $collMailinglists[] = $obj;
                        }
                    }
                }

                $this->collMailinglists = $collMailinglists;
                $this->collMailinglistsPartial = false;
            }
        }

        return $this->collMailinglists;
    }

    /**
     * Sets a collection of ChildMailinglist objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $mailinglists A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEvenement The current object (for fluent API support)
     */
    public function setMailinglists(Collection $mailinglists, ConnectionInterface $con = null)
    {
        /** @var ChildMailinglist[] $mailinglistsToDelete */
        $mailinglistsToDelete = $this->getMailinglists(new Criteria(), $con)->diff($mailinglists);


        $this->mailinglistsScheduledForDeletion = $mailinglistsToDelete;

        foreach ($mailinglistsToDelete as $mailinglistRemoved) {
            $mailinglistRemoved->setEvenement(null);
        }

        $this->collMailinglists = null;
        foreach ($mailinglists as $mailinglist) {
            $this->addMailinglist($mailinglist);
        }

        $this->collMailinglists = $mailinglists;
        $this->collMailinglistsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Mailinglist objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Mailinglist objects.
     * @throws PropelException
     */
    public function countMailinglists(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMailinglistsPartial && !$this->isNew();
        if (null === $this->collMailinglists || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMailinglists) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMailinglists());
            }

            $query = ChildMailinglistQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEvenement($this)
                ->count($con);
        }

        return count($this->collMailinglists);
    }

    /**
     * Method called to associate a ChildMailinglist object to this object
     * through the ChildMailinglist foreign key attribute.
     *
     * @param  ChildMailinglist $l ChildMailinglist
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function addMailinglist(ChildMailinglist $l)
    {
        if ($this->collMailinglists === null) {
            $this->initMailinglists();
            $this->collMailinglistsPartial = true;
        }

        if (!$this->collMailinglists->contains($l)) {
            $this->doAddMailinglist($l);

            if ($this->mailinglistsScheduledForDeletion and $this->mailinglistsScheduledForDeletion->contains($l)) {
                $this->mailinglistsScheduledForDeletion->remove($this->mailinglistsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildMailinglist $mailinglist The ChildMailinglist object to add.
     */
    protected function doAddMailinglist(ChildMailinglist $mailinglist)
    {
        $this->collMailinglists[]= $mailinglist;
        $mailinglist->setEvenement($this);
    }

    /**
     * @param  ChildMailinglist $mailinglist The ChildMailinglist object to remove.
     * @return $this|ChildEvenement The current object (for fluent API support)
     */
    public function removeMailinglist(ChildMailinglist $mailinglist)
    {
        if ($this->getMailinglists()->contains($mailinglist)) {
            $pos = $this->collMailinglists->search($mailinglist);
            $this->collMailinglists->remove($pos);
            if (null === $this->mailinglistsScheduledForDeletion) {
                $this->mailinglistsScheduledForDeletion = clone $this->collMailinglists;
                $this->mailinglistsScheduledForDeletion->clear();
            }
            $this->mailinglistsScheduledForDeletion[]= clone $mailinglist;
            $mailinglist->setEvenement(null);
        }

        return $this;
    }

    /**
     * Clears out the collVouchers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addVouchers()
     */
    public function clearVouchers()
    {
        $this->collVouchers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collVouchers collection loaded partially.
     */
    public function resetPartialVouchers($v = true)
    {
        $this->collVouchersPartial = $v;
    }

    /**
     * Initializes the collVouchers collection.
     *
     * By default this just sets the collVouchers collection to an empty array (like clearcollVouchers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initVouchers($overrideExisting = true)
    {
        if (null !== $this->collVouchers && !$overrideExisting) {
            return;
        }

        $collectionClassName = VoucherTableMap::getTableMap()->getCollectionClassName();

        $this->collVouchers = new $collectionClassName;
        $this->collVouchers->setModel('\fb_model\fb_model\Voucher');
    }

    /**
     * Gets an array of ChildVoucher objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEvenement is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildVoucher[] List of ChildVoucher objects
     * @throws PropelException
     */
    public function getVouchers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collVouchersPartial && !$this->isNew();
        if (null === $this->collVouchers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collVouchers) {
                // return empty collection
                $this->initVouchers();
            } else {
                $collVouchers = ChildVoucherQuery::create(null, $criteria)
                    ->filterByEvenement($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collVouchersPartial && count($collVouchers)) {
                        $this->initVouchers(false);

                        foreach ($collVouchers as $obj) {
                            if (false == $this->collVouchers->contains($obj)) {
                                $this->collVouchers->append($obj);
                            }
                        }

                        $this->collVouchersPartial = true;
                    }

                    return $collVouchers;
                }

                if ($partial && $this->collVouchers) {
                    foreach ($this->collVouchers as $obj) {
                        if ($obj->isNew()) {
                            $collVouchers[] = $obj;
                        }
                    }
                }

                $this->collVouchers = $collVouchers;
                $this->collVouchersPartial = false;
            }
        }

        return $this->collVouchers;
    }

    /**
     * Sets a collection of ChildVoucher objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $vouchers A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEvenement The current object (for fluent API support)
     */
    public function setVouchers(Collection $vouchers, ConnectionInterface $con = null)
    {
        /** @var ChildVoucher[] $vouchersToDelete */
        $vouchersToDelete = $this->getVouchers(new Criteria(), $con)->diff($vouchers);


        $this->vouchersScheduledForDeletion = $vouchersToDelete;

        foreach ($vouchersToDelete as $voucherRemoved) {
            $voucherRemoved->setEvenement(null);
        }

        $this->collVouchers = null;
        foreach ($vouchers as $voucher) {
            $this->addVoucher($voucher);
        }

        $this->collVouchers = $vouchers;
        $this->collVouchersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Voucher objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Voucher objects.
     * @throws PropelException
     */
    public function countVouchers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collVouchersPartial && !$this->isNew();
        if (null === $this->collVouchers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collVouchers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getVouchers());
            }

            $query = ChildVoucherQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEvenement($this)
                ->count($con);
        }

        return count($this->collVouchers);
    }

    /**
     * Method called to associate a ChildVoucher object to this object
     * through the ChildVoucher foreign key attribute.
     *
     * @param  ChildVoucher $l ChildVoucher
     * @return $this|\fb_model\fb_model\Evenement The current object (for fluent API support)
     */
    public function addVoucher(ChildVoucher $l)
    {
        if ($this->collVouchers === null) {
            $this->initVouchers();
            $this->collVouchersPartial = true;
        }

        if (!$this->collVouchers->contains($l)) {
            $this->doAddVoucher($l);

            if ($this->vouchersScheduledForDeletion and $this->vouchersScheduledForDeletion->contains($l)) {
                $this->vouchersScheduledForDeletion->remove($this->vouchersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildVoucher $voucher The ChildVoucher object to add.
     */
    protected function doAddVoucher(ChildVoucher $voucher)
    {
        $this->collVouchers[]= $voucher;
        $voucher->setEvenement($this);
    }

    /**
     * @param  ChildVoucher $voucher The ChildVoucher object to remove.
     * @return $this|ChildEvenement The current object (for fluent API support)
     */
    public function removeVoucher(ChildVoucher $voucher)
    {
        if ($this->getVouchers()->contains($voucher)) {
            $pos = $this->collVouchers->search($voucher);
            $this->collVouchers->remove($pos);
            if (null === $this->vouchersScheduledForDeletion) {
                $this->vouchersScheduledForDeletion = clone $this->collVouchers;
                $this->vouchersScheduledForDeletion->clear();
            }
            $this->vouchersScheduledForDeletion[]= $voucher;
            $voucher->setEvenement(null);
        }

        return $this;
    }

    /**
     * Clears out the collOptieIds collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addOptieIds()
     */
    public function clearOptieIds()
    {
        $this->collOptieIds = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the combinationCollOptieIds crossRef collection.
     *
     * By default this just sets the combinationCollOptieIds collection to an empty collection (like clearOptieIds());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initOptieIds()
    {
        $this->combinationCollOptieIds = new ObjectCombinationCollection;
        $this->combinationCollOptieIdsPartial = true;
    }

    /**
     * Checks if the combinationCollOptieIds collection is loaded.
     *
     * @return bool
     */
    public function isOptieIdsLoaded()
    {
        return null !== $this->combinationCollOptieIds;
    }

    /**
     * Returns a new query object pre configured with filters from current object and given arguments to query the database.
     *
     * @param int $id
     * @param Criteria $criteria
     *
     * @return ChildOptieQuery
     */
    public function createOptiesQuery($id = null, Criteria $criteria = null)
    {
        $criteria = ChildOptieQuery::create($criteria)
            ->filterByEvenement($this);

        $evenementHeeftOptieQuery = $criteria->useEvenementHeeftOptieQuery();

        if (null !== $id) {
            $evenementHeeftOptieQuery->filterById($id);
        }

        $evenementHeeftOptieQuery->endUse();

        return $criteria;
    }

    /**
     * Gets a combined collection of ChildOptie objects related by a many-to-many relationship
     * to the current object by way of the fb_evenement_heeft_optie cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEvenement is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCombinationCollection Combination list of ChildOptie objects
     */
    public function getOptieIds($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->combinationCollOptieIdsPartial && !$this->isNew();
        if (null === $this->combinationCollOptieIds || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->combinationCollOptieIds) {
                    $this->initOptieIds();
                }
            } else {

                $query = ChildEvenementHeeftOptieQuery::create(null, $criteria)
                    ->filterByEvenement($this)
                    ->joinOptie()
                ;

                $items = $query->find($con);
                $combinationCollOptieIds = new ObjectCombinationCollection();
                foreach ($items as $item) {
                    $combination = [];

                    $combination[] = $item->getOptie();
                    $combination[] = $item->getId();
                    $combinationCollOptieIds[] = $combination;
                }

                if (null !== $criteria) {
                    return $combinationCollOptieIds;
                }

                if ($partial && $this->combinationCollOptieIds) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->combinationCollOptieIds as $obj) {
                        if (!call_user_func_array([$combinationCollOptieIds, 'contains'], $obj)) {
                            $combinationCollOptieIds[] = $obj;
                        }
                    }
                }

                $this->combinationCollOptieIds = $combinationCollOptieIds;
                $this->combinationCollOptieIdsPartial = false;
            }
        }

        return $this->combinationCollOptieIds;
    }

    /**
     * Returns a not cached ObjectCollection of ChildOptie objects. This will hit always the databases.
     * If you have attached new ChildOptie object to this object you need to call `save` first to get
     * the correct return value. Use getOptieIds() to get the current internal state.
     *
     * @param int $id
     * @param Criteria $criteria
     * @param ConnectionInterface $con
     *
     * @return ChildOptie[]|ObjectCollection
     */
    public function getOpties($id = null, Criteria $criteria = null, ConnectionInterface $con = null)
    {
        return $this->createOptiesQuery($id, $criteria)->find($con);
    }

    /**
     * Sets a collection of ChildOptie objects related by a many-to-many relationship
     * to the current object by way of the fb_evenement_heeft_optie cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $optieIds A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildEvenement The current object (for fluent API support)
     */
    public function setOptieIds(Collection $optieIds, ConnectionInterface $con = null)
    {
        $this->clearOptieIds();
        $currentOptieIds = $this->getOptieIds();

        $combinationCollOptieIdsScheduledForDeletion = $currentOptieIds->diff($optieIds);

        foreach ($combinationCollOptieIdsScheduledForDeletion as $toDelete) {
            call_user_func_array([$this, 'removeOptieId'], $toDelete);
        }

        foreach ($optieIds as $optieId) {
            if (!call_user_func_array([$currentOptieIds, 'contains'], $optieId)) {
                call_user_func_array([$this, 'doAddOptieId'], $optieId);
            }
        }

        $this->combinationCollOptieIdsPartial = false;
        $this->combinationCollOptieIds = $optieIds;

        return $this;
    }

    /**
     * Gets the number of ChildOptie objects related by a many-to-many relationship
     * to the current object by way of the fb_evenement_heeft_optie cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related ChildOptie objects
     */
    public function countOptieIds(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->combinationCollOptieIdsPartial && !$this->isNew();
        if (null === $this->combinationCollOptieIds || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->combinationCollOptieIds) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getOptieIds());
                }

                $query = ChildEvenementHeeftOptieQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByEvenement($this)
                    ->count($con);
            }
        } else {
            return count($this->combinationCollOptieIds);
        }
    }

    /**
     * Returns the not cached count of ChildOptie objects. This will hit always the databases.
     * If you have attached new ChildOptie object to this object you need to call `save` first to get
     * the correct return value. Use getOptieIds() to get the current internal state.
     *
     * @param int $id
     * @param Criteria $criteria
     * @param ConnectionInterface $con
     *
     * @return integer
     */
    public function countOpties($id = null, Criteria $criteria = null, ConnectionInterface $con = null)
    {
        return $this->createOptiesQuery($id, $criteria)->count($con);
    }

    /**
     * Associate a ChildOptie to this object
     * through the fb_evenement_heeft_optie cross reference table.
     *
     * @param ChildOptie $optie,
     * @param int $id
     * @return ChildEvenement The current object (for fluent API support)
     */
    public function addOptie(ChildOptie $optie, $id)
    {
        if ($this->combinationCollOptieIds === null) {
            $this->initOptieIds();
        }

        if (!$this->getOptieIds()->contains($optie, $id)) {
            // only add it if the **same** object is not already associated
            $this->combinationCollOptieIds->push($optie, $id);
            $this->doAddOptieId($optie, $id);
        }

        return $this;
    }

    /**
     *
     * @param ChildOptie $optie,
     * @param int $id
     */
    protected function doAddOptieId(ChildOptie $optie, $id)
    {
        $evenementHeeftOptie = new ChildEvenementHeeftOptie();

        $evenementHeeftOptie->setOptie($optie);
        $evenementHeeftOptie->setId($id);


        $evenementHeeftOptie->setEvenement($this);

        $this->addEvenementHeeftOptie($evenementHeeftOptie);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if ($optie->isEvenementIdsLoaded()) {
            $optie->initEvenementIds();
            $optie->getEvenementIds()->push($this, $id);
        } elseif (!$optie->getEvenementIds()->contains($this, $id)) {
            $optie->getEvenementIds()->push($this, $id);
        }

    }

    /**
     * Remove optie, id of this object
     * through the fb_evenement_heeft_optie cross reference table.
     *
     * @param ChildOptie $optie,
     * @param int $id
     * @return ChildEvenement The current object (for fluent API support)
     */
    public function removeOptieId(ChildOptie $optie, $id)
    {
        if ($this->getOptieIds()->contains($optie, $id)) {
            $evenementHeeftOptie = new ChildEvenementHeeftOptie();
            $evenementHeeftOptie->setOptie($optie);
            if ($optie->isEvenementIdsLoaded()) {
                //remove the back reference if available
                $optie->getEvenementIds()->removeObject($this, $id);
            }

            $evenementHeeftOptie->setId($id);
            $evenementHeeftOptie->setEvenement($this);
            $this->removeEvenementHeeftOptie(clone $evenementHeeftOptie);
            $evenementHeeftOptie->clear();

            $this->combinationCollOptieIds->remove($this->combinationCollOptieIds->search($optie, $id));

            if (null === $this->combinationCollOptieIdsScheduledForDeletion) {
                $this->combinationCollOptieIdsScheduledForDeletion = clone $this->combinationCollOptieIds;
                $this->combinationCollOptieIdsScheduledForDeletion->clear();
            }

            $this->combinationCollOptieIdsScheduledForDeletion->push($optie, $id);
        }


        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aKeuzes) {
            $this->aKeuzes->removeEvenement($this);
        }
        $this->id = null;
        $this->naam = null;
        $this->categorie = null;
        $this->korte_omschrijving = null;
        $this->lange_omschrijving = null;
        $this->datum_begin = null;
        $this->datum_eind = null;
        $this->aantal_dagen = null;
        $this->frequentie = null;
        $this->inschrijving_begin = null;
        $this->inschrijving_eind = null;
        $this->extra_deelnemer_gegevens = null;
        $this->extra_contact_gegevens = null;
        $this->prijs = null;
        $this->betaalwijze = null;
        $this->max_deelnemers = null;
        $this->annuleringsverzekering = null;
        $this->account_nodig = null;
        $this->status = null;
        $this->gemaakt_datum = null;
        $this->gemaakt_door = null;
        $this->gewijzigd_datum = null;
        $this->gewijzigd_door = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collEvenementHeeftOpties) {
                foreach ($this->collEvenementHeeftOpties as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collInschrijvings) {
                foreach ($this->collInschrijvings as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMailinglists) {
                foreach ($this->collMailinglists as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collVouchers) {
                foreach ($this->collVouchers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->combinationCollOptieIds) {
                foreach ($this->combinationCollOptieIds as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collEvenementHeeftOpties = null;
        $this->collInschrijvings = null;
        $this->collMailinglists = null;
        $this->collVouchers = null;
        $this->combinationCollOptieIds = null;
        $this->aKeuzes = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(EvenementTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildEvenement The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[EvenementTableMap::COL_GEWIJZIGD_DATUM] = true;

        return $this;
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
