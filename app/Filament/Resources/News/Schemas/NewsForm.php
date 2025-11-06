<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255),
                Toggle::make('is_published')
                    ->label('Estado')
                    ->inline(false)
                    ->default(true),
                RichEditor::make('content')
                    ->label('Contenido')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->label('Imagen')
                    ->image()
                    ->directory('news')
                    ->columnSpanFull(),
                Select::make('user_id')
                    ->label('Autor')
                    ->relationship('user', 'name')
                    ->required()
                    ->default(fn () => auth()->id())
                    ->searchable()
                    ->preload(),
                Select::make('tags')
                    ->label('Etiquetas de recurso')
                    ->helperText('Si no seleccionas ninguna etiqueta, la noticia será visible para todos los usuarios.')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columnSpanFull(),
                DateTimePicker::make('published_at')
                    ->label('Fecha de Publicación')
                    ->native(false)
                    ->seconds(false),
            ]);
    }
}
