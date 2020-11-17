{include file="header-klant.tpl"}

<h2>{$doctitle}</h2>
<div class="window_back_half">

<form method="post" action="{$SCRIPT_NAME}">

    <div class="outer">
        <h2>{$evenementnaam}</h2>
        {if $bevestig == ""}
        <div class="center_div">
            Door u hier registreren geeft u aan belangstelling te hebben voor<br/>
            dit evenement. Het is geen inschrijving voor het evenement.<br/>
            Inschrijven kan zodra de inschrijving geopend is.<br/><br/>
            Naam: <input class="medium" maxlength="128" type="text" name="naam" value="{$naam}"><br/>
            <div class="error">{$naamErr}</div><br/>
            Email: <input class="medium" type="text" name="email" maxlength="128" value="{$email}"><br/>
            <div class="error">{$emailErr}</div><br/>
            <button name="registreer">Registreer</button>
        </div>
        <div class="tiny">
            U geeft hiermee toestemming om per mail benaderd te worden met informatie over dit evenement.<br/>
            Onder iedere nieuwsbrief staat een link waarmee u zich kunt uitschrijven.
        </div>
        {else}
        <div class="center_div">
            {$bevestig}
          </div>
        {/if}
</div>
    
    <input type="hidden" name="evenementnaam" value="{$evenementnaam}">
    <input type="hidden" name="evenementid" value="{$evenementid}">

</form>
</div>
