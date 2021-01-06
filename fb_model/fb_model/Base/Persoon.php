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
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;
use fb_model\fb_model\Contactlog as ChildContactlog;
use fb_model\fb_model\ContactlogQuery as ChildContactlogQuery;
use fb_model\fb_model\Deelnemer as ChildDeelnemer;
use fb_model\fb_model\DeelnemerQuery as ChildDeelnemerQuery;
use fb_model\fb_model\Gebruiker as ChildGebruiker;
use fb_model\fb_model\GebruikerQuery as ChildGebruikerQuery;
use fb_model\fb_model\Inschrijving as ChildInschrijving;
use fb_model\fb_model\InschrijvingQuery as ChildInschrijvingQuery;
use fb_model\fb_model\Persoon as ChildPersoon;
use fb_model\fb_model\PersoonQuery as ChildPersoonQuery;
use fb_model\fb_model\Map\ContactlogTableMap;
use fb_model\fb_model\Map\DeelnemerTableMap;
use fb_model\fb_model\Map\GebruikerTableMap;
use fb_model\fb_model\Map\InschrijvingTableMap;
use fb_model\fb_model\Map\PersoonTableMap;

/**
 * Base class that represents a row from the 'fb_persoon' table.
 *
 *
 *
 * @package    propel.generator.fb_model.fb_model.Base
 */
