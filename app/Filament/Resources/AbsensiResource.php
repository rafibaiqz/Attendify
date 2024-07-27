<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AbsensiResource\Pages;
use App\Filament\Resources\AbsensiResource\RelationManagers;
use App\Models\Absensi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\NumberInput;
use Filament\Forms\Components\DateTimePicker;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsensiExport;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Support\Collection;
use App\Mail\AbsensiNotification;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\Label;

class AbsensiResource extends Resource
{
    protected static ?string $model = Absensi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('extra_desc')
                ->label('Absensi Tambahan'),
            TextInput::make('code_ticket')
                ->required()
                ->label('Code Ticket'),
            TextInput::make('title_ticket')
                ->required()
                ->label('Tittle Ticket'),
            DateTimePicker::make('mulai_kerja')
                ->required()
                ->placeholder('Pilih waktu mulai kerja'),
            DateTimePicker::make('akhir_kerja')
            ->after('mulai_kerja')
                ->placeholder('Pilih waktu akhir kerja'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('extra_desc')->label('Absensi Tambahan'),
                TextColumn::make('description')->label('Ticket')->searchable(),
                TextColumn::make('mulai_kerja')->label('Mulai Kerja')->dateTime(),
                TextColumn::make('akhir_kerja')->label('Selesai Kerja')->dateTime(),
                TextColumn::make('total_hours')->label('Total Jam Kerja')
    ->label('Total Jam Kerja')
    ->formatStateUsing(fn ($record) => $record->total_hours),

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
                    BulkAction::make('exportToExcel')
                        ->label('Export to Excel')
                        ->action(function (Collection $records) {
                            // Convert the Eloquent collection to an array
                            $recordsArray = $records->map(function ($record) {
                                return $record->toArray();
                            });
    
                            $export = new AbsensiExport($recordsArray);
                            return Excel::download($export, 'absensi.xlsx');
                        }),
                ]),
            ]);
    }

    public function rules()
{
    return [
        'mulai_kerja' => 'required|date_format:Y-m-d H:i:s',
        'akhir_kerja' => 'required|date_format:Y-m-d H:i:s|after:mulai_kerja',
    ];
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
            'index' => Pages\ListAbsensis::route('/'),
            'create' => Pages\CreateAbsensi::route('/create'),
            'edit' => Pages\EditAbsensi::route('/{record}/edit'),
        ];
    }
}
