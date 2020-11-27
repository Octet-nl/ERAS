{include file="header-klant.tpl"}

<form method="post" action="{$SCRIPT_NAME}">

    <h2>Inschrijven</h2>
    
    {if $evenementnaam != "" }
    <h4>Nieuwe inschrijving voor {$evenementnaam}</h4>
    <button name="inschrijven" value={$evt}>Inschrijven</button>
    {/if}

    <div class="bmargin2">
    {if $aantal > 0}
    <h4>Uw huidige inschrijvingen</h4>
    <table >

        <thead>
            <tr>
                <th>Evenement</th>
                <th>Contact gegevens</th>
                <th>Betaling</th>
                <th>Status</th>
                <th>Inschrijving</th>
            </tr>
        </thead>

        {foreach $Inschrijvingen as $inschrijving}
        <tr>
            <td>
                <b>{$inschrijving.evenement_naam}</b><br />
                Inschrijfnummer: {$inschrijving.id}<br />
                Inschrijfdatum: {$inschrijving.datum}<br />
                Aantal deelnemers: {$inschrijving.aantal_deelnemers}<br />
                Contact: {$inschrijving.naam}
            </td>
            <td>
                Geb.dat. {$inschrijving.geboortedatum}<br />
                {$inschrijving.telefoon}<br />
                <a href=mailto://{$inschrijving.email}>{$inschrijving.email} </a> <br />
                {$inschrijving.straat} {$inschrijving.huisnummer} {$inschrijving.huisnummer_toevoeging}<br />
                {$inschrijving.postcode} {$inschrijving.woonplaats}
            </td>
            <td>
                Totaalbedrag: {$inschrijving.totaalbedrag}<br />
                Korting: {$inschrijving.korting}<br />
                Reeds betaald:{$inschrijving.reeds_betaald}<br />
                Te betalen: {$inschrijving.te_betalen}
            </td>
            <td>
                {$inschrijving.status}
            </td>
            <td>
                <button name="aanpassen" value={$inschrijving.id}>Aanpassen</button>
                {if file_exists( "{$inschrijving.factuurNaam}"  ) }
                <button name="factuur" value={$inschrijving.factuurNaam}>Factuur</button> 
                {/if}
                <button name="annuleer" value={$inschrijving.id} onclick="return verwijderKlik('Inschrijving met inschrijfnummer {$inschrijving.id}\nContactpersoon: {$inschrijving.naam}')">Annuleren</button>
            </td>
        </tr>
        {/foreach}
    </table>
    {else}
    <h4>U heeft geen openstaande inschrijvingen</h4>
    {/if}
    </div>

    <button name="afmelden">Afmelden</button>

    <input type="hidden" name="evt" value="{$evt}">
    <input type="hidden" name="email" value="{$email}">
    <input type="hidden" name="soort" value="{$soort}">
    <input type="hidden" name="klant" value="{$klant}">
    <input type="hidden" name="evenementnaam" value="{$evenementnaam}">
    <input type="hidden" name="contactpersoonId" value="{$contactpersoonId}">
    
  {include file="statusregel.tpl"}

</form>

<script>
    function verwijderKlik(naam)
    {
        return confirm( naam + "\n\nWeet u zeker dat u deze inschrijving wilt annuleren?\nNa annuleren heeft u geen toegang meer tot deze inschrijving!");
    }
 </script>

{include file="footer.tpl"}