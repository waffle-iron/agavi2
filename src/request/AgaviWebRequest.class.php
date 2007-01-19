<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Agavi package.                                   |
// | Copyright (c) 2003-2006 the Agavi Project.                                |
// | Based on the Mojavi3 MVC Framework, Copyright (c) 2003-2005 Sean Kerr.    |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code. You can also view the    |
// | LICENSE file online at http://www.agavi.org/LICENSE.txt                   |
// |   vi: set noexpandtab:                                                    |
// |   Local Variables:                                                        |
// |   indent-tabs-mode: t                                                     |
// |   End:                                                                    |
// +---------------------------------------------------------------------------+

/**
 * AgaviWebRequest provides additional support for web-only client requests 
 * such as cookie and file manipulation.
 *
 * @package    agavi
 * @subpackage request
 *
 * @author     Sean Kerr <skerr@mojavi.org>
 * @author     Veikko Makinen <mail@veikkomakinen.com>
 * @copyright  (c) Authors
 * @since      0.9.0
 *
 * @version    $Id$
 */
class AgaviWebRequest extends AgaviRequest
{
	/**
	 * @var        string The current URL scheme.
	 */
	protected $urlScheme = '';

	/**
	 * @var        string The current URL authority.
	 */
	protected $urlHost = '';

	/**
	 * @var        string The current URL authority.
	 */
	protected $urlPort = 0;

	/**
	 * @var        string The current URL path.
	 */
	protected $urlPath = '';

	/**
	 * @var        string The current URL query.
	 */
	protected $urlQuery = '';

	/**
	 * @var        string The current request URL (path and query).
	 */
	protected $requestUri = '';

	/**
	 * @var        string The current URL.
	 */
	protected $url = '';

	/**
	 * Retrieve the scheme part of a request URL, typically the protocol.
	 * Example: "http".
	 *
	 * @return     string The request URL scheme.
	 *
	 * @author     David Zuelke <dz@bitxtender.com>
	 * @since      0.11.0
	 */
	public function getUrlScheme()
	{
		return $this->urlScheme;
	}
	
	/**
	 * Retrieve the hostname part of a request URL.
	 *
	 * @return     string The request URL hostname.
	 *
	 * @author     David Zuelke <dz@bitxtender.com>
	 * @since      0.11.0
	 */
	public function getUrlHost()
	{
		return $this->urlHost;
	}
	
	/**
	 * Retrieve the hostname part of a request URL.
	 *
	 * @return     string The request URL hostname.
	 *
	 * @author     David Zuelke <dz@bitxtender.com>
	 * @since      0.11.0
	 */
	public function getUrlPort()
	{
		return $this->urlPort;
	}
	
	/**
	 * Retrieve the request URL authority, typically host and port.
	 * Example: "foo.example.com:8080".
	 *
	 * @param      bool Whether or not ports 80 (for HTTP) and 433 (for HTTPS)
	 *                  should be included in the return string.
	 *
	 * @return     string The request URL authority.
	 *
	 * @author     David Zuelke <dz@bitxtender.com>
	 * @since      0.11.0
	 */
	public function getUrlAuthority($forcePort = false)
	{
		$port = $this->getUrlPort();
		$scheme = $this->getUrlScheme();
		return $this->getUrlHost() . ($forcePort || AgaviToolkit::isPortNecessary($scheme, $port) ? ':' . $port : '');
	}
	
	/**
	 * Retrieve the relative part of the request URL, i.e. path and query.
	 * Example: "/foo/bar/baz?id=4815162342".
	 *
	 * @return     string The relative URL of the curent request.
	 *
	 * @author     David Zuelke <dz@bitxtender.com>
	 * @since      0.11.0
	 */
	public function getRequestUri()
	{
		return $this->requestUri;
	}
	
	/**
	 * Retrieve the path part of the URL.
	 * Example: "/foo/bar/baz".
	 *
	 * @return     string The path part of the URL.
	 *
	 * @author     David Zuelke <dz@bitxtender.com>
	 * @since      0.11.0
	 */
	public function getUrlPath()
	{
		return $this->urlPath;
	}
	
	/**
	 * Retrieve the query part of the URL.
	 * Example: "id=4815162342".
	 *
	 * @return     string The query part of the URL, or an empty string.
	 *
	 * @author     David Zuelke <dz@bitxtender.com>
	 * @since      0.11.0
	 */
	public function getUrlQuery()
	{
		return $this->urlQuery;
	}
	
	/**
	 * Retrieve the full request URL, including protocol, server name, port (if
	 * necessary), and request URI.
	 * Example: "http://foo.example.com:8080/foo/bar/baz?id=4815162342".
	 *
	 * @return     string The URL of the curent request.
	 *
	 * @author     David Zuelke <dz@bitxtender.com>
	 * @since      0.11.0
	 */
	public function getUrl()
	{
		return 
			$this->getUrlScheme() . '://' . 
			$this->getUrlAuthority() . 
			$this->getRequestUri();
	}
	
