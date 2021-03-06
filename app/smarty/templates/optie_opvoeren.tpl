{include file="openheader.tpl"}
<script type="text/javascript" src="js/nicEdit.js"></script> 
{include file="closeheader.tpl"}

{* Smarty functions *}
{function my_radios}
<label class="textlabel">{$tekst}</label>
{foreach $options as $key => $lbl}
    <input type="radio" id="{$naam}{$lbl}" name="{$naam}" value="{$key}" {if $selected==$key}checked{/if}/>{$lbl}
{/foreach}
{/function}

{function my_options}
<label class="textlabel">{$tekst}</label>
<select name="{$naam}">
 {foreach $options as $key => $lbl}
   <option id="{$naam}{$lbl}" value="{$key}" {if $selected==$key}selected{/if}>{$lbl}</option>
 {/foreach}
</select>
{/function}

<h2>{$doctitle}</h2>
<h2>{$evenement}</h2>

<form id="optieform" method="post" action="{$SCRIPT_NAME}">
<div align="right">Klik <a href="res/images/opties.png">hier</a> voor een voorbeeld van de verschillende optietypen.</div>

    {if sizeof($evenement_lijst) > 0 }
    <div>
        <label for="evenementId">Koppelen aan evenement:</label>
        <select name="evenementId" onchange="submit();">
                {html_options id=evenementId options=$evenement_lijst selected=$evenementId}
        </select>
    </div>
    {/if}

    <div>
        <label for="id">Id:</label>
        <input type="number" name="id" value="{$id}" readonly>
    </div>

    <div>
        <label for="type">Type:</label>
        {html_options name=type id=type options=$typenLijst selected=$type}
        <div class="tooltip">?
            <span class="tooltiptext">
             Zie ook het <a href="res/images/opties.png">voorbeeld</a> <br/>
             <b>Aantal: </b>Gebruikt voor opties waar een maximum voor geldt.<br>
             <b>Getal: </b>Een numerieke waarde, wordt niet mee gerekend.<br/>
             <b>Tekstregel: </b>Tekstinvoer, 1 regel<br/>
             <b>Tekstvak: </b>Tekstinvoer, meerdere regels<br/>
             <b>Keuze Ja/Nee: </b>Radiobuttons met waarde ja en nee<br/>
             <b>Keuze één optie (radio): </b>Radiobuttons voor één keuze binnen een groep<br/>
             <b>Keuze meerdere opties: </b>Checkboxen voor meerdere keuzes binnen een groep<br/>
             <b>Koptekst: </b>Tussenkop (vet), alleen voor markering, kan niet ingevuld worden<br/>
             <b>Vaste tekst: </b>Een regel tekst voor uitleg e.d., kan niet ingevuld worden.<br/>
             <b>Akkoord: </b>Een regel tekst waar de klant mee moet instemmen. Bijvoorbeeld een gezondheidsverklaring.<br/>
             <b>Voorwaarde: </b>Een ja/nee keuze. De opties die afhankelijk zijn van deze optie zijn alleen zichtbaar bij "ja".<br/>
            </span>
        </div>
        <span class="error">{$typeErr}</span>
    </div>

    <div id="groepid">
        <div>
            <label for="groep">Groep:</label>
            <input class="longtext" type="text" name="groep" id="groep_inp" value="{$groep}">
            <div class="tooltip">?
                <span class="tooltiptext">Groepsnaam wordt getoond als titel van de groep. De groepsnaam moet voor alle
                    bij elkaar horende opties (knoppen/selectievakjes) hetzelfde zijn.</span>
            </div>
            <span class="error">{$groepErr}</span>
        </div>

        <div>
            {my_radios naam='isDefault' options=$defaultKeus selected=$isDefault tekst='Is default in groep:'}
            <div class="tooltip">?
                <span class="tooltiptext">De default optie in een groep wordt standaard geselecteerd.<br/> Aangezien niet gecontroleerd kan worden of er een optie gekozen is, is het verstandig om een van de opties in de groep default te maken. Dan weet je in ieder geval zeker dat er iets gekozen is.</span>
            </div>
            <span class="error">{$isDefaultErr}</span>
        </div>
    </div>

    <div>
        <label for="optieNaam_naam">Naam:</label>
        <textarea rows="1" cols="40" maxlength="64" id="optieNaam" name="optieNaam">{$optieNaam}</textarea>
        <div class="tooltip">?
            <span class="tooltiptext">Beschrijving van de optie in de optielijst. Wordt niet op het inschrijfformulier
                getoond.<br/>Kies een betekenisvolle naam (bijv. met een code voor het evenement er in).<br/> Dit is later nodig om de optie terug te kunnen vinden.</span>
        </div>
        <span class="error">{$optieNaamErr}</span>
    </div>

    <div id="tekst">
        <div id="tekstVoorInput">
            <label for="tekstVoor">Tekst:</label>
            <span style="display: inline-block;vertical-align:middle;"><textarea onkeyup="console.log(this.value.length)" rows="2" cols="60" maxlength="4096" id="tekstVoor_inp" name="tekstVoor">{$tekstVoor}</textarea></span>
            <button type="button" class="bareleft" id="htmlTekst" onClick="setNic();">Opmaak</button>
            <div class="tooltip">?
                <span class="tooltiptext">Tekst die getoond wordt op website.<br/><br/>- Bij tekstvelden is dat vóór het invulveld,<br/><br/>- Bij radiobuttons en checkboxen achter het vinkje.<br/><br/>- Bij Koptekst, Vaste Tekst of Akkoord de inhoud van de koptekst, de tekst of de akkoordverklaring. Hierbij is ook opmaak mogelijk.</span>
            </div>
            <span class="error">{$tekstVoorErr}</span>

            <div id="gebruikt"></div>

        </div>

        <div id="tekstExtra">
            <div>
                <label for="tekstAchter">Uitleg:</label>
                <textarea rows="1" cols="50" maxlength="255" id="tekstAchter_inp" name="tekstAchter">{$tekstAchter}</textarea>
                <div class="tooltip">?
                    <span class="tooltiptext">Deze tekst wordt achter of onder de optie getoond, bij invulvelden in het veld als placeholder (hint)</span>
                </div>
                <span class="error">{$tekstAchterErr}</span>
            </div>
            <div>
                <label for="tooltipTekst">Eventueel Tooltip tekst:</label>
                <textarea rows="1" cols="50" maxlength="255" id="tooltipTekst_inp" name="tooltipTekst">{$tooltipTekst}</textarea>
                <div class="tooltip">?
                    <span class="tooltiptext">Dit is tooltip tekst, dus een stukje help informatie dat zichtbaar wordt als je
                        er met de muis overheen gaat"
                    </span>
                </div>
                <span class="error">{$tooltipTekstErr}</span>
            </div>
        </div>
    </div>

    <div id="lijn">
        {my_radios naam='heeftHorLijn' options=$horizontaleLijn selected=$heeft_hor_lijn tekst='Horizontale lijn:'}
        <div class="tooltip">?
            <span class="tooltiptext right">Moet er een horizontale lijn (afscheiding) boven of onder deze optie komen?</span>
        </div>
        <span class="error">{$horizontaleLijnErr}</span>
    </div>

    <div id="perDeelnemer">
        {my_radios naam='perDeelnemer' options=$perDeelnemerKeus selected=$perDeelnemer tekst='Optie is per deelnemer:'}
        <div class="tooltip">?
            <span class="tooltiptext right">'Ja' betekent dat deze optie per deelnemer geldt, 'Nee' betekent dat de optie voor de gehele inschrijving geldt.</span>
        </div>
        <span class="error">{$perDeelnemerErr}</span>
    </div>

    <div id="intern">
        {my_radios naam='isInternGebruik' options=$internGebruikKeus selected=$isInternGebruik tekst='Optie is alleen voor intern gebruik:'}
        <div class="tooltip">?
            <span class="tooltiptext right">Verschijnt bij 'ja' niet op het inschrijfformulier van de klant. Kan later wel door medewerker in de inschrijving gebruikt worden.</span>
        </div>
        <span class="error">{$isInternGebruikErr}</span>
    </div>

    <div id="selectLabel">
        <div>
            {my_options naam='selectLabel' options=$labelLijst selected=$selectLabel tekst='Afhankelijk van:'}
            <div class="tooltip">?
                <span class="tooltiptext right">Deze optie wordt alleen getoond als de voorwaarde waar deze optie van afhankelijk is met "ja" wordt beantwoord. "</span>
            </div>
            </div>
    </div>    

    <div id="label">
        <label class="textlabel" for="status">Label:</label>
        <input type="text" name="label" id="label_inp" value="{$label}">
        <span class="error">{$labelErr}</span>
    </div>

    <div>
        {my_options naam='status' options=$statusLijst selected=$status tekst='Status:'}
        <span class="error">{$statusErr}</span>
    </div>

    <div id="beschikbaarheid">
        <div>
            <label class="textlabel" for="totaalAantal">Totaal aantal beschikbaar:</label>
            <input type="number" name="totaalAantal" id="beschikbaarheid_inp" value="{$totaalAantal}">
            <span class="error">{$totaalAantalErr}</span>
        </div>
    </div>

    <div id="prijs">
        <div>
            <label for="prijs">Prijs:</label>
            <input class="short" type="text" name="prijs" id="prijs_inp" placeholder="123.45" value="{$prijs}">
            <span class="error">{$prijsErr}</span>
        </div>
    </div>

    <button name="opslaan">Opslaan</button>
    <button name="leegmaken">Formulier leeg maken</button>
    <button name="terug">Terug</button> 

    {$alsnieuwbutton}

    <span class="error">{$validatiemelding}</span>

    <input type="hidden" name="evt" value="{$evt}">
    <input type="hidden" name="volgorde" value="{$volgorde}">

    {include file="statusregel.tpl"}

