<?php

//getting the dboperation class
require_once '../includes/DbOperation.php';

//function validating all the paramters are available
//we will pass the required parameters to this function
function isTheseParametersAvailable($params)
{
    //assuming all parameters are available
    $available = true;
    $missingparams = "";

    foreach ($params as $param) {
        if (!isset($_POST[$param]) || strlen($_POST[$param]) <= 0) {
            $available = false;
            $missingparams = $missingparams . ", " . $param;
        }
    }

    //if parameters are missing
    if (!$available) {
        $response = array();
        $response['error'] = true;
        $response['message'] = 'Parameters ' . substr($missingparams, 1, strlen($missingparams)) . ' missing';

        //displaying error
        echo json_encode($response);

        //stopping further execution
        die();
    }
}


//an array to display response
$response = array();

//if it is an api call
//that means a get parameter named api call is set in the URL
//and with this parameter we are concluding that it is an api call
if (isset($_GET['apicall'])) {

    switch ($_GET['apicall']) {

        //the CREATE operation
        //if the api call value is 'createhero'
        //we will create a record in the database
        case 'register':
            //first check the parameters required for this request are available or not
            isTheseParametersAvailable(array('firstname', 'lastname', 'address', 'city', 'email', 'mobile', 'password'));

            //creating a new dboperation object
            $db = new DbOperation();

            //creating a new record in the database
            $result = $db->insert(
                $_POST['firstname'],
                $_POST['lastname'],
                $_POST['address'],
                $_POST['city'],
                $_POST['email'],
                $_POST['password'],
                $_POST['mobile']);


            if ($result) {

                $response['error'] = false;

                $response['message'] = 'Registered successfully';

            } else {

                $response['error'] = true;

                $response['message'] = 'Already Registered !!';
            }

            break;


        case 'login':

            isTheseParametersAvailable(array('email', 'password'));
            $db = new DbOperation();
            $result = $db->Login($_POST['email'], $_POST['password']);


            if ($result) {

                $response['error'] = false;
                $response['message'] = 'Login successfully';
                //$response['records'] = $db->getData($_POST['email'],$_POST['password']);


            } else {

                $response['error'] = true;
                $response['message'] = 'Email or Password is Invalid';

            }
            break;


        /*------------------------------------------------------Add Money-------------------------------------*/

        case 'add_money':

            isTheseParametersAvailable(array('user_id', 'amount'));
            $db = new DbOperation();
            $result = $db->AddMoney($_POST['user_id'], $_POST['amount']);


            if ($result) {

                $response['error'] = false;
                $response['message'] = 'Amount Added Successfully';


            } else {

                $response['error'] = true;
                $response['message'] = 'Something went wrong, Please try again';

            }
            break;


        /*------------------------------------------------------Get Money-------------------------------------*/

        case 'get_money':

            isTheseParametersAvailable(array('user_id'));
            $db = new DbOperation();

            $response['error'] = false;
            $response['message'] = 'Request successfully';
            $response['records'] = $db->GetMoney($_POST['user_id']);

            break;


        case 'update_details':
            isTheseParametersAvailable(array('fname', 'lname', 'address', 'city', 'email'));
            $db = new DbOperation();
            $result = $db->updateData($_POST['fname'], $_POST['lname'], $_POST['address'], $_POST['city'], $_POST['email']);

            if ($result) {
                $response['error'] = false;
                $response['message'] = 'Data updated successfully';
                //$response['heroes'] = $db->getData();
            } else {
                $response['error'] = true;
                $response['message'] = 'Some error occurred please try again';
            }
            break;


        case 'get_details':
            isTheseParametersAvailable(array('userId'));
            $db = new DbOperation();

            $response['error'] = false;
            $response['message'] = 'Request successfully';
            $response['records'] = $db->getData($_POST['userId']);

            break;


        case 'getproduct':
            $db = new DbOperation();
            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response['records'] = $db->getProduct($_GET['cat_id']);
            break;


        /*----------------------------------------------- INSERT CART---------------------------------------------------*/


        case 'cart':

            isTheseParametersAvailable(array('product_id', 'product_price', 'cat_id', 'user_id'));
            $db = new DbOperation();
            $result = $db->insertCart($_POST['product_id'], 1, $_POST['product_price'], $_POST['cat_id'], $_POST['user_id']);


            if ($result) {

                $response['error'] = false;
                $response['message'] = 'Cart successfully';
                // $response['records'] = $db->getCartData($_POST['user_id']);


            } else {

                $response['error'] = true;
                $response['message'] = 'Item Already Added To cart';

            }
            break;

        /*----------------------------------------------- CART DATA---------------------------------------------------*/


        case 'cartdata':

            $db = new DbOperation();


            $response['error'] = false;
            $response['message'] = 'Cart data successfully';
            $response['records'] = $db->getCartData($_GET['user_id']);


            break;

        /*----------------------------------------------- Category---------------------------------------------------*/


        case 'category':

            $db = new DbOperation();


            $response['error'] = false;
            $response['message'] = 'Cart data successfully';
            $response['records'] = $db->getCategory();


            break;

        /*----------------------------------------------- UPDATE CART---------------------------------------------------*/


        case 'updatecart':

            //isTheseParametersAvailable(array('qty','total_price','user_id','product_id'));


            if (isset($_GET['user_id'])) {


                $db = new DbOperation();
                $result = $db->updateCart($_GET['qty'], $_GET['total_price'], $_GET['user_id'], $_GET['product_id']);


                if ($result) {

                    $response['error'] = false;
                    $response['message'] = 'Cart successfully';
                    $response['records'] = $db->getCartData($_GET['user_id']);


                } else {

                    $response['error'] = true;
                    $response['message'] = 'Item Already Added To cart';

                }
                break;

            }


        /*----------------------------------------------- DELETE CART---------------------------------------------------*/


        case 'deletedata':

            if (isset($_GET['product_id'])) {

                $db = new DbOperation();

                if ($db->deleteData($_GET['product_id'], $_GET['user_id'])) {
                    $response['error'] = false;
                    $response['message'] = 'Product removed successfully';
                    $response['records'] = $db->getCartData($_GET['user_id']);

                } else {
                    $response['error'] = true;
                    $response['message'] = 'Some error occurred please try again';
                }
            } else {
                $response['error'] = true;
                $response['message'] = 'Data Not Found!!';
            }
            break;


        /*----------------------------------------------- Cart Count---------------------------------------------------*/


        case 'count':

            $db = new DbOperation();
            $response['error'] = false;
            $response['records'] = $db->getCartCount($_POST['user_id']);;

            break;


        /*----------------------------------------------- Place Order---------------------------------------------------*/


        case 'place_order':

            isTheseParametersAvailable(array('user_id', 'name', 'email', 'amount', 'mobile', 'address', 'order_type'));
            $db = new DbOperation();

            $result = $db->Place_Order($_POST['user_id'], $_POST['name'], $_POST['email'], $_POST['amount'], $_POST['mobile'], $_POST['address'], $_POST['order_type']);

            if ($result) {

                $response['error'] = false;
                $response['message'] = 'Order Placed successfully';

            } else {

                $response['error'] = true;
                $response['message'] = 'Something went wrong, Try again!';
            }


            break;


        /* ------------------------------------------------------ My Order Details------------------------ */

        case 'my_order_details':

            isTheseParametersAvailable(array('user_id'));
            $db = new DbOperation();

            $result = $db->MyOrderDetails($_POST['user_id']);

            if ($result) {

                $response['error'] = false;
                $response['records'] = $result;

            } else {

                $response['error'] = true;
                $response['message'] = 'Something went wrong, Try again!';
            }


            break;


        /*----------------------------------------------- Get Details By email---------------------------------------------------*/


        case 'get_details_by_email':
            isTheseParametersAvailable(array('email'));
            $db = new DbOperation();

            $response['error'] = false;
            $response['message'] = 'Request successfully';
            $response['records'] = $db->getData2($_POST['email']);

            break;


        case 'forgotpassword':
            isTheseParametersAvailable(array('email'));

            $db = new DbOperation();

            $response['error'] = false;
            $response['message'] = 'Code sent successfully';
            $response['records'] = $db->Send_Mail($_POST['email']);

            break;


        case 'update_forget_password_code':
            isTheseParametersAvailable(array('code'));

            $db = new DbOperation();


            $result = $db->Update_code($_POST['code']);


            if ($result) {
                $response['error'] = false;
                $response['message'] = 'Code Verified successfully';

            } else {

                $response['error'] = true;
                $response['message'] = 'Wrong Code, Please Try Again';
            }

            break;


        case 'update_new_password':
            isTheseParametersAvailable(array('new_password', 'email'));

            $db = new DbOperation();


            $result = $db->update_new_password($_POST['new_password'], $_POST['email']);


            if ($result) {
                $response['error'] = false;
                $response['message'] = 'New Password updated successfully';

            } else {

                $response['error'] = true;
                $response['message'] = 'Something Went Wrong, Please Try Again';
            }

            break;


        case 'google_login':

            isTheseParametersAvailable(array('email'));
            $db = new DbOperation();
            $result = $db->google_Login($_POST['email'], $_POST['username'], $_POST['personid'], $_POST['google_profile']);


            if ($result) {

                $response['error'] = false;
                $response['message'] = 'Login successfully';
                //$response['records'] = $db->getData($_POST['email'],$_POST['password']);


            } else {

                $response['error'] = true;
                $response['message'] = 'Google Invalid';

            }
            break;


        case 'facebook_login':

            isTheseParametersAvailable(array('email'));
            $db = new DbOperation();
            $result = $db->Facebook_Login($_POST['email'], $_POST['username'], $_POST['personid'], $_POST['google_profile']);


            if ($result) {

                $response['error'] = false;
                $response['message'] = 'Login successfully';
                //$response['records'] = $db->getData($_POST['email'],$_POST['password']);


            } else {

                $response['error'] = true;
                $response['message'] = 'Google Invalid';

            }
            break;


        case 'change_pwd':

            isTheseParametersAvailable(array('old', 'newpwd', 'email'));
            $db = new DbOperation();
            $result = $db->ChangePwd($_POST['old'], $_POST['newpwd'], $_POST['email']);


            if ($result) {

                $response['error'] = false;
                $response['message'] = 'Password Updated successfully';

            } else {

                $response['error'] = true;
                $response['message'] = 'Old Password is wrong';
            }
            break;


        case 'league_history':
            //first check the parameters required for this request are available or not
            isTheseParametersAvailable(array('userid'));

            $db = new DbOperation();

            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response['records'] = $db->getHistory($_POST['userid']);


            break;


        case 'getallleague':
            //first check the parameters required for this request are available or not

            $db = new DbOperation();

            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response['records'] = $db->getAllLeague();


            break;


        case 'nifty50':
            //first check the parameters required for this request are available or not


            isTheseParametersAvailable(array('type'));

            $db = new DbOperation();

            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response['records'] = $db->getNifty50($_POST['type']);


            break;


        case 'allcount':
            //first check the parameters required for this request are available or not


            isTheseParametersAvailable(array('mtid'));

            $db = new DbOperation();

            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response['records'] = $db->getAllCount($_POST['mtid']);


            break;


        case 'allcount2':
            //first check the parameters required for this request are available or not


            isTheseParametersAvailable(array('mtid'));

            $db = new DbOperation();

            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response['records'] = $db->getAllCount2($_POST['mtid']);


            break;


        case 'get_edit_count':
            //first check the parameters required for this request are available or not


            isTheseParametersAvailable(array('mtid'));

            $db = new DbOperation();

            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response['count'] = $db->getEditCount($_POST['mtid']);


            break;


        case 'add_team':

            isTheseParametersAvailable(array('league_id', 'league_name', 'entry_fees', 'userid', 'winning_amount', 'league_date', 'rank'));

            $db = new DbOperation();

            $response['error'] = false;
            $response['message'] = 'Team added successfully';
            $response['mt_id'] = $db->setTeam($_POST['league_id'], $_POST['league_name'], $_POST['entry_fees'], $_POST['userid'], $_POST['winning_amount'], $_POST['league_date'], $_POST['rank']);

            break;


        case 'stock_add':

            isTheseParametersAvailable(array('mtid', 'smid', 'token', 'stockname', 'playertype', 'sharetype'));
            $db = new DbOperation();


            $response['error'] = false;
            $response['message'] = 'Stock added successfully';
            $response['plid'] = $db->StockAdd($_POST['mtid'], $_POST['smid'], $_POST['token'], $_POST['stockname'], $_POST['playertype'], $_POST['sharetype']);
            $response['count'] = $db->StockCount($_POST['mtid']);


            break;


        case 'edit_league':

            isTheseParametersAvailable(array('mtid'));

            $db = new DbOperation();

            $response['error'] = false;
            $response['message'] = 'Edit League Request successfully';
            $response['records'] = $db->getEditLeague($_POST['mtid']);
            //$response['records1'] = $db->getNifty50("1");


            break;


        case 'compare_for_delete':

            isTheseParametersAvailable(array('mtid'));
            $db = new DbOperation();


            $response['error'] = false;
            $response['message'] = 'Compared successfully';
            $response['plid'] = $db->Compare_for_Delete($_POST['mtid']);


            break;


        case 'delete_team_details':

            isTheseParametersAvailable(array('mtid', 'smid'));
            $db = new DbOperation();


            $response['error'] = false;
            $response['message'] = 'deleted successfully';
            $response['count'] = $db->Delete_Team($_POST['mtid'], $_POST['smid']);


            break;


        case 'delete_team_mtid':

            //for the delete operation we are getting a GET parameter from the url having the id of the record to be deleted
            if (isset($_POST['mtid'])) {
                $db = new DbOperation();
                if ($db->deleteWholeTeam($_POST['mtid'])) {
                    $response['error'] = false;
                    $response['message'] = 'Team deleted successfully';

                } else {
                    $response['error'] = true;
                    $response['message'] = 'Some error occurred please try again';
                }
            } else {
                $response['error'] = true;
                $response['message'] = 'Nothing to delete, provide an id please';
            }
            break;


        case 'update_myteams_details_id':
            isTheseParametersAvailable(array('smid', 'plid', 'playertype', 'mtid', 'stock_token', 'stock_name'));
            $db = new DbOperation();
            $result = $db->updateKingbyPlid($_POST['smid'], $_POST['plid'], $_POST['mtid'], $_POST['stock_token'], $_POST['stock_name'], $_POST['playertype']);
            /*$result = $db->updateKing($_POST['smid'],$_POST['plid'],$_POST['mtid'],$_POST['stock_token'],$_POST['stock_name'],$_POST['playertype']);*/

            if ($result) {
                $response['error'] = false;
                $response['message'] = 'Data updated successfully';
            } else {
                $response['error'] = true;
                $response['message'] = 'Some error occurred please try again';
            }
            break;


        case 'update_by_playerid':
            isTheseParametersAvailable(array('smid', 'plid', 'playertype', 'mtid', 'stock_token', 'stock_name'));
            $db = new DbOperation();
            $result = $db->updateKingbyPlid($_POST['smid'], $_POST['plid'], $_POST['mtid'], $_POST['stock_token'], $_POST['stock_name'], $_POST['playertype']);

            if ($result) {
                $response['error'] = false;
                $response['message'] = 'Data updated successfully';
            } else {
                $response['error'] = true;
                $response['message'] = 'Some error occurred please try again';
            }
            break;


        case 'rank_from_to':
            //first check the parameters required for this request are available or not

            isTheseParametersAvailable(array('rankfrom', 'rankto'));


            $db = new DbOperation();

            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response['records'] = $db->getRankFromTo($_POST['rankfrom'], $_POST['rankto']);


            break;


        case 'amount_from_to':
            //first check the parameters required for this request are available or not

            isTheseParametersAvailable(array('amountfrom', 'amountto'));


            $db = new DbOperation();

            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response['records'] = $db->getAmountFromTo($_POST['amountfrom'], $_POST['amountto']);


            break;

        case 'count':
            //first check the parameters required for this request are available or not

            $db = new DbOperation();

            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response['records'] = $db->getCount();


            break;


        case 'myaccount':
            //first check the parameters required for this request are available or not
            isTheseParametersAvailable(array('userid'));

            $db = new DbOperation();

            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response['records'] = $db->getBalance($_POST['userid']);


            break;


        case 'image':
            //first check the parameters required for this request are available or not
            isTheseParametersAvailable(array('userid', 'image'));

            $db = new DbOperation();
            $result = $db->Upload($_POST['userid'], $_POST['image']);


            if ($result) {

                $response['error'] = false;
                $response['message'] = 'Image Uploaded successfully';

            } else {

                $response['error'] = true;
                $response['message'] = 'Something went wrong';
            }

            break;


        case 'upload_pan_image':
            //first check the parameters required for this request are available or not
            isTheseParametersAvailable(array('userid', 'image'));

            $db = new DbOperation();
            $result = $db->Upload_Pan($_POST['userid'], $_POST['image']);


            if ($result) {

                $response['error'] = false;
                $response['message'] = 'Image Uploaded successfully';

            } else {

                $response['error'] = true;
                $response['message'] = 'Something went wrong';
            }

            break;


        case 'upload_bank_image':
            //first check the parameters required for this request are available or not
            isTheseParametersAvailable(array('userid', 'image'));

            $db = new DbOperation();
            $result = $db->Upload_Bank($_POST['userid'], $_POST['image']);


            if ($result) {

                $response['error'] = false;
                $response['message'] = 'Image Uploaded successfully';

            } else {

                $response['error'] = true;
                $response['message'] = 'Something went wrong';
            }

            break;


        case 'verify_pan':

            isTheseParametersAvailable(array('userid', 'pan_name', 'pan_no', 'dob', 'image'));
            $db = new DbOperation();

            $result = $db->Pan_Insert($_POST['userid'], $_POST['pan_name'], $_POST['pan_no'], $_POST['dob'], $_POST['image']);

            if ($result) {

                $response['error'] = false;
                $response['message'] = 'Pan Details Uploaded successfully';

            } else {

                $response['error'] = true;
                $response['message'] = 'Something went wrong, Try again!';
            }


            break;


        case 'verify_bank':

            isTheseParametersAvailable(array('userid', 'bank_name', 'account', 'ifsc', 'bankstate', 'image'));
            $db = new DbOperation();

            $result = $db->Bank_Insert($_POST['userid'], $_POST['bank_name'], $_POST['account'], $_POST['ifsc'], $_POST['bankstate'], $_POST['image']);

            if ($result) {

                $response['error'] = false;
                $response['message'] = 'Bank Details Uploaded successfully';

            } else {

                $response['error'] = true;
                $response['message'] = 'Something went wrong, Try again!';
            }


            break;






        //the READ operation
        //if the call is getheroes
        case 'getdata':
            isTheseParametersAvailable(array('email'));

            $db = new DbOperation();
            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response['records'] = $db->getData($_POST['email']);
            break;


        case 'getdata2':
            isTheseParametersAvailable(array('userid'));

            $db = new DbOperation();
            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response['records'] = $db->getData2($_POST['userid']);
            break;


        case 'getdata3':
            isTheseParametersAvailable(array('person_id'));

            $db = new DbOperation();
            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response['records'] = $db->getData3($_POST['person_id']);
            break;


        //the delete operation
        case 'deletedata':

            //for the delete operation we are getting a GET parameter from the url having the id of the record to be deleted
            if (isset($_GET['id'])) {
                $db = new DbOperation();
                if ($db->deleteData($_GET['id'])) {
                    $response['error'] = false;
                    $response['message'] = 'Hero deleted successfully';
                    $response['heroes'] = $db->getData();
                } else {
                    $response['error'] = true;
                    $response['message'] = 'Some error occurred please try again';
                }
            } else {
                $response['error'] = true;
                $response['message'] = 'Nothing to delete, provide an id please';
            }
            break;


    }

} else {
    //if it is not api call
    //pushing appropriate values to response array
    $response['error'] = true;
    $response['message'] = 'Invalid API Call';
}

//displaying the response in json structure
echo json_encode($response);