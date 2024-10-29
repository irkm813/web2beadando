<!DOCTYPE HTML>
<html>
    <!-- Html header betöltése -->
    <?php 
    include __DIR__ . '/../includes/header.php';

    $db = new DatabaseModel();
    $years = $db->select("huzas", "DISTINCT ev");
    ?>

    
    <head>
            <!-- Stílusok betöltése -->
            <link rel="stylesheet" href="assets/css/pdf-maker.css">
    </head>

    <body class="mnb-currency">
        <div id="page-wrapper">
             <!-- Menü elemek betöltése -->
            <?php include __DIR__ . '/../includes/menu.php'; ?>
        <div class="wrapper style1">
                <div class="container">
                <article id="main" class="special">
                        <header>
                                        <h2>PDF Generálása</h2>
                                        <p>
                                            Válaszd ki, hogy melyik év melyik hetéből szeretnéd a PDF-et generálni.
                                        </p>
                        </header>
                        <!-- Form PDF generáláshoz -->
                        <form action="/models/PDFMaker.php" method="POST">
                            <div class="form-group">
                                <label for="ev">Év:</label>
                                <select id="ev" name="ev" required onchange="loadWeeksForYear(this.value)">
                                    <?php foreach ($years as $year): ?>
                                        <option value="<?= htmlspecialchars($year['ev']) ?>"><?= htmlspecialchars($year['ev']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="het">Hét:</label>
                                <select id="het" name="het" required></select>
                            </div>

                            <button type="submit">PDF generálása</button>
                        </form>
                    </article>
                </div>
            </div>
            <?php include __DIR__ . '/../includes/footer.php'; ?>
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
        <script src="assets/js/pdf-maker.js"></script>
    </body>
</html>