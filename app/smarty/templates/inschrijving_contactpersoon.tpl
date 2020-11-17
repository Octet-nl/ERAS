{include file="header-klant.tpl"}

    {if not $wijzigen}
      <div class="tlwrapper">
        <ol class="timeline">
          <li class="timeline-current"><span>Contactpersooon</span></li>
          <li><span>Deelnemer toevoegen</span></li>
          <li><span>Overzicht</span></li>
          <li><span>Betaling</span></li>
          <li><span>Inschrijving gereed</span></li>
        </ol>
      </div>
    {/if}

    <h2>{$doctitle}</h2>
    <form method="post" action="{$SCRIPT_NAME}">
        <h2>Uw persoonlijke gegevens:</h2>
        {include file="persoonsgegevens.tpl"}

        <div style="clear:left">
          <br />
          {if not $wijzigen}
          <label class="radiotitel" for="deelnemer">Bent u zelf ook deelnemer?</label>
          <input class="form-control" type="radio" name="deelnemer" value="ja" {$jachecked}>ja
          <input class="form-control" type="radio" name="deelnemer" value="nee" {$neechecked}>nee
          {/if}
        </div>
        <button name="opslaan">Opslaan</button>

        <input type="hidden" name="gebruiker_email" value="{$gebruiker_email}">

        <span class="error">{$validatiemelding}</span>
        
        {include file="statusregel.tpl"}

    </form>
