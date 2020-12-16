# ERAS
Evenement Registratie en Administratie Systeem

## Wat is een evenement?
Onder evenement verstaan we hier elke gebeurtenis waar personen aan deelnemen.
Voorbeelden hiervan zijn:
- Een wandeltocht
- Een aantal muzieklessen
- Een Yoga cursus
- Een schilderwedstrijd

## Wat doet ERAS?
ERAS is een compleet systeem om inschrijvingen voor de meest uiteenlopende soorten activiteiten en evenementen af te handelen.
Het is speciaal bedoeld om mensen zonder speciale kennis snel een compleet inschrijvingssysteem op te laten zetten.

Eras is heel erg flexibel en aanpasbaar aan verschillende situaties. 

Verder voorziet het in een complete back-office omgeving om snel overzicht te krijgen van betalingen, planning, bezetting etc.

## Systeem vereisten
ERAS is speciaal bedoeld voor een Apache-PHP-MySQL/MariaDB omgeving. Dit kan in een Linux omgeving zijn, maar een XAMP omgeving onder
Windows werkt ook prima.
PHP versie 7.0 is minimaal vereist. Verder moet ERAS schrijftoegang hebben tot een aantal eigen directories. De installatieprocedure test hier op.

## Installatie
Download het complete ERAS pakket:

### Via GIT
git clone https://github.com/Octet-nl/ERAS.git\

### Via download
Download de ZIP file uit Github en pak deze uit.

### Installeren
Start de installatieprocedure door met uw browser het bestand 'install.php' te openen.

### Voorbeeld

Om een beeld te vormen van de manier waarop ERAS werkt volgen hieronder een paar screenshots.

#### Definitie evenement

Het definiëren van een evenement gebeurt op de volgende wijze:

![Alt text](/app/res/images/gitaar_evenement.png?raw=true "Evenement definitie")

Daarna kunnen opties toegekend worden, het 'optie' mechanisme is erg sterk. Met heel weinig moeite kunnen er allerlei bijzonderheden 
worden toegevoegd aan een evenement.

![Alt text](/app/res/images/gitaar_huren.png?raw=true "Optie definitie")

#### Inschrijving klant

Na nog een aantal opties toegevoegd te hebben ziet het resultaat er voor de klant als volgt uit:
(merk op dat het thema (kleur en lettertype) voor medewerkers anders kan zijn dan het thema voor de klant)

Allereerst de inschrijfgegevens voor de klant:

![Alt text](/app/res/images/gitaar_deelnemer.png?raw=true "Inschrijven")

Na de deelnemergegevens volgt de afronding van de inschrijving met de betaalgegevens en de bevestiging:

![Alt text](/app/res/images/gitaar_afronding.png?raw=true "Inschrijven")

Na bevestiging ontvangt de klant een bevestigingsmail en eventueel een factuur.

