document.addEventListener('DOMContentLoaded', function () {
    const dailyRadio = document.getElementById('rate-daily');
    const monthlyRadio = document.getElementById('rate-monthly');
    const dynamicContent = document.getElementById('dynamic-content');
    const currencyForm = document.getElementById('currency-form');

    // jQuery UI Datepicker magyar nyelvi beállításai
    $.datepicker.regional['hu'] = {
        closeText: 'Kész',
        prevText: 'Előző',
        nextText: 'Következő',
        currentText: 'Ma',
        monthNames: ['Január', 'Február', 'Március', 'Április', 'Május', 'Június', 'Július', 'Augusztus', 'Szeptember', 'Október', 'November', 'December'],
        monthNamesShort: ['Január', 'Február', 'Március', 'Április', 'Május', 'Június', 'Július', 'Augusztus', 'Szeptember', 'Október', 'November', 'December'], // Itt is teljes neveket használunk
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

            // jQuery UI Datepicker inicializálása csak hónapokra és évekre
            $('#month-picker').datepicker({
                dateFormat: 'yy-mm', // Formátum: év-hónap
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                onClose: function (dateText, inst) {
                    const month = inst.selectedMonth + 1;
                    const year = inst.selectedYear;
                    $(this).val(`${year}-${month < 10 ? '0' + month : month}`);
                },
                beforeShow: function (input, inst) {
                    $(".ui-datepicker-calendar").hide(); // Elrejti a napokat tartalmazó naptárrészt
                }
            }).focus(function () {
                $(".ui-datepicker-calendar").hide(); // Napok panel elrejtése
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
    
        fetch('/models/SoapProcess.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.text())
        .then(data => {
            // Eredmény megjelenítése az űrlap után
            let resultContainer = document.getElementById('result-container');
            if (resultContainer) {
                resultContainer.innerHTML = data;
            } else {
                // Új konténer létrehozása az eredmény számára
                resultContainer = document.createElement('div');
                resultContainer.id = 'result-container';
                resultContainer.className = 'rate-result';
                resultContainer.innerHTML = data;
    
                // Az űrlap után helyezzük el a div-et
                document.querySelector('#currency-form').insertAdjacentElement('afterend', resultContainer);
            }
        })
        .catch(error => {
            console.error('Hiba történt:', error);
        });
    });
});
