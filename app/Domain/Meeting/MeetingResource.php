<?php

namespace App\Domain\Meeting;

use App\Domain\Meeting\MeetingResource\Pages;
use App\Domain\Meeting\MeetingResource\RelationManagers;
use App\Models\Meeting\Meeting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MeetingResource extends Resource
{
    protected static ?string $model = Meeting::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-bar';

    protected static ?string $navigationGroup = 'Toplantı Yönetimi';

    protected static ?string $modelLabel = 'Toplantı';

    protected static ?string $pluralModelLabel = 'Toplantılar';


    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Kullanıcının bağlı olduğu müşteri varsa, sadece o müşteriye ait toplantıları göster
        if (auth()->check() && auth()->user()->customer_id) {
            $query->where('customer_id', auth()->user()->customer_id);
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Toplantı Bilgileri')
                    ->schema([
                        Forms\Components\Select::make('customer_id')
                            ->relationship('customer', 'title', function ($query) {
                                // Kullanıcının bağlı olduğu müşteri varsa, sadece o müşteriyi göster
                                if (auth()->check() && auth()->user()->customer_id) {
                                    $query->where('id', auth()->user()->customer_id);
                                }
                            })
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
                            ->options([
                                'online' => 'Online',
                                'offline' => 'Offline',
                                'hybrid' => 'Hibrit',
                            ])
                            ->label('Tür'),

                        Forms\Components\DatePicker::make('start_at')
                            ->required()
                            ->label('Başlangıç Tarihi'),

                        Forms\Components\DatePicker::make('finish_at')
                            ->required()
                            ->label('Bitiş Tarihi'),

                        Forms\Components\Toggle::make('status')
                            ->required()
                            ->label('Durum')
                            ->default(true),

                        Forms\Components\FileUpload::make('banner_name')
                            ->directory('meeting-banners')
                            ->image()
                            ->imageEditor()
                            ->label('Banner'),
                    ])->columns(2),

                Forms\Components\Hidden::make('created_by')
                    ->default(fn() => auth()->id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.title')
                    ->searchable()
                    ->sortable()
                    ->label('Müşteri'),

                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->label('Kod'),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label('Başlık'),

                Tables\Columns\TextColumn::make('type')
                    ->searchable()
                    ->label('Tür'),

                Tables\Columns\TextColumn::make('start_at')
                    ->date()
                    ->sortable()
                    ->label('Başlangıç'),

                Tables\Columns\TextColumn::make('finish_at')
                    ->date()
                    ->sortable()
                    ->label('Bitiş'),

                Tables\Columns\IconColumn::make('status')
                    ->boolean()
                    ->label('Durum'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Oluşturulma Tarihi'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('customer_id')
                    ->relationship('customer', 'title', function ($query) {
                        // Kullanıcının bağlı olduğu müşteri varsa, sadece o müşteriyi göster
                        if (auth()->check() && auth()->user()->customer_id) {
                            $query->where('id', auth()->user()->customer_id);
                        }
                    })
                    ->label('Müşteri'),

                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'online' => 'Online',
                        'offline' => 'Offline',
                        'hybrid' => 'Hibrit',
                    ])
                    ->label('Tür'),

                Tables\Filters\TernaryFilter::make('status')
                    ->label('Durum'),
            ])
            ->actions([
                Tables\Actions\Action::make('view_documents')
                    ->label('Yönetim')
                    ->icon('heroicon-o-document-text')
                    ->url(fn ($record) => url("meeting-management/{$record->id}/documents"))
                    ->color('success'),
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
            RelationManagers\AnnouncementsRelationManager::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMeetings::route('/'),
            'create' => Pages\CreateMeeting::route('/create'),
            //'view' => Pages\ViewMeeting::route('/{record}'),
            'edit' => Pages\EditMeeting::route('/{record}/edit'),
        ];
    }
}
