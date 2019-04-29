<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
| ------------------------------------------------------------------- 
| EMAIL CONFING 
| ------------------------------------------------------------------- 
| Configuration of outgoing mail server. 
| */


$config['protocol'] = 'smtp';
$config['smtp_host'] = 'mail.salesscripter.com';
$config['smtp_user'] = 'no-reply@salesscripter.com';
$config['smtp_pass'] = 'ss13N32';
$config['smtp_port'] = '25';
$config['smtp_timeout'] = '5';
$config['mailtype'] = 'html';
$config['newline']   = "\r\n";
$config['charset']   = 'utf-8';
$config['wordwrap']  = TRUE;


/* End of file email.php */  
/* Location: ./system/application/config/email.php */ 