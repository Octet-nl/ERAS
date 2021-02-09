;<?php
;echo "<center><h1>404 Not Found</h1></center><hr><center>nginz</center>"
;die(""); // Cannot execute this file
;/*
;Dit bestand is niet bedoeld om met de hand gewijzigd te worden
;Het wordt in z'n geheel overschreven bij update van de settings!
;
[organisatie]
organisatienaam="Mijn Organisatie"
email="admin@myorg.nl"
website="https://www.myorg.nl"
voorwaarden="https://www.myorg.nl/MyOrg-voorwaarden.php"
logo="../images/OctetLogo.png"
footer="Mijn Organisatie is een Zeer Nuttige Organisatie (ZNO)"
adresregel="Mijn Organisatie    Reuzenweg 14    2345 AB Monster    Tel:012 - 345 66 77    BTW nr:NL5 21 21 21 21 B21    KvK:0123 45678"
;
[bank]
IBAN="NL44RABO0123456789"
BIC="INGSNL3Z"
ten_name_van="Mijn Organisatie"
;
[pdf_factuur]
aanmaken="nee"
verzenden="nee" 
titel="ERAS factuur"
notatype="Factuur"
;
BTW-percentage=21.00
BTW-regel1="Exclusief BTW"
BTW-regel2="BTW (21%)"
BTW-regel3="Totaal incl. BTW"
;
[tabelkop]
evenement-kolom1="Evenement"
evenement-kolom2="Datum"
evenement-kolom3="Aantal"
evenement-kolom4="Per pers."
evenement-kolom5="Prijs"
;
deelnemer-kolom1="Deelnemer"
deelnemer-kolom2="Omschrijving"
deelnemer-kolom3="Aantal"
deelnemer-kolom4="à"
deelnemer-kolom5="Prijs"
;
[ideal_payment]
toestaan="nee"
checkout_script="../idealcheckout/checkout.php"
status_stopped="html/ideal_betaald.html"
status_success="html/ideal_gestopt.html"
status_failure="html/ideal_fout.html"
status_pending="html/ideal_onbekend.html"
;
[betaling]
incasso_tekst="<div align=left>U heeft gekozen voor betaling in termijnen. Ongeveer een week na uw inschrijving ontvangt u van ons per mail een incassoformulier waarmee u toestemming geeft. De incassodata verschillen per evenement, kijk hiervoor op de inschrijfpagina. Bij de eerste incasso wordt een eventuele annuleringsverzekering en de incassokosten volledig verrekend, de termijnbedragen worden op het incassoformulier vermeld</div>"
contant_tekst="<div align=left>U kunt contant betalen bij de aanvang van het evenement</div>"
voorwaarden="<div align=left>Uw betaling moet binnen een maand na aanmelding bij ons binnen zijn. Als uw iDeal betaling mislukt is dan kunt u het bedrag altijd via een gewone bankopdracht overmaken.<br><br>- Vermeld bij zelf overschrijven zorgvuldig uw inschrijfnummer. Hiermee kunnen we uw betaling aan uw inschrijving koppelen. Niet traceerbare betalingen worden teruggeboekt met mogelijk gevolgen voor uw inschrijving.<br><br>- Een eventuele betaling via iDeal is hier nog niet in verwerkt.</div>"
;
[verzekering]
toestaan="ja"
voorwaarden="https://www.verzeker_bedrijf.nl/verzekering/kortlopende-annuleringsverzekering"
;
[settings]
log_directory="../log"
temp_directory="../temp"
facturen_directory="../facturen"
image_directory="../images"
;
refresh="30"
batch_size="10"
password_klant="1"
password_medewerker="2"
;
;*/
;?>
