<?php
/*
 * ###############################################################################
 * File: License.php
 * Project: Models
 * File Created: Saturday, 14th August 2021 2:32:01 pm
 * Author: Thomas Brinkmann (doyl@dsh.icu)
 * -----
 * Last Modified: Tuesday, 24th August 2021 5:35:43 pm
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
namespace ConanDoyl\TekbaseWhmcs\Models;

use ConanDoyl\TekbaseWhmcs\Manager\DatabaseManager;
use ConanDoyl\TekbaseWhmcs\Services\LicenseService;

class License {

    public $id;
    public $serviceid;    
    public $customer;    
    public $key;    
    public $siteip;       
    public $siteurl;       
    public $sitepath;    
    public $version;     
    public $cms;    
    public $shop;    
    public $gwislots;    
    public $rwislots;    
    public $swislots;    
    public $vwislots;    


    /** Load the License with $id or creante a new object
     * @param null $id
     */
    public function __construct($licenseId = null) {
        // Set default values 
        $this->customer     = (new LicenseService)->generateRandomString();
        $this->key          = "";
        $this->siteip       = "";
        $this->siteurl      = "";
        $this->sitepath     = "";
        $this->version      = "private";
        $this->cms          = 0;
        $this->shop         = 0;
        $this->gwislots     = 0;
        $this->rwislots     = 0;
        $this->swislots     = 0;
        $this->vwislots     = 0;
        
        if ($licenseId != null){
            $__lic = (new DatabaseManager)->GetLicense($licenseId);
            $this->id           = $__lic->licenseid;
            $this->serviceid    = $__lic->serviceid;
            $this->customer     = $__lic->customerid;
            $this->key          = $__lic->licensekey;
            $this->siteip       = $__lic->siteip;
            $this->siteurl      = $__lic->siteurl;
            $this->sitepath     = $__lic->sitepath;
            $this->version      = $__lic->version;
            $this->cms          = $__lic->cms;
            $this->shop         = $__lic->shop;
            $this->gwislots     = $__lic->gwislots;
            $this->rwislots     = $__lic->rwislots;
            $this->swislots     = $__lic->swislots;
            $this->vwislots     = $__lic->vwislots;
        }
            
        
    }


    
    /** Updates the model inside the database or creates a new one if it doesn't exists
     * @return boolean
     */
    public function save(){
        return (new DatabaseManager)->UpdateLicense($this);
    }




}
