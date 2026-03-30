<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\ReplicateAction;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // 1. Aktifkan sorting pada semua kolom teks
                TextColumn::make('id')
                ->label('ID')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('title')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('slug')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                ColorColumn::make('color'),

                ImageColumn::make('image')
                    ->disk('public'),

                TextColumn::make('tags')
                ->label('Tags')
                ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('published')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(), // 1. Sorting aktif di kolom tanggal
            ])
            // 2. Buat default sorting berdasarkan Created At descending
            ->defaultSort('created_at', 'desc')

            ->filters([
                Filter::make('created_at')
                ->label('Creation Date')
                ->schema([
                DatePicker::make('created_at')
                ->label('Select Date'),
                ])

                ->query(function ($query, $data) {
                return $query->when(
                $data['created_at'],
                fn ($query, $date) => $query->whereDate('created_at', $date)
                );
                }),

                SelectFilter::make('category_id')
                ->label('Select Category')
                ->relationship('category', 'name')
                ->preload(),
            ])
            ->recordActions([
                ReplicateAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                Action::make('status')
                ->icon('heroicon-o-check-circle')
                ->label('status change')
                ->schema ([
                Checkbox::make('published')
                ->default(fn($record): bool => $record->published)
                ->label('Ubah status publish?')
                ->required(),
                ])
                ->action(function ($record, $data) {
                $record->update (['published' => $data['published']]);
                })
                 ->action(function ($record, $data) {
                $record->update(['published' => $data['published']]);
                })

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
