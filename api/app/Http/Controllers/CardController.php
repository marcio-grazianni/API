<?php

namespace App\Http\Controllers;

use App\Http\Requests\BulkCardUpdateRequest;
use App\Http\Requests\StoreCardRequest;
use App\Http\Requests\UpdateCardRequest;
use App\Models\AccessToken;
use App\Models\Card;
use Carbon\Carbon;
use Illuminate\Http\Response;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $userAccessToken = request('access_token');
        $accessToken = AccessToken::first()->token ?? null;
        if ($userAccessToken != $accessToken) {
            return \response('Unauthenticated', 401);
        }
        $cards = Card::query();
        if (request()->filled('date')) {
            $date = request('date');
            $date = Carbon::createFromFormat('Y-m-d', $date);
            $cards->whereDate('created_at', $date);
        }
        return response($cards->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCardRequest $request
     * @return Response
     */
    public function store(StoreCardRequest $request): Response
    {
        $card = Card::create($request->validated());
        return response($card);
    }

    /**
     * Display the specified resource.
     *
     * @param Card $card
     * @return Response
     */
    public function show(Card $card): Response
    {
        return response($card);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCardRequest $request
     * @param Card $card
     * @return Response
     */
    public function update(UpdateCardRequest $request, Card $card)
    {
        $card->update($request->validated());
        return response($card);
    }

    public function bulkUpdate(BulkCardUpdateRequest $request): Response
    {
        $cards = $request->validated()['cards'];
        foreach ($cards as $card) {
            Card::findOrFail($card['id'])->update($card);
        }
        return \response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Card $card
     * @return Response
     */
    public function destroy(Card $card): Response
    {
        $card->delete();
        return response()->noContent();
    }
}
