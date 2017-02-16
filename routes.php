<?php

class Router
{


    public function LoginRoute(&$username, &$password)
    {

        /**//* require_once "Controllers/LoginController.php";*/

        $LoginHandle = new LoginController();
        $user = $LoginHandle->ValidateLoginUser($username, $password);
        $dataType = gettype($user);

        if ($dataType == 'string') {
            //return error
            return json_encode(['invalid_user' => $user]);

        } else if (empty($user)) {
            //user not found
            return json_encode(['user_not_found' => "user_not_found"]);

        } else if ($dataType == 'array') {
            $_SESSION['user'] = $user['username'];

            //return correct user and login
            return json_encode($user);
        }
    }

    public function AddUserRoute(&$first_name, &$middle_name, &$surname, &$birthday)
    {
        $NewUserController = new AddUserController();
        return $NewUserController->AddNewUser($first_name, $middle_name, $surname, $birthday);

    }

    public function UpdateUserData(&$user_id, &$first_name, &$middle_name, &$surname, &$birthday)
    {
        $updateController = new UpdateUserController();
        return $updateController->updateUser($user_id, $first_name, $middle_name, $surname, $birthday);
    }

    public function HomepageRoute(&$year = null)
    {
        $homepageController = new HomepageController();
        $usersData = $homepageController->getHomepageData($year);
        return $usersData;

    }

    public function ExportExcelRoute(&$gift_id, &$names)
    {

        ExcelController::exportExcel($gift_id, $names);
    }

    public function LogoutRoute()
    {
        return LoginController::Logout();
    }

    //TODO
    public function DeleteUserRoute($data)
    {
        $deletedUser = new DeleteController();
        return $deletedUser->deleteUser($data);
    }

    public function AddNoteRoute(&$note, &$user_from, &$gift_id)
    {
        return EditBirthdayUserController::AddNoteRoute($note, $user_from, $gift_id);
    }

    public function GetNoteRoute(&$user_from, &$gift_id)
    {
        return EditBirthdayUserController::getNotes($user_from, $gift_id);
    }

    public function AddGiftsAndConnection(&$year)
    {
        return json_encode(HomepageController::generateBirthdayAndConnections($year));
    }

    public function EditBirhdayUserRoute(&$user_id)
    {
        $users_birthday_gifts_data = new EditBirthdayUserController();
        return $users_birthday_gifts_data::load($user_id);
    }

    public function LockBirthdayRoute(&$gift_id, &$price, &$users_id_is_active)
    {
        if ($price == '' || $price == '0.00') {
            return json_encode(array("error" => "Моля въведете стойност"));
        }
        return EditBirthdayUserController::LockBirthday($gift_id, $price, $users_id_is_active);
    }

    public function UpdateAdminRoute(&$admin_id, &$username, &$password = null, &$first_name)
    {
        if ($password == "") {
            return Admins::updateAdminWithoutPass($admin_id, $username, $first_name);
        } else {

            return Admins::updateAdmin($admin_id, $username, $password, $first_name);
        }

    }

    public function InsertPaymentRoute(&$user_id, &$gift_id, &$is_paid)
    {
        return EditBirthdayUserController::InsertPayment($user_id, $gift_id, $is_paid);
    }

    public function getAdminsRoute()
    {
        return Admins::getAdmins();
    }

    public function getUpdateDataRoute(&$user_id)
    {
        return UpdateUserController::getUser($user_id);
    }

    public function sendMail()
    {

        (new Cron())->toro();
    }

    function ajaxRequestHandle(&$request_data)
    {
        switch ($request_data) {
            case 'update_admin':

                return $this->UpdateAdminRoute($_POST['admin_id'], $_POST['username'], $_POST['password'], $_POST['first_name']);
                die();
                break;
            case 'get_note':
                return $this->GetNoteRoute($_POST['user_from'], $_POST['gift_id']);
                die();
                break;
            case 'add_note':
                return $this->AddNoteRoute($_POST['note'], $_POST['user_from'], $_POST['gift_id']);
                die();
                break;
            case 'update_user':

                $result = $this->UpdateUserData($_POST['id'], $_POST['first_name'], $_POST['middle_name'], $_POST['surname'], $_POST['birthday']);
                return $result;
                die();
                break;
            //TODO
            case 'lock_birthday':
                return $this->LockBirthdayRoute($_POST['gift_id'], $_POST['price'], $_POST['users_id_is_active']);
                die();
                break;
            case 'login':
                return $this->LoginRoute($_POST['username'], $_POST['password']);
                die();
                break;
            case 'add_user':
                return $this->AddUserRoute($_POST['first_name'], $_POST['middle_name'], $_POST['surname'], $_POST['birthday']);
            case 'destroy_session':
                return $this->LogoutRoute();
                die();
                break;
            case 'delete_user':
                return $this->DeleteUserRoute($_POST['user_id']);
            case 'destroy_session':
                return $this->LogoutRoute();
                die();
                break;
            case 'insert_payment':

                return $this->InsertPaymentRoute($_POST['user_from_id'], $_POST['gift_id'], $_POST['is_paid']);
                die();
                break;

            case 'add_new_gift_connection':
                return $this->AddGiftsAndConnection($_POST['year']);
                die();
                break;
            case 'excel_export':
                return $this->ExportExcelRoute($_POST['user_id'], $_POST['names']);
                die();
                break;
        }
    }


    function basicRequestHandle(&$atr1 = null)
    {
        //get atr2 parameter
        $atr2 = $_GET['atr2'];

        switch ($atr1) {
            case 'Cron':
                $this->sendMail();
                break;

            case 'Homepage':
                $usersData = $this->HomepageRoute($atr2);
                return $usersData;
            case "EditUserGifts":
                $gift_id = $atr2;
                $user_gifts = $this->EditBirhdayUserRoute($gift_id);
                return $user_gifts;

            case "Update":
                $user_id = $atr2;
                $user_data = $this->getUpdateDataRoute($user_id);
                if (count($user_data) == 0) {

                    header("Location: " . HOME_URL);
                    die();
                }

                return $user_data;
            case "Admin":
                $admins = $this->getAdminsRoute();
                return $admins;

            default :
                $usersData = $this->HomepageRoute();
                return $usersData;
                break;
        }
    }

    public function DoRouting()
    {

        if ($_REQUEST['requestType'] == 'ajax') {
            return $this->ajaxRequestHandle($_POST['action']);
        } else if ($_GET['action'] == 'download') {
            $this->ExportExcelRoute($_GET['download_id'], $_GET['names']);
            die();

        } else if (!isset($_REQUEST['requestType'])) {
            $splittedURL = explode('/', $_GET['atr1']);
            return $this->basicRequestHandle($splittedURL[0]);
        }
    }

    public function getTemplate()
    {

        if (isset($_SESSION['user'])) {
            $splittedURL = explode('/', $_GET['atr1']);

            switch ($splittedURL[0]) {
                case 'Admin':
                    return "Templates/partials/admin.php";
                    break;
                case 'Homepage':
                    return "Templates/homepage.php";
                    break;
                case "NewBirthday":
                    return "Templates/new_user.php";
                    break;
                case "EditUserGifts":
                    return "Templates/partials/editusergift.php";
                    break;
                case "Update":
                    return "Templates/partials/update.php";
                    break;
                default :
                    return "Templates/homepage.php";
            }

        } else if (!isset($_SESSION['user'])) {
            return "Templates/login.php";
        }
    }
}


