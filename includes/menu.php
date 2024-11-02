<div id="header">
	<!-- Inner -->
	<div class="inner">
		<header>
			<h1><a href="/" id="logo">Hatos Lottó</a></h1>
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
					}elseif ($isFirstElement == false){
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