<?php

namespace App\Filament\Resources\Hotels\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use App\Models\SiteSetting;

class HotelForm
{
    public static function configure(Schema $schema): Schema
    {
        $settings = SiteSetting::pluck('value', 'key')->toArray();
        $getOptions = function($key) use ($settings) {
            $arr = isset($settings[$key]) ? json_decode($settings[$key], true) : [];
            if (!is_array($arr)) return [];
            
            // If the array contains associative arrays (like the new amenities format), pluck the name
            if (!empty($arr) && is_array(reset($arr))) {
                return collect($arr)->mapWithKeys(fn($item) => [$item['name'] => $item['name']])->toArray();
            }
            
            return collect($arr)->mapWithKeys(fn($item) => [$item => $item])->toArray();
        };

        return $schema
            ->components([
                Tabs::make('Hotel Details')
                    ->tabs([
                        Tabs\Tab::make('General Info')
                            ->icon('heroicon-o-information-circle')
                            ->columns(2)
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, callable $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                                Toggle::make('is_featured')
                                    ->label('Featured Hotel')
                                    ->helperText('Check this to show the hotel on the home page as featured.'),
                                TextInput::make('slug')
                                    ->disabled()
                                    ->dehydrated()
                                    ->required()
                                    ->unique(\App\Models\Hotel::class, 'slug', ignoreRecord: true),
                                Select::make('district_id')
                                    ->relationship('district', 'title')
                                    ->required(),
                                TextInput::make('location')
                                    ->required(),
                                MarkdownEditor::make('description')
                                    ->columnSpanFull(),
                            ]),
                        
                        Tabs\Tab::make('Configuration')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->columns(2)
                            ->schema([
                                Select::make('hotel_type')
                                    ->label('Property Type')
                                    ->options($getOptions('hotel_types'))
                                    ->searchable(),
                                Select::make('category')
                                    ->label('Star/Pricing Category')
                                    ->options($getOptions('hotel_categories'))
                                    ->searchable(),
                                CheckboxList::make('amenities')
                                    ->label('Property Amenities')
                                    ->options($getOptions('hotel_amenities'))
                                    ->columns(2)
                                    ->columnSpanFull(),
                                CheckboxList::make('features')
                                    ->label('Room Features')
                                    ->options($getOptions('hotel_features'))
                                    ->columns(2)
                                    ->columnSpanFull(),
                                CheckboxList::make('room_types')
                                    ->label('Room Types')
                                    ->options($getOptions('hotel_room_types'))
                                    ->columns(2)
                                    ->columnSpanFull(),
                                Select::make('tags')
                                    ->label('Tags & Highlights')
                                    ->multiple()
                                    ->relationship('tags', 'name')
                                    ->preload()
                                    ->columnSpanFull(),
                            ]),
                        
                        Tabs\Tab::make('Media & Gallery')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                FileUpload::make('image_path')
                                    ->label('Main Featured Image')
                                    ->image()
                                    ->directory('hotels')
                                    ->disk('public')
                                    ->required(),
                                FileUpload::make('gallery')
                                    ->label('Photo Gallery')
                                    ->image()
                                    ->multiple()
                                    ->directory('hotels/gallery')
                                    ->disk('public')
                                    ->panelLayout('grid')
                                    ->reorderable()
                                    ->appendFiles(),
                            ]),
                        
                        Tabs\Tab::make('Location & Contact')
                            ->icon('heroicon-o-map-pin')
                            ->columns(2)
                            ->schema([
                                TextInput::make('phone')
                                    ->tel(),
                                TextInput::make('whatsapp')
                                    ->tel(),
                                MarkdownEditor::make('nearby_attractions')
                                    ->label('Nearby Attractions')
                                    ->columnSpanFull(),
                                MarkdownEditor::make('how_to_reach')
                                    ->label('How to Reach')
                                    ->columnSpanFull(),
                            ]),
                    ])->columnSpanFull()
            ]);
    }
}
