<?php

namespace Hanson\MyVbot;

use Hanson\MyVbot\Handlers\Contact\ColleagueGroup;
use Hanson\MyVbot\Handlers\Contact\ExperienceGroup;
use Hanson\MyVbot\Handlers\Contact\FeedbackGroup;
use Hanson\MyVbot\Handlers\Contact\Hanson;
use Hanson\MyVbot\Handlers\Type\RecallType;
use Hanson\MyVbot\Handlers\Type\TextType;
use Hanson\Vbot\Contact\Friends;
use Hanson\Vbot\Contact\Groups;
use Hanson\Vbot\Contact\Members;

use Hanson\Vbot\Message\Emoticon;
use Hanson\Vbot\Message\Text;
use Illuminate\Support\Collection;


class MessageHandler
{
    public static function messageHandler(Collection $message)
    {
        /** @var Friends $friends */
        $friends = vbot('friends');

        /** @var Members $members */
        $members = vbot('members');

        /** @var Groups $groups */
        $groups = vbot('groups');

        Hanson::messageHandler($message, $friends, $groups);
        ColleagueGroup::messageHandler($message, $friends, $groups);
        FeedbackGroup::messageHandler($message, $friends, $groups);
        ExperienceGroup::messageHandler($message, $friends, $groups);

        TextType::messageHandler($message, $friends, $groups);
        RecallType::messageHandler($message);

        if ($message['type'] === 'new_friend') {
            //通过好友请求后第一次发信息
            Text::send($message['from']['UserName'], '我已经是你的好友了');
            
        }

        if ($message['type'] === 'emoticon' && random_int(0, 1)) {
            Emoticon::sendRandom($message['from']['UserName']);
        }

        // @todo
        if ($message['type'] === 'official') {
            vbot('console')->log('收到公众号消息:'.$message['title'].$message['description'].
                $message['app'].$message['url']);
        }

        if ($message['type'] === 'request_friend') {
            vbot('console')->log('收到好友申请:'.$message['info']['Content'].$message['avatar']);           
                $friends->approve($message); //自动通过
            
        }
    }

    //一直触发
    public static function messageCustomHandler()
    {

        if(time()%3 == 0)
        {
            Text::send('filehelper', '我已经是你的好友了'.time());
        }
        
        
       
    }
}
