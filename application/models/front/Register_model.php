 <?php 
class Register_model extends My_model
{
    function __construct() {
        parent::__construct();
    }
    
    public function adduser($postdata){
        $data['table'] = 'users';
        $data ["where"] = ['email'=>$postdata['email']];
        $countemail = $this->countRecords($data);
        if($countemail == 0){
            $data['table'] = 'users';
            $data ["where"] = ['username'=>$postdata['username']];
            $countusername = $this->countRecords($data);
            if($countusername == 0){
                 $data['table'] = 'users';
                 $data['insert'] = [
                     'username'=>$postdata['username'],
                     'password'=>sha1($postdata['password']),
                     'email'=>$postdata['email'],
                ];
            $result = $this->insertRecord($data);
                if($result){
                    return "done";
                }else{
                    return "wrong";
                }
            }else{
                return "userexits";
            }
        }else{
            return "emailexist";
        }
    }
}

