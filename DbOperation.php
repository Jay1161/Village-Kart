<?php

class DbOperation
{
    //Database connection link
    private $con;

    //Class constructor
    function __construct()
    {
        //Getting the DbConnect.php file
        require_once dirname(__FILE__) . '/DbConnect.php';

        //Creating a DbConnect object to connect to the database
        $db = new DbConnect();

        //Initializing our connection link of this class
        //by calling the method connect of DbConnect class
        $this->con = $db->connect();
    }

    /*
    * The create operation
    * When this method is called a new record is created in the database
    */
    function insert($fname, $lname, $add, $city, $email, $password, $mobile)
    {


        $q = "select * from reg_form where email='$email' and mobile_no='$mobile'";
        $data = mysqli_query($this->con, $q);
        $row = mysqli_num_rows($data);

        if ($row > 0) {

            return false;
        }


        $stmt = "INSERT INTO `reg_form`(`first_name`, `last_name`, `address`, `city`, `mobile_no`, `email`, `password`) VALUES ('$fname','$lname','$add','$city','$mobile','$email','$password')";
        $data2 = mysqli_query($this->con, $stmt);

        if ($data2) {

            $this->initWallet($this->con->insert_id);
            return true;

        } else {

            return false;
        }
    }


    private function initWallet($user_id)
    {
        $stmt = "INSERT INTO `wallet`(`user_id`) VALUES($user_id)";
        $this->con->query($stmt);
    }

    public function AddMoney($user_id, $amount)
    {
        $stmt = "UPDATE `wallet` set amount = amount+$amount  where user_id = $user_id";
        $data = $this->con->query($stmt);

        return $data ? true : false;
    }


    public function GetMoney($user_id)
    {

        $money = $this->getWalletBalance($user_id);
        $outer = array();

        for ($i = 0; $i < 1; $i++) {
            $inner = array();
            $inner['wallet'] = $money;
            array_push($outer, $inner);
        }

        return $outer;
    }


    private function deductWallet($user_id, $amount)
    {
        $stmt = "UPDATE `wallet` set amount = amount-$amount where user_id = $user_id";
        $this->con->query($stmt);
    }


    private function getWalletBalance($user_id)
    {
        $stmt = "SELECT * FROM `wallet` where user_id = $user_id";
        $data = $this->con->query($stmt);
        $obj = $data->fetch_object();

        return $obj->amount;
    }


    function login($email, $password)
    {


        $sql = "select * from reg_form where email='$email' and password='$password'";
        $stmt = mysqli_query($this->con, $sql);

        $num = mysqli_num_rows($stmt);

        if ($num > 0) {

            return true;
        } else {

            return false;
        }
    }


    /*---------------------------------------------Update NEW Password *---------------------------------------*/

    function update_new_password($new_pwd, $email)
    {


        $sql = "update reg_form set password='$new_pwd' where email='$email'";
        $stmt = mysqli_query($this->con, $sql);

        if ($stmt) {

            return true;
        } else {
            return false;
        }
    }


    function ChangePwd($old, $new, $email)
    {


        $sql = "select * from reg_form where email='$email' and password='$old'";
        $stmt = mysqli_query($this->con, $sql);

        $num = mysqli_num_rows($stmt);


        if ($num > 0) {

            $sql = "UPDATE reg_form SET password = '$new' WHERE password = '$old' and email = '$email'";
            $stmt = mysqli_query($this->con, $sql);


            return true;
        } else {

            return false;
        }
    }

    /*
    * The read operation
    * When this method is called it is returning all the existing record of the database
    */


    function getData3($personid)
    {


        $stmt = $this->con->prepare("SELECT * FROM reg_form where person_id='$personid'");
        $stmt->execute();
        $stmt->bind_result($id, $personid, $name, $img, $email, $password, $mobile, $block, $city, $dob, $widraw, $mobile_verified, $state_verified, $account_verified, $proof_verified, $pan_name, $pan_no, $pan_state, $bank_name, $bank_account_no, $bank_ifsc, $bank_balance);

        $heroes = array();

        while ($stmt->fetch()) {
            $hero = array();
            $hero['userid'] = $id;
            $hero['person_id'] = $personid;
            $hero['user_name'] = $name;
            $hero['user_image'] = $img;
            $hero['email'] = $email;
            $hero['password'] = $password;
            $hero['mobile_no'] = $mobile;
            $hero['block'] = $block;
            $hero['city'] = $city;
            $hero['dob'] = $dob;
            $hero['widraw'] = $widraw;
            $hero['mobile_verified'] = $mobile_verified;
            $hero['state_verified'] = $state_verified;
            $hero['account_verified'] = $account_verified;
            $hero['proof_verified'] = $proof_verified;
            $hero['pan_name'] = $pan_name;
            $hero['pan_no'] = $pan_no;
            $hero['pan_state'] = $pan_state;
            $hero['bank_name'] = $bank_name;
            $hero['bank_account_no'] = $bank_account_no;
            $hero['bank_ifsc'] = $bank_ifsc;
            $hero['bank_balance'] = $bank_balance;

            array_push($heroes, $hero);
        }

        return $heroes;
    }


