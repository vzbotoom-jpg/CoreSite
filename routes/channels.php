<?php
// routes/channels.php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
*/

// Admin channel for store notifications
Broadcast::channel('store.{storeId}', function ($user, $storeId) {
    return (int) $user->store_id === (int) $storeId;
});

// User specific channel
Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

// Product updates channel
Broadcast::channel('product.{productId}', function ($user, $productId) {
    $product = \App\Models\Product::find($productId);
    return $product && $user->store_id === $product->store_id;
});

// Transaction updates channel
Broadcast::channel('transaction.{storeId}', function ($user, $storeId) {
    return (int) $user->store_id === (int) $storeId;
});

// Inventory alerts channel
Broadcast::channel('inventory.{storeId}', function ($user, $storeId) {
    return (int) $user->store_id === (int) $storeId && $user->role === 'admin';
});

// Order updates channel (for store owner)
Broadcast::channel('order.{storeId}', function ($user, $storeId) {
    return (int) $user->store_id === (int) $storeId && $user->role === 'admin';
});

// System notifications channel (for developer)
Broadcast::channel('system', function ($user) {
    return $user->hasRole('developer') ?? false;
});

// Dashboard channel for real-time updates
Broadcast::channel('dashboard.{storeId}', function ($user, $storeId) {
    return (int) $user->store_id === (int) $storeId;
});

// Chat channel (if implementing chat feature)
Broadcast::channel('chat.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});