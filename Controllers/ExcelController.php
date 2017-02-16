<?php

class ExcelController
{
    static function exportExcel(&$gift_id, &$names)
    {

        require_once "/Classes/PHPExcel/IOFactory.php";
        require_once "/Classes/PHPExcel/Calculation.php";
        require_once "Classes/PHPExcel.php";

        //PHPExcel_Autoloader::Register();
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        /** PHPExcel_IOFactory */
        $names = explode(" ", $names);

        //Query start
        $query = "SELECT u.first_name,u.middle_name,u.surname,g.price,ug.is_active,ug.is_paid
FROM users AS u
LEFT JOIN users_gifts AS ug ON ug.user_id_from=u.id
LEFT JOIN gifts AS g on ug.gift_id=g.id
WHERE ug.gift_id=:gift_id";

        $stmt = Connection::$connection->prepare($query);
        $stmt->bindParam(":gift_id", $gift_id);
        $stmt->execute();
        $usersData = $stmt->fetchAll();
        //return  json_encode($usersData);
        $activeSheet = array();
        $doc = new PHPExcel();
        $doc->setActiveSheetIndex(0);
        //$activeSheet[]=$names;
        $activeSheet[] = array("Рожденик : ", $names[0], $names[1], $names[2]);
        $activeSheet[] = array("", "", "", "");
        $activeSheet[] = array("Име", "Презиме", "Фамилия", "Сума", "Активен", "Платил");
        foreach ($usersData as $user) {
            //A5first b5 c5middle d5surname e5 price
            $is_active = $user['is_active'];
            $is_paid = $user['is_paid'];
            $price = (($user['is_active'] == 1) && ($user['is_paid'] == 1)) ? $user['price'] : "0";
            $data = array($user['first_name'], $user['middle_name'], $user['surname'], $price, $is_active, $is_paid);
            $activeSheet[] = $data;
        }
        $doc->getActiveSheet()->getColumnDimension()->setAutoSize(true);

        $doc->getActiveSheet()->fromArray($activeSheet);


        //header('Content-Type: application/vnd.ms-excel;charset=utf-8');

        //tell browser what's the file name
        /*change everey time filename dynamic*/
        header("Content-Disposition: attachment;filename=export.xls;charset=utf-8");

        //header('Cache-Control: max-age=0;charset=utf-8'); //no cache

        $write = PHPExcel_IOFactory::createWriter($doc, 'Excel5');
        $write->save("php://output");

    }
}
