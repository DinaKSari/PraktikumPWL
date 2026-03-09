<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
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
                Tabs::make('Product Details')
                    ->tabs([
                        // Tab 1: Info Utama
                        Tab::make('General Info')
                            ->icon('heroicon-o-information-circle') // 4. Icon Berbeda
                            ->schema([
                                TextEntry::make('name')
                                    ->weight('bold')
                                    ->color('primary'),
                                TextEntry::make('sku')
                                    ->badge()
                                    ->color('info'), // 2. Warna badge berbeda (info/biru)
                                TextEntry::make('description')
                                    ->columnSpanFull(),
                            ])->columns(2),

                        // Tab 2: Harga & Stok
                        Tab::make('Pricing & Inventory')
                            ->icon('heroicon-o-currency-dollar') // 4. Icon Berbeda
                            ->schema([
                                TextEntry::make('price')
                                    ->label('Price')
                                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                                    ->weight('bold'),

                                // 1 & 2. Badge dinamis & Warna berbeda berdasarkan stok
                                TextEntry::make('stock')
                                    ->badge()
                                    ->color(fn (int $state): string => match (true) {
                                        $state <= 5 => 'danger',   // Merah jika <= 5
                                        $state <= 20 => 'warning', // Kuning jika <= 20
                                        default => 'success',      // Hijau jika banyak
                                    })
                                    ->icon('heroicon-o-cube'),
                            ])->columns(2),

                        // Tab 3: Media
                        Tab::make('Media & Status')
                            ->icon('heroicon-o-photo') // 4. Icon Berbeda
                            ->schema([
                                ImageEntry::make('image')
                                    ->disk('public')
                                    ->columnSpanFull(),
                                IconEntry::make('is_active')
                                    ->label('Status Aktif')
                                    ->boolean(),
                            ])->columns(2),
                    ])
                    ->vertical() // 3. Tampilan menjadi Vertical
                    ->columnSpanFull(),
            ]);
    }
}
