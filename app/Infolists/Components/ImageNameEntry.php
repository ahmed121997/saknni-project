<?php

namespace App\Infolists\Components;

use Filament\Infolists\Components\Entry;

class ImageNameEntry extends Entry
{
    protected string $view = 'infolists.components.image-name-entry';

    protected string | \Closure | null $imageColumn = 'image';

    public function imageColumn(string | \Closure | null $column = null): static
    {
        $this->imageColumn = $column;
        return $this;
    }

    public function getImageUrl(): ?string
    {
        $column = $this->imageColumn;
        return  $this->getRecord()->{$column} ?? null;
    }
}
