
class PorthDBarChartFromTable extends HTMLElement {
  constructor() {
    super();
    this.attachShadow({mode: 'open'});
    this.defaultColors = ['red', 'orange', 'green', 'blue', 'violet', 'pink'];
    this.chartJsUrl = this.getAttribute('chartjs-url') || 'https://cdn.jsdelivr.net/npm/chart.js';

    this.ready = this.loadChartJsScript();
  }

  connectedCallback() {
    this.ready.then(() => this.render());
  }

  async loadChartJsScript() {
    if (window.Chart) return;

    return new Promise(resolve => {
      const script = document.createElement('script');
      script.src = this.chartJsUrl;
      script.onload = () => {
        if (window.Chart) {
          resolve();
        } else {
          console.error("Chart.js konnte/wurde nicht geladen werden!");
        }
      };
      document.body.appendChild(script);
    });
  }

  static get observedAttributes() {
    return ['title-column', 'value-column', 'colors', 'orientation', 'transpose', 'chartjs-url'];
  }

  attributeChangedCallback() {
    this.ready.then(() => this.render());
  }

  render() {
    const titleIndex = parseInt(this.getAttribute('title-column') || '0');
    const orientation = this.getAttribute('orientation') || 'vertical';
    const transpose = this.hasAttribute('transpose');
    const colorList = (this.getAttribute('colors') || this.defaultColors.join(',')).split(',');

    const table = this.querySelector('table');
    if (!table) return;

    const shadow = this.shadowRoot;
    shadow.innerHTML = '';

    const container = document.createElement('div');

    const buttonText = this.getAttribute('button-text');
    let toggleBtn;
    if (buttonText && buttonText.trim()) {
      toggleBtn = document.createElement('button');
      toggleBtn.innerHTML = buttonText;
      toggleBtn.addEventListener('click', () => {
        tableVisible = !tableVisible;
        tableClone.style.display = tableVisible ? 'table' : 'none';
      });
    }

    const tableClone = table.cloneNode(true);
    tableClone.style.display = 'table';
    let tableVisible = true;

    const chartCanvas = document.createElement('canvas');
    chartCanvas.style.width = '100%';
    if  (typeof toggleBtn !== 'undefined') {
      container.appendChild(toggleBtn);
    }
    container.appendChild(tableClone);
    container.appendChild(chartCanvas);
    shadow.appendChild(container);

    const ctx = chartCanvas.getContext('2d');
    let chart;
    const rows = tableClone.querySelectorAll('tbody tr');
    let selectedValueColumn = 1;
    let selectedRowIndex = 0;

    if (transpose) {
      const thead = tableClone.querySelector('thead');
      const originalHeaderRow = thead.querySelector('tr:last-child');
      const checkboxRow = document.createElement('tr');

      checkboxRow.appendChild(document.createElement('th'));
      const ths = originalHeaderRow.querySelectorAll('th');

      ths.forEach((_, i) => {
        const th = document.createElement('th');
        if (i > 0) {
          const cb = document.createElement('input');
          cb.type = 'checkbox';
          cb.checked = true;
          cb.addEventListener('change', () => updateChart());
          th.appendChild(cb);
        }
        checkboxRow.appendChild(th);
      });

      thead.insertBefore(checkboxRow, originalHeaderRow);

      rows.forEach((row, idx) => {
        const td = document.createElement('td');
        const rb = document.createElement('input');
        rb.type = 'radio';
        rb.name = 'value-row';
        rb.checked = idx === 0;
        rb.addEventListener('change', () => {
          selectedRowIndex = idx;
          updateChart();
        });
        td.appendChild(rb);
        row.insertBefore(td, row.firstChild);
      });

      originalHeaderRow.insertBefore(document.createElement('th'), originalHeaderRow.firstChild);
    } else {
      rows.forEach(row => {
        const cb = document.createElement('input');
        cb.type = 'checkbox';
        cb.checked = true;
        cb.addEventListener('change', () => updateChart());
        const td = document.createElement('td');
        td.appendChild(cb);
        row.insertBefore(td, row.firstChild);
      });

      const headerRow = tableClone.querySelector('thead tr');
      if (headerRow) {
        headerRow.insertBefore(document.createElement('th'), headerRow.firstChild);

        let flag = true;
        for (let i = 1; i < headerRow.cells.length; i++) {
          const cell = headerRow.cells[i];
          let radio;
                    if (i>1) {
            radio = document.createElement('input');
            radio.type = 'radio';
            radio.name = 'value-column';
            radio.checked = flag;
            flag = false;
            radio.addEventListener('change', () => {
              selectedValueColumn = i;
              updateChart();
            });
          } else {
            radio = document.createElement('span');
            radio.innerHTML="&nbsp;";
          }
          cell.insertBefore(document.createElement('br'), cell.firstChild);
          cell.insertBefore(radio, cell.firstChild);
        }
        selectedValueColumn = 2;
      }
    }

    const updateChart = () => {
      let labels = [];
      let values = [];

      if (transpose) {
        const checkboxRow = tableClone.querySelector('thead tr:first-child');
        const colCheckboxes = checkboxRow.querySelectorAll('input[type="checkbox"]');
        const labelCells = tableClone.querySelectorAll('thead tr:last-child th');
        const selectedRow = tableClone.querySelectorAll('tbody tr')[selectedRowIndex];
        if (!selectedRow) return;
        const cells = selectedRow.querySelectorAll('td');

        for (let i = 1; i < cells.length; i++) {
          const cb = colCheckboxes[i - 2];
          if (!cb || !cb.checked) continue;

          const label = labelCells[i]?.textContent.trim();
          const val = parseFloat(cells[i].textContent);
          if (label && !isNaN(val)) {
            labels.push(label);
            values.push(val);
          }
        }
      } else {
        rows.forEach(row => {
          const cells = row.querySelectorAll('td');
          const cb = cells[0].querySelector('input[type="checkbox"]');
          if (!cb || !cb.checked) return;

          const label = cells[titleIndex + 1]?.textContent?.trim();
          const val = parseFloat(cells[selectedValueColumn]?.textContent);
          if (label && !isNaN(val)) {
            labels.push(label);
            values.push(val);
          }
        });
      }

      if (chart) chart.destroy();

      chart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Werte',
            data: values,
            backgroundColor: labels.map((_, i) => colorList[i % colorList.length])
          }]
        },
        options: {
          plugins: {
            legend: { display: false },
            title: { display: false }
          },
          responsive: true,
          indexAxis: orientation === 'horizontal' ? 'y' : 'x',
          scales: {
            x: { beginAtZero: true },
            y: { beginAtZero: true }
          }
        }
      });
    };

    updateChart();
  }
}


export default PorthDBarChartFromTable;
