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
                if (!in_array($pr->id, [1001, 1002, 1003, 1004, 1005])) {
                    $options[] = [['text' => $pr->description , 'callback_data' => 'referral_service_'.$pr->id]];
                }
            }
            $keyboard = new InlineKeyboard(...$options);
    
            $keyboard->setResizeKeyboard(true)
                ->setOneTimeKeyboard(true)
                ->setSelective(false);
    
            
            $data['text'] = 'Наш арсенал';
        }

        if( strpos($callback_data, 'referral_service_') !== false) {
            $product_id = explode('_', $callback_data)[2];
            $product = Product::find(intval($product_id));

            $options = [];
            $variants = [1,3,5,10,20,30,50];
            foreach ($variants as $k => $v) {
                $options[] = [['text' => $v . ' рефералов = ⭐️' . $v*$product->ppr, 'callback_data' => 'referral_amount_'.$product_id . '_' . $v]];
            }

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
