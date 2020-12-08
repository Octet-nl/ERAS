{include file="header.tpl"}

<form method="post" action="{$SCRIPT_NAME}">

<h2 align="center">{$doctitle}</h2>

<div class="window_back">
    <div class="outer">
        <div align="center">
          <div class="center_div">
            {if $melding != "" }
              {$melding}
            {else}
              Evenement: {$evenementnaam}<br/>
              Aantal subscribers: {$aantal}<br/>
              Nog te gaan: {$togo}<br/>
              Aantal per batch: {$size}<br/>
              {if $togo > 0 } 
                Volgende batch: {$start}<br/>
                <button name="verzend">Verzend batch nr. {$start}</button>
              {else}
                Batches zijn klaar.<br/>
              {/if}
                <button name="terug">Terug</button> 
            {/if}
          </div>
        </div>
    </div>
</div>
<input type="hidden" name="evenementnaam" value="{$evenementnaam}">
<input type="hidden" name="evt" value="{$evt}">
<input type="hidden" name="aantal" value="{$aantal}">
<input type="hidden" name="size" value="{$size}">
<input type="hidden" name="start" value="{$start}">
<input type="hidden" name="tekst" value="{$tekst}">

</form>

{include file="statusregel.tpl"}

{include file="footer.tpl"}