<?php
/**
 * This class helps to fetch information about the server.
 *
 * @package GF\Components\Web
 * @author Jorge Alejandro Quiroz Serna (Jako) <alejo.jko@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2017, Jakolab
 */


namespace GF\Components\Web;

class Server extends WebComponent {
    /**
     * The server name.
     * @var string
     */
    private $hostName;
    /**
     * IP server's Address.
     * @var string
     */
    private $hostAddress;
    /**
     * Server port.
     * @var int
     */
    private $hostPort;
    /**
     * Path to the www folder.
     * @var string
     */
    private $documentRoot;
    /**
     * Port used by the client to send the request.
     * @var int
     */
    private $remotePort;
    /**
     * IP from the client.
     * @var string
     */
    private $remoteAddress;
    /**
     * Protocol used by the host.
     * @var string
     */
    private $protocol;
    /**
     * Method used by the request.
     * @var string
     */
    private $method;
    /**
     * Query string fetched by the server.
     * @var string
     */
    private $queryString;
    /**
     * Script name fetched by the server.
     * @var string
     */
    private $scriptName;
    /**
     * Script executed by the server.
     * @var string
     */
    private $fileName;

    public function init(){
        $this->fetchServerInfo();
    }

    public function start(){}

    /**
     * This function captures the server information from the server.
     */
    private function fetchServerInfo(){
        $this->hostName = $this->serverVar("SERVER_NAME");
        $this->hostAddress = $this->serverVar("SERVER_ADDR");
        $this->hostPort = $this->serverVar("SERVER_PORT");
        $this->documentRoot = $this->serverVar("DOCUMENT_ROOT");
        $this->remoteAddress = $this->serverVar("REMOTE_ADDR");
        $this->remotePort = $this->serverVar("REMOTE_PORT");
        $this->protocol = $this->serverVar("REQUEST_SCHEME")?? null;
        $this->method = $this->serverVar("REQUEST_METHOD");
        $this->queryString = $this->serverVar("QUERY_STRING");
        $this->scriptName = $this->serverVar("SCRIPT_NAME");
        $this->fileName = $this->serverVar("SCRIPT_FILENAME");
    }

    /**
     * This function filters the server variables.
     * @param string $name
     * @return string
     */
    private function serverVar(string $name) : string{
        return filter_input(INPUT_SERVER, $name, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    /**
     * This function returns the method used by the request.
     * @return string
     */
    public function Method() : string {
        return $this->method;
    }

    /**
     * This function returns the protocol used by the server.
     * @return string
     */
    public function Protocol() : string {
        return $this->protocol;
    }

    /**
     * This function returns the Server name (Host name).
     * @return string
     */
    public function HostName() : string {
        return $this->HostName();
    }

    /**
     * This function returns the port used by the server.
     * @return string
     */
    public function HostPort() : string{
        return $this->hostPort;
    }

    /**
     * this function returns the name of the executed script.
     * @return string
     */
    public function ScriptName() : string{
        return $this->scriptName;
    }
}