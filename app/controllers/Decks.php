<?php

namespace App\Controllers;

use App\Authentication;
use App\Models\Deck;
use Core\Controller;
use Core\View\View;

class Decks extends Controller
{
    public function doBefore(): bool
    {
        Authentication::requestSignin();
        return true;
    }

    public function indexAction(): void
    {
        $decks = Deck::findAllByUser(Authentication::getSignedInUser()->getId());
        View::render('decks/index.twig', ['decks' => $decks]);
    }
}
