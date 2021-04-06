{include file="header.tpl"}

    <form method="post" action="{$SCRIPT_NAME}">
      <button class="zweven" name="terug">Terug</button> 
      <h2>{$doctitle}</h2>
        <button name={$buttonname} value="1">{$buttontekst}</button> 
        <button name="toevoegen" value="2">Evenement toevoegen</button>
        {if sizeof($Evenementen) > 0 }
        <table>
          <thead>
          <tr>
             <th>Evenement<br/>nummer</th>
             <th>Naam</th>
             <th>Begindatum
               <hr style="height:1px;width:80%;margin: auto;"/>
               Start inschrijving
             </th>
             <th>Einddatum
               <hr style="height:1px;width:80%;margin: auto;"/>
               Einde inschrijving
             </th>
             <th>Prijs</th>
             <th>Status</th>
             <th>Aantal<br/>deelnemers</th>
             <th>Beschikbaar</th>
             <th>Actie</th>
          </tr>
          </thead>
        {foreach $Evenementen as $evenement}
            <tr>
              <td style="text-align:center">
              {if $evenement.deleted == "1" }<del>{/if}
                <a href=preview_deelnemer.php?evt={$evenement.id} target="_blank">{$evenement.id}</a>
              {if $evenement.deleted == "1" }</del>{/if}
              </td>
              <td style="text-align:center">
              {if $evenement.deleted == "1" }<del>{/if}
               <a href=evenement_opvoeren.php?evt={$evenement.id}>{$evenement.naam}</a>
              {if $evenement.deleted == "1" }</del>{/if}
              </td>
              <td style="text-align:center">
              {if $evenement.deleted == "1" }<del>{/if}
                {if $evenement.started == "1" }<strong>{/if}
                  {$evenement.datum_begin}
                {if $evenement.started == "1" }</strong>{/if}
                  <hr style="height:1px;width:80%;margin: auto;"/>
                {if $evenement.inschrijven == "1" }<strong>{/if}
                  {$evenement.inschrijving_begin}
                {if $evenement.inschrijven == "1" }</strong>{/if}
              {if $evenement.deleted == "1" }</del>{/if}
              </td>
              <td style="text-align:center">
              {if $evenement.deleted == "1" }<del>{/if}
              {$evenement.datum_eind}
              <hr style="height:1px;width:80%;margin: auto;"/>
              {$evenement.inschrijving_eind}
              {if $evenement.deleted == "1" }</del>{/if}
              </td>
              <td style="text-align:center">
              {if $evenement.deleted == "1" }<del>{/if}
              &euro; {$evenement.prijs}
              {if $evenement.deleted == "1" }</del>{/if}
              </td>
              <td style="text-align:center">
                {if $evenement.deleted == "1" }<del>{/if}
                {$evenement.status}
                {if $evenement.deleted == "1" }</del>{/if}
              </td>
              <td style="text-align:center">
                 {if $evenement.deleted == "1" }<del>{/if}
                 {$evenement.max_deelnemers}
                 {if $evenement.deleted == "1" }</del>{/if}
              </td>
              <td style="text-align:center">
                {if $evenement.deleted == "1" }<del>{/if}
                {$evenement.aantal_beschikbaar}
                {if $evenement.deleted == "1" }</del>{/if}
              </td>
              <td style="text-align:center">
                  <button name="aanpassen" value={$evenement.id}>Aanpassen</button>
                  <button name="statistiek"  value={$evenement.id}>Statistiek</button>
                  {if $evenement.kanVerwijderd == "1"}
                      <button name="verwijder" value={$evenement.id} onclick="return verwijderKlik('{$evenement.naam}')">Verwijder</button> 
                      {/if}
              </td> 
            </tr>  
        {/foreach}
        </table>
        {else}
        <br/>
          <strong>Er zijn geen actieve evenementen</strong>
        <br/>
        {/if}
        <button name="terug">Terug</button> 

    {include file="statusregel.tpl"}
 
    </form>

    <script>
        function verwijderKlik(naam)
        {
            return confirm( "Evenement: " + naam + "\nEvenement verwijderen?");
        }
    </script>

{include file="footer.tpl"}