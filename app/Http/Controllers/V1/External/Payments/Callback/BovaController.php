<?php

declare(strict_types=1);


use App\Http\Controllers\Controller;
use App\Http\Requests\V1\External\Bova\WebhookRequest;
use App\Services\V1\Integrations\Payment\Callbacks\Bova\BovaCallbackService;
use App\Services\V1\Integrations\Payment\Exceptions\AlreadyCreditDepositException;
use App\Services\V1\Integrations\Payment\Exceptions\AlreadyExpiredDepositException;
use Hamidrezaniazi\Pecs\Fields\Log;
use Illuminate\Http\JsonResponse;
use Throwable;

class BovaController extends Controller
{
    public function __construct(
        private readonly BovaCallbackService $bovaCallbackService
    ) {}

    public function callback(WebhookRequest $request): JsonResponse
    {
        try {
            $this->bovaCallbackService->process($request->getDto());
        } catch (AlreadyCreditDepositException|AlreadyExpiredDepositException $exception) {
            $this->logger->withContext(new Log(
                filePath: $exception->getFile(),
                originFileLine: $exception->getLine(),
            ))->error($exception->getMessage());

            return $this->response()->send();
        } catch (Throwable $exception) {
            $this->logger->withContext(new Log(
                filePath: $exception->getFile(),
                originFileLine: $exception->getLine(),
            ))->error($exception->getMessage());

            return $this->response()->serverError()->send();
        }

        return $this->response()->send();
    }
}
