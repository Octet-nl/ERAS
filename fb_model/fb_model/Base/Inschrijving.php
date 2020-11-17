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
use fb_model\fb_model\Deelnemer as ChildDeelnemer;
use fb_model\fb_model\DeelnemerQuery as ChildDeelnemerQuery;
use fb_model\fb_model\Evenement as ChildEvenement;
use fb_model\fb_model\EvenementQuery as ChildEvenementQuery;
use fb_model\fb_model\FactuurNummer as ChildFactuurNummer;
use fb_model\fb_model\FactuurNummerQuery as ChildFactuurNummerQuery;
use fb_model\fb_model\Inschrijving as ChildInschrijving;
use fb_model\fb_model\InschrijvingHeeftOptie as ChildInschrijvingHeeftOptie;
use fb_model\fb_model\InschrijvingHeeftOptieQuery as ChildInschrijvingHeeftOptieQuery;
use fb_model\fb_model\InschrijvingQuery as ChildInschrijvingQuery;
use fb_model\fb_model\Keuzes as ChildKeuzes;
use fb_model\fb_model\KeuzesQuery as ChildKeuzesQuery;
use fb_model\fb_model\Optie as ChildOptie;
use fb_model\fb_model\OptieQuery as ChildOptieQuery;
use fb_model\fb_model\Persoon as ChildPersoon;
use fb_model\fb_model\PersoonQuery as ChildPersoonQuery;
use fb_model\fb_model\Voucher as ChildVoucher;
use fb_model\fb_model\VoucherQuery as ChildVoucherQuery;
use fb_model\fb_model\Map\DeelnemerTableMap;
use fb_model\fb_model\Map\FactuurNummerTableMap;
use fb_model\fb_model\Map\InschrijvingHeeftOptieTableMap;
use fb_model\fb_model\Map\InschrijvingTableMap;

/**
 * Base class that represents a row from the 'fb_inschrijving' table.
 *
 *
 *
 * @package    propel.generator.fb_model.fb_model.Base
 */
