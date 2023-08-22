<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppealTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $appeals = [
            ['title' => 'Частично досрочное погашение', 'view_template_name' => 'partial_early_repayment'],
            ['title' =>'Полный досрочный выкуп', 'view_template_name' => 'full_early_redemption'],
            ['title' =>'Полный досрочный выкуп со списанием пени в размере 90%', 'view_template_name' => 'full_early_redemption_with_penalty'],
            ['title' =>'Частично досрочное погашение за счет ЕПВ', 'view_template_name' => 'partial_early_repayment'],
            ['title' =>'Полный досрочный выкуп за счет ЕПВ', 'view_template_name' => 'full_early_redemption_at_the_expense'],
            ['title' =>'Справка о всех поступивших платежах', 'view_template_name' => 'information_about_all_recieved_payments'],
            ['title' =>'Согласие на передачу в субаренду', 'view_template_name' => 'consent_to_sublease'],
            ['title' =>'Согласие на постоянную прописку', 'view_template_name' => 'consent_to_permanent_residence'],
            ['title' =>'Расторжение договора', 'view_template_name' => 'termination_of_an_agreement'],
        ];

        foreach ($appeals as $appeal) {
            DB::table('appeal_templates')->insert([
                'title' => $appeal['title'],
                'view_template_name' => $appeal['view_template_name']
            ]);
        }
    }
}
