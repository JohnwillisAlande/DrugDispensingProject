let user = {
   "username": "Mike",
   "password": "Mike567",
   "gender": "male",
   "email": "mike@mail.com"
}

fetch("script.php", {
    "method": "POST",
    "headers": {
        "Content-Type": "application/json; charset=utf-8"
    },
    "body": JSON.stringify(user)
}).then(function(response){
    return response.json();
}).then(function(data){
    console.log(data);
})