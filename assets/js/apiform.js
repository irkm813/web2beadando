function getSoapParameters(event) {
    clearValues();
    const tableName = document.getElementById("soapTable").value;

    const menus = {
        "": ["nope"], 
        "currencies": ["code", "name"], 
        "huzas": ["ev", "het"], 
        "huzott": ["huzasid", "szam"],
        "nyeremeny": ["huzasid", "talalat", "darab", "ertek"]
    };

    // Convert the array to a formatted string
    const parametersList = menus[tableName].join(', ');

    // Display the formatted array inside the <pre> tag
    document.getElementById("soapParametersHelp").innerHTML = `
    <pre>Táblák:</pre>
    <pre>${parametersList}</pre>`;
}

function processSoapParameters() {
    const input = document.getElementById("soapParameters").value.trim();
    const paramsObj = {}; // Object to hold key-value pairs

    // Split by comma to get each key-value pair
    const pairs = input.split(',');

    // Loop over each pair and split into key and value
    pairs.forEach(pair => {
        const [key, value] = pair.split(':').map(item => item.trim());

        // Ensure both key and value are defined, non-empty, and trimmed
        if (key && value) {
            // Check if value is a number and convert to integer if true
            paramsObj[key] = /^\d+$/.test(value) ? parseInt(value, 10) : value;
        } else {
            console.error("Invalid format for pair:", pair);
        }
    });

    console.log(paramsObj); // For debugging
    return paramsObj;
}

function toggleForm() {
    const isRest = document.getElementById("apiSwitch").checked;
    document.getElementById("restForm").style.display = isRest ? "block" : "none";
    document.getElementById("soapForm").style.display = isRest ? "none" : "block";
}

function restMethods() {
    const requestType = document.getElementById("httprequest").value;
    clearValues();

    switch (requestType) {

        case 'GET':
            document.getElementById("itemIdContainer").style.display = "block"
            document.getElementById("huzasIdContainer").style.display = "none"
            document.getElementById("talalatContainer").style.display = "none"
            document.getElementById("darabContainer").style.display = "none"
            document.getElementById("ertekContainer").style.display = "none"
          break;

        case 'POST':
            document.getElementById("itemIdContainer").style.display = "none"
            document.getElementById("huzasIdContainer").style.display = "block"
            document.getElementById("talalatContainer").style.display = "block"
            document.getElementById("darabContainer").style.display = "block"
            document.getElementById("ertekContainer").style.display = "block"
          break;

        case 'PUT':
            document.getElementById("itemIdContainer").style.display = "block"
            document.getElementById("huzasIdContainer").style.display = "block"
            document.getElementById("talalatContainer").style.display = "block"
            document.getElementById("darabContainer").style.display = "block"
            document.getElementById("ertekContainer").style.display = "block"
        break;

        case 'DELETE':
            document.getElementById("itemIdContainer").style.display = "block"
            document.getElementById("huzasIdContainer").style.display = "none"
            document.getElementById("talalatContainer").style.display = "none"
            document.getElementById("darabContainer").style.display = "none"
            document.getElementById("ertekContainer").style.display = "none"
          break;


        default:
          console.log(`Sorry, we are out of ${expr}.`);
      }
}

function soapMethods() {
    const requestType = document.getElementById("SOAPrequest").value;
    clearValues();

    switch (requestType) {

        case 'getAllItems':
            document.getElementById("soapItemIdContainer").style.display = "none"
            document.getElementById("soapParametersContainer").style.display = "none"
          break;

        case 'getDataById':
            document.getElementById("soapItemIdContainer").style.display = "block"
            document.getElementById("soapParametersContainer").style.display = "none"
        break;

        case 'addRecord':
            document.getElementById("soapItemIdContainer").style.display = "none"
            document.getElementById("soapParametersContainer").style.display = "block"
          break;

        case 'updateRecord':
            document.getElementById("soapItemIdContainer").style.display = "block"
            document.getElementById("soapParametersContainer").style.display = "block"
        break;

        case 'deleteRecord':
            document.getElementById("soapItemIdContainer").style.display = "block"
            document.getElementById("soapParametersContainer").style.display = "none"
          break;


        default:
          console.log(`Sorry, we are out of ${expr}.`);
      }
}

