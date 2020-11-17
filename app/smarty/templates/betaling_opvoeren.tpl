{include file="header.tpl"}

<form method="post" action="{$SCRIPT_NAME}">
<div class="window_back_half">
    <h2>{$doctitle}</h2>

    <div><br /><br />
            <table class="noborder">
            <tr>
                <td class="noborder">
                    Evenement:
                </td> 
                <td class="noborder">
                    {$evenementNaam}
                </td>                    
            </tr>
            <tr>
                <td class="noborder">
                    Inschrijfnummer:
                </td> 
                <td class="noborder">
                    {$inschrijfnummer}
                </td>                    
            </tr>
            <tr>
                <td class="noborder">
                    Contactpersoon:
                </td> 
                <td class="noborder">
                    {$contactNaam}
                </td>                    
            </tr>
            </table>

        <br/>
        <label for="totaal_bedrag">Totaalbedrag: &euro;</label>
        <input class="short" type="text" id="totaalBedrag" name="totaalBedrag" placeholder="123.45" value="{$totaalBedrag}" readonly><br />
        <label for="reeds_betaald">Bedrag reeds betaald: &euro;</label>
        <input class="short" type="text" id="reedsBetaald" name="reedsBetaald" placeholder="123.45" value="{$reedsBetaald}" onblur="addPrices()" readonly><br />
        <label for="korting">Bedrag korting: &euro;</label>
        <input class="short" type="text"  id="korting" name="korting" placeholder="123.45" value="{$korting}" onblur="format()"><br />
        <label for="korting">Bedrag nu betaald: &euro;</label>
        <input class="short" type="text"  id="nuBetaald" name="nuBetaald" placeholder="123.45" value="{$nuBetaald}" onblur="format()">
        <input class="calcIcon" id="allesBetaald" type="button" onclick="isBetaald()" /><br />
        <label for="te_betalen">Bedrag nog te betalen: &euro;</label>
        <input class="short" type="text" id="teBetalen" name="teBetalen" placeholder="123.45" value="{$teBetalen}" readonly><br />
        <label for="omschrijving">Omschrijving: </label>
        <textarea rows="5" cols="60" name="omschrijving" id="omschrijving">{$omschrijving}</textarea>
        <br />
    </div>

    <button name="opslaan">Opslaan</button> 
    <button name="terug">Terug</button>
</div>

    <input type="hidden" name="inschrijfnummer" value="{$inschrijfnummer}">
    <input type="hidden" name="contactPersoonId" value="{$contactPersoonId}">
    
</form>

{include file="js/secretariaat_betaling_prijs.js"}

{include file="footer.tpl"}