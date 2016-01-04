<?php
/**
 * User: Slice
 * Date: 22/08/15
 * Time: 23:58
 */

namespace App\Exceptions;


use Illuminate\Support\MessageBag;

class MultiMessageException extends \Exception{

    private $messages = null;

    public function __construct(MessageBag $messages = null){

        parent::__construct("An error occured");

        $this->messages = $messages;

        if(is_null($this->messages)){
            $this->messages = new MessageBag();
        }

    }

    public function getMessages(){
        return $this->messages;
    }

}