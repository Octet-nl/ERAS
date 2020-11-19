{include file="header-klant.tpl"}

<form method="post" action="{$SCRIPT_NAME}" >

<div class="window_back">
    <div class="outer">
        <h2>Wijzig E-mailadres:</h2>
        <div class="left_div">
            <div>
            <label class="short" for="email">Huidig e-mailadres:</label>
            <input class="medium" type="text" name="email" placeholder="huidig adres" value="{$email}"><br/>
            <span class="error">{$emailErr}</span>
            </div>

            <div>
            <label class="short" for="password">Wachtwoord:</label>
            <input class="short" type="password" name="password" placeholder="wachtwoord" value="{$password}"><br/>
            <span class="error">{$passwordErr}</span>
            </div>
            <br/>
            <div id="groep">
                <div>
                <label class="short" for="newEmail">Nieuw e-mailadres:</label>
                <input class="medium" type="text" name="newEmail" id="newEmail" value="{$newEmail}" placeholder="nieuw adres" onkeyup='check();'>
                <span class="error" id="newEmailErr">{$newEmailErr}</span>
                </div>
                <div>
                <label class="short" for="repeatNewEmail">Bevestig nieuw e-mailadres:</label>
                <input class="medium" type="text" name="repeatNewEmail" id="repeatNewEmail" value="{$repeatNewEmail}" placeholder="bevestig adres" onkeyup='check();'>
                <span class="error" id="repeatNewEmailErr">{$repeatNewEmailErr}</span><span id="repeatcheck"></span>
                </div>
            </div>

            <br/>
            <br/>
            <button name="wijzig" value=1>Wijzigen</button>
            <button name="terug">Terug</button> 

            <input type="hidden" name=previous value={$previous}>
        </div>
        <div class="tiny">
            Hiermee wijzigt u:<br/>- Het mailadres waarmee u zich aanmeldt<br/>- Het mailadres waar we u als contactpersoon op kunnen bereiken.
        </div>
    </div>
</div>
</form>

<script>
  var check = function() 
  {
    if ( document.getElementById('newEmail').value ==
           document.getElementById('repeatNewEmail').value ) 
    {
        document.getElementById('repeatcheck').style.color = 'green';
        document.getElementById('repeatcheck').innerHTML = 'OK';
    } 
    else 
    {
        if( document.getElementById('repeatNewEmail').value != '' )
        {
            document.getElementById('repeatcheck').style.color = 'red';
            document.getElementById('repeatcheck').innerHTML = 'X';
        } 
    }
   }
</script>
{include file="footer.tpl"}