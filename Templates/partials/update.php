
<input type="hidden" value="<?php echo $usersData['id'];?>" class="edit_user_id"/>
<div class="col-xs-12 col-sm-8 col-sm-offset-2 add_new_user">
    <div class="form-inline">
        <div class="form-group">
            <label for="name">Име</label><br/>

            <input type="text" size="12" value="<?php echo $usersData['first_name'] ?>" class="form-control" id="edit_first_name" >
        </div>
        <div class="form-group">
            <label for="middle_name">Презиме</label><br/>
            <input type="text" size="12" value="<?php echo $usersData['middle_name'] ?>"  class="form-control" id="edit_middle_name">
        </div>
        <div class="form-group">
            <label for="surname">Фамилия</label><br/>
            <input type="text" size="12" value="<?php echo $usersData['surname'] ?>"  class="form-control" id="edit_surname" >
        </div>
        <div class="form-group">
            <label for="birthday">Рожденна дата</label><br/>
            <input type="text" value="<?php echo $usersData['birthday'] ?>" size="12" class="form-control datepicker" id="edit_birthday">
        </div><br/>
        <div class="col-xs-12 col-sm-8 col-sm-offset-3">
            <button id="edit_user" class="btn btn-primary">Промени потребител</button>
        </div>
    </div>
</div>