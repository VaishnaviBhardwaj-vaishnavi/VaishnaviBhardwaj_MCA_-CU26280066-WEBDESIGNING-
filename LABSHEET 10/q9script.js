const token = "MY_SECRET_API_TOKEN";

fetch("api.php", {
    method: "GET",

    headers: {
        "Authorization": "Bearer " + token
    }
})
.then(response => response.json())
.then(data => {
    console.log(data);
})
.catch(error => {
    console.log(error);
});