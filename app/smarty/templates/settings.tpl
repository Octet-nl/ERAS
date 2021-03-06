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

        <button class="softbutton" type="button" onclick='allesKlappen(9, false);' title="Alles inklappen">Inklappen</button>
        <button class="softbutton" type="button" onclick='allesKlappen(9, true);' title="Alles uitklappen">Uitklappen</button>

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
               <div class="tooltip">?
                <span class="tooltiptext right">Optioneel. Als u geen link naar leveringsvoorwaarden invult, wordt er ook geen akkoord met de voorwaarden gevraagd bij het afronden van de inschrijving.</span>
               </div>
               <span class="error">{$organisatieVoorwaardenErr}</span>

               <br/>
               <span class=setting_label>
               <h4>Het logo en de teksten hieronder worden gebruikt in de factuur, de mailings en de bevestigingsmail</h4>
            </span>
               <span class=setting_label>Adres van het logo van de organisatie</span>
               <span><input style="width:60%" type="text" class="setting_input" name="organisatieLogo" value="{$organisatieLogo}"> Voorbeeld: <img src="{$organisatieLogo}" height="50"></span>
               <span class="error">{$organisatieLogoErr}</span>
               <span class=setting_label>Bodemregel (plaats hier uw wervende tekst)</span>
               <input style="width:100%" type="text" class="setting_input" name="organisatieFooter" value="{$organisatieFooter}">
               <span class="error">{$organisatieFooterErr}</span>
               <span class=setting_label>Adresregel</span>
               <input style="width:100%" type="text" class="setting_input" name="organisatieAdresregel" value="{$organisatieAdresregel}">
               <span class="error">{$organisatieAdresregelErr}</span>
           </fieldset>
        </div>

        <div class="window_back" style="width:100%">
            <input type="checkbox" id="3" checked onchange='handleChecked(this,document.getElementById("factuur"));'/> 
            <h3 style="display: inline-block;">Factuur</h3>
            <fieldset id="factuur" class="setting_input">
                <span class=setting_label>Factuur aanmaken:&emsp;
                {html_options name=factuurAanmaken options=$jaNeeLijst selected=$factuurAanmaken}
                </span>
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
        
                <span class=setting_label>Factuur verzenden:&emsp;
                    {html_options name=factuurVerzenden options=$jaNeeLijst selected=$factuurVerzenden}
                    <div class="tooltip">?
                        <span class="tooltiptext right">Als u de factuur automatisch laat verzenden, krijgt deze een factuurnummer van ERAS 
                            toegewezen. Dit werkt prima als u verder geen facturering doet. Heeft u al een ander factureringssysteem 
                            met een eigen nummering, kies hier dan 'nee', 
                            u kunt dan later de facturen verzenden en er uw eigen factuurnummer aan toekennen.
                            <br/><strong>LET OP:</strong><br/>
                            Als u dit wijzigt, denk er dan aan dat uw factuurnummering niet meer een aaneengesloten geheel vormt. 
                            <i>Het is een eis van de belastingdienst dat factuurnummers aaneengesloten zijn!</i></span>
                    </div>        
                </span>
                <span class="error">{$factuurVerzendenErr}</span>
                <span class=setting_label>Titel van de factuur</span>
                <input type="text" class="setting_input" name="factuurTitel" value="{$factuurTitel}">
                <span class="error">{$factuurTitelErr}</span>
                <span class=setting_label>Soort factuur/rekening</span>
                <input type="text" class="setting_input" name="factuurNotatype" value="{$factuurNotatype}">
                <span class="error">{$factuurNotatypeErr}</span>
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
            <input type="checkbox" id="4" checked onchange='handleChecked(this,document.getElementById("tabelkop"));'/> 
            <h3 style="display: inline-block;">Tabel koppen</h3>
            <div class="tooltip">?
                <span class="tooltiptext right">Deze koppen worden gebruikt voor de tabellen in de factuur en in de bevestigingsmail.</span>
            </div>
            <fieldset id="tabelkop" class="setting_input">
                <span class=setting_label>Kopteksten per kolom voor Evenement</span>
                <input style="width:8em" type="text" class="setting_input" name="tabelEvenementKolom1" value="{$tabelEvenementKolom1}">
                <span class="error">{$tabelEvenementKolom1Err}</span>
                <input style="width:8em" type="text" class="setting_input" name="tabelEvenementKolom2" value="{$tabelEvenementKolom2}">
                <span class="error">{$tabelEvenementKolom2Err}</span>
                <input style="width:8em" type="text" class="setting_input" name="tabelEvenementKolom3" value="{$tabelEvenementKolom3}">
                <span class="error">{$tabelEvenementKolom3Err}</span>
                <input style="width:8em" type="text" class="setting_input" name="tabelEvenementKolom4" value="{$tabelEvenementKolom4}">
                <span class="error">{$tabelEvenementKolom4Err}</span>
                <input style="width:8em" type="text" class="setting_input" name="tabelEvenementKolom5" value="{$tabelEvenementKolom5}">
                <span class="error">{$tabelEvenementKolom5Err}</span>
                <span class=setting_label>Kopteksten per kolom voor Deelnemers</span>
                <input style="width:8em" type="text" class="setting_input" name="tabelDeelnemerKolom1" value="{$tabelDeelnemerKolom1}">
                <span class="error">{$tabelDeelnemerKolom1Err}</span>
                <input style="width:8em" type="text" class="setting_input" name="tabelDeelnemerKolom2" value="{$tabelDeelnemerKolom2}">
                <span class="error">{$tabelDeelnemerKolom2Err}</span>
                <input style="width:8em" type="text" class="setting_input" name="tabelDeelnemerKolom3" value="{$tabelDeelnemerKolom3}">
                <span class="error">{$tabelDeelnemerKolom3Err}</span>
                <input style="width:8em" type="text" class="setting_input" name="tabelDeelnemerKolom4" value="{$tabelDeelnemerKolom4}">
                <span class="error">{$tabelDeelnemerKolom4Err}</span>
                <input style="width:8em" type="text" class="setting_input" name="tabelDeelnemerKolom5" value="{$tabelDeelnemerKolom5}">
            </fieldset>
        </div>

        <div class="window_back" style="width:100%">
            <input type="checkbox" id="5" checked onchange='handleChecked(this,document.getElementById("iDeal"));'/> 
            <h3 style="display: inline-block;">iDEAL betaling</h3>
            <fieldset id="iDeal" class="setting_input">
                <span class=setting_label>iDeal betalingen toestaan:&emsp;
                  {html_options name=enableIDeal options=$jaNeeLijst selected=$enableIDeal}
                    <div class="tooltip">?
                        <span class="tooltiptext right">Voor iDeal betaling moet een afzonderlijk programma geinstalleerd worden. 
                            We hebben goede ervaringen met <a href="https://www.ideal-checkout.nl/" target="_blank">ideal-checkout</a>. 
                            Dit werkt goed en is in veel gevallen gratis.</span>
                    </div>
                </span>
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
            <input type="checkbox" id="6" checked onchange='handleChecked(this,document.getElementById("betaling"));'/> 
            <h3 style="display: inline-block;">Betaling</h3>
            <fieldset id="betaling" class="setting_input">
                <button type="button" class="bareleft" onClick="toggleBetalingVoorwaarden();">HTML</button>
                <span class=setting_label>Tekst op de bevestigingsmail bij betaling per incasso
                    <div class="tooltip">?
                        <span class="tooltiptext right">De variabele {literal}{aantal}{/literal} wordt later vervangen door het daadwerkelijk aantal termijnen.</span>
                    </div>
                </span>
                <br/>
                <textarea rows="10" cols="90" name="betalingIncassoTekst" id="betalingIncassoTekst">{$betalingIncassoTekst}</textarea>
                <span class="error">{$betalingIncassoTekstErr}</span>
                <span class=setting_label>Aantal termijnen bij betaling per incasso</span><br/>
                <input type="number" name="betalingIncassoTermijnen" id="betalingIncassoTermijnen" value="{$betalingIncassoTermijnen}">
                <span class="error">{$betalingIncassoTermijnenErr}</span>
                <span class=setting_label>Tekst op de bevestigingsmail bij contante betaling</span><br/>
                <textarea rows="10" cols="90" name="betalingContantTekst" id="betalingContantTekst">{$betalingContantTekst}</textarea>
                <span class="error">{$betalingContantTekstErr}</span>
                <span class=setting_label>Voorwaarden op de bevestigingsmail bij andere betaling</span><br/>
                <textarea rows="10" cols="90" name="betalingVoorwaarden" id="betalingVoorwaarden">{$betalingVoorwaarden}</textarea>
                <span class="error">{$betalingVoorwaardenErr}</span>
            </fieldset>
        </div>

        <div class="window_back" style="width:100%">
            <input type="checkbox" id="8" checked onchange='handleChecked(this,document.getElementById("verzekering"));'/> 
            <h3 style="display: inline-block;">Verzekering</h3>
            <fieldset id="verzekering" class="setting_input">
                <span class=setting_label>Annuleringsverzekering mogelijk:&emsp;
                  {html_options name=enableVerzekering options=$jaNeeLijst selected=$enableVerzekering}
                  <div class="tooltip">?
                    <span class="tooltiptext right">Is het in het algemeen mogelijk om annuleringsverzekeringen af te sluiten? Als u "ja" invult kunt u dit per evenement nog aanpassen. Als u hier "nee" invult, kan dit niet meer aangepast worden.</span>
                  </div>
                </span>
                <span class="error">{$enableVerzekeringErr}</span>
                <span class=setting_label>Adres van de voorwaarden voor de annuleringsverzekering (als annuleringsverzekering mogelijk is)</span>
                <input type="text" class="setting_input" name="settingVerzekeringVoorwaarden" value="{$settingVerzekeringVoorwaarden}">
                <span class="error">{$settingVerzekeringVoorwaardenErr}</span>
            </fieldset>
        </div>

        <div class="window_back" style="width:100%">
            <input type="checkbox" id="9" checked onchange='handleChecked(this,document.getElementById("instellingen"));'/> 
            <h3 style="display: inline-block;">Instellingen</h3>
            <fieldset id="instellingen" class="setting_input">
                <span class=setting_label>Maximaal aantal mails dat tegelijk verstuurd kan worden</span>
                <input style="width:8em" type="text" class="setting_input" name="settingBatchSize" value="{$settingBatchSize}">
                <div class="tooltip">?
                    <span class="tooltiptext right">Veel providers stellen een grens aan het maximaal in één keer te verzenden mails.
                         Voor de nieuwbrief is dat soms onvoldoende. Geef hier aan hoeveel mails tegelijk verstuurd mogen worden. Zijn het er meer, dan wordt een batchverwerking aangeboden.</span>
                </div>
                <span class="error">{$settingBatchSizeErr}</span>

                <span class=setting_label>Automatische refresh van preview (seconden)</span>
                <input style="width:8em" type="text" class="setting_input" name="settingRefresh" value="{$settingRefresh}">
                <div class="tooltip">?
                    <span class="tooltiptext right">De preview wordt automatisch ververst. 
                        Geef hier het interval aan, tussen de 5 en 300 seconden (=5 minuten). </span>
                </div>
                <span class="error">{$settingRefreshErr}</span>

                <span class=setting_label>Wachtwoord sterkte voor klanten:&emsp;
                    {html_options name=settingPasswordKlant options=$settingPasswordLijst selected=$settingPasswordKlant}
                    <div class="tooltip">?
                        <span class="tooltiptext right">Geef aan hoe sterk een wachtwoord moet zijn. Bij een sterkte groter dan 'zwak' mag het oude wachtwoord niet gebruikt worden.</span>
                    </div>
                </span>
                <span class="error">{$settingPasswordKlantErr}</span>

                <span class=setting_label>Wachtwoord sterkte voor medewerkers:&emsp;
                    {html_options name=settingPasswordMedewerker options=$settingPasswordLijst selected=$settingPasswordMedewerker}
                    <div class="tooltip">?
                        <span class="tooltiptext right">Geef aan hoe sterk een wachtwoord moet zijn. Bij een sterkte groter dan 'zwak' mag het oude wachtwoord niet gebruikt worden.</span>
                    </div>
                </span>
                <span class="error">{$settingPasswordMedewerkerErr}</span>

                <div class="window_back" style="width:100%">
                    <input type="checkbox" id="7" checked onchange='handleChecked(this,document.getElementById("directories"));'/> 
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
