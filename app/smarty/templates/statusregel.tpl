    <div class="statusRegel">
        <span class="status">
            {if $isError}
              <span class="signalError">
            {/if}
            {$statusRegel}
            {if $isError}
              </span>
            {/if}
        </span>

        <span class="eras">
          ERAS by HdR
        </span>

        <span class="loggedin">
          {if !isset($noLogout) or $noLogout != 'true' }
          <input class="barebutton" type="button" id="home" name="home" value="[home]" onclick="thuis()">
          |
          {/if}
          {if $loggedin == ""}
            <span style="padding-right: 2.5em;">
              <input class="barebutton" type="button" id="aanmelden" name="aanmelden" value="[aanmelden]" onclick="aanmeld()">
            </span>
            <span style="padding-right: 2.5em;"></span>
            {else}
            {if isset($noLogout) and $noLogout == 'true' }
              Aangemeld als '{$loggedin}'
              <span style="padding-right: 2.5em;"></span>
            {else}
              Aangemeld als '{$loggedin}'
              |
              <span style="padding-right: 2.5em;">
                <input class="barebutton" class="icontekst" type="button" id="afmelden" name="afmelden" value="[afmelden]" onclick="afmeld()">
              </span>
            {/if}
          {/if}
        </span>
    </div>
    <script>
      function afmeld()
      {
          document.body.innerHTML += '<form id="dynForm" method="post"><input type="hidden" name="afmelden"></form>';
          document.getElementById("dynForm").submit(); 
      }
      function aanmeld()
      {
        window.location.assign( 'login.php' );
      }

      function thuis()
      {
          window.location.assign( 'index.php' );
      }
    </script>      