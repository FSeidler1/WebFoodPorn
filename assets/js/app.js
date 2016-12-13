var loginApp = new angular.module('loginApp', []);

// --------------------------------------------------------------
// Formular - Controller (insert, update)
// --------------------------------------------------------------
loginApp.controller('FormController',
    function FormController($scope, $http) {
        $scope.submit = function() {
            console.log(this);
            // ------------------------------------------------------
            // Formular - Datenübermitteln an controller.php
            // ------------------------------------------------------ 
            var request = $http({
                method: "login",
                url: 'controller.php?class=user&action=login',
                data: {
                    benutzer_login: document.getElementById("benutzer_login").value,
                    passwort_login: document.getElementById("passwort_login").value
                },
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            });
            // Was kommt vom Controller.php zurück? Wenn passt, dann login. Wenn nicht dann redirect
            request.success(function(meldung) {
                if (meldung === true) {
                    //Password korrekt
                    window.location.replace("http://localhost/html/main.html");
                } else {
                    //Keine Anmeldung möglich
                    var mydiv = getElementById("falseUserLogin");
                    mydiv.style.display = "block";
                    //Keine Rückmeldung von Server
                    if (meldung === null) {
                        console.log("Keine Rückmeldung von Server")
                    }
                }
            });

        }
    }
);