<?php
/**
 * Clase MailReader
 *
 * @author Javier
 * date 20/10/2010
 */
require_once 'MailData.php';

class MailReader {

  	var $server='';
	var $username='';
	var $password='';

	var $mbox='';					/* mailbox resource */


	function __construct($username,$password,$mailserver='localhost',$port='110', $options=''){
    	if($port=='') $port='143';
		$strConnect='{'.$mailserver.':'.$port. $options .'}INBOX';

		$this->server			=	$strConnect;
		$this->username			=	$username;
		$this->password			=	$password;
	}

	function connect(){
		/* connect to the mailbox and make a active link */
		$this->mbox=imap_open($this->server,$this->username,$this->password);
        return $this->mbox!=false;
	}

    private $headerExpresion="/.*juicio.*/i";
    private $bodyExpresion="/folio:\s*([\w\/]+)\s+cedula:\s*(\d+)/i";
   	function getMailData(){
		$headers=imap_headers($this->mbox);
		$mailData=array();
		for($idx=0,$mid=1;$idx<count($headers);$idx++,$mid++){

			$mail_header=imap_header($this->mbox,$mid);
            $sender=$mail_header->from[0];

            if( preg_match($this->headerExpresion, $mail_header->subject) == 0 )
                continue;

            $register = new MailData();
            $register->setEmail(strtolower($sender->mailbox).'@'.$sender->host);

            $body = imap_body($this->mbox, $mid);
            $matches = null;
            if( preg_match($this->bodyExpresion, $body, $matches) ){
                $register->setFolio($matches[1]);
                $register->setCedula($matches[2]);
            }
            else{
                $register->setFolio('');
                $register->setCedula('');
            }
            array_push($mailData, $register);

			imap_delete($this->mbox,$mid);
		}
        return $mailData;
	}

	function close_mailbox(){
		imap_close($this->mbox,CL_EXPUNGE);
	}

}
?>
