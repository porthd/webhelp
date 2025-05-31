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

| Web-Component (intern verlinkt)                                    | slogan                                   | Aufgabe                                                                                                                                                                                                                                                                                                                      | Links                                                                                                                                                                                                                                                                                                                                                                                                     |
|--------------------------------------------------------------------|------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| [porthd-ajax](#parameter-in-porthd-ajax)                           | Content nachladen                        | Hole per HTTP-Request von einer definierten URL Daten oder HTML-Fragmente und inkludiere sie in das eigene Tag des Webcomponent. Ein Button für mehrfache Abfragen kan gesetzt werden. Gegebenenfalls kann zur Aufbereitung der Daten eine Callback ins Webcomponent eingeführt werden.                                      | [Ajax-Erläuterungen (deutsch)](https://de.wikipedia.org/wiki/Ajax_(Programmierung)) [Ajax-Erläuterungen (englisch)](https://en.wikipedia.org/wiki/Ajax_(programming))                                                                                                                                                                                                                                     |
| [porthd-bar-chart-table](#parameter-in-porthd-barchart-from-table) | Chart zu Tabelle                         | Transformiere Daten aus einer Tabelle in ein Balkendiagramm und biete dem Nutzer verschiedene Auswahlmöglichkeiten.                                                                                                                                                                                                          | ---                                                                                                                                                                                                                                                                                                                                                                                                       |
| [porthd-breadcrumb](#parameter-in-porthd-breadcrumb)               | Sprechenden Lin in Breadcrumb            | Konvertiere einen Zeit von einer Zeitzone in eine andere Zeitzone und präsentiere das Ergebnis innerhalb des Tags des Web-Component, wobei die Startzeit entwender vom Tag inkludiert sein muss oder aber im Attribut `datetime` stehen muss.                                                                                | [ Gedanken zur Breadcrumb-Navigation in Englisch](https://www.smashingmagazine.com/2009/03/breadcrumbs-in-web-design-examples-and-best-practices/) [Codebeispiel für gute Breadcrumb-Navigationshilfe in Deutsch](https://web.dev/patterns/components/breadcrumbs?hl=de)                                                                                                                                  |
| [porthd-codeview](#parameter-in-porthd-codeview)                   | Code-Ansicht                             | Es handelt sich um eine anpassbare Webkomponente zur Darstellung von Code mit Syntax-Hervorhebung, unterstützt durch Themes, Zeilennummern und die Möglichkeit, den Code in die Zwischenablage zu kopieren.                                                                                                                  | [Prism-Dokumentation in Englisch](https://prismjs.com/docs/)                                                                                                                                                                                                                                                                                                                                              |
| [porthd-icalendarevent](#parameter-in-porthd-icalendarevent)       | HTML-Event-Daten als ics-Datei anbieten  | Erstellt einen Events-Termin-Datei und wandelt eine inkludierte Liste mit Daten zu einem oder mehreren Events in eine downloadbare ics-Datei um. Die inkludierten Daten werden validiert.                                                                                                                                    | [Spezifikation](https://icalendar.org/RFC-Specifications/all/) --- [en-Wikipedia](https://en.wikipedia.org/wiki/ICalendar#:~:text=iCalendar%20ist%20ein%20Datenformat%20zum%20Austausch%20von%20Kalenderinhalten%2C,wurde%20urspr%C3%BCnglich%201998%20in%20RFC%202445%20%5B10%5D%20definiert.) --- [de-Wikipedia-Media](https://de.wikipedia.org/wiki/ICalendar#/media/Datei:ICalendarSpecification.png) |
| [porthd-infomodal](#parameter-in-porthd-infomodal)                 | Info-Popup per Template definieren       | erfordert die Definition von einem Template für das Modalfenster mit Schließen-Button und einem inkludierten Startbutton, um so die Ausgabe von einem Modal-Fenster zur Information zur Verfügung zu stellen. Über die Attribute `data-*` und gleichnamigen Slots im &lt;template&gt; sind dynamische Modal-Fenster möglich. | [Erläuterungen zu Modal-Fenstern in Deutsch](https://ichi.pro/de/4-moglichkeiten-zum-erstellen-eines-modalen-popup-felds-mit-html-css-und-vanilla-javascript-83364935438226)                                                                                                                                                                                                                              |
| [porthd-listselect](#parameter-in-porthd-listselect)               | Mega-Menüs interaktiv steuern/filtern    | Beschränkte die Ausgabe von langen verschachtelten Listen auf einen definierten Level und erlaubt die Suche verborgenen Teilüberschriften.                                                                                                                                                                                   | [Übersicht zu Menüs im Web](https://sketch.media/index.php?option=com_content&view=article&id=851) --- [Dropdown-Menü für große Verschachtelung](https://wiki.selfhtml.org/wiki/Navigation/Dropdown-Men%C3%BC) --- [Mediaevent zu Menüs](https://www.mediaevent.de/tutorial/css-responsive-menu.html)                                                                                                     |
| [porthd-tabnavi](#parameter-in-porthd-tabnavi)                     | Element mit Tab-Navigation               | Verschiebe Kind-Element in Tabs und erstelle einen Tab-Navigation               |                                                                                                                                                                                                                                                                                                           |
| [porthd-timezone](#parameter-in-porthd-timezone)                   | Zeitzoneumrechnung für Datum             | Konvertiere einen Zeit von einer Zeitzone in eine andere Zeitzone und präsentiere das Ergebnis innerhalb des Tags des Web-Component, wobei die Startzeit entwender vom Tag inkludiert sein muss oder aber im Attribut `datetime` stehen muss.                                                                                | [ Erläuterungen zur Zeitzone in Deutsch](https://www.mediaevent.de/javascript/get-timezone.html)                                                                                                                                                                                                                                                                                                          |
| [porthd-tocgenerator](#Parameter-in-porthd-tocgenerator)           | Inhaltsverzeichnis                       | Erstelle für einen definierten Block ein unnumeriertes oder nummerierte Inhaltsverzeichnis.                                                                                                                                                                                                                                  | [Artikel zum Inhaltsverzeichnis](https://ichi.pro/de/erstellen-eines-inhaltsverzeichnisses-mit-html-und-css-127834089968964)                                                                                                                                                                                                                                                                              |
| [porthd-vcard](#parameter-in-porthd-vcard)                         | HTML-Kontaktdaten als vcf-Datei anbieten | Erstelt eine Kontakt-Datei und wandelt die inkludierte Liste von Daten in eine downloadbare vcf-Datei um. Die inkludierten Daten werden validiert.                                                                                                                                                                           | [de-Wikipedia](https://de.wikipedia.org/wiki/VCard#Spezifikation) ---  [RFC6350-Spezifikation](https://www.rfc-editor.org/rfc/rfc6350)                                                                                                                                                                                                                                                                    |

## Definierter Symfony-Befehl

[TYPO3-Konsolenbefehl fox xlf-Refactoringstatistiken](#typo3-konsolenbefehl-fox-xlf-refactoringstatistiken) Erstellt Statistiken zu Aspekten des Refactorings Ihrer xlf-Dateien. (Dieser Befehl ist ab TYPO3 10.4 verfügbar.)

---

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


#### 🧪 Beispiel: Maximale Verwendung mit Styling

```html
<porthd-ajax
    url="https://example.com/data.html"
    loading-text="⏳ Daten werden geladen..."
    error-text="❌ Fehler beim Abrufen der Daten."
    callback="transformiereDaten"
    button-text="🔄 Daten neu laden"
    button-style="
        background: linear-gradient(to right, #ff6a00, #ee0979);
        color: white;
        font-size: 1.2rem;
        border: none;
        padding: 1rem 2rem;
        border-radius: 999px;
        box-shadow: 0 0 10px rgba(0,0,0,0.3);
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    "
    max-click="3">
</porthd-ajax>
```

#### 💡 Optional: Callback-Funktion
```javascript
function transformiereDaten(data) {
    return `<pre style="white-space: pre-wrap; font-family: monospace;">${data}</pre>`;
}
```
---

### Parameter in porthd-barchart-from-table

Diese Web Component wandelt eine HTML-Tabelle in ein interaktives Balkendiagramm mit **Chart.js** um. Die Anzeige ist dynamisch, flexibel und durch Checkboxen & Radiobuttons steuerbar.

#### ⚙️ Verwendete Attribute

| Attribut        | Typ     | Beschreibung                                                                 |
|-----------------|---------|------------------------------------------------------------------------------|
| `title-column`  | Number  | Index der Spalte, die als Beschriftung verwendet wird (beginnend bei 0)     |
| `value-column`  | Number  | Index der Spalte, die als Wertequelle dient                                  |
| `colors`        | String  | Komma-separierte Farbwerte                                                   |
| `orientation`   | String  | `horizontal` oder `vertical`                                                |
| `transpose`     | Flag    | Zeilen und Spalten werden getauscht                                          |
| `button-text`   | String  | Optional: Zeigt einen Button zum Ein-/Ausblenden der Tabelle                 |
| `chartjs-url`   | String  | URL zur Chart.js-Bibliothek (Standard: CDN)                                 |

#### 🧪 Beispiel: Maximale Konfiguration

```html
<porthd-barchart-from-table
  title-column="0"
  value-column="2"
  colors="crimson,orange,gold,forestgreen,dodgerblue,purple"
  orientation="horizontal"
  transpose
  button-text="📋 Tabelle anzeigen/ausblenden"
  chartjs-url="https://cdn.jsdelivr.net/npm/chart.js"
>
  <table>
    <thead>
      <tr><th>Produkt</th><th>Januar</th><th>Februar</th><th>März</th></tr>
    </thead>
    <tbody>
      <tr><td>Apfel</td><td>120</td><td>150</td><td>180</td></tr>
      <tr><td>Birne</td><td>90</td><td>130</td><td>160</td></tr>
      <tr><td>Kirsche</td><td>70</td><td>110</td><td>140</td></tr>
    </tbody>
  </table>
</porthd-barchart-from-table>
```

#### 🎨 Dynamisches Styling

- Jeder Balken kann mit einer Farbe aus der `colors`-Liste gestylt werden
- `button-text` zeigt einen Toggle-Button für die Tabelle
- Die Tabelle wird geklont und im Shadow DOM dargestellt

#### ✨ Features

- **Automatisches Laden** von Chart.js, wenn es nicht bereits verfügbar ist
- **Checkboxen** zur Auswahl von Zeilen oder Spalten
- **Radiobuttons** zur Auswahl der Wertequelle (Spalte oder Zeile)
- **Responsives Layout**, orientierbar an X- oder Y-Achse
- **Volle Kontrolle** über Anzeige durch Attribute

#### 🧠 Hinweise

- Die Komponente benutzt Shadow DOM – Styles müssen inline oder per JS gesetzt werden.
- Die Tabelle im Light DOM bleibt erhalten – Änderungen dort wirken sich nicht automatisch aus.
- Du kannst `chartjs-url` setzen, wenn du eine bestimmte Chart.js-Version laden willst.

#### 📌 Mögliche Erweiterungen

- Unterstützung für mehrere Datensätze
- Export-Funktion (PNG/SVG)
- Dynamische Farbpaletten je nach Wert
- Tooltip-Anpassung

---

### Parameter in porthd-breadcrumb

Die Webkomponente `<porthd-breadcrumb>` generiert eine breadcrumb-Navigation basierend auf einer angegebenen URL. Sie unterstützt dynamische Styling-Optionen, Callback-Verarbeitung und Anzeige von Domaininformationen.

#### Beispielhafte Verwendung

```html
<porthd-breadcrumb
    href="https://example.com/produkte/kategorie/item123?ref=abc"
    separator=" &gt; "
    show-domain="true"
    parameter-text="mit Parametern"
    error-text="Ungültige URL"
    callback="formatBreadcrumbLabel">
</porthd-breadcrumb>
```

##### Beispielhafter Callback im Fenster-Kontext:

```js
window.formatBreadcrumbLabel = function(text) {
    return text.replace(/-/g, ' ').toUpperCase();
};
```

#### Erklärung der Attribute

| Attribut         | Beschreibung                                                                 |
|------------------|------------------------------------------------------------------------------|
| `href`           | Die URL, aus der der Breadcrumb generiert wird. Muss gültig sein.            |
| `separator`      | HTML-Inhalt als Trennzeichen zwischen Breadcrumb-Elementen. Standard: `/`    |
| `show-domain`    | `true` oder `1`, um die Domain als erstes Element anzuzeigen.                |
| `parameter-text` | Text, der angezeigt wird, wenn URL-Parameter vorhanden sind.                |
| `error-text`     | Text, der angezeigt wird, wenn die URL ungültig ist.                         |
| `callback`       | Name einer Funktion im globalen Scope, die Pfadsegmente modifizieren kann.  |

#### Dynamisch generierter HTML-Code

##### Beispielausgabe bei aktivierter Domainanzeige und URL-Parametern:

```html
<span class="breadcrumb">
  <a href="https://example.com">example.com</a>
  <span>&nbsp;/&nbsp;</span>
  <a href="https://example.com/produkte/">PRODUKTE</a>
  <span>&nbsp;/&nbsp;</span>
  <a href="https://example.com/produkte/kategorie/">KATEGORIE</a>
  <span>&nbsp;/&nbsp;</span>
  <a href="https://example.com/produkte/kategorie/item123/">ITEM123</a>
  <span>&nbsp;/&nbsp;</span>
  <a href="https://example.com/produkte/kategorie/item123?ref=abc">mit Parametern</a>
</span>
```

#### Styling-Hinweis

Die Komponente fügt dem Container standardmäßig die Klasse `breadcrumb` hinzu. Beispielhaftes CSS:

```css
.breadcrumb {
    font-family: sans-serif;
    font-size: 0.9rem;
}

.breadcrumb a {
    text-decoration: none;
    color: #0366d6;
}

.breadcrumb a:hover {
    text-decoration: underline;
}

.breadcrumb span {
    margin: 0 4px;
    color: #aaa;
}

.breadcrumb .error {
    color: red;
}
```

Diese Komponente eignet sich hervorragend, um dynamisch Pfadnavigationen für Webanwendungen zu erzeugen, besonders bei CMS- oder SPA-Systemen.

---

---

### Parameter in porthd-codeview

Diese Dokumentation zeigt ein maximales Beispiel für die Ausgabe des dynamisch generierten Codes der Webkomponente `<porthd-codeview>` inklusive aller Styling-Elemente und interaktiven Features.

#### Beispiel-HTML zur Nutzung der Komponente

```html
<porthd-codeview
  language="javascript"
  theme="dark"
  line-numbers
  button-label="Copy Code"
  theme-button-label="Switch Theme"
  cdn="https://cdn.jsdelivr.net/npm/prismjs"
>
  <script type="text/plain">
    // Beispielhafter JavaScript-Code
    function greet(name) {
      console.log(`Hello, ${name}!`);
    }
    greet('World');
  </script>
</porthd-codeview>
```

#### Dynamisch generierter DOM-Inhalt (Shadow DOM)

Nach dem Einfügen der Komponente wird der folgende DOM-Abschnitt im Shadow DOM generiert:

```html
<style>
  :host {
    display: block;
    position: relative;
  }
  button {
    position: absolute;
    top: 0.5em;
    right: 0.5em;
    margin: 0 0.5em;
    z-index: 1;
    padding: 0.5em 1em;
    cursor: pointer;
  }
  pre {
    margin: 0;
    border: 1px solid #ddd;
    border-radius: 5px;
    overflow: auto;
  }
</style>
<button class="theme-toggle">Switch Theme</button>
<button class="copy-button" style="right: 2.5em;">Copy Code</button>
<pre class="line-numbers"><code class="language-javascript">
// Beispielhafter JavaScript-Code
function greet(name) {
  console.log(`Hello, ${name}!`);
}
greet('World');
</code></pre>
```

#### Funktionen

- Syntax-Highlighting mit Prism.js (dynamisch geladen)
- Umschalten zwischen `light` und `dark` Theme
- Zeilennummern über Plugin
- Kopierfunktion mit Feedback (✓)
- Unterstützung für mehrere Sprachen über `<script type="text/plain">`

#### Styling-Details

Die Buttons werden absolut über dem Codeblock positioniert. Das Theme kann dynamisch gewechselt werden, indem unterschiedliche CSS-Dateien von Prism eingebunden werden.

#### Hinweis

PrismJS und Plugins werden nur geladen, wenn sie nicht bereits vorhanden sind.

ℹ️ Oben ist ein vollständiges Beispiel für die maximal generierte Struktur dieser Komponente zu sehen.

---

### Parameter in porthd-icalendarevent

Dieses Beispiel zeigt eine vollständige Verwendung der Webkomponente `<porthd-icalendarevent>`, inklusive maximal generiertem dynamischen iCalendar-Code, validierten Datenfeldern und eingebautem Styling.

#### Beispiel HTML

```html
<porthd-icalendarevent
  button-label="iCal herunterladen"
  button-style="background: green; color: white; padding: 12px 20px; border-radius: 6px; border: none;"
  file-name="mein-event"
  prodid="-//Beispiel Firma//iCal Generator//DE">

  <div data-id="UID">123e4567-e89b-12d3-a456-426614174000</div>
  <div data-id="DTSTAMP">20250415T120000Z</div>
  <div data-id="DTSTART">20250501T090000Z</div>
  <div data-id="DTEND">20250501T100000Z</div>
  <div data-id="SUMMARY">Meeting mit Team</div>
  <div data-id="DESCRIPTION">Besprechung der Q2-Ziele und Strategie</div>
  <div data-id="LOCATION">Konferenzraum A</div>
  <div data-id="STATUS">CONFIRMED</div>
  <div data-id="CLASS">PUBLIC</div>
  <div data-id="ORGANIZER" data-cn="Max Mustermann">mailto:max@example.com</div>
  <div data-id="ATTENDEE" data-role="REQ-PARTICIPANT" data-cn="Erika Beispiel">mailto:erika@example.com</div>

</porthd-icalendarevent>
```

#### Erläuterung

- Das Button-Styling kann über `button-style` angepasst werden.
- Das Attribut `prodid` legt die PRODUKT-ID des iCalendar-Exports fest.
- Jeder `data-id` Container repräsentiert eine iCalendar-Zeile. Weitere Parameter werden über `data-` Attribute hinzugefügt.

#### Generierter iCal-Inhalt

Wenn korrekt verwendet, wird beim Klick auf den Button ein `.ics`-Dateidownload erzeugt mit folgendem Muster:

```ics
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//Beispiel Firma//iCal Generator//DE
BEGIN:VEVENT
UID:123e4567-e89b-12d3-a456-426614174000
DTSTAMP:20250415T120000Z
DTSTART:20250501T090000Z
DTEND:20250501T100000Z
SUMMARY:Meeting mit Team
DESCRIPTION:Besprechung der Q2-Ziele und Strategie
LOCATION:Konferenzraum A
STATUS:CONFIRMED
CLASS:PUBLIC
ORGANIZER;CN=Max Mustermann:mailto:max@example.com
ATTENDEE;ROLE=REQ-PARTICIPANT;CN=Erika Beispiel:mailto:erika@example.com
END:VEVENT
END:VCALENDAR
```
#### Erklärung zu Parametern

**Tabelle mit den erlaubten data-id`s für inkludierte Elemente**

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

#### Erklärung zu Attributen
Dieses Webcomponent bringt vier Attribute mit. Zwei dienen der Definition des Buttons, eines der ProdID für den iCalendar-Eintrag

| Attribute    | Funktion |
|--------------|-- |
|button-label | Text des Buttons, wobei der TEXT auch HTML- und SVG-Tags enhalten kann. |
|button-style | CSS-Eigenschaften für das style-Element des Buttons im Shadow-DOM |
|file-name    | Name für die Datei, die heruntergeladen wird; wobei die Endung '.ics' immer angefügt wird. |
|prodid       | Identifier für die Generierung der iCalendar-Datei. Dieser Eintrag ist nicht genormt. |

#### Fehlerbehandlung

Die Komponente prüft automatisch auf erforderliche Felder (`UID`, `DTSTAMP`, `DTSTART`, `SUMMARY`) und meldet Fehler in einem `alert`-Fenster.

---

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

---

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

---

### Parameter in porthd-tabnavi

#### Übersicht

`<porthd-tabnavi>` ist ein benutzerdefiniertes HTML-Webcomponent, das eingebettete Inhalte auf Basis eines strukturellen Markers (`startpanel`) in responsive Tabs umwandelt. Es bietet erweiterte Steuerung durch Attribute, automatische Benennung, Styling-Optionen und dynamisches CSS-Injektionsverhalten.

#### Funktionsweise

Beim Einfügen eines `<porthd-tabnavi>`-Elements in das DOM wird:

1. Das definierte `startpanel`-Element gesucht (z.B. `h2`, `.tab`, etc.).
2. Alle Kind-Elemente anhand dieser Markierung in Panels gruppiert.
3. Eine Navigation aus Buttons (`<button>`) in einem `<nav>` erzeugt.
4. Die Panels mit zugehöriger ID versehen und entsprechend gesteuert (anzeigen/verstecken).
5. Optional ein Tab als Starttab festgelegt oder automatisch der erste Tab angezeigt.
6. Die Tabnavigation bei nur einem Tab ausgeblendet.
7. Styles dynamisch injiziert, sofern noch nicht vorhanden.

#### Attribute

| Attribut       | Pflicht | Typ      | Beschreibung |
|----------------|---------|----------|--------------|
| `startpanel`   | ✅ Ja    | `string` | Selektor (z.B. `h2`, `.tab`) zur Definition von Startpunkten für neue Panels. |
| `name`         | ❌ Nein | `string` | Name für die Tab-IDs (`name-0`, `name-1`, …). Wenn nicht gesetzt, wird ein zufälliger Name generiert. |
| `listclass`    | ❌ Nein | `string` | CSS-Klassen für die Tab-Navigation (`<nav>`). |
| `liststyle`    | ❌ Nein | `string` | Inline-Styling für die Tab-Navigation. |
| `tabclass`     | ❌ Nein | `string` | CSS-Klasse für Tab-Buttons. |
| `tabstyle`     | ❌ Nein | `string` | Inline-Styling für Tab-Buttons. |
| `panelclass`   | ❌ Nein | `string` | CSS-Klasse für Panel-Container. |
| `panelstyle`   | ❌ Nein | `string` | Inline-Styling für Panel-Container. |

#### Zusätzliche Steuerattribute

| Attribut am Startpanel | Beschreibung |
|------------------------|--------------|
| `tabname`              | Optionaler benutzerdefinierter Titel für den Tab. |
| `starttab`             | Wenn gesetzt (auch leer oder `1`), wird dieses Panel beim Laden angezeigt. |

#### Verhalten bei Sonderfällen

| Fall | Verhalten |
|------|-----------|
| `startpanel` fehlt | Fehlermeldung in der Konsole, Inhalt bleibt unverändert. |
| Kein gültiges Element für `startpanel` | Fehlermeldung, Inhalt bleibt unverändert. |
| Inhalte **vor dem ersten startpanel** | In einem separaten Tab mit Titel `default` gruppiert. Warnung in der Konsole. |
| Kein Panel mit `starttab` | Der erste Tab wird automatisch aktiviert. |
| Nur ein Panel erzeugt | Tabnavigation wird **nicht** eingeblendet. |

#### Beispiele

##### Beispiel 1: Fehlendes `startpanel`
```html
<porthd-tabnavi>
    <div>Dies ist Inhalt ohne startpanel</div>
</porthd-tabnavi>
```

##### Beispiel 2: Drei `div`s, `startpanel="h2"`
```html
<porthd-tabnavi startpanel="h2" name="demo2">
    <h2 tabname="Tab A">Titel A</h2>
    <div>Inhalt A</div>
    <h2 tabname="Tab B">Titel B</h2>
    <div>Inhalt B</div>
    <h2 tabname="Tab C">Titel C</h2>
    <div>Inhalt C</div>
</porthd-tabnavi>
```

##### Beispiel 3: Struktur mit `starttab`
```html
<porthd-tabnavi startpanel="h2" name="demo3">
    <div>Intro-Text</div>
    <h2 tabname="Start 1" starttab>Panel 1</h2>
    ...
</porthd-tabnavi>
```

#### Dynamische CSS-Injektion

Wird automatisch ins `<head>` eingefügt, falls noch nicht vorhanden:

```css
porthd-tabnavi nav.tablist {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
  margin-bottom: 1rem;
}
porthd-tabnavi nav.tablist button {
  cursor: pointer;
  padding: 0.5rem 1rem;
}
porthd-tabnavi nav.tablist button.active {
  background-color: #ddd;
  font-weight: bold;
}
porthd-tabnavi .tabpanel {
  display: none;
}
porthd-tabnavi .tabpanel.active {
  display: block;
}
```

#### DOM-Struktur nach Initialisierung

```html
<porthd-tabnavi>
  <nav class="tablist">
    <button class="active" data-tab="name-0">Tab A</button>
    <button data-tab="name-1">Tab B</button>
    ...
  </nav>
  <div id="name-0" class="tabpanel active">...</div>
  <div id="name-1" class="tabpanel">...</div>
</porthd-tabnavi>
```

#### Methodenübersicht

| Methode                  | Funktion |
|--------------------------|----------|
| `connectedCallback()`    | Initialisiert die Komponente beim Einfügen ins DOM |
| `_injectStylesIfNeeded()`| Fügt CSS ein, falls noch nicht vorhanden |
| `_checkCSSClass()`       | Prüft vorhandene Stylesheets |
| `_showTab(id)`           | Aktiviert Tab und Panel |
| `_generateRandomName()`  | Erstellt eindeutigen Namen |
| `_getTabName(el, index)` | Liefert Tab-Namen oder Fallback |

#### Accessibility (a11y)

- `role="tablist"`, `role="tab"`, `role="tabpanel"`
- ARIA-Verbesserungen möglich


---

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

---

### Parameter in Porthd-TocGenerator

Eine benutzerdefinierte Web Component zur dynamischen Erstellung eines Inhaltsverzeichnisses (Table of Contents, TOC) aus HTML-Überschriften (`h1` bis `h6`) innerhalb eines bestimmten DOM-Blocks.
Das Web Component sollte leer sein, weil der Platz für das dynamisch generierte Inhaltsverzeichnis vorgesehen ist.

#### Features

- Unterstützt alle Überschriftenebenen von `h1` bis `h6`
- Verschachtelte Liste je nach Ebenentiefe
- Optionale Kapitelnummerierung (`add-number`)
- Startnummerierung via `chapter-start`
- Mehrere TOCs pro Seite möglich
- Fehlerbehandlung mit anpassbarem Text & CSS
- Unterstützt dynamische Änderungen durch Attribut `rebuild`

#### Verwendung

```html
<porthd-tocgenerator
  block="#mein-inhalt"
  add-number="true"
  chapter-start="1.0.0.0.0.0"
  pretext="mein_anker_"
  error-text="<strong>Fehler:</strong> Überschriften nicht gefunden."
  error-style="color: red; font-style: italic;"
></porthd-tocgenerator>
```

```html
<div id="mein-inhalt">
  <h2>Einleitung</h2>
  <h3>Motivation</h3>
  <h2>Hauptteil</h2>
</div>
```

#### Attribute-Referenz

| Attribut       | Typ      | Beschreibung                                                                 |
|----------------|----------|------------------------------------------------------------------------------|
| `block`        | CSS-Selector | Ziel-Container, aus dem die Überschriften gelesen werden. Standard: `body`. |
| `add-number`   | `true/false` | Aktiviert Kapitelnummerierung. Standard: `false`.                          |
| `chapter-start`| `X.X.X.X.X.X` | Startpunkt der Nummerierung (nur bei `add-number=true`).                  |
| `pretext`      | String   | Präfix für Anchor-IDs. Ermöglicht mehrere TOCs gleichzeitig.               |
| `error-text`   | HTML     | Optionaler HTML-Fehlertext, wenn kein Block oder keine Überschrift gefunden wird. |
| `error-style`  | CSS      | Inline-CSS-Styles für das Fehler-DIV.                                       |
| `rebuild`      | beliebig | Bei jeder Änderung dieses Attributs wird das TOC neu aufgebaut.            |

#### Dynamisches Rebuild

Wenn sich der DOM innerhalb des Ziel-Blocks ändert (z.B. neue Überschrift per Button), kann das TOC durch Setzen des `rebuild`-Attributs neu aufgebaut werden:

```js
const toc = document.querySelector('#mein-toc');
toc.setAttribute('rebuild', Date.now().toString());
```

#### Anchor-Verhalten

Jede Überschrift erhält ein unsichtbares `<span>`-Element mit einer eindeutigen ID als Anker. Diese ID setzt sich zusammen aus:

```
[pretext][zufälligerTeil]_[laufendeNummer]
```

Beispiel: `mein_anker_kd93kfj2_0`

#### Fehlerbehandlung

Wird der `block` nicht gefunden oder enthält keine Überschriften, wird ein `<div>` mit dem Fehlertext angezeigt. Sowohl Inhalt (`error-text`) als auch Stil (`error-style`) sind vollständig anpassbar.

#### Styling

Die TOC-Liste nutzt die Klasse `toc`. Eigene CSS-Regeln können dafür definiert werden:

```css
ul.toc {
  list-style: none;
  padding-left: 1em;
}
ul.toc li {
  margin-bottom: 0.3em;
}
```

#### Test-Setup

Mehrere Testfälle können gleichzeitig auf einer HTML-Seite getestet werden. Achte bei mehreren TOCs auf unterschiedliche `pretext`-Werte, um ID-Kollisionen zu vermeiden.

---

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

---

## Definierte symfony Kommandos dür die Konsole


### TYPO3-Konsolenbefehl fox xlf-Refactoringstatistiken

#### Übersicht

Dieses TYPO3-Konsolenkommando analysiert `.xlf`-Sprachdateien und durchsucht alle Dateien eines angegebenen Startordners, um die Nutzung von Sprach-Keys statistisch auszuwerten. Das Kommando generiert eine CSV-Datei mit verschiedenen Kennzahlen zur Nutzung, Duplizierung und Nichtverwendung von Keys.

Es wird angenommen, dass der Nutzer die CSV-Datei mit einer Tabellekalkulation wie Excel (Microsoft) oder calc (LibriOffice) untersucht.

Hinweis: Der Nutzer sollte die erstellte CSV-Datei aus Sicherheitsgründen aus dem Untersuchungsordner löschen.


#### Befehl

```bash
vendor/bin/typo3 extension:xlf-statistics /pfad/zum/startordner [--extensionlist=ext1,ext2,...]
```

##### Parameter

| Parameter | Typ | Beschreibung |
|----------|-----|--------------|
| `path` | Argument (erforderlich) | Pfad zum Startordner |
| `--extensionlist` | Option (optional) | Kommagetrennte Liste von Dateierweiterungen, in denen Keys gezählt werden sollen.<br>**Standard:** `html,htm,php,js,txt,typoscript,tsconfig,flex,t3s,t3c` |

#### Beschreibung der Analyse

##### Was wird analysiert?

1. Alle `.xlf`-Dateien im angegebenen Verzeichnisbaum (rekursiv).
2. Automatische Erkennung der unterstützten Sprachen anhand des Dateinamens.
3. Jede gefundene `trans-unit` mit einem `id`-Attribut wird gezählt – auch bei Mehrfachvorkommen.
4. Alle anderen Dateien im Projektverzeichnis werden nach diesen Keys durchsucht.

##### Sprachdateibenennung

- `locallang.xlf` → default-Sprache
- `de.locallang.xlf` → deutsche Sprachvariante
- `en.locallang.xlf` → englisch usw.

#### Struktur der CSV-Datei

Die erzeugte Datei hat den Namen:

```
xlf-statistic_YYYY-MM-DD-HH-MM-SS.csv
```

##### Spaltenübersicht

| Spalte | Beschreibung |
|--------|--------------|
| `path` | Pfad zur ursprünglichen XLF-Datei |
| `basename` | Basename: `dateiname:key` |
| `{language}` | Je eine Spalte pro Sprache – Anzahl der Vorkommen in dieser Sprachdatei |
| `{extension}` | Je eine Spalte pro definierter Extension – Anzahl der Vorkommen im jeweiligen Dateityp |
| `otherExtension` | Anzahl der Vorkommen in Dateien mit nicht gelisteter Extension |
| `countAll` | Summe der Vorkommen in allen Nicht-XLF-Dateien |
| `unused` | Zeigt `"Löschen?"`, wenn `countAll == 0`, sonst leer |
| `doubleUse` | Zeigt `"Reduzieren"`, wenn der Key in einer Sprachdatei mehrfach vorkommt |

#### Beispiele

##### Standardaufruf

```bash
vendor/bin/typo3 extension:xlf-statistics /var/www/html
```

##### Mit eigener Extension-Liste

```bash
vendor/bin/typo3 extension:xlf-statistics /var/www/html --extensionlist=php,html,twig
```

#### Hinweise für Entwickler

- Der Befehl nutzt `simplexml_load_file()` zur Analyse der XML-Dateien.
- Die Ausführung kann bis zu **30 Minuten** dauern (`set_time_limit(1800)`).
- Keys werden exakt anhand des Vorkommens im Dateitext gezählt (kein Parsing/Tokenizing).
- Die Datei wird im Zielverzeichnis gespeichert.

#### Letzte Aktualisierung

2025-05-31

---
