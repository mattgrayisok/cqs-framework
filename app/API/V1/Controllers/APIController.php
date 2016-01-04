<?php
/**
 * User: Slice
 * Date: 02/10/15
 * Time: 18:04
 */

namespace App\API\V1\Controllers;

use App\Exceptions\AuthorisationException;
use App\Exceptions\CommandParameterException;
use App\Exceptions\ValidationException;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class APIController extends BaseController{

    const ERROR_UNSPECIFIED = 'UnspecifiedError';
    const ERROR_INVALID_CREDENTIALS = 'InvalidCredentials';
    const ERROR_MISSING_PARAMETER = 'MissingParameter';
    const ERROR_VALIDATION = 'ValidationError';
    const ERROR_UNAUTHORISED = 'Unauthorised';

    protected function respondSuccess($data = null, $code = 200){
        return Response::create([
            'status' => 'success',
            'data' => $data
        ], $code);
    }

    protected function respondFail($data = null, $errorCode = self::ERROR_UNSPECIFIED, $code = 400){
        return Response::create([
            'status' => 'fail',
            'data' => $data,
            'code' => $errorCode
        ], $code);
    }

    protected function respondError($message = 'An unspecified error occured', $errorCode = self::ERROR_UNSPECIFIED, $code = 500){
        return Response::create([
            'status' => 'error',
            'message' => $message,
            'code' => $errorCode
        ], $code);
    }

	protected function wrapCommonExceptions($callback){

		try{

			return $callback();

		} catch (ValidationException $e) {

			return $this->respondFail($e->getMessages(), static::ERROR_VALIDATION);

		} catch (CommandParameterException $e){

			return $this->respondFail($e->getMessages(), static::ERROR_MISSING_PARAMETER);

		} catch (AuthorisationException $e){

			return $this->respondFail($e->getMessages(), static::ERROR_UNAUTHORISED);

		} catch (\Exception $e){

			return $this->respondError();

		}

	}

}