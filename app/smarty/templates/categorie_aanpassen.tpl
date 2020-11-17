{include file="header.tpl"}
<div align="center">
<h2>{$doctitle}</h2>

<div class="round_corners" align="left" style="display: inline-block">
    <h2>Let op:</h2>
    Met deze applicatie is het mogelijk om de volgende eigenschappen van een evenement-categorie te wijzigen:<br />
    <ul>
        <li>De getoonde tekst (beschrijving)</li>
        <li>De volgorde van tonen</li>
        <li>Of de betaalwijze zichtbaar (actief) is.</li>
    </ul>
    <strong><i>Dit werkt door op bestaande inschrijvingen!</i></strong> <br />
    <br />
    - Als er momenteel inschrijvingen zijn in de categorie "Muziekles", en de beschrijving wordt gewijzigd in
    "Wandeltocht"
    dan zullen alle bestaande inschrijvingen voor "Muziekles" ook in de categorie "Wandeltocht" terecht komen.<br />
    - Code 0 dient leeg te blijven, er moet dan altijd bewust voor een categorie gekozen worden.
</div>
</div>

<form method="post" action="{$SCRIPT_NAME}">
    <div class="window_back">
        <div class="outer">
            <div class="left_div">

                <table style="display: inline-block;" id="table">
                    <tr>
                        <th>Code</th>
                        <th>Beschrijving</th>
                        <th>Actief</th>
                    </tr>

                    {foreach $categorieen_lijst as $categorie}
                    <tr>
                        <td><input type="hidden" value="{$categorie.code}">{$categorie.code}</td>
                        <td><input value="{$categorie.naam}" name="xxN{$categorie.code}"></td>
                        <td><input value="{$categorie.isActief}" name="xxA{$categorie.code}"></td>
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
            </div>
        </div>
</form>

<script>
    function afmeld() {
        document.body.innerHTML += '<form id="dynForm" method="post"><input type="hidden" name="afmelden"></form>';
        document.getElementById("dynForm").submit();
    }

    function parentTr(element) {
        let parent = element.parentNode;
        while (parent != null) {
            if (parent.nodeName === "TR") {
                return parent;
            }
            parent = parent.parentNode;
        }
    }

    let table = document.getElementById('table');

    Array.from(document.getElementsByClassName('up')).forEach(upButton => {
        upButton.addEventListener('click', function () {
            let currentTr = parentTr(upButton);
            let previousTr = currentTr.previousElementSibling;
            if (previousTr) {
                previousTr.parentNode.insertBefore(currentTr, previousTr);
            }
        });
    });

    Array.from(document.getElementsByClassName('down')).forEach(downButton => {
        downButton.addEventListener('click', function () {
            let currentTr = parentTr(downButton);
            let nextTr = currentTr.nextElementSibling;
            if (nextTr) {
                currentTr.parentNode.insertBefore(nextTr, currentTr);
            }
        });
    });
</script>

{include file="footer.tpl"}