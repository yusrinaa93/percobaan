<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExamResource\Pages;
// TAMBAHKAN INI: Impor Relation Manager kita
use App\Filament\Resources\ExamResource\RelationManagers; 
use App\Models\Exam;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
// Impor komponen form yang akan kita pakai
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
// Impor komponen tabel yang akan kita pakai
use Filament\Tables\Columns\TextColumn;

class ExamResource extends Resource
{
    protected static ?string $model = Exam::class;
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('course_id')
                    ->label('Course')
                    ->relationship('course', 'title')
                    ->required(),
                // Ganti 'name' menjadi 'title' agar sesuai migrasi
                TextInput::make('title') 
                    ->label('Judul Ujian')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                // Ganti field lain dengan 'description'
                Textarea::make('description')
                    ->label('Deskripsi Ujian')
                    ->columnSpanFull(),
                // HAPUS SEMUA field lama seperti gform_link, duration, dll
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('course.title')->label('Course'),
                // Ganti 'name' menjadi 'title'
                TextColumn::make('title')->searchable(),
                // Tampilkan deskripsi
                TextColumn::make('description')->limit(50),
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

    // INI BAGIAN PENTING YANG BARU
    public static function getRelations(): array
    {
        return [
            // Daftarkan Relation Manager untuk Soal
            RelationManagers\QuestionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExams::route('/'),
            'create' => Pages\CreateExam::route('/create'),
            'edit' => Pages\EditExam::route('/{record}/edit'),
        ];
    }
}