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

                            <!-- CurrencySelect.php beillesztése, hogy a legördülő menük dinamikusan töltsenek be -->
                            <?php include __DIR__ . '/../models/CurrencySelect.php'; ?>

                            <div style="margin-top: 20px;">
                                <button type="submit">Lekérdezés</button>
                            </div>
                        </form>
                        <!-- Árfolyam eredmény blokk, előre elhelyezve -->
                        <div id="result-container" class="rate-result"></div>
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
    </body>
</html>
