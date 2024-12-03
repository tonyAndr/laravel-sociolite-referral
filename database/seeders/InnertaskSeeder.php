<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InnertaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            [
                'id' => 1001,
                'service' => 'youtube',
                'description' => 'YouTube',
                'ppr' => 0
            ], 
            [
                'id' => 1002,
                'service' => 'tiktok',
                'description' => 'TikTok',
                'ppr' => 0
            ], 
            [
                'id' => 1003,
                'service' => 'rutube',
                'description' => 'RuTube',
                'ppr' => 0
            ]
        ];

        \App\Models\Product::factory()->createMany($data);     

        //
        $data = [
            [
                'buyer_id' => 472434718,
                'status' => 'active',
                'proof_type' => 'text',
                'description' => "Расскажи о сайте Luchbux.Fun на платформе ютуб, опубликуй видео и отправь нам ссылку. Награда зачисляется за просмотры - чем больше видео соберет просмотров, тем больше ты получишь робуксов!",
                'title' => 'Создай видео на YouTube',
                'requested' => 99999,
                'fullfilled' => 0,
                'price' => 0,
                'user_reward' => 0,
                'task_type' => 1,
                'ref_url' => '',
                'product_id' => 1001 // yt
            ], 
            [
                'buyer_id' => 472434718,
                'status' => 'active',
                'proof_type' => 'text',
                'description' => 'Расскажи о сайте Luchbux.Fun на платформе тикток, опубликуй видео и отправь нам ссылку. Награда зачисляется за просмотры - чем больше видео соберет просмотров, тем больше ты получишь робуксов! ',
                'title' => 'Создай видео на TikTok',
                'requested' => 99999,
                'fullfilled' => 0,
                'price' => 0,
                'user_reward' => 0,
                'task_type' => 1,
                'ref_url' => '',
                'product_id' => 1002 // tt
            ], 
            [
                'buyer_id' => 472434718,
                'status' => 'active',
                'proof_type' => 'text',
                'description' => 'Расскажи о сайте Luchbux.Fun на платформе рутуб, опубликуй видео и отправь нам ссылку. Награда зачисляется за просмотры - чем больше видео соберет просмотров, тем больше ты получишь робуксов! ',
                'title' => 'Создай видео на RuTube',
                'requested' => 99999,
                'fullfilled' => 0,
                'price' => 0,
                'user_reward' => 0,
                'task_type' => 1,
                'ref_url' => '',
                'product_id' => 1003 // rt
            ], 

        ];

        \App\Models\MasterTask::factory()->createMany($data);      
                
    }
}
