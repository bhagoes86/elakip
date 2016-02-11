<?php
/**
 * Created by PhpStorm.
 * User: akung
 * Date: 2/10/16
 * Time: 23:50
 */

namespace App\Http\Controllers\Privy;


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

            foreach ($detail->achievementValues as $value) {
                $d['achievement_value'][$value->quarter] = [
                    "id" => $value->id,
                    "achievement_id" => $value->achievement_id,
                    "goal_detail_id" => $value->goal_detail_id,
                    "fisik_plan" => $value->fisik_plan,
                    "budget_plan" => $value->budget_plan,
                    "fisik_real" => $value->fisik_real,
                    "budget_real" => $value->budget_real,
                    "dipa" => $value->dipa,
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
            return AchievementValue::create([
                'achievement_id' => $achievementId,
                'goal_detail_id' => $goalDetailId,
                $field          => $value,
            ]);
        }
        else {

            $achievementValue = AchievementValue::find($pk);
            $achievementValue->{$field}    = $value;

            $achievementValue->save();

            return $achievementValue;
        }

    }
}