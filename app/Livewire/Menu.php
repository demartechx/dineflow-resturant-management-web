<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\Category;

class Menu extends Component
{
    public $tableNumber;
    public $search = '';
    public $selectedCategory = null;

    public function mount()
    {
        $this->tableNumber = session('restaurant_table_number');
    }

    public function selectCategory($categoryId)
    {
        $this->selectedCategory = $categoryId === 'all' ? null : $categoryId;
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        $categories = Category::with([
            'products' => function ($query) {
                $query->where('is_active', true)
                    ->when($this->search, function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('description', 'like', '%' . $this->search . '%');
                    });
            }
        ])
            ->where('is_active', true)
            ->when($this->selectedCategory, function ($query) {
                $query->where('id', $this->selectedCategory);
            })
            ->whereHas('products', function ($query) {
                $query->where('is_active', true)
                    ->when($this->search, function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('description', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('sort_order')
            ->get();

        return view('livewire.menu', [
            'categories' => $categories
        ]);
    }
}
