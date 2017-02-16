<div class="col-xs-12 main">
    <div class="col-xs-12">
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">Година
                <span class="caret"></span></button>
            <ul class="dropdown-menu scrollable-menu" role="menu">
                <?php
                $counterDown = 0;
                $entryYear=2016;
                $currentYear = intval(date("Y"));
                $finalYear=$currentYear+5;
                for ($i = $entryYear; $i <= $finalYear; $i++) {
                    $year = $i;
                    $year_exists = (in_array($year, $usersData[0]['year']) == 1 ? "true" : "false");
                    echo "<li><p class='homepage-dropdown-li' data-year_exists='" . $year_exists . "'>" . $year . "</p></li>";
                }
                ?>
            </ul>
        </div>
    </div>
    <section class="content">
        <div class="box">
            <!-- /.box-header -->

            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Име</th>
                        <th>Презиме</th>
                        <th>Фамилия</th>
                        <th>Рожден ден</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (!empty($usersData['users'])) {
                        //remove years array from usersData;
                        unset($usersData[0]);
                        foreach ($usersData as $users) {
                            //How much users gave gifts from all
                            foreach ($users as $user) {
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
                                echo "<tr>
                                <td >" . $user['first_name'] . "</td>
                                <td>" . $user['middle_name'] . "</td>
                                    <td>" . $user['surname'] . "</td>
                                    <td>" . $user['birthday'] . "</td>
                                    <td class='hidden-statistics'>
                                    <div class='hidden-procent'>" . $user['ttl_paid'] . " / " . $user['ttl_wanted'] .                                           "</div><div class='progress'>
                                <div class='progress-bar progress-bar-success' data-progress_value=" . $intPercent . " role='progressbar'                                   aria-valuenow='" . $intPercent . "'
                                aria-valuemin='0' aria-valuemax='100' style='width:" . $intPercent . "%'>
                                " . $intPercent . "% Complete (success)
                                  </div>
                                  </td>
                                  <td  class='col-lg-3  fixed_len_home_btn'>
                                  <div class='col-lg-12 col-lg-offset-1'><input type='hidden' value='" . $user['user_id'] . "'/>
                                    <a class='btn' href='" . HOME_URL . "EditUserGifts/" . $user['gift_id'] . "/'>Промяна на подаръци</a></div>
                                    <div class='col-lg-12 col-lg-offset-1'><a class='btn' href='" . HOME_URL . "Update/" . $user['user_id'] . "/" . $user['first_name'] . "/'>Редактирай потребител</a></div>
                                    <div class='col-lg-12 col-lg-offset-1'><input  type='button' data-export_id='" . $user['gift_id'] . "' class='export btn btn-primary' role='button'
                                           value='Експорт Ексел' /></div>
                                    <div class='col-lg-12 col-lg-offset-1'><input type='button'  name='delete' class='delete btn btn-primary' role='button'
                                           value='Изтрий' /></div>
                                           </td></tr>";
                            }
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>

    </section>
</div>