    function getData2($email)
    {
        $stmt = $this->con->prepare("SELECT * FROM reg_form where email='$email'");
        $stmt->execute();
        $stmt->bind_result($id, $fname, $lname, $image, $add, $city, $mobile, $email, $password, $block);

        $heroes = array();

        while ($stmt->fetch()) {
            $hero = array();
            $hero['user_id'] = $id;
            $hero['first_name'] = $fname;
            $hero['last_name'] = $lname;
            $hero['image'] = $image;
            $hero['address'] = $add;
            $hero['city'] = $city;
            $hero['email'] = $email;
            $hero['password'] = $password;
            $hero['mobile_no'] = $mobile;
            $hero['block'] = $block;


            array_push($heroes, $hero);
        }

        return $heroes;
    }


    /*function  ($id){

$stmt = "SELECT * FROM `my_stock`,team WHERE my_stock.player_type > 1 and (my_stock.plid and team.user_id = '$id')";
$data = mysqli_query($this->con,$stmt);


$stmt2 = "SELECT * FROM `my_stock` WHERE player_type = 2 and plid = 10='$id'";
$data2= mysqli_query($this->con,$stmt2);


        $heroes = array();

        while($rs = mysqli_fetch_assoc($data)){
            $hero  = array();


            $hero['league_id'] = $rs['league_id'];
            $hero['league_name'] = $rs['league_name'];
            $hero['winning_amount'] = $rs['winning_amount'];
            $hero['league_date'] = $rs['league_date'];
            $hero['rank'] = $rs['rank'];
            $hero['entry_fees'] = $rs['entry_fees'];
             $hero['mtid'] = $rs['mt_id'];
             $hero['player_type'] = $rs['player_type'];

                 if($rs['player_type'] == "2"){

             $hero['king'] = $rs[''];

         }
            $hero['queen'] = $queen;

             $hero['paid'] = $rs['is_paid'];

            array_push($heroes, $hero);
        }

        return $heroes;
    }


    */


    function getHistory($id)
    {

        $stmt = "SELECT * FROM team WHERE user_id = '$id'";
        $data = mysqli_query($this->con, $stmt);


        $heroes = array();

        while ($rs = mysqli_fetch_assoc($data)) {
            $hero = array();


            $mtid = $rs['mt_id'];
            $hero['league_id'] = $rs['league_id'];
            $hero['league_name'] = $rs['league_name'];
            $hero['entry_fees'] = $rs['entry_fees'];
            $hero['is_paid'] = $rs['is_paid'];

            $stmt2 = "SELECT * FROM `my_stock` WHERE player_type > 1 and (plid = '$id' and mt_id='" . $mtid . "')";
            $data2 = mysqli_query($this->con, $stmt2);


            while ($rs2 = mysqli_fetch_assoc($data2)) {


                $hero['mt_id'] = $rs2['mt_id'];


                if ($rs2['player_type'] == "2") {

                    $stmt3 = "SELECT * FROM `my_stock` WHERE player_type > 1 and (plid = '$id' and mt_id='" . $mtid . "') and player_type = '2'";
                    $data3 = mysqli_query($this->con, $stmt3);
                    $rs3 = mysqli_fetch_assoc($data3);

                    $hero['king'] = $rs3['stock_name'];
                    $hero['player_type'] = $rs2['player_type'];
                } //if

                else if ($rs2['player_type'] == "3") {

                    $stmt3 = "SELECT * FROM `my_stock` WHERE player_type > 1 and (plid = '$id' and mt_id='" . $mtid . "') and player_type = '3'";
                    $data3 = mysqli_query($this->con, $stmt3);
                    $rs3 = mysqli_fetch_assoc($data3);

                    $hero['queen'] = $rs3['stock_name'];
                    $hero['player_type'] = $rs2['player_type'];
                } // else if


            } // inner While


            array_push($heroes, $hero);
        } // Outer WHile

        return $heroes;
    }


    /*-------------------------------------------------------GetAllLeague*----------------------------------------------------------------*/


    function getAllLeague()
    {

        $stmt = $this->con->prepare("SELECT * FROM league_history");
        $stmt->execute();
        $stmt->bind_result($league_id, $league_name, $winning_amount, $league_date, $rank, $entry_fees, $comments, $total_teams, $teams_left, $total_winners, $user_id, $widraw, $king, $queen, $mtid, $paid);

        $heroes = array();

        while ($stmt->fetch()) {
            $hero = array();
            $hero['league_id'] = $league_id;
            $hero['league_name'] = $league_name;
            $hero['winning_amount'] = $winning_amount;
            $hero['league_date'] = $league_date;
            $hero['rank'] = $rank;
            $hero['entry_fees'] = $entry_fees;
            $hero['comments'] = $comments;
            $hero['total_teams'] = $total_teams;
            $hero['teams_left'] = $teams_left;
            $hero['total_winners'] = $total_winners;
            $hero['user_id'] = $user_id;
            $hero['widraw'] = $widraw;
            $hero['king'] = $king;
            $hero['queen'] = $queen;
            $hero['mtid'] = $mtid;
            $hero['paid'] = $paid;

            array_push($heroes, $hero);
        }

        return $heroes;
    }


