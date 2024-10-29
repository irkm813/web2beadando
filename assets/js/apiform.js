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

async function sendRestRequest(event,username,password) {
    event.preventDefault(); // Prevent the default form submission

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
}

// Initialize with REST form hidden
restMethods();
toggleForm();
