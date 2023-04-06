
<?php

        session_start();
        include('connection.php');
        
        
 if(!isset($_SESSION['admin'])){
     
        header('location:login.php');

}

if(isset($_GET['id'])){
        
        $id=$_GET['id'];
        
        
        
        
           //echo "<script>confirm('do you want to delete');</script>";
            
            $query="delete from prod_details where prod_id='$id'";
            
            $result=mysqli_query($conn,$query);
            
            if($result){
                
                echo "deleted;";
                header('location:products.php');
            }
            
        
}




if(isset($_GET['bid'])){
        
        $bid=$_GET['bid'];
        
        
        
        
           //echo "<script>confirm('do you want to delete');</script>";
            
            $query="delete from brand_details where brand_id='$bid'";
            
            $result=mysqli_query($conn,$query);
            
            if($result){
                
				
				            $query2="delete from prod_details where brand_id='$bid'";
            
            $result2=mysqli_query($conn,$query2);
				
				
                echo "deleted;";
                header('location:brand.php');
            }
            
        
}






if(isset($_GET['sid'])){
        
        $sid=$_GET['sid'];
        
        
        
        
           //echo "<script>confirm('do you want to delete');</script>";
            
            $query="delete from reg_form where shop_id='$sid'";
            
            $result=mysqli_query($conn,$query);
            
            if($result){
                
				 
                echo "deleted;";
                header('location:shopdetails.php');
            }
            
        
}

        ?>

<body>
    
  
    
</body>