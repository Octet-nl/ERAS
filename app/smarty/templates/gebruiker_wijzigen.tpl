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
        </tr
        <tr>
            <td class="noborder"><label for="password">Nieuw wachtwoord:</label></td>
            <td class="noborder"><input class="short" type="text" name="password" placeholder="wachtwoord" value={$password}></td>
            <td class="noborder">(Gebruiker moet dit wijzigen bij eerste maal aanloggen)</td>
            <td class="noborder"><span class="error">{$passwordErr}</span></td>
        </tr>
        <tr>
            <td class="noborder"><label for="rol">Rol:</label></td>
            <td class="noborder">{html_options name=rol options=$rollijst selected=$rol}</td>
            <td class="noborder"></td>
            <td class="noborder"><span class="error">{$rolErr}</span></td>
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