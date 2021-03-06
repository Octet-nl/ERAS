{include file="header-klant.tpl"}

  <div class="tlwrapper">
    <ol class="timeline">
      <li class="timeline-past">
              <span>Contactpersooon</span>
          </li>
      <li class="timeline-past">
              <span>Deelnemer toevoegen</span>
      </li>
      <li class="timeline-current">
         <span>Overzicht</span>
      </li>
      <li><span>Betaling</span></li>
      <li><span>Inschrijving gereed</span></li>
    </ol>
  </div>

    <form method="post" action="{$SCRIPT_NAME}">

        <h2>Inschrijving {$evenement_naam}</h2>
        
        <h4>Inschrijving nummer {$inschrijvingnummer}</h4>

        {if $changeDefinitief }
        <h4>=> Deze inschrijving is definitief <=</h4>
        {/if}
        
        {if !$deelnemerIsContactpersoon}
          <h3>Contactpersoon:</h3>
          {$contactpersoon_naam}
          <button name="bewerk_contact" value={$contactpersoon_id}>Aanpassen</button> 
          <br/>
          {if $aantalDeelnemers == 0}
            Klik <em>Aanpassen</em> als u de contactpersoon ook als deelnemer wilt opvoeren
          {/if}
        {/if}

        <h3>Deelnemers:</h3>

        {if !$changeDefinitief }
          {if $aantal_beschikbaar > 0}
            <h4>Nog beschikbaar: {$aantal_beschikbaar} plaatsen</h4>
          {else}
            <h4>Er zijn geen plaatsen meer beschikbaar</h4>
          {/if}
        {/if}
        <table>
          <thead>
          <tr>
             <th>Naam</th>
             <th>Geb.datum</th>
             <th>Mail adres</th>
             <th>Telefoonnr.</th>
             <th>Opties</th>
             <th>Bedrag</th>
             <th>Acties</th>
          </tr>
          </thead>

        {foreach $deelnemers as $deelnemer}
            <tr>
              <td>{$deelnemer.deelnemer_naam}</td>
              <td>{$deelnemer.geb_datum}</td>
              <td>{$deelnemer.mail}</td>
              <td>{$deelnemer.telefoonnr}</td>
              <td>{$deelnemer.opties}</td>
              <td>&euro;{$deelnemer.bedrag}</td>
              <td>
       {if $aantal_beschikbaar > -10 }
                 <button name="bewerk" value={$deelnemer.deelnemer_id} >Aanpassen</button> 
                 {if !$changeDefinitief || $isMedewerker }
                   <button name="verwijder" value={$deelnemer.deelnemer_id} onclick="return  confirm('Verwijderen van \n{$deelnemer.deelnemer_naam}.\nWeet u het zeker?')">Verwijderen</button> 
                 {/if}
       {else}
           Wijzigen niet mogelijk, evenement is vol
       {/if}
              </td> 
            </tr>  
        {/foreach}
        {if $inschrijvingsopties != ""}
          <tr>
              <td class="noborder"></td>
              <td class="noborder"></td>
              <td class="noborder"></td>
              <td class="noborder"></td>
              <td>{$inschrijvingsopties}</td>
              <td>{$inschrijvingsprijs}</td>
          </tr>
          {/if}
          <tr>
              <td class="noborder"></td>
              <td class="noborder"></td>
              <td class="noborder"></td>
              <td class="noborder"></td>
              <td>Totaalbedrag:</td>
              <td>&euro; {$totaalprijs}</td>
            </tr>
            <tr>
              <td class="noborder"></td>
              <td class="noborder"></td>
              <td class="noborder"></td>
              <td class="noborder"></td>
              <td class="noborder tiny"><i>Deze berekening is ter indicatie.<br/>Er kunnen geen rechten aan ontleend worden!</i></td>
              <td class="noborder"></td>
            </tr>
        </table>

       {if $aantal_beschikbaar > 0 && (!$changeDefinitief || $isMedewerker) }
       <button name="toevoegen" >Deelnemer toevoegen</button>
       {/if}

       {if $aantal_beschikbaar < 0 }
         <strong>Dit evenement is helaas vol. U kunt geen deelnemers meer boeken. Neem a.u.b. contact met ons op.</strong>
       {else}
         {if !$changeDefinitief || $isMedewerker }
         <button name="afronden" >Naar afronding >></button>
         {/if}
       {/if}
       {if $changeDefinitief }
         <button name="overzicht">Overzicht</button>
       {/if}


       <input type="hidden" name="aantalDeelnemers" value={$aantalDeelnemers}>
       <input type="hidden" name="deelnemerIsContactpersoon" value={$deelnemerIsContactpersoon}>

       {include file="statusregel.tpl"}

    </form>

{include file="footer.tpl"}