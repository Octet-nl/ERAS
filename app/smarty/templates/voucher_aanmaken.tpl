{include file="header.tpl"}

<form method="post" action="{$SCRIPT_NAME}">
<div class="window_back">
    
    <div class="outer">
        <h2>{$doctitle}</h2>
        <div class="left_div">

    Hiermee kunt u vouchers aanmaken in de database. 
    Er wordt verder nog niets mee gedaan. 
    Een eventuele bevestigings-email moet later separaat verzonden worden.
    <div><br /><br />
            <table class="noborder">
            <tr>
                <td class="noborder">
                    Voucher code:
                </td> 
                <td class="noborder">
                    <strong>{$voucherCode}</strong>
                </td>                    
            </tr>
            </table>

        <br/>
        <label for="waarde">Waarde: &euro;</label>
        <input class="short" type="text" id="waarde" name="waarde" placeholder="123.45" value="{$waarde}"><br />
        <div class="error">{$waardeErr}</div>

        <div id="emailBlok">
            <label for="email">E-mail:</label>
            <input type="text" id="email" name="email" value="{$email}">
            <div class="error">{$emailErr}</div>
        </div>

        <div id="evenementBlok">
            <label for="evenementId">Evenement:</label>
            <select name="evenementId" onDblClick="this.form.submit()" >
                {html_options options=$evenementLijst selected=$evenementId}
            </select>
            <div class="error">{$evenementIdErr}</div>
        </div>

        <label for="type">Type:</label>
        {html_options name=type id=type options=$typenLijst selected=$type onchange="hideEmail();"}
        <span class="error">{$typeErr}</span>

        <div>
          <label for="geldigTot">Geldig tot:</label>
          <input class="datuminput" type="text" id="geldigTot" name="geldigTot" placeholder="31-11-2022" value={$geldigTot}>
          <span class="error">{$geldigTotErr}</span>
        </div>

        <div>
            <label class="textlabel" for="isActief">Is actief:</label>
            {html_radios name='isActief' options=$isActiefLijst selected=$isActief labels=FALSE}
            <span class="error">{$isActiefErr}</span>
        </div>
        <br />
    </div>

    <button name="opslaan">Opslaan</button> 
    <button name="terug">Terug</button>
</div>
</div>
</div>

<input type="hidden" name="voucherCode" value="{$voucherCode}">

</form>

<script>
    hideEmail();
    function hideEmail()
    {
        var type = document.getElementById("type").value;
        if ( type == {$typeVoucher} )
        {
            document.getElementById("emailBlok").className = "show";
            document.getElementById("emailBlok").disabled = false;

            document.getElementById("evenementBlok").className = "hide";
            document.getElementById("evenementBlok").disabled = true;
        }
        else
        {
            document.getElementById("emailBlok").className = "hide";
            document.getElementById("emailBlok").disabled = true;

            document.getElementById("evenementBlok").className = "show";
            document.getElementById("evenementBlok").disabled = false;
        }
    }    

</script>

{include file="statusregel.tpl"}

{include file="footer.tpl"}