<?php

namespace App\Domain\Meeting\Resources;

use App\Domain\Meeting\Enums\MeetingStatusEnum;
use App\Domain\Meeting\Enums\MeetingTypeEnum;
use App\Domain\Meeting\Models\Meeting;
use App\Domain\Meeting\Resources\MeetingResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class MeetingResource extends Resource
{
    protected static ?string $model = Meeting::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-bar';

    protected static ?string $navigationGroup = 'Toplantı Yönetimi';

    protected static ?string $modelLabel = 'Toplantı';

    protected static ?string $pluralModelLabel = 'Toplantılar';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Temel Bilgiler')
                    ->schema([
                        Forms\Components\Select::make('customer_id')
                            ->relationship('customer', 'title')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Müşteri'),

                        Forms\Components\TextInput::make('code')
                            ->required()
                            ->maxLength(511)
                            ->label('Kod'),

                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(511)
                            ->label('Başlık'),

                        Forms\Components\Select::make('type')
                            ->options(MeetingTypeEnum::options())
                            ->label('Tür'),

                        Forms\Components\DatePicker::make('start_at')
                            ->required()
                            ->label('Başlangıç Tarihi'),

                        Forms\Components\DatePicker::make('finish_at')
                            ->required()
                            ->label('Bitiş Tarihi'),

                        Forms\Components\Toggle::make('status')
                            ->default(true)
                            ->label('Durum'),
                    ])->columns(2),

                Forms\Components\Section::make('Banner')
                    ->schema([
                        Forms\Components\FileUpload::make('banner')
                            ->label('Banner Görseli')
                            ->image()
                            ->disk('public')
                            ->directory('meetings')
                            ->visibility('public')
                            ->openable()
                            ->downloadable(),


                        // Form tanımı içinde
                        Forms\Components\FileUpload::make('banner_path')
                            ->image()
                            ->directory('meetings')
                            ->visibility('public')
                            ->disk('public')
                            ->imageResizeMode('cover')
                            ->label('Banner Görseli')
                            ->afterStateUpdated(function ($state, callable $set, $record) {
                                if ($state) {
                                    // Yüklenen dosya adını banner_name'e de kaydedelim
                                    $set('banner_name', $state);

                                    // Konsola bilgi yazdıralım
                                    \Illuminate\Support\Facades\Log::info('Dosya yüklendi', [
                                        'state' => $state,
                                        'record_id' => $record ? $record->id : 'new'
                                    ]);
                                }
                            }),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('banner_url')
                    ->label('Banner'),
                Tables\Columns\TextColumn::make('customer.title')
                    ->searchable()
                    ->sortable()
                    ->label('Müşteri'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label('Başlık'),
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->label('Kod'),
                Tables\Columns\TextColumn::make('type_label')
                    ->label('Tür'),
                Tables\Columns\TextColumn::make('date_range')
                    ->label('Tarih Aralığı'),
                Tables\Columns\IconColumn::make('status')
                    ->boolean()
                    ->label('Durum'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('customer_id')
                    ->relationship('customer', 'title')
                    ->label('Müşteri'),
                Tables\Filters\SelectFilter::make('type')
                    ->options(MeetingTypeEnum::options())
                    ->label('Tür'),
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Toplantı Bilgileri')
                    ->schema([
                        Infolists\Components\ImageEntry::make('banner_url')
                            ->label('Banner'),

                        Infolists\Components\TextEntry::make('customer.title')
                            ->label('Müşteri'),

                        Infolists\Components\TextEntry::make('title')
                            ->label('Başlık'),

                        Infolists\Components\TextEntry::make('code')
                            ->label('Kod'),

                        Infolists\Components\TextEntry::make('type_label')
                            ->label('Tür'),

                        Infolists\Components\TextEntry::make('date_range')
                            ->label('Tarih Aralığı'),

                        Infolists\Components\IconEntry::make('status')
                            ->boolean()
                            ->label('Durum'),
                    ])->columns(2),
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
            'index' => Pages\ListMeetings::route('/'),
            'create' => Pages\CreateMeeting::route('/create'),
            'view' => Pages\ViewMeeting::route('/{record}'),
            'edit' => Pages\EditMeeting::route('/{record}/edit'),
        ];
    }
}
