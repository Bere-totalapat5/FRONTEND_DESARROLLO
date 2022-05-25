<?php
/**
 * Clase MailData
 *
 * @author Javier
 * date 21/10/2010
 */
class MailData {
    private $email;
    private $de;
    private $folio;
    private $cedula;

    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function getFolio(){
        return $this->folio;
    }
    public function setFolio($folio){
        $this->folio = $folio;
    }
    public function getDe(){
        return $this->de;
    }
    public function setDe($de){
        $this->de = $de;
    }
    public function getCedula(){
        return $this->cedula;
    }
    public function setCedula($cedula){
        $this->cedula = $cedula;
    }
}
?>
