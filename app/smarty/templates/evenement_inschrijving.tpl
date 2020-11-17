{include file="header-klant.tpl"}

    <h2>{$doctitle} {$evenementNaam}</h2>
    {if ( isset($disclaimer))}
    <br/>
    {$disclaimer}
    <br/>
    {/if}
    <h3>Evenementnummer {$evenementNummer}</h3>
    {if $datumEind eq $datumBegin }
        <h3>Op {$datumBegin}</h3>
    {else}
        <h3>Van {$datumBegin} tot {$datumEind}</h3>
    {/if}

    <form method="post" action="{$SCRIPT_NAME}">

        {$langeOmschrijving}
        <br/>
        <br/>
        <strong>{$status}</strong>
        <br/>
        <br/>

        <input type="hidden" name="evt" value="{$evt}">
        <input type="hidden" name="evenement_naam" value="{$evenement_naam}">
        <input type="hidden" name="aantal_beschikbaar" value="{$aantal_beschikbaar}">
        <input type="hidden" name="extra_contact" value="{$extra_contact}">
        <input type="hidden" name="extra_deelnemer" value="{$extra_deelnemer}">
        <input type="hidden" name="max_deelnemers" value="{$max_deelnemers}">
        <input type="hidden" name="accountNodig" value="{$accountNodig}">
        <input type="hidden" name="prijs" value="{$prijs}">

        <br/>
        {$button}
 
    </form>


{include file="footer.tpl"}