<?php 
namespace App\EventListener;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\RequestStack;
class LoginSuccessListener {
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack) {
        $this->requestStack = $requestStack;
    }
    public function onLoginSuccess(InteractiveLoginEvent $event): void {
        $session = $this->requestStack->getSession();
        $session->getFlashBag()->add("notice","You have successully logged in!");
    }
}