abstract class Persoon implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\fb_model\\fb_model\\Map\\PersoonTableMap';


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
     * The value for the voornaam field.
     *
     * @var        string
     */
    protected $voornaam;

    /**
     * The value for the tussenvoegsel field.
     *
     * @var        string|null
     */
    protected $tussenvoegsel;

    /**
     * The value for the achternaam field.
     *
     * @var        string
     */
    protected $achternaam;

    /**
     * The value for the geboortedatum field.
     *
     * @var        DateTime|null
     */
    protected $geboortedatum;

    /**
     * The value for the geslacht field.
     *
     * @var        string
     */
    protected $geslacht;

    /**
     * The value for the email field.
     *
     * @var        string|null
     */
    protected $email;

    /**
     * The value for the telefoonnummer field.
     *
     * @var        string|null
     */
    protected $telefoonnummer;

    /**
     * The value for the straat field.
     *
     * @var        string
     */
    protected $straat;

    /**
     * The value for the huisnummer field.
     *
     * @var        int
     */
    protected $huisnummer;

    /**
     * The value for the toevoeging field.
     *
     * @var        string|null
     */
    protected $toevoeging;

    /**
     * The value for the postcode field.
     *
     * @var        string
     */
    protected $postcode;

    /**
     * The value for the woonplaats field.
     *
     * @var        string
     */
    protected $woonplaats;

    /**
     * The value for the landnaam field.
     *
     * @var        string|null
     */
    protected $landnaam;

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
     * @var        ObjectCollection|ChildContactlog[] Collection to store aggregation of ChildContactlog objects.
     */
    protected $collContactlogs;
    protected $collContactlogsPartial;

    /**
     * @var        ObjectCollection|ChildDeelnemer[] Collection to store aggregation of ChildDeelnemer objects.
     */
    protected $collDeelnemers;
    protected $collDeelnemersPartial;

    /**
     * @var        ObjectCollection|ChildGebruiker[] Collection to store aggregation of ChildGebruiker objects.
     */
    protected $collGebruikers;
    protected $collGebruikersPartial;

    /**
     * @var        ObjectCollection|ChildInschrijving[] Collection to store aggregation of ChildInschrijving objects.
     */
    protected $collInschrijvings;
    protected $collInschrijvingsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildContactlog[]
     */
    protected $contactlogsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDeelnemer[]
     */
    protected $deelnemersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGebruiker[]
     */
    protected $gebruikersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildInschrijving[]
     */
    protected $inschrijvingsScheduledForDeletion = null;

    /**
     * Initializes internal state of fb_model\fb_model\Base\Persoon object.
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
     * Compares this with another <code>Persoon</code> instance.  If
     * <code>obj</code> is an instance of <code>Persoon</code>, delegates to
     * <code>equals(Persoon)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this The current object, for fluid interface
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
     * @return void
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        Propel::log(get_class($this) . ': ' . $msg, $priority);
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
     * Get the [voornaam] column value.
     *
     * @return string
     */
    public function getVoornaam()
    {
        return $this->voornaam;
    }

    /**
     * Get the [tussenvoegsel] column value.
     *
     * @return string|null
     */
    public function getTussenvoegsel()
    {
        return $this->tussenvoegsel;
    }

    /**
     * Get the [achternaam] column value.
     *
     * @return string
     */
    public function getAchternaam()
    {
        return $this->achternaam;
    }

    /**
     * Get the [optionally formatted] temporal [geboortedatum] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime|null Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getGeboorteDatum($format = null)
    {
        if ($format === null) {
            return $this->geboortedatum;
        } else {
            return $this->geboortedatum instanceof \DateTimeInterface ? $this->geboortedatum->format($format) : null;
        }
    }

    /**
     * Get the [geslacht] column value.
     *
     * @return string
     */
    public function getGeslacht()
    {
        return $this->geslacht;
    }

    /**
     * Get the [email] column value.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the [telefoonnummer] column value.
     *
     * @return string|null
     */
    public function getTelefoonnummer()
    {
        return $this->telefoonnummer;
    }

    /**
     * Get the [straat] column value.
     *
     * @return string
     */
    public function getStraat()
    {
        return $this->straat;
    }

    /**
     * Get the [huisnummer] column value.
     *
     * @return int
     */
    public function getHuisnummer()
    {
        return $this->huisnummer;
    }

    /**
     * Get the [toevoeging] column value.
     *
     * @return string|null
     */
    public function getToevoeging()
    {
        return $this->toevoeging;
    }

    /**
     * Get the [postcode] column value.
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Get the [woonplaats] column value.
     *
     * @return string
     */
    public function getWoonplaats()
    {
        return $this->woonplaats;
    }

    /**
     * Get the [landnaam] column value.
     *
     * @return string|null
     */
    public function getLandnaam()
    {
        return $this->landnaam;
    }

    /**
     * Get the [optionally formatted] temporal [gemaakt_datum] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDatumGemaakt($format = null)
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
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDatumGewijzigd($format = null)
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
     * @param int $v New value
     * @return $this|\fb_model\fb_model\Persoon The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PersoonTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [voornaam] column.
     *
     * @param string $v New value
     * @return $this|\fb_model\fb_model\Persoon The current object (for fluent API support)
     */
    public function setVoornaam($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->voornaam !== $v) {
            $this->voornaam = $v;
            $this->modifiedColumns[PersoonTableMap::COL_VOORNAAM] = true;
        }

        return $this;
    } // setVoornaam()

    /**
     * Set the value of [tussenvoegsel] column.
     *
     * @param string|null $v New value
     * @return $this|\fb_model\fb_model\Persoon The current object (for fluent API support)
     */
    public function setTussenvoegsel($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->tussenvoegsel !== $v) {
            $this->tussenvoegsel = $v;
            $this->modifiedColumns[PersoonTableMap::COL_TUSSENVOEGSEL] = true;
        }

        return $this;
    } // setTussenvoegsel()

    /**
     * Set the value of [achternaam] column.
     *
     * @param string $v New value
     * @return $this|\fb_model\fb_model\Persoon The current object (for fluent API support)
     */
    public function setAchternaam($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->achternaam !== $v) {
            $this->achternaam = $v;
            $this->modifiedColumns[PersoonTableMap::COL_ACHTERNAAM] = true;
        }

        return $this;
    } // setAchternaam()

    /**
     * Sets the value of [geboortedatum] column to a normalized version of the date/time value specified.
     *
     * @param  string|integer|\DateTimeInterface|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\fb_model\fb_model\Persoon The current object (for fluent API support)
     */
    public function setGeboorteDatum($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->geboortedatum !== null || $dt !== null) {
            if ($this->geboortedatum === null || $dt === null || $dt->format("Y-m-d") !== $this->geboortedatum->format("Y-m-d")) {
                $this->geboortedatum = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PersoonTableMap::COL_GEBOORTEDATUM] = true;
            }
        } // if either are not null

        return $this;
    } // setGeboorteDatum()

    /**
     * Set the value of [geslacht] column.
     *
     * @param string $v New value
     * @return $this|\fb_model\fb_model\Persoon The current object (for fluent API support)
     */
    public function setGeslacht($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->geslacht !== $v) {
            $this->geslacht = $v;
            $this->modifiedColumns[PersoonTableMap::COL_GESLACHT] = true;
        }

        return $this;
    } // setGeslacht()

    /**
     * Set the value of [email] column.
     *
     * @param string|null $v New value
     * @return $this|\fb_model\fb_model\Persoon The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[PersoonTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Set the value of [telefoonnummer] column.
     *
     * @param string|null $v New value
     * @return $this|\fb_model\fb_model\Persoon The current object (for fluent API support)
     */
    public function setTelefoonnummer($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->telefoonnummer !== $v) {
            $this->telefoonnummer = $v;
            $this->modifiedColumns[PersoonTableMap::COL_TELEFOONNUMMER] = true;
        }

        return $this;
    } // setTelefoonnummer()

    /**
     * Set the value of [straat] column.
     *
     * @param string $v New value
     * @return $this|\fb_model\fb_model\Persoon The current object (for fluent API support)
     */
    public function setStraat($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->straat !== $v) {
            $this->straat = $v;
            $this->modifiedColumns[PersoonTableMap::COL_STRAAT] = true;
        }

        return $this;
    } // setStraat()

    /**
     * Set the value of [huisnummer] column.
     *
     * @param int $v New value
     * @return $this|\fb_model\fb_model\Persoon The current object (for fluent API support)
     */
    public function setHuisnummer($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->huisnummer !== $v) {
            $this->huisnummer = $v;
            $this->modifiedColumns[PersoonTableMap::COL_HUISNUMMER] = true;
        }

        return $this;
    } // setHuisnummer()

    /**
     * Set the value of [toevoeging] column.
     *
     * @param string|null $v New value
     * @return $this|\fb_model\fb_model\Persoon The current object (for fluent API support)
     */
    public function setToevoeging($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->toevoeging !== $v) {
            $this->toevoeging = $v;
            $this->modifiedColumns[PersoonTableMap::COL_TOEVOEGING] = true;
        }

        return $this;
    } // setToevoeging()

    /**
     * Set the value of [postcode] column.
     *
     * @param string $v New value
     * @return $this|\fb_model\fb_model\Persoon The current object (for fluent API support)
     */
    public function setPostcode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->postcode !== $v) {
            $this->postcode = $v;
            $this->modifiedColumns[PersoonTableMap::COL_POSTCODE] = true;
        }

        return $this;
    } // setPostcode()

    /**
     * Set the value of [woonplaats] column.
     *
     * @param string $v New value
     * @return $this|\fb_model\fb_model\Persoon The current object (for fluent API support)
     */
    public function setWoonplaats($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->woonplaats !== $v) {
            $this->woonplaats = $v;
            $this->modifiedColumns[PersoonTableMap::COL_WOONPLAATS] = true;
        }

        return $this;
    } // setWoonplaats()

    /**
     * Set the value of [landnaam] column.
     *
     * @param string|null $v New value
     * @return $this|\fb_model\fb_model\Persoon The current object (for fluent API support)
     */
    public function setLandnaam($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->landnaam !== $v) {
            $this->landnaam = $v;
            $this->modifiedColumns[PersoonTableMap::COL_LANDNAAM] = true;
        }

        return $this;
    } // setLandnaam()

    /**
     * Sets the value of [gemaakt_datum] column to a normalized version of the date/time value specified.
     *
     * @param  string|integer|\DateTimeInterface $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\fb_model\fb_model\Persoon The current object (for fluent API support)
     */
    public function setDatumGemaakt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->gemaakt_datum !== null || $dt !== null) {
            if ($this->gemaakt_datum === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->gemaakt_datum->format("Y-m-d H:i:s.u")) {
                $this->gemaakt_datum = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PersoonTableMap::COL_GEMAAKT_DATUM] = true;
            }
        } // if either are not null

        return $this;
    } // setDatumGemaakt()

    /**
     * Set the value of [gemaakt_door] column.
     *
     * @param string $v New value
     * @return $this|\fb_model\fb_model\Persoon The current object (for fluent API support)
     */
    public function setGemaaktDoor($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gemaakt_door !== $v) {
            $this->gemaakt_door = $v;
            $this->modifiedColumns[PersoonTableMap::COL_GEMAAKT_DOOR] = true;
        }

        return $this;
    } // setGemaaktDoor()

    /**
     * Sets the value of [gewijzigd_datum] column to a normalized version of the date/time value specified.
     *
     * @param  string|integer|\DateTimeInterface $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\fb_model\fb_model\Persoon The current object (for fluent API support)
     */
    public function setDatumGewijzigd($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->gewijzigd_datum !== null || $dt !== null) {
            if ($this->gewijzigd_datum === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->gewijzigd_datum->format("Y-m-d H:i:s.u")) {
                $this->gewijzigd_datum = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PersoonTableMap::COL_GEWIJZIGD_DATUM] = true;
            }
        } // if either are not null

        return $this;
    } // setDatumGewijzigd()

    /**
     * Set the value of [gewijzigd_door] column.
     *
     * @param string $v New value
     * @return $this|\fb_model\fb_model\Persoon The current object (for fluent API support)
     */
    public function setGewijzigdDoor($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gewijzigd_door !== $v) {
            $this->gewijzigd_door = $v;
            $this->modifiedColumns[PersoonTableMap::COL_GEWIJZIGD_DOOR] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PersoonTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PersoonTableMap::translateFieldName('Voornaam', TableMap::TYPE_PHPNAME, $indexType)];
            $this->voornaam = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PersoonTableMap::translateFieldName('Tussenvoegsel', TableMap::TYPE_PHPNAME, $indexType)];
            $this->tussenvoegsel = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PersoonTableMap::translateFieldName('Achternaam', TableMap::TYPE_PHPNAME, $indexType)];
            $this->achternaam = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PersoonTableMap::translateFieldName('GeboorteDatum', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->geboortedatum = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PersoonTableMap::translateFieldName('Geslacht', TableMap::TYPE_PHPNAME, $indexType)];
            $this->geslacht = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PersoonTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : PersoonTableMap::translateFieldName('Telefoonnummer', TableMap::TYPE_PHPNAME, $indexType)];
            $this->telefoonnummer = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : PersoonTableMap::translateFieldName('Straat', TableMap::TYPE_PHPNAME, $indexType)];
            $this->straat = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : PersoonTableMap::translateFieldName('Huisnummer', TableMap::TYPE_PHPNAME, $indexType)];
            $this->huisnummer = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : PersoonTableMap::translateFieldName('Toevoeging', TableMap::TYPE_PHPNAME, $indexType)];
            $this->toevoeging = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : PersoonTableMap::translateFieldName('Postcode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->postcode = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : PersoonTableMap::translateFieldName('Woonplaats', TableMap::TYPE_PHPNAME, $indexType)];
            $this->woonplaats = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : PersoonTableMap::translateFieldName('Landnaam', TableMap::TYPE_PHPNAME, $indexType)];
            $this->landnaam = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : PersoonTableMap::translateFieldName('DatumGemaakt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->gemaakt_datum = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : PersoonTableMap::translateFieldName('GemaaktDoor', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gemaakt_door = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : PersoonTableMap::translateFieldName('DatumGewijzigd', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->gewijzigd_datum = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : PersoonTableMap::translateFieldName('GewijzigdDoor', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gewijzigd_door = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 18; // 18 = PersoonTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\fb_model\\fb_model\\Persoon'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(PersoonTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPersoonQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collContactlogs = null;

            $this->collDeelnemers = null;

            $this->collGebruikers = null;

            $this->collInschrijvings = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Persoon::setDeleted()
     * @see Persoon::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PersoonTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPersoonQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PersoonTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                $time = time();
                $highPrecision = \Propel\Runtime\Util\PropelDateTime::createHighPrecision();
                if (!$this->isColumnModified(PersoonTableMap::COL_GEMAAKT_DATUM)) {
                    $this->setDatumGemaakt($highPrecision);
                }
                if (!$this->isColumnModified(PersoonTableMap::COL_GEWIJZIGD_DATUM)) {
                    $this->setDatumGewijzigd($highPrecision);
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(PersoonTableMap::COL_GEWIJZIGD_DATUM)) {
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
                PersoonTableMap::addInstanceToPool($this);
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

            if ($this->contactlogsScheduledForDeletion !== null) {
                if (!$this->contactlogsScheduledForDeletion->isEmpty()) {
                    \fb_model\fb_model\ContactlogQuery::create()
                        ->filterByPrimaryKeys($this->contactlogsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->contactlogsScheduledForDeletion = null;
                }
            }

            if ($this->collContactlogs !== null) {
                foreach ($this->collContactlogs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
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

            if ($this->gebruikersScheduledForDeletion !== null) {
                if (!$this->gebruikersScheduledForDeletion->isEmpty()) {
                    \fb_model\fb_model\GebruikerQuery::create()
                        ->filterByPrimaryKeys($this->gebruikersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->gebruikersScheduledForDeletion = null;
                }
            }

            if ($this->collGebruikers !== null) {
                foreach ($this->collGebruikers as $referrerFK) {
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

        $this->modifiedColumns[PersoonTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PersoonTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PersoonTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PersoonTableMap::COL_VOORNAAM)) {
            $modifiedColumns[':p' . $index++]  = 'voornaam';
        }
        if ($this->isColumnModified(PersoonTableMap::COL_TUSSENVOEGSEL)) {
            $modifiedColumns[':p' . $index++]  = 'tussenvoegsel';
        }
        if ($this->isColumnModified(PersoonTableMap::COL_ACHTERNAAM)) {
            $modifiedColumns[':p' . $index++]  = 'achternaam';
        }
        if ($this->isColumnModified(PersoonTableMap::COL_GEBOORTEDATUM)) {
            $modifiedColumns[':p' . $index++]  = 'geboortedatum';
        }
        if ($this->isColumnModified(PersoonTableMap::COL_GESLACHT)) {
            $modifiedColumns[':p' . $index++]  = 'geslacht';
        }
        if ($this->isColumnModified(PersoonTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }
        if ($this->isColumnModified(PersoonTableMap::COL_TELEFOONNUMMER)) {
            $modifiedColumns[':p' . $index++]  = 'telefoonnummer';
        }
        if ($this->isColumnModified(PersoonTableMap::COL_STRAAT)) {
            $modifiedColumns[':p' . $index++]  = 'straat';
        }
        if ($this->isColumnModified(PersoonTableMap::COL_HUISNUMMER)) {
            $modifiedColumns[':p' . $index++]  = 'huisnummer';
        }
        if ($this->isColumnModified(PersoonTableMap::COL_TOEVOEGING)) {
            $modifiedColumns[':p' . $index++]  = 'toevoeging';
        }
        if ($this->isColumnModified(PersoonTableMap::COL_POSTCODE)) {
            $modifiedColumns[':p' . $index++]  = 'postcode';
        }
        if ($this->isColumnModified(PersoonTableMap::COL_WOONPLAATS)) {
            $modifiedColumns[':p' . $index++]  = 'woonplaats';
        }
        if ($this->isColumnModified(PersoonTableMap::COL_LANDNAAM)) {
            $modifiedColumns[':p' . $index++]  = 'landnaam';
        }
        if ($this->isColumnModified(PersoonTableMap::COL_GEMAAKT_DATUM)) {
            $modifiedColumns[':p' . $index++]  = 'gemaakt_datum';
        }
        if ($this->isColumnModified(PersoonTableMap::COL_GEMAAKT_DOOR)) {
            $modifiedColumns[':p' . $index++]  = 'gemaakt_door';
        }
        if ($this->isColumnModified(PersoonTableMap::COL_GEWIJZIGD_DATUM)) {
            $modifiedColumns[':p' . $index++]  = 'gewijzigd_datum';
        }
        if ($this->isColumnModified(PersoonTableMap::COL_GEWIJZIGD_DOOR)) {
            $modifiedColumns[':p' . $index++]  = 'gewijzigd_door';
        }

        $sql = sprintf(
            'INSERT INTO fb_persoon (%s) VALUES (%s)',
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
                    case 'voornaam':
                        $stmt->bindValue($identifier, $this->voornaam, PDO::PARAM_STR);
                        break;
                    case 'tussenvoegsel':
                        $stmt->bindValue($identifier, $this->tussenvoegsel, PDO::PARAM_STR);
                        break;
                    case 'achternaam':
                        $stmt->bindValue($identifier, $this->achternaam, PDO::PARAM_STR);
                        break;
                    case 'geboortedatum':
                        $stmt->bindValue($identifier, $this->geboortedatum ? $this->geboortedatum->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'geslacht':
                        $stmt->bindValue($identifier, $this->geslacht, PDO::PARAM_STR);
                        break;
                    case 'email':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case 'telefoonnummer':
                        $stmt->bindValue($identifier, $this->telefoonnummer, PDO::PARAM_STR);
                        break;
                    case 'straat':
                        $stmt->bindValue($identifier, $this->straat, PDO::PARAM_STR);
                        break;
                    case 'huisnummer':
                        $stmt->bindValue($identifier, $this->huisnummer, PDO::PARAM_INT);
                        break;
                    case 'toevoeging':
                        $stmt->bindValue($identifier, $this->toevoeging, PDO::PARAM_STR);
                        break;
                    case 'postcode':
                        $stmt->bindValue($identifier, $this->postcode, PDO::PARAM_STR);
                        break;
                    case 'woonplaats':
                        $stmt->bindValue($identifier, $this->woonplaats, PDO::PARAM_STR);
                        break;
                    case 'landnaam':
                        $stmt->bindValue($identifier, $this->landnaam, PDO::PARAM_STR);
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
        $pos = PersoonTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getVoornaam();
                break;
            case 2:
                return $this->getTussenvoegsel();
                break;
            case 3:
                return $this->getAchternaam();
                break;
            case 4:
                return $this->getGeboorteDatum();
                break;
            case 5:
                return $this->getGeslacht();
                break;
            case 6:
                return $this->getEmail();
                break;
            case 7:
                return $this->getTelefoonnummer();
                break;
            case 8:
                return $this->getStraat();
                break;
            case 9:
                return $this->getHuisnummer();
                break;
            case 10:
                return $this->getToevoeging();
                break;
            case 11:
                return $this->getPostcode();
                break;
            case 12:
                return $this->getWoonplaats();
                break;
            case 13:
                return $this->getLandnaam();
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

        if (isset($alreadyDumpedObjects['Persoon'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Persoon'][$this->hashCode()] = true;
        $keys = PersoonTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getVoornaam(),
            $keys[2] => $this->getTussenvoegsel(),
            $keys[3] => $this->getAchternaam(),
            $keys[4] => $this->getGeboorteDatum(),
            $keys[5] => $this->getGeslacht(),
            $keys[6] => $this->getEmail(),
            $keys[7] => $this->getTelefoonnummer(),
            $keys[8] => $this->getStraat(),
            $keys[9] => $this->getHuisnummer(),
            $keys[10] => $this->getToevoeging(),
            $keys[11] => $this->getPostcode(),
            $keys[12] => $this->getWoonplaats(),
            $keys[13] => $this->getLandnaam(),
            $keys[14] => $this->getDatumGemaakt(),
            $keys[15] => $this->getGemaaktDoor(),
            $keys[16] => $this->getDatumGewijzigd(),
            $keys[17] => $this->getGewijzigdDoor(),
        );
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
            if (null !== $this->collContactlogs) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'contactlogs';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fb_contactlogs';
                        break;
                    default:
                        $key = 'Contactlogs';
                }

                $result[$key] = $this->collContactlogs->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
            if (null !== $this->collGebruikers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'gebruikers';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fb_gebruikers';
                        break;
                    default:
                        $key = 'Gebruikers';
                }

                $result[$key] = $this->collGebruikers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\fb_model\fb_model\Persoon
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PersoonTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\fb_model\fb_model\Persoon
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setVoornaam($value);
                break;
            case 2:
                $this->setTussenvoegsel($value);
                break;
            case 3:
                $this->setAchternaam($value);
                break;
            case 4:
                $this->setGeboorteDatum($value);
                break;
            case 5:
                $this->setGeslacht($value);
                break;
            case 6:
                $this->setEmail($value);
                break;
            case 7:
                $this->setTelefoonnummer($value);
                break;
            case 8:
                $this->setStraat($value);
                break;
            case 9:
                $this->setHuisnummer($value);
                break;
            case 10:
                $this->setToevoeging($value);
                break;
            case 11:
                $this->setPostcode($value);
                break;
            case 12:
                $this->setWoonplaats($value);
                break;
            case 13:
                $this->setLandnaam($value);
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
        $keys = PersoonTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setVoornaam($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setTussenvoegsel($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setAchternaam($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setGeboorteDatum($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setGeslacht($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setEmail($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setTelefoonnummer($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setStraat($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setHuisnummer($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setToevoeging($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setPostcode($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setWoonplaats($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setLandnaam($arr[$keys[13]]);
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
     * @return $this|\fb_model\fb_model\Persoon The current object, for fluid interface
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
        $criteria = new Criteria(PersoonTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PersoonTableMap::COL_ID)) {
            $criteria->add(PersoonTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PersoonTableMap::COL_VOORNAAM)) {
            $criteria->add(PersoonTableMap::COL_VOORNAAM, $this->voornaam);
        }
        if ($this->isColumnModified(PersoonTableMap::COL_TUSSENVOEGSEL)) {
            $criteria->add(PersoonTableMap::COL_TUSSENVOEGSEL, $this->tussenvoegsel);
        }
        if ($this->isColumnModified(PersoonTableMap::COL_ACHTERNAAM)) {
            $criteria->add(PersoonTableMap::COL_ACHTERNAAM, $this->achternaam);
        }
        if ($this->isColumnModified(PersoonTableMap::COL_GEBOORTEDATUM)) {
            $criteria->add(PersoonTableMap::COL_GEBOORTEDATUM, $this->geboortedatum);
        }
        if ($this->isColumnModified(PersoonTableMap::COL_GESLACHT)) {
            $criteria->add(PersoonTableMap::COL_GESLACHT, $this->geslacht);
        }
        if ($this->isColumnModified(PersoonTableMap::COL_EMAIL)) {
            $criteria->add(PersoonTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(PersoonTableMap::COL_TELEFOONNUMMER)) {
            $criteria->add(PersoonTableMap::COL_TELEFOONNUMMER, $this->telefoonnummer);
        }
        if ($this->isColumnModified(PersoonTableMap::COL_STRAAT)) {
            $criteria->add(PersoonTableMap::COL_STRAAT, $this->straat);
        }
        if ($this->isColumnModified(PersoonTableMap::COL_HUISNUMMER)) {
            $criteria->add(PersoonTableMap::COL_HUISNUMMER, $this->huisnummer);
        }
        if ($this->isColumnModified(PersoonTableMap::COL_TOEVOEGING)) {
            $criteria->add(PersoonTableMap::COL_TOEVOEGING, $this->toevoeging);
        }
        if ($this->isColumnModified(PersoonTableMap::COL_POSTCODE)) {
            $criteria->add(PersoonTableMap::COL_POSTCODE, $this->postcode);
        }
        if ($this->isColumnModified(PersoonTableMap::COL_WOONPLAATS)) {
            $criteria->add(PersoonTableMap::COL_WOONPLAATS, $this->woonplaats);
        }
        if ($this->isColumnModified(PersoonTableMap::COL_LANDNAAM)) {
            $criteria->add(PersoonTableMap::COL_LANDNAAM, $this->landnaam);
        }
        if ($this->isColumnModified(PersoonTableMap::COL_GEMAAKT_DATUM)) {
            $criteria->add(PersoonTableMap::COL_GEMAAKT_DATUM, $this->gemaakt_datum);
        }
        if ($this->isColumnModified(PersoonTableMap::COL_GEMAAKT_DOOR)) {
            $criteria->add(PersoonTableMap::COL_GEMAAKT_DOOR, $this->gemaakt_door);
        }
        if ($this->isColumnModified(PersoonTableMap::COL_GEWIJZIGD_DATUM)) {
            $criteria->add(PersoonTableMap::COL_GEWIJZIGD_DATUM, $this->gewijzigd_datum);
        }
        if ($this->isColumnModified(PersoonTableMap::COL_GEWIJZIGD_DOOR)) {
            $criteria->add(PersoonTableMap::COL_GEWIJZIGD_DOOR, $this->gewijzigd_door);
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
        $criteria = ChildPersoonQuery::create();
        $criteria->add(PersoonTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \fb_model\fb_model\Persoon (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setVoornaam($this->getVoornaam());
        $copyObj->setTussenvoegsel($this->getTussenvoegsel());
        $copyObj->setAchternaam($this->getAchternaam());
        $copyObj->setGeboorteDatum($this->getGeboorteDatum());
        $copyObj->setGeslacht($this->getGeslacht());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setTelefoonnummer($this->getTelefoonnummer());
        $copyObj->setStraat($this->getStraat());
        $copyObj->setHuisnummer($this->getHuisnummer());
        $copyObj->setToevoeging($this->getToevoeging());
        $copyObj->setPostcode($this->getPostcode());
        $copyObj->setWoonplaats($this->getWoonplaats());
        $copyObj->setLandnaam($this->getLandnaam());
        $copyObj->setDatumGemaakt($this->getDatumGemaakt());
        $copyObj->setGemaaktDoor($this->getGemaaktDoor());
        $copyObj->setDatumGewijzigd($this->getDatumGewijzigd());
        $copyObj->setGewijzigdDoor($this->getGewijzigdDoor());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getContactlogs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContactlog($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDeelnemers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDeelnemer($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getGebruikers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGebruiker($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getInschrijvings() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addInschrijving($relObj->copy($deepCopy));
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
     * @return \fb_model\fb_model\Persoon Clone of current object.
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Contactlog' === $relationName) {
            $this->initContactlogs();
            return;
        }
        if ('Deelnemer' === $relationName) {
            $this->initDeelnemers();
            return;
        }
        if ('Gebruiker' === $relationName) {
            $this->initGebruikers();
            return;
        }
        if ('Inschrijving' === $relationName) {
            $this->initInschrijvings();
            return;
        }
    }

    /**
     * Clears out the collContactlogs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addContactlogs()
     */
    public function clearContactlogs()
    {
        $this->collContactlogs = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collContactlogs collection loaded partially.
     */
    public function resetPartialContactlogs($v = true)
    {
        $this->collContactlogsPartial = $v;
    }

    /**
     * Initializes the collContactlogs collection.
     *
     * By default this just sets the collContactlogs collection to an empty array (like clearcollContactlogs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContactlogs($overrideExisting = true)
    {
        if (null !== $this->collContactlogs && !$overrideExisting) {
            return;
        }

        $collectionClassName = ContactlogTableMap::getTableMap()->getCollectionClassName();

        $this->collContactlogs = new $collectionClassName;
        $this->collContactlogs->setModel('\fb_model\fb_model\Contactlog');
    }

    /**
     * Gets an array of ChildContactlog objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPersoon is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildContactlog[] List of ChildContactlog objects
     * @throws PropelException
     */
    public function getContactlogs(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collContactlogsPartial && !$this->isNew();
        if (null === $this->collContactlogs || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collContactlogs) {
                    $this->initContactlogs();
                } else {
                    $collectionClassName = ContactlogTableMap::getTableMap()->getCollectionClassName();

                    $collContactlogs = new $collectionClassName;
                    $collContactlogs->setModel('\fb_model\fb_model\Contactlog');

                    return $collContactlogs;
                }
            } else {
                $collContactlogs = ChildContactlogQuery::create(null, $criteria)
                    ->filterByPersoon($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collContactlogsPartial && count($collContactlogs)) {
                        $this->initContactlogs(false);

                        foreach ($collContactlogs as $obj) {
                            if (false == $this->collContactlogs->contains($obj)) {
                                $this->collContactlogs->append($obj);
                            }
                        }

                        $this->collContactlogsPartial = true;
                    }

                    return $collContactlogs;
                }

                if ($partial && $this->collContactlogs) {
                    foreach ($this->collContactlogs as $obj) {
                        if ($obj->isNew()) {
                            $collContactlogs[] = $obj;
                        }
                    }
                }

                $this->collContactlogs = $collContactlogs;
                $this->collContactlogsPartial = false;
            }
        }

        return $this->collContactlogs;
    }

    /**
     * Sets a collection of ChildContactlog objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $contactlogs A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPersoon The current object (for fluent API support)
     */
    public function setContactlogs(Collection $contactlogs, ConnectionInterface $con = null)
    {
        /** @var ChildContactlog[] $contactlogsToDelete */
        $contactlogsToDelete = $this->getContactlogs(new Criteria(), $con)->diff($contactlogs);


        $this->contactlogsScheduledForDeletion = $contactlogsToDelete;

        foreach ($contactlogsToDelete as $contactlogRemoved) {
            $contactlogRemoved->setPersoon(null);
        }

        $this->collContactlogs = null;
        foreach ($contactlogs as $contactlog) {
            $this->addContactlog($contactlog);
        }

        $this->collContactlogs = $contactlogs;
        $this->collContactlogsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Contactlog objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Contactlog objects.
     * @throws PropelException
     */
    public function countContactlogs(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collContactlogsPartial && !$this->isNew();
        if (null === $this->collContactlogs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContactlogs) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getContactlogs());
            }

            $query = ChildContactlogQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPersoon($this)
                ->count($con);
        }

        return count($this->collContactlogs);
    }

    /**
     * Method called to associate a ChildContactlog object to this object
     * through the ChildContactlog foreign key attribute.
     *
     * @param  ChildContactlog $l ChildContactlog
     * @return $this|\fb_model\fb_model\Persoon The current object (for fluent API support)
     */
    public function addContactlog(ChildContactlog $l)
    {
        if ($this->collContactlogs === null) {
            $this->initContactlogs();
            $this->collContactlogsPartial = true;
        }

        if (!$this->collContactlogs->contains($l)) {
            $this->doAddContactlog($l);

            if ($this->contactlogsScheduledForDeletion and $this->contactlogsScheduledForDeletion->contains($l)) {
                $this->contactlogsScheduledForDeletion->remove($this->contactlogsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildContactlog $contactlog The ChildContactlog object to add.
     */
    protected function doAddContactlog(ChildContactlog $contactlog)
    {
        $this->collContactlogs[]= $contactlog;
        $contactlog->setPersoon($this);
    }

    /**
     * @param  ChildContactlog $contactlog The ChildContactlog object to remove.
     * @return $this|ChildPersoon The current object (for fluent API support)
     */
    public function removeContactlog(ChildContactlog $contactlog)
    {
        if ($this->getContactlogs()->contains($contactlog)) {
            $pos = $this->collContactlogs->search($contactlog);
            $this->collContactlogs->remove($pos);
            if (null === $this->contactlogsScheduledForDeletion) {
                $this->contactlogsScheduledForDeletion = clone $this->collContactlogs;
                $this->contactlogsScheduledForDeletion->clear();
            }
            $this->contactlogsScheduledForDeletion[]= clone $contactlog;
            $contactlog->setPersoon(null);
        }

        return $this;
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
     * If this ChildPersoon is new, it will return
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
        if (null === $this->collDeelnemers || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collDeelnemers) {
                    $this->initDeelnemers();
                } else {
                    $collectionClassName = DeelnemerTableMap::getTableMap()->getCollectionClassName();

                    $collDeelnemers = new $collectionClassName;
                    $collDeelnemers->setModel('\fb_model\fb_model\Deelnemer');

                    return $collDeelnemers;
                }
            } else {
                $collDeelnemers = ChildDeelnemerQuery::create(null, $criteria)
                    ->filterByPersoon($this)
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
     * @return $this|ChildPersoon The current object (for fluent API support)
     */
    public function setDeelnemers(Collection $deelnemers, ConnectionInterface $con = null)
    {
        /** @var ChildDeelnemer[] $deelnemersToDelete */
        $deelnemersToDelete = $this->getDeelnemers(new Criteria(), $con)->diff($deelnemers);


        $this->deelnemersScheduledForDeletion = $deelnemersToDelete;

        foreach ($deelnemersToDelete as $deelnemerRemoved) {
            $deelnemerRemoved->setPersoon(null);
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
                ->filterByPersoon($this)
                ->count($con);
        }

        return count($this->collDeelnemers);
    }

    /**
     * Method called to associate a ChildDeelnemer object to this object
     * through the ChildDeelnemer foreign key attribute.
     *
     * @param  ChildDeelnemer $l ChildDeelnemer
     * @return $this|\fb_model\fb_model\Persoon The current object (for fluent API support)
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
        $deelnemer->setPersoon($this);
    }

    /**
     * @param  ChildDeelnemer $deelnemer The ChildDeelnemer object to remove.
     * @return $this|ChildPersoon The current object (for fluent API support)
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
            $deelnemer->setPersoon(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Persoon is new, it will return
     * an empty collection; or if this Persoon has previously
     * been saved, it will retrieve related Deelnemers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Persoon.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildDeelnemer[] List of ChildDeelnemer objects
     */
    public function getDeelnemersJoinInschrijving(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDeelnemerQuery::create(null, $criteria);
        $query->joinWith('Inschrijving', $joinBehavior);

        return $this->getDeelnemers($query, $con);
    }

    /**
     * Clears out the collGebruikers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGebruikers()
     */
    public function clearGebruikers()
    {
        $this->collGebruikers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collGebruikers collection loaded partially.
     */
    public function resetPartialGebruikers($v = true)
    {
        $this->collGebruikersPartial = $v;
    }

    /**
     * Initializes the collGebruikers collection.
     *
     * By default this just sets the collGebruikers collection to an empty array (like clearcollGebruikers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGebruikers($overrideExisting = true)
    {
        if (null !== $this->collGebruikers && !$overrideExisting) {
            return;
        }

        $collectionClassName = GebruikerTableMap::getTableMap()->getCollectionClassName();

        $this->collGebruikers = new $collectionClassName;
        $this->collGebruikers->setModel('\fb_model\fb_model\Gebruiker');
    }

    /**
     * Gets an array of ChildGebruiker objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPersoon is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGebruiker[] List of ChildGebruiker objects
     * @throws PropelException
     */
    public function getGebruikers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGebruikersPartial && !$this->isNew();
        if (null === $this->collGebruikers || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collGebruikers) {
                    $this->initGebruikers();
                } else {
                    $collectionClassName = GebruikerTableMap::getTableMap()->getCollectionClassName();

                    $collGebruikers = new $collectionClassName;
                    $collGebruikers->setModel('\fb_model\fb_model\Gebruiker');

                    return $collGebruikers;
                }
            } else {
                $collGebruikers = ChildGebruikerQuery::create(null, $criteria)
                    ->filterByPersoon($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collGebruikersPartial && count($collGebruikers)) {
                        $this->initGebruikers(false);

                        foreach ($collGebruikers as $obj) {
                            if (false == $this->collGebruikers->contains($obj)) {
                                $this->collGebruikers->append($obj);
                            }
                        }

                        $this->collGebruikersPartial = true;
                    }

                    return $collGebruikers;
                }

                if ($partial && $this->collGebruikers) {
                    foreach ($this->collGebruikers as $obj) {
                        if ($obj->isNew()) {
                            $collGebruikers[] = $obj;
                        }
                    }
                }

                $this->collGebruikers = $collGebruikers;
                $this->collGebruikersPartial = false;
            }
        }

        return $this->collGebruikers;
    }

    /**
     * Sets a collection of ChildGebruiker objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $gebruikers A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPersoon The current object (for fluent API support)
     */
    public function setGebruikers(Collection $gebruikers, ConnectionInterface $con = null)
    {
        /** @var ChildGebruiker[] $gebruikersToDelete */
        $gebruikersToDelete = $this->getGebruikers(new Criteria(), $con)->diff($gebruikers);


        $this->gebruikersScheduledForDeletion = $gebruikersToDelete;

        foreach ($gebruikersToDelete as $gebruikerRemoved) {
            $gebruikerRemoved->setPersoon(null);
        }

        $this->collGebruikers = null;
        foreach ($gebruikers as $gebruiker) {
            $this->addGebruiker($gebruiker);
        }

        $this->collGebruikers = $gebruikers;
        $this->collGebruikersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Gebruiker objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Gebruiker objects.
     * @throws PropelException
     */
    public function countGebruikers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGebruikersPartial && !$this->isNew();
        if (null === $this->collGebruikers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGebruikers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGebruikers());
            }

            $query = ChildGebruikerQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPersoon($this)
                ->count($con);
        }

        return count($this->collGebruikers);
    }

    /**
     * Method called to associate a ChildGebruiker object to this object
     * through the ChildGebruiker foreign key attribute.
     *
     * @param  ChildGebruiker $l ChildGebruiker
     * @return $this|\fb_model\fb_model\Persoon The current object (for fluent API support)
     */
    public function addGebruiker(ChildGebruiker $l)
    {
        if ($this->collGebruikers === null) {
            $this->initGebruikers();
            $this->collGebruikersPartial = true;
        }

        if (!$this->collGebruikers->contains($l)) {
            $this->doAddGebruiker($l);

            if ($this->gebruikersScheduledForDeletion and $this->gebruikersScheduledForDeletion->contains($l)) {
                $this->gebruikersScheduledForDeletion->remove($this->gebruikersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildGebruiker $gebruiker The ChildGebruiker object to add.
     */
    protected function doAddGebruiker(ChildGebruiker $gebruiker)
    {
        $this->collGebruikers[]= $gebruiker;
        $gebruiker->setPersoon($this);
    }

    /**
     * @param  ChildGebruiker $gebruiker The ChildGebruiker object to remove.
     * @return $this|ChildPersoon The current object (for fluent API support)
     */
    public function removeGebruiker(ChildGebruiker $gebruiker)
    {
        if ($this->getGebruikers()->contains($gebruiker)) {
            $pos = $this->collGebruikers->search($gebruiker);
            $this->collGebruikers->remove($pos);
            if (null === $this->gebruikersScheduledForDeletion) {
                $this->gebruikersScheduledForDeletion = clone $this->collGebruikers;
                $this->gebruikersScheduledForDeletion->clear();
            }
            $this->gebruikersScheduledForDeletion[]= clone $gebruiker;
            $gebruiker->setPersoon(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Persoon is new, it will return
     * an empty collection; or if this Persoon has previously
     * been saved, it will retrieve related Gebruikers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Persoon.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGebruiker[] List of ChildGebruiker objects
     */
    public function getGebruikersJoinKeuzes(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGebruikerQuery::create(null, $criteria);
        $query->joinWith('Keuzes', $joinBehavior);

        return $this->getGebruikers($query, $con);
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
     * If this ChildPersoon is new, it will return
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
        if (null === $this->collInschrijvings || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collInschrijvings) {
                    $this->initInschrijvings();
                } else {
                    $collectionClassName = InschrijvingTableMap::getTableMap()->getCollectionClassName();

                    $collInschrijvings = new $collectionClassName;
                    $collInschrijvings->setModel('\fb_model\fb_model\Inschrijving');

                    return $collInschrijvings;
                }
            } else {
                $collInschrijvings = ChildInschrijvingQuery::create(null, $criteria)
                    ->filterByPersoon($this)
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
     * @return $this|ChildPersoon The current object (for fluent API support)
     */
    public function setInschrijvings(Collection $inschrijvings, ConnectionInterface $con = null)
    {
        /** @var ChildInschrijving[] $inschrijvingsToDelete */
        $inschrijvingsToDelete = $this->getInschrijvings(new Criteria(), $con)->diff($inschrijvings);


        $this->inschrijvingsScheduledForDeletion = $inschrijvingsToDelete;

        foreach ($inschrijvingsToDelete as $inschrijvingRemoved) {
            $inschrijvingRemoved->setPersoon(null);
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
                ->filterByPersoon($this)
                ->count($con);
        }

        return count($this->collInschrijvings);
    }

    /**
     * Method called to associate a ChildInschrijving object to this object
     * through the ChildInschrijving foreign key attribute.
     *
     * @param  ChildInschrijving $l ChildInschrijving
     * @return $this|\fb_model\fb_model\Persoon The current object (for fluent API support)
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
        $inschrijving->setPersoon($this);
    }

    /**
     * @param  ChildInschrijving $inschrijving The ChildInschrijving object to remove.
     * @return $this|ChildPersoon The current object (for fluent API support)
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
            $inschrijving->setPersoon(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Persoon is new, it will return
     * an empty collection; or if this Persoon has previously
     * been saved, it will retrieve related Inschrijvings from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Persoon.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildInschrijving[] List of ChildInschrijving objects
     */
    public function getInschrijvingsJoinEvenement(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildInschrijvingQuery::create(null, $criteria);
        $query->joinWith('Evenement', $joinBehavior);

        return $this->getInschrijvings($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Persoon is new, it will return
     * an empty collection; or if this Persoon has previously
     * been saved, it will retrieve related Inschrijvings from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Persoon.
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
     * Otherwise if this Persoon is new, it will return
     * an empty collection; or if this Persoon has previously
     * been saved, it will retrieve related Inschrijvings from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Persoon.
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
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->voornaam = null;
        $this->tussenvoegsel = null;
        $this->achternaam = null;
        $this->geboortedatum = null;
        $this->geslacht = null;
        $this->email = null;
        $this->telefoonnummer = null;
        $this->straat = null;
        $this->huisnummer = null;
        $this->toevoeging = null;
        $this->postcode = null;
        $this->woonplaats = null;
        $this->landnaam = null;
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
            if ($this->collContactlogs) {
                foreach ($this->collContactlogs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDeelnemers) {
                foreach ($this->collDeelnemers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collGebruikers) {
                foreach ($this->collGebruikers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collInschrijvings) {
                foreach ($this->collInschrijvings as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collContactlogs = null;
        $this->collDeelnemers = null;
        $this->collGebruikers = null;
        $this->collInschrijvings = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PersoonTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildPersoon The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[PersoonTableMap::COL_GEWIJZIGD_DATUM] = true;

        return $this;
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
            }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
            }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
            }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
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
