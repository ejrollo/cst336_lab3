<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        
        <title> Sign Up Page </title>
        <link href="css/styles_.css" rel="stylesheet" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
    </head>
    
    <body>
        
        <h1> Sign Up </h1> <br><br>   
        
        <form id="signupForm" action="welcome.html">
            First Name: <input type="text" name="fName"><br>
            Last Name:  <input type="text" name="lName"><br>
            Gender: <input type="radio" name="gender" value="m"> Male
                    <input type="radio" name="gender" value="f"> Female<br><br>
                    
            Zip Code: <input type="text" id="zip" name="zip"> <span id="zipError"></span><br>
            City:     <span id="city"></span><br>
            Latitude: <span id="latitude"></span><br>
            Longitude: <span id="longitude"></span><br><br>
            
            State: 
            <select id="state" name="state">
                <option> Select One </option>
                <option value="ca"> California </option>
                <option value="ny"> New York </option>
                <option value="tx"> Texas </option>
            </select><br>
            
            Select a County: <select id="county"></select><br><br>
            
            Desired Username: <input type="text" id="username" name="username"><br>
                                <span id="usernameError"></span><br>
            
            Password: <input type="password" id="password" name="password"><br>
            Password Again: <input type="password" id="passwordAgain"><br>
                            <span id="passwordAgainError"></span> <br>
                            <span id="passwordLengthError"></span> <br><br>
            
            <input type="submit" value="Sign up!"> <br><br>
            
            
        </form>
        
        <script>
        
            var usernameAvailable = false;
            var zipcodeAvailable = true;
            
            //displaying city from API after typing a zip code
            $("#zip").on("change", async function(){
                let zipCode = $("#zip").val();
                let url = `https://cst336.herokuapp.com/projects/api/cityInfoAPI.php?zip=${zipCode}`;
                let response = await fetch(url);
                let data = await response.json();
                
                $("#city").html(data.city);
                $("#latitude").html(data.latitude);
                $("#longitude").html(data.longitude);
                    
                if (data == false){
                    $("#zipError").html("Zip code not valid!");
                    $("#zipError").css("color","red");
                    zipcodeAvailable = false;
                }
                
            });//zip
            
            $("#state").on("change", async function(){
                let state = $("#state").val();
                let url = `https://cst336.herokuapp.com/projects/api/countyListAPI.php?state=${state}`;
                let response = await fetch(url);
                let data = await response.json();
                //console.log(data);
                $("#county").html("<option> Select one </option>");
                data.forEach( function(i){
                    $("#county").append(`<option> ${i.county} </option>`);
                });
            });//state
            
            $("#username").on("change", async function(){
                let username = $("#username").val();
                let url = `https://cst336.herokuapp.com/projects/api/usernamesAPI.php?username=${username}`;
                let response = await fetch(url);
                let data = await response.json();
                
                if (data.available){
                    $("#usernameError").html("Username available!");
                    $("#usernameError").css("color","green");
                    usernameAvailable = true;
                } else{
                    $("#usernameError").html("username not available!");
                    $("usernameError").css("color","red");
                    usernameAvailable = false;
                }
                
            });//username
            
            $("#signupForm").on("submit", function(e){
                if (!isFormValid()){
                    e.preventDefault();
                }
            });//signup form
            
            function isFormValid(){
                
                var isValid=true;
                
                if (!usernameAvailable){
                    isValid=false;
                }
                
                if (!zipcodeAvailable){
                    isValid=false;
                }
                
                if ($("#username").val().length == 0){
                    isValid=false;
                    $("#usernameError").html("Username is required");
                    $("#usernameError").css("color","red");
                }
                
                if ($("#password").val() != $("#passwordAgain").val()){
                    $("#passwordAgainError").html("Password Mismatch!");
                    $("#passwordAgainError").css("color","red");
                    isValid=false;
                }
                
                if ($("#password").val().length < 6){
                    $("#passwordLengthError").html("Password less than 6 characters!");
                    $("#passwordLengthError").css("color","red");
                    isValid=false;
                }
                
                return isValid;
            }
        </script>
        
        <footer>
            <hr>
                <img src="img/csumblogo.png" alt="CSUMB Logo" style="width:150px;height:150px;"/> <br />
                CST336 Internet Programming. 2020&copy; Rollo <br />
                <strong>Disclaimer:</strong> The information in this webpage is fictitious. <br />
                It is used for academic purposes only.
        </footer>
    </body>
</html>