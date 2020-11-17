{include file="header-klant.tpl"}

<form method="post" action="{$SCRIPT_NAME}">

   {if ( isset($disclaimer))}
   <br/>
   {$disclaimer}
   <br/>
   {/if}

        {if sizeof($Evenementen) > 0 }

            {foreach $Evenementen as $evenement}

                <h2>{$doctitle} {$evenement.naam}</h2>
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
                  {$evenement.statusTekst}
                  <br/>
                  <button name="opslaan" value={$evenement.id}>Informatie</button>
                {/if}
            {/foreach}
         {else}
        <br/>
        {if ( isset($disclaimer))}
          <strong>Er zijn geen evenementen met status "wachten"</strong>
        {else}
          <strong>Er zijn geen actieve evenementen</strong>
        {/if}
        <br/>
        {/if}

    </form>

{include file="footer.tpl"}