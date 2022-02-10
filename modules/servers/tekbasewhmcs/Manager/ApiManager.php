<?php
/*
 * ###############################################################################
 * File: ApiManager.php
 * Project: Manager
 * File Created: Saturday, 14th August 2021 12:00:08 pm
 * Author: Thomas Brinkmann (doyl@dsh.icu)
 * -----
 * Last Modified: Thursday, 10th February 2022 7:20:33 pm
 * Modified By: Thomas Brinkmann (doyl@dsh.icu>)
 * -----
 * Copyright 2021 - Thomas Brinkmann. All Rights Reserved.
 * -----
 * License Text 
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 * -----
 * ###############################################################################
 */
namespace ConanDoyl\TekbaseWhmcs\Manager;

use WHMCS\Database\Capsule;

class ApiManager {

    protected $Username;
    protected $Password;
    protected $Url;

    public function __construct(){
        $server = (new Capsule)->table('tblservers')->where('type', 'tekbasewhmcs')->where('active', '1')->select('username', 'password', 'secure')->first();
        $this->setUsername($server->username);
        $this->setPassword(decrypt($server->password));
        $this->setURL('http://api.tekbase.de/v1/reseller/'. $this->getUsername() . "/" ); 

        if ($server->secure == "on")
            $this->setURL('https://api.tekbase.de/v1/reseller/' . $this->getUsername() . "/");
        
    }



    /**
     * Set the value of Username
     *
     * @return  self
     */ 
    public function setUsername($Username)
    {
        $this->Username = $Username;

        return $this;
    }

    /**
     * Set the value of Password
     *
     * @return  self
     */ 
    public function setPassword($Password)
    {
        $this->Password = $Password;

        return $this;
    }

    /**
     * Set the value of Url
     *
     * @return  self
     */ 
    public function setUrl($Url)
    {
        $this->Url = $Url;

        return $this;
    }

    /**
     * Get the value of Url
     */ 
    public function getUrl()
    {
        return $this->Url;
    }

    
    /**
     * Get the value of Password
     */ 
    public function getPassword()
    {
        return $this->Password;
    }

    /**
     * Get the value of Username
     */ 
    public function getUsername()
    {
        return $this->Username;
    }



    /** Executes the API Reques
     * @param string $method POST | GET | PUT | DELETE | PATCH
     * @param array $data
     * @param string|null $LicenseId 
     * 
     * @return array|object Returns an array or an object with the results 
     */
    public function ExecuteApi(string $method, array $data, $LicenseId = null) { 
        $curl = curl_init($this->getUrl() .  ($LicenseId != null ? $LicenseId . '/' : "") );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);



        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'authenticate: apikey=' . $this->getPassword(),
            'Content-Type: application/json; charset=utf-8'
          ]);

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST,  $method  ); 
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($curl);
        $data = json_decode($response);


        curl_close($curl);
        return $data;
    }


}