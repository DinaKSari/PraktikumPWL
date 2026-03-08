<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                section::make("Post Details")
                -> Description("Fill in the details of the post")
                ->icon('heroicon-o-document-text')
                ->schema([
                TextInput::make('title')
                ->required()
                ->minLength(5), //minimal 5
                TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true), //unik slug
                Select::make("category_id")
                    ->relationship("category", "name")
                    ->preload()
                    ->searchable(),
                ColorPicker::make('color'),
                MarkdownEditor::make('content'),
                ]),
                //alternatif Markdown
                //RichEditor::make('body'),
                Section::make('Image Upload')
                ->schema([
                FileUpload::make('image')
                ->disk('public')
                ->directory('post'),
                ]),
                Section::make('Meta')
                ->schema([
                TagsInput::make('tags'),
                Checkbox::make('published'),
                DatePicker::make('published_at'),
                ]),
            ]);
    }
}
