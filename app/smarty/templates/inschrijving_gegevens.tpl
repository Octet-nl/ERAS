{include file="header.tpl"}

<form method="post" action="{$SCRIPT_NAME}">
    <h2>Inschrijving nr. {$inschrijving.id}</h2>

    <table>
        <thead>
            <tr>
                <th>Evenement</th>
                <th>Contact gegevens</th>
                <th>Betaling</th>
                <th>Status</th>
            </tr>
        </thead>

        <tr>
            <td>
                <b>{$inschrijving.evenement_naam}</b><br />
                <a href=inschrijving_overzicht.php?iid={$inschrijving.id}>Inschrijfnummer: {$inschrijving.id}</a><br />
                Inschrijfdatum: {$inschrijving.datum}<br />
                <a href="persoon_aanpassen.php?all=1&prs={$inschrijving.contactid}">Contact: {$inschrijving.naam}</a>

                <!--
                    Dit werkt niet goed, bij 'terug' krijg je een foutmelding.
                <a href=inschrijving_contactpersoon.php?prs={$inschrijving.contactid}>Contact: {$inschrijving.naam}</a><br />
                -->
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
                Te betalen: {$inschrijving.te_betalen}<br />
                <a href=betaling_opvoeren.php?iid={$inschrijving.id}>Boeken</a>
            </td>
            <td>
                {$inschrijving.status}
            </td>
        </tr>

    </table>

    <h2>Deelnemers</h2>
    <table>
        <thead>
        <tr>
           <th>Deelnemer<br/>nummer</th>
           <th>Naam</th>
           <th>Adres</th>
           <th>Geboortedatum</th>
           <th>Email</th>
           <th>Totaalbedrag</th>
           <th>Inschrijving<br/>status</th>
        </tr>
        </thead>

      {foreach $deelnemerLijst as $deelnemer}
          <tr>
            <td>                
                {$deelnemer.deelnemer_nummer}
            </td>
            <td>
                <a href="persoon_aanpassen.php?all=1&prs={$deelnemer.persoon_nummer}">{$deelnemer.naam}</a>
            </td>
            <td>
                {$deelnemer.straat}
                {$deelnemer.huisnummer}<br/>
                {$deelnemer.postcode} 
                {$deelnemer.woonplaats}<br/>
            </td>
            <td>
                {$deelnemer.geboortedatum}<br/>
            </td>
            <td>
                {$deelnemer.email}
            </td>
            <td>
              {$deelnemer.totaalbedrag}
            </td>
            <td>
              {$deelnemer.status}
            </td>
          </tr>
     {/foreach}
     </table>

    <button name="terug">Terug</button> 

    {include file="statusregel.tpl"}

</form>

<script>
    function verwijderKlik(naam)
    {
        return confirm( naam + "\n\nWeet u zeker dat u deze inschrijving wilt annuleren?\nNa annuleren heeft de klant geen toegang meer tot deze inschrijving!");
    }
 </script>

{include file="footer.tpl"}