{include file="header-klant.tpl"}

    <form method="post" action="{$SCRIPT_NAME}">

        <div class="outer">
            <h2>Reset uw wachtwoord</h2>
            {if $bevestig == ""}
            <div class="center_div">
                Geef uw geregistreerde email adres<br/>
                en we zullen u een link toesturen om <br/>
                uw wachtwoord te resetten.<br/>
                <input type="text" name="email" value="{$email}"><br/>
                <div class="error">{$emailErr}</div>
                <button name="stuur">Stuur wachtwoord-reset email</button>
            </div>
            {else}
            <div class="center_div">
                {$bevestig}
              </div>
            {/if}
        </div>
    </form>

{include file="footer.tpl"}