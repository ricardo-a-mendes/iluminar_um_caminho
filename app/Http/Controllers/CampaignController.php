<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignRequest;
use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ends_at = new Carbon();
        $campaigns = Campaign::where('ends_at', '>=', $ends_at->format('Y-m-d'))->get();

        $success = null;
        if (session()->has('success')) {
            $success = session('success');
        }

        return view('campaign/campaign_index', compact('campaigns', 'success'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $campaign = new Campaign();

        return view('campaign/campaign_form_store', compact('campaign'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CampaignRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CampaignRequest $request)
    {
        $campaign = new Campaign();
        $campaign->name = $request->post('name');
        $campaign->description = $request->post('description');
        $campaign->starts_at = $request->post('starts_at');
        $campaign->ends_at = $request->post('ends_at');
        $campaign->suggested_donation = $this->formatNumber($request->post('suggested_donation'));
        $campaign->target_amount = $this->formatNumber($request->post('target_amount'));
        $campaign->created_by = Auth::id();
        $campaign->save();

        $request->session()->flash('success', 'Campanha criada com sucesso!');

        return redirect()->route('campaign.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function edit($id)
    {
        $campaign = Campaign::find($id);

        if (!$campaign) {
            throw new \Exception('Campanha não localizada');
        }

        return view('campaign/campaign_form_update', compact('campaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CampaignRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CampaignRequest $request, $id)
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::find($id);
        $campaign->name = $request->post('name');
        $campaign->description = $request->post('description');
        $campaign->starts_at = $request->post('starts_at');
        $campaign->ends_at = $request->post('ends_at');
        $campaign->suggested_donation = $this->formatNumber($request->post('suggested_donation'));
        $campaign->target_amount = $this->formatNumber($request->post('target_amount'));
        $campaign->updated_by = Auth::id();

        $campaign->save();

        return redirect()->route('campaign.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect()->route('campaign.index');
    }

    /**
     * Format a number to save on DB
     *
     * @param string $number
     * @return string
     */
    private function formatNumber(string $number): string
    {
        $number = str_replace('.', '', $number);
        $number = str_replace(',', '.', $number);
        return number_format($number, 2, '.',  '');
    }
}
