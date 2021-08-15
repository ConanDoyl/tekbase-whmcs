<?php 
/*
 * ###############################################################################
 * File: TemplateManager.php
 * Project: Handler
 * File Created: Wednesday, 5th August 2020 3:24:34 pm
 * Author: Thomas Brinkmann (doyl@dsh.icu)
 * -----
 * Last Modified: Sunday, 15th August 2021 6:08:38 pm
 * Modified By: Thomas Brinkmann (doyl@dsh.icu>)
 * -----
 * Copyright 2020 - Thomas Brinkmann. All Rights Reserved.
 * -----
 * License Text 
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 * -----
 * ###############################################################################
 */
namespace ConanDoyl\TekbaseWhmcs\Manager;

class TemplateManager {

protected $basePath;
protected $currentTemplate;
protected $currentTPLFile;


public function __construct(string $basepath, $currentTemplate = "admin/home.tpl"){
    $this->setBasePath($basepath . '/templates/');
    $this->setCurrentTemplate($this->getBasePath() . $currentTemplate);
    $this->setCurrentTPLFile($currentTemplate);

}

    
public function getTemplate($page, $isAdmin = false){
    return ($isAdmin ? $this->getBasePath() ."admin/" . $page .".tpl"  : "templates/client/" . $page . ".tpl");
}


/**
 * Get the value of currentTemplate
 */ 
public function getCurrentTemplate()
{
    return $this->currentTemplate;
}

/**
 * Set the value of currentTemplate
 *
 * @return  self
 */ 
public function setCurrentTemplate($currentTemplate)
{
    $this->currentTemplate = $currentTemplate;

    return $this;
}

/**
 * Get the value of basePath
 */ 
public function getBasePath()
{
    return $this->basePath;
}

/**
 * Set the value of basePath
 *
 * @return  self
 */ 
public function setBasePath($basePath)
{
    $this->basePath = $basePath;

    return $this;
}

/**
 * Get the value of currentTPLFile
 */ 
public function getCurrentTPLFile()
{
return $this->currentTPLFile;
}

/**
 * Set the value of currentTPLFile
 *
 * @return  self
 */ 
public function setCurrentTPLFile($currentTPLFile)
{
$this->currentTPLFile = $currentTPLFile;

return $this;
}
}
