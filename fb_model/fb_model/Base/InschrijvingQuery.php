<?php

namespace fb_model\fb_model\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use fb_model\fb_model\Inschrijving as ChildInschrijving;
use fb_model\fb_model\InschrijvingQuery as ChildInschrijvingQuery;
use fb_model\fb_model\Map\InschrijvingTableMap;

/**
 * Base class that represents a query for the 'fb_inschrijving' table.
 *
 *
 *
 * @method     ChildInschrijvingQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildInschrijvingQuery orderByEvenementId($order = Criteria::ASC) Order by the evenement_id column
 * @method     ChildInschrijvingQuery orderByContactPersoonId($order = Criteria::ASC) Order by the contactpersoon_id column
 * @method     ChildInschrijvingQuery orderByDatumInschrijving($order = Criteria::ASC) Order by the datum_inschrijving column
 * @method     ChildInschrijvingQuery orderByAnnuleringsverzekeringAfgesloten($order = Criteria::ASC) Order by the annuleringsverzekering_afgesloten column
 * @method     ChildInschrijvingQuery orderByTotaalbedrag($order = Criteria::ASC) Order by the totaalbedrag column
 * @method     ChildInschrijvingQuery orderByReedsBetaald($order = Criteria::ASC) Order by the reeds_betaald column
 * @method     ChildInschrijvingQuery orderByNogTeBetalen($order = Criteria::ASC) Order by the nog_te_betalen column
 * @method     ChildInschrijvingQuery orderByKorting($order = Criteria::ASC) Order by the korting column
 * @method     ChildInschrijvingQuery orderByBetaaldPerVoucher($order = Criteria::ASC) Order by the betaald_per_voucher column
 * @method     ChildInschrijvingQuery orderByVoucherId($order = Criteria::ASC) Order by the voucher_id column
 * @method     ChildInschrijvingQuery orderByBetaalwijze($order = Criteria::ASC) Order by the betaalwijze column
 * @method     ChildInschrijvingQuery orderByAnnuleringsverzekering($order = Criteria::ASC) Order by the annuleringsverzekering column
 * @method     ChildInschrijvingQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildInschrijvingQuery orderByDatumGemaakt($order = Criteria::ASC) Order by the gemaakt_datum column
 * @method     ChildInschrijvingQuery orderByGemaaktDoor($order = Criteria::ASC) Order by the gemaakt_door column
 * @method     ChildInschrijvingQuery orderByDatumGewijzigd($order = Criteria::ASC) Order by the gewijzigd_datum column
 * @method     ChildInschrijvingQuery orderByGewijzigdDoor($order = Criteria::ASC) Order by the gewijzigd_door column
 *
 * @method     ChildInschrijvingQuery groupById() Group by the id column
 * @method     ChildInschrijvingQuery groupByEvenementId() Group by the evenement_id column
 * @method     ChildInschrijvingQuery groupByContactPersoonId() Group by the contactpersoon_id column
 * @method     ChildInschrijvingQuery groupByDatumInschrijving() Group by the datum_inschrijving column
 * @method     ChildInschrijvingQuery groupByAnnuleringsverzekeringAfgesloten() Group by the annuleringsverzekering_afgesloten column
 * @method     ChildInschrijvingQuery groupByTotaalbedrag() Group by the totaalbedrag column
 * @method     ChildInschrijvingQuery groupByReedsBetaald() Group by the reeds_betaald column
 * @method     ChildInschrijvingQuery groupByNogTeBetalen() Group by the nog_te_betalen column
 * @method     ChildInschrijvingQuery groupByKorting() Group by the korting column
 * @method     ChildInschrijvingQuery groupByBetaaldPerVoucher() Group by the betaald_per_voucher column
 * @method     ChildInschrijvingQuery groupByVoucherId() Group by the voucher_id column
 * @method     ChildInschrijvingQuery groupByBetaalwijze() Group by the betaalwijze column
 * @method     ChildInschrijvingQuery groupByAnnuleringsverzekering() Group by the annuleringsverzekering column
 * @method     ChildInschrijvingQuery groupByStatus() Group by the status column
 * @method     ChildInschrijvingQuery groupByDatumGemaakt() Group by the gemaakt_datum column
 * @method     ChildInschrijvingQuery groupByGemaaktDoor() Group by the gemaakt_door column
 * @method     ChildInschrijvingQuery groupByDatumGewijzigd() Group by the gewijzigd_datum column
 * @method     ChildInschrijvingQuery groupByGewijzigdDoor() Group by the gewijzigd_door column
 *
 * @method     ChildInschrijvingQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildInschrijvingQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildInschrijvingQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildInschrijvingQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildInschrijvingQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildInschrijvingQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildInschrijvingQuery leftJoinEvenement($relationAlias = null) Adds a LEFT JOIN clause to the query using the Evenement relation
 * @method     ChildInschrijvingQuery rightJoinEvenement($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Evenement relation
 * @method     ChildInschrijvingQuery innerJoinEvenement($relationAlias = null) Adds a INNER JOIN clause to the query using the Evenement relation
 *
 * @method     ChildInschrijvingQuery joinWithEvenement($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Evenement relation
 *
 * @method     ChildInschrijvingQuery leftJoinWithEvenement() Adds a LEFT JOIN clause and with to the query using the Evenement relation
 * @method     ChildInschrijvingQuery rightJoinWithEvenement() Adds a RIGHT JOIN clause and with to the query using the Evenement relation
 * @method     ChildInschrijvingQuery innerJoinWithEvenement() Adds a INNER JOIN clause and with to the query using the Evenement relation
 *
 * @method     ChildInschrijvingQuery leftJoinKeuzes($relationAlias = null) Adds a LEFT JOIN clause to the query using the Keuzes relation
 * @method     ChildInschrijvingQuery rightJoinKeuzes($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Keuzes relation
 * @method     ChildInschrijvingQuery innerJoinKeuzes($relationAlias = null) Adds a INNER JOIN clause to the query using the Keuzes relation
 *
 * @method     ChildInschrijvingQuery joinWithKeuzes($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Keuzes relation
 *
 * @method     ChildInschrijvingQuery leftJoinWithKeuzes() Adds a LEFT JOIN clause and with to the query using the Keuzes relation
 * @method     ChildInschrijvingQuery rightJoinWithKeuzes() Adds a RIGHT JOIN clause and with to the query using the Keuzes relation
 * @method     ChildInschrijvingQuery innerJoinWithKeuzes() Adds a INNER JOIN clause and with to the query using the Keuzes relation
 *
 * @method     ChildInschrijvingQuery leftJoinVoucher($relationAlias = null) Adds a LEFT JOIN clause to the query using the Voucher relation
 * @method     ChildInschrijvingQuery rightJoinVoucher($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Voucher relation
 * @method     ChildInschrijvingQuery innerJoinVoucher($relationAlias = null) Adds a INNER JOIN clause to the query using the Voucher relation
 *
 * @method     ChildInschrijvingQuery joinWithVoucher($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Voucher relation
 *
 * @method     ChildInschrijvingQuery leftJoinWithVoucher() Adds a LEFT JOIN clause and with to the query using the Voucher relation
 * @method     ChildInschrijvingQuery rightJoinWithVoucher() Adds a RIGHT JOIN clause and with to the query using the Voucher relation
 * @method     ChildInschrijvingQuery innerJoinWithVoucher() Adds a INNER JOIN clause and with to the query using the Voucher relation
 *
 * @method     ChildInschrijvingQuery leftJoinPersoon($relationAlias = null) Adds a LEFT JOIN clause to the query using the Persoon relation
 * @method     ChildInschrijvingQuery rightJoinPersoon($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Persoon relation
 * @method     ChildInschrijvingQuery innerJoinPersoon($relationAlias = null) Adds a INNER JOIN clause to the query using the Persoon relation
 *
 * @method     ChildInschrijvingQuery joinWithPersoon($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Persoon relation
 *
 * @method     ChildInschrijvingQuery leftJoinWithPersoon() Adds a LEFT JOIN clause and with to the query using the Persoon relation
 * @method     ChildInschrijvingQuery rightJoinWithPersoon() Adds a RIGHT JOIN clause and with to the query using the Persoon relation
 * @method     ChildInschrijvingQuery innerJoinWithPersoon() Adds a INNER JOIN clause and with to the query using the Persoon relation
 *
 * @method     ChildInschrijvingQuery leftJoinDeelnemer($relationAlias = null) Adds a LEFT JOIN clause to the query using the Deelnemer relation
 * @method     ChildInschrijvingQuery rightJoinDeelnemer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Deelnemer relation
 * @method     ChildInschrijvingQuery innerJoinDeelnemer($relationAlias = null) Adds a INNER JOIN clause to the query using the Deelnemer relation
 *
 * @method     ChildInschrijvingQuery joinWithDeelnemer($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Deelnemer relation
 *
 * @method     ChildInschrijvingQuery leftJoinWithDeelnemer() Adds a LEFT JOIN clause and with to the query using the Deelnemer relation
 * @method     ChildInschrijvingQuery rightJoinWithDeelnemer() Adds a RIGHT JOIN clause and with to the query using the Deelnemer relation
 * @method     ChildInschrijvingQuery innerJoinWithDeelnemer() Adds a INNER JOIN clause and with to the query using the Deelnemer relation
 *
 * @method     ChildInschrijvingQuery leftJoinFactuurNummer($relationAlias = null) Adds a LEFT JOIN clause to the query using the FactuurNummer relation
 * @method     ChildInschrijvingQuery rightJoinFactuurNummer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FactuurNummer relation
 * @method     ChildInschrijvingQuery innerJoinFactuurNummer($relationAlias = null) Adds a INNER JOIN clause to the query using the FactuurNummer relation
 *
 * @method     ChildInschrijvingQuery joinWithFactuurNummer($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the FactuurNummer relation
 *
 * @method     ChildInschrijvingQuery leftJoinWithFactuurNummer() Adds a LEFT JOIN clause and with to the query using the FactuurNummer relation
 * @method     ChildInschrijvingQuery rightJoinWithFactuurNummer() Adds a RIGHT JOIN clause and with to the query using the FactuurNummer relation
 * @method     ChildInschrijvingQuery innerJoinWithFactuurNummer() Adds a INNER JOIN clause and with to the query using the FactuurNummer relation
 *
 * @method     ChildInschrijvingQuery leftJoinInschrijvingHeeftOptie($relationAlias = null) Adds a LEFT JOIN clause to the query using the InschrijvingHeeftOptie relation
 * @method     ChildInschrijvingQuery rightJoinInschrijvingHeeftOptie($relationAlias = null) Adds a RIGHT JOIN clause to the query using the InschrijvingHeeftOptie relation
 * @method     ChildInschrijvingQuery innerJoinInschrijvingHeeftOptie($relationAlias = null) Adds a INNER JOIN clause to the query using the InschrijvingHeeftOptie relation
 *
 * @method     ChildInschrijvingQuery joinWithInschrijvingHeeftOptie($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the InschrijvingHeeftOptie relation
 *
 * @method     ChildInschrijvingQuery leftJoinWithInschrijvingHeeftOptie() Adds a LEFT JOIN clause and with to the query using the InschrijvingHeeftOptie relation
 * @method     ChildInschrijvingQuery rightJoinWithInschrijvingHeeftOptie() Adds a RIGHT JOIN clause and with to the query using the InschrijvingHeeftOptie relation
 * @method     ChildInschrijvingQuery innerJoinWithInschrijvingHeeftOptie() Adds a INNER JOIN clause and with to the query using the InschrijvingHeeftOptie relation
 *
 * @method     \fb_model\fb_model\EvenementQuery|\fb_model\fb_model\KeuzesQuery|\fb_model\fb_model\VoucherQuery|\fb_model\fb_model\PersoonQuery|\fb_model\fb_model\DeelnemerQuery|\fb_model\fb_model\FactuurNummerQuery|\fb_model\fb_model\InschrijvingHeeftOptieQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildInschrijving findOne(ConnectionInterface $con = null) Return the first ChildInschrijving matching the query
 * @method     ChildInschrijving findOneOrCreate(ConnectionInterface $con = null) Return the first ChildInschrijving matching the query, or a new ChildInschrijving object populated from the query conditions when no match is found
 *
 * @method     ChildInschrijving findOneById(int $id) Return the first ChildInschrijving filtered by the id column
 * @method     ChildInschrijving findOneByEvenementId(int $evenement_id) Return the first ChildInschrijving filtered by the evenement_id column
 * @method     ChildInschrijving findOneByContactPersoonId(int $contactpersoon_id) Return the first ChildInschrijving filtered by the contactpersoon_id column
 * @method     ChildInschrijving findOneByDatumInschrijving(string $datum_inschrijving) Return the first ChildInschrijving filtered by the datum_inschrijving column
 * @method     ChildInschrijving findOneByAnnuleringsverzekeringAfgesloten(string $annuleringsverzekering_afgesloten) Return the first ChildInschrijving filtered by the annuleringsverzekering_afgesloten column
 * @method     ChildInschrijving findOneByTotaalbedrag(string $totaalbedrag) Return the first ChildInschrijving filtered by the totaalbedrag column
 * @method     ChildInschrijving findOneByReedsBetaald(string $reeds_betaald) Return the first ChildInschrijving filtered by the reeds_betaald column
 * @method     ChildInschrijving findOneByNogTeBetalen(string $nog_te_betalen) Return the first ChildInschrijving filtered by the nog_te_betalen column
 * @method     ChildInschrijving findOneByKorting(string $korting) Return the first ChildInschrijving filtered by the korting column
 * @method     ChildInschrijving findOneByBetaaldPerVoucher(string $betaald_per_voucher) Return the first ChildInschrijving filtered by the betaald_per_voucher column
 * @method     ChildInschrijving findOneByVoucherId(int $voucher_id) Return the first ChildInschrijving filtered by the voucher_id column
 * @method     ChildInschrijving findOneByBetaalwijze(int $betaalwijze) Return the first ChildInschrijving filtered by the betaalwijze column
 * @method     ChildInschrijving findOneByAnnuleringsverzekering(int $annuleringsverzekering) Return the first ChildInschrijving filtered by the annuleringsverzekering column
 * @method     ChildInschrijving findOneByStatus(int $status) Return the first ChildInschrijving filtered by the status column
 * @method     ChildInschrijving findOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildInschrijving filtered by the gemaakt_datum column
 * @method     ChildInschrijving findOneByGemaaktDoor(string $gemaakt_door) Return the first ChildInschrijving filtered by the gemaakt_door column
 * @method     ChildInschrijving findOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildInschrijving filtered by the gewijzigd_datum column
 * @method     ChildInschrijving findOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildInschrijving filtered by the gewijzigd_door column *

 * @method     ChildInschrijving requirePk($key, ConnectionInterface $con = null) Return the ChildInschrijving by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijving requireOne(ConnectionInterface $con = null) Return the first ChildInschrijving matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInschrijving requireOneById(int $id) Return the first ChildInschrijving filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijving requireOneByEvenementId(int $evenement_id) Return the first ChildInschrijving filtered by the evenement_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijving requireOneByContactPersoonId(int $contactpersoon_id) Return the first ChildInschrijving filtered by the contactpersoon_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijving requireOneByDatumInschrijving(string $datum_inschrijving) Return the first ChildInschrijving filtered by the datum_inschrijving column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijving requireOneByAnnuleringsverzekeringAfgesloten(string $annuleringsverzekering_afgesloten) Return the first ChildInschrijving filtered by the annuleringsverzekering_afgesloten column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijving requireOneByTotaalbedrag(string $totaalbedrag) Return the first ChildInschrijving filtered by the totaalbedrag column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijving requireOneByReedsBetaald(string $reeds_betaald) Return the first ChildInschrijving filtered by the reeds_betaald column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijving requireOneByNogTeBetalen(string $nog_te_betalen) Return the first ChildInschrijving filtered by the nog_te_betalen column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijving requireOneByKorting(string $korting) Return the first ChildInschrijving filtered by the korting column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijving requireOneByBetaaldPerVoucher(string $betaald_per_voucher) Return the first ChildInschrijving filtered by the betaald_per_voucher column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijving requireOneByVoucherId(int $voucher_id) Return the first ChildInschrijving filtered by the voucher_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijving requireOneByBetaalwijze(int $betaalwijze) Return the first ChildInschrijving filtered by the betaalwijze column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijving requireOneByAnnuleringsverzekering(int $annuleringsverzekering) Return the first ChildInschrijving filtered by the annuleringsverzekering column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijving requireOneByStatus(int $status) Return the first ChildInschrijving filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijving requireOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildInschrijving filtered by the gemaakt_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijving requireOneByGemaaktDoor(string $gemaakt_door) Return the first ChildInschrijving filtered by the gemaakt_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijving requireOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildInschrijving filtered by the gewijzigd_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInschrijving requireOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildInschrijving filtered by the gewijzigd_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInschrijving[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildInschrijving objects based on current ModelCriteria
 * @method     ChildInschrijving[]|ObjectCollection findById(int $id) Return ChildInschrijving objects filtered by the id column
 * @method     ChildInschrijving[]|ObjectCollection findByEvenementId(int $evenement_id) Return ChildInschrijving objects filtered by the evenement_id column
 * @method     ChildInschrijving[]|ObjectCollection findByContactPersoonId(int $contactpersoon_id) Return ChildInschrijving objects filtered by the contactpersoon_id column
 * @method     ChildInschrijving[]|ObjectCollection findByDatumInschrijving(string $datum_inschrijving) Return ChildInschrijving objects filtered by the datum_inschrijving column
 * @method     ChildInschrijving[]|ObjectCollection findByAnnuleringsverzekeringAfgesloten(string $annuleringsverzekering_afgesloten) Return ChildInschrijving objects filtered by the annuleringsverzekering_afgesloten column
 * @method     ChildInschrijving[]|ObjectCollection findByTotaalbedrag(string $totaalbedrag) Return ChildInschrijving objects filtered by the totaalbedrag column
 * @method     ChildInschrijving[]|ObjectCollection findByReedsBetaald(string $reeds_betaald) Return ChildInschrijving objects filtered by the reeds_betaald column
 * @method     ChildInschrijving[]|ObjectCollection findByNogTeBetalen(string $nog_te_betalen) Return ChildInschrijving objects filtered by the nog_te_betalen column
 * @method     ChildInschrijving[]|ObjectCollection findByKorting(string $korting) Return ChildInschrijving objects filtered by the korting column
 * @method     ChildInschrijving[]|ObjectCollection findByBetaaldPerVoucher(string $betaald_per_voucher) Return ChildInschrijving objects filtered by the betaald_per_voucher column
 * @method     ChildInschrijving[]|ObjectCollection findByVoucherId(int $voucher_id) Return ChildInschrijving objects filtered by the voucher_id column
 * @method     ChildInschrijving[]|ObjectCollection findByBetaalwijze(int $betaalwijze) Return ChildInschrijving objects filtered by the betaalwijze column
 * @method     ChildInschrijving[]|ObjectCollection findByAnnuleringsverzekering(int $annuleringsverzekering) Return ChildInschrijving objects filtered by the annuleringsverzekering column
 * @method     ChildInschrijving[]|ObjectCollection findByStatus(int $status) Return ChildInschrijving objects filtered by the status column
 * @method     ChildInschrijving[]|ObjectCollection findByDatumGemaakt(string $gemaakt_datum) Return ChildInschrijving objects filtered by the gemaakt_datum column
 * @method     ChildInschrijving[]|ObjectCollection findByGemaaktDoor(string $gemaakt_door) Return ChildInschrijving objects filtered by the gemaakt_door column
 * @method     ChildInschrijving[]|ObjectCollection findByDatumGewijzigd(string $gewijzigd_datum) Return ChildInschrijving objects filtered by the gewijzigd_datum column
 * @method     ChildInschrijving[]|ObjectCollection findByGewijzigdDoor(string $gewijzigd_door) Return ChildInschrijving objects filtered by the gewijzigd_door column
 * @method     ChildInschrijving[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class InschrijvingQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \fb_model\fb_model\Base\InschrijvingQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\fb_model\\fb_model\\Inschrijving', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildInschrijvingQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildInschrijvingQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildInschrijvingQuery) {
            return $criteria;
        }
        $query = new ChildInschrijvingQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildInschrijving|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(InschrijvingTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = InschrijvingTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildInschrijving A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, evenement_id, contactpersoon_id, datum_inschrijving, annuleringsverzekering_afgesloten, totaalbedrag, reeds_betaald, nog_te_betalen, korting, betaald_per_voucher, voucher_id, betaalwijze, annuleringsverzekering, status, gemaakt_datum, gemaakt_door, gewijzigd_datum, gewijzigd_door FROM fb_inschrijving WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildInschrijving $obj */
            $obj = new ChildInschrijving();
            $obj->hydrate($row);
            InschrijvingTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildInschrijving|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(InschrijvingTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(InschrijvingTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the evenement_id column
     *
     * Example usage:
     * <code>
     * $query->filterByEvenementId(1234); // WHERE evenement_id = 1234
     * $query->filterByEvenementId(array(12, 34)); // WHERE evenement_id IN (12, 34)
     * $query->filterByEvenementId(array('min' => 12)); // WHERE evenement_id > 12
     * </code>
     *
     * @see       filterByEvenement()
     *
     * @param     mixed $evenementId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByEvenementId($evenementId = null, $comparison = null)
    {
        if (is_array($evenementId)) {
            $useMinMax = false;
            if (isset($evenementId['min'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_EVENEMENT_ID, $evenementId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($evenementId['max'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_EVENEMENT_ID, $evenementId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingTableMap::COL_EVENEMENT_ID, $evenementId, $comparison);
    }

    /**
     * Filter the query on the contactpersoon_id column
     *
     * Example usage:
     * <code>
     * $query->filterByContactPersoonId(1234); // WHERE contactpersoon_id = 1234
     * $query->filterByContactPersoonId(array(12, 34)); // WHERE contactpersoon_id IN (12, 34)
     * $query->filterByContactPersoonId(array('min' => 12)); // WHERE contactpersoon_id > 12
     * </code>
     *
     * @see       filterByPersoon()
     *
     * @param     mixed $contactPersoonId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByContactPersoonId($contactPersoonId = null, $comparison = null)
    {
        if (is_array($contactPersoonId)) {
            $useMinMax = false;
            if (isset($contactPersoonId['min'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_CONTACTPERSOON_ID, $contactPersoonId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($contactPersoonId['max'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_CONTACTPERSOON_ID, $contactPersoonId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingTableMap::COL_CONTACTPERSOON_ID, $contactPersoonId, $comparison);
    }

    /**
     * Filter the query on the datum_inschrijving column
     *
     * Example usage:
     * <code>
     * $query->filterByDatumInschrijving('2011-03-14'); // WHERE datum_inschrijving = '2011-03-14'
     * $query->filterByDatumInschrijving('now'); // WHERE datum_inschrijving = '2011-03-14'
     * $query->filterByDatumInschrijving(array('max' => 'yesterday')); // WHERE datum_inschrijving > '2011-03-13'
     * </code>
     *
     * @param     mixed $datumInschrijving The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByDatumInschrijving($datumInschrijving = null, $comparison = null)
    {
        if (is_array($datumInschrijving)) {
            $useMinMax = false;
            if (isset($datumInschrijving['min'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_DATUM_INSCHRIJVING, $datumInschrijving['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumInschrijving['max'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_DATUM_INSCHRIJVING, $datumInschrijving['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingTableMap::COL_DATUM_INSCHRIJVING, $datumInschrijving, $comparison);
    }

    /**
     * Filter the query on the annuleringsverzekering_afgesloten column
     *
     * Example usage:
     * <code>
     * $query->filterByAnnuleringsverzekeringAfgesloten('2011-03-14'); // WHERE annuleringsverzekering_afgesloten = '2011-03-14'
     * $query->filterByAnnuleringsverzekeringAfgesloten('now'); // WHERE annuleringsverzekering_afgesloten = '2011-03-14'
     * $query->filterByAnnuleringsverzekeringAfgesloten(array('max' => 'yesterday')); // WHERE annuleringsverzekering_afgesloten > '2011-03-13'
     * </code>
     *
     * @param     mixed $annuleringsverzekeringAfgesloten The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByAnnuleringsverzekeringAfgesloten($annuleringsverzekeringAfgesloten = null, $comparison = null)
    {
        if (is_array($annuleringsverzekeringAfgesloten)) {
            $useMinMax = false;
            if (isset($annuleringsverzekeringAfgesloten['min'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_ANNULERINGSVERZEKERING_AFGESLOTEN, $annuleringsverzekeringAfgesloten['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($annuleringsverzekeringAfgesloten['max'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_ANNULERINGSVERZEKERING_AFGESLOTEN, $annuleringsverzekeringAfgesloten['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingTableMap::COL_ANNULERINGSVERZEKERING_AFGESLOTEN, $annuleringsverzekeringAfgesloten, $comparison);
    }

    /**
     * Filter the query on the totaalbedrag column
     *
     * Example usage:
     * <code>
     * $query->filterByTotaalbedrag(1234); // WHERE totaalbedrag = 1234
     * $query->filterByTotaalbedrag(array(12, 34)); // WHERE totaalbedrag IN (12, 34)
     * $query->filterByTotaalbedrag(array('min' => 12)); // WHERE totaalbedrag > 12
     * </code>
     *
     * @param     mixed $totaalbedrag The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByTotaalbedrag($totaalbedrag = null, $comparison = null)
    {
        if (is_array($totaalbedrag)) {
            $useMinMax = false;
            if (isset($totaalbedrag['min'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_TOTAALBEDRAG, $totaalbedrag['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($totaalbedrag['max'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_TOTAALBEDRAG, $totaalbedrag['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingTableMap::COL_TOTAALBEDRAG, $totaalbedrag, $comparison);
    }

    /**
     * Filter the query on the reeds_betaald column
     *
     * Example usage:
     * <code>
     * $query->filterByReedsBetaald(1234); // WHERE reeds_betaald = 1234
     * $query->filterByReedsBetaald(array(12, 34)); // WHERE reeds_betaald IN (12, 34)
     * $query->filterByReedsBetaald(array('min' => 12)); // WHERE reeds_betaald > 12
     * </code>
     *
     * @param     mixed $reedsBetaald The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByReedsBetaald($reedsBetaald = null, $comparison = null)
    {
        if (is_array($reedsBetaald)) {
            $useMinMax = false;
            if (isset($reedsBetaald['min'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_REEDS_BETAALD, $reedsBetaald['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($reedsBetaald['max'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_REEDS_BETAALD, $reedsBetaald['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingTableMap::COL_REEDS_BETAALD, $reedsBetaald, $comparison);
    }

    /**
     * Filter the query on the nog_te_betalen column
     *
     * Example usage:
     * <code>
     * $query->filterByNogTeBetalen(1234); // WHERE nog_te_betalen = 1234
     * $query->filterByNogTeBetalen(array(12, 34)); // WHERE nog_te_betalen IN (12, 34)
     * $query->filterByNogTeBetalen(array('min' => 12)); // WHERE nog_te_betalen > 12
     * </code>
     *
     * @param     mixed $nogTeBetalen The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByNogTeBetalen($nogTeBetalen = null, $comparison = null)
    {
        if (is_array($nogTeBetalen)) {
            $useMinMax = false;
            if (isset($nogTeBetalen['min'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_NOG_TE_BETALEN, $nogTeBetalen['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($nogTeBetalen['max'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_NOG_TE_BETALEN, $nogTeBetalen['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingTableMap::COL_NOG_TE_BETALEN, $nogTeBetalen, $comparison);
    }

    /**
     * Filter the query on the korting column
     *
     * Example usage:
     * <code>
     * $query->filterByKorting(1234); // WHERE korting = 1234
     * $query->filterByKorting(array(12, 34)); // WHERE korting IN (12, 34)
     * $query->filterByKorting(array('min' => 12)); // WHERE korting > 12
     * </code>
     *
     * @param     mixed $korting The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByKorting($korting = null, $comparison = null)
    {
        if (is_array($korting)) {
            $useMinMax = false;
            if (isset($korting['min'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_KORTING, $korting['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($korting['max'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_KORTING, $korting['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingTableMap::COL_KORTING, $korting, $comparison);
    }

    /**
     * Filter the query on the betaald_per_voucher column
     *
     * Example usage:
     * <code>
     * $query->filterByBetaaldPerVoucher(1234); // WHERE betaald_per_voucher = 1234
     * $query->filterByBetaaldPerVoucher(array(12, 34)); // WHERE betaald_per_voucher IN (12, 34)
     * $query->filterByBetaaldPerVoucher(array('min' => 12)); // WHERE betaald_per_voucher > 12
     * </code>
     *
     * @param     mixed $betaaldPerVoucher The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByBetaaldPerVoucher($betaaldPerVoucher = null, $comparison = null)
    {
        if (is_array($betaaldPerVoucher)) {
            $useMinMax = false;
            if (isset($betaaldPerVoucher['min'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_BETAALD_PER_VOUCHER, $betaaldPerVoucher['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($betaaldPerVoucher['max'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_BETAALD_PER_VOUCHER, $betaaldPerVoucher['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingTableMap::COL_BETAALD_PER_VOUCHER, $betaaldPerVoucher, $comparison);
    }

    /**
     * Filter the query on the voucher_id column
     *
     * Example usage:
     * <code>
     * $query->filterByVoucherId(1234); // WHERE voucher_id = 1234
     * $query->filterByVoucherId(array(12, 34)); // WHERE voucher_id IN (12, 34)
     * $query->filterByVoucherId(array('min' => 12)); // WHERE voucher_id > 12
     * </code>
     *
     * @see       filterByVoucher()
     *
     * @param     mixed $voucherId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByVoucherId($voucherId = null, $comparison = null)
    {
        if (is_array($voucherId)) {
            $useMinMax = false;
            if (isset($voucherId['min'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_VOUCHER_ID, $voucherId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($voucherId['max'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_VOUCHER_ID, $voucherId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingTableMap::COL_VOUCHER_ID, $voucherId, $comparison);
    }

    /**
     * Filter the query on the betaalwijze column
     *
     * Example usage:
     * <code>
     * $query->filterByBetaalwijze(1234); // WHERE betaalwijze = 1234
     * $query->filterByBetaalwijze(array(12, 34)); // WHERE betaalwijze IN (12, 34)
     * $query->filterByBetaalwijze(array('min' => 12)); // WHERE betaalwijze > 12
     * </code>
     *
     * @param     mixed $betaalwijze The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByBetaalwijze($betaalwijze = null, $comparison = null)
    {
        if (is_array($betaalwijze)) {
            $useMinMax = false;
            if (isset($betaalwijze['min'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_BETAALWIJZE, $betaalwijze['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($betaalwijze['max'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_BETAALWIJZE, $betaalwijze['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingTableMap::COL_BETAALWIJZE, $betaalwijze, $comparison);
    }

    /**
     * Filter the query on the annuleringsverzekering column
     *
     * Example usage:
     * <code>
     * $query->filterByAnnuleringsverzekering(1234); // WHERE annuleringsverzekering = 1234
     * $query->filterByAnnuleringsverzekering(array(12, 34)); // WHERE annuleringsverzekering IN (12, 34)
     * $query->filterByAnnuleringsverzekering(array('min' => 12)); // WHERE annuleringsverzekering > 12
     * </code>
     *
     * @param     mixed $annuleringsverzekering The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByAnnuleringsverzekering($annuleringsverzekering = null, $comparison = null)
    {
        if (is_array($annuleringsverzekering)) {
            $useMinMax = false;
            if (isset($annuleringsverzekering['min'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_ANNULERINGSVERZEKERING, $annuleringsverzekering['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($annuleringsverzekering['max'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_ANNULERINGSVERZEKERING, $annuleringsverzekering['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingTableMap::COL_ANNULERINGSVERZEKERING, $annuleringsverzekering, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus(1234); // WHERE status = 1234
     * $query->filterByStatus(array(12, 34)); // WHERE status IN (12, 34)
     * $query->filterByStatus(array('min' => 12)); // WHERE status > 12
     * </code>
     *
     * @see       filterByKeuzes()
     *
     * @param     mixed $status The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (is_array($status)) {
            $useMinMax = false;
            if (isset($status['min'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_STATUS, $status['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($status['max'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_STATUS, $status['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the gemaakt_datum column
     *
     * Example usage:
     * <code>
     * $query->filterByDatumGemaakt('2011-03-14'); // WHERE gemaakt_datum = '2011-03-14'
     * $query->filterByDatumGemaakt('now'); // WHERE gemaakt_datum = '2011-03-14'
     * $query->filterByDatumGemaakt(array('max' => 'yesterday')); // WHERE gemaakt_datum > '2011-03-13'
     * </code>
     *
     * @param     mixed $datumGemaakt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByDatumGemaakt($datumGemaakt = null, $comparison = null)
    {
        if (is_array($datumGemaakt)) {
            $useMinMax = false;
            if (isset($datumGemaakt['min'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGemaakt['max'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingTableMap::COL_GEMAAKT_DATUM, $datumGemaakt, $comparison);
    }

    /**
     * Filter the query on the gemaakt_door column
     *
     * Example usage:
     * <code>
     * $query->filterByGemaaktDoor('fooValue');   // WHERE gemaakt_door = 'fooValue'
     * $query->filterByGemaaktDoor('%fooValue%', Criteria::LIKE); // WHERE gemaakt_door LIKE '%fooValue%'
     * </code>
     *
     * @param     string $gemaaktDoor The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByGemaaktDoor($gemaaktDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gemaaktDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingTableMap::COL_GEMAAKT_DOOR, $gemaaktDoor, $comparison);
    }

    /**
     * Filter the query on the gewijzigd_datum column
     *
     * Example usage:
     * <code>
     * $query->filterByDatumGewijzigd('2011-03-14'); // WHERE gewijzigd_datum = '2011-03-14'
     * $query->filterByDatumGewijzigd('now'); // WHERE gewijzigd_datum = '2011-03-14'
     * $query->filterByDatumGewijzigd(array('max' => 'yesterday')); // WHERE gewijzigd_datum > '2011-03-13'
     * </code>
     *
     * @param     mixed $datumGewijzigd The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByDatumGewijzigd($datumGewijzigd = null, $comparison = null)
    {
        if (is_array($datumGewijzigd)) {
            $useMinMax = false;
            if (isset($datumGewijzigd['min'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGewijzigd['max'])) {
                $this->addUsingAlias(InschrijvingTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd, $comparison);
    }

    /**
     * Filter the query on the gewijzigd_door column
     *
     * Example usage:
     * <code>
     * $query->filterByGewijzigdDoor('fooValue');   // WHERE gewijzigd_door = 'fooValue'
     * $query->filterByGewijzigdDoor('%fooValue%', Criteria::LIKE); // WHERE gewijzigd_door LIKE '%fooValue%'
     * </code>
     *
     * @param     string $gewijzigdDoor The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByGewijzigdDoor($gewijzigdDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gewijzigdDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InschrijvingTableMap::COL_GEWIJZIGD_DOOR, $gewijzigdDoor, $comparison);
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Evenement object
     *
     * @param \fb_model\fb_model\Evenement|ObjectCollection $evenement The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByEvenement($evenement, $comparison = null)
    {
        if ($evenement instanceof \fb_model\fb_model\Evenement) {
            return $this
                ->addUsingAlias(InschrijvingTableMap::COL_EVENEMENT_ID, $evenement->getId(), $comparison);
        } elseif ($evenement instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(InschrijvingTableMap::COL_EVENEMENT_ID, $evenement->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByEvenement() only accepts arguments of type \fb_model\fb_model\Evenement or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Evenement relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function joinEvenement($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Evenement');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Evenement');
        }

        return $this;
    }

    /**
     * Use the Evenement relation Evenement object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \fb_model\fb_model\EvenementQuery A secondary query class using the current class as primary query
     */
    public function useEvenementQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinEvenement($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Evenement', '\fb_model\fb_model\EvenementQuery');
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Keuzes object
     *
     * @param \fb_model\fb_model\Keuzes|ObjectCollection $keuzes The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByKeuzes($keuzes, $comparison = null)
    {
        if ($keuzes instanceof \fb_model\fb_model\Keuzes) {
            return $this
                ->addUsingAlias(InschrijvingTableMap::COL_STATUS, $keuzes->getId(), $comparison);
        } elseif ($keuzes instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(InschrijvingTableMap::COL_STATUS, $keuzes->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByKeuzes() only accepts arguments of type \fb_model\fb_model\Keuzes or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Keuzes relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function joinKeuzes($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Keuzes');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Keuzes');
        }

        return $this;
    }

    /**
     * Use the Keuzes relation Keuzes object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \fb_model\fb_model\KeuzesQuery A secondary query class using the current class as primary query
     */
    public function useKeuzesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinKeuzes($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Keuzes', '\fb_model\fb_model\KeuzesQuery');
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Voucher object
     *
     * @param \fb_model\fb_model\Voucher|ObjectCollection $voucher The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByVoucher($voucher, $comparison = null)
    {
        if ($voucher instanceof \fb_model\fb_model\Voucher) {
            return $this
                ->addUsingAlias(InschrijvingTableMap::COL_VOUCHER_ID, $voucher->getId(), $comparison);
        } elseif ($voucher instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(InschrijvingTableMap::COL_VOUCHER_ID, $voucher->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByVoucher() only accepts arguments of type \fb_model\fb_model\Voucher or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Voucher relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function joinVoucher($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Voucher');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Voucher');
        }

        return $this;
    }

    /**
     * Use the Voucher relation Voucher object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \fb_model\fb_model\VoucherQuery A secondary query class using the current class as primary query
     */
    public function useVoucherQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinVoucher($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Voucher', '\fb_model\fb_model\VoucherQuery');
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Persoon object
     *
     * @param \fb_model\fb_model\Persoon|ObjectCollection $persoon The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByPersoon($persoon, $comparison = null)
    {
        if ($persoon instanceof \fb_model\fb_model\Persoon) {
            return $this
                ->addUsingAlias(InschrijvingTableMap::COL_CONTACTPERSOON_ID, $persoon->getId(), $comparison);
        } elseif ($persoon instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(InschrijvingTableMap::COL_CONTACTPERSOON_ID, $persoon->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPersoon() only accepts arguments of type \fb_model\fb_model\Persoon or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Persoon relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function joinPersoon($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Persoon');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Persoon');
        }

        return $this;
    }

    /**
     * Use the Persoon relation Persoon object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \fb_model\fb_model\PersoonQuery A secondary query class using the current class as primary query
     */
    public function usePersoonQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPersoon($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Persoon', '\fb_model\fb_model\PersoonQuery');
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Deelnemer object
     *
     * @param \fb_model\fb_model\Deelnemer|ObjectCollection $deelnemer the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByDeelnemer($deelnemer, $comparison = null)
    {
        if ($deelnemer instanceof \fb_model\fb_model\Deelnemer) {
            return $this
                ->addUsingAlias(InschrijvingTableMap::COL_ID, $deelnemer->getInschrijvingId(), $comparison);
        } elseif ($deelnemer instanceof ObjectCollection) {
            return $this
                ->useDeelnemerQuery()
                ->filterByPrimaryKeys($deelnemer->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDeelnemer() only accepts arguments of type \fb_model\fb_model\Deelnemer or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Deelnemer relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function joinDeelnemer($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Deelnemer');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Deelnemer');
        }

        return $this;
    }

    /**
     * Use the Deelnemer relation Deelnemer object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \fb_model\fb_model\DeelnemerQuery A secondary query class using the current class as primary query
     */
    public function useDeelnemerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDeelnemer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Deelnemer', '\fb_model\fb_model\DeelnemerQuery');
    }

    /**
     * Filter the query by a related \fb_model\fb_model\FactuurNummer object
     *
     * @param \fb_model\fb_model\FactuurNummer|ObjectCollection $factuurNummer the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByFactuurNummer($factuurNummer, $comparison = null)
    {
        if ($factuurNummer instanceof \fb_model\fb_model\FactuurNummer) {
            return $this
                ->addUsingAlias(InschrijvingTableMap::COL_ID, $factuurNummer->getInschrijvingId(), $comparison);
        } elseif ($factuurNummer instanceof ObjectCollection) {
            return $this
                ->useFactuurNummerQuery()
                ->filterByPrimaryKeys($factuurNummer->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFactuurNummer() only accepts arguments of type \fb_model\fb_model\FactuurNummer or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FactuurNummer relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function joinFactuurNummer($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FactuurNummer');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'FactuurNummer');
        }

        return $this;
    }

    /**
     * Use the FactuurNummer relation FactuurNummer object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \fb_model\fb_model\FactuurNummerQuery A secondary query class using the current class as primary query
     */
    public function useFactuurNummerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFactuurNummer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FactuurNummer', '\fb_model\fb_model\FactuurNummerQuery');
    }

    /**
     * Filter the query by a related \fb_model\fb_model\InschrijvingHeeftOptie object
     *
     * @param \fb_model\fb_model\InschrijvingHeeftOptie|ObjectCollection $inschrijvingHeeftOptie the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByInschrijvingHeeftOptie($inschrijvingHeeftOptie, $comparison = null)
    {
        if ($inschrijvingHeeftOptie instanceof \fb_model\fb_model\InschrijvingHeeftOptie) {
            return $this
                ->addUsingAlias(InschrijvingTableMap::COL_ID, $inschrijvingHeeftOptie->getInschrijvingId(), $comparison);
        } elseif ($inschrijvingHeeftOptie instanceof ObjectCollection) {
            return $this
                ->useInschrijvingHeeftOptieQuery()
                ->filterByPrimaryKeys($inschrijvingHeeftOptie->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByInschrijvingHeeftOptie() only accepts arguments of type \fb_model\fb_model\InschrijvingHeeftOptie or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the InschrijvingHeeftOptie relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function joinInschrijvingHeeftOptie($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('InschrijvingHeeftOptie');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'InschrijvingHeeftOptie');
        }

        return $this;
    }

    /**
     * Use the InschrijvingHeeftOptie relation InschrijvingHeeftOptie object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \fb_model\fb_model\InschrijvingHeeftOptieQuery A secondary query class using the current class as primary query
     */
    public function useInschrijvingHeeftOptieQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinInschrijvingHeeftOptie($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'InschrijvingHeeftOptie', '\fb_model\fb_model\InschrijvingHeeftOptieQuery');
    }

    /**
     * Filter the query by a related Optie object
     * using the fb_inschrijving_heeft_optie table as cross reference
     *
     * @param Optie $optie the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildInschrijvingQuery The current query, for fluid interface
     */
    public function filterByOptie($optie, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useInschrijvingHeeftOptieQuery()
            ->filterByOptie($optie, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildInschrijving $inschrijving Object to remove from the list of results
     *
     * @return $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function prune($inschrijving = null)
    {
        if ($inschrijving) {
            $this->addUsingAlias(InschrijvingTableMap::COL_ID, $inschrijving->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fb_inschrijving table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InschrijvingTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            InschrijvingTableMap::clearInstancePool();
            InschrijvingTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InschrijvingTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(InschrijvingTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            InschrijvingTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            InschrijvingTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(InschrijvingTableMap::COL_GEWIJZIGD_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(InschrijvingTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(InschrijvingTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(InschrijvingTableMap::COL_GEMAAKT_DATUM);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(InschrijvingTableMap::COL_GEMAAKT_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildInschrijvingQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(InschrijvingTableMap::COL_GEMAAKT_DATUM);
    }

} // InschrijvingQuery
