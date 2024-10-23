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
							<h1><a href="/home" id="logo">Minta</a></h1>
							<hr />
							<p>Another fine freebie by HTML5 UP</p>
						</header>
						<footer>
							<a href="#banner" class="button circled scrolly">Start</a>
						</footer>
					</div>

				<!-- Nav -->
					<nav id="nav">
						<ul>
							<?php if (!empty($menuItems)): ?>
								<?php foreach ($menuItems as $menuItem): ?>
									<li><a href="<?php echo htmlspecialchars($menuItem['content']); ?>">
										<?php echo htmlspecialchars($menuItem['menu_name']); ?>
									</a></li>
								<?php endforeach; ?>
							<?php else: ?>
								<li>Nincs elérhető menüelem</li>
							<?php endif; ?>
						</ul>
					</nav>

			</div>

		<!-- Banner -->
			<section id="banner">
				<header>
					<h2>Hi. You're looking at <strong>Helios</strong>.</h2>
					<p>
					<?php 
						foreach ($menuItems as $item): ?>
							<li><?php echo htmlspecialchars($item['menu_name']); ?></li>
						<?php endforeach; ?>
					</p>
				</header>
			</section>

		<!-- Carousel -->
			<section class="carousel">
				<div class="reel">

					<article>
						<a href="#" class="image featured"><img src="images/pic01.jpg" alt="" /></a>
						<header>
							<h3><a href="#">Pulvinar sagittis congue</a></h3>
						</header>
						<p>Commodo id natoque malesuada sollicitudin elit suscipit magna.</p>
					</article>

					<article>
						<a href="#" class="image featured"><img src="images/pic02.jpg" alt="" /></a>
						<header>
							<h3><a href="#">Fermentum sagittis proin</a></h3>
						</header>
						<p>Commodo id natoque malesuada sollicitudin elit suscipit magna.</p>
					</article>

					<article>
						<a href="#" class="image featured"><img src="images/pic03.jpg" alt="" /></a>
						<header>
							<h3><a href="#">Sed quis rhoncus placerat</a></h3>
						</header>
						<p>Commodo id natoque malesuada sollicitudin elit suscipit magna.</p>
					</article>

					<article>
						<a href="#" class="image featured"><img src="images/pic04.jpg" alt="" /></a>
						<header>
							<h3><a href="#">Ultrices urna sit lobortis</a></h3>
						</header>
						<p>Commodo id natoque malesuada sollicitudin elit suscipit magna.</p>
					</article>

					<article>
						<a href="#" class="image featured"><img src="images/pic05.jpg" alt="" /></a>
						<header>
							<h3><a href="#">Varius magnis sollicitudin</a></h3>
						</header>
						<p>Commodo id natoque malesuada sollicitudin elit suscipit magna.</p>
					</article>

					<article>
						<a href="#" class="image featured"><img src="images/pic01.jpg" alt="" /></a>
						<header>
							<h3><a href="#">Pulvinar sagittis congue</a></h3>
						</header>
						<p>Commodo id natoque malesuada sollicitudin elit suscipit magna.</p>
					</article>

					<article>
						<a href="#" class="image featured"><img src="images/pic02.jpg" alt="" /></a>
						<header>
							<h3><a href="#">Fermentum sagittis proin</a></h3>
						</header>
						<p>Commodo id natoque malesuada sollicitudin elit suscipit magna.</p>
					</article>

					<article>
						<a href="#" class="image featured"><img src="images/pic03.jpg" alt="" /></a>
						<header>
							<h3><a href="#">Sed quis rhoncus placerat</a></h3>
						</header>
						<p>Commodo id natoque malesuada sollicitudin elit suscipit magna.</p>
					</article>

					<article>
						<a href="#" class="image featured"><img src="images/pic04.jpg" alt="" /></a>
						<header>
							<h3><a href="#">Ultrices urna sit lobortis</a></h3>
						</header>
						<p>Commodo id natoque malesuada sollicitudin elit suscipit magna.</p>
					</article>

					<article>
						<a href="#" class="image featured"><img src="images/pic05.jpg" alt="" /></a>
						<header>
							<h3><a href="#">Varius magnis sollicitudin</a></h3>
						</header>
						<p>Commodo id natoque malesuada sollicitudin elit suscipit magna.</p>
					</article>

				</div>
			</section>

		<!-- Main -->
			<div class="wrapper style2">

				<article id="main" class="container special">
					<a href="#" class="image featured"><img src="images/pic06.jpg" alt="" /></a>
					<header>
						<h2><a href="#">Sed massa imperdiet magnis</a></h2>
						<p>
							Sociis aenean eu aenean mollis mollis facilisis primis ornare penatibus aenean. Cursus ac enim
							pulvinar curabitur morbi convallis. Lectus malesuada sed fermentum dolore amet.
						</p>
					</header>
					<p>
						Commodo id natoque malesuada sollicitudin elit suscipit. Curae suspendisse mauris posuere accumsan massa
						posuere lacus convallis tellus interdum. Amet nullam fringilla nibh nulla convallis ut venenatis purus
						sit arcu sociis. Nunc fermentum adipiscing tempor cursus nascetur adipiscing adipiscing. Primis aliquam
						mus lacinia lobortis phasellus suscipit. Fermentum lobortis non tristique ante proin sociis accumsan
						lobortis. Auctor etiam porttitor phasellus tempus cubilia ultrices tempor sagittis. Nisl fermentum
						consequat integer interdum integer purus sapien. Nibh eleifend nulla nascetur pharetra commodo mi augue
						interdum tellus. Ornare cursus augue feugiat sodales velit lorem. Semper elementum ullamcorper lacinia
						natoque aenean scelerisque.
					</p>
					<footer>
						<a href="#" class="button">Continue Reading</a>
					</footer>
				</article>

			</div>

		<!-- Features -->
			<div class="wrapper style1">

				<section id="features" class="container special">
					<header>
						<h2>Morbi ullamcorper et varius leo lacus</h2>
						<p>Ipsum volutpat consectetur orci metus consequat imperdiet duis integer semper magna.</p>
					</header>
					<div class="row">
						<article class="col-4 col-12-mobile special">
							<a href="#" class="image featured"><img src="images/pic07.jpg" alt="" /></a>
							<header>
								<h3><a href="#">Gravida aliquam penatibus</a></h3>
							</header>
							<p>
								Amet nullam fringilla nibh nulla convallis tique ante proin sociis accumsan lobortis. Auctor etiam
								porttitor phasellus tempus cubilia ultrices tempor sagittis. Nisl fermentum consequat integer interdum.
							</p>
						</article>
						<article class="col-4 col-12-mobile special">
							<a href="#" class="image featured"><img src="images/pic08.jpg" alt="" /></a>
							<header>
								<h3><a href="#">Sed quis rhoncus placerat</a></h3>
							</header>
							<p>
								Amet nullam fringilla nibh nulla convallis tique ante proin sociis accumsan lobortis. Auctor etiam
								porttitor phasellus tempus cubilia ultrices tempor sagittis. Nisl fermentum consequat integer interdum.
							</p>
						</article>
						<article class="col-4 col-12-mobile special">
							<a href="#" class="image featured"><img src="images/pic09.jpg" alt="" /></a>
							<header>
								<h3><a href="#">Magna laoreet et aliquam</a></h3>
							</header>
							<p>
								Amet nullam fringilla nibh nulla convallis tique ante proin sociis accumsan lobortis. Auctor etiam
								porttitor phasellus tempus cubilia ultrices tempor sagittis. Nisl fermentum consequat integer interdum.
							</p>
						</article>
					</div>
				</section>

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