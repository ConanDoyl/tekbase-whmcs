<?php
/*
 * ###############################################################################
 * File: ProductService.php
 * Project: Services
 * File Created: Saturday, 14th August 2021 2:28:30 pm
 * Author: Thomas Brinkmann (doyl@dsh.icu)
 * -----
 * Last Modified: Sunday, 15th August 2021 6:08:21 pm
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

use ConanDoyl\TekbaseWhmcs\Manager\DatabaseManager;
use ConanDoyl\TekbaseWhmcs\Models\License;

class ProductService {


    /** Executes on "Service Create"
     * @param mixed $vars
     * 
     * @return bool
     */
    public function createService($vars){
        if (DatabaseManager::AlreadyExists($vars['serviceid']))
            return "There is already a licese available.";

        $package = false;
        $license = new License();
        $license->serviceid = $vars['serviceid'];

        // Generate and set the Username (CustomerID)
        $username = (new LicenseService)->generateRandomString();
        $vars['model']->serviceProperties->save(['Username' => $username]);
        $license->customer = $username;

        // Checking the Configoptions and check if the "Product" has options defined as a Package. 
        foreach ($vars['configoptions'] as $fieldname => $fieldvalue){
			if ($fieldname == 'Resources'){ $package = true; }
            if ($fieldname == 'Lizenz Typ') { $license->version = $fieldvalue; }
        }
    
        $license->cms   = $vars['configoptions']['cms'];
        $license->shop  = $vars['configoptions']['shop'];

        // Checking if the Customfield is exists
        if ( isset($vars['customfields']['siteurl'] ) ){
            $ip = gethostbyname(parse_url($vars['customfields']['siteurl'], PHP_URL_HOST));
            $license->siteurl   = $vars['customfields']['siteurl'];
            $license->siteip    = $ip;
        }

        if ( isset($vars['customfields']['sitepath'] ) ){
            $license->sitepath = $vars['customfields']['sitepath'];
        }

        if ($package){
            $license->gwislots  = $vars['configoptions']['Resources'];
            $license->rwislots  = $vars['configoptions']['Resources'];
            $license->swislots  = $vars['configoptions']['Resources'];
            $license->vwislots  = $vars['configoptions']['Resources'];
        } else {
            $license->gwislots  = $vars['configoptions']['gwislots'];
            $license->rwislots  = $vars['configoptions']['rwislots'];
            $license->swislots  = $vars['configoptions']['swislots'];
            $license->vwislots  = $vars['configoptions']['vwislots'];
        }


        $answer = (new LicenseService)->addLicense($username, (array)$license);

        //Check if Key isn't null 
		if ($answer->key != null){
			$license->key = $answer->key;
			$license->id = $answer->id;
		} else { $license->key = "<b><font color='#FF000'>Not retrieved yet.</font></b><br/>To retrieve the License Key make sure you've set url and path at the settings!"; logActivity(json_encode($answer)); }

        return $license->save();

    }


    /** Executes on package upgrade 
     * @param mixed $vars
     * 
     * @return bool
     */
    public function upgradeService($vars){
        $package = false;
        $license = new License($vars['serviceid']); // get the current License.

        // Checking the Configoptions and check if the "Product" has options defined as a Package. 
        foreach ($vars['configoptions'] as $fieldname => $fieldvalue){
			if ($fieldname == 'Resources'){ $package = true; }
            if ($fieldname == 'Lizenz Typ') { $license->version = $fieldvalue; }
        }
    
        
        if ($license->cms != $vars['configoptions']['cms'])
            $license->cms   = $vars['configoptions']['cms'];

        if ( $license->shop != $vars['configoptions']['shop'] )     
            $license->shop  = $vars['configoptions']['shop'];

        if ($license->siteurl != $vars['customfields']['siteurl'] || $license->sitepath != $vars['customfields']['sitepath'] || $license->siteip != $vars['customfields']['siteip'] ){
            $ip = gethostbyname(parse_url($vars['customfields']['siteurl'], PHP_URL_HOST));
            $license->pre_url   = $vars['customfields']['siteurl'];
            $license->siteurl   = $vars['customfields']['siteurl'];
            $license->pre_path  = $vars['customfields']['sitepath'];
            $license->sitepath  = $vars['customfields']['sitepath'];
            $license->siteip    = $ip;
        }
        

        if ($package){
            $license->gwislots  = $vars['configoptions']['Resources'];
            $license->rwislots  = $vars['configoptions']['Resources'];
            $license->swislots  = $vars['configoptions']['Resources'];
            $license->vwislots  = $vars['configoptions']['Resources'];
        } else {
            $license->gwislots  = $vars['configoptions']['gwislots'];
            $license->rwislots  = $vars['configoptions']['rwislots'];
            $license->swislots  = $vars['configoptions']['swislots'];
            $license->vwislots  = $vars['configoptions']['vwislots'];
        }

        $answer = (new LicenseService)->updateLicense($license);
        
        //Check if Key isn't null 
		if ($answer->message != null){
            if ($answer->message == "SUCCESSFUL")
                return $license->save(); 
        }

        return false;
    }

    /** Executes on service suspend
     * @param mixed $vars
     * 
     * @return bool
     */
    public function suspendService($vars){
        $license = DatabaseManager::FindLicenseByService($vars['serviceid']);
        $answer =(new LicenseService)->suspendLicense($license);
        return $answer->message == "SUCCESSFUL";
    }

    
    /** Executes on service unsuspend
     * @param mixed $vars
     * 
     * @return bool
     */
    public function unsuspendService($vars){
        $license = DatabaseManager::FindLicenseByService($vars['serviceid']);
        $answer =(new LicenseService)->unsuspendLicense($license);
        return $answer->message == "SUCCESSFUL";
    }



    /** Executes on servicee terminate
     * @param mixed $vars
     * 
     * @return bool
     */
    public function terminateService($vars){
        $license = DatabaseManager::FindLicenseByService($vars['serviceid']);
        $answer =(new LicenseService)->deleteLicense($license);
        if ($answer->message == "SUCCESSFUL"){
            return DatabaseManager::DeleteLicense($license);
        } else { return false; }
    }
    

    /** Updates the productdetails after a license update
     * @param License $license
     * 
     * @return bool
     */
    public function updateProductdetails(License $license){
       $Customfields = DatabaseManager::FindCustomFields($license->serviceid);
       foreach($Customfields as $CustomField){
           $__name  = explode( '|', $CustomField->fieldname );
           $NAME    = count($__name) > 1 ? $__name[0] :  $CustomField->fieldname;

            switch($NAME){

                case "siteurl": 
                    DatabaseManager::UpdateCustomfield($CustomField->valueID, $license->serviceid, $license->siteurl);
                    break;

                case "sitepath": 
                    DatabaseManager::UpdateCustomfield($CustomField->valueID, $license->serviceid, $license->sitepath);
                    break;

            }

       }
    }


}