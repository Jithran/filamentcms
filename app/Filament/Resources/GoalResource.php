<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GoalResource\Pages;
use App\Filament\Resources\GoalResource\RelationManagers;
use App\Models\Goal;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class GoalResource extends Resource
{
    protected static ?string $model = Goal::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make([
                    TextInput::make('name')
                        ->autofocus()
                        ->rules('required', 'max:255')
                        ->reactive()->afterStateUpdated(function (Closure $set, $state) {
                            $set('slug', Str::slug($state));
                        }),
                    Textarea::make('description'),
                ]),
                Forms\Components\Group::make([
                    TextInput::make('slug')
                        ->required(),

                    Forms\Components\DatePicker::make('due_date')
                        ->required(),
                    Forms\Components\Toggle::make('is_completed'),
                ]),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                'name' => \Filament\Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                'slug' => \Filament\Tables\Columns\TextColumn::make('slug')
                    ->sortable()
                    ->searchable(),
                'date' => \Filament\Tables\Columns\TextColumn::make('due_date')
                    ->sortable()
                    ->searchable(),
                'is_completed' => \Filament\Tables\Columns\IconColumn::make('is_completed')
                    ->boolean()
                    ->trueIcon('heroicon-o-check')
                    ->falseIcon('heroicon-o-x'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGoals::route('/'),
            'create' => Pages\CreateGoal::route('/create'),
            'edit' => Pages\EditGoal::route('/{record}/edit'),
        ];
    }
}
