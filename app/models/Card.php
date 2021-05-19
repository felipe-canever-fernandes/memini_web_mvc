<?php

namespace App\Models;

use Core\Model;
use PDO;

class Card extends Model
{
    private int $userId;
    private int $deckId;

    private string $front;
    private string $back;

    private int $repetitionCount;
    private int $timeInterval;
    private float $easeFactor;

    public function __construct(
        int $userId, int $deckId,
        string $front, string $back,
        int $id = 0,
        int $repetitionCount = 0, int $timeInterval = 0, float $easeFactor = 2.5
    )
    {
        parent::__construct($id);

        $this->setUserId($userId);
        $this->setDeckId($deckId);

        $this->setFront($front);
        $this->setBack($back);

        $this->setRepetitionCount($repetitionCount);
        $this->setTimeInterval($timeInterval);
        $this->setEaseFactor($easeFactor);
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getDeckId(): int
    {
        return $this->deckId;
    }

    public function setDeckId(int $deckId): void
    {
        $this->deckId = $deckId;
    }

    public function getFront(): string
    {
        return $this->front;
    }

    public function setFront(string $front): void
    {
        $this->front = $front;
    }

    public function getBack(): string
    {
        return $this->back;
    }

    public function setBack(string $back): void
    {
        $this->back = $back;
    }

    public function getRepetitionCount(): int
    {
        return $this->repetitionCount;
    }

    public function setRepetitionCount(int $repetitionCount): void
    {
        $this->repetitionCount = $repetitionCount;
    }

    public function getTimeInterval(): int
    {
        return $this->timeInterval;
    }

    public function setTimeInterval(int $timeInterval): void
    {
        $this->timeInterval = $timeInterval;
    }

    public function getEaseFactor(): float
    {
        return $this->easeFactor;
    }

    public function setEaseFactor(float $easeFactor): void
    {
        $this->easeFactor = $easeFactor;
    }
}
