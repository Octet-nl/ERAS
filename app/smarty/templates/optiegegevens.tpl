
        <div>
            <label for="id">Id:</label>
            <input type="number" name="id" value="{$id}" readonly>
        </div>

        <div>
            <label for="optieNaam_naam">Naam:</label>
            <textarea rows="1" cols="50" maxlength="64" name="optieNaam">{$optieNaam}</textarea>
            <span class="error">{$optieNaamErr}</span>
        </div>

        <div>
            <label for="titel">Titel:</label>
            <textarea rows="1" cols="50" maxlength="256" name="titel">{$titel}</textarea>
            <span class="error">{$titelErr}</span>
        </div>

        <div>
            <label for="tekst">Tekst:</label>
            <textarea rows="1" cols="50" maxlength="256" name="tekst">{$tekst}</textarea>
            <span class="error">{$tekstErr}</span>
        </div>

        <div>
            <label for="type">Type:</label>
            {html_options name=type options=$typenLijst selected=$type}
            <span class="error">{$typeErr}</span>
        </div>

        <div>
            <label for="groep">Groep:</label>
            <input class="longtext" type="text" name="groep" value="{$groep}">
            <span class="error">{$groepErr}</span>
        </div>

        <div>
            <label class="textlabel" for="default">Is default in groep:</label>
            {html_radios name='default' options=$defaultKeus selected=$default}
            <span class="error">{$defaultErr}</span>
        </div>

        <div>
            <label class="textlabel" for="totaalAantal">Totaal aantal beschikbaar:</label>
            <input type="number" name="totaalAantal" value="{$totaalAantal}">
            <span class="error">{$totaalAantalErr}</span>

            <label for="status">Status:</label>
             {html_options name=status options=$statusLijst selected=$status}
            <span class="error">{$statusErr}</span>
        </div>

        <div>
            <label for="prijs">Prijs:</label>
            <input type="text" name="prijs" placeholder="123.45" value="{$prijs}">
            <span class="error">{$prijsErr}</span>

            <label class="short" for="prijsPer">Prijs per:</label>
            <input type="text" name="prijsPer" placeholder="persoon per dag" value="{$prijsPer}">
            <span class="error">{$prijsPerErr}</span>
        </div>

        <div>
            <label class="textlabel" for="optieId">Suboptie van:</label>
            <input type="number" name="optieId" value="{$optieId}">
            <span class="error">{$optieIdErr}</span>
        </div>
