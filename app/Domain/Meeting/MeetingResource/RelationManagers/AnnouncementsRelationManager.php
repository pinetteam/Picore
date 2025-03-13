<?php

namespace App\Domain\Meeting\MeetingResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AnnouncementsRelationManager extends RelationManager
{
    protected static string $relationship = 'announcements';

    protected static ?string $recordTitleAttribute = 'title';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(511)
                    ->label('Başlık'),
                Forms\Components\Toggle::make('status')
                    ->required()
                    ->label('Durum')
                    ->default(true),
                Forms\Components\Toggle::make('is_published')
                    ->required()
                    ->label('Yayınlandı')
                    ->default(false),
                Forms\Components\DateTimePicker::make('publish_at')
                    ->label('Yayın Tarihi'),
                Forms\Components\Hidden::make('created_by')
                    ->default(fn() => auth()->id()),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label('Başlık'),
                Tables\Columns\IconColumn::make('status')
                    ->boolean()
                    ->label('Durum'),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean()
                    ->label('Yayınlandı'),
                Tables\Columns\TextColumn::make('publish_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Yayın Tarihi'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Oluşturulma Tarihi'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['meeting_id'] = $this->ownerRecord->id;
                        $data['created_by'] = auth()->id();
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