abstract class Inschrijving implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\fb_model\\fb_model\\Map\\InschrijvingTableMap';


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
     * The value for the evenement_id field.
     *
     * @var        int
     */
    protected $evenement_id;

    /**
     * The value for the contactpersoon_id field.
     *
     * @var        int
     */
    protected $contactpersoon_id;

    /**
     * The value for the datum_inschrijving field.
     *
     * @var        DateTime
     */
    protected $datum_inschrijving;

    /**
     * The value for the annuleringsverzekering_afgesloten field.
     *
     * @var        DateTime
     */
    protected $annuleringsverzekering_afgesloten;

    /**
     * The value for the totaalbedrag field.
     *
     * @var        string
     */
    protected $totaalbedrag;

    /**
     * The value for the reeds_betaald field.
     *
     * @var        string
     */
    protected $reeds_betaald;

    /**
     * The value for the nog_te_betalen field.
     *
     * @var        string
     */
    protected $nog_te_betalen;

    /**
     * The value for the korting field.
     *
     * @var        string
     */
    protected $korting;

    /**
     * The value for the betaald_per_voucher field.
     *
     * @var        string
     */
    protected $betaald_per_voucher;

    /**
     * The value for the voucher_id field.
     *
     * @var        int
     */
    protected $voucher_id;

    /**
     * The value for the betaalwijze field.
     *
     * @var        int
     */
    protected $betaalwijze;

    /**
     * The value for the annuleringsverzekering field.
     *
     * @var        int
     */
    protected $annuleringsverzekering;

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
     * @var        ChildEvenement
     */
    protected $aEvenement;

    /**
     * @var        ChildKeuzes
     */
    protected $aKeuzes;

    /**
     * @var        ChildVoucher
     */
    protected $aVoucher;

    /**
     * @var        ChildPersoon
     */
    protected $aPersoon;

    /**
     * @var        ObjectCollection|ChildDeelnemer[] Collection to store aggregation of ChildDeelnemer objects.
     */
    protected $collDeelnemers;
    protected $collDeelnemersPartial;

    /**
     * @var        ObjectCollection|ChildFactuurNummer[] Collection to store aggregation of ChildFactuurNummer objects.
     */
    protected $collFactuurNummers;
    protected $collFactuurNummersPartial;

    /**
     * @var        ObjectCollection|ChildInschrijvingHeeftOptie[] Collection to store aggregation of ChildInschrijvingHeeftOptie objects.
     */
    protected $collInschrijvingHeeftOpties;
    protected $collInschrijvingHeeftOptiesPartial;

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
     * @var ObjectCollection|ChildDeelnemer[]
     */
    protected $deelnemersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildFactuurNummer[]
     */
    protected $factuurNummersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildInschrijvingHeeftOptie[]
     */
    protected $inschrijvingHeeftOptiesScheduledForDeletion = null;

    /**
     * Initializes internal state of fb_model\fb_model\Base\Inschrijving object.
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
     * Compares this with another <code>Inschrijving</code> instance.  If
     * <code>obj</code> is an instance of <code>Inschrijving</code>, delegates to
     * <code>equals(Inschrijving)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Inschrijving The current object, for fluid interface
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
     * Get the [evenement_id] column value.
     *
     * @return int
     */
    public function getEvenementId()
    {
        return $this->evenement_id;
    }

    /**
     * Get the [contactpersoon_id] column value.
     *
     * @return int
     */
    public function getContactPersoonId()
    {
        return $this->contactpersoon_id;
    }

    /**
     * Get the [optionally formatted] temporal [datum_inschrijving] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDatumInschrijving($format = NULL)
    {
        if ($format === null) {
            return $this->datum_inschrijving;
        } else {
            return $this->datum_inschrijving instanceof \DateTimeInterface ? $this->datum_inschrijving->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [annuleringsverzekering_afgesloten] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getAnnuleringsverzekeringAfgesloten($format = NULL)
    {
        if ($format === null) {
            return $this->annuleringsverzekering_afgesloten;
        } else {
            return $this->annuleringsverzekering_afgesloten instanceof \DateTimeInterface ? $this->annuleringsverzekering_afgesloten->format($format) : null;
        }
    }

    /**
     * Get the [totaalbedrag] column value.
     *
     * @return string
     */
    public function getTotaalbedrag()
    {
        return $this->totaalbedrag;
    }

    /**
     * Get the [reeds_betaald] column value.
     *
     * @return string
     */
    public function getReedsBetaald()
    {
        return $this->reeds_betaald;
    }

    /**
     * Get the [nog_te_betalen] column value.
     *
     * @return string
     */
    public function getNogTeBetalen()
    {
        return $this->nog_te_betalen;
    }

    /**
     * Get the [korting] column value.
     *
     * @return string
     */
    public function getKorting()
    {
        return $this->korting;
    }

    /**
     * Get the [betaald_per_voucher] column value.
     *
     * @return string
     */
    public function getBetaaldPerVoucher()
    {
        return $this->betaald_per_voucher;
    }

    /**
     * Get the [voucher_id] column value.
     *
     * @return int
     */
    public function getVoucherId()
    {
        return $this->voucher_id;
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
     * Get the [annuleringsverzekering] column value.
     *
     * @return int
     */
    public function getAnnuleringsverzekering()
    {
        return $this->annuleringsverzekering;
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
     * @return $this|\fb_model\fb_model\Inschrijving The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[InschrijvingTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [evenement_id] column.
     *
     * @param int $v new value
     * @return $this|\fb_model\fb_model\Inschrijving The current object (for fluent API support)
     */
    public function setEvenementId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->evenement_id !== $v) {
            $this->evenement_id = $v;
            $this->modifiedColumns[InschrijvingTableMap::COL_EVENEMENT_ID] = true;
        }

        if ($this->aEvenement !== null && $this->aEvenement->getId() !== $v) {
            $this->aEvenement = null;
        }

        return $this;
    } // setEvenementId()

    /**
     * Set the value of [contactpersoon_id] column.
     *
     * @param int $v new value
     * @return $this|\fb_model\fb_model\Inschrijving The current object (for fluent API support)
     */
    public function setContactPersoonId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->contactpersoon_id !== $v) {
            $this->contactpersoon_id = $v;
            $this->modifiedColumns[InschrijvingTableMap::COL_CONTACTPERSOON_ID] = true;
        }

        if ($this->aPersoon !== null && $this->aPersoon->getId() !== $v) {
            $this->aPersoon = null;
        }

        return $this;
    } // setContactPersoonId()

    /**
     * Sets the value of [datum_inschrijving] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\fb_model\fb_model\Inschrijving The current object (for fluent API support)
     */
    public function setDatumInschrijving($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->datum_inschrijving !== null || $dt !== null) {
            if ($this->datum_inschrijving === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->datum_inschrijving->format("Y-m-d H:i:s.u")) {
                $this->datum_inschrijving = $dt === null ? null : clone $dt;
                $this->modifiedColumns[InschrijvingTableMap::COL_DATUM_INSCHRIJVING] = true;
            }
        } // if either are not null

        return $this;
    } // setDatumInschrijving()

    /**
     * Sets the value of [annuleringsverzekering_afgesloten] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\fb_model\fb_model\Inschrijving The current object (for fluent API support)
     */
    public function setAnnuleringsverzekeringAfgesloten($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->annuleringsverzekering_afgesloten !== null || $dt !== null) {
            if ($this->annuleringsverzekering_afgesloten === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->annuleringsverzekering_afgesloten->format("Y-m-d H:i:s.u")) {
                $this->annuleringsverzekering_afgesloten = $dt === null ? null : clone $dt;
                $this->modifiedColumns[InschrijvingTableMap::COL_ANNULERINGSVERZEKERING_AFGESLOTEN] = true;
            }
        } // if either are not null

        return $this;
    } // setAnnuleringsverzekeringAfgesloten()

    /**
     * Set the value of [totaalbedrag] column.
     *
     * @param string $v new value
     * @return $this|\fb_model\fb_model\Inschrijving The current object (for fluent API support)
     */
    public function setTotaalbedrag($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->totaalbedrag !== $v) {
            $this->totaalbedrag = $v;
            $this->modifiedColumns[InschrijvingTableMap::COL_TOTAALBEDRAG] = true;
        }

        return $this;
    } // setTotaalbedrag()

    /**
     * Set the value of [reeds_betaald] column.
     *
     * @param string $v new value
     * @return $this|\fb_model\fb_model\Inschrijving The current object (for fluent API support)
     */
    public function setReedsBetaald($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->reeds_betaald !== $v) {
            $this->reeds_betaald = $v;
            $this->modifiedColumns[InschrijvingTableMap::COL_REEDS_BETAALD] = true;
        }

        return $this;
    } // setReedsBetaald()

    /**
     * Set the value of [nog_te_betalen] column.
     *
     * @param string $v new value
     * @return $this|\fb_model\fb_model\Inschrijving The current object (for fluent API support)
     */
    public function setNogTeBetalen($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nog_te_betalen !== $v) {
            $this->nog_te_betalen = $v;
            $this->modifiedColumns[InschrijvingTableMap::COL_NOG_TE_BETALEN] = true;
        }

        return $this;
    } // setNogTeBetalen()

    /**
     * Set the value of [korting] column.
     *
     * @param string $v new value
     * @return $this|\fb_model\fb_model\Inschrijving The current object (for fluent API support)
     */
    public function setKorting($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->korting !== $v) {
            $this->korting = $v;
            $this->modifiedColumns[InschrijvingTableMap::COL_KORTING] = true;
        }

        return $this;
    } // setKorting()

    /**
     * Set the value of [betaald_per_voucher] column.
     *
     * @param string $v new value
     * @return $this|\fb_model\fb_model\Inschrijving The current object (for fluent API support)
     */
    public function setBetaaldPerVoucher($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->betaald_per_voucher !== $v) {
            $this->betaald_per_voucher = $v;
            $this->modifiedColumns[InschrijvingTableMap::COL_BETAALD_PER_VOUCHER] = true;
        }

        return $this;
    } // setBetaaldPerVoucher()

    /**
     * Set the value of [voucher_id] column.
     *
     * @param int $v new value
     * @return $this|\fb_model\fb_model\Inschrijving The current object (for fluent API support)
     */
    public function setVoucherId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->voucher_id !== $v) {
            $this->voucher_id = $v;
            $this->modifiedColumns[InschrijvingTableMap::COL_VOUCHER_ID] = true;
        }

        if ($this->aVoucher !== null && $this->aVoucher->getId() !== $v) {
            $this->aVoucher = null;
        }

        return $this;
    } // setVoucherId()

    /**
     * Set the value of [betaalwijze] column.
     *
     * @param int $v new value
     * @return $this|\fb_model\fb_model\Inschrijving The current object (for fluent API support)
     */
    public function setBetaalwijze($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->betaalwijze !== $v) {
            $this->betaalwijze = $v;
            $this->modifiedColumns[InschrijvingTableMap::COL_BETAALWIJZE] = true;
        }

        return $this;
    } // setBetaalwijze()

    /**
     * Set the value of [annuleringsverzekering] column.
     *
     * @param int $v new value
     * @return $this|\fb_model\fb_model\Inschrijving The current object (for fluent API support)
     */
    public function setAnnuleringsverzekering($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->annuleringsverzekering !== $v) {
            $this->annuleringsverzekering = $v;
            $this->modifiedColumns[InschrijvingTableMap::COL_ANNULERINGSVERZEKERING] = true;
        }

        return $this;
    } // setAnnuleringsverzekering()

    /**
     * Set the value of [status] column.
     *
     * @param int $v new value
     * @return $this|\fb_model\fb_model\Inschrijving The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[InschrijvingTableMap::COL_STATUS] = true;
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
     * @return $this|\fb_model\fb_model\Inschrijving The current object (for fluent API support)
     */
    public function setDatumGemaakt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->gemaakt_datum !== null || $dt !== null) {
            if ($this->gemaakt_datum === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->gemaakt_datum->format("Y-m-d H:i:s.u")) {
                $this->gemaakt_datum = $dt === null ? null : clone $dt;
                $this->modifiedColumns[InschrijvingTableMap::COL_GEMAAKT_DATUM] = true;
            }
        } // if either are not null

        return $this;
    } // setDatumGemaakt()

    /**
     * Set the value of [gemaakt_door] column.
     *
     * @param string $v new value
     * @return $this|\fb_model\fb_model\Inschrijving The current object (for fluent API support)
     */
    public function setGemaaktDoor($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gemaakt_door !== $v) {
            $this->gemaakt_door = $v;
            $this->modifiedColumns[InschrijvingTableMap::COL_GEMAAKT_DOOR] = true;
        }

        return $this;
    } // setGemaaktDoor()

    /**
     * Sets the value of [gewijzigd_datum] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\fb_model\fb_model\Inschrijving The current object (for fluent API support)
     */
    public function setDatumGewijzigd($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->gewijzigd_datum !== null || $dt !== null) {
            if ($this->gewijzigd_datum === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->gewijzigd_datum->format("Y-m-d H:i:s.u")) {
                $this->gewijzigd_datum = $dt === null ? null : clone $dt;
                $this->modifiedColumns[InschrijvingTableMap::COL_GEWIJZIGD_DATUM] = true;
            }
        } // if either are not null

        return $this;
    } // setDatumGewijzigd()

    /**
     * Set the value of [gewijzigd_door] column.
     *
     * @param string $v new value
     * @return $this|\fb_model\fb_model\Inschrijving The current object (for fluent API support)
     */
    public function setGewijzigdDoor($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gewijzigd_door !== $v) {
            $this->gewijzigd_door = $v;
            $this->modifiedColumns[InschrijvingTableMap::COL_GEWIJZIGD_DOOR] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : InschrijvingTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : InschrijvingTableMap::translateFieldName('EvenementId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->evenement_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : InschrijvingTableMap::translateFieldName('ContactPersoonId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->contactpersoon_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : InschrijvingTableMap::translateFieldName('DatumInschrijving', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->datum_inschrijving = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : InschrijvingTableMap::translateFieldName('AnnuleringsverzekeringAfgesloten', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->annuleringsverzekering_afgesloten = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : InschrijvingTableMap::translateFieldName('Totaalbedrag', TableMap::TYPE_PHPNAME, $indexType)];
            $this->totaalbedrag = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : InschrijvingTableMap::translateFieldName('ReedsBetaald', TableMap::TYPE_PHPNAME, $indexType)];
            $this->reeds_betaald = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : InschrijvingTableMap::translateFieldName('NogTeBetalen', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nog_te_betalen = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : InschrijvingTableMap::translateFieldName('Korting', TableMap::TYPE_PHPNAME, $indexType)];
            $this->korting = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : InschrijvingTableMap::translateFieldName('BetaaldPerVoucher', TableMap::TYPE_PHPNAME, $indexType)];
            $this->betaald_per_voucher = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : InschrijvingTableMap::translateFieldName('VoucherId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->voucher_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : InschrijvingTableMap::translateFieldName('Betaalwijze', TableMap::TYPE_PHPNAME, $indexType)];
            $this->betaalwijze = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : InschrijvingTableMap::translateFieldName('Annuleringsverzekering', TableMap::TYPE_PHPNAME, $indexType)];
            $this->annuleringsverzekering = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : InschrijvingTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : InschrijvingTableMap::translateFieldName('DatumGemaakt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->gemaakt_datum = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : InschrijvingTableMap::translateFieldName('GemaaktDoor', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gemaakt_door = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : InschrijvingTableMap::translateFieldName('DatumGewijzigd', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->gewijzigd_datum = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : InschrijvingTableMap::translateFieldName('GewijzigdDoor', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gewijzigd_door = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 18; // 18 = InschrijvingTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\fb_model\\fb_model\\Inschrijving'), 0, $e);
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
        if ($this->aEvenement !== null && $this->evenement_id !== $this->aEvenement->getId()) {
            $this->aEvenement = null;
        }
        if ($this->aPersoon !== null && $this->contactpersoon_id !== $this->aPersoon->getId()) {
            $this->aPersoon = null;
        }
        if ($this->aVoucher !== null && $this->voucher_id !== $this->aVoucher->getId()) {
            $this->aVoucher = null;
        }
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
            $con = Propel::getServiceContainer()->getReadConnection(InschrijvingTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildInschrijvingQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aEvenement = null;
            $this->aKeuzes = null;
            $this->aVoucher = null;
            $this->aPersoon = null;
            $this->collDeelnemers = null;

            $this->collFactuurNummers = null;

            $this->collInschrijvingHeeftOpties = null;

            $this->collOptieIds = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Inschrijving::setDeleted()
     * @see Inschrijving::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(InschrijvingTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildInschrijvingQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(InschrijvingTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                $time = time();
                $highPrecision = \Propel\Runtime\Util\PropelDateTime::createHighPrecision();
                if (!$this->isColumnModified(InschrijvingTableMap::COL_GEMAAKT_DATUM)) {
                    $this->setDatumGemaakt($highPrecision);
                }
                if (!$this->isColumnModified(InschrijvingTableMap::COL_GEWIJZIGD_DATUM)) {
                    $this->setDatumGewijzigd($highPrecision);
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(InschrijvingTableMap::COL_GEWIJZIGD_DATUM)) {
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
                InschrijvingTableMap::addInstanceToPool($this);
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

            if ($this->aEvenement !== null) {
                if ($this->aEvenement->isModified() || $this->aEvenement->isNew()) {
                    $affectedRows += $this->aEvenement->save($con);
                }
                $this->setEvenement($this->aEvenement);
            }

            if ($this->aKeuzes !== null) {
                if ($this->aKeuzes->isModified() || $this->aKeuzes->isNew()) {
                    $affectedRows += $this->aKeuzes->save($con);
                }
                $this->setKeuzes($this->aKeuzes);
            }

            if ($this->aVoucher !== null) {
                if ($this->aVoucher->isModified() || $this->aVoucher->isNew()) {
                    $affectedRows += $this->aVoucher->save($con);
                }
                $this->setVoucher($this->aVoucher);
            }

            if ($this->aPersoon !== null) {
                if ($this->aPersoon->isModified() || $this->aPersoon->isNew()) {
                    $affectedRows += $this->aPersoon->save($con);
                }
                $this->setPersoon($this->aPersoon);
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

                        $entryPk[2] = $this->getId();
                        $entryPk[1] = $combination[0]->getId();
                        //$combination[1] = Id;
                        $entryPk[0] = $combination[1];

                        $pks[] = $entryPk;
                    }

                    \fb_model\fb_model\InschrijvingHeeftOptieQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->combinationCollOptieIdsScheduledForDeletion = null;
                }

            }

            if (null !== $this->combinationCollOptieIds) {
                foreach ($this->combinationCollOptieIds as $combination) {

                    //$combination[0] = Optie (fb_inschrijving_heeft_optie_fk_c81db2)
                    if (!$combination[0]->isDeleted() && ($combination[0]->isNew() || $combination[0]->isModified())) {
                        $combination[0]->save($con);
                    }

                    //$combination[1] = Id; Nothing to save.
                }
            }


            if ($this->deelnemersScheduledForDeletion !== null) {
                if (!$this->deelnemersScheduledForDeletion->isEmpty()) {
                    \fb_model\fb_model\DeelnemerQuery::create()
                        ->filterByPrimaryKeys($this->deelnemersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->deelnemersScheduledForDeletion = null;
                }
            }

            if ($this->collDeelnemers !== null) {
                foreach ($this->collDeelnemers as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->factuurNummersScheduledForDeletion !== null) {
                if (!$this->factuurNummersScheduledForDeletion->isEmpty()) {
                    \fb_model\fb_model\FactuurNummerQuery::create()
                        ->filterByPrimaryKeys($this->factuurNummersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->factuurNummersScheduledForDeletion = null;
                }
            }

            if ($this->collFactuurNummers !== null) {
                foreach ($this->collFactuurNummers as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->inschrijvingHeeftOptiesScheduledForDeletion !== null) {
                if (!$this->inschrijvingHeeftOptiesScheduledForDeletion->isEmpty()) {
                    \fb_model\fb_model\InschrijvingHeeftOptieQuery::create()
                        ->filterByPrimaryKeys($this->inschrijvingHeeftOptiesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->inschrijvingHeeftOptiesScheduledForDeletion = null;
                }
            }

            if ($this->collInschrijvingHeeftOpties !== null) {
                foreach ($this->collInschrijvingHeeftOpties as $referrerFK) {
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

        $this->modifiedColumns[InschrijvingTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . InschrijvingTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(InschrijvingTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_EVENEMENT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'evenement_id';
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_CONTACTPERSOON_ID)) {
            $modifiedColumns[':p' . $index++]  = 'contactpersoon_id';
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_DATUM_INSCHRIJVING)) {
            $modifiedColumns[':p' . $index++]  = 'datum_inschrijving';
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_ANNULERINGSVERZEKERING_AFGESLOTEN)) {
            $modifiedColumns[':p' . $index++]  = 'annuleringsverzekering_afgesloten';
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_TOTAALBEDRAG)) {
            $modifiedColumns[':p' . $index++]  = 'totaalbedrag';
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_REEDS_BETAALD)) {
            $modifiedColumns[':p' . $index++]  = 'reeds_betaald';
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_NOG_TE_BETALEN)) {
            $modifiedColumns[':p' . $index++]  = 'nog_te_betalen';
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_KORTING)) {
            $modifiedColumns[':p' . $index++]  = 'korting';
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_BETAALD_PER_VOUCHER)) {
            $modifiedColumns[':p' . $index++]  = 'betaald_per_voucher';
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_VOUCHER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'voucher_id';
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_BETAALWIJZE)) {
            $modifiedColumns[':p' . $index++]  = 'betaalwijze';
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_ANNULERINGSVERZEKERING)) {
            $modifiedColumns[':p' . $index++]  = 'annuleringsverzekering';
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'status';
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_GEMAAKT_DATUM)) {
            $modifiedColumns[':p' . $index++]  = 'gemaakt_datum';
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_GEMAAKT_DOOR)) {
            $modifiedColumns[':p' . $index++]  = 'gemaakt_door';
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_GEWIJZIGD_DATUM)) {
            $modifiedColumns[':p' . $index++]  = 'gewijzigd_datum';
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_GEWIJZIGD_DOOR)) {
            $modifiedColumns[':p' . $index++]  = 'gewijzigd_door';
        }

        $sql = sprintf(
            'INSERT INTO fb_inschrijving (%s) VALUES (%s)',
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
                    case 'evenement_id':
                        $stmt->bindValue($identifier, $this->evenement_id, PDO::PARAM_INT);
                        break;
                    case 'contactpersoon_id':
                        $stmt->bindValue($identifier, $this->contactpersoon_id, PDO::PARAM_INT);
                        break;
                    case 'datum_inschrijving':
                        $stmt->bindValue($identifier, $this->datum_inschrijving ? $this->datum_inschrijving->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'annuleringsverzekering_afgesloten':
                        $stmt->bindValue($identifier, $this->annuleringsverzekering_afgesloten ? $this->annuleringsverzekering_afgesloten->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'totaalbedrag':
                        $stmt->bindValue($identifier, $this->totaalbedrag, PDO::PARAM_STR);
                        break;
                    case 'reeds_betaald':
                        $stmt->bindValue($identifier, $this->reeds_betaald, PDO::PARAM_STR);
                        break;
                    case 'nog_te_betalen':
                        $stmt->bindValue($identifier, $this->nog_te_betalen, PDO::PARAM_STR);
                        break;
                    case 'korting':
                        $stmt->bindValue($identifier, $this->korting, PDO::PARAM_STR);
                        break;
                    case 'betaald_per_voucher':
                        $stmt->bindValue($identifier, $this->betaald_per_voucher, PDO::PARAM_STR);
                        break;
                    case 'voucher_id':
                        $stmt->bindValue($identifier, $this->voucher_id, PDO::PARAM_INT);
                        break;
                    case 'betaalwijze':
                        $stmt->bindValue($identifier, $this->betaalwijze, PDO::PARAM_INT);
                        break;
                    case 'annuleringsverzekering':
                        $stmt->bindValue($identifier, $this->annuleringsverzekering, PDO::PARAM_INT);
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
        $pos = InschrijvingTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getEvenementId();
                break;
            case 2:
                return $this->getContactPersoonId();
                break;
            case 3:
                return $this->getDatumInschrijving();
                break;
            case 4:
                return $this->getAnnuleringsverzekeringAfgesloten();
                break;
            case 5:
                return $this->getTotaalbedrag();
                break;
            case 6:
                return $this->getReedsBetaald();
                break;
            case 7:
                return $this->getNogTeBetalen();
                break;
            case 8:
                return $this->getKorting();
                break;
            case 9:
                return $this->getBetaaldPerVoucher();
                break;
            case 10:
                return $this->getVoucherId();
                break;
            case 11:
                return $this->getBetaalwijze();
                break;
            case 12:
                return $this->getAnnuleringsverzekering();
                break;
            case 13:
                return $this->getStatus();
                break;
            case 14:
                return $this->getDatumGemaakt();
                break;
            case 15:
                return $this->getGemaaktDoor();
                break;
            case 16:
                return $this->getDatumGewijzigd();
                break;
            case 17:
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

        if (isset($alreadyDumpedObjects['Inschrijving'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Inschrijving'][$this->hashCode()] = true;
        $keys = InschrijvingTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getEvenementId(),
            $keys[2] => $this->getContactPersoonId(),
            $keys[3] => $this->getDatumInschrijving(),
            $keys[4] => $this->getAnnuleringsverzekeringAfgesloten(),
            $keys[5] => $this->getTotaalbedrag(),
            $keys[6] => $this->getReedsBetaald(),
            $keys[7] => $this->getNogTeBetalen(),
            $keys[8] => $this->getKorting(),
            $keys[9] => $this->getBetaaldPerVoucher(),
            $keys[10] => $this->getVoucherId(),
            $keys[11] => $this->getBetaalwijze(),
            $keys[12] => $this->getAnnuleringsverzekering(),
            $keys[13] => $this->getStatus(),
            $keys[14] => $this->getDatumGemaakt(),
            $keys[15] => $this->getGemaaktDoor(),
            $keys[16] => $this->getDatumGewijzigd(),
            $keys[17] => $this->getGewijzigdDoor(),
        );
        if ($result[$keys[3]] instanceof \DateTimeInterface) {
            $result[$keys[3]] = $result[$keys[3]]->format('c');
        }

        if ($result[$keys[4]] instanceof \DateTimeInterface) {
            $result[$keys[4]] = $result[$keys[4]]->format('c');
        }

        if ($result[$keys[14]] instanceof \DateTimeInterface) {
            $result[$keys[14]] = $result[$keys[14]]->format('c');
        }

        if ($result[$keys[16]] instanceof \DateTimeInterface) {
            $result[$keys[16]] = $result[$keys[16]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aEvenement) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'evenement';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fb_evenement';
                        break;
                    default:
                        $key = 'Evenement';
                }

                $result[$key] = $this->aEvenement->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
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
            if (null !== $this->aVoucher) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'voucher';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fb_voucher';
                        break;
                    default:
                        $key = 'Voucher';
                }

                $result[$key] = $this->aVoucher->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aPersoon) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'persoon';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fb_persoon';
                        break;
                    default:
                        $key = 'Persoon';
                }

                $result[$key] = $this->aPersoon->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collDeelnemers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'deelnemers';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fb_deelnemers';
                        break;
                    default:
                        $key = 'Deelnemers';
                }

                $result[$key] = $this->collDeelnemers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFactuurNummers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'factuurNummers';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fb_factuurs';
                        break;
                    default:
                        $key = 'FactuurNummers';
                }

                $result[$key] = $this->collFactuurNummers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collInschrijvingHeeftOpties) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'inschrijvingHeeftOpties';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fb_inschrijving_heeft_opties';
                        break;
                    default:
                        $key = 'InschrijvingHeeftOpties';
                }

                $result[$key] = $this->collInschrijvingHeeftOpties->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\fb_model\fb_model\Inschrijving
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = InschrijvingTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\fb_model\fb_model\Inschrijving
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setEvenementId($value);
                break;
            case 2:
                $this->setContactPersoonId($value);
                break;
            case 3:
                $this->setDatumInschrijving($value);
                break;
            case 4:
                $this->setAnnuleringsverzekeringAfgesloten($value);
                break;
            case 5:
                $this->setTotaalbedrag($value);
                break;
            case 6:
                $this->setReedsBetaald($value);
                break;
            case 7:
                $this->setNogTeBetalen($value);
                break;
            case 8:
                $this->setKorting($value);
                break;
            case 9:
                $this->setBetaaldPerVoucher($value);
                break;
            case 10:
                $this->setVoucherId($value);
                break;
            case 11:
                $this->setBetaalwijze($value);
                break;
            case 12:
                $this->setAnnuleringsverzekering($value);
                break;
            case 13:
                $this->setStatus($value);
                break;
            case 14:
                $this->setDatumGemaakt($value);
                break;
            case 15:
                $this->setGemaaktDoor($value);
                break;
            case 16:
                $this->setDatumGewijzigd($value);
                break;
            case 17:
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
        $keys = InschrijvingTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setEvenementId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setContactPersoonId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDatumInschrijving($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setAnnuleringsverzekeringAfgesloten($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setTotaalbedrag($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setReedsBetaald($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setNogTeBetalen($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setKorting($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setBetaaldPerVoucher($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setVoucherId($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setBetaalwijze($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setAnnuleringsverzekering($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setStatus($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setDatumGemaakt($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setGemaaktDoor($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setDatumGewijzigd($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setGewijzigdDoor($arr[$keys[17]]);
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
     * @return $this|\fb_model\fb_model\Inschrijving The current object, for fluid interface
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
        $criteria = new Criteria(InschrijvingTableMap::DATABASE_NAME);

        if ($this->isColumnModified(InschrijvingTableMap::COL_ID)) {
            $criteria->add(InschrijvingTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_EVENEMENT_ID)) {
            $criteria->add(InschrijvingTableMap::COL_EVENEMENT_ID, $this->evenement_id);
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_CONTACTPERSOON_ID)) {
            $criteria->add(InschrijvingTableMap::COL_CONTACTPERSOON_ID, $this->contactpersoon_id);
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_DATUM_INSCHRIJVING)) {
            $criteria->add(InschrijvingTableMap::COL_DATUM_INSCHRIJVING, $this->datum_inschrijving);
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_ANNULERINGSVERZEKERING_AFGESLOTEN)) {
            $criteria->add(InschrijvingTableMap::COL_ANNULERINGSVERZEKERING_AFGESLOTEN, $this->annuleringsverzekering_afgesloten);
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_TOTAALBEDRAG)) {
            $criteria->add(InschrijvingTableMap::COL_TOTAALBEDRAG, $this->totaalbedrag);
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_REEDS_BETAALD)) {
            $criteria->add(InschrijvingTableMap::COL_REEDS_BETAALD, $this->reeds_betaald);
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_NOG_TE_BETALEN)) {
            $criteria->add(InschrijvingTableMap::COL_NOG_TE_BETALEN, $this->nog_te_betalen);
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_KORTING)) {
            $criteria->add(InschrijvingTableMap::COL_KORTING, $this->korting);
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_BETAALD_PER_VOUCHER)) {
            $criteria->add(InschrijvingTableMap::COL_BETAALD_PER_VOUCHER, $this->betaald_per_voucher);
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_VOUCHER_ID)) {
            $criteria->add(InschrijvingTableMap::COL_VOUCHER_ID, $this->voucher_id);
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_BETAALWIJZE)) {
            $criteria->add(InschrijvingTableMap::COL_BETAALWIJZE, $this->betaalwijze);
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_ANNULERINGSVERZEKERING)) {
            $criteria->add(InschrijvingTableMap::COL_ANNULERINGSVERZEKERING, $this->annuleringsverzekering);
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_STATUS)) {
            $criteria->add(InschrijvingTableMap::COL_STATUS, $this->status);
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_GEMAAKT_DATUM)) {
            $criteria->add(InschrijvingTableMap::COL_GEMAAKT_DATUM, $this->gemaakt_datum);
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_GEMAAKT_DOOR)) {
            $criteria->add(InschrijvingTableMap::COL_GEMAAKT_DOOR, $this->gemaakt_door);
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_GEWIJZIGD_DATUM)) {
            $criteria->add(InschrijvingTableMap::COL_GEWIJZIGD_DATUM, $this->gewijzigd_datum);
        }
        if ($this->isColumnModified(InschrijvingTableMap::COL_GEWIJZIGD_DOOR)) {
            $criteria->add(InschrijvingTableMap::COL_GEWIJZIGD_DOOR, $this->gewijzigd_door);
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
        $criteria = ChildInschrijvingQuery::create();
        $criteria->add(InschrijvingTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \fb_model\fb_model\Inschrijving (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setEvenementId($this->getEvenementId());
        $copyObj->setContactPersoonId($this->getContactPersoonId());
        $copyObj->setDatumInschrijving($this->getDatumInschrijving());
        $copyObj->setAnnuleringsverzekeringAfgesloten($this->getAnnuleringsverzekeringAfgesloten());
        $copyObj->setTotaalbedrag($this->getTotaalbedrag());
        $copyObj->setReedsBetaald($this->getReedsBetaald());
        $copyObj->setNogTeBetalen($this->getNogTeBetalen());
        $copyObj->setKorting($this->getKorting());
        $copyObj->setBetaaldPerVoucher($this->getBetaaldPerVoucher());
        $copyObj->setVoucherId($this->getVoucherId());
        $copyObj->setBetaalwijze($this->getBetaalwijze());
        $copyObj->setAnnuleringsverzekering($this->getAnnuleringsverzekering());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setDatumGemaakt($this->getDatumGemaakt());
        $copyObj->setGemaaktDoor($this->getGemaaktDoor());
        $copyObj->setDatumGewijzigd($this->getDatumGewijzigd());
        $copyObj->setGewijzigdDoor($this->getGewijzigdDoor());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getDeelnemers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDeelnemer($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFactuurNummers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFactuurNummer($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getInschrijvingHeeftOpties() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addInschrijvingHeeftOptie($relObj->copy($deepCopy));
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
     * @return \fb_model\fb_model\Inschrijving Clone of current object.
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
     * Declares an association between this object and a ChildEvenement object.
     *
     * @param  ChildEvenement $v
     * @return $this|\fb_model\fb_model\Inschrijving The current object (for fluent API support)
     * @throws PropelException
     */
    public function setEvenement(ChildEvenement $v = null)
    {
        if ($v === null) {
            $this->setEvenementId(NULL);
        } else {
            $this->setEvenementId($v->getId());
        }

        $this->aEvenement = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildEvenement object, it will not be re-added.
        if ($v !== null) {
            $v->addInschrijving($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildEvenement object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildEvenement The associated ChildEvenement object.
     * @throws PropelException
     */
    public function getEvenement(ConnectionInterface $con = null)
    {
        if ($this->aEvenement === null && ($this->evenement_id != 0)) {
            $this->aEvenement = ChildEvenementQuery::create()->findPk($this->evenement_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aEvenement->addInschrijvings($this);
             */
        }

        return $this->aEvenement;
    }

    /**
     * Declares an association between this object and a ChildKeuzes object.
     *
     * @param  ChildKeuzes $v
     * @return $this|\fb_model\fb_model\Inschrijving The current object (for fluent API support)
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
            $v->addInschrijving($this);
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
                $this->aKeuzes->addInschrijvings($this);
             */
        }

        return $this->aKeuzes;
    }

    /**
     * Declares an association between this object and a ChildVoucher object.
     *
     * @param  ChildVoucher $v
     * @return $this|\fb_model\fb_model\Inschrijving The current object (for fluent API support)
     * @throws PropelException
     */
    public function setVoucher(ChildVoucher $v = null)
    {
        if ($v === null) {
            $this->setVoucherId(NULL);
        } else {
            $this->setVoucherId($v->getId());
        }

        $this->aVoucher = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildVoucher object, it will not be re-added.
        if ($v !== null) {
            $v->addInschrijving($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildVoucher object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildVoucher The associated ChildVoucher object.
     * @throws PropelException
     */
    public function getVoucher(ConnectionInterface $con = null)
    {
        if ($this->aVoucher === null && ($this->voucher_id != 0)) {
            $this->aVoucher = ChildVoucherQuery::create()->findPk($this->voucher_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aVoucher->addInschrijvings($this);
             */
        }

        return $this->aVoucher;
    }

    /**
     * Declares an association between this object and a ChildPersoon object.
     *
     * @param  ChildPersoon $v
     * @return $this|\fb_model\fb_model\Inschrijving The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPersoon(ChildPersoon $v = null)
    {
        if ($v === null) {
            $this->setContactPersoonId(NULL);
        } else {
            $this->setContactPersoonId($v->getId());
        }

        $this->aPersoon = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPersoon object, it will not be re-added.
        if ($v !== null) {
            $v->addInschrijving($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPersoon object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPersoon The associated ChildPersoon object.
     * @throws PropelException
     */
    public function getPersoon(ConnectionInterface $con = null)
    {
        if ($this->aPersoon === null && ($this->contactpersoon_id != 0)) {
            $this->aPersoon = ChildPersoonQuery::create()->findPk($this->contactpersoon_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPersoon->addInschrijvings($this);
             */
        }

        return $this->aPersoon;
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
        if ('Deelnemer' == $relationName) {
            $this->initDeelnemers();
            return;
        }
        if ('FactuurNummer' == $relationName) {
            $this->initFactuurNummers();
            return;
        }
        if ('InschrijvingHeeftOptie' == $relationName) {
            $this->initInschrijvingHeeftOpties();
            return;
        }
    }

    /**
     * Clears out the collDeelnemers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDeelnemers()
     */
    public function clearDeelnemers()
    {
        $this->collDeelnemers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDeelnemers collection loaded partially.
     */
    public function resetPartialDeelnemers($v = true)
    {
        $this->collDeelnemersPartial = $v;
    }

    /**
     * Initializes the collDeelnemers collection.
     *
     * By default this just sets the collDeelnemers collection to an empty array (like clearcollDeelnemers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDeelnemers($overrideExisting = true)
    {
        if (null !== $this->collDeelnemers && !$overrideExisting) {
            return;
        }

        $collectionClassName = DeelnemerTableMap::getTableMap()->getCollectionClassName();

        $this->collDeelnemers = new $collectionClassName;
        $this->collDeelnemers->setModel('\fb_model\fb_model\Deelnemer');
    }

    /**
     * Gets an array of ChildDeelnemer objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildInschrijving is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDeelnemer[] List of ChildDeelnemer objects
     * @throws PropelException
     */
    public function getDeelnemers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDeelnemersPartial && !$this->isNew();
        if (null === $this->collDeelnemers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDeelnemers) {
                // return empty collection
                $this->initDeelnemers();
            } else {
                $collDeelnemers = ChildDeelnemerQuery::create(null, $criteria)
                    ->filterByInschrijving($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDeelnemersPartial && count($collDeelnemers)) {
                        $this->initDeelnemers(false);

                        foreach ($collDeelnemers as $obj) {
                            if (false == $this->collDeelnemers->contains($obj)) {
                                $this->collDeelnemers->append($obj);
                            }
                        }

                        $this->collDeelnemersPartial = true;
                    }

                    return $collDeelnemers;
                }

                if ($partial && $this->collDeelnemers) {
                    foreach ($this->collDeelnemers as $obj) {
                        if ($obj->isNew()) {
                            $collDeelnemers[] = $obj;
                        }
                    }
                }

                $this->collDeelnemers = $collDeelnemers;
                $this->collDeelnemersPartial = false;
            }
        }

        return $this->collDeelnemers;
    }

    /**
     * Sets a collection of ChildDeelnemer objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $deelnemers A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildInschrijving The current object (for fluent API support)
     */
    public function setDeelnemers(Collection $deelnemers, ConnectionInterface $con = null)
    {
        /** @var ChildDeelnemer[] $deelnemersToDelete */
        $deelnemersToDelete = $this->getDeelnemers(new Criteria(), $con)->diff($deelnemers);


        $this->deelnemersScheduledForDeletion = $deelnemersToDelete;

        foreach ($deelnemersToDelete as $deelnemerRemoved) {
            $deelnemerRemoved->setInschrijving(null);
        }

        $this->collDeelnemers = null;
        foreach ($deelnemers as $deelnemer) {
            $this->addDeelnemer($deelnemer);
        }

        $this->collDeelnemers = $deelnemers;
        $this->collDeelnemersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Deelnemer objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Deelnemer objects.
     * @throws PropelException
     */
    public function countDeelnemers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDeelnemersPartial && !$this->isNew();
        if (null === $this->collDeelnemers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDeelnemers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDeelnemers());
            }

            $query = ChildDeelnemerQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByInschrijving($this)
                ->count($con);
        }

        return count($this->collDeelnemers);
    }

    /**
     * Method called to associate a ChildDeelnemer object to this object
     * through the ChildDeelnemer foreign key attribute.
     *
     * @param  ChildDeelnemer $l ChildDeelnemer
     * @return $this|\fb_model\fb_model\Inschrijving The current object (for fluent API support)
     */
    public function addDeelnemer(ChildDeelnemer $l)
    {
        if ($this->collDeelnemers === null) {
            $this->initDeelnemers();
            $this->collDeelnemersPartial = true;
        }

        if (!$this->collDeelnemers->contains($l)) {
            $this->doAddDeelnemer($l);

            if ($this->deelnemersScheduledForDeletion and $this->deelnemersScheduledForDeletion->contains($l)) {
                $this->deelnemersScheduledForDeletion->remove($this->deelnemersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildDeelnemer $deelnemer The ChildDeelnemer object to add.
     */
    protected function doAddDeelnemer(ChildDeelnemer $deelnemer)
    {
        $this->collDeelnemers[]= $deelnemer;
        $deelnemer->setInschrijving($this);
    }

    /**
     * @param  ChildDeelnemer $deelnemer The ChildDeelnemer object to remove.
     * @return $this|ChildInschrijving The current object (for fluent API support)
     */
    public function removeDeelnemer(ChildDeelnemer $deelnemer)
    {
        if ($this->getDeelnemers()->contains($deelnemer)) {
            $pos = $this->collDeelnemers->search($deelnemer);
            $this->collDeelnemers->remove($pos);
            if (null === $this->deelnemersScheduledForDeletion) {
                $this->deelnemersScheduledForDeletion = clone $this->collDeelnemers;
                $this->deelnemersScheduledForDeletion->clear();
            }
            $this->deelnemersScheduledForDeletion[]= clone $deelnemer;
            $deelnemer->setInschrijving(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Inschrijving is new, it will return
     * an empty collection; or if this Inschrijving has previously
     * been saved, it will retrieve related Deelnemers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Inschrijving.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildDeelnemer[] List of ChildDeelnemer objects
     */
    public function getDeelnemersJoinPersoon(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDeelnemerQuery::create(null, $criteria);
        $query->joinWith('Persoon', $joinBehavior);

        return $this->getDeelnemers($query, $con);
    }

    /**
     * Clears out the collFactuurNummers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFactuurNummers()
     */
    public function clearFactuurNummers()
    {
        $this->collFactuurNummers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collFactuurNummers collection loaded partially.
     */
    public function resetPartialFactuurNummers($v = true)
    {
        $this->collFactuurNummersPartial = $v;
    }

    /**
     * Initializes the collFactuurNummers collection.
     *
     * By default this just sets the collFactuurNummers collection to an empty array (like clearcollFactuurNummers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFactuurNummers($overrideExisting = true)
    {
        if (null !== $this->collFactuurNummers && !$overrideExisting) {
            return;
        }

        $collectionClassName = FactuurNummerTableMap::getTableMap()->getCollectionClassName();

        $this->collFactuurNummers = new $collectionClassName;
        $this->collFactuurNummers->setModel('\fb_model\fb_model\FactuurNummer');
    }

    /**
     * Gets an array of ChildFactuurNummer objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildInschrijving is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildFactuurNummer[] List of ChildFactuurNummer objects
     * @throws PropelException
     */
    public function getFactuurNummers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFactuurNummersPartial && !$this->isNew();
        if (null === $this->collFactuurNummers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFactuurNummers) {
                // return empty collection
                $this->initFactuurNummers();
            } else {
                $collFactuurNummers = ChildFactuurNummerQuery::create(null, $criteria)
                    ->filterByInschrijving($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collFactuurNummersPartial && count($collFactuurNummers)) {
                        $this->initFactuurNummers(false);

                        foreach ($collFactuurNummers as $obj) {
                            if (false == $this->collFactuurNummers->contains($obj)) {
                                $this->collFactuurNummers->append($obj);
                            }
                        }

                        $this->collFactuurNummersPartial = true;
                    }

                    return $collFactuurNummers;
                }

                if ($partial && $this->collFactuurNummers) {
                    foreach ($this->collFactuurNummers as $obj) {
                        if ($obj->isNew()) {
                            $collFactuurNummers[] = $obj;
                        }
                    }
                }

                $this->collFactuurNummers = $collFactuurNummers;
                $this->collFactuurNummersPartial = false;
            }
        }

        return $this->collFactuurNummers;
    }

    /**
     * Sets a collection of ChildFactuurNummer objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $factuurNummers A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildInschrijving The current object (for fluent API support)
     */
    public function setFactuurNummers(Collection $factuurNummers, ConnectionInterface $con = null)
    {
        /** @var ChildFactuurNummer[] $factuurNummersToDelete */
        $factuurNummersToDelete = $this->getFactuurNummers(new Criteria(), $con)->diff($factuurNummers);


        $this->factuurNummersScheduledForDeletion = $factuurNummersToDelete;

        foreach ($factuurNummersToDelete as $factuurNummerRemoved) {
            $factuurNummerRemoved->setInschrijving(null);
        }

        $this->collFactuurNummers = null;
        foreach ($factuurNummers as $factuurNummer) {
            $this->addFactuurNummer($factuurNummer);
        }

        $this->collFactuurNummers = $factuurNummers;
        $this->collFactuurNummersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FactuurNummer objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related FactuurNummer objects.
     * @throws PropelException
     */
    public function countFactuurNummers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFactuurNummersPartial && !$this->isNew();
        if (null === $this->collFactuurNummers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFactuurNummers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFactuurNummers());
            }

            $query = ChildFactuurNummerQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByInschrijving($this)
                ->count($con);
        }

        return count($this->collFactuurNummers);
    }

    /**
     * Method called to associate a ChildFactuurNummer object to this object
     * through the ChildFactuurNummer foreign key attribute.
     *
     * @param  ChildFactuurNummer $l ChildFactuurNummer
     * @return $this|\fb_model\fb_model\Inschrijving The current object (for fluent API support)
     */
    public function addFactuurNummer(ChildFactuurNummer $l)
    {
        if ($this->collFactuurNummers === null) {
            $this->initFactuurNummers();
            $this->collFactuurNummersPartial = true;
        }

        if (!$this->collFactuurNummers->contains($l)) {
            $this->doAddFactuurNummer($l);

            if ($this->factuurNummersScheduledForDeletion and $this->factuurNummersScheduledForDeletion->contains($l)) {
                $this->factuurNummersScheduledForDeletion->remove($this->factuurNummersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildFactuurNummer $factuurNummer The ChildFactuurNummer object to add.
     */
    protected function doAddFactuurNummer(ChildFactuurNummer $factuurNummer)
    {
        $this->collFactuurNummers[]= $factuurNummer;
        $factuurNummer->setInschrijving($this);
    }

    /**
     * @param  ChildFactuurNummer $factuurNummer The ChildFactuurNummer object to remove.
     * @return $this|ChildInschrijving The current object (for fluent API support)
     */
    public function removeFactuurNummer(ChildFactuurNummer $factuurNummer)
    {
        if ($this->getFactuurNummers()->contains($factuurNummer)) {
            $pos = $this->collFactuurNummers->search($factuurNummer);
            $this->collFactuurNummers->remove($pos);
            if (null === $this->factuurNummersScheduledForDeletion) {
                $this->factuurNummersScheduledForDeletion = clone $this->collFactuurNummers;
                $this->factuurNummersScheduledForDeletion->clear();
            }
            $this->factuurNummersScheduledForDeletion[]= clone $factuurNummer;
            $factuurNummer->setInschrijving(null);
        }

        return $this;
    }

    /**
     * Clears out the collInschrijvingHeeftOpties collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addInschrijvingHeeftOpties()
     */
    public function clearInschrijvingHeeftOpties()
    {
        $this->collInschrijvingHeeftOpties = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collInschrijvingHeeftOpties collection loaded partially.
     */
    public function resetPartialInschrijvingHeeftOpties($v = true)
    {
        $this->collInschrijvingHeeftOptiesPartial = $v;
    }

    /**
     * Initializes the collInschrijvingHeeftOpties collection.
     *
     * By default this just sets the collInschrijvingHeeftOpties collection to an empty array (like clearcollInschrijvingHeeftOpties());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initInschrijvingHeeftOpties($overrideExisting = true)
    {
        if (null !== $this->collInschrijvingHeeftOpties && !$overrideExisting) {
            return;
        }

        $collectionClassName = InschrijvingHeeftOptieTableMap::getTableMap()->getCollectionClassName();

        $this->collInschrijvingHeeftOpties = new $collectionClassName;
        $this->collInschrijvingHeeftOpties->setModel('\fb_model\fb_model\InschrijvingHeeftOptie');
    }

    /**
     * Gets an array of ChildInschrijvingHeeftOptie objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildInschrijving is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildInschrijvingHeeftOptie[] List of ChildInschrijvingHeeftOptie objects
     * @throws PropelException
     */
    public function getInschrijvingHeeftOpties(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collInschrijvingHeeftOptiesPartial && !$this->isNew();
        if (null === $this->collInschrijvingHeeftOpties || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collInschrijvingHeeftOpties) {
                // return empty collection
                $this->initInschrijvingHeeftOpties();
            } else {
                $collInschrijvingHeeftOpties = ChildInschrijvingHeeftOptieQuery::create(null, $criteria)
                    ->filterByInschrijving($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collInschrijvingHeeftOptiesPartial && count($collInschrijvingHeeftOpties)) {
                        $this->initInschrijvingHeeftOpties(false);

                        foreach ($collInschrijvingHeeftOpties as $obj) {
                            if (false == $this->collInschrijvingHeeftOpties->contains($obj)) {
                                $this->collInschrijvingHeeftOpties->append($obj);
                            }
                        }

                        $this->collInschrijvingHeeftOptiesPartial = true;
                    }

                    return $collInschrijvingHeeftOpties;
                }

                if ($partial && $this->collInschrijvingHeeftOpties) {
                    foreach ($this->collInschrijvingHeeftOpties as $obj) {
                        if ($obj->isNew()) {
                            $collInschrijvingHeeftOpties[] = $obj;
                        }
                    }
                }

                $this->collInschrijvingHeeftOpties = $collInschrijvingHeeftOpties;
                $this->collInschrijvingHeeftOptiesPartial = false;
            }
        }

        return $this->collInschrijvingHeeftOpties;
    }

    /**
     * Sets a collection of ChildInschrijvingHeeftOptie objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $inschrijvingHeeftOpties A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildInschrijving The current object (for fluent API support)
     */
    public function setInschrijvingHeeftOpties(Collection $inschrijvingHeeftOpties, ConnectionInterface $con = null)
    {
        /** @var ChildInschrijvingHeeftOptie[] $inschrijvingHeeftOptiesToDelete */
        $inschrijvingHeeftOptiesToDelete = $this->getInschrijvingHeeftOpties(new Criteria(), $con)->diff($inschrijvingHeeftOpties);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->inschrijvingHeeftOptiesScheduledForDeletion = clone $inschrijvingHeeftOptiesToDelete;

        foreach ($inschrijvingHeeftOptiesToDelete as $inschrijvingHeeftOptieRemoved) {
            $inschrijvingHeeftOptieRemoved->setInschrijving(null);
        }

        $this->collInschrijvingHeeftOpties = null;
        foreach ($inschrijvingHeeftOpties as $inschrijvingHeeftOptie) {
            $this->addInschrijvingHeeftOptie($inschrijvingHeeftOptie);
        }

        $this->collInschrijvingHeeftOpties = $inschrijvingHeeftOpties;
        $this->collInschrijvingHeeftOptiesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related InschrijvingHeeftOptie objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related InschrijvingHeeftOptie objects.
     * @throws PropelException
     */
    public function countInschrijvingHeeftOpties(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collInschrijvingHeeftOptiesPartial && !$this->isNew();
        if (null === $this->collInschrijvingHeeftOpties || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collInschrijvingHeeftOpties) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getInschrijvingHeeftOpties());
            }

            $query = ChildInschrijvingHeeftOptieQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByInschrijving($this)
                ->count($con);
        }

        return count($this->collInschrijvingHeeftOpties);
    }

    /**
     * Method called to associate a ChildInschrijvingHeeftOptie object to this object
     * through the ChildInschrijvingHeeftOptie foreign key attribute.
     *
     * @param  ChildInschrijvingHeeftOptie $l ChildInschrijvingHeeftOptie
     * @return $this|\fb_model\fb_model\Inschrijving The current object (for fluent API support)
     */
    public function addInschrijvingHeeftOptie(ChildInschrijvingHeeftOptie $l)
    {
        if ($this->collInschrijvingHeeftOpties === null) {
            $this->initInschrijvingHeeftOpties();
            $this->collInschrijvingHeeftOptiesPartial = true;
        }

        if (!$this->collInschrijvingHeeftOpties->contains($l)) {
            $this->doAddInschrijvingHeeftOptie($l);

            if ($this->inschrijvingHeeftOptiesScheduledForDeletion and $this->inschrijvingHeeftOptiesScheduledForDeletion->contains($l)) {
                $this->inschrijvingHeeftOptiesScheduledForDeletion->remove($this->inschrijvingHeeftOptiesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildInschrijvingHeeftOptie $inschrijvingHeeftOptie The ChildInschrijvingHeeftOptie object to add.
     */
    protected function doAddInschrijvingHeeftOptie(ChildInschrijvingHeeftOptie $inschrijvingHeeftOptie)
    {
        $this->collInschrijvingHeeftOpties[]= $inschrijvingHeeftOptie;
        $inschrijvingHeeftOptie->setInschrijving($this);
    }

    /**
     * @param  ChildInschrijvingHeeftOptie $inschrijvingHeeftOptie The ChildInschrijvingHeeftOptie object to remove.
     * @return $this|ChildInschrijving The current object (for fluent API support)
     */
    public function removeInschrijvingHeeftOptie(ChildInschrijvingHeeftOptie $inschrijvingHeeftOptie)
    {
        if ($this->getInschrijvingHeeftOpties()->contains($inschrijvingHeeftOptie)) {
            $pos = $this->collInschrijvingHeeftOpties->search($inschrijvingHeeftOptie);
            $this->collInschrijvingHeeftOpties->remove($pos);
            if (null === $this->inschrijvingHeeftOptiesScheduledForDeletion) {
                $this->inschrijvingHeeftOptiesScheduledForDeletion = clone $this->collInschrijvingHeeftOpties;
                $this->inschrijvingHeeftOptiesScheduledForDeletion->clear();
            }
            $this->inschrijvingHeeftOptiesScheduledForDeletion[]= clone $inschrijvingHeeftOptie;
            $inschrijvingHeeftOptie->setInschrijving(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Inschrijving is new, it will return
     * an empty collection; or if this Inschrijving has previously
     * been saved, it will retrieve related InschrijvingHeeftOpties from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Inschrijving.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildInschrijvingHeeftOptie[] List of ChildInschrijvingHeeftOptie objects
     */
    public function getInschrijvingHeeftOptiesJoinOptie(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildInschrijvingHeeftOptieQuery::create(null, $criteria);
        $query->joinWith('Optie', $joinBehavior);

        return $this->getInschrijvingHeeftOpties($query, $con);
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
            ->filterByInschrijving($this);

        $inschrijvingHeeftOptieQuery = $criteria->useInschrijvingHeeftOptieQuery();

        if (null !== $id) {
            $inschrijvingHeeftOptieQuery->filterById($id);
        }

        $inschrijvingHeeftOptieQuery->endUse();

        return $criteria;
    }

    /**
     * Gets a combined collection of ChildOptie objects related by a many-to-many relationship
     * to the current object by way of the fb_inschrijving_heeft_optie cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildInschrijving is new, it will return
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

                $query = ChildInschrijvingHeeftOptieQuery::create(null, $criteria)
                    ->filterByInschrijving($this)
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
     * to the current object by way of the fb_inschrijving_heeft_optie cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $optieIds A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildInschrijving The current object (for fluent API support)
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
     * to the current object by way of the fb_inschrijving_heeft_optie cross-reference table.
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

                $query = ChildInschrijvingHeeftOptieQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByInschrijving($this)
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
     * through the fb_inschrijving_heeft_optie cross reference table.
     *
     * @param ChildOptie $optie,
     * @param int $id
     * @return ChildInschrijving The current object (for fluent API support)
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
        $inschrijvingHeeftOptie = new ChildInschrijvingHeeftOptie();

        $inschrijvingHeeftOptie->setOptie($optie);
        $inschrijvingHeeftOptie->setId($id);


        $inschrijvingHeeftOptie->setInschrijving($this);

        $this->addInschrijvingHeeftOptie($inschrijvingHeeftOptie);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if ($optie->isInschrijvingIdsLoaded()) {
            $optie->initInschrijvingIds();
            $optie->getInschrijvingIds()->push($this, $id);
        } elseif (!$optie->getInschrijvingIds()->contains($this, $id)) {
            $optie->getInschrijvingIds()->push($this, $id);
        }

    }

    /**
     * Remove optie, id of this object
     * through the fb_inschrijving_heeft_optie cross reference table.
     *
     * @param ChildOptie $optie,
     * @param int $id
     * @return ChildInschrijving The current object (for fluent API support)
     */
    public function removeOptieId(ChildOptie $optie, $id)
    {
        if ($this->getOptieIds()->contains($optie, $id)) {
            $inschrijvingHeeftOptie = new ChildInschrijvingHeeftOptie();
            $inschrijvingHeeftOptie->setOptie($optie);
            if ($optie->isInschrijvingIdsLoaded()) {
                //remove the back reference if available
                $optie->getInschrijvingIds()->removeObject($this, $id);
            }

            $inschrijvingHeeftOptie->setId($id);
            $inschrijvingHeeftOptie->setInschrijving($this);
            $this->removeInschrijvingHeeftOptie(clone $inschrijvingHeeftOptie);
            $inschrijvingHeeftOptie->clear();

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
        if (null !== $this->aEvenement) {
            $this->aEvenement->removeInschrijving($this);
        }
        if (null !== $this->aKeuzes) {
            $this->aKeuzes->removeInschrijving($this);
        }
        if (null !== $this->aVoucher) {
            $this->aVoucher->removeInschrijving($this);
        }
        if (null !== $this->aPersoon) {
            $this->aPersoon->removeInschrijving($this);
        }
        $this->id = null;
        $this->evenement_id = null;
        $this->contactpersoon_id = null;
        $this->datum_inschrijving = null;
        $this->annuleringsverzekering_afgesloten = null;
        $this->totaalbedrag = null;
        $this->reeds_betaald = null;
        $this->nog_te_betalen = null;
        $this->korting = null;
        $this->betaald_per_voucher = null;
        $this->voucher_id = null;
        $this->betaalwijze = null;
        $this->annuleringsverzekering = null;
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
            if ($this->collDeelnemers) {
                foreach ($this->collDeelnemers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFactuurNummers) {
                foreach ($this->collFactuurNummers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collInschrijvingHeeftOpties) {
                foreach ($this->collInschrijvingHeeftOpties as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->combinationCollOptieIds) {
                foreach ($this->combinationCollOptieIds as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collDeelnemers = null;
        $this->collFactuurNummers = null;
        $this->collInschrijvingHeeftOpties = null;
        $this->combinationCollOptieIds = null;
        $this->aEvenement = null;
        $this->aKeuzes = null;
        $this->aVoucher = null;
        $this->aPersoon = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(InschrijvingTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildInschrijving The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[InschrijvingTableMap::COL_GEWIJZIGD_DATUM] = true;

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
