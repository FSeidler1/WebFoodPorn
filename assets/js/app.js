var loginApp = new angular.module('loginApp', []);
var registrationApp = new angular.module('registrationApp', []);
var mainApp = new angular.module('mainApp', []);

// --------------------------------------------------------------
// Formular - Controller
// --------------------------------------------------------------
loginApp.controller('FormController',
    function FormController($scope, $http) {
        $scope.submit = function() {
            console.log(this);
            // ------------------------------------------------------
            // Formular - Datenübermitteln an controller.php
            // ------------------------------------------------------ 
            var request = $http({
                method: 'post',
                url: './assets/php/controller.php?class=user&action=login',
                data: {
                    benutzer_login: document.getElementById("benutzer_login").value,
                    passwort_login: document.getElementById("passwort_login").value
                },
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            });
            //console.log(document.getElementById("benutzer_login").value);
            //console.log(document.getElementById("passwort_login").value);
            // Was kommt vom Controller.php zurück? Wenn passt, dann login. Wenn nicht dann redirect
            request.success(function(meldung) {
                //Keine Rückmeldung von Server
                if (meldung === null) {
                    console.log("Fehlerhafte Rückmeldung von Server");
                } else {
                    console.log(meldung);
                    if (meldung === 'true') {
                        //Password korrekt
                        window.location.replace("./assets/html/main.html");
                    } else {
                        falseData();
                    }
                }
            });

        }
    }
);

// --------------------------------------------------------------
// Formular - Controller (insert, update)
// --------------------------------------------------------------
registrationApp.controller('FormController',
    function FormController($scope, $http) {
        $scope.submit = function() {
            console.log(this);
            // ------------------------------------------------------
            // Formular - Datenübermitteln an controller.php
            // ------------------------------------------------------ 
            var request = $http({
                method: "post",
                url: './assets/php/controller.php?class=user&action=registration',
                data: {
                    benutzer_registration: document.getElementById("benutzer_registration").value,
                    email_registration: document.getElementById("email_registration").value,
                    passwort_registration: document.getElementById("passwort_registration").value
                },
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            });
            // Was kommt vom Controller.php zurück? Wenn passt, dann login. Wenn nicht dann redirect
            request.success(function(meldung) {
                //Keine Rückmeldung von Server
                if (meldung === null) {
                    console.log("Fehlerhafte Rückmeldung von Server")
                } else {
                    if (meldung === 'true') {
                        //Password korrekt
                        window.location.replace("./assets/html/main.html");
                    }
                }
            });

        }
    }
);


function falseData() {
    //Keine Anmeldung möglich
    var mydiv = document.getElementById("falseUserLogin");
    mydiv.style.display = "block";

}

/*Controller definieren, Funktion für den controller*/
mainApp.controller('buildMainEntrys',
    function mainController($scope, $http) {
        $http.get('./../php/Controller.php?class=foodporn').success(
            function(data) {
                //console.log(data);
                $scope.entrys = data;
            }
        );
    });


mainApp.controller('sendNewEntry',
    function sendNewEntry($scope, $http) {
        $scope.submit = function() {
            // ------------------------------------------------------
            // Formular - Datenübermitteln an controller.php
            // ------------------------------------------------------ 
            var request = $http({
                method: "post",
                url: './assets/php/controller.php?class=foodporn&action=add',
                data: {
                    titel_neuesBild: document.getElementById("titel_neuesBild").value,
                    beschreibung_neuesBild: document.getElementById("beschreibung_neuesBild").value,
                    kategorie_neuesBild: document.getElementById("kategorie_neuesBild").value,
                    //datei_neuesBild: document.getElementById("datei_neuesBild").value
                    datei_neuesBild: dataTrans()
                },
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            });
            console.log(document.getElementById("datei_neuesBild").value);
            console.log(dataTrans());
            // Was kommt vom Controller.php zurück?
            request.success(function(meldung) {
                //Keine Rückmeldung von Server
                if (meldung === null) {
                    console.log("Fehlerhafte Rückmeldung von Server")
                } else {
                    if (meldung === 'true') {
                        //Clear Inputs  
                        var formModal = document.getElementById("formNewentryAdd");
                        formModal.reset();
                        //Hide Modal
                        $('#meinModal').modal('hide');
                    }
                }
            });
        }
    }
);

//Für Bildformatierung
function dataTrans() {
    var file = document.querySelector('#datei_neuesBild').files[0];
    var reader = new FileReader();
    if (file) {
        var dataFile = reader.readAsDataURL(file);
        console.log(dataFile);
        return dataFile;
    }
}