{include file="openheader.tpl"}
    <script type="text/javascript" src="js/nicEdit.js"></script> 
{include file="closeheader.tpl"}
<body>
    <form method="post" action="{$SCRIPT_NAME}">
        <div class="zweven">
            <button name="opslaan">Opslaan</button>
            <button name="terug">Terug</button>
        </div>
        <h2>{$doctitle}</h2>

        <button class="softbutton" type="button" onclick='allesKlappen(7, false);' title="Alles inklappen">Inklappen</button>
        <button class="softbutton" type="button" onclick='allesKlappen(7, true);' title="Alles uitklappen">Uitklappen</button>

        <div class="window_back" style="width:100%">
            <input type="checkbox" id="1" checked onchange='handleChecked(this,document.getElementById("organisatie"));'/> 
            <h3 style="display: inline-block;">Organisatie</h3>
            <fieldset id="organisatie" class="setting_input">
               <span class=setting_label>Naam van de organisatie</span>
               <input type="text" class="setting_input" name="organisatieNaam" value="{$organisatieNaam}">
               <span class="error">{$organisatieNaamErr}</span>
               <span class=setting_label>E-mail adres</span>
               <input type="text" class="setting_input" name="organisatieEmail" value="{$organisatieEmail}">
               <span class="error">{$organisatieEmailErr}</span>
               <span class=setting_label>Website adres</span>
               <input type="text" class="setting_input" name="organisatieWebsite" value="{$organisatieWebsite}">
               <span class="error">{$organisatieWebsiteErr}</span>
               <span class=setting_label>Adres van de leveringsvoorwaarden van de organisatie</span>
               <input type="text" class="setting_input" name="organisatieVoorwaarden" value="{$organisatieVoorwaarden}">
               <span class="error">{$organisatieVoorwaardenErr}</span>
            </fieldset>
        </div>

        <div class="window_back" style="width:100%">
            <input type="checkbox" id="3" checked onchange='handleChecked(this,document.getElementById("factuur"));'/> 
            <h3 style="display: inline-block;">Factuur</h3>
            <fieldset id="factuur" class="setting_input">
                <span class=setting_label>Factuur aanmaken ({$ja}/{$nee})</span>
                <input type="text" class="setting_input" name="factuurAanmaken" value="{$factuurAanmaken}">
                <span class="error">{$factuurAanmakenErr}</span>

                <div class="window_back" style="width:100%">
                    <input type="checkbox" id="2" checked onchange='handleChecked(this,document.getElementById("bankgegevens"));'/> 
                    <h3 style="display: inline-block;">Bankgegevens</h3>
                    <fieldset id="bankgegevens" class="setting_input">
                       <span class=setting_label>Banknummer (IBAN)</span>
                       <input type="text" class="setting_input" name="bankIbanNummer" value="{$bankIbanNummer}">
                       <span class="error">{$bankIbanNummerErr}</span>
                       <span class=setting_label>Bank code (BIC/SWIFT)</span>
                       <input type="text" class="setting_input" name="bankBicNummer" value="{$bankBicNummer}">
                       <span class="error">{$bankBicNummerErr}</span>
                       <span class=setting_label>Ten name van</span>
                       <input type="text" class="setting_input" name="bankTenNameVan" value="{$bankTenNameVan}">
                       <span class="error">{$bankTenNameVanErr}</span>
                    </fieldset>
                </div>
        
                <span class=setting_label>Factuur verzenden ({$ja}/{$nee})</span>
                <input type="text" class="setting_input" name="factuurVerzenden" value="{$factuurVerzenden}">
                <span class="error">{$factuurVerzendenErr}</span>
                <span class=setting_label>Titel van de factuur</span>
                <input type="text" class="setting_input" name="factuurTitel" value="{$factuurTitel}">
                <span class="error">{$factuurTitelErr}</span>
                <span class=setting_label>Soort factuur/rekening</span>
                <input type="text" class="setting_input" name="factuurNotatype" value="{$factuurNotatype}">
                <span class="error">{$factuurNotatypeErr}</span>
                <span class=setting_label>Adres van het logo van de organisatie</span>
                <span><input style="width:60%" type="text" class="setting_input" name="factuurLogo" value="{$factuurLogo}"> Voorbeeld: <img src="{$factuurLogo}" height="50"></span>
                <span class="error">{$factuurLogoErr}</span>
                <span class=setting_label>Bodemregel (plaats hier uw wervende tekst)</span>
                <input style="width:100%" type="text" class="setting_input" name="factuurFooter" value="{$factuurFooter}">
                <span class="error">{$factuurFooterErr}</span>
                <span class=setting_label>Adresregel</span>
                <input style="width:100%" type="text" class="setting_input" name="factuurAdresregel" value="{$factuurAdresregel}">
                <span class="error">{$factuurAdresregelErr}</span>
                <span class=setting_label>Kopteksten per kolom voor Evenement</span>
                <input style="width:8em" type="text" class="setting_input" name="factuurEvenementKolom1" value="{$factuurEvenementKolom1}">
                <span class="error">{$factuurEvenementKolom1Err}</span>
                <input style="width:8em" type="text" class="setting_input" name="factuurEvenementKolom2" value="{$factuurEvenementKolom2}">
                <span class="error">{$factuurEvenementKolom2Err}</span>
                <input style="width:8em" type="text" class="setting_input" name="factuurEvenementKolom3" value="{$factuurEvenementKolom3}">
                <span class="error">{$factuurEvenementKolom3Err}</span>
                <input style="width:8em" type="text" class="setting_input" name="factuurEvenementKolom4" value="{$factuurEvenementKolom4}">
                <span class="error">{$factuurEvenementKolom4Err}</span>
                <input style="width:8em" type="text" class="setting_input" name="factuurEvenementKolom5" value="{$factuurEvenementKolom5}">
                <span class="error">{$factuurEvenementKolom5Err}</span>
                <span class=setting_label>Kopteksten per kolom voor Deelnemers</span>
                <input style="width:8em" type="text" class="setting_input" name="factuurDeelnemerKolom1" value="{$factuurDeelnemerKolom1}">
                <span class="error">{$factuurDeelnemerKolom1Err}</span>
                <input style="width:8em" type="text" class="setting_input" name="factuurDeelnemerKolom2" value="{$factuurDeelnemerKolom2}">
                <span class="error">{$factuurDeelnemerKolom2Err}</span>
                <input style="width:8em" type="text" class="setting_input" name="factuurDeelnemerKolom3" value="{$factuurDeelnemerKolom3}">
                <span class="error">{$factuurDeelnemerKolom3Err}</span>
                <input style="width:8em" type="text" class="setting_input" name="factuurDeelnemerKolom4" value="{$factuurDeelnemerKolom4}">
                <span class="error">{$factuurDeelnemerKolom4Err}</span>
                <input style="width:8em" type="text" class="setting_input" name="factuurDeelnemerKolom5" value="{$factuurDeelnemerKolom5}">
                <span class=setting_label>BTW percentage</span>
                <input style="width:8em" type="text" class="setting_input" name="factuurBtwPercentage" value="{$factuurBtwPercentage}">
                <span class="error">{$factuurBtwPercentageErr}</span>
                <span class=setting_label>Teksten voor BTW gegevens</span>
                <input style="width:8em" type="text" class="setting_input" name="factuurBtwRegel1" value="{$factuurBtwRegel1}"><br/>
                <span class="error">{$factuurBtwRegel1Err}</span>
                <input style="width:8em" type="text" class="setting_input" name="factuurBtwRegel2" value="{$factuurBtwRegel2}"><br/>
                <span class="error">{$factuurBtwRegel2Err}</span>
                <input style="width:8em" type="text" class="setting_input" name="factuurBtwRegel3" value="{$factuurBtwRegel3}">
                <span class="error">{$factuurBtwRegel3Err}</span>
            </fieldset>
        </div>

        <div class="window_back" style="width:100%">
            <input type="checkbox" id="4" checked onchange='handleChecked(this,document.getElementById("iDeal"));'/> 
            <h3 style="display: inline-block;">iDEAL betaling</h3>
            <fieldset id="iDeal" class="setting_input">
                <span class=setting_label>iDeal betalingen toestaan ({$ja}/{$nee})</span>
                <input type="text" class="setting_input" name="enableIDeal" value="{$enableIDeal}">
                <span class="error">{$enableIDealErr}</span>
                <span class=setting_label>Adres van de routine die de iDeal betaling verzorgt</span>
                <input type="text" class="setting_input" name="idealCheckout" value="{$idealCheckout}">
                <span class="error">{$idealCheckoutErr}</span>
                <span class=setting_label>Adres van de routine/html die aangeroepen wordt als de betaling gelukt is</span>
                <input type="text" class="setting_input" name="idealStatusSuccess" value="{$idealStatusSuccess}">
                <span class="error">{$idealStatusSuccessErr}</span>
                <span class=setting_label>Adres van de routine/html die aangeroepen wordt als de betaling voortijdig gestopt is</span>
                <input type="text" class="setting_input" name="idealStatusStopped" value="{$idealStatusStopped}">
                <span class="error">{$idealStatusStoppedErr}</span>
                <span class=setting_label>Adres van de routine/html die aangeroepen wordt als de betaling mislukt is</span>
                <input type="text" class="setting_input" name="idealStatusFailure" value="{$idealStatusFailure}">
                <span class="error">{$idealStatusFailureErr}</span>
                <span class=setting_label>Adres van de routine/html die aangeroepen wordt als de betaling (nog) niet correct is afgehandeld</span>
                <input type="text" class="setting_input" name="idealStatusPending" value="{$idealStatusPending}">
                <span class="error">{$idealStatusPendingErr}</span>
            </fieldset>
        </div>

        <div class="window_back" style="width:100%">
            <input type="checkbox" id="5" checked onchange='handleChecked(this,document.getElementById("betaling"));'/> 
            <h3 style="display: inline-block;">Betaling</h3>
            <fieldset id="betaling" class="setting_input">
                <button type="button" class="bareleft" onClick="toggleBetalingVoorwaarden();">HTML</button>
                <span class=setting_label>Tekst op de bevestigingsmail bij betaling per incasso</span><br/>
                <textarea rows="10" cols="90" name="betalingIncassoTekst" id="betalingIncassoTekst">{$betalingIncassoTekst}</textarea>
                <span class="error">{$betalingIncassoTekstErr}</span>
                <span class=setting_label>Tekst op de bevestigingsmail bij contante betaling</span><br/>
                <textarea rows="10" cols="90" name="betalingContantTekst" id="betalingContantTekst">{$betalingContantTekst}</textarea>
                <span class="error">{$betalingContantTekstErr}</span>
                <span class=setting_label>Voorwaarden op de bevestigingsmail bij andere betaling</span><br/>
                <textarea rows="10" cols="90" name="betalingVoorwaarden" id="betalingVoorwaarden">{$betalingVoorwaarden}</textarea>
                <span class="error">{$betalingVoorwaardenErr}</span>
            </fieldset>
        </div>

        <div class="window_back" style="width:100%">
            <input type="checkbox" id="6" checked onchange='handleChecked(this,document.getElementById("directories"));'/> 
            <h3 style="display: inline-block;">Directories</h3>
            <fieldset id="directories" class="setting_input">
                <span class=setting_label>Directory waar de tijdelijke bestanden geplaatst kunnen worden</span>
                <input type="text" class="setting_input" name="settingTempDirectory" value="{$settingTempDirectory}">
                <span class="error">{$settingTempDirectoryErr}</span>
                <span class=setting_label>Directory waar de logbestanden geplaatst worden</span>
                <input type="text" class="setting_input" name="settingLogDirectory" value="{$settingLogDirectory}">
                <span class="error">{$settingLogDirectoryErr}</span>
                <span class=setting_label>Directory waar de facturen geplaatst worden</span>
                <input type="text" class="setting_input" name="settingFacturenDirectory" value="{$settingFacturenDirectory}">
                <span class="error">{$settingFacturenDirectoryErr}</span>
                <span class=setting_label>Directory waar de afbeeldingen geplaatst worden</span>
                <input type="text" class="setting_input" name="settingImageDirectory" value="{$settingImageDirectory}">
                <span class="error">{$settingImageDirectoryErr}</span>
            </fieldset>
        </div>

        <div class="window_back" style="width:100%">
            <input type="checkbox" id="7" checked onchange='handleChecked(this,document.getElementById("instellingen"));'/> 
            <h3 style="display: inline-block;">Instellingen</h3>
            <fieldset id="instellingen" class="setting_input">
                <span class=setting_label>Maximaal aantal mails dat tegelijk verstuurd kan worden</span>
                <input style="width:8em" type="text" class="setting_input" name="settingBatchSize" value="{$settingBatchSize}">
                <div class="tooltip">?
                    <span class="tooltiptext right">Veel providers stellen een grens aan het maximaal in één keer te verzenden mails. Voor de nieuwbrief is dat soms onvoldoende. Geef hier aan hoeveel mails tegelijk verstuurd kunnen worden. Zijn het er meer, dan wordt een batchverwerking aangeboden.</span>
                </div>
                <span class="error">{$settingBatchSizeErr}</span>
                
                <span class=setting_label>Annuleringsverzekering mogelijk? ({$ja}/{$nee})</span>
                <input type="text" class="setting_input" name="enableVerzekering" value="{$enableVerzekering}">
                <div class="tooltip">?
                    <span class="tooltiptext right">Biedt uw organisatie de mogelijkheid om annuleringsverzekeringen af te sluiten? Als u "ja" invult kunt u dit later per evenement aan- of uitzetten. Als u hier "nee" invult wordt de vraag niet gesteld.</span>
                </div>
                <span class="error">{$enableVerzekeringErr}</span>
                <span class=setting_label>Adres van de voorwaarden voor de annuleringsverzekering (als annuleringsverzekering mogelijk is)</span>
                <input type="text" class="setting_input" name="settingVerzekeringVoorwaarden" value="{$settingVerzekeringVoorwaarden}">
                <span class="error">{$settingVerzekeringVoorwaardenErr}</span>

                
            </fieldset>
        </div>

        <button name="opslaan">Opslaan</button>
        <button name="terug">Terug</button> 
        <br/><br/><br/>
        {include file="statusregel.tpl"}
    </form>

