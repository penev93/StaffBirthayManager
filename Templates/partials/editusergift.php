<div class="col-xs-12 main">
    <section class="content">
        <div class=" col-xs-12 field_set_save_sum" data-gift_id="<?php echo $_GET["atr2"]; ?>">
            <fieldset class="col-sm-offset-3 col-sm-5">
                <legend>Обща сума</legend>
                <div class="col-sm-12">
                    <label class="">Сума:</label>
                    <input id="sum_birthday_gift" class="" type="text">
                    <button class="btn" id="save_sum_birthday_gift">Запази</button>
                </div>
                <div class="col-sm-8">
                    Сума на човек : <span class="avarage_birthday_sum"></span>
                </div>
            </fieldset>

        </div>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Име</th>
                        <th>Презиме</th>
                        <th>Фамилия</th>
                        <th>Платил</th>
                        <th>Бележка</th>
                        <th>Дължи</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($usersData['connections'] as $user) {

                        $sum += $user['is_active'] == 1 ? doubleval($user['price']) : 0;
                        $price_per_person = $user['price'] > 0 ? "<span>Цена за човек: </span>" . $user['price']." лв" : "";
                        $mathPercent = 0;
                        if ($user['ttl_paid'] != 0 || $user['ttl_wanted'] != 0) {
                            $mathPercent = (intval($user['ttl_paid']) / intval($user['ttl_wanted']));
                        }

                        $inPercent = 0;
                        if ($mathPercent < 1) {
                            $intPercent = round($mathPercent * 100, 2);

                        } else if ($mathPercent == 1) {
                            $intPercent = 100;
                        }
                        $price = "";

                        if (($user['is_active'] == 1) && ($user['is_paid'] == 0) && ($user['lock_birthday'] != null)) {
                            $price = "<input   type='checkbox' />";
                        } else if (($user['is_active'] == 0) && ($user['is_paid'] == 0) && ($user['lock_birthday'] == null)) {
                            $price = "<input type='checkbox' onclick='return false' />";
                        } else if (($user['is_active'] == 1) && ($user['is_paid'] == 1)) {
                            $price = "<input type='checkbox' checked/>";
                        } else if (($user['is_active'] == 1) && ($user['is_paid'] == 0)) {
                            $price = "<input  type='checkbox'/>";
                        }
                        if ($user['is_paid'] == 1) {
                            $btnUpdatePaid = "<input btn";
                        }
                        //lock switch button and decide checked or not
                        $is_active_checked = ($user['is_active'] == 1) ? "checked" : "";
                        $is_active_checked_locked = ($user['lock_birthday'] != null) ? 'disabled' : "";
                        $edit_active_switch = ($user['lock_birthday'] != null) ? '' : " <button class='btn btn-success' value='false' id='save_birthday_action'>Запази длъжници</button>";
                        //place btn or not
                        $is_gift_locked = $user['lock_birthday'];
                        $is_switch_checked=($user['lock_birthday'] != null) ? '':'checked';
                        $isBtnShow = (($user['is_active'] == 0) ? "" : "<input type='button' class='update_gift_status btn btn-primary'role='button' value='Запази плащане' />");

                        
                        echo "<tr>
                        <td>" . $user['first_name'] . "</td>
                        <td>" . $user['middle_name'] . "</td>
                        <td>" . $user['surname'] . "</td>
                        <td class='payment_checkbox'>" . $price . "</td>
                        <td><div>" . $user['note'] . "</div><button class='addNote' class='btn '>Добави бележка</button></span></td>
                        <td><input type='checkbox' name='my-checkbox' $is_switch_checked $is_active_checked_locked  $is_active_checked></td>
                        <td><input data-user_id='" . $user['id'] . "' type='hidden'/> $isBtnShow</td>
</tr>";
                    }
                    ?>
                    </tbody>
                </table>

            </div>
        </div>
        <div class="col-xs-offset-6">
            <!-- /.box-body -->
            <?php  echo $sum!=0?"Обща сума : " . $sum . " лв<br/>":""; ?>

            <?php echo $price_per_person; ?>
            <?php echo $edit_active_switch; ?>
        </div>
    </section>
</div>

