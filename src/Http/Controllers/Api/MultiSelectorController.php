<?php

namespace Kostasmatrix\MultiSelector\Http\Controllers\Api;

use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\CardRequest;
use App\Models\Contact;
use App\Models\Touchpoint;
use App\Models\GiftType;

class MultiSelectorController
{

    public function update(Request $request)
    {

        $resourceId = $request->input('resourceId');
        $journey = json_decode($request->input('journey'), true);

        if($request->input('resource') == 'touchpoints') {
            $touchpoint = Touchpoint::find($resourceId);
            $touchpoint->journey = $journey;
            $touchpoint->save();
    
            // Retrieve
            $contact = $touchpoint->contact;
            $currentTouchpointJourney = $touchpoint->journeyArray;
            $currentContactJourney = $contact->journeyArray;
            $updatedJourney = array_unique(array_merge($currentTouchpointJourney, $currentContactJourney ?? []));
    
            $contact->journey = $updatedJourney;
            $contact->save();
    
            return response()->json(['message' => 'Updated successfully']);
        }
        if($request->input('resource') == 'contacts') {
            dump("The resource id is: ");
            dump($resourceId);
            $contact = Contact::find($resourceId);
            dump("The full contact is: ");
            $contact->journey = $journey;
            $contact->save();
        }
        
        // Get the data from the request
        



        dump("The dumped journey is: ");
        dump($journey);

        // Update the database (replace 'Touchpoint' with your actual model)
       
    }


    public function comeGetMe(Request $request)
    {

    

    $contacts = Contact::with(['gifts.giftType', 'gifts.shortUrl'])
        ->whereHas('gifts')
        ->get()
        ->each(function ($contact) {
            $contact->gifts->each(function ($gift) {
                $gift->visits_count = $gift->shortUrl ? $gift->shortUrl->visits->count() : 0;
            });
        });

    $giftTypes = GiftType::all();

    return response()->json([
        'contacts' => $contacts,
        'giftTypes' => $giftTypes,
    ]);
}

    public function createTouchpoint(Request $request)
{

    dump("The requester isa...");
    dump($request);
    /*$request->validate([
        'contact_id' => 'required|integer|exists:contacts,id',
        'category' => 'required|string',
        'date' => 'required|date',
    ]);*/

    $contact = Contact::find($request->contact_id);
    dump("I got a contact hit me");

    dump("Date we getting is: ");
    dump($request->date);

    $touchpoint = new Touchpoint();

    // Set the properties of the model
    $touchpoint->date = $request->date;
    $touchpoint->notes = $request->category;
    $touchpoint->air_contact_id = $contact->air_id;
    
    /*$touchpoint = new Touchpoint([
        'date' => $request->date,
        'notes' => $request->category,
        'contact_air_id' => $contact->air_id
    ]);*/

    $touchpoint->save();

    dump("Are we in the game still?");

    return response()->json([
        'message' => 'Touchpoint created successfully',
        'touchpoint' => $touchpoint,
    ]);
}
}