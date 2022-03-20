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

  class EasyVCard extends HTMLAnchorElement {
    constructor() {
      console.log('easy-vcard');
      super();
      this.addEventListener('click', this.createFile);
    }



    validateData(jsonObj) {
      let flag = true;
      // to do define Validation
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
    padDouble(number) {
      if (number < 10) {
        return '0' + number;
      }
      return number;
    }

    currentDateToPseudoIsoString() {
      let date = new Date();
      return date.getUTCFullYear() +
        + this.padDouble(date.getUTCMonth() + 1) +
        + this.padDouble(date.getUTCDate()) +
        'T'+
        + this.padDouble(date.getUTCHours()) +
        + this.padDouble(date.getUTCMinutes()) +
        + this.padDouble(date.getUTCSeconds()) +
        'Z';
    };
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
      console.log('start');
      let name = "N:"+ jsonObj['n']+"\r\n",
        revDate =  "REV:"+this.currentDateToPseudoIsoString()+"\r\n",
        fullname =  ( (jsonObj['fn'] !== '')?
          this.folding("FN:" +jsonObj['FN']):
          ''),
        email = ( (jsonObj['email'] !== '')?
          this.folding("EMAIL:" +jsonObj['email']):
        ''),
      geo = ( (jsonObj['geo'] !== '')?
          this.folding("GEO:" +jsonObj['geo']):
        ''),
      key = ( (jsonObj['key'].length > 0)? // Array
          "KEY"+jsonObj['key'].join("\r\nKEY")+"\r\n":
        ''),
      adr = ( (jsonObj['adr'].length > 0)?  // Array
          "ADR"+jsonObj['adr'].join("\r\nADR")+"\r\n":
        ''),
      logo = ( (jsonObj['logo'] !== '')?
          this.folding("LOGO:" +jsonObj['logo']):
        ''),
      n = ( (jsonObj['n'] !== '')?
          this.folding("N:" +jsonObj['n']):
        ''),
      note = ( (jsonObj['note'] !== '')?
          this.folding("NOTE:" +jsonObj['note']):
        ''),
      org = ( (jsonObj['org'] !== '')?
          this.folding("ORG:" +jsonObj['org']):
        ''),
      photo = ( (jsonObj['photo'] !== '')?
          this.folding("PHOTO:" +jsonObj['photo']):
        ''),
      role = ( (jsonObj['role'] !== '')?
          this.folding("ROLE:" +jsonObj['role']):
        ''),
        tel= ( (jsonObj['tel'].length > 0)?  // Array
          "TEL"+jsonObj['tel'].join("\r\nTEL")+"\r\n":
          ''),
      title = ( (jsonObj['title'] !== '')?
          this.folding("TITLE:" +jsonObj['title']):
        ''),
      tz = ( (jsonObj['tz'] !== '')?
          this.folding("TZ:" +jsonObj['tz']):
        ''),
      uid = ( (jsonObj['uid'] !== '')?
          this.folding("UID:" +jsonObj['uid']):
        ''),
      url = ( (jsonObj['url'] !== '')?
          this.folding("URL:" +jsonObj['url']):
        ''),
      version = "VERSION:4.0"+"\r\n";
      let vcardText =
          "BEGIN:VCARD"+"\r\n" +
      version +
      name +
      fullname +
          email +
      geo +
      key +
      adr +
      logo +
      n +
      note +
      org +
      photo +
      role +
      tel +
      title +
      tz +
      uid +
      url +
         revDate +
      "END:VCARD";
      console.log('start save');
      this.save(fileName, vcardText, 'text/vcard;charset=utf-8');
      console.log('save done');
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
  customElements.define('easy-vcard', EasyVCard, {extends: 'a'});

})();
