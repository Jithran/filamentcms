<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Users';

    protected static ?string $navigationLabel = 'User Management';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Card::make()->schema([
                        Forms\Components\TextInput::make('name')
                            ->autofocus()
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->required(),
                        Forms\Components\TextInput::make('password')
                            ->type('password')
                            ->required(fn($record): bool => is_null($record?->id))
                            ->minLength(8)
                            ->same('password_confirmation')
                            ->dehydrateStateUsing(fn($state): string => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state)),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->type('password')
                            ->required(fn($record): bool => is_null($record?->id))
                            ->minLength(8)
                            ->dehydrated(false),
                        Toggle::make('has_filament_access')
                            ->label('Has Filament Access')
                            ->helperText('If this is checked, the user will be able to access the Filament admin panel.'),

                    ]),
                ]),
                Forms\Components\Card::make()->schema([
                    Forms\Components\SpatieMediaLibraryFileUpload::make('avatar')
                        ->rules('required', 'image', 'max:1024')
                        ->maxFiles(1)
                        ->maxSize(2048)
                        ->acceptedFileTypes(['image/*'])
                        ->helperText('Upload an image for this user. (max 2MB)')
                        ->collection('users'),
                ]),
            ]);
    }

    /**
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                'Name' => TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                'Email' => TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
