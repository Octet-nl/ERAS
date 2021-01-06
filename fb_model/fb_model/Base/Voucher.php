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
use fb_model\fb_model\Evenement as ChildEvenement;
use fb_model\fb_model\EvenementQuery as ChildEvenementQuery;
use fb_model\fb_model\Inschrijving as ChildInschrijving;
use fb_model\fb_model\InschrijvingQuery as ChildInschrijvingQuery;
use fb_model\fb_model\Voucher as ChildVoucher;
use fb_model\fb_model\VoucherQuery as ChildVoucherQuery;
use fb_model\fb_model\Map\InschrijvingTableMap;
use fb_model\fb_model\Map\VoucherTableMap;

/**
 * Base class that represents a row from the 'fb_voucher' table.
 *
 *
 *
 * @package    propel.generator.fb_model.fb_model.Base
 */
abstract class Voucher implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\fb_model\\fb_model\\Map\\VoucherTableMap';


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
     * The value for the code field.
     *
     * @var        string
     */
    protected $code;

    /**
     * The value for the email field.
     *
     * @var        string|null
     */
    protected $email;

    /**
     * The value for the evenement_id field.
     *
     * @var        int|null
     */
    protected $evenement_id;

    /**
     * The value for the oorsprongwaarde field.
     *
     * @var        string|null
     */
    protected $oorsprongwaarde;

    /**
     * The value for the restwaarde field.
     *
     * @var        string|null
     */
    protected $restwaarde;

    /**
     * The value for the verbruikt field.
     *
     * @var        string|null
     */
    protected $verbruikt;

    /**
     * The value for the vouchertype field.
     *
     * @var        int
     */
    protected $vouchertype;

    /**
     * The value for the actief field.
     *
     * @var        int
     */
    protected $actief;

    /**
     * The value for the geldig_tot field.
     *
     * @var        DateTime
     */
    protected $geldig_tot;

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
     * @var ObjectCollection|ChildInschrijving[]
     */
    protected $inschrijvingsScheduledForDeletion = null;

    /**
     * Initializes internal state of fb_model\fb_model\Base\Voucher object.
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
     * Compares this with another <code>Voucher</code> instance.  If
     * <code>obj</code> is an instance of <code>Voucher</code>, delegates to
     * <code>equals(Voucher)</code>.  Otherwise, returns <code>false</code>.
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
     * Get the [code] column value.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
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
     * Get the [evenement_id] column value.
     *
     * @return int|null
     */
    public function getEvenementId()
    {
        return $this->evenement_id;
    }

    /**
     * Get the [oorsprongwaarde] column value.
     *
     * @return string|null
     */
    public function getOorspronkelijkeWaarde()
    {
        return $this->oorsprongwaarde;
    }

    /**
     * Get the [restwaarde] column value.
     *
     * @return string|null
     */
    public function getRestWaarde()
    {
        return $this->restwaarde;
    }

    /**
     * Get the [verbruikt] column value.
     *
     * @return string|null
     */
    public function getVerbruikt()
    {
        return $this->verbruikt;
    }

    /**
     * Get the [vouchertype] column value.
     *
     * @return int
     */
    public function getVoucherType()
    {
        return $this->vouchertype;
    }

    /**
     * Get the [actief] column value.
     *
     * @return int
     */
    public function getIsActief()
    {
        return $this->actief;
    }

    /**
     * Get the [optionally formatted] temporal [geldig_tot] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getGeldigTot($format = null)
    {
        if ($format === null) {
            return $this->geldig_tot;
        } else {
            return $this->geldig_tot instanceof \DateTimeInterface ? $this->geldig_tot->format($format) : null;
        }
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
     * @return $this|\fb_model\fb_model\Voucher The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[VoucherTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [code] column.
     *
     * @param string $v New value
     * @return $this|\fb_model\fb_model\Voucher The current object (for fluent API support)
     */
    public function setCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->code !== $v) {
            $this->code = $v;
            $this->modifiedColumns[VoucherTableMap::COL_CODE] = true;
        }

        return $this;
    } // setCode()

    /**
     * Set the value of [email] column.
     *
     * @param string|null $v New value
     * @return $this|\fb_model\fb_model\Voucher The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[VoucherTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Set the value of [evenement_id] column.
     *
     * @param int|null $v New value
     * @return $this|\fb_model\fb_model\Voucher The current object (for fluent API support)
     */
    public function setEvenementId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->evenement_id !== $v) {
            $this->evenement_id = $v;
            $this->modifiedColumns[VoucherTableMap::COL_EVENEMENT_ID] = true;
        }

        if ($this->aEvenement !== null && $this->aEvenement->getId() !== $v) {
            $this->aEvenement = null;
        }

        return $this;
    } // setEvenementId()

    /**
     * Set the value of [oorsprongwaarde] column.
     *
     * @param string|null $v New value
     * @return $this|\fb_model\fb_model\Voucher The current object (for fluent API support)
     */
    public function setOorspronkelijkeWaarde($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->oorsprongwaarde !== $v) {
            $this->oorsprongwaarde = $v;
            $this->modifiedColumns[VoucherTableMap::COL_OORSPRONGWAARDE] = true;
        }

        return $this;
    } // setOorspronkelijkeWaarde()

    /**
     * Set the value of [restwaarde] column.
     *
     * @param string|null $v New value
     * @return $this|\fb_model\fb_model\Voucher The current object (for fluent API support)
     */
    public function setRestWaarde($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->restwaarde !== $v) {
            $this->restwaarde = $v;
            $this->modifiedColumns[VoucherTableMap::COL_RESTWAARDE] = true;
        }

        return $this;
    } // setRestWaarde()

    /**
     * Set the value of [verbruikt] column.
     *
     * @param string|null $v New value
     * @return $this|\fb_model\fb_model\Voucher The current object (for fluent API support)
     */
    public function setVerbruikt($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->verbruikt !== $v) {
            $this->verbruikt = $v;
            $this->modifiedColumns[VoucherTableMap::COL_VERBRUIKT] = true;
        }

        return $this;
    } // setVerbruikt()

    /**
     * Set the value of [vouchertype] column.
     *
     * @param int $v New value
     * @return $this|\fb_model\fb_model\Voucher The current object (for fluent API support)
     */
    public function setVoucherType($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->vouchertype !== $v) {
            $this->vouchertype = $v;
            $this->modifiedColumns[VoucherTableMap::COL_VOUCHERTYPE] = true;
        }

        return $this;
    } // setVoucherType()

    /**
     * Set the value of [actief] column.
     *
     * @param int $v New value
     * @return $this|\fb_model\fb_model\Voucher The current object (for fluent API support)
     */
    public function setIsActief($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->actief !== $v) {
            $this->actief = $v;
            $this->modifiedColumns[VoucherTableMap::COL_ACTIEF] = true;
        }

        return $this;
    } // setIsActief()

    /**
     * Sets the value of [geldig_tot] column to a normalized version of the date/time value specified.
     *
     * @param  string|integer|\DateTimeInterface $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\fb_model\fb_model\Voucher The current object (for fluent API support)
     */
    public function setGeldigTot($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->geldig_tot !== null || $dt !== null) {
            if ($this->geldig_tot === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->geldig_tot->format("Y-m-d H:i:s.u")) {
                $this->geldig_tot = $dt === null ? null : clone $dt;
                $this->modifiedColumns[VoucherTableMap::COL_GELDIG_TOT] = true;
            }
        } // if either are not null

        return $this;
    } // setGeldigTot()

    /**
     * Sets the value of [gemaakt_datum] column to a normalized version of the date/time value specified.
     *
     * @param  string|integer|\DateTimeInterface $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\fb_model\fb_model\Voucher The current object (for fluent API support)
     */
    public function setDatumGemaakt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->gemaakt_datum !== null || $dt !== null) {
            if ($this->gemaakt_datum === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->gemaakt_datum->format("Y-m-d H:i:s.u")) {
                $this->gemaakt_datum = $dt === null ? null : clone $dt;
                $this->modifiedColumns[VoucherTableMap::COL_GEMAAKT_DATUM] = true;
            }
        } // if either are not null

        return $this;
    } // setDatumGemaakt()

    /**
     * Set the value of [gemaakt_door] column.
     *
     * @param string $v New value
     * @return $this|\fb_model\fb_model\Voucher The current object (for fluent API support)
     */
    public function setGemaaktDoor($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gemaakt_door !== $v) {
            $this->gemaakt_door = $v;
            $this->modifiedColumns[VoucherTableMap::COL_GEMAAKT_DOOR] = true;
        }

        return $this;
    } // setGemaaktDoor()

    /**
     * Sets the value of [gewijzigd_datum] column to a normalized version of the date/time value specified.
     *
     * @param  string|integer|\DateTimeInterface $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\fb_model\fb_model\Voucher The current object (for fluent API support)
     */
    public function setDatumGewijzigd($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->gewijzigd_datum !== null || $dt !== null) {
            if ($this->gewijzigd_datum === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->gewijzigd_datum->format("Y-m-d H:i:s.u")) {
                $this->gewijzigd_datum = $dt === null ? null : clone $dt;
                $this->modifiedColumns[VoucherTableMap::COL_GEWIJZIGD_DATUM] = true;
            }
        } // if either are not null

        return $this;
    } // setDatumGewijzigd()

    /**
     * Set the value of [gewijzigd_door] column.
     *
     * @param string $v New value
     * @return $this|\fb_model\fb_model\Voucher The current object (for fluent API support)
     */
    public function setGewijzigdDoor($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gewijzigd_door !== $v) {
            $this->gewijzigd_door = $v;
            $this->modifiedColumns[VoucherTableMap::COL_GEWIJZIGD_DOOR] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : VoucherTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : VoucherTableMap::translateFieldName('Code', TableMap::TYPE_PHPNAME, $indexType)];
            $this->code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : VoucherTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : VoucherTableMap::translateFieldName('EvenementId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->evenement_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : VoucherTableMap::translateFieldName('OorspronkelijkeWaarde', TableMap::TYPE_PHPNAME, $indexType)];
            $this->oorsprongwaarde = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : VoucherTableMap::translateFieldName('RestWaarde', TableMap::TYPE_PHPNAME, $indexType)];
            $this->restwaarde = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : VoucherTableMap::translateFieldName('Verbruikt', TableMap::TYPE_PHPNAME, $indexType)];
            $this->verbruikt = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : VoucherTableMap::translateFieldName('VoucherType', TableMap::TYPE_PHPNAME, $indexType)];
            $this->vouchertype = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : VoucherTableMap::translateFieldName('IsActief', TableMap::TYPE_PHPNAME, $indexType)];
            $this->actief = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : VoucherTableMap::translateFieldName('GeldigTot', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->geldig_tot = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : VoucherTableMap::translateFieldName('DatumGemaakt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->gemaakt_datum = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : VoucherTableMap::translateFieldName('GemaaktDoor', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gemaakt_door = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : VoucherTableMap::translateFieldName('DatumGewijzigd', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->gewijzigd_datum = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : VoucherTableMap::translateFieldName('GewijzigdDoor', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gewijzigd_door = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 14; // 14 = VoucherTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\fb_model\\fb_model\\Voucher'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(VoucherTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildVoucherQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aEvenement = null;
            $this->collInschrijvings = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Voucher::setDeleted()
     * @see Voucher::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(VoucherTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildVoucherQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(VoucherTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                $time = time();
                $highPrecision = \Propel\Runtime\Util\PropelDateTime::createHighPrecision();
                if (!$this->isColumnModified(VoucherTableMap::COL_GEMAAKT_DATUM)) {
                    $this->setDatumGemaakt($highPrecision);
                }
                if (!$this->isColumnModified(VoucherTableMap::COL_GEWIJZIGD_DATUM)) {
                    $this->setDatumGewijzigd($highPrecision);
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(VoucherTableMap::COL_GEWIJZIGD_DATUM)) {
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
                VoucherTableMap::addInstanceToPool($this);
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

            if ($this->inschrijvingsScheduledForDeletion !== null) {
                if (!$this->inschrijvingsScheduledForDeletion->isEmpty()) {
                    foreach ($this->inschrijvingsScheduledForDeletion as $inschrijving) {
                        // need to save related object because we set the relation to null
                        $inschrijving->save($con);
                    }
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

        $this->modifiedColumns[VoucherTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . VoucherTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(VoucherTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(VoucherTableMap::COL_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'code';
        }
        if ($this->isColumnModified(VoucherTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }
        if ($this->isColumnModified(VoucherTableMap::COL_EVENEMENT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'evenement_id';
        }
        if ($this->isColumnModified(VoucherTableMap::COL_OORSPRONGWAARDE)) {
            $modifiedColumns[':p' . $index++]  = 'oorsprongwaarde';
        }
        if ($this->isColumnModified(VoucherTableMap::COL_RESTWAARDE)) {
            $modifiedColumns[':p' . $index++]  = 'restwaarde';
        }
        if ($this->isColumnModified(VoucherTableMap::COL_VERBRUIKT)) {
            $modifiedColumns[':p' . $index++]  = 'verbruikt';
        }
        if ($this->isColumnModified(VoucherTableMap::COL_VOUCHERTYPE)) {
            $modifiedColumns[':p' . $index++]  = 'vouchertype';
        }
        if ($this->isColumnModified(VoucherTableMap::COL_ACTIEF)) {
            $modifiedColumns[':p' . $index++]  = 'actief';
        }
        if ($this->isColumnModified(VoucherTableMap::COL_GELDIG_TOT)) {
            $modifiedColumns[':p' . $index++]  = 'geldig_tot';
        }
        if ($this->isColumnModified(VoucherTableMap::COL_GEMAAKT_DATUM)) {
            $modifiedColumns[':p' . $index++]  = 'gemaakt_datum';
        }
        if ($this->isColumnModified(VoucherTableMap::COL_GEMAAKT_DOOR)) {
            $modifiedColumns[':p' . $index++]  = 'gemaakt_door';
        }
        if ($this->isColumnModified(VoucherTableMap::COL_GEWIJZIGD_DATUM)) {
            $modifiedColumns[':p' . $index++]  = 'gewijzigd_datum';
        }
        if ($this->isColumnModified(VoucherTableMap::COL_GEWIJZIGD_DOOR)) {
            $modifiedColumns[':p' . $index++]  = 'gewijzigd_door';
        }

        $sql = sprintf(
            'INSERT INTO fb_voucher (%s) VALUES (%s)',
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
                    case 'code':
                        $stmt->bindValue($identifier, $this->code, PDO::PARAM_STR);
                        break;
                    case 'email':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case 'evenement_id':
                        $stmt->bindValue($identifier, $this->evenement_id, PDO::PARAM_INT);
                        break;
                    case 'oorsprongwaarde':
                        $stmt->bindValue($identifier, $this->oorsprongwaarde, PDO::PARAM_STR);
                        break;
                    case 'restwaarde':
                        $stmt->bindValue($identifier, $this->restwaarde, PDO::PARAM_STR);
                        break;
                    case 'verbruikt':
                        $stmt->bindValue($identifier, $this->verbruikt, PDO::PARAM_STR);
                        break;
                    case 'vouchertype':
                        $stmt->bindValue($identifier, $this->vouchertype, PDO::PARAM_INT);
                        break;
                    case 'actief':
                        $stmt->bindValue($identifier, $this->actief, PDO::PARAM_INT);
                        break;
                    case 'geldig_tot':
                        $stmt->bindValue($identifier, $this->geldig_tot ? $this->geldig_tot->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
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
        $pos = VoucherTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getCode();
                break;
            case 2:
                return $this->getEmail();
                break;
            case 3:
                return $this->getEvenementId();
                break;
            case 4:
                return $this->getOorspronkelijkeWaarde();
                break;
            case 5:
                return $this->getRestWaarde();
                break;
            case 6:
                return $this->getVerbruikt();
                break;
            case 7:
                return $this->getVoucherType();
                break;
            case 8:
                return $this->getIsActief();
                break;
            case 9:
                return $this->getGeldigTot();
                break;
            case 10:
                return $this->getDatumGemaakt();
                break;
            case 11:
                return $this->getGemaaktDoor();
                break;
            case 12:
                return $this->getDatumGewijzigd();
                break;
            case 13:
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

        if (isset($alreadyDumpedObjects['Voucher'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Voucher'][$this->hashCode()] = true;
        $keys = VoucherTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getCode(),
            $keys[2] => $this->getEmail(),
            $keys[3] => $this->getEvenementId(),
            $keys[4] => $this->getOorspronkelijkeWaarde(),
            $keys[5] => $this->getRestWaarde(),
            $keys[6] => $this->getVerbruikt(),
            $keys[7] => $this->getVoucherType(),
            $keys[8] => $this->getIsActief(),
            $keys[9] => $this->getGeldigTot(),
            $keys[10] => $this->getDatumGemaakt(),
            $keys[11] => $this->getGemaaktDoor(),
            $keys[12] => $this->getDatumGewijzigd(),
            $keys[13] => $this->getGewijzigdDoor(),
        );
        if ($result[$keys[9]] instanceof \DateTimeInterface) {
            $result[$keys[9]] = $result[$keys[9]]->format('c');
        }

        if ($result[$keys[10]] instanceof \DateTimeInterface) {
            $result[$keys[10]] = $result[$keys[10]]->format('c');
        }

        if ($result[$keys[12]] instanceof \DateTimeInterface) {
            $result[$keys[12]] = $result[$keys[12]]->format('c');
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
     * @return $this|\fb_model\fb_model\Voucher
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = VoucherTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\fb_model\fb_model\Voucher
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setCode($value);
                break;
            case 2:
                $this->setEmail($value);
                break;
            case 3:
                $this->setEvenementId($value);
                break;
            case 4:
                $this->setOorspronkelijkeWaarde($value);
                break;
            case 5:
                $this->setRestWaarde($value);
                break;
            case 6:
                $this->setVerbruikt($value);
                break;
            case 7:
                $this->setVoucherType($value);
                break;
            case 8:
                $this->setIsActief($value);
                break;
            case 9:
                $this->setGeldigTot($value);
                break;
            case 10:
                $this->setDatumGemaakt($value);
                break;
            case 11:
                $this->setGemaaktDoor($value);
                break;
            case 12:
                $this->setDatumGewijzigd($value);
                break;
            case 13:
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
        $keys = VoucherTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setCode($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setEmail($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setEvenementId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setOorspronkelijkeWaarde($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setRestWaarde($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setVerbruikt($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setVoucherType($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setIsActief($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setGeldigTot($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setDatumGemaakt($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setGemaaktDoor($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setDatumGewijzigd($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setGewijzigdDoor($arr[$keys[13]]);
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
     * @return $this|\fb_model\fb_model\Voucher The current object, for fluid interface
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
        $criteria = new Criteria(VoucherTableMap::DATABASE_NAME);

        if ($this->isColumnModified(VoucherTableMap::COL_ID)) {
            $criteria->add(VoucherTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(VoucherTableMap::COL_CODE)) {
            $criteria->add(VoucherTableMap::COL_CODE, $this->code);
        }
        if ($this->isColumnModified(VoucherTableMap::COL_EMAIL)) {
            $criteria->add(VoucherTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(VoucherTableMap::COL_EVENEMENT_ID)) {
            $criteria->add(VoucherTableMap::COL_EVENEMENT_ID, $this->evenement_id);
        }
        if ($this->isColumnModified(VoucherTableMap::COL_OORSPRONGWAARDE)) {
            $criteria->add(VoucherTableMap::COL_OORSPRONGWAARDE, $this->oorsprongwaarde);
        }
        if ($this->isColumnModified(VoucherTableMap::COL_RESTWAARDE)) {
            $criteria->add(VoucherTableMap::COL_RESTWAARDE, $this->restwaarde);
        }
        if ($this->isColumnModified(VoucherTableMap::COL_VERBRUIKT)) {
            $criteria->add(VoucherTableMap::COL_VERBRUIKT, $this->verbruikt);
        }
        if ($this->isColumnModified(VoucherTableMap::COL_VOUCHERTYPE)) {
            $criteria->add(VoucherTableMap::COL_VOUCHERTYPE, $this->vouchertype);
        }
        if ($this->isColumnModified(VoucherTableMap::COL_ACTIEF)) {
            $criteria->add(VoucherTableMap::COL_ACTIEF, $this->actief);
        }
        if ($this->isColumnModified(VoucherTableMap::COL_GELDIG_TOT)) {
            $criteria->add(VoucherTableMap::COL_GELDIG_TOT, $this->geldig_tot);
        }
        if ($this->isColumnModified(VoucherTableMap::COL_GEMAAKT_DATUM)) {
            $criteria->add(VoucherTableMap::COL_GEMAAKT_DATUM, $this->gemaakt_datum);
        }
        if ($this->isColumnModified(VoucherTableMap::COL_GEMAAKT_DOOR)) {
            $criteria->add(VoucherTableMap::COL_GEMAAKT_DOOR, $this->gemaakt_door);
        }
        if ($this->isColumnModified(VoucherTableMap::COL_GEWIJZIGD_DATUM)) {
            $criteria->add(VoucherTableMap::COL_GEWIJZIGD_DATUM, $this->gewijzigd_datum);
        }
        if ($this->isColumnModified(VoucherTableMap::COL_GEWIJZIGD_DOOR)) {
            $criteria->add(VoucherTableMap::COL_GEWIJZIGD_DOOR, $this->gewijzigd_door);
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
        $criteria = ChildVoucherQuery::create();
        $criteria->add(VoucherTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \fb_model\fb_model\Voucher (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCode($this->getCode());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setEvenementId($this->getEvenementId());
        $copyObj->setOorspronkelijkeWaarde($this->getOorspronkelijkeWaarde());
        $copyObj->setRestWaarde($this->getRestWaarde());
        $copyObj->setVerbruikt($this->getVerbruikt());
        $copyObj->setVoucherType($this->getVoucherType());
        $copyObj->setIsActief($this->getIsActief());
        $copyObj->setGeldigTot($this->getGeldigTot());
        $copyObj->setDatumGemaakt($this->getDatumGemaakt());
        $copyObj->setGemaaktDoor($this->getGemaaktDoor());
        $copyObj->setDatumGewijzigd($this->getDatumGewijzigd());
        $copyObj->setGewijzigdDoor($this->getGewijzigdDoor());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

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
     * @return \fb_model\fb_model\Voucher Clone of current object.
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
     * @param  ChildEvenement|null $v
     * @return $this|\fb_model\fb_model\Voucher The current object (for fluent API support)
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
            $v->addVoucher($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildEvenement object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildEvenement|null The associated ChildEvenement object.
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
                $this->aEvenement->addVouchers($this);
             */
        }

        return $this->aEvenement;
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
        if ('Inschrijving' === $relationName) {
            $this->initInschrijvings();
            return;
        }
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
     * If this ChildVoucher is new, it will return
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
                    ->filterByVoucher($this)
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
     * @return $this|ChildVoucher The current object (for fluent API support)
     */
    public function setInschrijvings(Collection $inschrijvings, ConnectionInterface $con = null)
    {
        /** @var ChildInschrijving[] $inschrijvingsToDelete */
        $inschrijvingsToDelete = $this->getInschrijvings(new Criteria(), $con)->diff($inschrijvings);


        $this->inschrijvingsScheduledForDeletion = $inschrijvingsToDelete;

        foreach ($inschrijvingsToDelete as $inschrijvingRemoved) {
            $inschrijvingRemoved->setVoucher(null);
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
                ->filterByVoucher($this)
                ->count($con);
        }

        return count($this->collInschrijvings);
    }

    /**
     * Method called to associate a ChildInschrijving object to this object
     * through the ChildInschrijving foreign key attribute.
     *
     * @param  ChildInschrijving $l ChildInschrijving
     * @return $this|\fb_model\fb_model\Voucher The current object (for fluent API support)
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
        $inschrijving->setVoucher($this);
    }

    /**
     * @param  ChildInschrijving $inschrijving The ChildInschrijving object to remove.
     * @return $this|ChildVoucher The current object (for fluent API support)
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
            $this->inschrijvingsScheduledForDeletion[]= $inschrijving;
            $inschrijving->setVoucher(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Voucher is new, it will return
     * an empty collection; or if this Voucher has previously
     * been saved, it will retrieve related Inschrijvings from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Voucher.
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
     * Otherwise if this Voucher is new, it will return
     * an empty collection; or if this Voucher has previously
     * been saved, it will retrieve related Inschrijvings from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Voucher.
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
     * Otherwise if this Voucher is new, it will return
     * an empty collection; or if this Voucher has previously
     * been saved, it will retrieve related Inschrijvings from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Voucher.
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
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aEvenement) {
            $this->aEvenement->removeVoucher($this);
        }
        $this->id = null;
        $this->code = null;
        $this->email = null;
        $this->evenement_id = null;
        $this->oorsprongwaarde = null;
        $this->restwaarde = null;
        $this->verbruikt = null;
        $this->vouchertype = null;
        $this->actief = null;
        $this->geldig_tot = null;
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
            if ($this->collInschrijvings) {
                foreach ($this->collInschrijvings as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collInschrijvings = null;
        $this->aEvenement = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(VoucherTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildVoucher The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[VoucherTableMap::COL_GEWIJZIGD_DATUM] = true;

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
