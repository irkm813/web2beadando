<!DOCTYPE HTML>
<html>
    <!-- Html header betöltése -->
    <?php 
    include __DIR__ . '/../includes/header.php';

    // Hibaüzenet kezelése
    $error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
    unset($_SESSION['error']);
    ?>

<head>
        <!-- Stílusok betöltése -->
        <link rel="stylesheet" href="assets/css/profile.css">
    </head>

    <body class="profile">
        <div id="page-wrapper">
            <!-- Menü elemek betöltése -->
            <?php include __DIR__ . '/../includes/menu.php'; ?>
            
            <div class="wrapper style1">
                <div class="container">
                    <article id="main" class="special">
                        <header>
                            <h2>Profil</h2>
                            <p>Alapvető információk a profilodról:</p>
                        </header>

                        <!-- Hibaüzenet megjelenítése, ha van -->
                        <?php if (!empty($error)): ?>
                            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
                        <?php else: ?>
                            <!-- Felhasználói adatok megjelenítése -->
                            <ul>
                                <li><strong>Felhasználónév:</strong> <?php echo htmlspecialchars($userData['username']); ?></li>
                                <li><strong>Email cím:</strong> <?php echo htmlspecialchars($userData['email']); ?></li>
                                <li><strong>Szerepkör:</strong> <?php echo htmlspecialchars($userData['role']); ?></li>
                            </ul>

                            <!-- Kijelentkezés gomb -->
                            <div class="logout-button-container">
                                <form action="/logout" method="post">
                                    <button type="submit">Kijelentkezés</button>
                                </form>
                            </div>
                        <?php endif; ?>
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
