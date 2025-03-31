# Inhalt
## Warnung
Ich habe es nur für TYPO3 12 getestet. Es sollte aber auch mit anderen versionen funktionieren.

## Ziel der Extension
Die Extension stellt vom Browser unterstützte Webcomponents zur Nutzung in Templates zur Verfügung.
Webcomponent sind Helfer-Tags, die den View und oder das interaktive Verhalten verändern.
Die Webcomponents wurde via [vibe coding](https://en.wikipedia.org/wiki/Vibe_coding) erzeugt, so dass bei Fehlern natürlich nicht ich als Entwickler sondern die KI schuld ist, weil sie nicht alle Randfälle berücksichtigt hat.

## Installation und Nutzung
1. Installieren sie die Extension
   1. auf dem klassischen Weg
   2. via composer mit `composer require porthd/webhelp`
2. Prüfen sie im Installtool-Bereich, ob die Konfiguration der Extension ihren Ansprüchen genügt.
 Per Default wird im TypoScript das `page = PAGE`-Objekt für das Laden des JavaScriupts unterstellt.
3. Nutzen sie dei Tags der Web Commponents in ihren Fluid-Templates. Schauen sie im Ordner `Resources/Private/Examples`, wie sie in Fluid-Templates bzw. im HTML die Tags der Web Components verwenden können.

## Definierte Webcomponents

Web-Component | Aufgabe                                                                                                                                                                                   | Links
--------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|------
porthd-vcard | Erstelt eine Kontakt-Datei und wandelt die inkludierte Liste von Daten in eine downloadbare vcf-Datei um. Die inkludierten Daten werden validiert.                                        | [de-Wikipedia](https://de.wikipedia.org/wiki/VCard#Spezifikation) ---  [RFC6350-Spezifikation](https://www.rfc-editor.org/rfc/rfc6350)
porthd-icalendar | Erstellt einen Events-Termin-Datei und wandelt eine inkludierte Liste mit Daten zu einem oder mehreren Events in eine downloadbare ics-Datei um. Die inkludierten Daten werden validiert. | [Spezifikation](https://icalendar.org/RFC-Specifications/all/) --- [en-Wikipedia](https://en.wikipedia.org/wiki/ICalendar#:~:text=iCalendar%20ist%20ein%20Datenformat%20zum%20Austausch%20von%20Kalenderinhalten%2C,wurde%20urspr%C3%BCnglich%201998%20in%20RFC%202445%20%5B10%5D%20definiert.) --- [de-Wikipedia-Media](https://de.wikipedia.org/wiki/ICalendar#/media/Datei:ICalendarSpecification.png)
porthd-listselect | Beschränkte die Ausgabe von langen verschachtelten Listen auf einen definierten Level und erlaubt die Suche verborgenen Teilüberschriften.                                                | [Übersicht zu Menüs im Web](https://sketch.media/index.php?option=com_content&view=article&id=851) --- [Dropdown-Menü für große Verschachtelung](https://wiki.selfhtml.org/wiki/Navigation/Dropdown-Men%C3%BC) --- [Mediaevent zu Menüs](https://www.mediaevent.de/tutorial/css-responsive-menu.html)



### Parameter in `<porthd-vcard>`
Das Web-Component `<porthd-vcard>` inkludiert eine Liste von HTML-Tags, die die einzelnen Parameter in der vcard-Datei definieren.
Die Nutzungbeispiele findet man hier in der Dokumentation in ['Examples/WebcomponentVCard.html'](./Examples/WebcomponentVCard.html)
Der Wert in `data-id` bestimmt den jeweiligen Parameter in der späteren vcard-Datei.
Gegebenenfalls können im Hauptparameter noch weitere Parameter erlaubt sein, wie zum Beispiel der TYPE-Parameter oder der VALUE-Parameter oder ähnliches, wie aus der nachfolgenden Tabelle zu ersehen ist.
Im Gegensatz zum in dieser Extension definierten iCalendar-Web Component werden außer den genannten data-Attributen keinen weiteren akzeptiert.
Wenn sie bei den inkludierten Elementen weitere Data-Attribute einfügen, dann werden diese ungeprüft nach folgenden Schema eingefügt:
`<div data-id="ATTACH" data-fmttype="application/postscript">ftp://example.com/pub/reports/r-960812.ps</div>`
führt zu folgenden Eintrag im iCalendar
`ATTACH;FMTTYPE=application/postscript:ftp://example.com/pub/reports/r-960812.ps`.
Bitte stellen sie sicher, dass immer eine valide Kombination genutzt wird.

**Tabelle mit den validierten IDs für inkludierte Elemente**

Parameter | Definiton | `data-value` | `data-type` | `data-`*
--|--|--|--|--
ADR | Adresse | 0 | 1 |
ANNIVERSARY | Jahrestag | 1 | 0 |
BDAY | Geburtstag | 1 | 0 |
BIRTHPLACE | Geburtsort der Person | 0 | 0 |
CALADRURI | URL zum Senden einer Terminanfrage an den Kalender der Person | 0 | 0 |
CALURI | URL zum Kalender der Person | 0 | 0 |
CATEGORIES | Liste von Tags zur Beschreibung des durch diese vCard repräsentierten Objekts | 0 | 0 |
CLIENTPIDMAP | Wird zum Synchronisieren verschiedener Revisionen derselben vCard verwendet. | 0 | 0 |
DEATHDATE | Sterbedatum der Person | 0 | 0 |
DEATHPLACE | Sterbeort der Person | 0 | 0 |
EMAIL | E-Mail-Adresse | 0 | 1 |
EXPERTISE | Fachgebiet der Person | 0 | 0 |
FBURL | Definiert eine URL, die anzeigt, wann Die Person ist in ihrem Kalender frei oder beschäftigt., 0, 0 |
**FN** | **Full Name (Required)** | **0** | **0** | ** **
GENDER | Geschlecht | 0 | 0 |
GEO | Geokoordinaten (V4.0) | 0 | 0 |
HOBBY | Freizeitbeschäftigung der Person | 0 | 0 |
IMPP | Benutzername für einen Instant Messenger. Dieser wurde in der offiziellen vCard-Spezifikation in Version 4.0 aufgenommen. | 0 | 0 |
INTEREST | Freizeitbeschäftigung, an der die Person interessiert ist, die sie aber nicht unbedingt ausübt. | 0 | 0 |
KEY | Öffentlicher Verschlüsselungsschlüssel (V4.0) | 0 | 0 | MEDIATYPE,ENCODING
KIND | Definiert den Entitätstyp, den diese vCard repräsentiert: 'Anwendung' | Einzelperson' | Gruppe' | Standort' oder 'Organisation'; experimentell., 0, 0 | ',
LABEL | Sprache | 0 | 1 |
LANG | Sprache | 0 | 0 |
LOGO | Firmenlogo (V4.0) | 1 | 0 | ENCODING
MEMBER | Definiert ein Mitglied der Gruppe, die diese vCard repräsentiert. | 0 | 0 |
N | Name (V4.0 – optional) | 0 | 0 |
NICKNAME | Spitzname | 0 | 0 |
NOTE | Notiz | 1 | 0 | LANGUAGE
ORG | Organisation | 0 | 1 |
ORG-DIRECTORY | URI für den Arbeitsplatz der Person; hierüber können Informationen über die Mitarbeiter der Person abgerufen werden | 0 | 0 |
PHOTO | Foto | 1 | 1 | ENCODING,MEDIATYPE
RELATED | Eine andere Entität, mit der die Person in Beziehung steht. | 0 | 1 |
REV | Letzte Aktualisierung | 1 | 0 |
ROLE | Rolle | 0 | 0 |
SOUND | Es Gibt die Aussprache der FN an., 0, 0 |
SOURCE | Eine URL, über die die neueste Version dieser vCard abgerufen werden kann. | 0 | 0 |
TEL | Telefonnummer | 0 | 1 |
TITEL | Titel | 0 | 0 |
TZ | Zeitzone | 0 | 0 |
URL | Website | 0 | 1 | TITEL
XML | Alle XML-Daten, die mit der vCard verknüpft sind | 0 | 1 | TITEL

Zur genauen inhaltlichen Nutzung sei auf die Definition der vCard [bei wikipedia](https://en.wikipedia.org/wiki/VCard) oder [bei der Spezifikation](https://www.rfc-editor.org/rfc/rfc6350.html) verwiesen.

Um die Datei zur Verfügung zu stellen, wird im web-component ein Button im Shadow-DOM definiert.
Über die Attribute kann das Aussehen und der Text des Buttons definiert werden.

**Attribute in `<porthd-vcard>`**

Attribute | Funktion
--|--
button-label | Text des Buttons, wobei der TEXT auch HTML- und SVG-Tags enhalten kann.
button-style | CSS-Eigenschaften für das style-Element des Buttons im Shadow-DOM
file-name | Name für die Datei, die heruntergeladen wird

### Parameter in `<porthd-icalendar>`
Das Web-Component `<porthd-icalendar>` inkludiert eine Liste von HTML-Tags, die die einzelnen Parameter in der icalendar-Datei definieren.
Die Nutzungbeispiele findet man hier in der Dokumentation in ['Examples/WebcomponentICalendar.html'](./Examples/WebcomponentICalendar.html)
Wenn sie bei den inkludierten Elemente weitere Data-Attribute einfügen, dann werden diese ungeprüft nach folgenden Schema eingefügt:
`<div data-id="ATTACH" data-fmttype="application/postscript">ftp://example.com/pub/reports/r-960812.ps</div>`
führt zu folgenden Eintrag im iCalendar
`ATTACH;FMTTYPE=application/postscript:ftp://example.com/pub/reports/r-960812.ps`.
Bitte stellen sie sicher, dass immer eine valide Kombination genutzt wird.

**Tabelle mit den validierten IDs für inkludierte Elemente**

data-id | Beschreibung
------|-----
ATTACH | Anhänge (z. B. PDF-Agenda)
ATTENDEE | Veranstaltungsteilnehmer
BEGIN | immer mit VEVENT - Definieren Sie ein neues Ereignis in der Datei. Nicht erforderlich für nur ein Ereignis. Nur direkt nach END
CALSCALE | Kalenderskala (z. B. GREGORIANISCH)
CATEGORIES | Veranstaltungskategorien
CLASS | Sichtbarkeit (ÖFFENTLICH, PRIVAT, VERTRAULICH)
CREATED | Erstellungszeitpunkt
DESCRIPTION | Längere Beschreibung des Ereignisses
DTEND | Endzeit des Ereignisses
DTSTAMP | Erstellungszeitstempel (erforderlich)
DTSTART | Startzeit des Ereignisses (erforderlich)
END | immer mit VEVENT - Definieren Sie ein neues Ereignis in der Datei. Nicht erforderlich für nur ein Ereignis. BEGIN muss anschließend zur Definition des nächsten Events folgen
EXDATE | Ausnahmen für Wiederholungen
GEO | Geografische Koordinaten (Breitengrad; Längengrad)
LAST-MODIFIED | Zeitpunkt der letzten Änderun
LOCATION | Veranstaltungsort
METHOD | Methode für den Kalender (z. B. VERÖFFENTLICHEN)
ORGANIZER | Veranstalter
PRIORITY | Priorität (1-9, 1 = höchste)
RECURRENCE-ID | Referenz zu einer wiederkehrenden Veranstaltung
RRULE | Regel für wiederkehrende Veranstaltungen
SEQUENCE | Änderungsanzahl der Veranstaltung
STATUS | Status (z. B. BESTÄTIGT, ABGESAGT)
SUMMARY | Kurzbeschreibung des Ereignisses
TRANSP | Transparenz (OPAQUE = belegt, TRANSPARENT = frei)
UID | Eindeutige Identifikationsnummer des Ereignisses (erforderlich)
URL | Weblink zur Veranstaltung
X-WR-CALNAME | Anzeigename des Kalenders
X-WR-TIMEZONE | Kalenderzeitzone

**Attribute in `<porthd-vcard>`**
Dieses Webcomponent bringt vier Attribute mit. Zwei dienen der Definition des Buttons, eines der ProdID für den iCalendar-Eintrag

Attribute | Funktion
--|--
button-label | Text des Buttons, wobei der TEXT auch HTML- und SVG-Tags enhalten kann.
button-style | CSS-Eigenschaften für das style-Element des Buttons im Shadow-DOM
file-name | Name für die Datei, die heruntergeladen wird; wobei die Endung '.ics' immer angefügt wird.
prodid | Identifier für die Generierung der iCalendar-Datei. Dieser Eintrag ist nicht genormt.

### Parameter in `<porthd-listselect>`

Das Web-Component `<porthd-listselect>` inkludiert eine verschachtelte Liste von HTML-Tags, die zum Beispiel ein komplexes Menü, die Sitemap einer Seite, ein Organigram oder ein Inhaltsverzeichnis repräsentieren können. Es erlaubt die einfache Filterung nach Level und/oder Schlagworten, die gemäß dem Autocomplete-Prinzip angeboten werden.
Ein Nutzungbeispiel findet man hier in der Dokumentation in ['Examples/WebcomponentListSelectFilter.html'](./Examples/WebcomponentListSelectFilter.html)
Das Web-Component bringt relativ viele Attribute, um das Filterformular einstellen zu können.

**Attribute in `<porthd-listselect>`**

Attribute | Funktion
--|--
level | Ebene, die bei verschachtelten Listen per Default oder nach einem Reset angezeigt werden soll
filter | Begriff, der in die Suchbox beim Filter eingetragen wird
list-tags | Selektoren bzw. HTML-Tags, die jeweils ein Listenelement und/oder einen verschachtelten Liste umklammern. Es wird die Pseudoklasse :where() zur Selektion genutzt.
search-length | Zahl der Buchstaben, die mindestens in die Suchbox eingegeben werden müssen
label-range | Text-Bezeichner vor dem Schieberegler zur Einstellung der angezeigen Verschachtelungstiefe
label-search | Text-Bezeichner vor dem Eingabefeld für die Filterung
label-reset | Text-Bezeichner für den Reset-Button
placeholder | Text, der im leeren Eingabefeld für die Filterung angezeigt wird
label-style | Liste der CSS-Eigenschaften, die man den beiden Label-Felder zuordnen möchte. Es ist analog zum style-Feld in normalen Tags.
input-style | Liste der CSS-Eigenschaften, die man den Input-Feld zuordnen möchte. Es ist analog zum style-Feld in normalen Tags.
range-style | Liste der CSS-Eigenschaften, die man den Range-Feld zuordnen möchte. Es ist analog zum style-Feld in normalen Tags. Pseudoklasse werden nicht übertragen.
button-style | Liste der CSS-Eigenschaften, die man den Reset-Button zuordnen möchte. Es ist analog zum style-Feld in normalen Tags.
trim | Die Worte für das Autocomplete können um die Zeichen getrimmt werden, so dass zum Beispiel Klammern ohne Leerzeichen vor einem Wort im Autocomplete nicht auftauchen.

## Experiment

### Parameter in ``<porth-modal>``

Die ist ein schlechtes Produkt von vibe-coding mit ChatGPT, weil sich das Modal noch nichteinmal leicht zentrieren lässt.
Das Negativ-Beispiel findet man hier in der Dokumentation in ['Examples/WebcomponentModal.html'](./Examples/WebcomponentModal.html).
Vielleicht habe ich das falsche Promting verwendet oder es gibt eine technische Lösung, die das System noch nicht gelernt hat und die es bisher mangels Kreativität nicht erdenken kann.
