# Extension Webhelp
##Hinweis
Die Extension ist aktuell noch in der Experimentierphase.
Die Webcomponents sind noch nicht sher ausgereift. Für Verbesserungsvorschläge werde ich mich freuen.
Wenn sie eigenen Code für WebComponets haben, berücksichtige ich den gern in dieser Extension.
Email: info@mobger.de


## Was ist das Ziel der Extension
Es stellt für Integratoeren Viewhelper zur Verfügung,
die ihrerseits die Nutzung von  WebComponents erlauben.
Web-Componets eignen, um
- Adressdaten als VCard zum Download anzubieten
- Events als ICalendar-Datei zum Download anzubieten
- Kontaktdaten als VCard-Datei zum Download anzubieten
- einfach Popup-Fenster zu,m Beispiel für Hilfsteste zu integrieren
- ....

## Installation
Durch Herunterladen oder via composer installieren sie die Extension. Anschließend aktivieren sie diese.
TypoScript braucht dieser Service nicht.

## Viewhelper
Aktuell sind zwei Viewhelper definiert. Im Fluid-Template können sie das Prääfix `webhelp:` verwenden.

### EasyIcalendar für ICS-Dateien
`<webhelp:easyIcalendar>` erlaubt das Erzeugen einer ICS-Datei. Sie können die notwendigen Angaben einzeln, als JSON-String oder als Fluid-Array/Modell übergeben.
#### Beispiel-Code im Fluid
```

<!-- TYPO3-Fluidtemplate:-->
<!-- ==================== -->
<div>
    <webhelp:easyICalendar
            description="Meine Beschreibung2"
            location="Mein Ort2"
            organizer="IchSchauWeg"
            contact="info@mobger.de"
            summary="Test2"
            url="Irgendwo im Universum2"
            dateStart="1995-12-17T03:24:00"
            dateEnd="1995-12-17T05:24:00"
            fileName="Klaus2.ics"
    >
        Mein Event (Limits)
    </webhelp:easyICalendar>
    Mein Event (EndDate)
</div>

<!-- Output (Frontend-HTML / Firefox):-->
<!-- ==================== -->
<div>
    <easy-icalendar eventJson="{&quot;description&quot;:&quot;Meine Beschreibung2&quot;,&quot;location&quot;:&quot;Mein Ort2&quot;,&quot;summary&quot;:&quot;Test2&quot;,&quot;uid&quot;:&quot;Irgendwo im Universum2&quot;,&quot;url&quot;:&quot;Irgendwo im Universum2&quot;,&quot;dateStart&quot;:&quot;19951217T022400&quot;,&quot;dateEnd&quot;:&quot;19951217T042400&quot;,&quot;duration&quot;:&quot;&quot;,&quot;organizer&quot;:&quot;IchSchauWeg&quot;,&quot;contact&quot;:&quot;info@mobger.de&quot;,&quot;fileName&quot;:&quot;&quot;}">
        Mein Event (Limits)
    </easy-icalendar>
    Mein Event (EndDate)
</div>


<!-- TYPO3-Fluidtemplate:-->
<!-- ==================== -->
<div>
    <webhelp:easyICalendar
            description="Meine Beschreibung"
            location="Mein Ort"
            organizer="IchSchauWeg"
            contact="info@mobger.de"
            summary="Test"
            url="Irgendwo im Universum"
            dateStart="1995-12-17T03:24:00"
            dateEnd=""
            duration="PT12H"
            fileName="Klaus.ics"
    >
        Mein Event (Duration)
    </webhelp:easyICalendar>
</div>

<!-- Output (Frontend-HTML / Firefox):-->
<!-- ==================== -->
<div>
    <easy-icalendar eventJson="{&quot;description&quot;:&quot;Meine Beschreibung&quot;,&quot;location&quot;:&quot;Mein Ort&quot;,&quot;summary&quot;:&quot;Test&quot;,&quot;uid&quot;:&quot;Irgendwo im Universum&quot;,&quot;url&quot;:&quot;Irgendwo im Universum&quot;,&quot;dateStart&quot;:&quot;19951217T022400&quot;,&quot;dateEnd&quot;:&quot;&quot;,&quot;duration&quot;:&quot;PT12H&quot;,&quot;organizer&quot;:&quot;IchSchauWeg&quot;,&quot;contact&quot;:&quot;info@mobger.de&quot;,&quot;fileName&quot;:&quot;&quot;}">
        Mein Event (Duration)
    </easy-icalendar>
</div>


<!-- TYPO3-Fluidtemplate:-->
<!-- ==================== -->
<div>
    <webhelp:easyICalendar
            fluidData="{description:'Meine Beschreibung2',
                                    location:'Mein Ort2',
                                    summary:'Test2',
                                    url:'Irgendwo im Universum2',
                                    dateStart:'1995-12-17T03:24:00',
                                    dateEnd:'1995-12-17T05:24:00',
                                    duration:'',
                                    organizer:'IchSchauWeg',
                                    fileName:'Klaus2.ics',
                        contact:'info@mobger.de'}"
    >
        Mein Event (FluidData)
    </webhelp:easyICalendar>
</div>

<!-- Output (Frontend-HTML / Firefox):-->
<!-- ==================== -->
<div>
    <easy-icalendar eventJson="{&quot;description&quot;:&quot;Meine Beschreibung2&quot;,&quot;location&quot;:&quot;Mein Ort2&quot;,&quot;summary&quot;:&quot;Test2&quot;,&quot;uid&quot;:&quot;Irgendwo im Universum2&quot;,&quot;url&quot;:&quot;Irgendwo im Universum2&quot;,&quot;dateStart&quot;:&quot;19951217T022400&quot;,&quot;dateEnd&quot;:&quot;19951217T042400&quot;,&quot;duration&quot;:&quot;&quot;,&quot;organizer&quot;:&quot;IchSchauWeg&quot;,&quot;contact&quot;:&quot;info@mobger.de&quot;,&quot;fileName&quot;:&quot;&quot;}">
        Mein Event (FluidData)
    </easy-icalendar>
</div>


<!-- TYPO3-Fluidtemplate:-->
<!-- ==================== -->
<div>
    <!-- prohibit Fluid from building an array from JSON -->
    <f:alias map="{jsonOneFluid: '{\" description\":\"Meine Beschreibung2\",\"location\":\"Mein Ort2\",\"summary\":\"Test2\",',
                   jsonTwoFluid :'\"url\":\"Irgendwo im Universum2\",\"dateStart\":\"1995-12-17T03:24:00\",\"dateEnd\":\"1995-12-17T05:24:00\",\"duration\":\"\",\"organizer\":\"IchSchauWeg\",\"fileName\":\"Klaus2.ics\",\"contact\":\"info@mobger.de\"}'}">
    <webhelp:easyICalendar
            jsonData="{jsonOneFluid}{jsonTwoFluid}"
    >
        Mein Event (JsonData)
    </webhelp:easyICalendar>
    </f:alias>
</div>

<!-- Output (Frontend-HTML / Firefox):-->
<!-- ==================== -->
<div>
    <!-- prohibit Fluid from building an array from JSON -->

    <easy-icalendar eventJson="{&quot;description&quot;:&quot;Test2&quot;,&quot;location&quot;:&quot;Mein Ort2&quot;,&quot;summary&quot;:&quot;Test2&quot;,&quot;uid&quot;:&quot;Irgendwo im Universum2&quot;,&quot;url&quot;:&quot;Irgendwo im Universum2&quot;,&quot;dateStart&quot;:&quot;19951217T022400&quot;,&quot;dateEnd&quot;:&quot;19951217T042400&quot;,&quot;duration&quot;:&quot;&quot;,&quot;organizer&quot;:&quot;IchSchauWeg&quot;,&quot;contact&quot;:&quot;info@mobger.de&quot;,&quot;fileName&quot;:&quot;&quot;}">
        Mein Event (JsonData)
    </easy-icalendar>
</div>
```
### EasyVCard für ICS-Dateien
`<webhelp:easyVCard>` erlaubt das Erzeugen einer ICS-Datei. Sie können die notwendigen Angaben einzeln, als JSON-String oder als Fluid-Array/Modell übergeben. Die Verwendeun ist analog wie oben bei `<webhelp:easyIcalendar>`.
#### Beispiel-Code im Fluid
```
<!-- example input (TYPO3-template)-->
<!-- ===================================== -->
     <webhelp:easyVCard
                                n="Porth;Dieter;;Dr;"
                                fn="Dr. Dieter Porth"
                                adr="{first:';;Grünenstraße 23;Bremen;;28199;Germany'}"
                                adrtype="{first:'TYPE=home;LABEL=\"Grünenstraße 23\n28199 Bremen\nDeutschland\"'}"
                        email="info@mobger.de"
                        tel="{first: 'tel:049-421-51483548', second:'+49-160-99180688'}"
                        teltype="{first:'TYPE=home,voice',second:'TYPE=mobile,voice'}"
                        url="https://www.düddelei.de"
                        uid="https://www.mobger.de/"
                        role="TYPO3-Developer"
     >
         my Imprint (detailData needed)
     </webhelp:easyVCard>

<!-- example output-->
<!-- ===============================-->
    <easy-vcard eventJson="{&quot;n&quot;:&quot;Porth;Dieter;;Dr;&quot;,&quot;uid&quot;:&quot;https:\/\/www.d\u00fcddelei.de&quot;,&quot;email&quot;:&quot;info@mobger.de&quot;,&quot;fn&quot;:&quot;Dr. Dieter Porth&quot;,&quot;geo&quot;:&quot;&quot;,&quot;logo&quot;:&quot;&quot;,&quot;note&quot;:&quot;&quot;,&quot;org&quot;:&quot;private&quot;,&quot;photo&quot;:&quot;&quot;,&quot;role&quot;:&quot;TYPO3-Developer&quot;,&quot;tz&quot;:&quot;&quot;,&quot;url&quot;:&quot;https:\/\/www.d\u00fcddelei.de&quot;,&quot;adr&quot;:[&quot;;TYPE=TYPE=home;LABEL=\&quot;Gr\u00fcnenstra\u00dfe 23\\n28199 Bremen\\nDeutschland\&quot;:;;Gr\u00fcnenstra\u00dfe 23;Bremen;;28199;Germany&quot;],&quot;key&quot;:&quot;&quot;,&quot;keytype&quot;:&quot;&quot;,&quot;tel&quot;:[&quot;;MEDIATYPE=TYPE=mobile,voice:+49-160-99180688&quot;,&quot;;MEDIATYPE=TYPE=home,voice:tel:049-421-51483548&quot;],&quot;filename&quot;:&quot;&quot;}">
         my Imprint (detailData needed)
     </easy-vcard>
```
### EasyTextLogo für Logo-basierte Popups
`<webhelp:easyTextLogo>` erwartet einen (HTML-)Text und den Pfad zu einem Logo.
Fehlt ein Logo, wird das Stopshild als default-Logo verwendet.
#### Beispiel-Code im Fluid
```
<!-- TYPO3-Fluidtemplate:-->
<!-- ==================== -->
<div>
    <webhelp:EasyTextLogo
            value="Hallo Welt, morgen sind wir schon weiter. Heute stehen wir vor dem Abgrund; die Hungerkriege haben längst begonnen, wie die Corona-Maßnahmen in den Entwicklungsländern zeigen."
            logopath="EXT:webhelp/Resources/Public/Icons/Cursor/DownloadCursor.svg"
    />
</div>

<!-- Output (Frontend-HTML / Firefox):-->
<!-- ==================== -->
<div>
    <popup-info
            value="Hallo Welt, morgen sind wir schon weiter. Heute stehen wir vor dem Abgrund; die Hungerkriege haben längst begonnen, wie die Corona-Maßnahmen in den Entwicklungsländern zeigen."
            logopath="EXT:webhelp/Resources/Public/Icons/Cursor/DownloadCursor.svg"
            my-text-json="&quot;Hallo Welt, morgen sind wir schon weiter. Heute stehen wir vor dem Abgrund; die Hungerkriege haben l\u00e4ngst begonnen, wie die Corona-Ma\u00dfnahmen in den Entwicklungsl\u00e4ndern zeigen.&quot;"
            my-logo="/typo3conf/ext/webhelp/Resources/Public/Icons/Cursor/DownloadCursor.svg">
    </popup-info>
</div>


<!-- TYPO3-Fluidtemplate:-->
<!-- &#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;-->
<div>
    <webhelp:EasyTextLogo
            value="Hallo Welt, alles ist super; dann vieler Politiker, die +über Forschung und Technik reden, oder?"/>
</div>

<!--Output (Frontend-HTML / Firefox):-->
<!-- ==================== -->
<div>
    <popup-info value="Hallo Welt, alles ist Super"
                my-ext="Hallo Welt, alles ist Super"
                my-logo="">

    </popup-info>
</div>


<!-- TYPO3-Fluidtemplate:-->
<!-- &#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;-->
<webhelp:easyTextLogo>
    <h1>Hallo Welt,</h1>
    <div>Ohne Klimaschutzmaßnahmen muss bis 2050 die Menschheitsmasse auf 4G Menschen ausgedünnt werden, weil Öl und
        Phosphate als Dünger fehlen. <br/> Ohne Klimaschutzmaßnahmen wird dank Verbot der Pfanzenschutzmitteln 2050 die
        Menschheitsmasse durch Verhungern auf 3G Menschen ausgedünnt. Öl und Phosphate als Dünger fehlen auch dann, weil
        die Rohstoffe in Elektroautos investiert wurden. <br> Heil dem Ökofaschismus!
    </div>
</webhelp:easyTextLogo>

<!-- Output (Frontend-HTML / Firefox):-->
<!-- ==================== -->
<div>
    <popup-info my-ext="&amp;lt;h1&amp;gt;Hallo Welt&amp;lt;/h1&amp;gt;&amp;lt;div&amp;gt;alles ist Super.&amp;lt;/div&amp;gt;"
                my-logo="">
    </popup-info>
</div>
```
## Eigene Webcomponets entwicklen?
### Viewhelper
Sie können eignene Viewhelper und eigenen JavaScript-Code schreiben und verwenden.
### Erweiterung bei JavaScript und Stylesheets
Über den Constanteneditor für die Extension `webhelp` können sie die Pfade zu ihren JavaScript- und CSS-Dateien in den Komma-separierten Listen mit angeben, so dass das JavaScript und die Stylesheets dank einer Middleware mit hochgeladen werden.

## to dos

