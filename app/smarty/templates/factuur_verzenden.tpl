{include file="openheader.tpl"}
<script type="text/javascript" src="js/nicEdit.js"></script>
{include file="closeheader.tpl"}

<form id="form_id" method="post" action="{$SCRIPT_NAME}">
    <h2>Openstaande facturen</h2>
    <table>
        <thead>
            <tr>
                <th>Inschrijfnummer</th>
                <th>Evenement</th>
                <th>Contact</th>
                <th>Verzenden</th>
            </tr>
        </thead>

        {foreach $factuur_lijst as $factuur}
        <tr>
            <td>
                <b>{$factuur.inschrijving}</b><br />
            </td>
            <td>
                <b>{$factuur.evenement}</b><br />
            </td>
            <td>
                {$factuur.naam}<br />
            </td>
            <td>
                {if $factuur.Err != "" }
                  <button type="button" name="factuurid" value="{$factuur.id}" disabled>Factuur verzenden</button>
                {else}
                  <button type="button" name="factuurid" value="{$factuur.id}" onclick="myFunction('{$factuur.id}', '{$factuur.evenement}', '{$factuur.inschrijving}', '{$factuur.serialnaam}', '{$factuur.email}', '{$factuur.naam}')">Factuur verzenden</button>
                {/if}
                <span class="error">{$factuur.Err}</span>
            </td>
        </tr>
        {/foreach}
    </table>

    <button name="terug">Terug</button>
    <input type="hidden" id="verzend">
    <input type="hidden" id="factuurnummer" name="factuurnummer">
    <input type="hidden" id="factuurid" name="factuurid" value="{$factuur.id}">
    <input type="hidden" id="evenement" name="evenement" value="{$factuur.evenement}">
    <input type="hidden" id="serialnaam" name="serialnaam" value="{$factuur.serialnaam}">
    <input type="hidden" id="emailadres" name="emailadres" value="{$factuur.email}">


</form>

{include file="statusregel.tpl"}

<script>
  function myFunction( id, evenement, nummer, serialnaam, emailadres, naam ) 
  {
      var factuurnr = prompt( "Geef factuurnummer voor:\n  Evenement: " + evenement + "\n  inschrijfnummer: " + nummer + "\n  van: " + naam, "");
      if (factuurnr != null) 
      {
        document.getElementById("factuurnummer").value = factuurnr;
        document.getElementById("factuurid").value = id;
        document.getElementById("evenement").value = evenement;
        document.getElementById("serialnaam").value = serialnaam;
        document.getElementById("emailadres").value = emailadres;
        document.getElementById("verzend").name = "verzend";
        document.getElementById("form_id").submit();
      }
      else
      {
        return false;
      }
  }
</script>

{include file="footer.tpl"}