</form>

<script>
    (function () {
        'use strict';
        /* jshint browser: true */
        var optieform = document.getElementById('optieform');
        optieform.reset();

        showAll();
        switchThem( document.getElementById('type').value );

        document.getElementById('type').onchange = function () 
        {
            showAll();
            switchThem( this.value );
            setNic( false );
        };
    }());

    var tekstveld = null;
    function setNic( value = true ) 
    {
        // NicEditor voor koptekst en vaste tekst opmaak.
        if( ( !tekstveld && value ) ) 
        {
            tekstveld = new nicEditor(  ).panelInstance('tekstVoor_inp' );
        } 
        else 
        {
            tekstveld.removeInstance('tekstVoor_inp');
            tekstveld = null;
        }
    }

    function switchThem( value )
    {
        switch (value) 
        {
            case '{$keuzeJaNee}':
                hideLabel();
                hideGroep();
                break;
            case '{$keuzeAantal}':
                hideLabel();
                hideGroep();
                break;
            case '{$keuzeGetal}':
            case '{$keuzeTekstvak}':
            case '{$keuzeTekstregel}':
                hideLabel();
                hidePrijs();
                hideBeschikbaar();
                hideGroep();
                break;
            case '{$keuzeRadio}':
            case '{$keuzeMeerdere}':
                hideLabel();
                hideLijn();
                break;
            case '{$keuzeVoorwaarde}':
                hideSelectLabel();
                hidePrijs();
                hideBeschikbaar();
                hideGroep();
                hideIntern();
                break;
            case '{$keuzeKoptekst}':
            case '{$keuzeInstemming}':
            case '{$keuzeVasteTekst}':
                hideLabel();
                hidePrijs();
                hideBeschikbaar();
                hideGroep();
                hideIntern();
                hideTekstExtra();
                break;
            default:
                hideLabel();
                hideGroep();
        }
    }

    function showAll()
    {
        document.getElementById("tekst").className = "show";
        document.getElementById("tekstExtra").className = "show";
        document.getElementById("tooltipTekst_inp").className = "show";
        document.getElementById("perDeelnemer").className = "show";
        document.getElementById("lijn").className = "show";
        document.getElementById("intern").className = "show";
        document.getElementById("beschikbaarheid").className = "show";
        document.getElementById("prijs").className = "show";
        document.getElementById("groepid").className = "show";
        document.getElementById("label").className = "show";
        document.getElementById("selectLabel").className = "show";
        document.getElementById("htmlTekst").className = "hide";

        document.getElementById("tekstVoor_inp").disabled = false;
        document.getElementById("tekstAchter_inp").disabled = false;
        document.getElementById("tooltipTekst_inp").disabled = false;
        document.getElementById("beschikbaarheid_inp").disabled = false;
        document.getElementById("prijs_inp").disabled = false;
        document.getElementById("groep_inp").disabled = false;
        document.getElementById("label_inp").disabled = false;
    }

    function hideBeschikbaar()
    {
        document.getElementById("beschikbaarheid").className = "hide";
        document.getElementById("beschikbaarheid_inp").disabled = true;
    }    

    function hidePrijs()
    {
        document.getElementById("prijs").className = "hide";
        document.getElementById("prijs_inp").value = "0.00";
        document.getElementById("prijs_inp").disabled = true;
    }    

    function hideGroep()
    {
        document.getElementById("groepid").className = "hide";
        document.getElementById("groep_inp").disabled = true;
    }    

    function hideLabel()
    {
        document.getElementById("label").className = "hide";
        document.getElementById("label_inp").disabled = true;
    }    

    function hideSelectLabel()
    {
        document.getElementById("selectLabel").className = "hide";
    }    

    function hideTekst()
    {
        document.getElementById("tekst").className = "hide";
        document.getElementById("tekstVoor_inp").disabled = true;
        document.getElementById("tekstAchter_inp").disabled = true;
        document.getElementById("tooltipTekst_inp").disabled = true;
    }

    function hideLijn()
    {
        document.getElementById("lijn").className = "hide";
    }

    function hideIntern()
    {
        document.getElementById("intern").className = "hide";
    }

    function hidePerDeelnemer()
    {
        document.getElementById("perDeelnemer").className = "hide";
    }

    function hideTekstExtra()
    {
        document.getElementById("tekstExtra").className = "hide";
        //document.getElementById("tooltipTekst").className = "hide";
        document.getElementById("tekstAchter_inp").disabled = true;
        document.getElementById("tooltipTekst_inp").disabled = true;
        document.getElementById("htmlTekst").className = "bareleft";
    }

</script>

{include file="footer.tpl"}