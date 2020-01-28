@section('head-scripts')
    <script>
        var app = angular.module("myApp");
        app.controller('TestController',TestController);

        function TestController($scope,$http) {
            $scope.templates=[];
            $scope.roles=[];
            $scope.dynamicVariables={
              admin:[
                  '{admin_first_name}','{admin_last_name}'
              ],
                user:[
                    '{user_first_name}','{user_last_name}'
                ],
                allUserType:[
                    '{first_name}','{last_name}',
                ]
            };
            $scope.templateTypes=[
                'Admin','User','All Types'
            ];
            $scope.saveTemplate= function (){
                $http.post('email-template',{body:$scope.body,role_id:$scope.role_id}).then(function (res) {
                })
            };

            $scope.insert= function (text) {
              if($scope.body) $scope.body=$scope.body+' '+text;
              else $scope.body=text;
            };

            $scope.getVariables=function () {
                if($scope.type=='Admin') return $scope.dynamicVariables.admin;
                if($scope.type=='User') return $scope.dynamicVariables.user;
                if($scope.type=='All Types') return $scope.dynamicVariables.allUserType;
                return [];
            };

            function loadRole(){
                $http.get('role').then(function (res) {
                    $scope.roles=res.data;
                })
            }
            loadRole();
        }
    </script>
@endsection
