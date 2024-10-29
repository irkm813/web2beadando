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
                                <form id="httprequestform" onsubmit="sendRestRequest(event)">
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
                                <form method="post" action="api_client.php">
                                    <h3>SOAP API Client</h3>
                                    <label for="soapEndpoint">Endpoint:</label>
                                    <input type="text" name="soapEndpoint" id="soapEndpoint" required><br>
                                    <label for="soapAction">SOAP Action:</label>
                                    <input type="text" name="soapAction" id="soapAction" required><br>
                                    <label for="soapData">Data (XML):</label>
                                    <textarea name="soapData" id="soapData" required></textarea><br>
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