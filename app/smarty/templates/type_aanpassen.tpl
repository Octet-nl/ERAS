{include file="header.tpl"}

<h2>{$doctitle}</h2>

<div class="round_corners" style="display: inline-block">
    <h2>Let op:</h2>
    Met deze applicatie is het mogelijk om de volgende eigenschappen van een optietype te wijzigen:<br/> 
    <ul>
    <li>De getoonde tekst (beschrijving)</li>
    <li>De volgorde van tonen</li>
    <li>Of het type zichtbaar (actief) is.</li>
    </ul>
    <strong><i>De werking verandert echter niet.</i></strong> <br/>
    <br/>
    -De beschrijving van code 5 heeft dus alleen effect op de tekst die getoond wordt. <br/>
    -Code 5 zal echter altijd een ja/nee keuze zijn.<br/>
    -Typen die inactief gemaakt worden, worden niet meer getoond bij het toevoegen van opties.
    Bestaande opties van dat type blijven gewoon op het inschrijfformulier getoond worden.<br/>
    - Code 0 moet leeg blijven, de medewerker moet dan actief een type kiezen.<br/>
    - Toevoegen van opties (door Gereserveerd te veranderen in iets anders) heeft geen zin. 
    De programmatuur herkent de toegevoegde code niet en zal deze negeren.
</div>


<form method="post" action="{$actionForm}">
    <table style="display: inline-block;" id="table">
        <tr>
            <th>Code</th>
            <th>Beschrijving</th>
            <th>Actief</th>
        </tr>

        {foreach $types_lijst as $type}
        <tr>
            <td><input type="hidden" value="{$type.code}">{$type.code}</td>
            <td><input value="{$type.naam}" name="xxN{$type.code}"></td>
            <td><input value="{$type.isActief}" name="xxA{$type.code}"></td>
            <td><a href="#" class="up">↑</a></td>
            <td><a href="#" class="down">↓</a></td>
        </tr>
        {/foreach}
    </table>

    <table style="display: inline-block; border-spacing: 3.5px;">
        <tr>
            <td class="noborder"><input type="hidden">
                <span class="error">{$naamErr} {$isActiefErr}</span></td>
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