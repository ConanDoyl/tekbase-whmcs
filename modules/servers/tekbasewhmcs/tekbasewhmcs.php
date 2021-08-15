<?php
/*
 * ###############################################################################
 * File: tekbasewhmcs.php
 * Project: tekbasewhmcs
 * File Created: Saturday, 14th August 2021 11:48:16 am
 * Author: Thomas Brinkmann (doyl@dsh.icu)
 * -----
 * Last Modified: Sunday, 15th August 2021 6:07:53 pm
 * Modified By: Thomas Brinkmann (doyl@dsh.icu>)
 * -----
 * Copyright 2021 - Thomas Brinkmann. All Rights Reserved.
 * -----
 * License text:
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 * ###############################################################################
 */

use ConanDoyl\TekbaseWhmcs\Models\License;
use ConanDoyl\TekbaseWhmcs\Manager\DatabaseManager;
use ConanDoyl\TekbaseWhmcs\Manager\TemplateManager;
use ConanDoyl\TekbaseWhmcs\Services\LicenseService;
use ConanDoyl\TekbaseWhmcs\Services\ProductService;
use ConanDoyl\TekbaseWhmcs\Services\ResponseService;
use ConanDoyl\TekbaseWhmcs\Services\TemplateService;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

include_once(__DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php'); 

/**
 * Define module related meta data.
 *
 * Values returned here are used to determine module related abilities and
 * settings.
 *
 * @see https://developers.whmcs.com/provisioning-modules/meta-data-params/
 *
 * @return array
 */
function tekbasewhmcs_MetaData()
{
    return array(
        'DisplayName' => 'Tekbase Reseller Module',
        'APIVersion' => '1.1', // Use API Version 1.1
        'DefaultNonSSLPort' => '80',
        'DefaultSSLPort' => '443',
        'RequiresServer' => true, // Set true if module requires a server to work
    );
}


function tekbasewhmcs_TestConnection($params){
    try {
        $apiTest = (new LicenseService)->countLicenses();
        DatabaseManager::init();

        if (!is_array($apiTest)){
            $success = true;
            $errorMsg = "";
        } else { 
            $success = false;
            $errorMsg = 'Connection failed! - ' . $apiTest['Message'];
        }
    } catch (Exception $e) {
        logModuleCall(
            'tekbasewhmcs',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );

        $success = false;
        $errorMsg = $e->getMessage();
    }

    return array(
        'success' => $success,
        'error' => $errorMsg,
    );
}

function tekbasewhmcs_CreateAccount($params){
    return (new ProductService)->createService($params);
}

function tekbasewhmcs_SuspendAccount($params){
    return (new ProductService)->suspendService($params);
}

function tekbasewhmcs_UnsuspendAccount($params){
    return (new ProductService)->unsuspendService($params);
}

function tekbasewhmcs_TerminateAccount($params){
    return (new ProductService)->terminateService($params);
}

function tekbasewhmcs_ChangePackage($params){
    return (new ProductService)->upgradeService($params);
}

function tekbasewhmcs_ClientArea($params){
    $TPLManager = new TemplateManager(dirname(__FILE__), "client/home.tpl"); 
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';
    $CustomFunction = "template_" . $page;
    $modulelink = $params['modulelink'];

    return array(
        'pagetitle' => 'Tekbase Module',
        'breadcrumb' => array('index.php?m=tekbasewhmcs' => 'Tekbase for WHMCS'),
        'templatefile' => $TPLManager->getTemplate($page),
        'requirelogin' => true,
        'forcessl' => false,
        'vars' => array(
            'modulelink'    => $modulelink,
            'tplVars' => (new TemplateService)->$CustomFunction($params)
        ),
    );

}



function tekbasewhmcs_saveClientSettings($params){ 
    if ( isset($_POST['siteurl']) && isset($_POST['sitepath']) ) {
		return (new ResponseService)->jsonResponse( (new TemplateService)->saveClientSettings($params) );
	} else { return (new ResponseService)->jsonResponse([ "result" => "failed", "message" => "Something went wrong" ]); }
}


function tekbasewhmcs_AdminServicesTabFields($params){
    $license = new License($params['serviceid']);
    return array(
        'License unique ID' => $license->id,
        'License Key' => '<textarea readonly style="resize: none;" name="License Key" rows="8" cols="45">'. $license->key .'</textarea>'
    );
}


function tekbasewhmcs_ClientAreaAllowedFunctions() {
    return [ "SaveClientSettings" => "saveClientSettings" ];
}