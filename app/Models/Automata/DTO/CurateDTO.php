<?php


namespace App\Models\Automata\DTO;


use App\Enums\CuratorshipsIsFakeOptions;

class CurateDTO
{
    public function __construct(
        private ?bool $isNews,
        private ?int $isFake,
        private ?bool $isSimilar = null,
        private ?string $textNote = null
    )
    { }

    /**
     * @return bool
     */
    public function isSimilar(): ?bool
    {
        return $this->isSimilar;
    }

    /**
     * @return bool
     */
    public function isNews(): ?bool
    {
        return $this->isNews;
    }

    /**
     * @return bool
     */
    public function isNotNews(): bool
    {
        return ! $this->isNews();
    }
    /**
     * @return bool
     */
    public function isFake(): ?bool
    {
        $isFake = (int) $this->isFake;
        return match ($isFake) {
            CuratorshipsIsFakeOptions::IS_FAKE => true,
            CuratorshipsIsFakeOptions::IS_NOT_FAKE => false,
            default => null,
        };
    }

    /**
     * @return bool
     */
    public function isNotFake(): bool
    {
        return ! $this->isFake();
    }

    /**
     * @return string|null
     */
    public function getTextNote(): ?string
    {
        return $this->textNote;
    }
}
