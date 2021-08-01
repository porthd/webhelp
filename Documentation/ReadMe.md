# Extension Webhelp
##A notice
The extension is currently still in the experimental phase.
The web components are not very mature yet. I will be happy to receive suggestions for improvement.
If you have your own code for WebComponets, I'll be happy to include it in this extension.
Email: info@mobger.de


## What is the aim of the extension
It provides view helpers for integrators,
which in turn allow the use of WebComponents.
Web componentets are suitable to
- Offer address data as a VCard for download
- Offer events as ICalendar files for download
- Offer contact details as a VCard file for download
- Easy to integrate pop-up windows, m example for auxiliary tests
- ....

## installation
Install the extension by downloading it or via composer. Then activate them.
TypoScript does not need this service.

## Viewhelper
Two view helpers are currently defined. You can use the prefix `webhelp:` in the Fluid template.

### EasyIcalendar for ICS files
`<webhelp: easyIcalendar>` allows the creation of an ICS file. You can transfer the necessary information individually, as a JSON string or as a fluid array / model.
#### Example code in the fluid
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

### EasyVCard for ICS files
`<webhelp: easyVCard>` allows the creation of an ICS file. You can transfer the necessary information individually, as a JSON string or as a fluid array / model. The use is the same as above for `<webhelp: easyIcalendar>`.
#### Example code in the fluid
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

### EasyTextLogo for logo-based popups
`<webhelp: easyTextLogo>` expects an (HTML) text and the path to a logo.
If a logo is missing, the stop sign is used as the default logo.
#### Example code in the fluid
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

## Develop your own web components?
### Viewhelper
You can write and use your own view helpers and JavaScript code.
### Extension for JavaScript and stylesheets
Using the constant editor for the extension `webhelp` you can specify the paths to your JavaScript and CSS files in the comma-separated lists, so that the JavaScript and the stylesheets are uploaded thanks to a middleware.

## to dos
