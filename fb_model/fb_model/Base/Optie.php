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
use fb_model\fb_model\Evenement as ChildEvenement;
use fb_model\fb_model\EvenementHeeftOptie as ChildEvenementHeeftOptie;
use fb_model\fb_model\EvenementHeeftOptieQuery as ChildEvenementHeeftOptieQuery;
use fb_model\fb_model\EvenementQuery as ChildEvenementQuery;
use fb_model\fb_model\Inschrijving as ChildInschrijving;
use fb_model\fb_model\InschrijvingHeeftOptie as ChildInschrijvingHeeftOptie;
use fb_model\fb_model\InschrijvingHeeftOptieQuery as ChildInschrijvingHeeftOptieQuery;
use fb_model\fb_model\InschrijvingQuery as ChildInschrijvingQuery;
use fb_model\fb_model\Optie as ChildOptie;
use fb_model\fb_model\OptieQuery as ChildOptieQuery;
use fb_model\fb_model\Type as ChildType;
use fb_model\fb_model\TypeQuery as ChildTypeQuery;
use fb_model\fb_model\Map\DeelnemerHeeftOptieTableMap;
use fb_model\fb_model\Map\EvenementHeeftOptieTableMap;
use fb_model\fb_model\Map\InschrijvingHeeftOptieTableMap;
use fb_model\fb_model\Map\OptieTableMap;

/**
 * Base class that represents a row from the 'fb_optie' table.
 *
 *
 *
 * @package    propel.generator.fb_model.fb_model.Base
 */