	/**
	 * Initialize this Request.
	 *
	 * @param      AgaviContext An AgaviContext instance.
	 * @param      array        An associative array of initialization parameters.
	 *
	 * @throws     <b>AgaviInitializationException</b> If an error occurs while
	 *                                                 initializing this Request.
	 *
	 * @author     Sean Kerr <skerr@mojavi.org>
	 * @author     Veikko Makinen <mail@veikkomakinen.com>
	 * @author     David Zuelke <dz@bitxtender.com>
	 * @since      0.9.0
	 */
	public function initialize(AgaviContext $context, array $parameters = array())
	{
		parent::initialize($context, $parameters);
		
		$methods = array('GET' => 'read', 'POST' => 'write', 'PUT' => 'create', 'DELETE' => 'remove');
		if(isset($parameters['method_names'])) {
			$methods = array_merge($methods, (array) $parameters['method_names']);
		}
		
		switch(isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET') {
			case 'POST':
				$this->setMethod($methods['POST']);
				break;
			case 'PUT':
				$this->setMethod($methods['PUT']);
				break;
			case 'DELETE':
				$this->setMethod($methods['DELETE']);
				break;
			default:
				$this->setMethod($methods['GET']);
		}
		
		$this->urlScheme = 'http' . (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ? 's' : '');

		if(isset($_SERVER['SERVER_PORT'])) {
			$this->urlPort = intval($_SERVER['SERVER_PORT']);
		}

		if(isset($_SERVER['SERVER_NAME'])) {
			$port = $this->getUrlPort();
			if(preg_match_all('/\:/', preg_quote($_SERVER['SERVER_NAME']), $m) > 1) {
				$this->urlHost = preg_replace('/\]\:' . preg_quote($port) . '$/', '', $_SERVER['SERVER_NAME']);
			} else {
				$this->urlHost = preg_replace('/\:' . preg_quote($port) . '$/', '', $_SERVER['SERVER_NAME']);
			}
		}

		if(isset($_SERVER['HTTP_X_REWRITE_URL'])) {
			// Microsoft IIS with ISAPI_Rewrite
			$this->requestUri = $_SERVER['HTTP_X_REWRITE_URL'];
		} elseif(!isset($_SERVER['REQUEST_URI']) && isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== false) {
			// Microsoft IIS with PHP in CGI mode
			$this->requestUri = $_SERVER['ORIG_PATH_INFO'] . (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0 ? '?' . $_SERVER['QUERY_STRING'] : '');
		} elseif(isset($_SERVER['REQUEST_URI'])) {
			$this->requestUri = $_SERVER['REQUEST_URI'];
		}

		// Microsoft IIS with PHP in CGI mode
		if(!isset($_SERVER['QUERY_STRING'])) {
			$_SERVER['QUERY_STRING'] = '';
		}
		if(!isset($_SERVER['REQUEST_URI'])) {
			$_SERVER['REQUEST_URI'] = $this->getRequestUri();
		}

		$parts = array_merge(array('path' => '', 'query' => ''), parse_url($this->getRequestUri()));
		$this->urlPath = $parts['path'];
		$this->urlQuery = $parts['query'];
		unset($parts);
		
		if($this->getMethod() == $methods['PUT']) {
			// PUT. We now gotta set a flag for that and populate $_FILES manually
			$this->isHttpPutFile = true;

			$putFile = tmpfile();

			stream_copy_to_stream(fopen("php://input", "rb"), $putFile);

			// for temp file name and size
			$putFileInfo = array(
				'stat' => fstat($putFile),
				'meta_data' => stream_get_meta_data($putFile)
			);

			$putFileName = $request->getParameter('PUT_file_name', 'put_file');

			$_FILES = array(
				$putFileName => array(
					'name' => $putFileName,
					'type' => 'application/octet-stream',
					'size' => $putFileInfo['stat']['size'],
					'tmp_name' => $putFileInfo['meta_data']['uri'],
					'error' => UPLOAD_ERR_OK,
					'HTTP_PUT' => true,
				)
			);
		}

		$headers = array();
		foreach($_SERVER as $key => $value) {
			if(substr($key, 0, 5) == 'HTTP_') {
				$headers[strtolower(substr($key, 5))] = $value;
			}
		}
		
		$this->requestData = new AgaviWebRequestDataHolder(array(
			AgaviWebRequestDataHolder::SOURCE_PARAMETERS => array_merge($_GET, $_POST),
			AgaviWebRequestDataHolder::SOURCE_COOKIES => $_COOKIE,
			AgaviWebRequestDataHolder::SOURCE_FILES => $_FILES,
			AgaviWebRequestDataHolder::SOURCE_HEADERS => $headers,
		));
		
		if($this->getParameter("unset_input", true)) {
			$_GET = $_POST = $_COOKIE = $_REQUEST = $_FILES = array();
		}
	}
}

?>