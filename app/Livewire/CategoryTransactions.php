<?php

namespace App\Livewire;

use Livewire\Component;
use \App\Models\M_CategoryTransactions;
use Livewire\Attributes\Validate;

class CategoryTransactions extends Component
{

    #[Validate("required")]
    public $category = "";

    #[Validate("required")]
    public $amount_target = "";

    public function render()
    {
        return view('livewire.category-transactions')->layout("Layout.root");
    }

    public function save_category()
    {
        return dd($this->validate());
        $this->validate();
        M_CategoryTransactions::create(
            $this->only(["category", "amount_target"])
        );
        // return $this->redirect("posts");
    }
}
