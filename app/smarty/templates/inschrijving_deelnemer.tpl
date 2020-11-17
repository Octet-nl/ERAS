{include file="header-klant.tpl"}

<div class="tlwrapper">
	<ol class="timeline">
		<li class="timeline-past">
            <span>Contactpersooon</span>
        </li>
		<li class="timeline-current">
            <span>Deelnemer toevoegen</span>
		</li>
		<li><span>Overzicht</span></li>
		<li><span>Betaling</span></li>
		<li><span>Inschrijving gereed</span></li>
	</ol>
</div>

    {include file="js/deelnemer_prijs.js"}

    <form method="post" id="form1" action="{$SCRIPT_NAME}">

        {if !$wijzigingDefinitieveInschrijving}
        <div class="zweven">
            <div align="right">
                Evenement prijs: &euro;
                <input type="text" class="xshort" name="evenement prijs" id="extra_bedrag1" value="{$prijs_per_persoon}" readonly onblur="addPrices()">
                <input type="hidden" id="extra_prijs1" value="{$prijs_per_persoon}">
            </div>
            <div align="right">
                Totaal inclusief opties: &euro;
                <input type="text" class="xshort" name="totaalprijs" id="subtotaal" value="0.00" readonly>
            </div>
        </div>
        {/if}

        <h2>Inschrijving deelnemer voor {$evenement_naam}</h2>

        <h4>Inschrijving nummer: {$inschrijvingnummer}</h4>

        <h4>Contactpersoon: {$contactpersoon_naam}</h4>
   
        <h4>Deelnemer gegevens {$extra_tekst}</h4>

        {include file="persoonsgegevens.tpl"}

        {$dynamichtml}

        <br/>
        <span class="error">{$validatiemelding}</span>

        <button name="annuleren" onclick="location.href = document.referrer; return false;">Terug</button>
        <button name="opslaan">Opslaan >></button>

        <input type="hidden" name="wijzigingDefinitieveInschrijving" value="{$wijzigingDefinitieveInschrijving}">
        <input type="hidden" name="deelnemerId" value="{$deelnemerId}">
        <input type="hidden" name="persoonId" value="{$persoonId}">

        {include file="statusregel.tpl"}

    </form>

{include file="footer.tpl"}