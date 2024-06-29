<?php

namespace App\Forms\Components;

use App\Models\Store;
use Filament\Forms\Components\Field;

class Review extends Field
{
    protected string $view = 'forms.components.review';
    protected Store $store;
    protected array $reviews;

    protected function setUp(): void
    {
        parent::setUp();
        // dd($this->view);
    }
    public function Getstore($store)
    {
        $this->store = $store;
        // dd($this->store);
        return $this;
    }



    public $data;
}
