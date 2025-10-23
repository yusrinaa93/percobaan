<?php

namespace App\Filament\Resources\DutyResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

// PASTIKAN 'use' STATEMENTS INI ADA
class SubmissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'submissions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('original_filename')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('original_filename')
            ->columns([
                // Menggunakan 'Tables\Columns\TextColumn' karena kita sudah mengimpor 'Filament\Tables'
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Pengunggah')
                    ->searchable(),

                Tables\Columns\TextColumn::make('original_filename')
                    ->label('Nama File'),
                Tables\Columns\TextColumn::make('score')
                    ->label('Nilai')
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state === null ? '-' : $state),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Upload')
                    ->dateTime('d M Y, H:i'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // CreateAction dinonaktifkan
            ])
            ->actions([
                Tables\Actions\Action::make('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn ($record) => asset('storage/' . $record->file_path), shouldOpenInNewTab: true),

                // Action untuk mengisi/mengedit nilai oleh admin
                Tables\Actions\Action::make('Grade')
                    ->icon('heroicon-o-pencil')
                    ->form([
                        Forms\Components\TextInput::make('score')
                            ->label('Nilai (0-100)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->required(),
                    ])
                    ->action(function ($record, $data) {
                        $record->update(['score' => (int) $data['score']]);
                    })
                    ->requiresConfirmation(false),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}