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
                url: '001.php?clas=phones&action=update',
                data: {
                    form_id: document.getElementById("form_id").value,
                    form_name: document.getElementById("form_name").value,
                    form_snippet: document.getElementById("form_snippet").value
                },
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            });
            // Was kommt vom 001.php zurück? Anzeige in {{text}}
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