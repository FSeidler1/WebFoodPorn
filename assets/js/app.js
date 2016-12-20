/*********************************************************
 * Projekt M335 - Abschlussarbeit
 * ******************************************************
 * Autor:       Fabian Seidler
 * Datum:       12.12.2016 - 20.12.2016
 * Änderungen:  Siehe GitHub
 * Status:      Fertig - zur Abgabe bereit 
 * Team:        Leonardo Sandbichler, Ivo Keller, Fabian Seidler 
 ******************************************************** */



//auf Login Page eingebunden
var loginApp = new angular.module('loginApp', []);
//auf Registrierungs Page eingebunden
var registrationApp = new angular.module('registrationApp', []);
//Auf den Main Pages eingebunden - main und registration
var mainApp = new angular.module('mainApp', []);
//Dient zur Überprüfung ob der User bereits eingeloggt ist, ansonsten redirect auf Login
var isloggedin;



// --------------------------------------------------------------
// Controller für die Login-Page
// Funktion: Login und weiterleitung auf Main-Page
// --------------------------------------------------------------
loginApp.controller('FormController',
    function FormController($scope, $http) {
        $scope.benutzer_login = "";
        $scope.passwort_login = "";
        $scope.submit = function() {
            //Datenübermittlung an Controller.php 
            var request = $http({
                method: 'post',
                url: './assets/php/controller.php?class=user&action=login',
                data: {
                    benutzer_login: $scope.benutzer_login,
                    passwort_login: $scope.passwort_login
                },
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            });
            // Was kommt vom Controller.php zurück? Wenn passt, dann Login.
            request.success(function(meldung) {
                //Keine Rückmeldung von Server
                if (meldung === null) {
                    console.log("Fehlerhafte Rückmeldung von Server");
                } else {
                    //Password korrekt
                    if (meldung === 'true') {
                        //setzt zusäätzlich lokales Loginflag
                        localStorage.setItem("loggedIn", "true");
                        //Redirect auf Main weil Login korrekt
                        window.location.replace("./assets/html/main.html");
                    } else {
                        //Feedback - Fehlerhafte Login-Daten
                        falseData();
                    }
                }
            });
        }
    }
);

// --------------------------------------------------------------
// Controller für die Registrierungs-Page
// Funktion: Registrierung, Login und weiterleitung auf Main-Page
// --------------------------------------------------------------
registrationApp.controller('FormController',
    function FormController($scope, $http) {
        $scope.submit = function() {
            $scope.benutzer_registration = "";
            $scope.email_registration = "";
            $scope.passwort_registration = "";
            //Datenübermittlung an Controller.php 
            var request = $http({
                method: "post",
                url: './../php/controller.php?class=user&action=registration',
                data: {
                    //Daten aus Formular auslesen
                    benutzer_registration: $scope.benutzer_registration,
                    email_registration: $scope.email_registration,
                    passwort_registration: $scope.passwort_registration
                },
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            });
            // Was kommt vom Controller.php zurück? Wenn passt, dann login.
            request.success(function(meldung) {
                //Keine Rückmeldung von Server
                if (meldung === null) {
                    console.log("Fehlerhafte Rückmeldung von Server")
                } else {
                    //Password korrekt
                    if (meldung === 'true') {
                        //setzt zusäätzlich lokales Loginflag
                        localStorage.setItem("loggedIn", "true");
                        //Redirect auf Main weil Login korrekt
                        window.location.replace("./../html/main.html");
                    }
                }
            });
        }
    }
);

//Zeigt roten Text an, welcher auf falsche Login-Daten hinweist
function falseData() {
    //Keine Anmeldung möglich
    var mydiv = document.getElementById("falseUserLogin");
    mydiv.style.display = "block";
}


// --------------------------------------------------------------
// Controller für die Main-Pages
// Funktion: (Main, Profil) Globale Funkionen 
// --------------------------------------------------------------

//Bildet die Einträge auf der Hauptseite, wird von main.html aufgerufen
mainApp.controller('buildMainEntrys',
    function mainController($scope, $http) {
        $scope.navSearch = "";
        $scope.entrys = [];
        $http.get('./../php/Controller.php?class=foodporn').success(
            function(data) {
                $scope.entrys = data;
            }
        );
        //Suche über Searchbar, Einträge gefiltert zurück
        $scope.submit = function() {
                $http.get('./../php/Controller.php?class=foodporn&action=search&navSearch=' + $scope.navSearch).success(
                    function(data) {
                        $scope.entrys = [];
                        $scope.entrys = data;
                    }
                );
            }
            //Filterung über Dropdown-Feld, Einträge gefiltert zurück
        $scope.getElementCategory = function(category) {
                $http.get('./../php/Controller.php?class=foodporn&action=filterCategory&filter=' + category).success(
                    function(data) {
                        $scope.entrys = [];
                        $scope.entrys = data;
                    }
                );
            }
            //Filterung über Dropdown-Feld, favoritisierte Einträge zurück
        $scope.getElementFavorite = function() {
            $http.get('./../php/Controller.php?class=foodporn&action=filterFavorite').success(
                function(data) {
                    $scope.entrys = [];
                    $scope.entrys = data;
                }
            );
        };
        //Sicherheit, dass Modal auf Main für neue Einträge leer ist
        $scope.entry = { user: { username: "" }, title: "", description: "", image: "" };
        $scope.buildModalEntry = function(xEntry) {
            //this.entry.id_foodporn
            $scope.entry.user.username = xEntry.user.username;
            $scope.entry.title = xEntry.title;
            $scope.entry.description = xEntry.description;
            $("#openModal_img").attr('src', xEntry.image);
            $("#myModal").modal();
        }
    });

