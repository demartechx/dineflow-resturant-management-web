<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2; // Display after stats

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()->where('status', 'pending')->latest()
            )
            ->heading('Pending Orders')
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('Order ID')->searchable(),
                Tables\Columns\TextColumn::make('restaurantTable.number')->label('Table'),
                Tables\Columns\TextColumn::make('total_amount')->money('NGN'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'preparing' => 'info',
                        'ready' => 'success',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')->since()->label('Placed'),
            ])
            ->actions([
                Tables\Actions\Action::make('Process')
                    ->url(fn(Order $record): string => route('filament.admin.resources.orders.edit', $record))
                    ->icon('heroicon-m-arrow-right')
                    ->button(),
            ]);
    }
}
