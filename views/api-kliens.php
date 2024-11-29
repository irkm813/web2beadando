<!DOCTYPE HTML>
<!--
	Helios by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<!-- Html header betöltése -->
	<?php include __DIR__ . '/../includes/header.php'; ?>
    <link rel="stylesheet" href="assets/css/togglebutton.css" />
	
	<body class="no-sidebar is-preload">
		<div id="page-wrapper">

		<!-- Menü elemek betöltése -->
		<?php include __DIR__ . '/../includes/menu.php'; ?>

			<!-- Main -->
			<div class="wrapper style2">

				<div class="container">
                    <article id="main" class="special">
                        <header>
                        <p>Váltás REST és SOAP kliens között</p>
                            <!-- Toggle Switch -->
                            <label class="switch">
                                <input type="checkbox" id="apiSwitch" onclick="toggleForm()">
                                <span class="slider round"></span>
                            </label>
                            <p></p>
                            <!-- REST Form -->
                            <div id="restForm" class="form-container">
                                <form id="httprequestform" onsubmit="sendRestRequest(event,'<?php echo $_SESSION['username']; ?>', '<?php echo $_SESSION['password']; ?>')">
                                    <h3>REST API Client</h3>
                                    <label for="httprequest">Válasszon HTTP kérést:</label>
                                        <select id="httprequest" onchange="restMethods()">
                                            <option value="GET">GET</option>
                                            <option value="POST">POST</option>
                                            <option value="PUT">PUT</option>
                                            <option value="DELETE">DELETE</option>
                                        </select>

                                    <div id=itemIdContainer>
                                        <label for="itemId">Item ID:</label>
                                        <input type="number" name="itemId" id="itemId"><br>
                                    </div>

                                    <div id=huzasIdContainer>
                                        <label for="huzasId">Húzás ID:</label>
                                        <input type="number" name="huzasId" id="huzasId" ><br>
                                    </div>

                                    <div id=talalatContainer>
                                        <label for="talalat">Találat:</label>
                                        <input type="number" name="talalat" id="talalat" ><br>
                                    </div>

                                    <div id=darabContainer>
                                        <label for="darab">Darab:</label>
                                        <input type="number" name="darab" id="darab" ><br>
                                    </div>

                                    <div id=ertekContainer>
                                        <label for="ertek">Érték:</label>
                                        <input type="number" name="ertek" id="ertek" ><br>
                                    </div>
                  

                                    <input type="hidden" name="apiType" value="rest">
                                    <button type="submit">Rest kérés küldése</button>
                                </form>
                            </div>

                            <!-- SOAP Form -->
                            <div id="soapForm" class="form-container">
                                <form form id="soaprequestform" onsubmit="callSoapApi(event,'<?php echo $_SESSION['username']; ?>', '<?php echo $_SESSION['password']; ?>')">

                                    <h3>SOAP API Client</h3>
                                    
                                    <label for="SOAPrequest">Válasszon SOAP kérést:</label>
                                    <select id="SOAPrequest" onchange="soapMethods()">
                                        <option value="getAllItems">Az összes rekord lekérdezése</option>
                                        <option value="getDataById">Egy Rekord lekérdezése</option>
                                        <option value="addRecord">Új rekord létrehozása</option>
                                        <option value="updateRecord">Egy rekord frissítése</option>
                                        <option value="deleteRecord">Egy rekord törlése</option>
                                    </select>

                                    <label for="soapTable">Válasszon Táblát:</label>
                                    <select id="soapTable" onchange="getSoapParameters()">
                                        <option default value="">Válasszon táblát</option>
                                        <option value="currencies">Currencies</option>
                                        <option value="huzas">Húzás</option>
                                        <option value="huzott">Húzott</option>
                                        <option value="nyeremeny">Nyeremény</option>
                                    </select>

                                    <div id=soapItemIdContainer>
                                        <label for="soapItemId">Item ID:</label>
                                        <input type="number" name="soapItemId" id="soapItemId"><br>
                                    </div>

                                    <div id=soapParametersContainer>
                                        
                                        <label for="soapParameters">Soap paraméterek:</label>
                                        <div id="soapParametersHelp"></div>
                                        <input type="text" name="soapParameters" id="soapParameters" placeholder="Pl: ev:2001,het:23">
                                    </div>

                                    <input type="hidden" name="apiType" value="soap">
                                    <button type="submit">Submit SOAP Request</button>
                                </form>
                            </div>
                        </header>

                        <div id="responseContainer"></div>
                            
                    </article>
				</div>
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
            <script src="assets/js/apiform.js"></script>

	</body>
</html>