{include file="header.tpl"}
<div align="center">
<h2>{$doctitle}</h2>

<div class="round_corners" align="left" style="display: inline-block">

    <h2>Aanpassen nummering voor evenementen, inschrijvingen en mailinglists</h2>
    <p>Om evenementen, inschrijvingen en mailinglists snel terug te kunnen vinden is het handig het lopende kalenderjaar toegevoegd, gevolgd door een reeks cijfers (bijv. 0001). 
       De opbouw van de factuurnummering ziet er dan voor het jaar 2022 als volgt uit:</p>
    <p><strong>20220001</strong><br><strong>20220002</strong><br><strong>20220003</strong><br>enz..</p>
    <p>Kiest u voor deze opbouw, zorg dan dat u genoeg ruimte aanhoudt om door te kunnen nummeren. 
       Dit is vooral van belang bij inschrijvingen. Voor mailinglists en evenementen speelt het minder.
       Begint u met 202201, dan is het laatste opeenvolgende factuurnummer dat u kunt maken in dat jaar 202299. 
       Dat betekent dat er hoogstens 99 inschrijvingen mogelijk zijn. 
       Als u echter met 20220001 begint, dan zijn er 999 mogelijkheden. Houd hier dus rekening mee en gebruik liever teveel dan te weinig ruimte.
    </p>
</div>
</div>

<form method="post" action="{$SCRIPT_NAME}">
    <div class="window_back">
        <div class="outer">
            <div class="left_div">

                <table style="display: inline-block;" id="table">
                    <tr>
                        <th></th>
                        <th>Hoogste<br/>nummer</th>
                        <th>Nieuw<br/>beginnummer</th>
                    </tr>
                    <tr>
                        <td>Evenement</td>
                        <td>{$evenementStart}</td>
                        <td><input value="{$evenementNummer}" name="evenementNummer">
                            <span class="error">{$evenementErr}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Inschrijving</td>
                        <td>{$inschrijvingStart}</td>
                        <td><input value="{$inschrijvingNummer}" name="inschrijvingNummer">
                            <span class="error">{$inschrijvingErr}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Mailing</td>
                        <td>{$mailingStart}</td>
                        <td><input value="{$mailingNummer}" name="mailingNummer">
                            <span class="error">{$mailingErr}</span>
                        </td>
                    </tr>
                </table>

                <div style="display: block;">
                    <button type="submit">Opslaan</button>
                    <button name="terug">Terug</button>
                </div>

                <input type="hidden" name="evenementStart" value="{$evenementStart}">
                <input type="hidden" name="inschrijvingStart" value="{$inschrijvingStart}">
                <input type="hidden" name="mailingStart" value="{$mailingStart}">

                {include file="statusregel.tpl"}
            </div>
        </div>
</form>

<script>
    function afmeld() {
        document.body.innerHTML += '<form id="dynForm" method="post"><input type="hidden" name="afmelden"></form>';
        document.getElementById("dynForm").submit();
    }

</script>

{include file="footer.tpl"}