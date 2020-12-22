{include file="openheader.tpl"}
    <link rel="stylesheet" type="text/css" href="css/navigatie.css">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
{include file="closeheader.tpl"}

  <!--form method="post" action="{$SCRIPT_NAME}" -->
    <div class="window_color" style="width: 80%; margin: 0 auto;">
      <div class="menuregel">
        <nav style="display: inline;">
          <ul class="nav">
          {if $autorisatie > $KLANT}
            <li><a href="#">Nieuw</a>
              <ul>
                <li><a href=evenement_opvoeren.php>Evenement</a></li>
                <li><a href=preview_evenement.php>Preview
                  <div class="tooltip">?
                    <span class="tooltiptext left">Beoordeel hoe de klant een evenement te zien krijgt.</span>
                  </div>
                  </a>
                </li>
              <li><a href=optie_opvoeren.php>Optie</a></li>
                {if $autorisatie >= $SUPERVISOR}
                  <li><a href=mailing_verzenden.php>Mailing</a></li>
                  <li><a href=voucher_aanmaken.php>Voucher</a></li>
                {/if}
                <li><a href=gebruiker_opvoeren.php>Gebruiker</a></li>
              </ul>
            </li>
            <li><a href="#">Wijzigen</a>
              <ul>
                <li><a href=evenement_lijst.php>Evenementen</a></li>
                <li><a href=optie_lijst.php>Opties</a></li>
                <li><a href=evenement_opties_koppelen.php>Opties per evenement</a></li>
                {if $autorisatie >= $ADMIN}
                  <li><a href=voucher_wijzigen.php>Vouchers wijzigen</a></li>
                {/if}
              </ul>
            </li>

            <li><a href="#">Zoeken</a>
              <ul>
                <li><a href=inschrijving_lijst.php>Inschrijvingen</a></li>
                <li><a href=deelnemer_lijst.php>Deelnemers</a></li>
                <li><a href=gebruiker_lijst.php>Gebruikers</a></li>
                <li><a href=klant_zoeken.php>Klanten</a></li>
                <li><a href=evenement_statistiek.php>Statistiek</a></li>
              </ul>
            </li>

            <li><a href="#">Diversen</a>
              <ul>
                {if $autorisatie >= $ADMIN}
                  <li><a href="#">Admin taken</a>
                    <ul>
                      <li><a href=annuleringsverzekering_aanpassen.php>Annuleringsverzekering aanpassen</a></li>
                      <li><a href=categorie_aanpassen.php>Evenement categorieën</a></li>
                      <li><a href=settings.php>Instellingen</a></li>
                    </ul>
                  </li>
                {/if}
                {if $autorisatie == $ROOT}
                  <li>
                    <li><a href="#">Tabellenbeheer 
                    </a>
                      <ul>
                        <li><a href=type_aanpassen.php>Optietypen aanpassen</a></li>
                        <li><a href=betaalwijze_aanpassen.php>Betaalwijzen aanpassen</a></li>
                        <li><a href=thema_wijzigen.php>Thema wijzigen</a></li>
                      </ul>
                    </li>
                  </li>
                {/if}
                <li><a href="#">IT taken</a>
                  <ul>
                    <li><a href=clear.php>Wis sessiegegevens</a></li>
                    <li><a href=show.php>Toon sessiegegevens voor inschrijving</a></li>
                    <li><a href="show.php?alles=1">Toon alle sessiegegevens</a></li>
                    {if $autorisatie >= $ADMIN}
                      <li><a href="logging.php">Wijzig logging level</a></li>
                    {/if}
                    {if $autorisatie == $ROOT}
                      <li><a href=deploy.php>Installeer nieuwe versie
                          <div class="tooltip">?
                            <span class="tooltiptext left">Haal nieuwe versie uit GIT.</span>
                          </div>
                        </a>
                      </li>
                    {/if}
                  </ul>
                </li>
              </ul>
            </li>
          {/if}

          <li><a href="#">Als klant</a>
            <ul>
              <li><a href=registreer.php>Aanmelden bestaande klant</a></li>
              <li><a href=evenement_kiezen.php>Inschrijven op evenement</a></li>
            </ul>
          </li>

        </ul>
        {if !$loggedin}
          <a href=login.php style="float: right;"><img src="res/icons/login.png" alt="Login" height="40" width="40"></a>
        {else}
          <a href=logout.php style="float: right;"><img src="res/icons/logout.png" alt="Logout" height="40" width="40"></a>
          {if $autorisatie > $KLANT}
            <a href=klant_zoeken.php style="float: right;margin-right:2em;"><img src="res/icons/search.png" alt="Klant zoeken" height="40" width="40"></a>
          {/if}
        {/if}
      </nav>
    </div>

      <br/>
      <br/>

      <div class="window_back_80">
      <h1>{$organisatie_naam} Inschrijvingen</h1>

      {if file_exists("smarty/templates/version.tpl")}
        {include file="version.tpl" nocache}
      {/if}

      <h3 class="errorcolor">{$debugmessage}</h3>

      <br/>
      <br/>

      {if sizeof($lopendeEvenementen) > 0 }
        <h3>Lopende evenementen</h3>
        <table>
          <thead>
          <tr>
            <th>Naam</th>
            <th>Einddatum</th>
          </tr>
          </thead>

        {foreach $lopendeEvenementen as $evenement}
            <tr>
              <td>
                <a href="evenement_statistiek.php?evt={$evenement.id}">{$evenement.naam}</a>
              </td>
              <td>
                {$evenement.datum_eind}
              </td>
            </tr>
        {/foreach}
        </table>
      {else}
        <br />
        <strong>Er zijn geen lopende evenementen</strong>
        <br />
      {/if}

      <br/>

      {if sizeof($komendeEvenementen) > 0 }
        <h3>Komende evenementen volgende maand</h3>
        <table>
          <thead>
          <tr>
            <th>Naam</th>
            <th>Startdatum</th>
            <th>Einddatum</th>
            <th>Plaatsen<br/>beschikbaar</th>
          </tr>
          </thead>

        {foreach $komendeEvenementen as $evenement}
            <tr>
              <td>
                <a href="evenement_statistiek.php?evt={$evenement.id}">{$evenement.naam}</a>
              </td>
              <td>
                {$evenement.datum_begin}
              </td>
              <td>
                {$evenement.datum_eind}
              </td>
              <td align="center">
                {$evenement.aantal_beschikbaar}
              </td>
            </tr>
        {/foreach}
        </table>
      {else}
        <br />
        <strong>Er zijn geen komende evenementen</strong>
        <br />
      {/if}
    </div>

      {include file="statusregel.tpl"}

  <!--/form-->

  {include file="footer.tpl"}