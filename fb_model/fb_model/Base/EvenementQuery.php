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
use fb_model\fb_model\Evenement as ChildEvenement;
use fb_model\fb_model\EvenementQuery as ChildEvenementQuery;
use fb_model\fb_model\Map\EvenementTableMap;

/**
 * Base class that represents a query for the 'fb_evenement' table.
 *
 *
 *
 * @method     ChildEvenementQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildEvenementQuery orderByNaam($order = Criteria::ASC) Order by the naam column
 * @method     ChildEvenementQuery orderByCategorie($order = Criteria::ASC) Order by the categorie column
 * @method     ChildEvenementQuery orderByKorteOmschrijving($order = Criteria::ASC) Order by the korte_omschrijving column
 * @method     ChildEvenementQuery orderByLangeOmschrijving($order = Criteria::ASC) Order by the lange_omschrijving column
 * @method     ChildEvenementQuery orderByDatumBegin($order = Criteria::ASC) Order by the datum_begin column
 * @method     ChildEvenementQuery orderByDatumEind($order = Criteria::ASC) Order by the datum_eind column
 * @method     ChildEvenementQuery orderByAantalDagen($order = Criteria::ASC) Order by the aantal_dagen column
 * @method     ChildEvenementQuery orderByFrequentie($order = Criteria::ASC) Order by the frequentie column
 * @method     ChildEvenementQuery orderByInschrijvingBegin($order = Criteria::ASC) Order by the inschrijving_begin column
 * @method     ChildEvenementQuery orderByInschrijvingEind($order = Criteria::ASC) Order by the inschrijving_eind column
 * @method     ChildEvenementQuery orderByExtraDeelnemerGegevens($order = Criteria::ASC) Order by the extra_deelnemer_gegevens column
 * @method     ChildEvenementQuery orderByExtraContactGegevens($order = Criteria::ASC) Order by the extra_contact_gegevens column
 * @method     ChildEvenementQuery orderByPrijs($order = Criteria::ASC) Order by the prijs column
 * @method     ChildEvenementQuery orderByBetaalwijze($order = Criteria::ASC) Order by the betaalwijze column
 * @method     ChildEvenementQuery orderByMaxDeelnemers($order = Criteria::ASC) Order by the max_deelnemers column
 * @method     ChildEvenementQuery orderByAnnuleringsverzekering($order = Criteria::ASC) Order by the annuleringsverzekering column
 * @method     ChildEvenementQuery orderByAccountNodig($order = Criteria::ASC) Order by the account_nodig column
 * @method     ChildEvenementQuery orderByGroepsInschrijving($order = Criteria::ASC) Order by the groepsinschrijving column
 * @method     ChildEvenementQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildEvenementQuery orderByDatumGemaakt($order = Criteria::ASC) Order by the gemaakt_datum column
 * @method     ChildEvenementQuery orderByGemaaktDoor($order = Criteria::ASC) Order by the gemaakt_door column
 * @method     ChildEvenementQuery orderByDatumGewijzigd($order = Criteria::ASC) Order by the gewijzigd_datum column
 * @method     ChildEvenementQuery orderByGewijzigdDoor($order = Criteria::ASC) Order by the gewijzigd_door column
 *
 * @method     ChildEvenementQuery groupById() Group by the id column
 * @method     ChildEvenementQuery groupByNaam() Group by the naam column
 * @method     ChildEvenementQuery groupByCategorie() Group by the categorie column
 * @method     ChildEvenementQuery groupByKorteOmschrijving() Group by the korte_omschrijving column
 * @method     ChildEvenementQuery groupByLangeOmschrijving() Group by the lange_omschrijving column
 * @method     ChildEvenementQuery groupByDatumBegin() Group by the datum_begin column
 * @method     ChildEvenementQuery groupByDatumEind() Group by the datum_eind column
 * @method     ChildEvenementQuery groupByAantalDagen() Group by the aantal_dagen column
 * @method     ChildEvenementQuery groupByFrequentie() Group by the frequentie column
 * @method     ChildEvenementQuery groupByInschrijvingBegin() Group by the inschrijving_begin column
 * @method     ChildEvenementQuery groupByInschrijvingEind() Group by the inschrijving_eind column
 * @method     ChildEvenementQuery groupByExtraDeelnemerGegevens() Group by the extra_deelnemer_gegevens column
 * @method     ChildEvenementQuery groupByExtraContactGegevens() Group by the extra_contact_gegevens column
 * @method     ChildEvenementQuery groupByPrijs() Group by the prijs column
 * @method     ChildEvenementQuery groupByBetaalwijze() Group by the betaalwijze column
 * @method     ChildEvenementQuery groupByMaxDeelnemers() Group by the max_deelnemers column
 * @method     ChildEvenementQuery groupByAnnuleringsverzekering() Group by the annuleringsverzekering column
 * @method     ChildEvenementQuery groupByAccountNodig() Group by the account_nodig column
 * @method     ChildEvenementQuery groupByGroepsInschrijving() Group by the groepsinschrijving column
 * @method     ChildEvenementQuery groupByStatus() Group by the status column
 * @method     ChildEvenementQuery groupByDatumGemaakt() Group by the gemaakt_datum column
 * @method     ChildEvenementQuery groupByGemaaktDoor() Group by the gemaakt_door column
 * @method     ChildEvenementQuery groupByDatumGewijzigd() Group by the gewijzigd_datum column
 * @method     ChildEvenementQuery groupByGewijzigdDoor() Group by the gewijzigd_door column
 *
 * @method     ChildEvenementQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildEvenementQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildEvenementQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildEvenementQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildEvenementQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildEvenementQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildEvenementQuery leftJoinKeuzes($relationAlias = null) Adds a LEFT JOIN clause to the query using the Keuzes relation
 * @method     ChildEvenementQuery rightJoinKeuzes($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Keuzes relation
 * @method     ChildEvenementQuery innerJoinKeuzes($relationAlias = null) Adds a INNER JOIN clause to the query using the Keuzes relation
 *
 * @method     ChildEvenementQuery joinWithKeuzes($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Keuzes relation
 *
 * @method     ChildEvenementQuery leftJoinWithKeuzes() Adds a LEFT JOIN clause and with to the query using the Keuzes relation
 * @method     ChildEvenementQuery rightJoinWithKeuzes() Adds a RIGHT JOIN clause and with to the query using the Keuzes relation
 * @method     ChildEvenementQuery innerJoinWithKeuzes() Adds a INNER JOIN clause and with to the query using the Keuzes relation
 *
 * @method     ChildEvenementQuery leftJoinEvenementHeeftOptie($relationAlias = null) Adds a LEFT JOIN clause to the query using the EvenementHeeftOptie relation
 * @method     ChildEvenementQuery rightJoinEvenementHeeftOptie($relationAlias = null) Adds a RIGHT JOIN clause to the query using the EvenementHeeftOptie relation
 * @method     ChildEvenementQuery innerJoinEvenementHeeftOptie($relationAlias = null) Adds a INNER JOIN clause to the query using the EvenementHeeftOptie relation
 *
 * @method     ChildEvenementQuery joinWithEvenementHeeftOptie($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the EvenementHeeftOptie relation
 *
 * @method     ChildEvenementQuery leftJoinWithEvenementHeeftOptie() Adds a LEFT JOIN clause and with to the query using the EvenementHeeftOptie relation
 * @method     ChildEvenementQuery rightJoinWithEvenementHeeftOptie() Adds a RIGHT JOIN clause and with to the query using the EvenementHeeftOptie relation
 * @method     ChildEvenementQuery innerJoinWithEvenementHeeftOptie() Adds a INNER JOIN clause and with to the query using the EvenementHeeftOptie relation
 *
 * @method     ChildEvenementQuery leftJoinInschrijving($relationAlias = null) Adds a LEFT JOIN clause to the query using the Inschrijving relation
 * @method     ChildEvenementQuery rightJoinInschrijving($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Inschrijving relation
 * @method     ChildEvenementQuery innerJoinInschrijving($relationAlias = null) Adds a INNER JOIN clause to the query using the Inschrijving relation
 *
 * @method     ChildEvenementQuery joinWithInschrijving($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Inschrijving relation
 *
 * @method     ChildEvenementQuery leftJoinWithInschrijving() Adds a LEFT JOIN clause and with to the query using the Inschrijving relation
 * @method     ChildEvenementQuery rightJoinWithInschrijving() Adds a RIGHT JOIN clause and with to the query using the Inschrijving relation
 * @method     ChildEvenementQuery innerJoinWithInschrijving() Adds a INNER JOIN clause and with to the query using the Inschrijving relation
 *
 * @method     ChildEvenementQuery leftJoinMailinglist($relationAlias = null) Adds a LEFT JOIN clause to the query using the Mailinglist relation
 * @method     ChildEvenementQuery rightJoinMailinglist($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Mailinglist relation
 * @method     ChildEvenementQuery innerJoinMailinglist($relationAlias = null) Adds a INNER JOIN clause to the query using the Mailinglist relation
 *
 * @method     ChildEvenementQuery joinWithMailinglist($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Mailinglist relation
 *
 * @method     ChildEvenementQuery leftJoinWithMailinglist() Adds a LEFT JOIN clause and with to the query using the Mailinglist relation
 * @method     ChildEvenementQuery rightJoinWithMailinglist() Adds a RIGHT JOIN clause and with to the query using the Mailinglist relation
 * @method     ChildEvenementQuery innerJoinWithMailinglist() Adds a INNER JOIN clause and with to the query using the Mailinglist relation
 *
 * @method     ChildEvenementQuery leftJoinVoucher($relationAlias = null) Adds a LEFT JOIN clause to the query using the Voucher relation
 * @method     ChildEvenementQuery rightJoinVoucher($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Voucher relation
 * @method     ChildEvenementQuery innerJoinVoucher($relationAlias = null) Adds a INNER JOIN clause to the query using the Voucher relation
 *
 * @method     ChildEvenementQuery joinWithVoucher($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Voucher relation
 *
 * @method     ChildEvenementQuery leftJoinWithVoucher() Adds a LEFT JOIN clause and with to the query using the Voucher relation
 * @method     ChildEvenementQuery rightJoinWithVoucher() Adds a RIGHT JOIN clause and with to the query using the Voucher relation
 * @method     ChildEvenementQuery innerJoinWithVoucher() Adds a INNER JOIN clause and with to the query using the Voucher relation
 *
 * @method     \fb_model\fb_model\KeuzesQuery|\fb_model\fb_model\EvenementHeeftOptieQuery|\fb_model\fb_model\InschrijvingQuery|\fb_model\fb_model\MailinglistQuery|\fb_model\fb_model\VoucherQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildEvenement findOne(ConnectionInterface $con = null) Return the first ChildEvenement matching the query
 * @method     ChildEvenement findOneOrCreate(ConnectionInterface $con = null) Return the first ChildEvenement matching the query, or a new ChildEvenement object populated from the query conditions when no match is found
 *
 * @method     ChildEvenement findOneById(int $id) Return the first ChildEvenement filtered by the id column
 * @method     ChildEvenement findOneByNaam(string $naam) Return the first ChildEvenement filtered by the naam column
 * @method     ChildEvenement findOneByCategorie(string $categorie) Return the first ChildEvenement filtered by the categorie column
 * @method     ChildEvenement findOneByKorteOmschrijving(string $korte_omschrijving) Return the first ChildEvenement filtered by the korte_omschrijving column
 * @method     ChildEvenement findOneByLangeOmschrijving(string $lange_omschrijving) Return the first ChildEvenement filtered by the lange_omschrijving column
 * @method     ChildEvenement findOneByDatumBegin(string $datum_begin) Return the first ChildEvenement filtered by the datum_begin column
 * @method     ChildEvenement findOneByDatumEind(string $datum_eind) Return the first ChildEvenement filtered by the datum_eind column
 * @method     ChildEvenement findOneByAantalDagen(int $aantal_dagen) Return the first ChildEvenement filtered by the aantal_dagen column
 * @method     ChildEvenement findOneByFrequentie(string $frequentie) Return the first ChildEvenement filtered by the frequentie column
 * @method     ChildEvenement findOneByInschrijvingBegin(string $inschrijving_begin) Return the first ChildEvenement filtered by the inschrijving_begin column
 * @method     ChildEvenement findOneByInschrijvingEind(string $inschrijving_eind) Return the first ChildEvenement filtered by the inschrijving_eind column
 * @method     ChildEvenement findOneByExtraDeelnemerGegevens(int $extra_deelnemer_gegevens) Return the first ChildEvenement filtered by the extra_deelnemer_gegevens column
 * @method     ChildEvenement findOneByExtraContactGegevens(int $extra_contact_gegevens) Return the first ChildEvenement filtered by the extra_contact_gegevens column
 * @method     ChildEvenement findOneByPrijs(string $prijs) Return the first ChildEvenement filtered by the prijs column
 * @method     ChildEvenement findOneByBetaalwijze(int $betaalwijze) Return the first ChildEvenement filtered by the betaalwijze column
 * @method     ChildEvenement findOneByMaxDeelnemers(int $max_deelnemers) Return the first ChildEvenement filtered by the max_deelnemers column
 * @method     ChildEvenement findOneByAnnuleringsverzekering(int $annuleringsverzekering) Return the first ChildEvenement filtered by the annuleringsverzekering column
 * @method     ChildEvenement findOneByAccountNodig(int $account_nodig) Return the first ChildEvenement filtered by the account_nodig column
 * @method     ChildEvenement findOneByGroepsInschrijving(int $groepsinschrijving) Return the first ChildEvenement filtered by the groepsinschrijving column
 * @method     ChildEvenement findOneByStatus(int $status) Return the first ChildEvenement filtered by the status column
 * @method     ChildEvenement findOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildEvenement filtered by the gemaakt_datum column
 * @method     ChildEvenement findOneByGemaaktDoor(string $gemaakt_door) Return the first ChildEvenement filtered by the gemaakt_door column
 * @method     ChildEvenement findOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildEvenement filtered by the gewijzigd_datum column
 * @method     ChildEvenement findOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildEvenement filtered by the gewijzigd_door column *

 * @method     ChildEvenement requirePk($key, ConnectionInterface $con = null) Return the ChildEvenement by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenement requireOne(ConnectionInterface $con = null) Return the first ChildEvenement matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEvenement requireOneById(int $id) Return the first ChildEvenement filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenement requireOneByNaam(string $naam) Return the first ChildEvenement filtered by the naam column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenement requireOneByCategorie(string $categorie) Return the first ChildEvenement filtered by the categorie column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenement requireOneByKorteOmschrijving(string $korte_omschrijving) Return the first ChildEvenement filtered by the korte_omschrijving column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenement requireOneByLangeOmschrijving(string $lange_omschrijving) Return the first ChildEvenement filtered by the lange_omschrijving column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenement requireOneByDatumBegin(string $datum_begin) Return the first ChildEvenement filtered by the datum_begin column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenement requireOneByDatumEind(string $datum_eind) Return the first ChildEvenement filtered by the datum_eind column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenement requireOneByAantalDagen(int $aantal_dagen) Return the first ChildEvenement filtered by the aantal_dagen column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenement requireOneByFrequentie(string $frequentie) Return the first ChildEvenement filtered by the frequentie column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenement requireOneByInschrijvingBegin(string $inschrijving_begin) Return the first ChildEvenement filtered by the inschrijving_begin column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenement requireOneByInschrijvingEind(string $inschrijving_eind) Return the first ChildEvenement filtered by the inschrijving_eind column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenement requireOneByExtraDeelnemerGegevens(int $extra_deelnemer_gegevens) Return the first ChildEvenement filtered by the extra_deelnemer_gegevens column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenement requireOneByExtraContactGegevens(int $extra_contact_gegevens) Return the first ChildEvenement filtered by the extra_contact_gegevens column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenement requireOneByPrijs(string $prijs) Return the first ChildEvenement filtered by the prijs column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenement requireOneByBetaalwijze(int $betaalwijze) Return the first ChildEvenement filtered by the betaalwijze column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenement requireOneByMaxDeelnemers(int $max_deelnemers) Return the first ChildEvenement filtered by the max_deelnemers column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenement requireOneByAnnuleringsverzekering(int $annuleringsverzekering) Return the first ChildEvenement filtered by the annuleringsverzekering column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenement requireOneByAccountNodig(int $account_nodig) Return the first ChildEvenement filtered by the account_nodig column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenement requireOneByGroepsInschrijving(int $groepsinschrijving) Return the first ChildEvenement filtered by the groepsinschrijving column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenement requireOneByStatus(int $status) Return the first ChildEvenement filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenement requireOneByDatumGemaakt(string $gemaakt_datum) Return the first ChildEvenement filtered by the gemaakt_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenement requireOneByGemaaktDoor(string $gemaakt_door) Return the first ChildEvenement filtered by the gemaakt_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenement requireOneByDatumGewijzigd(string $gewijzigd_datum) Return the first ChildEvenement filtered by the gewijzigd_datum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvenement requireOneByGewijzigdDoor(string $gewijzigd_door) Return the first ChildEvenement filtered by the gewijzigd_door column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEvenement[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildEvenement objects based on current ModelCriteria
 * @method     ChildEvenement[]|ObjectCollection findById(int $id) Return ChildEvenement objects filtered by the id column
 * @method     ChildEvenement[]|ObjectCollection findByNaam(string $naam) Return ChildEvenement objects filtered by the naam column
 * @method     ChildEvenement[]|ObjectCollection findByCategorie(string $categorie) Return ChildEvenement objects filtered by the categorie column
 * @method     ChildEvenement[]|ObjectCollection findByKorteOmschrijving(string $korte_omschrijving) Return ChildEvenement objects filtered by the korte_omschrijving column
 * @method     ChildEvenement[]|ObjectCollection findByLangeOmschrijving(string $lange_omschrijving) Return ChildEvenement objects filtered by the lange_omschrijving column
 * @method     ChildEvenement[]|ObjectCollection findByDatumBegin(string $datum_begin) Return ChildEvenement objects filtered by the datum_begin column
 * @method     ChildEvenement[]|ObjectCollection findByDatumEind(string $datum_eind) Return ChildEvenement objects filtered by the datum_eind column
 * @method     ChildEvenement[]|ObjectCollection findByAantalDagen(int $aantal_dagen) Return ChildEvenement objects filtered by the aantal_dagen column
 * @method     ChildEvenement[]|ObjectCollection findByFrequentie(string $frequentie) Return ChildEvenement objects filtered by the frequentie column
 * @method     ChildEvenement[]|ObjectCollection findByInschrijvingBegin(string $inschrijving_begin) Return ChildEvenement objects filtered by the inschrijving_begin column
 * @method     ChildEvenement[]|ObjectCollection findByInschrijvingEind(string $inschrijving_eind) Return ChildEvenement objects filtered by the inschrijving_eind column
 * @method     ChildEvenement[]|ObjectCollection findByExtraDeelnemerGegevens(int $extra_deelnemer_gegevens) Return ChildEvenement objects filtered by the extra_deelnemer_gegevens column
 * @method     ChildEvenement[]|ObjectCollection findByExtraContactGegevens(int $extra_contact_gegevens) Return ChildEvenement objects filtered by the extra_contact_gegevens column
 * @method     ChildEvenement[]|ObjectCollection findByPrijs(string $prijs) Return ChildEvenement objects filtered by the prijs column
 * @method     ChildEvenement[]|ObjectCollection findByBetaalwijze(int $betaalwijze) Return ChildEvenement objects filtered by the betaalwijze column
 * @method     ChildEvenement[]|ObjectCollection findByMaxDeelnemers(int $max_deelnemers) Return ChildEvenement objects filtered by the max_deelnemers column
 * @method     ChildEvenement[]|ObjectCollection findByAnnuleringsverzekering(int $annuleringsverzekering) Return ChildEvenement objects filtered by the annuleringsverzekering column
 * @method     ChildEvenement[]|ObjectCollection findByAccountNodig(int $account_nodig) Return ChildEvenement objects filtered by the account_nodig column
 * @method     ChildEvenement[]|ObjectCollection findByGroepsInschrijving(int $groepsinschrijving) Return ChildEvenement objects filtered by the groepsinschrijving column
 * @method     ChildEvenement[]|ObjectCollection findByStatus(int $status) Return ChildEvenement objects filtered by the status column
 * @method     ChildEvenement[]|ObjectCollection findByDatumGemaakt(string $gemaakt_datum) Return ChildEvenement objects filtered by the gemaakt_datum column
 * @method     ChildEvenement[]|ObjectCollection findByGemaaktDoor(string $gemaakt_door) Return ChildEvenement objects filtered by the gemaakt_door column
 * @method     ChildEvenement[]|ObjectCollection findByDatumGewijzigd(string $gewijzigd_datum) Return ChildEvenement objects filtered by the gewijzigd_datum column
 * @method     ChildEvenement[]|ObjectCollection findByGewijzigdDoor(string $gewijzigd_door) Return ChildEvenement objects filtered by the gewijzigd_door column
 * @method     ChildEvenement[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class EvenementQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \fb_model\fb_model\Base\EvenementQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\fb_model\\fb_model\\Evenement', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildEvenementQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildEvenementQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildEvenementQuery) {
            return $criteria;
        }
        $query = new ChildEvenementQuery();
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
     * @return ChildEvenement|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EvenementTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = EvenementTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildEvenement A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, naam, categorie, korte_omschrijving, lange_omschrijving, datum_begin, datum_eind, aantal_dagen, frequentie, inschrijving_begin, inschrijving_eind, extra_deelnemer_gegevens, extra_contact_gegevens, prijs, betaalwijze, max_deelnemers, annuleringsverzekering, account_nodig, groepsinschrijving, status, gemaakt_datum, gemaakt_door, gewijzigd_datum, gewijzigd_door FROM fb_evenement WHERE id = :p0';
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
            /** @var ChildEvenement $obj */
            $obj = new ChildEvenement();
            $obj->hydrate($row);
            EvenementTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildEvenement|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(EvenementTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(EvenementTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(EvenementTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(EvenementTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the naam column
     *
     * Example usage:
     * <code>
     * $query->filterByNaam('fooValue');   // WHERE naam = 'fooValue'
     * $query->filterByNaam('%fooValue%', Criteria::LIKE); // WHERE naam LIKE '%fooValue%'
     * </code>
     *
     * @param     string $naam The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByNaam($naam = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($naam)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementTableMap::COL_NAAM, $naam, $comparison);
    }

    /**
     * Filter the query on the categorie column
     *
     * Example usage:
     * <code>
     * $query->filterByCategorie('fooValue');   // WHERE categorie = 'fooValue'
     * $query->filterByCategorie('%fooValue%', Criteria::LIKE); // WHERE categorie LIKE '%fooValue%'
     * </code>
     *
     * @param     string $categorie The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByCategorie($categorie = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($categorie)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementTableMap::COL_CATEGORIE, $categorie, $comparison);
    }

    /**
     * Filter the query on the korte_omschrijving column
     *
     * Example usage:
     * <code>
     * $query->filterByKorteOmschrijving('fooValue');   // WHERE korte_omschrijving = 'fooValue'
     * $query->filterByKorteOmschrijving('%fooValue%', Criteria::LIKE); // WHERE korte_omschrijving LIKE '%fooValue%'
     * </code>
     *
     * @param     string $korteOmschrijving The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByKorteOmschrijving($korteOmschrijving = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($korteOmschrijving)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementTableMap::COL_KORTE_OMSCHRIJVING, $korteOmschrijving, $comparison);
    }

    /**
     * Filter the query on the lange_omschrijving column
     *
     * Example usage:
     * <code>
     * $query->filterByLangeOmschrijving('fooValue');   // WHERE lange_omschrijving = 'fooValue'
     * $query->filterByLangeOmschrijving('%fooValue%', Criteria::LIKE); // WHERE lange_omschrijving LIKE '%fooValue%'
     * </code>
     *
     * @param     string $langeOmschrijving The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByLangeOmschrijving($langeOmschrijving = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($langeOmschrijving)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementTableMap::COL_LANGE_OMSCHRIJVING, $langeOmschrijving, $comparison);
    }

    /**
     * Filter the query on the datum_begin column
     *
     * Example usage:
     * <code>
     * $query->filterByDatumBegin('2011-03-14'); // WHERE datum_begin = '2011-03-14'
     * $query->filterByDatumBegin('now'); // WHERE datum_begin = '2011-03-14'
     * $query->filterByDatumBegin(array('max' => 'yesterday')); // WHERE datum_begin > '2011-03-13'
     * </code>
     *
     * @param     mixed $datumBegin The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByDatumBegin($datumBegin = null, $comparison = null)
    {
        if (is_array($datumBegin)) {
            $useMinMax = false;
            if (isset($datumBegin['min'])) {
                $this->addUsingAlias(EvenementTableMap::COL_DATUM_BEGIN, $datumBegin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumBegin['max'])) {
                $this->addUsingAlias(EvenementTableMap::COL_DATUM_BEGIN, $datumBegin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementTableMap::COL_DATUM_BEGIN, $datumBegin, $comparison);
    }

    /**
     * Filter the query on the datum_eind column
     *
     * Example usage:
     * <code>
     * $query->filterByDatumEind('2011-03-14'); // WHERE datum_eind = '2011-03-14'
     * $query->filterByDatumEind('now'); // WHERE datum_eind = '2011-03-14'
     * $query->filterByDatumEind(array('max' => 'yesterday')); // WHERE datum_eind > '2011-03-13'
     * </code>
     *
     * @param     mixed $datumEind The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByDatumEind($datumEind = null, $comparison = null)
    {
        if (is_array($datumEind)) {
            $useMinMax = false;
            if (isset($datumEind['min'])) {
                $this->addUsingAlias(EvenementTableMap::COL_DATUM_EIND, $datumEind['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumEind['max'])) {
                $this->addUsingAlias(EvenementTableMap::COL_DATUM_EIND, $datumEind['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementTableMap::COL_DATUM_EIND, $datumEind, $comparison);
    }

    /**
     * Filter the query on the aantal_dagen column
     *
     * Example usage:
     * <code>
     * $query->filterByAantalDagen(1234); // WHERE aantal_dagen = 1234
     * $query->filterByAantalDagen(array(12, 34)); // WHERE aantal_dagen IN (12, 34)
     * $query->filterByAantalDagen(array('min' => 12)); // WHERE aantal_dagen > 12
     * </code>
     *
     * @param     mixed $aantalDagen The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByAantalDagen($aantalDagen = null, $comparison = null)
    {
        if (is_array($aantalDagen)) {
            $useMinMax = false;
            if (isset($aantalDagen['min'])) {
                $this->addUsingAlias(EvenementTableMap::COL_AANTAL_DAGEN, $aantalDagen['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($aantalDagen['max'])) {
                $this->addUsingAlias(EvenementTableMap::COL_AANTAL_DAGEN, $aantalDagen['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementTableMap::COL_AANTAL_DAGEN, $aantalDagen, $comparison);
    }

    /**
     * Filter the query on the frequentie column
     *
     * Example usage:
     * <code>
     * $query->filterByFrequentie('fooValue');   // WHERE frequentie = 'fooValue'
     * $query->filterByFrequentie('%fooValue%', Criteria::LIKE); // WHERE frequentie LIKE '%fooValue%'
     * </code>
     *
     * @param     string $frequentie The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByFrequentie($frequentie = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($frequentie)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementTableMap::COL_FREQUENTIE, $frequentie, $comparison);
    }

    /**
     * Filter the query on the inschrijving_begin column
     *
     * Example usage:
     * <code>
     * $query->filterByInschrijvingBegin('2011-03-14'); // WHERE inschrijving_begin = '2011-03-14'
     * $query->filterByInschrijvingBegin('now'); // WHERE inschrijving_begin = '2011-03-14'
     * $query->filterByInschrijvingBegin(array('max' => 'yesterday')); // WHERE inschrijving_begin > '2011-03-13'
     * </code>
     *
     * @param     mixed $inschrijvingBegin The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByInschrijvingBegin($inschrijvingBegin = null, $comparison = null)
    {
        if (is_array($inschrijvingBegin)) {
            $useMinMax = false;
            if (isset($inschrijvingBegin['min'])) {
                $this->addUsingAlias(EvenementTableMap::COL_INSCHRIJVING_BEGIN, $inschrijvingBegin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($inschrijvingBegin['max'])) {
                $this->addUsingAlias(EvenementTableMap::COL_INSCHRIJVING_BEGIN, $inschrijvingBegin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementTableMap::COL_INSCHRIJVING_BEGIN, $inschrijvingBegin, $comparison);
    }

    /**
     * Filter the query on the inschrijving_eind column
     *
     * Example usage:
     * <code>
     * $query->filterByInschrijvingEind('2011-03-14'); // WHERE inschrijving_eind = '2011-03-14'
     * $query->filterByInschrijvingEind('now'); // WHERE inschrijving_eind = '2011-03-14'
     * $query->filterByInschrijvingEind(array('max' => 'yesterday')); // WHERE inschrijving_eind > '2011-03-13'
     * </code>
     *
     * @param     mixed $inschrijvingEind The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByInschrijvingEind($inschrijvingEind = null, $comparison = null)
    {
        if (is_array($inschrijvingEind)) {
            $useMinMax = false;
            if (isset($inschrijvingEind['min'])) {
                $this->addUsingAlias(EvenementTableMap::COL_INSCHRIJVING_EIND, $inschrijvingEind['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($inschrijvingEind['max'])) {
                $this->addUsingAlias(EvenementTableMap::COL_INSCHRIJVING_EIND, $inschrijvingEind['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementTableMap::COL_INSCHRIJVING_EIND, $inschrijvingEind, $comparison);
    }

    /**
     * Filter the query on the extra_deelnemer_gegevens column
     *
     * Example usage:
     * <code>
     * $query->filterByExtraDeelnemerGegevens(1234); // WHERE extra_deelnemer_gegevens = 1234
     * $query->filterByExtraDeelnemerGegevens(array(12, 34)); // WHERE extra_deelnemer_gegevens IN (12, 34)
     * $query->filterByExtraDeelnemerGegevens(array('min' => 12)); // WHERE extra_deelnemer_gegevens > 12
     * </code>
     *
     * @param     mixed $extraDeelnemerGegevens The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByExtraDeelnemerGegevens($extraDeelnemerGegevens = null, $comparison = null)
    {
        if (is_array($extraDeelnemerGegevens)) {
            $useMinMax = false;
            if (isset($extraDeelnemerGegevens['min'])) {
                $this->addUsingAlias(EvenementTableMap::COL_EXTRA_DEELNEMER_GEGEVENS, $extraDeelnemerGegevens['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($extraDeelnemerGegevens['max'])) {
                $this->addUsingAlias(EvenementTableMap::COL_EXTRA_DEELNEMER_GEGEVENS, $extraDeelnemerGegevens['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementTableMap::COL_EXTRA_DEELNEMER_GEGEVENS, $extraDeelnemerGegevens, $comparison);
    }

    /**
     * Filter the query on the extra_contact_gegevens column
     *
     * Example usage:
     * <code>
     * $query->filterByExtraContactGegevens(1234); // WHERE extra_contact_gegevens = 1234
     * $query->filterByExtraContactGegevens(array(12, 34)); // WHERE extra_contact_gegevens IN (12, 34)
     * $query->filterByExtraContactGegevens(array('min' => 12)); // WHERE extra_contact_gegevens > 12
     * </code>
     *
     * @param     mixed $extraContactGegevens The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByExtraContactGegevens($extraContactGegevens = null, $comparison = null)
    {
        if (is_array($extraContactGegevens)) {
            $useMinMax = false;
            if (isset($extraContactGegevens['min'])) {
                $this->addUsingAlias(EvenementTableMap::COL_EXTRA_CONTACT_GEGEVENS, $extraContactGegevens['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($extraContactGegevens['max'])) {
                $this->addUsingAlias(EvenementTableMap::COL_EXTRA_CONTACT_GEGEVENS, $extraContactGegevens['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementTableMap::COL_EXTRA_CONTACT_GEGEVENS, $extraContactGegevens, $comparison);
    }

    /**
     * Filter the query on the prijs column
     *
     * Example usage:
     * <code>
     * $query->filterByPrijs(1234); // WHERE prijs = 1234
     * $query->filterByPrijs(array(12, 34)); // WHERE prijs IN (12, 34)
     * $query->filterByPrijs(array('min' => 12)); // WHERE prijs > 12
     * </code>
     *
     * @param     mixed $prijs The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByPrijs($prijs = null, $comparison = null)
    {
        if (is_array($prijs)) {
            $useMinMax = false;
            if (isset($prijs['min'])) {
                $this->addUsingAlias(EvenementTableMap::COL_PRIJS, $prijs['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($prijs['max'])) {
                $this->addUsingAlias(EvenementTableMap::COL_PRIJS, $prijs['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementTableMap::COL_PRIJS, $prijs, $comparison);
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
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByBetaalwijze($betaalwijze = null, $comparison = null)
    {
        if (is_array($betaalwijze)) {
            $useMinMax = false;
            if (isset($betaalwijze['min'])) {
                $this->addUsingAlias(EvenementTableMap::COL_BETAALWIJZE, $betaalwijze['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($betaalwijze['max'])) {
                $this->addUsingAlias(EvenementTableMap::COL_BETAALWIJZE, $betaalwijze['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementTableMap::COL_BETAALWIJZE, $betaalwijze, $comparison);
    }

    /**
     * Filter the query on the max_deelnemers column
     *
     * Example usage:
     * <code>
     * $query->filterByMaxDeelnemers(1234); // WHERE max_deelnemers = 1234
     * $query->filterByMaxDeelnemers(array(12, 34)); // WHERE max_deelnemers IN (12, 34)
     * $query->filterByMaxDeelnemers(array('min' => 12)); // WHERE max_deelnemers > 12
     * </code>
     *
     * @param     mixed $maxDeelnemers The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByMaxDeelnemers($maxDeelnemers = null, $comparison = null)
    {
        if (is_array($maxDeelnemers)) {
            $useMinMax = false;
            if (isset($maxDeelnemers['min'])) {
                $this->addUsingAlias(EvenementTableMap::COL_MAX_DEELNEMERS, $maxDeelnemers['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($maxDeelnemers['max'])) {
                $this->addUsingAlias(EvenementTableMap::COL_MAX_DEELNEMERS, $maxDeelnemers['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementTableMap::COL_MAX_DEELNEMERS, $maxDeelnemers, $comparison);
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
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByAnnuleringsverzekering($annuleringsverzekering = null, $comparison = null)
    {
        if (is_array($annuleringsverzekering)) {
            $useMinMax = false;
            if (isset($annuleringsverzekering['min'])) {
                $this->addUsingAlias(EvenementTableMap::COL_ANNULERINGSVERZEKERING, $annuleringsverzekering['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($annuleringsverzekering['max'])) {
                $this->addUsingAlias(EvenementTableMap::COL_ANNULERINGSVERZEKERING, $annuleringsverzekering['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementTableMap::COL_ANNULERINGSVERZEKERING, $annuleringsverzekering, $comparison);
    }

    /**
     * Filter the query on the account_nodig column
     *
     * Example usage:
     * <code>
     * $query->filterByAccountNodig(1234); // WHERE account_nodig = 1234
     * $query->filterByAccountNodig(array(12, 34)); // WHERE account_nodig IN (12, 34)
     * $query->filterByAccountNodig(array('min' => 12)); // WHERE account_nodig > 12
     * </code>
     *
     * @param     mixed $accountNodig The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByAccountNodig($accountNodig = null, $comparison = null)
    {
        if (is_array($accountNodig)) {
            $useMinMax = false;
            if (isset($accountNodig['min'])) {
                $this->addUsingAlias(EvenementTableMap::COL_ACCOUNT_NODIG, $accountNodig['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($accountNodig['max'])) {
                $this->addUsingAlias(EvenementTableMap::COL_ACCOUNT_NODIG, $accountNodig['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementTableMap::COL_ACCOUNT_NODIG, $accountNodig, $comparison);
    }

    /**
     * Filter the query on the groepsinschrijving column
     *
     * Example usage:
     * <code>
     * $query->filterByGroepsInschrijving(1234); // WHERE groepsinschrijving = 1234
     * $query->filterByGroepsInschrijving(array(12, 34)); // WHERE groepsinschrijving IN (12, 34)
     * $query->filterByGroepsInschrijving(array('min' => 12)); // WHERE groepsinschrijving > 12
     * </code>
     *
     * @param     mixed $groepsInschrijving The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByGroepsInschrijving($groepsInschrijving = null, $comparison = null)
    {
        if (is_array($groepsInschrijving)) {
            $useMinMax = false;
            if (isset($groepsInschrijving['min'])) {
                $this->addUsingAlias(EvenementTableMap::COL_GROEPSINSCHRIJVING, $groepsInschrijving['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($groepsInschrijving['max'])) {
                $this->addUsingAlias(EvenementTableMap::COL_GROEPSINSCHRIJVING, $groepsInschrijving['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementTableMap::COL_GROEPSINSCHRIJVING, $groepsInschrijving, $comparison);
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
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (is_array($status)) {
            $useMinMax = false;
            if (isset($status['min'])) {
                $this->addUsingAlias(EvenementTableMap::COL_STATUS, $status['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($status['max'])) {
                $this->addUsingAlias(EvenementTableMap::COL_STATUS, $status['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementTableMap::COL_STATUS, $status, $comparison);
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
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByDatumGemaakt($datumGemaakt = null, $comparison = null)
    {
        if (is_array($datumGemaakt)) {
            $useMinMax = false;
            if (isset($datumGemaakt['min'])) {
                $this->addUsingAlias(EvenementTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGemaakt['max'])) {
                $this->addUsingAlias(EvenementTableMap::COL_GEMAAKT_DATUM, $datumGemaakt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementTableMap::COL_GEMAAKT_DATUM, $datumGemaakt, $comparison);
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
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByGemaaktDoor($gemaaktDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gemaaktDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementTableMap::COL_GEMAAKT_DOOR, $gemaaktDoor, $comparison);
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
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByDatumGewijzigd($datumGewijzigd = null, $comparison = null)
    {
        if (is_array($datumGewijzigd)) {
            $useMinMax = false;
            if (isset($datumGewijzigd['min'])) {
                $this->addUsingAlias(EvenementTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datumGewijzigd['max'])) {
                $this->addUsingAlias(EvenementTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementTableMap::COL_GEWIJZIGD_DATUM, $datumGewijzigd, $comparison);
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
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByGewijzigdDoor($gewijzigdDoor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gewijzigdDoor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EvenementTableMap::COL_GEWIJZIGD_DOOR, $gewijzigdDoor, $comparison);
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Keuzes object
     *
     * @param \fb_model\fb_model\Keuzes|ObjectCollection $keuzes The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByKeuzes($keuzes, $comparison = null)
    {
        if ($keuzes instanceof \fb_model\fb_model\Keuzes) {
            return $this
                ->addUsingAlias(EvenementTableMap::COL_STATUS, $keuzes->getId(), $comparison);
        } elseif ($keuzes instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(EvenementTableMap::COL_STATUS, $keuzes->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildEvenementQuery The current query, for fluid interface
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
     * Filter the query by a related \fb_model\fb_model\EvenementHeeftOptie object
     *
     * @param \fb_model\fb_model\EvenementHeeftOptie|ObjectCollection $evenementHeeftOptie the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByEvenementHeeftOptie($evenementHeeftOptie, $comparison = null)
    {
        if ($evenementHeeftOptie instanceof \fb_model\fb_model\EvenementHeeftOptie) {
            return $this
                ->addUsingAlias(EvenementTableMap::COL_ID, $evenementHeeftOptie->getEvenementId(), $comparison);
        } elseif ($evenementHeeftOptie instanceof ObjectCollection) {
            return $this
                ->useEvenementHeeftOptieQuery()
                ->filterByPrimaryKeys($evenementHeeftOptie->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByEvenementHeeftOptie() only accepts arguments of type \fb_model\fb_model\EvenementHeeftOptie or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the EvenementHeeftOptie relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function joinEvenementHeeftOptie($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('EvenementHeeftOptie');

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
            $this->addJoinObject($join, 'EvenementHeeftOptie');
        }

        return $this;
    }

    /**
     * Use the EvenementHeeftOptie relation EvenementHeeftOptie object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \fb_model\fb_model\EvenementHeeftOptieQuery A secondary query class using the current class as primary query
     */
    public function useEvenementHeeftOptieQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinEvenementHeeftOptie($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'EvenementHeeftOptie', '\fb_model\fb_model\EvenementHeeftOptieQuery');
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Inschrijving object
     *
     * @param \fb_model\fb_model\Inschrijving|ObjectCollection $inschrijving the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByInschrijving($inschrijving, $comparison = null)
    {
        if ($inschrijving instanceof \fb_model\fb_model\Inschrijving) {
            return $this
                ->addUsingAlias(EvenementTableMap::COL_ID, $inschrijving->getEvenementId(), $comparison);
        } elseif ($inschrijving instanceof ObjectCollection) {
            return $this
                ->useInschrijvingQuery()
                ->filterByPrimaryKeys($inschrijving->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByInschrijving() only accepts arguments of type \fb_model\fb_model\Inschrijving or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Inschrijving relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function joinInschrijving($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Inschrijving');

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
            $this->addJoinObject($join, 'Inschrijving');
        }

        return $this;
    }

    /**
     * Use the Inschrijving relation Inschrijving object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \fb_model\fb_model\InschrijvingQuery A secondary query class using the current class as primary query
     */
    public function useInschrijvingQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinInschrijving($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Inschrijving', '\fb_model\fb_model\InschrijvingQuery');
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Mailinglist object
     *
     * @param \fb_model\fb_model\Mailinglist|ObjectCollection $mailinglist the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByMailinglist($mailinglist, $comparison = null)
    {
        if ($mailinglist instanceof \fb_model\fb_model\Mailinglist) {
            return $this
                ->addUsingAlias(EvenementTableMap::COL_ID, $mailinglist->getEvenementId(), $comparison);
        } elseif ($mailinglist instanceof ObjectCollection) {
            return $this
                ->useMailinglistQuery()
                ->filterByPrimaryKeys($mailinglist->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMailinglist() only accepts arguments of type \fb_model\fb_model\Mailinglist or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Mailinglist relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function joinMailinglist($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Mailinglist');

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
            $this->addJoinObject($join, 'Mailinglist');
        }

        return $this;
    }

    /**
     * Use the Mailinglist relation Mailinglist object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \fb_model\fb_model\MailinglistQuery A secondary query class using the current class as primary query
     */
    public function useMailinglistQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMailinglist($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Mailinglist', '\fb_model\fb_model\MailinglistQuery');
    }

    /**
     * Filter the query by a related \fb_model\fb_model\Voucher object
     *
     * @param \fb_model\fb_model\Voucher|ObjectCollection $voucher the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByVoucher($voucher, $comparison = null)
    {
        if ($voucher instanceof \fb_model\fb_model\Voucher) {
            return $this
                ->addUsingAlias(EvenementTableMap::COL_ID, $voucher->getEvenementId(), $comparison);
        } elseif ($voucher instanceof ObjectCollection) {
            return $this
                ->useVoucherQuery()
                ->filterByPrimaryKeys($voucher->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildEvenementQuery The current query, for fluid interface
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
     * Filter the query by a related Optie object
     * using the fb_evenement_heeft_optie table as cross reference
     *
     * @param Optie $optie the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildEvenementQuery The current query, for fluid interface
     */
    public function filterByOptie($optie, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useEvenementHeeftOptieQuery()
            ->filterByOptie($optie, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildEvenement $evenement Object to remove from the list of results
     *
     * @return $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function prune($evenement = null)
    {
        if ($evenement) {
            $this->addUsingAlias(EvenementTableMap::COL_ID, $evenement->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fb_evenement table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EvenementTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            EvenementTableMap::clearInstancePool();
            EvenementTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(EvenementTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(EvenementTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            EvenementTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            EvenementTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(EvenementTableMap::COL_GEWIJZIGD_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(EvenementTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(EvenementTableMap::COL_GEWIJZIGD_DATUM);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(EvenementTableMap::COL_GEMAAKT_DATUM);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(EvenementTableMap::COL_GEMAAKT_DATUM, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildEvenementQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(EvenementTableMap::COL_GEMAAKT_DATUM);
    }

} // EvenementQuery
