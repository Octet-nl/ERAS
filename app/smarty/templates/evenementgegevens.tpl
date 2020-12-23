{* Smarty functions *}
{function my_radios}
<label class="textlabel">{$tekst}</label>
{foreach $options as $key => $lbl}
    <input type="radio" id="{$naam}{$lbl}" name="{$naam}" value="{$key}" {if $selected==$key}checked{/if}/>{$lbl}
{/foreach}
{/function}

        <div>
            <label for="id">Evenementnummer:</label>
            <input type="text" id="evenementNummer" name="id" value="{$id}" readonly>
        </div>

        <div>
            <label for="evenement_naam">Evenementnaam:</label>
            <input class="wide" type="text" id="evenementNaam" name="evenement_naam" value="{$evenement_naam}">
            <span class="error">{$naamErr}</span>
        </div>
        <div>
            <label for="categorie">Categorie:</label>
            {html_options id=categorie name=categorie options=$categorielijst selected=$categorie}
            <span class="error">{$categorieErr}</span>
        </div>


        <div>
            <label for="korteOmschrijving">Korte omschrijving:</label>
            <textarea rows="5" cols="90" name="korteOmschrijving" id="korteOmschrijving" maxlength="512">{$korteOmschrijving}</textarea>
            <button type="button" class="bareleft" onClick="toggleKorteOmschrijving();">HTML</button>
            <span class="error">{$korteOmschrijvingErr}</span>
        </div>

        <div>
            <label for="langeOmschrijving">Lange omschrijving:</label>
            <textarea rows="10" cols="90" name="langeOmschrijving" id="langeOmschrijving">{$langeOmschrijving}</textarea>
            <button type="button" class="bareleft" onClick="toggleLangeOmschrijving();">HTML</button>
            <span class="error">{$langeOmschrijvingErr}</span>
        </div>

        <div>
            <label for="datumBegin"><strong>Evenement</strong> Begindatum:</label>
            <input class="datuminput" type="text" id="datumBegin" name="datumBegin" placeholder="31-11-2019" value={$datumBegin}>
            <span class="error">{$datumBeginErr}</span>

            <label class="datuminput" for="datumEind">Einddatum:</label>
            <input class="datuminput" type="text" id="datumEind" name="datumEind" placeholder="31-11-2019" value={$datumEind}>
            <span class="error">{$datumEindErr}</span>

            <label class="datuminput" for="aantalDagen">Aantal dagen:</label>
            <input type="number" id="aantalDagen" name="aantalDagen" value="{$aantalDagen}" min="1" max="365" >
            <input class="calcIcon" id="berekenDagen" type="button" onclick="dateDifference();" />
            <div class="tooltip">?
                <span class="tooltiptext">Werkelijk aantal dagen. Bij bijvoorbeeld wekelijkse activiteiten met de hand uitrekenen</span>
            </div>
            <span class="error">{$aantalDagenErr}</span>
        </div>

        <div>
            <label for="inschrijvingBeginDatum"><strong>Inschrijving</strong> Begindatum:</label>
            <input class="datuminput" type="text" id="inschrijfDatumBegin" name="inschrijfDatumBegin" placeholder="31-11-2019" value={$inschrijfDatumBegin}>
            <span class="error">{$inschrijfDatumBeginErr}</span>

            <label class="datuminput" for="inschrijvingEindDatum">Einddatum:</label>
            <input class="datuminput" type="text" id="inschrijfDatumEind" name="inschrijfDatumEind" placeholder="31-11-2019" value={$inschrijfDatumEind}>
            <span class="error">{$inschrijfDatumEindErr}</span>
            <br/>

            <label for="inschrijvingBeginTijd"><strong>Inschrijving</strong> Begintijd:</label>
            <input class="datuminput" type="text" id="inschrijfTijdBegin" name="inschrijfTijdBegin" placeholder="00:00:00" value={$inschrijfTijdBegin}>
            <span class="error">{$inschrijfTijdBeginErr}</span>

            <label class="datuminput" for="inschrijvingEindTijd">Eindtijd:</label>
            <input class="datuminput" type="text" id="inschrijfTijdEind" name="inschrijfTijdEind" placeholder="00:00:00" value={$inschrijfTijdEind}>
            <span class="error">{$inschrijfTijdEindErr}</span>
        </div>
        <br/>

        <div>
            <label for="prijs">Prijs:</label>
            <input class="datuminput" type="text" id="prijs" name="prijs" placeholder="123.45" value="{$prijs}">
            <span class="error">{$prijsErr}</span>

            <label class="datuminput" for="maxDeelnemers">Max deelnemers:</label>
            <input type="number" id="maxDeelnemers" name="maxDeelnemers" value="{$maxDeelnemers}" min="1">
            <span class="error">{$maxDeelnemersErr}</span>
        </div>

        <div>
            <label for="status">Status:</label>
            {html_options name=status id=status options=$statuslijst selected=$status class="selectinput" }
            <span class="error">{$statusErr}</span>

            <label class="datuminput" for="isAccountNodig">Is een account nodig:</label>
            {html_radios name='isAccountNodig' id=isAccountNodig options=$accountNodigKeus selected=$isAccountNodig labels=FALSE}
            <div class="tooltip">?
                <span class="tooltiptext right">Kan er ook ingeschreven worden zonder een account aan te maken, of is voor inschrijving in dit evenement een account noodzakelijk?</span>
            </div>
            <span class="error">{$isAccountNodigErr}</span>
   
            <label class="datuminput" for="groepsInschrijving">Groepsinschrijving mogelijk?</label>
            {html_radios name='groepsInschrijving' id=groepsInschrijving options=$groepsInschrijvingKeus selected=$groepsInschrijving labels=FALSE}
            <div class="tooltip">?
                <span class="tooltiptext left">Kan voor een groep of voor iemand anders dan de contactpersoon worden ingeschreven, of is alleen individuele inschrijving mogelijk?</span>
            </div>
            <span class="error">{$groepsInschrijvingErr}</span>

            <!--            <label class="datuminput" for="isAccountNodig">Is een account nodig:</label>
            {html_radios name='isAccountNodig' id=isAccountNodig options=$accountNodigKeus selected=$isAccountNodig labels=FALSE}
            
            {my_radios naam='isAccountNodig' options=$accountNodigKeus selected=$isAccountNodig tekst='Is een account nodig:'}
