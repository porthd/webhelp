
class PorthDICalendarEventGenerator extends HTMLElement {
  constructor() {
    super();
    this.attachShadow({ mode: "open" });

    this.button = document.createElement("button");
    this.updateButton();
    this.button.addEventListener("click", () => this.downloadICalendar());

    this.shadowRoot.appendChild(this.button);
  }

  connectedCallback() {
    this.updateButton();
  }

  static get observedAttributes() {
    return ["button-label", "button-style", "file-name", "prodid"];
  }

  attributeChangedCallback() {
    this.updateButton();
  }

  updateButton() {
    this.button.innerHTML = this.getAttribute("button-label") || "download iCal";
    this.button.setAttribute("style", this.getAttribute("button-style") ||
      "background: #007bff; color: white; padding: 10px 15px; border-radius: 5px; border: none; cursor: pointer;");
  }

  downloadICalendar() {
    const validAttributes = {
      "BEGIN": "VEVENT - define a neu event in the file. Not needed for onyl one event",
      "END": "VEVENT - define a neu event in the file. Not needed for onyl one event",

      "UID": "Unique Identification Number of the Event (required)",
      "DTSTAMP": "Creation Timestamp (required)",
      "DTSTART": "Event Start Time (required)",

      "CALSCALE": "Calendar Scale (e.g., GREGORIAN)",
      "METHOD": "Method for the Calendar (e.g., PUBLISH)",
      "X-WR-CALNAME": "Calendar Display Name",
      "X-WR-TIMEZONE": "Calendar Time Zone",
      "DTEND": "Event End Time",
      "SUMMARY": "Brief Description of the Event",
      "DESCRIPTION": "Longer Description of the Event",
      "LOCATION": "Event Location",
      "GEO": "Geographical Coordinates (Latitude; Longitude)",
      "PRIORITY": "Priority (1-9, 1 = highest)",
      "STATUS": "Status (e.g., CONFIRMED, CANCELLED)",
      "CLASS": "Visibility (PUBLIC, PRIVATE, CONFIDENTIAL)",
      "CATEGORIES": "Event categories",
      "ATTENDEE": "Event attendees",
      "ORGANIZER": "Organizer",
      "URL": "Web link to the event",
      "ATTACH": "Attachments (e.g., PDF agenda)",
      "SEQUENCE": "Change count for the event",
      "TRANSP": "Transparency (OPAQUE = busy, TRANSPARENT = free)",
      "RECURRENCE-ID": "Reference to a recurring event",
      "RRULE": "Rule for recurring events",
      "EXDATE": "Exceptions for recurrences",
      "CREATED": "Creation time",
      "LAST-MODIFIED": "Last modified time"
    };

    let icalData = "BEGIN:VCALENDAR\nVERSION:2.0\n";
    let errors = [];
    let prodid = this.getAttribute("prodid"); // PRODID wird aus dem Attribut gelesen

    // PRODID in die iCalendar-Daten einfügen, falls gesetzt
    if (prodid) {
      icalData += `PRODID:${prodid}\n`;
    } else {
      icalData += `PRODID:-//PorthDieter porthd//webhelp porthd-icalendarevent//DE\n`;
    }
    // Beginne das Event
    icalData += "BEGIN:VEVENT\n";
    let undefinedRowFlag = false;
    let uidFlag = 0;
    let flagError = true;
    this.querySelectorAll("[data-id]").forEach(element => {
      flagError = false;
      let dataId = element.getAttribute("data-id").toUpperCase();

      if (!validAttributes.hasOwnProperty(dataId)) {
        errors.push(`❌ undefined data-id: ${dataId} (failed validation of allowed fields in iCalendar-events)`);
        flagError = true;
      }

      let value = element.textContent.trim();
      let params = "";

      Array.from(element.attributes).forEach(attr => {
        if (attr.name.startsWith("data-") && attr.name !== "data-id") {
          let paramName = attr.name.replace("data-", "").toUpperCase();
          params += `;${paramName}=${attr.value}`;
        }
      });
      if (dataId === "BEGIN") {
        params = "";
        value = "VEVENT";
        uidFlag = 0;
        undefinedRowFlag = false;
      } else{
        if (undefinedRowFlag) {
          errors.push(`❌ missing beginning of next event in the list after definition-end of the former event.`);
          flagError = true;
        }
      }
      if (dataId === "END") {
        params = "";
        value = "VEVENT";
        undefinedRowFlag = true;
        if (uidFlag !== 15) {
          errors.push(`❌ missing the required field UID (+1), DTSTAMP(+2), DTSTART(+4) or SUMMARY(+8) for the definition of one event. `);
          flagError = true;
        }
      }
      if (dataId === "UID") {
        uidFlag = uidFlag | 1;  // add bit on position 1 in an integer
      }
      if (dataId === "DTSTAMP") {
        uidFlag = uidFlag | 2; // add bit on position 2 in an integer
      }
      if (dataId === "DTSTART") {
        uidFlag = uidFlag | 4; // add bit on position 4 in an integer
      }
      if (dataId === "SUMMARY") {
        uidFlag = uidFlag | 8; // add bit on position 8 in an integer
      }

      if(! flagError ) {
        icalData += `${dataId}${params}:${value}\n`;
      }

    });
    icalData += "END:VEVENT\n";

    icalData += "END:VCALENDAR\n";  // iCalendar-Ende
    if (uidFlag !== 15) {
      errors.push(`❌ missing the required field UID (+1), DTSTAMP(+2), DTSTART(+4) or SUMMARY(+8) for the definition of one event. Found sum: ${uidFlag}.`);
    }

    if(errors.length > 0){
      alert("One or more errors detected:\n\n" + errors.join("\n") + "\n\nGenerated Calendar-Code:\n\n" + icalData);
      return;
    }

    let fileName = this.getAttribute("file-name") || "calendar.ics";
    if (!fileName.toLowerCase().endsWith(".ics")) {
      fileName += ".ics";
    }

    const blob = new Blob([icalData], { type: "text/calendar" });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = fileName;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
  }
}


export default PorthDICalendarEventGenerator;
