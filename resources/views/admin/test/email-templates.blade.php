<div class="row box content" ng-show="emailForm=='template list'">
    <div class="col-md-12 box-body">
        <table class="table table-responsive">
            <thead>
            <tr>
                <th>ID</th>
                <th>Body</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="email in emails">
                <td>@{{ email.id }}</td>
                <td>@{{ email.body |limitTo:10 }}</td>
                <td>@{{ email.role.name }}</td>
                <td>@{{ email.created_at }}</td>
                <td class="text-center"><i class="fa fa-edit" ng-click="updateForm(email.id)"></i></td>
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
