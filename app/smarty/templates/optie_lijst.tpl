{include file="header.tpl"}

    <form method="post" action="{$SCRIPT_NAME}">
      <div class="zweven">
        <button name="toevoegen" value="2">Optie toevoegen</button>
        <button name="terug">Terug</button> 
      </div>
      <h2>{$doctitle} </h2>
      <h4>{$documentsubtekst}</h4>
      Kies een filter, vul eventueel een evenementnaam of zoekargument in, en druk "Selecteer"<br/><br/>
        <table>
          <tr>
            <td class="noborder">
          Filter:
                {html_options name=filter id=filter options=$filterlijst selected="0"}
          </td>
          <td class="noborder" style="width: 3em;"></td>
          <td class="noborder">
            <div id="evenement">
            Evenement:
            <select name="evenement">
                {html_options options=$evenementenLijst selected=$evenement}
            </select>
            <br/>
          </div>

          <div id="zoeken">
          Zoekargument:
          <input type="text" name="zoekarg">
          </div>
        </td>
        <td class="noborder" style="width: 3em;"></td>
        <td class="noborder">
          <button type="submit" name="selecteer">Selecteer</button>
        </td>
        </tr>
        </table>

        {if $verwijderbaar > 1}
          <div style="float: right;">
            <input type="checkbox"  name="zonderVragen" id="zonderVragen" {$zonderVragenCheck}>
            <label for="zonderVragen">Verwijder zonder vragen</label>
          </div>
        {/if}
        <table>
          <thead>
          <tr>
             <th>Groep</th>
             <th>Naam</th>
             <th style="width:15em">Tekst voor</th>
             <th>Type</th>
             <th>Label</th>
             <th>Prijs</th>
             <th>Actie</th>
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
                {if $optie.is_default == "1"}<strong>{/if}
                  {$optie.naam}
                {if $optie.is_default == "1"}</strong>{/if}
              {if $optie.deleted == "1" }</del>{/if}
              </td>
              <td>
              {if $optie.deleted == "1" }<del>{/if}
              {$optie.tekst_voor}
              {if $optie.deleted == "1" }</del>{/if}
              </td>
              <td>
              {if $optie.deleted == "1" }<del>{/if}
              {$optie.type}
              {if $optie.deleted == "1" }</del>{/if}
              </td>
              <td>
              {if $optie.deleted == "1" }<del>{/if}
              {$optie.label}
              {if $optie.deleted == "1" }</del>{/if}
              </td>
              <td>
              {if $optie.deleted == "1" }<del>{/if}
              &euro; {$optie.prijs}
              {if $optie.deleted == "1" }</del>{/if}
              </td>
              <td>
                  <button name="bewerk" value={$optie.id}>Wijzig</button>  
                  {if $buttonname =="act" and $optie.deleted == "1"}
                    <button name="{$buttonitemname}" value={$optie.id}>{$buttonitemtekst}</button>  
                  {elseif $buttonname =="inact" and $optie.deleted == "0"}
                    <button name="{$buttonitemname}" value={$optie.id}>{$buttonitemtekst}</button>  
                  {/if}
                  {if $optie.kanVerwijderd == "1"}
                    <button name="verwijder" value={$optie.id} onclick="return verwijderKlik('{$optie.naam}')">Verwijder</button> 
                  {/if}
              </td> 
            </tr>  
       {/foreach}
        </table>

        {include file="statusregel.tpl"}
  
    </form>
    
    <script>
        (function () {
            'use strict';
            /* jshint browser: true */
            //var optieform = document.getElementById('optieform');
            //optieform.reset();

            showAll();
            switchThem( document.getElementById('filter').value );

            document.getElementById('filter').onchange = function () 
            {
                showAll();
                switchThem( this.value );
            };
        }());

        function switchThem( value )
        {
            switch (value) 
            {
                case 'Evenement':
                    hideZoeken();
                    break;
                case 'Zoeken':
                    hideEvenement();
                    break;
                default:
                    hideEvenement();
                    hideZoeken();
            }
        }

        function showAll()
        {
            document.getElementById("evenement").className = "show";
            document.getElementById("zoeken").className = "show";
        }

        function hideEvenement()
        {
            document.getElementById("evenement").className = "hide";
        }    
        function hideZoeken()
        {
            document.getElementById("zoeken").className = "hide";
        }    


        function verwijderKlik(naam)
        {
            if ( document.getElementById( "zonderVragen" ).checked == false )
            {
                return confirm( naam + "\nOptie verwijderen?");
            }
            return true;
        }

        function showHide()
        {

        }        
     </script>

{include file="footer.tpl"}