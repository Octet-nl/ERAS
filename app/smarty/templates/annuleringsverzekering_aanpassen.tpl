{include file="header.tpl"}

<form method="post" action="{$actionForm}">
    <div class="window_back">
        <div class="outer">
            <h2>{$doctitle}</h2>
            <div class="left_div">
                <br>
                <label for="afsluitkostenGeen">Annuleringsverzekering <strong>Geen</strong>:</label><br>
                <label for="afsluitkostenGeen">Afsluitkosten: </label><input value="{$geenAfsluitkosten}"
                    name="afsluitkostenGeen"><span class="error">{$geenAfsluitErr}</span><br>
                <label for="percentageGeen">Percentage: </label><input value="{$geenPercentage}"
                    name="percentageGeen"><span class="error">{$geenPercentageErr}</span><br>
                <label for="btwGeen">Btw: </label><input value="{$geenBtw}" name="btwGeen"><span
                    class="error">{$geenBtwErr}</span><br>
                <button type="submit" name="opslaanGeen">Opslaan</button>
                <br>

                <br>
                <label for="afsluitkostenGewoon">Annuleringsverzekering <strong>Gewoon</strong>:</label><br>
                <label for="afsluitkostenGewoon">Afsluitkosten: </label><input value="{$afsluitkostenGewoon}"
                    name="afsluitkostenGewoon"><span class="error">{$gewoonAfsluitErr}</span><br>
                <label for="percentageGewoon">Percentage: </label><input value="{$percentageGewoon}"
                    name="percentageGewoon"><span class="error">{$gewoonPercentageErr}</span><br>
                <label for="btwGewoon">Btw: </label><input value="{$btwGewoon}" name="btwGewoon"><span
                    class="error">{$gewoonBtwErr}</span><br>
                <button type="submit" name="opslaanGewoon">Opslaan</button>
                <br>

                <br>
                <label for="afsluitkostenAllrisk">Annuleringsverzekering <strong>All-risk</strong>:</label><br>
                <label for="afsluitkostenAllrisk">Afsluitkosten: </label><input value="{$afsluitkostenAllrisk}"
                    name="afsluitkostenAllrisk"><span class="error">{$allriskAfsluitErr}</span><br>
                <label for="percentageAllrisk">Percentage: </label><input value="{$percentageAllrisk}"
                    name="percentageAllrisk"><span class="error">{$allriskPercentageErr}</span><br>
                <label for="btwAllrisk"> Btw: </label><input value="{$btwAllrisk}" name="btwAllrisk"><span
                    class="error">{$allriskBtwErr}</span><br>
                <button type="submit" name="opslaanAllrisk">Opslaan</button>

                <button name="terug">Terug</button>
            </div>
        </div>
</form>

{include file="footer.tpl"}