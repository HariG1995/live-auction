<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Bid;

class BidderController extends Controller
{
    public function index(){
        return view('bidder/index');
    }

    public function liveAuction(){
        $now = Carbon::now();

        $products = Product::where('start_date', '<=', $now)
                                ->where('end_date', '>', $now)
                                ->where('status', 'active')
                                ->get();

        return response()->json($products);
    }

    public function liveAuctionDetails($id){
        $product = Product::findOrFail($id);

        $now = Carbon::now();
        $isActive = $product->status === 'active' && $product->start_date <= $now && $product->end_date > $now;

        $highestBid = Bid::where('product_id', $id)->orderByDesc('amount')->first();
        $currentBid = $highestBid ? $highestBid->amount : $product->base_price;
        return view('bidder/bid_details', compact('product', 'currentBid', 'isActive'));
    }

    public function createBid(Request $request){
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'bid_price' => 'required|numeric|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $now = Carbon::now();

        if (($product->status != 'active') || $now->lt($product->start_date) || $now->gt($product->end_date)) {
            return response()->json(['status' => 'failed', 'message' => 'Bidding time has expired or not started yet.'], 403);
        }

        $existingBid = Bid::where('user_id', auth()->id())
                                ->where('product_id', $product->id)
                                ->where('amount', $request->bid_price)
                                ->first();

        if($existingBid){
            return response()->json(['status' => 'failed', 'message' => 'You have already placed this bid amount for this product.'], 403);
        }

        $otherUserBid = Bid::where('user_id', '!=', auth()->id())
                       ->where('product_id', $product->id)
                       ->where('amount', $request->bid_price)
                       ->first();

        if($otherUserBid){
            return response()->json(['status' => 'failed', 'message' => 'This bid amount has already been placed by another user. Try a different amount.'], 403);
        }

        Bid::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'amount' => $request->bid_price,
        ]);

        return response()->json(['status' => 'success'], 200);
    }

    public function checkOtherBid(Request $request){
        $bidPrice = $request->bid_price;
        $prodID = $request->product_id;

        $otherBid = Bid::where('user_id', '!=', auth()->id())
                            ->where('product_id', $prodID)
                            ->where('amount', '>', $bidPrice)
                            ->orderBy('amount', 'desc')
                            ->first();

        if($otherBid){
            return response()->json(['status' => 'success', 'amount' => $otherBid->amount], 200);
        }else{
            return response()->json(['status' => 'failed'], 200);
        }
    }

    public function completeBid(Request $request){
        $prodtID = $request->product_id;

        $highestBid = Bid::where('product_id', $prodtID)
                        ->orderByDesc('amount')
                        ->first();

        if($highestBid){
            $product = Product::findOrFail($prodtID);

            $product->update([
                'bid_price' => $highestBid->amount,
                'highest_bidder_id' => $highestBid->user_id,
                'status' => 'closed'
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Bid closed successfully!'
            ], 201);
        }
    }

    public function myBids(){
        $userId = Auth::id();

        $bids = Product::whereNotNull('bid_price')
                                ->where('highest_bidder_id', $userId)
                                ->where('status', 'closed')
                                ->with('highestBidder')
                                ->get();
            
        return view('bidder/my_bids', compact('bids'));
    }
}
