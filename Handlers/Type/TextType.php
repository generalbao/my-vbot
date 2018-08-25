<?php

namespace Hanson\MyVbot\Handlers\Type;

use Carbon\Carbon;
use Hanson\Vbot\Contact\Friends;
use Hanson\Vbot\Contact\Groups;
use Hanson\Vbot\Message\Text;
use Hanson\Vbot\Support\File;
use Illuminate\Support\Collection;

class TextType
{
    public static function messageHandler(Collection $message, Friends $friends, Groups $groups)
    {
        if ($message['type'] === 'text') {
        	Text::send($message['from']['UserName'], time());
                       
        }
    }
}
