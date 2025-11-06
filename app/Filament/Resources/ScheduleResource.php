<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleResource\Pages;
use App\Models\Schedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Course;

// SEMUA 'use' statement HARUS DI SINI, di luar class
class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('course_id')
                    ->label('Course')
                    ->relationship('course', 'title')
                    ->required(),
                Forms\Components\TextInput::make('category')
                    ->label('Nama/Kategori Jadwal')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\DateTimePicker::make('start_time')
                    ->label('Waktu Mulai')
                    ->required(),

                Forms\Components\DateTimePicker::make('end_time')
                    ->label('Waktu Selesai')
                    ->required(),

                Forms\Components\TextInput::make('zoom_link')
                    ->label('Link Zoom Meeting')
                    ->url()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category')
                    ->label('Nama Jadwal')
                    ->searchable(),

                Tables\Columns\TextColumn::make('start_time')
                    ->label('Waktu Mulai')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('end_time')
                    ->label('Waktu Selesai')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                //
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
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }    
}