<script>
    var betalingVoorwaarden = null;
    var betalingContant = null;
    var betalingIncasso = null;

    // {if $toonWysiwig}
    window.onload = function() 
    {
        betalingContant = new nicEditor( { imageURI : '{$imageDirectory}' } ).panelInstance('betalingContantTekst' );
        betalingIncasso = new nicEditor( { imageURI : '{$imageDirectory}' } ).panelInstance('betalingIncassoTekst' );
        betalingVoorwaarden = new nicEditor( { imageURI : '{$imageDirectory}' } ).panelInstance('betalingVoorwaarden' );
    };
    // {/if}

    function toggleBetalingVoorwaarden() 
    {
        if(!betalingVoorwaarden) 
        {
            betalingContant = new nicEditor( { imageURI : '{$imageDirectory}' } ).panelInstance('betalingContantTekst' );
            betalingIncasso = new nicEditor( { imageURI : '{$imageDirectory}' } ).panelInstance('betalingIncassoTekst' );
            betalingVoorwaarden = new nicEditor( { imageURI : '{$imageDirectory}' } ).panelInstance('betalingVoorwaarden' );
        }
        else 
        {
            betalingContant.removeInstance('betalingContantTekst');
            betalingIncasso.removeInstance('betalingIncassoTekst');
            betalingVoorwaarden.removeInstance('betalingVoorwaarden');
            betalingContant = null;
            betalingIncasso = null;
            betalingVoorwaarden = null;
        }
    }

    function handleChecked( checkbox, fieldset )
    {
        if ( checkbox.checked )
        {
            fieldset.style.display = "block";
        }
        else
        {
            fieldset.style.display = "none";
        }
    }

    function allesKlappen( aantal, inuit )
    {
        for ( i = 1; i < aantal + 1; i++ )
        {
            var n = i.toString();
            var element = document.getElementById(n);
            element.checked = inuit;
            var event = new Event('change');
            element.dispatchEvent(event);
        }
    }
</script>
{include file="footer.tpl"}
