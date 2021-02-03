{include file="openheader.tpl"}
<script type="text/javascript" src="js/nicEdit.js"></script> 
{include file="closeheader.tpl"}

<form method="post" action="{$SCRIPT_NAME}">
    <h2>{$doctitle}</h2>

    <table>
        <thead>
            <tr>
                <th>Klantgegevens</th>
                <th>Inschrijvingen</th>
                <th>Betaling</th>
                <th>Status</th>
            </tr>
        </thead>

        <tr>
            <td>
                Klant Id: {$id}<br />
                Naam: {$naam}<br />
                Adres: {$straat} {$huisnummer} {$huisnummer_toevoeging}<br />
                Plaats: {$postcode} {$woonplaats} {$landnaam}<br />
                Geb.dat.: {$geboortedatum}<br />
                Telefooon: {$telefoonnummer}<br />
                E-mail: {$email}<br/>
                {if $geslacht != "" }
                  Geslacht: {$geslacht}<br/>
                {/if}
            </td>
            <td>
                {foreach $inschrijving_lijst as $inschrijving}
                  <a href="inschrijving_gegevens.php?id={$inschrijving.inschrijfnr}">{$inschrijving.inschrijfnr}</a> {$inschrijving.evenement}<br/>
                {/foreach}
            </td>
            <td>
                {if $voucherCode != ""}
                <a href="voucher_wijzigen.php?id={$voucherId}">Voucher: {$voucherCode}</a>
                {/if}
            </td>
            <td>
            </td>
        </tr>
    </table>
    <br/>
    
    <div>
        Contact info toevoegen:<br/>
        <textarea rows="5" cols="90" name="nieuweLog" id="nieuweLog">{$nieuweLog}</textarea><br/>
        <span class="error">{$nieuweLogErr}</span>
        <br/>
        <button name="toevoegen">Toevoegen</button> 
        <button name="terug">Terug</button> 
    </div>
    <br/>

    <div>
        Klantcontacten:
        {if $invers == 0}
        <input class="barebutton" type="button" name="invers" value="Zet oudste bovenaan" onclick="oudste()">
        {else}
        <input class="barebutton" type="button" name="gewoon" value="Zet nieuwste bovenaan" onclick="nieuwste()">
        {/if}    
        <br/>
        <textarea rows="15" cols="90" name="klantcontact" id="klantcontact" readonly>{$logTekst}</textarea>
        <br/>
    </div>

    <button name="terug">Terug</button> 

    <input type="hidden" name="id" id="id" value={$id}>
</form>

{include file="statusregel.tpl"}

<script>
    bkLib.onDomLoaded(function() { klantcontactRO(); } );
    function klantcontactRO()
    {
        klantcontact = new nicEditor( { imageURI : '{$imageDirectory}', buttonList : [] } ).panelInstance('klantcontact' );

        nicEditors.findEditor("klantcontact").disable();
    }

    function oudste()
    {
        window.location.assign( "persoon_gegevens.php?prs=" + {$id} + "&invers=1" );
    }
    function nieuwste()
    {
        window.location.assign( "persoon_gegevens.php?prs=" + {$id} );
    }
</script>

{include file="footer.tpl"}