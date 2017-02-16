<?php
function basicRequest(&$Router, $requestType, $atr = null)
{
    if($_GET['atr1']=='Cron')
    {
        $Router->DoRouting();
    }
    if (isset($requestType)) {

        echo $Router->DoRouting();

        die();
    }

    if (isset($_SESSION['user'])) {

        $usersData = $Router->DoRouting();
        if ($atr == "Update") {
            if ($usersData == false) {
                header("Location:" . HOME_URL);
                die();
            }
        }
        return $usersData;
    }
}
