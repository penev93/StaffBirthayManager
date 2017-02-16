<div class="col-xs-12">
    <div class="col-xs-12">
        <h1 class="Title">
            <?php  switch ($_GET['atr1']) {
                case "Homepage":
                    echo "Панел за рожденни дни"." ".$_GET['atr2'];
                    break;
                case "EditUserGifts":
  
                    echo "Рожден ден на "." ".$usersData['birthday_boy'][0]['first_name']." ".$usersData['birthday_boy'][0]['surname'];
                    break;
                case "NewBirthday":
                    echo "Добави нов рожденик";
                    break;
                case "Admin":
                    echo "Администратори";
                    break;
                case "Update":
                    echo "Редактирай потребител ".$_GET['atr3'];
                    break;
                default:
                    echo "Панел за рожденни дни"." ".$_GET['atr2'];
            }


            ?>
        </h1>
    </div>
    <div class="col-sm-12">
        <input type="button" class="btn" value="Logout" id="logout"/>
        </div>
    <div class="col-sm-8 col-sm-offset-2">
        <div class="col-xs-4"><a class="btn" href="<?php echo HOME_URL; ?>Homepage/">Рожденици</a></div>
        <div class="col-xs-4"><a class="btn" href="<?php echo HOME_URL; ?>NewBirthday/">Добави рожденик</a></div>
        <div class="col-xs-4"><a class="btn" href="<?php echo HOME_URL; ?>Admin/">Администратори</a></div>
    </div>
</div>

<!--SELECT first_name,price
FROM users
LEFT JOIN gifts
ON users.id=gifts.user_to_id
WHERE users.id !=1-->

<!--общ брой на подараци към избран служител-->
<!--SELECT count(first_name)
FROM users
LEFT JOIN gifts
ON users.id=gifts.user_to_id
WHERE users.id !=1-->

<!--текущ общ брой на подараци към даден служител-->
<!--	SELECT count(gifts.user_from_id)
FROM users
LEFT JOIN gifts
ON users.id=gifts.uesr_to_id
WHERE users.id !=1-->

<!--
homepage podaraci vseki na vseki
SELECT users.first_name,users.middle_name,users.surname,users.birthday, (SELECT count(gifts.user_to_id) FROM gifts WHERE gifts.user_to_id=users.id) as Total FROM users

SELECT users.`first_name`,gifts.`price`
FROM users
LEFT JOIN gifts
ON users.id=gifts.user_from_id
WHERE gifts.user_to_id=4

/test
SELECT users.first_name,users.middle_name,users.surname,users.birthday, (SELECT gifts.price FROM gifts WHERE gifts.user_to_id=users.id) as Total FROM users where users.id!=4

//correct query
SELECT users.first_name,users.middle_name,users.surname,users.birthday, (SELECT gifts.price FROM gifts WHERE gifts.user_from_id=users.id) as Total FROM users where users.id!=4
-->
