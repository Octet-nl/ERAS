{include file="header.tpl"}

<form method="post" action="{$SCRIPT_NAME}">

    <h2>{$doctitle} ({$aantal})</h2>

    <h3>Let op:</h3>
    Deze toepassing is alleen bedoeld voor het terugzetten van het vinkje "afgesloten" bij een annuleringsverzekering.<br/>
    Een eventuele verzekering wordt echter NIET ongedaan gemaakt.<br/>
    Het betreft hier alleen een administratieve handeling!

    <br/><br/><br/>
    Evenement:
    <select name="evenement" onchange="submit();">
        {html_options options=$evenementenLijst selected=$evenementid}
    </select>

    <br/><br/>
    {if not $Inschrijvingen}
      <br/>Er zijn geen inschrijvingen voor dit evenement gevonden waarvoor al een annuleringsverzekering is afgesloten.<br/>
    {else} 
    <table>
        <thead>
            <tr>
                <th>Evenement</th>
                <th>Contact gegevens</th>
                <th>Annuleringsverzekering</th>
                <th>Niet afgesloten</th>
            </tr>
        </thead>

        {foreach $Inschrijvingen as $inschrijving}
        <tr>
            <td>
                <b>{$inschrijving.evenement_naam}</b><br />
                Inschrijfnummer:<a href="inschrijving_gegevens.php?id={$inschrijving.id}">{$inschrijving.id}</a><br/>
            </td>
            <td>
                {$inschrijving.naam}<br/>
                {$inschrijving.straat} {$inschrijving.huisnummer} 
                {$inschrijving.postcode} {$inschrijving.woonplaats}
                {$inschrijving.telefoon}<br />
                <a href=mailto://{$inschrijving.email}>{$inschrijving.email} </a> <br />
            </td>
            <td>
                {$inschrijving.annulering}<br/>
                Afgesloten op: {$inschrijving.afgeslotenop}
            </td>
            <td>
                <button name="ongedaan" value={$inschrijving.id}>Bevestig</button>
                of
                <input type="checkbox" id="{$inschrijving.id}" name="id[]" value="{$inschrijving.id}">
            </td>
        </tr>
        {/foreach}
        <tr>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
                <button name="aangevinkt">Bevestig geselecteerd</button>
            </td>
        </tr>

    </table>
    {/if}

    <button name="afsluiten">Ga naar annuleringsverzekering afsluiten</button> 
    <button name="terug">Terug</button> 
    
    <input type="hidden" name="evt" value="{$evt}">

    {include file="statusregel.tpl"}

</form>

{include file="footer.tpl"}