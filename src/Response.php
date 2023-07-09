<?php declare(strict_types=1);

namespace Kingsoft\Http;

enum ContentTypeString: string
{
	case TextPlain = 'text/plain';
	case TextHtml = 'text/html';
	case Json = 'application/json';
	case JsonProblem = 'application/problem+json';
	case Xml = 'application/xml';
	case XmlProblem = 'application/problem+xml';
}
enum ContentType: string
{
	case Json = 'json';
	case Xml = 'xml';
	case Text = 'text';
}

class Response
{
	public function __construct(
		readonly StatusCode $statusCode,
		readonly string|null $body,
	) {
	}

	private static function decodeHttpResponse(StatusCode $statusCode): string
	{
		return match ( $statusCode ) {
			StatusCode::Continue => 'Continue',
			StatusCode::SwitchingProtocols => 'Switching Protocols',
			StatusCode::OK => 'OK',
			StatusCode::Created => 'Created',
			StatusCode::Accepted => 'Accepted',
			StatusCode::NonAuthoritativeInformation => 'Non-Authoritative Information',
			StatusCode::NoContent => 'No Content',
			StatusCode::ResetContent => 'Reset Content',
			StatusCode::PartialContent => 'Partial Content',
			StatusCode::MultipleChoices => 'Multiple Choices',
			StatusCode::MovedPermanently => 'Moved Permanently',
			StatusCode::Found => 'Found',
			StatusCode::SeeOther => 'See Other',
			StatusCode::NotModified => 'Not Modified',
			StatusCode::UseProxy => 'Use Proxy',
			StatusCode::TemporaryRedirect => 'Temporary Redirect',
			StatusCode::BadRequest => 'Bad Request',
			StatusCode::Unauthorized => 'Unauthorized',
			StatusCode::PaymentRequired => 'Payment Required',
			StatusCode::Forbidden => 'Forbidden',
			StatusCode::NotFound => 'Not Found',
			StatusCode::MethodNotAllowed => 'Method Not Allowed',
			StatusCode::NotAcceptable => 'Not Acceptable',
			StatusCode::ProxyAuthenticationRequired => 'Proxy Authentication Required',
			StatusCode::RequestTimeout => 'Request Timeout',
			StatusCode::Conflict => 'Conflict',
			StatusCode::Gone => 'Gone',
			StatusCode::LengthRequired => 'Length Required',
			StatusCode::PreconditionFailed => 'Precondition Failed',
			StatusCode::RequestEntityTooLarge => 'Request Entity Too Large',
			StatusCode::RequestURITooLong => 'Request-URI Too Long',
			StatusCode::UnsupportedMediaType => 'Unsupported Media Type',
			StatusCode::RequestedRangeNotSatisfiable => 'Requested Range Not Satisfiable',
			StatusCode::ExpectationFailed => 'Expectation Failed',
			StatusCode::InternalServerError => 'Internal Server Error',
			StatusCode::NotImplemented => 'Not Implemented',
			StatusCode::BadGateway => 'Bad Gateway',
			StatusCode::ServiceUnavailable => 'Service Unavailable',
			StatusCode::GatewayTimeout => 'Gateway Timeout',
			StatusCode::HTTPVersionNotSupported => 'HTTP Version Not Supported',
			default => 'Unknown HTTP status code'
		};
	}

	/**
	 * sendStatusCode
	 *
	 * @return self
	 */
	public static function sendStatusCode(StatusCode $statusCode): self
	{
		header_remove('x-powered-by');
		header(
			sprintf(
				'HTTP/1.1 %d %s',
				$statusCode->value,
				self::decodeHttpResponse( $statusCode )
			)
		);
		return $this;
	}

}