<?php

class DBHANDLER{
 private $connection;
    function __construct() {
        require_once dirname(__FILE__) . '/DBCONNECT.php';
        // opening db connection
        $db = new DBCONNECT();
        $this->connection = $db->connect();
        mysqli_set_charset($this->connection,"utf8");
    }
    
    
  
    
    
    
      
    /// HOME PAGE MODULES......
    /*public function Fetch(){
        
    $HomeData=array();
    
    $HomeData["SLIDER"]=$this->fetchSliders();
    $HomeData["SERVICE_CATEGORIES"]=$this->GetServiceCategories();
    $HomeData["SERVICE_PRODUCTS"]=$this->fetchAllServices();
    
    return $HomeData;

        
        
    }
    private function fetchSliders(){
    
    $data=array();
        
                // fetch the source data using TN..
    $IMG_URL="http://homeservices.vugido.com/IMAGES/";
                $st=$this->connection->prepare("SELECT  IMAGE,ID  FROM  SLIDERS WHERE ACTIVE_STATE = 1");
                
                if($st->execute()){
                    $d=array();
                    
                    $st->bind_result($IMAGE,$ID);
                    
                    $st->store_result();
                    
                    if($st->num_rows>0){
                        
                        while($st->fetch()){
                            
                            
                            array_push($d,array('IMAGE'=>$IMG_URL.$IMAGE,'SID'=>$ID ));
                            
                        }
                       
                       $data=$d;
                      //  array_push($data,array($TN=>$d));

                    }
                    

                }

        return $data;
    }
    private function fetchAllServices(){
    
    $IMG_URL="http://homeservices.vugido.com/IMAGES/";
    $data=array();
    $stmt=$this->connection->prepare("SELECT ID,SID,NAME,IMAGE,DESCRIBER,TAGS  FROM SERVICE_PROFILE WHERE ACTIVE_STATE = 1 ");
    
    if($stmt->execute()){
        
        
        $stmt->bind_result($ID,$SID,$TITLE,$IMG,$DES,$TAGS);
        $stmt->store_result();
        
        if($stmt->num_rows>0){
            
            while($stmt->fetch()){
                
                
                   
                    
                    
                            
              array_push($data,array('IMAGE'=>$IMG_URL.$IMG,  'TITLE'=>$TITLE, 
              'ID'=>$ID,'DESCRIPTION'=>$DES ,'SID'=>$SID,'TAGS'=>$TAGS));
                        
                        
                       

                    
                
                
            }
            
            
        }
        
    }
    
    
    return $data;
    
    
}
    public function GetServiceCategories(){
    
    $data=array();
    //$IMG_URL="http://homeservices.vugido.com/IMAGES/";
    $stmt=$this->connection->prepare("SELECT ID ,SERVICE_NAME FROM SERVICE_TYPE WHERE ACTIVE_STATE = 1 ");
    if($stmt->execute()){
        
        $stmt->bind_result($ID,$TITLE);
        $stmt->store_result();
        
        if($stmt->num_rows > 0){
            
            
            while($stmt->fetch()){
                
                array_push($data,array('ID'=>$ID,'TITLE'=>$TITLE));
                
            }
        
            
            
        }
        
    }
    
    return $data;
    
    
    
    
}










   

    private function getCurrentDateTime(){

    date_default_timezone_set("Asia/kolkata");
	   $t=time();
	   $ON=date("d-m-y h:i:s A",$t);
           return $ON;
}

}
*/
public function register($fname,$email,$phone,$college,$ename){
    $stmt = $this->connection->prepare("insert into register(fname ,email,phone,college,ename) values(? , ? , ? , ? , ?);");
    $stmt->bind_param('sssss',$fname,$email,$phone,$college,$ename);
    if($stmt->execute()){
        return true;
    }
    return false;
}

public function get_login($uname,$password){
    $arr=array();
    $arr['status']=false;
    $stmt = $this->connection->prepare("select USER_TYPE,USER_ROLE,FCM_TOKEN from users_credentials_table where USER_NAME=? and PASSWORD=?");
    $stmt->bind_param('ss',$uname,$password);
    if($stmt->execute()){
        $stmt->bind_result($utype,$urole,$token);
        $stmt->store_result();
        if($stmt->num_rows > 0){
            $stmt->fetch();
            $arr['status']= true;
            $arr['user_role']=$utype;
            $arr['user_type']=$utype;
            $arr['fcm_token']=$token;
        }
    }
    return $arr;
}
public function insert_user($user_name ,$password ,$user_type ,$user_role ,$fcm_token ){
    $uid=null;
    $stmt = $this->connection->prepare("insert into users_credentials_table(USER_NAME , PASSWORD , USER_TYPE , USER_ROLE , FCM_TOKEN) values(? , ? , ? , ? , ?);");
    $stmt->bind_param('sssss',$user_name ,$password ,$user_type ,$user_role ,$fcm_token);
    if($stmt->execute()){
        $stmt = $this->connection->prepare("select uid from users_credentials_table where USER_NAME=?");
        $stmt->bind_param('s',$user_name);
        if($stmt->execute()){
            $stmt->bind_result($uid);
            $stmt->store_result();
            if($stmt->num_rows>0){
                $stmt->fetch();
                return $uid;
            }
        }
    }
}
 function getbase64img($imgurl){
    $img = file_get_contents($imgurl);
  
                // Encode the image string data into base64
                    $data = base64_encode($img);
                    return $data;
                // Display the output
                //echo $data;
}
 function getimgbase64($base64_string, $output_file){
        // open the output file for writing
    $ifp = fopen( $output_file, 'wb' ); 

    // split the string on commas
    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>
    //$data = explode( ',', $base64_string );

    // we could add validation here with ensuring count( $data ) > 1
    fwrite( $ifp, base64_decode( $base64_string ) );

    // clean up the file resource
    fclose( $ifp ); 

    return $output_file; 

}
public function insert_stud($uid ,$first_name ,$last_name ,$address ,$program ,$year ,$gender ,$phone ,$dob ,$image ,$branch ,$roll_number ,$bio){
    $response=array();
    $response['status']=false;
    $stmt = $this->connection->prepare("insert into students(UID , FIRST_NAME , LAST_NAME , ADDRESS , PROGRAM , YEAR , GENDER , PHONE , DOB , IMAGE , BRANCH , ROLL_NUMBER , BIO) values(? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ?);");
    $imgurl=$this->getimgbase64($image,$uid.".jpg");
    $stmt->bind_param('sssssssssssss',$uid ,$first_name ,$last_name ,$address ,$program ,$year ,$gender ,$phone ,$dob ,$imgurl ,$branch ,$roll_number ,$bio);
    if($stmt->execute()){
        $response['status']=true;
    }
    return $response;
}
public function insert_faculty($uid ,$first_name ,$last_name ,$phone ,$image ,$program ,$gender ,$dob ,$bio){
    $response=array();
    $response['status']=false;
    $stmt = $this->connection->prepare("insert into faculty(UID , FIRST_NAME , LAST_NAME , PHONE , IMAGE , PROGRAM , GENDER , DOB , BIO) values(? , ? , ? , ? , ? , ? , ? , ? , ?);");
    $imgurl=$this->getimgbase64($image,$uid.".jpg");
    $stmt->bind_param('sssssssss',$uid ,$first_name ,$last_name ,$phone ,$imgurl ,$program ,$gender ,$dob ,$bio);
    if($stmt->execute()){
        $response['status']=true;
    }
    return $response;
}
    private function getCurrentDateTime(){

    date_default_timezone_set("Asia/kolkata");
	   $t=time();
	   $ON=date("d-m-y h:i:s A",$t);
           return $ON;
}
public function insertfeed($uid,$msg,$issueid){
    $response=array();
    $response['status']=false;
    $date = $this->getCurrentDateTime();
    $stmt = $this->connection->prepare("insert into app_zone_feedback(user_id,created,feedback_message,issue_type_id) values(?,?,?,?);");
    $stmt->bind_param('issi',$uid,$date,$msg,$issueid);
    if($stmt->execute()){
        $response['status']=true;
    }
    return $response;
}
public function getfeedspinner(){
    $response=array();
    $response['status']=false;
    $data=array();
    $stmt = $this->connection->prepare("select id,issue_type from app_zone_issue;");
    if($stmt->execute()){
            $stmt->bind_result($id,$issuetype);
            $stmt->store_result();
            if($stmt->num_rows>0){
                $response['status']=true;
                while($stmt->fetch()){
                array_push($data,array('id'=>$id,'issueid'=>$issuetype));
            }
               $response['data']=$data; 
            }
        }
        return $response;
}
}
?>

