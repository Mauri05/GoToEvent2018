<?php namespace controllers;

use models\CartLine as CartLine;
use daos\lists\CartList as CartList;
use controllers\BuyController as BuyController;
use daos\databases\PlaceDB as PlaceDB;

class CartController{

    protected $dao;
    public function __construct()
    {
        $this->dao=CartList::getInstance();
    }


    public function index(){

        include(ROOT. "views/cartView.php");
    }

    public function agregar($placeName, $price, $quantity){
        
        $eventId = $_SESSION['idEvent'];

        settype($price,"integer");
        settype($quantity,"integer");
        $finalPrice = $price * $quantity;

        $placedb = new PlaceDB();
        $placedb->updateRemainder($placeName,$quantity,$eventId);

        $cartLine = new CartLine($placeName, $quantity, $finalPrice);
        $this->dao->add($cartLine);

        
        $buyController = new BuyController();
        $buyController->index($eventId);
    }

    public function eliminar($objectCartLine){

        $this->dao->delete($objectCartLine);


    }



}

?>