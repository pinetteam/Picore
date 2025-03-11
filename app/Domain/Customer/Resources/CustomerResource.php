<?php

namespace App\Domain\Customer\Resources;

use App\Domain\Customer\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Domain\Customer\Resources\CustomerResource\Pages;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'Müşteri Yönetimi';

    protected static ?string $modelLabel = 'Müşteri';

    protected static ?string $pluralModelLabel = 'Müşteriler';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Temel Bilgiler')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('Kod')
                            ->required()
                            ->maxLength(127),
                        Forms\Components\TextInput::make('title')
                            ->label('Başlık')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('language')
                            ->label('Dil')
                            ->options([
                                'tr' => 'Türkçe',
                                'en' => 'İngilizce',
                                'de' => 'Almanca',
                                'fr' => 'Fransızca',
                            ]),
                        Forms\Components\TextInput::make('credit')
                            ->label('Kredi')
                            ->numeric(),
                        Forms\Components\FileUpload::make('logo')
                            ->label('Logo')
                            ->image()
                            ->directory('customers/logos'),
                        Forms\Components\FileUpload::make('icon')
                            ->label('İkon')
                            ->image()
                            ->directory('customers/icons'),
                        Forms\Components\Toggle::make('status')
                            ->label('Durum')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo_url')
                    ->label('Logo'),
                Tables\Columns\TextColumn::make('code')
                    ->label('Kod')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable(),
                Tables\Columns\TextColumn::make('language')
                    ->label('Dil'),
                Tables\Columns\TextColumn::make('credit')
                    ->label('Kredi')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->label('Durum')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma Tarihi')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('language')
                    ->label('Dil')
                    ->options([
                        'tr' => 'Türkçe',
                        'en' => 'İngilizce',
                        'de' => 'Almanca',
                        'fr' => 'Fransızca',
                    ]),
                Tables\Filters\TernaryFilter::make('status')
                    ->label('Durum'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            \App\Domain\Customer\Resources\CustomerResource\RelationManagers\UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'view' => Pages\ViewCustomer::route('/{record}'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
