<?php
/**
 * Created by PhpStorm.
 * User: akung
 * Date: 2/10/16
 * Time: 23:50
 */

namespace App\Http\Controllers\Privy;


use App\Models\Achievement;
use App\Models\AchievementValue;
use App\Models\Goal;
use Illuminate\Http\Request;

class QuarterDetailController extends AdminController
{
    public function edit(Request $request)
    {
        $goalId = $request->get('goal');
        $achievementId = $request->get('achievement');
        $quarter = $request->get('tw');

        $goal = Goal::with(['details' => function($query) {
            $query->with(['achievementValues']);
        }])->find($goalId);


        $details_array = [];
        foreach ($goal->details as $detail) {

            $d = [];

            $d['id'] = $detail->id;
            $d['goal_id'] = $detail->goal_id;
            $d['description'] = $detail->description;
            $d['action_plan'] = $detail->action_plan;
            $d['dipa'] = $detail->dipa;

            foreach ($detail->achievementValues as $value) {
                $d['achievement_value'][$value->quarter] = [
                    "id" => $value->id,
                    "achievement_id" => $value->achievement_id,
                    "goal_detail_id" => $value->goal_detail_id,
                    "fisik_plan" => $value->fisik_plan,
                    "budget_plan" => $value->budget_plan,
                    "fisik_real" => $value->fisik_real,
                    "budget_real" => $value->budget_real,
                    "quarter" => $value->quarter,
                ];
            }

            array_push($details_array, $d);
        }

        return view('private.quarter_detail.edit')
            ->with('documents', $details_array)
            ->with('quarter', $quarter)
            ->with('id', [
                'achievement' => $achievementId
            ]);
    }

    public function update(Request $request)
    {
        $name   = $request->get('name');
        $value  = $request->get('value');
        $field  = $request->get('field');
        $pk     = $request->get('pk');

        $achievementId = $request->get('achievement_id');
        $goalDetailId = $request->get('detail_id');

        if($request->get('pk') == 0) {
            $achievementValue =  AchievementValue::create([
                'achievement_id' => $achievementId,
                'goal_detail_id' => $goalDetailId,
                $field          => $value,
            ]);

            $this->calculateMean($achievementId);

            return $achievementValue;
        }
        else {

            $achievementValue = AchievementValue::find($pk);
            $achievementValue->{$field}    = $value;

            $achievementValue->save();

            $this->calculateMean($achievementValue->achievement_id);

            return $achievementValue;
        }

    }

    /**
     * @param $achievementId
     */
    private function calculateMean($achievementId)
    {
        $meanFisikPlan = AchievementValue::where('achievement_id', $achievementId)->avg('fisik_plan');
        $meanFisikReal = AchievementValue::where('achievement_id', $achievementId)->avg('fisik_real');


        $allAv = AchievementValue::with('goalDetail')->where('achievement_id', $achievementId)->get();

        $budgetPlanArray = [];
        $budgetRealArray = [];
        foreach ($allAv as $av) {
            $meanBudgetPlanAv = $av->budget_plan / $av->goalDetail->dipa * 100;
            if($av->budget_plan == 0)
                $meanBudgetRealAv = 0;
            else
                $meanBudgetRealAv = $av->budget_real / $av->budget_plan * $meanBudgetPlanAv;

            array_push($budgetPlanArray, $meanBudgetPlanAv);
            array_push($budgetRealArray, $meanBudgetRealAv);
        }

        // Mean in percentation
        $meanBudgetPlan = array_sum($budgetPlanArray) / count($budgetPlanArray);
        $meanBudgetReal = array_sum($budgetRealArray) / count($budgetRealArray);

        $achievement = Achievement::find($achievementId);
        $achievement->plan = $meanFisikPlan;
        $achievement->realization = $meanFisikReal;
        $achievement->budget_plan = $meanBudgetPlan;
        $achievement->budget_realization = $meanBudgetReal;
        $achievement->save();

    }
}