<?php  

namespace App\Service;


use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ShoppingCartService{

    protected $session;
    

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
    
    public function addProduct(int $id){
        $shoppingCart = $this->session->get('shoppingCart',[]);
        if(!empty($shoppingCart[$id])){
            $shoppingCart[$id]++;
    } else {
        $shoppingCart[$id] = 1;
    }
    $this->session->set('shoppingCart',$shoppingCart);
    dd($this->session->get('shoppingCart'));
}}