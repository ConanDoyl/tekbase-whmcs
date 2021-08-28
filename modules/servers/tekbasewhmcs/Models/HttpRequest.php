<?php
/*
 * ###############################################################################
 * File: HttpRequest.php
 * Project: Models
 * File Created: Saturday, 28th August 2021 10:40:24 am
 * Author: Thomas Brinkmann (doyl@dsh.icu)
 * -----
 * Last Modified: Saturday, 28th August 2021 12:57:51 pm
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


class HttpRequest {

    protected $post;
    protected $get;

    public function __construct() {
        $this->post = filter_input_array(INPUT_POST);
        $this->get = filter_input_array(INPUT_GET);
    }


    /** Returns the variable from the POST or GET variable
     * @param mixed $type INPUT_GET, INPUT_POST
     * @param mixed $variable
     * 
     * @return mixed
     */
    public function get($type, $variable){
        switch($type){

            case INPUT_GET:
                return filter_input($type, $variable);
            break;

            case INPUT_POST: 
                return filter_input($type, $variable);
            break;
        }
    }

    /** Returns the full array of the POST|GET variable
     * @param mixed $type INPUT_GET, INPUT_POST
     * 
     * @return array|false|null
     */
    public function getAll($type){
        switch($type){

            case INPUT_GET:
                return $this->get;
            break;

            case INPUT_POST: 
                return $this->post;
            break;
        }
    } 

    /** Returns the current page as string
     * @return string
     */
    public function getCurrentPage(){
        $page = $this->get(INPUT_GET, 'page');
        if (isset($page)){
            if ($page != ""){
                return $page;
            }
            return "home";
        }
        return "home";
    }


    /** Checks if the Variable is set
     * @param mixed $type INPUT_GET, INPUT_POST
     * @param mixed $key The key we're looking for
     * 
     * @return bool
     */
    public function hasKey($type, $value){
        switch($type){

            case INPUT_GET:
                return in_array($value, $this->get);
            break;

            case INPUT_POST: 
                return in_array($value, $this->post);
            break;
        }
        
    }

}
