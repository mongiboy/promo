<?php

namespace App\Filament\Pages;

use App\Enums\PartnerNetwork;
use App\Services\OfferImportService;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Concerns\RestrictsFileUploadsToSchemaComponents;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;


class ImportOffers extends Page implements HasSchemas
{
    use InteractsWithSchemas;
    use RestrictsFileUploadsToSchemaComponents;

    protected string $view = 'filament.pages.import-offers';
    protected static ?string $title = 'Импорт офферов';
    protected static ?string $navigationLabel = 'Импорт офферов';
    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-arrow-up-tray';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Radio::make('partner_network')
                    ->hiddenLabel()
                    ->options(PartnerNetwork::class)
                    ->required(),

                FileUpload::make('file')
                    ->label('Выгрузка')
                    ->rules(['mimes:csv,txt'])
                    ->disk('local')
                    ->directory('imports')
                    ->required(),

                Actions::make([
                    Action::make('import')
                        ->label('Загрузить')
                        ->submit('import'),
                ]),
            ])
            ->statePath('data');
    }

    public function import(): void
    {
        $data = $this->form->getState();

        $count = app(OfferImportService::class)->importFromFile(
            $data['partner_network'],
            $data['file'],
        );

        Notification::make()
            ->title('Импорт завершён')
            ->body("Загружено офферов: {$count}")
            ->success()
            ->send();

    }
}
