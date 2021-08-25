<?php


namespace App\Models\Automata\DTO;

use App\Models\Automata\Curatorship;

class CuratorshipDTO
{
    public function __construct(private Curatorship $curatorship)
    {
    }

    public function getId(): int
    {
        return $this->curatorship->id_curatorship;
    }

    public function hasSimilarCheckedNews(): bool
    {
        return ! is_null($this->curatorship->id_news_checked);
    }

    public function hasSimilarCheckedNewsDescription(): string
    {
        return $this->hasSimilarCheckedNews() ? 'Sim' : 'Não';
    }

    public function newsText(): string
    {
        return $this->curatorship->news->text_news;
    }

    public function newsPublicationDate(): string
    {
        return $this->curatorship->news->datetime_publication->format('d/m/Y');
    }

    public function agencyCheckedNewsUrl(): string
    {
        return $this->curatorship?->agencyCheckedNews?->publication_url ?? '';
    }

    public function agencyCheckedNewsText(): string
    {
        return $this->curatorship?->agencyCheckedNews?->publication_title ?? '';
    }

    public function agencyNewsName(): string
    {
        return $this->curatorship?->agencyCheckedNews->trustedAgency->name_agency ?? '';
    }
}