    /*-------------------------------------------------------RankFromTo*----------------------------------------------------------------*/

    function getRankFromTo($from, $to)
    {

        $stmt = $this->con->prepare("SELECT * FROM `league_history` WHERE rank BETWEEN '$from' and '$to'");
        $stmt->execute();
        $stmt->bind_result($league_id, $league_name, $winning_amount, $league_date, $rank, $entry_fees, $comments, $total_teams, $teams_left, $total_winners, $user_id, $widraw, $king, $queen, $mtid, $paid);

        $heroes = array();

        while ($stmt->fetch()) {
            $hero = array();
            $hero['league_id'] = $league_id;
            $hero['league_name'] = $league_name;
            $hero['winning_amount'] = $winning_amount;
            $hero['league_date'] = $league_date;
            $hero['rank'] = $rank;
            $hero['entry_fees'] = $entry_fees;
            $hero['comments'] = $comments;
            $hero['total_teams'] = $total_teams;
            $hero['teams_left'] = $teams_left;
            $hero['total_winners'] = $total_winners;
            $hero['user_id'] = $user_id;
            $hero['widraw'] = $widraw;
            $hero['king'] = $king;
            $hero['queen'] = $queen;
            $hero['mtid'] = $mtid;
            $hero['paid'] = $paid;

            array_push($heroes, $hero);
        }

        return $heroes;
    }


    /*-------------------------------------------------------AmountFromTo*----------------------------------------------------------------*/


    function getAmountFromTo($from, $to)
    {

        $stmt = $this->con->prepare("SELECT * FROM `league_history` WHERE winning_amount BETWEEN '$from' and '$to'");
        $stmt->execute();
        $stmt->bind_result($league_id, $league_name, $winning_amount, $league_date, $rank, $entry_fees, $comments, $total_teams, $teams_left, $total_winners, $user_id, $widraw, $king, $queen, $mtid, $paid);

        $heroes = array();

        while ($stmt->fetch()) {
            $hero = array();
            $hero['league_id'] = $league_id;
            $hero['league_name'] = $league_name;
            $hero['winning_amount'] = $winning_amount;
            $hero['league_date'] = $league_date;
            $hero['rank'] = $rank;
            $hero['entry_fees'] = $entry_fees;
            $hero['comments'] = $comments;
            $hero['total_teams'] = $total_teams;
            $hero['teams_left'] = $teams_left;
            $hero['total_winners'] = $total_winners;
            $hero['user_id'] = $user_id;
            $hero['widraw'] = $widraw;
            $hero['king'] = $king;
            $hero['queen'] = $queen;
            $hero['mtid'] = $mtid;
            $hero['paid'] = $paid;

            array_push($heroes, $hero);
        }

        return $heroes;
    }


    /*-------------------------------------------------------Nifty50*----------------------------------------------------------------*/


    function getNifty50($type)
    {

        $stmt = $this->con->prepare("SELECT * FROM `all_stocks` WHERE instra_type = '$type'");
        $stmt->execute();
        $stmt->bind_result($asset_token, $display_name, $exchange, $expiry_date, $isin, $instra_type, $lot_size, $min_lot, $multiplier, $opt_type, $smid, $series_group, $strike_price, $symbol, $ticket_size, $token, $unit);

        $heroes = array();

        while ($stmt->fetch()) {
            $hero = array();
            $hero['asset_token'] = $asset_token;
            $hero['display_name'] = $display_name;
            $hero['exchange'] = $exchange;
            $hero['expiry_date'] = $expiry_date;
            $hero['isin'] = $isin;
            $hero['instra_type'] = $instra_type;
            $hero['lot_size'] = $lot_size;
            $hero['min_lot'] = $min_lot;
            $hero['multiplier'] = $multiplier;
            $hero['opt_type'] = $opt_type;
            $hero['smid'] = $smid;
            $hero['series_group'] = $series_group;
            $hero['strike_price'] = $strike_price;
            $hero['symbol'] = $symbol;
            $hero['ticket_size'] = $ticket_size;
            $hero['token'] = $token;
            $hero['unit'] = $unit;

            array_push($heroes, $hero);
        }

        return $heroes;
    }


    /*------------------------------------------------------GET ALL COUNT*----------------------------------------------------------------*/


