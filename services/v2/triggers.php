<?php

require_once("dbconnection.php");
require_once("returnData.php");
require_once("editors.php");

class triggers extends dbconnection
{	
    //Takes in game JSON, all fields optional except user_id + token
    public static function createTriggerJSON($glob)
    {
        $data = file_get_contents("php://input");
        $glob = json_decode($data);
        return games::createTrigger($glob);
    }

    public static function createTrigger($pack)
    {
        if(!editors::authenticateGameEditor($pack->game_id, $pack->auth->user_id, $pack->auth->token, "read_write"))
            return new returnData(6, NULL, "Failed Authentication");

        $triggerId = dbconnection::queryInsert(
            "INSERT INTO triggers (".
            "game_id,".
            ($pack->name                        ? "name,"                        : "").
            ($pack->instance_id                 ? "instance_id,"                 : "").
            ($pack->scene_id                    ? "scene_id,"                    : "").
            ($pack->requirement_root_package_id ? "requirement_root_package_id," : "").
            ($pack->type                        ? "type,"                        : "").
            ($pack->latitude                    ? "latitude,"                    : "").
            ($pack->longitude                   ? "longitude,"                   : "").
            ($pack->distance                    ? "distance,"                    : "").
            ($pack->wiggle                      ? "wiggle,"                      : "").
            ($pack->show_title                  ? "show_title,"                  : "").
            ($pack->code                        ? "code,"                        : "").
            "created".
            ") VALUES (".
            "'".$pack->game_id."',".
            ($pack->name                        ? "'".addslashes($pack->name)."',"                        : "").
            ($pack->instanc_id                  ? "'".addslashes($pack->instanc_id)."',"                  : "").
            ($pack->scene_id                    ? "'".addslashes($pack->scene_id)."',"                    : "").
            ($pack->requirement_root_package_id ? "'".addslashes($pack->requirement_root_package_id)."'," : "").
            ($pack->type                        ? "'".addslashes($pack->type)."',"                        : "").
            ($pack->latitude                    ? "'".addslashes($pack->latitude)."',"                    : "").
            ($pack->longitude                   ? "'".addslashes($pack->longitude)."',"                   : "").
            ($pack->distance                    ? "'".addslashes($pack->distance)."',"                    : "").
            ($pack->wiggle                      ? "'".addslashes($pack->wiggle)."',"                      : "").
            ($pack->show_title                  ? "'".addslashes($pack->show_title)."',"                  : "").
            ($pack->code                        ? "'".addslashes($pack->code)."',"                        : "").
            "CURRENT_TIMESTAMP".
            ")"
        );

        return triggers::getTrigger($triggerId);
    }

    //Takes in game JSON, all fields optional except user_id + token
    public static function updateTriggerJSON($glob)
    {
        $data = file_get_contents("php://input");
        $glob = json_decode($data);
        return games::updateTrigger($glob);
    }

    public static function updateTrigger($pack)
    {
        $gameId = dbconnection::queryObject("SELECT * FROM triggers WHERE trigger_id = '{$pack->trigger_id}'")->game_id;
        if(!editors::authenticateGameEditor($gameId, $pack->auth->user_id, $pack->auth->token, "read_write"))
            return new returnData(6, NULL, "Failed Authentication");

        $triggerId = dbconnection::queryInsert(
            "UPDATE triggers SET ".
            ($pack->name                        ? "name                        = '{$pack->name}', "                        : "").
            ($pack->instance_id                 ? "instance_id                 = '{$pack->instance_id}', "                 : "").
            ($pack->scene_id                    ? "scene_id                    = '{$pack->scene_id}', "                    : "").
            ($pack->requirement_root_package_id ? "requirement_root_package_id = '{$pack->requirement_root_package_id}', " : "").
            ($pack->type                        ? "type                        = '{$pack->type}', "                        : "").
            ($pack->latitude                    ? "latitude                    = '{$pack->latitude}', "                    : "").
            ($pack->longitude                   ? "longitude                   = '{$pack->longitude}', "                   : "").
            ($pack->distance                    ? "distance                    = '{$pack->distance}', "                    : "").
            ($pack->wiggle                      ? "wiggle                      = '{$pack->wiggle}', "                      : "").
            ($pack->show_title                  ? "show_title                  = '{$pack->show_title}', "                  : "").
            ($pack->code                        ? "code                        = '{$pack->code}', "                        : "").
            "last_active = CURRENT_TIMESTAMP ".
            "WHERE trigger_id = '{$pack->trigger_id}'".
        );

        return triggers::getTrigger($triggerId);
    }

    public static function getTrigger($triggerId)
    {
        $sql_trigger = dbconnection::queryObject("SELECT * FROM triggers WHERE trigger_id = '{$triggerId}' LIMIT 1");

        $trigger = new stdClass();
        $trigger->trigger_id                  = $sql_trigger->trigger_id;
        $trigger->game_id                     = $sql_trigger->game_id;
        $trigger->name                        = $sql_trigger->name;
        $trigger->instance_id                 = $sql_trigger->instance_id;
        $trigger->scene_id                    = $sql_trigger->scene_id;
        $trigger->requirement_root_package_id = $sql_trigger->requirement_root_package_id;
        $trigger->type                        = $sql_trigger->type;
        $trigger->latitude                    = $sql_trigger->latitude;
        $trigger->longitude                   = $sql_trigger->longitude;
        $trigger->distance                    = $sql_trigger->distance;
        $trigger->wiggle                      = $sql_trigger->wiggle;
        $trigger->show_title                  = $sql_trigger->show_title;
        $trigger->code                        = $sql_trigger->code;

        return new returnData(0,$trigger);
    }

    public static function deleteTrigger($triggerId, $userId, $token)
    {
        $gameId = dbconnection::queryObject("SELECT * FROM triggers WHERE trigger_id = '{$triggerId}'")->game_id;
        if(!editors::authenticateGameEditor($gameId, $userId, $token, "read_write")) return new returnData(6, NULL, "Failed Authentication");

        dbconnection::queryObject("DELETE FROM triggers WHERE trigger_id = '{$triggerId}' LIMIT 1");
    }
}
?>
