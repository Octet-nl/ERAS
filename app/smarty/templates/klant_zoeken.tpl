{include file="header.tpl"}

<form method="post" action="{$SCRIPT_NAME}">
  <div class="window_back">
    <div class="outer">
      <h2>{$doctitle}</h2>
      <div class="left_div">

        Zoek contactpersoon op:
        <br />
        <table>
          <tr>
            <td>
              <div>
                <label for="email">(Deel van) e-mail adres:</label>
                <input size="10" type="text" name="email" value="{$email}">
                <div class="error">{$emailErr}</div>
              </div>
            </td>
            <td>
              <button name="emailzoek">zoeken</button>
            </td>
          </tr>
          <tr>
            <td>
              <div>
                <label for="naam">(Deel van) achternaam:</label>
                <input size="10" type="text" name="naam" value="{$naam}">
                <div class="error">{$naamErr}</div>
              </div>
            </td>
            <td>
              <button name="naamzoek">zoeken</button>
            </td>
          </tr>
          <tr>
            <td>
              <div>
                <label for="inschrijfnummer">Inschrijfnummer:</label>
                <input size="10" type="text" name="inschrijfnummer" value="{$inschrijfnummer}">
                <div class="error">{$inschrijfnummerErr}</div>
              </div>
            </td>
            <td>
              <button name="inschrijfnummerzoek">zoeken</button>
            </td>
          </tr>
          <tr>
            <td>
              <div>
                <label for="postcode">Postcode:</label>
                <input size="10" type="text" name="postcode" placeholder="9999AA" value="{$postcode}">
                <div class="error">{$postcodeErr}</div>

                <label for="huisnummer">Huisnummer:</label>
                <input type="number" min="1" max="99999" name="huisnummer" value="{$huisnummer}">
                <div class="error">{$huisnummerErr}</div>
              </div>
            </td>
            <td>
              <button name="postcode_huisnummerzoek">zoeken</button>
            </td>
          </tr>
        </table>

        <br />
        <br />

        <br />

        {if sizeof($personenlijst) > 0 }
        <table>
          <thead>
            <tr>
              <th>Naam</th>
              <th>Email</th>
              <th>Adres</th>
              <th>Inschrijf-<br />nummer(s)</th>
              <th></th>
            </tr>
          </thead>

          {foreach $personenlijst as $persoon}
          <tr>
            <td>
              <a href="persoon_gegevens.php?all=1&prs={$persoon.id}">{$persoon.naam}</a>
            </td>
            <td>
              {$persoon.email}
            </td>
            <td align="">
              {$persoon.adres}
            </td>
            <td>
              {foreach $persoon.inschrijvingen as $inschrijfnummer}
              <a href="inschrijving_gegevens.php?id={$inschrijfnummer.inschrijfnr}">{$inschrijfnummer.inschrijfnr}</a>
              {$inschrijfnummer.evenement}<br />
              {/foreach}
            </td>
            <td>
              <a href="persoon_gegevens.php?all=1&prs={$persoon.id}"><button type="button">Klantcontact log</button></a>
            </td>
          </tr>
          {/foreach}
        </table>
        {else}
        <h4>Geen personen gevonden</h4>
        {/if}

        <button name="terug">Terug</button>
      </div>
    </div>
  </div>
  {include file="statusregel.tpl"}

</form>

{include file="footer.tpl"}