{include file="header.tpl"}

<h2>{$doctitle}</h2>
<div class="window_back_half">

<form method="post" action="{$SCRIPT_NAME}">
    <h2>{$evenementnaam}</h2>

    <div style="clear:left">
        <div style="float: left;width: 200px">
            <label for="voornaam">Voornaam:</label>
            <input size="20" type="text" name="voornaam" value="{$voornaam}">
            <div class="error">{$voornaamErr}</div>
        </div>
        <div style="float: left;width: 50px">
            <label for="tussenvoegsel">Tussenvoegsel:</label>
            <input size="10" type="text" name="tussenvoegsel" value="{$tussenvoegsel}">
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
            <input size="10" type="number" min="1" max="99999" name="huisnummer" value="{$huisnummer}">
            <div class="error">{$huisnummerErr}</div>
        </div>
        <div style="float: left;width: 50px">
            <label for="huisnummer_toevoeging">Toevoeging:</label>
            <input size="10" type="text" name="toevoeging" value="{$toevoeging}">
            <div class="error">{$toevoegingErr}</div>
        </div>
    </div>

    <div style="clear:left">
        <div style="float:left;width: 150px">
            <label for="postcode">Postcode:</label>
            <input size="10" type="text" name="postcode" placeholder="9999AA" value="{$postcode}">
            <div class="error">{$postcodeErr}</div>
        </div>
        <div style="float: left;width: 200px">
            <label for="woonplaats">Woonplaats:</label>
            <input type="text" name="woonplaats" value="{$woonplaats}">
            <div class="error">{$woonplaatsErr}</div>
        </div>
    </div>

    <div style="clear: left;width: 200px">
        <label for="email">E-mail:</label>
        <input type="text" name="email" value="{$email}">
        <div class="error">{$emailErr}</div>
    </div>


    <div style="clear:left">
        <br />
    </div>
    <button name="opslaan">Opslaan</button>
    
    <input type="hidden" name="evenementnaam" value={$evenementnaam}>

</form>
</div>
