{include file="header.tpl"}

    <form method="post" action="{$SCRIPT_NAME}">
      <button class="zweven" name="terug">Terug</button> 
      <h2>Gebruikers ({$aantal})</h2>
        <button name="toevoegen">Gebruiker toevoegen</button>
        <table>

          <thead>
          <tr>
             <th>Userid</th>
             <th>Naam</th>
             <th>E-mail</th>
             <th>Rol</th>
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
                {$gebruiker.userid}
              </td>
              <td>
                {$gebruiker.naam}
              </td>
              <td>
                {$gebruiker.email}
              </td>
              <td>
                {$gebruiker.rol}
              </td>
              <td>
                {$gebruiker.laatste_logindatum}
              </td>
              <td>
                {$gebruiker.laatste_loginadres}
              </td>

              <td>            
                <button name="wijzigen" value={$gebruiker.id}>Wijzigen</button>
              </td>
            </tr>
       {/foreach}
       </table>

       <button name="terug">Terug</button> 

       {include file="statusregel.tpl"}
       
    </form>

{include file="footer.tpl"}