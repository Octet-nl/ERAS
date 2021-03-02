{include file="header.tpl"}

<form method="post" action="{$SCRIPT_NAME}">

    <div class="linkszweven">
        Evenement:
        <select name="evenement">
            {html_options options=$evenementenLijst selected=$evenementid}
        </select>
    Status:
        <button name="stat_all">Alle</button>
        <button name="stat_open">Open</button>
        <button name="stat_def">Definitief</button>
        <button name="stat_deb">Onbetaald</button>
        <button name="stat_ann">Geannuleerd</button>
        <button name="terug">Terug</button> 
    </div>

    <h2 style="margin-top: 5em;">Inschrijvingen ({$aantal})</h2>
<br/>
    {if not $Inschrijvingen}
      {if $isget == '1'}
        <br/>Kies een evenement<br/>
      {else}
        <br/>Geen evenementen gevonden voor deze criteria<br/>
      {/if}
    {else}
    <table>
        <thead>
            <tr>
                <th>Evenement</th>
                <th>Contact gegevens</th>
                <th>Betaling</th>
                <th>Status</th>
                <th>Annulerings<br/>verzekering</th>
                <th>Actie</th>
            </tr>
        </thead>

        {foreach $Inschrijvingen as $inschrijving}
        <tr>
            <td>
                <b>{$inschrijving.evenement_naam}</b><br />
                Inschrijfnummer:<a href="inschrijving_gegevens.php?id={$inschrijving.id}">{$inschrijving.id}</a><br/>
                Inschrijfdatum: {$inschrijving.datum}<br />
                Aantal deelnemers: {$inschrijving.aantal_deelnemers}<br />
                Contact: {$inschrijving.naam}
            </td>
            <td>
                Geb.dat. {$inschrijving.geboortedatum}<br />
                {$inschrijving.telefoon}<br />
                <a href=mailto://{$inschrijving.email}>{$inschrijving.email} </a> <br />
                {$inschrijving.straat} {$inschrijving.huisnummer}<br />
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
                {if $inschrijving.status == {$statusDefinitief} || $inschrijving.status == {$statusGeannuleerd} }
                  <button name="open" value={$inschrijving.id} onclick="return openKlik('Inschrijving nummer {$inschrijving.id}\nvan {$inschrijving.naam} openen')">Heropen<br/>inschrijving</button> 
                {/if}
            </td>
            <td>
                {$inschrijving.annuleringsverzekering}<br/>
                Afgesloten: {$inschrijving.avafgesloten}
            </td>
            <td>

                <button name="aanpassen" value={$inschrijving.id}>Aanpassen</button>
                <button name="betaling" value={$inschrijving.id}>Betaling</button>
                {if file_exists( "{$factuurdir}{$inschrijving.factuurnummer}.pdf"  ) }
                <button name="factuur" value={$inschrijving.factuurnummer}>Factuur</button> 
                {/if}
                <button name="annuleer" value={$inschrijving.id} onclick="return verwijderKlik('Inschrijving nummer {$inschrijving.id}\nvan {$inschrijving.naam}')">Annuleer</button>
            </td>
        </tr>
        {/foreach}
    </table>
    {/if}

    <button name="terug">Terug</button> 
    
    <input type="hidden" name="evt" value="{$evt}">

    {include file="statusregel.tpl"}

</form>

<script>
    function verwijderKlik(naam)
    {
        return confirm( naam + "\n\nWeet u zeker dat u deze inschrijving wilt annuleren?\nNa annuleren heeft de klant geen toegang meer tot deze inschrijving!");
    }
    function openKlik(naam)
    {
        return confirm( naam + "\n\nWeet u zeker dat u deze inschrijving opnieuw wilt openen?\n\nEr worden geen automatische controles uitgevoerd, dus u moet zelf betaling e.d. controleren en aanpassen!\n\nBij het opnieuw definitief maken krijgt de klant nogmaals een bevestiging, en indien dit geaktiveerd is een factuur!");
    }
 </script>

{include file="footer.tpl"}