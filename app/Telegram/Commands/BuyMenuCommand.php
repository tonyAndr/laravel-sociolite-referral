<?php


namespace App\Telegram\Commands;


use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Request;
use App\Models\Product;

class BuyMenuCommand extends UserCommand
{

    /** @var string Command name */
    protected $name = 'buymenu';
    /** @var string Command description */
    protected $description = '';
    /** @var string Usage description */
    protected $usage = '/buymenu';
    /** @var string Version */
    protected $version = '1.0.0';

    public function execute(): ServerResponse
    {

        $callback_query = $this->getCallbackQuery();
        $callback_data  = $callback_query->getData();

        $chat_id = $callback_query->getMessage()->getChat()->getId();
        $data = [];
        $data['chat_id'] = $chat_id;
        $keyboard = false;

        
        if (strpos($callback_data, 'command_buy') !== false) {
            $products = Product::all();
            foreach ($products as $key => $pr) {
                # code...
                $options[] = [['text' => $pr->description , 'callback_data' => 'referral_service_'.$pr->id]];
            }
            $keyboard = new InlineKeyboard(...$options);
    
            $keyboard->setResizeKeyboard(true)
                ->setOneTimeKeyboard(true)
                ->setSelective(false);
    
            
            $data['text'] = 'Наш арсенал';
        }

        if( strpos($callback_data, 'referral_service_') !== false) {
            $product_id = explode('_', $callback_data)[2];
            $options = [];
            $options[] = [['text' => 1 . ' реферал' , 'callback_data' => 'referral_amount_'.$product_id . '_1']];
            $options[] = [['text' => 3 . ' реферал' , 'callback_data' => 'referral_amount_'.$product_id . '_3']];
            $options[] = [['text' => 5 . ' реферал' , 'callback_data' => 'referral_amount_'.$product_id . '_5']];
            $options[] = [['text' => 10 . ' реферал' , 'callback_data' => 'referral_amount_'.$product_id . '_10']];
            $options[] = [['text' => 20 . ' реферал' , 'callback_data' => 'referral_amount_'.$product_id . '_20']];
            $options[] = [['text' => 30 . ' реферал' , 'callback_data' => 'referral_amount_'.$product_id . '_30']];
            $options[] = [['text' => 50 . ' реферал' , 'callback_data' => 'referral_amount_'.$product_id . '_50']];

            $keyboard = new InlineKeyboard(...$options);
    
            $keyboard->setResizeKeyboard(true)
                ->setOneTimeKeyboard(true)
                ->setSelective(false);
    
            $data['text'] = 'Выбери калибр';
        }

        $data['reply_markup'] = $keyboard;

        return Request::sendMessage($data);

    }

}
