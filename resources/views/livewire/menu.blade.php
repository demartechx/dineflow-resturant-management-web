<div>
    <!-- Hero / Header -->
    <div class="relative bg-gray-900 overflow-hidden pb-10 rounded-b-[3rem] shadow-2xl z-50">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-20">
            <svg class="h-full w-full text-gray-700" fill="currentColor" viewBox="0 0 100 100">
                <path d="M0 0h100v100H0z" fill="none"/>
                <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="2" fill="none" opacity="0.3"/>
                <circle cx="20" cy="20" r="10" fill="currentColor" opacity="0.5"/>
                <circle cx="80" cy="80" r="15" fill="currentColor" opacity="0.5"/>
            </svg>
        </div>
        <div class="absolute inset-x-0 top-0 h-full bg-gradient-to-br from-orange-600/90 to-red-600/90"></div>
        
        <div class="relative pt-8 px-6">
            <div class="flex justify-between items-start mb-8">
                <div>
                     <h1 class="text-3xl font-black text-white tracking-tight leading-tight drop-shadow-md">
                        Delicious<br>Food
                     </h1>
                     <div class="mt-2">
                        @if($tableNumber)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white/20 text-white backdrop-blur-md border border-white/10 shadow-sm">
                                Table {{ $tableNumber }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white/20 text-white backdrop-blur-md border border-white/10 shadow-sm">
                                Welcome
                            </span>
                        @endif
                     </div>
                </div>
                <div class="bg-white/10 p-3 rounded-2xl backdrop-blur-md border border-white/10 shadow-inner">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h-4v-4H8m13-4V7a1 1 0 00-1-1H4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
            </div>

            <!-- Search -->
            <div class="relative group mb-4">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-200 group-focus-within:text-orange-200 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" 
                    wire:model.live.debounce.300ms="search"
                    class="block w-full pl-11 pr-4 py-4 bg-white/10 border border-white/10 rounded-2xl text-white placeholder-gray-200 focus:outline-none focus:ring-2 focus:ring-white/30 focus:bg-white/20 transition-all shadow-inner backdrop-blur-sm sm:text-sm font-medium" 
                    placeholder="What are you craving?">
            </div>
        </div>
    </div>

    <!-- Sticky Category Nav -->
    <div class="sticky top-0 z-40 bg-gray-50/95 backdrop-blur-xl border-b border-gray-200/50 shadow-sm py-8 -mt-4">
        <div class="flex overflow-x-auto px-6 pb-1 space-x-3 no-scrollbar hide-scrollbar snap-x">
             <button 
                wire:click="selectCategory('all')"
                class="snap-start flex-shrink-0 px-6 py-2.5 rounded-2xl text-sm font-bold transition-all transform hover:scale-105 {{ is_null($selectedCategory) ? 'bg-orange-600 text-white shadow-lg shadow-orange-600/30' : 'bg-white text-gray-600 border border-gray-100 hover:bg-orange-50 hover:text-orange-600 hover:border-orange-100 shadow-sm' }}">
                All
            </button>
            @foreach(\App\Models\Category::where('is_active', true)->orderBy('sort_order')->get() as $navCategory)
                @if($navCategory->products()->where('is_active', true)->exists())
                    <button 
                        wire:click="selectCategory({{ $navCategory->id }})"
                        class="snap-start flex-shrink-0 px-6 py-2.5 rounded-2xl text-sm font-bold transition-all transform hover:scale-105 whitespace-nowrap {{ $selectedCategory == $navCategory->id ? 'bg-orange-600 text-white shadow-lg shadow-orange-600/30' : 'bg-white text-gray-600 border border-gray-100 hover:bg-orange-50 hover:text-orange-600 hover:border-orange-100 shadow-sm' }}">
                        {{ $navCategory->name }}
                    </button>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Product Grid -->
    <div class="px-4 pb-32 pt-6 space-y-10 bg-gray-50 min-h-screen">
        @foreach($categories as $category)
            @if($category->products->isNotEmpty())
                <div id="category-{{ $category->id }}">
                    <div class="flex items-center justify-between mb-5 px-2">
                        <h2 class="text-2xl font-black text-gray-800">{{ $category->name }}</h2>
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            {{ $category->products->count() }} items
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-6">
                        @foreach($category->products as $product)
                            <!-- Deep Card Design -->
                            <div class="group bg-white rounded-3xl p-3 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 relative overflow-hidden">
                                <div class="flex space-x-4">
                                    <!-- Image Container -->
                                    <div class="w-28 h-28 flex-shrink-0 relative rounded-2xl overflow-hidden shadow-md group-hover:shadow-lg transition-shadow">
                                        @if($product->image)
                                            <img class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500" 
                                                src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}" 
                                                alt="{{ $product->name }}">
                                        @else
                                            <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-300">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Content -->
                                    <div class="flex-1 flex flex-col justify-between py-1">
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900 leading-tight group-hover:text-orange-600 transition-colors">{{ $product->name }}</h3>
                                            <p class="text-xs text-gray-500 mt-1.5 line-clamp-2 leading-relaxed">{{ $product->description }}</p>
                                        </div>
                                        <div class="flex justify-between items-center mt-3">
                                            <span class="text-lg font-black text-gray-900">₦{{ number_format($product->price, 2) }}</span>
                                            <button 
                                                wire:click="$dispatch('addToCart', { productId: {{ $product->id }} })"
                                                class="w-10 h-10 bg-gray-900 text-white rounded-full flex items-center justify-center hover:bg-orange-600 transition-colors shadow-lg active:scale-95 transform"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    
    <livewire:cart />

    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</div>