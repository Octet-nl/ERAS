{include file="header-klant.tpl"}

<h2>{$doctitle}</h2>
<form method="post" action="{$SCRIPT_NAME}">

    <fieldset>
        {if $evt!="" }
        <h2>Inloggen of account maken?</h2>
        Als u een account aanmaakt
        kunt u later zelf uw inschrijving bekijken en aanpassen.
        <hr />
        <div class="radio">
            <input type="radio" name="account" id="regist" value="register" {$registerchecked} onclick="doRegister()" />
            Account aanmaken
        </div>
        {if !$accountNodig}
        <div class="radio">
            <input type="radio" name="account" id="zonder" value="zonder" {$directchecked} onclick="doZonder()" />
            Direct inschrijven zonder account
        </div>
        {/if}
        <div class="radio">
            <input type="radio" name="account" id="login" value="login" {$loginchecked} onclick="doLogin()" />
            Terugkerende klant
        </div>
        {else}
        <h2>Inloggen</h2>
        <div class="radio">
            <input type="radio" name="account" id="login" value="login" checked="checked" onclick="doLogin()" />
            Terugkerende klant
        </div>
        {/if}

    </fieldset>
    <br /><br />

    <fieldset id="inloggen">
        <h2 class="secondary-title">Terugkerende klant</h2>
        <div>
            <label>E-mailadres</label>
            <input class="medium" type="text" name="mailadres" value="{$mailadres}" placeholder="E-mailadres" />
            <span class="error">{$mailadresErr}</span>
            <button name="wijzigEmail">Wijzigen</button>
        </div>
        <div>
         <label for="input-login_password">Uw wachtwoord</label>
         <input class="short" type="password" name="wachtwoord" value="{$wachtwoord}" placeholder="Uw wachtwoord" />
         <span class="error">{$wachtwoordErr}</span>
         <br /><br/>
         <a href=wachtwoord_aanvragen.php>Wachtwoord vergeten</a>
        </div>

        <div>
            <span class="error" id="moetWijzigenErr">{$moetWijzigen}</span>
        </div>
        <div>
            <br/>
            <input type="checkbox" name="wijzigWachtwoord" id="change" value="wijzig" {$wijzigchecked}>Wijzig
            wachtwoord<br /><br />
        </div>

    {if $wijzigchecked != "" }
        <div id="nieuwww">
    {else}
        <div id="nieuwww" style="display:none;">
    {/if}
        <div>
            <label for="password">Nieuw wachtwoord:</label>
            <input class="short" type="password" name="newPassword" id="newPassword" value="{$newPassword}"
                placeholder="nieuw wachtwoord" onkeyup='check();'>
            <span class="error" id="newPasswordErr">{$newPasswordErr}</span>
        </div>
        <div>
            <label for="password">Bevestig nieuw wachtwoord:</label>
            <input class="short" type="password" name="repeatPassword" id="repeatPassword"  value="{$repeatPassword}"
                placeholder="bevestig wachtwoord" onkeyup='check();'>
            <span class="error" id="repeatPasswordErr">{$repeatPasswordErr}</span><span id="repeatcheck"></span>
        </div>
    </div>

    <div>
        <button name="inloggen">Inloggen</button>
    </div>

    </fieldset>

    <fieldset id="direct">
        <h2 class="secondary-title">Direct inschrijven</h2>
        <div>
            <label class="control-label" for="input-payment-password">Uw E-mailadres</label>
            <input class="medium" type="text" name="noregemail" value="{$noregemail}" placeholder="Uw E-mailadres" />
            <div class="tooltip">?
                <span class="tooltiptext medium">Uw mailadres hebben we nodig om u een bevestiging/factuur te kunnen sturen en u op de 
                    hoogte te houden van eventuele wijzigingen of aanpassingen. Verder moeten we controleren of het
                    email adres niet reeds gebruikt wordt.
                </span>
            </div>
            <span class="error">{$noregemailErr}</span>
        </div>
        <br/>
        <div>
            <strong>Let op:</strong><br/>Als u zonder account inschrijft, kunt u later niet uw inschrijving(en) inzien of wijzigen.
        </div>
        <br/>
        <div>
            <button type="button" name="account" onclick="tochRegister()" >Maak toch maar een account aan</button>
        </div>
        <div>
            <button name="direct">Zonder account naar inschrijving</button>
        </div>
    </fieldset>

    <fieldset id="registreer">
        <h2>Account aanmaken</h2>
        <p>U gebruikt later uw e-mailadres en wachtwoord om in te loggen.</p>
        <h4>Uw E-mailadres</h4>
        <div>
            <label class="control-label" for="input-payment-password">Uw E-mailadres</label>
            <input class="medium" type="text" name="email" value="{$email}" placeholder="Uw E-mailadres" />
            <div class="tooltip">?
                <span class="tooltiptext">Uw mailadres gebruikt u later om aan te melden en uw inschrijving(en) in te zien of te wijzigen.
                </span>
            </div>
            <span class="error">{$emailErr}</span>
            </div>
            <h4>Kies uw wachtwoord</h4>
            <div>
                <label class="control-label" for="input-payment-password">Uw wachtwoord</label>
                <input class="short" type="password" name="password" id="password" value="{$password}" placeholder="Uw wachtwoord" onkeyup='check2();' />
                <div class="tooltip">?
                    <span class="tooltiptext">Uw kunt uw wachtwoord later zelf wijzigen.
                    </span>
                </div>
                    <span class="error">{$passwordErr}</span>
            </div>
            <label class="control-label" for="input-payment-confirm">Bevestig uw wachtwoord</label>
            <input class="short" type="password" name="bevestig" id="bevestig" value="{$bevestig}" placeholder="Bevestig uw wachtwoord" onkeyup='check2();' />
            <span class="error">{$bevestigErr}</span><span id="repeatcheck2"></span>
            <div>
                <button name="register">Aanmelden</button>
            </div>

    </fieldset>
    <br />
    <input type="hidden" name="evt" value="{$evt}">
    <input type="hidden" name="accountNodig" value="{$accountNodig}">
