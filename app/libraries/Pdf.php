<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pdf
 *
 * @author genesis
 */
class Pdf extends TCPDF {
    //put your code here
   function __construct()
    {
        parent::__construct();
    }
}
