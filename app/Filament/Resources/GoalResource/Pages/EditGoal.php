<?php

namespace App\Filament\Resources\GoalResource\Pages;

use App\Filament\Resources\GoalResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGoal extends EditRecord
{
    protected static string $resource = GoalResource::class;

    /**
     * @throws \Exception
     */
    protected function getActions(): array
    {
        return [
            Actions\Action::make(_('Back to Goals'))
                ->icon('heroicon-o-arrow-left')
            ->url(fn ($record) => route('filament.resources.goals.index')),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        /** @var \Filament\Resources\Resource $class */
        $class = $this->getResource();
        return $class::getUrl();
    }
}
