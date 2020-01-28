@push('head-scripts')
    <script>
        (function () {
            angular.module("myApp").controller('MainController', MainController);
            function MainController($scope, $http) {
                var state=$scope.state={
                    params:{
                        page:1,
                        sort:'id',
                        perPage:5
                    }
                };
                function load() {
                    $http.get('load-ads',state).then(function (res) {
                        $scope.ads=res.data.data;
                        $scope.info=res.data;
                    })
                }
                $scope.save = function () {
                    $http.post('ad-management', {title: $scope.title, points: $scope.points}).then(function (res) {
                        load();
                    });
                };


                load();
                $scope.$watch('state.params', function () {
                },true);

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
                  return data;
                };

                $scope.updateForm=function (id) {
                    $scope.emailForm="update form";
                    $http.post('email-update-form',{id}).then(function (res) {


                    });
                };
            }

        })();

    </script>
@endpush