//Einzelnen Eintrag holen, wird dann in einzelnem Vollbild-Modal dargestellt
mainApp.controller('buildSingleEntry',
    function mainController($scope, $http) {
        $scope.entrys = [];
        $http.get('./../php/Controller.php?class=foodporn&action=get').success(
            function(data) {
                $scope.entrys = data;
            }
        );
    });

//Erstellt sämtliche Einträge auf der Profil-Seite, welche der angemeldete User je erfasst hat
mainApp.controller('buildPersonalEntrys',
    function mainController($scope, $http) {
        $scope.entrys = [];
        $scope.userX = { desc: "", oldPW: "", newPW: "", Ahg: "" }
        $scope.userData = { title: "", description: "" };
        $http.get('./../php/Controller.php?class=foodporn&action=byUser').success(
            function(data) {
                $scope.entrys = data;
            }
        );
        //Holt Daten des Users
        $http.get('./../php/Controller.php?class=user&action=get').success(
            function(data) {
                $scope.userData = data;
            }
        );

        //Vorbefüllen des "Benutzer-Bearbeiten"-Moduls
        $scope.updateUdssr = function() {
                var request = $http({
                    method: "post",
                    url: './../../assets/php/controller.php?class=user&action=update',
                    data: {
                        beschreibung: $("#beschreibung_neuesBild").val(),
                        altesPW: $scope.userX.oldPW,
                        neuesPW: $scope.userX.newPW,
                        image: $("#datei_neuesBild").val()
                    },
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                });
                // Was kommt vom Controller.php zurück?
                request.success(function(meldung) {
                    //Keine Rückmeldung von Server
                    if (meldung === null) {
                        console.log("Fehlerhafte Rückmeldung von Server")
                    } else {
                        meldung = meldung.replace(/ /g, '');
                        if (meldung === 'true') {
                            //Clear Inputs  
                            var formModal = document.getElementById("formNewentryAdd");
                            formModal.reset();
                            //Hide Modal
                            $('#meinModal').modal('toggle');
                            location.reload();
                        }
                    }
                });
            }
            //Suche über Searchbar, Einträge gefiltert zurück
        $scope.submit = function() {
                $http.get('./../php/Controller.php?class=foodporn&action=search&navSearch=' + $scope.navSearch).success(
                    function(data) {
                        $scope.entrys = [];
                        $scope.entrys = data;
                    }
                );
            }
            //Filterung über Dropdown-Feld, Einträge gefiltert zurück
        $scope.getElementCategory = function(category) {
                $http.get('./../php/Controller.php?class=foodporn&action=filterCategory&filter=' + category).success(
                    function(data) {
                        $scope.entrys = [];
                        $scope.entrys = data;
                    }
                );
            }
            //Filterung über Dropdown-Feld, favoritisierte Einträge zurück
        $scope.getElementFavorite = function() {
            $http.get('./../php/Controller.php?class=foodporn&action=filterFavorite').success(
                function(data) {
                    $scope.entrys = [];
                    $scope.entrys = data;
                }
            );
        };
    });

//Eingabe aus Modal - neuen Foodporn hinzufügen
mainApp.controller('sendNewEntry',
    function sendNewEntry($scope, $http) {
        $scope.submit = function() {
            //Datenübermittlung an Controller.php 
            var request = $http({
                method: "post",
                url: './../../assets/php/controller.php?class=foodporn&action=add',
                data: {
                    title: document.getElementById("titel_neuesBild").value,
                    description: document.getElementById("beschreibung_neuesBild").value,
                    category: document.getElementById("kategorie_neuesBild").value,
                    //datei_neuesBild: document.getElementById("datei_neuesBild").value
                    image: document.getElementById("datei_neuesBild").value
                },
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            });
            // Was kommt vom Controller.php zurück?
            request.success(function(meldung) {
                //Keine Rückmeldung von Server
                if (meldung === null) {
                    console.log("Fehlerhafte Rückmeldung von Server")
                } else {
                    meldung = meldung.replace(/ /g, '');
                    if (meldung === 'true') {
                        //Clear Inputs  
                        var formModal = document.getElementById("formNewentryAdd");
                        formModal.reset();
                        //Hide Modal
                        $('#meinModal').modal('toggle');
                        location.reload();
                    }
                }
            });
        }
    }
);

