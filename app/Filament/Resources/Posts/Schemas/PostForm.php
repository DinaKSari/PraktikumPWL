<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3) // Membuat grid utama 3 kolom
            ->components([

                // Bagian KIRI (2/3)
                Section::make("Post Details")
                    ->description("Fill in the details of the post")
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Group::make([
                            TextInput::make('title')
                            ->required()
                            ->rules('min:3|max:100'),
                            TextInput::make('slug')
                            ->required()
                            ->unique()
                            ->validationMessages([
                            'unique' => 'Slug harus unik.',
                            ]),
                                //->unique(ignoreRecord: true),
                            Select::make("category_id")
                                ->relationship("category", "name")
                                ->preload()
                                ->searchable()
                                ->required(),
                            ColorPicker::make('color'),
                        ])->columns(2), // 2 kolom untuk field utama di dalam section

                        MarkdownEditor::make('content'),
                    ])->columnSpan(2),

                // Bagian KANAN (1/3)
                Group::make([
                    Section::make("Image Upload")
                        ->icon('heroicon-o-photo') // Ikon berbeda
                        ->schema([
                            FileUpload::make("image")
                                ->disk("public")
                                ->directory("posts")
                                ->required(),
                        ]),

                    Section::make("Meta Information")
                        ->icon('heroicon-o-list-bullet') // Ikon berbeda
                        ->schema([
                            TagsInput::make("tags"),
                            Checkbox::make("published"),
                            DatePicker::make('published_at'),
                        ]),
                ])->columnSpan(1),
            ]);
    }
}