async function sendRestRequest(event,username,password) {
    event.preventDefault(); // Prevent the default form submission
    document.getElementById("responseContainer").innerHTML = "";
    const requestType = document.getElementById("httprequest").value;
    let endpoint = 'http://localhost/restapi';

    // Authentication credentials
    const authHeader = 'Basic ' + btoa(`${username}:${password}`);

    // Collect form data
    const data = {
        id: document.getElementById("itemId").value,
        huzasid: document.getElementById("huzasId").value,
        talalat: document.getElementById("talalat").value,
        darab: document.getElementById("darab").value,
        ertek: document.getElementById("ertek").value
    };

    // Clean data by removing empty fields
    Object.keys(data).forEach(key => {
        if (!data[key]) delete data[key];
    });

    let options = {
        method: requestType,
        headers: {
            "Content-Type": "application/json",
            "Authorization": authHeader // Add Authorization header
        }
    };

    if (requestType === "POST") {
        // Add JSON body for POST and PUT requests
        options.body = JSON.stringify(data);
    }else if (requestType === "PUT"){

        endpoint += '?id=' + data['id'];
        delete data['id'];
        options.body = JSON.stringify(data);

    }else if (requestType === "DELETE" || requestType === "GET") {
        // Append data as query parameters for DELETE and GET requests
        let queryString = new URLSearchParams(data).toString();
        endpoint += '?' + queryString;
    }

    try {

        const response = await fetch(endpoint,options);
        console.log(endpoint);
        const responseData = await response.json();

        // Display response
        document.getElementById("responseContainer").innerHTML = `
            <h3>API Response:</h3>
            <pre>${JSON.stringify(responseData, null, 2)}</pre>
        `;
    } catch (error) {
        console.error("Error:", error);
        document.getElementById("responseContainer").innerHTML = `
            <p style="color:red;">Failed to send request: ${error}</p>
        `;
    }
}

function clearValues(){
    document.getElementById("itemId").value = null;
    document.getElementById("huzasId").value = null;
    document.getElementById("talalat").value = null;
    document.getElementById("darab").value = null;
    document.getElementById("ertek").value = null;
    document.getElementById("soapItemId").value = null;
    document.getElementById("soapParameters").value = null;
}

function callSoapApi(event,username,password) {

    event.preventDefault();
    document.getElementById("responseContainer").innerHTML = "";

    // Basic Auth felhasználónév és jelszó
    const credentials = btoa(`${username}:${password}`); 
    const requestType = document.getElementById("SOAPrequest").value;
    let innerContent ="";

    const url = 'http://localhost/soapapi'; // SOAP API végpont URL-je

    let soapTable = document.getElementById("soapTable").value;
    let soapId =  document.getElementById("soapItemId").value;

    soapTable = soapTable == "" ? "":`<table>${soapTable}</table>`;
    soapId = soapId == "" ? "":`<id>${soapId}</id>`;

    const data = processSoapParameters();


    // Clean data by removing empty fields
    Object.keys(data).forEach(key => {
        if (!data[key]) delete data[key];
    });

    for (const [key, value] of Object.entries(data)) {
        innerContent += `<${key}>${value}</${key}>`;
    }

    // SOAP kérés XML
    const soapRequest =
        `<?xml version="1.0" encoding="UTF-8"?>
           <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
           <soap:Body>
                <${requestType} xmlns="http://localhost/soapapi">
                    ${soapTable}
                    ${soapId}
                    <data>
                        ${innerContent}
                    </data>
                </${requestType}>
           </soap:Body>
        </soap:Envelope>`;

    console.log(`valami: ${soapRequest}`);

    // Új XMLHttpRequest létrehozása
    const xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Authorization', `Basic ${credentials}`);

    // Beállítjuk a Content-Type fejlécet SOAP kéréshez
    xhr.setRequestHeader('Content-Type', 'text/xml');

    // Válasz kezelése
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) { // A kérés elkészült
            if (xhr.status === 200) { // Sikeres válasz


                let successMessage = document.createElement("p");
                successMessage.textContent = "Sikeres API hívás!";
                responseContainer.appendChild(successMessage);

                let formattedXml = xhr.response;

                // Parse the XML string to a DOM object
                let parser = new DOMParser();
                let xmlDoc = parser.parseFromString(formattedXml, "application/xml");

                // Get all 'item' elements
                let items = xmlDoc.getElementsByTagName("item");

                // Create an HTML table
                let table = document.createElement("table");
                let tbody = table.createTBody();


                Array.from(items).forEach(item => {
                    if (item.getAttribute("xsi:type") !== "ns2:Map"){
                        let row = tbody.insertRow();
                        Array.from(item.children).forEach(col => {
                            let cell = row.insertCell();
                            cell.textContent = col.textContent;
                        });}
                });

                // Append table to the document body or a specific container
                document.getElementById("responseContainer").appendChild(table);

            } else { // Hibakezelés
                console.error('Hiba történt a kérés során:', xhr.statusText);
            }
        }
    };
    // Kérés elküldése
    xhr.send(soapRequest);
}

// Initialize with REST form hidden
soapMethods();
restMethods();
getSoapParameters();
toggleForm();
