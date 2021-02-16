{include file="openheader.tpl"}
<script type="text/javascript" src="js/nicEdit.js"></script>
{include file="closeheader.tpl"}

<form method="post" action="{$SCRIPT_NAME}">
    <table>
        <thead>
            <tr>
                <th>Evenement</th>
                <th>Contact gegevens</th>
                <th>Actie</th>
            </tr>
        </thead>

        {foreach $factuur_lijst as $factuur}
        <tr>
            <td>
                <b>{$factuur.evenement}</b><br />
            </td>
            <td>
                {$factuur.naam}<br />
            </td>
            <td>

                <button name="aanpassen" value={$factuur.id}>Aanpassen</button>
                <button name="betaling" value={$factuur.id}>Betaling</button>
                <button name="annuleer" value={$factuur.id} onclick="return verwijderKlik('Inschrijving nummer {$factuur.id}\nvan {$factuur.naam}')">Annuleer</button>
            </td>
        </tr>
        {/foreach}
    </table>


</form>

{include file="statusregel.tpl"}

<script>
    var mailingTekst;

    bkLib.onDomLoaded(function () { toggleMailingTekst(); });

    function toggleMailingTekst() {
        if (!mailingTekst) {
            mailingTekst = new nicEditor({ imageURI: '{$imageDirectory}' }).panelInstance('mailingTekst');
            document.getElementById("mailingTekst").style.alignContent("left");
        }
        else {
            mailingTekst.removeInstance('mailingTekst');
            mailingTekst = null;
        }
    }
</script>

{include file="footer.tpl"}