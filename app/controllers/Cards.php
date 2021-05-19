<?php

namespace App\Controllers;

use App\Authentication;
use App\Models\Card;
use App\Models\Deck;
use Core\Controller;
use Core\Router\Router;
use Core\View\View;

class Cards extends Controller
{
    public function doBefore(): bool
    {
        Authentication::requestSignin();
        return true;
    }

    public static function getDeck(int $deckId): Deck
    {
        $deck = Deck::findById($deckId);

        if ($deck === false)
            Router::redirect('/error/not-found');

        if ($deck->getUserId() !== Authentication::getSignedInUser()->getId())
            Router::redirect('/error/forbidden');

        return $deck;
    }

    public function indexAction(int $deckId): void
    {
        $deck = self::getDeck($deckId);
        $cards = Card::findAllByDeck($deckId);

        View::render('cards/index.twig', [
            'deck' => $deck,
            'cards' => $cards
        ]);
    }

    public function newAction(int $deckId): void
    {
        $deck = self::getDeck($deckId);
        View::render('cards/new.twig', ['deck' => $deck]);
    }
}