    function getAllCount($mtid)
    {

        $stmt = "SELECT * FROM my_stock,team where my_stock.mt_id = team.mt_id and (my_stock.mt_id and team.mt_id = '$mtid')";
        $data = mysqli_query($this->con, $stmt);


        $heroes = array();


        $i = 1000;

        while ($rs = mysqli_fetch_assoc($data)) {
            $hero = array();
            $hero['mtid'] = $rs['mt_id'];
            $hero['smid'] = $rs['smid'];
            $hero['stock_token'] = $rs['stock_token'];
            $hero['stock_name'] = $rs['stock_name'];
            $hero['player_type'] = $rs['player_type'];
            $hero['plid'] = $rs['plid'];
            $hero['stock_rate'] = $i;

            $i++;

            array_push($heroes, $hero);
        }

        return $heroes;
    }


    /*------------------------------------------------------GET ALL COUNT---2*----------------------------------------------------------------*/


    function getAllCount2($mtid)
    {

        $stmt = "SELECT * FROM my_stock,team where my_stock.mt_id = team.mt_id and (my_stock.mt_id and team.mt_id = '$mtid')";
        $data = mysqli_query($this->con, $stmt);


        $heroes = array();


        $i = 1000;

        while ($rs = mysqli_fetch_assoc($data)) {
            $hero = array();
            $hero['mtid'] = $rs['mt_id'];
            $hero['smid'] = $rs['smid'];
            $hero['stock_token'] = $rs['stock_token'];
            $hero['stock_name'] = $rs['stock_name'];
            $hero['player_type'] = $rs['player_type'];


            if ($rs['player_type'] == "2") {


                $hero['king'] = $rs['stock_name'];
            } else if ($rs['player_type'] == "3") {

                $hero['queen'] = $rs['stock_name'];
            }


            $hero['plid'] = $rs['plid'];
            $hero['stock_rate'] = $i;

            $i++;

            array_push($heroes, $hero);
        }

        return $heroes;
    }

    /*-------------------------------------------------------Count*----------------------------------------------------------------*/


    function getCount()
    {

        $stmt = $this->con->prepare("SELECT teams_left,total_teams FROM `league_history`");
        $stmt->execute();
        $stmt->bind_result($teams_left, $total_teams);

        $heroes = array();

        while ($stmt->fetch()) {
            $hero = array();

            $hero['total_teams'] = $total_teams;
            $hero['teams_left'] = $teams_left;


            array_push($heroes, $hero);
        }

        return $heroes;
    }


    /*-------------------------------------------------------GET Edit Count*---------------------------------------------------------*/


    function getEditCount($mtid)
    {

        $stmt = "SELECT count(*) as cnt FROM my_stock where mt_id='$mtid'";
        $data = mysqli_query($this->con, $stmt);


        if ($data) {
            $rs = mysqli_fetch_assoc($data);

            return $rs['cnt'];
        } else {

            return "0";
        }
    }

    /*-------------------------------------------------------SET TEAM*----------------------------------------------------------------*/


    function setTeam($league_id, $league_name, $entry_fees, $user_id, $winning_amount, $league_date, $rank)
    {


        /*
$stmt = $this->con->prepare("INSERT INTO `team`(`league_id`, `league_name`, `entry_fees`, `user_id`, `winning_amount`, `league_date`, `rank`) VALUES (?,?,?,?,?,?,?)");
$stmt->bind_param("ississs",$league_id,$league_name,$entry_fees,$user_id,$winning_amount,$league_date,$rank);
$stmt->execute();

*/

        $stmt = "INSERT INTO `team`(`league_id`, `league_name`, `entry_fees`, `user_id`, `winning_amount`, `league_date`, `rank`,`date`, `time`) VALUES ('$league_id','$league_name','$entry_fees','$user_id','$winning_amount','$league_date','$rank',NOW(),NOW())";

        $data = mysqli_query($this->con, $stmt);

        if ($data) {

            //SELECT mt_id FROM `team` WHERE user_id='10' and league_id='1' and mt_id=(select max(mt_id) from team)
            $sql = "SELECT mt_id FROM `team` WHERE user_id='$user_id' and league_id='$league_id' and mt_id=(select max(mt_id) from team)";
            $data = mysqli_query($this->con, $sql);
            $num = mysqli_num_rows($data);

            if ($num > 0) {


                $rs = mysqli_fetch_assoc($data);

                return $rs['mt_id'];
            } else {

                return "0";
            }
        }
    }

    /*-------------------------------------------------------STock ADD*----------------------------------------------------------------*/


    function StockAdd($mtid, $smid, $token, $stockname, $playertype, $sharetype)
    {


        //$q= "SELECT * FROM my_stock,team WHERE my_stock.mt_id = team.mt_id and (my_stock.mt_id and team.mt_id = '$mtid')";
        $q = "SELECT * FROM team WHERE mt_id = '$mtid'";
        $data = mysqli_query($this->con, $q);
        $rs = mysqli_fetch_assoc($data);


        $plid = $rs['user_id'];


        /*
$stmt = $this->con->prepare("INSERT INTO my_stock( `stock_name`, `stock_token`, `smid`, `mt_id`, `player_type`, `share_type`,plid) VALUES (?,?,?,?,?,?,?)");
$stmt->bind_param("sssssss",$stockname,$token,$smid,$mtid,$playertype,$sharetype,$plid);
$stmt->execute();


*/


        $stmt = "INSERT INTO my_stock( `stock_name`, `stock_token`, `smid`, `mt_id`, `player_type`, `share_type`,plid) VALUES ('$stockname','$token','$smid','$mtid','$playertype','$sharetype','$plid')";

        $d = mysqli_query($this->con, $stmt);


        if ($d) {

            return $plid;
        } else {

            return "0";
        }
    }


