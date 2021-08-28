<?php
/*
 * ###############################################################################
 * File: TemplateService.php
 * Project: Services
 * File Created: Saturday, 14th August 2021 4:44:07 pm
 * Author: Thomas Brinkmann (doyl@dsh.icu)
 * -----
 * Last Modified: Saturday, 28th August 2021 12:34:38 pm
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
use ConanDoyl\TekbaseWhmcs\Models\HttpRequest;
use ConanDoyl\TekbaseWhmcs\Models\License;

class TemplateService {


    public function template_home($data){
        $vars = [];
        $license = (new DatabaseManager)->FindLicenseByService($data['serviceid']);
        $lKey = explode("\n", $license->key);
        $vars += [ 'License_Key' => $lKey ];

        return $vars;        
    }



    public function saveClientSettings($data){
        $request = new HttpRequest;
        $license = new License($data['serviceid']);
		$pre_url = $request->get(INPUT_POST, 'siteurl');
		$sitepath = $request->get(INPUT_POST, 'sitepath');

		if (filter_var($pre_url, FILTER_VALIDATE_URL)) {
			$ipaddr = gethostbyname(parse_url($pre_url, PHP_URL_HOST));
			$url = $pre_url;
            
		} else { return [ "result" => "failed", "message" => "Url is not valid!" ]; }

        $license->siteip    = $ipaddr;
        $license->siteurl   = $url;
        $license->sitepath  = $sitepath;
		$answer = (new LicenseService)->updateLicense($license);
        if( $answer->message == "SUCCESSFUL" ) {
            $license->save();
		    return [ "result" => "success", "message" => "Saved"  ];
        } else { 
            logActivity(json_encode($answer));
            return [ "result" => "failed", "message" => "Something went wrong"  ];
        }

    }

}