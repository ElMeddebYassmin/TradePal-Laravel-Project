<?php



namespace App\Http\Controllers;



use App\Models\Donation;
use App\Models\Organization;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DonationsExport;
use App\Events\DonationMade;



class DonationController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $viewPath = 'BackOffice.donation.table';
        $donations = Donation::with('organization', 'donor', 'item')->simplePaginate(10);
        return view('BackOffice.template', compact('viewPath', 'donations'))

            ->with('i', (request()->input('page', 1) - 1) * 5);
    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        $viewPath = 'BackOffice.donation.forms';
        return view('BackOffice.template', compact('viewPath'));
    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        $donation = new Donation();
        $donation->user_id = auth()->user()->id;
        $donation->organization_id = $request->input('organization_id');
        $donation->amount = $request->input('amount');
        $donation->category = $request->input('category');
        if ($request->input('object') == 0) {
            unset($donation->item_id);
        } else {
            $donation->item_id = $request->input('object');
        }

        $donation->save();

        $item = Item::find($request->input('object'));
        if ($item) {
            $item->status = 'NONDISPONIBLE';
            $item->save();
        }

        $user = User::find(auth()->user()->id);
        if ($user) {
            $currentHazelnuts = $user->hazelnuts;
            $donated = $request->input('amount');
            $newHazelnuts = $currentHazelnuts - $donated;
            $user->hazelnuts = $newHazelnuts;
            $user->save();
        }
        event(new DonationMade($donation));

        return redirect()->route('organizations.show', ['id' => $donation->organization_id])

            ->with('success', 'Donation created successfully.');
    }



    /**

     * Display the specified resource.

     *

     * @param  \App\Models\Donation  $donation

     * @return \Illuminate\Http\Response

     */

    public function show(Donation $donation)

    {

        return view('donations.show', compact('donation'));
    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Models\Donation  $donation

     * @return \Illuminate\Http\Response

     */

    public function edit(Donation $donation)

    {

        $viewPath = 'BackOffice.donation.forms';

        return view('BackOffice.template', compact('donation', 'viewPath'));
    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Models\Donation  $donation

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, Donation $donation)

    {

        $request->validate([

            'user_id' => 'required',
            'category' => 'required',
            'timestamp' => 'required|date',
            'donation_id' => 'required',
            'amount' => 'required|numeric',
            'object' => 'required',

        ]);

        $donation->update($request->all());
        return redirect()->route('donations.index')

            ->with('success', 'Donation updated successfully');
    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Models\Donation  $donation

     * @return \Illuminate\Http\Response

     */

    public function destroy(Donation $donation)

    {

        $donation->delete();



        return redirect()->route('donations.index')

            ->with('success', 'Donation deleted successfully');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function export()
    {
        $organizations = Organization::all();
        return Excel::download(new DonationsExport($organizations), 'donations.xlsx');
    }
}
