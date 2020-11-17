{include file="header.tpl"}

<form method="post" action="{$SCRIPT_NAME}">

  <div class="window_back">
    <div class="outer">
      <h2>Aanmelden:</h2>
      <div class="left_div">

        <div>
          <label class="short" for="userid">Gebruikers ID:</label>
          <input class="short" type="text" name="userid" placeholder="userid" value="{$userid}"><br />
          <span class="error">{$useridErr}</span>
        </div>

        <div>
          <label class="short" for="password">Wachtwoord:</label>
          <input class="short" type="password" name="password" placeholder="wachtwoord" value="{$password}"><br />
          <span class="error">{$passwordErr}</span>
        </div>
        <br />
        <div>
          <span class="error" id="moetWijzigenErr">{$moetWijzigen}</span>
        </div>
        <div>
          <input type="checkbox" name="wijzigWachtwoord" id="change" value="wijzig" {$wijzigchecked}>Wijzig
          wachtwoord<br /><br />
        </div>

        {if $wijzigchecked != "" }
        <div id="groep">
          {else}
          <div id="groep" style="display:none;">
            {/if}
            <div>
              <label class="short" for="password">Nieuw wachtwoord:</label>
              <input class="short" type="password" name="newPassword" id="newPassword" placeholder="nieuw wachtwoord"
                onkeyup='check();'>
              <span class="error" id="newPasswordErr">{$newPasswordErr}</span>
            </div>
            <div>
              <label class="short" for="password">Bevestig nieuw wachtwoord:</label>
              <input class="short" type="password" name="repeatPassword" id="repeatPassword"
                placeholder="bevestig wachtwoord" onkeyup='check();'>
              <span class="error" id="repeatPasswordErr">{$repeatPasswordErr}</span><span id="repeatcheck"></span>
            </div>
          </div>

          <div align="center" />
            <button name="login" value=1>Aanmelden</button>
          </div>
          <input type="hidden" name=previous value={$previous}>

        </div>
        <div class="tiny">
          Hiermee kunt u zich aanmelden voor het medewerker gedeelte van de site.<br />
          Voor klantregistratie ga <a href="registreer.php">hier</a> heen.</br>
          Voor inschrijvingen ga <a href="evenement_kiezen.php">hier</a> heen.
        </div>
      </div>

    </div>

  </div>

</form>

<script>
  document.getElementById('change').onchange = function () {
    if (this.value === 'wijzig' && this.checked === true) {
      document.getElementById("groep").style.display = "inline";
    }
    else {
      document.getElementById("groep").style.display = "none";
    }

  };

  var check = function () {
    if (document.getElementById('newPassword').value ==
      document.getElementById('repeatPassword').value) {
      document.getElementById('repeatcheck').style.color = 'green';
      document.getElementById('repeatcheck').innerHTML = 'OK';
    }
    else {
      if (document.getElementById('repeatPassword').value != '') {
        document.getElementById('repeatcheck').style.color = 'red';
        document.getElementById('repeatcheck').innerHTML = 'X';
      }
    }
  }
</script>
{include file="footer.tpl"}