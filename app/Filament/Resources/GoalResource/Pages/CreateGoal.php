<?php

namespace App\Filament\Resources\GoalResource\Pages;

use App\Filament\Resources\GoalResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGoal extends CreateRecord
{
    protected static string $resource = GoalResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
