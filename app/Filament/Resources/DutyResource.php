<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DutyResource\Pages;
use App\Filament\Resources\DutyResource\RelationManagers; // <-- PENTING
use App\Models\Duty;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DutyResource extends Resource
{
    protected static ?string $model = Duty::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('course_id')
                    ->label('Course')
                    ->relationship('course', 'title')
                    ->required(),
                Forms\Components\TextInput::make('name')->required()->columnSpanFull(),
                Forms\Components\RichEditor::make('description')->columnSpanFull(),
                Forms\Components\DateTimePicker::make('deadline')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('course.title')->label('Course'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('deadline')->dateTime('d M Y, H:i'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }
    
    // INI BAGIAN YANG ANDA TAMBAHKAN
    public static function getRelations(): array
    {
        return [
            RelationManagers\SubmissionsRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDuties::route('/'),
            'create' => Pages\CreateDuty::route('/create'),
            'edit' => Pages\EditDuty::route('/{record}/edit'),
        ];
    }    
}