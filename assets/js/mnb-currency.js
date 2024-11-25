document.addEventListener('DOMContentLoaded', function () {
    const dailyRadio = document.getElementById('rate-daily');
    const monthlyRadio = document.getElementById('rate-monthly');
    const dynamicContent = document.getElementById('dynamic-content');
    const currencyForm = document.getElementById('currency-form');
    const resultContainer = document.getElementById('result-container');
    const baseCurrencySelect = document.getElementById('base-currency');
    const targetCurrencySelect = document.getElementById('target-currency');

    // jQuery UI Datepicker magyar nyelvi beállításai
    $.datepicker.regional['hu'] = {
        closeText: 'Kész',
        prevText: 'Előző',
        nextText: 'Következő',
        currentText: 'Ma',
        monthNames: ['Január', 'Február', 'Március', 'Április', 'Május', 'Június', 'Július', 'Augusztus', 'Szeptember', 'Október', 'November', 'December'],
        monthNamesShort: ['Január', 'Február', 'Március', 'Április', 'Május', 'Június', 'Július', 'Augusztus', 'Szeptember', 'Október', 'November', 'December'],
        dayNames: ['Vasárnap', 'Hétfő', 'Kedd', 'Szerda', 'Csütörtök', 'Péntek', 'Szombat'],
        dayNamesShort: ['Vas', 'Hét', 'Ked', 'Sze', 'Csü', 'Pén', 'Szo'],
        dayNamesMin: ['V', 'H', 'K', 'Sz', 'Cs', 'P', 'Sz'],
        weekHeader: 'Hét',
        dateFormat: 'yy-mm',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: true,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['hu']);

    function updateContent() {
        if (dailyRadio.checked) {
            dynamicContent.innerHTML = `
                <label for="date-picker">Válassz dátumot:</label>
                <input type="date" id="date-picker" name="selected-date" required>
            `;
        } else if (monthlyRadio.checked) {
            dynamicContent.innerHTML = `
                <label for="month-picker">Válassz hónapot és évet:</label>
                <input type="text" id="month-picker" name="selected-month" required>
            `;

            $('#month-picker').datepicker({
                dateFormat: 'yy-mm',
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                onClose: function (dateText, inst) {
                    const month = inst.selectedMonth + 1;
                    const year = inst.selectedYear;
                    $(this).val(`${year}-${month < 10 ? '0' + month : month}`);
                },
                beforeShow: function (input, inst) {
                    $(".ui-datepicker-calendar").hide();
                }
            }).focus(function () {
                $(".ui-datepicker-calendar").hide();
            });
        }
    }

    // Inicializáljuk a tartalmat
    updateContent();

    // Event listener a rádiógombokra
    dailyRadio.addEventListener('change', updateContent);
    monthlyRadio.addEventListener('change', updateContent);

    // AJAX kérés az űrlap elküldéséhez és az eredmény megjelenítéséhez
    currencyForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(currencyForm);
        const baseCurrency = baseCurrencySelect.value;
        const targetCurrency = targetCurrencySelect.value;
        
        fetch('/models/SoapProcess.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json()) // Feldolgozzuk JSON formátumban a választ
        .then(response => {
            // HTML eredmény beillesztése
            resultContainer.innerHTML = response.html;

            // Grafikon létrehozása a kapott adatokkal, ha adatok érkeztek és a 'monthly' radio gomb van kiválasztva
            if (monthlyRadio.checked && response.chartData.length > 0) {
                createChart(response.chartData, baseCurrency, targetCurrency);
            }
        })
        .catch(error => {
            console.error('Hiba történt:', error);
        });
    });

    function createChart(chartData, baseCurrency, targetCurrency) {
        chartData.reverse();
        let labels = chartData.map(item => item.date.split('-')[2]);
        let yearMonth = chartData[0].date.substring(0, 7); // 'YYYY-MM' formátum

        const data = {
            labels: labels,
            datasets: [{
                label: `${targetCurrency} / ${baseCurrency} árfolyam: ${yearMonth}`,
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: chartData.map(item => item.rate),
            }]
        };

        const config = {
            type: 'line',
            data: data,
            options: {}
        };

        const existingCanvas = resultContainer.querySelector('canvas');
        if (existingCanvas) {
            resultContainer.removeChild(existingCanvas);
        }

        const canvas = document.createElement('canvas');
        resultContainer.appendChild(canvas);
        new Chart(canvas, config);
    }
    
});