</form>

<script>

document.getElementById('change').onchange=function() 
   {
        if( this.value==='wijzig' && this.checked===true )
        {
            document.getElementById("nieuwww").style.display = "inline";
        }
        else 
        {
            document.getElementById("nieuwww").style.display = "none";
        }
    };

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

var check2 = function() 
  {
    if ( document.getElementById('password').value ==
           document.getElementById('bevestig').value ) 
    {
        document.getElementById('repeatcheck2').style.color = 'green';
        document.getElementById('repeatcheck2').innerHTML = 'OK';
    } 
    else 
    {
        if( document.getElementById('bevestig').value != '' )
        {
            document.getElementById('repeatcheck2').style.color = 'red';
            document.getElementById('repeatcheck2').innerHTML = 'X';
        } 
    }
   }

function tochRegister()
{
    document.getElementById("regist").checked = true;
    doRegister();
}

    document.getElementById("registreer").className = "hide";
    document.getElementById("inloggen").className = "hide";
    document.getElementById("direct").className = "hide";

    if (document.getElementById("login").checked) {
        doLogin();
    }
    else if (document.getElementById("regist").checked) {
        doRegister();
    }
    else if (document.getElementById("zonder").checked) {
        doZonder();
    }

    function doLogin() {
        document.getElementById("inloggen").className = "show";
        document.getElementById("registreer").className = "hide";
        document.getElementById("direct").className = "hide";
    }

    function doRegister() {
        document.getElementById("registreer").className = "show";
        document.getElementById("inloggen").className = "hide";
        document.getElementById("direct").className = "hide";
    }

    function doZonder() {
        document.getElementById("direct").className = "show";
        document.getElementById("registreer").className = "hide";
        document.getElementById("inloggen").className = "hide";
    }

</script>