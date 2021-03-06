<?php
/*
 * ###############################################################################
 * File: ResponseService.php
 * Project: Services
 * File Created: Sunday, 15th August 2021 12:51:00 pm
 * Author: Thomas Brinkmann (doyl@dsh.icu)
 * -----
 * Last Modified: Tuesday, 24th August 2021 5:59:19 pm
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

use WHMCS\Http\JsonResponse;
use WHMCS\Terminus;

class ResponseService {


    /** Returns a JSON Response
     * @param array $data
     * 
     * @return JSON
     */
    function jsonResponse(array $data){
        $response = new JsonResponse((array)$data);
        $response->send();
        (new Terminus)->getInstance()->doExit();
    }


}