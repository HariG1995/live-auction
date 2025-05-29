<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BidderController;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin-home');

    Route::get('admin/products', [AdminController::class, 'productsList'])->name('view_products');
    Route::get('admin/add-product', [AdminController::class, 'addProduct'])->name('add_products');
    Route::post('admin/create-product', [AdminController::class, 'createProduct'])->name('create_products');
    Route::get('admin/edit-product/{id}', [AdminController::class, 'editProduct'])->name('edit_products');
    Route::put('admin/update-product/{id}', [AdminController::class, 'updateProduct'])->name('update_products');
    Route::delete('admin/delete-product', [AdminController::class, 'deleteProduct'])->name('delete_product');
    Route::put('admin/product-status-update', [AdminController::class, 'updateProductStatus'])->name('update_product_status');

    Route::get('admin/completed-bid', [AdminController::class, 'completedBidList'])->name('completed_bids');

    Route::get('admin/chat-contacts', [ChatController::class, 'getContacts']);
    Route::get('admin/chat-messages/{contact}', [ChatController::class, 'getMessages']);
    Route::post('admin/chat-send', [ChatController::class, 'sendMessage']);
});

//BIDDER SECTION
Route::get('/', [BidderController::class, 'index'])->name('bidder-home');
Route::get('live-auction', [BidderController::class, 'liveAuction'])->name('live_auction');
Route::get('live-auction-details/{id}', [BidderController::class, 'liveAuctionDetails'])->name('live_auction_details');
Route::post('complete-bid', [BidderController::class, 'completeBid'])->name('complete_bid');

Route::middleware(['auth', 'role:bidder'])->group(function () {
    Route::post('add-bid', [BidderController::class, 'createBid'])->name('create_bid');
    Route::get('check_other_bid', [BidderController::class, 'checkOtherBid'])->name('check_other_bid');
    Route::get('my-bid', [BidderController::class, 'myBids'])->name('my_bids');
});

//CHAT SECTION
Route::middleware('auth')->group(function () {
    Route::get('chat-contacts', [ChatController::class, 'getContacts']);
    Route::get('chat-messages/{contact}', [ChatController::class, 'getMessages']);
    Route::post('chat-send', [ChatController::class, 'sendMessage']);
    Route::post('chat-messages/{message}/read', [ChatController::class, 'markAsRead'])->name('chat.mark-read');
    Route::post('chat-messages/mark-read', [ChatController::class, 'markMultipleAsRead'])->name('chat.mark-multiple-read');
});

require __DIR__.'/auth.php';
