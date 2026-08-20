<?php

namespace App\Filament\Pages\Settings;

use App\Models\SiteSetting;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageHotelSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationLabel = 'Hotel Configurations';
    protected static ?string $title = 'Manage Hotel Configurations';
    protected static bool $shouldRegisterNavigation = false;

    // Use a standard blade view for the form
    protected string $view = 'filament.pages.manage-setting-form';

    public ?array $data = [];

    // Fields that should be handled as arrays
    protected array $arrayKeys = [
        'hotel_types',
        'hotel_categories',
        'hotel_amenities',
        'hotel_features',
        'hotel_room_types',
    ];

    public function mount(): void
    {
        $settings = SiteSetting::pluck('value', 'key')->toArray();
        
        foreach ($this->arrayKeys as $key) {
            if (isset($settings[$key])) {
                $decoded = json_decode($settings[$key], true) ?? [];
                
                // Migrate legacy simple array to associative array for amenities
                if ($key === 'hotel_amenities' && !empty($decoded) && !is_array(reset($decoded))) {
                    $decoded = array_map(function($name) {
                        return ['name' => $name, 'icon' => 'heroicon-o-check-circle'];
                    }, $decoded);
                }
                
                $settings[$key] = $decoded;
            } else {
                $settings[$key] = [];
            }
        }
        
        
        $this->form->fill($settings);
    }

    public function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('General Metadata')
                    ->description('Define the global options for hotel properties and site content.')
                    ->components([
                        Repeater::make('hotel_types')
                            ->label('Property Types')
                            ->simple(TextInput::make('name')->required())
                            ->reorderableWithDragAndDrop()
                            ->addActionLabel('Add Property Type'),
                        Repeater::make('hotel_categories')
                            ->label('Categories (Stars / Pricing)')
                            ->simple(TextInput::make('name')->required())
                            ->reorderableWithDragAndDrop()
                            ->addActionLabel('Add Category'),
                    ])->columns(2),
                    
                \Filament\Schemas\Components\Section::make('Amenities & Features')
                    ->description('Options for property-level and room-level features.')
                    ->components([
                        Repeater::make('hotel_amenities')
                            ->label('Property Amenities')
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->columnSpan(2),
                                \Filament\Forms\Components\Select::make('icon')
                                    ->options(function () {
                                        $icons = [
                                            // Essentials & General
                                            'heroicon-o-wifi' => 'Free WiFi',
                                            'heroicon-o-bolt' => 'Air Conditioning (AC)',
                                            'heroicon-o-fire' => 'Heating / Fireplace',
                                            'heroicon-o-tv' => 'TV / Flat-screen TV',
                                            'heroicon-o-device-phone-mobile' => 'Telephone / Device',
                                            'heroicon-o-sparkles' => 'Daily Housekeeping / Clean',
                                            'heroicon-o-key' => 'Key Access / Key Card',
                                            'heroicon-o-lock-closed' => 'Safety Deposit Box',
                                            'heroicon-o-no-symbol' => 'Non-smoking Rooms',
                                            'heroicon-o-arrow-up-circle' => 'Elevator / Lift',

                                            // Bathroom
                                            'heroicon-o-beaker' => 'Free Toiletries',
                                            'heroicon-o-eye-dropper' => 'Hairdryer / Grooming',
                                            'heroicon-o-view-columns' => 'Bath or Shower',
                                            'heroicon-o-scissors' => 'Bathrobes / Slippers',

                                            // Food, Drink & Kitchen
                                            'heroicon-o-cake' => 'Restaurant / Breakfast',
                                            'heroicon-o-user' => 'Private Chef / Cook',
                                            'heroicon-o-shopping-bag' => 'Minibar / Grocery',
                                            'heroicon-o-archive-box' => 'Refrigerator / Kitchen',
                                            'heroicon-o-fire' => 'BBQ Facilities',

                                            // Outdoors & Views
                                            'heroicon-o-sun' => 'Balcony / Terrace / Beach',
                                            'heroicon-o-map' => 'City View / Landmark',
                                            'heroicon-o-globe-americas' => 'Mountain View / Nature',
                                            'heroicon-o-photo' => 'Lake View / Sea View',

                                            // Wellness & Pool
                                            'heroicon-o-heart' => 'Spa & Wellness Centre',
                                            'heroicon-o-face-smile' => 'Massage / Beauty',
                                            'heroicon-o-check-badge' => 'Swimming Pool',
                                            'heroicon-o-star' => 'Hot Tub / Jacuzzi',

                                            // Services & Parking
                                            'heroicon-o-truck' => 'Free Parking / Valet',
                                            'heroicon-o-map-pin' => 'Location / Tour Info',
                                            'heroicon-o-bell' => '24-hour Front Desk / Room Service',
                                            'heroicon-o-clock' => 'Express Check-in/out',
                                            'heroicon-o-briefcase' => 'Luggage Storage / Business',
                                            'heroicon-o-banknotes' => 'Currency Exchange',
                                            'heroicon-o-receipt-refund' => 'Laundry / Dry Cleaning',

                                            // Room Features
                                            'heroicon-o-home-modern' => 'Seating Area / Sofa',
                                            'heroicon-o-computer-desktop' => 'Desk / Workspace',
                                            'heroicon-o-archive-box-x-mark' => 'Wardrobe / Closet',
                                            'heroicon-o-speaker-x-mark' => 'Soundproofing',

                                            // Activities & Entertainment
                                            'heroicon-o-musical-note' => 'Evening Entertainment',
                                            'heroicon-o-ticket' => 'Tour Desk / Tickets',
                                            'heroicon-o-camera' => 'Activities / Local Culture',
                                            'heroicon-o-paper-airplane' => 'Airport Shuttle',
                                            'heroicon-o-user-group' => 'Kids Club / Family Rooms',
                                            
                                            // Security & Health
                                            'heroicon-o-shield-check' => '24-hour Security / CCTV',
                                            'heroicon-o-plus-circle' => 'First Aid / Medical',
                                            'heroicon-o-check-circle' => 'Verified / Standard (Default)',
                                        ];
                                        $options = [];
                                        foreach ($icons as $icon => $label) {
                                            try {
                                                $svg = svg($icon, ['style' => 'width: 20px; height: 20px; flex-shrink: 0; color: #6b7280;'])->toHtml();
                                                $options[$icon] = "<div style='display: flex; align-items: center; gap: 8px;'>{$svg} <span>{$label}</span></div>";
                                            } catch (\Exception $e) {
                                                $options[$icon] = $label;
                                            }
                                        }
                                        return $options;
                                    })
                                    ->searchable()
                                    ->allowHtml()
                                    ->required()
                                    ->default('heroicon-o-check-circle')
                                    ->columnSpan(2)
                            ])
                            ->columns(4)
                            ->reorderableWithDragAndDrop()
                            ->addActionLabel('Add Amenity'),
                        Repeater::make('hotel_features')
                            ->label('Room Features / Highlights')
                            ->simple(TextInput::make('name')->required())
                            ->reorderableWithDragAndDrop()
                            ->addActionLabel('Add Feature'),
                    ])->columns(2),
                    
                \Filament\Schemas\Components\Section::make('Room Types')
                    ->components([
                        Repeater::make('hotel_room_types')
                            ->label('Room Types')
                            ->simple(TextInput::make('name')->required())
                            ->reorderableWithDragAndDrop()
                            ->addActionLabel('Add Room Type'),
                    ]),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            // Encode arrays to JSON string before saving
            if (in_array($key, $this->arrayKeys)) {
                $value = json_encode($value ?: []);
            }
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Notification::make()
            ->title('Hotel configurations saved successfully')
            ->success()
            ->send();
    }
}
