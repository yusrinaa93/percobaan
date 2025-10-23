<?php

namespace App\Filament\Resources\ExamResource\RelationManagers;

// PASTIKAN SEMUA 'USE' STATEMENT INI ADA
use Filament\Forms;
use Filament\Forms\Form; // <-- Ini yang tadi error
use Filament\Resources\RelationManagers\RelationManager; // <-- Ini yang tadi error
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
// Impor komponen Form yang kita butuhkan
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Toggle;
// Impor komponen Tabel yang kita butuhkan
use Filament\Tables\Columns\TextColumn;

class QuestionsRelationManager extends RelationManager
{
    // 'questions' HARUS SAMA dengan nama method relasi di Model Exam.php
    protected static string $relationship = 'questions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Field untuk Teks Pertanyaan
                TextInput::make('question_text')
                    ->label('Teks Pertanyaan')
                    ->required()
                    ->columnSpanFull(),
                
                // Repeater untuk Pilihan Jawaban
                // 'options' HARUS SAMA dengan nama method relasi di Model Question.php
                Repeater::make('options') 
                    ->relationship()
                    ->schema([
                        TextInput::make('option_text')
                            ->label('Teks Pilihan Jawaban')
                            ->required(),
                        Toggle::make('is_correct')
                            ->label('Ini Jawaban Benar?'),
                    ])
                    ->label('Pilihan Jawaban')
                    ->columns(2)
                    ->minItems(2) // Minimal 2 pilihan
                    ->maxItems(5) // Maksimal 5 pilihan
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question_text')
            ->columns([
                TextColumn::make('question_text')->label('Teks Pertanyaan')->limit(100),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Buat Soal Baru'),
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