<?php
namespace App\Http\Services;

use App\Http\Requests\Request;
use App\Http\Validations\ValidateUserReqest;

class User {
    /**  
     * @param string $username
     */
    protected $username;
    /**
     * @param string $password
     */
    protected $password;
    /**
     * @param string $email
     */
    protected $email;

    /**
     * Create a new user or redirect on error back to the form
     * @param ValidateUserReqest $validation
     */
    
    public function createUser(ValidateUserReqest $validation)
    {
        $data = [];
        $isValid = $validation->setData($_REQUEST)->validate($validation->rules());
        $request =  new Request;

        $userData = new self;

        $this->username = $request->request('username');
        $this->password = $request->request('password');
        $this->email = $request->request('email');

       if(!$isValid){
         $data['error'] = true;
         $data['error_messages'] = $validation->messages();
         $data['user_data'] =            $data['user_data'] = [
            'username' => $this->username,
            'password' => $this->password,
            'email' => $this->email,
        ];

       }else{

        $data['error'] = false;
        $data['error_messages'] =null;
        $data['user_data'] = [
            'username' => $this->username,
            'password' => $this->password,
            'email' => $this->email,
        ];

       }
       return $data;
    }
}