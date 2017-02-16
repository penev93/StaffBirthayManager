<?php

/**
 * Created by PhpStorm.
 * User: Replace
 * Date: 3.11.2016 г.
 * Time: 09:29 ч.
 */
class HomepageController
{

    public function getHomepageData(&$date_year=null)
    {
                    $allData=[];
                    $years=array();
                    $getYearsArray=array("years"=>SELF::getYearBirthdays());
                    $yearArray=[];
                    foreach ($getYearsArray as $item)
                    {
                        foreach ($item as $year)
                        {
                            $yearArray[]=$year['year'];

                        }

                    }
                    $years['year']=$yearArray;

                    $allData[]=$years;


            if(!empty($date_year))
            {

                        $sql = "SELECT u.id AS 'user_id' ,u.first_name, u.middle_name, u.surname, u.birthday,g.id as gift_id, COUNT(u2.id) AS ttl_wanted, COUNT(u3.id) AS ttl_paid FROM gifts AS g 
            LEFT JOIN users AS u ON g.user_id = u.id 
            LEFT JOIN users_gifts AS ug ON g.id = ug.gift_id 
            LEFT JOIN users AS u2 ON ug.user_id_from = u2.id AND ug.is_active = 1 
            LEFT JOIN users AS u3 ON ug.user_id_from = u3.id AND ug.is_active = 1 AND ug.is_paid = 1 WHERE g.year = :year AND u.is_delete IS NULL GROUP BY u.id ,g.id";

                $sth = Connection::$connection->prepare($sql);
                $sth->execute(array(":year"=>$date_year));
                $usersData = $sth->fetchAll();
                $allData['users']=$usersData;

            }

        return $allData;

    }

    private static function getYearBirthdays()
    {
        $query="SELECT DISTINCT `year` FROM `gifts` ";
        $stmt = Connection::$connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }

    static function generateBirthdayAndConnections(&$year)
    {
        $selectUsersIDQuery="SELECT id AS user_id FROm users WHERE `is_delete` IS NULL ";
        $stmt=Connection::$connection->prepare($selectUsersIDQuery);
        $stmt->execute();
        $usersID=$stmt->fetchAll();
        foreach ($usersID as $user)
        {
            $insertNewGift="INSERT INTO `gifts` (`year`,`price`,`user_id`) VALUES(:year, :price, :user_id)";
            $stmt=Connection::$connection->prepare($insertNewGift);
            $stmt->execute(array(':year'=>$year,":price"=>'0',':user_id'=>$user['user_id']));
            $lastGiftID=Connection::$connection->lastInsertId();
            $count=$stmt->rowCount();
            if($count>0)
            {
                foreach($usersID as $connectUsers)
                {

                    if($connectUsers['user_id']!=$user['user_id']){
                        
                        $insertNewGiftUsers="INSERT INTO `users_gifts` (`user_id_from`,`gift_id`,`is_active`,`is_paid`) 
                                                VALUES(:gift_from,:gift_id,:is_active,:is_paid)";
                        $stmt=Connection::$connection->prepare($insertNewGiftUsers);
                        $stmt->execute(array(':gift_from'=>$connectUsers['user_id'],":gift_id"=>$lastGiftID,':is_active'=>'0',":is_paid"=>'0'));

                    }
                }

            }
        }
        return json_encode("ok");
    }

}
/*select users.first_name,users.middle_name,users.surname,users.birthday,COUNT(users_gift.gift_id)
    FROM users LEFT JOIN users_gifts ON users.id=users_gifts.user_id_from;*/