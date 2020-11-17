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
use fb_model\fb_model\DeelnemerHeeftOptie as ChildDeelnemerHeeftOptie;
use fb_model\fb_model\DeelnemerHeeftOptieQuery as ChildDeelnemerHeeftOptieQuery;
use fb_model\fb_model\DeelnemerQuery as ChildDeelnemerQuery;
use fb_model\fb_model\Inschrijving as ChildInschrijving;
use fb_model\fb_model\InschrijvingQuery as ChildInschrijvingQuery;
use fb_model\fb_model\Optie as ChildOptie;
use fb_model\fb_model\OptieQuery as ChildOptieQuery;
use fb_model\fb_model\Persoon as ChildPersoon;
use fb_model\fb_model\PersoonQuery as ChildPersoonQuery;
use fb_model\fb_model\Map\DeelnemerHeeftOptieTableMap;
use fb_model\fb_model\Map\DeelnemerTableMap;

/**
 * Base class that represents a row from the 'fb_deelnemer' table.
 *
 *
 *
 * @package    propel.generator.fb_model.fb_model.Base
 */
abstract class Deelnemer implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\fb_model\\fb_model\\Map\\DeelnemerTableMap';


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
     * The value for the inschrijving_id field.
     *
     * @var        int
     */
    protected $inschrijving_id;

    /**
     * The value for the persoon_id field.
     *
     * @var        int
     */
    protected $persoon_id;

    /**
     * The value for the totaalbedrag field.
     *
     * @var        string
     */
    protected $totaalbedrag;

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
     * @var        ChildInschrijving
     */
    protected $aInschrijving;

    /**
     * @var        ChildPersoon
     */
    protected $aPersoon;

    /**
     * @var        ObjectCollection|ChildDeelnemerHeeftOptie[] Collection to store aggregation of ChildDeelnemerHeeftOptie objects.
     */
    protected $collDeelnemerHeeftOpties;
    protected $collDeelnemerHeeftOptiesPartial;

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
     * @var ObjectCollection|ChildDeelnemerHeeftOptie[]
     */
    protected $deelnemerHeeftOptiesScheduledForDeletion = null;

    /**
     * Initializes internal state of fb_model\fb_model\Base\Deelnemer object.
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
     * Compares this with another <code>Deelnemer</code> instance.  If
     * <code>obj</code> is an instance of <code>Deelnemer</code>, delegates to
     * <code>equals(Deelnemer)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Deelnemer The current object, for fluid interface
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
     * Get the [inschrijving_id] column value.
     *
     * @return int
     */
    public function getInschrijvingId()
    {
        return $this->inschrijving_id;
    }

    /**
     * Get the [persoon_id] column value.
     *
     * @return int
     */
    public function getPersoonId()
    {
        return $this->persoon_id;
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
     * @return $this|\fb_model\fb_model\Deelnemer The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[DeelnemerTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [inschrijving_id] column.
     *
     * @param int $v new value
     * @return $this|\fb_model\fb_model\Deelnemer The current object (for fluent API support)
     */
    public function setInschrijvingId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->inschrijving_id !== $v) {
            $this->inschrijving_id = $v;
            $this->modifiedColumns[DeelnemerTableMap::COL_INSCHRIJVING_ID] = true;
        }

        if ($this->aInschrijving !== null && $this->aInschrijving->getId() !== $v) {
            $this->aInschrijving = null;
        }

        return $this;
    } // setInschrijvingId()

    /**
     * Set the value of [persoon_id] column.
     *
     * @param int $v new value
     * @return $this|\fb_model\fb_model\Deelnemer The current object (for fluent API support)
     */
    public function setPersoonId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->persoon_id !== $v) {
            $this->persoon_id = $v;
            $this->modifiedColumns[DeelnemerTableMap::COL_PERSOON_ID] = true;
        }

        if ($this->aPersoon !== null && $this->aPersoon->getId() !== $v) {
            $this->aPersoon = null;
        }

        return $this;
    } // setPersoonId()

    /**
     * Set the value of [totaalbedrag] column.
     *
     * @param string $v new value
     * @return $this|\fb_model\fb_model\Deelnemer The current object (for fluent API support)
     */
    public function setTotaalbedrag($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->totaalbedrag !== $v) {
            $this->totaalbedrag = $v;
            $this->modifiedColumns[DeelnemerTableMap::COL_TOTAALBEDRAG] = true;
        }

        return $this;
    } // setTotaalbedrag()

    /**
     * Set the value of [status] column.
     *
     * @param int $v new value
     * @return $this|\fb_model\fb_model\Deelnemer The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[DeelnemerTableMap::COL_STATUS] = true;
        }

        return $this;
    } // setStatus()

    /**
     * Sets the value of [gemaakt_datum] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\fb_model\fb_model\Deelnemer The current object (for fluent API support)
     */
    public function setDatumGemaakt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->gemaakt_datum !== null || $dt !== null) {
            if ($this->gemaakt_datum === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->gemaakt_datum->format("Y-m-d H:i:s.u")) {
                $this->gemaakt_datum = $dt === null ? null : clone $dt;
                $this->modifiedColumns[DeelnemerTableMap::COL_GEMAAKT_DATUM] = true;
            }
        } // if either are not null

        return $this;
    } // setDatumGemaakt()

    /**
     * Set the value of [gemaakt_door] column.
     *
     * @param string $v new value
     * @return $this|\fb_model\fb_model\Deelnemer The current object (for fluent API support)
     */
    public function setGemaaktDoor($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gemaakt_door !== $v) {
            $this->gemaakt_door = $v;
            $this->modifiedColumns[DeelnemerTableMap::COL_GEMAAKT_DOOR] = true;
        }

        return $this;
    } // setGemaaktDoor()

    /**
     * Sets the value of [gewijzigd_datum] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\fb_model\fb_model\Deelnemer The current object (for fluent API support)
     */
    public function setDatumGewijzigd($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->gewijzigd_datum !== null || $dt !== null) {
            if ($this->gewijzigd_datum === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->gewijzigd_datum->format("Y-m-d H:i:s.u")) {
                $this->gewijzigd_datum = $dt === null ? null : clone $dt;
                $this->modifiedColumns[DeelnemerTableMap::COL_GEWIJZIGD_DATUM] = true;
            }
        } // if either are not null

        return $this;
    } // setDatumGewijzigd()

    /**
     * Set the value of [gewijzigd_door] column.
     *
     * @param string $v new value
     * @return $this|\fb_model\fb_model\Deelnemer The current object (for fluent API support)
     */
    public function setGewijzigdDoor($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gewijzigd_door !== $v) {
            $this->gewijzigd_door = $v;
            $this->modifiedColumns[DeelnemerTableMap::COL_GEWIJZIGD_DOOR] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : DeelnemerTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : DeelnemerTableMap::translateFieldName('InschrijvingId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->inschrijving_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : DeelnemerTableMap::translateFieldName('PersoonId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->persoon_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : DeelnemerTableMap::translateFieldName('Totaalbedrag', TableMap::TYPE_PHPNAME, $indexType)];
            $this->totaalbedrag = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : DeelnemerTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : DeelnemerTableMap::translateFieldName('DatumGemaakt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->gemaakt_datum = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : DeelnemerTableMap::translateFieldName('GemaaktDoor', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gemaakt_door = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : DeelnemerTableMap::translateFieldName('DatumGewijzigd', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->gewijzigd_datum = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : DeelnemerTableMap::translateFieldName('GewijzigdDoor', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gewijzigd_door = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = DeelnemerTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\fb_model\\fb_model\\Deelnemer'), 0, $e);
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
        if ($this->aInschrijving !== null && $this->inschrijving_id !== $this->aInschrijving->getId()) {
            $this->aInschrijving = null;
        }
        if ($this->aPersoon !== null && $this->persoon_id !== $this->aPersoon->getId()) {
            $this->aPersoon = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(DeelnemerTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildDeelnemerQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aInschrijving = null;
            $this->aPersoon = null;
            $this->collDeelnemerHeeftOpties = null;

            $this->collOptieIds = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Deelnemer::setDeleted()
     * @see Deelnemer::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(DeelnemerTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildDeelnemerQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(DeelnemerTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                $time = time();
                $highPrecision = \Propel\Runtime\Util\PropelDateTime::createHighPrecision();
                if (!$this->isColumnModified(DeelnemerTableMap::COL_GEMAAKT_DATUM)) {
                    $this->setDatumGemaakt($highPrecision);
                }
                if (!$this->isColumnModified(DeelnemerTableMap::COL_GEWIJZIGD_DATUM)) {
                    $this->setDatumGewijzigd($highPrecision);
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(DeelnemerTableMap::COL_GEWIJZIGD_DATUM)) {
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
                DeelnemerTableMap::addInstanceToPool($this);
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

            if ($this->aInschrijving !== null) {
                if ($this->aInschrijving->isModified() || $this->aInschrijving->isNew()) {
                    $affectedRows += $this->aInschrijving->save($con);
                }
                $this->setInschrijving($this->aInschrijving);
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

                    \fb_model\fb_model\DeelnemerHeeftOptieQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->combinationCollOptieIdsScheduledForDeletion = null;
                }

            }

            if (null !== $this->combinationCollOptieIds) {
                foreach ($this->combinationCollOptieIds as $combination) {

                    //$combination[0] = Optie (fb_deelnemer_heeft_optie_fk_c81db2)
                    if (!$combination[0]->isDeleted() && ($combination[0]->isNew() || $combination[0]->isModified())) {
                        $combination[0]->save($con);
                    }

                    //$combination[1] = Id; Nothing to save.
                }
            }


            if ($this->deelnemerHeeftOptiesScheduledForDeletion !== null) {
                if (!$this->deelnemerHeeftOptiesScheduledForDeletion->isEmpty()) {
                    \fb_model\fb_model\DeelnemerHeeftOptieQuery::create()
                        ->filterByPrimaryKeys($this->deelnemerHeeftOptiesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->deelnemerHeeftOptiesScheduledForDeletion = null;
                }
            }

            if ($this->collDeelnemerHeeftOpties !== null) {
                foreach ($this->collDeelnemerHeeftOpties as $referrerFK) {
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

        $this->modifiedColumns[DeelnemerTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . DeelnemerTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(DeelnemerTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(DeelnemerTableMap::COL_INSCHRIJVING_ID)) {
            $modifiedColumns[':p' . $index++]  = 'inschrijving_id';
        }
        if ($this->isColumnModified(DeelnemerTableMap::COL_PERSOON_ID)) {
            $modifiedColumns[':p' . $index++]  = 'persoon_id';
        }
        if ($this->isColumnModified(DeelnemerTableMap::COL_TOTAALBEDRAG)) {
            $modifiedColumns[':p' . $index++]  = 'totaalbedrag';
        }
        if ($this->isColumnModified(DeelnemerTableMap::COL_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'status';
        }
        if ($this->isColumnModified(DeelnemerTableMap::COL_GEMAAKT_DATUM)) {
            $modifiedColumns[':p' . $index++]  = 'gemaakt_datum';
        }
        if ($this->isColumnModified(DeelnemerTableMap::COL_GEMAAKT_DOOR)) {
            $modifiedColumns[':p' . $index++]  = 'gemaakt_door';
        }
        if ($this->isColumnModified(DeelnemerTableMap::COL_GEWIJZIGD_DATUM)) {
            $modifiedColumns[':p' . $index++]  = 'gewijzigd_datum';
        }
        if ($this->isColumnModified(DeelnemerTableMap::COL_GEWIJZIGD_DOOR)) {
            $modifiedColumns[':p' . $index++]  = 'gewijzigd_door';
        }

        $sql = sprintf(
            'INSERT INTO fb_deelnemer (%s) VALUES (%s)',
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
                    case 'inschrijving_id':
                        $stmt->bindValue($identifier, $this->inschrijving_id, PDO::PARAM_INT);
                        break;
                    case 'persoon_id':
                        $stmt->bindValue($identifier, $this->persoon_id, PDO::PARAM_INT);
                        break;
                    case 'totaalbedrag':
                        $stmt->bindValue($identifier, $this->totaalbedrag, PDO::PARAM_STR);
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
        $pos = DeelnemerTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getInschrijvingId();
                break;
            case 2:
                return $this->getPersoonId();
                break;
            case 3:
                return $this->getTotaalbedrag();
                break;
            case 4:
                return $this->getStatus();
                break;
            case 5:
                return $this->getDatumGemaakt();
                break;
            case 6:
                return $this->getGemaaktDoor();
                break;
            case 7:
                return $this->getDatumGewijzigd();
                break;
            case 8:
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

        if (isset($alreadyDumpedObjects['Deelnemer'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Deelnemer'][$this->hashCode()] = true;
        $keys = DeelnemerTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getInschrijvingId(),
            $keys[2] => $this->getPersoonId(),
            $keys[3] => $this->getTotaalbedrag(),
            $keys[4] => $this->getStatus(),
            $keys[5] => $this->getDatumGemaakt(),
            $keys[6] => $this->getGemaaktDoor(),
            $keys[7] => $this->getDatumGewijzigd(),
            $keys[8] => $this->getGewijzigdDoor(),
        );
        if ($result[$keys[5]] instanceof \DateTimeInterface) {
            $result[$keys[5]] = $result[$keys[5]]->format('c');
        }

        if ($result[$keys[7]] instanceof \DateTimeInterface) {
            $result[$keys[7]] = $result[$keys[7]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aInschrijving) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'inschrijving';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fb_inschrijving';
                        break;
                    default:
                        $key = 'Inschrijving';
                }

                $result[$key] = $this->aInschrijving->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
            if (null !== $this->collDeelnemerHeeftOpties) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'deelnemerHeeftOpties';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fb_deelnemer_heeft_opties';
                        break;
                    default:
                        $key = 'DeelnemerHeeftOpties';
                }

                $result[$key] = $this->collDeelnemerHeeftOpties->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\fb_model\fb_model\Deelnemer
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = DeelnemerTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\fb_model\fb_model\Deelnemer
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setInschrijvingId($value);
                break;
            case 2:
                $this->setPersoonId($value);
                break;
            case 3:
                $this->setTotaalbedrag($value);
                break;
            case 4:
                $this->setStatus($value);
                break;
            case 5:
                $this->setDatumGemaakt($value);
                break;
            case 6:
                $this->setGemaaktDoor($value);
                break;
            case 7:
                $this->setDatumGewijzigd($value);
                break;
            case 8:
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
        $keys = DeelnemerTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setInschrijvingId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setPersoonId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setTotaalbedrag($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setStatus($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setDatumGemaakt($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setGemaaktDoor($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setDatumGewijzigd($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setGewijzigdDoor($arr[$keys[8]]);
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
     * @return $this|\fb_model\fb_model\Deelnemer The current object, for fluid interface
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
        $criteria = new Criteria(DeelnemerTableMap::DATABASE_NAME);

        if ($this->isColumnModified(DeelnemerTableMap::COL_ID)) {
            $criteria->add(DeelnemerTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(DeelnemerTableMap::COL_INSCHRIJVING_ID)) {
            $criteria->add(DeelnemerTableMap::COL_INSCHRIJVING_ID, $this->inschrijving_id);
        }
        if ($this->isColumnModified(DeelnemerTableMap::COL_PERSOON_ID)) {
            $criteria->add(DeelnemerTableMap::COL_PERSOON_ID, $this->persoon_id);
        }
        if ($this->isColumnModified(DeelnemerTableMap::COL_TOTAALBEDRAG)) {
            $criteria->add(DeelnemerTableMap::COL_TOTAALBEDRAG, $this->totaalbedrag);
        }
        if ($this->isColumnModified(DeelnemerTableMap::COL_STATUS)) {
            $criteria->add(DeelnemerTableMap::COL_STATUS, $this->status);
        }
        if ($this->isColumnModified(DeelnemerTableMap::COL_GEMAAKT_DATUM)) {
            $criteria->add(DeelnemerTableMap::COL_GEMAAKT_DATUM, $this->gemaakt_datum);
        }
        if ($this->isColumnModified(DeelnemerTableMap::COL_GEMAAKT_DOOR)) {
            $criteria->add(DeelnemerTableMap::COL_GEMAAKT_DOOR, $this->gemaakt_door);
        }
        if ($this->isColumnModified(DeelnemerTableMap::COL_GEWIJZIGD_DATUM)) {
            $criteria->add(DeelnemerTableMap::COL_GEWIJZIGD_DATUM, $this->gewijzigd_datum);
        }
        if ($this->isColumnModified(DeelnemerTableMap::COL_GEWIJZIGD_DOOR)) {
            $criteria->add(DeelnemerTableMap::COL_GEWIJZIGD_DOOR, $this->gewijzigd_door);
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
        $criteria = ChildDeelnemerQuery::create();
        $criteria->add(DeelnemerTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \fb_model\fb_model\Deelnemer (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setInschrijvingId($this->getInschrijvingId());
        $copyObj->setPersoonId($this->getPersoonId());
        $copyObj->setTotaalbedrag($this->getTotaalbedrag());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setDatumGemaakt($this->getDatumGemaakt());
        $copyObj->setGemaaktDoor($this->getGemaaktDoor());
        $copyObj->setDatumGewijzigd($this->getDatumGewijzigd());
        $copyObj->setGewijzigdDoor($this->getGewijzigdDoor());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getDeelnemerHeeftOpties() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDeelnemerHeeftOptie($relObj->copy($deepCopy));
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
     * @return \fb_model\fb_model\Deelnemer Clone of current object.
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
     * Declares an association between this object and a ChildInschrijving object.
     *
     * @param  ChildInschrijving $v
     * @return $this|\fb_model\fb_model\Deelnemer The current object (for fluent API support)
     * @throws PropelException
     */
    public function setInschrijving(ChildInschrijving $v = null)
    {
        if ($v === null) {
            $this->setInschrijvingId(NULL);
        } else {
            $this->setInschrijvingId($v->getId());
        }

        $this->aInschrijving = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildInschrijving object, it will not be re-added.
        if ($v !== null) {
            $v->addDeelnemer($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildInschrijving object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildInschrijving The associated ChildInschrijving object.
     * @throws PropelException
     */
    public function getInschrijving(ConnectionInterface $con = null)
    {
        if ($this->aInschrijving === null && ($this->inschrijving_id != 0)) {
            $this->aInschrijving = ChildInschrijvingQuery::create()->findPk($this->inschrijving_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aInschrijving->addDeelnemers($this);
             */
        }

        return $this->aInschrijving;
    }

    /**
     * Declares an association between this object and a ChildPersoon object.
     *
     * @param  ChildPersoon $v
     * @return $this|\fb_model\fb_model\Deelnemer The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPersoon(ChildPersoon $v = null)
    {
        if ($v === null) {
            $this->setPersoonId(NULL);
        } else {
            $this->setPersoonId($v->getId());
        }

        $this->aPersoon = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPersoon object, it will not be re-added.
        if ($v !== null) {
            $v->addDeelnemer($this);
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
        if ($this->aPersoon === null && ($this->persoon_id != 0)) {
            $this->aPersoon = ChildPersoonQuery::create()->findPk($this->persoon_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPersoon->addDeelnemers($this);
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
        if ('DeelnemerHeeftOptie' == $relationName) {
            $this->initDeelnemerHeeftOpties();
            return;
        }
    }

    /**
     * Clears out the collDeelnemerHeeftOpties collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDeelnemerHeeftOpties()
     */
    public function clearDeelnemerHeeftOpties()
    {
        $this->collDeelnemerHeeftOpties = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDeelnemerHeeftOpties collection loaded partially.
     */
    public function resetPartialDeelnemerHeeftOpties($v = true)
    {
        $this->collDeelnemerHeeftOptiesPartial = $v;
    }

    /**
     * Initializes the collDeelnemerHeeftOpties collection.
     *
     * By default this just sets the collDeelnemerHeeftOpties collection to an empty array (like clearcollDeelnemerHeeftOpties());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDeelnemerHeeftOpties($overrideExisting = true)
    {
        if (null !== $this->collDeelnemerHeeftOpties && !$overrideExisting) {
            return;
        }

        $collectionClassName = DeelnemerHeeftOptieTableMap::getTableMap()->getCollectionClassName();

        $this->collDeelnemerHeeftOpties = new $collectionClassName;
        $this->collDeelnemerHeeftOpties->setModel('\fb_model\fb_model\DeelnemerHeeftOptie');
    }

    /**
     * Gets an array of ChildDeelnemerHeeftOptie objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildDeelnemer is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDeelnemerHeeftOptie[] List of ChildDeelnemerHeeftOptie objects
     * @throws PropelException
     */
    public function getDeelnemerHeeftOpties(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDeelnemerHeeftOptiesPartial && !$this->isNew();
        if (null === $this->collDeelnemerHeeftOpties || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDeelnemerHeeftOpties) {
                // return empty collection
                $this->initDeelnemerHeeftOpties();
            } else {
                $collDeelnemerHeeftOpties = ChildDeelnemerHeeftOptieQuery::create(null, $criteria)
                    ->filterByDeelnemer($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDeelnemerHeeftOptiesPartial && count($collDeelnemerHeeftOpties)) {
                        $this->initDeelnemerHeeftOpties(false);

                        foreach ($collDeelnemerHeeftOpties as $obj) {
                            if (false == $this->collDeelnemerHeeftOpties->contains($obj)) {
                                $this->collDeelnemerHeeftOpties->append($obj);
                            }
                        }

                        $this->collDeelnemerHeeftOptiesPartial = true;
                    }

                    return $collDeelnemerHeeftOpties;
                }

                if ($partial && $this->collDeelnemerHeeftOpties) {
                    foreach ($this->collDeelnemerHeeftOpties as $obj) {
                        if ($obj->isNew()) {
                            $collDeelnemerHeeftOpties[] = $obj;
                        }
                    }
                }

                $this->collDeelnemerHeeftOpties = $collDeelnemerHeeftOpties;
                $this->collDeelnemerHeeftOptiesPartial = false;
            }
        }

        return $this->collDeelnemerHeeftOpties;
    }

    /**
     * Sets a collection of ChildDeelnemerHeeftOptie objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $deelnemerHeeftOpties A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildDeelnemer The current object (for fluent API support)
     */
    public function setDeelnemerHeeftOpties(Collection $deelnemerHeeftOpties, ConnectionInterface $con = null)
    {
        /** @var ChildDeelnemerHeeftOptie[] $deelnemerHeeftOptiesToDelete */
        $deelnemerHeeftOptiesToDelete = $this->getDeelnemerHeeftOpties(new Criteria(), $con)->diff($deelnemerHeeftOpties);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->deelnemerHeeftOptiesScheduledForDeletion = clone $deelnemerHeeftOptiesToDelete;

        foreach ($deelnemerHeeftOptiesToDelete as $deelnemerHeeftOptieRemoved) {
            $deelnemerHeeftOptieRemoved->setDeelnemer(null);
        }

        $this->collDeelnemerHeeftOpties = null;
        foreach ($deelnemerHeeftOpties as $deelnemerHeeftOptie) {
            $this->addDeelnemerHeeftOptie($deelnemerHeeftOptie);
        }

        $this->collDeelnemerHeeftOpties = $deelnemerHeeftOpties;
        $this->collDeelnemerHeeftOptiesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related DeelnemerHeeftOptie objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related DeelnemerHeeftOptie objects.
     * @throws PropelException
     */
    public function countDeelnemerHeeftOpties(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDeelnemerHeeftOptiesPartial && !$this->isNew();
        if (null === $this->collDeelnemerHeeftOpties || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDeelnemerHeeftOpties) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDeelnemerHeeftOpties());
            }

            $query = ChildDeelnemerHeeftOptieQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDeelnemer($this)
                ->count($con);
        }

        return count($this->collDeelnemerHeeftOpties);
    }

    /**
     * Method called to associate a ChildDeelnemerHeeftOptie object to this object
     * through the ChildDeelnemerHeeftOptie foreign key attribute.
     *
     * @param  ChildDeelnemerHeeftOptie $l ChildDeelnemerHeeftOptie
     * @return $this|\fb_model\fb_model\Deelnemer The current object (for fluent API support)
     */
    public function addDeelnemerHeeftOptie(ChildDeelnemerHeeftOptie $l)
    {
        if ($this->collDeelnemerHeeftOpties === null) {
            $this->initDeelnemerHeeftOpties();
            $this->collDeelnemerHeeftOptiesPartial = true;
        }

        if (!$this->collDeelnemerHeeftOpties->contains($l)) {
            $this->doAddDeelnemerHeeftOptie($l);

            if ($this->deelnemerHeeftOptiesScheduledForDeletion and $this->deelnemerHeeftOptiesScheduledForDeletion->contains($l)) {
                $this->deelnemerHeeftOptiesScheduledForDeletion->remove($this->deelnemerHeeftOptiesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildDeelnemerHeeftOptie $deelnemerHeeftOptie The ChildDeelnemerHeeftOptie object to add.
     */
    protected function doAddDeelnemerHeeftOptie(ChildDeelnemerHeeftOptie $deelnemerHeeftOptie)
    {
        $this->collDeelnemerHeeftOpties[]= $deelnemerHeeftOptie;
        $deelnemerHeeftOptie->setDeelnemer($this);
    }

    /**
     * @param  ChildDeelnemerHeeftOptie $deelnemerHeeftOptie The ChildDeelnemerHeeftOptie object to remove.
     * @return $this|ChildDeelnemer The current object (for fluent API support)
     */
    public function removeDeelnemerHeeftOptie(ChildDeelnemerHeeftOptie $deelnemerHeeftOptie)
    {
        if ($this->getDeelnemerHeeftOpties()->contains($deelnemerHeeftOptie)) {
            $pos = $this->collDeelnemerHeeftOpties->search($deelnemerHeeftOptie);
            $this->collDeelnemerHeeftOpties->remove($pos);
            if (null === $this->deelnemerHeeftOptiesScheduledForDeletion) {
                $this->deelnemerHeeftOptiesScheduledForDeletion = clone $this->collDeelnemerHeeftOpties;
                $this->deelnemerHeeftOptiesScheduledForDeletion->clear();
            }
            $this->deelnemerHeeftOptiesScheduledForDeletion[]= clone $deelnemerHeeftOptie;
            $deelnemerHeeftOptie->setDeelnemer(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Deelnemer is new, it will return
     * an empty collection; or if this Deelnemer has previously
     * been saved, it will retrieve related DeelnemerHeeftOpties from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Deelnemer.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildDeelnemerHeeftOptie[] List of ChildDeelnemerHeeftOptie objects
     */
    public function getDeelnemerHeeftOptiesJoinOptie(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDeelnemerHeeftOptieQuery::create(null, $criteria);
        $query->joinWith('Optie', $joinBehavior);

        return $this->getDeelnemerHeeftOpties($query, $con);
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
            ->filterByDeelnemer($this);

        $deelnemerHeeftOptieQuery = $criteria->useDeelnemerHeeftOptieQuery();

        if (null !== $id) {
            $deelnemerHeeftOptieQuery->filterById($id);
        }

        $deelnemerHeeftOptieQuery->endUse();

        return $criteria;
    }

    /**
     * Gets a combined collection of ChildOptie objects related by a many-to-many relationship
     * to the current object by way of the fb_deelnemer_heeft_optie cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildDeelnemer is new, it will return
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

                $query = ChildDeelnemerHeeftOptieQuery::create(null, $criteria)
                    ->filterByDeelnemer($this)
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
     * to the current object by way of the fb_deelnemer_heeft_optie cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $optieIds A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildDeelnemer The current object (for fluent API support)
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
     * to the current object by way of the fb_deelnemer_heeft_optie cross-reference table.
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

                $query = ChildDeelnemerHeeftOptieQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByDeelnemer($this)
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
     * through the fb_deelnemer_heeft_optie cross reference table.
     *
     * @param ChildOptie $optie,
     * @param int $id
     * @return ChildDeelnemer The current object (for fluent API support)
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
        $deelnemerHeeftOptie = new ChildDeelnemerHeeftOptie();

        $deelnemerHeeftOptie->setOptie($optie);
        $deelnemerHeeftOptie->setId($id);


        $deelnemerHeeftOptie->setDeelnemer($this);

        $this->addDeelnemerHeeftOptie($deelnemerHeeftOptie);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if ($optie->isDeelnemerIdsLoaded()) {
            $optie->initDeelnemerIds();
            $optie->getDeelnemerIds()->push($this, $id);
        } elseif (!$optie->getDeelnemerIds()->contains($this, $id)) {
            $optie->getDeelnemerIds()->push($this, $id);
        }

    }

    /**
     * Remove optie, id of this object
     * through the fb_deelnemer_heeft_optie cross reference table.
     *
     * @param ChildOptie $optie,
     * @param int $id
     * @return ChildDeelnemer The current object (for fluent API support)
     */
    public function removeOptieId(ChildOptie $optie, $id)
    {
        if ($this->getOptieIds()->contains($optie, $id)) {
            $deelnemerHeeftOptie = new ChildDeelnemerHeeftOptie();
            $deelnemerHeeftOptie->setOptie($optie);
            if ($optie->isDeelnemerIdsLoaded()) {
                //remove the back reference if available
                $optie->getDeelnemerIds()->removeObject($this, $id);
            }

            $deelnemerHeeftOptie->setId($id);
            $deelnemerHeeftOptie->setDeelnemer($this);
            $this->removeDeelnemerHeeftOptie(clone $deelnemerHeeftOptie);
            $deelnemerHeeftOptie->clear();

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
        if (null !== $this->aInschrijving) {
            $this->aInschrijving->removeDeelnemer($this);
        }
        if (null !== $this->aPersoon) {
            $this->aPersoon->removeDeelnemer($this);
        }
        $this->id = null;
        $this->inschrijving_id = null;
        $this->persoon_id = null;
        $this->totaalbedrag = null;
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
            if ($this->collDeelnemerHeeftOpties) {
                foreach ($this->collDeelnemerHeeftOpties as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->combinationCollOptieIds) {
                foreach ($this->combinationCollOptieIds as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collDeelnemerHeeftOpties = null;
        $this->combinationCollOptieIds = null;
        $this->aInschrijving = null;
        $this->aPersoon = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(DeelnemerTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildDeelnemer The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[DeelnemerTableMap::COL_GEWIJZIGD_DATUM] = true;

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
