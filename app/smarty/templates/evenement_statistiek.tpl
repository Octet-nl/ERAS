{include file="header.tpl"}

    <form method="post" action="{$SCRIPT_NAME}">
        <h2>Overzicht {$evenementnaam} </h2>
          Evenement:
            <select name="evenement" onDblClick="this.form.submit()" >
                {html_options options=$evenementenLijst selected=$evenementid}
            </select>
          <button name="evenement_click">Selecteer</button>

<div>
<h4>Evenement ID: {$evenementid}, aantal deelnemers: {$aantal_deelnemers}, nog beschikbaar: {$aantal_beschikbaar} plaatsen.</h4>
<div style="display: inline-block;">
        <h3>Inschrijvingen</h3>
        <table>
            <tr>
                <td><a href="inschrijving_lijst.php?evt={$evenementid}&status=open">Open</a></td>
                <td style="width:5em;" align="center"> {$openInschrijvingen} </td>
            </tr>
            <tr>
                <td><a href="inschrijving_lijst.php?evt={$evenementid}&status=annuleer">Geannuleerd</a></td>
                <td align="center"> {$geannuleerdeInschrijvingen} </td>
            </tr>
            <tr>
               <td><a href="inschrijving_lijst.php?evt={$evenementid}&status=definitief">Definitief</a></td>
               <td align="center"> {$definitieveInschrijvingen} </td>
            </tr>
        </table>
</div>

<div style="display: inline-block;margin-left: 4em;" >
        <h3>Betaling</h3>
        <table>
            <tr>
                <td>Totaal te betalen</td>
                <td style="width:6em;" align="center">&euro; {$teBetalen} </td>
            </tr>
            <tr>
                <td>Al betaald</td>
                <td align="center">&euro; {$alBetaald} </td>
            </tr>
            <tr>
                <td>Betaald per voucher</td>
                <td align="center">&euro; {$betaaldPerVoucher} </td>
            </tr>
            <tr>
                <td>Korting</td>
                <td align="center">&euro; {$korting} </td>
            </tr>
            <tr>
                <td>Nog te betalen</td>
                <td align="center">&euro; {$nogTeBetalen} </td>
            </tr>
        </table>
</div>

<div style="display: inline-block;margin-left: 4em;" >
        <h3>Annuleringsverzekering</h3>
        <table>
            <tr>
                <td>Geen</td>
                <td style="width:5em;" align="center"> {$annuleringsverzekeringLijst["geen"]} </td style="width:5em;" align="center">
            </tr>
            <tr>
                <td>Gewoon</td>
                <td align="center"> {$annuleringsverzekeringLijst["gewoon"]} </td align="center">
            </tr>
            <tr>
                <td>All Risk</td>
                <td align="center"> {$annuleringsverzekeringLijst["allrisk"]} </td align="center">
            </tr>
        </table>
</div>

<div style="display: inline-block;margin-left: 4em;" >
    <h3>Vouchers</h3>
    <div>Dit zijn de vouchers voor <b>alle</b> evenementen</div>
    <table>
        <th></th>
        <th>Aantal</th>
        <th>Totaal<br/>Bedrag</th>
        <tr>
            <td>Uitgegeven</td>
            <td style="width:5em;" align="center"> {$beginaantalVouchers} </td style="width:5em;" align="center">
            <td style="width:5em;" align="center">&euro; {$beginwaardeVouchers} </td style="width:5em;" align="center">
        </tr>
        <tr>
            <td>Resterende waarde</td>
            <td align="center"> {$restaantalVouchers} </td align="center">
            <td align="center">&euro; {$restwaardeVouchers} </td align="center">
        </tr>
    </table>
</div>

</div>

<br/>

        <h3>Opties</h3>
        <table>
          <thead>
          <tr>
             <th>Groep</th>
             <th>Naam</th>
             <th style="width:20em">Tekst</th>
             <th style="width:5em">Prijs</th>
             <th style="width:5em">Aantal opties</th>
             <th style="width:5em">Totaal</th>
          </tr>
          </thead>
        {foreach $Opties as $optie}
            <tr>
              <td>
              {if $optie.deleted == "1" }<del>{/if}
                {$optie.groep}
              {if $optie.deleted == "1" }</del>{/if}
              </td>
              <td>
              {if $optie.deleted == "1" }<del>{/if}
                {$optie.naam}
              {if $optie.deleted == "1" }</del>{/if}
              </td>
              <td>
              {if $optie.deleted == "1" }<del>{/if}
                {$optie.tekst_voor}
              {if $optie.deleted == "1" }</del>{/if}
              </td>
              <td align="center">
              {if $optie.deleted == "1" }<del>{/if}
                {$optie.prijs}
              {if $optie.deleted == "1" }</del>{/if}
              </td>
              <td align="center">
              {if $optie.deleted == "1" }<del>{/if}
               {$optie.aantal_opties}
              {if $optie.deleted == "1" }</del>{/if}
              </td>
              <td align="center">
              {if $optie.deleted == "1" }<del>{/if}
                {$optie.totaalprijs}
              {if $optie.deleted == "1" }</del>{/if}
              </td>
              </tr>  
       {/foreach}
        </table>

        <button name="terug">Terug</button>
 
    </form>
    
{include file="footer.tpl"}