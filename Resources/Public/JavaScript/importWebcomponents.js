
import PorthDAjax from "./Module/WebcomponentAjax.js";
import PorthDBreadcrumb from "./Module/WebcomponentBreadcrumb.js";
import PorthDBarChartFromTable from "./Module/WebcomponentBarchartFromTable.js";
import PorthDCodeView from "./Module/WebcomponentCodeview.js";
import PorthDICalendarEventGenerator from "./Module/WebcomponentICalendar.js";
import PorthDInfoModal from "./Module/WebcomponentInfomodal.js";
import PorthDListSelectFilter from "./Module/WebcomponentListSelectFilter.js";
import PorthDTimezone from "./Module/WebcomponentTimeZone.js";
import PorthDTocGenerator from "./Module/WebcomponentTocGenerator.js";
import PorthdVCardGenerator from "./Module/WebcomponentVCard.js";

customElements.define('porthd-ajax', PorthDAjax);
customElements.define('porthd-breadcrumb', PorthDBreadcrumb);
customElements.define('porthd-barchart-from-table', PorthDBarChartFromTable);
customElements.define('porthd-codeview',PorthDCodeView);
customElements.define("porthd-icalendarevent", PorthDICalendarEventGenerator);
customElements.define('porthd-infomodal', PorthDInfoModal);
customElements.define("porthd-listselect", PorthDListSelectFilter);
customElements.define('porthd-timezone', PorthDTimezone);
customElements.define('porthd-tocgenerator', PorthDTocGenerator);
customElements.define("porthd-vcard", PorthdVCardGenerator);

