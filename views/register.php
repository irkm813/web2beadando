<!DOCTYPE HTML>
<html>
    <!-- Html header betöltése -->
    <?php 
    include __DIR__ . '/../includes/header.php';

    // Hibaüzenet kezelése
    $error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
    unset($_SESSION['error']); // Töröljük az üzenetet, hogy ne maradjon meg
    ?>

    <head>
        <!-- Stílusok betöltése -->
        <link rel="stylesheet" href="assets/css/login.css">
    </head>

    <body class="register">
        <div id="page-wrapper">
            <!-- Menü elemek betöltése -->
            <?php include __DIR__ . '/../includes/menu.php'; ?>
            
            <div class="wrapper style1">
                <div class="container">
                    <article id="main" class="special">
                        <header>
                            <?php if (!empty($error)): ?>
                                <!-- Hibaüzenet megjelenítése pirosan -->
                                <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
                            <?php else: ?>
                                <h2>Regisztráció</h2>
                                <p>Regisztrálj új fiókot a felhasználóneved, e-mail címed és jelszavad megadásával!</p>
                            <?php endif; ?>
                        </header>

                        <!-- Regisztrációs űrlap -->
                        <form action="/register" method="POST">
                            <div class="form-group">
                                <label for="username">Felhasználónév</label>
                                <input type="text" id="username" name="username" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Jelszó</label>
                                <input type="password" id="password" name="password" required>
                            </div>

                            <div class="form-group">
                                <label for="confirm_password">Jelszó megerősítése</label>
                                <input type="password" id="confirm_password" name="confirm_password" required>
                            </div>

                            <button type="submit">Regisztráció</button>
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
    </body>
</html>
