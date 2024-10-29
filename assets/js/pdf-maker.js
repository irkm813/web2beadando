document.addEventListener("DOMContentLoaded", function() {
    loadInitialWeeks();  // Kezdeti hetek betöltése
});

// Kezdeti hetek betöltése az alapértelmezett, vagy elsőként megjelenített év alapján
function loadInitialWeeks() {
    const year = document.getElementById("ev").value;
    loadWeeksForYear(year);
}

function loadWeeksForYear(year) {
    fetch(`models/PDFfetchWeeks.php?year=${year}`)  // AJAX hívás a kiválasztott év hetek számának lekérdezéséhez
    .then(response => response.json())
    .then(data => {
        const weekSelect = document.getElementById("het");
        weekSelect.innerHTML = ''; // Hetek törlése

        data.forEach(function(week) {
            const option = document.createElement("option");
            option.value = week.het;
            option.text = week.het;
            weekSelect.appendChild(option);
        });
    })
    .catch(error => console.error('Hiba történt a hetek betöltése közben: ', error));
}

document.getElementById("ev").addEventListener("change", function() {
    loadWeeksForYear(this.value);  // Frissíti a hetek listáját, ha az év megváltozik
});
