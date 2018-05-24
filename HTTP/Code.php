<?php
namespace Softhub99\Zest_Framework\HTTP;
class Code
{
    /*
     * HTTP Status Codes & their meaning
     * Source: https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
     */

    /*
     * Informational codes (1xx)
     */
    /**
     * 100 - Continue
     * The server has received the request headers and the client should proceed to send the request body (in the case of a request for which a body needs to be sent; for example, a POST request). Sending a large request body to a server after a request has been rejected for inappropriate headers would be inefficient. To have a server check the request's headers, a client must send Expect: 100-continue as a header in its initial request and receive a 100 Continue status code in response before sending the body. If the client receives an error code such as 403 (Forbidden) or 405 (Method Not Allowed) then it shouldn't send the request's body. The response 417 Expectation Failed indicates that the request should be repeated without the Expect header as it indicates that the server doesn't support expectations (this is the case, for example, of HTTP/1.0 servers).
     */
    const CONTINUE_ = 100;
    /**
     * 101 - Switching Protocols
     * The requester has asked the server to switch protocols and the server has agreed to do so
     */
    const SWITCHING_PROTOCOLS = 101;
    /**
     * 102 - Processing
     * A WebDAV request may contain many sub-requests involving file operations, requiring a long time to complete
     * the request. This code indicates that the server has received and is processing the request, but no response
     * is available yet. This prevents the client from timing out and assuming the request was lost.
     */
    const PROCESSING = 102;
    /**
     * 103 - Early Hints
     * Used to return some response headers before file HTTP message.
     */
    const EARLY_HINTS = 103;
    /*
     * Success codes (2xx)
     */
    /**
     * 200 - OK
     * Standard response for successful HTTP requests. The actual response will depend on the request method used.
     * In a GET request, the response will contain an entity corresponding to the requested resource. In a POST
     * request, the response will contain an entity describing or containing the result of the action.
     */
    const OK = 200;
    /**
     * 201 - Created
     * The request has been fulfilled, resulting in the creation of a new resource.
     */
    const CREATED = 201;
    /**
     * 202 - Accepted
     * The request has been accepted for processing, but the processing has not been completed. The request might
     * or might not be eventually acted upon, and may be disallowed when processing occurs.
     */
    const ACCEPTED = 202;
    /**
     * 203 - Non Authoritative Info
     * The server is a transforming proxy (e.g. a Web accelerator) that received a 200 OK from its origin, but is
     * returning a modified version of the origin's response.
     */
    const NON_AUTHORITATIVE_INFO = 203;
    /**
     * 204 - No Content
     * The server successfully processed the request and is not returning any content.
     */
    const NO_CONTENT = 204;
    /**
     * 205 - Reset Content
     * The server successfully processed the request and is not returning any content.
     */
    const RESET_CONTENT = 205;
    /**
     * 206 - Partial Content
     * The server successfully processed the request, but is not returning any content. Unlike a 204 response, this
     * response requires that the requester reset the document view.
     */
    const PARTIAL_CONTENT = 206;
    /**
     * 207 - Multi Status
     * The message body that follows is an XML message and can contain a number of separate response codes, depending
     * on how many sub-requests were made.
     */
    const MULTI_STATUS = 207;
    /**
     * 208 - Already Reported
     * The members of a DAV binding have already been enumerated in a preceding part of the (multistatus) response,
     * and are not being included again.
     */
    const ALREADY_REPORTED = 208;
    /**
     * 226 - IM Used
     * The server has fulfilled a request for the resource, and the response is a representation of the result of
     * one or more instance-manipulations applied to the current instance.
     */
    const IM_USED = 226;
    /*
     * Redirection codes (3xx)
     */

