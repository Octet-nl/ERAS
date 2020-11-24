{include file="header-klant.tpl"}

<form method="post" action="{$SCRIPT_NAME}">

   {if ( isset($disclaimer))}
   <br/>
   {$disclaimer}
   <br/>
   {/if}
   <h1>{$doctitle}</h1>
      {if sizeof($Evenementen) > 0 }
        {foreach $Evenementen as $evenement}
          {if ( $evenement.categorie != "" )}
            {if !$evenement@first}
              <hr/>
            {/if}
            {if $categorieLinks == "1"}
              <h1><a href=evenement_kiezen.php?categorie={$evenement.categorieNummer}>{$evenement.categorie}</a></h1>
            {else}
              <h1>{$evenement.categorie}</h1>
            {/if}
          {/if}
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
          <strong>Er zijn geen evenementen gevonden</strong>
        {/if}
        <br/>
      {/if}

    </form>

{include file="footer.tpl"}