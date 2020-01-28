@push('head-scripts')
    <script>
        (function () {
            angular.module("myApp").controller('TestController', TestController);
            function TestController($scope, $http) {
                $scope.emailForm='template list';
                $scope.templates = [];
                $scope.roles = [];
                var state=$scope.state={
                    params:{
                        page:1,
                        sort:'id',
                        perPage:5
                    }
                };
                $scope.dynamicVariables = {
                    admin: [
                        '{admin_first_name}', '{admin_last_name}'
                    ],
                    user: [
                        '{user_first_name}', '{user_last_name}'
                    ],
                    allUserType: [
                        '{first_name}', '{last_name}',
                    ]
                };
                $scope.templateTypes = [
                    'Admin', 'User', 'All Types'
                ];
                $scope.saveTemplate = function () {
                    $scope.body=CKEDITOR.instances['editor1'].getData();
                    $http.post('email-template', {body: $scope.body, role_id: $scope.role_id}).then(function (res) {
                        loadEmailTemplates();
                        $scope.emailForm='template list'
                    });
                };

                $scope.insert = function (text) {
                    if (CKEDITOR.instances['editor1'].getData()) CKEDITOR.instances['editor1'].setData(CKEDITOR.instances['editor1'].getData() + ' '+ text);
                    else CKEDITOR.instances['editor1'].setData(text);
                };

                $scope.getVariables = function () {
                    if ($scope.type == 'Admin') return $scope.dynamicVariables.admin;
                    if ($scope.type == 'User') return $scope.dynamicVariables.user;
                    if ($scope.type == 'All Types') return $scope.dynamicVariables.allUserType;
                    return [];
                };

                function loadRole() {
                    $http.get('role').then(function (res) {
                        $scope.roles = res.data;
                    })
                }
                loadRole();

                function loadEmailTemplates() {
                    $http.get('load-email-templates',state).then(function (res) {
                        $scope.emails=res.data.data;
                        $scope.info=res.data;
                    })
                }

                $scope.$watch('state.params', function () {
                    loadEmailTemplates();
                },true);
                loadEmailTemplates();

                $scope.changePage= function (number) {
                    if(number==='back')
                    {
                        if(state.params.page>1){
                            state.params.page--;
                            return true;
                        }
                        return false;
                    }
                    if(number==='next'){
                        if(state.params.page<$scope.info.last_page){
                            state.params.page++;
                            return true;
                        }
                        return false;
                    }
                  state.params.page=number;
                };

                $scope.showNumber= function () {
                  var data=[];
                  for(var i=0;i<$scope.info.last_page;i++){
                      data.push(i+1);
                  }
                  console.log(data);
                  return data;
                };

                $scope.updateForm=function (id) {
                    $scope.emailForm="update form";
                    $http.post('email-update-form',{id}).then(function (res) {
                        $scope.template=res.data;
                        $scope.role_id=res.data.role_id;
                        console.log(res.data.role_id,'role_id',$scope.role_id);
                        CKEDITOR.instances['editor2'].setData($scope.template.body);

                    });
                };
            }

        })();

    </script>
@endpush
