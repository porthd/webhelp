# Inhalt
## Warnung
Ich habe es nur für TYPO3 12 getestet. Es sollte aber auch mit anderen versionen funktionieren.

Übersetzt von Deutsch nach Englisch mit google - nur flüchtig geprüft.

### Work-Around bei Fehlern
Im schlimmsten Fall testen sie einmal kurz die HTML-Datei und übernehmen die per vibe-coding generierten und im JavaScript definierten Web-Components in ihre Extension auf. Dann können sie die Tags der Web-Components wie normale HTML-Tags auch in ihrem Fluid-Templates verwenden. Falls der Code nicht funktioniert, bitten sie einfach eine KI, Ihnen den Code zu reparieren.
Vibe-Coding steht für "Programmieren wie Politiker - oder besser: ahnungslos Geniales vortäuschen".

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
3. Nutzen sie die Tags der Web Commponents in ihren Fluid-Templates. Schauen sie im Ordner `Resources/Private/Examples`, wie sie in Fluid-Templates bzw. im HTML die Tags der Web Components verwenden können.

## Definierte Webcomponents

| Web-Component (intern verlinkt)                        | slogan                               | Aufgabe                                                                                                                                                                                                                                                                                                                      | Links                                                                                                                                                                                                                                                                                                                                                                                                     |
|--------------------------------------------------------|--------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| [porthd-ajax](#parameter-in-porthd-ajax)               |  Content nachladen                   | Hole per HTTP-Request von einer definierten URL Daten oder HTML-Fragmente und inkludiere sie in das eigene Tag des Webcomponent. Ein Button für mehrfache Abfragen kan gesetzt werden. Gegebenenfalls kann zur Aufbereitung der Daten eine Callback ins Webcomponent eingeführt werden.                                      | [Ajax-Erläuterungen (deutsch)](https://de.wikipedia.org/wiki/Ajax_(Programmierung)) [Ajax-Erläuterungen (englisch)](https://en.wikipedia.org/wiki/Ajax_(programming))                                                                                                                                                                                                                                     |
| [porthd-breadcrumb](#parameter-in-porthd-breadcrumb)   | Sprechenden Lin in Breadcrumb        | Konvertiere einen Zeit von einer Zeitzone in eine andere Zeitzone und präsentiere das Ergebnis innerhalb des Tags des Web-Component, wobei die Startzeit entwender vom Tag inkludiert sein muss oder aber im Attribut `datetime` stehen muss.                                                                                | [ Gedanken zur Breadcrumb-Navigation in Englisch](https://www.smashingmagazine.com/2009/03/breadcrumbs-in-web-design-examples-and-best-practices/) [Codebeispiel für gute Breadcrumb-Navigationshilfe in Deutsch](https://web.dev/patterns/components/breadcrumbs?hl=de)                                                                                                                                  |
| [porthd-codeview](#parameter-in-porthd-codeview)     | Code-Ansicht                            | Es handelt sich um eine anpassbare Webkomponente zur Darstellung von Code mit Syntax-Hervorhebung, unterstützt durch Themes, Zeilennummern und die Möglichkeit, den Code in die Zwischenablage zu kopieren.                                                                                                                                                                                                                              | [Prism-Dokumentation in Englisch](https://prismjs.com/docs/)                                                                                                                                                                                                                                                                                                                                         |
| [porthd-icalendar](#parameter-in-porthd-icalendar)     | HTML-Event-Daten als ics-Datei anbieten | Erstellt einen Events-Termin-Datei und wandelt eine inkludierte Liste mit Daten zu einem oder mehreren Events in eine downloadbare ics-Datei um. Die inkludierten Daten werden validiert.                                                                                                                                    | [Spezifikation](https://icalendar.org/RFC-Specifications/all/) --- [en-Wikipedia](https://en.wikipedia.org/wiki/ICalendar#:~:text=iCalendar%20ist%20ein%20Datenformat%20zum%20Austausch%20von%20Kalenderinhalten%2C,wurde%20urspr%C3%BCnglich%201998%20in%20RFC%202445%20%5B10%5D%20definiert.) --- [de-Wikipedia-Media](https://de.wikipedia.org/wiki/ICalendar#/media/Datei:ICalendarSpecification.png) |
| [porthd-infomodal](#parameter-in-porthd-infomodal)     | Info-Popup per Template definieren   | erfordert die Definition von einem Template für das Modalfenster mit Schließen-Button und einem inkludierten Startbutton, um so die Ausgabe von einem Modal-Fenster zur Information zur Verfügung zu stellen. Über die Attribute `data-*` und gleichnamigen Slots im &lt;template&gt; sind dynamische Modal-Fenster möglich. | [Erläuterungen zu Modal-Fenstern in Deutsch](https://ichi.pro/de/4-moglichkeiten-zum-erstellen-eines-modalen-popup-felds-mit-html-css-und-vanilla-javascript-83364935438226)                                                                                                                          |
| [porthd-listselect](#parameter-in-porthd-listselect)   | Mega-Menüs interaktiv steuern/filtern | Beschränkte die Ausgabe von langen verschachtelten Listen auf einen definierten Level und erlaubt die Suche verborgenen Teilüberschriften.                                                                                                                                                                                   | [Übersicht zu Menüs im Web](https://sketch.media/index.php?option=com_content&view=article&id=851) --- [Dropdown-Menü für große Verschachtelung](https://wiki.selfhtml.org/wiki/Navigation/Dropdown-Men%C3%BC) --- [Mediaevent zu Menüs](https://www.mediaevent.de/tutorial/css-responsive-menu.html)                         |
| [porthd-timezone](#parameter-in-porthd-timezone)       | Zeitzoneumrechnung für Datum         | Konvertiere einen Zeit von einer Zeitzone in eine andere Zeitzone und präsentiere das Ergebnis innerhalb des Tags des Web-Component, wobei die Startzeit entwender vom Tag inkludiert sein muss oder aber im Attribut `datetime` stehen muss.                                                                                | [ Erläuterungen zur Zeitzone in Deutsch](https://www.mediaevent.de/javascript/get-timezone.html)                                                                                                                                                                                                                             |
| [porthd-vcard](#parameter-in-porthd-vcard)             | HTML-Kontaktdaten als vcf-Datei anbieten |  Erstelt eine Kontakt-Datei und wandelt die inkludierte Liste von Daten in eine downloadbare vcf-Datei um. Die inkludierten Daten werden validiert.                                                                                                                                                                          | [de-Wikipedia](https://de.wikipedia.org/wiki/VCard#Spezifikation) ---  [RFC6350-Spezifikation](https://www.rfc-editor.org/rfc/rfc6350)                                                                                                                                                                                       |

### Parameter in porthd-vcard
Das Web-Component `<porthd-vcard>` inkludiert eine Liste von HTML-Tags, die die einzelnen Parameter in der vcard-Datei definieren.
Die Nutzungsbeispiele findet man hier in der Dokumentation in ['Examples/WebcomponentVCard.html'](./Examples/WebcomponentVCard.html)
Der Wert in `data-id` bestimmt den jeweiligen Parameter in der späteren vcard-Datei.
Gegebenenfalls können im Hauptparameter noch weitere Parameter erlaubt sein, wie zum Beispiel der TYPE-Parameter oder der VALUE-Parameter oder ähnliches, wie aus der nachfolgenden Tabelle zu ersehen ist.
Im Gegensatz zum in dieser Extension definierten iCalendar-Web Component werden außer den genannten data-Attributen keinen weiteren akzeptiert.
Wenn sie bei den inkludierten Elementen weitere Data-Attribute einfügen, dann werden diese ungeprüft nach folgenden Schema eingefügt:
`<div data-id="ATTACH" data-fmttype="application/postscript">ftp://example.com/pub/reports/r-960812.ps</div>`
führt zu folgenden Eintrag im iCalendar
`ATTACH;FMTTYPE=application/postscript:ftp://example.com/pub/reports/r-960812.ps`.
Bitte stellen sie sicher, dass immer eine valide Kombination genutzt wird.

Der Code ist per vibe-coding entstanden und wurde bisher nicht sogfältig geprüft.

**Tabelle mit den validierten IDs für inkludierte Elemente**

| Parameter     | Definiton | `data-value` | `data-type` | `data-`*|
|---------------|--|--|--|--|
| ADR           | Adresse | 0 | 1 ||
| ANNIVERSARY   | Jahrestag | 1 | 0 ||
| BDAY          | Geburtstag | 1 | 0 ||
| BIRTHPLACE    | Geburtsort der Person | 0 | 0 ||
| CALADRURI     | URL zum Senden einer Terminanfrage an den Kalender der Person | 0 | 0 ||
| CALURI        | URL zum Kalender der Person | 0 | 0 ||
| CATEGORIES    | Liste von Tags zur Beschreibung des durch diese vCard repräsentierten Objekts | 0 | 0 ||
| CLIENTPIDMAP  | Wird zum Synchronisieren verschiedener Revisionen derselben vCard verwendet. | 0 | 0 ||
| DEATHDATE     | Sterbedatum der Person | 0 | 0 ||
| DEATHPLACE    | Sterbeort der Person | 0 | 0 ||
| EMAIL         | E-Mail-Adresse | 0 | 1 ||
| EXPERTISE     | Fachgebiet der Person | 0 | 0 ||
| FBURL         | Definiert eine URL, die anzeigt, wann Die Person ist in ihrem Kalender frei oder beschäftigt., 0, 0 ||
| **FN**        | **Full Name (Required)** | **0** | **0** | ** **|
| GENDER        | Geschlecht | 0 | 0 ||
| GEO           | Geokoordinaten (V4.0) | 0 | 0 ||
| HOBBY         | Freizeitbeschäftigung der Person | 0 | 0 ||
| IMPP          | Benutzername für einen Instant Messenger. Dieser wurde in der offiziellen vCard-Spezifikation in Version 4.0 aufgenommen. | 0 | 0 ||
| INTEREST      | Freizeitbeschäftigung, an der die Person interessiert ist, die sie aber nicht unbedingt ausübt. | 0 | 0 ||
| KEY           | Öffentlicher Verschlüsselungsschlüssel (V4.0) | 0 | 0 | MEDIATYPE,ENCODING|
| KIND          | Definiert den Entitätstyp, den diese vCard repräsentiert: 'Anwendung' | Einzelperson' | Gruppe' | Standort' oder 'Organisation'; experimentell., 0, 0 | ',|
| LABEL         | Sprache | 0 | 1 ||
| LANG          | Sprache | 0 | 0 ||
| LOGO          | Firmenlogo (V4.0) | 1 | 0 | ENCODING|
| MEMBER        | Definiert ein Mitglied der Gruppe, die diese vCard repräsentiert. | 0 | 0 ||
| N             | Name (V4.0 – optional) | 0 | 0 ||
| NICKNAME      | Spitzname | 0 | 0 ||
| NOTE          | Notiz | 1 | 0 | LANGUAGE|
| ORG           | Organisation | 0 | 1 ||
| ORG-DIRECTORY | URI für den Arbeitsplatz der Person; hierüber können Informationen über die Mitarbeiter der Person abgerufen werden | 0 | 0 ||
| PHOTO         | Foto | 1 | 1 | ENCODING,MEDIATYPE|
| RELATED       | Eine andere Entität, mit der die Person in Beziehung steht. | 0 | 1 ||
| REV           | Letzte Aktualisierung | 1 | 0 ||
| ROLE          | Rolle | 0 | 0 ||
| SOUND         | Es Gibt die Aussprache der FN an., 0, 0 ||
| SOURCE        | Eine URL, über die die neueste Version dieser vCard abgerufen werden kann. | 0 | 0 ||
| TEL           | Telefonnummer | 0 | 1 ||
| TITEL         | Titel | 0 | 0 ||
| TZ            | Zeitzone | 0 | 0 ||
| URL           | Website | 0 | 1 | TITEL|
| XML           | Alle XML-Daten, die mit der vCard verknüpft sind | 0 | 1 | TITEL|

Zur genauen inhaltlichen Nutzung sei auf die Definition der vCard [bei wikipedia](https://en.wikipedia.org/wiki/VCard) oder [bei der Spezifikation](https://www.rfc-editor.org/rfc/rfc6350.html) verwiesen.

Um die Datei zur Verfügung zu stellen, wird im web-component ein Button im Shadow-DOM definiert.
Über die Attribute kann das Aussehen und der Text des Buttons definiert werden.

**Attribute in `<porthd-vcard>`**

| Attribute    | Funktion|
|--------------|--|
| button-label | Text des Buttons, wobei der TEXT auch HTML- und SVG-Tags enhalten kann.|
| button-style | CSS-Eigenschaften für das style-Element des Buttons im Shadow-DOM|
| file-name    | Name für die Datei, die heruntergeladen wird|

### Parameter in porthd-icalendar
Das Web-Component `<porthd-icalendar>` inkludiert eine Liste von HTML-Tags, die die einzelnen Parameter in der icalendar-Datei definieren.
Die Nutzungsbeispiele findet man hier in der Dokumentation in ['Examples/WebcomponentICalendar.html'](./Examples/WebcomponentICalendar.html)
Wenn sie bei den inkludierten Elemente weitere Data-Attribute einfügen, dann werden diese ungeprüft nach folgenden Schema eingefügt:
`<div data-id="ATTACH" data-fmttype="application/postscript">ftp://example.com/pub/reports/r-960812.ps</div>`
führt zu folgenden Eintrag im iCalendar
`ATTACH;FMTTYPE=application/postscript:ftp://example.com/pub/reports/r-960812.ps`.
Bitte stellen sie sicher, dass immer eine valide Kombination genutzt wird.

Der Code ist per vibe-coding entstanden und wurde bisher nicht sogfältig geprüft.

**Tabelle mit den validierten IDs für inkludierte Elemente**

| data-id       | Beschreibung|
|---------------|-----|
| ATTACH        | Anhänge (z. B. PDF-Agenda)|
| ATTENDEE      | Veranstaltungsteilnehmer|
| BEGIN         | immer mit VEVENT - Definieren Sie ein neues Ereignis in der Datei. Nicht erforderlich für nur ein Ereignis. Nur direkt nach END|
| CALSCALE      | Kalenderskala (z. B. GREGORIANISCH)|
| CATEGORIES    | Veranstaltungskategorien|
| CLASS         | Sichtbarkeit (ÖFFENTLICH, PRIVAT, VERTRAULICH)|
| CREATED       | Erstellungszeitpunkt|
| DESCRIPTION   | Längere Beschreibung des Ereignisses|
| DTEND         | Endzeit des Ereignisses|
| DTSTAMP       | Erstellungszeitstempel (erforderlich)|
| DTSTART       | Startzeit des Ereignisses (erforderlich)|
| END           | immer mit VEVENT - Definieren Sie ein neues Ereignis in der Datei. Nicht erforderlich für nur ein Ereignis. BEGIN muss anschließend zur Definition des nächsten Events folgen|
| EXDATE        | Ausnahmen für Wiederholungen|
| GEO           | Geografische Koordinaten (Breitengrad; Längengrad)|
| LAST-MODIFIED | Zeitpunkt der letzten Änderun|
| LOCATION      | Veranstaltungsort|
| METHOD        | Methode für den Kalender (z. B. VERÖFFENTLICHEN)|
| ORGANIZER     | Veranstalter|
| PRIORITY      | Priorität (1-9, 1 = höchste)|
| RECURRENCE-ID | Referenz zu einer wiederkehrenden Veranstaltung|
| RRULE         | Regel für wiederkehrende Veranstaltungen|
| SEQUENCE      | Änderungsanzahl der Veranstaltung|
| STATUS        | Status (z. B. BESTÄTIGT, ABGESAGT)|
| SUMMARY       | Kurzbeschreibung des Ereignisses|
| TRANSP        | Transparenz (OPAQUE = belegt, TRANSPARENT = frei)|
| UID           | Eindeutige Identifikationsnummer des Ereignisses (erforderlich)|
| URL           | Weblink zur Veranstaltung|
| X-WR-CALNAME  | Anzeigename des Kalenders|
| X-WR-TIMEZONE | Kalenderzeitzone|

**Attribute in `<porthd-vcard>`**
Dieses Webcomponent bringt vier Attribute mit. Zwei dienen der Definition des Buttons, eines der ProdID für den iCalendar-Eintrag

| Attribute    | Funktion |
|--------------|-- |
|button-label | Text des Buttons, wobei der TEXT auch HTML- und SVG-Tags enhalten kann. |
|button-style | CSS-Eigenschaften für das style-Element des Buttons im Shadow-DOM |
|file-name    | Name für die Datei, die heruntergeladen wird; wobei die Endung '.ics' immer angefügt wird. |
|prodid       | Identifier für die Generierung der iCalendar-Datei. Dieser Eintrag ist nicht genormt. |

### Parameter in porthd-listselect

Das Web-Component `<porthd-listselect>` inkludiert eine verschachtelte Liste von HTML-Tags, die zum Beispiel ein komplexes Menü, die Sitemap einer Seite, ein Organigram oder ein Inhaltsverzeichnis repräsentieren können. Es erlaubt die einfache Filterung nach Level und/oder Schlagworten, die gemäß dem Autocomplete-Prinzip angeboten werden.
Ein Nutzungsbeispiel findet man hier in der Dokumentation in ['Examples/WebcomponentListSelectFilter.html'](./Examples/WebcomponentListSelectFilter.html)
Das Web-Component bringt relativ viele Attribute mit, um das Filterformular einstellen zu können.

Der Code ist per vibe-coding entstanden und wurde bisher nicht sogfältig geprüft.

**Attribute in `<porthd-listselect>`**

| Attribute     | Funktion |
|---------------|---------- |
| level         | Ebene, die bei verschachtelten Listen per Default oder nach einem Reset angezeigt werden soll |
| filter        | Begriff, der in die Suchbox beim Filter eingetragen wird |
| list-tags     | Selektoren bzw. HTML-Tags, die jeweils ein Listenelement und/oder einen verschachtelten Liste umklammern. Es wird die Pseudoklasse :where() zur Selektion genutzt. |
| search-length | Zahl der Buchstaben, die mindestens in die Suchbox eingegeben werden müssen |
| label-range   | Text-Bezeichner vor dem Schieberegler zur Einstellung der angezeigen Verschachtelungstiefe |
| label-search  | Text-Bezeichner vor dem Eingabefeld für die Filterung |
| label-reset   | Text-Bezeichner für den Reset-Button |
| placeholder   | Text, der im leeren Eingabefeld für die Filterung angezeigt wird |
| label-style   | Liste der CSS-Eigenschaften, die man den beiden Label-Felder zuordnen möchte. Es ist analog zum style-Feld in normalen Tags. |
| input-style   | Liste der CSS-Eigenschaften, die man den Input-Feld zuordnen möchte. Es ist analog zum style-Feld in normalen Tags. |
| range-style   | Liste der CSS-Eigenschaften, die man den Range-Feld zuordnen möchte. Es ist analog zum style-Feld in normalen Tags. Pseudoklasse werden nicht übertragen. |
| button-style  | Liste der CSS-Eigenschaften, die man den Reset-Button zuordnen möchte. Es ist analog zum style-Feld in normalen Tags. |
| trim          | Die Worte für das Autocomplete können um die Zeichen getrimmt werden, so dass zum Beispiel Klammern ohne Leerzeichen vor einem Wort im Autocomplete nicht auftauchen. |

### Parameter in porth-ajax
Das Web-Component `<porthd-ajax>` erlaubt die Integration von Daten, die aktiv per Ajax nachgeladen werden. Die Abfrage kann automatisch oder aber erst nach Klick auf einen Button erfolgen, wobei der Button gestylt, betextet und in seiner Nutzungshäufigkeit beschränkt werden kann. Auch ist es möglich, die empfangenen Daten mit Hilfe einer JavaScript-Funktion für die Ausgabe umzuformen. Auch lassen sich die Hilfstexte frei definieren.
Ein Nutzungsbeispiel findet man hier in der Dokumentation in ['Examples/WebcomponentAjax.html'](./Examples/WebcomponentAjax.html)

Der Code ist per vibe-coding entstanden und wurde bisher nicht sogfältig geprüft.

**Attribute in `<porthd-ajax>`**
Die nachfolgende Tabelle beschreibt die verschiedenen unterstützten Attribute und ihre Funktion.

|  Attribute     | Funktion|
|----------------|--|
|  url           | URL für den https-Request, von wo die gewünschten Daten heruntergeladen werden können.|
|  loading-text  | Text, der während der Wartezeit beim Laden der Daten angezeigt wird. Der Text kann HTML-Tags enthalten.|
|  error-text    | Text, der während der Wartezeit beim Laden der Daten angezeigt wird. Der Text kann HTML-Tags enthalten.|
|  callback      | Optional. Funktion vom Typ `data = callback(data);`. Die Funktion dient dazu die ankommenden Daten für die Anzeige im Web-Component vorzubereiten.|
|  button-text   | Wenn hier mindestens ein Nicht-Weißzeichen steht, wird im Web-Component ein Button mit dem dargebotenen Text angezeigt. Der Text kann HTML-Tags enthalten. Erst nach dem Klick auf den Button wird der Ajax-Request gestartet.|
|  button-style  | Die angegeben Eigenschaften werden dem `style`-Attribut des Buttons zugeordnet und erlauben so ein individuelles Styling.|
|  max-click     | Durch Angabe ein Zahl kann die Zahl der Klicks auf den Button beschränkt werden. Wenn die Maximalzahl erreicht ist, wird der Button ausgeblendet. Wenn as Attribut fehlt oder leer ist, gibt es keine Beschränkung der Klickzahlen.|

### Parameter in porth-timezone
Das Web-Component `<porthd-timezone>` erlaubt die Konvertierung eines Datums mit Uhrzeit einer bestimmten Zeitzone in ein Datum einer anderen Zeitzone. Laut KI sollen dabei Aspekte wie die Sommerzeit beachtet werden.
Ein Nutzungsbeispiel findet man hier in der Dokumentation in ['Examples/WebcomponentTimeZone.html'](./Examples/WebcomponentTimeZone.html)

Der Code ist per vibe-coding entstanden und wurde bisher nicht sogfältig geprüft.

**Attribute in `<porthd-timezone>`**
Die nachfolgende Tabelle beschreibt die verschiedenen unterstützten Attribute und ihre Funktion.

| Attribute       | Funktion|
|-----------------|--|
| datetime        | Attribut mit der aktuellen Zeitangabe, die in einen Zielzeit konvertiert werden soll. Wenn dies Attribut fehlt|
| to-timezone     | Definiert die Zeitzone, in welche die angebene Uhrzeit konvertiert werden soll.|
| source-timezone | Definiert die Zeitzone, in welche die angebene Uhrzeit vorliegt.|
| aria-text       | Hinweistext für Screenreader zur Funktion des Web-Components. Der Text kann auch HTML-Tags enthalten.|
| error-text      | Hinweistext, wenn ein Fehler aufgetreten ist. Der Text kann auch HTML-Tags enthalten.|
| parse-format    | Neben den gängigen ISO-Formaten kann man folgende fordefinierte Formate verwenden: 'Y-m-d', 'Y-m-d H:i', 'H:i:s', 'd.m.Y', 'm/d/Y' und 'Y-m-d H:i:s'. Auch ist die Angabe `Tag Monatsname Jahr` erlaubt, sofern eine Liste mit Monatsnamen im Attribut `month-names` hinterlegt ist.|
| month-names     | Definiert einen Liste von Monatsnamen in sortierter Reihenfolge. Man kann mehrere Listen mit allen Monaten des Jahres in sortierter Reihenfolge verketten. Folgendes ist also erlaubt: 'jan,feb.mär,apr,mai,jun,jul,aug,sep,okt,nov,dez,jan,feb.mar,apr,may,jun,jul,aug,sep,oct,nov,dec'.|



### Parameter in porthd-infomodal

#### Übersicht

`<porthd-infomodal>` ist eine benutzerdefinierte Web Component zur Darstellung modaler Dialoge mit flexibler Template-Nutzung. Sie ist für den Einsatz in Templating-Engines von Shopsystemen oder Content-Managment-systemen für Zusatzinformationen gedacht. Sie unterstützt sowohl externe als auch interne HTML-Templates für die Strukturierung der Modalinformationen und ermöglicht durch HTML-Attribute eine einfache Konfiguration.

Ein Nutzungsbeispiel findet man hier in der Dokumentation in ['Examples/WebcomponentInfomodal.html'](./Examples/WebcomponentInfomodal.html)
#### Verwendung

##### Externes Template

```html
<template id="modal-template">
  <div class="modal-content" role="dialog" aria-modal="true" tabindex="-1">
    <h2><slot name="title">Standard-Titel</slot></h2>
    <p><slot name="info"></slot></p>
    <button data-id="cancel">Schließen</button>
  </div>
</template>

<porthd-infomodal
  template-id="modal-template"
  background-class="modal-overlay"
  data-title="Hallo Welt"
  data-info="Das ist ein Testmodal.">
  <button data-id="modal-start">Modal öffnen</button>
</porthd-infomodal>
```

##### Internes Template

```html
<porthd-infomodal background-class="modal-overlay" data-title="Langtext-Test" data-info="Lorem ipsum...">
  <button data-id="modal-start">Langer Inhalt</button>
  <template>
    <div class="modal-content" role="dialog" aria-modal="true" tabindex="-1">
      <button data-id="cancel">Schließen</button>
      <h2><slot name="title"></slot></h2>
      <p><slot name="info"></slot></p>
    </div>
  </template>
</porthd-infomodal>
```

#### Attribute

##### Templates

| Attribut | Beschreibung |
|----------|--------------|
| `template-id` | ID eines externen `<template>`-Elements. Optional, falls ein internes Template vorhanden ist. |
| `<template>` | Direkt im Component-Tag eingebettet, wird bevorzugt, wenn `template-id` fehlt. |

##### Inhalte & Slots

| Attribut | Slot                                      | Beschreibung                                             |
|----------|-------------------------------------------|----------------------------------------------------------|
| `data-title` | `title`                                   | Inhalt für den `<slot name="title">`                     |
| `data-info` | `info`                                    | Inhalt für den `<slot name="info">`                      |
| Beliebig viele `data-*` | `*` ist Name  das Slots | Erlaubt dynamische Modale über benutzerdefinierte Slots. |

##### Fehlerbehandlung

| Attribut | Typ | Beschreibung                                                                                                           |
|----------|------|------------------------------------------------------------------------------------------------------------------------|
| `error-text` | `string` | Meldung bei allgemeinen Fehlern, z. B. fehlendes Template oder Startbutton                                             |
| `error-canceltext` | `string` | Meldung bei fehlendem Cancel-Button (`data-id="cancel"`)                                                               |
| `error-style` | `string` | CSS-Styling der Fehlermeldung im Frontend                                                                              |
| `error-hide` | `boolean` | Wenn gesetzt (`1`, `true`), wird die Fehlermeldung **nicht** im DOM angezeigt, sondern nur in der Konsole ausgeworfen. |

#### CSS

Die Anzeige des Modals basiert auf einer Containerklasse (z. B. `modal-overlay`) und einer internen Struktur (`modal-content`).

```css
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.6);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal-content {
  background: white;
  border-radius: 10px;
  min-width: 300px;
  max-width: 90vw;
  max-height: 90vh;
  overflow-y: auto;
  position: relative;
  padding: 2rem;
}
```

#### Tastaturnavigation

- **Escape**: Schließt das Modal.
- **Tab** und **Shift+Tab**: Navigiert innerhalb des Modals (Focus-Trap aktiv).

#### Fehleranzeige (Beispiel)

```html
<porthd-infomodal template-id="nicht-vorhanden" error-text="Template nicht gefunden!">
  <button data-id="modal-start">Fehler anzeigen</button>
</porthd-infomodal>
```

Mit `error-style`:

```html
<porthd-infomodal
  template-id="modal-template"
  error-text="Fehler!"
  error-style="background: red; color: white; font-weight: bold;">
  ...
</porthd-infomodal>
```

Mit `error-canceltext`:

```html
<porthd-infomodal error-canceltext="Cancel-Button fehlt!" ...>
```

Mit `error-hide` (nur Console-Log):

```html
<porthd-infomodal error-hide="true" ...>
```

#### Vorteile
- **Flexible Templates**: Nutzung externer und interner Templates.
- **Anpassbar**: Dynamische Inhaltsanpassung über `data-*` Attribute.
- **Barrierefreiheit**: Fokusmanagement und ARIA-Unterstützung.
- **Fehlerbehandlung**: Benutzerdefinierte Fehlermeldungen im Frontend und in der Konsole.
- **Tastaturfreundlich**: Fokusfalle für Navigation.
- **CSS-Anpassbar**: Anpassbare Stile durch `error-style` und `background-class`.
- **Template-Abhängigkeit**: Fehler bei fehlendem Template.

#### Nachteile
- **Komplexität**: Lernkurve bei der Nutzung von Templates und Fehlerbehandlung.
- **Performance**: Bei vielen Instanzen kann es zu Performance-Problemen kommen.
- **Fehlende Animationen**: Keine eingebauten Übergänge beim Öffnen/Schließen des Modals.
- **Mobile Geräte**: Eventuelle Probleme auf mobilen Geräten.

#### Erweiterungen
- **Animationen**: Hinzufügen von Animationen beim Öffnen/Schließen.
- **Modal-Typen**: Weitere Modal-Varianten (Bestätigung, Fehler, Info).
- **Größenanpassung**: Dynamische Modaldimensionen.
- **Formulare**: Einbettung von Formularen im Modal.
- **Tastenkombinationen**: Weitere Tastenkürzel zur Steuerung.
- **Mobile Optimierung**: Bessere Unterstützung für mobile Geräte.
- **Performance-Optimierung**: Lazy-Loading und DOM-Optimierungen.
- **Erweiterte Barrierefreiheit**: Weitere ARIA-Attribute und Screenreader-Unterstützung.


### Parameter in porth-breadcrumb

Das Web-Component `<porthd-breadcrumb>` wandelt eine übergebene URL (absolut oder relativ) in eine strukturierte, klickbare Breadcrumb-Navigation um.

Die einzelnen Pfade der URL werden als `<a>`-Elemente ausgegeben, die jeweils auf den Pfad bis zu dieser Ebene verlinken. Optionale Parameter, Domains und Trennzeichen lassen sich über Attribute steuern.

Ein Nutzungsbeispiel findet man hier in der Dokumentation in ['Examples/WebcomponentBreadcrumb.html'](./Examples/WebcomponentBreadcrumb.html)

#### Verwendung

```html
<porthd-breadcrumb
  href="https://example.com/dokumentation/kapitel/artikel?param=1"
  separator=" &raquo; "
  parameter-text="Details anzeigen"
  show-domain="true"
  error-text="Fehlerhafte URL">
</porthd-breadcrumb>
```

#### Attribute
| Attribut         | Typ       | Beschreibung                                                                                     | Optional | Standardwert                       |
|------------------|-----------|--------------------------------------------------------------------------------------------------|----------|------------------------------------|
| `href`           | String    | Die zu analysierende URL (absolut oder relativ).                                                 | ❌        | —                                  |
| `separator`      | String    | HTML-Inhalt als Trenner zwischen Breadcrumb-Ebenen. Kann HTML-Entities oder SVG-Code enthalten. | ✅        | `<span>&nbsp;/&nbsp;</span>`       |
| `parameter-text` | String    | Wenn gesetzt und die URL Parameter enthält (`?param=...`), wird dieser Text als letzter Link gezeigt. | ✅   | `"plus parameter"`                 |
| `show-domain`    | Boolean   | Wenn `true` oder `1`, wird die Domain als erste Breadcrumb-Ebene ausgegeben.                     | ✅        | `false`                            |
| `error-text`     | String    | Text, der angezeigt wird, wenn `href` fehlt oder keine gültige URL darstellt.                   | ✅        | `"URL missing or not valid"`       |

#### Verhalten

- **Pfad-Aufteilung:** Jeder Verzeichnisteil wird als eigene Breadcrumb-Ebene mit Link angezeigt.
- **Parameter:** Wenn die URL Parameter enthält (`?param=...`) und `parameter-text` gesetzt ist, erscheint eine zusätzliche Breadcrumb-Ebene.
- **Trennzeichen:** Über `separator` steuerbar. Standardmäßig wird ` / ` verwendet.
- **Domain:** Wenn `show-domain` aktiviert ist und eine absolute URL verwendet wird, wird die Domain (z. B. `example.com`) als erste Ebene angezeigt.
- **Ungültige URL:** Bei fehlender oder ungültiger URL erscheint `error-text` oder der Standardtext.

#### Beispiel-Ausgabe

Für folgende Komponente:

```html
<porthd-breadcrumb
  href="https://example.com/docs/kapitel/artikel?x=1"
  show-domain="true"
  parameter-text="Filter aktiv">
</porthd-breadcrumb>
```

Ergibt folgende Breadcrumb-Navigation:

```html
<a href="https://example.com">example.com</a>
<span>/</span>
<a href="https://example.com/docs/">docs</a>
<span>/</span>
<a href="https://example.com/docs/kapitel/">kapitel</a>
<span>/</span>
<a href="https://example.com/docs/kapitel/artikel/">artikel</a>
<span>/</span>
<a href="https://example.com/docs/kapitel/artikel?x=1">Filter aktiv</a>
```

#### Testfälle

Die Komponente wurde gegen folgende Tests validiert:

1. Mit absoluter URL und allen Attributen
2. Mit relativer URL und allen Attributen
3. Ohne `separator` → Standard-Trennzeichen
4. Ohne `parameter-text` → `"plus parameter"` wird angezeigt
5. Ohne `show-domain` → Domain wird nicht angezeigt
6. Ohne `error-text` → `"URL missing or not valid"` wird angezeigt
7. Ohne `href` → Fehleranzeige

#### Styling

Die Komponente verwendet kein Shadow DOM und kann somit direkt über CSS-Klassen von außen gestylt werden.

##### Beispiel:

```css
.breadcrumb a {
  color: red;
  text-decoration: none;
}
.breadcrumb span {
  margin: 0 4px;
}
.breadcrumb .error {
  color: darkred;
  font-style: italic;
}
```

#### Integration

Das Web-Component kann direkt in HTML eingebunden oder als Modul in moderne JavaScript-Frameworks integriert werden.

##### Direkt im HTML:

```html
<script>
  // Definition hier einfügen oder über externes JS-Modul einbinden
</script>
```

##### Vorteile:

- Kein Shadow DOM → vollständige Kontrolle über Styling
- Kompatibel mit statischen Seiten und Frameworks wie React, Vue oder Angular
- HTML-API: einfache Nutzung über deklarative Attribute

#### Erweiterungsmöglichkeiten

- Unterstützung für benutzerdefinierte Templates
- Mehrsprachigkeit (i18n)
- Dynamisches Nachladen der URL oder automatisches Lesen aus `window.location`

### Parameter in `PorthDCodeView`

Die Klasse `PorthDCodeView` ist eine individuelle Webkomponente, die Quellcode mit Syntax-Hervorhebung anzeigt. Sie bietet Funktionen wie **Thema-Umschaltung**, **Kopier-Button** und Unterstützung für **Zeilennummern**. Dank des **Shadow DOM** wird eine isolierte und sichere Darstellung garantiert. Die Komponente verwendet **PrismJS** zur Syntax-Hervorhebung.

Beispiele zur Nutzung finden Sie hier in der Dokumentation unter ['Examples/WebcomponentCodeview.html'](./Examples/WebcomponentCodeview.html).

---

#### Übersicht

Die `PorthDCodeView`-Klasse ist eine benutzerdefinierte `HTMLElement`-Erweiterung, die es ermöglicht, Code direkt in der eigenen Applikation hervorzuheben. Zusätzlich können Light/Dark-Themes und Zeilennummern mit wenig Aufwand konfiguriert werden.

---

#### Attribute

Die Web-Komponente unterstützt mehrere HTML-Attribute zur Konfiguration. Nachfolgend eine detaillierte Auflistung dieser Attribute:

| **Attribut**           | **Typ**       | **Erforderlich?** | **Beschreibung**                                                                                                                                                    | **Standardwert**                  |
|-------------------------|---------------|--------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------|-----------------------------------|
| `language`             | `String`      | Nein               | Gibt die Sprache des Codes an. Beispiele: `markup`, `javascript`, `php`, `css`. PrismJS-Komponenten werden entsprechend geladen.                                     | `markup`                          |
| `theme`                | `String`      | Nein               | Bestimmt das anfängliche Thema der Syntax-Hervorhebung. Werte: `light`, `dark`.                                                                                     | `light`                           |
| `line-numbers`         | `Boolean`     | Nein               | Wenn dieses Attribut gesetzt ist, werden **Zeilennummern** eingeblendet.                                                                                           | Nicht gesetzt                     |
| `button-label`         | `String`      | Nein               | Definiert den Text, der für den Kopieren-Button angezeigt wird. Beispiel: `Copy`.                                                                                   | `Copy`                            |
| `theme-button-label`   | `String`      | Nein               | Text für den Theme-Umschalter. Sollte den Zweck für Nutzer verdeutlichen. Beispiele: `🌞/🌜`, `Toggle Theme`.                                                        | `Toggle Theme`                    |
| `cdn`                  | `String`      | Nein               | Gibt die Basis-URL an, von der PrismJS und seine Komponenten geladen werden. Falls keine Angabe erfolgt, wird das offizielle CDN von PrismJS verwendet.              | `https://cdn.jsdelivr.net/npm/prismjs` |

---

#### Funktionsweise

##### 1. **Syntaxhervorhebung**
- Die Syntaxhervorhebung wird durch PrismJS umgesetzt.
- Bei der Initialisierung wird das Attribut `language` verwendet, um die richtige Sprachkomponente zu laden.
- Der Codeinhalt wird standardmäßig in ein `<code>`-Tag innerhalb eines `<pre>`-Containers eingefügt und anschließend hervorgehoben.

##### 2. **Thema-Umschaltung**
- Die Attribute `theme` und `theme-button-label` erlauben die Konfiguration eines Theme-Toggles zwischen `light` und `dark`.
- Das Umschalten des Themes wird asynchron ausgeführt, wobei das korrekt zugehörige PrismJS-CSS nachgeladen wird.

##### 3. **Zeilennummern**
- Wenn das Attribut `line-numbers` gesetzt ist, wird dem `<pre>`-Element die Klasse `line-numbers` zugewiesen.
- Zeilennummern werden mithilfe des PrismJS-Plugins automatisch generiert.

##### 4. **Kopierbutton**
- Der Text des Kopier-Buttons wird über `button-label` definiert.
- Der Button kopiert den vollständigen Codeinhalt in die Zwischenablage.

---

#### Verwendung

##### **Code-Block mit Standard-Light-Theme**
```html
<porthd-codeview language="javascript">
    <script type="text/plain">
console.log("Hallo Welt!");
    </script>
</porthd-codeview>
```

##### **Dark-Theme mit Zeilennummern und angepasstem Button-Text**
```html
<porthd-codeview language="php" theme="dark" line-numbers button-label="Kopiere Code" theme-button-label="Wechseln">
    <script type="text/plain">
<?php
echo "Hallo Welt!";
?>
    </script>
</porthd-codeview>
```

##### **Anpassen des PrismJS-CDN**
```html
<porthd-codeview language="html" cdn="https://example-cdn.com/prismjs" theme="light">
    <script type="text/plain">
<div>
    <h1>Hallo Welt!</h1>
</div>
    </script>
</porthd-codeview>
```

---

#### Methodendetails

##### `connectedCallback()`
Die Methode wird automatisch ausgeführt, wenn das Element in das DOM eingefügt wird. Sie initialisiert die Komponente, indem sie folgende Schritte ausführt:
1. **Attribute laden**: Ermittelt alle relevanten Attribute wie `theme`, `language`, etc.
2. **Shadow-DOM erstellen**: Baut sicher ein Shadow-DOM für isolierte Styles und Inhalte.
3. **PrismJS laden**, wenn es nicht verfügbar ist:
    - PrismJS-Core, Sprachkomponenten (`markup`, `javascript`, `css`) und das Plugin für Zeilennummern werden dynamisch geladen.
4. **Interne Buttons hinzufügen**:
    - Ein **Kopier-Button** wird erstellt und mit einem Event-Listener versehen, um den Code in die Zwischenablage zu kopieren.
    - Ein **Theme-Toggle-Button** schaltet das Theme und lädt die entsprechenden CSS-Dateien nach.
5. **Code übernehmen**:
    - Entweder vom `<script>`-Tag oder dem Inhalt des Tags, in dem die Komponente definiert wird.
6. **Syntax-Hervorhebung** mit PrismJS auf den Code anwenden.

##### `applyTheme(theme: string)`
Private Hilfsmethode, die das entsprechende PrismJS-Stylesheet (entweder `light` oder `dark`) basierend auf dem gewünschten `theme` lädt. Die Methode wird sowohl beim Initialisieren als auch beim Umschalten zwischen den Themen aufgerufen.

```javascript
const applyTheme = async theme => {
    const themeHref =
        theme === 'dark'
            ? `${cdnBase}/themes/prism-okaidia.css`
            : `${cdnBase}/themes/prism.css`;
    await loadCSS(themeHref);
};
```

---

#### Tests

Hier sind Beispiele, um sicherzustellen, dass die Komponente wie erwartet funktioniert:

##### **Test: Kopier-Button**
1. Richte eine `porthd-codeview`-Instanz ein und stelle sicher, dass ein Button mit der Beschriftung des `button-label` sichtbar ist.
2. Klicke auf den Button und überzeug dich, dass der Code in die Zwischenablage kopiert wurde.

##### **Test: Theme-Toggle**
1. Richte eine Instanz mit `theme="dark"` ein und überprüfe, dass das `prism-okaidia.css`-Theme geladen wird.
2. Klicke auf den Theme-Toggle-Button und überprüfe, ob das `light`-Theme geladen wird.

---

#### Einschränkungen
- Themes werden asynchron geladen, was zu kurzem Flackern führen kann.
- Benutzer müssen sicherstellen, dass PrismJS über das definierte CDN verfügbar ist.
- Nur standardmäßige Sprachkomponenten (`markup`, `javascript`, `css`) werden automatisch geladen. Zusätzliche Sprachen müssen manuell angepasst werden.
