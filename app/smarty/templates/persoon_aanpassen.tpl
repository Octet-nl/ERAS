{include file="header-klant.tpl"}

    {if not $wijzigen}
      <div class="tlwrapper">
        <ol class="timeline">
          <li class="timeline-current">
                  <span>Contactpersooon</span>
              </li>
          <li>
                  <span>Deelnemer toevoegen</span>
          </li>
          <li><span>Overzicht</span></li>
          <li><span>Betaling</span></li>
          <li><span>Inschrijving gereed</span></li>
        </ol>
      </div>
    {/if}

    <h2>{$doctitle}</h2>
    <form method="post" action="{$SCRIPT_NAME}">

        {include file="persoonsgegevens.tpl"}

        <div style="clear:left">
          <br/>
        </div>

        <button name="opslaan">Opslaan</button>
        <button onclick="history.go(-1);">Terug</button>

        <span class="error">{$validatiemelding}</span>

        <input type="hidden" name="all" value="{$all}">

        {include file="statusregel.tpl"}

    </form>
