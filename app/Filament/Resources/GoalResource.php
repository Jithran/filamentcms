<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GoalResource\Pages;
use App\Models\Goal;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Str;

class GoalResource extends Resource
{
    protected static ?string $model = Goal::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make([
                    Forms\Components\Card::make()->schema([
                        TextInput::make('name')
                            ->autofocus()
                            ->rules('required', 'max:255')
                            ->reactive()->afterStateUpdated(function (Closure $set, $state) {
                                $set('slug', Str::slug($state));
                            }),
                        TextInput::make('slug')
                            ->required(),

                        DatePicker::make('due_date'),
                        Toggle::make('is_completed'),
                    ]),
                ]),
                Group::make([
                    Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                        ->rules('required', 'image', 'max:1024')
                        ->maxFiles(1)
                        ->maxSize(2048)
                        ->acceptedFileTypes(['image/*'])
                        ->helperText('Upload an image for this goal. (max 2MB)')
                        ->collection('groups'),
                ]),

                Forms\Components\Card::make()->schema([
                    Forms\Components\RichEditor::make('description'),
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
