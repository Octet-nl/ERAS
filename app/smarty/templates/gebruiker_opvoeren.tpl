{include file="header.tpl"}

<form method="post" action="{$SCRIPT_NAME}">

    <div class="window_back">
        <div class="outer">
            <h2>Toevoegen gebruiker:</h2>
            <div class="left_div">

                <div>
                    <label for="userid">Gebruikers ID:</label>
                    <input class="medium" type="text" name="userid" placeholder="userid" value={$userid}>
                    <span class="error">{$useridErr}</span>
                </div>

                <div>
                    <label for="password">Initieel wachtwoord:</label>
                    <input class="short" type="text" name="password" placeholder="wachtwoord" value={$password}>
                    <span class="error">{$passwordErr}</span><br/>
                    (Gebruiker moet dit wijzigen bij eerste maal aanloggen)
                </div>
                <br />
                <div>
                    <label for="rol">Rol:</label>
                    {html_options name=rol options=$rollijst selected=$rol}
                    <span class="error">{$rolErr}</span>
                </div>

                <br />
                <br />

                <button name="toevoegen" value=1>Toevoegen</button> <button name="terug">Terug</button>

                {include file="statusregel.tpl"}

            </div>
        </div>
    </div>
</form>

{include file="footer.tpl"}