"use strict";

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2021 Dr. Dieter Porth <info@mobger.de> - TYPO3-developer
 *
 *  All rights reserved
 *
 *  This script is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

(function () {

  class EasyICalendar extends HTMLAnchorElement {
    constructor() {
      super();
      this.addEventListener('click', this.createFile);
    }

    validateValue(testString) {
      //console.log(testString +  ' is every timer true');
      //every string is OKAY
      return true;
    }

    validateDateTime(testString) {
      /**
       * see around  https://datatracker.ietf.org/doc/html/rfc2445#section-4.3.5

       FORM : DATE
       DTSTART:19980118 // 18 Jan 1998

       FORM #1: DATE_TIME WITH LOCAL TIME

       DTSTART:19980118T230000

       FORM #2: DATE WITH UTC TIME
       DTSTART:19980119T070000Z

       FORM #3: DATE-TIME WITH LOCAL TIME AND TIME ZONE REFERENCE
       DTSTART;TZID=US-Eastern:19980119T020000
       */
      let flag = true,
        withTimezone = testString.split(':'),
        check = ((withTimezone.length === 1)? withTimezone[0] : withTimezone[1]),
        parts= check.split("T");
      if (withTimezone.length > 1){
        flag= flag && (
          (withTimezone[0].substr(0,5) === 'TZID=') ||
          (withTimezone[0] === "VALUE=DATE" )||
          (withTimezone[0] === "VALUE=DATE-TIME")
        )
      }
      //
      flag = flag && (parts.length <=2);
        flag = flag && /[^0-9]/.test(parts[0]);
        flag = flag && parts.length === 8; // 19980123 = 23 Jan 1998
      if (parts.length === 2) {
        if (parts[1].length === 6) {
          flag = flag && /[^0-9]/.test(parts[1]);
        } else if (parts[1].length === 7) {
          flag = flag && /[^0-9]/.test(
            (parts[1].substr(0,6))
          );
          flag = flag && (parts[1].substr(6)==='Z')
        } else {
          flag = flag && (false);
        }
      }
      return flag;
    }

    validateDuration(testString) {
      /**
       * see around https://datatracker.ietf.org/doc/html/rfc5545#section-3.3.6
       *  Format Definition:  This value type is defined by the following
       notation:

       dur-value  = (["+"] / "-") "P" (dur-date / dur-time / dur-week)

       dur-date   = dur-day [dur-time]
       dur-time   = "T" (dur-hour / dur-minute / dur-second)
       dur-week   = 1*DIGIT "W"
       dur-hour   = 1*DIGIT "H" [dur-minute]
       dur-minute = 1*DIGIT "M" [dur-second]
       dur-second = 1*DIGIT "S"
       dur-day    = 1*DIGIT "D"

       */

      let flag = /[^\-+PTWHMSD0-9]/.test(testString),
          split = [...testString];
      flag = flag && (split.length >2); // min length >= 3 = P+DIGIT+Unit
      flag = flag && (
        (split[0] === 'P') ||
        (
          (
            (split[0] === '-') ||
            (split[0] === '+' )
          ) &&
          (split[1] === 'P')
        )
      );
      flag = flag && (/[HMSD]/.test(split[(split.length-1)]));
      return flag; // not fully checked
    }

    validateData(jsonObj) {
      let flag = true;
      // required DTSTAMP          | 1        |                                   |
      //    |   DTSTART          | 1        |                                   |
      //    |   ORGANIZER        | 1        |                                   |
      //    |   SUMMARY          | 1        | Can be null.                      |
      //    |   UID
      flag = flag && (!jsonObj['uid'] ? false : this.validateValue(jsonObj['uid']));
      flag = flag && (!jsonObj['organizer'] ? false : this.validateValue(jsonObj['organizer']));
      flag = flag && (!jsonObj['summary'] ? false : this.validateValue(jsonObj['summary']));
      flag = flag && (!jsonObj['dateStart'] ? false : this.validateDateTime(jsonObj['dateStart'])); // format php-code YmdTHisZ 20210721T235501Z
      flag = flag && (
        (!jsonObj['duration'] ? false : this.validateDuration(jsonObj['duration'])) || // like in DateInterval PHP P0Y0M1DT1H0M0S
        (!jsonObj['dateEnd'] ? false : this.validateDateTime(jsonObj['dateEnd']))
      );


      // optional
      flag = flag && (!jsonObj['location'] ? true : this.validateValue(jsonObj['location'])); //CRLF BreakLine at laest after 75 bytes
      flag = flag && (!jsonObj['contact'] ? true : this.validateValue(jsonObj['contact']));
      flag = flag && (!jsonObj['url'] ? true : this.validateValue(jsonObj['url']));
      flag = flag && (!jsonObj['description']) ? true : this.validateValue(jsonObj['description']);
      return flag;
    }

    createFile(event) {
      let node = this;
      let jsonData = node.getAttribute('eventjson'),
        jsonObj;
      try {
        jsonObj = JSON.parse(jsonData);
        let flag = (((!jsonObj['dateEnd']) && (jsonObj['dateEnd'] !== '')) ? 1 : 0) +
          (((!jsonObj['duration']) && (jsonObj['duration'] !== '')) ? 2 : 0);
        switch (flag) {
          case 3 :
            delete jsonObj['duration'];
            break;
          case 0 :
            jsonObj['dateEnd'] = jsonObj['dateStart']
            break;
          default :
            // do nothing
            break;
        }
        // There is no normalization. The JSON must present korrekt normalized. The Datas are only validated.
        // No correction-magic for idiots: // jsonObj = this.normalizeData(jsonObj);
        // Check only, if datas are formally correct.

        if (this.validateData(jsonObj)) {
          let fileName = jsonObj['fileName'] ?? 'invitation.ics';
          this.makeIcsFile(jsonObj, fileName);
        } else {
          let errorMessage = 'The values of the data are not valid or some data are missing. Check the JSON-String: ' + jsonData;
          this.makeErrorFile(errorMessage);
          console.log(errorMessage);
        }
      } catch (e) {
        let errorMessage = 'Error in JSON?' + jsonData + "\n" + e.message;
        this.makeErrorFile(errorMessage);
        console.log(errorMessage);
        console.log(e); // error in the above string (in this case, yes)!
      }
    }

    folding(text) {
        let split = [...text],
            result = '',
            count = '',
            len = split.length;
        for(let i = 0; i < len; i++) {
          count = count + split[i].length;
          if (count >= 75) {
            result += "\r\n"+ split[i];
            count = split[i].length;
          } else {
            result += "\r\n"+ split[i];
          }
        }
        return result;
    }
    makeErrorFile(message) {
      let fileName = 'error.txt';
      this.save(fileName, message, 'text/plain;charset=utf-8');
    }

    makeIcsFile(jsonObj, fileName) {
      let organizer = this.folding("ORGANIZER:" + jsonObj['organizer']),
        uid = this.folding("UID:" + jsonObj['uid']),
        url = this.folding("URL:" + jsonObj['url']),
        location =( (jsonObj['location'] !== '')?
          this.folding("LOCATION:" +jsonObj['location']):
        ''),
        description =( (jsonObj['description'] !== '')?
          this.folding("LOCATION:" +jsonObj['description']):
        ''),
        contact =( (jsonObj['contact'] !== '')?
          this.folding("LOCATION:" +jsonObj['contact']):
        ''),
        summary =( (jsonObj['summary'] !== '')?
          this.folding("LOCATION:" +jsonObj['summary']):
        ''),
        nowStamp = "DTSTAMP:" + Math.round(((new Date().getUTCMilliseconds()) / 1000)),
        addStartTime = (/[:]/.test( jsonObj['dateStart'])?'':':'),
        startTime = "DTSTART" + addStartTime + jsonObj['dateStart'],
        addEndTime = (/[:]/.test( jsonObj['dateEnd'])?'':':'),
        endTime = ((!jsonObj['duration'])?
          ("DTEND" + addEndTime +jsonObj['dateEnd']):
            ("DURATION:" +          jsonObj['duration'] )
        ),
        calendarText =
          "BEGIN:VCALENDAR\r\n" +  // must contain crlf see https://datatracker.ietf.org/doc/html/rfc5545#section-3.1
          "CALSCALE:GREGORIAN\r\n" +
          "METHOD:PUBLISH\r\n" +
          "PRODID:-//porthd\/webhelp//EN\r\n" +
          "VERSION:2.0\r\n" +
          "BEGIN:VEVENT\r\n" +
          uid + "\r\n" +
          url + "\r\n" +
          organizer + "\r\n" +
          nowStamp + "\r\n"+
          startTime +"\r\n"+
          endTime +"\r\n" +
          location+ "\r\n" +
          contact+ "\r\n" +
          description+ "\r\n" +
          summary+ "\r\n" +
        "END:VEVENT\r\n" +
        "END:VCALENDAR";
      this.save(fileName, calendarText, 'text/calendar;charset=utf-8')
    }

    save(filename, data, type) {
      let blob = new Blob([data], {type: type});
      if (window.navigator.msSaveOrOpenBlob) {
        window.navigator.msSaveBlob(blob, filename);
      } else {
        var elem = window.document.createElement('a');
        elem.href = window.URL.createObjectURL(blob);
        elem.download = filename;
        document.body.appendChild(elem);
        elem.click();
        document.body.removeChild(elem);
      }
    }
  }

// Define the new element, after the DOM is loaded
  customElements.define('easy-icalendar', EasyICalendar, {extends: 'a'});

})();