abstract class Optie implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\fb_model\\fb_model\\Map\\OptieTableMap';


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
     * The value for the per_deelnemer field.
     *
     * @var        int|null
     */
    protected $per_deelnemer;

    /**
     * The value for the naam field.
     *
     * @var        string
     */
    protected $naam;

    /**
     * The value for the tekst_voor field.
     *
     * @var        string|null
     */
    protected $tekst_voor;

    /**
     * The value for the tekst_achter field.
     *
     * @var        string|null
     */
    protected $tekst_achter;

    /**
     * The value for the tooltip_tekst field.
     *
     * @var        string|null
     */
    protected $tooltip_tekst;

    /**
     * The value for the heeft_hor_lijn field.
     *
     * @var        int
     */
    protected $heeft_hor_lijn;

    /**
     * The value for the optietype field.
     *
     * @var        int|null
     */
    protected $optietype;

    /**
     * The value for the groep field.
     *
     * @var        string|null
     */
    protected $groep;

    /**
     * The value for the label field.
     *
     * @var        string|null
     */
    protected $label;

    /**
     * The value for the is_default field.
     *
     * @var        int|null
     */
    protected $is_default;

    /**
     * The value for the later_wijzigen field.
     *
     * Note: this column has a database default value of: 1
     * @var        int|null
     */
    protected $later_wijzigen;

    /**
     * The value for the totaal_aantal field.
     *
     * @var        int|null
     */
    protected $totaal_aantal;

    /**
     * The value for the prijs field.
     *
     * @var        string|null
     */
    protected $prijs;

    /**
     * The value for the status field.
     *
     * @var        int
     */
    protected $status;

    /**
     * The value for the intern_gebruik field.
     *
     * @var        int|null
     */
    protected $intern_gebruik;

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
     * @var        ChildType
     */
    protected $aType;

    /**
     * @var        ObjectCollection|ChildDeelnemerHeeftOptie[] Collection to store aggregation of ChildDeelnemerHeeftOptie objects.
     */
    protected $collDeelnemerHeeftOpties;
    protected $collDeelnemerHeeftOptiesPartial;

    /**
     * @var        ObjectCollection|ChildEvenementHeeftOptie[] Collection to store aggregation of ChildEvenementHeeftOptie objects.
     */
    protected $collEvenementHeeftOpties;
    protected $collEvenementHeeftOptiesPartial;

    /**
     * @var        ObjectCollection|ChildInschrijvingHeeftOptie[] Collection to store aggregation of ChildInschrijvingHeeftOptie objects.
     */
    protected $collInschrijvingHeeftOpties;
    protected $collInschrijvingHeeftOptiesPartial;

    /**
     * @var ObjectCombinationCollection Cross CombinationCollection to store aggregation of ChildDeelnemer combinations.
     */
    protected $combinationCollDeelnemerIds;

    /**
     * @var bool
     */
    protected $combinationCollDeelnemerIdsPartial;

    /**
     * @var        ObjectCollection|ChildDeelnemer[] Cross Collection to store aggregation of ChildDeelnemer objects.
     */
    protected $collDeelnemers;

    /**
     * @var bool
     */
    protected $collDeelnemersPartial;

    /**
     * @var ObjectCombinationCollection Cross CombinationCollection to store aggregation of ChildEvenement combinations.
     */
    protected $combinationCollEvenementIds;

    /**
     * @var bool
     */
    protected $combinationCollEvenementIdsPartial;

    /**
     * @var        ObjectCollection|ChildEvenement[] Cross Collection to store aggregation of ChildEvenement objects.
     */
    protected $collEvenements;

    /**
     * @var bool
     */
    protected $collEvenementsPartial;

    /**
     * @var ObjectCombinationCollection Cross CombinationCollection to store aggregation of ChildInschrijving combinations.
     */
    protected $combinationCollInschrijvingIds;

    /**
     * @var bool
     */
    protected $combinationCollInschrijvingIdsPartial;

    /**
     * @var        ObjectCollection|ChildInschrijving[] Cross Collection to store aggregation of ChildInschrijving objects.
     */
    protected $collInschrijvings;

    /**
     * @var bool
     */
    protected $collInschrijvingsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * @var ObjectCombinationCollection Cross CombinationCollection to store aggregation of ChildDeelnemer combinations.
     */
    protected $combinationCollDeelnemerIdsScheduledForDeletion = null;

    /**
     * @var ObjectCombinationCollection Cross CombinationCollection to store aggregation of ChildEvenement combinations.
     */
    protected $combinationCollEvenementIdsScheduledForDeletion = null;

    /**
     * @var ObjectCombinationCollection Cross CombinationCollection to store aggregation of ChildInschrijving combinations.
     */
    protected $combinationCollInschrijvingIdsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDeelnemerHeeftOptie[]
     */
    protected $deelnemerHeeftOptiesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildEvenementHeeftOptie[]
     */
    protected $evenementHeeftOptiesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildInschrijvingHeeftOptie[]
     */
    protected $inschrijvingHeeftOptiesScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->later_wijzigen = 1;
    }

    /**
     * Initializes internal state of fb_model\fb_model\Base\Optie object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
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
     * Compares this with another <code>Optie</code> instance.  If
     * <code>obj</code> is an instance of <code>Optie</code>, delegates to
     * <code>equals(Optie)</code>.  Otherwise, returns <code>false</code>.
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
     * Get the [per_deelnemer] column value.
     *
     * @return int|null
     */
    public function getPerDeelnemer()
    {
        return $this->per_deelnemer;
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
     * Get the [tekst_voor] column value.
     *
     * @return string|null
     */
    public function getTekstVoor()
    {
        return $this->tekst_voor;
    }

    /**
     * Get the [tekst_achter] column value.
     *
     * @return string|null
     */
    public function getTekstAchter()
    {
        return $this->tekst_achter;
    }

    /**
     * Get the [tooltip_tekst] column value.
     *
     * @return string|null
     */
    public function getTooltipTekst()
    {
        return $this->tooltip_tekst;
    }

    /**
     * Get the [heeft_hor_lijn] column value.
     *
     * @return int
     */
    public function getHeeftHorizontaleLijn()
    {
        return $this->heeft_hor_lijn;
    }

    /**
     * Get the [optietype] column value.
     *
     * @return int|null
     */
    public function getOptieType()
    {
        return $this->optietype;
    }

    /**
     * Get the [groep] column value.
     *
     * @return string|null
     */
    public function getGroep()
    {
        return $this->groep;
    }

    /**
     * Get the [label] column value.
     *
     * @return string|null
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Get the [is_default] column value.
     *
     * @return int|null
     */
    public function getIsDefault()
    {
        return $this->is_default;
    }

    /**
     * Get the [later_wijzigen] column value.
     *
     * @return int|null
     */
    public function getLaterWijzigen()
    {
        return $this->later_wijzigen;
    }

    /**
     * Get the [totaal_aantal] column value.
     *
     * @return int|null
     */
    public function getTotaalAantal()
    {
        return $this->totaal_aantal;
    }

    /**
     * Get the [prijs] column value.
     *
     * @return string|null
     */
    public function getPrijs()
    {
        return $this->prijs;
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
     * Get the [intern_gebruik] column value.
     *
     * @return int|null
     */
    public function getInternGebruik()
    {
        return $this->intern_gebruik;
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
     * @return $this|\fb_model\fb_model\Optie The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[OptieTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [per_deelnemer] column.
     *
     * @param int|null $v New value
     * @return $this|\fb_model\fb_model\Optie The current object (for fluent API support)
     */
    public function setPerDeelnemer($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->per_deelnemer !== $v) {
            $this->per_deelnemer = $v;
            $this->modifiedColumns[OptieTableMap::COL_PER_DEELNEMER] = true;
        }

        return $this;
    } // setPerDeelnemer()

    /**
     * Set the value of [naam] column.
     *
     * @param string $v New value
     * @return $this|\fb_model\fb_model\Optie The current object (for fluent API support)
     */
    public function setNaam($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->naam !== $v) {
            $this->naam = $v;
            $this->modifiedColumns[OptieTableMap::COL_NAAM] = true;
        }

        return $this;
    } // setNaam()

    /**
     * Set the value of [tekst_voor] column.
     *
     * @param string|null $v New value
     * @return $this|\fb_model\fb_model\Optie The current object (for fluent API support)
     */
    public function setTekstVoor($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->tekst_voor !== $v) {
            $this->tekst_voor = $v;
            $this->modifiedColumns[OptieTableMap::COL_TEKST_VOOR] = true;
        }

        return $this;
    } // setTekstVoor()

    /**
     * Set the value of [tekst_achter] column.
     *
     * @param string|null $v New value
     * @return $this|\fb_model\fb_model\Optie The current object (for fluent API support)
     */
    public function setTekstAchter($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->tekst_achter !== $v) {
            $this->tekst_achter = $v;
            $this->modifiedColumns[OptieTableMap::COL_TEKST_ACHTER] = true;
        }

        return $this;
    } // setTekstAchter()

    /**
     * Set the value of [tooltip_tekst] column.
     *
     * @param string|null $v New value
     * @return $this|\fb_model\fb_model\Optie The current object (for fluent API support)
     */
    public function setTooltipTekst($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->tooltip_tekst !== $v) {
            $this->tooltip_tekst = $v;
            $this->modifiedColumns[OptieTableMap::COL_TOOLTIP_TEKST] = true;
        }

        return $this;
    } // setTooltipTekst()

    /**
     * Set the value of [heeft_hor_lijn] column.
     *
     * @param int $v New value
     * @return $this|\fb_model\fb_model\Optie The current object (for fluent API support)
     */
    public function setHeeftHorizontaleLijn($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->heeft_hor_lijn !== $v) {
            $this->heeft_hor_lijn = $v;
            $this->modifiedColumns[OptieTableMap::COL_HEEFT_HOR_LIJN] = true;
        }

        return $this;
    } // setHeeftHorizontaleLijn()

    /**
     * Set the value of [optietype] column.
     *
     * @param int|null $v New value
     * @return $this|\fb_model\fb_model\Optie The current object (for fluent API support)
     */
    public function setOptieType($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->optietype !== $v) {
            $this->optietype = $v;
            $this->modifiedColumns[OptieTableMap::COL_OPTIETYPE] = true;
        }

        if ($this->aType !== null && $this->aType->getId() !== $v) {
            $this->aType = null;
        }

        return $this;
    } // setOptieType()

    /**
     * Set the value of [groep] column.
     *
     * @param string|null $v New value
     * @return $this|\fb_model\fb_model\Optie The current object (for fluent API support)
     */
    public function setGroep($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->groep !== $v) {
            $this->groep = $v;
            $this->modifiedColumns[OptieTableMap::COL_GROEP] = true;
        }

        return $this;
    } // setGroep()

    /**
     * Set the value of [label] column.
     *
     * @param string|null $v New value
     * @return $this|\fb_model\fb_model\Optie The current object (for fluent API support)
     */
    public function setLabel($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->label !== $v) {
            $this->label = $v;
            $this->modifiedColumns[OptieTableMap::COL_LABEL] = true;
        }

        return $this;
    } // setLabel()

    /**
     * Set the value of [is_default] column.
     *
     * @param int|null $v New value
     * @return $this|\fb_model\fb_model\Optie The current object (for fluent API support)
     */
    public function setIsDefault($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->is_default !== $v) {
            $this->is_default = $v;
            $this->modifiedColumns[OptieTableMap::COL_IS_DEFAULT] = true;
        }

        return $this;
    } // setIsDefault()

    /**
     * Set the value of [later_wijzigen] column.
     *
     * @param int|null $v New value
     * @return $this|\fb_model\fb_model\Optie The current object (for fluent API support)
     */
    public function setLaterWijzigen($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->later_wijzigen !== $v) {
            $this->later_wijzigen = $v;
            $this->modifiedColumns[OptieTableMap::COL_LATER_WIJZIGEN] = true;
        }

        return $this;
    } // setLaterWijzigen()

    /**
     * Set the value of [totaal_aantal] column.
     *
     * @param int|null $v New value
     * @return $this|\fb_model\fb_model\Optie The current object (for fluent API support)
     */
    public function setTotaalAantal($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->totaal_aantal !== $v) {
            $this->totaal_aantal = $v;
            $this->modifiedColumns[OptieTableMap::COL_TOTAAL_AANTAL] = true;
        }

        return $this;
    } // setTotaalAantal()

    /**
     * Set the value of [prijs] column.
     *
     * @param string|null $v New value
     * @return $this|\fb_model\fb_model\Optie The current object (for fluent API support)
     */
    public function setPrijs($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->prijs !== $v) {
            $this->prijs = $v;
            $this->modifiedColumns[OptieTableMap::COL_PRIJS] = true;
        }

        return $this;
    } // setPrijs()

    /**
     * Set the value of [status] column.
     *
     * @param int $v New value
     * @return $this|\fb_model\fb_model\Optie The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[OptieTableMap::COL_STATUS] = true;
        }

        return $this;
    } // setStatus()

    /**
     * Set the value of [intern_gebruik] column.
     *
     * @param int|null $v New value
     * @return $this|\fb_model\fb_model\Optie The current object (for fluent API support)
     */
    public function setInternGebruik($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->intern_gebruik !== $v) {
            $this->intern_gebruik = $v;
            $this->modifiedColumns[OptieTableMap::COL_INTERN_GEBRUIK] = true;
        }

        return $this;
    } // setInternGebruik()

    /**
     * Sets the value of [gemaakt_datum] column to a normalized version of the date/time value specified.
     *
     * @param  string|integer|\DateTimeInterface $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\fb_model\fb_model\Optie The current object (for fluent API support)
     */
    public function setDatumGemaakt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->gemaakt_datum !== null || $dt !== null) {
            if ($this->gemaakt_datum === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->gemaakt_datum->format("Y-m-d H:i:s.u")) {
                $this->gemaakt_datum = $dt === null ? null : clone $dt;
                $this->modifiedColumns[OptieTableMap::COL_GEMAAKT_DATUM] = true;
            }
        } // if either are not null

        return $this;
    } // setDatumGemaakt()

    /**
     * Set the value of [gemaakt_door] column.
     *
     * @param string $v New value
     * @return $this|\fb_model\fb_model\Optie The current object (for fluent API support)
     */
    public function setGemaaktDoor($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gemaakt_door !== $v) {
            $this->gemaakt_door = $v;
            $this->modifiedColumns[OptieTableMap::COL_GEMAAKT_DOOR] = true;
        }

        return $this;
    } // setGemaaktDoor()

    /**
     * Sets the value of [gewijzigd_datum] column to a normalized version of the date/time value specified.
     *
     * @param  string|integer|\DateTimeInterface $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\fb_model\fb_model\Optie The current object (for fluent API support)
     */
    public function setDatumGewijzigd($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->gewijzigd_datum !== null || $dt !== null) {
            if ($this->gewijzigd_datum === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->gewijzigd_datum->format("Y-m-d H:i:s.u")) {
                $this->gewijzigd_datum = $dt === null ? null : clone $dt;
                $this->modifiedColumns[OptieTableMap::COL_GEWIJZIGD_DATUM] = true;
            }
        } // if either are not null

        return $this;
    } // setDatumGewijzigd()

    /**
     * Set the value of [gewijzigd_door] column.
     *
     * @param string $v New value
     * @return $this|\fb_model\fb_model\Optie The current object (for fluent API support)
     */
    public function setGewijzigdDoor($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gewijzigd_door !== $v) {
            $this->gewijzigd_door = $v;
            $this->modifiedColumns[OptieTableMap::COL_GEWIJZIGD_DOOR] = true;
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
            if ($this->later_wijzigen !== 1) {
                return false;
            }

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : OptieTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : OptieTableMap::translateFieldName('PerDeelnemer', TableMap::TYPE_PHPNAME, $indexType)];
            $this->per_deelnemer = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : OptieTableMap::translateFieldName('Naam', TableMap::TYPE_PHPNAME, $indexType)];
            $this->naam = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : OptieTableMap::translateFieldName('TekstVoor', TableMap::TYPE_PHPNAME, $indexType)];
            $this->tekst_voor = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : OptieTableMap::translateFieldName('TekstAchter', TableMap::TYPE_PHPNAME, $indexType)];
            $this->tekst_achter = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : OptieTableMap::translateFieldName('TooltipTekst', TableMap::TYPE_PHPNAME, $indexType)];
            $this->tooltip_tekst = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : OptieTableMap::translateFieldName('HeeftHorizontaleLijn', TableMap::TYPE_PHPNAME, $indexType)];
            $this->heeft_hor_lijn = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : OptieTableMap::translateFieldName('OptieType', TableMap::TYPE_PHPNAME, $indexType)];
            $this->optietype = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : OptieTableMap::translateFieldName('Groep', TableMap::TYPE_PHPNAME, $indexType)];
            $this->groep = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : OptieTableMap::translateFieldName('Label', TableMap::TYPE_PHPNAME, $indexType)];
            $this->label = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : OptieTableMap::translateFieldName('IsDefault', TableMap::TYPE_PHPNAME, $indexType)];
            $this->is_default = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : OptieTableMap::translateFieldName('LaterWijzigen', TableMap::TYPE_PHPNAME, $indexType)];
            $this->later_wijzigen = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : OptieTableMap::translateFieldName('TotaalAantal', TableMap::TYPE_PHPNAME, $indexType)];
            $this->totaal_aantal = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : OptieTableMap::translateFieldName('Prijs', TableMap::TYPE_PHPNAME, $indexType)];
            $this->prijs = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : OptieTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : OptieTableMap::translateFieldName('InternGebruik', TableMap::TYPE_PHPNAME, $indexType)];
            $this->intern_gebruik = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : OptieTableMap::translateFieldName('DatumGemaakt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->gemaakt_datum = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : OptieTableMap::translateFieldName('GemaaktDoor', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gemaakt_door = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : OptieTableMap::translateFieldName('DatumGewijzigd', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->gewijzigd_datum = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : OptieTableMap::translateFieldName('GewijzigdDoor', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gewijzigd_door = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 20; // 20 = OptieTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\fb_model\\fb_model\\Optie'), 0, $e);
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
        if ($this->aType !== null && $this->optietype !== $this->aType->getId()) {
            $this->aType = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(OptieTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildOptieQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aType = null;
            $this->collDeelnemerHeeftOpties = null;

            $this->collEvenementHeeftOpties = null;

            $this->collInschrijvingHeeftOpties = null;

            $this->collDeelnemerIds = null;
            $this->collEvenementIds = null;
            $this->collInschrijvingIds = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Optie::setDeleted()
     * @see Optie::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(OptieTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildOptieQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(OptieTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                $time = time();
                $highPrecision = \Propel\Runtime\Util\PropelDateTime::createHighPrecision();
                if (!$this->isColumnModified(OptieTableMap::COL_GEMAAKT_DATUM)) {
                    $this->setDatumGemaakt($highPrecision);
                }
                if (!$this->isColumnModified(OptieTableMap::COL_GEWIJZIGD_DATUM)) {
                    $this->setDatumGewijzigd($highPrecision);
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(OptieTableMap::COL_GEWIJZIGD_DATUM)) {
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
                OptieTableMap::addInstanceToPool($this);
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

            if ($this->aType !== null) {
                if ($this->aType->isModified() || $this->aType->isNew()) {
                    $affectedRows += $this->aType->save($con);
                }
                $this->setType($this->aType);
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

            if ($this->combinationCollDeelnemerIdsScheduledForDeletion !== null) {
                if (!$this->combinationCollDeelnemerIdsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->combinationCollDeelnemerIdsScheduledForDeletion as $combination) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[2] = $combination[0]->getId();
                        //$combination[1] = Id;
                        $entryPk[0] = $combination[1];

                        $pks[] = $entryPk;
                    }

                    \fb_model\fb_model\DeelnemerHeeftOptieQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->combinationCollDeelnemerIdsScheduledForDeletion = null;
                }

            }

            if (null !== $this->combinationCollDeelnemerIds) {
                foreach ($this->combinationCollDeelnemerIds as $combination) {

                    //$combination[0] = Deelnemer (fb_deelnemer_heeft_optie_fk_f419b5)
                    if (!$combination[0]->isDeleted() && ($combination[0]->isNew() || $combination[0]->isModified())) {
                        $combination[0]->save($con);
                    }

                    //$combination[1] = Id; Nothing to save.
                }
            }


            if ($this->combinationCollEvenementIdsScheduledForDeletion !== null) {
                if (!$this->combinationCollEvenementIdsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->combinationCollEvenementIdsScheduledForDeletion as $combination) {
                        $entryPk = [];

                        $entryPk[2] = $this->getId();
                        $entryPk[1] = $combination[0]->getId();
                        //$combination[1] = Id;
                        $entryPk[0] = $combination[1];

                        $pks[] = $entryPk;
                    }

                    \fb_model\fb_model\EvenementHeeftOptieQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->combinationCollEvenementIdsScheduledForDeletion = null;
                }

            }

            if (null !== $this->combinationCollEvenementIds) {
                foreach ($this->combinationCollEvenementIds as $combination) {

                    //$combination[0] = Evenement (fb_evenement_heeft_optie_fk_d45e30)
                    if (!$combination[0]->isDeleted() && ($combination[0]->isNew() || $combination[0]->isModified())) {
                        $combination[0]->save($con);
                    }

                    //$combination[1] = Id; Nothing to save.
                }
            }


            if ($this->combinationCollInschrijvingIdsScheduledForDeletion !== null) {
                if (!$this->combinationCollInschrijvingIdsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->combinationCollInschrijvingIdsScheduledForDeletion as $combination) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[2] = $combination[0]->getId();
                        //$combination[1] = Id;
                        $entryPk[0] = $combination[1];

                        $pks[] = $entryPk;
                    }

                    \fb_model\fb_model\InschrijvingHeeftOptieQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->combinationCollInschrijvingIdsScheduledForDeletion = null;
                }

            }

            if (null !== $this->combinationCollInschrijvingIds) {
                foreach ($this->combinationCollInschrijvingIds as $combination) {

                    //$combination[0] = Inschrijving (fb_inschrijving_heeft_optie_fk_4f2b18)
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

        $this->modifiedColumns[OptieTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . OptieTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(OptieTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(OptieTableMap::COL_PER_DEELNEMER)) {
            $modifiedColumns[':p' . $index++]  = 'per_deelnemer';
        }
        if ($this->isColumnModified(OptieTableMap::COL_NAAM)) {
            $modifiedColumns[':p' . $index++]  = 'naam';
        }
        if ($this->isColumnModified(OptieTableMap::COL_TEKST_VOOR)) {
            $modifiedColumns[':p' . $index++]  = 'tekst_voor';
        }
        if ($this->isColumnModified(OptieTableMap::COL_TEKST_ACHTER)) {
            $modifiedColumns[':p' . $index++]  = 'tekst_achter';
        }
        if ($this->isColumnModified(OptieTableMap::COL_TOOLTIP_TEKST)) {
            $modifiedColumns[':p' . $index++]  = 'tooltip_tekst';
        }
        if ($this->isColumnModified(OptieTableMap::COL_HEEFT_HOR_LIJN)) {
            $modifiedColumns[':p' . $index++]  = 'heeft_hor_lijn';
        }
        if ($this->isColumnModified(OptieTableMap::COL_OPTIETYPE)) {
            $modifiedColumns[':p' . $index++]  = 'optietype';
        }
        if ($this->isColumnModified(OptieTableMap::COL_GROEP)) {
            $modifiedColumns[':p' . $index++]  = 'groep';
        }
        if ($this->isColumnModified(OptieTableMap::COL_LABEL)) {
            $modifiedColumns[':p' . $index++]  = 'label';
        }
        if ($this->isColumnModified(OptieTableMap::COL_IS_DEFAULT)) {
            $modifiedColumns[':p' . $index++]  = 'is_default';
        }
        if ($this->isColumnModified(OptieTableMap::COL_LATER_WIJZIGEN)) {
            $modifiedColumns[':p' . $index++]  = 'later_wijzigen';
        }
        if ($this->isColumnModified(OptieTableMap::COL_TOTAAL_AANTAL)) {
            $modifiedColumns[':p' . $index++]  = 'totaal_aantal';
        }
        if ($this->isColumnModified(OptieTableMap::COL_PRIJS)) {
            $modifiedColumns[':p' . $index++]  = 'prijs';
        }
        if ($this->isColumnModified(OptieTableMap::COL_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'status';
        }
        if ($this->isColumnModified(OptieTableMap::COL_INTERN_GEBRUIK)) {
            $modifiedColumns[':p' . $index++]  = 'intern_gebruik';
        }
        if ($this->isColumnModified(OptieTableMap::COL_GEMAAKT_DATUM)) {
            $modifiedColumns[':p' . $index++]  = 'gemaakt_datum';
        }
        if ($this->isColumnModified(OptieTableMap::COL_GEMAAKT_DOOR)) {
            $modifiedColumns[':p' . $index++]  = 'gemaakt_door';
        }
        if ($this->isColumnModified(OptieTableMap::COL_GEWIJZIGD_DATUM)) {
            $modifiedColumns[':p' . $index++]  = 'gewijzigd_datum';
        }
        if ($this->isColumnModified(OptieTableMap::COL_GEWIJZIGD_DOOR)) {
            $modifiedColumns[':p' . $index++]  = 'gewijzigd_door';
        }

        $sql = sprintf(
            'INSERT INTO fb_optie (%s) VALUES (%s)',
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
                    case 'per_deelnemer':
                        $stmt->bindValue($identifier, $this->per_deelnemer, PDO::PARAM_INT);
                        break;
                    case 'naam':
                        $stmt->bindValue($identifier, $this->naam, PDO::PARAM_STR);
                        break;
                    case 'tekst_voor':
                        $stmt->bindValue($identifier, $this->tekst_voor, PDO::PARAM_STR);
                        break;
                    case 'tekst_achter':
                        $stmt->bindValue($identifier, $this->tekst_achter, PDO::PARAM_STR);
                        break;
                    case 'tooltip_tekst':
                        $stmt->bindValue($identifier, $this->tooltip_tekst, PDO::PARAM_STR);
                        break;
                    case 'heeft_hor_lijn':
                        $stmt->bindValue($identifier, $this->heeft_hor_lijn, PDO::PARAM_INT);
                        break;
                    case 'optietype':
                        $stmt->bindValue($identifier, $this->optietype, PDO::PARAM_INT);
                        break;
                    case 'groep':
                        $stmt->bindValue($identifier, $this->groep, PDO::PARAM_STR);
                        break;
                    case 'label':
                        $stmt->bindValue($identifier, $this->label, PDO::PARAM_STR);
                        break;
                    case 'is_default':
                        $stmt->bindValue($identifier, $this->is_default, PDO::PARAM_INT);
                        break;
                    case 'later_wijzigen':
                        $stmt->bindValue($identifier, $this->later_wijzigen, PDO::PARAM_INT);
                        break;
                    case 'totaal_aantal':
                        $stmt->bindValue($identifier, $this->totaal_aantal, PDO::PARAM_INT);
                        break;
                    case 'prijs':
                        $stmt->bindValue($identifier, $this->prijs, PDO::PARAM_STR);
                        break;
                    case 'status':
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_INT);
                        break;
                    case 'intern_gebruik':
                        $stmt->bindValue($identifier, $this->intern_gebruik, PDO::PARAM_INT);
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
        $pos = OptieTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getPerDeelnemer();
                break;
            case 2:
                return $this->getNaam();
                break;
            case 3:
                return $this->getTekstVoor();
                break;
            case 4:
                return $this->getTekstAchter();
                break;
            case 5:
                return $this->getTooltipTekst();
                break;
            case 6:
                return $this->getHeeftHorizontaleLijn();
                break;
            case 7:
                return $this->getOptieType();
                break;
            case 8:
                return $this->getGroep();
                break;
            case 9:
                return $this->getLabel();
                break;
            case 10:
                return $this->getIsDefault();
                break;
            case 11:
                return $this->getLaterWijzigen();
                break;
            case 12:
                return $this->getTotaalAantal();
                break;
            case 13:
                return $this->getPrijs();
                break;
            case 14:
                return $this->getStatus();
                break;
            case 15:
                return $this->getInternGebruik();
                break;
            case 16:
                return $this->getDatumGemaakt();
                break;
            case 17:
                return $this->getGemaaktDoor();
                break;
            case 18:
                return $this->getDatumGewijzigd();
                break;
            case 19:
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

        if (isset($alreadyDumpedObjects['Optie'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Optie'][$this->hashCode()] = true;
        $keys = OptieTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getPerDeelnemer(),
            $keys[2] => $this->getNaam(),
            $keys[3] => $this->getTekstVoor(),
            $keys[4] => $this->getTekstAchter(),
            $keys[5] => $this->getTooltipTekst(),
            $keys[6] => $this->getHeeftHorizontaleLijn(),
            $keys[7] => $this->getOptieType(),
            $keys[8] => $this->getGroep(),
            $keys[9] => $this->getLabel(),
            $keys[10] => $this->getIsDefault(),
            $keys[11] => $this->getLaterWijzigen(),
            $keys[12] => $this->getTotaalAantal(),
            $keys[13] => $this->getPrijs(),
            $keys[14] => $this->getStatus(),
            $keys[15] => $this->getInternGebruik(),
            $keys[16] => $this->getDatumGemaakt(),
            $keys[17] => $this->getGemaaktDoor(),
            $keys[18] => $this->getDatumGewijzigd(),
            $keys[19] => $this->getGewijzigdDoor(),
        );
        if ($result[$keys[16]] instanceof \DateTimeInterface) {
            $result[$keys[16]] = $result[$keys[16]]->format('c');
        }

        if ($result[$keys[18]] instanceof \DateTimeInterface) {
            $result[$keys[18]] = $result[$keys[18]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aType) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'type';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fb_type';
                        break;
                    default:
                        $key = 'Type';
                }

                $result[$key] = $this->aType->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\fb_model\fb_model\Optie
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = OptieTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\fb_model\fb_model\Optie
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setPerDeelnemer($value);
                break;
            case 2:
                $this->setNaam($value);
                break;
            case 3:
                $this->setTekstVoor($value);
                break;
            case 4:
                $this->setTekstAchter($value);
                break;
            case 5:
                $this->setTooltipTekst($value);
                break;
            case 6:
                $this->setHeeftHorizontaleLijn($value);
                break;
            case 7:
                $this->setOptieType($value);
                break;
            case 8:
                $this->setGroep($value);
                break;
            case 9:
                $this->setLabel($value);
                break;
            case 10:
                $this->setIsDefault($value);
                break;
            case 11:
                $this->setLaterWijzigen($value);
                break;
            case 12:
                $this->setTotaalAantal($value);
                break;
            case 13:
                $this->setPrijs($value);
                break;
            case 14:
                $this->setStatus($value);
                break;
            case 15:
                $this->setInternGebruik($value);
                break;
            case 16:
                $this->setDatumGemaakt($value);
                break;
            case 17:
                $this->setGemaaktDoor($value);
                break;
            case 18:
                $this->setDatumGewijzigd($value);
                break;
            case 19:
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
        $keys = OptieTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setPerDeelnemer($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setNaam($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setTekstVoor($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setTekstAchter($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setTooltipTekst($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setHeeftHorizontaleLijn($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setOptieType($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setGroep($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setLabel($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setIsDefault($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setLaterWijzigen($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setTotaalAantal($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setPrijs($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setStatus($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setInternGebruik($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setDatumGemaakt($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setGemaaktDoor($arr[$keys[17]]);
        }
        if (array_key_exists($keys[18], $arr)) {
            $this->setDatumGewijzigd($arr[$keys[18]]);
        }
        if (array_key_exists($keys[19], $arr)) {
            $this->setGewijzigdDoor($arr[$keys[19]]);
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
     * @return $this|\fb_model\fb_model\Optie The current object, for fluid interface
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
        $criteria = new Criteria(OptieTableMap::DATABASE_NAME);

        if ($this->isColumnModified(OptieTableMap::COL_ID)) {
            $criteria->add(OptieTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(OptieTableMap::COL_PER_DEELNEMER)) {
            $criteria->add(OptieTableMap::COL_PER_DEELNEMER, $this->per_deelnemer);
        }
        if ($this->isColumnModified(OptieTableMap::COL_NAAM)) {
            $criteria->add(OptieTableMap::COL_NAAM, $this->naam);
        }
        if ($this->isColumnModified(OptieTableMap::COL_TEKST_VOOR)) {
            $criteria->add(OptieTableMap::COL_TEKST_VOOR, $this->tekst_voor);
        }
        if ($this->isColumnModified(OptieTableMap::COL_TEKST_ACHTER)) {
            $criteria->add(OptieTableMap::COL_TEKST_ACHTER, $this->tekst_achter);
        }
        if ($this->isColumnModified(OptieTableMap::COL_TOOLTIP_TEKST)) {
            $criteria->add(OptieTableMap::COL_TOOLTIP_TEKST, $this->tooltip_tekst);
        }
        if ($this->isColumnModified(OptieTableMap::COL_HEEFT_HOR_LIJN)) {
            $criteria->add(OptieTableMap::COL_HEEFT_HOR_LIJN, $this->heeft_hor_lijn);
        }
        if ($this->isColumnModified(OptieTableMap::COL_OPTIETYPE)) {
            $criteria->add(OptieTableMap::COL_OPTIETYPE, $this->optietype);
        }
        if ($this->isColumnModified(OptieTableMap::COL_GROEP)) {
            $criteria->add(OptieTableMap::COL_GROEP, $this->groep);
        }
        if ($this->isColumnModified(OptieTableMap::COL_LABEL)) {
            $criteria->add(OptieTableMap::COL_LABEL, $this->label);
        }
        if ($this->isColumnModified(OptieTableMap::COL_IS_DEFAULT)) {
            $criteria->add(OptieTableMap::COL_IS_DEFAULT, $this->is_default);
        }
        if ($this->isColumnModified(OptieTableMap::COL_LATER_WIJZIGEN)) {
            $criteria->add(OptieTableMap::COL_LATER_WIJZIGEN, $this->later_wijzigen);
        }
        if ($this->isColumnModified(OptieTableMap::COL_TOTAAL_AANTAL)) {
            $criteria->add(OptieTableMap::COL_TOTAAL_AANTAL, $this->totaal_aantal);
        }
        if ($this->isColumnModified(OptieTableMap::COL_PRIJS)) {
            $criteria->add(OptieTableMap::COL_PRIJS, $this->prijs);
        }
        if ($this->isColumnModified(OptieTableMap::COL_STATUS)) {
            $criteria->add(OptieTableMap::COL_STATUS, $this->status);
        }
        if ($this->isColumnModified(OptieTableMap::COL_INTERN_GEBRUIK)) {
            $criteria->add(OptieTableMap::COL_INTERN_GEBRUIK, $this->intern_gebruik);
        }
        if ($this->isColumnModified(OptieTableMap::COL_GEMAAKT_DATUM)) {
            $criteria->add(OptieTableMap::COL_GEMAAKT_DATUM, $this->gemaakt_datum);
        }
        if ($this->isColumnModified(OptieTableMap::COL_GEMAAKT_DOOR)) {
            $criteria->add(OptieTableMap::COL_GEMAAKT_DOOR, $this->gemaakt_door);
        }
        if ($this->isColumnModified(OptieTableMap::COL_GEWIJZIGD_DATUM)) {
            $criteria->add(OptieTableMap::COL_GEWIJZIGD_DATUM, $this->gewijzigd_datum);
        }
        if ($this->isColumnModified(OptieTableMap::COL_GEWIJZIGD_DOOR)) {
            $criteria->add(OptieTableMap::COL_GEWIJZIGD_DOOR, $this->gewijzigd_door);
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
        $criteria = ChildOptieQuery::create();
        $criteria->add(OptieTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \fb_model\fb_model\Optie (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setPerDeelnemer($this->getPerDeelnemer());
        $copyObj->setNaam($this->getNaam());
        $copyObj->setTekstVoor($this->getTekstVoor());
        $copyObj->setTekstAchter($this->getTekstAchter());
        $copyObj->setTooltipTekst($this->getTooltipTekst());
        $copyObj->setHeeftHorizontaleLijn($this->getHeeftHorizontaleLijn());
        $copyObj->setOptieType($this->getOptieType());
        $copyObj->setGroep($this->getGroep());
        $copyObj->setLabel($this->getLabel());
        $copyObj->setIsDefault($this->getIsDefault());
        $copyObj->setLaterWijzigen($this->getLaterWijzigen());
        $copyObj->setTotaalAantal($this->getTotaalAantal());
        $copyObj->setPrijs($this->getPrijs());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setInternGebruik($this->getInternGebruik());
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

            foreach ($this->getEvenementHeeftOpties() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addEvenementHeeftOptie($relObj->copy($deepCopy));
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
     * @return \fb_model\fb_model\Optie Clone of current object.
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
     * Declares an association between this object and a ChildType object.
     *
     * @param  ChildType|null $v
     * @return $this|\fb_model\fb_model\Optie The current object (for fluent API support)
     * @throws PropelException
     */
    public function setType(ChildType $v = null)
    {
        if ($v === null) {
            $this->setOptieType(NULL);
        } else {
            $this->setOptieType($v->getId());
        }

        $this->aType = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildType object, it will not be re-added.
        if ($v !== null) {
            $v->addOptie($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildType object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildType|null The associated ChildType object.
     * @throws PropelException
     */
    public function getType(ConnectionInterface $con = null)
    {
        if ($this->aType === null && ($this->optietype != 0)) {
            $this->aType = ChildTypeQuery::create()->findPk($this->optietype, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aType->addOpties($this);
             */
        }

        return $this->aType;
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
        if ('DeelnemerHeeftOptie' === $relationName) {
            $this->initDeelnemerHeeftOpties();
            return;
        }
        if ('EvenementHeeftOptie' === $relationName) {
            $this->initEvenementHeeftOpties();
            return;
        }
        if ('InschrijvingHeeftOptie' === $relationName) {
            $this->initInschrijvingHeeftOpties();
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
     * If this ChildOptie is new, it will return
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
        if (null === $this->collDeelnemerHeeftOpties || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collDeelnemerHeeftOpties) {
                    $this->initDeelnemerHeeftOpties();
                } else {
                    $collectionClassName = DeelnemerHeeftOptieTableMap::getTableMap()->getCollectionClassName();

                    $collDeelnemerHeeftOpties = new $collectionClassName;
                    $collDeelnemerHeeftOpties->setModel('\fb_model\fb_model\DeelnemerHeeftOptie');

                    return $collDeelnemerHeeftOpties;
                }
            } else {
                $collDeelnemerHeeftOpties = ChildDeelnemerHeeftOptieQuery::create(null, $criteria)
                    ->filterByOptie($this)
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
     * @return $this|ChildOptie The current object (for fluent API support)
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
            $deelnemerHeeftOptieRemoved->setOptie(null);
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
                ->filterByOptie($this)
                ->count($con);
        }

        return count($this->collDeelnemerHeeftOpties);
    }

    /**
     * Method called to associate a ChildDeelnemerHeeftOptie object to this object
     * through the ChildDeelnemerHeeftOptie foreign key attribute.
     *
     * @param  ChildDeelnemerHeeftOptie $l ChildDeelnemerHeeftOptie
     * @return $this|\fb_model\fb_model\Optie The current object (for fluent API support)
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
        $deelnemerHeeftOptie->setOptie($this);
    }

    /**
     * @param  ChildDeelnemerHeeftOptie $deelnemerHeeftOptie The ChildDeelnemerHeeftOptie object to remove.
     * @return $this|ChildOptie The current object (for fluent API support)
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
            $deelnemerHeeftOptie->setOptie(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Optie is new, it will return
     * an empty collection; or if this Optie has previously
     * been saved, it will retrieve related DeelnemerHeeftOpties from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Optie.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildDeelnemerHeeftOptie[] List of ChildDeelnemerHeeftOptie objects
     */
    public function getDeelnemerHeeftOptiesJoinDeelnemer(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDeelnemerHeeftOptieQuery::create(null, $criteria);
        $query->joinWith('Deelnemer', $joinBehavior);

        return $this->getDeelnemerHeeftOpties($query, $con);
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
     * If this ChildOptie is new, it will return
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
        if (null === $this->collEvenementHeeftOpties || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collEvenementHeeftOpties) {
                    $this->initEvenementHeeftOpties();
                } else {
                    $collectionClassName = EvenementHeeftOptieTableMap::getTableMap()->getCollectionClassName();

                    $collEvenementHeeftOpties = new $collectionClassName;
                    $collEvenementHeeftOpties->setModel('\fb_model\fb_model\EvenementHeeftOptie');

                    return $collEvenementHeeftOpties;
                }
            } else {
                $collEvenementHeeftOpties = ChildEvenementHeeftOptieQuery::create(null, $criteria)
                    ->filterByOptie($this)
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
     * @return $this|ChildOptie The current object (for fluent API support)
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
            $evenementHeeftOptieRemoved->setOptie(null);
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
                ->filterByOptie($this)
                ->count($con);
        }

        return count($this->collEvenementHeeftOpties);
    }

    /**
     * Method called to associate a ChildEvenementHeeftOptie object to this object
     * through the ChildEvenementHeeftOptie foreign key attribute.
     *
     * @param  ChildEvenementHeeftOptie $l ChildEvenementHeeftOptie
     * @return $this|\fb_model\fb_model\Optie The current object (for fluent API support)
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
        $evenementHeeftOptie->setOptie($this);
    }

    /**
     * @param  ChildEvenementHeeftOptie $evenementHeeftOptie The ChildEvenementHeeftOptie object to remove.
     * @return $this|ChildOptie The current object (for fluent API support)
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
            $evenementHeeftOptie->setOptie(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Optie is new, it will return
     * an empty collection; or if this Optie has previously
     * been saved, it will retrieve related EvenementHeeftOpties from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Optie.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildEvenementHeeftOptie[] List of ChildEvenementHeeftOptie objects
     */
    public function getEvenementHeeftOptiesJoinEvenement(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildEvenementHeeftOptieQuery::create(null, $criteria);
        $query->joinWith('Evenement', $joinBehavior);

        return $this->getEvenementHeeftOpties($query, $con);
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
     * If this ChildOptie is new, it will return
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
        if (null === $this->collInschrijvingHeeftOpties || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collInschrijvingHeeftOpties) {
                    $this->initInschrijvingHeeftOpties();
                } else {
                    $collectionClassName = InschrijvingHeeftOptieTableMap::getTableMap()->getCollectionClassName();

                    $collInschrijvingHeeftOpties = new $collectionClassName;
                    $collInschrijvingHeeftOpties->setModel('\fb_model\fb_model\InschrijvingHeeftOptie');

                    return $collInschrijvingHeeftOpties;
                }
            } else {
                $collInschrijvingHeeftOpties = ChildInschrijvingHeeftOptieQuery::create(null, $criteria)
                    ->filterByOptie($this)
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
     * @return $this|ChildOptie The current object (for fluent API support)
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
            $inschrijvingHeeftOptieRemoved->setOptie(null);
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
                ->filterByOptie($this)
                ->count($con);
        }

        return count($this->collInschrijvingHeeftOpties);
    }

    /**
     * Method called to associate a ChildInschrijvingHeeftOptie object to this object
     * through the ChildInschrijvingHeeftOptie foreign key attribute.
     *
     * @param  ChildInschrijvingHeeftOptie $l ChildInschrijvingHeeftOptie
     * @return $this|\fb_model\fb_model\Optie The current object (for fluent API support)
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
        $inschrijvingHeeftOptie->setOptie($this);
    }

    /**
     * @param  ChildInschrijvingHeeftOptie $inschrijvingHeeftOptie The ChildInschrijvingHeeftOptie object to remove.
     * @return $this|ChildOptie The current object (for fluent API support)
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
            $inschrijvingHeeftOptie->setOptie(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Optie is new, it will return
     * an empty collection; or if this Optie has previously
     * been saved, it will retrieve related InschrijvingHeeftOpties from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Optie.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildInschrijvingHeeftOptie[] List of ChildInschrijvingHeeftOptie objects
     */
    public function getInschrijvingHeeftOptiesJoinInschrijving(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildInschrijvingHeeftOptieQuery::create(null, $criteria);
        $query->joinWith('Inschrijving', $joinBehavior);

        return $this->getInschrijvingHeeftOpties($query, $con);
    }

    /**
     * Clears out the collDeelnemerIds collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDeelnemerIds()
     */
    public function clearDeelnemerIds()
    {
        $this->collDeelnemerIds = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the combinationCollDeelnemerIds crossRef collection.
     *
     * By default this just sets the combinationCollDeelnemerIds collection to an empty collection (like clearDeelnemerIds());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initDeelnemerIds()
    {
        $this->combinationCollDeelnemerIds = new ObjectCombinationCollection;
        $this->combinationCollDeelnemerIdsPartial = true;
    }

    /**
     * Checks if the combinationCollDeelnemerIds collection is loaded.
     *
     * @return bool
     */
    public function isDeelnemerIdsLoaded()
    {
        return null !== $this->combinationCollDeelnemerIds;
    }

    /**
     * Returns a new query object pre configured with filters from current object and given arguments to query the database.
     *
     * @param int $id
     * @param Criteria $criteria
     *
     * @return ChildDeelnemerQuery
     */
    public function createDeelnemersQuery($id = null, Criteria $criteria = null)
    {
        $criteria = ChildDeelnemerQuery::create($criteria)
            ->filterByOptie($this);

        $deelnemerHeeftOptieQuery = $criteria->useDeelnemerHeeftOptieQuery();

        if (null !== $id) {
            $deelnemerHeeftOptieQuery->filterById($id);
        }

        $deelnemerHeeftOptieQuery->endUse();

        return $criteria;
    }

    /**
     * Gets a combined collection of ChildDeelnemer objects related by a many-to-many relationship
     * to the current object by way of the fb_deelnemer_heeft_optie cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildOptie is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCombinationCollection Combination list of ChildDeelnemer objects
     */
    public function getDeelnemerIds($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->combinationCollDeelnemerIdsPartial && !$this->isNew();
        if (null === $this->combinationCollDeelnemerIds || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->combinationCollDeelnemerIds) {
                    $this->initDeelnemerIds();
                }
            } else {

                $query = ChildDeelnemerHeeftOptieQuery::create(null, $criteria)
                    ->filterByOptie($this)
                    ->joinDeelnemer()
                ;

                $items = $query->find($con);
                $combinationCollDeelnemerIds = new ObjectCombinationCollection();
                foreach ($items as $item) {
                    $combination = [];

                    $combination[] = $item->getDeelnemer();
                    $combination[] = $item->getId();
                    $combinationCollDeelnemerIds[] = $combination;
                }

                if (null !== $criteria) {
                    return $combinationCollDeelnemerIds;
                }

                if ($partial && $this->combinationCollDeelnemerIds) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->combinationCollDeelnemerIds as $obj) {
                        if (!call_user_func_array([$combinationCollDeelnemerIds, 'contains'], $obj)) {
                            $combinationCollDeelnemerIds[] = $obj;
                        }
                    }
                }

                $this->combinationCollDeelnemerIds = $combinationCollDeelnemerIds;
                $this->combinationCollDeelnemerIdsPartial = false;
            }
        }

        return $this->combinationCollDeelnemerIds;
    }

    /**
     * Returns a not cached ObjectCollection of ChildDeelnemer objects. This will hit always the databases.
     * If you have attached new ChildDeelnemer object to this object you need to call `save` first to get
     * the correct return value. Use getDeelnemerIds() to get the current internal state.
     *
     * @param int $id
     * @param Criteria $criteria
     * @param ConnectionInterface $con
     *
     * @return ChildDeelnemer[]|ObjectCollection
     */
    public function getDeelnemers($id = null, Criteria $criteria = null, ConnectionInterface $con = null)
    {
        return $this->createDeelnemersQuery($id, $criteria)->find($con);
    }

    /**
     * Sets a collection of ChildDeelnemer objects related by a many-to-many relationship
     * to the current object by way of the fb_deelnemer_heeft_optie cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $deelnemerIds A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildOptie The current object (for fluent API support)
     */
    public function setDeelnemerIds(Collection $deelnemerIds, ConnectionInterface $con = null)
    {
        $this->clearDeelnemerIds();
        $currentDeelnemerIds = $this->getDeelnemerIds();

        $combinationCollDeelnemerIdsScheduledForDeletion = $currentDeelnemerIds->diff($deelnemerIds);

        foreach ($combinationCollDeelnemerIdsScheduledForDeletion as $toDelete) {
            call_user_func_array([$this, 'removeDeelnemerId'], $toDelete);
        }

        foreach ($deelnemerIds as $deelnemerId) {
            if (!call_user_func_array([$currentDeelnemerIds, 'contains'], $deelnemerId)) {
                call_user_func_array([$this, 'doAddDeelnemerId'], $deelnemerId);
            }
        }

        $this->combinationCollDeelnemerIdsPartial = false;
        $this->combinationCollDeelnemerIds = $deelnemerIds;

        return $this;
    }

    /**
     * Gets the number of ChildDeelnemer objects related by a many-to-many relationship
     * to the current object by way of the fb_deelnemer_heeft_optie cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related ChildDeelnemer objects
     */
    public function countDeelnemerIds(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->combinationCollDeelnemerIdsPartial && !$this->isNew();
        if (null === $this->combinationCollDeelnemerIds || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->combinationCollDeelnemerIds) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getDeelnemerIds());
                }

                $query = ChildDeelnemerHeeftOptieQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByOptie($this)
                    ->count($con);
            }
        } else {
            return count($this->combinationCollDeelnemerIds);
        }
    }

    /**
     * Returns the not cached count of ChildDeelnemer objects. This will hit always the databases.
     * If you have attached new ChildDeelnemer object to this object you need to call `save` first to get
     * the correct return value. Use getDeelnemerIds() to get the current internal state.
     *
     * @param int $id
     * @param Criteria $criteria
     * @param ConnectionInterface $con
     *
     * @return integer
     */
    public function countDeelnemers($id = null, Criteria $criteria = null, ConnectionInterface $con = null)
    {
        return $this->createDeelnemersQuery($id, $criteria)->count($con);
    }

    /**
     * Associate a ChildDeelnemer to this object
     * through the fb_deelnemer_heeft_optie cross reference table.
     *
     * @param ChildDeelnemer $deelnemer,
     * @param int $id
     * @return ChildOptie The current object (for fluent API support)
     */
    public function addDeelnemer(ChildDeelnemer $deelnemer, $id)
    {
        if ($this->combinationCollDeelnemerIds === null) {
            $this->initDeelnemerIds();
        }

        if (!$this->getDeelnemerIds()->contains($deelnemer, $id)) {
            // only add it if the **same** object is not already associated
            $this->combinationCollDeelnemerIds->push($deelnemer, $id);
            $this->doAddDeelnemerId($deelnemer, $id);
        }

        return $this;
    }

    /**
     *
     * @param ChildDeelnemer $deelnemer,
     * @param int $id
     */
    protected function doAddDeelnemerId(ChildDeelnemer $deelnemer, $id)
    {
        $deelnemerHeeftOptie = new ChildDeelnemerHeeftOptie();

        $deelnemerHeeftOptie->setDeelnemer($deelnemer);
        $deelnemerHeeftOptie->setId($id);


        $deelnemerHeeftOptie->setOptie($this);

        $this->addDeelnemerHeeftOptie($deelnemerHeeftOptie);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if ($deelnemer->isOptieIdsLoaded()) {
            $deelnemer->initOptieIds();
            $deelnemer->getOptieIds()->push($this, $id);
        } elseif (!$deelnemer->getOptieIds()->contains($this, $id)) {
            $deelnemer->getOptieIds()->push($this, $id);
        }

    }

    /**
     * Remove deelnemer, id of this object
     * through the fb_deelnemer_heeft_optie cross reference table.
     *
     * @param ChildDeelnemer $deelnemer,
     * @param int $id
     * @return ChildOptie The current object (for fluent API support)
     */
    public function removeDeelnemerId(ChildDeelnemer $deelnemer, $id)
    {
        if ($this->getDeelnemerIds()->contains($deelnemer, $id)) {
            $deelnemerHeeftOptie = new ChildDeelnemerHeeftOptie();
            $deelnemerHeeftOptie->setDeelnemer($deelnemer);
            if ($deelnemer->isOptieIdsLoaded()) {
                //remove the back reference if available
                $deelnemer->getOptieIds()->removeObject($this, $id);
            }

            $deelnemerHeeftOptie->setId($id);
            $deelnemerHeeftOptie->setOptie($this);
            $this->removeDeelnemerHeeftOptie(clone $deelnemerHeeftOptie);
            $deelnemerHeeftOptie->clear();

            $this->combinationCollDeelnemerIds->remove($this->combinationCollDeelnemerIds->search($deelnemer, $id));

            if (null === $this->combinationCollDeelnemerIdsScheduledForDeletion) {
                $this->combinationCollDeelnemerIdsScheduledForDeletion = clone $this->combinationCollDeelnemerIds;
                $this->combinationCollDeelnemerIdsScheduledForDeletion->clear();
            }

            $this->combinationCollDeelnemerIdsScheduledForDeletion->push($deelnemer, $id);
        }


        return $this;
    }

    /**
     * Clears out the collEvenementIds collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addEvenementIds()
     */
    public function clearEvenementIds()
    {
        $this->collEvenementIds = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the combinationCollEvenementIds crossRef collection.
     *
     * By default this just sets the combinationCollEvenementIds collection to an empty collection (like clearEvenementIds());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initEvenementIds()
    {
        $this->combinationCollEvenementIds = new ObjectCombinationCollection;
        $this->combinationCollEvenementIdsPartial = true;
    }

    /**
     * Checks if the combinationCollEvenementIds collection is loaded.
     *
     * @return bool
     */
    public function isEvenementIdsLoaded()
    {
        return null !== $this->combinationCollEvenementIds;
    }

    /**
     * Returns a new query object pre configured with filters from current object and given arguments to query the database.
     *
     * @param int $id
     * @param Criteria $criteria
     *
     * @return ChildEvenementQuery
     */
    public function createEvenementsQuery($id = null, Criteria $criteria = null)
    {
        $criteria = ChildEvenementQuery::create($criteria)
            ->filterByOptie($this);

        $evenementHeeftOptieQuery = $criteria->useEvenementHeeftOptieQuery();

        if (null !== $id) {
            $evenementHeeftOptieQuery->filterById($id);
        }

        $evenementHeeftOptieQuery->endUse();

        return $criteria;
    }

    /**
     * Gets a combined collection of ChildEvenement objects related by a many-to-many relationship
     * to the current object by way of the fb_evenement_heeft_optie cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildOptie is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCombinationCollection Combination list of ChildEvenement objects
     */
    public function getEvenementIds($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->combinationCollEvenementIdsPartial && !$this->isNew();
        if (null === $this->combinationCollEvenementIds || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->combinationCollEvenementIds) {
                    $this->initEvenementIds();
                }
            } else {

                $query = ChildEvenementHeeftOptieQuery::create(null, $criteria)
                    ->filterByOptie($this)
                    ->joinEvenement()
                ;

                $items = $query->find($con);
                $combinationCollEvenementIds = new ObjectCombinationCollection();
                foreach ($items as $item) {
                    $combination = [];

                    $combination[] = $item->getEvenement();
                    $combination[] = $item->getId();
                    $combinationCollEvenementIds[] = $combination;
                }

                if (null !== $criteria) {
                    return $combinationCollEvenementIds;
                }

                if ($partial && $this->combinationCollEvenementIds) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->combinationCollEvenementIds as $obj) {
                        if (!call_user_func_array([$combinationCollEvenementIds, 'contains'], $obj)) {
                            $combinationCollEvenementIds[] = $obj;
                        }
                    }
                }

                $this->combinationCollEvenementIds = $combinationCollEvenementIds;
                $this->combinationCollEvenementIdsPartial = false;
            }
        }

        return $this->combinationCollEvenementIds;
    }

    /**
     * Returns a not cached ObjectCollection of ChildEvenement objects. This will hit always the databases.
     * If you have attached new ChildEvenement object to this object you need to call `save` first to get
     * the correct return value. Use getEvenementIds() to get the current internal state.
     *
     * @param int $id
     * @param Criteria $criteria
     * @param ConnectionInterface $con
     *
     * @return ChildEvenement[]|ObjectCollection
     */
    public function getEvenements($id = null, Criteria $criteria = null, ConnectionInterface $con = null)
    {
        return $this->createEvenementsQuery($id, $criteria)->find($con);
    }

    /**
     * Sets a collection of ChildEvenement objects related by a many-to-many relationship
     * to the current object by way of the fb_evenement_heeft_optie cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $evenementIds A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildOptie The current object (for fluent API support)
     */
    public function setEvenementIds(Collection $evenementIds, ConnectionInterface $con = null)
    {
        $this->clearEvenementIds();
        $currentEvenementIds = $this->getEvenementIds();

        $combinationCollEvenementIdsScheduledForDeletion = $currentEvenementIds->diff($evenementIds);

        foreach ($combinationCollEvenementIdsScheduledForDeletion as $toDelete) {
            call_user_func_array([$this, 'removeEvenementId'], $toDelete);
        }

        foreach ($evenementIds as $evenementId) {
            if (!call_user_func_array([$currentEvenementIds, 'contains'], $evenementId)) {
                call_user_func_array([$this, 'doAddEvenementId'], $evenementId);
            }
        }

        $this->combinationCollEvenementIdsPartial = false;
        $this->combinationCollEvenementIds = $evenementIds;

        return $this;
    }

    /**
     * Gets the number of ChildEvenement objects related by a many-to-many relationship
     * to the current object by way of the fb_evenement_heeft_optie cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related ChildEvenement objects
     */
    public function countEvenementIds(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->combinationCollEvenementIdsPartial && !$this->isNew();
        if (null === $this->combinationCollEvenementIds || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->combinationCollEvenementIds) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getEvenementIds());
                }

                $query = ChildEvenementHeeftOptieQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByOptie($this)
                    ->count($con);
            }
        } else {
            return count($this->combinationCollEvenementIds);
        }
    }

    /**
     * Returns the not cached count of ChildEvenement objects. This will hit always the databases.
     * If you have attached new ChildEvenement object to this object you need to call `save` first to get
     * the correct return value. Use getEvenementIds() to get the current internal state.
     *
     * @param int $id
     * @param Criteria $criteria
     * @param ConnectionInterface $con
     *
     * @return integer
     */
    public function countEvenements($id = null, Criteria $criteria = null, ConnectionInterface $con = null)
    {
        return $this->createEvenementsQuery($id, $criteria)->count($con);
    }

    /**
     * Associate a ChildEvenement to this object
     * through the fb_evenement_heeft_optie cross reference table.
     *
     * @param ChildEvenement $evenement,
     * @param int $id
     * @return ChildOptie The current object (for fluent API support)
     */
    public function addEvenement(ChildEvenement $evenement, $id)
    {
        if ($this->combinationCollEvenementIds === null) {
            $this->initEvenementIds();
        }

        if (!$this->getEvenementIds()->contains($evenement, $id)) {
            // only add it if the **same** object is not already associated
            $this->combinationCollEvenementIds->push($evenement, $id);
            $this->doAddEvenementId($evenement, $id);
        }

        return $this;
    }

    /**
     *
     * @param ChildEvenement $evenement,
     * @param int $id
     */
    protected function doAddEvenementId(ChildEvenement $evenement, $id)
    {
        $evenementHeeftOptie = new ChildEvenementHeeftOptie();

        $evenementHeeftOptie->setEvenement($evenement);
        $evenementHeeftOptie->setId($id);


        $evenementHeeftOptie->setOptie($this);

        $this->addEvenementHeeftOptie($evenementHeeftOptie);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if ($evenement->isOptieIdsLoaded()) {
            $evenement->initOptieIds();
            $evenement->getOptieIds()->push($this, $id);
        } elseif (!$evenement->getOptieIds()->contains($this, $id)) {
            $evenement->getOptieIds()->push($this, $id);
        }

    }

    /**
     * Remove evenement, id of this object
     * through the fb_evenement_heeft_optie cross reference table.
     *
     * @param ChildEvenement $evenement,
     * @param int $id
     * @return ChildOptie The current object (for fluent API support)
     */
    public function removeEvenementId(ChildEvenement $evenement, $id)
    {
        if ($this->getEvenementIds()->contains($evenement, $id)) {
            $evenementHeeftOptie = new ChildEvenementHeeftOptie();
            $evenementHeeftOptie->setEvenement($evenement);
            if ($evenement->isOptieIdsLoaded()) {
                //remove the back reference if available
                $evenement->getOptieIds()->removeObject($this, $id);
            }

            $evenementHeeftOptie->setId($id);
            $evenementHeeftOptie->setOptie($this);
            $this->removeEvenementHeeftOptie(clone $evenementHeeftOptie);
            $evenementHeeftOptie->clear();

            $this->combinationCollEvenementIds->remove($this->combinationCollEvenementIds->search($evenement, $id));

            if (null === $this->combinationCollEvenementIdsScheduledForDeletion) {
                $this->combinationCollEvenementIdsScheduledForDeletion = clone $this->combinationCollEvenementIds;
                $this->combinationCollEvenementIdsScheduledForDeletion->clear();
            }

            $this->combinationCollEvenementIdsScheduledForDeletion->push($evenement, $id);
        }


        return $this;
    }

    /**
     * Clears out the collInschrijvingIds collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addInschrijvingIds()
     */
    public function clearInschrijvingIds()
    {
        $this->collInschrijvingIds = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the combinationCollInschrijvingIds crossRef collection.
     *
     * By default this just sets the combinationCollInschrijvingIds collection to an empty collection (like clearInschrijvingIds());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initInschrijvingIds()
    {
        $this->combinationCollInschrijvingIds = new ObjectCombinationCollection;
        $this->combinationCollInschrijvingIdsPartial = true;
    }

    /**
     * Checks if the combinationCollInschrijvingIds collection is loaded.
     *
     * @return bool
     */
    public function isInschrijvingIdsLoaded()
    {
        return null !== $this->combinationCollInschrijvingIds;
    }

    /**
     * Returns a new query object pre configured with filters from current object and given arguments to query the database.
     *
     * @param int $id
     * @param Criteria $criteria
     *
     * @return ChildInschrijvingQuery
     */
    public function createInschrijvingsQuery($id = null, Criteria $criteria = null)
    {
        $criteria = ChildInschrijvingQuery::create($criteria)
            ->filterByOptie($this);

        $inschrijvingHeeftOptieQuery = $criteria->useInschrijvingHeeftOptieQuery();

        if (null !== $id) {
            $inschrijvingHeeftOptieQuery->filterById($id);
        }

        $inschrijvingHeeftOptieQuery->endUse();

        return $criteria;
    }

    /**
     * Gets a combined collection of ChildInschrijving objects related by a many-to-many relationship
     * to the current object by way of the fb_inschrijving_heeft_optie cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildOptie is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCombinationCollection Combination list of ChildInschrijving objects
     */
    public function getInschrijvingIds($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->combinationCollInschrijvingIdsPartial && !$this->isNew();
        if (null === $this->combinationCollInschrijvingIds || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->combinationCollInschrijvingIds) {
                    $this->initInschrijvingIds();
                }
            } else {

                $query = ChildInschrijvingHeeftOptieQuery::create(null, $criteria)
                    ->filterByOptie($this)
                    ->joinInschrijving()
                ;

                $items = $query->find($con);
                $combinationCollInschrijvingIds = new ObjectCombinationCollection();
                foreach ($items as $item) {
                    $combination = [];

                    $combination[] = $item->getInschrijving();
                    $combination[] = $item->getId();
                    $combinationCollInschrijvingIds[] = $combination;
                }

                if (null !== $criteria) {
                    return $combinationCollInschrijvingIds;
                }

                if ($partial && $this->combinationCollInschrijvingIds) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->combinationCollInschrijvingIds as $obj) {
                        if (!call_user_func_array([$combinationCollInschrijvingIds, 'contains'], $obj)) {
                            $combinationCollInschrijvingIds[] = $obj;
                        }
                    }
                }

                $this->combinationCollInschrijvingIds = $combinationCollInschrijvingIds;
                $this->combinationCollInschrijvingIdsPartial = false;
            }
        }

        return $this->combinationCollInschrijvingIds;
    }

    /**
     * Returns a not cached ObjectCollection of ChildInschrijving objects. This will hit always the databases.
     * If you have attached new ChildInschrijving object to this object you need to call `save` first to get
     * the correct return value. Use getInschrijvingIds() to get the current internal state.
     *
     * @param int $id
     * @param Criteria $criteria
     * @param ConnectionInterface $con
     *
     * @return ChildInschrijving[]|ObjectCollection
     */
    public function getInschrijvings($id = null, Criteria $criteria = null, ConnectionInterface $con = null)
    {
        return $this->createInschrijvingsQuery($id, $criteria)->find($con);
    }

    /**
     * Sets a collection of ChildInschrijving objects related by a many-to-many relationship
     * to the current object by way of the fb_inschrijving_heeft_optie cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $inschrijvingIds A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildOptie The current object (for fluent API support)
     */
    public function setInschrijvingIds(Collection $inschrijvingIds, ConnectionInterface $con = null)
    {
        $this->clearInschrijvingIds();
        $currentInschrijvingIds = $this->getInschrijvingIds();

        $combinationCollInschrijvingIdsScheduledForDeletion = $currentInschrijvingIds->diff($inschrijvingIds);

        foreach ($combinationCollInschrijvingIdsScheduledForDeletion as $toDelete) {
            call_user_func_array([$this, 'removeInschrijvingId'], $toDelete);
        }

        foreach ($inschrijvingIds as $inschrijvingId) {
            if (!call_user_func_array([$currentInschrijvingIds, 'contains'], $inschrijvingId)) {
                call_user_func_array([$this, 'doAddInschrijvingId'], $inschrijvingId);
            }
        }

        $this->combinationCollInschrijvingIdsPartial = false;
        $this->combinationCollInschrijvingIds = $inschrijvingIds;

        return $this;
    }

    /**
     * Gets the number of ChildInschrijving objects related by a many-to-many relationship
     * to the current object by way of the fb_inschrijving_heeft_optie cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related ChildInschrijving objects
     */
    public function countInschrijvingIds(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->combinationCollInschrijvingIdsPartial && !$this->isNew();
        if (null === $this->combinationCollInschrijvingIds || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->combinationCollInschrijvingIds) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getInschrijvingIds());
                }

                $query = ChildInschrijvingHeeftOptieQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByOptie($this)
                    ->count($con);
            }
        } else {
            return count($this->combinationCollInschrijvingIds);
        }
    }

    /**
     * Returns the not cached count of ChildInschrijving objects. This will hit always the databases.
     * If you have attached new ChildInschrijving object to this object you need to call `save` first to get
     * the correct return value. Use getInschrijvingIds() to get the current internal state.
     *
     * @param int $id
     * @param Criteria $criteria
     * @param ConnectionInterface $con
     *
     * @return integer
     */
    public function countInschrijvings($id = null, Criteria $criteria = null, ConnectionInterface $con = null)
    {
        return $this->createInschrijvingsQuery($id, $criteria)->count($con);
    }

    /**
     * Associate a ChildInschrijving to this object
     * through the fb_inschrijving_heeft_optie cross reference table.
     *
     * @param ChildInschrijving $inschrijving,
     * @param int $id
     * @return ChildOptie The current object (for fluent API support)
     */
    public function addInschrijving(ChildInschrijving $inschrijving, $id)
    {
        if ($this->combinationCollInschrijvingIds === null) {
            $this->initInschrijvingIds();
        }

        if (!$this->getInschrijvingIds()->contains($inschrijving, $id)) {
            // only add it if the **same** object is not already associated
            $this->combinationCollInschrijvingIds->push($inschrijving, $id);
            $this->doAddInschrijvingId($inschrijving, $id);
        }

        return $this;
    }

    /**
     *
     * @param ChildInschrijving $inschrijving,
     * @param int $id
     */
    protected function doAddInschrijvingId(ChildInschrijving $inschrijving, $id)
    {
        $inschrijvingHeeftOptie = new ChildInschrijvingHeeftOptie();

        $inschrijvingHeeftOptie->setInschrijving($inschrijving);
        $inschrijvingHeeftOptie->setId($id);


        $inschrijvingHeeftOptie->setOptie($this);

        $this->addInschrijvingHeeftOptie($inschrijvingHeeftOptie);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if ($inschrijving->isOptieIdsLoaded()) {
            $inschrijving->initOptieIds();
            $inschrijving->getOptieIds()->push($this, $id);
        } elseif (!$inschrijving->getOptieIds()->contains($this, $id)) {
            $inschrijving->getOptieIds()->push($this, $id);
        }

    }

    /**
     * Remove inschrijving, id of this object
     * through the fb_inschrijving_heeft_optie cross reference table.
     *
     * @param ChildInschrijving $inschrijving,
     * @param int $id
     * @return ChildOptie The current object (for fluent API support)
     */
    public function removeInschrijvingId(ChildInschrijving $inschrijving, $id)
    {
        if ($this->getInschrijvingIds()->contains($inschrijving, $id)) {
            $inschrijvingHeeftOptie = new ChildInschrijvingHeeftOptie();
            $inschrijvingHeeftOptie->setInschrijving($inschrijving);
            if ($inschrijving->isOptieIdsLoaded()) {
                //remove the back reference if available
                $inschrijving->getOptieIds()->removeObject($this, $id);
            }

            $inschrijvingHeeftOptie->setId($id);
            $inschrijvingHeeftOptie->setOptie($this);
            $this->removeInschrijvingHeeftOptie(clone $inschrijvingHeeftOptie);
            $inschrijvingHeeftOptie->clear();

            $this->combinationCollInschrijvingIds->remove($this->combinationCollInschrijvingIds->search($inschrijving, $id));

            if (null === $this->combinationCollInschrijvingIdsScheduledForDeletion) {
                $this->combinationCollInschrijvingIdsScheduledForDeletion = clone $this->combinationCollInschrijvingIds;
                $this->combinationCollInschrijvingIdsScheduledForDeletion->clear();
            }

            $this->combinationCollInschrijvingIdsScheduledForDeletion->push($inschrijving, $id);
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
        if (null !== $this->aType) {
            $this->aType->removeOptie($this);
        }
        $this->id = null;
        $this->per_deelnemer = null;
        $this->naam = null;
        $this->tekst_voor = null;
        $this->tekst_achter = null;
        $this->tooltip_tekst = null;
        $this->heeft_hor_lijn = null;
        $this->optietype = null;
        $this->groep = null;
        $this->label = null;
        $this->is_default = null;
        $this->later_wijzigen = null;
        $this->totaal_aantal = null;
        $this->prijs = null;
        $this->status = null;
        $this->intern_gebruik = null;
        $this->gemaakt_datum = null;
        $this->gemaakt_door = null;
        $this->gewijzigd_datum = null;
        $this->gewijzigd_door = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
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
            if ($this->collEvenementHeeftOpties) {
                foreach ($this->collEvenementHeeftOpties as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collInschrijvingHeeftOpties) {
                foreach ($this->collInschrijvingHeeftOpties as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->combinationCollDeelnemerIds) {
                foreach ($this->combinationCollDeelnemerIds as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->combinationCollEvenementIds) {
                foreach ($this->combinationCollEvenementIds as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->combinationCollInschrijvingIds) {
                foreach ($this->combinationCollInschrijvingIds as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collDeelnemerHeeftOpties = null;
        $this->collEvenementHeeftOpties = null;
        $this->collInschrijvingHeeftOpties = null;
        $this->combinationCollDeelnemerIds = null;
        $this->combinationCollEvenementIds = null;
        $this->combinationCollInschrijvingIds = null;
        $this->aType = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(OptieTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildOptie The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[OptieTableMap::COL_GEWIJZIGD_DATUM] = true;

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
