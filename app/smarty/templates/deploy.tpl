{include file="header.tpl"}

<form method="post" action="{$SCRIPT_NAME}">
    <div class="window_back_half">
        <h2>{$doctitle}</h2>

        <hr />
        <h2>Dit is een experimentele functie</h2>
        <h4>Upgrade bij voorkeur volgens de procedure die beschreven is in GitHub. Deze deployment is experimenteel en kan tot onverwachte resultaten leiden </h4>
        <h3>Dit is een potentieel destructieve handeling</h3>
        <h4>Het is mogelijk dat de applicatie na afloop niet meer werkt</h4>
        <h3>Je bent gewaarschuwd!</h3>
        <h4>Na de druk op de knop wordt de gekozen tag uit GitHub op de {$omgeving} omgeving geplaatst (directory {$deployDirectory})</h4>

        <h4>Als je twijfelt over de werking van de deployment:</h4>
        <button type="submit" name="afmelden" class="link-button">
            <h4>log dan nu onmiddelijk uit</h4>
        </button>
        <h4>Bij onjuist gebruik kun je hiermee het inschrijvingssysteem onbruikbaar maken</h4>

        <button type="button" onclick="gaTochVerder()">Ik weet wat ik doe en accepteer het risico</button>
        <hr />

        <div id="tochverder">
            <h3>Deployment vanuit GIT naar {$omgeving} omgeving</h3>
            <h4>-Alle bestaande bestanden op de {$omgeving} omgeving worden verwijderd.<br />-Daarna wordt de genoemde
                tag wordt vanuit GitHub op de {$omgeving} omgeving geplaatst. </h4>
            Tag:
            <select name="tag">
                {html_options options=$taglijst}
            </select>

            <button type="submit" name="deploy" value="{$deployDirectory}">Deploy naar {$omgeving}</button>

            <hr />
        </div>

        <button name="annuleren">Annuleren</button>

        <input type="hidden" name="omgeving" value="{$omgeving}">
        <input type="hidden" name="deployDirectory" value="{$deployDirectory}">

        {include file="statusregel.tpl"}

</form>

<script>
    var x = document.getElementById("tochverder");
    x.style.display = "none";
    function gaTochVerder() {
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>
{include file="footer.tpl"}