//Like, Dislike und Favoriten auswählen und Flag setzen
mainApp.controller('setLikeFavorite',
    function setLikeFavorite($scope, $http) {
        var entryTemp;
        //Like auswählen und Flag setzen
        $scope.setLike = function() {
                entryTemp = this.entry;
                // Formular - Datenübermitteln an controller.php
                var request = $http({
                    method: "post",
                    url: './../php/controller.php?class=foodporn&action=like',
                    data: {
                        id_foodporn: entryTemp.id_foodporn,
                        isLike: 1
                    },
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                });
                // Was kommt vom Controller.php zurück?
                request.success(function(dataTF) {
                    $http.get('./../php/Controller.php?class=foodporn').success(
                        function(data) {
                            dataTF = dataTF.replace(/ /g, '');
                            if (dataTF == 'true') {
                                $("#entry_" + entryTemp.id_foodporn + " .foodporn-like-button.green span").val(
                                    entryTemp.likes++
                                );
                            }
                        }
                    );
                });
            }
            //Dislike auswählen und Flag setzen
        $scope.setDisike = function() {
                entryTemp = this.entry;
                // ------------------------------------------------------
                // Formular - Datenübermitteln an controller.php
                // ------------------------------------------------------ 
                var request = $http({
                    method: "post",
                    url: './../php/controller.php?class=foodporn&action=like',
                    data: {
                        id_foodporn: entryTemp.id_foodporn,
                        isLike: 0
                    },
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                });

                // Was kommt vom Controller.php zurück?
                request.success(function(dataTF) {
                    $http.get('./../php/Controller.php?class=foodporn').success(
                        function(data) {
                            dataTF = dataTF.replace(/ /g, '');
                            if (dataTF == 'true') {
                                $("#entry_" + entryTemp.id_foodporn + " .foodporn-like-button.red span").val(
                                    entryTemp.dislikes++
                                );
                            }
                        }
                    );
                });
            }
            //Favoriten auswählen und Flag setzen
        $scope.setFavorite = function() {
            entryTemp = this.entry;
            // ------------------------------------------------------
            // Formular - Datenübermitteln an controller.php
            // ------------------------------------------------------ 
            var request = $http({
                method: "post",
                url: './../php/controller.php?class=foodporn&action=setfavorite',
                data: {
                    id_foodporn: entryTemp.id_foodporn,
                },
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            });

            // Was kommt vom Controller.php zurück?
            request.success(function(data) {
                $("#entry_" + entryTemp.id_foodporn + " .foodporn-eye-button").removeClass("true");
                $("#entry_" + entryTemp.id_foodporn + " .foodporn-eye-button").removeClass("false");
                $("#entry_" + entryTemp.id_foodporn + " .foodporn-eye-button").addClass(data);


            });
        }
    }
);



//Überprüfen ob User bereits eingeloggt ist
//Übergabeparameter ist die aktuelle Seite, von wo die Funktion aufgerufen wird
function isUserLoggedIn(actualPage) {
    var loggedIn = localStorage.getItem("loggedIn");
    switch (actualPage) {
        case "index":
            if (loggedIn === "true") {
                //load 'main' page
                window.location.replace("./assets/html/main.html");
                //write Username inNavbar

            } else {
                //redirect to index
                //allready in index - do nothing
            }
            break;
        case "registration":
            if (loggedIn === "true") {
                //load 'main' page
                window.location.replace("./main.html");
                //write Username inNavbar

            } else {
                //redirect to index
                window.location.replace("./../../index.html");
            }
            break;
        case "main":
            if (loggedIn === "true") {
                //do nothing                
            } else {
                //redirect to index
                window.location.replace("./../../index.html");
            }
            break;
        case "profil":
            if (loggedIn === "true") {
                //do nothing                
            } else {
                //redirect to index
                window.location.replace("./../../index.html");
            }
            break;

        default:
            console.log("Login Case unbekannt - nicht implementiert");
            break;
    }
}


//localStorage wird dem Loginstatus angepasst
function isloggedInCall(data) {
    if (data === 'true') {
        isloggedin = true;
        localStorage.setItem("loggedIn", "true");
    } else {
        isloggedin = false;
        localStorage.setItem("loggedIn", "false");
    }
}

//Aufgaben, wenn der Logout geklickt wird
mainApp.controller('LogoutController',
    function LogoutController($scope, $http) {
        $scope.userLogOut = function() {
            $http.get('./../php/Controller.php?class=user&action=logout').success(
                function(data) {
                    localStorage.setItem("loggedIn", "false");
                    isloggedin = false;
                    //redirect to index
                    window.location.replace("./../../index.html");
                }
            );
        }
    }
);