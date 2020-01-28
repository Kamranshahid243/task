<div class="row" ng-show="emailForm=='email form'">
    <div class="col-md-12">

        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-header">
                Create Email Template
            </div>
            <div class="btn-group"  role="group" aria-label="Basic example">
                <a href="#" type="button" ng-click="insert(var)" ng-repeat="var in getVariables()" style="color: red;">@{{ var }} </a>
            </div>
            <br>
            <textarea name="editor1" id="editor1" ng-model="body" rows="10" cols="80">

            </textarea>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'editor1' );
            </script>
            <div class="box-body box-profile">
                <div class="form-group">
                    <label for="exampleInputEmail1">Template Type</label>
                    <select class="form-control" ng-model="type">
                        <option ng-repeat="type in templateTypes" value="@{{type}}">@{{type}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Role</label>
                    <select class="form-control" ng-model="role_id">
                        <option ng-repeat="role in roles" value="@{{role.id}}">@{{role.name}}</option>
                    </select>
                </div>
                <br><br>
                <button class="btn btn-primary" ng-click="saveTemplate()" ng-disabled="!body && !role_id">Save</button>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <!-- /.box -->
    </div>
</div>