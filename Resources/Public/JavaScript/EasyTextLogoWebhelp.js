"use strict";

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2021 Dr. Dieter Porth <info@mobger.de>
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

  // Create a class for the element
  class PopUpInfo extends HTMLElement {
    // Specify observed attributes so that
    // attributeChangedCallback will work
    static get observedAttributes() {
      return ['my-text-json', 'my-logo'];
    }
    constructor() {

      // Always call super first in constructor
      super();

      const stopSignSvg = '<svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="600px" height="600px" viewBox="-5 -5 610 610" id="stop-sign"><g><path style="fill:#ffffff;stroke:#000000;stroke-width:3;stroke-miterlimit:4;stroke-opacity:1;stroke-dasharray:none" d="m 188.3,599.7 c -8.5,-0.4 -15.1,-3.6 -20.2,-7.6 L 7.8,431.8 5.6,429.1 C 2.2,423.7 0.7,420.3 0.2,413.3 l 0,-226.7 C 1.2,176.6 4.3,172.6 9.2,167.2 L 166.9,9.0 c 6.0,-5.2 9.8,-7.5 19.6,-8.8 l 226.7,0 c 8.8,1.0 13.7,3.8 19.3,8.9 L 590.7,167.2 c 6.1,6.9 8.3,11.5 8.9,19.3 l 0,226.7 c -0.9,7.8 -2.0,12.4 -7.6,18.4 L 431.8,592.1 c -5.0,4.5 -10.8,7.3 -18.4,7.6 l -224.9,0" /><path style="fill:#c1121c;fill-opacity:1;fill-rule:evenodd;stroke:none" d="m 188.3,569.6 -158.0,-158.0 0,-223.2 158.0,-158.0 223.2,0 158.0,158.0 0,223.2 -158.0,158.0 -223.2,0" /><path style="fill:#fffefe;fill-rule:evenodd;stroke:none" d="m 70.7,345.1 29.6,0 c -3.5,20.7 9.7,37.5 30.9,30.0 7.4,-3.5 12.7,-10.1 12.9,-18.3 -0.4,0.5 4.7,-32.0 -12.5,-41.8 -24.6,-9.6 -48.5,-15.2 -57.0,-43.1 -4.8,-16.4 -4.0,-46.6 8.9,-60.1 35.1,-39.4 96.1,-11.7 89.8,43.5 l -30.0,0 c 0.5,-11.7 1.0,-23.4 -10.7,-29.6 -7.1,-3.8 -18.2,-3.0 -23.8,3.1 -8.7,8.2 -6.9,21.2 -6.2,31.8 3.2,19.0 30.0,19.1 42.2,27.3 18.3,9.6 28.0,25.1 28.7,45.8 1.1,28.4 1.0,48.2 -24.2,65.5 -39.8,21.3 -84.4,-6.7 -78.5,-54.3 z m 149.5,59.7 0,-181.4 -35.4,0 0,-28.2 101.0,0 0,28.2 -35.4,0 0,181.4 -30.0,0 z m 80.8,-48.5 0,-115.8 0.4,-6.2 1.7,-5.8 2.2,-5.8 3.1,-5.8 c 6.9,-12.0 22.7,-21.8 36.3,-22.9 30.5,-3.8 56.1,19.2 57.0,49.8 l 0,112.7 -0.4,3.1 -0.4,6.2 -1.7,6.2 -2.2,5.8 -3.1,5.3 c -6.8,11.8 -22.8,22.0 -36.3,22.9 -28.9,4.3 -57.9,-20.1 -56.5,-49.8 z m 29.6,0 0,-113.6 0.4,-2.6 0.4,-2.6 1.3,-2.2 0.8,-2.2 c 4.8,-6.1 6.9,-7.8 14.8,-9.4 12.3,-1.4 23.3,7.6 23.3,20.2 l 0,114.0 -0.4,2.2 -0.4,2.6 -0.8,2.2 -1.3,2.2 c -4.2,6.1 -7.5,7.9 -14.8,9.4 -12.0,1.8 -23.2,-8.1 -23.3,-20.2 z m 101.0,48.5 0,-209.7 c 41.5,-4.0 94.4,-5.2 97.4,48.5 5.9,52.2 -11.3,83.6 -67.3,79.0 l 0,82.1 -30.0,0 z M 461.9,223.4 c 17.9,-1.5 37.3,-1.9 39.5,20.2 2.4,38.0 2.1,54.9 -39.5,50.7 l 0,-70.9" /></g></svg>';
      const baseStopSignSvg = btoa(stopSignSvg);

      // Create a shadow root
      const shadow = this.attachShadow({mode: 'open'});

      // Create spans
      const wrapper = document.createElement('span');
      wrapper.setAttribute('class', 'wrapper');

      const icon = document.createElement('span');
      icon.setAttribute('class', 'icon');
      icon.setAttribute('tabindex', 0);

      const info = document.createElement('span');
      info.setAttribute('class', 'info');

      // Take attribute content and put it inside the info span
      let  myText =  this.getAttribute('my-text-json');
      if (myText) {
        myText = JSON.parse(myText);
      }
      info.innerHTML = myText;

      // Insert icon
      let logoUrl = '',
          flagImg = false;
      if(this.hasAttribute('my-logo')) {
        logoUrl = this.getAttribute('my-logo');
        flagImg = (logoUrl !== '');
      }
      if (!flagImg) {
        logoUrl = 'data:image/svg+xml;base64,'+baseStopSignSvg;
      }

      const img = document.createElement('img');
      img.src = logoUrl;
      icon.appendChild(img);

      // Create some CSS to apply to the shadow dom
      const style = document.createElement('style');

      style.textContent = `
      .wrapper {
        position: relative;
      }
      .info {
        font-size: 0.8rem;
        width: 200px;
        display: inline-block;
        border: 1px solid black;
        padding: 10px;
        background: white;
        border-radius: 10px;
        opacity: 0;
        transition: 0.6s all;
        position: absolute;
        bottom: 20px;
        left: 10px;
        z-index: 3;
      }
      img {
        width: 1.2rem;
      }
      .icon:hover + .info, .icon:focus + .info {
        opacity: 1;
      }
    `;

      // Attach the created elements to the shadow dom
      shadow.appendChild(style);
      shadow.appendChild(wrapper);
      wrapper.appendChild(icon);
      wrapper.appendChild(info);
    }
  }

  // Define the new element, after the DOM is loaded
  customElements.define('popup-info', PopUpInfo);
})();