-->
            <span class="error">{$isAccountNodigErr}</span>

        </div>

        <div>
<!--            <label class="textlabel" for="annuleringsverzekering">Annuleringsverzekering:</label>
            {html_radios name='isAnnuleringsverzekering' label_ids=true options=$annuleringsverzekeringKeus selected=$isAnnuleringsverzekering labels=FALSE}
-->
            {my_radios naam='isAnnuleringsverzekering' options=$annuleringsverzekeringKeus selected=$isAnnuleringsverzekering tekst='Annuleringsverzekering:'}
            <div class="tooltip">?
                <span class="tooltiptext right">Kan voor dit evenement een annuleringsverzekering afgesloten worden?</span>
            </div>
            <span class="error">{$isAnnuleringsverzekeringErr}</span>
    
        </div>

        <br/>

        <div>
            <table>
                <thead>
                    <tr>
                    <th>Extra gegevens voor contactpersoon</th>
                    <th>Extra gegevens voor deelnemers</th>
                    <th class="blankHeader"></th>
                    <th>Betaalwijze</th>
                    <th class="blankHeader"></th>
                    </tr>
                </thead>
                <tr>
                    <td valign="top"> 
                        {html_checkboxes name='volledigheid_contact' label_ids=true options=$volledigheidlijst selected=$volledigheid_contact separator='<br />'}
                    </td>
                    <td valign="top"> 
                        {html_checkboxes name='volledigheid_deelnemer' label_ids=true options=$volledigheidlijst selected=$volledigheid_deelnemer separator='<br />'}
                    </td>
                    <td class="tooltip">?
                        <span class="tooltiptext">De volledige Naam, Adres en Woonplaats gegevens (NAW) worden altijd gevraagd, zowel bij contactpersonen als bij deelnemers. Hier kun je aangeven welke informatie nog meer verplicht moet worden ingevuld voor dit evenement.<br/><i>Denk erom dat het volgens de AVG verboden is om informatie op te slaan die niet noodzakelijk is voor het evenement!</i></span>
                    </td>
                    <td valign="top"> 
                        {html_checkboxes name='betaalwijze_deelnemer' label_ids=true options=$betaalwijzelijst selected=$betaalwijze_deelnemer separator='<br />'}
                    </td>
                    <td valign="top" class="noborder">
                        <div class="tooltip">?
                            <span class="tooltiptext">De mogelijke betaalwijzen voor dit evenement. Als alleen voor 'contant' gekozen wordt, word ervan uitgegaan dat het een contante betaling bij aanvang van het evenement betreft.</span>
                        </div>
                        <span class="error">{$betaalwijze_deelnemerErr}</span>                       
                    </td>
                </tr>
            </table>
        </div>

