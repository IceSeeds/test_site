<?php

namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
	protected $clients;

	public function __construct() {
		/* https://www.php.net/manual/ja/class.splobjectstorage.php
			 SplObjectStorageクラスの詳細 ↑
			 インスタンスをしている。使うときは $clientsで
		*/
		$this->clients = new \SplObjectStorage ();
	}

	public function onOpen(ConnectionInterface $conn) {
		// Store the new connection to send messages to later
		$this->clients->attach($conn);

		/* getRequestTarget()でroom名（固有）を受け取る。 clientsには受け取った部屋名が入ってる */
		$conn_param = $this->parse_url_param($conn->httpRequest->getRequestTarget());

		echo "New connection! ({$conn->resourceId})\n";
	}

	public function onMessage( ConnectionInterface $from, $msg )
	{
		/* 部屋に入っている人数カウントのロジック */
		$numRecv = count ( $this->clients ) - 1;

		/* getRequestTarget()でroom名（固有）を受け取る。  全ての部屋が $from_param に入っている感じ。*/
		$from_param = $this->parse_url_param($from->httpRequest->getRequestTarget());

		if ($from_param["mode"] == "room") {
			/* clients を client に展開してる */
			foreach ($this->clients as $client) {
				/* 同じルームの人対象に送信。 */
				$client_param = $this->parse_url_param($client->httpRequest->getRequestTarget());
				/* $from_param(全ての部屋) と $client_param(さっき受け取った部屋)　同じだったら。メッセ！ */
				if( ( $from_param["room"] === $client_param["room"] ) && ( $from !== $client ) )
				{
						$client->send($msg);
				}
			}
		}
	}
	public function onClose(ConnectionInterface $conn) {
		// The connection is closed, remove it, as we can no longer send it messages
		$this->clients->detach ( $conn );

		echo "Connection {$conn->resourceId} has disconnected\n";
	}
	public function onError(ConnectionInterface $conn, \Exception $e) {
		echo "An error has occurred: {$e->getMessage()}\n";

		$conn->close ();
	}

	public function parse_url_param($string) {
			$query = str_replace("/?", "", $string);
			parse_str($query, $return_param);
			return $return_param;
	}
}
