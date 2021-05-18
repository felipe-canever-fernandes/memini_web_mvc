<?php

namespace App\Controllers;

use App\Authentication;
use App\Models\Deck;
use App\Models\ValidationErrorException;
use Core\Controller;
use Core\Router\Router;
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

    public function newAction(): void
    {
        View::render('decks/new.twig');
    }

    public function createAction(): void
    {
        if (!isset($_POST['create']))
            Router::redirect('/decks/new');

        $deck = new Deck(
            Authentication::getSignedInUser()->getId(),
            $_POST['title'],
            $_POST['description']
        );

        try {
            Deck::save($deck);
            Router::redirect('/decks');
        } catch (ValidationErrorException $exception) {
            View::render('decks/new.twig', [
                'deck' => $deck,
                'errors' => $exception->getErrors()
            ]);
        }
    }

    public function editAction(int $id): void
    {
        $result = Deck::findById($id);

        if ($result === false)
            Router::redirect('/error/not-found');

        if ($result->getUserId() !== Authentication::getSignedInUser()->getId())
            Router::redirect('/error/forbidden');

        View::render('decks/edit.twig', ['deck' => $result]);
    }
}
