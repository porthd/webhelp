# Content
## Warning
I have only tested it with TYPO3 12. But it should work with other TYPO3-versions too.

## Goal of the Extension
The extension provides browser-supported web components for use in templates.
Web components are helper tags that modify the view and/or interactive behavior.
The web components were created using [vibe coding](https://en.wikipedia.org/wiki/Vibe_coding), so any errors are, of course, not my fault as the developer, but the AI's, because it didn't take all edge cases into account.

## Installation and Use
1. Install the extension
1. Using the traditional method
2. Using composer with `composer require porthd/webhelp`
2. Check in the install tool area whether the extension configuration meets your requirements.
   By default, TypoScript uses the `page = PAGE` object to load the JavaScript.
3. Use the web component tags in your Fluid templates. See the `Resources/Private/Examples` folder for how to use the web component tags in Fluid templates or HTML.

## Defined Web Components

Web Component | Task | Links
-------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|------
porthd-vcard | Creates a contact file and converts the included list of data into a downloadable vcf file. The included data is validated. | [de-Wikipedia](https://de.wikipedia.org/wiki/VCard#Spezifikation) --- [RFC6350 Specification](https://www.rfc-editor.org/rfc/rfc6350)
porthd-icalendar | Creates an events file and converts an included list of data for one or more events into a downloadable ics file. The included data is validated. | [Specification](https://icalendar.org/RFC-Specifications/all/) --- [en-Wikipedia](https://en.wikipedia.org/wiki/ICalendar#:~:text=iCalendar%20is%20a%20data%20format%20for%20exchange%20of%20calendar%20content%2C,was%20originally%20defined%20in%20RFC%202445%20%5B10%5D%20in%201998.) --- [de-Wikipedia-Media](https://de.wikipedia.org/wiki/ICalendar#/media/Datei:ICalendarSpecification.png)
porthd-listselect | Restricts the output of long nested lists to a defined level and allows searching hidden subheadings. | [Overview of menus on the web](https://sketch.media/index.php?option=com_content&view=article&id=851) --- [Dropdown menu for large nesting](https://wiki.selfhtml.org/wiki/Navigation/Dropdown-Men%C3%BC) --- [Mediaevent on menus](https://www.mediaevent.de/tutorial/css-responsive-menu.html)

### Parameters in `<porthd-vcard>`
The web component `<porthd-vcard>` includes a list of HTML tags that define the individual parameters in the vcard file.
The usage examples can be found here in the documentation in ['Examples/WebcomponentVCard.html'](./Examples/WebcomponentVCard.html).
The value in `data-id` determines the respective parameter in the subsequent vCard file.
If necessary, additional parameters may be allowed in the main parameter, such as the TYPE parameter or the VALUE parameter, or similar, as shown in the table below.
In contrast to the iCalendar Web Component defined in this extension, no other attributes are accepted besides the data attributes mentioned.
If you add additional data attributes to the included elements, they will be inserted without verification according to the following scheme:
`<div data-id="ATTACH" data-fmttype="application/postscript">ftp://example.com/pub/reports/r-960812.ps</div>`
results in the following entry in the iCalendar:
`ATTACH;FMTTYPE=application/postscript:ftp://example.com/pub/reports/r-960812.ps`.
Please ensure that a valid combination is always used.

**Table with the validated IDs for included elements**

Parameter | Definition | `data-value` | `data-type` | `data-`*
--|--|--|--|--
ADR | Address | 0 | 1 |
ANNIVERSARY | Anniversary | 1 | 0 |
BDAY | Birthday | 1 | 0 |
BIRTHPLACE | Person's birthplace | 0 | 0 |
CALADRURI | URL to send an appointment request to the person's calendar | 0 | 0 |
CALURI | URL to the person's calendar | 0 | 0 |
CATEGORIES | List of tags to describe the object represented by this vCard | 0 | 0 |
CLIENTPIDMAP | Used to synchronize different revisions of the same vCard. | 0 | 0 |
DEATHDATE | Person's death date | 0 | 0 |
DEATHPLACE | Person's death place | 0 | 0 |
EMAIL | Email address | 0 | 1 |
EXPERTISE | Person's field of expertise | 0 | 0 |
FBURL | Defines a URL that indicates when the person is free or busy in their calendar., 0, 0 |
**FN** | **Full Name (Required)** | **0** | **0** | ** **
GENDER | Gender | 0 | 0 |
GEO | Geocoordinates (V4.0) | 0 | 0 |
HOBBY | Person's leisure activity | 0 | 0 |
IMPP | Username for an instant messenger. This was included in the official vCard specification in version 4.0. | 0 | 0 |
INTEREST | Leisure activity the person is interested in, but not necessarily engaged in. | 0 | 0 |
KEY | Public encryption key (V4.0) | 0 | 0 | MEDIATYPE,ENCODING
KIND | Defines the entity type this vCard represents: 'Application' | 'Individual' | 'Group' | 'Location' or 'Organization'; experimental., 0, 0 | ',
LABEL | Language | 0 | 1 |
LANG | Language | 0 | 0 |
LOGO | Company logo (V4.0) | 1 | 0 | ENCODING
MEMBER | Defines a member of the group this vCard represents. | 0 | 0 |
N | Name (V4.0 – optional) | 0 | 0 |
NICKNAME | Nickname | 0 | 0 |
NOTE | Note | 1 | 0 | LANGUAGE
ORG | Organization | 0 | 1 |
ORG-DIRECTORY | URI for the person's workplace; this can be used to retrieve information about the person's employees. | 0 | 0 |
PHOTO | Photo | 1 | 1 | ENCODING,MEDIATYPE
RELATED | Another entity with which the person is related. | 0 | 1 |
REV | Last updated | 1 | 0 |
ROLE | Role | 0 | 0 |
SOUND | It specifies the pronunciation of the FN., 0, 0 |
SOURCE | A URL where the latest version of this vCard can be retrieved. | 0 | 0 |
TEL | Telephone number | 0 | 1 |
TITLE | Title | 0 | 0 |
TZ | Time zone | 0 | 0 |
URL | Website | 0 | 1 | TITLE
XML | All XML data associated with the vCard | 0 | 1 | TITLE

For precise content usage, please refer to the vCard definition [on Wikipedia](https://en.wikipedia.org/wiki/VCard) or [on the specification](https://www.rfc-editor.org/rfc/rfc6350.html).

To make the file available, a button is defined in the shadow DOM in the web component.
The attributes can be used to define the appearance and text of the button.

**Attributes in `<porthd-vcard>`**

Attributes | Function
--|--
button-label | Text of the button, where TEXT can also contain HTML and SVG tags.
button-style | CSS properties for the button's style element in the Shadow DOM
file-name | Name for the file to be downloaded

### Parameters in `<porthd-icalendar>`
The web component `<porthd-icalendar>` includes a list of HTML tags that define the individual parameters in the icalendar file.
The usage examples can be found here in the documentation in ['Examples/WebcomponentICalendar.html'](./Examples/WebcomponentICalendar.html).
If you add additional data attributes to the included elements, they will be inserted without verification according to the following scheme:
`<div data-id="ATTACH" data-fmttype="application/postscript">ftp://example.com/pub/reports/r-960812.ps</div>`
results in the following entry in the iCalendar:
`ATTACH;FMTTYPE=application/postscript:ftp://example.com/pub/reports/r-960812.ps`.
Please ensure that a valid combination is always used.

**Table with the validated IDs for included elements**

data-id | Description
-----|-----
ATTACH | Attachments (e.g., PDF agenda)
ATTENDEE | Event attendees
BEGIN | always with VEVENT - Define a new event in the file. Not required for a single event. Only directly after END
CALSCALE | Calendar scale (e.g., GREGORIAN)
CATEGORIES | Event categories
CLASS | Visibility (PUBLIC, PRIVATE, CONFIDENTIAL)
CREATED | Creation time
DESCRIPTION | Longer description of the event
DTEND | End time of the event
DTSTAMP | Creation timestamp (required)
DTSTART | Start time of the event (required)
END | always with VEVENT - Define a new event in the file. Not required for a single event. BEGIN must follow to define the next event
EXDATE | Exceptions for recurrences
GEO | Geographical coordinates (latitude; longitude)
LAST-MODIFIED | Time of last change
LOCATION | Event location
METHOD | Calendar method (e.g., PUBLISH)
ORGANIZER | Organizer
PRIORITY | Priority (1-9, 1 = highest)
RECURRENCE-ID | Reference to a recurring event
RRULE | Rule for recurring events
SEQUENCE | Number of changes to the event
STATUS | Status (e.g., CONFIRMED, CANCELLED)
SUMMARY | Short description of the event
TRANSP | Transparency (OPAQUE = occupied, TRANSPARENT = free)
UID | Unique identification number of the event (required)
URL | Web link to the event
X-WR-CALNAME | Display name of the calendar
X-WR-TIMEZONE | Calendar time zone

**Attributes in `<porthd-vcard>`**
This web component has four attributes. Two are used to define the button, one is the ProdID for the iCalendar entry

Attributes | Function
--|--
button-label | Text of the button, where TEXT can also contain HTML and SVG tags.
button-style | CSS properties for the button's style element in the Shadow DOM
file-name | Name for the file being downloaded; the '.ics' extension is always appended.
prodid | Identifier for generating the iCalendar file. This entry is not standardized.

### Parameters in `<porthd-listselect>`

The web component `<porthd-listselect>` includes a nested list of HTML tags that can represent, for example, a complex menu, a site's sitemap, an organizational chart, or a table of contents. It allows easy filtering by level and/or keywords, which are offered according to the autocomplete principle.
An example of use can be found here in the documentation in ['Examples/WebcomponentListSelectFilter.html'](./Examples/WebcomponentListSelectFilter.html).
The web component provides a relatively large number of attributes for configuring the filter form.

**Attributes in `<porthd-listselect>`**

Attributes | Function
--|--
level | Level to be displayed for nested lists by default or after a reset
filter | Term to be entered into the search box for the filter
list-tags | Selectors or HTML tags that each enclose a list element and/or a nested list. The :where() pseudo-class is used for selection.
search-length | Minimum number of letters that must be entered into the search box
label-range | Text identifier before the slider for setting the displayed nesting depth
label-search | Text identifier before the input field for filtering
label-reset | Text identifier for the reset button
placeholder | Text displayed in the empty input field for filtering
label-style | List of CSS properties to assign to the two label fields. This is analogous to the style field in normal tags.
input-style | List of CSS properties to assign to the input field. This is analogous to the style field in normal tags.
range-style | List of CSS properties to assign to the range field. This is analogous to the style field in normal tags. Pseudo-classes are not transferred.
button-style | List of CSS properties to assign to the reset button. This is analogous to the style field in normal tags.
trim | The words for autocomplete can be trimmed by the characters, so that, for example, brackets without spaces before a word do not appear in the autocomplete.

## Experiment

### Parameters in ``<porth-modal>``

This is a poor product of vibe-coding with ChatGPT because the modal isn't even easily centered.
The negative example can be found here in the documentation in ['Examples/WebcomponentModal.html'](./Examples/WebcomponentModal.html).
Perhaps I used the wrong prompting, or there's a technical solution that the system hasn't learned yet and can't come up with due to a lack of creativity.
