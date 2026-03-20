<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MatchRuleWeight;
use Illuminate\Http\Request;

class MatchRuleController extends Controller
{
    public function index()
    {
        $rules = MatchRuleWeight::orderBy('id')->get();
        $total = $rules->where('is_active', true)->sum('weight');

        return view('admin.job_listings.match_rules', compact('rules', 'total'));
    }

    public function update(Request $request, $id)
    {
        $rule = MatchRuleWeight::findOrFail($id);

        $request->validate([
            'weight' => 'required|numeric|min:0|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        $rule->weight = $request->weight;
        $rule->is_active = $request->boolean('is_active', true);
        $rule->updated_by = auth()->id();
        $rule->save();

        // Check total
        $total = MatchRuleWeight::active()->sum('weight');
        if (abs($total - 100) > 0.5) {
            flash("Uyarı: Aktif kural ağırlıklarının toplamı {$total}%. İdeal olarak 100% olmalı.")->warning();
        } else {
            flash("Kural güncellendi. Toplam: {$total}%")->success();
        }

        return back();
    }

    public function reset()
    {
        $defaults = [
            'location' => 20,
            'category' => 20,
            'experience' => 15,
            'work_hours' => 15,
            'salary' => 10,
            'certificate' => 10,
            'profile_completeness' => 10,
        ];

        foreach ($defaults as $key => $weight) {
            MatchRuleWeight::where('rule_key', $key)->update([
                'weight' => $weight,
                'is_active' => true,
                'updated_by' => auth()->id(),
            ]);
        }

        flash('Kural ağırlıkları varsayılan değerlere sıfırlandı.')->success();
        return back();
    }
}
