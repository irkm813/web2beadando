<!DOCTYPE HTML>
<html>
	<!-- Html header betöltése -->
	<?php include __DIR__ . '/../includes/header.php'; ?>

	<body class="homepage is-preload">
		<div id="page-wrapper">

			<!-- Header -->
			<div id="header">

				<!-- Inner -->
					<div class="inner">
						<header>
							<a href="#banner"><img src="/images/hatoslotto.png" alt=""></a>
						</header>
					</div>

				<!-- Nav -->

				<nav id="nav">
					<ul>
						
					<?php
						$lastmenuwasmain = false;
						$isFirstElement = true;

						foreach ($menuItems as $menuItem) {
							$menuName = htmlspecialchars($menuItem['menu_name']);
							$content = htmlspecialchars($menuItem['content']);

							if ($menuName[0] != '/') {
								// Bezárja a lista tag-et, ha az előző menü nem almenü volt
								if ($lastmenuwasmain) {
									echo "</li>";
								}
								elseif ($isFirstElement == false){
									echo "</ul>";
								}
								
								// Egy fő menüelemet renderel
								echo "<li><a href=\"$content\">$menuName</a>";
								$lastmenuwasmain = true;
							} else {
								// This is a submenu item
								if ($lastmenuwasmain) {
									echo "<ul>"; // Nyit egy új listát a fő listaelemen belül
									$lastmenuwasmain = false;
								}

								// Rendereli az almenüt
								$submenuName = substr($menuName, 1);
								echo "<li class=\"submenu\"><a href=\"$content\">$submenuName</a></li>";
							}

							$isFirstElement = false;
						}

						// Ha van nem bezárt tag a loop után, akkor azokat lezárja
						if ($lastmenuwasmain) {
							echo "</li>";
						} else {
							echo "</ul></li>";
						}
						?>

					</ul>
				</nav>



			</div>

		<!-- Banner -->
			<section id="banner">
				<header>
					<h2>Üdvözöljük a <strong>Hatos Lottó</strong> weboldalán!</h2>
					<p>Weboldalunk funkciói:</p>
				</header>
			</section>

		<!-- Carousel -->
			<section class="carousel">
				<div class="reel">
					<article>
						<a href="/api-kliens" class="image featured"><img src="images/api.jpg" alt="" /></a>
						<header>
							<h3><a href="/api-kliens">API hozzáférés</a></h3>
						</header>
						<p>Az általunk fejlesztett SOAP és REST klienseink.</p>
					</article>

					<article>
						<a href="/mnb-currency" class="image featured"><img src="images/bank.jpg" alt="" /></a>
						<header>
							<h3><a href="/mnb-currency">MNB kliens</a></h3>
						</header>
						<p>Adatokat lekérni az Magyar Nemzeti Bank adatbázisából</p>
					</article>

					<article>
						<a href="/pdf-maker" class="image featured"><img src="images/pdf.jpg" alt="" /></a>
						<header>
							<h3><a href="/pdf-maker">PDF generás<label for=""></label></a></h3>
						</header>
						<p>Letölthető PDF-et tud generálni a kiválasztott év és hét nyereményeiből</p>
					</article>

					<article>
						<a href="/bejelentkezes" class="image featured"><img src="images/login.jpg" alt="" /></a>
						<header>
							<h3><a href="/bejelentkezes">Bejelentkezés</a></h3>
						</header>
						<p>Amennyiben ön már regisztrált tag, lehetősége van bejelentkezni az oldalra.</p>
					</article>

					<article>
						<a href="#" class="image featured"><img src="images/pic05.jpg" alt="" /></a>
						<header>
							<h3><a href="#">Valami</a></h3>
						</header>
						<p>Nem tudom </p>
					</article>

				</div>
			</section>

		<!-- Main -->
			<div class="wrapper style2">

				<article id="main" class="container special">
					<a href="#" class="image featured"><img src="images/money.jpg" alt="" /></a>
					<header>
						<h2>Játszon ön is!</h2>
						<p>
							Ha lottózik, rendkívül sok pénzt van lehetősége nyerni, ahogy azt a fotó is mutatja.
						</p>
					</header>
					<p>
					A hatos lottón játszani izgalmas élmény, hiszen minden szelvény új reményt ad a nagy nyereményre. A heti sorsolások izgalommal tölthetik meg a hétköznapokat, amikor elképzeli, hogy mit kezdene a nyereménnyel. Az apró befektetés mellett óriási esélyek várják, hiszen akár életre szóló anyagi biztonságot is hozhat. Ráadásul a barátokkal vagy családdal együtt játszani közös élmény, ami összehozhat mindenkit a lottósorsolás estéjén.
					</p>
					<footer>
						<a href="/pdf-maker" class="button">Nézze meg, eddig hányan és mennyit nyertek!</a>
					</footer>
				</article>

			</div>

			<!-- Lábléc betöltése -->
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

	</body>
</html>