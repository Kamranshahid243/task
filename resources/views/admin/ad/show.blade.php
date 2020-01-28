<div class="row box content">
    <div class="col-md-12 box-body">
        <table class="table table-responsive">
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Points</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="add in ads">
                <td>@{{ add.id }}</td>
                <td>@{{ add.title  }}</td>
                <td>@{{ add.created_at|limitTo:10 }}</td>
                <td class="text-center"><i class="fa fa-edit"></i></td>
            </tr>
            </tbody>
        </table>
        <div align="right">
            <nav>
                <ul class="pagination">
                    <li class="page-item">
                        <span class="page-link" ng-click="changePage('back')">Previous</span>
                    </li>
                    <li class="page-item" ng-click="changePage(number)" ng-repeat="number in showNumber()"><a class="page-link" href>@{{ number }}</a></li>
                    <li class="page-item">
                        <a class="page-link"  ng-click="changePage('next')" href>Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
