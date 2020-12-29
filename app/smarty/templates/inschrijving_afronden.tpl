{include file="header-klant.tpl"}

<div class="tlwrapper">
  <ol class="timeline">
    <li class="timeline-past">
      <span>Contactpersooon</span>
    </li>
    <li class="timeline-past">
      <span>Deelnemer toevoegen</span>
    </li>
    <li class="timeline-past">
      <span>Overzicht</span>
    </li>
    <li class="timeline-current">
      <span>Betaling en bevestiging</span>
    </li>
    <li><span>Inschrijving gereed</span></li>
  </ol>
</div>

<h2>Inschrijving {$evenement_naam}</h2>

<h4>Inschrijving nummer {$inschrijvingnummer}</h4>

<h4>Contactpersoon: {$contactpersoon_naam}</h4>

<form method="post" id="form1" action="{$SCRIPT_NAME}">

  <div class="aantal">
    <label for="aantal_deelnemers">Aantal deelnemers à &euro;{$prijs_per_persoon}:</label>
    <input type="number" name="aantal_deelnemers" id="aantal_deelnemers1" value="{$aantal_deelnemers}" readonly
      onblur="addPrices()">
    <input type="hidden" id="prijs1" value="{$prijs_per_persoon}">
  </div>

  <div class="aantal">
    <label for="aantal_deelnemers">Prijs : &euro; </label>
    <input type="text" class="xshort" name="totaalprijs" value="{$totaalprijs}" readonly>
  </div>

  {if $totaalprijs_opties != 0 }
  <div class="aantal">
    <label for="totaalprijs_opties">Totaalbedrag deelnemeropties : &euro; </label>
    <input type="text" class="xshort" name="totaalprijs_opties" id="extra_bedrag1" value="{$totaalprijs_opties}"
      readonly onblur="addPrices()">
    <input type="hidden" id="extra_bedrag_prijs1" value="{$totaalprijs_opties}">
  </div>
  {/if}
  <br/>
  
  {$dynamichtml}

  <span class="error">{$validatiemelding}</span>

  <br/><br/>
  <div class="subtotaalprijs">
  <strong>
    Subtotaal: &euro;
    <input type="text" class="subprijsshort" id="subtotaal" value="0.00" readonly>
  </strong>
  </div>

  {$avhtml}
  <br />
  <div id="betaalwijze">
  {$betaalwijzeHtml}
  </div>
  
  <br />
  <div id="betaalwijze">
    {$voucherHtml}
  </div>

  <div class="totaalprijs">
    <table align="center">
      <tr>
        <td>
          <strong>Totaal: &euro;</strong>
        </td>
        <td>
          <input type="text" class="totprijsshort" name="totaalbedrag" id="totaal" value="0.00" readonly>
        </td>
      </tr>
{if {$reedsbetaald} > 0}
      <tr>
        <td>
          Reeds betaald : &euro;
        </td>
        <td>
          <input type="text" class="totprijsshort" name="reedsBetaald" id="reedsBetaald" value="{$reedsbetaald}" readonly><br/>
        </td>
      </tr>
{/if}
      <tr>
        <td>
          Nog te betalen: &euro;
        </td>
        <td>
          <input type="text" class="totprijsshort" name="teBetalen" id="teBetalen" value="0.00" readonly>
        </td>
      </tr>
    </table>
  </div>



  {if $aantal_deelnemers != 0}
  <!--button name="opslaan" onclick="history.go(-1)">Opslaan</button-->
  <br />
  <br />

  {if !$isPersoneel && {$voorwaarden} != ""}
  <input type="checkbox" title="Akkoord voorwaarden" name="akkoord_voorwaarden" required value="0">
  <label class="medium"> <a href="{$voorwaarden}" alt="Bekijk onze voorwaarden" target="_blank">Ik ga
      akkoord met de inschrijfvoorwaarden</a></label>
  <br />
  {/if}

  <input type="checkbox" title="Nieuwsbrief" name="nieuwsbrief" value="1" checked>
  <label class="medium">Ik wil op de hoogte gehouden worden</label>
  <br />
  <br />
  
  <fieldset class="medium">
  <div align="center">
  <button name="opslaan">Bevestig inschrijving</button>
  <br />
  <strong>Hiermee maakt u de inschrijving definitief.</strong>
  <br />
  </div>
  </fieldset>
  <br />
  <button onclick="history.go(-1);">Terug</button>
  <br />
  <span class="error">{$statusErr}</span>
  {else}
  <br/>
  <br/>
  <strong>Er zijn geen deelnemers opgevoerd.</strong>
  <br/>
  <br/>
  {/if}

  <input type="hidden" id="evenementId" name="evt" value="{$evt}">
  <input type="hidden" name="max_deelnemers" value="{$max_deelnemers}">
  <input type="hidden" name="aantal_beschikbaar" value="{$aantal_beschikbaar}">
  <input type="hidden" name="heeft_annuleringsverzekering" value="{$heeft_annuleringsverzekering}">
  
  {include file="statusregel.tpl"}

</form>

{include file="js/inschrijving_prijs.js"}

{include file="footer.tpl"}