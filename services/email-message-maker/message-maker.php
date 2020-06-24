<?php

namespace services\email_message_maker;

class MessageMaker
{
    private $template;
    private $content;

    public function __construct($template, $content)
    {
        $this->template = $template;
        $this->content = $content;
    }
    public function make()
    {
        $page =  str_ireplace('__mailBody__', $this->content, $this->template);
        return $page;
    }

}
