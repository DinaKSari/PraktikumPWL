<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                Tabs::make('Product Tabs')
                ->tabs([
                    Tab::make('Product Details')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Product Name')
                            ->weight('bold')
                            ->color('primary'),
                        TextEntry::make('id')
                           ->label('Product ID'),
                        TextEntry::make('sku')
                            ->label('Product SKU')
                            ->badge()
                            ->color('success'),
                        TextEntry::make('description')
                         ->label('Product Description'),
                        TextEntry::make('created_at')
                            ->label('Product Creation Date')
                            ->date('d MY')
                            ->color('info'),
                ]),
                Tab::make('Product Price and Stock')
                    ->schema([
                        TextEntry::make('price')
                            ->label('Product Price')
                            ->weight('bold')
                            ->color('primary')
                            ->icon('heroicon-s-currency-dollar'),
                        TextEntry::make('stock')
                            ->label('Product Stock'),
                    ]),
                Tab::make('Image and Status')
                    ->schema([
                        ImageEntry::make('image')
                            ->label('Product Image')
                            ->disk('public'),
                        TextEntry::make('price')
                            ->label('Product Price')
                            ->weight('bold')
                            ->color('primary')
                            ->icon('heroicon-s-currency-dollar'),
                        TextEntry::make('stock')
                            ->label('Product Stock')
                            ->weight('bold')
                            ->color('primary'),
                        IconEntry::make('is_active')
                            ->label('Is Active?')
                            ->boolean(),
                        IconEntry::make('is_featured')
                            ->label('Is Featured?')
                            ->boolean(),
                ])
                ])->columnSpanFull(),
                Section::make('Product Info')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Product Name')
                            ->weight('bold')
                            ->color('primary'),

                        TextEntry::make('sku')
                            ->label('Product SKU')
                            ->badge()
                            ->color('warning'), // 1. Badge SKU dengan warna berbeda (kuning/warning)

                        TextEntry::make('price')
                            ->label('Product Price')
                            ->weight('bold')
                            ->icon('heroicon-s-currency-dollar')
                            // 3. Format harga menjadi Rp dengan formatStateUsing
                            ->formatStateUsing(fn (string $state): string => 'Rp ' . number_format($state, 0, ',', '.')),

                        TextEntry::make('stock')
                            ->label('Product Stock')
                            ->icon('heroicon-o-cube') // 2. Tambahkan icon pada Stock
                            ->weight('bold'),

                        TextEntry::make('description')
                            ->label('Product Description')
                            ->columnSpanFull(),
                    ])
                ->columnSpanFull(),
                Section::make('Pricing & Stock')
                    ->schema([
                        TextEntry::make('price')
                            ->label('Product Price')
                            ->icon('heroicon-o-currency-dollar'),
                        TextEntry::make('stock')
                         ->label('Product Stock'),
                    ])
                ->columnSpanFull(),
                Section::make ('Image and Status')
                    ->description('')
                    ->schema([
                        ImageEntry::make('image')
                            ->label('Product Image')
                            ->disk('public'),
                        TextEntry::make('price')
                            ->label('Product Price')
                            ->weight('bold')
                            ->color('primary')
                            ->icon('heroicon-s-currency-dollar'),
                        TextEntry::make('stock')
                            ->label('Product Stock')
                            ->weight('bold')
                            ->color('primary'),
                        IconEntry::make('is_active')
                            ->label('Is Active')
                            ->boolean(),
                        IconEntry::make('is_featured')
                            ->label('Is Featured')
                            ->boolean(),
                    ])
                ->columnSpanFull(),
            ]);
    }
}
