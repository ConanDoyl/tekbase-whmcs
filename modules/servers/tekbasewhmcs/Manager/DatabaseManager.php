<?php
/*
 * ###############################################################################
 * File: DatabaseManager.php
 * Project: Manager
 * File Created: Saturday, 14th August 2021 12:11:27 pm
 * Author: Thomas Brinkmann (doyl@dsh.icu)
 * -----
 * Last Modified: Thursday, 10th February 2022 6:48:14 pm
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

use Exception;
use WHMCS\Database\Capsule;
use Carbon\Carbon;
use ConanDoyl\TekbaseWhmcs\Models\License;


class DatabaseManager {


    public static function Init() {

        
        // Create a new table.
        try {
            if (!(new Capsule)->schema()->hasTable('mod_tekbase_licenses'))
                (new Capsule)->schema()->create(
                    'mod_tekbase_licenses',
                    function ($table) {
                        $table->increments('id');
                        $table->integer('serviceid');
                        $table->string('customerid');
                        $table->integer('licenseid');
                        $table->text('licensekey')->nullable();
                        $table->string('siteip')->nullable();
                        $table->string('siteurl')->nullable();
                        $table->string('sitepath')->nullable();
                        $table->string('version');
                        $table->boolean('cms');
                        $table->boolean('shop');
                        $table->integer('gwislots');
                        $table->integer('rwislots');
                        $table->integer('swislots');
                        $table->integer('vwislots');
                        $table->timestamps();
                    }
                );
        } catch (Exception $e) {
            logModuleCall(
                'tekbasewhmcs',
                __FUNCTION__,
                "",
                $e->getMessage(),
                $e->getTraceAsString()
            );
        }

    }


    public static function Destroy() {
        try {
            (new Capsule)->dropIfExists('mod_tekbase_licenses');
        } catch (\Exception $e) {
            logModuleCall(
                'tekbasewhmcs',
                __FUNCTION__,
                "",
                $e->getMessage(),
                $e->getTraceAsString()
            );
        }
    }


    public static function GetLicense(int $id) {
        if ((new Capsule)->table('mod_tekbase_licenses')->where('licenseid', $id)->count() > 0){
            return (new Capsule)->table('mod_tekbase_licenses')->where('licenseid', $id)->first();
        } else {
            return (new Capsule)->table('mod_tekbase_licenses')->where('serviceid', $id)->first();
        }
    }

    public static function FindLicenseByService($serviceid) {
        return new License(((new Capsule)->table('mod_tekbase_licenses')->where('serviceid', $serviceid)->first())->licenseid);
    }

    public static function UpdateLicense(License $license) {
        if ((new Capsule)->table('mod_tekbase_licenses')->where('licenseid', $license->id)->count() > 0 ){
            return (new Capsule)->table('mod_tekbase_licenses')->where('licenseid', $license->id)->update([

                'serviceid'  => $license->serviceid,
                'customerid' => $license->customer,
                'licenseid'  => $license->id,
                'licensekey' => $license->key,
                'siteip'     => $license->siteip,
                'siteurl'    => $license->siteurl,
                'sitepath'   => $license->sitepath,
                'version'    => $license->version,
                'cms'        => $license->cms,
                'shop'       => $license->shop,
                'gwislots'   => $license->gwislots,
                'rwislots'   => $license->rwislots,
                'swislots'   => $license->swislots,
                "updated_at" => (new Carbon)->now()

            ]) == 1;
        } else {
            return (new Capsule)->table('mod_tekbase_licenses')->insert([

                'serviceid'  => $license->serviceid,
                'customerid' => $license->customer,
                'licenseid'  => $license->id,
                'licensekey' => $license->key,
                'siteip'     => $license->siteip,
                'siteurl'    => $license->siteurl,
                'sitepath'   => $license->sitepath,
                'version'    => $license->version,
                'cms'        => $license->cms,
                'shop'       => $license->shop,
                'gwislots'   => $license->gwislots,
                'rwislots'   => $license->rwislots,
                'swislots'   => $license->swislots,
                "updated_at" => (new Carbon)->now(),
                "created_at" => (new Carbon)->now()

            ]);
        }
    }


    public static function FindCustomFields($serviceid){
        return (new Capsule)->table('tblcustomfieldsvalues')->where('tblcustomfieldsvalues.relid', $serviceid)
                           ->join('tblcustomfields', 'tblcustomfieldsvalues.fieldid', '=', 'tblcustomfields.id')
                           ->select('tblcustomfieldsvalues.id as valueID', 'tblcustomfieldsvalues.fieldid', 'tblcustomfieldsvalues.relid', 'tblcustomfields.id', 'tblcustomfields.fieldname')->get();
    }
    
    public static function UpdateCustomfield ($id, $serviceid, $value){
        return (new Capsule)->table('tblcustomfieldsvalues')->where('id', $id)->where('relid', $serviceid)->update([
            "value" => $value
        ]) == 1;
    }

    public static function DeleteLicense(License $license){
        return (new Capsule)->table('mod_tekbase_licenses')->where('licenseid', $license->id)->where('serviceid', $license->serviceid)->delete() > 0;
    }

    public static function AlreadyExists($serviceid){
        return (new Capsule)->table('mod_tekbase_licenses')->where('serviceid', $serviceid)->count() > 0; 
    }


}