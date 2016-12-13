var loginApp = new angular.module('loginApp', []);

// --------------------------------------------------------------
// Formular - Controller (insert, update)
// --------------------------------------------------------------
phonecatApp.controller('FormController',
    function FormController($scope, $http) {
        $scope.submit = function() {
            console.log(this);
            // ------------------------------------------------------
            // Formular - Datenübermitteln an controller.php
            // ------------------------------------------------------ 
            var request = $http({
                method: "post",
                url: 'controller.php?class=user&action=login',
                data: {
                    benutzer_login: document.getElementById("benutzer-login").value,
                    passwort_login: document.getElementById("passwort_login").value
                },
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            });
            // Was kommt vom 001.php zurück? Wenn passt, dann login. Wenn nicht dann redirect
            request.success(function(meldung) {
                console.log("api: " + meldung);
                $scope.text = meldung;
            });

        }
    }
);




// --------------------------------------------------------------
// Standard - Front Controller / JSON anzeigen
// --------------------------------------------------------------
phonecatApp.controller('PhoneListController',
    function PhoneListController($scope, $http) {
        /* JSON - von einem Backend holen*/
        $http.get('001.php').success(
            function(data) {
                $scope.phones = data;
            }
        );
        // ------------------------------------------------------
        // Edit - Link - Form anzeigen und Daten laden
        // ------------------------------------------------------
        $scope.edit = function() {
                console.log(this.phone.id);
                document.getElementById("form_id").value = this.phone.id;
                document.getElementById("form_name").value = this.phone.name;
                document.getElementById("form_snippet").value = this.phone.snippet;
            }
            // ------------------------------------------------------
            /* JSON - fix definiert*/
            // ------------------------------------------------------
            /*$scope.phones = [{
                name: 'nexus',
                snippet: 'es ist gut'
            }];*/
    }
);