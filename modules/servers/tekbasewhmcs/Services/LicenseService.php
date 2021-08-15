<?php
/*
 * ###############################################################################
 * File: LicenseService.php
 * Project: Services
 * File Created: Saturday, 14th August 2021 1:12:21 pm
 * Author: Thomas Brinkmann (doyl@dsh.icu)
 * -----
 * Last Modified: Sunday, 15th August 2021 6:08:27 pm
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
namespace ConanDoyl\TekbaseWhmcs\Services;

use Exception;
use ConanDoyl\TekbaseWhmcs\Models\License;
use ConanDoyl\TekbaseWhmcs\Manager\ApiManager;

class LicenseService {

    /** Returns an object containing total and unlocked license numbers
     * @return object { "total": XX, "unlocked": XX }
     */
    public function countLicenses() { 
        return (new ApiManager)->ExecuteApi('GET', [], 'count/');
    }



    /** Returns a Array with the licenses 
     * @param bool $onlyActives Returns only licenses with the status ACTIVE
     * 
     * @return array 
     */
    public function getAllLicenses($onlyActives = false) { throw new Exception('Not implemented'); }



    /** Returns the License and all details 
     * @param int $licenseid The id of the license that should be retured
     * 
     * @return object
     */
    public function getLicense(int $licenseid) { throw new Exception('Not implemented'); }




    /** Returns the license key for this license
     * @param int $licenseid
     * @param int $version
     * 
     * @return object
     */
    public function getLicenseKey(int $licenseid, int $version = 8) { throw new Exception('Not implemented'); }




    /** Returns the License Key if it was successful and its id
     * @param array $fields
     * 
     * @return object
     */
    public function addLicense(string $customer, array $fields) {
        $fields = array_merge($fields, [ "customer" => $customer ] ); 
        return (new ApiManager)->ExecuteApi('POST', $fields);
    }




    /** Updates the License with the fields
     * @param array $fields
     * 
     * @return object
     */
    public function updateLicense(License $license) {
        $data = array_merge((array)$license, [ "status" => 1 ]);
        $answer = (new ApiManager)->ExecuteApi('PUT',  $data, $license->id);
        if ($answer->message == "SUCCESSFUL"){
            (new ProductService)->updateProductdetails($license);
        }

        return $answer;
     }

    
    /** Suspend the License and set its status to closed
     * @param int $licenseid
     * 
     * @return object
     */
    public function suspendLicense(License $license) {
        return (new ApiManager)->ExecuteApi('PUT', [
            "customer"  => $license->customer,
            "siteurl"   => $license->siteurl,
            "sitepath"  => $license->sitepath,
            "siteip"    => $license->siteip,
            "status"    => 0,
        ], $license->id);
     }




    /** Unsuspend the license and set its status back to active
     * @param int $licenseid
     * 
     * @return object
     */
    public function unsuspendLicense(License $license) { 
        return (new ApiManager)->ExecuteApi('PUT', [
            "customer"  => $license->customer,
            "siteurl"   => $license->siteurl,
            "sitepath"  => $license->sitepath,
            "siteip"    => $license->siteip,
            "status"    => 1,
        ], $license->id);
    }




    /** Deletes the license 
     * @param int $licenseid
     * 
     * @return object
     */
    public function deleteLicense(License $license) {
        return (new ApiManager)->ExecuteApi('DELETE', [], $license->id);
    }


    /** Generates a random string 
     * @param int $length Number of chars that should returned
     * 
     * @return string
     */
    public function generateRandomString($length = 12) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
}