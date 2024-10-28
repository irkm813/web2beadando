<!DOCTYPE HTML>
<html>
    <!-- Html header betöltése -->
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <head>
        <!-- Stílusok betöltése -->
        <link rel="stylesheet" href="assets/css/mnb-currency.css">
    </head>

    <body class="mnb-currency">
        <div id="page-wrapper">

        <!-- Menü elemek betöltése -->
        <?php include __DIR__ . '/../includes/menu.php'; ?>

            <!-- Main -->
            <div class="wrapper style1">

                <div class="container">
                    <article id="main" class="special">
                        <header>
                            <h2>Deviza Árfolyam Lekérdezés</h2>
                            <p>
                                Válaszd ki, hogy napi vagy havi árfolyamot szeretnél lekérdezni.
                            </p>
                        </header>

                        <!-- Árfolyam lekérdezés űrlap -->
                        <form id="currency-form" method="post" action="/models/SoapProcess.php">
                            <div style="margin: 10px 0; display: inline-block;">
                                <input
                                    type="radio"
                                    id="rate-daily"
                                    name="rateType"
                                    value="daily"
                                    required
                                    checked
                                >
                                <label for="rate-daily" class="radio-label">Napi árfolyam</label>
                            </div>
                            <div style="margin: 10px 0; display: inline-block;">
                                <input
                                    type="radio"
                                    id="rate-monthly"
                                    name="rateType"
                                    value="monthly"
                                    required
                                >
                                <label for="rate-monthly" class="radio-label">Havi árfolyam</label>
                            </div>
                            <div id="dynamic-content" style="margin-top: 20px;">
                                <!-- Dinamikusan frissülő tartalom ide kerül -->
                                <label for="date-picker">Válassz dátumot:</label>
                                <input type="date" id="date-picker" name="selected-date" required>
                            </div>

                            <!-- Base currency legördülő menü -->
                            <div style="margin-top: 20px;">
                                <label for="base-currency">Válassz alap devizát:</label>
                                <select id="base-currency" name="base-currency" required>
                                    <option value="HUF" selected>HUF - Hungarian Forint</option>
                                    <option value="EUR">EUR - Euro</option>
                                    <option value="USD">USD - US Dollar</option>
                                    <option value="GBP">GBP - British Pound</option>
                                    <option value="JPY">JPY - Japanese Yen</option>
                                    <option value="CHF">CHF - Swiss Franc</option>
                                    <option value="CAD">CAD - Canadian Dollar</option>
                                    <option value="AUD">AUD - Australian Dollar</option>
                                    <option value="CNY">CNY - Chinese Yuan</option>
                                    <option value="RUB">RUB - Russian Ruble</option>
                                    <option value="PLN">PLN - Polish Zloty</option>
                                    <option value="CZK">CZK - Czech Koruna</option>
                                    <option value="NOK">NOK - Norwegian Krone</option>
                                    <option value="SEK">SEK - Swedish Krona</option>
                                    <option value="DKK">DKK - Danish Krone</option>
                                    <option value="BGN">BGN - Bulgarian Lev</option>
                                    <option value="RON">RON - Romanian Leu</option>
                                    <option value="HRK">HRK - Croatian Kuna</option>
                                    <option value="ZAR">ZAR - South African Rand</option>
                                    <option value="INR">INR - Indian Rupee</option>
                                    <!-- További devizák hozzáadhatók, amennyiben szükséges -->
                                </select>
                            </div>

                            <!-- Target currency legördülő menü -->
                            <div style="margin-top: 20px;">
                                <label for="target-currency">Válassz cél devizát:</label>
                                <select id="target-currency" name="target-currency" required>
                                    <option value="HUF">HUF - Hungarian Forint</option>
                                    <option value="EUR">EUR - Euro</option>
                                    <option value="USD" selected>USD - US Dollar</option>
                                    <option value="GBP">GBP - British Pound</option>
                                    <option value="JPY">JPY - Japanese Yen</option>
                                    <option value="CHF">CHF - Swiss Franc</option>
                                    <option value="CAD">CAD - Canadian Dollar</option>
                                    <option value="AUD">AUD - Australian Dollar</option>
                                    <option value="CNY">CNY - Chinese Yuan</option>
                                    <option value="RUB">RUB - Russian Ruble</option>
                                    <option value="PLN">PLN - Polish Zloty</option>
                                    <option value="CZK">CZK - Czech Koruna</option>
                                    <option value="NOK">NOK - Norwegian Krone</option>
                                    <option value="SEK">SEK - Swedish Krona</option>
                                    <option value="DKK">DKK - Danish Krone</option>
                                    <option value="BGN">BGN - Bulgarian Lev</option>
                                    <option value="RON">RON - Romanian Leu</option>
                                    <option value="HRK">HRK - Croatian Kuna</option>
                                    <option value="ZAR">ZAR - South African Rand</option>
                                    <option value="INR">INR - Indian Rupee</option>
                                    <!-- További devizák hozzáadhatók, amennyiben szükséges -->
                                </select>
                            </div>

                            <div style="margin-top: 20px;">
                                <button type="submit">Lekérdezés</button>
                            </div>
                        </form>
                        <!-- Árfolyam eredmény blokk, előre elhelyezve -->
                        <div id="result-container" class="rate-result"></div>
                        <canvas id="exchangeRateChart" width="400" height="200"></canvas>
                    </article>
                </div>
            </div>

        </div>

        <!-- Scripts -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/jquery.dropotron.min.js"></script>
        <script src="assets/js/jquery.scrolly.min.js"></script>
        <script src="assets/js/jquery.scrollex.min.js"></script>
        <script src="assets/js/browser.min.js"></script>
        <script src="assets/js/breakpoints.min.js"></script>
        <script src="assets/js/util.js"></script>
        <script src="assets/js/main.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <script src="assets/js/mnb-currency.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="assets/js/init-chart.js"></script>
    </body>
</html>
