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
        <div class="window_back" style="width:100%">
            <h3>Organisatie</h3>
            <div class="setting_input">
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
               <span class=setting_label>Adres van de voorwaarden voor de annuleringsverzekering</span>
               <input type="text" class="setting_input" name="organisatieVerzekeringVoorwaarden" value="{$organisatieVerzekeringVoorwaarden}">
               <span class="error">{$organisatieVerzekeringVoorwaardenErr}</span>
            </div>
        </div>

        <div class="window_back" style="width:100%">
            <h3>Bankgegevens</h3>
            <div class="setting_input">
               <span class=setting_label>Banknummer (IBAN)</span>
               <input type="text" class="setting_input" name="bankIbanNummer" value="{$bankIbanNummer}">
               <span class="error">{$bankIbanNummerErr}</span>
               <span class=setting_label>Bank code (BIC/SWIFT)</span>
               <input type="text" class="setting_input" name="bankBicNummer" value="{$bankBicNummer}">
               <span class="error">{$bankBicNummerErr}</span>
               <span class=setting_label>Ten name van</span>
               <input type="text" class="setting_input" name="bankTenNameVan" value="{$bankTenNameVan}">
               <span class="error">{$bankTenNameVanErr}</span>
            </div>
        </div>

        <div class="window_back" style="width:100%">
            <h3>Factuur</h3>
            <div class="setting_input">
                <span class=setting_label>Factuur aanmaken ({$ja}/{$nee})</span>
                <input type="text" class="setting_input" name="factuurAanmaken" value="{$factuurAanmaken}">
                <span class="error">{$factuurAanmakenErr}</span>
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
            </div>
        </div>

        <div class="window_back" style="width:100%">
            <h3>iDEAL betaling</h3>
            <div class="setting_input">
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
            </div>
        </div>

        <div class="window_back" style="width:100%">
            <h3>Betaling</h3>
            <div class="setting_input">
                <span class=setting_label>Betalingsvoorwaarden op de bevestigingsmail</span><br/>
                <textarea rows="10" cols="90" name="betalingVoorwaarden" id="betalingVoorwaarden">{$betalingVoorwaarden}</textarea>
                <button type="button" class="bareleft" onClick="toggleBetalingVoorwaarden();">HTML</button>
                <span class="error">{$betalingVoorwaardenErr}</span>
            </div>
        </div>

        <div class="window_back" style="width:100%">
            <h3>Directories</h3>
            <div class="setting_input">
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
            </div>
        </div>

        <div class="window_back" style="width:100%">
            <h3>Instellingen</h3>
            <div class="setting_input">
                <span class=setting_label>Maximaal aantal mails dat tegelijk verstuurd kan worden</span>
                <input style="width:8em" type="text" class="setting_input" name="settingBatchSize" value="{$settingBatchSize}">
                <div class="tooltip">?
                    <span class="tooltiptext right">Veel providers stellen een grens aan het maximaal in één keer te verzenden mails. Voor de nieuwbrief is dat soms onvoldoende. Geef hier aan hoeveel mails tegelijk verstuurd kunnen worden. Zijn het er meer, dan wordt een batchverwerking aangeboden.</span>
                </div>
                <span class="error">{$settingBatchSizeErr}</span>
            </div>
        </div>

        <button name="opslaan">Opslaan</button>
        <button name="terug">Terug</button> 
        <br/><br/><br/>
        {include file="statusregel.tpl"}
    </form>

<script>
    var betalingVoorwaarden = null;

    // {if $toonWysiwig}

    bkLib.onDomLoaded(function() { toggleBetalingVoorwaarden(); } );

    // {/if}

    function toggleBetalingVoorwaarden() 
    {
        if(!betalingVoorwaarden) {
            betalingVoorwaarden = new nicEditor( { imageURI : '{$imageDirectory}' } ).panelInstance('betalingVoorwaarden' );
        } else {
            betalingVoorwaarden.removeInstance('betalingVoorwaarden');
            betalingVoorwaarden = null;
        }
    }
</script>
{include file="footer.tpl"}
