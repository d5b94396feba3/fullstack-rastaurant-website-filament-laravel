<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'System Configuration';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('key')
                ->required()
                ->disabled(fn ($record) => $record !== null)
                ->columnSpanFull(),
            
            // Text value input for general configuration items
            Forms\Components\TextInput::make('value')
                ->label('Setting Value (Text or URL)')
                ->required()
                ->columnSpanFull(),

            // Extra helper text or info for image keys
            Forms\Components\Placeholder::make('image_hint')
                ->label('Image Note')
                ->content('To update logo or images, you can alternatively paste the public storage file path directly above or use a direct URL.')
                ->visible(fn ($record) => $record && in_array($record->key, ['logo_image', 'favicon', 'story_image', 'about_image_1', 'about_image_2', 'hero_image']))
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => ucwords(str_replace('_', ' ', $state))),
                
                Tables\Columns\TextColumn::make('value')
                    ->limit(50)
                    ->searchable()
                    ->formatStateUsing(function ($state, $record) {
                        if (in_array($record->key, ['logo_image', 'favicon', 'story_image', 'about_image_1', 'about_image_2', 'hero_image']) && !empty($state)) {
                            return '[Image File Uploaded]';
                        }
                        return $state;
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}