    /*-------------------------------------------------------STock Count*----------------------------------------------------------------*/


    function StockCount($mtid)
    {


        $q = "SELECT * FROM team WHERE mt_id = '$mtid'";
        $data = mysqli_query($this->con, $q);
        $rs = mysqli_fetch_assoc($data);


        $plid = $rs['user_id'];


        $q1 = "SELECT count(*) as cnt FROM my_stock where plid = '$plid' and mt_id = '$mtid'";
        $data2 = mysqli_query($this->con, $q1);
        $rs2 = mysqli_fetch_assoc($data2);


        $count = $rs2['cnt'];


        if ($data2) {

            return $count;
        } else {

            return "0";
        }
    }


    /*-------------------------------------------------------GET EDIT LEAGUE*-----------------------------------------------------------*/


    function getEditLeague($mtid)
    {


        //$q= "SELECT * FROM `all_stocks`,my_stock WHERE (all_stocks.smid = my_stock.smid) and my_stock.mt_id = '$mtid'";
        /*$q= "SELECT * FROM my_stock WHERE mt_id = '$mtid'";
    $data = mysqli_query($this->con,$q);

    $heroes = array();

    while ($rs = mysqli_fetch_assoc($data)){


            $hero = array();

            $hero['stock_id'] = $rs['stock_id'];
            $hero['stock_name'] = $rs['stock_name'];
            $hero['stock_token'] = $rs['stock_token'];
            $hero['smid'] = $rs['smid'];
            $hero['mt_id'] = $rs['mt_id'];
            $hero['player_type'] = $rs['player_type'];
            $hero['share_type'] = $rs['share_type'];
            $hero['plid'] = $rs['plid'];


            array_push($heroes, $hero);


        }


         return $heroes;


*/


        $q = "SELECT * FROM `all_stocks`";
        $data = mysqli_query($this->con, $q);

        $heroes = array();


        while ($rs = mysqli_fetch_assoc($data)) {
            $hero = array();


            $sm = $rs['smid'];

            $q2 = "SELECT * FROM `my_stock` where smid = '$sm' and mt_id='$mtid'";
            $data2 = mysqli_query($this->con, $q2);
            $num = mysqli_num_rows($data2);

            if ($num > 0) {


                $rs2 = mysqli_fetch_assoc($data2);

                $hero['display_name'] = $rs['display_name'];
                $hero['share_type'] = "1";
                $hero['player_type'] = $rs2['player_type'];
                $hero['token'] = $rs['token'];
                $hero['smid'] = $rs['smid'];
                $hero['hint'] = "00";

                // while($rs2 =  mysqli_fetch_assoc($data2) ){


                // 		// if($rs2['smid'] == $rs['smid']){


                // 		// }

                // 		else if ($rs2['smid'] != $rs['smid']){

                // 			$hero['display_name'] = $rs['display_name'];
                // 			$hero['hint']  = "01";
                // 		}


                // }

            } else {

                $hero['display_name'] = $rs['display_name'];
                $hero['share_type'] = "1";
                $hero['player_type'] = "0";

                $hero['token'] = $rs['token'];
                $hero['smid'] = $rs['smid'];
                $hero['hint'] = "01";
            }

            array_push($heroes, $hero);
        }


        return $heroes;
    }


    /*-------------------------------------------------------Compare_for_Delete*----------------------------------------------------------*/


    function Compare_for_Delete($mtid)
    {


        $q = "SELECT * FROM team WHERE mt_id = '$mtid'";
        $data = mysqli_query($this->con, $q);
        $rs = mysqli_fetch_assoc($data);


        $plid = $rs['user_id'];

        if ($data) {

            return $plid;
        } else {

            return "0";
        }
    }

    /*-----------------------------------------------------Delete WHOLE TEAM*--------------------------------------------------------*/


    function deleteWholeTeam($mtid)
    {


        $q = "DELETE FROM team WHERE mt_id = '$mtid'";
        $data = mysqli_query($this->con, $q);


        if ($data) {

            $q = "DELETE FROM my_stock WHERE mt_id = '$mtid'";
            $data = mysqli_query($this->con, $q);

            if ($data) {
                return true;
            } else {
                return false;
            }
        } else {

            return false;
        }
    }

    /*-------------------------------------------------------UPDATE KING*-------------------------------------------------------*/

