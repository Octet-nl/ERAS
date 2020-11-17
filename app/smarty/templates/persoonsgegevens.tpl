<div class="{$id_visibility}">
    <label for="id">Id:</label>
    <input type="number" name="id" value="{$id}" readonly>

    <div class="hide">
        <input type="text" name="evt" value="{$evt}">
    </div>

</div>

<div style="clear:left">
    <div style="float: left;width: 200px">
        <label for="voornaam">Voornaam:</label>
        <input size="20" type="text" name="voornaam" value="{$voornaam}">
        <div class="error">{$voornaamErr}</div>
    </div>
    <div style="float: left;width: 50px">
        <label for="tussenvoegsel">Tussenvoegsel:</label>
        <input size="20" type="text" name="tussenvoegsel" value="{$tussenvoegsel}">
        <div class="error">{$tussenvoegselErr}</div>
    </div>
</div>

<div style="clear:left">
    <div style="float: left;width: 200px">
        <label for="achternaam">Achternaam:</label>
        <input type="text" class="medium" name="achternaam" value="{$achternaam}">
        <div class="error">{$achternaamErr}</div>
    </div>
</div>

<div style="clear:left">
    <div style="float: left;width: 200px">
        <label for="straat">Straat:</label>
        <input type="text" name="straat" value="{$straat}">
        <div class="error">{$straatErr}</div>
    </div>
    <div style="float: left;width: 100px">
        <label for="huisnummer">Huisnr:</label>
        <input type="number" min="1" max="99999" name="huisnummer" value="{$huisnummer}">
        <div class="error">{$huisnummerErr}</div>
    </div>
    <div style="float: left;width: 80px">
        <label for="huisnummer_toevoeging">Toevoeging:</label>
        <input size="10" type="text" name="huisnummer_toevoeging" value="{$huisnummer_toevoeging}">
        <div class="error">{$huisnummer_toevoegingErr}</div>
    </div>
</div>

<div style="clear:left">
    <div style="float: left;width: 150px">
        <label for="postcode">Postcode:</label>
        <input size="10" type="text" name="postcode" placeholder="9999AA" value="{$postcode}">
        <div class="error">{$postcodeErr}</div>
    </div>
    <div style="float: left;width: 200px">
        <label for="woonplaats">Woonplaats:</label>
        <input type="text" name="woonplaats" value="{$woonplaats}">
        <div class="error">{$woonplaatsErr}</div>
    </div>
    {if $volledigheid & $keuzeLandnaam }
      <div style="float: left;width: 200px">
          <label for="landnaam">Land:</label>
          <input type="text" name="landnaam" value="{$landnaam}">
          <div class="error">{$landnaamErr}</div>
      </div>
    {/if}
</div>

<div style="clear:left"></div>

{if $volledigheid & $keuzeMail || $all}
<div style="float: left;width: 200px">
    <label for="email">E-mail:</label>
    <input type="text" name="email" value="{$email}" {$readonly_email}>
    <div class="error">{$emailErr}</div>
</div>
{/if}

{if $volledigheid & $keuzeTelefoon || $all}
<div style="float: left;width: 200px">
    <label for="telefoonnummer">Telefoonnummer:</label>
    <input type="text" name="telefoonnummer" value="{$telefoonnummer}">
    <div class="error">{$telefoonnummerErr}</div>
</div>
{/if}

<div style="clear:left">
</div>

{if $volledigheid & $keuzeGeboortedatum || $all}
<div style="float: left;width: 200px">
    <label for="geboortedatum">Geboortedatum:</label>
    <input type="text" name="geboortedatum" placeholder="01-01-2001" value="{$geboortedatum}">
    <div class="error">{$geboortedatumErr}</div>
</div>
{/if}

{if $volledigheid & $keuzeGeslacht || $all}
<div style="float: left;width: 200px">
    <label for="geslacht">Geslacht:</label>
    <input type="text" name="geslacht" maxlength="1" value="{$geslacht}">
    <div class="error">{$geslachtErr}</div>
</div>
{/if}