    /* Multiple Choices
    * Indicates multiple options for the resource from which the client may choose (via agent-driven content negotiation). For example, this code could be used to present multiple video format options, to list files with different filename extensions, or to suggest word-sense disambiguation
    */
    const MULTIPLE_CHOICES = 300;
    /* Moved Permanently
    * This and all future requests should be directed to the given URI.
    */    
    const MOVED_PERMANENTLY = 301;
    /* Found
    * This and all future requests should be directed to the given URI.
    */      
    const FOUND = 302;
    /* 
    * Tells the client to look at (browse to) another url. 302 has been superseded by 303 and 307. This is an example of industry practice contradicting the standard. The HTTP/1.0 specification (RFC 1945) required the client to perform a temporary redirect (the original describing phrase was "Moved Temporarily"), but popular browsers implemented 302 with the functionality of a 303 See Other. Therefore, HTTP/1.1 added status codes 303 and 307 to distinguish between the two behaviours. However, some Web applications and frameworks use the 302 status code as if it were the 303.
    */      
    const SEE_OTHER = 303;
    /*  Not Modified
    * The response to the request can be found under another URI using the GET method. When received in response to a POST (or PUT/DELETE), the client should presume that the server has received the data and should issue a new GET request to the given URI
    */      
    const NOT_MODIFIED = 304;
    /* Use Proxy (since HTTP/1.1)
    * Indicates that the resource has not been modified since the version specified by the request headers If-Modified-Since or If-None-Match. In such case, there is no need to retransmit the resource since the client still has a previously-downloaded copy
    */      
    const USE_PROXY = 305;
    /* Switch Proxy
    * No longer used. Originally meant "Subsequent requests should use the specified proxy.
    */      
    const SWITCH_PROXY = 306;
    /* Temporary Redirect (since HTTP/1.1)
    * In this case, the request should be repeated with another URI; however, future requests should still use the original URI. In contrast to how 302 was historically implemented, the request method is not allowed to be changed when reissuing the original request. For example, a POST request should be repeated using another POST request.
    */      
    const TEMPORARY_REDIRECT = 307;
    /* Permanent Redirect (RFC 7538)
    * The request and all future requests should be repeated using another URI. 307 and 308 parallel the behaviors of 302 and 301, but do not allow the HTTP method to change. So, for example, submitting a form to a permanently redirected resource may continue smoothly.[
    */      
    const PERMANENT_REDIRECT = 308;
    /*
     * Client Error codes (4xx)
     */
    /**
     * 400 - Bad Request
     * The server cannot or will not process the request due to an apparent client error (e.g., malformed request
     * syntax, size too large, invalid request message framing, or deceptive request routing).
     */
    const BAD_REQUEST = 400;
    /**
     * 401 - Unauthorized
     * Similar to 403 Forbidden, but specifically for use when authentication is required and has failed or has not
     * yet been provided. The response must include a WWW-Authenticate header field containing a challenge applicable
     * to the requested resource. See Basic access authentication and Digest access authentication. 401 semantically
     * means "unauthenticated", i.e. the user does not have the necessary credentials.
     * Note: Some sites issue HTTP 401 when an IP address is banned from the website (usually the website domain)
     * and that specific address is refused permission to access a website.
     */
    const UNAUTHORIZED = 401;
    /**
     * 402 - Payment Required
     * Reserved for future use. The original intention was that this code might be used as part of some form of
     * digital cash or micropayment scheme, as proposed for example by GNU Taler, but that has not yet happened,
     * and this code is not usually used. Google Developers API uses this status if a particular developer has
     * exceeded the daily limit on requests. Stripe API uses this code for errors with processing credit cards.
     */
    const PAYMENT_REQUIRED = 402;
    /**
     * 403 - Forbidden
     * The request was valid, but the server is refusing action. The user might not have the necessary permissions
     * for a resource, or may need an account of some sort.
     */
    const FORBIDDEN = 403;
    /**
     * 404 - Not Found
     * The requested resource could not be found but may be available in the future. Subsequent requests by the
     * client are permissible.
     */
    const NOT_FOUND = 404;
    /**
     * 405 - Method Not Allowed
     * A request method is not supported for the requested resource; for example, a GET request on a form that
     * requires data to be presented via POST, or a PUT request on a read-only resource.
     */
    const METHOD_NOT_ALLOWED = 405;
    /**
     * 406 - Not Acceptable
     * The requested resource is capable of generating only content not acceptable according to the Accept headers
     * sent in the request. See Content negotiation.
     */
    const NOT_ACCEPTABLE = 406;
    /**
     * 407 - Proxy Authentication Required
     * The client must first authenticate itself with the proxy.
     */
    const PROXY_AUTHENTICATION_REQUIRED = 407;
    /**
     * 408 - Request Timeout
     * The server timed out waiting for the request. According to HTTP specifications: "The client did not produce
     * a request within the time that the server was prepared to wait. The client MAY repeat the request without
     * modifications at any later time."
     */
    const REQUEST_TIMEOUT = 408;
    /**
     * 409 - Conflict
     * Indicates that the request could not be processed because of conflict in the request, such as an edit
     * conflict between multiple simultaneous updates.
     */
    const CONFLICT = 409;
    /**
     * 410 - Gone
     * Indicates that the resource requested is no longer available and will not be available again. This should
     * be used when a resource has been intentionally removed and the resource should be purged. Upon receiving a
     * 410 status code, the client should not request the resource in the future. Clients such as search engines
     * should remove the resource from their indices. Most use cases do not require clients and search engines to
     * purge the resource, and a "404 Not Found" may be used instead.
     */
    const GONE = 410;
    /**
     * 411 - Length Required
     * The request did not specify the length of its content, which is required by the requested resource.
     */
    const LENGTH_REQUIRED = 411;
    /**
     * 412 - Precondition Failed
     * The server does not meet one of the preconditions that the requester put on the request.
     */
    const PRECONDITION_FAILED = 412;
    /**
     * 413 - Payload Too Large
     * The request is larger than the server is willing or able to process. Previously called
     * "Request Entity Too Large".
     */
    const PAYLOAD_TOO_LARGE = 413;
    const URI_TOO_LONG = 414;
    const UNSUPPORTED_MEDIA_TYPE = 415;
    const RANGE_NOT_SATISFIABLE = 416;
    const EXPECTATION_FAILED = 417;
    /**
     * 418 - I'm a teapot
     * This code was defined in 1998 as one of the traditional IETF April Fools' jokes, in
     * RFC 2324, Hyper Text Coffee Pot Control Protocol, and is not expected to be implemented by actual HTTP servers.
     * The RFC specifies this code should be returned by teapots requested to brew coffee. This HTTP status is used
     * as an Easter egg in some websites, including Google.com.
     */
    const IM_A_TEAPOT = 418;
    const MISDIRECTED_REQUEST = 421;
    const UNPROCESSABLE_ENTITY = 422;
    const LOCKED = 423;
    const FAILED_DEPENDENCY = 424;
    const UPGRADE_REQUIRED = 426;
    const PRECONDITION_REQUIRED = 428;
    const TOO_MANY_REQUESTS = 429;
    const REQUEST_HEADER_FIELDS_TOO_LARGE = 431;
    const UNAVAILABLE_FOR_LEGAL_REASONS = 451;
    /*
     * Server Error codes (5xx)
     */
    /**
     * 500 - Internal Server Error
     * A generic error message, given when an unexpected condition was encountered and no more specific message
     * is suitable.
     */
    const INTERNAL_SERVER_ERROR = 500;
    const NOT_IMPLEMENTED = 501;
    const BAD_GATEWAY = 502;
    const SERVICE_UNAVAILABLE = 503;
    const GATEWAY_TIMEOUT = 504;
    const HTTP_VERSION_NOT_SUPPORTED = 505;
    const VARIANT_ALSO_NEGOTIATES = 506;
    const INSUFFICIENT_STORAGE = 507;
    const LOOP_DETECTED = 508;
    const NOT_EXTENDED = 510;
    const NETWORK_AUTHENTICATION_REQUIRED = 511;
}