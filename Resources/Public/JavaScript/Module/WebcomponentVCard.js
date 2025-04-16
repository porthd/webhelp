
class PorthdVCardGenerator extends HTMLElement {
  constructor() {
    super();
    this.attachShadow({mode: "open"});

    // Button erstellen
    this.button = document.createElement("button");
    this.updateButton();
    this.button.addEventListener("click", () => this.downloadVCard());

    this.shadowRoot.appendChild(this.button);
  }

  connectedCallback() {
    this.updateButton();
  }

  static get observedAttributes() {
    return ["button-label", "button-style", "file-name"];
  }

  attributeChangedCallback() {
    this.updateButton();
  }

  updateButton() {
    this.button.innerHTML = this.getAttribute("button-label") || "download vCard";
    this.button.setAttribute("style", this.getAttribute("button-style") ||
      "background: #007bff; color: white; padding: 10px 15px; border-radius: 5px; border: none; cursor: pointer;");
  }

  downloadVCard() {
    const vCardAttributes = {
      // PARAM_IN_VCARD : [ Description, flagVALUE, flagTYPE, additional data-Parameter ]
      "FN": ["Full Name (Required)", 0, 0, '',],

      "ADR": ["Address", 0, 1, '',],
      "ANNIVERSARY": ["Anniversary", 1, 0, '',],
      "BDAY": ["Birthday", 1, 0, '',],
      "CALADRURI": ["A URL to use for sending a scheduling request to the person's calendar", 0, 0, '',],
      "CALURI": ["A URL to the person's calendar", 0, 0, '',],
      "CATEGORIES": ["A list of 'tags' that can be used to describe the object represented by this vCard", 0, 0, '',],
      "CLIENTPIDMAP": ["Used for synchronizing different revisions of the same vCard.", 0, 0, '',],
      "EMAIL": ["Email Address", 0, 1, '',],
      "FBURL": ["Defines a URL that shows when the person is 'free' or 'busy' on their calendar.", 0, 0, '',],
      "GEO": ["Geo-coordinates (V4.0)", 0, 0, '',],
      "GENDER": ["Gender", 0, 0, '',],
      "KEY": ["Public encryption-key (V4.0)", 0, 0, 'MEDIATYPE,ENCODING',],
      "KIND": ["Defines the type of entity that this vCard represents: 'application', 'individual', 'group', 'location' or 'organization'; experimental.", 0, 0, '',],
      "LABEL": ["Language", 0, 1, '',],
      "LANG": ["Language", 0, 0, '',],
      "LOGO": ["Company Logo (V4.0)", 1, 0, 'ENCODING',],
      "MEMBER": ["Defines a member that is part of the group that this vCard represents.", 0, 0, '',],
      "N": ["Name (V4.0 - optional)", 0, 0, '',],
      "NICKNAME": ["Nickname", 0, 0, '',],
      "NOTE": ["Note", 1, 0, 'LANGUAGE',],
      "ORG": ["Organization", 0, 1, '',],
      "PHOTO": ["Photo", 1, 1, 'ENCODING,MEDIATYPE',],
      "RELATED": ["Another entity that the person is related to.", 0, 1, '',],
      "REV": ["Last Updated", 1, 0, '',],
      "ROLE": ["Role", 0, 0, '',],
      "SOUND": ["It specifies the pronunciation of the FN.", 0, 0, '',],
      "SOURCE": ["A URL that can be used to get the latest version of this vCard.", 0, 0, '',],
      "TEL": ["Phone Number", 0, 1, '',],
      "TITLE": ["Title", 0, 0, '',],
      "TZ": ["Time-zone", 0, 0, '',],
      "URL": ["Website", 0, 1, 'TITLE',],
      "XML": ["Any XML data that is attached to the vCar", 0, 1, 'TITLE',],

      "BIRTHPLACE": ["Person's birthplace",0,0,''],
      "DEATHDATE": ["Person's death date",0,0,''],
      "DEATHPLACE": ["Person's death place",0,0,''],
      "EXPERTISE": ["Field of expertise the person has",0,0,''],
      "HOBBY": ["Leisure activity the person pursues",0,0,''],
      "IMPP": ["Handle to an instant messenger. This was included in the official vCard specification in version 4.0.",0,0,''],
      "INTEREST": ["Leisure activity the person is interested in, but not necessarily participating in.",0,0,''],
      "ORG-DIRECTORY": ["URI representing the person's workplace; this can be used to obtain information about the person's employees",0,0,''],
    };

    let vcardData = "BEGIN:VCARD\nVERSION:4.0\n";
    let errors = [];
    this.querySelectorAll(":not([data-id])").forEach(element => {
      let lostValue =  element.textContent.trim(); // Entferne TYPE/EXTRA
      errors.push(`❌ Missing data-id with value:\n\n>>>"${lostValue}"<<<\n\n\nCurrent text-string:\n` + this.innerHTML);
    });

    // Validation: Missing or invalid data-id values
    this.querySelectorAll("[data-id]").forEach(element => {
      let dataId = element.getAttribute("data-id").split(";")[0]; // Entferne TYPE/EXTRA
      dataId = dataId.toUpperCase();
      if (!vCardAttributes[dataId]) {
        errors.push(`❌ Unknown data-id: ${dataId} → no valid vCard 4.0 attribute.`);
      }
    });

    // Check required fields
    if (!this.querySelector("[data-id='FN']")) errors.push("❌ Required field missing: FN (Full Name) - Case sensitive?");

    // If errors occur, abort
    if (errors.length > 0) {
      alert(`Error generating vCard:\n\n${errors.join("\n")}`);
      return;
    }
    // add only valid attributes into vCard
    // The additional attributes type and value are not checked!!
    let flagError = false;
    this.querySelectorAll("[data-id]").forEach(element => {
      flagError = false;
      let attr = element.getAttribute("data-id");
      attr = attr.toUpperCase(); // base-attribute (without TYPE/EXTRA)
      if (!vCardAttributes.hasOwnProperty(attr)) {
        errors.push(`❌ undefined data-id: ${attr} (failed validation of allowed fields in vcard-objects)`);
        flagError = true;
      }
      let listAdd = ((vCardAttributes[attr][3])?vCardAttributes[attr][3].split(','):[]);
      let type = ((vCardAttributes[attr][2]) ? element.getAttribute("data-type"): '');
      let value = ((vCardAttributes[attr][1]) ?element.getAttribute("data-value"):'');
      let content = element.textContent.trim();

      if (!flagError) {
        let vcardLine = attr;
        if (type) vcardLine += `;TYPE=${type}`;
        if (value) vcardLine += `;VALUE=${value}`;
        if (listAdd.length>0) {
          listAdd.forEach((param) =>{
            let dataparam= 'data-'+ param.toLowerCase();
            let datavalue = element.getAttribute(dataparam);
            if (datavalue) vcardLine += `;${param}=${datavalue}`;
          });
        }
        vcardLine += `:${content}`;
        vcardData += vcardLine + "\n";
      }
    });

    vcardData += "END:VCARD";
    if (errors.length > 0) {
      alert(`Error generating vCard:\n\n${errors.join("\n")}` + "\n\nGenerated Card-Code:\n\n" + vcardData);
      return;
    }

    // Get filename from attribute (default: "contact.vcf")
    let fileName = this.getAttribute("file-name") || "contact.vcf";

    // If the filename does not end with ".vcf", add it automatically
    if (!fileName.toLowerCase().endsWith(".vcf")) {
      fileName += ".vcf";
    }

    // Make file available for download
    const blob = new Blob([vcardData], {type: "text/vcard"});
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


export default PorthdVCardGenerator;
