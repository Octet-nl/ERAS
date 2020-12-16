{include file="header.tpl"}
<body>
    <form method="post" action="{$SCRIPT_NAME}">
        <div class="window_back">
            <div class="outer">
                <h2>{$doctitle}</h2>
            <h3>Debugging</h3>
            <div class="left_div" style="width: 60%;">
                Beschikbare logging niveaus:<br/>
                <table>
                    <thead>
                    <tr>
                      <th>Niveaunaam</th>
                      <th>Betekenis</th>
                    </tr>
                    </thead>
          
                    <tr>
                      <td>
                        ERROR
                      </td>
                      <td>
                        Toont alleen foutsituaties in de logfile
                      </td>
                    </tr>
                    <tr>
                    <td>
                        WARNING
                    </td>
                    <td>
                        Laat ook waarschuwingen zien in de logfile
                    </td>
                    </tr>
                    <tr>
                    <td>
                        INFO
                    </td>
                    <td>
                        Laat ook extra informatie zien in de logfile.
                    </td>
                    </tr>
                    <tr>
                        <td>
                            ======>
                        </td>
                        <td>
                            <strong>De niveaus hieronder zijn niet bedoeld voor normaal productiebedrijf !</strong>
                        </td>
                    </tr>
                    <tr>
                    <td>
                        DEBUG
                    </td>
                    <td>
                        Toont ook debugging informatie. Dit niveau levert een grote logfile op en vertraagt de uitvoering aanzienlijk
                    </td>
                    </tr>
                    <tr>
                    <td>
                        DUMP
                    </td>
                    <td>
                        Toont behalve debugging informatie ook de inhoud van sommige arrays. Dit niveau levert een nog grotere logfile op en vertraagt de uitvoering nog meer.
                    </td>
                    </tr>
                    <tr>
                    <td>
                        VERBOSE
                    </td>
                    <td>
                        Toont behalve debugging informatie ook de inhoud van alle arrays. Dit niveau levert de grooste logfile op en vertraagt de uitvoering het meest.
                    </td>
                    </tr>
                    </table>
                    Elk logging niveau toont dus wat het niveau daarboven toont, plus wat extra.
                   <br/><br/>
                   <br/>
                   <div align="center">
                     <span class=setting_label>Kies Logger niveau</span>
                      {html_options name=loggerNiveau options=$loggerLevels selected=$loggerNiveau}
                     <span class="error">{$loggerNiveauErr}</span>
                   </div>
               <br/>
               <br/>
               <div align="center">
                 <button name="opslaan">Opslaan</button>
                 <button name="terug">Terug</button> 
                 <br/><br/><br/>
                 <a href={$logfile}>Download logfile ({$filesize} kb)</a>
                 {if $autorisatie >= $ADMIN}
                  <button name="verwijder">Logfile leegmaken</button> 
                 {/if}
                </div>
                </div>
            <br/>
            </div>
        </div>

        {include file="statusregel.tpl"}
    </form>
{include file="footer.tpl"}
