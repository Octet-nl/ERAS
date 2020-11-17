{include file="header.tpl"}

{if $formGetMail}

<form method="POST" action={$SCRIPT_NAME}>
    <div class="window_back_half">
        <div class="outer">
            <h2>Voucher (Tegoedbon) zoeken</h2>
            <div class="left_div">

                <br />
                <input type="checkbox" id="inactief" name="inactief" value="inactief">
                <label for="inactief"> Zoek ook inactieve bonnen</label><br>

                <label for="email">Voucher zoeken op E-mail adres:</label><br />
                <input type="text" name="email" value={$email}><br />
                <button name="getMail">Zoeken</button><br />
                <br />
                <label for="code">Voucher zoeken op vouchercode:</label><br />
                <input type="text" name="code" value={$code}><br />
                <button name="getCode">Zoeken</button>
                <br />
                <button name="lijst">Anonieme bonnen</button>
                <br /><br />
                {if $voucherLijst ne null}
                Anonieme bonnen:
                {foreach $voucherLijst as $voucher}
                <table class="noborder">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Beginwaarde</th>
                            <th>Geldig tot</th>
                        </tr>
                    </thead>
                    <tr>
                        <td class="noborder">
                            {if $voucher.deleted == "1" }<del>{/if}
                                <a href="voucher_wijzigen.php?cd={$voucher.code}">{$voucher.code}</a>
                                {if $voucher.deleted == "1" }</del>{/if}
                        </td>
                        <td class="noborder">
                            {if $voucher.deleted == "1" }<del>{/if}
                                {$voucher.waarde}
                                {if $voucher.deleted == "1" }</del>{/if}
                        </td>
                        <td class="noborder">
                            {if $voucher.deleted == "1" }<del>{/if}
                                {$voucher.geldigTot}
                                {if $voucher.deleted == "1" }</del>{/if}
                        </td>
                    </tr>
                </table>
                {/foreach}
                {/if}
                <br /><br />
                <button name="terug">Terug</button>
            </div>
        </div>
</form>

{else}

<form method="post" action="{$SCRIPT_NAME}">
    <div class="window_back_half">
        <h2>{$doctitle}</h2>
        Wijzigen vouchers.

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

            <br />
            <label for="oorsprongwaarde">Oorspronkelijke waarde: &euro;</label>
            <input class="short" type="text" id="oorsprongwaarde" value="{$oorsprongwaarde}" readonly><br />

            <label for="waarde">Restwaarde: &euro;</label>
            <input class="short" type="text" id="restwaarde" name="restwaarde" placeholder="123.45"
                value="{$restwaarde}" onchange="berekenVerbruikt();" readonly><br />
            <div class="error">{$restwaardeErr}</div>

            <label for="waarde">Verbruikt: &euro;</label>
            <input class="short" type="text" id="verbruikt" name="verbruikt" placeholder="123.45" value="{$verbruikt}"
                onchange="berekenRest();" readonly><br />
            <div class="error">{$verbruiktErr}</div>

            <label for="email">E-mail:</label>
            <input type="text" name="email" value="{$email}" readonly>
            <div class="error">{$emailErr}</div>

            <label for="evenementId">Evenement ID:</label>
            <input type="text" name="evenementId" value="{$evenementId}" readonly>
            <div class="error">{$evenementIdErr}</div>

            <label for="type">Type:</label>
            {html_options name=type id=type options=$typenLijst selected=$type disabled="disabled" strict='1'}
            <span class="error">{$typeErr}</span>

            <div>
                <label for="geldigTot">Geldig tot:</label>
                <input class="datuminput" type="text" id="geldigTot" name="geldigTot" placeholder="31-11-2022"
                    value={$geldigTot}>
                <span class="error">{$geldigTotErr}</span>
            </div>

            <div>
                <label class="textlabel" for="isActief">Is actief:</label>
                {if $isActief == 'nee'}
                {html_radios name='isActief' options=$isActiefLijst selected=$isActief labels=FALSE disabled="disabled"
                strict='1'}
                {else}
                {html_radios name='isActief' options=$isActiefLijst selected=$isActief labels=FALSE strict='1'}
                {/if}
                <div class="tooltip">?
                    <span class="tooltiptext"><strong>Let Op:</strong><br />Je kunt hier een voucher inactief maken.
                        Eenmaal inactief kan een voucher <strong>niet</strong> meer
                        actief gemaakt worden. Je zult dan een <a href="voucher_aanmaken.php">nieuwe voucher</a> voor de
                        klant moeten aanmaken.
                    </span>
                </div>
                <span class="error">{$isActiefErr}</span>
            </div>
            <br />
        </div>

        <button name="opslaan">Opslaan</button>
        <button name="terug">Terug</button>
    </div>

    <input type="hidden" name="voucherCode" value="{$voucherCode}">
    <input type="hidden" name="voucherId" value="{$voucherId}">
    <input type="hidden" name="type" value="{$type}">
    <input type="hidden" name="isIeActief" value="{$isIeActief}">
    <input type="hidden" name="oorsprongwaarde" value="{$oorsprongwaarde}">

</form>

<script>
    function berekenRest() {
        var rest = document.getElementById("oorsprongwaarde").value - document.getElementById("verbruikt").value;
        document.getElementById("restwaarde").value = rest;
        if (rest < 0) {
            document.getElementById("restwaarde").value = document.getElementById("restwaarde").defaultValue;
            document.getElementById("verbruikt").value = document.getElementById("verbruikt").defaultValue;
        }
    }

    function berekenVerbruikt() {
        var verbruikt = document.getElementById("oorsprongwaarde").value - document.getElementById("restwaarde").value;
        document.getElementById("verbruikt").value = verbruikt;
        if (verbruikt < 0) {
            document.getElementById("restwaarde").value = document.getElementById("restwaarde").defaultValue;
            document.getElementById("verbruikt").value = document.getElementById("verbruikt").defaultValue;
        }
    }
</script>

{/if}

{include file="statusregel.tpl"}

{include file="footer.tpl"}