<!DOCTYPE HTML>
<html>
    <!-- Html header betöltése -->
    <?php 
    include __DIR__ . '/../includes/header.php';

    // Hiba- és sikerüzenet kezelése
    $error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
    $success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
    unset($_SESSION['error']);
    unset($_SESSION['success']);
    ?>

    <head>
        <!-- Stílusok betöltése -->
        <link rel="stylesheet" href="assets/css/login.css">
    </head>

    <body class="mnb-currency">
        <div id="page-wrapper">
            <!-- Menü elemek betöltése -->
            <?php include __DIR__ . '/../includes/menu.php'; ?>
            
            <div class="wrapper style1">
                <div class="container">
                    <article id="main" class="special">
                        <header>
                            <!-- Sikeres regisztráció üzenet megjelenítése -->
                            <?php if (!empty($success)): ?>
                                <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
                            <?php endif; ?>

                            <!-- Hibaüzenet megjelenítése, ha van -->
                            <?php if (!empty($error)): ?>
                                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
                            <?php endif; ?>

                            <h2>Bejelentkezés</h2>
                            <p>A bejelentkezéshez add meg a felhasználóneved és jelszavad!</p>
                        </header>

                        <!-- Bejelentkezési űrlap -->
                        <form action="/login" method="POST">
                            <div class="form-group">
                                <label for="username">Felhasználónév</label>
                                <input type="text" id="username" name="username" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Jelszó</label>
                                <input type="password" id="password" name="password" required>
                            </div>

                            <button type="submit">Bejelentkezés</button>
                        </form>

                        <!-- Regisztrációs szöveg és link középre igazítva -->
                        <div class="register-section">
                            <p>Még nincs fiókod?</p>
                            <a href="/register">Regisztráció</a>
                        </div>
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