    function updateKing($smid, $plid, $mtid, $token, $name, $type)
    {


        $q = "UPDATE my_stock set player_type='$type' WHERE smid = '$smid' and mt_id='$mtid' and stock_token='$token' and stock_name='$name' and plid='$plid'";
        $data = mysqli_query($this->con, $q);


        if ($data) {

            return true;
        } else {

            return false;
        }
    }


    /*------------------------------------------------UPDATE KING QUEEN PLID*--------------------------------------------------------*/

    function updateKingbyPlid($smid, $plid, $mtid, $token, $name, $type)
    {


        $q = "UPDATE my_stock set player_type='1' WHERE mt_id='$mtid' and (plid='$plid' and player_type = '$type')";
        $data = mysqli_query($this->con, $q);

        if ($data) {

            $q = "UPDATE my_stock set player_type='$type' WHERE smid = '$smid' and mt_id='$mtid' and stock_token='$token' and stock_name='$name' and plid='$plid'";
            $data = mysqli_query($this->con, $q);


            if ($data) {

                return true;
            } else {

                return false;
            }
        }
    }

    /*-------------------------------------------------------Delete_Team*----------------------------------------------------------------*/


    function Delete_Team($mtid, $smid)
    {


        $q2 = "SELECT * FROM team WHERE mt_id = '$mtid'";
        $data2 = mysqli_query($this->con, $q2);
        $rs = mysqli_fetch_assoc($data2);


        $plid = $rs['user_id'];


        $q = "DELETE FROM `my_stock` WHERE plid = '$plid' and (smid ='$smid' and mt_id='$mtid')";
        $data = mysqli_query($this->con, $q);
        //	$rs = mysql_fetch_assoc($data);


        if ($data) {

            $q = "SELECT count(*) as cnt FROM my_stock where plid = '$plid' and mt_id='$mtid'";
            $data = mysqli_query($this->con, $q);
            $rs = mysqli_fetch_assoc($data);


            return $rs['cnt'];
        } else {

            return "0";
        }
    }


    /*-------------------------------------------------------Get BALANCE*----------------------------------------------------------------*/


    function getBalance($id)
    {


        $q = "SELECT bank_balance FROM `reg_form` WHERE userid='$id'";
        $data = mysqli_query($this->con, $q);
        $rs1 = mysqli_fetch_assoc($data);


        $q2 = "SELECT sum(winning_amount) as winning_amount FROM `league_history` WHERE userid='$id' AND widraw=0";
        $data2 = mysqli_query($this->con, $q2);
        $rs2 = mysqli_fetch_assoc($data2);


        $heroes = array();
        $hero = array();

        $heroes['bank_balance'] = $rs1['bank_balance'];
        $heroes['winning_amount'] = $rs2['winning_amount'];

        $len = count($heroes);

        for ($i = 0; $i < 1; $i++) {


            array_push($hero, $heroes);
        }

        return $hero;
    }


    /*--------------------------------------------Image Upload-----------------------------------------------------------*/

    function Upload($userid, $image)
    {

        $img_name = $userid . "_userImage" . ".jpg";
        $insertion_path = "../images/" . $userid . "_userImage" . ".jpg";
        // $path = "images/" . $userid . "_userImage" . ".png";
        // $actualpath = "http://192.168.1.9:9999/akil_surti/" . $path;

        file_put_contents($insertion_path, base64_decode($image));

        $sql = "update reg_form set image='$img_name' where user_id = '$userid'";

        if (mysqli_query($this->con, $sql)) {

            return true;
        } else {

            return false;
        }
    }


    /*----------------------------------------------- CART INSERT---------------------------------------------------*/


    function insertCart($product_id, $qty, $total_price, $cat_id, $user_id)
    {

        $q = " SELECT product_id FROM `cart` WHERE user_id='$user_id' and product_id='$product_id' and is_purchased='0'";
        $data = mysqli_query($this->con, $q);
        $num = mysqli_num_rows($data);


        if ($num > 0) {

            return false;
        }


        $stmt = "INSERT INTO cart (product_id,qty,total_price,cat_id,user_id) VALUES ('$product_id','$qty','$total_price','$cat_id','$user_id')";
        //$stmt->bind_param("iiii", $product_id,$qty,$total_price,$user_id);

        $d = mysqli_query($this->con, $stmt);

        if ($d) {
            return true;
        }
    }


    /*-----------------------------------------------GET CART DATA---------------------------------------------------*/


