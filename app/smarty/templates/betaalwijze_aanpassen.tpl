{include file="header.tpl"}

<h2>{$doctitle}</h2>

<div class="round_corners" style="display: inline-block">
    <h2>Let op:</h2>
    Met deze applicatie is het mogelijk om de volgende eigenschappen van een betaalwijze te wijzigen:<br/> 
    <ul>
    <li>De getoonde tekst (beschrijving)</li>
    <li>De volgorde van tonen</li>
    <li>De kosten van de betaling</li>
    <li>Of de betaalwijze zichtbaar (actief) is.</li>
    </ul>
    <strong><i>De werking verandert echter niet.</i></strong> <br/>
    <br/>
    Opmerkingen
    <ul style="list-style-type: square;">
    <li>De beschrijving van code 8 heeft dus alleen effect op de tekst die getoond wordt.<br/>
    Code 8 zal echter altijd een contante betaling zijn.</li>
    <li>Het aantal incassotermijnen bij (code 4) wordt aangegeven door de variabele {literal}{aantal}{/literal}. Deze variabele wordt later vervangen door het aantal termijnen dat in de instellingen is opgegeven.</li>
    <li>Er kan een betaalwijze worden toegevoegd (door Gereserveerd te vervangen door iets anders). 
    Dit wordt dan getoond bij de inschrijving en eventueel op de factuur, maar er vindt geen berekening plaats.
    De nieuwe betaalwijze wordt simpelweg (nog) niet herkend in de programmacode.</li>
    </ul>

</div>

<form method="post" action="{$SCRIPT_NAME}">
    <table style="display: inline-block;" id="table">
        <tr>
            <th>Code</th>
            <th>Beschrijving</th>
            <th>Kosten</th>
            <th>Actief</th>
        </tr>

        {foreach $betaalwijzen_lijst as $betaalwijze}
        <tr>
            <td><input type="hidden" value="{$betaalwijze.code}">{$betaalwijze.code}</td>
            <td><input value="{$betaalwijze.naam}" name="xxN{$betaalwijze.code}"></td>
            <td><input value="{$betaalwijze.prijs}" name="xxP{$betaalwijze.code}"></td>
            <td><input value="{$betaalwijze.isActief}" name="xxA{$betaalwijze.code}"></td>
            <td><a href="#" class="up">↑</a></td>
            <td><a href="#" class="down">↓</a></td>
        </tr>
        {/foreach}
    </table>

    <table style="display: inline-block; border-spacing: 3.5px;">
        <tr>
            <td class="noborder"><input type="hidden">
                <span class="error">{$naamErr} {$isActiefErr} {$kostenErr}</span></td>
        <tr>
    </table>

    <div style="display: block;">
    <button type="submit">Opslaan</button>
    <button name="terug">Terug</button> 
    </div>

    {include file="statusregel.tpl"}

</form>

<script>
    function afmeld()
    {
        document.body.innerHTML+='<form id="dynForm" method="post"><input type="hidden" name="afmelden"></form>';
        document.getElementById("dynForm").submit();
    }

    function parentTr(element)
    {
        let parent=element.parentNode;
        while(parent!=null)
        {
            if(parent.nodeName==="TR")
            {
                return parent;
            }
            parent=parent.parentNode;
        }
    }

    let table=document.getElementById('table');

    Array.from(document.getElementsByClassName('up')).forEach(upButton =>
    {
        upButton.addEventListener('click',function()
        {
            let currentTr=parentTr(upButton);
            let previousTr=currentTr.previousElementSibling;
            if(previousTr)
            {
                previousTr.parentNode.insertBefore(currentTr,previousTr);
            }
        });
    });

    Array.from(document.getElementsByClassName('down')).forEach(downButton =>
    {
        downButton.addEventListener('click',function()
        {
            let currentTr=parentTr(downButton);
            let nextTr=currentTr.nextElementSibling;
            if(nextTr)
            {
                currentTr.parentNode.insertBefore(nextTr,currentTr);
            }
        });
    });
</script>

{include file="footer.tpl"}