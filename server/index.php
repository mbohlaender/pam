<?php
/**
 *
 * @file
 * @version 0.1
 * @copyright 2012 CN-Consult GmbH
 * @author Marcel Bohländer <marcel.bohlaender@cn-consult.eu>
 */

require_once("propel/Propel.php");
Propel::init(__DIR__."/build/conf/pam-conf.php");
set_include_path(__DIR__."/build/classes" . PATH_SEPARATOR . get_include_path());


if (($stream = fopen('php://input', "r")) !== FALSE)
{
	$input = stream_get_contents($stream);
	$request = json_decode($input);

    if ($request->requestType == "login")
    { // login
        //prepare respond message
        $respond = new stdClass();
        $respond->respondType = "login";

        if (isset($request->username) && isset($request->password) && isset($request->timestamp))
        {
            if ($request->timestamp+20 > date("U"))
            { // request not older as 20 seconds
                $user = UserQuery::create()->filterByName($request->username)->filterByPassword($request->password)->findOne();
                if ($user)
                { // successfully logged in
                    $respond->success = true;
                    file_put_contents(__DIR__."/logs/request.log",date("Y-m-d H:i:s")." SUCCESSFULLY LOGGED IN!.\n",FILE_APPEND);
                    echo json_encode($respond);
                }
                else
                { //login failed because of wrong username or invalid password
                    $respond->success = false;
                    $respond->error = "Invalid username or password.";
                    file_put_contents(__DIR__."/logs/request.log",date("Y-m-d H:i:s")." LOGIN FAILED, invalid username $request->username or password $request->password !.\n",FILE_APPEND);
                    echo json_encode($respond);
                }
            }
            else
            { // request to old
                $respond->success = false;
                $respond->error = "Request is older than 20 seconds, please retry.";
                file_put_contents(__DIR__."/logs/request.log",date("Y-m-d H:i:s")." LOGIN FAILED, request is too old, request time:\"".date("Y-m-d H:i:s",$request->timestamp)."\" !.\n",FILE_APPEND);
                echo json_encode($respond);
            }
        }
        else
        { // not all needed params are set
            $respond->success = false;
            $respond->error = "Invalid request";
            file_put_contents(__DIR__."/logs/request.log",date("Y-m-d H:i:s")." LOGIN FAILED, params username, password or timestamp are missing.\n",FILE_APPEND);
            echo json_encode($respond);
        }
    }
    else if ($request->requestType == "notes")
    { // get notes
        //prepare respond message
        $respond = new stdClass();
        $respond->respondType = "notes";
        $respond->notes = array();
        if (isset($request->username) && isset($request->password) && isset($request->timestamp))
        {
            if ($request->timestamp+20 > date("U"))
            { // request not older as 20 seconds
                $user = UserQuery::create()->filterByName($request->username)->filterByPassword($request->password)->findOne();
                if ($user)
                { // successfully logged in
                    file_put_contents(__DIR__."/logs/request.log",date("Y-m-d H:i:s")." GET NOTES SUCCESS, user found!.\n",FILE_APPEND);
                    $notes = NoteQuery::create()->filterByUserId($user->getId())->find();
                    if ($notes)
                    { // user found
                        foreach ($notes as $note)
                        { /** @var $note Note */
                            $loadedNote = new stdClass();
                            $loadedNote->id = $note->getId();
                            $loadedNote->title = $note->getTitle();
                            $loadedNote->content = $note->getContent();
                            $loadedNote->createdAt = $note->getCreatedAt();
                            $loadedNote->validTo = $note->getValidTo();
                            $loadedNote->category = $note->getCategory();
                            $respond->notes[] = $loadedNote;
                        }
                        file_put_contents(__DIR__."/logs/request.log",date("Y-m-d H:i:s")." GET NOTES SUCCESS, ".count($notes)." notes found!.\n",FILE_APPEND);
                        echo json_encode($respond);
                    }
                    else
                    { // no notes found for user
                        file_put_contents(__DIR__."/logs/request.log",date("Y-m-d H:i:s")." GET NOTES INFO, 0 notes found!.\n",FILE_APPEND);
                        echo json_encode($respond);
                    }
                }
                else
                { //no user found for this username and password
                    $respond->success = false;
                    $respond->error = "Invalid username or password.";
                    file_put_contents(__DIR__."/logs/request.log",date("Y-m-d H:i:s")." GET NOTES FAIL, invalid username $request->username or password $request->password !.\n",FILE_APPEND);
                    echo json_encode($respond);
                }
            }
            else
            { // request to old
                $respond->success = false;
                $respond->error = "Request is older than 20 seconds, please retry.";
                file_put_contents(__DIR__."/logs/request.log",date("Y-m-d H:i:s")." GET NOTES FAIL, request is too old, request time:\"".date("Y-m-d H:i:s",$request->timestamp)."\" !.\n",FILE_APPEND);
                echo json_encode($respond);
            }
        }
        else
        { // not all needed params are set
            $respond->success = false;
            $respond->error = "Invalid request";
            file_put_contents(__DIR__."/logs/request.log",date("Y-m-d H:i:s")." GET NOTES FAIL, params username, password or timestamp are missing.\n",FILE_APPEND);
            echo json_encode($respond);
        }
    }
    else if ($request->requestType == "add")
    { // add note
        //prepare respond message
        $respond = new stdClass();
        $respond->respondType = "add";

        if (isset($request->username) && isset($request->password) && isset($request->timestamp))
        {
            if ($request->timestamp+20 > date("U"))
            { // request not older as 20 seconds
                $user = UserQuery::create()->filterByName($request->username)->filterByPassword($request->password)->findOne();
                if ($user)
                { // user found
                    $note = new Note();
                    $note->setUserId($user->getId());
                    $note->setTitle($request->note->title);
                    $note->setContent($request->note->content);
                    $note->setCreatedAt(date("Y-m-d H:i:s"));
                    $note->setValidTo($request->note->validTo);
                    $note->setCategory($request->note->category);
                    if ($note->save())
                    {
                        $respond->success = true;
                        file_put_contents(__DIR__."/logs/request.log",date("Y-m-d H:i:s")." ADD NOTE FAIL, invalid username $request->username or password $request->password !.\n",FILE_APPEND);
                        echo json_encode($respond);
                    }
                    else
                    {
                        $respond->success = false;
                        $respond->error = "Couldn't save note, please retry!";
                        file_put_contents(__DIR__."/logs/request.log",date("Y-m-d H:i:s")." ADD NOTE FAIL, invalid username $request->username or password $request->password !.\n",FILE_APPEND);
                        echo json_encode($respond);
                    }
                }
                else
                { //no user found for this username and password
                    $respond->success = false;
                    $respond->error = "Invalid username or password.";
                    file_put_contents(__DIR__."/logs/request.log",date("Y-m-d H:i:s")." ADD NOTE FAIL, invalid username $request->username or password $request->password !.\n",FILE_APPEND);
                    echo json_encode($respond);
                }
            }
            else
            { // request to old
                $respond->success = false;
                $respond->error = "Request is older than 20 seconds, please retry.";
                file_put_contents(__DIR__."/logs/request.log",date("Y-m-d H:i:s")." ADD NOTE FAIL, request is too old, request time:\"".date("Y-m-d H:i:s",$request->timestamp)."\" !.\n",FILE_APPEND);
                echo json_encode($respond);
            }
        }
        else
        { // not all needed params are set
            $respond->success = false;
            $respond->error = "Invalid request";
            file_put_contents(__DIR__."/logs/request.log",date("Y-m-d H:i:s")." ADD NOTE FAIL, params username, password or timestamp are missing.\n",FILE_APPEND);
            echo json_encode($respond);
        }
    }
    else if ($request->requestType == "change")
    { // add note
        //prepare respond message
        $respond = new stdClass();
        $respond->respondType = "change";

        if (isset($request->username) && isset($request->password) && isset($request->timestamp))
        {
            if ($request->timestamp+20 > date("U"))
            { // request not older as 20 seconds
                $user = UserQuery::create()->filterByName($request->username)->filterByPassword($request->password)->findOne();
                if ($user)
                { // user found
                    $note = NoteQuery::create()->findPk($request->note->id);
                    if ($note)
                    { // note found
                        $note->setUserId($user->getId());
                        $note->setTitle($request->note->title);
                        $note->setContent($request->note->content);
                        $note->setCreatedAt(date("Y-m-d H:i:s"));
                        $note->setValidTo($request->note->validTo);
                        $note->setCategory($request->note->category);
                        if ($note->save())
                        {
                            $respond->success = true;
                            file_put_contents(__DIR__."/logs/request.log",date("Y-m-d H:i:s")." CHANGE NOTE SUCCESS, successfully changed!.\n",FILE_APPEND);
                            echo json_encode($respond);
                        }
                        else
                        {
                            $respond->success = false;
                            $respond->error = "Couldn't save note, please retry!";
                            file_put_contents(__DIR__."/logs/request.log",date("Y-m-d H:i:s")." CHANGE NOTE FAIL, couldn't save note!.\n",FILE_APPEND);
                            echo json_encode($respond);
                        }
                    }
                    else
                    { // no note found for the given id
                        $respond->success = false;
                        $respond->error = "No note to change found!";
                        file_put_contents(__DIR__."/logs/request.log",date("Y-m-d H:i:s")." CHANGE NOTE FAIL, no note id found for the id:\"".$request->note->id."\"!.\n",FILE_APPEND);
                        echo json_encode($respond);
                    }
                }
                else
                { //no user found for this username and password
                    $respond->success = false;
                    $respond->error = "Invalid username or password.";
                    file_put_contents(__DIR__."/logs/request.log",date("Y-m-d H:i:s")." CHANGE NOTE FAIL, invalid username $request->username or password $request->password !.\n",FILE_APPEND);
                    echo json_encode($respond);
                }
            }
            else
            { // request to old
                $respond->success = false;
                $respond->error = "Request is older than 20 seconds, please retry.";
                file_put_contents(__DIR__."/logs/request.log",date("Y-m-d H:i:s")." CHANGE NOTE FAIL, request is too old, request time:\"".date("Y-m-d H:i:s",$request->timestamp)."\" !.\n",FILE_APPEND);
                echo json_encode($respond);
            }
        }
        else
        { // not all needed params are set
            $respond->success = false;
            $respond->error = "Invalid request";
            file_put_contents(__DIR__."/logs/request.log",date("Y-m-d H:i:s")." CHANGE NOTE FAIL, params username, password or timestamp are missing.\n",FILE_APPEND);
            echo json_encode($respond);
        }
    }
}