    function getCartData($user_id)
    {
        //$stmt = "SELECT * FROM cart,users,product where cart.product_id = product.product_id and cart.user_id = users.user_id and ( cart.product_id and product.product_id='$product_id') and (cart.user_id and users.user_id='$user_id')";


        $q = "SELECT SUM( total_price ) as grand_total FROM  `cart` WHERE user_id ='$user_id' and is_purchased = 0";
        $d = mysqli_query($this->con, $q);
        $rs2 = mysqli_fetch_assoc($d);


        $stmt = "SELECT * FROM cart,reg_form,product where cart.product_id = product.product_id and cart.user_id = reg_form.user_id and cart.is_purchased = 0 and (cart.user_id and reg_form.user_id='$user_id')";
        $data = mysqli_query($this->con, $stmt);
        $num = mysqli_num_rows($data);


        if ($num < 1) {

            // return "Data Not Found!!";


            $hero = array();
            $heroes = array();

            $hero['error'] = true;
            $hero['message'] = "Data Not Found !! ";

            for ($i = 0; $i < 1; $i++) {
                array_push($heroes, $hero);
            }

            return $heroes;
        }

        $LoginRecords = array();

        while ($rs = mysqli_fetch_assoc($data)) {
            $hero = array();
            $hero['user_id'] = $rs['user_id'];
            $hero['product_id'] = $rs['product_id'];
            $hero['product_name'] = $rs['product_name'];
            $hero['product_price'] = $rs['product_price'];
            $hero['product_img'] = $rs['product_image'];
            $hero['cat_id'] = $rs['cat_id'];
            $hero['total_price'] = $rs['total_price'];
            $hero['qty'] = $rs['qty'];
            $hero['grand_total'] = $rs2['grand_total'];
            $hero['first_name'] = $rs['first_name'];
            $hero['error'] = false;
            $hero['message'] = " ... ";


            array_push($LoginRecords, $hero);
        }

        return $LoginRecords;
    }


    /*-----------------------------------------------GET Category---------------------------------------------------*/


    function getCategory()
    {


        $q = "SELECT * FROM `product_category`";
        $data = mysqli_query($this->con, $q);


        $heroes = array();

        while ($rs = mysqli_fetch_assoc($data)) {
            $hero = array();
            $hero['cat_id'] = $rs['cat_id'];
            $hero['cat_name'] = $rs['cat_name'];
            $hero['cat_image'] = $rs['cat_image'];

            array_push($heroes, $hero);
        }

        return $heroes;
    }


    /*----------------------------------------------- UPDATE CART---------------------------------------------------*/


    function updateCart($qty, $total_price, $user_id, $product_id)
    {
        $sql = "update cart set qty='$qty',total_price='$total_price' where user_id='$user_id' and product_id='$product_id' and is_purchased = 0";
        $data = mysqli_query($this->con, $sql);

        if ($data) {

            return true;
        }

        return false;
    }


    /*----------------------------------------------- Cart Count---------------------------------------------------*/


    function getCartCount($id)
    {
        $sql = "SELECT count(*) as cnt FROM `cart` WHERE user_id='$id' and is_purchased = 0";
        $data = mysqli_query($this->con, $sql);
        $rs = mysqli_fetch_assoc($data);
        $result = $rs['cnt'];


        return $result;
    }


    /*--------------------------------------------Image PAN Upload-----------------------------------------------------------*/

    function Upload_Pan($userid, $image)
    {


        $insertion_path = "../pan/" . $userid . "_panImage" . ".png";
        $path = "pan/" . $userid . "_panImage" . ".png";
        $actualpath = "http://192.168.1.9:9999/royal/" . $path;

        $sql = "insert into pan_card(pan_image,user_id) values('$actualpath','$userid')";

        if (mysqli_query($this->con, $sql)) {
            file_put_contents($insertion_path, base64_decode($image));

            return true;
        } else {

            return false;
        }
    }


    /*--------------------------------------------Image BANK Upload-------------------------------------------------------*/

    function Upload_Bank($userid, $image)
    {


        $insertion_path = "../bank/" . $userid . "_bankImage" . ".png";
        $path = "bank/" . $userid . "_bankImage" . ".png";
        $actualpath = "http://192.168.1.9:9999/royal/" . $path;

        $sql = "insert into bank_details(bank_image,user_id) values('$actualpath','$userid')";

        if (mysqli_query($this->con, $sql)) {
            file_put_contents($insertion_path, base64_decode($image));

            return true;
        } else {

            return false;
        }
    }


    /*--------------------------------------------Insert PAN DATA----------------------------------------------------*/

    function Pan_Insert($userid, $panname, $panno, $dob, $image)
    {


        // update reg_form set pan_name = 'Aman' , pan_no = '&*&jh' , dob = "1/11/1111" where userid = '10'

        $insertion_path = "../pan/" . $userid . "_panImage" . ".png";
        $path = "pan/" . $userid . "_panImage" . ".png";
        $actualpath = "http://192.168.1.9:9999/royal/" . $path;


        $sql = "insert into pan_card(pan_image,pan_name,pan_no,dob,user_id) VALUES('$actualpath','$panname','$panno','$dob','$userid')";
        $data = mysqli_query($this->con, $sql);

        if ($data) {

            file_put_contents($insertion_path, base64_decode($image));

            return true;
        } else {

            return false;
        }
    }


    /*--------------------------------------------Insert BANK DATA--------------------------------------------------*/

