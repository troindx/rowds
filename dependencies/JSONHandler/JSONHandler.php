<?php

class JSONResponseData{
    public $msg = null;
    public $value = 1;
    public $errors = null;
    public function __construct($value = 1, $msg = null)
    {
        $this->msg = $msg;
        $this->value = $value;
    }
}

class JSONHandler 
{

    protected static $_messages = array(
        JSON_ERROR_NONE => 'No error has occurred',
        JSON_ERROR_DEPTH => 'The maximum stack depth has been exceeded',
        JSON_ERROR_STATE_MISMATCH => 'Invalid or malformed JSON',
        JSON_ERROR_CTRL_CHAR => 'Control character error, possibly incorrectly encoded',
        JSON_ERROR_SYNTAX => 'Syntax error',
        JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded'
    );
    
    public static function sendResponse($value=1, $msg = null, $options = 0) 
    {
        global $ErrorModule;

        $result = new JSONResponseData($value, $msg);
        if(!$result)
        {
            throw new RuntimeException(static::$_messages[json_last_error()]);
        }
        else if ($ErrorModule->hasErrors())
        {
            $ErrorModule->printErrors();
            die(11);
        }
        else
        {
            $result->errors = error_get_last();
            echo json_encode($result, $options);
        }
 
    }
 
    public static function getResponse($json, $assoc = false) {
        $result = json_decode($json, $assoc);
 
        if($result) 
        {
            return $result;
        }
        else
        {
            throw new RuntimeException(static::$_messages[json_last_error()]);
        }
    }

    /*
     * Coding standards: Value is set to 1 and msg to null in order to indicate that everything went OK
     * invoking sendOk() does like sendResponse() without parameters.
     * Values and MSG can be set through the other methods to be used for something else.
     */
    public static function sendOK()
    {
        global $ErrorModule;
        $result = new JSONResponseData(1, null);
        if(!$result)
        {
            throw new RuntimeException(static::$_messages[json_last_error()]);
        }
        else if ($ErrorModule->hasErrors())
        {
            $ErrorModule->printErrors();
            die(11);
        }
        else
        {
            $result->errors = error_get_last();
            echo json_encode($result, 0);
        }
    }

    public static function sendFail($msg)
    {
        global $ErrorModule;
        $result = new JSONResponseData(0, $msg);
        if(!$result)
        {
            throw new RuntimeException(static::$_messages[json_last_error()]);
        }
        else if ($ErrorModule->hasErrors())
        {
            $ErrorModule->printErrors();
            die(11);
        }
        else
        {
            $result->errors = error_get_last();
            echo json_encode($result, 0);
        }
    }

 
}
?>