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
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;
use fb_model\fb_model\Evenement as ChildEvenement;
use fb_model\fb_model\EvenementQuery as ChildEvenementQuery;
use fb_model\fb_model\Mailinglist as ChildMailinglist;
use fb_model\fb_model\MailinglistQuery as ChildMailinglistQuery;
use fb_model\fb_model\Map\MailinglistTableMap;

/**
 * Base class that represents a row from the 'fb_mailinglist' table.
 *
 *
 *
 * @package    propel.generator.fb_model.fb_model.Base
 */
abstract class Mailinglist implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\fb_model\\fb_model\\Map\\MailinglistTableMap';


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
     * The value for the naam field.
     *
     * @var        string
     */
    protected $naam;

    /**
     * The value for the email field.
     *
     * @var        string
     */
    protected $email;

    /**
     * The value for the code field.
     *
     * @var        string
     */
    protected $code;

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
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of fb_model\fb_model\Base\Mailinglist object.
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
     * Compares this with another <code>Mailinglist</code> instance.  If
     * <code>obj</code> is an instance of <code>Mailinglist</code>, delegates to
     * <code>equals(Mailinglist)</code>.  Otherwise, returns <code>false</code>.
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
     * Get the [evenement_id] column value.
     *
     * @return int
     */
    public function getEvenementId()
    {
        return $this->evenement_id;
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
     * Get the [email] column value.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
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
     * @return $this|\fb_model\fb_model\Mailinglist The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[MailinglistTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [evenement_id] column.
     *
     * @param int $v New value
     * @return $this|\fb_model\fb_model\Mailinglist The current object (for fluent API support)
     */
    public function setEvenementId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->evenement_id !== $v) {
            $this->evenement_id = $v;
            $this->modifiedColumns[MailinglistTableMap::COL_EVENEMENT_ID] = true;
        }

        if ($this->aEvenement !== null && $this->aEvenement->getId() !== $v) {
            $this->aEvenement = null;
        }

        return $this;
    } // setEvenementId()

    /**
     * Set the value of [naam] column.
     *
     * @param string $v New value
     * @return $this|\fb_model\fb_model\Mailinglist The current object (for fluent API support)
     */
    public function setNaam($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->naam !== $v) {
            $this->naam = $v;
            $this->modifiedColumns[MailinglistTableMap::COL_NAAM] = true;
        }

        return $this;
    } // setNaam()

    /**
     * Set the value of [email] column.
     *
     * @param string $v New value
     * @return $this|\fb_model\fb_model\Mailinglist The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[MailinglistTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Set the value of [code] column.
     *
     * @param string $v New value
     * @return $this|\fb_model\fb_model\Mailinglist The current object (for fluent API support)
     */
    public function setCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->code !== $v) {
            $this->code = $v;
            $this->modifiedColumns[MailinglistTableMap::COL_CODE] = true;
        }

        return $this;
    } // setCode()

    /**
     * Sets the value of [gemaakt_datum] column to a normalized version of the date/time value specified.
     *
     * @param  string|integer|\DateTimeInterface $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\fb_model\fb_model\Mailinglist The current object (for fluent API support)
     */
    public function setDatumGemaakt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->gemaakt_datum !== null || $dt !== null) {
            if ($this->gemaakt_datum === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->gemaakt_datum->format("Y-m-d H:i:s.u")) {
                $this->gemaakt_datum = $dt === null ? null : clone $dt;
                $this->modifiedColumns[MailinglistTableMap::COL_GEMAAKT_DATUM] = true;
            }
        } // if either are not null

        return $this;
    } // setDatumGemaakt()

    /**
     * Set the value of [gemaakt_door] column.
     *
     * @param string $v New value
     * @return $this|\fb_model\fb_model\Mailinglist The current object (for fluent API support)
     */
    public function setGemaaktDoor($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gemaakt_door !== $v) {
            $this->gemaakt_door = $v;
            $this->modifiedColumns[MailinglistTableMap::COL_GEMAAKT_DOOR] = true;
        }

        return $this;
    } // setGemaaktDoor()

    /**
     * Sets the value of [gewijzigd_datum] column to a normalized version of the date/time value specified.
     *
     * @param  string|integer|\DateTimeInterface $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\fb_model\fb_model\Mailinglist The current object (for fluent API support)
     */
    public function setDatumGewijzigd($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->gewijzigd_datum !== null || $dt !== null) {
            if ($this->gewijzigd_datum === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->gewijzigd_datum->format("Y-m-d H:i:s.u")) {
                $this->gewijzigd_datum = $dt === null ? null : clone $dt;
                $this->modifiedColumns[MailinglistTableMap::COL_GEWIJZIGD_DATUM] = true;
            }
        } // if either are not null

        return $this;
    } // setDatumGewijzigd()

    /**
     * Set the value of [gewijzigd_door] column.
     *
     * @param string $v New value
     * @return $this|\fb_model\fb_model\Mailinglist The current object (for fluent API support)
     */
    public function setGewijzigdDoor($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gewijzigd_door !== $v) {
            $this->gewijzigd_door = $v;
            $this->modifiedColumns[MailinglistTableMap::COL_GEWIJZIGD_DOOR] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : MailinglistTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : MailinglistTableMap::translateFieldName('EvenementId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->evenement_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : MailinglistTableMap::translateFieldName('Naam', TableMap::TYPE_PHPNAME, $indexType)];
            $this->naam = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : MailinglistTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : MailinglistTableMap::translateFieldName('Code', TableMap::TYPE_PHPNAME, $indexType)];
            $this->code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : MailinglistTableMap::translateFieldName('DatumGemaakt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->gemaakt_datum = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : MailinglistTableMap::translateFieldName('GemaaktDoor', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gemaakt_door = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : MailinglistTableMap::translateFieldName('DatumGewijzigd', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->gewijzigd_datum = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : MailinglistTableMap::translateFieldName('GewijzigdDoor', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gewijzigd_door = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = MailinglistTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\fb_model\\fb_model\\Mailinglist'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(MailinglistTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildMailinglistQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aEvenement = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Mailinglist::setDeleted()
     * @see Mailinglist::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(MailinglistTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildMailinglistQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(MailinglistTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                $time = time();
                $highPrecision = \Propel\Runtime\Util\PropelDateTime::createHighPrecision();
                if (!$this->isColumnModified(MailinglistTableMap::COL_GEMAAKT_DATUM)) {
                    $this->setDatumGemaakt($highPrecision);
                }
                if (!$this->isColumnModified(MailinglistTableMap::COL_GEWIJZIGD_DATUM)) {
                    $this->setDatumGewijzigd($highPrecision);
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(MailinglistTableMap::COL_GEWIJZIGD_DATUM)) {
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
                MailinglistTableMap::addInstanceToPool($this);
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

        $this->modifiedColumns[MailinglistTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . MailinglistTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(MailinglistTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(MailinglistTableMap::COL_EVENEMENT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'evenement_id';
        }
        if ($this->isColumnModified(MailinglistTableMap::COL_NAAM)) {
            $modifiedColumns[':p' . $index++]  = 'naam';
        }
        if ($this->isColumnModified(MailinglistTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }
        if ($this->isColumnModified(MailinglistTableMap::COL_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'code';
        }
        if ($this->isColumnModified(MailinglistTableMap::COL_GEMAAKT_DATUM)) {
            $modifiedColumns[':p' . $index++]  = 'gemaakt_datum';
        }
        if ($this->isColumnModified(MailinglistTableMap::COL_GEMAAKT_DOOR)) {
            $modifiedColumns[':p' . $index++]  = 'gemaakt_door';
        }
        if ($this->isColumnModified(MailinglistTableMap::COL_GEWIJZIGD_DATUM)) {
            $modifiedColumns[':p' . $index++]  = 'gewijzigd_datum';
        }
        if ($this->isColumnModified(MailinglistTableMap::COL_GEWIJZIGD_DOOR)) {
            $modifiedColumns[':p' . $index++]  = 'gewijzigd_door';
        }

        $sql = sprintf(
            'INSERT INTO fb_mailinglist (%s) VALUES (%s)',
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
                    case 'naam':
                        $stmt->bindValue($identifier, $this->naam, PDO::PARAM_STR);
                        break;
                    case 'email':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case 'code':
                        $stmt->bindValue($identifier, $this->code, PDO::PARAM_STR);
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
        $pos = MailinglistTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getNaam();
                break;
            case 3:
                return $this->getEmail();
                break;
            case 4:
                return $this->getCode();
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

        if (isset($alreadyDumpedObjects['Mailinglist'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Mailinglist'][$this->hashCode()] = true;
        $keys = MailinglistTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getEvenementId(),
            $keys[2] => $this->getNaam(),
            $keys[3] => $this->getEmail(),
            $keys[4] => $this->getCode(),
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
     * @return $this|\fb_model\fb_model\Mailinglist
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = MailinglistTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\fb_model\fb_model\Mailinglist
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
                $this->setNaam($value);
                break;
            case 3:
                $this->setEmail($value);
                break;
            case 4:
                $this->setCode($value);
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
        $keys = MailinglistTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setEvenementId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setNaam($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setEmail($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setCode($arr[$keys[4]]);
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
     * @return $this|\fb_model\fb_model\Mailinglist The current object, for fluid interface
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
        $criteria = new Criteria(MailinglistTableMap::DATABASE_NAME);

        if ($this->isColumnModified(MailinglistTableMap::COL_ID)) {
            $criteria->add(MailinglistTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(MailinglistTableMap::COL_EVENEMENT_ID)) {
            $criteria->add(MailinglistTableMap::COL_EVENEMENT_ID, $this->evenement_id);
        }
        if ($this->isColumnModified(MailinglistTableMap::COL_NAAM)) {
            $criteria->add(MailinglistTableMap::COL_NAAM, $this->naam);
        }
        if ($this->isColumnModified(MailinglistTableMap::COL_EMAIL)) {
            $criteria->add(MailinglistTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(MailinglistTableMap::COL_CODE)) {
            $criteria->add(MailinglistTableMap::COL_CODE, $this->code);
        }
        if ($this->isColumnModified(MailinglistTableMap::COL_GEMAAKT_DATUM)) {
            $criteria->add(MailinglistTableMap::COL_GEMAAKT_DATUM, $this->gemaakt_datum);
        }
        if ($this->isColumnModified(MailinglistTableMap::COL_GEMAAKT_DOOR)) {
            $criteria->add(MailinglistTableMap::COL_GEMAAKT_DOOR, $this->gemaakt_door);
        }
        if ($this->isColumnModified(MailinglistTableMap::COL_GEWIJZIGD_DATUM)) {
            $criteria->add(MailinglistTableMap::COL_GEWIJZIGD_DATUM, $this->gewijzigd_datum);
        }
        if ($this->isColumnModified(MailinglistTableMap::COL_GEWIJZIGD_DOOR)) {
            $criteria->add(MailinglistTableMap::COL_GEWIJZIGD_DOOR, $this->gewijzigd_door);
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
        $criteria = ChildMailinglistQuery::create();
        $criteria->add(MailinglistTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \fb_model\fb_model\Mailinglist (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setEvenementId($this->getEvenementId());
        $copyObj->setNaam($this->getNaam());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setCode($this->getCode());
        $copyObj->setDatumGemaakt($this->getDatumGemaakt());
        $copyObj->setGemaaktDoor($this->getGemaaktDoor());
        $copyObj->setDatumGewijzigd($this->getDatumGewijzigd());
        $copyObj->setGewijzigdDoor($this->getGewijzigdDoor());
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
     * @return \fb_model\fb_model\Mailinglist Clone of current object.
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
     * @return $this|\fb_model\fb_model\Mailinglist The current object (for fluent API support)
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
            $v->addMailinglist($this);
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
                $this->aEvenement->addMailinglists($this);
             */
        }

        return $this->aEvenement;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aEvenement) {
            $this->aEvenement->removeMailinglist($this);
        }
        $this->id = null;
        $this->evenement_id = null;
        $this->naam = null;
        $this->email = null;
        $this->code = null;
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
        } // if ($deep)

        $this->aEvenement = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(MailinglistTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildMailinglist The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[MailinglistTableMap::COL_GEWIJZIGD_DATUM] = true;

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
