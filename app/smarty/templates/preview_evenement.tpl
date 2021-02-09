{include file="header.tpl"}

<form method="post" action="{$SCRIPT_NAME}">

    <h4>Let op: Deze toepassing dient om de layout van evenementen en opties te beoordelen voordat ze "live" gaan.</h4>
    
    <h2>{$doctitle}</h2>
    <button name={$buttonname} value="1">{$buttontekst}</button> 
        {if sizeof($Evenementen) > 0 }
           {foreach $Evenementen as $evenement}

                <h2>{$evenement.naam}</h2>
                <h3>Evenementnummer {$evenement.id}</h3>
                {if $evenement.datumEind eq $evenement.datumBegin }
                  <h3>Op {$evenement.datumBegin}</h3>
                {else}
                  <h3>Van {$evenement.datumBegin} tot {$evenement.datumEind}</h3>
                {/if}

                {$evenement.korteOmschrijving}
                <br/><br/>
                Prijs &euro; {$evenement.prijs}
                <br/><br/>
                {if $evenement.status ==  $statusGeannuleerd}
                    <strong>Dit evenement is geannuleerd.</strong>
                {else}
                  {if $evenement.beschikbaar == 0}
                     <strong>Er zijn geen plaatsen meer beschikbaar. U kunt nog wel informatie aanvragen.</strong>
                  {else}
                     {if $evenement.beschikbaar == 1}
                        <strong>Er is nog één plaats beschikbaar</strong>
                     {else}
                        Er zijn nog {$evenement.beschikbaar} plaatsen beschikbaar
                     {/if}
                  {/if}
                  <br/>
                  <strong>{$evenement.statusTekst}</strong>
                  <br/>
                  <br/>
                  <i>De voorbeeldlayout (preview) wordt in een nieuwe tab/window getoond.<br/>
                   De preview heeft een automatische verversing ({$refresh} sec) zodat u alle wijzigingen live kunt volgen.</i><br/><br/>
                  <a class="linkbutton" href="preview_deelnemer.php?evt={$evenement.id}" target="_blank">Toon layout</a>
                  <br/>
                  <br/>
                {/if}
            {/foreach}
         {else}
        <br/>
        <h2>Geen evenementen gevonden.</h2>
        <br/>
        {/if}
        <button name="terug">Terug</button> 

    </form>

{include file="footer.tpl"}