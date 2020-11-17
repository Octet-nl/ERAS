{include file="header.tpl"}

<form method="post" action="{$SCRIPT_NAME}">

    <h2>{$doctitle} ({$aantal})</h2>
    Evenement:
    <select name="evenement" onchange="submit();">
        {html_options options=$evenementenLijst selected=$evenementid}
    </select>

    <br/><br/>
    {if not $Inschrijvingen}
      <br/>Er zijn geen inschrijvingen voor dit evenement gevonden waarvoor nog een annuleringsverzekering moet worden afgesloten.<br/>
    {else} 
    <table>
        <thead>
            <tr>
                <th>Evenement</th>
                <th>Contact gegevens</th>
                <th>Annuleringsverzekering</th>
                <th>Is afgesloten</th>
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
                {$inschrijving.annulering}
            </td>
            <td>
                <button name="bevestig" value={$inschrijving.id}>Bevestig</button>
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

    <button name="ongedaan">Herstel per ongeluk afgesloten verzekering</button> 
    <button name="terug">Terug</button> 
    
    <input type="hidden" name="evt" value="{$evt}">

    {include file="statusregel.tpl"}

</form>

{include file="footer.tpl"}