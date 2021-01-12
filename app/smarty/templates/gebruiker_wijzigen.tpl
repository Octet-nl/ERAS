{include file="header.tpl"}

<form method="post" action="{$SCRIPT_NAME}">

    <div class="window_back_half">
        <h2>Wijzigen gebruiker:</h2>

        <table>
            <tr>
                <td class="noborder"><label for="userid">Gebruikers ID:</label></td>
                <td class="noborder"><strong>{$userid}</strong></td>
                <td class="noborder"></td>
                <td class="noborder"><span class="error">{$useridErr}</span></td>
            </tr>
            <tr>
                <td class="noborder"><label for="password">Nieuw wachtwoord:</label></td>
                <td class="noborder"><input class="short" type="text" name="password" placeholder="wachtwoord" value="{$password}"></td>
                <td class="noborder">(Gebruiker moet dit wijzigen bij eerste maal aanloggen)</td>
                <td class="noborder"><span class="error">{$passwordErr}</span></td>
            </tr>
            <tr>
                <td class="noborder"><label for="rol">Rol:</label></td>
                {if ($rol==$ROL_KLANT)}
                <td class="noborder"><input class="short" type="text" name="rol" value="$rol" hidden>Klant</td>
                {else}
                <td class="noborder">{html_options name=rol options=$rollijst selected=$rol}</td>
                {/if}
                <td class="noborder"></td>
                <td class="noborder"><span class="error">{$rolErr}</span></td>
            </tr>
            <tr>
                <td class="noborder"><label for="actief">Actief:</label></td>
                <td class="noborder">{html_radios name='actief' id=isActief options=$actiefKeus selected=$isActief labels=FALSE}</td>

                {if (preg_match("/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/", $userid))}
                <td class="noborder">
                    Denk er om dat als je een klant (d.w.z. een gebruiker met een <i>mailadres</i> als gebruikers ID) inactief maakt, 
                    deze niet meer kan inloggen, geen wachtwoord meer kan wijzigen 
                        en dat het <strong>mailadres ook niet meer gebruikt kan worden</strong>.<br/>
                        Het is dus een volledige blokkade van dit mailadres!
                </td>
                {/if}
                <td class="noborder"><span class="error">{$isActiefErr}</span></td>
            </tr>
        </table>

        <br />
        <br />

        <button name="opslaan" value=1>Opslaan</button>
        <button name="terug">Terug</button> 

        {include file="statusregel.tpl"}
    </div>

    <input type="hidden" name="userid" value="{$userid}">
    <input type="hidden" name="id" value="{$id}">
</form>

{include file="footer.tpl"}