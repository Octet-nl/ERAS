<!DOCTYPE HTML>
<html>

<head>
  <title>{$doctitle}</title>
  <link rel="stylesheet" type="text/css" href="css/colors.css">
  <link rel="stylesheet" type="text/css" href="css/font.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="icon" href="favicon.png" type="image/png" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
  <noscript>Deze website werkt beter met JavaScript.</noscript>

  <form method="post" action="{$SCRIPT_NAME}">
    <h2>Installatie ERAS</h2>

    <fieldset id="check">
      <h2>Controles</h2>
      <div>
        <h3>Algemene systeemcontrole<br /></h3>
        De installatie slaagt alleen als alle controles succesvol zijn.<br/><br/>
        <table>
          {foreach $presentie as $present}
          <tr>
            <td>
              {$present.0}
            </td>
            <td>
              {if ($present.1 == '1') }
                <span class="signalMessage"> OK</span>
              {else}
                <span class="signalError">X</span>
              {/if}
            </td>
          </tr>
          {/foreach}
          </table>
      </div>
      {if $isOk}
      <button name="verder" value=1 >Verder</button>
      <br />
      {/if}
      <span class="error">{$createErr}</span>
    <input type="hidden" name="isOk" value="{$isOk}">
    </fieldset>

    <fieldset id="create">
      <h3>Nieuwe database</h3>
      <div>In deze installatieprocedure kunt u een database voor ERAS aanmaken. <br />
        U heeft hier een gebruikers ID voor nodig dat voldoende rechten heeft (bijvoorbeeld 'root').

        <div class="tooltip">?
          <span class="tooltiptext wide xright">
            <br />
            U kunt ook zelf op een andere manier de database aanmaken, bijvoorbeeld met MySQLAdmin of met 'mysql' via de
            commandline.
            U kunt dit als volgt doen
            <br /><br />

            <code>   # mysql -u root -p <br/>
              > CREATE DATABASE eras DEFAULT CHARACTER SET utf8mb4;
            </code>

            <br /><br />
            Geef gebruiker 'erasuser' rechten op deze database:<br/>
            <i>('erasuser@localhost' en 'uw_wachtwoord' kunt u aanpassen)</i>
            <br /><br />

            <code>
              > GRANT SELECT,INSERT,UPDATE,DELETE,CREATE,DROP,INDEX,ALTER,CREATE TEMPORARY TABLES ON eras.* 
                      TO erasuser@localhost IDENTIFIED BY 'uw_wachtwoord'; <br/>
              > quit <br/>
            </code>
            <br /><br />
          </span>
        </div>

        <br /><br/>

        <div>
          <label class="longer" for="hostname">Host naam:</label>
          <input class="longer" type="text" name="createhost" value="{$createhost}"><br />
          <span class="error">{$createhostErr}</span>
          <br />
          <label class="longer" for="createport">Poort:</label>
          <input class="short" type="text" name="createport" value="{$createport}">
          <div class="tooltip">?
            <span class="tooltiptext">Het default poortnummer van een MySQL/MariaDB database is 3306. <br/>
            Verander dit nummer niet tenzij u zeker weet dat uw database op een andere poort draait.<br/>
            Als u een foutcode 2002 krijgt, heeft u een verkeerde hostnaam of een verkeerd poortnummer opgegeven</span>
          </div>
          <span class="error">{$createportErr}</span>
          <br />
          <label class="longer" for="rootUser">Gebruikers ID met CREATE rechten:</label>
          <input class="short" type="text" name="rootuser" value="{$rootuser}">
          <div class="tooltip">?
            <span class="tooltiptext">Dit kan bijvoorbeeld 'root' zijn, of een andere user die voldoende rechten op de
              omgeving heeft om een database aan te maken.</span>
          </div>
          <br />
          <span class="error">{$rootuserErr}</span>
          <br />
          <label class="longer" for="rootpassword">Wachtwoord van dit userid:</label>
          <input class="short" type="password" name="rootpassword" value="{$rootpassword}"><br />
          <span class="error">{$rootpasswordErr}</span>
          <br />
          <hr />
          <br />
          <br />
          <label class="longer" for="createdb">ERAS database naam:</label>
          <input class="short" type="text" name="createdb" value="{$createdb}">
          <span class="error">{$createdbErr}</span>
          <br />
          <label class="longer" for="erasuser">Gebruikers ID van ERAS:</label>
          <input class="short" type="text" name="erasuser" value="{$erasuser}">
          <div class="tooltip">?
            <span class="tooltiptext">Bij voorkeur geen 'root' gebruiken. Voor uw veiligheid is het beter een apart
              userid voor ERAS te maken</span>
          </div>
          <br />
          <span class="error">{$erasuserErr}</span>
          <br />
          <label class="longer" for="eraspassword">Wachtwoord van ERAS gebruikers ID:</label>
          <input class="short" type="eraspassword" name="eraspassword" value="{$eraspassword}"><br />
          <span class="error">{$eraspasswordErr}</span>
        </div>
        <button name="aanmaken" value=1>Nu een database maken</button>
        <button type="button" name="overslaan" value=2 onclick="doLoad()">Overslaan, ik heb al een database gemaakt</button>
        <br />
        <span class="error">{$createErr}</span>
        <br />
        <br />
    </div>
    </fieldset>

    <br />

    <fieldset id="load">
      <h3>Vooraf aangemaakte database</h3>
      <br />
      Als u de database voor ERAS heeft aangemaakt wordt u verzocht onderstaande gegevens in te vullen:
      <br />
      <br />
      <div class="window_back">

        <div>
          <label class="short" for="hostname">Host naam:</label>
          <input class="longer" type="text" name="hostname" value="{$hostname}"><br />
          <span class="error">{$hostnameErr}</span>
          <br />
          <label class="short" for="dbname">Database naam:</label>
          <input class="short" type="text" name="dbname" value="{$dbname}"><br />
          <span class="error">{$dbnameErr}</span>
          <br />
          <label class="short" for="dbname">Poortnummer:</label>
          <input class="short" type="text" name="poortnummer" value="{$poortnummer}"><br />
          <span class="error">{$poortnummerErr}</span>
          <br />
          <label class="short" for="userid">Gebruikers ID:</label>
          <input class="short" type="text" name="userid" value="{$userid}"><br />
          <span class="error">{$useridErr}</span>
          <br />
          <label class="short" for="password">Wachtwoord:</label>
          <input class="short" type="password" name="password" value="{$password}"><br />
          <span class="error">{$passwordErr}</span>
        </div>

        <button type="button" name="terug" value=2 onclick="doTerug()">Terug</button>
        <button name="laden" value=1>Database laden</button>
       <!-- <button type="button" name="instellingen" value=2 onclick="doSetup()">Overslaan, wijzig instellingen</button> -->
        <span class="error">{$createErr}</span>
      </div>
      <input type="hidden" name="saveport" value="{$saveport}">
    </fieldset>

    <fieldset id="setup">
      <h3>Instellingen</h3>
      <br />
      Wijzig de basisinstellingen voor zover nu al bekend.
      <br/>Later kunt u via het hoofdmenu alles nog aanpassen.
      <br />
      <br />
      <div class="window_back">

        <div>

          <br/>
          <label class="longer" for="this">Laden database:</label>
          <span class="signalMessage"> OK</span>
          <br/>
          <label class="longer" for="rootpw">Wijzig ROOT wachtwoord:</label>
          <button name="rootpw" value=1>Wijzig wachtwoord</button>
          <div class="tooltip">?
            <span class="tooltiptext">Bij installatie is 'root' het enige userid. Het initi&euml;le wachtwoord is 'ERASroot'. Wijzig dit wachtwoord zo snel mogelijk.<br/>
              Daarna gebruikt u 'root' om gebruikers aan te maken.<br/>Later wordt 'root' alleen nog gebruikt voor heel specifieke zaken. 
              Zie hiervoor de <a href="../images/Autorisatiematrix.bmp">autorisatiematrix</a></span>
          </div>
          {if ($rootchanged == '1') }
             <span class="signalMessage"> OK</span>
          {else}
             <span class="signalError">Nog doen</span>
          {/if}
          <span class="error">{$rootpwErr}</span>
          <br />

          <label class="longer" for="instellingen">Wijzig basisinstellingen:</label>
          <button name="instellingen" value='1'>Wijzigen</button>
          {if ($settingschanged == '1') }
             <span class="signalMessage"> OK</span>
          {else}
             <span class="signalError">Nog doen</span>
          {/if}
          <br />

          <label class="longer" for="gebruikers">Gebruikers aanmaken:</label>
          <button name="gebruikers" value='1'>Aanmaken</button>
          {if ($userschanged == '1') }
            <span class="signalMessage"> OK</span>
          {else}
            <span class="signalError">Nog doen</span>
          {/if}
          <br />

      </div>
    </div>

      {if $rootchanged == "1" && $settingschanged == "1" && $userschanged == "1"}
        <br/>
        U kunt de installatieprocedure nu afsluiten en het bestand 'install.php' verwijderen.
        <br/>
        U wordt automatisch afgemeld. 
        Via 'Account' kunt u zich zometeen weer aanmelden als een van de zojuist opgevoerde gebruikers.
        <br/>
        <button name="klaar" value=1>Afsluiten, start ERAS</button>
        {/if}
      </div>
    </fieldset>
  </form>

  <script>

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

    window.onload = onLoad();
    function onLoad( deel = {$schermdeel} ) {
      if ( deel == "0" )
      {
        document.getElementById("check").className = "show";
        document.getElementById("create").className = "hide";
        document.getElementById("load").className = "hide";
        document.getElementById("setup").className = "hide";
      }
      else if ( deel == "1" )
      {
        document.getElementById("check").className = "hide";
        document.getElementById("create").className = "show";
        document.getElementById("load").className = "hide";
        document.getElementById("setup").className = "hide";
      }
      else if ( deel == "2" )
      {
        document.getElementById("check").className = "hide";
        document.getElementById("create").className = "hide";
        document.getElementById("load").className = "show";
        document.getElementById("setup").className = "hide";
      }
      else if ( deel == "3" )
      {
        document.getElementById("create").className = "hide";
        document.getElementById("check").className = "hide";
        document.getElementById("load").className = "hide";
        document.getElementById("setup").className = "show";
      }
    }

    function doLoad() {
      document.getElementById("check").className = "hide";
        document.getElementById("create").className = "hide";
        document.getElementById("load").className = "show";
        document.getElementById("setup").className = "hide";
    }
    function doTerug() {
      document.getElementById("check").className = "hide";
        document.getElementById("create").className = "show";
        document.getElementById("load").className = "hide";
        document.getElementById("setup").className = "hide";
    }
    function doSetup() {
      document.getElementById("check").className = "hide";
        document.getElementById("create").className = "hide";
        document.getElementById("load").className = "hide";
        document.getElementById("setup").className = "show";
    }

  </script>

</body>

</html>