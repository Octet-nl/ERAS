{include file="header.tpl"}

    <form method="post" action="{$SCRIPT_NAME}" >

      <div class="outer">
        <h2>Reset wachtwoord:</h2>
        {if $klaar == ""}
        <div class="center_div">
          <div id="groep">
              <div>
                <label class="short" for="password">Nieuw wachtwoord:</label>
                <input class="short" type="password" name="newPassword" id="newPassword" placeholder="nieuw wachtwoord" onkeyup='check();'>
                <span class="error" id="newPasswordErr">{$newPasswordErr}</span>
              </div>
              <div>
                <label class="short" for="password">Bevestig nieuw wachtwoord:</label>
                <input class="short" type="password" name="repeatPassword" id="repeatPassword" placeholder="bevestig wachtwoord" onkeyup='check();'>
                <span class="error" id="repeatPasswordErr">{$repeatPasswordErr}</span><span id="repeatcheck"></span>
              </div>
          </div>
          <br/>
          <br/>
          <button name="reset" value=1>Reset wachtwoord</button>
        </div>
        {else}
        <div class="center_div">
          {$klaar}
        </div>
        {/if}
      </div>
    <input type="hidden" name=previous value={$previous}>
    <input type="hidden" name=email value={$email}>

  </div>
    </form>

<script>
  var check = function() 
  {
    if ( document.getElementById('newPassword').value ==
           document.getElementById('repeatPassword').value ) 
    {
        document.getElementById('repeatcheck').style.color = 'green';
        document.getElementById('repeatcheck').innerHTML = 'OK';
    } 
    else 
    {
        if( document.getElementById('repeatPassword').value != '' )
        {
            document.getElementById('repeatcheck').style.color = 'red';
            document.getElementById('repeatcheck').innerHTML = 'X';
        } 
    }
   }
</script>
{include file="footer.tpl"}