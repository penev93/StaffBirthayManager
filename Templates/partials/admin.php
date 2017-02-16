<div class="col-xs-12 main">

    <div class="col-xs-12">
    </div>
    <section class="content">
        <div class="box">
            <!-- /.box-header -->

            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Потребител</th>
                        <th>Парола</th>
                        <th>Име</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                   <?php

                       foreach ($usersData as $admin){

                           echo "<tr><td>".$admin['username']."</td><td>".$admin['password']."</td><td>".$admin['first_name']."</td><td>  <input type='button' class='edit-admin btn btn-primary' role='button'
                                           value='Редактирай' /><input data-admin_id='".$admin['id']."' class='save-admin btn btn-warning' type='button' name='save'
                                    value='Запази'/></td></tr>";

                        }
                    ?>

                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>

    </section>
</div>
<!--/*<input class='edit btn btn-primary' data-user_id='' type='button' name='update'
         value='Редактирай'/><input class='save btn btn-warning' type='button' name='save'
                                    value='Запази'/>*/-->