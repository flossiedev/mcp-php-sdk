<?php

declare(strict_types=1);

/*
 * This file is part of the official PHP MCP SDK.
 *
 * A collaboration between Symfony and the PHP Foundation.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mcp\Schema\Request;

use Mcp\Exception\InvalidArgumentException;
use Mcp\Schema\Elicitation\ElicitationSchema;
use Mcp\Schema\JsonRpc\Request;

/**
 * A request from the server to elicit consent to load an external website
 *
 * The client will present the message and requested schema to the user, allowing them
 * to provide the requested information, decline, or cancel the operation.
 *
 */
final class ElicitWebRequest extends Request
{
    /**
     * @param string $message       A human-readable message describing the website the user is being sent to
     * @param string $url           The destination URL for the request
     * @param string $elicitationId The unique ID for the elicitation request
     */
    public function __construct(
        public readonly string $message,
        public readonly string $url,
        public readonly string $elicitationId,
    ) {
    }

    public static function getMethod(): string
    {
        return 'elicitation/create';
    }

    protected static function fromParams(?array $params): static
    {
        if (!isset($params['message']) || !\is_string($params['message'])) {
            throw new InvalidArgumentException('Missing or invalid "message" parameter for elicitation/create.');
        }

        if (!isset($params['url']) || !\is_string($params['url'])) {
            throw new InvalidArgumentException('Missing or invalid "url" parameter for elicitation/create.');
        }

        if (!isset($params['elicitationId']) || !\is_string($params['elicitationId'])) {
            throw new InvalidArgumentException('Missing or invalid "elicitationId" parameter for elicitation/create.');
        }

        return new self(
            $params['message'],
            $params['url'],
            $params['elicitationId'],
        );
    }

    /**
     * @return array{
     *     mode: string,
     *     message: string,
     *     url: string,
     *     elicitationId: string,
     * }
     */
    protected function getParams(): array
    {
        return [
            'mode' => 'url',
            'message' => $this->message,
            'url' => $this->url,
            'elicitationId' => $this->elicitationId,
        ];
    }
}
