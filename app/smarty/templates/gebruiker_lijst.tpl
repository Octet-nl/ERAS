{include file="header.tpl"}

    <form method="post" action="{$SCRIPT_NAME}">
      <button class="zweven" name="terug">Terug</button> 
        {if $filter=="Actief"}
         <h2>Actieve medewerkers ({$aantal})</h2>
         <button name="filter" value="Alles">Alle medewerkers</button>
         <button name="filter" value="Klanten">Ook klanten (lange lijst!)</button>
        {elseif $filter=="Klanten"}
         <h2>Medewerkers en klanten ({$aantal})</h2>
         <button name="filter" value="Actief">Actieve medewerkers</button>
         <button name="filter" value="Alles">Alle medewerkers</button>
        {elseif $filter=="Alles"}
         <h2>Alle medewerkers ({$aantal})</h2>
         <button name="filter" value="Actief">Actieve medewerkers</button>
         <button name="filter" value="Klanten">Ook klanten (lange lijst!)</button>
        {/if}
        <button name="toevoegen">Gebruiker toevoegen</button>
        <table>

          <thead>
          <tr>
             <th>Userid</th>
             <th>Naam</th>
             <th>E-mail</th>
             <th>Rol</th>
             <th>Actief</th>
             <th>Laatste<br/>logindatum</th>
             <th>Laatste<br/>loginadres</th>
             <th>
             Actie
             </th>
          </tr>
          </thead>

        {foreach $Gebruikers as $gebruiker}
            <tr>
              <td>
                {if $gebruiker.actief == "0" }<del>{/if}
                  {$gebruiker.userid}
                {if $gebruiker.actief == "0" }</del>{/if}
              </td>
              <td>
                {if $gebruiker.actief == "0" }<del>{/if}
                  {$gebruiker.naam}
                {if $gebruiker.actief == "0" }</del>{/if}
              </td>
              <td>
                {if $gebruiker.actief == "0" }<del>{/if}
                  {$gebruiker.email}
                {if $gebruiker.actief == "0" }</del>{/if}
              </td>
              <td>
                {if $gebruiker.actief == "0" }<del>{/if}
                  {$gebruiker.rol}
                {if $gebruiker.actief == "0" }</del>{/if}
              </td>
              <td>
                {if $gebruiker.actief == "0" }<del>{/if}
                  {$gebruiker.actief}
                {if $gebruiker.actief == "0" }</del>{/if}
              </td>
              <td>
                {if $gebruiker.actief == "0" }<del>{/if}
                  {$gebruiker.laatste_logindatum}
                {if $gebruiker.actief == "0" }</del>{/if}
              </td>
              <td>
                {if $gebruiker.actief == "0" }<del>{/if}
                  {$gebruiker.laatste_loginadres}
                {if $gebruiker.actief == "0" }</del>{/if}
              </td>

              <td>
                {if $gebruiker.wijzigen == "1"}
                <button name="wijzigen" value={$gebruiker.id}>Wijzigen</button>
                {/if}
              </td>
            </tr>
       {/foreach}
       </table>

       <button name="terug">Terug</button> 

       {include file="statusregel.tpl"}
       
    </form>

{include file="footer.tpl"}