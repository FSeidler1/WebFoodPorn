var loginApp = new angular.module('loginApp', []);
var registrationApp = new angular.module('registrationApp', []);
var mainApp = new angular.module('mainApp', []);
var isloggedin;

/************
 * TODO
 * **********
 * Benutzer Daten laden
 * Foodporn-Modal daten einlesen
 * 
 * Verschönerungen
 * ******************
 * Datenfelder - angular ($scope...)
 * Kommentare
 * 
 *  
 * 
 ************/


// --------------------------------------------------------------
// Formular - Controller
// --------------------------------------------------------------
loginApp.controller('FormController',
    function FormController($scope, $http) {
        $scope.benutzer_login = "";
        $scope.passwort_login = "";
        $scope.submit = function() {
            console.log(this);
            // ------------------------------------------------------
            // Formular - Datenübermitteln an controller.php
            // ------------------------------------------------------ 
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
                        localStorage.setItem("loggedIn", "true");
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
                        localStorage.setItem("loggedIn", "true");
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
        $scope.entrys = [];
        $http.get('./../php/Controller.php?class=foodporn').success(
            function(data) {
                $scope.entrys = data;
            }
        );
        $scope.buildModalEntry = function() {
            //this.entry.id_foodporn
            console.log('hoi');
            $("#openModal_IdAutor").text(this.entry.user.username);
            $("#openModal_Title").text(this.entry.title);
            $("#openModal_Text").text(this.entry.description);

            $("#openModal_img").attr('src', this.entry.image);

            $("#myModal").modal();
        }
    });

/*Controller definieren, Funktion für den controller*/
mainApp.controller('buildSingleEntry',
    function mainController($scope, $http) {
        $scope.entrys = [];
        $http.get('./../php/Controller.php?class=foodporn&action=get').success(
            function(data) {
                $scope.entrys = data;
            }
        );
    });

/*Controller definieren, Funktion für den controller*/
mainApp.controller('buildPersonalEntrys',
    function mainController($scope, $http) {
        $scope.entrys = [];
        $http.get('./../php/Controller.php?class=foodporn&action=byUser').success(
            function(data) {
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
            console.log(document.getElementById("datei_neuesBild").value);

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
                    }
                }
            });
        }
    }
);
/*
//Für Bildformatierung
function dataTrans() {
    var FR = new FileReader();
    FR.readAsDataURL(document.querySelector('#datei_neuesBild').files[0])
    FR.onload = function(FR) {
        return FR.target.result;
    }
}
*/
mainApp.controller('searchFormSend',
    function searchFormSend($scope, $http) {
        $scope.submit = function() {
            // ------------------------------------------------------
            // Formular - Datenübermitteln an controller.php
            // ------------------------------------------------------ 
            var request = $http({
                method: "post",
                url: './../php/controller.php?class=foodporn&action=search',
                data: {
                    navSearch: document.getElementById("navSearch").value
                },
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            });

            // Was kommt vom Controller.php zurück?
            request.success(function(data) {
                console.log(data);
                $scope.entrys = data;
            });
        }
    }
);

//Filter by Category
mainApp.controller('getElementCategoryCon',
    function getElementCategoryCon($scope, $http) {
        $scope.getElementCategory = function(category) {
            // ------------------------------------------------------
            // Formular - Datenübermitteln an controller.php
            // ------------------------------------------------------ 
            var request = $http({
                method: "post",
                url: './../php/controller.php?class=foodporn&action=filterCategory',
                data: {
                    categoryName: category
                },
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            });

            // Was kommt vom Controller.php zurück?
            request.success(function(data) {
                $scope.entrys = data;
                console.log(data);
            });
        }
        $scope.getElementFavorite = function() {
            // ------------------------------------------------------
            // Formular - Datenübermitteln an controller.php
            // ------------------------------------------------------ 
            var request = $http({
                method: "post",
                url: './../php/controller.php?class=foodporn&action=filterFavorite',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            });

            // Was kommt vom Controller.php zurück?
            request.success(function(data) {
                $scope.entrys = data;
            });
        }
    }
);


mainApp.controller('setLikeFavorite',
    function setLikeFavorite($scope, $http) {

        var entryTemp;

        $scope.setLike = function() {
            entryTemp = this.entry;
            // ------------------------------------------------------
            // Formular - Datenübermitteln an controller.php
            // ------------------------------------------------------ 
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



function isloggedInCall(data) {
    if (data === 'true') {
        isloggedin = true;
        localStorage.setItem("loggedIn", "true");
    } else {
        isloggedin = false;
        localStorage.setItem("loggedIn", "false");
    }
}

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