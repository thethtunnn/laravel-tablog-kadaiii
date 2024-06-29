<?php

namespace App\Filament\Resources;

use App\Filament\Exports\StoreExporter;
use App\Filament\Resources\StoreResource\Pages;
use App\Filament\Resources\StoreResource\RelationManagers;
use App\Forms\Components\Review;
use App\Models\Caeegory;
use App\Models\Category;
use App\Models\Store;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;

use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

// use Filament\Tables\Actions\ExportBulkAction;


use Filament\Actions\Exports\Enums\ExportFormat;

class StoreResource extends Resource
{
    protected static ?string $model = Store::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),

                TextInput::make('description'),
                FileUpload::make('image')->disk('public_stores'),
                TextInput::make('lowest_price')->numeric(),
                TextInput::make('highest_price')->numeric(),
                TextInput::make('postal_code')->numeric()->minLength(7),
                TextInput::make('Address'),
                DateTimePicker::make('opening_time'),
                DateTimePicker::make('closing_time'),
                TextInput::make('seating_capacity')->numeric(),


                Select::make('category_id')->options(function (): array {
                    return Category::all()->pluck('name', 'id')->all();
                })->native(false)
                    ->beforeStateDehydrated(function ($state) {
                        return $state;
                    })->label('Category Name')->searchable()
                // TextInput::make('seating_capacity')
                ,
                TextInput::make('seat')->label('Left Seat')
                    ->afterStateHydrated(function (TextInput $component, $record) {

                        $component->state($record?->leftSeat());
                    })
                    ->readOnly()->disabled(fn ($record) => !is_null($record)),

                ViewField::make('reviews')->view('filament.forms.components.review')
                    // Review::make('reviews')
                    //     ->Getstore($record)
                    // ->viewData([
                    //     'data' => function ($record) {
                    //         // Logic to fetch and pass data if needed

                    //         return $record->reviews->all();
                    //     },
                    // ])
                    ->viewData([
                        // 'reviews' => (is_object($form?->model) && is_array($form->model->reviews) && count($form->model->reviews) > 0)
                        //     ? $form->model->reviews
                        //     : []
                        'reviews' => $form->model->reviews

                    ])
                // ->disabledOn('edit')

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),

                TextColumn::make('name')->searchable(),

                TextColumn::make('description'),
                ImageColumn::make('image')->disk('public_stores'),
                TextColumn::make('lowest_price'),
                TextColumn::make('highest_price'),
                TextColumn::make('postal_code'),
                TextColumn::make('Address'),
                TextColumn::make('opening_time'),
                TextColumn::make('closing_time'),
                TextColumn::make('category.name')->searchable(),
                TextColumn::make('category_id')->hidden(),

                TextColumn::make('seating_capacity'),
                TextColumn::make('seat')->label('Left Seat')
                    ->getStateUsing(function ($record) {
                        return $record->leftSeat();
                    }),



            ])
            ->filters([
                //
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
                // ExportBulkAction::make()
                //     ->exporter(StoreExporter::class)
                //     ->formats([
                //         ExportFormat::Csv,
                //     ])


            ])

            ->headerActions([
                ExportAction::make()->exports([
                    ExcelExport::make('table')->fromTable(),
                    // ExcelExport::make('form')->fromForm(),
                ])
                // ->withWriterType(\Maatwebsite\Excel\Excel::CSV),
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
            'index' => Pages\ListStores::route('/'),
            'create' => Pages\CreateStore::route('/create'),
            'view' => Pages\ViewStore::route('/{record}'),
            'edit' => Pages\EditStore::route('/{record}/edit'),
        ];
    }
}
