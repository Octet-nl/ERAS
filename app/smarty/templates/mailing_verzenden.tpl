{include file="openheader.tpl"}
<script type="text/javascript" src="js/nicEdit.js"></script>
{include file="closeheader.tpl"}

<form method="post" action="{$SCRIPT_NAME}">


    <div class="window_back">
        <div class="outer">
            <h2>{$doctitle}</h2>

            <div>
                Evenement:
                <select name="evenementId" onchange="submit();">
                    {html_options options=$evenement_lijst selected=$evenementId}
                </select>
                Aantal subscribers: {$aantal}
                <div class="tooltip">?
                    <span class="tooltiptext">Als je 'alle' kiest, dan wordt de mailing naar elke abonnee één keer
                        verstuurd. Dit is bedoeld voor algemene mailings.</span>
                </div>
            </div>
            <br /><br />
            <div align="center">
                <label for="mailingTekst">Mailing tekst:</label><br />
                <span class="error">{$mailingTekstErr}</span>
                <textarea rows="35" cols="90" name="mailingTekst" id="mailingTekst"
                    maxlength="10000">{$mailingTekst}</textarea>
                <button type="button" class="bareleft" onClick="toggleMailingTekst();">HTML</button>
            </div>
        </div>

        <div align="center">
            De mail wordt afgesloten met de volgende regels:<br /><br />
            <div align="center" style="font-size:0.8em;">U heeft zich aangemeld voor onze nieuwsbrief, u kunt zich <a
                    href="{$unsubscribeLink}">hier</a> afmelden.</div>
            <div align="center">{$adresRegel}</div><br />

            {if $aantal <= $batchSize}
              {if $aantal > 0}
                <div style="font-size:0.8em;">
                <h3>Let op:</h3>
                Bij 'Verzend met BCC' wordt deze (via BCC) verzonden naar alle ({$aantal}) subscribers tegelijk.<br />
                Ook kan een klant dan alleen voor <strong>alle evenementen tegelijk</strong> afmelden, en niet per stuk.<br />
                Als u dat niet wilt, kies dan 'Verzend per batch'.<br />
                <br />
                </div>
                <button name="verzend">Verzend met BCC</button>
              {/if}  
            {/if}

            {if $aantal > 0}
            <button name="batch">Verzend per batch</button>
            <button name="download">Download mailadressen</button>
            {/if}
            <button name="terug">Terug</button>
        </div>
    </div>
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