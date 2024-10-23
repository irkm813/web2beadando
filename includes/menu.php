<div id="header">
	<!-- Inner -->
	<div class="inner">
		<header>
			<h1><a href="/" id="logo">Helios</a></h1>
		</header>
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