# Content

## Warning

I've only tested it for TYPO3 12. It should work with other versions as well.

Translated from German to English using Google - only with a cursory check.

### Workaround for errors

In the worst case, quickly test the HTML file and incorporate the web components generated using vibe coding and defined
in JavaScript into your extension. Then you can use the web component tags like normal HTML tags in your Fluid template.
If the code doesn't work, simply ask an AI to fix it for you.
Vibe coding stands for "programming like a politician - or better: feigning ignorant genius."

## Goal of the Extension

The extension provides browser-supported web components for use in templates.
Web components are helper tags that modify the view and/or interactive behavior.
The web components were created using [vibe coding](https://en.wikipedia.org/wiki/Vibe_coding), so any errors are, of
course, not my fault as the developer, but the AI's, because it didn't take all edge cases into account.

## Installation and Use

1. Install the extension
1. Using the traditional method
2. Using composer with `composer require porthd/webhelp`
2. Check in the install tool area whether the extension configuration meets your requirements.
   By default, TypoScript uses the `page = PAGE` object to load the JavaScript.
3. Use the web component tags in your Fluid templates. See the `Resources/Private/Examples` folder for how to use the
   web component tags in Fluid templates or HTML.

## Defined Web Components

| Web Component (internal link)                                       | slogan                                  | Task                                                                                                                                                                                                                                                                                        | Links                                                                                                                                                                                                                                                                                                                                                                                               |
|---------------------------------------------------------------------|-----------------------------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| [porthd-ajax](#parameters-in-porthd-ajax)                           | Reload content                          | Fetch data or HTML fragments from a defined URL via HTTP request and include them in the web component's own tag. A button for multiple queries can be set. If necessary, a callback can be introduced into the web component to prepare the data.                                          | [Ajax explanations (German)](https://de.wikipedia.org/wiki/Ajax_(programming)) [Ajax explanations (English)](https://en.wikipedia.org/wiki/Ajax_(programming))                                                                                                                                                                                                                                      |
| [porthd-bar-chart-table](#parameters-in-porthd-barchart-from-table) | Chart to Table                          | Transforms data from a table into a bar chart and offers the user various selection options.                                                                                                                                                                                                | ---                                                                                                                                                                                                                                                                                                                                                                                                 |
| [porthd-breadcrumb](#parameters-in-porthd-breadcrumb)               | Talking link in breadcrumb              | Convert a time from one time zone to another and present it                                                                                                                                                                                                                                 |
| [porthd-codeview](#parameters-in-porthd-codeview)                   | Code viewer                             | It is a customizable web component for rendering syntax-highlighted code snippets with support for themes, line numbers, and clipboard copying.                                                                                                                                             | [prism-Dokumentation in English](https://prismjs.com/docs/)                                                                                                                                                                                                                                                                                                                                         |
| [porthd-icalendarevent](##parameters-in-porthd-icalendarevent)           | Provide HTML event data as an ics file  | Creates an events appointment file and converts an included list of data for one or more events into a downloadable ics file. The included data is validated.                                                                                                                               | [Specification](https://icalendar.org/RFC-Specifications/all/) --- [en-Wikipedia](https://en.wikipedia.org/wiki/ICalendar#:~:text=iCalendar%20is%20a%20data%20format%20for%20exchange%20of%20calendar%20contents%2C,was%20originally%20defined%20in%20RFC%202445%20%5B10%5D%20in%201998.) --- [de-Wikipedia-Media](https://de.wikipedia.org/wiki/ICalendar#/media/Datei:ICalendarSpecification.png) |
| [porthd-infomodal](#parameters-in-porthd-infomodal)                 | Define info popups using a template     | requires the definition of a template for the modal window with a close button and an included start button to provide the output of a modal window for information purposes. Dynamic modal windows are possible using the `data-*` attribute and slots of the same name in the <template>. | [Explanations of modal windows in German](https://ichi.pro/de/4-moglichkeiten-zum-erstellen-eines-modalen-popup-felds-mit-html-css-und-vanilla-javascript-83364935438226)                                                                                                                                                                                                                           |
| [porthd-listselect](#parameters-in-porthd-listselect)               | Interactively control/filter mega menus | Restricts the output of long nested lists to a defined level and allows searching hidden subheadings.                                                                                                                                                                                       | [Overview of menus on the web](https://sketch.media/index.php?option=com_content&view=article&id=851) --- [Dropdown menu for large nesting](https://wiki.selfhtml.org/wiki/Navigation/Dropdown-Men%C3%BC) --- [Media event on menus](https://www.mediaevent.de/tutorial/css-responsive-menu.html)                                                                                                   |
| [porthd-timezone](#parameters-in-porthd-timezone)                   | Time zone conversion for dates          | Convert a time from one time zone to another and present the result within the web component's tag. The start time must either be included in the tag or be in the `datetime` attribute.                                                                                                    | [Explanations of the time zone in German](https://www.mediaevent.de/javascript/get-timezone.html)                                                                                                                                                                                                                                                                                                   |
| [porthd-tocgenerator](#Parameter-in-porthd-tocgenerator)            | Table of Contents                       | Create an unnumbered or numbered table of contents for a defined block.                                                                                                                                                                                                                     | [Article on the table of contents](https://ichi.pro/de/erstellen-eines-inhaltsverzeichnisses-mit-html-und-css-127834089968964)                                                                                                                                                                                                                                                                      |
| [porthd-vcard](#parameters-in-porthd-vcard)                         | Provide HTML contact data as a vcf file | Creates a contact file and converts the included list of data into a downloadable vcf file. The included data is validated.                                                                                                                                                                 | [de-Wikipedia](https://de.wikipedia.org/wiki/VCard#Spezifikation) --- [RFC6350 Specification](https://www.rfc-editor.org/rfc/rfc6350)                                                                                                                                                                                                                                                               |

---

### Parameters in porthd-ajax

The web component `<porthd-ajax>` allows the integration of data that is actively reloaded via Ajax. The query can be
performed automatically or only after clicking a button. The button can be styled, labeled, and restricted in its
frequency of use. It is also possible to transform the received data for output using a JavaScript function. The help
texts can also be freely defined.
A usage example can be found here in the documentation
in ['Examples/WebcomponentAjax.html'](./Examples/WebcomponentAjax.html)

The code was created using vibe-coding and has not been thoroughly tested yet.

#### Attributes in `<porthd-ajax>`

The following table describes the various supported attributes and their functions.

| Attributes   | Function                                                                                                                                                                                                                 |
|--------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| url          | URL for the https request, from which the desired data can be downloaded.                                                                                                                                                |
| loading-text | Text displayed while waiting for the data to load. The text may contain HTML tags.                                                                                                                                       |
| error-text   | Text displayed while waiting for data to load. The text may contain HTML tags.                                                                                                                                           |
| callback     | Optional. Function of type `data = callback(data);`. This function prepares the incoming data for display in the web component.                                                                                          |
| button-text  | If at least one non-white character is present here, a button with the displayed text is displayed in the web component. The text may contain HTML tags. The Ajax request is only initiated after the button is clicked. |
| button-style | The specified properties are assigned to the button's `style` attribute, allowing for custom styling.                                                                                                                    |
| max-click    | By specifying a number, the number of clicks on the button can be limited. If the maximum number is reached, the button is hidden. If the attribute is missing or empty, there is no limit to the number of clicks.      |

#### 🧪 Example: Maximum use with styling

```html
<porthd-ajax
url="https://example.com/data.html"
loading-text="⏳ Loading data..."
error-text="❌ Error retrieving data."
callback="transformData"
 button-text="🔄 Reload data"
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

#### 💡 Optional: callback function
```javascript
function transformData(data) {
 return `<pre style="white-space: pre-wrap; font-family: monospace;">${data}</pre>`;
}
```

---

### Parameters in porthd-barchart-from-table

This web component converts an HTML table into an interactive bar chart using **Chart.js**. The display is dynamic, flexible, and controllable with checkboxes and radio buttons.

---

#### ⚙️ Attributes Used

| Attribute | Type | Description |
|- ... `button-text` | String | Optional: Displays a button to show/hide the table |
| `chartjs-url` | String | URL to the Chart.js library (default: CDN) |

---

#### 🧪 Example: Maximum configuration

```html
<porthd-barchart-from-table
 title-column="0"
 value-column="2"
 colors="crimson,orange,gold,forestgreen,dodgerblue,purple"
 orientation="horizontal"
 transpose
 button-text="📋 Show/Hide Table"
 chartjs-url="https://cdn.jsdelivr.net/npm/chart.js"
>
 <table>
 <thead>
 <tr><th>Product</th><th>January</th><th>February</th><th>March</th></tr>
 </thead>
 <tbody>
 <tr><td>Apple</td><td>120</td><td>150</td><td>180</td></tr>
<tr><td>Pear</td><td>90</td><td>130</td><td>160</td></tr>
<tr><td>Cherry</td><td>70</td><td>110</td><td>140</td></tr>
</tbody>
</table>
</porthd-barchart-from-table>
```

---

#### 🎨 Dynamic Styling

- Each bar can be styled with a color from the `colors` list
- `button-text` displays a toggle button for the table
- The table is cloned and displayed in the Shadow DOM

---

#### ✨ Features

- **Automatic loading** of Chart.js if it is not already available
- **Checkboxes** for selecting rows or columns
- **Radio buttons** for selecting the Value source (column or row)
- **Responsive layout**, orientable along the X or Y axis
- **Full control** over display using attributes

---

#### 🧠 Notes

- The component uses Shadow DOM – styles must be set inline or via JS.
- The table in the Light DOM is retained – changes there do not take effect automatically.
- You can set `chartjs-url` if you want to load a specific Chart.js version.

---

#### 📌 Possible extensions

- Support for multiple datasets
- Export function (PNG/SVG)
- Dynamic color palettes based on values
- Tooltip customization

---

### Parameters in porthd-breadcrumb

The `<porthd-breadcrumb>` web component generates breadcrumb navigation based on a specified URL. It supports dynamic styling options, callback processing, and display of domain information.

#### Example usage

```html
<porthd-breadcrumb
href="https://example.com/products/category/item123?ref=abc"
separator=" &gt; "
show-domain="true"
parameter-text="with parameters"
error-text="Invalid URL"
callback="formatBreadcrumbLabel">
</porthd-breadcrumb>
```

##### Example callback in the window context:

```js
window.formatBreadcrumbLabel = function(text) {
return text.replace(/-/g, ' ').toUpperCase();
};
```

#### Explanation of the attributes

| Attribute | Description |
|------------------|-------------------------------------------------------------------------------|
| `href` | The URL from which the breadcrumb is generated. Must be valid. |
| `separator` | HTML content as a separator between breadcrumb elements. Default: `/` |
| `show-domain` | `true` or `1` to display the domain as the first element. |
| `parameter-text` | Text displayed if URL parameters are present. |
| `error-text` | Text displayed if the URL is invalid. |
| `callback` | Name of a function in the global scope that can modify path segments. |

#### Dynamically generated HTML code

##### Example output with domain display and URL parameters enabled:

```html
<span class="breadcrumb">
<a href="https://example.com">example.com</a>
<span>/</span>
<a href="https://example.com/produkte/">PRODUCTS</a>
<span>/</span>
<a href="https://example.com/produkte/kategorie/">CATEGORY</a>
<span>/</span>
<a href="https://example.com/produkte/kategorie/item123/">ITEM123</a>
<span>/</span>
<a href="https://example.com/products/category/item123?ref=abc">with parameters</a>
</span>
```

#### Styling Note

The component adds the `breadcrumb` class to the container by default. Example CSS:

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
margin: 0.4px;
color: #aaa;
}

.breadcrumb .error {
color: red;
}
```

This component is ideal for dynamically generating path navigation for web applications, especially for CMS or SPA systems.

---

### Parameters in porthd-codeview

This documentation shows a maximum example of the output of the dynamically generated code of the web component `<porthd-codeview>`, including all styling elements and interactive features.

#### Example HTML for using the component

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
// Example JavaScript code
function greet(name) {
console.log(`Hello, ${name}!`);
}
greet('World');
</script>
</porthd-codeview>
```

#### Dynamically generated DOM content (Shadow DOM)

After inserting the component, the following DOM section is generated in the Shadow DOM:

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
// Example JavaScript Code
function greet(name) {

console.log(`Hello, ${name}!`);
}
greet('World');

</code></pre>
```

#### Features

- Syntax highlighting with Prism.js (dynamically loaded)
- Switching between `light` and `dark` themes
- Line numbers via plugin
- Copy function with feedback (✓)
- Multi-language support via `<script type="text/plain">`

#### Styling Details

The buttons are positioned absolutely above the code block. The theme can be changed dynamically by including different CSS files from Prism.

#### Note

PrismJS and plugins are only loaded if they are not already present.

ℹ️ A complete example of the maximum generated structure of this component is shown above.

---

### Parameters in porthd-icalendarevent

This example demonstrates full use of the `<porthd-icalendarevent>` web component, including maximum generated dynamic iCalendar code, validated data fields, and built-in styling.

#### Example HTML

```html
<porthd-icalendarevent
button-label="Download iCal"
button-style="background: green; color: white; padding: 12px 20px; border-radius: 6px; border: none;"
file-name="my-event"
prodid="-//Example Company//iCal Generator//DE">

<div data-id="UID">123e4567-e89b-12d3-a456-426614174000</div>
<div data-id="DTSTAMP">20250415T120000Z</div>
<div data-id="DTSTART">20250501T090000Z</div>
<div data-id="DTEND">20250501T100000Z</div>
<div data-id="SUMMARY">Meeting with Team</div>
<div data-id="DESCRIPTION">Discussion of Q2 Goals and Strategy</div>
<div data-id="LOCATION">Conference Room A</div>
<div data-id="STATUS">CONFIRMED</div>
<div data-id="CLASS">PUBLIC</div>
<div data-id="ORGANIZER" data-cn="Max Mustermann">mailto:max@example.com</div>
<div data-id="ATTENDEE" data-role="REQ-PARTICIPANT" data-cn="Erika Example">mailto:erika@example.com</div>

</porthd-icalendarevent>
```

#### Explanation

- The button styling can be customized using `button-style`.
- The `prodid` attribute specifies the PRODUCT ID of the iCalendar export.
- Each `data-id` container represents an iCalendar row. Additional parameters are added using `data-` attributes.

#### Generated iCal Content

If used correctly, clicking the button will generate an .ics file download with the following format:

```ics
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//Example Company//iCal Generator//DE
BEGIN:VEVENT
UID:123e4567-e89b-12d3-a456-426614174000
DTSTAMP:20250415T120000Z
DTSTART:20250501T090000Z
DTEND:20250501T100000Z
SUMMARY:Meeting with Team
DESCRIPTION:Discussion of Q2 Goals and Strategy
LOCATION:Conference Room A
STATUS:CONFIRMED
CLASS:PUBLIC
ORGANIZER;CN=Max Mustermann:mailto:max@example.com
ATTENDEE;ROLE=REQ-PARTICIPANT;CN=Erika Example:mailto:erika@example.com
END:VEVENT
END:VCALENDAR
```
#### Explanation of parameters

**Table with the permitted data IDs for included elements**

| data-id | Description|
|---------------|-----|
| ATTACH | Attachments (e.g., PDF agenda)|
| ATTENDEE | Event participants|
| BEGIN | Always with VEVENT - Define a new event in the file. Not required for a single event. Only directly after END|
| CALSCALE | Calendar scale (e.g., GREGORIAN)|
| CATEGORIES | Event categories |
| CLASS | Visibility (PUBLIC, PRIVATE, CONFIDENTIAL) |
| CREATED | Creation time |
| DESCRIPTION | Longer description of the event |
| DTEND | Event end time |
| DTSTAMP | Creation timestamp (required) |
| DTSTART | Event start time (required) |
| END | Always with VEVENT - Define a new event in the file. Not required for just one event. BEGIN must follow to define the next event |
| EXDATE | Exceptions for recurrences |
| GEO | Geographical coordinates (latitude; longitude) |
| LAST-MODIFIED | Last modified time |
| LOCATION | Event location |
| METHOD | Method for the calendar (e.g., PUBLISH) |
| ORGANIZER | Organizer |
| PRIORITY | Priority (1-9, 1 = highest) |
| RECURRENCE-ID | Reference to a recurring event |
| RRULE | Rule for recurring events |
| SEQUENCE | Number of changes to the event |
| STATUS | Status (e.g., CONFIRMED, CANCELED) |
| SUMMARY | Short description of the event |
| TRANSP | Transparency (OPAQUE = booked, TRANSPARENT = free) |
| UID | Unique identification number of the event (required) |
| URL | Web link to the event |
| X-WR-CALNAME | Display name of the calendar |
| X-WR-TIMEZONE | Calendar time zone |

#### Explanation of attributes
This web component has four attributes. Two are used to define the button, one is the ProdID for the iCalendar entry.

| Attributes | Function |
|--------------|-- |
|button-label | Button text, where TEXT can also contain HTML and SVG tags. |
|button-style | CSS properties for the button's style element in the Shadow DOM |
|file-name | Name for the file being downloaded; the '.ics' extension is always appended. |
|prodid | Identifier for generating the iCalendar file. This entry is not standardized. |

#### Error Handling

The component automatically checks for required fields (`UID`, `DTSTAMP`, `DTSTART`, `SUMMARY`) and reports errors in an `alert` window.

---


### Parameters in porthd-infomodal

#### Overview

The `porthd-infomodal` is a customizable modal web component. It allows for flexible configuration using attributes,
internal or external templates, and various error-handling mechanisms. The component supports accessibility features,
including focus traps for keyboard navigation and dynamic updates via data attributes.

#### Attributes

##### `template-id`

- **Description**: Specifies the `id` of an external template to use for the modal content.
- **Example**: `<porthd-infomodal template-id="modal-template">`

##### `background-class`

- **Description**: Specifies a CSS class to be applied to the modal's background overlay.
- **Example**: `<porthd-infomodal background-class="modal-overlay">`

##### `data-*`

- **Description**: Custom data attributes to dynamically pass content into slots inside the modal.
- **Example**: `<porthd-infomodal data-title="Modal Title" data-info="This is the modal description.">`

##### `error-text`

- **Description**: Specifies the error message displayed in the frontend when the modal template or modal elements are
  missing or incorrectly configured. Default value: `'Modal/Button missing'`.
- **Example**: `<porthd-infomodal error-text="Template not found!">`

##### `error-style`

- **Description**: Allows you to specify custom CSS styles for the error message displayed in the frontend.
- **Example**: `<porthd-infomodal error-style="color:red; font-weight: bold;">`

##### `error-canceltext`

- **Description**: Specifies the error message displayed when the "Cancel" (close) button is missing from the modal
  template.
- **Example**: `<porthd-infomodal error-canceltext="Cancel button missing!">`

##### `error-hide`

- **Description**: If set to `1` or `true`, the error message is shown only in the console and hidden from the frontend.
  By default, error messages are displayed in the frontend.
- **Example**: `<porthd-infomodal error-hide="true">`

##### `error-show`

- **Description**: If set to `1` or `true`, the error message is displayed in both the console and the frontend.
- **Example**: `<porthd-infomodal error-show="true">`

#### Methods

##### `openModal()`

- **Description**: Opens the modal by removing the `hidden` class. Focus is moved to the modal dialog.

##### `closeModal()`

- **Description**: Closes the modal by adding the `hidden` class back. The focus returns to the button that triggered
  the modal.

##### `initFocusTrap(container)`

- **Description**: Initializes a focus trap within the modal to ensure that keyboard navigation stays within the modal
  when it's open.

##### `errorLog(message)`

- **Description**: Logs error messages to the console and optionally displays them in the frontend based on the
  `error-show` and `error-hide` attributes.

#### Usage Examples

##### Example 1: External Template with Modal

```html

<porthd-infomodal template-id="modal-template" background-class="modal-overlay" data-title="Hello World"
                  data-info="This is a test modal.">
    <button data-id="modal-start">Open Modal</button>
</porthd-infomodal>
```

##### Example 2: Internal Template with Scrollable Content

```html

<porthd-infomodal background-class="modal-overlay" data-title="Long Text Test" data-info="Lorem ipsum...">
    <button data-id="modal-start">Scroll Content</button>
    <template>
        <div class="modal-content" role="dialog" aria-modal="true" tabindex="-1">
            <h2>
                <slot name="title"></slot>
            </h2>
            <p>
                <slot name="info">[Text here]</slot>
            </p>
            <button data-id="cancel">Close</button>
        </div>
    </template>
</porthd-infomodal>
```

##### Example 3: Missing Template with Frontend Error Message

```html

<porthd-infomodal template-id="non-existent-template" error-text="Template not found!">
    <button data-id="modal-start">Show Error</button>
</porthd-infomodal>
```

##### Example 4: Missing Cancel Button with Custom Error Text

```html

<porthd-infomodal error-text="Modal template/start button is missing!" error-canceltext="Cancel button forgotten?"
                  background-class="modal-overlay">
    <button data-id="modal-start">Open Modal</button>
    <template>
        <div class="modal-content" role="dialog" aria-modal="true" tabindex="-1">
            <h2>
                <slot name="title">Error</slot>
            </h2>
            <p>
                <slot name="info">No Cancel Button</slot>
            </p>
        </div>
    </template>
</porthd-infomodal>
```

##### Example 5: Standard Error Message with Frontend Display

```html

<porthd-infomodal template-id="modal-template" error-text="Modal template/start button missing!"
                  data-title="Hello World" data-info="Something is missing...">
    <div>Button to open is missing. :-( - Sad for the modal.</div>
</porthd-infomodal>
```

##### Example 6: Modal with Custom Error Styling

```html

<porthd-infomodal template-id="modal-template" error-text="Modal template/start button missing!"
                  error-style="background:red; color:#fff; font-weight: bolder;" data-title="Hello World"
                  data-info="Something is missing...">
    <div>Button to open is missing. :-( - Sad for the modal.</div>
</porthd-infomodal>
```

##### Example 7: Event Details with 5 Custom Slots

```html

<porthd-infomodal background-class="modal-overlay" data-eventtitel="ChatGPT Workshop"
                  data-eventbeschreibung="Learn the basics of LLMs" data-start="10:00 AM" data-ende="12:00 PM"
                  data-preis="99€">
    <button data-id="modal-start">Event Details</button>
    <template>
        <div class="modal-content" role="dialog" aria-modal="true" tabindex="-1">
            <h2>
                <slot name="eventtitel"></slot>
            </h2>
            <p>
                <slot name="eventbeschreibung"></slot>
            </p>
            <p><strong>Start:</strong>
                <slot name="start"></slot>
            </p>
            <p><strong>End:</strong>
                <slot name="ende"></slot>
            </p>
            <p><strong>Price:</strong>
                <slot name="preis"></slot>
            </p>
            <button data-id="cancel">Close</button>
        </div>
    </template>
</porthd-infomodal>
```

#### Notes

- **Accessibility**: The modal includes accessibility features such as `role="dialog"` and `aria-modal="true"`. It also
  implements a focus trap to ensure keyboard navigation remains within the modal when it is open.
- **Error Handling**: The component includes multiple mechanisms for handling errors, such as missing templates, missing
  buttons, and custom error messages. The `error-show` and `error-hide` attributes allow flexibility in how errors are
  displayed.

#### Advantages

- Flexible Templates: Use of external and internal templates.
- Customizable: Dynamic content adjustment via `data-*` attributes.
- Accessibility: Focus management and ARIA support.
- Error Handling: Custom error messages in both frontend and console.
- Keyboard-Friendly: Focus trap for navigation.
- CSS Customization: Customizable styles via `error-style` and `background-class`.
- Template Dependency: Errors occur if the template is missing.

#### Disadvantages

- Complexity: Learning curve for using templates and error handling.
- Performance: Possible performance issues with many instances.
- Missing Animations: No built-in transitions for opening/closing modals.
- Mobile Devices: Potential issues on mobile devices.

#### Extensions

- Animations: Adding animations when opening/closing.
- Modal Types: Additional modal variants (Confirmation, Error, Info).
- Size Customization: Dynamic modal dimensions.
- Forms: Embedding forms inside the modal.
- Keyboard Shortcuts: Additional shortcuts for control.
- Mobile Optimization: Better support for mobile devices.
- Performance Optimization: Lazy loading and DOM optimizations.
- Extended Accessibility: Additional ARIA attributes and screen reader support.

---

### Parameters in porthd-listselect

The web component `<porthd-listselect>` includes a nested list of HTML tags that can represent, for example, a complex
menu, a site's sitemap, an organizational chart, or a table of contents. It allows easy filtering by level and/or
keywords, which are offered according to the autocomplete principle.
An example of use can be found here in the documentation
in ['Examples/WebcomponentListSelectFilter.html'](./Examples/WebcomponentListSelectFilter.html).
The web component provides a relatively large number of attributes for configuring the filter form.

The code was created using vibe-coding and has not been thoroughly tested yet.

**Attributes in `<porthd-listselect>`**

| Attributes    | Function                                                                                                                                                    |
|---------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------|
| level         | Level to be displayed for nested lists by default or after a reset                                                                                          |
| filter        | Term to be entered into the search box for the filter                                                                                                       |
| list-tags     | Selectors or HTML tags that each enclose a list element and/or a nested list. The :where() pseudo-class is used for selection.                              |
| search-length | Minimum number of letters that must be entered into the search box                                                                                          |
| label-range   | Text identifier before the slider for setting the displayed nesting depth                                                                                   |
| label-search  | Text identifier before the input field for filtering                                                                                                        |
| label-reset   | Text identifier for the reset button                                                                                                                        |
| placeholder   | Text displayed in the empty input field for filtering                                                                                                       |
| label-style   | List of CSS properties to assign to the two label fields. This is analogous to the style field in normal tags.                                              |
| input-style   | List of CSS properties to assign to the input field. This is analogous to the style field in normal tags.                                                   |
| range-style   | List of CSS properties to assign to the range field. This is analogous to the style field in normal tags. Pseudo-classes are not transferred.               |
| button-style  | List of CSS properties to assign to the reset button. This is analogous to the style field in normal tags.                                                  |
| trim          | The words for autocomplete can be trimmed by the characters, so that, for example, brackets without spaces before a word do not appear in the autocomplete. |

---

### Parameters in porthd-timezone

The web component `<porthd-timezone>` allows the conversion of a date and time from a specific time zone to a date in
another time zone. According to AI, aspects such as daylight saving time should be taken into account.

A usage example can be found here in the documentation
in ['Examples/WebcomponentTimeZone.html'](./Examples/WebcomponentAjax.html)

The code was created using vibe coding and has not yet been thoroughly tested.

**Attributes in `<porthd-timezone>`**
The following table describes the various supported attributes and their functions.

| Attributes      | Function                                                                                                                                                                                                                                                                                     |
|-----------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| datetime        | Attribute with the current time to be converted to a target time. If this attribute is missing,                                                                                                                                                                                              |
| to-timezone     | Defines the time zone to which the specified time should be converted.                                                                                                                                                                                                                       |
| source-timezone | Defines the time zone in which the specified time is located.                                                                                                                                                                                                                                |
| aria-text       | Information text for screen readers about the function of the web component. The text can also contain HTML tags.                                                                                                                                                                            |
| error-text      | Information text if an error has occurred. The text can also contain HTML tags.                                                                                                                                                                                                              |
| parse-format    | In addition to the common ISO formats, the following predefined formats can be used: 'Y-m-d', 'Y-m-d H:i', 'H:i:s', 'd.m.Y', 'm/d/Y', and 'Y-m-d H:i:s'. The specification `Day Month Name Year` is also permitted, provided a list of month names is stored in the `month-names` attribute. |
| month-names     | Defines a list of month names in sorted order. You can concatenate multiple lists containing all months of the year in sorted order. The following is allowed: 'jan,feb.mar,apr,may,jun,jul,aug,sep,oct,nov,dec,jan,feb.mar,apr,may,jun,jul,aug,sep,oct,nov,dec'.                            |

---

### Parameters in Porthd-TocGenerator

A custom web component for dynamically generating a table of contents (TOC) from HTML headings (`h1` to `h6`) within a
specific DOM block.
The web component should be empty because the space is reserved for the dynamically generated table of contents.

#### Features

- Supports all heading levels from `h1` to `h6`
- Nested list depending on level depth
- Optional chapter numbering (`add-number`)
- Start numbering via `chapter-start`
- Multiple TOCs per page possible
- Error handling with customizable text & CSS
- Supports dynamic changes via the `rebuild` attribute

#### Usage

```html

<porthd-tocgenerator
    block="#my-content"
    add-number="true"
    chapter-start="1.0.0.0.0.0"
    pretext="my_anchor_"
    error-text="<strong>Error:</strong> Headings not found."
    error-style="color: red; font-style: italic;"
></porthd-tocgenerator>
```

```html

<div id="my-content">
    <h2>Introduction</h2>
    <h3>Motivation</h3>
    <h2>Main body</h2>
</div>
```

#### Attribute reference

| Attribute       | Type         | Description                                                         |
|-----------------|--------------|---------------------------------------------------------------------|
| `block`         | CSS selector | Target container from which the headings are read. Default: `body`. |
| `add-number`    | `true/false` | Enables chapter numbering. Default: `false`.                        |
| `chapter-start` | `X.X.X.X.X`  | Starting point of the numbering (only if `add-number=true`).        |
| `pretext`       | String       | Prefix for anchor IDs. Allows multiple TOCs at once.                |
| `error-text`    | HTML         | Optional HTML error text if no block or heading is found.           |
| `error-style`   | CSS          | Inline CSS styles for the error DIV.                                |
| `rebuild`       | any          | The TOC is rebuilt every time this attribute is changed.            |

#### Dynamic Rebuild

If the DOM changes within the target block (e.g., a new heading via a button), the TOC can be rebuilt by setting the
`rebuild` attribute:

```js
const toc = document.querySelector('#mein-toc');
toc.setAttribute('rebuild', Date.now().toString());
```

#### Anchor Behavior

Each heading receives an invisible `<span>` element with a unique ID as an anchor. This ID is composed of:

```
[pretext][random_part]_[sequence_number]
```

Example: `my_anchor_kd93kfj2_0`

#### Error Handling

If the `block` is not found or contains no headings, a `<div>` with the error text is displayed. Both the content (
`error-text`) and the style (`error-style`) are fully customizable.

#### Styling

The TOC list uses the `toc` class. Custom CSS rules can be defined for it:

```css
ul.toc {
    list-style: none;
    padding-left: 1em;
}

ul.toc li {
    margin-bottom: 0.3em;
}
```

#### Test Setup

Multiple test cases can be tested simultaneously on an HTML page. For multiple TOCs, make sure to use different
`pretext` values to avoid ID collisions.

---

### Parameters in porthd-vcard

The web component `<porthd-vcard>` includes a list of HTML tags that define the individual parameters in the vcard file.
The usage examples can be found here in the documentation
in ['Examples/WebcomponentVCard.html'](./Examples/WebcomponentVCard.html).
The value in `data-id` determines the respective parameter in the subsequent vCard file.
If necessary, additional parameters may be allowed in the main parameter, such as the TYPE parameter or the VALUE
parameter, or similar, as shown in the table below.
In contrast to the iCalendar Web Component defined in this extension, no other attributes are accepted besides the data
attributes mentioned.
If you add additional data attributes to the included elements, they will be inserted without verification according to
the following scheme:
`<div data-id="ATTACH" data-fmttype="application/postscript">ftp://example.com/pub/reports/r-960812.ps</div>`
results in the following entry in the iCalendar:
`ATTACH;FMTTYPE=application/postscript:ftp://example.com/pub/reports/r-960812.ps`.
Please ensure that a valid combination is always used.

The code was created using vibe-coding and has not been thoroughly tested yet.

**Table with the validated IDs for included elements**

| Parameter     | Definition                                                                                               | `data-value` | `data-type` | `data-`*                                          |
|---------------|----------------------------------------------------------------------------------------------------------|--------------|-------------|---------------------------------------------------|
| ADR           | Address                                                                                                  | 0            | 1           |                                                   |
| ANNIVERSARY   | Anniversary                                                                                              | 1            | 0           |                                                   |
| BDAY          | Birthday                                                                                                 | 1            | 0           |                                                   |
| BIRTHPLACE    | Person's birthplace                                                                                      | 0            | 0           |                                                   |
| CALADRURI     | URL to send an appointment request to the person's calendar                                              | 0            | 0           |                                                   |
| CALURI        | URL to the person's calendar                                                                             | 0            | 0           |                                                   |
| CATEGORIES    | List of tags to describe the object represented by this vCard                                            | 0            | 0           |                                                   |
| CLIENTPIDMAP  | Used to synchronize different revisions of the same vCard.                                               | 0            | 0           |                                                   |
| DEATHDATE     | Person's death date                                                                                      | 0            | 0           |                                                   |
| DEATHPLACE    | Person's death place                                                                                     | 0            | 0           |                                                   |
| EMAIL         | Email address                                                                                            | 0            | 1           |                                                   |
| EXPERTISE     | Person's field of expertise                                                                              | 0            | 0           |                                                   |
| FBURL         | Defines a URL that indicates when the person is free or busy in their calendar., 0, 0                    |              |
| **FN**        | **Full Name (Required)**                                                                                 | **0**        | **0**       | ** **                                             |
| GENDER        | Gender                                                                                                   | 0            | 0           |                                                   |
| GEO           | Geocoordinates (V4.0)                                                                                    | 0            | 0           |                                                   |
| HOBBY         | Person's leisure activity                                                                                | 0            | 0           |                                                   |
| IMPP          | Username for an instant messenger. This was included in the official vCard specification in version 4.0. | 0            | 0           |                                                   |
| INTEREST      | Leisure activity the person is interested in, but not necessarily engaged in.                            | 0            | 0           |                                                   |
| KEY           | Public encryption key (V4.0)                                                                             | 0            | 0           | MEDIATYPE,ENCODING                                |
| KIND          | Defines the entity type this vCard represents: 'Application'                                             | 'Individual' | 'Group'     | 'Location' or 'Organization'; experimental., 0, 0 | ',|
| LABEL         | Language                                                                                                 | 0            | 1           |                                                   |
| LANG          | Language                                                                                                 | 0            | 0           |                                                   |
| LOGO          | Company logo (V4.0)                                                                                      | 1            | 0           | ENCODING                                          |
| MEMBER        | Defines a member of the group this vCard represents.                                                     | 0            | 0           |                                                   |
| N             | Name (V4.0 – optional)                                                                                   | 0            | 0           |                                                   |
| NICKNAME      | Nickname                                                                                                 | 0            | 0           |                                                   |
| NOTE          | Note                                                                                                     | 1            | 0           | LANGUAGE                                          |
| ORG           | Organization                                                                                             | 0            | 1           |                                                   |
| ORG-DIRECTORY | URI for the person's workplace; this can be used to retrieve information about the person's employees.   | 0            | 0           |                                                   |
| PHOTO         | Photo                                                                                                    | 1            | 1           | ENCODING,MEDIATYPE                                |
| RELATED       | Another entity with which the person is related.                                                         | 0            | 1           |                                                   |
| REV           | Last updated                                                                                             | 1            | 0           |                                                   |
| ROLE          | Role                                                                                                     | 0            | 0           |                                                   |
| SOUND         | It specifies the pronunciation of the FN., 0, 0                                                          |              |
| SOURCE        | A URL where the latest version of this vCard can be retrieved.                                           | 0            | 0           |                                                   |
| TEL           | Telephone number                                                                                         | 0            | 1           |                                                   |
| TITLE         | Title                                                                                                    | 0            | 0           |                                                   |
| TZ            | Time zone                                                                                                | 0            | 0           |                                                   |
| URL           | Website                                                                                                  | 0            | 1           | TITLE                                             |
| XML           | All XML data associated with the vCard                                                                   | 0            | 1           | TITLE                                             |

For precise content usage, please refer to the vCard definition [on Wikipedia](https://en.wikipedia.org/wiki/VCard)
or [on the specification](https://www.rfc-editor.org/rfc/rfc6350.html).

To make the file available, a button is defined in the shadow DOM in the web component.
The attributes can be used to define the appearance and text of the button.

**Attributes in `<porthd-vcard>`**

| Attributes   | Function                                                           |
|--------------|--------------------------------------------------------------------|
| button-label | Text of the button, where TEXT can also contain HTML and SVG tags. |
| button-style | CSS properties for the button's style element in the Shadow DOM    |
| file-name    | Name for the file to be downloaded                                 |

---