    function Bank_Insert($userid, $bankname, $account, $ifsc, $state, $image)
    {


        // update reg_form set pan_name = 'Aman' , pan_no = '&*&jh' , dob = "1/11/1111" where userid = '10'
        /*$sql = "update reg_form set bank_name = '$bankname' , bank_account_no = '$account' , bank_ifsc = '$ifsc',pan_state='$state' where 	  userid = '$userid'";*/


        $insertion_path = "../bank/" . $userid . "_bankImage" . ".png";
        $path = "bank/" . $userid . "_bankImage" . ".png";
        $actualpath = "http://192.168.1.9:9999/royal/" . $path;


        $sql = "insert into bank_details(bank_image,bank_name,bank_account_no,bank_ifsc,state,user_id) VALUES('$actualpath','$bankname','$account','$ifsc','$state','$userid')";


        $data = mysqli_query($this->con, $sql);

        if ($data) {

            file_put_contents($insertion_path, base64_decode($image));


            return true;
        } else {

            return false;
        }
    }


    function getData($uid)
    {

        $stmt = "select * from reg_form where user_id = '$uid'";
        $data = mysqli_query($this->con, $stmt);

        $heroes = array();
        while ($rs = mysqli_fetch_assoc($data)) {

            $hero = array();
            $hero['first_name'] = $rs['first_name'];
            $hero['last_name'] = $rs['last_name'];
            $hero['image'] = $rs['image'];
            $hero['address'] = $rs['address'];
            $hero['city'] = $rs['city'];
            $hero['mobile_no'] = $rs['mobile_no'];
            $hero['email'] = $rs['email'];
            $hero['password'] = $rs['password'];

            array_push($heroes, $hero);
        }

        return $heroes;
    }


    /*----------------------------------------PLACE ORDER----------------------------------------------------------*/

    function Place_Order($id, $name, $email, $amount, $mobile, $address, $order_type)
    {

        $stmt = "select * from cart where user_id = '$id' and is_purchased=0";
        $data = mysqli_query($this->con, $stmt);
        $num = mysqli_num_rows($data);

        if ($num > 0) {
            while ($rs = mysqli_fetch_assoc($data)) {

                $fname = $name;
                $pid = $rs['product_id'];
                $qty = $rs['qty'];
                $pprice = $rs['total_price'];
                $type = $order_type;


                if ($type == "Online") {
                    $this->deductWallet($id, $pprice);
                }


                $q = "INSERT INTO `final_order`(`product_id`, `qty`, `product_price`, `user_id`, `order_type`, `user_name`, `user_email`, `user_mobile`, `user_address`, `date`, `time`) VALUES ('$pid','$qty','$pprice','$id','$type','$fname','$email','$mobile','$address',NOW(),NOW())";
                mysqli_query($this->con, $q);
            }

            $this->con->query("UPDATE CART SET is_purchased = '1' where user_id = '$id'");

            return true;
        } else {
            return false;
        }
    }


    /* -------------------------------------------My Order Details--------------------------------------------- */


    function MyOrderDetails($userid)
    {

        $sql = "SELECT pro.product_name,pro.product_image,fo.product_price,fo.date FROM `final_order` fo,product pro where fo.user_id = '$userid' and pro.product_id = fo.product_id order by fo.date desc";
        $execute = $this->con->query($sql);
        $num = mysqli_num_rows($execute);

        if ($num > 0) {

            $outer = array();
            while ($obj = $execute->fetch_object()) {
                $innner = array();
                $innner['product_name'] = $obj->product_name;
                $innner['product_price'] = $obj->product_price;
                $innner['product_img'] = $obj->product_image;
                $innner['date'] = date("d-m-Y", strtotime($obj->date));

                array_push($outer, $innner);

            }

            return $outer;
        }
    }


    /*----------------------------------------GET PRODUCT----------------------------------------------------------*/


    function getProduct($id)
    {
        $stmt = $this->con->prepare("SELECT * FROM product where cat_id='$id'");
        $stmt->execute();
        $stmt->bind_result($id, $name, $price, $img, $cat_id);

        $heroes = array();

        while ($stmt->fetch()) {
            $hero = array();
            $hero['product_id'] = $id;
            $hero['product_name'] = $name;
            $hero['product_price'] = $price;
            $hero['product_img'] = $img;
            $hero['cat_id'] = $cat_id;


            array_push($heroes, $hero);
        }

        return $heroes;
    }

    function updateData($fname, $lname, $address, $city, $email)
    {

        $stmt = $this->con->prepare("UPDATE reg_form SET first_name = ?,last_name=?, address = ?, city = ? WHERE email = ?");
        $stmt->bind_param("sssss", $fname, $lname, $address, $city, $email);
        if ($stmt->execute()) {

            return true;
        } else {
            return false;
        }
    }


    /*
    * The delete operation
    * When this method is called record is deleted for the given id
    */


    function deleteData($product_id, $user_id)
    {
        $stmt = $this->con->prepare("DELETE FROM cart WHERE user_id = ? and product_id=? ");
        $stmt->bind_param("ii", $user_id, $product_id);
        if ($stmt->execute())
            return true;

        return false;
    }
}
