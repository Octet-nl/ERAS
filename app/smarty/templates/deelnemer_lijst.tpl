{include file="header.tpl"}

    <form method="post" action="{$SCRIPT_NAME}">
      <button class="zweven" name="terug">Terug</button> 
      <h2>Deelnemers ({$aantal})</h2>
      Evenement:
      <select name="evenement" onchange="submit();">
          {html_options options=$evenementenLijst selected=$evenementid}
      </select>

      {if sizeof($Deelnemers) > 0 }
      <table>
          <thead>
          <tr>
             <th>Evenement</th>
             <th>Deelnemer<br/>nummer</th>
             <th>inschrijving<br/>nummer</th>
             <th>Naam</th>
             <th>Geboortedatum</th>
             <th>Email</th>
             <th>Totaalbedrag</th>
             <th>Inschrijving<br/>status</th>
          </tr>
          </thead>

        {foreach $Deelnemers as $deelnemer}
            <tr>
              <td>
                {$deelnemer.evenement_naam}
              </td>
              <td>
                {$deelnemer.deelnemer_nummer}
              </td>
              <td>
                <a href="inschrijving_gegevens.php?id={$deelnemer.inschrijving_nummer}">{$deelnemer.inschrijving_nummer}</a> 
              </td>
              <td>
                <a href="persoon_aanpassen.php?all=1&prs={$deelnemer.persoon_nummer}">{$deelnemer.naam}</a>
              </td>
              <td>
                {$deelnemer.geboortedatum}
              </td>
              <td>
                {$deelnemer.email}
              </td>
              <td>
                {$deelnemer.totaalbedrag}
              </td>
              <td>
                {$deelnemer.status}
              </td>
            </tr>
       {/foreach}
       </table>
       {else}
         <br/><br/>Geen deelnemers gevonden. Kies een evenement waar u de deelnemers van wilt zien<br/>
       {/if}
       <button name="terug">Terug</button> 
       <input type="hidden" name="evt" value="{$evt}">

       {include file="statusregel.tpl"}
       
    </form>

{include file="footer.tpl"}